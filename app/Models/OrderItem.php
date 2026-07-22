<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'size',
        'color',
        'customization_json',
        'customization_image',
        // Legacy fields
        'product_name',
        'product_sku',
        'total',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return array<string, mixed>|null
     */
    public function customizationArray(): ?array
    {
        if ($this->customization_json === null || $this->customization_json === '') {
            return null;
        }
        $d = json_decode($this->customization_json, true);

        return is_array($d) ? $d : null;
    }

    public function adminDisplayProductTitle(): string
    {
        $d = $this->customizationArray();
        if ($d && ! empty($d['product_title']) && is_string($d['product_title'])) {
            return $d['product_title'];
        }

        return (string) ($this->product_name ?? $this->product?->name ?? '');
    }

    public function adminDisplaySize(): string
    {
        if ($this->size !== null && $this->size !== '') {
            return (string) $this->size;
        }
        $d = $this->customizationArray();
        if ($d === null) {
            return '';
        }
        if (! empty($d['size_name']) && is_string($d['size_name'])) {
            return $d['size_name'];
        }
        if (array_key_exists('size_idx', $d)) {
            return 'Size #'.(((int) $d['size_idx']) + 1);
        }

        return '';
    }

    /**
     * Safe hex for inline CSS swatches (admin only).
     */
    public static function sanitizeHex(?string $hex): ?string
    {
        if ($hex === null || $hex === '') {
            return null;
        }
        $h = strtoupper(ltrim(trim($hex), '#'));
        if (preg_match('/^[0-9A-F]{6}$/', $h)) {
            return '#'.$h;
        }
        if (preg_match('/^[0-9A-F]{3}$/', $h)) {
            return '#'.$h[0].$h[0].$h[1].$h[1].$h[2].$h[2];
        }

        return null;
    }

    /**
     * @return list<array{label: string, name: string, hex: ?string}>
     */
    public function adminCustomizationColorLines(): array
    {
        $d = $this->customizationArray();
        if ($d === null || empty($d['colors']) || ! is_array($d['colors'])) {
            return [];
        }

        $labels = [
            'body' => 'Body',
            'lid_ring' => 'Cap',
            'straw' => 'Straw',
            'handle' => 'Handle',
            'bottom_base' => 'Bottom base',
        ];

        $out = [];
        foreach ($labels as $key => $label) {
            if (! isset($d['colors'][$key]) || ! is_array($d['colors'][$key])) {
                continue;
            }
            $c = $d['colors'][$key];
            $name = isset($c['name']) && is_string($c['name']) ? $c['name'] : '';
            $hexRaw = isset($c['hex']) && is_string($c['hex']) ? $c['hex'] : '';
            $hex = self::sanitizeHex($hexRaw);
            if ($name === '' && $hex === null) {
                continue;
            }
            $out[] = ['label' => $label, 'name' => $name, 'hex' => $hex];
        }

        return $out;
    }
}
