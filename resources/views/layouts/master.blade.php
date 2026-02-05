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
</body>
</html>