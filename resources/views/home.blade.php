@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Dashboard</h3>
    </div>

    <div class="card-body">
        <h4>Welcome, {{ Auth::user()->name }}!</h4>
        <p>You are logged in!</p>
        
        @if(Auth::user()->role === 'customer')
            <hr style="margin: 2rem 0;">
            <h5>Browse Our Menu</h5>
            <p>Start ordering your favorite food!</p>
            <a href="#" class="btn btn-primary">View Menu</a>
        @endif
    </div>
</div>
@endsection