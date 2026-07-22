<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class QuotaRequest extends Model
{
    protected $fillable = [
        'reference',
        'company_name',
        'contact_name',
        'email',
        'phone',
        'message',
        'status',
        'admin_notes',
    ];

    public static function generateReference(): string
    {
        do {
            $ref = 'QR-'.strtoupper(Str::random(8));
        } while (self::query()->where('reference', $ref)->exists());

        return $ref;
    }

    public function items(): HasMany
    {
        return $this->hasMany(QuotaRequestItem::class);
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'warning',
            'in_review' => 'info',
            'quoted' => 'success',
            'closed' => 'secondary',
            'cancelled' => 'danger',
            default => 'secondary',
        };
    }
}
