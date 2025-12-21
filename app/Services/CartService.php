<?php

namespace App\Services;

use App\Enums\PaymentMethod;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartService
{
    public function items(User $user)
    {
        return CartItem::with('product')
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();
    }

    public function addItem(User $user, Product $product, int $quantity = 1): CartItem
    {
        $item = CartItem::firstOrNew([
            'user_id'    => $user->id,
            'product_id' => $product->id,
        ]);

        $item->unit_price = $product->price;
        $item->quantity   = ($item->exists ? $item->quantity : 0) + $quantity;
        $item->save();

        return $item;
    }

    public function updateItemQuantity(CartItem $item, int $quantity): CartItem
    {
        $item->update(['quantity' => $quantity]);
        return $item;
    }

    public function removeItem(CartItem $item): void
    {
        $item->delete();
    }

    public function clear(User $user): void
    {
        CartItem::where('user_id', $user->id)->delete();
    }

    public function totals(User $user): array
    {
        $items = $this->items($user);
        $subtotal = $items->sum(fn($i) => $i->subtotal);
        $shipping = 0; // kalau mau bisa dinamis
        $total    = $subtotal + $shipping;

        return compact('items', 'subtotal', 'shipping', 'total');
    }

    public function checkout(
        User $user,
        array $shippingData,
        PaymentMethod $paymentMethod
    ): Order {
        return DB::transaction(function () use ($user, $shippingData, $paymentMethod) {
            $items = $this->items($user);
            if ($items->isEmpty()) {
                throw new \RuntimeException('Keranjang belanja kosong.');
            }

            $subtotal = $items->sum(fn($i) => $i->subtotal);
            $shipping = 0;
            $total    = $subtotal + $shipping;

            // buat order
            $order = Order::create([
                'user_id'              => $user->id,
                'code'                 => $this->generateOrderCode(),
                'subtotal'             => $subtotal,
                'shipping_cost'        => $shipping,
                'total'                => $total,
                'shipping_name'        => $shippingData['shipping_name'] ?? $user->name,
                'shipping_phone'       => $shippingData['shipping_phone'] ?? $user->phone,
                'shipping_address'     => $shippingData['shipping_address'],
                'shipping_city'        => $shippingData['shipping_city'] ?? null,
                'shipping_postal_code' => $shippingData['shipping_postal_code'] ?? null,
                'shipping_province'    => $shippingData['shipping_province'] ?? null,
                'payment_method'       => $paymentMethod,
                'status'               => 'pending',
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product->name,
                    'unit_price'   => $item->unit_price,
                    'quantity'     => $item->quantity,
                    'subtotal'     => $item->subtotal,
                ]);
            }

            // kosongkan keranjang
            $this->clear($user);

            return $order;
        });
    }

    protected function generateOrderCode(): string
    {
        $prefix = 'ORD-' . now()->format('Ymd') . '-';
        $random = Str::upper(Str::random(4));
        return $prefix . $random;
    }
}
