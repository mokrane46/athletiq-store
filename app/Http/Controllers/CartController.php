<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:Product,Product_ID',
            'variant_color' => 'nullable|string',
            'variant_size' => 'nullable|string',
        ]);
        $productId = $request->product_id;
        $color = $request->variant_color;
        $size = $request->variant_size;
        $customer = Auth::user();
        if (!$customer) {
            $cart = session()->get('cart', []);
            $cartKey = $productId . '_' . ($color ?: 'none') . '_' . ($size ?: 'none');
            if (isset($cart[$cartKey])) {
                $cart[$cartKey]['quantity'] += 1;
            } else {
                $cart[$cartKey] = [
                    'product_id' => $productId,
                    'quantity' => 1,
                    'color' => $color,
                    'size' => $size
                ];
            }
            session()->put('cart', $cart);
            return back()->with('success', 'Product added to cart!');
        }
        $cart = $customer->cart ?? Cart::create(['Customer_ID' => $customer->Customer_ID]);
        $existing = $cart->products()
            ->wherePivot('Product_ID', $productId)
            ->wherePivot('color', $color)
            ->wherePivot('size', $size)
            ->first();
        if ($existing) {
            $qty = $existing->pivot->Product_quantity + 1;
            DB::table('Cart_Product')
                ->where('Cart_ID', $cart->Cart_ID)
                ->where('Product_ID', $productId)
                ->where('color', $color)
                ->where('size', $size)
                ->update(['Product_quantity' => $qty]);
        } else {
            $cart->products()->attach($productId, [
                'Product_quantity' => 1,
                'color' => $color,
                'size' => $size
            ]);
        }
        return back()->with('success', 'Product added to cart!');
    }
    public function showCart()
    {
        $customer = Auth::user();
        if (!$customer) {
            $sessionCart = session()->get('cart', []);
            $productIds = collect($sessionCart)->pluck('product_id')->unique()->toArray();
            $productsData = Product::whereIn('Product_ID', $productIds)->get()->keyBy('Product_ID');
            $cartItems = collect();
            foreach ($sessionCart as $key => $item) {
                if (isset($productsData[$item['product_id']])) {
                    $cartItems->push((object)[
                        'cart_key' => $key,
                        'product' => $productsData[$item['product_id']],
                        'quantity' => $item['quantity'],
                        'color' => $item['color'],
                        'size' => $item['size'],
                        'price' => $productsData[$item['product_id']]->Price
                    ]);
                }
            }
            return view('cart_show', compact('cartItems', 'customer'));
        }
        $cart = $customer->cart;
        $products = $cart ? $cart->products()->withPivot('Product_quantity', 'color', 'size')->get() : collect();
        $cartItems = $products->map(function($prod) {
            return (object)[
                'cart_key' => $prod->Product_ID . '_' . ($prod->pivot->color ?: 'none') . '_' . ($prod->pivot->size ?: 'none'),
                'product' => $prod,
                'quantity' => $prod->pivot->Product_quantity,
                'color' => $prod->pivot->color,
                'size' => $prod->pivot->size,
                'price' => $prod->Price
            ];
        });
        return view('cart_show', compact('cartItems', 'customer'));
    }
    public function remove(Request $request, $productId)
    {
        $color = $request->variant_color;
        $size = $request->variant_size;
        $customer = Auth::user();
        if (!$customer) {
            $cart = session()->get('cart', []);
            $cartKey = $productId . '_' . ($color ?: 'none') . '_' . ($size ?: 'none');
            if (isset($cart[$cartKey])) {
                if ($cart[$cartKey]['quantity'] > 1) {
                    $cart[$cartKey]['quantity']--;
                } else {
                    unset($cart[$cartKey]);
                }
                session()->put('cart', $cart);
            }
            return back()->with('success', 'Cart updated!');
        }
        $cart = $customer->cart;
        if ($cart) {
            $existing = $cart->products()
                ->wherePivot('Product_ID', $productId)
                ->wherePivot('color', $color)
                ->wherePivot('size', $size)
                ->first();
            if ($existing) {
                if ($existing->pivot->Product_quantity > 1) {
                    DB::table('Cart_Product')
                        ->where('Cart_ID', $cart->Cart_ID)
                        ->where('Product_ID', $productId)
                        ->where('color', $color)
                        ->where('size', $size)
                        ->update(['Product_quantity' => $existing->pivot->Product_quantity - 1]);
                } else {
                    DB::table('Cart_Product')
                        ->where('Cart_ID', $cart->Cart_ID)
                        ->where('Product_ID', $productId)
                        ->where('color', $color)
                        ->where('size', $size)
                        ->delete();
                }
            }
        }
        return back()->with('success', 'Cart updated!');
    }
}