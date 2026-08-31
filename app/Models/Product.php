<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'category_id',
        'price',
        'sale_price',
        'sku',
        'stock_quantity',
        'stock',
        'in_stock',
        'is_active',
        'is_featured',
        'is_new_arrival',
        'image',
        'images',
        'color_images',
        'video',
        'sizes',
        'colors',
        'specifications',
        'customize_config',
        'product_type',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'stock' => 'integer',
        'in_stock' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_new_arrival' => 'boolean',
        'images' => 'array',
        'color_images' => 'array',
        'sizes' => 'array',
        'colors' => 'array',
        'specifications' => 'array',
        'customize_config' => 'array',
        'sort_order' => 'integer',
    ];

    /**
     * Keys stored in `specifications` JSON for bearing catalog (admin form, CSV import, storefront tabs).
     *
     * @return list<string>
     */
    public static function bearingStructuredSpecKeys(): array
    {
        return [
            'bore_diameter',
            'outside_diameter',
            'width',
            'dynamic_load_rating',
            'static_load_rating',
            'limiting_speed_grease',
            'limiting_speed_oil',
            'number_of_rows',
            'radial_clearance',
            'tolerance_class',
            'cage',
            'bore_type',
            'weight',
            'equiv_skf',
            'equiv_fag',
            'equiv_ntn',
            'equiv_timken',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            if (empty($product->sku)) {
                $product->sku = 'PROD-'.strtoupper(Str::random(8));
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Limit to products under the Bearings main category (edx-bearing HTML catalog).
     */
    public function scopeEdxBearingsCatalog(Builder $query): Builder
    {
        $id = MainCategory::bearingsCatalogId();
        if ($id === null) {
            return $query;
        }

        return $query->whereHas('category', function (Builder $q) use ($id) {
            $q->where('main_category_id', $id);
        });
    }

    /**
     * Get cart items for this product
     */
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get inventories for this product
     */
    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    /**
     * Get order items for this product
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get approved reviews (top-level, no replies in main list)
     */
    public function reviews()
    {
        return $this->hasMany(ProductReview::class)->whereNull('parent_id')->where('is_approved', true)->orderBy('created_at', 'desc');
    }

    /**
     * All reviews for rating stats (approved only)
     */
    public function allApprovedReviews()
    {
        return $this->hasMany(ProductReview::class)->where('is_approved', true);
    }

    /**
     * Whether the product has any customer-visible numeric price (MRP or sale).
     */
    public function hasDisplayablePrice(): bool
    {
        $mrp = (float) ($this->attributes['price'] ?? 0);
        $sale = $this->sale_price;

        if ($mrp > 0) {
            return true;
        }

        return $sale !== null && (float) $sale > 0;
    }

    /**
     * Get current price (sale_price if available, otherwise price)
     */
    public function getCurrentPriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }

    /**
     * Get final price (alias for current_price)
     */
    public function getFinalPriceAttribute()
    {
        return $this->current_price;
    }

    /**
     * Get discount percentage
     */
    public function getDiscountPercentageAttribute()
    {
        if ($this->sale_price && $this->price > $this->sale_price) {
            return round((($this->price - $this->sale_price) / $this->price) * 100);
        }

        return 0;
    }

    /**
     * Get total stock (sum of all inventory quantities)
     */
    public function getTotalStockAttribute()
    {
        return $this->inventories()->sum('quantity');
    }

    /**
     * Sync product stock_quantity and in_stock from inventory totals (e.g. after order deducts inventory)
     */
    public function syncStockFromInventories(): void
    {
        $total = (int) $this->inventories()->sum('quantity');
        $this->update([
            'stock_quantity' => $total,
            'in_stock' => $total > 0,
        ]);
    }

    /**
     * Get stock for specific color and size
     */
    public function getStockForColorSize($color = null, $size = null)
    {
        $query = $this->inventories();

        if ($color) {
            $query->where('color', $color);
        }

        if ($size) {
            $query->where('size', $size);
        }

        return $query->sum('quantity');
    }

    /**
     * Get image URL for a color variant (from color_images), or fallback to main image
     */
    public function getImageForColor($color)
    {
        if (! $color) {
            return $this->image;
        }
        $colorImages = $this->color_images ?? [];
        $key = trim($color);
        if (isset($colorImages[$key]) && $colorImages[$key]) {
            return $colorImages[$key];
        }

        return $this->image;
    }

    /**
     * True when a remote URL is very likely to return image bytes (not an HTML attachment page or site URL).
     */
    public static function pathLooksLikeRemoteImageUrl(string $url): bool
    {
        $url = trim($url);
        if ($url === '') {
            return false;
        }

        if (str_starts_with($url, '//')) {
            $url = 'https:'.$url;
        }

        if (! str_starts_with($url, 'http://') && ! str_starts_with($url, 'https://')) {
            return false;
        }

        $parsed = parse_url($url);
        if (! is_array($parsed)) {
            return false;
        }

        $pathname = $parsed['path'] ?? '';
        if ($pathname !== '' && preg_match('/\.(jpe?g|png|gif|webp|avif|svg|bmp)(\/)?$/i', $pathname)) {
            return true;
        }

        $query = $parsed['query'] ?? '';
        if ($query !== '' && preg_match('/(^|&)(format|fm|type)=(webp|jpg|jpeg|png|gif)/i', $query)) {
            return true;
        }

        return false;
    }

    /**
     * Whether this stored reference should be used as an <img> src (skips obvious HTML page links).
     */
    public static function isAcceptableImageSource(?string $path): bool
    {
        if ($path === null || ! is_string($path)) {
            return false;
        }
        $path = trim($path);
        if ($path === '' || str_contains($path, 'PhotoshopExtension_Image-1.webp') || str_ends_with($path, '.tmp') || str_contains($path, 'Temp')) {
            return false;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '//')) {
            return self::pathLooksLikeRemoteImageUrl($path);
        }

        return true;
    }

    /**
     * Public URL for a stored image path (uploads under storage/app/public, or static files under public/).
     */
    public static function publicUrlForPath(?string $path): string
    {
        $fallback = asset('assets/images/PhotoshopExtension_Image-1.webp');

        if ($path === null || $path === '') {
            return $fallback;
        }

        $raw = trim((string) $path);

        if (str_starts_with($raw, 'http://') || str_starts_with($raw, 'https://') || str_starts_with($raw, '//')) {
            if (! self::pathLooksLikeRemoteImageUrl($raw)) {
                return $fallback;
            }

            return $raw;
        }

        $url = storage_asset($raw);

        return $url !== '' ? $url : $fallback;
    }

    /**
     * Check if a stored path or remote image actually exists on disk / remote.
     */
    public static function storedFileExists(?string $path): bool
    {
        if ($path === null || ! is_string($path)) {
            return false;
        }
        $path = trim($path);
        if ($path === '') {
            return false;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '//')) {
            return self::pathLooksLikeRemoteImageUrl($path);
        }

        $clean = ltrim($path, '/');
        if (str_starts_with($clean, 'storage/')) {
            $clean = substr($clean, 8);
        }

        if (str_starts_with($clean, 'assets/')) {
            return file_exists(public_path($clean));
        }

        if (file_exists(storage_path('app/public/'.$clean))) {
            return true;
        }

        if (file_exists(public_path('storage/'.$clean)) || file_exists(public_path($clean))) {
            return true;
        }

        return false;
    }

    /**
     * First usable image path: main image, then gallery, then imported bearing_image in specifications.
     */
    public function resolveMainImagePath(): ?string
    {
        $candidates = [];

        $push = function ($v) use (&$candidates): void {
            if (! is_string($v)) {
                return;
            }
            $v = trim($v);
            if ($v === '') {
                return;
            }
            $candidates[] = $v;
        };

        $push($this->attributes['image'] ?? null);

        $gallery = $this->images;
        if (is_array($gallery)) {
            foreach ($gallery as $item) {
                $push(is_string($item) ? $item : null);
            }
        }

        $specs = $this->specifications;
        if (is_string($specs)) {
            $decoded = json_decode($specs, true);
            $specs = is_array($decoded) ? $decoded : [];
        } elseif (! is_array($specs)) {
            $specs = [];
        }
        $push($specs['bearing_image'] ?? null);

        // Priority 1: Product's own image (main, gallery, or imported specs) - only if file actually exists
        foreach ($candidates as $candidate) {
            if (self::isAcceptableImageSource($candidate) && self::storedFileExists($candidate)) {
                return $candidate;
            }
        }

        // Priority 2: Category image - only if category image actually exists
        $categoryImage = $this->category?->image;
        if (is_string($categoryImage) && trim($categoryImage) !== '' && self::isAcceptableImageSource($categoryImage) && self::storedFileExists($categoryImage)) {
            return trim($categoryImage);
        }

        // Priority 3: Fallback (publicUrlForPath returns default placeholder image)
        return null;
    }

    /**
     * Customer-facing title: admin product name, falling back to SKU.
     */
    public function getDisplayNameAttribute(): string
    {
        $name = trim((string) ($this->name ?? ''));
        if ($name !== '') {
            return $name;
        }

        return trim((string) ($this->sku ?? '')) ?: 'Product';
    }

    /**
     * Resolved main image URL for Blade / JSON (never points at wrong /storage/... for public assets).
     */
    public function getImageUrlAttribute(): string
    {
        return self::publicUrlForPath($this->resolveMainImagePath());
    }
}
