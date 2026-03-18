@extends('layouts.app')
@section('title', 'Select Category | Athletiq')
@section('styles')
<style>
    .category-page {
        padding-top: 120px;
    }
    .subcategory-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
        margin-top: 40px;
    }
    .subcategory-card {
        padding: 40px;
        text-align: center;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 16px;
    }
    .subcategory-card i {
        font-size: 3rem;
        color: var(--accent);
        margin-bottom: 10px;
        transition: transform 0.3s ease;
    }
    .subcategory-card:hover i {
        transform: scale(1.1) rotate(5deg);
    }
    .subcategory-card h3 {
        font-family: 'Sakana', sans-serif;
        font-size: 1.5rem;
        color: var(--text-primary);
    }
    .subcategory-card p {
        color: var(--text-secondary);
        font-size: 0.95rem;
        line-height: 1.5;
    }
    .category-back-btn {
        margin-bottom: 24px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--text-secondary);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s;
    }
    .category-back-btn:hover { color: var(--accent-dark); }
</style>
@endsection
@section('content')
<div class="premium-container category-page">
    <a href="{{ url('/') }}" class="category-back-btn">
        <i class='bx bx-left-arrow-alt'></i> Back to Home
    </a>
    <div class="premium-page-header">
        <span class="premium-eyebrow">CHOOSE YOUR DISCIPLINE</span>
        <h1 class="premium-title">Subcategories in {{ $category->Category_name }}</h1>
    </div>
    <div class="subcategory-grid">
        @foreach($category->subcategories as $subcategory)
            <a href="{{ route('subcategory.products', $subcategory->SubCategory_ID) }}" class="premium-card subcategory-card">
                <i class='bx bxs-bolt-circle'></i>
                <h3>{{ $subcategory->SubCategory_name }}</h3>
                <p>{{ $subcategory->description ?? 'Explore our elite range of ' . strtolower($subcategory->SubCategory_name) . '.' }}</p>
                <span class="premium-btn-outline premium-btn" style="margin-top: 10px; padding: 8px 20px;">View Collection</span>
            </a>
        @endforeach
    </div>
</div>
@endsection
