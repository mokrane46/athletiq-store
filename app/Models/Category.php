<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Category extends Model
{
    use HasFactory;
    protected $table = 'Category';
    protected $primaryKey = 'Category_ID';
    protected $fillable = ['Category_name'];
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class, 'Category_ID');
    }
    public function categories()
{
    return $this->hasMany(Category::class);
}
    public function products()
    {
        return $this->hasMany(Product::class, 'Category_ID', 'Category_ID');
    }
}
