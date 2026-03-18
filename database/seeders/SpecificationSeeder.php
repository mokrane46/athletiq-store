<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Specification;

class SpecificationSeeder extends Seeder
{
    public function run(): void
    {
        $specifications = [
            ['Spec_ID' => 1, 'Spec_name' => 'Weight'],
            ['Spec_ID' => 2, 'Spec_name' => 'Color'],
            ['Spec_ID' => 3, 'Spec_name' => 'Size'],
            ['Spec_ID' => 4, 'Spec_name' => 'Brand'],
            ['Spec_ID' => 5, 'Spec_name' => 'Others'],
        ];

        foreach ($specifications as $spec) {
            Specification::create($spec);
        }
    }
}
