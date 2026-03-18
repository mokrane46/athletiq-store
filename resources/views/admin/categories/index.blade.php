@extends('layouts.admin')
@section('content')
<div class="premium-page-header" style="text-align: left; display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 50px;">
    <div>
        <span class="premium-eyebrow">Store Architecture</span>
        <h1 class="premium-title">Categories</h1>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="premium-btn" style="text-decoration: none;">
        <i class='bx bx-plus-circle'></i> Add New Category
    </a>
</div>
<div class="premium-card" style="padding: 0; overflow: hidden; border: 1px solid rgba(0,0,0,0.08);">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: var(--bg-secondary); border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <th style="padding: 25px 20px; font-size: 0.65rem; text-transform: uppercase; letter-spacing: 2px; color: var(--text-muted);">Structure</th>
                    <th style="padding: 25px 20px; font-size: 0.65rem; text-transform: uppercase; letter-spacing: 2px; color: var(--text-muted);">Linked Sub-Sections</th>
                    <th style="padding: 25px 20px; font-size: 0.65rem; text-transform: uppercase; letter-spacing: 2px; color: var(--text-muted);">Control</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.05); transition: all 0.2s;" onmouseover="this.style.background='rgba(50, 255, 126, 0.03)'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 25px 20px;">
                        <div style="font-weight: 800; color: var(--text-primary); font-size: 1.1rem; font-family: 'Sakana', sans-serif;">{{ $category->Category_name }}</div>
                        <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 4px;">ID: #{{ $category->Category_ID }} • {{ count($category->subcategories) }} Active Subcategories</div>
                    </td>
                    <td style="padding: 25px 20px;">
                        <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                            @foreach ($category->subcategories as $sub)
                                <span style="background: rgba(50, 255, 126, 0.1); color: var(--accent-dark); padding: 5px 14px; border-radius: 50px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">
                                    {{ $sub->SubCategory_name }}
                                </span>
                            @endforeach
                            @if(count($category->subcategories) == 0)
                                <span style="color: var(--text-muted); font-size: 0.8rem; font-style: italic;">No segments mapped</span>
                            @endif
                        </div>
                    </td>
                    <td style="padding: 25px 20px;">
                        <div style="display: flex; gap: 12px; align-items: center;">
                            <a href="{{ route('admin.categories.edit', $category) }}" title="Edit Category" style="width: 36px; height: 36px; border-radius: 10px; background: rgba(0,0,0,0.03); display: flex; align-items: center; justify-content: center; color: var(--text-secondary); text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='var(--accent)'; this.style.color='#000'" onmouseout="this.style.background='rgba(0,0,0,0.03)'; this.style.color='var(--text-secondary)'">
                                <i class='bx bx-edit-alt' style="font-size: 1.1rem;"></i>
                            </a>
                            <a href="{{ route('admin.categories.subcategories.index', ['categoryId' => $category->Category_ID]) }}" class="premium-btn" style="padding: 8px 16px; font-size: 0.7rem; text-decoration: none;">
                                <i class='bx bx-list-check'></i> Manage Sub-Sections
                            </a>
                            <form action="{{ route('admin.categories.destroy', ['category' => $category->Category_ID]) }}" method="POST" onsubmit="return confirm('Architectural Wipe: Permanent removal of this category?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="width: 36px; height: 36px; border-radius: 10px; background: rgba(255, 62, 62, 0.05); border: none; display: flex; align-items: center; justify-content: center; color: #ff3e3e; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#ff3e3e'; this.style.color='#fff'" onmouseout="this.style.background='rgba(255, 62, 62, 0.05)'; this.style.color='#ff3e3e'">
                                    <i class='bx bx-trash' style="font-size: 1.1rem;"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@if($categories->isEmpty())
<div class="premium-card" style="text-align: center; padding: 100px 40px;">
    <div style="width: 100px; height: 100px; border-radius: 50%; background: var(--bg-secondary); margin: 0 auto 30px; display: flex; align-items: center; justify-content: center;">
        <i class='bx bx-category' style="font-size: 3rem; color: var(--text-muted);"></i>
    </div>
    <h3 style="color: var(--text-primary); font-family: 'Sakana', sans-serif; font-size: 1.5rem; margin-bottom: 15px;">No Architecture Defined</h3>
    <p style="color: var(--text-muted); max-width: 400px; margin: 0 auto 30px;">Your store architecture is currently blank. Define categories to organize your gear deployments.</p>
    <a href="{{ route('admin.categories.create') }}" class="premium-btn" style="text-decoration: none; display: inline-flex;">Build Architecture</a>
</div>
@endif
@endsection
