<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Http\Requests\ProductFilterRequest;
use App\Models\Category;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(ProductFilterRequest $request)
    {
        $filters    = $request->validated();
        $products   = $this->productService->search($filters, 20);
        $categories = Category::orderBy('name')->get();

        return view('products.list', compact('products', 'filters', 'categories'));
    }


    public function create()
    {
        $product    = new Product();
        $categories = Category::orderBy('name')->get();

        return view('products.form', [
            'product'    => $product,
            'formMode'   => 'create',
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'stock'       => 'required|integer|min:0',
        ]);

        $this->productService->create($validated);

        return redirect()
            ->route('products')
            ->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product    = $this->productService->findById($id);
        $categories = Category::orderBy('name')->get();

        return view('products.form', [
            'product'    => $product,
            'formMode'   => 'edit',
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, $id) // Changed from UpdateProductRequest to Request for simplicity or update the Request class if preferred
    {
        $product   = $this->productService->findById($id);
        
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'stock'       => 'required|integer|min:0',
        ]);

        $this->productService->update($product, $validated);

        return redirect()
            ->route('products')
            ->with('success', 'Produk berhasil diubah.');
    }
    public function destroy($id)
    {
        $product = $this->productService->findById($id);

        $this->productService->delete($product);

        return redirect()
            ->route('products')
            ->with('success', 'Product deleted successfully.');
    }

    public function show($id)
    {
        $product = Product::with(['category', 'reviews.user'])
            ->findOrFail($id);
        
        // Calculate rating statistics
        $totalReviews = $product->reviews->count();
        $avgRating = $totalReviews > 0 ? round($product->reviews->avg('rating'), 1) : 0;
        
        // Rating breakdown (count per star)
        $ratingBreakdown = [
            5 => $product->reviews->where('rating', 5)->count(),
            4 => $product->reviews->where('rating', 4)->count(),
            3 => $product->reviews->where('rating', 3)->count(),
            2 => $product->reviews->where('rating', 2)->count(),
            1 => $product->reviews->where('rating', 1)->count(),
        ];
        
        // Get reviews with pagination
        $reviews = $product->reviews()
            ->with('user')
            ->latest()
            ->paginate(10);
        
        // Calculate cart quantity for stock validation
        $cartQty = 0;
        if(auth()->check()) {
            $cartQty = \App\Models\CartItem::where('user_id', auth()->id())
                        ->where('product_id', $product->id)
                        ->sum('quantity');
        }
        $realStock = $product->stock - $cartQty;

        return view('products.show', compact(
            'product', 
            'totalReviews', 
            'avgRating', 
            'ratingBreakdown',
            'reviews',
            'realStock'
        ));
    }
}
