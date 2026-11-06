<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class CustomForm extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'settings',
        'fields_schema',
        'is_active',
        'submissions_count',
        'user_id',
    ];

    protected $casts = [
        'settings' => 'array',
        'fields_schema' => 'array',
        'is_active' => 'boolean',
        'submissions_count' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'is_active'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fields()
    {
        return $this->hasMany(FormField::class)->orderBy('sort_order');
    }

    public function submissions()
    {
        return $this->hasMany(FormSubmission::class);
    }

    public function getFormUrlAttribute(): string
    {
        return route('forms.show', $this->slug);
    }

    public function getEmbedCodeAttribute(): string
    {
        return '<iframe src="' . $this->form_url . '/embed" width="100%" height="500" frameborder="0"></iframe>';
    }

    public function incrementSubmissions()
    {
        $this->increment('submissions_count');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($form) {
            if (empty($form->slug)) {
                $form->slug = Str::slug($form->title);
            }
            if (empty($form->submissions_count)) {
                $form->submissions_count = 0;
            }
            if (empty($form->user_id)) {
                $form->user_id = auth()->id();
            }
        });
    }
}