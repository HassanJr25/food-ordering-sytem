<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FoodItem;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // Show all food items
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)->get();
        
        $query = FoodItem::where('is_available', true)->with('category');
        
        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }
        
        // Search by name
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        // Get featured items separately
        $featuredItems = FoodItem::where('is_available', true)
            ->where('is_featured', true)
            ->with('category')
            ->limit(6)
            ->get();
        
        $foodItems = $query->latest()->get();
        
        return view('customer.menu.index', compact('foodItems', 'categories', 'featuredItems'));
    }
    
    // Show single food item details
    public function show(FoodItem $foodItem)
    {
        if (!$foodItem->is_available) {
            abort(404);
        }
        
        // Get related items from same category
        $relatedItems = FoodItem::where('category_id', $foodItem->category_id)
            ->where('id', '!=', $foodItem->id)
            ->where('is_available', true)
            ->limit(4)
            ->get();
        
        return view('customer.menu.show', compact('foodItem', 'relatedItems'));
    }
}