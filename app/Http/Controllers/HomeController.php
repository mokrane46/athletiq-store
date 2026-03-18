<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $featuredProducts = Product::take(6)->get();
        $cartCount = Auth::check() ? Auth::user()->cartItemCount() : 0;
        return view('home', compact('featuredProducts','categories','cartCount'));
    }
}
?>