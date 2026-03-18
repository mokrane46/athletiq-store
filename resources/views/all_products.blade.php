@extends('layouts.app')
@section('title', 'All Products | Athletiq')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<style>
    /* 2. ONLY LAYOUT CSS (Spacing and Grid Wrapping) */
    .products-page {
        padding-top: 120px;
        padding-bottom: 80px;
    }
    .breadcrumb {
        margin-bottom: 32px;
        font-size: 0.9rem;
        color: #666;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .breadcrumb a { color: #666; text-decoration: none; }
    .breadcrumb a:hover { color: #000; }
    .premium-page-header { margin-bottom: 40px; }
    .premium-eyebrow {
        font-size: 0.85rem;
        letter-spacing: 2px;
        color: #999;
        text-transform: uppercase;
        font-weight: 600;
        display: block;
        margin-bottom: 8px;
    }
    .premium-title { font-size: 2.5rem; font-weight: 800; margin: 0; color: #111; }
    /* --- THE GRID FIX --- */
    .product-grid-wrap {
        display: flex;
        flex-wrap: wrap; /* Forces items to drop to the next row */
        justify-content: center; /* Centers the cards nicely */
        gap: 30px;
        width: 100%;
        padding-bottom: 40px;
    }
    /* Locks the cards to be the exact same size as the Home Page */
    .product-grid-wrap .product-card {
        width: 300px !important; 
        flex: 0 0 300px !important; 
        margin: 0;
        display: flex;
        flex-direction: column;
    }
    /* Product Description Styling */
    .product-desc {
        font-size: 0.85rem;
        color: #777;
        margin: 8px 0 0 0;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2; /* Limit to 2 lines */
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    body.dark-mode .product-desc {
        color: #999;
    }
</style>
@endsection
@section('content')
<div class="premium-container products-page">
    <nav class="breadcrumb">
        <a href="{{ url('/') }}">Home</a>
        <span>/</span>
        @if(isset($isSearch) && $isSearch)
            <a href="{{ route('products.index') }}">Products</a>
            <span>/</span>
            <span style="color: var(--accent, #e63946); font-weight: 600;">Search: "{{ $query }}"</span>
        @else
            <span style="color: var(--accent, #e63946); font-weight: 600;">All Products</span>
        @endif
    </nav>
    <div class="premium-page-header">
        <span class="premium-eyebrow">
            {{ (isset($isSearch) && $isSearch) ? 'Search Results' : 'Elite Performance Gear' }}
        </span>
        <h1 class="premium-title">
            {{ (isset($isSearch) && $isSearch) ? 'Results for "' . $query . '"' : 'All Products' }}
        </h1>
    </div>
    <div class="product-grid-wrap">
        @forelse($products as $product)
            <div class="product-card">
                <a href="{{ route('product.show', $product->Product_ID) }}" style="text-decoration: none; color: inherit; display: flex; flex-direction: column; flex: 1;">
                    <div class="product-img-wrapper">
                        <img src="{{ asset('images/' . $product->Product_image) }}" alt="{{ $product->Product_name }}">
                        <div class="product-badge">New</div>
                    </div>
                    <div class="product-info" style="flex: 1; display: flex; flex-direction: column;">
                        <h3>{{ $product->Product_name }}</h3>
                        <p class="product-desc">
                            @if($product->specifications && $product->specifications->count() > 0)
                                {{ implode(' • ', $product->specifications->map(function($spec) {
                                    return $spec->pivot->Spec_value;
                                })->toArray()) }}
                            @else
                                Premium athletic gear designed for maximum performance and durability.
                            @endif
                        </p>
                        <span class="product-price" style="margin-top: auto; padding-top: 12px;">£{{ number_format($product->Price, 2) }}</span>
                    </div>
                </a>
                <div class="product-actions-hover">
                    <form method="POST" action="{{ route('cart.add') }}" style="flex: 1; display: flex;">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->Product_ID }}">
                        <button type="submit" class="btn-full"><i class='bx bx-cart'></i> Add</button>
                    </form>
                    <form method="POST" action="{{ route('wishlist.add') }}" class="wishlist-form-hover">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->Product_ID }}">
                        <button type="submit" class="btn-icon" title="Add to Wishlist"><i class='bx bx-heart'></i></button>
                    </form>
                </div>
            </div>
        @empty
            <div style="width: 100%; text-align: center; padding: 100px 0;">
                <p style="color: #999; font-size: 1.2rem;">No products found.</p>
            </div>
        @endforelse
    </div>
</div>
<script>
document.querySelectorAll('.wishlist-form-hover').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        fetch(this.action, {
            method: 'POST',
            body: new FormData(this)
        }).then(response => response.json())
          .then(data => {
              if(!data.success && data.redirect) {
                  window.location.href = data.redirect;
              } else {
                  alert(data.message);
                  if (data.success && data.message.includes('Added')) {
                     window.location.reload(); 
                  }
              }
          });
    });
});
</script>
@endsection