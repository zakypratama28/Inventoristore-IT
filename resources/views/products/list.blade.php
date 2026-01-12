@extends('layouts.inventory')

@section('title', 'Master Data Barang')
@section('page-title', 'Data Barang')

@section('content')
<div class="row g-4">
    {{-- Main Content --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-0 text-dark">Daftar Produk</h5>
                        <small class="text-muted">Kelola data persediaan barang gudang.</small>
                    </div>
                    <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm"
                        data-bs-toggle="modal" data-bs-target="#createProductModal">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Barang
                    </button>
                </div>
            </div>
            
            <div class="card-body p-0">
                {{-- Filters & Search --}}
                <div class="bg-light bg-opacity-50 p-3 mx-3 rounded-3 mb-3 border">
                    <form method="GET" action="{{ route('products') }}" class="row g-3 align-items-end">
                        <div class="col-lg-4">
                            <label class="form-label small text-muted fw-bold text-uppercase ls-1">Pencarian</label>
                            <div class="input-group bg-white rounded-3 border">
                                <span class="input-group-text bg-transparent border-0 text-muted"><i class="bi bi-search"></i></span>
                                <input type="text" name="q" class="form-control border-0 shadow-none ps-0" placeholder="Cari nama barang..." value="{{ $filters['q'] ?? '' }}">
                            </div>
                        </div>
                        <div class="col-lg-2 col-6">
                            <label class="form-label small text-muted fw-bold text-uppercase ls-1">Harga Min</label>
                            <input type="number" name="price_min" class="form-control" placeholder="0" value="{{ $filters['price_min'] ?? '' }}">
                        </div>
                        <div class="col-lg-2 col-6">
                            <label class="form-label small text-muted fw-bold text-uppercase ls-1">Harga Max</label>
                            <input type="number" name="price_max" class="form-control" placeholder="Max" value="{{ $filters['price_max'] ?? '' }}">
                        </div>
                        <div class="col-lg-2 col-6">
                            <label class="form-label small text-muted fw-bold text-uppercase ls-1">Urutan</label>
                            <select name="sort_by" class="form-select">
                                <option value="name" {{ ($filters['sort_by'] ?? '') === 'name' ? 'selected' : '' }}>Nama A-Z</option>
                                <option value="price" {{ ($filters['sort_by'] ?? '') === 'price' ? 'selected' : '' }}>Harga Termurah</option>
                                <option value="created_at" {{ ($filters['sort_by'] ?? '') === 'created_at' ? 'selected' : '' }}>Terbaru</option>
                            </select>
                        </div>
                        <div class="col-lg-2 d-grid">
                            <button type="submit" class="btn btn-secondary w-100">
                                Filter
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">Produk</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kategori</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stok</th>
                                <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 me-3">Harga</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0 text-sm fw-bold text-dark">{{ $product->name }}</h6>
                                        <p class="text-xs text-secondary mb-0 text-truncate" style="max-width: 250px;">
                                            {{ $product->description ?? 'Tidak ada deskripsi' }}
                                        </p>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">
                                        {{ $product->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold {{ $product->stock <= 5 ? 'text-danger' : 'text-dark' }}">
                                        {{ $product->stock }} Unit
                                    </span>
                                </td>
                                <td class="text-end pe-3">
                                    <span class="text-dark font-weight-bold text-sm">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group shadow-sm border rounded-pill overflow-hidden">
                                        <button type="button" class="btn btn-sm btn-white text-dark px-3" 
                                            data-bs-toggle="modal" data-bs-target="#showProductModal-{{ $product->id }}" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-white text-primary px-3 border-start border-end" 
                                            data-bs-toggle="modal" data-bs-target="#editProductModal-{{ $product->id }}" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-white text-danger px-3" 
                                            data-bs-toggle="modal" data-bs-target="#deleteProductModal-{{ $product->id }}" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-box-seam fs-1 d-block mb-2 opacity-50"></i>
                                    Belum ada data produk.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="card-footer bg-white border-0 py-3">
                {{ $products->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>

{{-- MODALS --}}
@include('products.modals')

@endsection

@push('styles')
<style>
    .btn-white { background: #fff; border: 0; }
    .btn-white:hover { background: #f8f9fa; }
    .table > :not(caption) > * > * { padding: 1rem 0.5rem; border-bottom-color: #f0f2f5; }
    .text-xxs { font-size: 0.75rem; }
</style>
@endpush
