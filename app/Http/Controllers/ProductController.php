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

    public function update(UpdateProductRequest $request, $id)
    {
        $product   = $this->productService->findById($id);
        $validated = $request->validated();   // sudah termasuk category_id

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
        $product = $this->productService->findById($id);

        return view('products.show', compact('product'));
    }
}
