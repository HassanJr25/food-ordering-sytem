@extends('layouts.master')

@section('content')
<div class="container" style="margin-top: 2rem; margin-bottom: 3rem;">
    <!-- Back Button -->
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('menu.index') }}" style="color: #3498db; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
            ← Back to Menu
        </a>
    </div>

    <div class="row">
        <!-- Left Column - Image -->
        <div class="col-6">
            <div class="card" style="padding: 0; overflow: hidden;">
                @if($foodItem->image)
                    <img src="{{ asset($foodItem->image) }}" alt="{{ $foodItem->name }}" style="width: 100%; height: auto; max-height: 500px; object-fit: cover;">
                @else
                    <div style="width: 100%; height: 400px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 5rem;">🍽️</div>
                @endif
            </div>
        </div>

        <!-- Right Column - Details -->
        <div class="col-6">
            <div class="card">
                <!-- Category Badge -->
                <div style="margin-bottom: 1rem;">
                    <span style="background: #e3f2fd; color: #1976d2; padding: 0.4rem 1rem; border-radius: 16px; font-size: 0.9rem;">
                        {{ $foodItem->category->name }}
                    </span>
                    @if($foodItem->is_featured)
                        <span style="background: #fff3cd; color: #856404; padding: 0.4rem 1rem; border-radius: 16px; font-size: 0.9rem; margin-left: 0.5rem;">
                            ⭐ Featured
                        </span>
                    @endif
                </div>

                <!-- Food Name -->
                <h1 style="color: #2c3e50; margin-bottom: 1rem; font-size: 2.5rem;">{{ $foodItem->name }}</h1>

                <!-- Price -->
                <div style="margin-bottom: 1.5rem;">
                    <span style="color: #27ae60; font-size: 2rem; font-weight: bold;">TZS {{ number_format($foodItem->price, 2) }}</span>
                </div>

                <!-- Description -->
                @if($foodItem->description)
                    <div style="margin-bottom: 2rem;">
                        <h3 style="color: #2c3e50; margin-bottom: 0.75rem;">Description</h3>
                        <p style="color: #666; line-height: 1.6;">{{ $foodItem->description }}</p>
                    </div>
                @endif

                <!-- Availability Status -->
                <div style="margin-bottom: 2rem;">
                    @if($foodItem->is_available)
                        <span style="background: #d4edda; color: #155724; padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.95rem;">✓ Available Now</span>
                    @else
                        <span style="background: #f8d7da; color: #721c24; padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.95rem;">✗ Currently Unavailable</span>
                    @endif
                </div>

                <!-- Order Button -->
@auth
    <form method="POST" action="{{ route('cart.add', $foodItem) }}">
        @csrf
        <div style="margin-bottom: 1.5rem;">
            <label for="quantity" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Quantity</label>
            <input type="number" id="quantity" name="quantity" value="1" min="1" max="99" style="width: 100px; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1.1rem;">
        </div>
        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-success" style="flex: 1; padding: 1rem 2rem; font-size: 1.1rem;">🛒 Add to Cart</button>
        </div>
    </form>
@else
                    <div style="background: #fff3cd; padding: 1.5rem; border-radius: 8px; text-align: center;">
                        <p style="color: #856404; margin-bottom: 1rem;">Please login to order this item</p>
                        <div style="display: flex; gap: 1rem; justify-content: center;">
                            <a href="{{ route('login') }}" class="btn btn-primary" style="padding: 0.75rem 2rem;">Login</a>
                            <a href="{{ route('register') }}" class="btn btn-success" style="padding: 0.75rem 2rem;">Register</a>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- Related Items Section -->
    @if($relatedItems->isNotEmpty())
        <div style="margin-top: 4rem;">
            <h2 style="color: #2c3e50; margin-bottom: 1.5rem;">You May Also Like</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1.5rem;">
                @foreach($relatedItems as $item)
                    <div class="card" style="overflow: hidden; transition: transform 0.3s, box-shadow 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.1)'">
                        <a href="{{ route('menu.show', $item) }}" style="text-decoration: none; color: inherit;">
                            @if($item->image)
                                <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" style="width: 100%; height: 180px; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 180px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 2.5rem;">🍽️</div>
                            @endif
                            
                            <div style="padding: 1.25rem;">
                                <h3 style="color: #2c3e50; margin: 0 0 0.5rem 0; font-size: 1.1rem;">{{ $item->name }}</h3>
                                <p style="color: #27ae60; font-size: 1.2rem; font-weight: bold; margin: 0;">TZS {{ number_format($item->price, 2) }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection