<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
class Cart extends Model
{
    use HasFactory;
    protected $table = 'Cart';
    protected $primaryKey = 'Cart_ID';
    protected $fillable = ['Customer_ID'];
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'Customer_ID');
    }
    public function products()
    {
        return $this->belongsToMany(
            Product::class, 
            'Cart_Product', 
            'Cart_ID',
            'Product_ID')->withPivot('Product_quantity', 'color', 'size');
    }
    public function order()
    {
        return $this->hasOne(Orders::class, 'Cart_ID');
    }
}
