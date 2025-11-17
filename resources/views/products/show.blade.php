@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-3">Product Detail</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $product->name }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">
                Price: {{ $product->formatted_price ?? number_format($product->price, 2, ',', '.') }}
            </h6>
            <p class="card-text">
                {{ $product->description }}
            </p>
            <a href="{{ route('products') }}" class="btn btn-secondary">Back to list</a>
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>
@endsection
