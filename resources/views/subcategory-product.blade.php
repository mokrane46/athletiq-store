@extends('layouts.app')
@section('title', ($subcategory->SubCategory_name ?? 'Products') . ' | Athletiq')
@section('styles')
<style>
    .products-page {
        padding-top: 120px;
    }
    .breadcrumb {
        margin-bottom: 32px;
        font-size: 0.9rem;
        color: var(--text-secondary);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .breadcrumb a {
        color: var(--text-secondary);
        text-decoration: none;
        transition: color 0.2s;
    }
    .breadcrumb a:hover { color: var(--accent-dark); }
    .breadcrumb span { color: var(--text-muted); }
    /* Modern Filters */
    .filter-bar {
        background: rgba(var(--bg-rgb, 20, 20, 20), 0.7);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        padding: 16px 32px;
        border-radius: 50px;
        margin-bottom: 60px;
        display: flex;
        align-items: center;
        gap: 24px;
        border: 1px solid rgba(255,255,255,0.1);
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        max-width: fit-content;
    }
    body:not(.dark-mode) .filter-bar {
        background: rgba(255, 255, 255, 0.8);
        border-color: rgba(0,0,0,0.05);
        box-shadow: 0 8px 32px rgba(0,0,0,0.05);
    }
    .filter-label {
        font-weight: 700;
        font-size: 0.8rem;
        letter-spacing: 1px;
        color: var(--accent);
        text-transform: uppercase;
        white-space: nowrap;
    }
    .filter-group {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .filter-select {
        background: transparent;
        border: none;
        color: var(--text-primary);
        font-family: 'Montserrat', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        padding: 5px 10px;
        outline: none;
        border-bottom: 2px solid transparent;
        transition: border-color 0.3s;
    }
    .filter-select:hover, .filter-select:focus {
        border-color: var(--accent);
    }
    .filter-submit-btn {
        background: var(--accent);
        color: #111;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        font-size: 1.1rem;
        transition: transform 0.3s ease;
    }
    .filter-submit-btn:hover {
        transform: scale(1.1);
        background: var(--accent-dark);
    }
    .filter-clear-link {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-muted);
        text-decoration: none;
        transition: color 0.2s;
    }
    .filter-clear-link:hover {
        color: var(--text-primary);
    }
</style>
@endsection
@section('content')
<div class="premium-container products-page">
    <nav class="breadcrumb">
        <a href="{{ url('/') }}">Home</a>
        <span>/</span>
        <a href="{{ route('category.subcategories', $subcategory->Category_ID) }}">
            {{ $subcategory->category->Category_name ?? 'Collection' }}
        </a>
        <span>/</span>
        <span style="color: var(--accent); font-weight: 600;">{{ $subcategory->SubCategory_name }}</span>
    </nav>
    <div class="premium-page-header" style="text-align: left;">
        <span class="premium-eyebrow">ELITE PERFORMANCE GEAR</span>
        <h1 class="premium-title">{{ $subcategory->SubCategory_name }}</h1>
    </div>
    @if($subcategory->category->Category_name == 'Clothes' || $subcategory->SubCategory_ID == 5)
        <div style="display: flex; justify-content: center;">
            <form method="GET" action="{{ route('subcategory.products.search', ['id' => $subcategory->SubCategory_ID]) }}" class="filter-bar">
                <span class="filter-label"><i class='bx bx-filter-alt'></i> Filter By</span>
                @if($subcategory->category->Category_name == 'Clothes')
                    <div class="filter-group">
                        <select name="Size" class="filter-select">
                            <option value="">Size: All</option>
                            @foreach(['S', 'M', 'L', 'XL'] as $size)
                                <option value="{{ $size }}" {{ request('Size') == $size ? 'selected' : '' }}>{{ $size }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-group">
                        <select name="Color" class="filter-select">
                            <option value="">Color: All</option>
                            @foreach(['Red', 'Blue', 'Green', 'Black', 'White'] as $color)
                                <option value="{{ $color }}" {{ request('Color') == $color ? 'selected' : '' }}>{{ $color }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                @if($subcategory->SubCategory_ID == 5)
                    <div class="filter-group">
                        <select name="Weight" class="filter-select">
                            <option value="">Weight: All</option>
                            @foreach(['2kg', '5kg', '10kg', '15kg', '20kg', '25kg', '30kg'] as $w)
                                <option value="{{ $w }}" {{ request('Weight') == $w ? 'selected' : '' }}>{{ $w }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <button type="submit" class="filter-submit-btn" title="Apply Filters">
                    <i class='bx bx-check'></i>
                </button>
                <a href="{{ route('subcategory.products', $subcategory->SubCategory_ID) }}" class="filter-clear-link">Reset</a>
            </form>
        </div>
    @endif
    <div class="product-grid">
        @forelse($products as $product)
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
                                Premium athletic gear designed for maximum performance.
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
            <div style="grid-column: 1/-1; text-align: center; padding: 100px 0;">
                <p style="color: var(--text-muted); font-size: 1.2rem;">No products found matching your elite criteria.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
