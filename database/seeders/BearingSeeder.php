<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\MainCategory;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BearingSeeder extends Seeder
{
    public function run(): void
    {
        // Create Main Categories for Bearings
        $mainBearings = MainCategory::updateOrCreate(
            ['slug' => 'bearings'],
            [
                'name' => 'Bearings',
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        // Create Bearing Categories
        $categories = [
            [
                'name' => 'Deep Groove Ball Bearing',
                'slug' => 'deep-groove-ball-bearing',
                'description' => 'Deep groove ball bearings for various applications',
            ],
            [
                'name' => 'Spherical Roller Bearing',
                'slug' => 'spherical-roller-bearing',
                'description' => 'Spherical roller bearings for heavy loads',
            ],
            [
                'name' => 'Cylindrical Roller Bearing',
                'slug' => 'cylindrical-roller-bearing',
                'description' => 'Cylindrical roller bearings for high radial loads',
            ],
            [
                'name' => 'Taper Roller Bearing',
                'slug' => 'taper-roller-bearing',
                'description' => 'Taper roller bearings for combined loads',
            ],
            [
                'name' => 'Pillow Block',
                'slug' => 'pillow-block',
                'description' => 'Pillow block bearing units',
            ],
            [
                'name' => 'Angular Contact Ball Bearing',
                'slug' => 'angular-contact-ball-bearing',
                'description' => 'Angular contact ball bearings for axial loads',
            ],
            [
                'name' => 'Thrust Ball Bearing',
                'slug' => 'thrust-ball-bearing',
                'description' => 'Thrust ball bearings for axial loads',
            ],
            [
                'name' => 'Needle Roller Bearing',
                'slug' => 'needle-roller-bearing',
                'description' => 'Needle roller bearings for compact designs',
            ],
        ];

        $categoryModels = [];
        foreach ($categories as $index => $catData) {
            $categoryModels[$catData['slug']] = Category::updateOrCreate(
                ['slug' => $catData['slug']],
                [
                    'name' => $catData['name'],
                    'description' => $catData['description'],
                    'parent_id' => null,
                    'main_category_id' => $mainBearings->id,
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }

        // Bearing Products Data
        $bearingProducts = [
            // Deep Groove Ball Bearings
            [
                'sku' => '16001',
                'name' => 'Deep Groove Ball Bearing 16001',
                'category' => 'deep-groove-ball-bearing',
                'specifications' => [
                    // edx.html listing row (DABB shop cards)
                    'bore_diameter' => '150 mm',
                    'outside_diameter' => '250 mm',
                    'width' => '56 mm',
                    'dynamic_load_rating' => '5.10 KN',
                    'static_load_rating' => '2.39 KN',
                    'limiting_speed_grease' => '26000 r/min',
                    'limiting_speed_oil' => '30000 r/min',
                    'number_of_rows' => '1',
                    'bore_type' => 'Cylindrical',
                    'cage' => 'Sheet Steel',
                    'radial_clearance' => 'CN',
                    'tolerance_class' => 'P6',
                    'weight' => '0.015 kg',
                    'material' => 'Chrome Steel',
                ],
                'is_featured' => true,
            ],
            [
                'sku' => '6000',
                'name' => 'Deep Groove Ball Bearing 6000',
                'category' => 'deep-groove-ball-bearing',
                'specifications' => [
                    'bore_diameter' => '10 mm',
                    'outside_diameter' => '26 mm',
                    'width' => '8 mm',
                    'dynamic_load_rating' => '4.75 KN',
                    'static_load_rating' => '1.96 KN',
                    'limiting_speed_grease' => '30000 r/min',
                    'limiting_speed_oil' => '36000 r/min',
                    'number_of_rows' => '1',
                    'bore_type' => 'Cylindrical',
                    'cage' => 'Sheet Steel',
                    'radial_clearance' => 'CN',
                    'tolerance_class' => 'P6',
                    'weight' => '0.012 kg',
                    'material' => 'Chrome Steel',
                ],
                'is_featured' => true,
            ],
            [
                'sku' => '6001',
                'name' => 'Deep Groove Ball Bearing 6001',
                'category' => 'deep-groove-ball-bearing',
                'specifications' => [
                    'bore_diameter' => '12 mm',
                    'outside_diameter' => '28 mm',
                    'width' => '8 mm',
                    'dynamic_load_rating' => '5.10 KN',
                    'static_load_rating' => '2.39 KN',
                    'limiting_speed_grease' => '26000 r/min',
                    'limiting_speed_oil' => '32000 r/min',
                    'number_of_rows' => '1',
                    'bore_type' => 'Cylindrical',
                    'cage' => 'Sheet Steel',
                    'radial_clearance' => 'CN',
                    'tolerance_class' => 'P6',
                    'weight' => '0.018 kg',
                    'material' => 'Chrome Steel',
                ],
                'is_featured' => true,
            ],
            [
                'sku' => '6002',
                'name' => 'Deep Groove Ball Bearing 6002',
                'category' => 'deep-groove-ball-bearing',
                'specifications' => [
                    'bore_diameter' => '15 mm',
                    'outside_diameter' => '32 mm',
                    'width' => '9 mm',
                    'dynamic_load_rating' => '5.60 KN',
                    'static_load_rating' => '2.85 KN',
                    'limiting_speed_grease' => '22000 r/min',
                    'limiting_speed_oil' => '28000 r/min',
                    'number_of_rows' => '1',
                    'bore_type' => 'Cylindrical',
                    'cage' => 'Sheet Steel',
                    'radial_clearance' => 'CN',
                    'tolerance_class' => 'P6',
                    'weight' => '0.023 kg',
                    'material' => 'Chrome Steel',
                ],
                'is_featured' => false,
            ],
            [
                'sku' => '6003',
                'name' => 'Deep Groove Ball Bearing 6003',
                'category' => 'deep-groove-ball-bearing',
                'specifications' => [
                    'bore_diameter' => '17 mm',
                    'outside_diameter' => '35 mm',
                    'width' => '10 mm',
                    'dynamic_load_rating' => '6.05 KN',
                    'static_load_rating' => '3.25 KN',
                    'limiting_speed_grease' => '20000 r/min',
                    'limiting_speed_oil' => '26000 r/min',
                    'number_of_rows' => '1',
                    'bore_type' => 'Cylindrical',
                    'cage' => 'Sheet Steel',
                    'radial_clearance' => 'CN',
                    'tolerance_class' => 'P6',
                    'weight' => '0.030 kg',
                    'material' => 'Chrome Steel',
                ],
                'is_featured' => false,
            ],
            [
                'sku' => '6004',
                'name' => 'Deep Groove Ball Bearing 6004',
                'category' => 'deep-groove-ball-bearing',
                'specifications' => [
                    'bore_diameter' => '20 mm',
                    'outside_diameter' => '42 mm',
                    'width' => '12 mm',
                    'dynamic_load_rating' => '9.95 KN',
                    'static_load_rating' => '5.00 KN',
                    'limiting_speed_grease' => '17000 r/min',
                    'limiting_speed_oil' => '22000 r/min',
                    'number_of_rows' => '1',
                    'bore_type' => 'Cylindrical',
                    'cage' => 'Sheet Steel',
                    'radial_clearance' => 'CN',
                    'tolerance_class' => 'P6',
                    'weight' => '0.050 kg',
                    'material' => 'Chrome Steel',
                ],
                'is_featured' => true,
            ],
            [
                'sku' => '6005',
                'name' => 'Deep Groove Ball Bearing 6005',
                'category' => 'deep-groove-ball-bearing',
                'specifications' => [
                    'bore_diameter' => '25 mm',
                    'outside_diameter' => '47 mm',
                    'width' => '12 mm',
                    'dynamic_load_rating' => '11.9 KN',
                    'static_load_rating' => '6.55 KN',
                    'limiting_speed_grease' => '15000 r/min',
                    'limiting_speed_oil' => '19000 r/min',
                    'number_of_rows' => '1',
                    'bore_type' => 'Cylindrical',
                    'cage' => 'Sheet Steel',
                    'radial_clearance' => 'CN',
                    'tolerance_class' => 'P6',
                    'weight' => '0.065 kg',
                    'material' => 'Chrome Steel',
                ],
                'is_featured' => false,
            ],
            [
                'sku' => '6006',
                'name' => 'Deep Groove Ball Bearing 6006',
                'category' => 'deep-groove-ball-bearing',
                'specifications' => [
                    'bore_diameter' => '30 mm',
                    'outside_diameter' => '55 mm',
                    'width' => '13 mm',
                    'dynamic_load_rating' => '13.8 KN',
                    'static_load_rating' => '8.30 KN',
                    'limiting_speed_grease' => '13000 r/min',
                    'limiting_speed_oil' => '17000 r/min',
                    'number_of_rows' => '1',
                    'bore_type' => 'Cylindrical',
                    'cage' => 'Sheet Steel',
                    'radial_clearance' => 'CN',
                    'tolerance_class' => 'P6',
                    'weight' => '0.095 kg',
                    'material' => 'Chrome Steel',
                ],
                'is_featured' => false,
            ],

            // Spherical Roller Bearings
            [
                'sku' => '22205',
                'name' => 'Spherical Roller Bearing 22205',
                'category' => 'spherical-roller-bearing',
                'specifications' => [
                    'bore_diameter' => '25 mm',
                    'outside_diameter' => '52 mm',
                    'width' => '18 mm',
                    'dynamic_load_rating' => '36.5 KN',
                    'static_load_rating' => '31.5 KN',
                    'limiting_speed_grease' => '8500 r/min',
                    'limiting_speed_oil' => '11000 r/min',
                    'number_of_rows' => '2',
                    'bore_type' => 'Cylindrical',
                    'cage' => 'Brass',
                    'radial_clearance' => 'CN',
                    'tolerance_class' => 'P6',
                    'weight' => '0.150 kg',
                    'material' => 'Chrome Steel',
                ],
                'is_featured' => true,
            ],
            [
                'sku' => '22206',
                'name' => 'Spherical Roller Bearing 22206',
                'category' => 'spherical-roller-bearing',
                'specifications' => [
                    'bore_diameter' => '30 mm',
                    'outside_diameter' => '62 mm',
                    'width' => '20 mm',
                    'dynamic_load_rating' => '52.0 KN',
                    'static_load_rating' => '46.5 KN',
                    'limiting_speed_grease' => '7500 r/min',
                    'limiting_speed_oil' => '9500 r/min',
                    'number_of_rows' => '2',
                    'bore_type' => 'Cylindrical',
                    'cage' => 'Brass',
                    'radial_clearance' => 'CN',
                    'tolerance_class' => 'P6',
                    'weight' => '0.230 kg',
                    'material' => 'Chrome Steel',
                ],
                'is_featured' => false,
            ],
            [
                'sku' => '22208',
                'name' => 'Spherical Roller Bearing 22208',
                'category' => 'spherical-roller-bearing',
                'specifications' => [
                    'bore_diameter' => '40 mm',
                    'outside_diameter' => '80 mm',
                    'width' => '23 mm',
                    'dynamic_load_rating' => '80.0 KN',
                    'static_load_rating' => '73.5 KN',
                    'limiting_speed_grease' => '6000 r/min',
                    'limiting_speed_oil' => '7500 r/min',
                    'number_of_rows' => '2',
                    'bore_type' => 'Cylindrical',
                    'cage' => 'Brass',
                    'radial_clearance' => 'CN',
                    'tolerance_class' => 'P6',
                    'weight' => '0.450 kg',
                    'material' => 'Chrome Steel',
                ],
                'is_featured' => true,
            ],

            // Cylindrical Roller Bearings
            [
                'sku' => 'NU205',
                'name' => 'Cylindrical Roller Bearing NU205',
                'category' => 'cylindrical-roller-bearing',
                'specifications' => [
                    'bore_diameter' => '25 mm',
                    'outside_diameter' => '52 mm',
                    'width' => '15 mm',
                    'dynamic_load_rating' => '28.0 KN',
                    'static_load_rating' => '24.0 KN',
                    'limiting_speed_grease' => '12000 r/min',
                    'limiting_speed_oil' => '15000 r/min',
                    'number_of_rows' => '1',
                    'bore_type' => 'Cylindrical',
                    'cage' => 'Brass',
                    'radial_clearance' => 'CN',
                    'tolerance_class' => 'P6',
                    'weight' => '0.120 kg',
                    'material' => 'Chrome Steel',
                ],
                'is_featured' => true,
            ],
            [
                'sku' => 'NU206',
                'name' => 'Cylindrical Roller Bearing NU206',
                'category' => 'cylindrical-roller-bearing',
                'specifications' => [
                    'bore_diameter' => '30 mm',
                    'outside_diameter' => '62 mm',
                    'width' => '16 mm',
                    'dynamic_load_rating' => '35.5 KN',
                    'static_load_rating' => '31.0 KN',
                    'limiting_speed_grease' => '10000 r/min',
                    'limiting_speed_oil' => '13000 r/min',
                    'number_of_rows' => '1',
                    'bore_type' => 'Cylindrical',
                    'cage' => 'Brass',
                    'radial_clearance' => 'CN',
                    'tolerance_class' => 'P6',
                    'weight' => '0.180 kg',
                    'material' => 'Chrome Steel',
                ],
                'is_featured' => false,
            ],

            // Taper Roller Bearings
            [
                'sku' => '30205',
                'name' => 'Taper Roller Bearing 30205',
                'category' => 'taper-roller-bearing',
                'specifications' => [
                    'bore_diameter' => '25 mm',
                    'outside_diameter' => '52 mm',
                    'width' => '16.25 mm',
                    'dynamic_load_rating' => '29.0 KN',
                    'static_load_rating' => '31.5 KN',
                    'limiting_speed_grease' => '8000 r/min',
                    'limiting_speed_oil' => '10000 r/min',
                    'number_of_rows' => '1',
                    'bore_type' => 'Cylindrical',
                    'cage' => 'Sheet Steel',
                    'radial_clearance' => 'N/A',
                    'tolerance_class' => 'P5',
                    'weight' => '0.140 kg',
                    'material' => 'Chrome Steel',
                ],
                'is_featured' => true,
            ],
            [
                'sku' => '30206',
                'name' => 'Taper Roller Bearing 30206',
                'category' => 'taper-roller-bearing',
                'specifications' => [
                    'bore_diameter' => '30 mm',
                    'outside_diameter' => '62 mm',
                    'width' => '17.25 mm',
                    'dynamic_load_rating' => '40.0 KN',
                    'static_load_rating' => '44.0 KN',
                    'limiting_speed_grease' => '7000 r/min',
                    'limiting_speed_oil' => '9000 r/min',
                    'number_of_rows' => '1',
                    'bore_type' => 'Cylindrical',
                    'cage' => 'Sheet Steel',
                    'radial_clearance' => 'N/A',
                    'tolerance_class' => 'P5',
                    'weight' => '0.200 kg',
                    'material' => 'Chrome Steel',
                ],
                'is_featured' => false,
            ],

            // Pillow Blocks
            [
                'sku' => 'UCP205',
                'name' => 'Pillow Block UCP205',
                'category' => 'pillow-block',
                'specifications' => [
                    'bore_diameter' => '25 mm',
                    'outside_diameter' => '52 mm',
                    'width' => '34 mm',
                    'dynamic_load_rating' => '14.0 KN',
                    'static_load_rating' => '7.85 KN',
                    'limiting_speed_grease' => '6300 r/min',
                    'limiting_speed_oil' => '8000 r/min',
                    'number_of_rows' => '1',
                    'bore_type' => 'Cylindrical',
                    'cage' => 'Sheet Steel',
                    'radial_clearance' => 'CN',
                    'tolerance_class' => 'P0',
                    'weight' => '0.650 kg',
                    'material' => 'Cast Iron Housing',
                ],
                'is_featured' => true,
            ],
            [
                'sku' => 'UCP206',
                'name' => 'Pillow Block UCP206',
                'category' => 'pillow-block',
                'specifications' => [
                    'bore_diameter' => '30 mm',
                    'outside_diameter' => '62 mm',
                    'width' => '38 mm',
                    'dynamic_load_rating' => '19.5 KN',
                    'static_load_rating' => '11.2 KN',
                    'limiting_speed_grease' => '5300 r/min',
                    'limiting_speed_oil' => '6700 r/min',
                    'number_of_rows' => '1',
                    'bore_type' => 'Cylindrical',
                    'cage' => 'Sheet Steel',
                    'radial_clearance' => 'CN',
                    'tolerance_class' => 'P0',
                    'weight' => '0.950 kg',
                    'material' => 'Cast Iron Housing',
                ],
                'is_featured' => false,
            ],

            // Angular Contact Ball Bearings
            [
                'sku' => '7205B',
                'name' => 'Angular Contact Ball Bearing 7205B',
                'category' => 'angular-contact-ball-bearing',
                'specifications' => [
                    'bore_diameter' => '25 mm',
                    'outside_diameter' => '52 mm',
                    'width' => '15 mm',
                    'dynamic_load_rating' => '14.8 KN',
                    'static_load_rating' => '9.30 KN',
                    'limiting_speed_grease' => '14000 r/min',
                    'limiting_speed_oil' => '18000 r/min',
                    'number_of_rows' => '1',
                    'bore_type' => 'Cylindrical',
                    'cage' => 'Polyamide',
                    'radial_clearance' => 'CN',
                    'tolerance_class' => 'P5',
                    'weight' => '0.095 kg',
                    'material' => 'Chrome Steel',
                ],
                'is_featured' => true,
            ],

            // Thrust Ball Bearings
            [
                'sku' => '51105',
                'name' => 'Thrust Ball Bearing 51105',
                'category' => 'thrust-ball-bearing',
                'specifications' => [
                    'bore_diameter' => '25 mm',
                    'outside_diameter' => '42 mm',
                    'width' => '11 mm',
                    'dynamic_load_rating' => '15.9 KN',
                    'static_load_rating' => '40.0 KN',
                    'limiting_speed_grease' => '4300 r/min',
                    'limiting_speed_oil' => '5300 r/min',
                    'number_of_rows' => '1',
                    'bore_type' => 'Cylindrical',
                    'cage' => 'Brass',
                    'radial_clearance' => 'N/A',
                    'tolerance_class' => 'P6',
                    'weight' => '0.055 kg',
                    'material' => 'Chrome Steel',
                ],
                'is_featured' => false,
            ],

            // Needle Roller Bearings
            [
                'sku' => 'HK2020',
                'name' => 'Needle Roller Bearing HK2020',
                'category' => 'needle-roller-bearing',
                'specifications' => [
                    'bore_diameter' => '20 mm',
                    'outside_diameter' => '26 mm',
                    'width' => '20 mm',
                    'dynamic_load_rating' => '12.7 KN',
                    'static_load_rating' => '17.6 KN',
                    'limiting_speed_grease' => '10000 r/min',
                    'limiting_speed_oil' => '13000 r/min',
                    'number_of_rows' => '1',
                    'bore_type' => 'Cylindrical',
                    'cage' => 'Sheet Steel',
                    'radial_clearance' => 'CN',
                    'tolerance_class' => 'P6',
                    'weight' => '0.018 kg',
                    'material' => 'Chrome Steel',
                ],
                'is_featured' => false,
            ],
        ];

        $bearingImage = 'assets/images/PhotoshopExtension_Image-1.webp';

        foreach ($bearingProducts as $index => $productData) {
            $category = $categoryModels[$productData['category']] ?? null;

            $slug = Str::slug($productData['sku'].'-'.$productData['category']);

            Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $productData['name'],
                    'sku' => $productData['sku'],
                    'description' => 'High-quality '.$productData['name'].' from EDX Rulmenti Romania. Precision engineered for optimal performance and durability.',
                    'short_description' => $productData['name'].' - Premium quality bearing',
                    'category_id' => $category ? $category->id : null,
                    'price' => 0,
                    'sale_price' => null,
                    'stock_quantity' => 100,
                    'in_stock' => true,
                    'is_active' => true,
                    'is_featured' => $productData['is_featured'] ?? false,
                    'is_new_arrival' => false,
                    'specifications' => $productData['specifications'],
                    'sort_order' => $index + 1,
                    'image' => $bearingImage,
                    'images' => [$bearingImage],
                ]
            );
        }

        $deactivated = Product::query()
            ->where(function ($q) use ($mainBearings) {
                $q->whereNull('category_id')
                    ->orWhereDoesntHave('category', function ($cq) use ($mainBearings) {
                        $cq->where('main_category_id', $mainBearings->id);
                    });
            })
            ->update(['is_active' => false]);

        $this->command->info('Bearing categories and products seeded successfully! (HTML bearing image on all rows; '.$deactivated.' non-bearing products set inactive.)');
    }
}
