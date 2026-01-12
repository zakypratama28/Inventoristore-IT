<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewManagementController extends Controller
{
    /**
     * Display all reviews with filters
     */
    public function index(Request $request)
    {
        $query = Review::with(['user', 'product']);
        
        // Filter by product
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }
        
        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }
        
        // Search by review text
        if ($request->filled('search')) {
            $query->where('review_text', 'like', '%' . $request->search . '%');
        }
        
        $reviews = $query->latest()->paginate(20);
        
        // Get all products for filter dropdown
        $products = Product::orderBy('name')->get();
        
        // Statistics
        $stats = [
            'total' => Review::count(),
            'average_rating' => round(Review::avg('rating'), 1),
            'five_star' => Review::where('rating', 5)->count(),
            'one_star' => Review::where('rating', 1)->count(),
        ];
        
        return view('admin.reviews.index', compact('reviews', 'products', 'stats'));
    }
    
    /**
     * Delete a review
     */
    public function destroy(Review $review)
    {
        $review->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Review berhasil dihapus'
        ]);
    }
    
    /**
     * Get reviews for a specific product (AJAX)
     */
    public function getByProduct($productId)
    {
        $reviews = Review::with('user')
            ->where('product_id', $productId)
            ->latest()
            ->get();
            
        return response()->json($reviews);
    }
}
