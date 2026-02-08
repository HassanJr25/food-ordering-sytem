@extends('layouts.master')

@section('content')
<div class="container" style="margin-top: 2rem; margin-bottom: 3rem;">
    <h2 style="color: #2c3e50; margin-bottom: 2rem;">👋 Welcome back, {{ Auth::user()->name }}!</h2>

    <!-- Statistics Cards -->
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-4">
            <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 2rem;">
                <h3 style="font-size: 2.5rem; margin: 0 0 0.5rem 0;">{{ $totalOrders }}</h3>
                <p style="margin: 0; opacity: 0.9;">Total Orders</p>
            </div>
        </div>
        <div class="col-4">
            <div class="card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: #fff; padding: 2rem;">
                <h3 style="font-size: 2.5rem; margin: 0 0 0.5rem 0;">{{ $pendingOrders }}</h3>
                <p style="margin: 0; opacity: 0.9;">Pending Orders</p>
            </div>
        </div>
        <div class="col-4">
            <div class="card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: #fff; padding: 2rem;">
                <h3 style="font-size: 1.8rem; margin: 0 0 0.5rem 0;">TZS {{ number_format($totalSpent, 2) }}</h3>
                <p style="margin: 0; opacity: 0.9;">Total Spent</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card" style="margin-bottom: 2rem;">
        <div class="card-header">
            <h3>Quick Actions</h3>
        </div>
        <div class="card-body">
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="{{ route('menu.index') }}" class="btn btn-success" style="padding: 1rem 2rem;">🍕 Browse Menu</a>
                <a href="{{ route('cart.index') }}" class="btn btn-primary" style="padding: 1rem 2rem;">🛒 View Cart</a>
                <a href="{{ route('orders.index') }}" class="btn btn-warning" style="padding: 1rem 2rem;">📋 My Orders</a>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="card" style="margin-bottom: 2rem;">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3>Recent Orders</h3>
            <a href="{{ route('orders.index') }}" style="color: #3498db; text-decoration: none;">View All →</a>
        </div>
        <div class="card-body">
            @if($recentOrders->isEmpty())
                <div style="text-align: center; padding: 3rem;">
                    <div style="font-size: 4rem; margin-bottom: 1rem; opacity: 0.3;">📦</div>
                    <p style="color: #666; margin-bottom: 1rem;">No orders yet</p>
                    <a href="{{ route('menu.index') }}" class="btn btn-success">Start Ordering</a>
                </div>
            @else
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
                            @foreach($recentOrders as $order)
                                <tr>
                                    <td><strong style="font-family: monospace;">{{ $order->order_number }}</strong></td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                    <td>{{ $order->orderItems->sum('quantity') }} items</td>
                                    <td><strong style="color: #27ae60;">TZS {{ number_format($order->total_amount, 2) }}</strong></td>
                                    <td>
                                        <span style="{{ $order->status_color }} padding: 0.4rem 0.8rem; border-radius: 12px; font-size: 0.85rem;">
                                            {{ $order->status_text }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('orders.show', $order) }}" class="btn btn-primary" style="padding: 0.4rem 1rem; font-size: 0.85rem;">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Featured Items -->
    @if($featuredItems->isNotEmpty())
        <div class="card">
            <div class="card-header">
                <h3>⭐ Featured Items</h3>
            </div>
            <div class="card-body">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                    @foreach($featuredItems as $item)
                        <div class="card" style="overflow: hidden;">
                            <a href="{{ route('menu.show', $item) }}" style="text-decoration: none; color: inherit;">
                                @if($item->image)
                                    <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" style="width: 100%; height: 180px; object-fit: cover;">
                                @else
                                    <div style="width: 100%; height: 180px; background: #667eea; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 3rem;">🍽️</div>
                                @endif
                                <div style="padding: 1.25rem;">
                                    <h4 style="color: #2c3e50; margin: 0 0 0.5rem 0;">{{ $item->name }}</h4>
                                    <p style="color: #999; font-size: 0.9rem; margin-bottom: 0.75rem;">{{ $item->category->name }}</p>
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <strong style="color: #27ae60; font-size: 1.2rem;">TZS {{ number_format($item->price, 2) }}</strong>
                                        <span class="btn btn-success" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Order Now</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection