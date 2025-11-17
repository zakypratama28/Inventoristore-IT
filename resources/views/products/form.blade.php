@extends('layouts.app')

@section('content')
    @php
        $isEdit = ($formMode ?? 'create') === 'edit';
    @endphp

    <h1 class="h3 mb-3">
        {{ $isEdit ? 'Edit Product' : 'Create New Product' }}
    </h1>

    {{-- Error validation --}}
    @if ($errors->any())
        <x-alert type="danger" :message="$errors->first()" />
    @endif

    <form method="POST" action="{{ $isEdit ? route('products.update', $product->id) : route('products.store') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                value="{{ old('name', $product->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                rows="4">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price"
                name="price" value="{{ old('price', $product->price) }}" required>
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">
            {{ $isEdit ? 'Update Product' : 'Save Product' }}
        </button>
        <a href="{{ route('products') }}" class="btn btn-secondary">
            Cancel
        </a>
    </form>
@endsection
