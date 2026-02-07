@extends('layouts.master')

@section('content')
<div class="container" style="margin-top: 2rem; margin-bottom: 3rem;">
    <!-- Back Button -->
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('admin.orders.index') }}" style="color: #3498db; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
            ← Back to Orders
        </a>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <!-- Order Info & Customer Details (Left) -->
        <div class="col-6">
            <!-- Order Information -->
            <div class="card" style="margin-bottom: 1.5rem;">
                <div class="card-header">
                    <h3>Order Information</h3>
                </div>
                <div class="card-body">
                    <div style="margin-bottom: 1.5rem;">
                        <label style="color: #999; font-size: 0.9rem; display: block; margin-bottom: 0.3rem;">Order Number</label>
                        <strong style="font-size: 1.2rem; font-family: monospace; color: #2c3e50;">{{ $order->order_number }}</strong>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="color: #999; font-size: 0.9rem; display: block; margin-bottom: 0.3rem;">Order Date</label>
                        <strong style="color: #2c3e50;">{{ $order->created_at->format('M d, Y - h:i A') }}</strong>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="color: #999; font-size: 0.9rem; display: block; margin-bottom: 0.3rem;">Current Status</label>
                        <span style="{{ $order->status_color }} padding: 0.5rem 1rem; border-radius: 12px; display: inline-block;">
                            {{ $order->status_text }}
                        </span>
                    </div>

                    <!-- Update Status Form -->
                    <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px;">
                        <h4 style="color: #2c3e50; margin-bottom: 1rem;">Update Order Status</h4>
                        <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group">
                                <select name="status" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px; margin-bottom: 1rem;">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                    <option value="preparing" {{ $order->status == 'preparing' ? 'selected' : '' }}>👨‍🍳 Preparing</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>✅ Delivered</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-success" style="width: 100%;">Update Status</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Customer Details -->
            <div class="card">
                <div class="card-header">
                    <h3>Customer Details</h3>
                </div>
                <div class="card-body">
                    <div style="margin-bottom: 1.5rem;">
                        <label style="color: #999; font-size: 0.9rem; display: block; margin-bottom: 0.3rem;">Customer Name</label>
                        <strong style="color: #2c3e50;">{{ $order->user->name }}</strong>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="color: #999; font-size: 0.9rem; display: block; margin-bottom: 0.3rem;">Email</label>
                        <a href="mailto:{{ $order->user->email }}" style="color: #3498db;">{{ $order->user->email }}</a>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="color: #999; font-size: 0.9rem; display: block; margin-bottom: 0.3rem;">Phone Number</label>
                        <a href="tel:{{ $order->phone_number }}" style="color: #3498db;">{{ $order->phone_number }}</a>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="color: #999; font-size: 0.9rem; display: block; margin-bottom: 0.3rem;">Delivery Address</label>
                        <p style="color: #2c3e50; margin: 0;">{{ $order->delivery_address }}</p>
                    </div>

                    @if($order->notes)
                        <div>
                            <label style="color: #999; font-size: 0.9rem; display: block; margin-bottom: 0.3rem;">Order Notes</label>
                            <p style="color: #2c3e50; margin: 0; padding: 0.75rem; background: #fff3cd; border-radius: 6px; font-style: italic;">
                                💬 "{{ $order->notes }}"
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Order Items (Right) -->
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h3>Order Items</h3>
                </div>
                <div class="card-body">
                    @foreach($order->orderItems as $item)
                        <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem 0; border-bottom: 1px solid #eee;">
                            @if($item->foodItem->image)
                                <img src="{{ asset($item->foodItem->image) }}" alt="{{ $item->foodItem->name }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                            @else
                                <div style="width: 80px; height: 80px; background: #667eea; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 2.5rem;">🍽️</div>
                            @endif
                            <div style="flex: 1;">
                                <strong style="display: block; color: #2c3e50; margin-bottom: 0.3rem; font-size: 1.1rem;">{{ $item->foodItem->name }}</strong>
                                <span style="color: #999; font-size: 0.9rem;">{{ $item->foodItem->category->name }}</span><br>
                                <span style="color: #666; font-size: 0.95rem; margin-top: 0.3rem; display: inline-block;">
                                    Qty: {{ $item->quantity }} × TZS {{ number_format($item->price, 2) }}
                                </span>
                            </div>
                            <strong style="color: #27ae60; font-size: 1.2rem;">TZS {{ number_format($item->subtotal, 2) }}</strong>
                        </div>
                    @endforeach

                    <!-- Total -->
                    <div style="padding: 1.5rem 0; margin-top: 1rem; border-top: 3px solid #2c3e50;">
                        <div style="display: flex; justify-content: space-between; font-size: 1.5rem;">
                            <strong style="color: #2c3e50;">Total Amount:</strong>
                            <strong style="color: #27ae60;">TZS {{ number_format($order->total_amount, 2) }}</strong>
                        </div>
                    </div>

                    <!-- Order Summary Stats -->
                    <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; margin-top: 1.5rem;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div>
                                <span style="color: #999; font-size: 0.9rem;">Total Items</span>
                                <h3 style="color: #2c3e50; margin: 0.3rem 0 0 0;">{{ $order->orderItems->sum('quantity') }}</h3>
                            </div>
                            <div>
                                <span style="color: #999; font-size: 0.9rem;">Payment Method</span>
                                <h4 style="color: #2c3e50; margin: 0.3rem 0 0 0;">Cash on Delivery</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection