<?php

namespace Database\Seeders;

use App\Models\MasterColor;
use App\Models\MasterSize;
use Illuminate\Database\Seeder;

class ColorSizeSeeder extends Seeder
{
    public function run(): void
    {
        $colors = [
            'Red', 'Blue', 'Green', 'Yellow', 'Black', 'White', 'Grey', 'Brown', 'Pink', 'Orange',
            'Purple', 'Navy', 'Maroon', 'Charcoal', 'Light Blue', 'Beige', 'Cream', 'Coral', 'Teal',
            'Indigo', 'Olive', 'Burgundy', 'Silver', 'Gold', 'Peach', 'Sky Blue', 'Mint', 'Lavender',
        ];
        foreach ($colors as $i => $name) {
            MasterColor::firstOrCreate(
                ['name' => $name],
                ['sort_order' => $i + 1]
            );
        }

        $sizes = [
            'Free Size', 'XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL',
            '28', '30', '32', '34', '36', '38', '40', '42',
            '32GB', '64GB', '128GB', '256GB', '512GB', '1TB',
            'Standard', 'Premium', 'Pro', 'Max', '500ml', '1L',
        ];
        foreach ($sizes as $i => $name) {
            MasterSize::firstOrCreate(
                ['name' => $name],
                ['sort_order' => $i + 1]
            );
        }
    }
}
