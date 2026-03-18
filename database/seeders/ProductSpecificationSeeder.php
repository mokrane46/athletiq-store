<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductSpecification;

class ProductSpecificationSeeder extends Seeder
{
    public function run(): void
    {
        $productSpecs = [
            // Clothes: Men’s Gym Tank Top
            ['Product_ID' => 1, 'Spec_ID' => 2, 'Spec_value' => 'Black'],  // Color
            ['Product_ID' => 1, 'Spec_ID' => 3, 'Spec_value' => 'M'],      // Size
            ['Product_ID' => 1, 'Spec_ID' => 4, 'Spec_value' => 'Nike'],   // Brand

            // Clothes: Women’s Compression Leggings
            ['Product_ID' => 2, 'Spec_ID' => 2, 'Spec_value' => 'Blue'],
            ['Product_ID' => 2, 'Spec_ID' => 3, 'Spec_value' => 'L'],
            ['Product_ID' => 2, 'Spec_ID' => 4, 'Spec_value' => 'Adidas'],

            // Equipment: Adjustable Dumbbell Set
            ['Product_ID' => 3, 'Spec_ID' => 1, 'Spec_value' => '20 kg'],       // Weight
            ['Product_ID' => 3, 'Spec_ID' => 4, 'Spec_value' => 'Bowflex'],    // Brand
            ['Product_ID' => 3, 'Spec_ID' => 5, 'Spec_value' => 'Adjustable weight plates'],  

            // Equipment: Yoga Mat
         
            ['Product_ID' => 4, 'Spec_ID' => 4, 'Spec_value' => 'Liforme'],    
            ['Product_ID' => 4, 'Spec_ID' => 5, 'Spec_value' => 'Non-slip texture'],

            // Supplements: Whey Protein Powder
            ['Product_ID' => 5, 'Spec_ID' => 1, 'Spec_value' => '2 kg'],      
            ['Product_ID' => 5, 'Spec_ID' => 4, 'Spec_value' => 'Optimum Nutrition'],  
            ['Product_ID' => 5, 'Spec_ID' => 5, 'Spec_value' => 'Vanilla flavor'],  

            // Supplements: Pre-Workout Formula
            ['Product_ID' => 6, 'Spec_ID' => 1, 'Spec_value' => '0.3 kg'],    
            ['Product_ID' => 6, 'Spec_ID' => 4, 'Spec_value' => 'BSN'],       
            ['Product_ID' => 6, 'Spec_ID' => 5, 'Spec_value' => 'Citrus flavor'],  
        ];

        foreach ($productSpecs as $spec) {
            ProductSpecification::create($spec);
        }
    }
}
