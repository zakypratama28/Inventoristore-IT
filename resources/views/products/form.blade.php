@extends('layouts.app')

@section('content')
    @php
        $isEdit = ($formMode ?? 'create') === 'edit';
    @endphp

    <h1 class="h3 mb-3">
        {{ $isEdit ? 'Ubah Produk' : 'Tambah Produk Baru' }}
    </h1>

    {{-- Error validation --}}
    @if ($errors->any())
        <x-alert type="danger" :message="$errors->first()" />
    @endif
    <form method="POST" action="{{ $isEdit ? route('products.update', $product->id) : route('products.store') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nama Barang : </label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                value="{{ old('name', $product->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi : </label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                rows="4">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori :</label>
            <select id="category_id" name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                <option value="">-- Pilih Kategori --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ (string) old('category_id', $product->category_id) === (string) $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Harga : </label>
            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price"
                name="price" value="{{ old('price', $product->price) }}" required>
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">
            {{ $isEdit ? 'Ubah Produk' : 'Simpan Produk' }}
        </button>
        <a href="{{ route('products') }}" class="btn btn-secondary">
            Batal
        </a>
    </form>
@endsection
