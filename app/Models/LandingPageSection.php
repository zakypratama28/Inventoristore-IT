<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPageSection extends Model
{
    protected $fillable = [
        'section_key',
        'title',
        'content',
        'image_path',
        'extra_data',
        'order',
        'is_active',
    ];

    protected $casts = [
        'extra_data' => 'array',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Scope to get only active sections
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }

    /**
     * Get the image URL
     */
    public function getImageUrlAttribute()
    {
        return $this->image_path
            ? asset('storage/' . $this->image_path)
            : null;
    }
}
