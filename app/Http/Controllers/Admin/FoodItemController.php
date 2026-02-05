<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FoodItem;
use App\Models\Category;
use Illuminate\Http\Request;

class FoodItemController extends Controller
{
    // List all food items
    public function index()
    {
        $foodItems = FoodItem::with('category')->latest()->get();
        return view('admin.food-items.index', compact('foodItems'));
    }

    // Show create form
    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.food-items.create', compact('categories'));
    }

    // Store new food item
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255|unique:food_items',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => FoodItem::generateSlug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'is_available' => $request->has('is_available') ? true : false,
            'is_featured' => $request->has('is_featured') ? true : false,
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/food-items'), $imageName);
            $data['image'] = 'images/food-items/' . $imageName;
        }

        FoodItem::create($data);

        return redirect()->route('admin.food-items.index')
            ->with('success', 'Food item created successfully!');
    }

    // Show edit form
    public function edit(FoodItem $foodItem)
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.food-items.edit', compact('foodItem', 'categories'));
    }

    // Update food item
    public function update(Request $request, FoodItem $foodItem)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255|unique:food_items,name,' . $foodItem->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => FoodItem::generateSlug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'is_available' => $request->has('is_available') ? true : false,
            'is_featured' => $request->has('is_featured') ? true : false,
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($foodItem->image && file_exists(public_path($foodItem->image))) {
                unlink(public_path($foodItem->image));
            }
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/food-items'), $imageName);
            $data['image'] = 'images/food-items/' . $imageName;
        }

        // Remove image if checkbox checked
        if ($request->has('remove_image')) {
            if ($foodItem->image && file_exists(public_path($foodItem->image))) {
                unlink(public_path($foodItem->image));
            }
            $data['image'] = null;
        }

        $foodItem->update($data);

        return redirect()->route('admin.food-items.index')
            ->with('success', 'Food item updated successfully!');
    }

    // Delete food item
    public function destroy(FoodItem $foodItem)
    {
        // Delete image if exists
        if ($foodItem->image && file_exists(public_path($foodItem->image))) {
            unlink(public_path($foodItem->image));
        }

        $foodItem->delete();

        return redirect()->route('admin.food-items.index')
            ->with('success', 'Food item deleted successfully!');
    }
}