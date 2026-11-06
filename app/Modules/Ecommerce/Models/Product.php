<?php

namespace App\Modules\Ecommerce\Models;

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

class Product extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, LogsActivity, InteractsWithMedia, HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'sku',
        'price',
        'compare_price',
        'cost_price',
        'stock_quantity',
        'low_stock_threshold',
        'weight',
        'dimensions',
        'status',
        'featured',
        'digital',
        'downloadable',
        'virtual',
        'requires_shipping',
        'taxable',
        'tax_class',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'meta_data',
        'attributes',
        'variations',
        'categories',
        'tags',
        'related_products',
        'upsells',
        'cross_sells',
        'views_count',
        'sales_count',
        'rating_average',
        'rating_count',
        'user_id',
        'brand_id',
        'published_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'weight' => 'decimal:2',
        'dimensions' => 'array',
        'featured' => 'boolean',
        'digital' => 'boolean',
        'downloadable' => 'boolean',
        'virtual' => 'boolean',
        'requires_shipping' => 'boolean',
        'taxable' => 'boolean',
        'meta_data' => 'array',
        'attributes' => 'array',
        'variations' => 'array',
        'categories' => 'array',
        'tags' => 'array',
        'related_products' => 'array',
        'upsells' => 'array',
        'cross_sells' => 'array',
        'views_count' => 'integer',
        'sales_count' => 'integer',
        'rating_average' => 'decimal:2',
        'rating_count' => 'integer',
        'published_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'price', 'status', 'stock_quantity'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(ProductReview::class)->where('status', 'approved');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function inventory()
    {
        return $this->hasMany(ProductInventory::class);
    }

    public function getCurrentStockAttribute(): int
    {
        return $this->stock_quantity;
    }

    public function getIsInStockAttribute(): bool
    {
        return $this->stock_quantity > 0;
    }

    public function getIsLowStockAttribute(): bool
    {
        return $this->stock_quantity <= $this->low_stock_threshold;
    }

    public function getIsOnSaleAttribute(): bool
    {
        return $this->compare_price && $this->compare_price > $this->price;
    }

    public function getDiscountPercentageAttribute(): float
    {
        if (!$this->is_on_sale) {
            return 0;
        }

        return round((($this->compare_price - $this->price) / $this->compare_price) * 100, 2);
    }

    public function getFeaturedImageUrlAttribute(): ?string
    {
        $media = $this->getFirstMedia('featured');
        return $media ? $media->getUrl() : null;
    }

    public function getGalleryImagesAttribute(): array
    {
        return $this->getMedia('gallery')->map(function ($media) {
            return [
                'id' => $media->id,
                'url' => $media->getUrl(),
                'thumbnail' => $media->getUrl('thumbnail'),
                'alt' => $media->getCustomProperty('alt'),
            ];
        })->toArray();
    }

    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price, 2);
    }

    public function getFormattedComparePriceAttribute(): string
    {
        return $this->compare_price ? '$' . number_format($this->compare_price, 2) : '';
    }

    public function getStockStatusAttribute(): string
    {
        if ($this->stock_quantity <= 0) {
            return 'out_of_stock';
        } elseif ($this->is_low_stock) {
            return 'low_stock';
        } else {
            return 'in_stock';
        }
    }

    public function getStockStatusLabelAttribute(): string
    {
        return match ($this->stock_status) {
            'in_stock' => 'In Stock',
            'low_stock' => 'Low Stock',
            'out_of_stock' => 'Out of Stock',
            default => 'Unknown',
        };
    }

    public function getStockStatusColorAttribute(): string
    {
        return match ($this->stock_status) {
            'in_stock' => 'green',
            'low_stock' => 'yellow',
            'out_of_stock' => 'red',
            default => 'gray',
        };
    }

    public function updateStock(int $quantity, string $type = 'decrease'): bool
    {
        if ($type === 'decrease') {
            if ($this->stock_quantity < $quantity) {
                return false;
            }
            $this->decrement('stock_quantity', $quantity);
        } else {
            $this->increment('stock_quantity', $quantity);
        }

        return true;
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    public function incrementSales(int $quantity = 1): void
    {
        $this->increment('sales_count', $quantity);
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

    public function getRelatedProductsAttribute(): array
    {
        if (!empty($this->related_products)) {
            return $this->related_products;
        }

        // Auto-generate related products based on categories
        $related = static::published()
            ->where('id', '!=', $this->id)
            ->where(function ($query) {
                foreach ($this->categories ?? [] as $categoryId) {
                    $query->orWhereJsonContains('categories', $categoryId);
                }
            })
            ->limit(4)
            ->get();

        return $related->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $product->price,
                'featured_image' => $product->featured_image_url,
                'rating' => $product->rating_average,
            ];
        })->toArray();
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    public function scopeOnSale($query)
    {
        return $query->whereNotNull('compare_price')
                    ->whereColumn('compare_price', '>', 'price');
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->whereJsonContains('categories', $categoryId);
    }

    public function scopeByPriceRange($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
              ->orWhere('description', 'like', "%{$term}%")
              ->orWhere('sku', 'like', "%{$term}%");
        });
    }

    public function scopeSortBy($query, $sort)
    {
        return match ($sort) {
            'price_low' => $query->orderBy('price', 'asc'),
            'price_high' => $query->orderBy('price', 'desc'),
            'newest' => $query->orderBy('created_at', 'desc'),
            'oldest' => $query->orderBy('created_at', 'asc'),
            'popular' => $query->orderBy('sales_count', 'desc'),
            'rating' => $query->orderBy('rating_average', 'desc'),
            'name' => $query->orderBy('name', 'asc'),
            default => $query->orderBy('created_at', 'desc'),
        };
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->status)) {
                $product->status = 'draft';
            }
            if (empty($product->sku)) {
                $product->sku = 'PROD-' . strtoupper(uniqid());
            }
            if (empty($product->stock_quantity)) {
                $product->stock_quantity = 0;
            }
            if (empty($product->low_stock_threshold)) {
                $product->low_stock_threshold = 10;
            }
            if (empty($product->views_count)) {
                $product->views_count = 0;
            }
            if (empty($product->sales_count)) {
                $product->sales_count = 0;
            }
            if (empty($product->rating_average)) {
                $product->rating_average = 0;
            }
            if (empty($product->rating_count)) {
                $product->rating_count = 0;
            }
        });

        static::saving(function ($product) {
            if ($product->status === 'published' && empty($product->published_at)) {
                $product->published_at = now();
            }
        });
    }
}