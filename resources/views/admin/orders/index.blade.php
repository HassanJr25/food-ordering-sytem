@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>Manage Orders</h3>
    </div>

    <div class="card-body">
        <!-- Success Alert -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Search & Filter Bar -->
        <div class="card" style="margin-bottom: 2rem; padding: 1.5rem; background: #f8f9fa;">
            <form method="GET" action="{{ route('admin.orders.index') }}" style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <!-- Search Input -->
                <div style="flex: 1; min-width: 250px;">
                    <input type="text" name="search" placeholder="Search by order number or customer name..." value="{{ request('search') }}" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #ddd; border-radius: 6px;">
                </div>
                
                <!-- Status Filter -->
                <div style="min-width: 200px;">
                    <select name="status" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #ddd; border-radius: 6px;">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="preparing" {{ request('status') == 'preparing' ? 'selected' : '' }}>Preparing</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                
                <!-- Search Button -->
                <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem;">Filter</button>
                
                @if(request('search') || request('status'))
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-danger" style="padding: 0.75rem 1.5rem;">Clear</a>
                @endif
            </form>
        </div>

        @if($orders->isEmpty())
            <!-- No Orders -->
            <div style="text-align: center; padding: 4rem 2rem;">
                <div style="font-size: 5rem; margin-bottom: 1rem; opacity: 0.3;">📦</div>
                <h3 style="color: #666; margin-bottom: 1rem;">No orders found</h3>
                <p style="color: #999;">Orders will appear here when customers place them.</p>
            </div>
        @else
            <!-- Orders Table -->
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order Number</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th style="text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $index => $order)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong style="font-family: monospace; color: #2c3e50;">{{ $order->order_number }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $order->user->name }}</strong><br>
                                    <span style="color: #999; font-size: 0.85rem;">{{ $order->user->email }}</span>
                                </td>
                                <td>
                                    {{ $order->created_at->format('M d, Y') }}<br>
                                    <span style="color: #999; font-size: 0.85rem;">{{ $order->created_at->format('h:i A') }}</span>
                                </td>
                                <td>{{ $order->orderItems->sum('quantity') }} items</td>
                                <td><strong style="color: #27ae60; font-size: 1.1rem;">TZS {{ number_format($order->total_amount, 2) }}</strong></td>
                                <td>
                                    <span style="{{ $order->status_color }} padding: 0.4rem 0.9rem; border-radius: 12px; font-size: 0.9rem;">
                                        {{ $order->status_text }}
                                    </span>
                                </td>
                                <td style="text-align: center;">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-primary" style="padding: 0.4rem 0.9rem; font-size: 0.85rem;">View Details</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Order Statistics -->
            <div style="margin-top: 2rem; padding: 1.5rem; background: #f8f9fa; border-radius: 8px;">
                <h4 style="color: #2c3e50; margin-bottom: 1rem;">Order Statistics</h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                    <div>
                        <span style="color: #999; font-size: 0.9rem;">Total Orders</span>
                        <h3 style="color: #2c3e50; margin: 0.3rem 0 0 0;">{{ $orders->count() }}</h3>
                    </div>
                    <div>
                        <span style="color: #999; font-size: 0.9rem;">Pending</span>
                        <h3 style="color: #856404; margin: 0.3rem 0 0 0;">{{ $orders->where('status', 'pending')->count() }}</h3>
                    </div>
                    <div>
                        <span style="color: #999; font-size: 0.9rem;">Preparing</span>
                        <h3 style="color: #084298; margin: 0.3rem 0 0 0;">{{ $orders->where('status', 'preparing')->count() }}</h3>
                    </div>
                    <div>
                        <span style="color: #999; font-size: 0.9rem;">Delivered</span>
                        <h3 style="color: #155724; margin: 0.3rem 0 0 0;">{{ $orders->where('status', 'delivered')->count() }}</h3>
                    </div>
                    <div>
                        <span style="color: #999; font-size: 0.9rem;">Total Revenue</span>
                        <h3 style="color: #27ae60; margin: 0.3rem 0 0 0;">TZS {{ number_format($orders->sum('total_amount'), 2) }}</h3>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection