<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Http\Request;
class OrderController extends Controller
{
    public function index()
    {
        $orders = Orders::with('cart')->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }
    public function update(Request $request, Orders $order)
    {
        $request->validate(['Order_status' => 'required|string']);
        $order->update(['Order_status' => $request->Order_status]);
        return back()->with('success', 'Order status updated.');
    }
}
