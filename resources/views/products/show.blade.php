@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-3">Detail Barang</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $product->name }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">
                Harga: {{ $product->formatted_price ?? number_format($product->price, 2, ',', '.') }}
            </h6>
            <p class="card-text">
                {{ $product->description }}
            </p>
            <a href="{{ route('products') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Ubah</a>
        </div>
    </div>
@endsection
