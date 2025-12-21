<?php

namespace App\Http\Controllers;

use App\Enums\PaymentMethod;
use App\Http\Requests\CheckoutRequest;
use App\Services\CartService;

class CheckoutController extends Controller
{
    public function __construct(private CartService $cartService)
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $user       = auth()->user();
        $totals     = $this->cartService->totals($user);
        $methods    = PaymentMethod::cases();

        return view('checkout.create', array_merge($totals, compact('methods')));
    }

    public function store(CheckoutRequest $request)
    {
        $user = $request->user();

        $order = $this->cartService->checkout(
            $user,
            $request->validated(),
            PaymentMethod::from($request->payment_method),
        );

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Order berhasil dibuat. Silakan lanjutkan proses pembayaran.');
    }
}
