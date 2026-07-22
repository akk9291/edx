<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\MainCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Main Categories first
        $mainDrinkware = MainCategory::updateOrCreate(
            ['slug' => 'drinkware'],
            [
                'name' => 'Drinkware',
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        $mainBarware = MainCategory::updateOrCreate(
            ['slug' => 'barware'],
            [
                'name' => 'Barware',
                'is_active' => true,
                'sort_order' => 2,
            ]
        );

        $mainKitchenware = MainCategory::updateOrCreate(
            ['slug' => 'kitchenware'],
            [
                'name' => 'Kitchenware',
                'is_active' => true,
                'sort_order' => 3,
            ]
        );

        // 1. Drinkware (Category linked to Main Category)
        $drinkware = Category::updateOrCreate(
            ['slug' => 'drinkware'],
            [
                'name' => 'Drinkware',
                'description' => 'Drinkware products',
                'parent_id' => null,
                'main_category_id' => $mainDrinkware->id,
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        // 1.1 Double wall Bottles (Sub-category)
        $doubleWallBottles = Category::updateOrCreate(
            ['slug' => 'double-wall-bottles'],
            [
                'name' => 'Double wall Bottles',
                'description' => 'Double wall insulated bottles',
                'parent_id' => $drinkware->id,
                'main_category_id' => $mainDrinkware->id,
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        // Double wall Bottles - Products
        $doubleWallProducts = [
            'Zenith',
            'Oasis',
            'Oasis Pro',
            'Zion',
            'California',
            'Apex',
            'Retro',
            'Froste',
            'Hydro',
        ];

        foreach ($doubleWallProducts as $index => $productName) {
            Category::updateOrCreate(
                ['slug' => Str::slug($productName)],
                [
                    'name' => $productName,
                    'description' => $productName . ' - Double wall bottle',
                    'parent_id' => $doubleWallBottles->id,
                    'main_category_id' => $mainDrinkware->id,
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }

        // 1.2 Single Wall Bottles (Sub-category)
        $singleWallBottles = Category::updateOrCreate(
            ['slug' => 'single-wall-bottles'],
            [
                'name' => 'Single Wall Bottles',
                'description' => 'Single wall bottles',
                'parent_id' => $drinkware->id,
                'main_category_id' => $mainDrinkware->id,
                'sort_order' => 2,
                'is_active' => true,
            ]
        );

        // Single Wall Bottles - Products
        Category::updateOrCreate(
            ['slug' => 'magic'],
            [
                'name' => 'Magic',
                'description' => 'Magic - Single wall bottle',
                'parent_id' => $singleWallBottles->id,
                'main_category_id' => $mainDrinkware->id,
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        // 2. Barware (Category linked to Main Category)
        $barware = Category::updateOrCreate(
            ['slug' => 'barware'],
            [
                'name' => 'Barware',
                'description' => 'Essential barware products',
                'parent_id' => null,
                'main_category_id' => $mainBarware->id,
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        // Barware - Products
        $barwareProducts = [
            'Perch O Holic',
            'Elite Kit',
            'Suitcase Bar Set',
            '3D Printed Cocktail Set',
        ];

        foreach ($barwareProducts as $index => $productName) {
            Category::updateOrCreate(
                ['slug' => Str::slug($productName)],
                [
                    'name' => $productName,
                    'description' => $productName . ' - Barware essential',
                    'parent_id' => $barware->id,
                    'main_category_id' => $mainBarware->id,
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }

        // 3. Kitchenware (Category linked to Main Category)
        $kitchenware = Category::updateOrCreate(
            ['slug' => 'kitchenware'],
            [
                'name' => 'Kitchenware',
                'description' => 'Home and kitchen products',
                'parent_id' => null,
                'main_category_id' => $mainKitchenware->id,
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        // Kitchenware - Products
        $kitchenwareProducts = [
            'Speckle',
            'Plaxa',
            'Graters & Bowls',
            'Cheese Shakers',
            'Measuring Cup & Spoon',
        ];

        foreach ($kitchenwareProducts as $index => $productName) {
            Category::updateOrCreate(
                ['slug' => Str::slug($productName)],
                [
                    'name' => $productName,
                    'description' => $productName . ' - Kitchenware product',
                    'parent_id' => $kitchenware->id,
                    'main_category_id' => $mainKitchenware->id,
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }
    }
}
