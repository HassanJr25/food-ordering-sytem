@extends('layouts.master')

@section('content')
<div style="text-align: center; margin-top: 5rem;">
    <div class="card" style="max-width: 700px; margin: 0 auto; padding: 3rem;">
        <h1 style="color: #2c3e50; margin-bottom: 1rem; font-size: 2.5rem;">🍕 Food Ordering System</h1>
        <p style="color: #666; font-size: 1.2rem; margin-bottom: 2rem;">Order your favorite food online. Fast, easy, and delicious!</p>
        
        <div style="display: flex; gap: 1rem; justify-content: center;">
            @guest
                <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
                <a href="{{ route('login') }}" class="btn btn-success">Login</a>
            @else
                @if(Auth::user()->role === 'admin')
                    <a href="/admin/dashboard" class="btn btn-primary">Admin Dashboard</a>
                @else
                    <a href="{{ route('home') }}" class="btn btn-primary">Go to Dashboard</a>
                @endif
            @endguest
        </div>
    </div>
</div>
@endsection