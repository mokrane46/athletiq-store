<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Specification extends Model
{
    use HasFactory;
    protected $table = 'Specifications';
    protected $primaryKey = 'Spec_ID';
    protected $fillable = ['Spec_name'];
}
