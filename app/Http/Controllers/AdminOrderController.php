<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')
            ->when(request('q'), function ($query) {
                $query->where('code', 'like', '%' . request('q') . '%')
                    ->orWhereHas('user', function ($q) {
                        $q->where('name', 'like', '%' . request('q') . '%');
                    });
            })
            ->when(request('status'), function ($query) {
                $query->where('status', request('status'));
            })
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'user');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:pending,processing,shipped,completed,cancelled,paid'
        ]);

        $order->update(['status' => $request->status]);

        // Kirim email notifikasi ke pelanggan
        try {
            \Illuminate\Support\Facades\Mail::to($order->user->email)->send(new \App\Mail\OrderStatusUpdated($order));
        } catch (\Exception $e) {
            // Log error if needed or ignore for local testing
        }

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
