<?php
namespace App\Http\Controllers\Admin;
use App\Models\ProductSpecification;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Specification;
use Illuminate\Http\Request;
class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('subcategory.category')->paginate(10);
        return view('admin.products.index', compact('products'));
    }
    public function show($id)
{
    $product = Product::with('specifications.specification')->findOrFail($id);
    return view('show', compact('product'));
}
    public function create()
    {
        $subcategories = Subcategory::with('category')->get();
        $specifications = Specification::all();
        return view('admin.products.create', compact('subcategories', 'specifications'));
    }
   public function store(Request $request)
    {
        $validated = $request->validate([
            'Product_name' => 'required|string|max:255',
            'Price' => 'required|numeric|min:0',
            'Quantity' => 'required|integer|min:1',
            'SubCategory_ID' => 'required|exists:Subcategory,SubCategory_ID',
            'Product_image' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('Product_image')) {
            $file = $request->file('Product_image');
            $filename = $file->getClientOriginalName();
            $path = $file->storeAs('products', $filename, 'public'); 
            $validated['Product_image'] = $filename;
        }
        $product = Product::create($validated);
        if ($request->has('specifications')) {
            foreach ($request->specifications as $specName => $specValue) {
                $spec = Specification::where('Spec_name', $specName)->first();
                if ($spec) {
                    ProductSpecification::create([
                        'Product_ID' => $product->Product_ID, 
                        'Spec_ID' => $spec->Spec_ID,
                        'Spec_value' => $specValue
                    ]);
                }
            }
        }
        return redirect()->route('admin.products.index')
                         ->with('success', 'Product added successfully!');
    }
    public function edit(Product $product)
    {
        $subcategories = Subcategory::with('category')->get();
        $specifications = Specification::all();
        $product->load('specifications');
        return view('admin.products.edit', compact('product', 'subcategories', 'specifications'));
    }
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'Product_name' => 'required|string|max:255',
            'Price' => 'required|numeric|min:0',
            'Quantity' => 'required|integer|min:0',
            'SubCategory_ID' => 'required|exists:Subcategory,SubCategory_ID',
            'Product_image' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('Product_image')) {
            $file = $request->file('Product_image');
            $filename = $file->getClientOriginalName();
            $file->storeAs('products', $filename, 'public');
            $validated['Product_image'] = $filename;
        }
        $product->update($validated);
        if ($request->has('specifications')) {
            ProductSpecification::where('Product_ID', $product->Product_ID)->delete();
            foreach ($request->specifications as $specName => $specValue) {
                $spec = Specification::where('Spec_name', $specName)->first();
                if ($spec && $specValue !== null) {
                    ProductSpecification::create([
                        'Product_ID' => $product->Product_ID,
                        'Spec_ID' => $spec->Spec_ID,
                        'Spec_value' => $specValue
                    ]);
                }
            }
        }
        return redirect()->route('admin.products.index')
                         ->with('success', 'Product updated successfully!');
    }
    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Product deleted.');
    }
    public function destroyAll()
    {
        Product::truncate();
        return back()->with('success', 'All products removed.');
    }
}
