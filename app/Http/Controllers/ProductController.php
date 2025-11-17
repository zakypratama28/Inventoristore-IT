<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getLatestProducts(20);

        return view('products.list', compact('products'));
    }

    public function create()
    {
        $product = new Product();
        return view('products.form', [
            'product' => $product,
            'formMode' => 'create',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
        ]);

        $this->productService->create($validated);

        return redirect()
            ->route('products')
            ->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = $this->productService->findById($id);

        return view('products.form', [
            'product' => $product,
            'formMode' => 'edit',
        ]);
    }

    public function update(Request $request, $id)
    {
        $product = $this->productService->findById($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
        ]);

        $this->productService->update($product, $validated);

        return redirect()
            ->route('products')
            ->with('success', 'Product updated successfully.');
    }

    public function show($id)
    {
        $product = $this->productService->findById($id);

        return view('products.show', compact('product'));
    }
}
