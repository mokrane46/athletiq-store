<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CartSeeder extends Seeder
{
    public function run(): void
    {
      
        // Get some customers and products (assuming they already exist)
        $customers = Customer::all();
        $products = Product::all();

        if ($customers->isEmpty() || $products->isEmpty()) {
            $this->command->info("No customers or products found. Make sure CustomerSeeder and ProductSeeder run first.");
            return;
        }

        // Example: create 3 carts
        foreach ($customers->take(3) as $index => $customer) {
            $cart = Cart::create([
                'Customer_ID' => $customer->Customer_ID,
            ]);
        }
    }
}
