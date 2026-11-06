<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Tag extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'is_active',
        'usage_count',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'usage_count' => 'integer',
    ];

    /**
     * Get the activity log options for the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'is_active'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the tag's posts.
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    /**
     * Get the tag's published posts.
     */
    public function publishedPosts()
    {
        return $this->belongsToMany(Post::class)->published();
    }

    /**
     * Get the tag's posts count.
     */
    public function getPostsCountAttribute(): int
    {
        return $this->posts()->count();
    }

    /**
     * Get the tag's published posts count.
     */
    public function getPublishedPostsCountAttribute(): int
    {
        return $this->publishedPosts()->count();
    }

    /**
     * Check if tag is active.
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Scope for active tags.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for tags with posts.
     */
    public function scopeWithPosts($query)
    {
        return $query->whereHas('posts');
    }

    /**
     * Scope ordered by usage count.
     */
    public function scopePopular($query)
    {
        return $query->orderBy('usage_count', 'desc');
    }

    /**
     * Scope ordered by name.
     */
    public function scopeAlphabetical($query)
    {
        return $query->orderBy('name');
    }

    /**
     * Update usage count.
     */
    public function updateUsageCount()
    {
        $this->usage_count = $this->posts()->count();
        $this->save();
    }

    /**
     * Get popular tags.
     */
    public static function getPopular($limit = 10)
    {
        return static::active()
            ->withPosts()
            ->popular()
            ->limit($limit)
            ->get();
    }

    /**
     * Get tag cloud data.
     */
    public static function getTagCloud($limit = 50)
    {
        $tags = static::active()
            ->withPosts()
            ->get();

        if ($tags->isEmpty()) {
            return collect();
        }

        $maxCount = $tags->max('usage_count');
        $minCount = $tags->min('usage_count');

        return $tags->map(function ($tag) use ($maxCount, $minCount) {
            $weight = $maxCount > $minCount 
                ? (($tag->usage_count - $minCount) / ($maxCount - $minCount)) * 100 
                : 50;
            
            return [
                'tag' => $tag,
                'weight' => round($weight),
                'size' => $this->getTagSize($weight),
            ];
        })->sortByDesc('weight')->take($limit);
    }

    /**
     * Get tag size based on weight.
     */
    private static function getTagSize($weight)
    {
        if ($weight >= 80) return 'text-2xl';
        if ($weight >= 60) return 'text-xl';
        if ($weight >= 40) return 'text-lg';
        if ($weight >= 20) return 'text-base';
        return 'text-sm';
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tag) {
            if (empty($tag->color)) {
                $colors = ['#EF4444', '#F97316', '#EAB308', '#22C55E', '#06B6D4', '#3B82F6', '#8B5CF6', '#EC4899'];
                $tag->color = $colors[array_rand($colors)];
            }
            if (empty($tag->usage_count)) {
                $tag->usage_count = 0;
            }
        });

        // Update usage count when posts are attached/detached
        static::saved(function ($tag) {
            $tag->updateUsageCount();
        });
    }
}