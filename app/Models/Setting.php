<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Get setting value by key
     */
    public static function get($key, $default = null)
    {
        return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set setting value by key
     */
    public static function set($key, $value)
    {
        $setting = self::firstOrNew(['key' => $key]);
        $setting->value = $value;
        $setting->save();
        
        Cache::forget("setting_{$key}");
        
        return $setting;
    }

    /**
     * Get all settings as key-value array
     */
    public static function allAsArray()
    {
        return Cache::remember('settings_all', 3600, function () {
            return self::pluck('value', 'key')->toArray();
        });
    }

    /**
     * Clear settings cache
     */
    public static function clearCache()
    {
        Cache::forget('settings_all');
        self::all()->each(function ($setting) {
            Cache::forget("setting_{$setting->key}");
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            self::clearCache();
        });

        static::deleted(function () {
            self::clearCache();
        });
    }
}




