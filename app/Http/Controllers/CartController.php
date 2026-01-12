<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\UpdateCartItemRequest;
use App\Models\CartItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cartService)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user   = auth()->user();
        $totals = $this->cartService->totals($user);

        return view('cart.index', $totals);
    }

    public function store(AddToCartRequest $request)
    {
        $user    = $request->user();
        $product = Product::findOrFail($request->product_id);

        $this->cartService->addItem($user, $product, $request->input('quantity', 1));

        // Check if request is AJAX
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan ke keranjang.'
            ]);
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function update(UpdateCartItemRequest $request, CartItem $item): RedirectResponse
    {
        $this->authorizeItem($item);

        $this->cartService->updateItemQuantity($item, $request->quantity);

        return back()->with('success', 'Jumlah produk berhasil diperbarui.');
    }

    public function destroy(CartItem $item): RedirectResponse
    {
        $this->authorizeItem($item);

        $this->cartService->removeItem($item);

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    /**
     * Get cart items as JSON for cart sidebar
     */
    public function getItems()
    {
        $user = auth()->user();
        $items = $user->cartItems()->with('product')->get();
        
        $formattedItems = $items->map(function($item) {
            return [
                'id' => $item->id,
                'name' => $item->product->name,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
                'image' => $item->product->image_url ?? asset('images/default-product.png'),
            ];
        });
        
        return response()->json([
            'success' => true,
            'items' => $formattedItems,
            'total' => $items->sum(function($item) {
                return $item->quantity * $item->product->price;
            })
        ]);
    }

    protected function authorizeItem(CartItem $item): void
    {
        abort_unless($item->user_id === auth()->id(), 403);
    }
}
