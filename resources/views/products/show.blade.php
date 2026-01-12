@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="product-detail-page">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="container mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            @if($product->category)
                <li class="breadcrumb-item"><a href="{{ route('home', ['category' => $product->category->id]) }}">{{ $product->category->name }}</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($product->name, 50) }}</li>
        </ol>
    </nav>

    {{-- Main Product Section --}}
    <div class="container py-4">
        <div class="row g-4">
            {{-- Left Column: Image Gallery --}}
            <div class="col-lg-5">
                <div class="product-gallery sticky-top" style="top: 100px;">
                    {{-- Main Image --}}
                    <div class="main-image-container mb-3">
                        <img id="mainImage" 
                             src="{{ Str::startsWith($product->image_url, 'http') ? $product->image_url : asset('storage/' . $product->image_url) }}" 
                             alt="{{ $product->name }}"
                             class="img-fluid rounded-4 shadow-sm w-100"
                             style="max-height: 500px; object-fit: contain; background: #f8f9fa;">
                    </div>
                    
                    {{-- Thumbnails --}}
                    <div class="thumbnails d-flex gap-2">
                        <div class="thumbnail-item active">
                            <img src="{{ Str::startsWith($product->image_url, 'http') ? $product->image_url : asset('storage/' . $product->image_url) }}" 
                                 alt="Thumbnail 1"
                                 class="img-fluid rounded-3"
                                 onclick="changeMainImage(this.src)">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Product Info --}}
            <div class="col-lg-7">
                <div class="product-info">
                    {{-- Category Badge --}}
                    @if($product->category)
                        <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-2">
                            <i class="bi bi-tag me-1"></i>{{ $product->category->name }}
                        </span>
                    @endif

                    {{-- Product Name --}}
                    <h1 class="product-title fw-bold mb-3" style="font-size: 1.75rem;">{{ $product->name }}</h1>

                    {{-- Rating & Reviews --}}
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="d-flex align-items-center">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star-fill" style="color: {{ $i <= floor($avgRating) ? '#FFD700' : '#e0e0e0' }}; font-size: 1rem;"></i>
                            @endfor
                            <span class="ms-2 fw-semibold">{{ number_format($avgRating, 1) }}</span>
                        </div>
                        <span class="text-muted">•</span>
                        <a href="#reviews-section" class="text-decoration-none text-primary">
                            {{ $totalReviews }} {{ $totalReviews == 1 ? 'ulasan' : 'ulasan' }}
                        </a>
                        <span class="text-muted">•</span>
                        <span class="text-muted">Terjual {{ $product->sold_count ?? 0 }}+</span>
                    </div>

                    {{-- Price --}}
                    <div class="price-section mb-4">
                        <h2 class="price fw-bold mb-0" style="font-size: 2rem; color: #0d6efd;">
                            Rp{{ number_format($product->price, 0, ',', '.') }}
                        </h2>
                    </div>

                    {{-- Stock Info --}}
                    <div class="stock-info mb-4">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted">Stok:</span>
                            <span class="fw-semibold {{ $realStock > 10 ? 'text-success' : ($realStock > 0 ? 'text-warning' : 'text-danger') }}">
                                {{ $realStock > 0 ? $realStock . ' unit tersedia' : 'Habis' }}
                            </span>
                        </div>
                    </div>

                    {{-- Quantity Selector --}}
                    <div class="quantity-section mb-4">
                        <label class="form-label fw-semibold">Atur Jumlah</label>
                        <div class="d-flex align-items-center gap-3">
                            <div class="input-group" style="width: 150px;">
                                <button class="btn btn-outline-secondary" type="button" onclick="decrementQuantity()">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <input type="number" id="quantity" class="form-control text-center" value="1" min="1" max="{{ $realStock }}" readonly>
                                <button class="btn btn-outline-secondary" type="button" onclick="incrementQuantity()">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                            <span class="text-muted small">Max: {{ $realStock }}</span>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="action-buttons mb-4">
                        <form action="{{ route('cart.store') }}" method="POST" class="add-to-cart-form">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" id="cartQuantity" value="1">
                            
                            <div class="d-flex gap-2 mb-3">
                                <button type="submit" class="btn btn-primary btn-lg flex-grow-1" {{ $realStock <= 0 ? 'disabled' : '' }}>
                                    <i class="bi bi-cart-plus me-2"></i>
                                    {{ $realStock > 0 ? '+ Keranjang' : 'Stok Habis' }}
                                </button>
                            </div>
                        </form>

                        <div class="d-flex gap-2">
                            {{-- Wishlist Button --}}
                            @auth
                                <button type="button" class="btn btn-outline-danger flex-grow-1" id="wishlistBtn" 
                                        data-product-id="{{ $product->id }}"
                                        data-in-wishlist="{{ auth()->user()->hasInWishlist($product->id) ? 'true' : 'false' }}">
                                    <i class="bi {{ auth()->user()->hasInWishlist($product->id) ? 'bi-heart-fill' : 'bi-heart' }}" id="wishlistIcon"></i>
                                    <span id="wishlistText">{{ auth()->user()->hasInWishlist($product->id) ? 'Favorit' : 'Favorit' }}</span>
                                </button>
                            @else
                                <button type="button" class="btn btn-outline-danger flex-grow-1" 
                                        onclick="alert('Silakan login terlebih dahulu'); window.location.href='{{ route('login') }}';">
                                    <i class="bi bi-heart"></i> Favorit
                                </button>
                            @endauth

                            <button type="button" class="btn btn-outline-secondary">
                                <i class="bi bi-share"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Product Features (if applicable) --}}
                    <div class="product-features card border-0 bg-light p-3 rounded-4">
                        <h6 class="fw-bold mb-2"><i class="bi bi-shield-check me-2 text-success"></i>Keunggulan Produk</h6>
                        <ul class="list-unstyled mb-0 small">
                            <li class="mb-1"><i class="bi bi-check-circle-fill text-success me-2"></i>Produk Original</li>
                            <li class="mb-1"><i class="bi bi-check-circle-fill text-success me-2"></i>Garansi Resmi</li>
                            <li class="mb-0"><i class="bi bi-check-circle-fill text-success me-2"></i>Gratis Ongkir (min. Rp100.000)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Product Description Section --}}
        <div class="row mt-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h3 class="fw-bold mb-4"><i class="bi bi-journal-text me-2"></i>Detail Produk</h3>
                        <div class="product-description">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Reviews Section --}}
        <div class="row mt-5" id="reviews-section">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-0">
                        <div class="p-4 border-bottom">
                            <h3 class="fw-bold mb-0"><i class="bi bi-star-fill text-warning me-2"></i>Ulasan Pembeli</h3>
                        </div>

                        <div class="row g-0">
                            {{-- Left Sidebar: Rating Overview & Filters --}}
                            <div class="col-lg-3 border-end p-4">
                                {{-- Rating Overview --}}
                                <div class="rating-overview text-center mb-4 p-4 bg-light rounded-4">
                                    <div class="display-4 fw-bold text-warning mb-2">
                                        <i class="bi bi-star-fill"></i> {{ number_format($avgRating, 1) }}
                                    </div>
                                    <div class="text-muted mb-1">{{ number_format($avgRating, 1) }}/5.0</div>
                                    <div class="small text-muted">{{ $totalReviews }} rating • {{ $totalReviews }} ulasan</div>
                                    @if($totalReviews > 0)
                                        <div class="small fw-semibold text-success mt-2">
                                            {{ round(($ratingBreakdown[5] / $totalReviews) * 100) }}% pembeli merasa puas
                                        </div>
                                    @endif
                                </div>

                                {{-- Filter by Rating --}}
                                <div class="filter-section">
                                    <h6 class="fw-bold mb-3">Rating</h6>
                                    <div class="d-flex flex-column gap-2">
                                        @foreach([5,4,3,2,1] as $star)
                                            <button class="btn btn-sm btn-outline-secondary text-start rating-filter-btn" data-rating="{{ $star }}">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <span>
                                                        @for($i = 0; $i < $star; $i++)
                                                            <i class="bi bi-star-fill" style="color: #FFD700; font-size: 0.8rem;"></i>
                                                        @endfor
                                                    </span>
                                                    <span class="badge bg-secondary-subtle text-secondary">{{ $ratingBreakdown[$star] }}</span>
                                                </div>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            {{-- Right Content: Reviews List --}}
                            <div class="col-lg-9 p-4">
                                {{-- Rating Breakdown Bars --}}
                                <div class="rating-bars mb-4">
                                    @foreach([5,4,3,2,1] as $star)
                                        <div class="d-flex align-items-center gap-3 mb-2">
                                            <div style="width: 60px;">
                                                <span class="small">{{ $star }} <i class="bi bi-star-fill" style="color: #FFD700; font-size: 0.75rem;"></i></span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="progress" style="height: 8px;">
                                                    @php
                                                        $percentage = $totalReviews > 0 ? ($ratingBreakdown[$star] / $totalReviews) * 100 : 0;
                                                    @endphp
                                                    <div class="progress-bar" role="progressbar" 
                                                         style="width: {{ $percentage }}%; background-color: #FFD700;" 
                                                         aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div style="width: 40px;" class="text-end">
                                                <span class="small text-muted">({{ $ratingBreakdown[$star] }})</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <hr class="my-4">

                                {{-- Review Header --}}
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0">Menampilkan {{ $reviews->count() }} dari {{ $totalReviews }} ulasan</h6>
                                    <select class="form-select form-select-sm w-auto">
                                        <option>Paling Membantu</option>
                                        <option>Terbaru</option>
                                        <option>Rating Tertinggi</option>
                                        <option>Rating Terendah</option>
                                    </select>
                                </div>

                                {{-- Reviews List --}}
                                <div class="reviews-list">
                                    @forelse($reviews as $review)
                                        <div class="review-card p-3 mb-3 border rounded-3">
                                            <div class="d-flex gap-3">
                                                {{-- User Avatar --}}
                                                <div class="flex-shrink-0">
                                                    <div class="avatar-circle bg-primary text-white d-flex align-items-center justify-content-center rounded-circle" 
                                                         style="width: 48px; height: 48px; font-size: 1.25rem;">
                                                        {{ strtoupper(substr($review->user->name ?? 'A', 0, 1)) }}
                                                    </div>
                                                </div>

                                                {{-- Review Content --}}
                                                <div class="flex-grow-1">
                                                    <div class="mb-1">
                                                        <span class="fw-semibold">{{ $review->user->name ?? 'Anonymous' }}</span>
                                                        <span class="text-muted mx-2">•</span>
                                                        <span class="text-muted small">{{ $review->created_at->diffForHumans() }}</span>
                                                    </div>

                                                    {{-- Rating Stars --}}
                                                    <div class="mb-2">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="bi bi-star-fill" style="color: {{ $i <= $review->rating ? '#FFD700' : '#e0e0e0' }}; font-size: 0.9rem;"></i>
                                                        @endfor
                                                    </div>

                                                    {{-- Review Text --}}
                                                    <p class="mb-2">{{ $review->review_text }}</p>

                                                    {{-- Review Images --}}
                                                    @if($review->images)
                                                        @php
                                                            $images = json_decode($review->images, true) ?? [];
                                                        @endphp
                                                        @if(count($images) > 0)
                                                            <div class="review-images d-flex gap-2 mb-2">
                                                                @foreach($images as $image)
                                                                    <img src="{{ asset('storage/' . $image) }}" 
                                                                         alt="Review image" 
                                                                         class="rounded" 
                                                                         style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;">
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    @endif

                                                    {{-- Helpful Button --}}
                                                    <div class="mt-2">
                                                        <button class="btn btn-sm btn-outline-secondary">
                                                            <i class="bi bi-hand-thumbs-up me-1"></i> Membantu
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-5">
                                            <i class="bi bi-chat-left-text text-muted" style="font-size: 3rem;"></i>
                                            <p class="text-muted mt-3">Belum ada ulasan untuk produk ini</p>
                                        </div>
                                    @endforelse
                                </div>

                                {{-- Pagination --}}
                                @if($reviews->hasPages())
                                    <div class="mt-4">
                                        {{ $reviews->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Image Gallery
function changeMainImage(src) {
    document.getElementById('mainImage').src = src;
    
    // Update active thumbnail
    document.querySelectorAll('.thumbnail-item').forEach(thumb => {
        thumb.classList.remove('active');
    });
    event.target.closest('.thumbnail-item').classList.add('active');
}

// Quantity Controls
function incrementQuantity() {
    const input = document.getElementById('quantity');
    const max = parseInt(input.max);
    const current = parseInt(input.value);
    
    if (current < max) {
        input.value = current + 1;
        document.getElementById('cartQuantity').value = current + 1;
    }
}

function decrementQuantity() {
    const input = document.getElementById('quantity');
    const current = parseInt(input.value);
    
    if (current > 1) {
        input.value = current - 1;
        document.getElementById('cartQuantity').value = current - 1;
    }
}

// Sync quantity
document.getElementById('quantity').addEventListener('change', function() {
    document.getElementById('cartQuantity').value = this.value;
});

// Wishlist Toggle
@auth
document.addEventListener('DOMContentLoaded', function() {
    const wishlistBtn = document.getElementById('wishlistBtn');
    if (!wishlistBtn) return;
    
    wishlistBtn.addEventListener('click', async function() {
        const btn = this;
        const productId = btn.dataset.productId;
        const isInWishlist = btn.dataset.inWishlist === 'true';
        const icon = document.getElementById('wishlistIcon');
        
        try {
            let response;
            if (isInWishlist) {
                response = await fetch(`{{ url('/wishlist') }}/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    }
                });
            } else {
                response = await fetch('{{ url('/wishlist') }}', {
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
                    icon.classList.remove('bi-heart-fill');
                    icon.classList.add('bi-heart');
                } else {
                    icon.classList.remove('bi-heart');
                    icon.classList.add('bi-heart-fill');
                }
            }
        } catch (error) {
            console.error('Wishlist error:', error);
            alert('Gagal menambahkan ke wishlist. Silakan coba lagi.');
        }
    });
});
@endauth
</script>
@endpush

@push('styles')
<style>
.product-detail-page {
    background: #f8f9fa;
    min-height: 100vh;
}

.breadcrumb {
    background: none;
    padding: 0;
    margin: 0;
}

.breadcrumb-item a {
    color: #6c757d;
    text-decoration: none;
}

.breadcrumb-item a:hover {
    color: #0d6efd;
}

.product-gallery .thumbnail-item {
    width: 80px;
    height: 80px;
    border: 2px solid transparent;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.3s ease;
}

.product-gallery .thumbnail-item.active {
    border-color: #0d6efd;
}

.product-gallery .thumbnail-item:hover {
    border-color: #0d6efd;
    opacity: 0.8;
}

.product-gallery .thumbnail-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.action-buttons .btn {
    font-weight: 600;
    padding: 12px 24px;
    border-radius: 8px;
}

.review-card {
    transition: all 0.2s ease;
}

.review-card:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.rating-filter-btn {
    transition: all 0.2s ease;
}

.rating-filter-btn:hover {
    background-color: #0d6efd;
    color: white;
    border-color: #0d6efd;
}

.review-images img:hover {
    transform: scale(1.05);
    transition: transform 0.2s ease;
}
</style>
@endpush
@endsection
