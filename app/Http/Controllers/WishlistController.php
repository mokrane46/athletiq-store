<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
class WishlistController extends Controller
{
    public function index()
    {
        $wishlistIds = session()->get('wishlist_' . Auth::id(), []);
        $products = collect();
        if(!empty($wishlistIds)) {
            $products = Product::whereIn('Product_ID', $wishlistIds)->get();
        }
        $cartCount = Auth::check() ? Auth::user()->cartItemCount() : 0;
        return view('wishlist', compact('products', 'cartCount'));
    }
    public function add(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Please login to add to wishlist.', 'redirect' => route('login')], 401);
        }
        $productId = $request->product_id;
        $sessionKey = 'wishlist_' . Auth::id();
        $wishlistIds = session()->get($sessionKey, []);
        if (!in_array($productId, $wishlistIds)) {
            $wishlistIds[] = $productId;
            session()->put($sessionKey, $wishlistIds);
            return response()->json(['success' => true, 'message' => 'Added to wishlist!']);
        }
        return response()->json(['success' => true, 'message' => 'Already in wishlist!']);
    }
    public function remove(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $sessionKey = 'wishlist_' . Auth::id();
        $wishlistIds = session()->get($sessionKey, []);
        $wishlistIds = array_diff($wishlistIds, [$id]);
        session()->put($sessionKey, $wishlistIds);
        return redirect()->back()->with('success', 'Removed from wishlist.');
    }
}
