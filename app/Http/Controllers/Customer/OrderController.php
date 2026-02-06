<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Show checkout page
    public function checkout()
    {
        $cartItems = Cart::getCartItems();
        $cartTotal = Cart::getCartTotal();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        return view('customer.orders.checkout', compact('cartItems', 'cartTotal'));
    }

    // Place order
    public function placeOrder(Request $request)
    {
        $request->validate([
            'delivery_address' => 'required|string|max:500',
            'phone_number' => 'required|string|max:20',
            'notes' => 'nullable|string|max:500',
        ]);

        $cartItems = Cart::getCartItems();
        $cartTotal = Cart::getCartTotal();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        DB::beginTransaction();

        try {
            // Create order
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => auth()->id(),
                'total_amount' => $cartTotal,
                'status' => 'pending',
                'delivery_address' => $request->delivery_address,
                'phone_number' => $request->phone_number,
                'notes' => $request->notes,
            ]);

            // Create order items
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'food_item_id' => $cartItem->food_item_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                    'subtotal' => $cartItem->subtotal,
                ]);
            }

            // Clear cart
            Cart::where('user_id', auth()->id())->delete();

            DB::commit();

            return redirect()->route('orders.confirmation', $order)->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to place order. Please try again.');
        }
    }

    // Show order confirmation
    public function confirmation(Order $order)
    {
        // Make sure order belongs to current user
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('orderItems.foodItem');

        return view('customer.orders.confirmation', compact('order'));
    }

    // Show order history
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('orderItems')
            ->latest()
            ->get();

        return view('customer.orders.index', compact('orders'));
    }

    // Show single order details
    public function show(Order $order)
    {
        // Make sure order belongs to current user
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('orderItems.foodItem.category');

        return view('customer.orders.show', compact('order'));
    }
}