@extends('layouts.app')

@section('content')
    {{-- HERO SECTION --}}
    <section class="hero-section position-relative d-flex align-items-center text-white" 
        style="min-height: 600px; background-image: url('{{ asset('material-dashboard/assets/img/Gamingwall.jpg') }}'); background-size: cover; background-position: center;">
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-75"></div>
        <div class="container position-relative z-2">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary mb-3 px-4 py-2 rounded-pill fw-bold shadow-sm backdrop-blur-sm">
                        New Collection 2025
                    </span>
                    <h1 class="display-2 fw-bold mb-3 text-white text-shadow-sm">Temukan Perangkat Gaming & Gadget Anda</h1>
                    <p class="lead mb-5 text-white opacity-90 text-shadow-sm">
                        Koleksi lengkap kebutuhan gaming & gadget terbaru dengan harga terbaik terpercaya.
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="#products" class="btn btn-primary btn-lg px-5 fw-semibold shadow-lg rounded-pill hover-scale">Belanja
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
                        @php
                            $cartQty = 0;
                            if(auth()->check()) {
                                $cartQty = \App\Models\CartItem::where('user_id', auth()->id())
                                            ->where('product_id', $product->id)
                                            ->sum('quantity');
                            }
                            $realStock = $product->stock - $cartQty;
                            $isOutOfStock = $realStock <= 0;
                        @endphp
                        <div class="col">
                            <div class="card-product d-flex flex-column h-100 position-relative group">
                                <div class="img-wrapper position-relative overflow-hidden">
                                    {{-- Click triggers detail page --}}
                                    <a href="{{ route('products.show', $product->id) }}"
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

                                    @if($isOutOfStock)
                                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex align-items-center justify-content-center z-2">
                                            <span class="badge bg-danger fs-5 px-4 py-2 shadow">Habis</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="card-body d-flex flex-column p-4">
                                    <h6 class="card-title fw-bold text-dark mb-1 text-truncate">
                                        <a href="{{ route('products.show', $product->id) }}"
                                            class="text-decoration-none text-dark">
                                            {{ $product->name }}
                                        </a>
                                    </h6>
                                    <div class="mb-3 d-flex justify-content-between align-items-center">
                                        <span class="h5 fw-bold text-primary mb-0">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</span>
                                        <small class="text-muted fw-medium">Stok: {{ $realStock }}</small>
                                    </div>


                                    {{-- Action Buttons --}}
                                    <div class="d-flex gap-2">
                                        <button type="button"
                                            class="btn btn-primary flex-grow-1 product-modal-trigger"
                                            data-product-id="{{ $product->id }}"
                                            data-product-name="{{ $product->name }}"
                                            data-product-price="{{ $product->price }}"
                                            data-product-description="{{ $product->description }}"
                                            data-product-image="{{ Str::startsWith($product->image_url, 'http') ? $product->image_url : asset('storage/' . $product->image_url) }}"
                                            data-product-category="{{ $product->category->name ?? '' }}"
                                            data-product-stock="{{ $realStock }}"
                                            {{ $isOutOfStock ? 'disabled' : '' }}>
                                            <i class="bi bi-cart-plus"></i> {{ $isOutOfStock ? 'Habis' : 'Tambah' }}
                                        </button>
                                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </div>
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
                                <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                                    <span id="modalCategoryBadge"
                                        class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-medium">
                                        Category
                                    </span>
                                    
                                    {{-- Wishlist Button --}}
                                    <div id="modalWishlistContainer"></div>
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
            // Event Delegation for Product Modal Triggers
            document.addEventListener('click', function(e) {
                const trigger = e.target.closest('.product-modal-trigger');
                if (!trigger) return;
                
                e.preventDefault();
                
                // Get product data from data attributes
                const productData = {
                    id: trigger.dataset.productId,
                    name: trigger.dataset.productName,
                    price: trigger.dataset.productPrice,
                    description: trigger.dataset.productDescription
                };
                const imageUrl = trigger.dataset.productImage;
                const categoryName = trigger.dataset.productCategory;
                const realStock = parseInt(trigger.dataset.productStock);
                
                showProductModal(productData, imageUrl, categoryName, realStock);
            });
            
            function showProductModal(product, imageUrl, categoryName, realStock) {
                // Populate Data
                document.getElementById('modalTitle').textContent = product.name;
                document.getElementById('modalImage').src = imageUrl;
                document.getElementById('modalPrice').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(product
                    .price);
                document.getElementById('modalDescription').textContent = product.description;
                document.getElementById('modalCategoryBadge').textContent = categoryName;
                document.getElementById('modalInputId').value = product.id;
                
                // Render Wishlist Button
                const wishlistContainer = document.getElementById('modalWishlistContainer');
                @auth
                    wishlistContainer.innerHTML = `
                        <button type="button" class="btn wishlist-toggle-btn" 
                                data-product-id="${product.id}" data-in-wishlist="false"
                                style="width: 42px; height: 42px; border-radius: 50%; border: 2px solid #e0e0e0; background: white;"
                                title="Tambah ke Wishlist">
                            <i class="bi bi-heart wishlist-icon" style="font-size: 1.25rem;"></i>
                        </button>
                    `;
                    
                    fetch(`/wishlist/check/${product.id}`, {
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }
                    })
                    .then(r => r.json())
                    .then(data => {
                        const btn = wishlistContainer.querySelector('.wishlist-toggle-btn');
                        const icon = btn.querySelector('.wishlist-icon');
                        if (data.inWishlist) {
                            btn.dataset.inWishlist = 'true';
                            btn.style.borderColor = '#e91e63'; btn.style.background = 'rgba(233,30,99,0.1)';
                            icon.classList.remove('bi-heart'); icon.classList.add('bi-heart-fill');
                            icon.style.color = '#e91e63'; btn.title = 'Hapus dari Wishlist';
                        }
                    });
                @else
                    wishlistContainer.innerHTML = `
                        <button type="button" class="btn" 
                                onclick="alert('Silakan login terlebih dahulu'); window.location.href='{{ route('login') }}';"
                                style="width: 42px; height: 42px; border-radius: 50%; border: 2px solid #e0e0e0; background: white;">
                            <i class="bi bi-heart" style="font-size: 1.25rem;"></i>
                        </button>
                    `;
                @endauth
                
                // Stock Logic
                const stockElement = document.getElementById('modalStock');
                stockElement.textContent = realStock;
                
                const qtyInput = document.getElementById('modalQty');
                const addToCartBtn = document.querySelector('#productModal button[type="submit"]');
                
                if (realStock > 0) {
                    qtyInput.max = realStock;
                    qtyInput.value = 1;
                    qtyInput.disabled = false;
                    addToCartBtn.disabled = false;
                    addToCartBtn.textContent = 'Add to cart';
                } else {
                    qtyInput.value = 0;
                    qtyInput.disabled = true;
                    addToCartBtn.disabled = true;
                    addToCartBtn.textContent = 'Stok Habis';
                }

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
            
            // Wishlist Toggle Handler for Modal (Event Delegation)
            @auth
            document.addEventListener('click', async function(e) {
                const btn = e.target.closest('.wishlist-toggle-btn');
                if (!btn) return;
                
                e.preventDefault();
                e.stopPropagation();
                
                const productId = btn.dataset.productId;
                const isInWishlist = btn.dataset.inWishlist === 'true';
                const icon = btn.querySelector('.wishlist-icon');
                
                try {
                    let response;
                    if (isInWishlist) {
                        response = await fetch(`/wishlist/${productId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            }
                        });
                    } else {
                        response = await fetch('/wishlist', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({ product_id: productId })
                        });
                    }
                    
                    const data = await response.json();
                    
                    if (response.ok) {
                        btn.dataset.inWishlist = !isInWishlist;
                        if (isInWishlist) {
                            btn.style.borderColor = '#e0e0e0'; btn.style.background = 'white';
                            icon.classList.remove('bi-heart-fill'); icon.classList.add('bi-heart');
                            icon.style.color = ''; btn.title = 'Tambah ke Wishlist';
                        } else {
                            btn.style.borderColor = '#e91e63'; btn.style.background = 'rgba(233,30,99,0.1)';
                            icon.classList.remove('bi-heart'); icon.classList.add('bi-heart-fill');
                            icon.style.color = '#e91e63'; btn.title = 'Hapus dari Wishlist';
                        }
                    }
                } catch (error) {
                    console.error('Wishlist error:', error);
                }
            });
            @endauth
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

            /* === PRODUCT CARD LAYOUT FIXES === */
            .card-product {
                border: 1px solid #e5e7eb;
                border-radius: 1rem;
                background: white;
                transition: all 0.3s ease;
                min-height: 480px; /* Ensure consistent minimum height */
            }

            .card-product:hover {
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
                transform: translateY(-5px);
            }

            /* Fixed aspect ratio for product images */
            .card-product .img-wrapper {
                position: relative;
                width: 100%;
                padding-top: 75%; /* 4:3 aspect ratio */
                background: #f8f9fa;
            }

            .card-product .img-wrapper img {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            /* Category badge positioning */
            .card-product .category-badge {
                position: absolute;
                top: 12px;
                left: 12px;
                z-index: 1;
                background: rgba(255, 255, 255, 0.95);
                color: #4f46e5;
                padding: 0.375rem 0.875rem;
                border-radius: 999px;
                font-size: 0.75rem;
                font-weight: 600;
                backdrop-filter: blur(10px);
            }

            /* Card body consistent spacing */
            .card-product .card-body {
                flex: 1;
                display: flex;
                flex-direction: column;
                min-height: 180px; /* Ensure consistent body height */
            }

            /* Product title height consistency */
            .card-product .card-title {
                height: 2.5em; /* 2 lines max */
                overflow: hidden;
                line-height: 1.25;
            }

            /* Price and stock row fixed height */
            .card-product .card-body > div:nth-child(2) {
                height: 2.5rem;
            }

            /* Push buttons to bottom */
            .card-product .card-body > div:last-child {
                margin-top: auto;
            }

            /* Consistent button heights */
            .card-product .btn {
                padding: 0.625rem 1rem;
                font-size: 0.875rem;
                font-weight: 500;
            }
        </style>
    @endpush
@endsection
