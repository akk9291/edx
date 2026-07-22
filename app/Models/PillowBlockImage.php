<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PillowBlockImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'pillow_block_id',
        'image_path',
    ];

    public function pillowBlock()
    {
        return $this->belongsTo(PillowBlock::class);
    }
}
