<?php

namespace App\Modules\Blog\Models;

use App\Models\Post;
use App\Services\AIService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class BlogPost extends Post
{
    use HasFactory, HasSlug;

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'status',
        'published_at',
        'user_id',
        'category_id',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'views_count',
        'likes_count',
        'comments_count',
        'is_featured',
        'allow_comments',
        'seo_score',
        'reading_time',
        'word_count',
        'ai_generated',
        'ai_prompt',
        'tags',
        'author_bio',
        'related_posts',
        'social_shares',
        'engagement_score',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'allow_comments' => 'boolean',
        'views_count' => 'integer',
        'likes_count' => 'integer',
        'comments_count' => 'integer',
        'seo_score' => 'integer',
        'reading_time' => 'integer',
        'word_count' => 'integer',
        'ai_generated' => 'boolean',
        'tags' => 'array',
        'related_posts' => 'array',
        'social_shares' => 'array',
        'engagement_score' => 'float',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function author()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }

    public function comments()
    {
        return $this->hasMany(\App\Models\Comment::class, 'post_id');
    }

    public function approvedComments()
    {
        return $this->hasMany(\App\Models\Comment::class, 'post_id')->where('is_approved', true);
    }

    public function getSeoScoreAttribute(): int
    {
        $score = 0;
        
        // Title optimization (30 points)
        if (!empty($this->meta_title)) {
            $titleLength = strlen($this->meta_title);
            if ($titleLength >= 30 && $titleLength <= 60) {
                $score += 30;
            } elseif ($titleLength > 60) {
                $score += 15;
            } else {
                $score += 10;
            }
        }
        
        // Meta description optimization (25 points)
        if (!empty($this->meta_description)) {
            $descLength = strlen($this->meta_description);
            if ($descLength >= 120 && $descLength <= 160) {
                $score += 25;
            } elseif ($descLength > 160) {
                $score += 15;
            } else {
                $score += 10;
            }
        }
        
        // Content optimization (25 points)
        if ($this->word_count >= 300) {
            $score += 25;
        } elseif ($this->word_count >= 150) {
            $score += 15;
        } else {
            $score += 5;
        }
        
        // Featured image (10 points)
        if (!empty($this->featured_image)) {
            $score += 10;
        }
        
        // Tags (10 points)
        if (!empty($this->tags) && count($this->tags) >= 3) {
            $score += 10;
        }
        
        return min(100, $score);
    }

    public function getReadingTimeAttribute(): int
    {
        if ($this->word_count > 0) {
            return max(1, ceil($this->word_count / 200)); // 200 words per minute
        }
        
        $wordCount = str_word_count(strip_tags($this->content));
        return max(1, ceil($wordCount / 200));
    }

    public function getWordCountAttribute(): int
    {
        return str_word_count(strip_tags($this->content));
    }

    public function getEngagementScoreAttribute(): float
    {
        if ($this->views_count === 0) {
            return 0;
        }
        
        $engagement = ($this->likes_count + $this->comments_count + $this->social_shares_count) / $this->views_count;
        return round($engagement * 100, 2);
    }

    public function getSocialSharesCountAttribute(): int
    {
        if (empty($this->social_shares)) {
            return 0;
        }
        
        return array_sum($this->social_shares);
    }

    public function generateWithAI(array $params = []): array
    {
        $aiService = app(AIService::class);
        
        if (!$aiService->isAvailable()) {
            return ['success' => false, 'error' => 'AI service not available'];
        }
        
        $prompt = "Write a comprehensive blog post about: {$params['topic']}";
        
        if (isset($params['tone'])) {
            $prompt .= " in a {$params['tone']} tone";
        }
        
        if (isset($params['length'])) {
            $prompt .= ". The post should be approximately {$params['length']} words";
        }
        
        if (isset($params['target_audience'])) {
            $prompt .= " for {$params['target_audience']}";
        }
        
        if (isset($params['keywords'])) {
            $prompt .= ". Include these keywords naturally: " . implode(', ', $params['keywords']);
        }
        
        $result = $aiService->generateBlogPost($params);
        
        if ($result['success']) {
            $this->update([
                'content' => $result['content'],
                'ai_generated' => true,
                'ai_prompt' => $prompt,
            ]);
        }
        
        return $result;
    }

    public function generateSEOContent(): array
    {
        $aiService = app(AIService::class);
        
        if (!$aiService->isAvailable()) {
            return ['success' => false, 'error' => 'AI service not available'];
        }
        
        $result = $aiService->generateSEODescription($this->title, $this->content);
        
        if ($result['success']) {
            $this->update([
                'meta_description' => $result['content'],
            ]);
        }
        
        return $result;
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    public function incrementLikes(): void
    {
        $this->increment('likes_count');
    }

    public function decrementLikes(): void
    {
        $this->decrement('likes_count');
    }

    public function incrementSocialShare(string $platform): void
    {
        $shares = $this->social_shares ?? [];
        $shares[$platform] = ($shares[$platform] ?? 0) + 1;
        
        $this->update(['social_shares' => $shares]);
    }

    public function scopePopular($query, $days = 30)
    {
        return $query->where('published_at', '>=', now()->subDays($days))
                    ->orderBy('views_count', 'desc');
    }

    public function scopeTrending($query, $days = 7)
    {
        return $query->where('published_at', '>=', now()->subDays($days))
                    ->orderBy('engagement_score', 'desc');
    }

    public function scopeHighSeo($query)
    {
        return $query->where('seo_score', '>=', 80);
    }

    public function scopeAiGenerated($query)
    {
        return $query->where('ai_generated', true);
    }

    public function getRelatedPostsAttribute(): array
    {
        $related = \App\Modules\Blog\Models\BlogPost::published()
            ->where('id', '!=', $this->id)
            ->where(function ($query) {
                $query->where('category_id', $this->category_id)
                      ->orWhereJsonContains('tags', $this->tags);
            })
            ->limit(4)
            ->get();
            
        return $related->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'excerpt' => $post->excerpt,
                'featured_image' => $post->featured_image_url,
                'published_at' => $post->published_at,
                'author' => $post->author->name,
            ];
        })->toArray();
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($post) {
            // Auto-generate SEO content if not provided
            if (empty($post->meta_description) && !empty($post->content)) {
                $post->meta_description = \Str::limit(strip_tags($post->content), 160);
            }
            
            if (empty($post->meta_title)) {
                $post->meta_title = $post->title;
            }
            
            // Calculate word count and reading time
            $post->word_count = str_word_count(strip_tags($post->content));
        });

        static::saved(function ($post) {
            // Update SEO score
            $post->update(['seo_score' => $post->seo_score]);
        });
    }
}