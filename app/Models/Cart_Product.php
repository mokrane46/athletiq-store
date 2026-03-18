<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Relations\Pivot;
class CartProduct extends Pivot
{
    protected $table = 'Cart_Product';
    protected $fillable = ['Cart_ID', 'Product_ID', 'Product_quantity'];
}
