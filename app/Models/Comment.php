<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Comment extends Model
{
    use HasFactory, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'post_id',
        'user_id',
        'author_name',
        'author_email',
        'author_website',
        'content',
        'status',
        'is_approved',
        'parent_id',
        'ip_address',
        'user_agent',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_approved' => 'boolean',
    ];

    /**
     * Get the activity log options for the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status', 'is_approved'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Get the comment's post.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get the comment's author.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the comment's parent.
     */
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Get the comment's replies.
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    /**
     * Get the comment's approved replies.
     */
    public function approvedReplies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->approved();
    }

    /**
     * Get the author's name.
     */
    public function getAuthorNameAttribute($value): string
    {
        if ($this->author) {
            return $this->author->name;
        }
        return $value ?? 'Anonymous';
    }

    /**
     * Get the author's avatar.
     */
    public function getAuthorAvatarAttribute(): string
    {
        if ($this->author) {
            return $this->author->avatar_url;
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->author_name) . '&background=random&color=fff&size=64';
    }

    /**
     * Check if comment is approved.
     */
    public function isApproved(): bool
    {
        return $this->is_approved;
    }

    /**
     * Check if comment is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if comment is spam.
     */
    public function isSpam(): bool
    {
        return $this->status === 'spam';
    }

    /**
     * Check if comment has replies.
     */
    public function hasReplies(): bool
    {
        return $this->replies()->count() > 0;
    }

    /**
     * Scope for approved comments.
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope for pending comments.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for spam comments.
     */
    public function scopeSpam($query)
    {
        return $query->where('status', 'spam');
    }

    /**
     * Scope for top-level comments (no parent).
     */
    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope for replies.
     */
    public function scopeReplies($query)
    {
        return $query->whereNotNull('parent_id');
    }

    /**
     * Approve the comment.
     */
    public function approve()
    {
        $this->update([
            'status' => 'approved',
            'is_approved' => true,
        ]);
    }

    /**
     * Reject the comment.
     */
    public function reject()
    {
        $this->update([
            'status' => 'rejected',
            'is_approved' => false,
        ]);
    }

    /**
     * Mark as spam.
     */
    public function markAsSpam()
    {
        $this->update([
            'status' => 'spam',
            'is_approved' => false,
        ]);
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($comment) {
            if (empty($comment->status)) {
                $comment->status = 'pending';
            }
            if ($comment->user_id) {
                // Auto-approve comments from registered users
                $comment->is_approved = true;
                $comment->status = 'approved';
            }
        });

        // Update post comments count
        static::saved(function ($comment) {
            $comment->post->update(['comments_count' => $comment->post->comments()->approved()->count()]);
        });

        static::deleted(function ($comment) {
            $comment->post->update(['comments_count' => $comment->post->comments()->approved()->count()]);
        });
    }
}