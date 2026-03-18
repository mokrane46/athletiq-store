<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
class FrontendProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('all_products', compact('products'));
    }
    public function show($id)
    {
        $product = Product::with(['specifications', 'reviews.customer', 'subcategory.category'])->findOrFail($id);
        $relatedProducts = Product::where('SubCategory_ID', $product->SubCategory_ID)
            ->where('Product_ID', '!=', $product->Product_ID)
            ->take(8)
            ->get();
        return view('show', compact('product', 'relatedProducts'));
    }
    public function search(Request $request)
    {
        $originalQuery = trim($request->input('query'));
        if (!$originalQuery) {
            return redirect()->route('products.index');
        }
        $lowerQuery = strtolower($originalQuery);
        $exactMatch = Product::where('Product_name', 'LIKE', $originalQuery)->first();
        if ($exactMatch) {
            return redirect()->route('product.show', $exactMatch->Product_ID);
        }
        $isWomen = (preg_match('/\bwomen\b|\bwoman\b/i', $originalQuery));
        $isMen = (preg_match('/\bmen\b|\bman\b/i', $originalQuery)) && !$isWomen;
        $cleanQuery = trim(preg_replace('/\bwomen\b|\bwoman\b|\bmen\b|\bman\b/i', '', $originalQuery));
        $searchName = $cleanQuery ?: $originalQuery;
        $productsQuery = Product::query();
        if ($cleanQuery !== "") {
            $productsQuery->where('Product_name', 'LIKE', "%{$cleanQuery}%");
        }
        if ($isWomen) {
            $productsQuery->whereHas('subcategory', function($q) {
                $q->where('SubCategory_name', 'LIKE', '%women%')
                  ->orWhere('SubCategory_name', 'LIKE', '%woman%');
            });
        } elseif ($isMen) {
            $productsQuery->whereHas('subcategory', function($q) {
                $q->where(function($sq) {
                    $sq->where('SubCategory_name', 'LIKE', '%men%')
                       ->orWhere('SubCategory_name', 'LIKE', '%man%');
                })->where(function($sq) {
                    $sq->where('SubCategory_name', 'NOT LIKE', '%women%')
                       ->where('SubCategory_name', 'NOT LIKE', '%woman%');
                });
            });
        } 
        elseif ($cleanQuery === "") {
            $productsQuery->where('Product_name', 'LIKE', "%{$originalQuery}%");
        }
        $products = $productsQuery->get();
        $isSearch = true;
        $query = $originalQuery;
        return view('all_products', compact('products', 'query', 'isSearch'));
    }
}