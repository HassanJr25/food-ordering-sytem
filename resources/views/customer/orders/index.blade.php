@extends('layouts.master')

@section('content')
<div class="container" style="margin-top: 2rem; margin-bottom: 3rem;">
    <div class="card">
        <div class="card-header">
            <h2 style="margin: 0;">📋 My Orders</h2>
        </div>

        <div class="card-body">
            @if($orders->isEmpty())
                <!-- No Orders -->
                <div style="text-align: center; padding: 4rem 2rem;">
                    <div style="font-size: 5rem; margin-bottom: 1rem; opacity: 0.3;">📦</div>
                    <h3 style="color: #666; margin-bottom: 1rem;">No orders yet</h3>
                    <p style="color: #999; margin-bottom: 2rem;">Start ordering your favorite food!</p>
                    <a href="{{ route('menu.index') }}" class="btn btn-success" style="padding: 1rem 2rem; font-size: 1.1rem;">Browse Menu</a>
                </div>
            @else
                <!-- Orders Table -->
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>
                                        <strong style="font-family: monospace; color: #2c3e50;">{{ $order->order_number }}</strong>
                                    </td>
                                    <td>{{ $order->created_at->format('M d, Y') }}<br><span style="color: #999; font-size: 0.85rem;">{{ $order->created_at->format('h:i A') }}</span></td>
                                    <td>{{ $order->orderItems->sum('quantity') }} items</td>
                                    <td><strong style="color: #27ae60; font-size: 1.1rem;">TZS {{ number_format($order->total_amount, 2) }}</strong></td>
                                    <td>
                                        <span style="{{ $order->status_color }} padding: 0.4rem 0.9rem; border-radius: 12px; font-size: 0.9rem;">
                                            {{ $order->status_text }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('orders.show', $order) }}" class="btn btn-primary" style="padding: 0.5rem 1.2rem; font-size: 0.9rem;">View Details</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection