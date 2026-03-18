<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'Product_name' => 'Men’s Gym Tank Top',
            'Product_image' => 'tanktop.jpg',
            'Price' => 19.99,
            'Quantity' => 100,
            'SubCategory_ID' => 1, // e.g., "Clothing"
        ]);

        Product::create([
            'Product_name' => 'Women’s Compression Leggings',
            'Product_image' => 'leggings.jpg',
            'Price' => 29.99,
            'Quantity' => 80,
            'SubCategory_ID' => 4, // e.g., "Clothing"
        ]);

        Product::create([
            'Product_name' => 'Adjustable Dumbbell Set (20kg)',
            'Product_image' => 'dumbbells.jpg',
            'Price' => 149.99,
            'Quantity' => 20,
            'SubCategory_ID' => 5, // e.g., "Equipment"
        ]);

        Product::create([
            'Product_name' => 'Yoga Mat (Non-Slip)',
            'Product_image' => 'yogamat.jpg',
            'Price' => 24.99,
            'Quantity' => 60,
            'SubCategory_ID' => 7, // e.g., "Equipment"
        ]);

        Product::create([
            'Product_name' => 'Whey Protein Powder (2kg)',
            'Product_image' => 'proteinpowder.jpg',
            'Price' => 59.99,
            'Quantity' => 40,
            'SubCategory_ID' => 10, // e.g., "Supplements"
        ]);

        Product::create([
            'Product_name' => 'Pre-Workout Formula (300g)',
            'Product_image' => 'preworkout.jpg',
            'Price' => 39.99,
            'Quantity' => 50,
            'SubCategory_ID' => 11, // e.g., "Supplements"
        ]);
    }
}
