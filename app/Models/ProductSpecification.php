<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ProductSpecification extends Model
{
    public $timestamps = false;
    protected $table = 'product_specifications';
    protected $fillable = ['Product_ID','Spec_ID','Spec_value'];
    public function product()
    {
        return $this->belongsTo(Product::class, 'Product_ID', 'Product_ID');
    }
    public function specification()
    {
        return $this->belongsTo(Specification::class, 'Spec_ID', 'Spec_ID');
    }
}
