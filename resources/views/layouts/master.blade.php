<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Food Ordering System') }}</title>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header>
    <nav class="container">
        <div class="logo">🍕 Food Ordering System</div>
        <ul>
            @guest
                <li><a href="/">Home</a></li>
                <li><a href="{{ route('menu.index') }}">Menu</a></li>
                <li><a href="/login">Login</a></li>
                <li><a href="/register">Register</a></li>
            @else
                <li><a href="/">Home</a></li>
                <li><a href="{{ route('menu.index') }}">Menu</a></li>
                <li>
    <a href="{{ route('cart.index') }}" style="position: relative;">
        🛒 Cart
        @auth
            @php
                $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
            @endphp
            @if($cartCount > 0)
                <span style="position: absolute; top: -8px; right: -10px; background: #e74c3c; color: #fff; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: bold;">{{ $cartCount }}</span>
            @endif
        @endauth
    </a>
</li>
                <li><a href="{{ route('orders.index') }}">📋 My Orders</a></li>
                <li><a href="/home">Dashboard</a></li>
                @if(Auth::user()->role === 'admin')
                    <li><a href="/admin/dashboard">Admin Panel</a></li>
                @endif
                <li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: #fff; cursor: pointer; font-size: 1rem; padding: 0.5rem 0; transition: color 0.3s;" onmouseover="this.style.color='#3498db'" onmouseout="this.style.color='#fff'">
                            Logout ({{ Auth::user()->name }})
                        </button>
                    </form>
                </li>
            @endguest
        </ul>
    </nav>
</header>
    <main class="container" style="margin-top: 2rem;">
        @yield('content')
    </main>

    <!-- Custom JavaScript -->
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
    <!-- Footer -->
    <footer style="background: #2c3e50; color: #fff; padding: 3rem 0; margin-top: 4rem;">
        <div class="container">
            <div class="row">
                <div class="col-4">
                    <h3 style="color: #fff; margin-bottom: 1rem;">🍕 Food Ordering System</h3>
                    <p style="color: rgba(255,255,255,0.8); line-height: 1.6;">
                        Order your favorite food online. Fast, easy, and delicious!
                    </p>
                </div>
                <div class="col-4">
                    <h4 style="color: #fff; margin-bottom: 1rem;">Quick Links</h4>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 0.5rem;">
                            <a href="{{ route('menu.index') }}" style="color: rgba(255,255,255,0.8); text-decoration: none;">Menu</a>
                        </li>
                        @auth
                            <li style="margin-bottom: 0.5rem;">
                                <a href="{{ route('cart.index') }}" style="color: rgba(255,255,255,0.8); text-decoration: none;">Cart</a>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <a href="{{ route('orders.index') }}" style="color: rgba(255,255,255,0.8); text-decoration: none;">My Orders</a>
                            </li>
                        @else
                            <li style="margin-bottom: 0.5rem;">
                                <a href="{{ route('login') }}" style="color: rgba(255,255,255,0.8); text-decoration: none;">Login</a>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <a href="{{ route('register') }}" style="color: rgba(255,255,255,0.8); text-decoration: none;">Register</a>
                            </li>
                        @endauth
                    </ul>
                </div>
                <div class="col-4">
                    <h4 style="color: #fff; margin-bottom: 1rem;">Contact</h4>
                    <p style="color: rgba(255,255,255,0.8); line-height: 1.8;">
                        📧 Email: hassanjunior597@gmail.com<br>
                        📱 Phone: +255 656 487 704<br>
                        📍 Location: Dar es Salaam, Tanzania
                    </p>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.2); margin: 2rem 0;">
            <div style="text-align: center; color: rgba(255,255,255,0.6);">
                <p style="margin: 0;">© {{ date('Y') }} Food Ordering System. Built from scratch with Laravel & Pure HTML/CSS/JS. No frameworks! 🚀</p>
            </div>
        </div>
    </footer>

    <!-- Custom JavaScript -->
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</body>
</html>