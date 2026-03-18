@extends('layouts.admin')
@section('content')
<div class="premium-page-header" style="text-align: left; margin-bottom: 50px;">
    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
        <a href="{{ route('admin.categories.index') }}" style="color: var(--text-muted); font-size: 1.2rem; text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='var(--accent)'" onmouseout="this.style.color='var(--text-muted)'">
            <i class='bx bx-arrow-back'></i>
        </a>
        <span class="premium-eyebrow" style="margin-bottom: 0;">Store Architecture</span>
    </div>
    <h1 class="premium-title">New Category</h1>
</div>
<div class="premium-card" style="max-width: 550px;">
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="premium-form-group" style="margin-bottom: 40px;">
            <label class="premium-label" for="Category_name">Category Name</label>
            <input type="text" name="Category_name" id="Category_name" class="premium-input" placeholder="e.g. Footwear" value="{{ old('Category_name') }}" required autofocus>
            <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 10px;">
                This will define a new high-level department in your storefront architecture.
            </p>
            @error('Category_name')<p style="color: #ff3e3e; font-size: 0.8rem; margin-top: 8px;">{{ $message }}</p>@enderror
        </div>
        <div style="display: flex; gap: 20px;">
            <button type="submit" class="premium-btn" style="flex: 1.5;">Map Category</button>
            <a href="{{ route('admin.categories.index') }}" class="premium-btn premium-btn-outline" style="flex: 1; text-decoration: none;">Discard</a>
        </div>
    </form>
</div>
@endsection
