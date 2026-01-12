<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'user_id',
        'label',
        'name',
        'phone',
        'address',
        'city',
        'postal_code',
        'province',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Get the user that owns the address
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Set this address as default and unset others
     */
    public function setAsDefault()
    {
        // Unset all other addresses as default for this user
        self::where('user_id', $this->user_id)
            ->where('id', '!=', $this->id)
            ->update(['is_default' => false]);

        // Set this address as default
        $this->is_default = true;
        $this->save();
    }

    /**
     * Scope to get only default address
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }
}
