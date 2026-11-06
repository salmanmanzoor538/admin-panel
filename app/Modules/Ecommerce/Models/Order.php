<?php

namespace App\Modules\Ecommerce\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Order extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'order_number',
        'user_id',
        'customer_email',
        'customer_first_name',
        'customer_last_name',
        'customer_phone',
        'billing_address',
        'shipping_address',
        'subtotal',
        'tax_amount',
        'shipping_amount',
        'discount_amount',
        'total_amount',
        'currency',
        'payment_method',
        'payment_status',
        'payment_reference',
        'shipping_method',
        'shipping_status',
        'tracking_number',
        'status',
        'notes',
        'internal_notes',
        'coupon_code',
        'coupon_discount',
        'refund_amount',
        'refund_reason',
        'completed_at',
        'cancelled_at',
        'refunded_at',
    ];

    protected $casts = [
        'billing_address' => 'array',
        'shipping_address' => 'array',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'coupon_discount' => 'decimal:2',
        'refund_amount' => 'decimal:2',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'refunded_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status', 'payment_status', 'shipping_status'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }

    public function getCustomerNameAttribute(): string
    {
        return trim($this->customer_first_name . ' ' . $this->customer_last_name);
    }

    public function getCustomerFullNameAttribute(): string
    {
        return $this->customer_name;
    }

    public function getFormattedTotalAttribute(): string
    {
        return '$' . number_format($this->total_amount, 2);
    }

    public function getFormattedSubtotalAttribute(): string
    {
        return '$' . number_format($this->subtotal, 2);
    }

    public function getFormattedTaxAmountAttribute(): string
    {
        return '$' . number_format($this->tax_amount, 2);
    }

    public function getFormattedShippingAmountAttribute(): string
    {
        return '$' . number_format($this->shipping_amount, 2);
    }

    public function getFormattedDiscountAmountAttribute(): string
    {
        return '$' . number_format($this->discount_amount, 2);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Pending',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
            'refunded' => 'Refunded',
            default => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'processing' => 'blue',
            'shipped' => 'purple',
            'delivered' => 'green',
            'cancelled' => 'red',
            'refunded' => 'gray',
            default => 'gray',
        };
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return match ($this->payment_status) {
            'pending' => 'Pending',
            'paid' => 'Paid',
            'failed' => 'Failed',
            'refunded' => 'Refunded',
            'partially_refunded' => 'Partially Refunded',
            default => ucfirst($this->payment_status),
        };
    }

    public function getPaymentStatusColorAttribute(): string
    {
        return match ($this->payment_status) {
            'pending' => 'yellow',
            'paid' => 'green',
            'failed' => 'red',
            'refunded' => 'gray',
            'partially_refunded' => 'orange',
            default => 'gray',
        };
    }

    public function getShippingStatusLabelAttribute(): string
    {
        return match ($this->shipping_status) {
            'pending' => 'Pending',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
            default => ucfirst($this->shipping_status),
        };
    }

    public function getShippingStatusColorAttribute(): string
    {
        return match ($this->shipping_status) {
            'pending' => 'yellow',
            'processing' => 'blue',
            'shipped' => 'purple',
            'delivered' => 'green',
            'cancelled' => 'red',
            default => 'gray',
        };
    }

    public function getTotalItemsAttribute(): int
    {
        return $this->items()->sum('quantity');
    }

    public function getTotalWeightAttribute(): float
    {
        return $this->items()->sum(function ($item) {
            return $item->quantity * $item->product->weight;
        });
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'processing']) && 
               in_array($this->payment_status, ['pending', 'paid']);
    }

    public function canBeRefunded(): bool
    {
        return $this->payment_status === 'paid' && 
               !in_array($this->status, ['cancelled', 'refunded']);
    }

    public function canBeShipped(): bool
    {
        return $this->payment_status === 'paid' && 
               in_array($this->status, ['processing']);
    }

    public function cancel(string $reason = null): bool
    {
        if (!$this->canBeCancelled()) {
            return false;
        }

        $this->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'notes' => $reason ? $this->notes . "\nCancelled: " . $reason : $this->notes,
        ]);

        // Restore inventory
        foreach ($this->items as $item) {
            $item->product->updateStock($item->quantity, 'increase');
        }

        return true;
    }

    public function refund(float $amount, string $reason = null): bool
    {
        if (!$this->canBeRefunded() || $amount > $this->total_amount) {
            return false;
        }

        $this->update([
            'refund_amount' => $amount,
            'refund_reason' => $reason,
            'refunded_at' => now(),
        ]);

        if ($amount >= $this->total_amount) {
            $this->update([
                'status' => 'refunded',
                'payment_status' => 'refunded',
            ]);
        } else {
            $this->update([
                'payment_status' => 'partially_refunded',
            ]);
        }

        return true;
    }

    public function markAsShipped(string $trackingNumber = null): bool
    {
        if (!$this->canBeShipped()) {
            return false;
        }

        $this->update([
            'status' => 'shipped',
            'shipping_status' => 'shipped',
            'tracking_number' => $trackingNumber,
        ]);

        return true;
    }

    public function markAsDelivered(): bool
    {
        if ($this->status !== 'shipped') {
            return false;
        }

        $this->update([
            'status' => 'delivered',
            'shipping_status' => 'delivered',
            'completed_at' => now(),
        ]);

        return true;
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByPaymentStatus($query, $status)
    {
        return $query->where('payment_status', $status);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'delivered');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'ORD-' . strtoupper(uniqid());
            }
            if (empty($order->status)) {
                $order->status = 'pending';
            }
            if (empty($order->payment_status)) {
                $order->payment_status = 'pending';
            }
            if (empty($order->shipping_status)) {
                $order->shipping_status = 'pending';
            }
            if (empty($order->currency)) {
                $order->currency = 'USD';
            }
        });
    }
}