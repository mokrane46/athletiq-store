<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Subcategory;

class CategorySeeder extends Seeder
{
    public function run(): void
    {

        $categories = [
            ['Category_name' => 'Clothes'],
            ['Category_name' => 'Equipment'],
            ['Category_name' => 'Supplements'],
        ];
        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
