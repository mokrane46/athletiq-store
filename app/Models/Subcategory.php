<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Subcategory extends Model
{
    use HasFactory;
    protected $table = 'Subcategory';
    protected $primaryKey = 'SubCategory_ID';
    protected $fillable = ['SubCategory_name', 'Category_ID'];
    public function category()
    {
        return $this->belongsTo(Category::class, 'Category_ID');
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'SubCategory_ID');
    }
}
