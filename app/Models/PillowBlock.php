<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PillowBlock extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'category_id',
        'brand',
        'short_description',
        'description',
        'price',
        'sale_price',
        'image',
        'video',
        'pdf_catalogue',
        'equiv_skf',
        'equiv_fag',
        'equiv_ntn',
        'equiv_timken',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_active',
        'in_stock',
        'is_featured',
        'is_new_arrival',
        'sort_order',

        // Specifications
        'bearing_number',
        'specifications',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'is_active' => 'boolean',
        'in_stock' => 'boolean',
        'is_featured' => 'boolean',
        'is_new_arrival' => 'boolean',
        'sort_order' => 'integer',
        'specifications' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pb) {
            if (empty($pb->slug)) {
                $pb->slug = Str::slug($pb->name);
            }
            if (empty($pb->sku)) {
                $pb->sku = 'PB-'.strtoupper(Str::random(8));
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function galleryImages()
    {
        return $this->hasMany(PillowBlockImage::class, 'pillow_block_id');
    }

    /**
     * Get list of gallery image paths as array, matching the behavior of Product model
     */
    public function getImagesAttribute(): array
    {
        return $this->galleryImages->pluck('image_path')->toArray();
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
     * Whether the pillow block has any customer-visible numeric price (MRP or sale).
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
     * Customer-facing title: name falling back to SKU.
     */
    public function getDisplayNameAttribute(): string
    {
        $name = trim((string) ($this->name ?? ''));
        if ($name !== '') {
            return $name;
        }

        return trim((string) ($this->sku ?? '')) ?: 'Pillow Block';
    }

    /**
     * Resolved main image URL for Blade / JSON
     */
    public function getImageUrlAttribute(): string
    {
        return self::publicUrlForPath($this->resolveMainImagePath());
    }

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

        // Priority 1: Product's own image (main or gallery) - only if file exists
        foreach ($candidates as $candidate) {
            if (self::isAcceptableImageSource($candidate) && self::storedFileExists($candidate)) {
                return $candidate;
            }
        }

        // Priority 2: Category image - only if category image exists
        $categoryImage = $this->category?->image;
        if (is_string($categoryImage) && trim($categoryImage) !== '' && self::isAcceptableImageSource($categoryImage) && self::storedFileExists($categoryImage)) {
            return trim($categoryImage);
        }

        // Priority 3: Fallback (publicUrlForPath returns default placeholder image)
        return null;
    }
}
