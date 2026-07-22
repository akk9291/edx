<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Fix storage link and permissions so uploaded images (avatar, categories, etc.) show on server
Artisan::command('storage:fix', function () {
    $storagePublic = storage_path('app/public');
    $publicStorage = public_path('storage');

    // 1. Create storage/app/public and required subdirs
    $dirs = [
        $storagePublic,
        $storagePublic . '/avatars',
        $storagePublic . '/main-categories',
        $storagePublic . '/main-categories/hero',
        $storagePublic . '/main-categories/banners',
        $storagePublic . '/main-categories/bottom-banner',
        $storagePublic . '/main-categories/additional-banner',
        $storagePublic . '/products',
    ];
    foreach ($dirs as $dir) {
        if (!File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true);
            $this->info("Created: {$dir}");
        }
    }

    // 2. Create storage symlink if missing
    if (!file_exists($publicStorage)) {
        try {
            Artisan::call('storage:link');
            $this->info('Storage link created: public/storage -> storage/app/public');
        } catch (\Throwable $e) {
            $this->warn('Could not create storage link: ' . $e->getMessage());
            $this->line('Run manually: php artisan storage:link');
        }
    } else {
        $this->info('Storage link already exists.');
    }

    // 3. Make storage/app/public and subdirs writable (0755 or 0775)
    $this->line('Setting permissions on storage/app/public (0755)...');
    foreach ($dirs as $dir) {
        if (is_dir($dir) && @chmod($dir, 0755)) {
            $this->line("  OK: {$dir}");
        }
    }

    $this->newLine();
    $this->info('If images still do not show on server:');
    $this->line('1. Ensure APP_URL in .env is correct (e.g. https://perchlife.in)');
    $this->line('2. Run: php artisan storage:link (if link was not created)');
    $this->line('3. Permissions:');
    $this->line('   - Shared hosting (no sudo): chmod -R 775 storage bootstrap/cache');
    $this->line('   - VPS with sudo: sudo chown -R www-data:www-data storage bootstrap/cache && sudo chmod -R 775 storage bootstrap/cache');
    $this->line('4. On SELinux: sudo chcon -R -t httpd_sys_rw_content_t storage');
})->purpose('Create storage link and fix permissions for uploaded images on server');
