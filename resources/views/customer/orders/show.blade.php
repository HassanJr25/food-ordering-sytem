@extends('layouts.master')

@section('content')
<div class="container" style="margin-top: 2rem; margin-bottom: 3rem;">
    <!-- Back Button -->
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('orders.index') }}" style="color: #3498db; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
            ← Back to My Orders
        </a>
    </div>

    <div class="row">
        <!-- Order Info (Left) -->
        <div class="col-6">
            <div class="card">
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
                        <label style="color: #999; font-size: 0.9rem; display: block; margin-bottom: 0.3rem;">Status</label>
                        <span style="{{ $order->status_color }} padding: 0.5rem 1rem; border-radius: 12px; display: inline-block;">
                            {{ $order->status_text }}
                        </span>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="color: #999; font-size: 0.9rem; display: block; margin-bottom: 0.3rem;">Delivery Address</label>
                        <p style="color: #2c3e50; margin: 0;">{{ $order->delivery_address }}</p>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="color: #999; font-size: 0.9rem; display: block; margin-bottom: 0.3rem;">Phone Number</label>
                        <strong style="color: #2c3e50;">{{ $order->phone_number }}</strong>
                    </div>

                    @if($order->notes)
                        <div>
                            <label style="color: #999; font-size: 0.9rem; display: block; margin-bottom: 0.3rem;">Order Notes</label>
                            <p style="color: #2c3e50; margin: 0; font-style: italic;">{{ $order->notes }}</p>
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
                                <img src="{{ asset($item->foodItem->image) }}" alt="{{ $item->foodItem->name }}" style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px;">
                            @else
                                <div style="width: 70px; height: 70px; background: #667eea; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 2rem;">🍽️</div>
                            @endif
                            <div style="flex: 1;">
                                <strong style="display: block; color: #2c3e50; margin-bottom: 0.3rem;">{{ $item->foodItem->name }}</strong>
                                <span style="color: #999; font-size: 0.9rem;">{{ $item->foodItem->category->name }}</span><br>
                                <span style="color: #666; font-size: 0.9rem;">{{ $item->quantity }} × TZS {{ number_format($item->price, 2) }}</span>
                            </div>
                            <strong style="color: #27ae60; font-size: 1.1rem;">TZS {{ number_format($item->subtotal, 2) }}</strong>
                        </div>
                    @endforeach

                    <!-- Total -->
                    <div style="padding: 1.5rem 0; margin-top: 1rem; border-top: 2px solid #2c3e50;">
                        <div style="display: flex; justify-content: space-between; font-size: 1.4rem;">
                            <strong style="color: #2c3e50;">Total Amount:</strong>
                            <strong style="color: #27ae60;">TZS {{ number_format($order->total_amount, 2) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection