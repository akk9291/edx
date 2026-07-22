<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ProductSeeder extends Seeder
{
    /**
     * Available product images
     */
    private $productImages = [
        'perch-bottal.webp',
        'Bottle-1.webp',
        'Bottle-4.webp',
        'Bottle-8.webp',
        '20250521_1801_Stylish-Thermos-Bottle_remix_01jvsd3j07f6a9rm70wqvvb657-1-1.webp',
        '20250521_1821_Funky-Purple-Bottle_remix_01jvse8qtcf3rb4t4cy114y0x1-1.webp',
        '20250614_1217_Color-Coordinated-Background_remix_01jxpjzpcdf599yv9ssqfqndfm.webp',
        '20250614_1238_Floral-Bottle-Harmony_remix_01jxpm7f78f0dtz5hba3sy1fp2.webp',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories
        $categories = Category::all();
        
        if ($categories->isEmpty()) {
            $this->command->warn('No categories found. Please run CategorySeeder first.');
            return;
        }

        // Clear existing products if needed (optional - comment out if you want to keep existing products)
        // Product::truncate();

        // Product data matching the screenshot
        $products = [
            // Featured Products (from screenshot)
            [
                'name' => 'Hydro Double Wall Bottle 1L',
                'price' => 44.99,
                'sale_price' => 39.99,
                'stock' => 22,
                'category' => 'Double wall Bottles',
                'is_featured' => true,
                'is_new_arrival' => false,
                'image' => 'perch-bottal.webp',
                'sort_order' => 1,
            ],
            [
                'name' => 'Elegant Single Wall Bottle 1L',
                'price' => 29.99,
                'sale_price' => null,
                'stock' => 38,
                'category' => 'Single Wall Bottles',
                'is_featured' => true,
                'is_new_arrival' => true,
                'image' => 'Bottle-1.webp',
                'sort_order' => 2,
            ],
            [
                'name' => 'Oasis Pro Double Wall Bottle 1L',
                'price' => 39.99,
                'sale_price' => 34.99,
                'stock' => 25,
                'category' => 'Double wall Bottles',
                'is_featured' => true,
                'is_new_arrival' => false,
                'image' => 'Bottle-4.webp',
                'sort_order' => 3,
            ],
            [
                'name' => 'Zenith Double Wall Bottle 500ml',
                'price' => 29.99,
                'sale_price' => 24.99,
                'stock' => 50,
                'category' => 'Double wall Bottles',
                'is_featured' => true,
                'is_new_arrival' => false,
                'image' => 'Bottle-8.webp',
                'sort_order' => 4,
            ],
            
            // More Double Wall Bottles
            [
                'name' => 'Oasis Double Wall Bottle 750ml',
                'price' => 34.99,
                'sale_price' => null,
                'stock' => 30,
                'category' => 'Double wall Bottles',
                'is_featured' => false,
                'is_new_arrival' => true,
                'image' => '20250521_1801_Stylish-Thermos-Bottle_remix_01jvsd3j07f6a9rm70wqvvb657-1-1.webp',
                'sort_order' => 5,
            ],
            [
                'name' => 'Zion Double Wall Bottle 500ml',
                'price' => 27.99,
                'sale_price' => null,
                'stock' => 40,
                'category' => 'Double wall Bottles',
                'is_featured' => false,
                'is_new_arrival' => false,
                'image' => '20250521_1821_Funky-Purple-Bottle_remix_01jvse8qtcf3rb4t4cy114y0x1-1.webp',
                'sort_order' => 6,
            ],
            [
                'name' => 'California Double Wall Bottle 750ml',
                'price' => 32.99,
                'sale_price' => 28.99,
                'stock' => 35,
                'category' => 'Double wall Bottles',
                'is_featured' => true,
                'is_new_arrival' => false,
                'image' => '20250614_1217_Color-Coordinated-Background_remix_01jxpjzpcdf599yv9ssqfqndfm.webp',
                'sort_order' => 7,
            ],
            [
                'name' => 'Apex Double Wall Bottle 1L',
                'price' => 42.99,
                'sale_price' => null,
                'stock' => 20,
                'category' => 'Double wall Bottles',
                'is_featured' => false,
                'is_new_arrival' => true,
                'image' => '20250614_1238_Floral-Bottle-Harmony_remix_01jxpm7f78f0dtz5hba3sy1fp2.webp',
                'sort_order' => 8,
            ],
            [
                'name' => 'Retro Double Wall Bottle 500ml',
                'price' => 31.99,
                'sale_price' => 27.99,
                'stock' => 15,
                'category' => 'Double wall Bottles',
                'is_featured' => true,
                'is_new_arrival' => false,
                'image' => 'perch-bottal.webp',
                'sort_order' => 9,
            ],
            [
                'name' => 'Froste Double Wall Bottle 750ml',
                'price' => 36.99,
                'sale_price' => null,
                'stock' => 28,
                'category' => 'Double wall Bottles',
                'is_featured' => false,
                'is_new_arrival' => false,
                'image' => 'Bottle-1.webp',
                'sort_order' => 10,
            ],
            
            // Single Wall Bottles
            [
                'name' => 'Magic Single Wall Bottle 500ml',
                'price' => 19.99,
                'sale_price' => null,
                'stock' => 60,
                'category' => 'Single Wall Bottles',
                'is_featured' => false,
                'is_new_arrival' => true,
                'image' => 'Bottle-4.webp',
                'sort_order' => 11,
            ],
            [
                'name' => 'Classic Single Wall Bottle 750ml',
                'price' => 24.99,
                'sale_price' => 21.99,
                'stock' => 45,
                'category' => 'Single Wall Bottles',
                'is_featured' => true,
                'is_new_arrival' => false,
                'image' => 'Bottle-8.webp',
                'sort_order' => 12,
            ],
            
            // Barware Essentials
            [
                'name' => 'Elite Kit Barware Set',
                'price' => 89.99,
                'sale_price' => 79.99,
                'stock' => 12,
                'category' => 'Barware Essentials',
                'is_featured' => true,
                'is_new_arrival' => false,
                'image' => 'perch-bottal.webp',
                'sort_order' => 13,
            ],
            [
                'name' => 'Perch O Holic Cocktail Shaker',
                'price' => 45.99,
                'sale_price' => null,
                'stock' => 25,
                'category' => 'Barware Essentials',
                'is_featured' => false,
                'is_new_arrival' => true,
                'image' => 'Bottle-1.webp',
                'sort_order' => 14,
            ],
            [
                'name' => 'Premium Bar Tools Set',
                'price' => 65.99,
                'sale_price' => 55.99,
                'stock' => 18,
                'category' => 'Barware Essentials',
                'is_featured' => true,
                'is_new_arrival' => false,
                'image' => 'Bottle-4.webp',
                'sort_order' => 15,
            ],
            [
                'name' => 'Professional Mixing Set',
                'price' => 52.99,
                'sale_price' => null,
                'stock' => 20,
                'category' => 'Barware Essentials',
                'is_featured' => false,
                'is_new_arrival' => false,
                'image' => 'Bottle-8.webp',
                'sort_order' => 16,
            ],
            
            // Home & Kitchen
            [
                'name' => 'Speckle Storage Container Set',
                'price' => 39.99,
                'sale_price' => 34.99,
                'stock' => 30,
                'category' => 'Home & Kitchen',
                'is_featured' => true,
                'is_new_arrival' => false,
                'image' => 'perch-bottal.webp',
                'sort_order' => 17,
            ],
            [
                'name' => 'Modern Kitchen Utensil Set',
                'price' => 49.99,
                'sale_price' => null,
                'stock' => 25,
                'category' => 'Home & Kitchen',
                'is_featured' => false,
                'is_new_arrival' => true,
                'image' => 'Bottle-1.webp',
                'sort_order' => 18,
            ],
            [
                'name' => 'Premium Cookware Set',
                'price' => 129.99,
                'sale_price' => 109.99,
                'stock' => 8,
                'category' => 'Home & Kitchen',
                'is_featured' => true,
                'is_new_arrival' => false,
                'image' => 'Bottle-4.webp',
                'sort_order' => 19,
            ],
        ];

        foreach ($products as $index => $productData) {
            // Find category by name
            $category = $categories->firstWhere('name', $productData['category']);
            
            if (!$category) {
                // Try to find a subcategory
                $category = $categories->first(function ($cat) use ($productData) {
                    return $cat->parent && $cat->parent->name === $productData['category'];
                });
                
                if (!$category) {
                    // Use first available category as fallback
                    $category = $categories->first();
                }
            }

            // Handle image - use asset path directly (images are in public folder)
            $imagePath = null;
            if (isset($productData['image'])) {
                $sourcePath = public_path('assets/images/product/' . $productData['image']);
                if (File::exists($sourcePath)) {
                    // For now, store the relative path - images are already in public/assets/images/product
                    // In production, you might want to copy to storage, but for development this works
                    $imagePath = 'assets/images/product/' . $productData['image'];
                } else {
                    // Fallback to default image
                    $imagePath = 'assets/images/product/perch-bottal.webp';
                }
            } else {
                // Default image if none specified
                $imagePath = 'assets/images/product/perch-bottal.webp';
            }

            // Check if product already exists
            $slug = Str::slug($productData['name']);
            $existingProduct = Product::where('slug', $slug)->first();
            
            if ($existingProduct) {
                $existingProduct->update([
                    'name' => $productData['name'],
                    'description' => $this->generateDescription($productData['name']),
                    'short_description' => $this->generateShortDescription($productData['name']),
                    'category_id' => $category ? $category->id : null,
                    'price' => $productData['price'],
                    'sale_price' => $productData['sale_price'],
                    'stock_quantity' => $productData['stock'],
                    'in_stock' => $productData['stock'] > 0,
                    'is_active' => true,
                    'is_featured' => $productData['is_featured'] ?? false,
                    'is_new_arrival' => $productData['is_new_arrival'] ?? false,
                    'image' => $imagePath,
                    'images' => $imagePath ? [$imagePath] : null,
                    'sort_order' => $productData['sort_order'] ?? $index + 1,
                ]);
            } else {
                Product::create([
                    'name' => $productData['name'],
                    'slug' => $slug,
                    'description' => $this->generateDescription($productData['name']),
                    'short_description' => $this->generateShortDescription($productData['name']),
                    'category_id' => $category ? $category->id : null,
                    'price' => $productData['price'],
                    'sale_price' => $productData['sale_price'],
                    'sku' => 'PROD-' . strtoupper(Str::random(8)),
                    'stock_quantity' => $productData['stock'],
                    'in_stock' => $productData['stock'] > 0,
                    'is_active' => true,
                    'is_featured' => $productData['is_featured'] ?? false,
                    'is_new_arrival' => $productData['is_new_arrival'] ?? false,
                    'image' => $imagePath,
                    'images' => $imagePath ? [$imagePath] : null,
                    'sort_order' => $productData['sort_order'] ?? $index + 1,
                ]);
            }
        }

        $this->command->info('Products seeded successfully with images!');
    }

    private function generateDescription($name): string
    {
        $descriptions = [
            "Premium quality {$name}. Made with high-grade materials for durability and style. Perfect for everyday use. Features excellent craftsmanship and modern design.",
            "Experience the perfect blend of style and functionality with our {$name}. Designed with attention to detail, this product offers superior quality and performance.",
            "The {$name} combines innovative design with practical functionality. Built to last with premium materials, it's the perfect addition to your collection.",
            "Discover the elegance of our {$name}. Crafted with precision and care, this product delivers exceptional quality and timeless design.",
        ];
        
        return $descriptions[array_rand($descriptions)];
    }

    private function generateShortDescription($name): string
    {
        return "High-quality {$name} with modern design and premium materials. Perfect for daily use.";
    }
}
