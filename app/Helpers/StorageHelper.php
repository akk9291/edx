<?php

use App\Models\Product;

if (! function_exists('storage_asset')) {
    /**
     * Public URL for a path on the public disk, or '' if missing.
     * Uses /media/{path} route to serve reliably across all environments (bypassing Hostinger LiteSpeed symlink 403 blocks).
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

        // 3. Strip leading storage/ or media/ if already present
        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, 8);
        } elseif (str_starts_with($path, 'media/')) {
            $path = substr($path, 6);
        }

        // 4. Return reliable media route URL
        return url('/media/'.$path);
    }
}
