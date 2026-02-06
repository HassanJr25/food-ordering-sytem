<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'total_amount',
        'status',
        'delivery_address',
        'phone_number',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    // Belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Has many order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Generate unique order number
    public static function generateOrderNumber()
    {
        return 'ORD-' . strtoupper(uniqid());
    }

    // Get status badge color
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'background: #fff3cd; color: #856404;',
            'preparing' => 'background: #cfe2ff; color: #084298;',
            'delivered' => 'background: #d4edda; color: #155724;',
            'cancelled' => 'background: #f8d7da; color: #721c24;',
            default => 'background: #e2e3e5; color: #383d41;',
        };
    }

    // Get status display text
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'pending' => '⏳ Pending',
            'preparing' => '👨‍🍳 Preparing',
            'delivered' => '✅ Delivered',
            'cancelled' => '❌ Cancelled',
            default => ucfirst($this->status),
        };
    }
}