@extends('layouts.app')

@section('content')
    {{-- HERO SECTION --}}
    <section class="hero-section text-center">
        <div class="container position-relative z-1">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <span class="badge bg-white text-primary mb-3 px-3 py-2 rounded-pill fw-bold shadow-sm">
                        New Collection 2025
                    </span>
                    <h1 class="display-3 fw-bold mb-4">Temukan Gadget Impian Anda</h1>
                    <p class="lead mb-5 opacity-75">
                        Koleksi lengkap perangkat elektronik terbaru dengan harga terbaik dan garansi resmi.
                        Tingkatkan produktivitas Anda sekarang.
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="#products" class="btn btn-light btn-lg px-5 fw-semibold text-primary shadow-sm">Belanja
                            Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        {{-- ALERT (Jika ada pesan sukses dari halaman lain) --}}
        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm d-flex align-items-center mb-5" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        <div class="row">
            {{-- SIDEBAR FILTER (Hidden on mobile, stylized) --}}
            <div class="col-lg-3 d-none d-lg-block">
                <div class="sticky-top" style="top: 100px; z-index: 100;">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                        <div class="card-header bg-white border-0 py-3">
                            <h6 class="fw-bold mb-0 text-uppercase text-secondary small ls-1">Kategori</h6>
                        </div>
                        <div class="list-group list-group-flush">
                            <a href="{{ route('home') }}"
                                class="list-group-item list-group-item-action border-0 py-2 px-3 {{ !request('category') ? 'text-primary fw-bold bg-primary-subtle' : 'text-muted' }}">
                                <i class="bi bi-grid me-2"></i> Semua Produk
                            </a>
                            @foreach ($categories as $category)
                                <a href="{{ route('home', ['category' => $category->id]) }}"
                                    class="list-group-item list-group-item-action border-0 py-2 px-3 {{ request('category') == $category->id ? 'text-primary fw-bold bg-primary-subtle' : 'text-muted' }}">
                                    <i class="bi bi-tag me-2"></i> {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- PRODUCT GRID --}}
            <div class="col-lg-9" id="products">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold text-dark mb-0">
                        {{ request('category') ? 'Kategori: ' . (\App\Models\Category::find(request('category'))->name ?? 'Unknown') : 'Produk Pilihan' }}
                    </h4>
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-muted small">Urutkan:</span>
                        <select class="form-select form-select-sm border-0 bg-light rounded-pill" style="width: auto;" 
                                onchange="window.location.href = this.value">
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'terbaru']) }}" 
                                {{ request('sort') == 'terbaru' || !request('sort') ? 'selected' : '' }}>Terbaru</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'terlaris']) }}" 
                                {{ request('sort') == 'terlaris' ? 'selected' : '' }}>Terlaris</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'harga_rendah']) }}" 
                                {{ request('sort') == 'harga_rendah' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'harga_tinggi']) }}" 
                                {{ request('sort') == 'harga_tinggi' ? 'selected' : '' }}>Harga Tertinggi</option>
                        </select>
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                    @forelse($products as $product)
                        <div class="col">
                            <div class="card-product d-flex flex-column h-100">
                                <div class="img-wrapper">
                                    {{-- Placeholder image logic handled elegantly --}}
                                    <img src="{{ Str::startsWith($product->image_url, 'http') ? $product->image_url : asset('storage/' . $product->image_url) }}"
                                        alt="{{ $product->name }}"
                                        onerror="this.src='https://placehold.co/400x300/f1f5f9/64748b?text=No+Image';">

                                    @if ($product->category)
                                        <span class="category-badge shadow-sm">
                                            {{ $product->category->name }}
                                        </span>
                                    @endif
                                </div>

                                <div class="card-body d-flex flex-column p-4">
                                    <h6 class="card-title fw-bold text-dark mb-1 text-truncate">{{ $product->name }}</h6>
                                    <div class="mb-3">
                                        <span class="h5 fw-bold text-primary">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</span>
                                    </div>

                                    <p class="card-text text-muted small flex-grow-1 mb-4" style="line-height: 1.6;">
                                        {{ Str::limit($product->description, 60) }}
                                    </p>

                                    <form action="{{ route('cart.store') }}" method="POST" class="mt-auto">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit"
                                            class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2">
                                            <i class="bi bi-bag-plus"></i> Tambah
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 py-5">
                            <div class="text-center py-5 bg-white rounded-4 shadow-sm">
                                <div class="mb-3">
                                    <i class="bi bi-search fs-1 text-muted opacity-50"></i>
                                </div>
                                <h5 class="fw-bold text-muted">Produk tidak ditemukan</h5>
                                <p class="text-muted">Coba cari kategori lain.</p>
                                <a href="{{ route('home') }}" class="btn btn-outline-primary rounded-pill">Lihat Semua
                                    Produk</a>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="mt-5 d-flex justify-content-center">
                    {{ $products->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
