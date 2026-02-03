<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // One category has many food items
    public function foodItems()
    {
        return $this->hasMany(FoodItem::class);
    }

    // Auto-generate slug from name
    public static function generateSlug($name)
    {
        return strtolower(str_replace(' ', '-', $name));
    }
}