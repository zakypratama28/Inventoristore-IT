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
                    <h1 class="display-2 fw-bold mb-3">Temukan Perangkat Gaming & Gadget Anda</h1>
                    <p class="lead mb-5 opacity-75">
                        Koleksi lengkap kebutuhan gaming & gadget terbaru dengan harga terbaik terpercaya.
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
                            <div class="card-product d-flex flex-column h-100 position-relative group">
                                <div class="img-wrapper position-relative overflow-hidden">
                                    {{-- Click triggers modal --}}
                                    <a href="javascript:void(0)"
                                        onclick="showProductModal({{ json_encode($product) }}, '{{ Str::startsWith($product->image_url, 'http') ? $product->image_url : asset('storage/' . $product->image_url) }}', '{{ $product->category->name ?? '' }}')"
                                        class="d-block w-100 h-100">
                                        <img src="{{ Str::startsWith($product->image_url, 'http') ? $product->image_url : asset('storage/' . $product->image_url) }}"
                                            alt="{{ $product->name }}"
                                            class="w-100 h-100 object-fit-cover transition-transform"
                                            onerror="this.src='https://placehold.co/400x300/f1f5f9/64748b?text=No+Image';">
                                    </a>

                                    @if ($product->category)
                                        <span class="category-badge shadow-sm">
                                            {{ $product->category->name }}
                                        </span>
                                    @endif
                                </div>

                                <div class="card-body d-flex flex-column p-4">
                                    <h6 class="card-title fw-bold text-dark mb-1 text-truncate">
                                        <a href="javascript:void(0)"
                                            onclick="showProductModal({{ json_encode($product) }}, '{{ Str::startsWith($product->image_url, 'http') ? $product->image_url : asset('storage/' . $product->image_url) }}', '{{ $product->category->name ?? '' }}')"
                                            class="text-decoration-none text-dark stretched-link">
                                            {{ $product->name }}
                                        </a>
                                    </h6>
                                    <div class="mb-3">
                                        <span class="h5 fw-bold text-primary">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</span>
                                    </div>


                                    {{-- Standard Add to Cart --}}
                                    <button type="button"
                                        onclick="showProductModal({{ json_encode($product) }}, '{{ Str::startsWith($product->image_url, 'http') ? $product->image_url : asset('storage/' . $product->image_url) }}', '{{ $product->category->name ?? '' }}')"
                                        class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2 mt-auto">
                                        <i class="bi bi-cart-plus"></i> Tambah
                                    </button>
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

    {{-- QUICK VIEW MODAL --}}
    <div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg overflow-hidden rounded-4">
                <div class="position-absolute top-0 end-0 p-3 z-3">
                    <button type="button" class="btn-close bg-white bg-opacity-50 p-2 rounded-circle shadow-sm"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="row g-0">
                        {{-- Image Side --}}
                        <div class="col-md-6 bg-light d-flex align-items-center justify-content-center p-4">
                            <img id="modalImage" src="" alt="Product" class="img-fluid rounded-3 shadow-sm"
                                style="max-height: 400px; object-fit: contain;">
                        </div>

                        {{-- Content Side --}}
                        <div class="col-md-6 p-4 p-lg-5 d-flex flex-column">
                            <div class="mb-auto">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span id="modalCategoryBadge"
                                        class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-medium">
                                        Category
                                    </span>
                                </div>
                                <h3 id="modalTitle" class="fw-bold mb-2 text-dark lh-sm">Product Name</h3>
                                <h4 class="text-primary fw-bold mb-4" id="modalPrice">Rp 0</h4>

                                <p id="modalDescription" class="text-muted mb-4 small" style="line-height: 1.7;">
                                    Description...
                                </p>
                            </div>

                            <form action="{{ route('cart.store') }}" method="POST" class="mt-4">
                                @csrf
                                <input type="hidden" name="product_id" id="modalInputId">

                                <div class="d-flex align-items-center gap-3 mb-4">
                                    <div class="input-group input-group-sm w-auto border rounded-pill overflow-hidden">
                                        <button class="btn btn-light px-3" type="button"
                                            onclick="decrementQty()">-</button>
                                        <input type="number" name="quantity" id="modalQty"
                                            class="form-control text-center border-0 bg-white" value="1"
                                            min="1" step="1" style="width: 50px;">
                                        <button class="btn btn-light px-3" type="button"
                                            onclick="incrementQty()">+</button>
                                    </div>
                                    <span class="text-muted small">Stok: <span id="modalStock"
                                            class="fw-bold text-dark">0</span></span>
                                </div>

                                <button type="submit"
                                    class="btn btn-dark w-100 py-3 rounded-pill fw-semibold shadow-sm transition-transform hover-scale">
                                    Add to cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function showProductModal(product, imageUrl, categoryName) {
                // Populate Data
                document.getElementById('modalTitle').textContent = product.name;
                document.getElementById('modalImage').src = imageUrl;
                document.getElementById('modalPrice').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(product
                    .price);
                document.getElementById('modalDescription').textContent = product.description;
                document.getElementById('modalCategoryBadge').textContent = categoryName;
                document.getElementById('modalInputId').value = product.id;
                document.getElementById('modalStock').textContent = product.stock;
                document.getElementById('modalQty').max = product.stock;
                document.getElementById('modalQty').value = 1;

                // Show Modal
                var myModal = new bootstrap.Modal(document.getElementById('productModal'));
                myModal.show();
            }

            function incrementQty() {
                const input = document.getElementById('modalQty');
                if (parseInt(input.value) < parseInt(input.max)) {
                    input.value = parseInt(input.value) + 1;
                }
            }

            function decrementQty() {
                const input = document.getElementById('modalQty');
                if (parseInt(input.value) > 1) {
                    input.value = parseInt(input.value) - 1;
                }
            }
        </script>
        <style>
            .hover-scale:hover {
                transform: translateY(-2px);
            }

            .transition-transform {
                transition: transform 0.2s;
            }

            /* Fix modal backdrop acting weird in some bootstrap setups if nested */
            .modal-backdrop {
                z-index: 1050;
            }

            .modal {
                z-index: 1060;
            }
        </style>
    @endpush
@endsection
