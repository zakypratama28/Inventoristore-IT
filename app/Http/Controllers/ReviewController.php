<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a new review from an order
     */
    public function storeFromOrder(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Verify order belongs to user
        $order = \App\Models\Order::findOrFail($request->order_id);
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Verify order is completed
        if ($order->status !== 'completed') {
            return redirect()->back()->with('error', 'Hanya pesanan yang sudah selesai yang bisa direview.');
        }

        // Check if user already reviewed this product from this order
        $existingReview = Review::where('user_id', auth()->id())
                               ->where('product_id', $request->product_id)
                               ->where('order_id', $request->order_id)
                               ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Anda sudah memberikan review untuk produk ini.');
        }

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'order_id' => $request->order_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Review berhasil ditambahkan. Terima kasih!');
    }

    /**
     * Store a new review
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Check if user has already reviewed this product
        $existingReview = Review::where('user_id', auth()->id())
                               ->where('product_id', $product->id)
                               ->first();

        if ($existingReview) {
            return redirect()->back()
                           ->with('error', __('messages.review.already_reviewed'));
        }

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()
                       ->with('success', __('messages.review.added'));
    }

    /**
     * Update existing review
     */
    public function update(Request $request, Review $review)
    {
        // Check if user owns this review
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()
                       ->with('success', __('messages.review.updated'));
    }

    /**
     * Delete review
     */
    public function destroy(Review $review)
    {
        // Check if user owns this review or is admin
        if ($review->user_id !== auth()->id() && !in_array(auth()->user()->role, ['admin', 'staff'])) {
            abort(403);
        }

        $review->delete();

        return redirect()->back()
                       ->with('success', __('messages.review.deleted'));
    }
}
