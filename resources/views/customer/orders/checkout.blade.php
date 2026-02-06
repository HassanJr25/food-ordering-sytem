@extends('layouts.master')

@section('content')
<div class="container" style="margin-top: 2rem; margin-bottom: 3rem;">
    <div class="row">
        <!-- Order Summary (Left Column) -->
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h3>Order Summary</h3>
                </div>
                <div class="card-body">
                    @foreach($cartItems as $item)
                        <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem 0; border-bottom: 1px solid #eee;">
                            @if($item->foodItem->image)
                                <img src="{{ asset($item->foodItem->image) }}" alt="{{ $item->foodItem->name }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px;">
                            @else
                                <div style="width: 60px; height: 60px; background: #667eea; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #fff;">🍽️</div>
                            @endif
                            <div style="flex: 1;">
                                <strong style="display: block; color: #2c3e50;">{{ $item->foodItem->name }}</strong>
                                <span style="color: #999; font-size: 0.9rem;">Qty: {{ $item->quantity }} × TZS {{ number_format($item->price, 2) }}</span>
                            </div>
                            <strong style="color: #27ae60;">TZS {{ number_format($item->subtotal, 2) }}</strong>
                        </div>
                    @endforeach

                    <!-- Total -->
                    <div style="padding: 1.5rem 0; border-top: 2px solid #2c3e50; margin-top: 1rem;">
                        <div style="display: flex; justify-content: space-between; font-size: 1.3rem;">
                            <strong style="color: #2c3e50;">Total Amount:</strong>
                            <strong style="color: #27ae60;">TZS {{ number_format($cartTotal, 2) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delivery Details Form (Right Column) -->
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h3>Delivery Details</h3>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-error">
                            <strong>Please fix the following errors:</strong>
                            <ul style="margin-top: 0.5rem; padding-left: 1.5rem;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('orders.place') }}">
                        @csrf

                        <!-- Delivery Address -->
                        <div class="form-group">
                            <label for="delivery_address">Delivery Address <span style="color: #e74c3c;">*</span></label>
                            <textarea id="delivery_address" name="delivery_address" rows="3" required placeholder="Enter your full delivery address...">{{ old('delivery_address') }}</textarea>
                            <span style="color: #999; font-size: 0.85rem;">Please provide a detailed address including street, building, and landmarks</span>
                        </div>

                        <!-- Phone Number -->
                        <div class="form-group">
                            <label for="phone_number">Phone Number <span style="color: #e74c3c;">*</span></label>
                            <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required placeholder="+255 XXX XXX XXX">
                            <span style="color: #999; font-size: 0.85rem;">We'll call you if we can't find your location</span>
                        </div>

                        <!-- Order Notes -->
                        <div class="form-group">
                            <label for="notes">Order Notes (Optional)</label>
                            <textarea id="notes" name="notes" rows="2" placeholder="Any special instructions? (e.g., extra spicy, no onions, etc.)">{{ old('notes') }}</textarea>
                        </div>

                        <!-- Terms -->
                        <div style="background: #f8f9fa; padding: 1rem; border-radius: 6px; margin-bottom: 1.5rem;">
                            <p style="color: #666; font-size: 0.9rem; margin: 0;">
                                📦 <strong>Delivery Time:</strong> 30-45 minutes<br>
                                💵 <strong>Payment:</strong> Cash on Delivery<br>
                                🚚 <strong>Delivery Fee:</strong> Included in price
                            </p>
                        </div>

                        <!-- Action Buttons -->
                        <div style="display: flex; gap: 1rem;">
                            <a href="{{ route('cart.index') }}" class="btn btn-primary" style="flex: 1; text-align: center;">← Back to Cart</a>
                            <button type="submit" class="btn btn-success" style="flex: 2;">Place Order (TZS {{ number_format($cartTotal, 2) }})</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection