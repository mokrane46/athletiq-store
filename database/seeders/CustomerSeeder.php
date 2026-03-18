<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        // Example customers
        $customers = [
            ['Email' => 'john@example.com',  'Password' => Hash::make('password123')],
            ['Email' => 'jane@example.com',  'Password' => Hash::make('secret456')],
            ['Email' => 'alice@example.com', 'Password' => Hash::make('alice789')],
            ['Email' => 'bob@example.com',   'Password' => Hash::make('bob321')],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
