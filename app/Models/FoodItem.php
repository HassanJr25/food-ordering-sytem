<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'image',
        'price',
        'is_available',
        'is_featured',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
        'is_featured' => 'boolean',
    ];

    // Belongs to a category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Has many cart items
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    // Has many order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Auto-generate slug from name
    public static function generateSlug($name)
    {
        return strtolower(str_replace(' ', '-', $name));
    }

    // Format price with currency
    public function getFormattedPriceAttribute()
    {
        return 'TZS ' . number_format($this->price, 2);
    }
}