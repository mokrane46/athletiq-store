@extends('layouts.app')
@section('title', 'Your Cart | Athletiq')
@section('styles')
<style>
    .cart-page {
        padding-top: 120px;
        min-height: 80vh;
        padding-bottom: 80px;
    }
    .cart-grid {
        display: grid;
        grid-template-columns: 1fr 420px; /* Made the summary slightly wider for the new form */
        gap: 40px;
        align-items: flex-start;
    }
    .cart-items {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    .cart-item-card {
        display: grid;
        grid-template-columns: 100px 1fr auto;
        gap: 24px;
        align-items: center;
        background: var(--bg-secondary, #fff);
        padding: 24px;
        border-radius: 12px;
        border: 1px solid rgba(0,0,0,0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    body.dark-mode .cart-item-card { border-color: rgba(255,255,255,0.05); background: #1a1a1a; }
    .cart-item-card:hover { 
        transform: translateY(-3px); 
        box-shadow: 0 8px 16px rgba(0,0,0,0.05);
    }
    .cart-item-img {
        width: 100px;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        background: #eee;
    }
    .cart-item-info h3 {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 4px;
        color: var(--text-primary, #111);
    }
    .cart-item-details {
        font-size: 0.9rem;
        color: var(--text-secondary, #666);
        margin-bottom: 12px;
    }
    .cart-item-price {
        font-weight: 700;
        color: var(--accent-dark, #000);
        font-size: 1.1rem;
    }
    .quantity-control {
        display: inline-flex;
        align-items: center;
        background: var(--bg-color, #fff);
        padding: 6px;
        border-radius: 30px;
        border: 1px solid rgba(0,0,0,0.1);
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
        gap: 12px;
    }
    body.dark-mode .quantity-control { 
        background: #111;
        border-color: rgba(255,255,255,0.1); 
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.2);
    }
    .qty-btn {
        background: rgba(0,0,0,0.04);
        border: none;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: var(--text-primary, #111);
        font-weight: 700;
        font-size: 1.2rem;
        transition: all 0.2s ease;
    }
    body.dark-mode .qty-btn { background: rgba(255,255,255,0.08); color: #fff; }
    .qty-btn:hover { 
        background: var(--accent, #111);
        color: #111;
        transform: scale(1.1);
        box-shadow: 0 4px 10px rgba(50, 255, 126, 0.4);
    }
    .qty-num {
        font-weight: 700;
        font-size: 1.1rem;
        min-width: 20px;
        text-align: center;
        color: var(--text-primary, #111);
    }
    .remove-item {
        color: #ff3e3e;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-top: 10px;
        display: block;
        transition: color 0.2s;
    }
    .remove-item:hover { color: #d00000; }
    /* Summary Sidebar */
    .cart-summary {
        position: sticky;
        top: 100px;
    }
    .summary-card {
        background: var(--bg-secondary, #fdfdfd);
        padding: 32px;
        border-radius: 12px;
        border: 1px solid rgba(0,0,0,0.08);
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    }
    .summary-title {
        font-size: 1.4rem;
        font-weight: 800;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid rgba(0,0,0,0.06);
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 16px;
        font-size: 1rem;
        color: var(--text-secondary, #555);
    }
    .summary-row.total {
        margin-top: 24px;
        padding-top: 24px;
        border-top: 1px solid rgba(0,0,0,0.06);
        color: var(--text-primary, #111);
        font-weight: 800;
        font-size: 1.3rem;
    }
    /* --- REALISTIC CHECKOUT FORM STYLES --- */
    .checkout-form {
        margin-top: 30px;
        text-align: left;
    }
    .form-section-header {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 16px;
        color: var(--text-primary, #111);
    }
    .form-group {
        margin-bottom: 16px;
    }
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
    .form-label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 6px;
        color: var(--text-secondary, #444);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 0.95rem;
        background: #fff;
        transition: border-color 0.2s, box-shadow 0.2s;
        box-sizing: border-box;
    }
    .form-input:focus {
        border-color: var(--accent, #111);
        outline: none;
        box-shadow: 0 0 0 3px rgba(17, 17, 17, 0.1);
    }
    select.form-input {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23333%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem top 50%;
        background-size: 0.65rem auto;
    }
    .checkout-btn {
        width: 100%;
        margin-top: 10px;
        padding: 16px;
        font-size: 1.1rem;
        background: var(--accent, #111);
        color: #fff;
        border: none;
        border-radius: 6px;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.2s;
    }
    .checkout-btn:hover {
        background: var(--accent-dark, #333);
    }
    @media (max-width: 1000px) {
        .cart-grid { grid-template-columns: 1fr; }
        .cart-summary { position: static; }
    }
    @media (max-width: 600px) {
        .cart-item-card { grid-template-columns: 80px 1fr; }
        .cart-item-actions { 
            grid-column: span 2; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            border-top: 1px solid rgba(0,0,0,0.05); 
            padding-top: 15px; 
        }
    }
</style>
@endsection
@section('content')
<div class="premium-container cart-page">
    <div class="premium-page-header">
        <span class="premium-eyebrow">READY TO DOMINATE?</span>
        <h1 class="premium-title">Your Cart</h1>
    </div>
    @if($cartItems->isEmpty())
        <div class="premium-card" style="text-align: center; padding: 60px; background: #fff; border-radius: 12px; border: 1px solid #eaeaea;">
            <i class='bx bx-cart' style="font-size: 4rem; color: var(--accent, #111); margin-bottom: 20px; display: block;"></i>
            <h3>Your cart is empty</h3>
            <p style="margin-bottom: 30px; color: var(--text-secondary, #666);">Looks like you haven't added any gear yet.</p>
            <a href="{{ url('/') }}" class="checkout-btn" style="display: inline-block; width: auto; padding: 12px 30px; text-decoration: none;">Start Shopping</a>
        </div>
    @else
        <div class="cart-grid">
            <div class="cart-items">
                @php $subtotal = 0; @endphp
                @foreach($cartItems as $item)
                    @php
                        $product = $item->product;
                        $quantity = $item->quantity;
                        $color = $item->color;
                        $size = $item->size;
                        $itemTotal = $item->price * $quantity;
                        $subtotal += $itemTotal;
                    @endphp
                    <div class="cart-item-card">
                        <img src="{{ asset('images/'.$product->Product_image) }}" alt="{{ $product->Product_name }}" class="cart-item-img">
                        <div class="cart-item-info">
                            <h3>{{ $product->Product_name }}</h3>
                            <p class="cart-item-details">
                                Elite Performance Wear
                                @if($color && $color !== 'none') <br> Color: <strong>{{ $color }}</strong> @endif
                                @if($size && $size !== 'none') <br> Size: <strong>{{ $size }}</strong> @endif
                            </p>
                            <span class="cart-item-price">£{{ number_format($product->Price, 2) }}</span>
                            <form action="{{ route('cart.remove', $product->Product_ID) }}" method="POST">
                                @csrf
                                <input type="hidden" name="variant_color" value="{{ $color }}">
                                <input type="hidden" name="variant_size" value="{{ $size }}">
                                <button type="submit" class="remove-item">Remove</button>
                            </form>
                        </div>
                        <div class="cart-item-actions">
                            <div class="quantity-control">
                                <form action="{{ route('cart.remove', $product->Product_ID) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="variant_color" value="{{ $color }}">
                                    <input type="hidden" name="variant_size" value="{{ $size }}">
                                    <button type="submit" class="qty-btn">−</button>
                                </form>
                                <span class="qty-num">{{ $quantity }}</span>
                                <form action="{{ route('cart.add') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->Product_ID }}">
                                    <input type="hidden" name="variant_color" value="{{ $color }}">
                                    <input type="hidden" name="variant_size" value="{{ $size }}">
                                    <button type="submit" class="qty-btn">+</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="cart-summary">
                <div class="summary-card">
                    <h2 class="summary-title">Order Summary</h2>
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>£{{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span>£0.00</span>
                    </div>
                    <div class="summary-row">
                        <span>Tax (Included)</span>
                        <span>£{{ number_format($subtotal * 0.2, 2) }}</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>£{{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div style="margin-top: 30px;">
                        <a href="{{ route('checkout') }}" class="checkout-btn" style="display: block; text-align: center; text-decoration: none;">Proceed to Checkout</a>
                    </div>
                    <p style="font-size: 0.75rem; text-align: center; color: var(--text-muted, #999); margin-top: 16px;">
                        <i class="fa fa-lock"></i> Secure Checkout Powered by Athletiq Elite
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection