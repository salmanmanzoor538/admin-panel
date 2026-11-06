<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Tenant extends BaseTenant
{
    use HasDatabase, HasDomains, LogsActivity;

    protected $fillable = [
        'id',
        'data',
        'plan',
        'subscription_status',
        'subscription_ends_at',
        'max_users',
        'max_storage',
        'features',
        'settings',
        'is_active',
    ];

    protected $casts = [
        'data' => 'array',
        'features' => 'array',
        'settings' => 'array',
        'subscription_ends_at' => 'datetime',
        'is_active' => 'boolean',
        'max_users' => 'integer',
        'max_storage' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['plan', 'subscription_status', 'is_active'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function users()
    {
        return $this->hasMany(TenantUser::class);
    }

    public function getDomainAttribute(): string
    {
        return $this->domains()->first()?->domain ?? '';
    }

    public function getMainDomainAttribute(): string
    {
        return $this->domains()->where('is_primary', true)->first()?->domain ?? $this->domain;
    }

    public function getSubscriptionStatusAttribute(): string
    {
        return $this->data['subscription_status'] ?? 'trial';
    }

    public function getPlanAttribute(): string
    {
        return $this->data['plan'] ?? 'free';
    }

    public function getFeaturesAttribute(): array
    {
        return $this->data['features'] ?? $this->getDefaultFeatures();
    }

    public function getSettingsAttribute(): array
    {
        return $this->data['settings'] ?? [];
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->data['is_active'] ?? true;
    }

    public function getMaxUsersAttribute(): int
    {
        return $this->data['max_users'] ?? $this->getPlanLimits()['users'];
    }

    public function getMaxStorageAttribute(): int
    {
        return $this->data['max_storage'] ?? $this->getPlanLimits()['storage'];
    }

    public function isFeatureEnabled(string $feature): bool
    {
        return in_array($feature, $this->features);
    }

    public function canAddUser(): bool
    {
        return $this->users()->count() < $this->max_users;
    }

    public function getStorageUsed(): int
    {
        // This would calculate actual storage usage
        // For now, return 0
        return 0;
    }

    public function canUseStorage(int $bytes): bool
    {
        return ($this->getStorageUsed() + $bytes) <= ($this->max_storage * 1024 * 1024);
    }

    public function isSubscriptionActive(): bool
    {
        if ($this->subscription_status === 'active') {
            return true;
        }

        if ($this->subscription_status === 'trial') {
            return $this->created_at->addDays(14)->isFuture();
        }

        return false;
    }

    public function getDaysUntilExpiry(): int
    {
        if ($this->subscription_ends_at) {
            return max(0, now()->diffInDays($this->subscription_ends_at, false));
        }

        if ($this->subscription_status === 'trial') {
            return max(0, now()->diffInDays($this->created_at->addDays(14), false));
        }

        return 0;
    }

    protected function getDefaultFeatures(): array
    {
        return [
            'blog',
            'pages',
            'forms',
            'basic_analytics',
        ];
    }

    protected function getPlanLimits(): array
    {
        $limits = [
            'free' => ['users' => 5, 'storage' => 100], // 100MB
            'starter' => ['users' => 25, 'storage' => 1000], // 1GB
            'professional' => ['users' => 100, 'storage' => 10000], // 10GB
            'enterprise' => ['users' => -1, 'storage' => -1], // Unlimited
        ];

        return $limits[$this->plan] ?? $limits['free'];
    }

    public function getPlanFeatures(): array
    {
        $features = [
            'free' => ['blog', 'pages', 'forms', 'basic_analytics'],
            'starter' => ['blog', 'pages', 'forms', 'analytics', 'ecommerce', 'ai_content'],
            'professional' => ['blog', 'pages', 'forms', 'analytics', 'ecommerce', 'ai_content', 'lms', 'crm'],
            'enterprise' => ['blog', 'pages', 'forms', 'analytics', 'ecommerce', 'ai_content', 'lms', 'crm', 'multi_tenant', 'custom_domain', 'priority_support'],
        ];

        return $features[$this->plan] ?? $features['free'];
    }

    public function upgradePlan(string $newPlan): bool
    {
        $allowedPlans = ['free', 'starter', 'professional', 'enterprise'];
        
        if (!in_array($newPlan, $allowedPlans)) {
            return false;
        }

        $this->update([
            'data' => array_merge($this->data ?? [], [
                'plan' => $newPlan,
                'features' => $this->getPlanFeatures(),
                'max_users' => $this->getPlanLimits()['users'],
                'max_storage' => $this->getPlanLimits()['storage'],
            ])
        ]);

        return true;
    }

    public function activate(): void
    {
        $this->update([
            'data' => array_merge($this->data ?? [], ['is_active' => true])
        ]);
    }

    public function deactivate(): void
    {
        $this->update([
            'data' => array_merge($this->data ?? [], ['is_active' => false])
        ]);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tenant) {
            if (empty($tenant->data)) {
                $tenant->data = [];
            }
            
            $tenant->data = array_merge($tenant->data, [
                'plan' => 'free',
                'subscription_status' => 'trial',
                'is_active' => true,
                'features' => $tenant->getDefaultFeatures(),
            ]);
        });
    }
}