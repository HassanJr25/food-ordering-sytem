<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\FoodItem;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
        $user = auth()->user();

        // Customer Dashboard
        if ($user->role === 'customer') {
            $recentOrders = Order::where('user_id', $user->id)
                ->with('orderItems')
                ->latest()
                ->limit(5)
                ->get();

            $totalOrders = Order::where('user_id', $user->id)->count();
            $totalSpent = Order::where('user_id', $user->id)->sum('total_amount');
            $pendingOrders = Order::where('user_id', $user->id)
                ->where('status', 'pending')
                ->count();

            $featuredItems = FoodItem::where('is_featured', true)
                ->where('is_available', true)
                ->limit(3)
                ->get();

            return view('home', compact('recentOrders', 'totalOrders', 'totalSpent', 'pendingOrders', 'featuredItems'));
        }

        // Admin redirect
        return redirect('/admin/dashboard');
    }
}