<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
class OrderController extends Controller
{
    public function checkout()
    {
        $user = Auth::user();
        if ($user) {
            $cart = Cart::where('Customer_ID', $user->Customer_ID)->first();
            if (!$cart || $cart->products->isEmpty()) {
                return redirect()->route('cart.show')->with('error', 'Your cart is empty');
            }
            $products = $cart->products;
        } else {
            $sessionCart = session()->get('cart', []);
            if (empty($sessionCart)) {
                return redirect()->route('cart.show')->with('error', 'Your cart is empty');
            }
            $products = \App\Models\Product::whereIn('Product_ID', array_keys($sessionCart))->get();
            foreach ($products as $product) {
                $product->setRelation('pivot', (object)['Product_quantity' => $sessionCart[$product->Product_ID]]);
            }
            $cart = (object)['products' => $products];
        }
        $subtotal = $products->sum(function($product) {
            return $product->Price * ($product->pivot->Product_quantity ?? 1);
        });
        return view('checkout', compact('cart', 'subtotal'));
    }
    public function placeOrder(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'address_line_1' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postcode' => 'required|string|max:20',
            'country' => 'required|string|max:50',
        ]);
        $delivery_address = $request->address_line_1 . ', ' . $request->city . ', ' . $request->postcode . ', ' . $request->country;
        $user = Auth::user();
        if ($user) {
            $cart = Cart::where('Customer_ID', $user->Customer_ID)->first();
            if (!$cart || $cart->products->isEmpty()) {
                return back()->with('error', 'Your cart is empty');
            }
            $products = $cart->products;
        } else {
            $sessionCart = session()->get('cart', []);
            if (empty($sessionCart)) {
                return back()->with('error', 'Your cart is empty');
            }
            $products = \App\Models\Product::whereIn('Product_ID', array_keys($sessionCart))->get();
            $cart = Cart::create(['Customer_ID' => null]);
            foreach ($sessionCart as $productId => $quantity) {
                $cart->products()->attach($productId, ['Product_quantity' => $quantity]);
            }
            $products = $cart->products;
        }
        $order = Orders::create([
            'Order_date' => now(),
            'Delivery_address' => $delivery_address,
            'Order_status' => 'pending',
            'Cart_ID' => $cart->Cart_ID,
        ]);
        foreach ($products as $product) {
            $quantity = $product->pivot->Product_quantity ?? 1;
            $product->decrement('Quantity', $quantity);
        }
        if ($user) {
            $cart->products()->detach();
        } else {
            session()->forget('cart');
        }
        return view('order_success')->with('message', 'Order placed successfully!');
    }
}
