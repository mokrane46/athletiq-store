@extends('layouts.app')
@section('title', 'MY WISHLIST | Athletiq')
@section('content')
<div class="premium-container">
    <div class="premium-page-header">
        <span class="premium-eyebrow">SAVED GEAR</span>
        <h1 class="premium-title">YOUR WISHLIST</h1>
    </div>
    @if($products->isEmpty())
        <div class="empty-state" style="text-align: center; padding: 60px 20px;">
            <div style="font-size: 4rem; color: var(--text-muted); margin-bottom: 20px;">
                <i class='bx bx-heart-circle'></i>
            </div>
            <h2 style="font-family: 'Sakana', sans-serif; margin-bottom: 15px;">Your wishlist is empty</h2>
            <p style="color: var(--text-muted); margin-bottom: 30px;">Start saving your favorite elite gear for later.</p>
            <a href="{{ route('products.index') }}" class="premium-btn">Explore Collections</a>
        </div>
    @else
        <div class="product-grid">
            @foreach($products as $product)
                <div class="product-card">
                    <a href="{{ route('product.show', $product->Product_ID) }}" style="text-decoration: none; color: inherit; display: flex; flex-direction: column; flex: 1;">
                        <div class="product-img-wrapper">
                            <img src="{{ asset('images/' . $product->Product_image) }}" alt="{{ $product->Product_name }}">
                        </div>
                        <div class="product-info" style="flex: 1; display: flex; flex-direction: column;">
                            <h3>{{ $product->Product_name }}</h3>
                            <p class="product-desc" style="font-size: 0.85rem; color: #777; margin: 8px 0 0 0; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                @if($product->specifications && $product->specifications->count() > 0)
                                    {{ implode(' • ', $product->specifications->map(function($spec) {
                                        return $spec->pivot->Spec_value;
                                    })->toArray()) }}
                                @else
                                    Premium athletic gear.
                                @endif
                            </p>
                            <span class="product-price" style="margin-top: auto; padding-top: 12px; margin-bottom: 20px; display: block;">£{{ number_format($product->Price, 2) }}</span>
                        </div>
                    </a>
                    <div class="product-actions-hover">
                        <form action="{{ route('cart.add') }}" method="POST" style="flex: 1; display: flex;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->Product_ID }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn-full">
                                <i class='bx bx-cart-add'></i> Add to Cart
                            </button>
                        </form>
                        <form action="{{ route('wishlist.remove', $product->Product_ID) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-icon" title="Remove from Wishlist" style="color: #ff3e3e; border-color: rgba(255, 62, 62, 0.2);">
                                <i class='bx bx-trash'></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
