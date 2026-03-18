@extends('layouts.admin')
@section('content')
<div class="premium-page-header" style="text-align: left; margin-bottom: 40px;">
    <span class="premium-eyebrow">Transaction Management</span>
    <h1 class="premium-title">Customer Orders</h1>
</div>
<div class="premium-card" style="padding: 0; overflow: hidden;">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: rgba(0,0,0,0.02); border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <th style="padding: 20px; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted);">Order ID</th>
                    <th style="padding: 20px; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted);">Current Status</th>
                    <th style="padding: 20px; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted);">Update Progress</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.05); transition: background 0.2s;" onmouseover="this.style.background='rgba(50, 255, 126, 0.02)'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 20px; font-weight: 700;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <i class='bx bx-shopping-bag' style="color: var(--accent); font-size: 1.2rem;"></i>
                            <span>#{{ $order->Order_ID }}</span>
                        </div>
                    </td>
                    <td style="padding: 20px;">
                        @php
                            $statusColors = [
                                'pending' => ['bg' => 'rgba(255, 184, 0, 0.1)', 'color' => '#ffb800'],
                                'processing' => ['bg' => 'rgba(59, 130, 246, 0.1)', 'color' => '#3b82f6'],
                                'completed' => ['bg' => 'rgba(34, 197, 94, 0.1)', 'color' => '#22c55e']
                            ];
                            $colors = $statusColors[strtolower($order->Order_status)] ?? ['bg' => 'rgba(0,0,0,0.05)', 'color' => 'var(--text-muted)'];
                        @endphp
                        <span style="background: {{ $colors['bg'] }}; color: {{ $colors['color'] }}; padding: 6px 14px; border-radius: 50px; font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">
                            {{ $order->Order_status }}
                        </span>
                    </td>
                    <td style="padding: 20px;">
                        <form action="{{ route('admin.orders.update', $order) }}" method="POST" style="display: flex; gap: 10px; align-items: center;">
                            @csrf
                            @method('PUT')
                            <select name="Order_status" class="premium-input" style="padding: 8px 15px; width: auto; min-width: 150px; font-size: 0.85rem; font-weight: 600;">
                                <option value="pending" @if($order->Order_status=='pending') selected @endif>Set to Pending</option>
                                <option value="processing" @if($order->Order_status=='processing') selected @endif>Start Processing</option>
                                <option value="completed" @if($order->Order_status=='completed') selected @endif>Mark Completed</option>
                            </select>
                            <button type="submit" class="premium-btn" style="padding: 8px 16px; font-size: 0.8rem;">
                                Update
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@if($orders->isEmpty())
<div class="premium-card" style="text-align: center; padding: 60px;">
    <i class='bx bx-receipt' style="font-size: 3rem; color: var(--text-muted); margin-bottom: 20px; display: block;"></i>
    <h3 style="color: var(--text-muted);">The arena is quiet. No orders have been placed yet.</h3>
</div>
@endif
@endsection
