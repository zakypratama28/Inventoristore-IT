<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display user's wishlist
     */
    public function index()
    {
        $wishlists = auth()->user()->wishlists()->with('product.category')->latest()->get();
        
        return view('wishlist.index', compact('wishlists'));
    }

    /**
     * Check if product is in wishlist (for AJAX)
     */
    public function check($productId)
    {
        $inWishlist = auth()->user()->hasInWishlist($productId);
        
        return response()->json([
            'inWishlist' => $inWishlist
        ]);
    }

    /**
     * Add product to wishlist
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        try {
            $wishlist = Wishlist::firstOrCreate([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
            ]);

            return response()->json([
                'success' => true,
                'message' => __('messages.wishlist.added'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('messages.wishlist.already_exists'),
            ], 400);
        }
    }

    /**
     * Remove product from wishlist
     * Supports both wishlist ID and product ID
     */
    public function destroy($identifier)
    {
        // Try to find by product_id first (for AJAX toggle button)
        $wishlist = Wishlist::where('user_id', auth()->id())
                           ->where('product_id', $identifier)
                           ->first();
        
        // If not found, try by wishlist id (for wishlist page)
        if (!$wishlist) {
            $wishlist = Wishlist::where('user_id', auth()->id())
                               ->where('id', $identifier)
                               ->first();
        }
        
        if (!$wishlist) {
            // For AJAX requests
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => __('messages.wishlist.not_found'),
                ], 404);
            }
            
            return redirect()->route('wishlist.index')
                            ->with('error', __('messages.wishlist.not_found'));
        }
        
        $wishlist->delete();

        // Return JSON for AJAX requests
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('messages.wishlist.removed'),
            ]);
        }

        return redirect()->route('wishlist.index')
                        ->with('success', __('messages.wishlist.removed'));
    }
}
