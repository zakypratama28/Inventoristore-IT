<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getLatestProducts($limit = 20)
    {
        return Product::latest()->take($limit)->get();
    }

    public function findById($id)
    {
        return Product::findOrFail($id);
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);
        return $product;
    }
}
