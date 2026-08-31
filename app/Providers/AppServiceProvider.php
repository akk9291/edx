<?php

namespace App\Providers;

use App\Models\InstagramReel;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\ServiceProvider;

/**
 * When static files are served from /public/... but APP_URL has no /public segment,
 * set app.asset_url so asset() yields .../public/assets/... .
 *
 * Priority: explicit ASSET_URL in config → else APP_PUBLIC_ASSET_BASE=true in .env
 * → else auto when DOCUMENT_ROOT realpath equals base_path() (docroot = project root).
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Load currency helper functions
        if (file_exists($helperPath = app_path('Helpers/CurrencyHelper.php'))) {
            require_once $helperPath;
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurePublicAssetBaseUrl();
        $this->ensureStorageLink();

        // Share alerts count with all views
        view()->composer('admin.layout', function ($view) {
            $lowStockCount = Product::where('stock_quantity', '<', 10)
                ->where('is_active', true)
                ->count();
            $pendingOrdersCount = Order::where('status', 'pending')->count();
            $alertsCount = $lowStockCount + $pendingOrdersCount;

            $view->with('alertsCount', $alertsCount);
        });

        view()->composer(
            ['home', 'category', 'shop.category'],
            function ($view) {
                $view->with(
                    'instagramReels',
                    InstagramReel::ordered()->get()
                );
            }
        );
    }

    protected function configurePublicAssetBaseUrl(): void
    {
        if (! filter_var(env('ASSET_URL_AUTO_PUBLIC', true), FILTER_VALIDATE_BOOLEAN)) {
            return;
        }

        if (filled(config('app.asset_url'))) {
            return;
        }

        $appUrl = rtrim((string) config('app.url'), '/');
        if ($appUrl === '') {
            return;
        }

        $forcePublic = filter_var(env('APP_PUBLIC_ASSET_BASE', false), FILTER_VALIDATE_BOOLEAN);
        if (! $forcePublic) {
            $docRoot = realpath((string) ($_SERVER['DOCUMENT_ROOT'] ?? '')) ?: '';
            $basePath = realpath(base_path()) ?: '';
            $forcePublic = $docRoot !== '' && $basePath !== '' && $docRoot === $basePath;
        }

        if ($forcePublic) {
            config(['app.asset_url' => $appUrl.'/public']);
        }
    }

    /**
     * Auto-heal public storage symlink / directories on deployment.
     */
    protected function ensureStorageLink(): void
    {
        $publicStorage = public_path('storage');
        $target = storage_path('app/public');

        if (! is_dir($target)) {
            @mkdir($target, 0775, true);
        }

        foreach (['categories', 'products', 'pillow-blocks', 'hero-banners', 'main-categories'] as $dir) {
            $sub = $target.'/'.$dir;
            if (! is_dir($sub)) {
                @mkdir($sub, 0775, true);
            }
        }

        if (! file_exists($publicStorage) && is_dir($target)) {
            try {
                @symlink($target, $publicStorage);
            } catch (\Throwable $e) {
                // If symlink cannot be created, web.php fallback route handles it
            }
        }
    }
}
