<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('subcategories')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }
    public function create()
    {
        return view('admin.categories.create');
    }
    public function store(Request $request)
    {
        $request->validate(['Category_name' => 'required|string|max:255']);
        Category::create($request->only('Category_name'));
        return redirect()->route('admin.categories.index')->with('success', 'Category added.');
    }
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }
    public function update(Request $request, Category $category)
    {
        $request->validate(['Category_name' => 'required|string|max:255']);
        $category->update($request->only('Category_name'));
        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    }
    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }
}
