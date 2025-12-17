<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function search(array $filters, int $perPage = 20)
    {
        $query = Product::query()->with('category');

        // Search by name or description
        if (!empty($filters['q'])) {
            $search = $filters['q'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter price range
        if (!empty($filters['price_min'])) {
            $query->where('price', '>=', $filters['price_min']);
        }

        if (!empty($filters['price_max'])) {
            $query->where('price', '<=', $filters['price_max']);
        }

        // Sorting
        $sortBy  = $filters['sort_by'] ?? 'name';
        $sortDir = $filters['sort_dir'] ?? 'asc';

        if (!in_array($sortDir, ['asc', 'desc'])) {
            $sortDir = 'asc';
        }

        switch ($sortBy) {
            case 'price':
                // urutkan berdasarkan kolom price produk
                $query->orderBy('price', $sortDir);
                break;

            case 'category':
                // urutkan berdasarkan nama kategori (tabel categories)
                $query->leftJoin('categories', 'products.category_id', '=', 'categories.id')
                    ->select('products.*')
                    ->orderBy('categories.name', $sortDir);
                break;

            case 'name':
            default:
                // default: urutkan berdasarkan nama produk
                $query->orderBy('name', $sortDir);
                break;
        }

        return $query->paginate($perPage)->appends($filters);
    }

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
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $data['image_path'] = $data['image']->store('products', 'public');
            unset($data['image']);
        }

        return Product::create($data);
    }

    public function update(Product $product, array $data): Product
    {
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            // Delete old image if exists
            if ($product->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->image_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image_path);
            }
            $data['image_path'] = $data['image']->store('products', 'public');
            unset($data['image']);
        }

        $product->update([
            'name'        => $data['name'],
            'description' => $data['description'] ?? null,
            'price'       => $data['price'],
            'category_id' => $data['category_id'] ?? null,
            'image_path'  => $data['image_path'] ?? $product->image_path,
        ]);

        return $product;
    }
    public function delete(Product $product): void
    {
        $product->delete();
    }
}
