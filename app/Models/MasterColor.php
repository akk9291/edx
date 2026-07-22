<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterColor extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'color_code', 'sort_order'];

    protected $casts = [
        'sort_order' => 'integer',
    ];
}
