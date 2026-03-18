<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Subcategory;
use App\Models\Product;
class CategoryController extends Controller
{
    public function showSubcategories($id)
{
    $category = \App\Models\Category::with('subcategories')->findOrFail($id);
    return view('subcategories', [
        'category' => $category,
        'subcategories' => $category->subcategories,
    ]);
}
public function show($id)
    {
        $category = \App\Models\Category::with('products')->findOrFail($id);
        $groupedProducts = $category->products->groupBy('Subcategory_name');
        return view('collection_show', compact('category', 'groupedProducts'));
    }
    public function showProducts($id)
    {
        $subcategory = Subcategory::with('category', 'products')->findOrFail($id);
        return view('subcategory-product', [
            'subcategory' => $subcategory,
            'products' => $subcategory->products,
        ]);
    }
public function searchProducts(Request $request, $id)
{
    $subcategory = Subcategory::with('category')->findOrFail($id);
    $products = Product::where('SubCategory_ID', $id);
    if ($subcategory->category->Category_name == 'Clothes') {
        if ($request->filled('Size')) {
            $products->whereHas('specifications', function ($q) use ($request) {
                $q->where('Spec_name', 'Size')
                  ->where('product_specifications.Spec_value', $request->Size);
            });
        }
        if ($request->filled('Color')) {
            $products->whereHas('specifications', function ($q) use ($request) {
                $q->where('Spec_name', 'Color')
                  ->where('product_specifications.Spec_value', $request->Color);
            });
        }
        if ($request->filled('Brand')) {
            $products->whereHas('specifications', function ($q) use ($request) {
                $q->where('Spec_name', 'Brand')
                  ->where('product_specifications.Spec_value', 'like', '%' . $request->Brand . '%');
            });
        }
    }
    if ($subcategory->SubCategory_ID == 5 && $request->filled('Weight')) {
        $products->whereHas('specifications', function ($q) use ($request) {
    $weight = strtolower(str_replace(' ', '', $request->Weight));
    $q->where('Spec_name', 'Weight')
      ->whereRaw("REPLACE(LOWER(product_specifications.Spec_value), ' ', '') LIKE ?", ["%{$weight}%"]);
});
    }
    $products = $products->get();
    return view('subcategory-product', [
        'subcategory' => $subcategory,
        'products' => $products,
    ]);
}
    public function showByGender($gender) {
        $title = ucfirst($gender) . "'s Collection";
        $query = \App\Models\Subcategory::query();
        if (strtolower($gender) === 'women') {
            $query->where(function($q) {
                $q->where('SubCategory_name', 'like', '%women%')
                  ->orWhere('SubCategory_name', 'like', '%woman%');
            });
        } else if (strtolower($gender) === 'men') {
            $query->where(function($q) {
                $q->where('SubCategory_name', 'like', '%men%')
                  ->orWhere('SubCategory_name', 'like', '%man%');
            })->where(function($q) {
                $q->where('SubCategory_name', 'not like', '%women%')
                  ->where('SubCategory_name', 'not like', '%woman%');
            });
        }
        $subcategories = $query->get();
        $category = new \App\Models\Category();
        $category->Category_name = $title;
        $category->setRelation('subcategories', $subcategories);
        return view('subcategories', [
            'category' => $category,
            'subcategories' => $subcategories,
        ]);
    }
}
