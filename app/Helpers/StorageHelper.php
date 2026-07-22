<?php

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

if (! function_exists('storage_asset')) {
    /**
     * Public URL for a path on the public disk, or '' if missing.
     * Uses request-relative /storage/... when the file exists (avoids broken img when APP_URL/host mismatches).
     */
    function storage_asset(?string $path): string
    {
        if ($path === null || ! is_string($path)) {
            return '';
        }

        $path = ltrim(trim($path), '/');
        if ($path === '') {
            return '';
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '//')) {
            return Product::pathLooksLikeRemoteImageUrl($path) ? $path : '';
        }

        if (str_starts_with($path, 'assets/')) {
            return is_file(public_path($path)) ? asset($path) : '';
        }

        if (Storage::disk('public')->exists($path)) {
            return url('storage/'.$path);
        }

        if (is_file(public_path($path))) {
            return asset($path);
        }

        return '';
    }
}
