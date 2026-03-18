<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Review extends Model
{
    protected $fillable = ['Product_ID', 'Customer_ID', 'Rating', 'Comment'];
    public function product()
    {
        return $this->belongsTo(Product::class, 'Product_ID', 'Product_ID');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'Customer_ID', 'Customer_ID');
    }
}
