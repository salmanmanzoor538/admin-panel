<?php

namespace App\Modules\LMS\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Course extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, LogsActivity, InteractsWithMedia, HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'short_description',
        'featured_image',
        'price',
        'sale_price',
        'currency',
        'status',
        'difficulty_level',
        'duration',
        'language',
        'instructor_id',
        'category_id',
        'tags',
        'learning_objectives',
        'prerequisites',
        'target_audience',
        'certificate_enabled',
        'certificate_template',
        'enrollment_limit',
        'enrollment_deadline',
        'start_date',
        'end_date',
        'is_featured',
        'is_free',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'meta_data',
        'settings',
        'views_count',
        'enrollments_count',
        'completions_count',
        'rating_average',
        'rating_count',
        'published_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'tags' => 'array',
        'learning_objectives' => 'array',
        'prerequisites' => 'array',
        'target_audience' => 'array',
        'certificate_enabled' => 'boolean',
        'enrollment_deadline' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_featured' => 'boolean',
        'is_free' => 'boolean',
        'meta_data' => 'array',
        'settings' => 'array',
        'views_count' => 'integer',
        'enrollments_count' => 'integer',
        'completions_count' => 'integer',
        'rating_average' => 'decimal:2',
        'rating_count' => 'integer',
        'published_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'status', 'price', 'enrollments_count'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function category()
    {
        return $this->belongsTo(CourseCategory::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('sort_order');
    }

    public function publishedLessons()
    {
        return $this->hasMany(Lesson::class)->where('status', 'published')->orderBy('sort_order');
    }

    public function enrollments()
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    public function activeEnrollments()
    {
        return $this->hasMany(CourseEnrollment::class)->where('status', 'active');
    }

    public function completedEnrollments()
    {
        return $this->hasMany(CourseEnrollment::class)->where('status', 'completed');
    }

    public function reviews()
    {
        return $this->hasMany(CourseReview::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(CourseReview::class)->where('status', 'approved');
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function getCurrentPriceAttribute(): float
    {
        return $this->sale_price ?: $this->price;
    }

    public function getFormattedPriceAttribute(): string
    {
        return $this->is_free ? 'Free' : '$' . number_format($this->current_price, 2);
    }

    public function getFormattedSalePriceAttribute(): string
    {
        return $this->sale_price ? '$' . number_format($this->sale_price, 2) : '';
    }

    public function getIsOnSaleAttribute(): bool
    {
        return $this->sale_price && $this->sale_price < $this->price;
    }

    public function getDiscountPercentageAttribute(): float
    {
        if (!$this->is_on_sale) {
            return 0;
        }

        return round((($this->price - $this->sale_price) / $this->price) * 100, 2);
    }

    public function getFeaturedImageUrlAttribute(): ?string
    {
        $media = $this->getFirstMedia('featured');
        return $media ? $media->getUrl() : null;
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'draft' => 'Draft',
            'published' => 'Published',
            'archived' => 'Archived',
            default => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'draft' => 'gray',
            'published' => 'green',
            'archived' => 'red',
            default => 'gray',
        };
    }

    public function getDifficultyLevelLabelAttribute(): string
    {
        return match ($this->difficulty_level) {
            'beginner' => 'Beginner',
            'intermediate' => 'Intermediate',
            'advanced' => 'Advanced',
            default => ucfirst($this->difficulty_level),
        };
    }

    public function getDifficultyLevelColorAttribute(): string
    {
        return match ($this->difficulty_level) {
            'beginner' => 'green',
            'intermediate' => 'yellow',
            'advanced' => 'red',
            default => 'gray',
        };
    }

    public function getTotalLessonsAttribute(): int
    {
        return $this->publishedLessons()->count();
    }

    public function getTotalDurationAttribute(): int
    {
        return $this->publishedLessons()->sum('duration');
    }

    public function getFormattedDurationAttribute(): string
    {
        $minutes = $this->total_duration;
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;

        if ($hours > 0) {
            return $hours . 'h ' . $remainingMinutes . 'm';
        }

        return $minutes . 'm';
    }

    public function getCompletionRateAttribute(): float
    {
        if ($this->enrollments_count === 0) {
            return 0;
        }

        return round(($this->completions_count / $this->enrollments_count) * 100, 2);
    }

    public function getCanEnrollAttribute(): bool
    {
        if ($this->status !== 'published') {
            return false;
        }

        if ($this->enrollment_deadline && $this->enrollment_deadline->isPast()) {
            return false;
        }

        if ($this->enrollment_limit && $this->enrollments_count >= $this->enrollment_limit) {
            return false;
        }

        return true;
    }

    public function getIsEnrolledAttribute(): bool
    {
        if (!auth()->check()) {
            return false;
        }

        return $this->enrollments()
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->exists();
    }

    public function getEnrollmentAttribute(): ?CourseEnrollment
    {
        if (!auth()->check()) {
            return null;
        }

        return $this->enrollments()
            ->where('user_id', auth()->id())
            ->first();
    }

    public function getProgressAttribute(): float
    {
        $enrollment = $this->enrollment;
        
        if (!$enrollment) {
            return 0;
        }

        return $enrollment->progress_percentage;
    }

    public function getNextLessonAttribute(): ?Lesson
    {
        $enrollment = $this->enrollment;
        
        if (!$enrollment) {
            return $this->publishedLessons()->first();
        }

        $completedLessons = $enrollment->completedLessons()->pluck('lesson_id');
        
        return $this->publishedLessons()
            ->whereNotIn('id', $completedLessons)
            ->first();
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    public function incrementEnrollments(): void
    {
        $this->increment('enrollments_count');
    }

    public function incrementCompletions(): void
    {
        $this->increment('completions_count');
    }

    public function updateRating(): void
    {
        $approvedReviews = $this->approvedReviews();
        $count = $approvedReviews->count();
        
        if ($count > 0) {
            $average = $approvedReviews->avg('rating');
            $this->update([
                'rating_average' => round($average, 2),
                'rating_count' => $count,
            ]);
        } else {
            $this->update([
                'rating_average' => 0,
                'rating_count' => 0,
            ]);
        }
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeFree($query)
    {
        return $query->where('is_free', true);
    }

    public function scopePaid($query)
    {
        return $query->where('is_free', false);
    }

    public function scopeByDifficulty($query, $level)
    {
        return $query->where('difficulty_level', $level);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByInstructor($query, $instructorId)
    {
        return $query->where('instructor_id', $instructorId);
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
              ->orWhere('description', 'like', "%{$term}%")
              ->orWhere('short_description', 'like', "%{$term}%");
        });
    }

    public function scopeSortBy($query, $sort)
    {
        return match ($sort) {
            'price_low' => $query->orderBy('current_price', 'asc'),
            'price_high' => $query->orderBy('current_price', 'desc'),
            'newest' => $query->orderBy('created_at', 'desc'),
            'oldest' => $query->orderBy('created_at', 'asc'),
            'popular' => $query->orderBy('enrollments_count', 'desc'),
            'rating' => $query->orderBy('rating_average', 'desc'),
            'title' => $query->orderBy('title', 'asc'),
            default => $query->orderBy('created_at', 'desc'),
        };
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($course) {
            if (empty($course->status)) {
                $course->status = 'draft';
            }
            if (empty($course->difficulty_level)) {
                $course->difficulty_level = 'beginner';
            }
            if (empty($course->language)) {
                $course->language = 'en';
            }
            if (empty($course->currency)) {
                $course->currency = 'USD';
            }
            if (empty($course->views_count)) {
                $course->views_count = 0;
            }
            if (empty($course->enrollments_count)) {
                $course->enrollments_count = 0;
            }
            if (empty($course->completions_count)) {
                $course->completions_count = 0;
            }
            if (empty($course->rating_average)) {
                $course->rating_average = 0;
            }
            if (empty($course->rating_count)) {
                $course->rating_count = 0;
            }
        });

        static::saving(function ($course) {
            if ($course->status === 'published' && empty($course->published_at)) {
                $course->published_at = now();
            }
        });
    }
}