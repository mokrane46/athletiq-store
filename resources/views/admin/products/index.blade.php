@extends('layouts.admin')
@section('content')
<div class="premium-page-header" style="text-align: left; display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 50px;">
    <div>
        <span class="premium-eyebrow">Inventory Management</span>
        <h1 class="premium-title">Stored Gear</h1>
    </div>
    <a href="{{ route('admin.products.create') }}" class="premium-btn" style="text-decoration: none;">
        <i class='bx bx-plus-circle'></i> Deploy New Gear
    </a>
</div>
<div class="premium-card" style="padding: 0; overflow: hidden; border: 1px solid rgba(0,0,0,0.08);">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: var(--bg-secondary); border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <th style="padding: 25px 20px; font-size: 0.65rem; text-transform: uppercase; letter-spacing: 2px; color: var(--text-muted);">Asset</th>
                    <th style="padding: 25px 20px; font-size: 0.65rem; text-transform: uppercase; letter-spacing: 2px; color: var(--text-muted);">Product Details</th>
                    <th style="padding: 25px 20px; font-size: 0.65rem; text-transform: uppercase; letter-spacing: 2px; color: var(--text-muted);">Category</th>
                    <th style="padding: 25px 20px; font-size: 0.65rem; text-transform: uppercase; letter-spacing: 2px; color: var(--text-muted);">Price</th>
                    <th style="padding: 25px 20px; font-size: 0.65rem; text-transform: uppercase; letter-spacing: 2px; color: var(--text-muted);">Stock Status</th>
                    <th style="padding: 25px 20px; font-size: 0.65rem; text-transform: uppercase; letter-spacing: 2px; color: var(--text-muted);">Control</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.05); transition: all 0.2s;" onmouseover="this.style.background='rgba(50, 255, 126, 0.03)'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 20px;">
                        <div style="width: 50px; height: 50px; border-radius: 10px; overflow: hidden; background: #eee; border: 1px solid rgba(0,0,0,0.05);">
                            @php
                                $thumbPath = 'images/' . $product->Product_image;
                                if (!file_exists(public_path($thumbPath))) {
                                    $thumbPath = 'storage/products/' . $product->Product_image;
                                }
                            @endphp
                            <img src="{{ asset($thumbPath) }}" alt="Thumbnail" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    </td>
                    <td style="padding: 20px;">
                        <div style="font-weight: 800; color: var(--text-primary); font-size: 0.95rem;">{{ $product->Product_name }}</div>
                        <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 4px;">ID: #{{ $product->Product_ID }} • {{ $product->subcategory->SubCategory_name ?? 'N/A' }}</div>
                    </td>
                    <td style="padding: 20px;">
                        <span style="background: rgba(0,0,0,0.05); padding: 5px 12px; border-radius: 50px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">
                            {{ $product->subcategory->category->Category_name ?? 'Uncategorized' }}
                        </span>
                    </td>
                    <td style="padding: 20px; font-weight: 800; color: var(--accent-dark); font-size: 1rem;">${{ number_format($product->Price, 2) }}</td>
                    <td style="padding: 20px;">
                        @if($product->Quantity > 10)
                            <div style="display: flex; align-items: center; gap: 8px; color: #22cc62;">
                                <div style="width: 8px; height: 8px; border-radius: 50%; background: #22cc62; box-shadow: 0 0 10px #22cc62;"></div>
                                <span style="font-weight: 700; font-size: 0.85rem;">{{ $product->Quantity }} In Stock</span>
                            </div>
                        @elseif($product->Quantity > 0)
                            <div style="display: flex; align-items: center; gap: 8px; color: #ffb800;">
                                <div style="width: 8px; height: 8px; border-radius: 50%; background: #ffb800; box-shadow: 0 0 10px #ffb800;"></div>
                                <span style="font-weight: 700; font-size: 0.85rem;">Low ({{ $product->Quantity }})</span>
                            </div>
                        @else
                            <div style="display: flex; align-items: center; gap: 8px; color: #ff3e3e;">
                                <div style="width: 8px; height: 8px; border-radius: 50%; background: #ff3e3e; box-shadow: 0 0 10px #ff3e3e;"></div>
                                <span style="font-weight: 700; font-size: 0.85rem;">Depleted</span>
                            </div>
                        @endif
                    </td>
                    <td style="padding: 20px;">
                        <div style="display: flex; gap: 12px;">
                            <a href="{{ route('admin.products.edit', $product) }}" title="Edit Product" style="width: 36px; height: 36px; border-radius: 10px; background: rgba(0,0,0,0.03); display: flex; align-items: center; justify-content: center; color: var(--text-secondary); text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='var(--accent)'; this.style.color='#000'" onmouseout="this.style.background='rgba(0,0,0,0.03)'; this.style.color='var(--text-secondary)'">
                                <i class='bx bx-edit-alt' style="font-size: 1.1rem;"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Secure Wipe: Permanent removal?');" style="display:inline;">
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
@if($products->isEmpty())
<div class="premium-card" style="text-align: center; padding: 100px 40px;">
    <div style="width: 100px; height: 100px; border-radius: 50%; background: var(--bg-secondary); margin: 0 auto 30px; display: flex; align-items: center; justify-content: center;">
        <i class='bx bx-package' style="font-size: 3rem; color: var(--text-muted);"></i>
    </div>
    <h3 style="color: var(--text-primary); font-family: 'Sakana', sans-serif; font-size: 1.5rem; margin-bottom: 15px;">Warehouse Empty</h3>
    <p style="color: var(--text-muted); max-width: 400px; margin: 0 auto 30px;">Your inventory vault is currently unoccupied. Deploy your first assets to start tracking performance.</p>
    <a href="{{ route('admin.products.create') }}" class="premium-btn" style="text-decoration: none; display: inline-flex;">Initialize Stock</a>
</div>
@endif
<div style="margin-top: 40px;">
    {{ $products->links() }}
</div>
@endsection
