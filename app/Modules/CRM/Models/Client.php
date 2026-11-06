<?php

namespace App\Modules\CRM\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Client extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, LogsActivity, InteractsWithMedia;

    protected $fillable = [
        'company_name',
        'first_name',
        'last_name',
        'email',
        'phone',
        'mobile',
        'website',
        'industry',
        'company_size',
        'annual_revenue',
        'description',
        'notes',
        'status',
        'source',
        'priority',
        'rating',
        'tags',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'timezone',
        'currency',
        'language',
        'assigned_to',
        'last_contact_date',
        'next_follow_up_date',
        'lead_score',
        'conversion_date',
        'total_deals_value',
        'total_deals_count',
        'won_deals_value',
        'won_deals_count',
        'lost_deals_value',
        'lost_deals_count',
        'meta_data',
        'settings',
        'user_id',
    ];

    protected $casts = [
        'annual_revenue' => 'decimal:2',
        'tags' => 'array',
        'address' => 'array',
        'last_contact_date' => 'datetime',
        'next_follow_up_date' => 'datetime',
        'conversion_date' => 'datetime',
        'total_deals_value' => 'decimal:2',
        'total_deals_count' => 'integer',
        'won_deals_value' => 'decimal:2',
        'won_deals_count' => 'integer',
        'lost_deals_value' => 'decimal:2',
        'lost_deals_count' => 'integer',
        'meta_data' => 'array',
        'settings' => 'array',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['company_name', 'first_name', 'last_name', 'email', 'status', 'assigned_to'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function deals()
    {
        return $this->hasMany(Deal::class);
    }

    public function activeDeals()
    {
        return $this->hasMany(Deal::class)->whereIn('status', ['open', 'qualified', 'proposal']);
    }

    public function wonDeals()
    {
        return $this->hasMany(Deal::class)->where('status', 'won');
    }

    public function lostDeals()
    {
        return $this->hasMany(Deal::class)->where('status', 'lost');
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function notes()
    {
        return $this->hasMany(ClientNote::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function documents()
    {
        return $this->hasMany(ClientDocument::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->company_name ?: $this->full_name;
    }

    public function getFormattedAddressAttribute(): string
    {
        $address = $this->address;
        
        if (empty($address)) {
            return '';
        }

        $parts = array_filter([
            $address['street'] ?? '',
            $address['city'] ?? '',
            $address['state'] ?? '',
            $address['country'] ?? '',
            $address['postal_code'] ?? '',
        ]);

        return implode(', ', $parts);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'lead' => 'Lead',
            'prospect' => 'Prospect',
            'customer' => 'Customer',
            'inactive' => 'Inactive',
            default => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'lead' => 'blue',
            'prospect' => 'yellow',
            'customer' => 'green',
            'inactive' => 'gray',
            default => 'gray',
        };
    }

    public function getPriorityLabelAttribute(): string
    {
        return match ($this->priority) {
            'low' => 'Low',
            'medium' => 'Medium',
            'high' => 'High',
            'urgent' => 'Urgent',
            default => ucfirst($this->priority ?? 'medium'),
        };
    }

    public function getPriorityColorAttribute(): string
    {
        return match ($this->priority) {
            'low' => 'green',
            'medium' => 'yellow',
            'high' => 'orange',
            'urgent' => 'red',
            default => 'gray',
        };
    }

    public function getSourceLabelAttribute(): string
    {
        return match ($this->source) {
            'website' => 'Website',
            'referral' => 'Referral',
            'social_media' => 'Social Media',
            'advertising' => 'Advertising',
            'cold_call' => 'Cold Call',
            'email' => 'Email',
            'event' => 'Event',
            'other' => 'Other',
            default => ucfirst($this->source ?? 'other'),
        };
    }

    public function getAvatarUrlAttribute(): string
    {
        $media = $this->getFirstMedia('avatar');
        
        if ($media) {
            return $media->getUrl();
        }

        // Generate avatar from initials
        $initials = '';
        if ($this->first_name) {
            $initials .= strtoupper(substr($this->first_name, 0, 1));
        }
        if ($this->last_name) {
            $initials .= strtoupper(substr($this->last_name, 0, 1));
        }
        if (!$initials && $this->company_name) {
            $initials = strtoupper(substr($this->company_name, 0, 2));
        }

        return "https://ui-avatars.com/api/?name={$initials}&background=random&color=fff&size=128";
    }

    public function getWinRateAttribute(): float
    {
        if ($this->total_deals_count === 0) {
            return 0;
        }

        return round(($this->won_deals_count / $this->total_deals_count) * 100, 2);
    }

    public function getAverageDealSizeAttribute(): float
    {
        if ($this->total_deals_count === 0) {
            return 0;
        }

        return round($this->total_deals_value / $this->total_deals_count, 2);
    }

    public function getDaysSinceLastContactAttribute(): int
    {
        if (!$this->last_contact_date) {
            return 0;
        }

        return $this->last_contact_date->diffInDays(now());
    }

    public function getDaysUntilFollowUpAttribute(): int
    {
        if (!$this->next_follow_up_date) {
            return 0;
        }

        return now()->diffInDays($this->next_follow_up_date, false);
    }

    public function isOverdueFollowUp(): bool
    {
        return $this->next_follow_up_date && $this->next_follow_up_date->isPast();
    }

    public function updateLastContact(): void
    {
        $this->update(['last_contact_date' => now()]);
    }

    public function scheduleFollowUp(int $days): void
    {
        $this->update(['next_follow_up_date' => now()->addDays($days)]);
    }

    public function updateDealStats(): void
    {
        $totalDeals = $this->deals();
        $wonDeals = $this->wonDeals();
        $lostDeals = $this->lostDeals();

        $this->update([
            'total_deals_count' => $totalDeals->count(),
            'total_deals_value' => $totalDeals->sum('value'),
            'won_deals_count' => $wonDeals->count(),
            'won_deals_value' => $wonDeals->sum('value'),
            'lost_deals_count' => $lostDeals->count(),
            'lost_deals_value' => $lostDeals->sum('value'),
        ]);
    }

    public function convertToCustomer(): void
    {
        $this->update([
            'status' => 'customer',
            'conversion_date' => now(),
        ]);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeBySource($query, $source)
    {
        return $query->where('source', $source);
    }

    public function scopeByAssignedUser($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    public function scopeOverdueFollowUp($query)
    {
        return $query->where('next_follow_up_date', '<', now());
    }

    public function scopeUpcomingFollowUp($query, $days = 7)
    {
        return $query->where('next_follow_up_date', '>=', now())
                    ->where('next_follow_up_date', '<=', now()->addDays($days));
    }

    public function scopeHighValue($query, $minValue = 10000)
    {
        return $query->where('total_deals_value', '>=', $minValue);
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('company_name', 'like', "%{$term}%")
              ->orWhere('first_name', 'like', "%{$term}%")
              ->orWhere('last_name', 'like', "%{$term}%")
              ->orWhere('email', 'like', "%{$term}%")
              ->orWhere('phone', 'like', "%{$term}%");
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($client) {
            if (empty($client->status)) {
                $client->status = 'lead';
            }
            if (empty($client->priority)) {
                $client->priority = 'medium';
            }
            if (empty($client->source)) {
                $client->source = 'other';
            }
            if (empty($client->currency)) {
                $client->currency = 'USD';
            }
            if (empty($client->language)) {
                $client->language = 'en';
            }
            if (empty($client->total_deals_count)) {
                $client->total_deals_count = 0;
            }
            if (empty($client->total_deals_value)) {
                $client->total_deals_value = 0;
            }
            if (empty($client->won_deals_count)) {
                $client->won_deals_count = 0;
            }
            if (empty($client->won_deals_value)) {
                $client->won_deals_value = 0;
            }
            if (empty($client->lost_deals_count)) {
                $client->lost_deals_count = 0;
            }
            if (empty($client->lost_deals_value)) {
                $client->lost_deals_value = 0;
            }
        });
    }
}