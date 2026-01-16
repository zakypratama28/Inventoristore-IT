<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'category_id',
        'image_path',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image_path
            ? asset('storage/' . $this->image_path)
            : asset('images/default-product.png');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Get average rating for this product
     */
    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    /**
     * Get total number of reviews
     */
    public function totalReviews()
    {
        return $this->reviews()->count();
    }

    /**
     * Check if product is in stock
     */
    public function isInStock()
    {
        return $this->stock > 0;
    }

    /**
     * Check if product is low stock (less than 10)
     */
    public function isLowStock()
    {
        return $this->stock > 0 && $this->stock < 10;
    }

    /**
     * Get total sold count for this product
     * Counts quantity from all completed orders
     */
    public function getSoldCountAttribute()
    {
        return $this->orderItems()
            ->whereHas('order', function ($query) {
                $query->where('status', 'completed');
            })
            ->sum('quantity');
    }
}
