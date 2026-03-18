@extends('layouts.app')
@section('title', $category->Category_name . ' | Athletiq')
@section('styles')
<style>
    .collection-page {
        padding-top: 120px;
    }
    .subcategory-section {
        margin-bottom: 80px;
    }
    .subcategory-title {
        font-family: 'Sakana', 'Montserrat', sans-serif;
        font-size: 2rem;
        color: var(--text-primary);
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .subcategory-title::after {
        content: '';
        flex: 1;
        height: 1px;
        background: linear-gradient(90deg, var(--accent), transparent);
        opacity: 0.3;
    }
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 30px;
    }
    .product-card {
        background: var(--bg-secondary);
        border-radius: var(--radius-md);
        padding: 20px;
        border: 1px solid rgba(0,0,0,0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
    }
    body.dark-mode .product-card { border-color: rgba(255,255,255,0.05); }
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.1);
    }
    .product-img-wrap {
        width: 100%;
        aspect-ratio: 1;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 20px;
        background: #eee;
    }
    .product-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .product-card:hover .product-img-wrap img {
        transform: scale(1.05);
    }
    .product-info h3 {
        font-family: 'Sakana', sans-serif;
        font-size: 1.1rem;
        margin-bottom: 8px;
        color: var(--text-primary);
    }
    .product-price {
        font-weight: 700;
        color: var(--accent-dark);
        font-size: 1.2rem;
        margin-bottom: 20px;
        display: block;
    }
    .product-actions {
        margin-top: auto;
    }
    .buy-btn {
        width: 100%;
    }
</style>
@endsection
@section('content')
<div class="premium-container collection-page">
    <div class="premium-page-header" style="text-align: left;">
        <span class="premium-eyebrow">ELITE COLLECTIONS</span>
        <h1 class="premium-title">{{ $category->Category_name }}</h1>
    </div>
    @foreach($groupedProducts as $subcategoryName => $products)
        <section class="subcategory-section">
            <h2 class="subcategory-title">{{ $subcategoryName }}</h2>
            <div class="product-grid">
                @foreach($products as $product)
                    <div class="product-card">
                        <div class="product-img-wrap">
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
                        <div class="product-actions">
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->Product_ID }}">
                                <button type="submit" class="premium-btn buy-btn">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endforeach
</div>
@endsection