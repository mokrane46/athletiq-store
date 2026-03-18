<?php 
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Orders;
class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'products_count' => Product::count(),
            'categories_count' => Category::count(),
            'orders_count' => Orders::count(),
        ];
        return view('admin.dashboard', compact('stats'));
    }
}
