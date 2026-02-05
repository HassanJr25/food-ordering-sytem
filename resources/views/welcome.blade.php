@extends('layouts.master')

@section('content')
<div style="text-align: center; margin-top: 3rem;">
    <div class="card" style="max-width: 800px; margin: 0 auto; padding: 3rem;">
        <h1 style="color: #2c3e50; margin-bottom: 1rem; font-size: 2.5rem;">🍕 Food Ordering System</h1>
        <p style="color: #666; font-size: 1.2rem; margin-bottom: 2rem;">Order your favorite food online. Fast, easy, and delicious!</p>
        
        <div style="display: flex; gap: 1rem; justify-content: center; margin-bottom: 2rem;">
            <a href="{{ route('menu.index') }}" class="btn btn-success" style="padding: 1rem 2rem; font-size: 1.1rem;">View Menu</a>
            @guest
                <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 1rem 2rem; font-size: 1.1rem;">Get Started</a>
            @else
                @if(Auth::user()->role === 'admin')
                    <a href="/admin/dashboard" class="btn btn-warning" style="padding: 1rem 2rem; font-size: 1.1rem;">Admin Dashboard</a>
                @else
                    <a href="{{ route('home') }}" class="btn btn-primary" style="padding: 1rem 2rem; font-size: 1.1rem;">My Orders</a>
                @endif
            @endguest
        </div>
        
        <div style="background: #f8f9fa; padding: 2rem; border-radius: 8px; margin-top: 2rem;">
            <h3 style="color: #2c3e50; margin-bottom: 1rem;">Why Choose Us?</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; text-align: left;">
                <div>
                    <h4 style="color: #27ae60; margin-bottom: 0.5rem;">🚀 Fast Delivery</h4>
                    <p style="color: #666; font-size: 0.9rem;">Get your food delivered hot and fresh in no time</p>
                </div>
                <div>
                    <h4 style="color: #3498db; margin-bottom: 0.5rem;">🍔 Quality Food</h4>
                    <p style="color: #666; font-size: 0.9rem;">Made with fresh ingredients and love</p>
                </div>
                <div>
                    <h4 style="color: #e67e22; margin-bottom: 0.5rem;">💳 Easy Payment</h4>
                    <p style="color: #666; font-size: 0.9rem;">Multiple payment options available</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection