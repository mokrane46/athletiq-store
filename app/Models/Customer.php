<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
class Customer extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'Customer';
    protected $primaryKey = 'Customer_ID';
    public $timestamps = true;
    protected $fillable = ['Email', 'Password', 'role', 'last_login_at'];
    protected $hidden = ['Password'];
    protected $casts = [
        'last_login_at' => 'datetime',
    ];
    public function getAuthPassword()
    {
        return $this->Password;
    }
    public function setPasswordAttribute($value)
    {
        $this->attributes['Password'] = Hash::make($value);
    }
    public function cart()
    {
        return $this->hasOne(Cart::class, 'Customer_ID');
    }
    public function cartItemCount()
{
    return $this->cart ? $this->cart->products()->sum('Product_quantity') : 0;
}
public function reviews()
{
    return $this->hasMany(Review::class, 'Customer_ID', 'Customer_ID');
}
}
