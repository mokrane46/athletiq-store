<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:Product,Product_ID',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);
        if (!Auth::check()) {
            return back()->with('error', 'You must be logged in to leave a review.');
        }
        Review::create([
            'Product_ID' => $request->product_id,
            'Customer_ID' => Auth::user()->Customer_ID,
            'Rating' => $request->rating,
            'Comment' => $request->comment,
        ]);
        return back()->with('success', 'Thank you for your review!');
    }
}
