@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Daftar Product</h1>

        <a href="{{ route('products.create') }}" class="btn btn-primary">
            Tambah Produk Baru
        </a>
    </div>

    {{-- Form Search + Filter + Sort --}}
    <form method="GET" action="{{ route('products') }}" class="card mb-3">
        <div class="card-body">
            <div class="row g-2">
                <div class="col-md-4">
                    <label class="form-label">Search (name / description)</label>
                    <input type="text" name="q" class="form-control" placeholder="Search product..."
                        value="{{ $filters['q'] ?? '' }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Price min</label>
                    <input type="number" name="price_min" class="form-control" value="{{ $filters['price_min'] ?? '' }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Price max</label>
                    <input type="number" name="price_max" class="form-control" value="{{ $filters['price_max'] ?? '' }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Sort by</label>
                    <select name="sort_by" class="form-select">
                        <option value="name" {{ ($filters['sort_by'] ?? '') === 'name' ? 'selected' : '' }}>Name</option>
                        <option value="price" {{ ($filters['sort_by'] ?? '') === 'price' ? 'selected' : '' }}>Price
                        </option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Order</label>
                    <select name="sort_dir" class="form-select">
                        <option value="asc" {{ ($filters['sort_dir'] ?? '') === 'asc' ? 'selected' : '' }}>Ascending
                        </option>
                        <option value="desc" {{ ($filters['sort_dir'] ?? '') === 'desc' ? 'selected' : '' }}>Descending
                        </option>
                    </select>
                </div>
            </div>

            <div class="mt-3 d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-success">
                    Terapkan Filter
                </button>

                <a href="{{ route('products') }}" class="btn btn-outline-secondary">
                    Reset
                </a>
            </div>
        </div>
    </form>

    @if ($products->isEmpty())
        <p>No products found.</p>
    @else
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th class="text-end">Price</th>
                    <th style="width: 180px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $index => $product)
                    <tr>
                        <td>{{ $products->firstItem() + $index }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name ?? '-' }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($product->description, 60) }}</td>
                        <td class="text-end">
                            {{ $product->formatted_price ?? number_format($product->price, 2, ',', '.') }}
                        </td>
                        <td>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-info">
                                Detail
                            </a>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">
                                Edit
                            </a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $products->links('pagination::bootstrap-4') }}
    @endif
@endsection
