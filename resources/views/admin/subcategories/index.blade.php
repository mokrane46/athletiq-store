@extends('layouts.admin')
@section('content')
<div class="premium-page-header" style="text-align: left; display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px;">
    <div>
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
            <a href="{{ route('admin.categories.index') }}" style="color: var(--text-muted); text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='var(--accent)'" onmouseout="this.style.color='var(--text-muted)'">
                <i class='bx bx-left-arrow-alt'></i> Categories
            </a>
        </div>
        <span class="premium-eyebrow">Architecture Refinement</span>
        <h1 class="premium-title">Subcategories for: {{ $category->Category_name }}</h1>
    </div>
</div>
<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px; align-items: start;">
    <div class="premium-card">
        <h3 style="font-family: 'Sakana', sans-serif; font-size: 1.1rem; margin-bottom: 20px; color: var(--text-primary);">
            <i class='bx bx-plus-circle'></i> New Sub-section
        </h3>
        <form action="{{ route('admin.categories.subcategories.store', ['categoryId' => $category->Category_ID]) }}" method="POST">
            @csrf
            <div class="premium-form-group">
                <label class="premium-label" for="SubCategory_name">Subcategory Title</label>
                <input type="text" name="SubCategory_name" id="SubCategory_name" class="premium-input" placeholder="e.g. Hoodies & Sweats" required autofocus>
                @error('SubCategory_name')
                    <p style="color: #ff3e3e; font-size: 0.8rem; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="premium-btn" style="width: 100%; padding: 14px;">Add to {{ $category->Category_name }}</button>
        </form>
    </div>
    <div class="premium-card" style="padding: 0; overflow: hidden;">
        <div style="padding: 20px; border-bottom: 1px solid rgba(0,0,0,0.05); background: rgba(0,0,0,0.01);">
            <h3 style="font-family: 'Sakana', sans-serif; font-size: 1rem; color: var(--text-secondary);">Active Sub-sections</h3>
        </div>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="background: rgba(0,0,0,0.02); border-bottom: 1px solid rgba(0,0,0,0.05);">
                        <th style="padding: 15px 20px; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted);">ID</th>
                        <th style="padding: 15px 20px; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted);">Name</th>
                        <th style="padding: 15px 20px; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted); text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($category->subcategories as $subcategory)
                    <tr style="border-bottom: 1px solid rgba(0,0,0,0.05); transition: background 0.2s;" onmouseover="this.style.background='rgba(50, 255, 126, 0.02)'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 15px 20px; font-weight: 700; font-size: 0.9rem;">#{{ $subcategory->SubCategory_ID }}</td>
                        <td style="padding: 15px 20px;">
                            <span style="font-weight: 700; color: var(--text-primary);">{{ $subcategory->SubCategory_name }}</span>
                        </td>
                        <td style="padding: 15px 20px; text-align: right;">
                            <form action="{{ route('admin.categories.subcategories.destroy', [$category->Category_ID, $subcategory->SubCategory_ID ]) }}" 
                                  method="POST" onsubmit="return confirm('Remove this sub-section? This may affect linked products.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; padding: 5px; color: #ff3e3e; font-size: 1.1rem; cursor: pointer; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'" title="Delete Subcategory">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($category->subcategories->isEmpty())
        <div style="text-align: center; padding: 40px;">
            <p style="color: var(--text-muted); font-size: 0.9rem; font-style: italic;">No sub-sections defined for this category.</p>
        </div>
        @endif
    </div>
</div>
@endsection
