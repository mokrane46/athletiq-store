<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subcategory;

class SubCategorySeeder extends Seeder
{
    public function run(): void
    {
        $subcategories = [
            // Category 1: Clothes
            ['SubCategory_ID' => 1,  'SubCategory_name' => 'Men’s Gym Tops',          'Category_ID' => 1],
            ['SubCategory_ID' => 2,  'SubCategory_name' => 'Women’s Gym Tops',        'Category_ID' => 1],
            ['SubCategory_ID' => 3,  'SubCategory_name' => 'Men’s Bottoms',           'Category_ID' => 1],
            ['SubCategory_ID' => 4,  'SubCategory_name' => 'Women’s Bottoms',         'Category_ID' => 1],

            // Category 2: Equipment
            ['SubCategory_ID' => 5,  'SubCategory_name' => 'Dumbbells & Weights',     'Category_ID' => 2],
            ['SubCategory_ID' => 6,  'SubCategory_name' => 'Resistance Bands',        'Category_ID' => 2],
            ['SubCategory_ID' => 7,  'SubCategory_name' => 'Yoga & Pilates Gear',     'Category_ID' => 2],
            ['SubCategory_ID' => 8,  'SubCategory_name' => 'Cardio Machines',         'Category_ID' => 2],
            ['SubCategory_ID' => 9,  'SubCategory_name' => 'Strength Training Gear',  'Category_ID' => 2],

            // Category 3: Supplements
            ['SubCategory_ID' => 10, 'SubCategory_name' => 'Protein Powders',         'Category_ID' => 3],
            ['SubCategory_ID' => 11, 'SubCategory_name' => 'Pre-Workout',             'Category_ID' => 3],
            ['SubCategory_ID' => 12, 'SubCategory_name' => 'Post-Workout Recovery',   'Category_ID' => 3],
            ['SubCategory_ID' => 13, 'SubCategory_name' => 'Vitamins & Health',       'Category_ID' => 3],
        ];

        foreach ($subcategories as $subcategory) {
            Subcategory::create($subcategory);
        }
    }
}
