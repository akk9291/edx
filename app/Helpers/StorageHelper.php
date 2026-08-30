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

        // 1. Remote URLs (http://, https://, //)
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '//')) {
            return Product::pathLooksLikeRemoteImageUrl($path) ? $path : '';
        }

        // 2. Static public assets (e.g. assets/images/...)
        if (str_starts_with($path, 'assets/')) {
            return asset($path);
        }

        // 3. Path already starting with storage/
        if (str_starts_with($path, 'storage/')) {
            return asset($path);
        }

        // 4. Stored on public storage disk (e.g. products/xyz.jpg)
        return asset('storage/'.$path);
    }
}
