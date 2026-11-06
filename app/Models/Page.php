<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Page extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'status',
        'template',
        'parent_id',
        'sort_order',
        'user_id',
        'featured_image',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_homepage',
        'is_featured',
        'views_count',
        'published_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_homepage' => 'boolean',
        'is_featured' => 'boolean',
        'views_count' => 'integer',
        'sort_order' => 'integer',
        'published_at' => 'datetime',
    ];

    /**
     * Get the activity log options for the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'status', 'published_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the page's author.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the page's parent.
     */
    public function parent()
    {
        return $this->belongsTo(Page::class, 'parent_id');
    }

    /**
     * Get the page's children.
     */
    public function children()
    {
        return $this->hasMany(Page::class, 'parent_id');
    }

    /**
     * Get the page's featured image URL.
     */
    public function getFeaturedImageUrlAttribute(): ?string
    {
        if ($this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }
        return null;
    }

    /**
     * Get the page's excerpt.
     */
    public function getExcerptAttribute($value): string
    {
        if ($value) {
            return $value;
        }
        
        // Generate excerpt from content if not set
        $content = strip_tags($this->content);
        return \Str::limit($content, 160);
    }

    /**
     * Check if page is published.
     */
    public function isPublished(): bool
    {
        return $this->status === 'published' && $this->published_at <= now();
    }

    /**
     * Check if page is draft.
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    /**
     * Check if page is homepage.
     */
    public function isHomepage(): bool
    {
        return $this->is_homepage;
    }

    /**
     * Check if page has children.
     */
    public function hasChildren(): bool
    {
        return $this->children()->count() > 0;
    }

    /**
     * Get all descendants of the page.
     */
    public function descendants()
    {
        return $this->children()->with('descendants');
    }

    /**
     * Get all ancestors of the page.
     */
    public function ancestors()
    {
        $ancestors = collect();
        $parent = $this->parent;
        
        while ($parent) {
            $ancestors->prepend($parent);
            $parent = $parent->parent;
        }
        
        return $ancestors;
    }

    /**
     * Get the page's breadcrumb.
     */
    public function getBreadcrumbAttribute(): array
    {
        $breadcrumb = [];
        $ancestors = $this->ancestors();
        
        foreach ($ancestors as $ancestor) {
            $breadcrumb[] = [
                'name' => $ancestor->title,
                'slug' => $ancestor->slug,
            ];
        }
        
        $breadcrumb[] = [
            'name' => $this->title,
            'slug' => $this->slug,
        ];
        
        return $breadcrumb;
    }

    /**
     * Scope for published pages.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope for featured pages.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for root pages (no parent).
     */
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope for pages by template.
     */
    public function scopeByTemplate($query, $template)
    {
        return $query->where('template', $template);
    }

    /**
     * Scope ordered by sort order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('title');
    }

    /**
     * Get homepage.
     */
    public static function getHomepage()
    {
        return static::where('is_homepage', true)->published()->first();
    }

    /**
     * Get page tree.
     */
    public static function getTree()
    {
        return static::with('children')
            ->whereNull('parent_id')
            ->published()
            ->ordered()
            ->get();
    }

    /**
     * Increment views count.
     */
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            if (empty($page->status)) {
                $page->status = 'draft';
            }
            if ($page->status === 'published' && empty($page->published_at)) {
                $page->published_at = now();
            }
            if (empty($page->sort_order)) {
                $page->sort_order = static::max('sort_order') + 1;
            }
            if (empty($page->template)) {
                $page->template = 'default';
            }
        });

        static::updating(function ($page) {
            if ($page->status === 'published' && empty($page->published_at)) {
                $page->published_at = now();
            }
        });

        // Ensure only one homepage
        static::saving(function ($page) {
            if ($page->is_homepage) {
                static::where('id', '!=', $page->id)->update(['is_homepage' => false]);
            }
        });
    }
}