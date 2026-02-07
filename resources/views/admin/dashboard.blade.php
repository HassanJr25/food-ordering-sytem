@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Admin Dashboard</h3>
    </div>

    <div class="card-body">
        <h4>Welcome, {{ Auth::user()->name }}!</h4>
        <p>You are logged in as an Administrator.</p>
        
        <hr style="margin: 2rem 0; border: none; border-top: 1px solid #ddd;">
        
        <div class="row">
            <div class="col-4">
                <div class="dashboard-card primary">
                    <div>
                        <h3>Manage Categories</h3>
                        <p>Add, edit, or delete food categories.</p>
                    </div>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary" style="background: rgba(255,255,255,0.2);">Go to Categories</a>
                </div>
            </div>
            
            <div class="col-4">
    <div class="dashboard-card success">
        <div>
            <h3>Manage Food Items</h3>
            <p>Add, edit, or delete food items.</p>
        </div>
        <a href="{{ route('admin.food-items.index') }}" class="btn btn-success" style="background: rgba(255,255,255,0.2);">Go to Food Items</a>
    </div>
</div>
            
            <div class="col-4">
                <div class="dashboard-card warning">
                    <div>
                        <h3>Manage Orders</h3>
                        <p>View and manage customer orders.</p>
                    </div>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-warning" style="background: rgba(255,255,255,0.2);">Go to Orders</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection