@extends('layouts.master')

@section('content')
<div class="container" style="margin-top: 2rem; margin-bottom: 3rem;">
    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="margin: 0;">🛒 Shopping Cart</h2>
            <a href="{{ route('menu.index') }}" class="btn btn-primary">Continue Shopping</a>
        </div>

        <div class="card-body">
            <!-- Success or Error Alert -->
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            @if($cartItems->isEmpty())
                <!-- Empty Cart -->
                <div style="text-align: center; padding: 4rem 2rem;">
                    <div style="font-size: 5rem; margin-bottom: 1rem; opacity: 0.3;">🛒</div>
                    <h3 style="color: #666; margin-bottom: 1rem;">Your cart is empty</h3>
                    <p style="color: #999; margin-bottom: 2rem;">Add some delicious food to get started!</p>
                    <a href="{{ route('menu.index') }}" class="btn btn-success" style="padding: 1rem 2rem; font-size: 1.1rem;">Browse Menu</a>
                </div>
            @else
                <!-- Cart Items -->
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                                <tr>
                                    <!-- Item Details -->
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 1rem;">
                                            @if($item->foodItem->image)
                                                <img src="{{ asset($item->foodItem->image) }}" alt="{{ $item->foodItem->name }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                                            @else
                                                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 2rem;">🍽️</div>
                                            @endif
                                            <div>
                                                <strong style="font-size: 1.1rem; color: #2c3e50;">{{ $item->foodItem->name }}</strong>
                                                <br>
                                                <span style="color: #999; font-size: 0.9rem;">{{ $item->foodItem->category->name }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Price -->
                                    <td>
                                        <strong style="color: #27ae60;">TZS {{ number_format($item->price, 2) }}</strong>
                                    </td>

                                    <!-- Quantity -->
                                    <td>
                                        <form method="POST" action="{{ route('cart.update', $item) }}" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="99" style="width: 70px; padding: 0.5rem; text-align: center; border: 1px solid #ddd; border-radius: 4px;">
                                            <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Update</button>
                                        </form>
                                    </td>

                                    <!-- Subtotal -->
                                    <td>
                                        <strong style="color: #2c3e50; font-size: 1.1rem;">TZS {{ number_format($item->subtotal, 2) }}</strong>
                                    </td>

                                    <!-- Remove Button -->
                                    <td>
                                        <form method="POST" action="{{ route('cart.remove', $item) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.85rem;" onclick="return confirm('Remove this item from cart?')">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Cart Summary -->
                <div style="margin-top: 2rem; display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap; gap: 2rem;">
                    <!-- Clear Cart Button -->
                    <div>
                        <form method="POST" action="{{ route('cart.clear') }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Clear entire cart?')">Clear Cart</button>
                        </form>
                    </div>

                    <!-- Total & Checkout -->
                    <div style="min-width: 350px;">
                        <div class="card" style="background: #f8f9fa; padding: 1.5rem;">
                            <h3 style="color: #2c3e50; margin-bottom: 1rem;">Cart Summary</h3>
                            
                            <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid #ddd;">
                                <span style="color: #666;">Items ({{ $cartItems->sum('quantity') }})</span>
                                <span style="color: #666;">TZS {{ number_format($cartTotal, 2) }}</span>
                            </div>
                            
                            <div style="display: flex; justify-content: space-between; margin-bottom: 1.5rem; font-size: 1.3rem;">
                                <strong style="color: #2c3e50;">Total:</strong>
                                <strong style="color: #27ae60;">TZS {{ number_format($cartTotal, 2) }}</strong>
                            </div>

                            <a href="#" class="btn btn-success" style="width: 100%; padding: 1rem; font-size: 1.1rem; text-align: center;">Proceed to Checkout</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection