<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Orders extends Model
{
    use HasFactory;
    protected $table = 'Orders';
    protected $primaryKey = 'Order_ID';
    protected $fillable = ['Order_date', 'Delivery_address', 'Order_status', 'Cart_ID'];
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'Cart_ID');
    }
}
