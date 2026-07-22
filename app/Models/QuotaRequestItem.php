<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuotaRequestItem extends Model
{
    protected $fillable = [
        'quota_request_id',
        'product_id',
        'quantity',
        'product_sku',
        'product_name',
    ];

    public function quotaRequest(): BelongsTo
    {
        return $this->belongsTo(QuotaRequest::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
