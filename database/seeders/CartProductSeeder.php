<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Product;

class CartProductSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure tables are populated
        $carts = Cart::all();
        $products = Product::all();
        if ($carts->isEmpty() || $products->isEmpty()) {
            $this->command->info('No carts or products found. Run CartSeeder and ProductSeeder first.');
            return;
        }
        // Example seeding: assign a few products to each cart
        foreach ($carts as $cart) {
            // Pick 2–4 random products per cart
            $cartProducts = $products->random(rand(2, 4));

            foreach ($cartProducts as $product) {
                DB::table('Cart_Product')->insert([
                    'Cart_ID' => $cart->Cart_ID,
                    'Product_ID' => $product->Product_ID,
                    'Product_quantity' => rand(1, 5), // random quantity 1–5
                ]);
            }
        }
    }
}
