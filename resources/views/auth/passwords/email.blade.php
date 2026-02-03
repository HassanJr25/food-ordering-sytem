@extends('layouts.master')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h2>Reset Password</h2>
        <p style="text-align: center; color: #666; margin-bottom: 1.5rem;">Enter your email and we'll send a reset link.</p>
        
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Send Reset Link</button>
            </div>

            <div style="text-align: center; margin-top: 1rem;">
                <a href="{{ route('login') }}">Back to Login</a>
            </div>
        </form>
    </div>
</div>
@endsection