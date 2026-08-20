<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Products count: " . App\Models\Product::count() . "\n";
echo "Pillow blocks count: " . App\Models\PillowBlock::count() . "\n";

// Print columns of products table
$prodColumns = Schema::getColumnListing('products');
echo "Products columns: " . json_encode($prodColumns) . "\n";

// Print columns of pillow_blocks table
$pbColumns = Schema::getColumnListing('pillow_blocks');
echo "Pillow blocks columns: " . json_encode($pbColumns) . "\n";
