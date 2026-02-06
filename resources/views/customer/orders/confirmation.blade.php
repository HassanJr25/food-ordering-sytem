@extends('layouts.master')

@section('content')
<div class="container" style="margin-top: 2rem; margin-bottom: 3rem;">
    <div class="card" style="max-width: 700px; margin: 0 auto; text-align: center;">
        <div class="card-body" style="padding: 3rem;">
            <!-- Success Icon -->
            <div style="font-size: 5rem; margin-bottom: 1rem; color: #27ae60;">✅</div>
            
            <h1 style="color: #2c3e50; margin-bottom: 0.5rem;">Order Placed Successfully!</h1>
            <p style="color: #666; font-size: 1.1rem; margin-bottom: 2rem;">Thank you for your order. We'll prepare it right away!</p>

            <!-- Order Number -->
            <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
                <p style="color: #999; margin-bottom: 0.5rem; font-size: 0.9rem;">Your Order Number</p>
                <h2 style="color: #2c3e50; margin: 0; font-family: monospace;">{{ $order->order_number }}</h2>
            </div>

            <!-- Order Details -->
            <div style="text-align: left; background: #fff; padding: 1.5rem; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 2rem;">
                <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid #eee;">
                    <span style="color: #666;">Order Date:</span>
                    <strong style="color: #2c3e50;">{{ $order->created_at->format('M d, Y - h:i A') }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid #eee;">
                    <span style="color: #666;">Total Amount:</span>
                    <strong style="color: #27ae60; font-size: 1.2rem;">TZS {{ number_format($order->total_amount, 2) }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid #eee;">
                    <span style="color: #666;">Status:</span>
                    <span style="{{ $order->status_color }} padding: 0.3rem 0.75rem; border-radius: 12px; font-size: 0.9rem;">{{ $order->status_text }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 0.5rem 0;">
                    <span style="color: #666;">Delivery Address:</span>
                    <strong style="color: #2c3e50; text-align: right; max-width: 60%;">{{ $order->delivery_address }}</strong>
                </div>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 1rem; justify-content: center;">
                <a href="{{ route('orders.show', $order) }}" class="btn btn-primary" style="padding: 1rem 2rem;">View Order Details</a>
                <a href="{{ route('menu.index') }}" class="btn btn-success" style="padding: 1rem 2rem;">Continue Shopping</a>
            </div>
        </div>
    </div>
</div>
@endsection