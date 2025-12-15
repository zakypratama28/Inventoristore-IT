@extends('layouts.inventory')

@section('title', 'Daftar Produk')
@section('page-title', 'Daftar Produk')

@section('page-actions')
    <div class="d-flex gap-2">
        <a href="{{ route('home') }}" class="btn btn-sm btn-dark">
            Kembali ke Dashboard
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                {{-- HEADER UNGU --}}
                <div class="card-header p-0 mx-3 mt-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3 mb-0">Daftar Produk</h6>
                        <p class="text-white-50 ps-3 mb-0 small">
                            Tabel semua produk yang ada di sistem.
                        </p>
                    </div>
                </div>

                <div class="px-3 pt-3 pb-3">
                    {{-- Baris 1: deskripsi + chip info --}}
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                        <span class="text-muted small">
                            Kelola data barang persediaan gudang. Gunakan filter untuk mencari produk tertentu.
                        </span>

                        <div class="d-flex gap-2 flex-wrap">
                            <span class="filter-chip">
                                Total data: {{ $products->total() }}
                            </span>
                            <span class="filter-chip">
                                Halaman: {{ $products->currentPage() }} / {{ $products->lastPage() }}
                            </span>
                        </div>
                    </div>

                    {{-- Baris 2: form filter --}}
                    <form method="GET" action="{{ route('products') }}" class="row g-3">
                        <div class="col-lg-4 col-md-6">
                            <label class="form-label small text-muted">Cari Nama Barang</label>
                            <input type="text" name="q" class="form-control form-control-sm"
                                value="{{ $filters['q'] ?? '' }}">
                        </div>

                        <div class="col-lg-2 col-md-3 col-6">
                            <label class="form-label small text-muted">Harga Terendah</label>
                            <input type="number" name="price_min" class="form-control form-control-sm"
                                value="{{ $filters['price_min'] ?? '' }}">
                        </div>

                        <div class="col-lg-2 col-md-3 col-6">
                            <label class="form-label small text-muted">Harga Tertinggi</label>
                            <input type="number" name="price_max" class="form-control form-control-sm"
                                value="{{ $filters['price_max'] ?? '' }}">
                        </div>

                        <div class="col-lg-2 col-md-4 col-6">
                            <label class="form-label small text-muted">Urutkan Berdasarkan</label>
                            <select name="sort_by" class="form-select form-select-sm">
                                <option value="name" {{ ($filters['sort_by'] ?? '') === 'name' ? 'selected' : '' }}>Nama
                                </option>
                                <option value="price" {{ ($filters['sort_by'] ?? '') === 'price' ? 'selected' : '' }}>Harga
                                </option>
                                <option value="Category"
                                    {{ ($filters['sort_by'] ?? '') === 'Category' ? 'selected' : '' }}>Kategori</option>
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-4 col-6">
                            <label class="form-label small text-muted">Urut Dari</label>
                            <select name="sort_dir" class="form-select form-select-sm">
                                <option value="asc" {{ ($filters['sort_dir'] ?? '') === 'asc' ? 'selected' : '' }}>
                                    A-Z</option>
                                <option value="desc" {{ ($filters['sort_dir'] ?? '') === 'desc' ? 'selected' : '' }}>
                                    Z-A</option>
                            </select>
                        </div>

                        <div class="col-12 d-flex justify-content-end gap-2">
                            {{-- <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                data-bs-target="#createProductModal">
                                Tambah Barang Baru
                            </button> --}}
                            <a href="{{ route('products') }}" class="btn btn-danger btn-sm">
                                Reset
                            </a>
                            <button type="submit" class="btn btn-sm btn-success">
                                Terapkan Filter
                            </button>
                        </div>
                    </form>
                </div>
                </form>
            </div>
            {{-- Tombol Tambah Barang Baru di atas kolom AKSI --}}
            <div class="px-3 pb-2 d-flex justify-content-end">
                <button type="button" class="btn btn-primary-dark btn-sm" data-bs-toggle="modal"
                    data-bs-target="#createProductModal">
                    Tambah Barang Baru
                </button>
            </div>
            {{-- TABLE --}}
            <div class="table-responsive p-0">
                <table class="table table-modern align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Barang
                            </th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kategori
                            </th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Deskripsi</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">
                                Harga</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $index => $product)
                            <tr>
                                <td class="align-middle">
                                    <span class="text-xs font-weight-bold">
                                        {{ $products->firstItem() + $index }}
                                    </span>
                                </td>

                                <td class="align-middle">
                                    <span class="cell-name">
                                        {{ $product->name }}
                                    </span>
                                </td>

                                <td class="align-middle">
                                    <span class="badge-category">
                                        {{ $product->category->name ?? 'Tanpa Kategori' }}
                                    </span>
                                </td>

                                <td class="align-middle">
                                    <span class="text-xs text-muted">
                                        {{ \Illuminate\Support\Str::limit($product->description, 80) }}
                                    </span>
                                </td>

                                <td class="align-middle text-end">
                                    <span class="price-text">
                                        {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </td>

                                <td class="align-middle text-center table-actions">
                                    {{-- Tambah ke keranjang --}}
                                    <form action="{{ route('cart.store') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        {{-- kalau mau jumlah: --}}
                                        {{-- <input type="number" name="quantity" value="1" min="1" class="form-control form-control-sm d-inline-block" style="width:70px;"> --}}
                                        <button type="submit" class="btn btn-sm btn-outline-primary">
                                            + Keranjang
                                        </button>
                                    </form>

                                    {{-- Detail / Ubah / Hapus --}}
                                    <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                        data-bs-target="#showProductModal-{{ $product->id }}">
                                        Detail
                                    </button>

                                    <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal"
                                        data-bs-target="#editProductModal-{{ $product->id }}">
                                        Ubah
                                    </button>

                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteProductModal-{{ $product->id }}">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    Tidak ada produk ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-3 pt-3">
                {{ $products->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
    </div>
    </div>


    <div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <form method="POST" action="{{ route('products.store') }}">
                    @csrf

                    <div class="modal-header border-0 pb-0">
                        <div>
                            <h5 class="modal-title fw-semibold mb-1">Tambah Produk Baru</h5>
                            <p class="text-muted small mb-0">
                                Isi informasi produk dengan lengkap, lalu klik <strong>Simpan Produk</strong>.
                            </p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>


                    <div class="modal-body pt-3">
                        <div class="row g-3">
                            {{-- Nama --}}
                            <div class="col-12">
                                <label class="form-label small text-muted mb-1">Nama Barang</label>
                                <input type="text" name="name" class="form-control form-control-sm"
                                    placeholder="Contoh: Flashdisk 64GB" value="{{ old('name') }}" required>
                            </div>

                            {{-- Deskripsi --}}
                            <div class="col-12">
                                <label class="form-label small text-muted mb-1">Deskripsi</label>
                                <textarea name="description" class="form-control form-control-sm" rows="3"
                                    placeholder="Tuliskan deskripsi singkat produk">{{ old('description') }}</textarea>
                            </div>

                            {{-- Kategori --}}
                            <div class="col-md-6">
                                <label class="form-label small text-muted mb-1">Kategori</label>
                                <select name="category_id" class="form-select form-select-sm">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Harga --}}
                            <div class="col-md-6">
                                <label class="form-label small text-muted mb-1">Harga</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="price" step="0.01" class="form-control"
                                        placeholder="0" value="{{ old('price') }}" required>
                                </div>
                                <div class="form-text small text-muted">
                                    Gunakan satuan rupiah tanpa titik. Contoh: 16500000
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- FOOTER --}}
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light border rounded-pill px-3" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary rounded-pill px-3">
                            <i class="bi bi-check-circle me-1"></i> Simpan Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ========== MODAL DETAIL / EDIT / DELETE PER PRODUK ========== --}}
    @foreach ($products as $product)
        {{-- DETAIL --}}
        <div class="modal fade" id="showProductModal-{{ $product->id }}" tabindex="-1"
            aria-labelledby="showProductModalLabel-{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="showProductModalLabel-{{ $product->id }}">
                            Detail Produk
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <dl class="row">
                            <dt class="col-sm-3">Nama Barang</dt>
                            <dd class="col-sm-9">{{ $product->name }}</dd>

                            <dt class="col-sm-3">Kategori</dt>
                            <dd class="col-sm-9">{{ $product->category->name ?? '-' }}</dd>

                            <dt class="col-sm-3">Deskripsi</dt>
                            <dd class="col-sm-9">{{ $product->description }}</dd>

                            <dt class="col-sm-3">Harga</dt>
                            <dd class="col-sm-9">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </dd>
                        </dl>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- EDIT --}}
        <div class="modal fade" id="editProductModal-{{ $product->id }}" tabindex="-1"
            aria-labelledby="editProductModalLabel-{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <form method="POST" action="{{ route('products.update', $product->id) }}">
                        @csrf

                        {{-- HEADER --}}
                        <div class="modal-header border-0 pb-0">
                            <div>
                                <h5 class="modal-title fw-semibold mb-1">Ubah Produk</h5>
                                <p class="text-muted small mb-0">
                                    Perbarui informasi produk lalu klik <strong>Simpan Perubahan</strong>.
                                </p>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        {{-- BODY --}}
                        <div class="modal-body pt-3">
                            <div class="row g-3">
                                {{-- Nama --}}
                                <div class="col-12">
                                    <label class="form-label small text-muted mb-1">Nama Barang</label>
                                    <input type="text" name="name" class="form-control form-control-sm"
                                        value="{{ $product->name }}" required>
                                </div>

                                {{-- Deskripsi --}}
                                <div class="col-12">
                                    <label class="form-label small text-muted mb-1">Deskripsi</label>
                                    <textarea name="description" class="form-control form-control-sm" rows="3">{{ $product->description }}</textarea>
                                </div>

                                {{-- Kategori --}}
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">Kategori</label>
                                    <select name="category_id" class="form-select form-select-sm">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ (string) $product->category_id === (string) $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Harga --}}
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">Harga</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="price" step="0.01" class="form-control"
                                            value="{{ $product->price }}" required>
                                    </div>
                                    <div class="form-text small text-muted">
                                        Gunakan satuan rupiah tanpa titik. Contoh: 16500000
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- FOOTER --}}
                        <div class="modal-footer border-0 pt-0">
                            <button type="button" class="btn btn-light border rounded-pill px-3"
                                data-bs-dismiss="modal">
                                <i class="bi bi-x-lg me-1"></i> Batal
                            </button>
                            <button type="submit" class="btn btn-primary rounded-pill px-3">
                                <i class="bi bi-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        {{-- DELETE --}}
        <div class="modal fade" id="deleteProductModal-{{ $product->id }}" tabindex="-1"
            aria-labelledby="deleteProductModalLabel-{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form method="POST" action="{{ route('products.destroy', $product->id) }}">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteProductModalLabel-{{ $product->id }}">
                                Hapus Produk
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin menghapus
                            <strong>{{ $product->name }}</strong>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                Batal
                            </button>
                            <button type="submit" class="btn bg-gradient-danger">
                                Ya, hapus
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
