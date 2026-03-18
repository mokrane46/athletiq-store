@extends('layouts.app')
@section('title', 'Order Success | Athletiq')
@section('styles')
<style>
    .success-page {
        padding-top: 160px;
        padding-bottom: 100px;
        text-align: center;
        min-height: 80vh;
        background: #f8f9fa;
    }
    .success-card {
        max-width: 600px;
        margin: 0 auto;
        background: #fff;
        padding: 60px 40px;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.05);
    }
    .success-icon {
        width: 80px;
        height: 80px;
        background: #e6f7ed;
        color: #00c853;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        margin: 0 auto 30px;
        animation: scaleUp 0.5s ease;
    }
    @keyframes scaleUp {
        from { transform: scale(0.5); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    .success-title {
        font-family: 'Sakana', sans-serif;
        font-size: 2.2rem;
        margin-bottom: 15px;
    }
    .success-text {
        color: #666;
        font-size: 1.1rem;
        margin-bottom: 40px;
        line-height: 1.6;
    }
    .order-summary-box {
        background: #f9f9f9;
        border-radius: 12px;
        padding: 25px;
        text-align: left;
        margin-bottom: 40px;
    }
    .summary-line {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 0.95rem;
    }
    .btn-home {
        background: var(--accent, #111);
        color: #fff;
        padding: 16px 40px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 700;
        display: inline-block;
        transition: transform 0.2s;
    }
    .btn-home:hover {
        transform: translateY(-2px);
    }
</style>
@endsection
@section('content')
<div class="success-page">
    <div class="container">
        <div class="success-card">
            <div class="success-icon">
                <i class='bx bx-check'></i>
            </div>
            <h1 class="success-title">Order Confirmed!</h1>
            <p class="success-text">
                Your order has been placed successfully and is being processed. 
                We'll send you a confirmation email with tracking details shortly.
            </p>
            <div class="order-summary-box">
                <div class="summary-line">
                    <span style="color: #999;">Status:</span>
                    <span style="font-weight: 700; color: #00c853;">Processing</span>
                </div>
                <div class="summary-line">
                    <span style="color: #999;">Payment:</span>
                    <span style="font-weight: 700;">Authorized</span>
                </div>
                <div class="summary-line">
                    <span style="color: #999;">Shipping:</span>
                    <span style="font-weight: 700;">Standard (FREE)</span>
                </div>
            </div>
            <a href="{{ url('/') }}" class="btn-home">Back to Shop</a>
        </div>
    </div>
</div>
@endsection
