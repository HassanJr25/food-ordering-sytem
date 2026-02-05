<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'food_item_id',
        'quantity',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    // Belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Belongs to a food item
    public function foodItem()
    {
        return $this->belongsTo(FoodItem::class);
    }

    // Calculate subtotal for this cart item
    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->price;
    }

    // Get all cart items for current user
    public static function getCartItems()
    {
        return self::where('user_id', auth()->id())
            ->with('foodItem.category')
            ->get();
    }

    // Get cart total
    public static function getCartTotal()
    {
        return self::where('user_id', auth()->id())
            ->get()
            ->sum(function($item) {
                return $item->quantity * $item->price;
            });
    }

    // Get cart count
    public static function getCartCount()
    {
        return self::where('user_id', auth()->id())
            ->sum('quantity');
    }
}