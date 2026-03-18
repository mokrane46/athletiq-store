@extends('layouts.admin')
@section('content')
<div class="premium-page-header" style="text-align: left; margin-bottom: 50px;">
    <span class="premium-eyebrow">Control Center</span>
    <h1 class="premium-title">Performance Overview</h1>
</div>
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px; margin-bottom: 50px;">
    <div class="premium-card" style="position: relative; overflow: hidden; display: flex; flex-direction: column; gap: 15px;">
        <div style="font-size: 0.7rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 2px;">Catalog Size</div>
        <div style="display: flex; align-items: baseline; gap: 10px;">
            <span style="font-size: 2.8rem; font-weight: 900; font-family: 'Sakana', sans-serif;">{{ $stats['products_count'] }}</span>
            <span style="font-size: 0.9rem; font-weight: 700; color: var(--accent);">Live Units</span>
        </div>
        <i class='bx bxs-package' style="position: absolute; right: -10px; bottom: -10px; font-size: 6rem; opacity: 0.03;"></i>
    </div>
    <div class="premium-card" style="position: relative; overflow: hidden; display: flex; flex-direction: column; gap: 15px;">
        <div style="font-size: 0.7rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 2px;">Market Segments</div>
        <div style="display: flex; align-items: baseline; gap: 10px;">
            <span style="font-size: 2.8rem; font-weight: 900; font-family: 'Sakana', sans-serif;">{{ $stats['categories_count'] }}</span>
            <span style="font-size: 0.9rem; font-weight: 700; color: var(--accent);">Active Depts</span>
        </div>
        <i class='bx bxs-category' style="position: absolute; right: -10px; bottom: -10px; font-size: 6rem; opacity: 0.03;"></i>
    </div>
    <div class="premium-card" style="position: relative; overflow: hidden; display: flex; flex-direction: column; gap: 15px;">
        <div style="font-size: 0.7rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 2px;">Pipeline Volume</div>
        <div style="display: flex; align-items: baseline; gap: 10px;">
            <span style="font-size: 2.8rem; font-weight: 900; font-family: 'Sakana', sans-serif;">{{ $stats['orders_count'] }}</span>
            <span style="font-size: 0.9rem; font-weight: 700; color: #ffb800;">Processed</span>
        </div>
        <i class='bx bxs-receipt' style="position: absolute; right: -10px; bottom: -10px; font-size: 6rem; opacity: 0.03;"></i>
    </div>
</div>
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 40px;">
    <div>
        <div class="premium-card">
            <h3 style="font-family: 'Sakana', sans-serif; font-size: 1.4rem; margin-bottom: 30px; letter-spacing: -0.5px;">Operational Toolkit</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <a href="{{ route('admin.products.index') }}" class="premium-btn" style="text-decoration: none;">
                    <i class='bx bx-list-check'></i> Inventory Log
                </a>
                <a href="{{ route('admin.categories.index') }}" class="premium-btn premium-btn-outline" style="text-decoration: none;">
                    <i class='bx bx-git-repo-forked'></i> Category Map
                </a>
                <a href="{{ route('admin.orders.index') }}" class="premium-btn premium-btn-outline" style="text-decoration: none; grid-column: span 2;">
                    <i class='bx bx-line-chart'></i> View Detailed Order Analytics
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
