<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public function run(): void
    {
        $this->call([
    CustomerSeeder::class,
    CategorySeeder::class,
    SubCategorySeeder::class,
    SpecificationSeeder::class,
    ProductSeeder::class,
    ProductSpecificationSeeder::class,
    CartSeeder::class,
    CartProductSeeder::class,
    OrderSeeder::class,
    ]);
    }
}






