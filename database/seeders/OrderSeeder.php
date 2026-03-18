<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Orders;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing orders for clean re-seeding
        Orders::truncate();

        // Get all carts
        $carts = Cart::all();

        if ($carts->isEmpty()) {
            $this->command->info('No carts found. Please run CartSeeder first.');
            return;
        }

        foreach ($carts as $cart) {
            Orders::create([
                'Order_date'       => Carbon::now()->subDays(rand(0, 10)), // random date within last 10 days
                'Delivery_address' => fake()->address(),
                'Order_status'     => collect(['Pending', 'Processing', 'Delivered', 'Cancelled'])->random(),
                'Cart_ID'          => $cart->Cart_ID,
            ]);
        }
    }
}
