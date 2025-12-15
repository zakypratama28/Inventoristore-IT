<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'code',
        'subtotal',
        'shipping_cost',
        'total',
        'shipping_address',
        'payment_method',
        'status',
    ];

    protected $casts = [
        'payment_method' => PaymentMethod::class,
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
