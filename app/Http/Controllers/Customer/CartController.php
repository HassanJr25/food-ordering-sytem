<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\FoodItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Show cart
    public function index()
    {
        $cartItems = Cart::getCartItems();
        $cartTotal = Cart::getCartTotal();
        
        return view('customer.cart.index', compact('cartItems', 'cartTotal'));
    }

    // Add to cart
    public function add(Request $request, FoodItem $foodItem)
    {
        if (!$foodItem->is_available) {
            return redirect()->back()->with('error', 'This item is currently unavailable.');
        }

        $quantity = $request->input('quantity', 1);

        // Check if item already in cart
        $cartItem = Cart::where('user_id', auth()->id())
            ->where('food_item_id', $foodItem->id)
            ->first();

        if ($cartItem) {
            // Update quantity
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // Create new cart item
            Cart::create([
                'user_id' => auth()->id(),
                'food_item_id' => $foodItem->id,
                'quantity' => $quantity,
                'price' => $foodItem->price,
            ]);
        }

        return redirect()->back()->with('success', 'Item added to cart!');
    }

    // Update cart item quantity
    public function update(Request $request, Cart $cart)
    {
        // Make sure cart belongs to current user
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $cart->quantity = $request->quantity;
        $cart->save();

        return redirect()->route('cart.index')->with('success', 'Cart updated!');
    }

    // Remove from cart
    public function remove(Cart $cart)
    {
        // Make sure cart belongs to current user
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cart->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
    }

    // Clear entire cart
    public function clear()
    {
        Cart::where('user_id', auth()->id())->delete();

        return redirect()->route('cart.index')->with('success', 'Cart cleared!');
    }
}