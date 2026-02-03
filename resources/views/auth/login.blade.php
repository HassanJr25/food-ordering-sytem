@extends('layouts.master')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h2>Login</h2>
        
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span style="color: #e74c3c; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
                @error('password')
                    <span style="color: #e74c3c; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label style="display: flex; align-items: center; font-weight: normal;">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} style="width: auto; margin-right: 0.5rem;">
                    Remember Me
                </label>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
            </div>

            <div style="text-align: center; margin-top: 1rem;">
                <a href="{{ route('password.request') }}">Forgot Your Password?</a>
            </div>
        </form>
    </div>
</div>
@endsection