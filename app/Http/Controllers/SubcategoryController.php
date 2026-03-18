<?php
namespace App\Http\Controllers; 
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
class SubcategoryController extends Controller
{
    public function show($id)
    {
        $category = Category::with('products')->findOrFail($id);
        $groupedProducts = $category->products->groupBy('Subcategory_name'); 
        return view('category_show', compact('category', 'groupedProducts'));
    }
    public function index($categoryId)
    {
        $category = Category::with('subcategories')->findOrFail($categoryId);
        return view('admin.subcategories.index', compact('category'));
    }
    public function store(Request $request, $categoryId)
    {
        $request->validate([
            'SubCategory_name' => 'required|string|max:255|unique:Subcategory,SubCategory_name',
        ]);
        $category = Category::findOrFail($categoryId);
        $category->subcategories()->create([
            'SubCategory_name' => $request->SubCategory_name,
        ]);
        return redirect()->route('categories.subcategories.index', $categoryId)
                         ->with('success', 'Subcategory added successfully!');
    }
    public function destroy($categoryId, $subcategoryId)
    {
        $subcategory = Subcategory::where('category_id', $categoryId)
                                  ->where('id', $subcategoryId)
                                  ->firstOrFail();
        $subcategory->delete();
        return redirect()->route('admin.subcategories.index', $categoryId)
                         ->with('success', 'Subcategory deleted successfully!');
    }
}