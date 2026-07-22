<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstagramReel extends Model
{
    protected $fillable = [
        'url',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Instagram share URL → iframe embed URL (reel / post / tv).
     */
    public static function urlToEmbedUrl(string $url): ?string
    {
        $url = trim($url);
        if ($url === '') {
            return null;
        }

        if (! preg_match('#instagram\.com/(reel|reels|p|tv)/([A-Za-z0-9_-]+)#i', $url, $m)) {
            return null;
        }

        $kind = strtolower($m[1]);
        $code = $m[2];

        if (in_array($kind, ['reel', 'reels', 'tv'], true)) {
            return 'https://www.instagram.com/reel/'.$code.'/embed/';
        }

        return 'https://www.instagram.com/p/'.$code.'/embed/';
    }

    public function getEmbedUrlAttribute(): ?string
    {
        return self::urlToEmbedUrl($this->url);
    }
}
