@extends('layouts.master')

@section('content')
<div style="text-align: center; margin-top: 3rem; margin-bottom: 3rem;">
    <!-- Hero Section -->
    <div class="card" style="max-width: 900px; margin: 0 auto; padding: 4rem 3rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff;">
        <h1 style="color: #fff; margin-bottom: 1rem; font-size: 3rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.2);">🍕 Food Ordering System</h1>
        <p style="color: rgba(255,255,255,0.95); font-size: 1.3rem; margin-bottom: 2.5rem; line-height: 1.6;">Order your favorite food online. Fast, easy, and delicious!</p>
        
        <div style="display: flex; gap: 1rem; justify-content: center; margin-bottom: 2rem;">
            <a href="{{ route('menu.index') }}" class="btn btn-success" style="padding: 1.2rem 2.5rem; font-size: 1.2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">🍽️ View Menu</a>
            @guest
                <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 1.2rem 2.5rem; font-size: 1.2rem; background: rgba(255,255,255,0.2); border: 2px solid #fff; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">Get Started</a>
            @else
                @if(Auth::user()->role === 'admin')
                    <a href="/admin/dashboard" class="btn btn-warning" style="padding: 1.2rem 2.5rem; font-size: 1.2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">Admin Dashboard</a>
                @else
                    <a href="{{ route('home') }}" class="btn btn-primary" style="padding: 1.2rem 2.5rem; font-size: 1.2rem; background: rgba(255,255,255,0.2); border: 2px solid #fff; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">My Dashboard</a>
                @endif
            @endguest
        </div>
        
        <!-- Statistics -->
        <div style="display: flex; justify-content: center; gap: 3rem; margin-top: 3rem; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.3);">
            <div>
                <h3 style="color: #fff; font-size: 2.5rem; margin: 0;">{{ \App\Models\FoodItem::count() }}+</h3>
                <p style="color: rgba(255,255,255,0.9); margin: 0.5rem 0 0 0;">Food Items</p>
            </div>
            <div>
                <h3 style="color: #fff; font-size: 2.5rem; margin: 0;">{{ \App\Models\Category::count() }}+</h3>
                <p style="color: rgba(255,255,255,0.9); margin: 0.5rem 0 0 0;">Categories</p>
            </div>
            <div>
                <h3 style="color: #fff; font-size: 2.5rem; margin: 0;">{{ \App\Models\Order::count() }}+</h3>
                <p style="color: rgba(255,255,255,0.9); margin: 0.5rem 0 0 0;">Orders Served</p>
            </div>
        </div>
    </div>
    
    <!-- Features Section -->
    <div style="max-width: 1200px; margin: 4rem auto;">
        <h2 style="color: #2c3e50; margin-bottom: 2rem; font-size: 2rem;">Why Choose Us?</h2>
        <div class="row">
            <div class="col-4">
                <div class="card" style="padding: 2rem; text-align: center; height: 100%;">
                    <div style="font-size: 4rem; margin-bottom: 1rem;">🚀</div>
                    <h3 style="color: #27ae60; margin-bottom: 1rem;">Fast Delivery</h3>
                    <p style="color: #666; line-height: 1.6;">Get your food delivered hot and fresh in 30-45 minutes</p>
                </div>
            </div>
            <div class="col-4">
                <div class="card" style="padding: 2rem; text-align: center; height: 100%;">
                    <div style="font-size: 4rem; margin-bottom: 1rem;">🍔</div>
                    <h3 style="color: #3498db; margin-bottom: 1rem;">Quality Food</h3>
                    <p style="color: #666; line-height: 1.6;">Made with fresh ingredients and prepared with love</p>
                </div>
            </div>
            <div class="col-4">
                <div class="card" style="padding: 2rem; text-align: center; height: 100%;">
                    <div style="font-size: 4rem; margin-bottom: 1rem;">💳</div>
                    <h3 style="color: #e67e22; margin-bottom: 1rem;">Easy Payment</h3>
                    <p style="color: #666; line-height: 1.6;">Cash on delivery for your convenience</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection