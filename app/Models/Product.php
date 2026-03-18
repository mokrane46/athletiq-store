<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Product extends Model
{
    use HasFactory;
    protected $table = 'Product';
    protected $primaryKey = 'Product_ID';
    protected $fillable = ['Product_name', 'Product_image', 'Price', 'Quantity', 'SubCategory_ID'];
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'SubCategory_ID');
    }
    public function specifications()
{
    return $this->belongsToMany(Specification::class, 'product_specifications', 'Product_ID', 'Spec_ID')
                ->withPivot('Spec_value');
}
    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'Cart_Product', 'Product_ID', 'Cart_ID')->withPivot('Product_quantity', 'color', 'size');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'Category_ID', 'Category_ID');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'Product_ID', 'Product_ID')->orderBy('created_at', 'desc');
    }
}
