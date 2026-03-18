@extends('layouts.app')
@section('title', $product->Product_name . ' | Athletiq')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection
@section('content')
<div class="product-details-page">
    <div class="container">
        <div class="product-main-layout">
            <div class="product-gallery">
                <div class="product-main-img">
                    <img src="{{ asset('images/'.$product->Product_image) }}" alt="{{ $product->Product_name }}">
                </div>
            </div>
            <div class="product-info-sticky">
                <div class="product-header-info">
                    <span class="category-tag">Elite Performance Gear</span>
                    <h1>{{ $product->Product_name }}</h1>
                    <div class="price-tag">
                        £{{ number_format($product->Price, 2) }}
                    </div>
                </div>
                <div class="product-description-premium">
                    @if($product->specifications && $product->specifications->count() > 0)
                        <p>
                            Elevate your performance with the {{ $product->Product_name }}. 
                            This elite piece features  
                            <strong>{{ implode(', ', $product->specifications->map(fn($s) => $s->Spec_name . ': ' . $s->pivot->Spec_value)->toArray()) }}</strong>.
                            Designed for the absolute elite, combining cutting-edge fabric technology with athletic ergonomics.
                        </p>
                    @else
                        <p>Designed for the absolute elite, this piece combines cutting-edge fabric technology with athletic ergonomics. Engineered to move with your body, it offers unparalleled breathability and moisture-wicking performance.</p>
                    @endif
                </div>
                @php
                    $availableColors = [];
                    $availableSizes = [];
                    if($product->specifications) {
                        foreach($product->specifications as $spec) {
                            if(strtolower($spec->Spec_name) === 'color') {
                                $availableColors[] = $spec->pivot->Spec_value;
                            }
                            if(strtolower($spec->Spec_name) === 'size') {
                                $availableSizes[] = $spec->pivot->Spec_value;
                            }
                        }
                    }
                    $availableColors = array_values(array_unique($availableColors));
                    $availableSizes = array_values(array_unique($availableSizes));
                    $defaultColor = count($availableColors) > 0 ? $availableColors[0] : null;
                    $defaultSize = count($availableSizes) > 0 ? $availableSizes[0] : null;
                @endphp
                @if($product->subcategory && $product->subcategory->category && $product->subcategory->category->Category_name == 'Clothes')
                    <div class="variant-section">
                        <div class="variant-group">
                            <span class="variant-title">Select Color</span>
                            <div class="color-selector" id="color-options">
                                <div class="color-swatch {{ strtolower($defaultColor ?? '') == 'black' ? 'active' : '' }}" style="background-color: #111;" data-color="Black" title="Black"></div>
                                <div class="color-swatch {{ strtolower($defaultColor ?? '') == 'white' ? 'active' : '' }}" style="background-color: #f0f0f0;" data-color="White" title="White"></div>
                                <div class="color-swatch {{ strtolower($defaultColor ?? '') == 'navy' ? 'active' : '' }}" style="background-color: #2c3e50;" data-color="Navy" title="Navy"></div>
                                <div class="color-swatch {{ strtolower($defaultColor ?? '') == 'red' ? 'active' : '' }}" style="background-color: #e74c3c;" data-color="Red" title="Red"></div>
                            </div>
                        </div>
                        <div class="variant-group">
                            <span class="variant-title">Select Size</span>
                            <div class="size-selector" id="size-options">
                                <div class="size-swatch {{ strtolower($defaultSize ?? '') == 's' ? 'active' : '' }}" data-size="S">S</div>
                                <div class="size-swatch {{ strtolower($defaultSize ?? '') == 'm' ? 'active' : '' }}" data-size="M">M</div>
                                <div class="size-swatch {{ strtolower($defaultSize ?? '') == 'l' ? 'active' : '' }}" data-size="L">L</div>
                                <div class="size-swatch {{ strtolower($defaultSize ?? '') == 'xl' ? 'active' : '' }}" data-size="XL">XL</div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="action-container">
                    <form action="{{ route('cart.add') }}" method="POST" id="add-to-cart-form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->Product_ID }}">
                        <input type="hidden" name="variant_color" id="input_color" value="{{ current(array_filter(['Black', 'White', 'Navy', 'Red'], fn($c) => strtolower($c) === strtolower($defaultColor ?? ''))) ?: 'Black' }}">
                        <input type="hidden" name="variant_size" id="input_size" value="{{ current(array_filter(['S', 'M', 'L', 'XL'], fn($s) => strtolower($s) === strtolower($defaultSize ?? ''))) ?: 'M' }}">
                        <button type="submit" class="btn-premium-cart">
                            <i class='bx bx-shopping-bag'></i> Add to Basket
                        </button>
                    </form>
                    <form action="{{ route('wishlist.add') }}" method="POST" id="wishlist-form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->Product_ID }}">
                        <button type="submit" class="btn-premium-wish">
                            <i class='bx bx-heart'></i> Add to Wishlist
                        </button>
                    </form>
                </div>
                <div class="trust-badges">
                    <div class="trust-item">
                        <i class='bx bx-package'></i>
                        <span>Free Express Shipping</span>
                    </div>
                    <div class="trust-item">
                        <i class='bx bx-refresh'></i>
                        <span>30-Day Easy Returns</span>
                    </div>
                    <div class="trust-item">
                        <i class='bx bx-shield-quarter'></i>
                        <span>2 Year Warranty</span>
                    </div>
                    <div class="trust-item">
                        <i class='bx bx-lock-alt'></i>
                        <span>Secure Checkout</span>
                    </div>
                </div>
            </div>
        </div>
        <section class="reviews-section">
            <div class="reviews-grid">
                <div class="reviews-content">
                    <div class="reviews-header">
                        <h2>Community Reviews</h2>
                        <div class="rating-summary">
                            @php
                                $avgRating = $product->reviews->avg('Rating') ?: 0;
                                $fullStars = floor($avgRating);
                            @endphp
                            <span class="avg-rating">{{ number_format($avgRating, 1) }}</span>
                            <div class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class='bx {{ $i <= $fullStars ? "bxs-star" : "bx-star" }}'></i>
                                @endfor
                            </div>
                            <span style="color: var(--text-muted);">({{ $product->reviews->count() }} Reviews)</span>
                        </div>
                    </div>
                    <div class="reviews-list">
                        @if($product->reviews->isNotEmpty())
                            @foreach($product->reviews as $review)
                                <div class="review-card">
                                    <div class="review-meta">
                                        <span class="reviewer-name">{{ $review->customer->name ?: 'Elite Athlete' }}</span>
                                        <div class="stars" style="font-size: 0.9rem;">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class='bx {{ $i <= $review->Rating ? "bxs-star" : "bx-star" }}'></i>
                                            @endfor
                                        </div>
                                        <span class="review-date">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="review-comment">{{ $review->Comment }}</p>
                                </div>
                            @endforeach
                        @else
                            <div class="empty-reviews" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                <i class='bx bx-message-dots' style="font-size: 3rem; margin-bottom: 10px; display: block;"></i>
                                <p>No reviews yet. Be the first to share your experience!</p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="review-form-wrapper">
                    <div class="review-form-container">
                        @auth
                            <h3>Leave a Review</h3>
                            <form action="{{ route('reviews.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->Product_ID }}">
                                <div class="premium-label">How would you rate it?</div>
                                <div class="rating-input">
                                    @for($i = 5; $i >= 1; $i--)
                                        <input type="radio" name="rating" id="star-{{ $i }}" value="{{ $i }}" required>
                                        <label for="star-{{ $i }}"><i class='bx bxs-star'></i></label>
                                    @endfor
                                </div>
                                <div class="premium-label">Your thoughts</div>
                                <textarea name="comment" class="review-textarea" placeholder="Share your experience with this gear..." required></textarea>
                                <button type="submit" class="btn-submit-review">Post Review</button>
                            </form>
                        @else
                            <div style="text-align: center; padding: 20px;">
                                <i class='bx bx-lock-alt' style="font-size: 2.5rem; color: var(--accent); margin-bottom: 15px; display: block;"></i>
                                <h3 style="margin-bottom: 15px;">Want to review?</h3>
                                <p style="color: var(--text-secondary); margin-bottom: 25px;">You must be logged in to share your thoughts with the community.</p>
                                <a href="{{ route('login') }}" class="premium-btn" style="display: block; width: 100%;">Login to Review</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </section>
        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
            <div class="related-section">
                <h2 class="related-title">Complete Your Look</h2>
                <div class="product-grid">
                    @foreach($relatedProducts as $related)
                        <div class="product-card">
                            <a href="{{ route('product.show', $related->Product_ID) }}" style="text-decoration: none; color: inherit; display: flex; flex-direction: column; flex: 1;">
                                <div class="product-img-wrapper">
                                    <img src="{{ asset('images/'.$related->Product_image) }}" alt="{{ $related->Product_name }}">
                                </div>
                                <div class="product-info">
                                    <h3>{{ $related->Product_name }}</h3>
                                    <span class="product-price">£{{ number_format($related->Price, 2) }}</span>
                                </div>
                            </a>
                            <div class="product-actions-hover">
                                <form method="POST" action="{{ route('cart.add') }}" style="flex: 1; display: flex;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $related->Product_ID }}">
                                    <button type="submit" class="btn-full"><i class='bx bx-cart'></i> Add</button>
                                </form>
                                <form method="POST" action="{{ route('wishlist.add') }}" class="wishlist-form-hover">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $related->Product_ID }}">
                                    <button type="submit" class="btn-icon"><i class='bx bx-heart'></i></button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
<script>
document.getElementById('wishlist-form').addEventListener('submit', function(e) {
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
// For related products AJAX wishlist
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
// Variant Selection Logic
document.addEventListener('DOMContentLoaded', function() {
    const colorInput = document.getElementById('input_color');
    const sizeInput = document.getElementById('input_size');
    // Handle Color Selection
    const colorSwatches = document.querySelectorAll('#color-options .color-swatch');
    if(colorSwatches.length > 0) {
        colorSwatches.forEach(swatch => {
            swatch.addEventListener('click', function() {
                colorSwatches.forEach(s => s.classList.remove('active'));
                this.classList.add('active');
                if(colorInput) colorInput.value = this.getAttribute('data-color');
            });
        });
    }
    // Handle Size Selection
    const sizeSwatches = document.querySelectorAll('#size-options .size-swatch');
    if(sizeSwatches.length > 0) {
        sizeSwatches.forEach(swatch => {
            swatch.addEventListener('click', function() {
                sizeSwatches.forEach(s => s.classList.remove('active'));
                this.classList.add('active');
                if(sizeInput) sizeInput.value = this.getAttribute('data-size');
            });
        });
    }
});
</script>
@endsection