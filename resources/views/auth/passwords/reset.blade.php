@extends('layouts.master')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h2>Reset Password</h2>
        
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label for="email">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">New Password</label>
                <input id="password" type="password" name="password" required>
                @error('password')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password-confirm">Confirm New Password</label>
                <input id="password-confirm" type="password" name="password_confirmation" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
            </div>

            <div style="text-align: center; margin-top: 1rem;">
                <a href="{{ route('login') }}">Back to Login</a>
            </div>
        </form>
    </div>
</div>
@endsection