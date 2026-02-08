@extends('layouts.master')

@section('content')
<div style="padding: 2rem 0;">
    <div class="container">
        <h1 style="color: #2c3e50; margin-bottom: 2rem;">Admin Dashboard</h1>
        <hr style="border: 1px solid #3498db; margin-bottom: 2rem;">

        <h2 style="color: #2c3e50; margin-bottom: 1rem;">Welcome, Admin!</h2>
        <p style="color: #666; margin-bottom: 3rem;">You are logged in as an Administrator.</p>

        <!-- Statistics Cards -->
        <div class="row" style="margin-bottom: 3rem;">
            <div class="col-4">
                <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 2rem;">
                    <h3 style="font-size: 2.5rem; margin: 0 0 0.5rem 0;">{{ \App\Models\Category::count() }}</h3>
                    <p style="margin: 0; opacity: 0.9;">Total Categories</p>
                </div>
            </div>
            <div class="col-4">
                <div class="card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: #fff; padding: 2rem;">
                    <h3 style="font-size: 2.5rem; margin: 0 0 0.5rem 0;">{{ \App\Models\FoodItem::count() }}</h3>
                    <p style="margin: 0; opacity: 0.9;">Total Food Items</p>
                </div>
            </div>
            <div class="col-4">
                <div class="card" style="background: linear-gradient(135deg, #30cfd0 0%, #330867 100%); color: #fff; padding: 2rem;">
                    <h3 style="font-size: 2.5rem; margin: 0 0 0.5rem 0;">{{ \App\Models\Order::count() }}</h3>
                    <p style="margin: 0; opacity: 0.9;">Total Orders</p>
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom: 3rem;">
            <div class="col-4">
                <div class="card" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); color: #2c3e50; padding: 2rem;">
                    <h3 style="font-size: 2.5rem; margin: 0 0 0.5rem 0;">{{ \App\Models\User::where('role', 'customer')->count() }}</h3>
                    <p style="margin: 0; opacity: 0.9;">Total Customers</p>
                </div>
            </div>
            <div class="col-4">
                <div class="card" style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%); color: #2c3e50; padding: 2rem;">
                    <h3 style="font-size: 2.5rem; margin: 0 0 0.5rem 0;">{{ \App\Models\Order::where('status', 'pending')->count() }}</h3>
                    <p style="margin: 0; opacity: 0.9;">Pending Orders</p>
                </div>
            </div>
            <div class="col-4">
                <div class="card" style="background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%); color: #2c3e50; padding: 2rem;">
                    <h3 style="font-size: 1.8rem; margin: 0 0 0.5rem 0;">TZS {{ number_format(\App\Models\Order::sum('total_amount'), 2) }}</h3>
                    <p style="margin: 0; opacity: 0.9;">Total Revenue</p>
                </div>
            </div>
        </div>

        <!-- Management Cards -->
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