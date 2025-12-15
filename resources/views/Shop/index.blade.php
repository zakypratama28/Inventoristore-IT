@extends('layouts.inventory')

@section('title', 'Katalog Produk')
@section('page-title', 'Katalog Produk')

@section('content')
    <div class="row g-4">
        @foreach ($products as $product)
            <div class="col-md-4 col-lg-3">
                <div class="card h-100 border-0 shadow-sm product-card">
                    <img src="{{ $product->image_url }}" class="card-img-top product-thumb" alt="{{ $product->name }}">

                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title mb-1">{{ $product->name }}</h6>
                        <small class="text-muted d-block mb-2">
                            {{ $product->category->name ?? 'Tanpa kategori' }}
                        </small>
                        <p class="card-text text-muted small flex-fill">
                            {{ \Illuminate\Support\Str::limit($product->description, 80) }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong>
                            <form action="{{ route('cart.store') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="bi bi-cart-plus me-1"></i> Keranjang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $products->links('pagination::bootstrap-4') }}
    </div>
@endsection
