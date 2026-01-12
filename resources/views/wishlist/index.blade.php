@extends('layouts.app')

@section('content')
<div class="container py-5" style="margin-top: 80px;">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">
                <i class="bi bi-heart-fill text-danger me-2"></i>
                Daftar Favorit
            </h2>
            <p class="text-muted">Simpan produk favoritmu dan belanja nanti</p>
        </div>
    </div>

    @if($wishlists->isEmpty())
        <div class="row">
            <div class="col-12">
                <div class="card text-center py-5">
                    <div class="card-body">
                        <i class="bi bi-heart display-1 text-muted mb-3"></i>
                        <h4>Daftar Favoritmu Masih Kosong</h4>
                        <p class="text-muted">Yuk, pilih produk favorit dan simpan di sini agar mudah ditemukan!</p>
                        <a href="{{ route('home') }}" class="btn btn-primary mt-3">
                            <i class="bi bi-shop me-2"></i>Mulai Belanja
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($wishlists as $wishlist)
                <div class="col-md-6 col-lg-4">
                    <div class="card product-card h-100 border-0 shadow-sm">
                        <div class="position-relative">
                            <img src="{{ $wishlist->product->image_url }}" 
                                 class="card-img-top" 
                                 alt="{{ $wishlist->product->name }}"
                                 style="height: 250px; object-fit: cover;">
                            
                            @if(!$wishlist->product->isInStock())
                                <span class="badge bg-danger position-absolute top-0 end-0 m-3">
                                    Habis
                                </span>
                            @elseif($wishlist->product->isLowStock())
                                <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-3">
                                    Stok Terbatas
                                </span>
                            @endif

                            <form action="{{ route('wishlist.destroy', $wishlist) }}" 
                                  method="POST" 
                                  class="position-absolute top-0 start-0 m-3">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-light btn-sm rounded-circle" style="width: 40px; height: 40px;">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </form>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <span class="badge bg-primary-subtle text-primary mb-2 align-self-start">
                                {{ $wishlist->product->category->name ?? 'Tanpa Kategori' }}
                            </span>
                            
                            <h5 class="card-title">{{ $wishlist->product->name }}</h5>
                            
                            <p class="card-text text-muted small flex-grow-1">
                                {{ Str::limit($wishlist->product->description, 100) }}
                            </p>

                            @if($wishlist->product->averageRating() > 0)
                                <div class="mb-2">
                                    <span class="text-warning">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= $wishlist->product->averageRating() ? '-fill' : '' }}"></i>
                                        @endfor
                                    </span>
                                    <small class="text-muted">({{ $wishlist->product->totalReviews() }})</small>
                                </div>
                            @endif

                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <h4 class="text-primary mb-0">Rp {{ number_format($wishlist->product->price, 0, ',', '.') }}</h4>
                                
                                @if($wishlist->product->isInStock())
                                    <form action="{{ route('cart.store') }}" method="POST" class="add-to-cart-form">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $wishlist->product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="bi bi-cart-plus me-1"></i>+ Keranjang
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>
                                        Stok Habis
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    .product-card {
        transition: transform 0.3s, box-shadow 0.3s;
        overflow: hidden;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2) !important;
    }

    .product-card img {
        transition: transform 0.3s;
    }

    .product-card:hover img {
        transform: scale(1.05);
    }
</style>

@push('scripts')
<script>
document.querySelectorAll('.add-to-cart-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('{{ url('/cart') }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error('HTTP error! status: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if(data.success) {
                alert('Produk berhasil ditambahkan ke keranjang!');
                // Update cart badge
                const badge = document.querySelector('.cart-count');
                if(badge) {
                    badge.textContent = parseInt(badge.textContent || 0) + 1;
                }
                // Reload page to update cart sidebar
                window.location.reload();
            } else {
                alert(data.message || 'Gagal menambahkan ke keranjang');
            }
        })
        .catch(error => {
            console.error('Error details:', error);
            alert('Error: ' + error.message);
        });
    });
});
</script>
@endpush
@endsection
