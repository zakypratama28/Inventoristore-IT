@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container mt-5 pt-5">
    <div class="row g-4">
        {{-- Left Column: Cart Items --}}
        <div class="col-lg-8">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="fw-bold mb-0">Keranjang Belanja</h4>
                <span class="badge bg-primary rounded-pill px-3">{{ $items->count() }} Item</span>
            </div>

            @if($items->isEmpty())
                <div class="card border-0 shadow-sm rounded-4 text-center py-5">
                    <div class="card-body">
                        <div class="mb-4">
                            <i class="bi bi-cart-x text-muted opacity-25" style="font-size: 5rem;"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Keranjang Anda Kosong</h5>
                        <p class="text-muted mb-4">Sepertinya Anda belum menambahkan produk apapun.</p>
                        <a href="{{ route('home') }}" class="btn btn-primary rounded-pill px-4 py-2">
                            Mulai Belanja
                        </a>
                    </div>
                </div>
            @else
                <div class="d-flex flex-column gap-3">
                    @foreach($items as $item)
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-body p-3 p-md-4">
                                <div class="row align-items-center">
                                    {{-- Product Image --}}
                                    <div class="col-3 col-md-2">
                                        @if($item->product->image_url)
                                            <img src="{{ asset($item->product->image_url) }}" alt="{{ $item->product->name }}" 
                                                class="img-fluid rounded-3" style="width: 100%; aspect-ratio: 1/1; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted" 
                                                style="width: 100%; aspect-ratio: 1/1;">
                                                <i class="bi bi-camera fs-4"></i>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Product Details --}}
                                    <div class="col-9 col-md-5">
                                        <h6 class="fw-bold text-dark mb-1">{{ $item->product->name }}</h6>
                                        <p class="text-muted small mb-2">{{ $item->product->category->name ?? 'Uncategorized' }}</p>
                                        <div class="fw-semibold text-primary">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</div>
                                    </div>

                                    {{-- Quantity & Subtotal --}}
                                    <div class="col-12 col-md-5 mt-3 mt-md-0">
                                        <div class="d-flex align-items-center justify-content-between justify-content-md-end gap-3 gap-md-4">
                                            
                                            {{-- Quantity Selector --}}
                                            <form action="{{ route('cart.update', $item) }}" method="POST" class="d-flex align-items-center quantity-form">
                                                @csrf
                                                @method('PATCH')
                                                <div class="input-group input-group-sm bg-light rounded-pill border-0" style="width: 110px;">
                                                    <button type="button" class="btn btn-link text-dark text-decoration-none px-2 js-qty-btn" data-action="decrease">
                                                        <i class="bi bi-dash"></i>
                                                    </button>
                                                    <input type="number" name="quantity" class="form-control bg-transparent border-0 text-center fw-bold p-0" 
                                                        value="{{ $item->quantity }}" min="1" readonly>
                                                    <button type="button" class="btn btn-link text-dark text-decoration-none px-2 js-qty-btn" data-action="increase">
                                                        <i class="bi bi-plus"></i>
                                                    </button>
                                                </div>
                                            </form>

                                            {{-- Subtotal --}}
                                            <div class="text-end" style="min-width: 80px;">
                                                <span class="d-md-none text-muted small me-2">Subtotal:</span>
                                                <span class="fw-bold text-dark">
                                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                                </span>
                                            </div>

                                            {{-- Remove Button --}}
                                            <form action="{{ route('cart.destroy', $item) }}" method="POST" 
                                                onsubmit="return confirm('Hapus item ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-light text-danger btn-sm rounded-circle p-2" 
                                                    style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    <a href="{{ route('home') }}" class="btn btn-link text-decoration-none text-muted ps-0">
                        <i class="bi bi-arrow-left me-1"></i> Lanjut Belanja
                    </a>
                </div>
            @endif
        </div>

        {{-- Right Column: Summary --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4" style="position: sticky; top: 100px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Ringkasan Belanja</h5>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total Barang</span>
                        <span class="fw-medium">{{ $items->sum('quantity') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>

                    <div class="alert alert-success d-flex align-items-center border-0 small mb-3" 
                         style="background-color: rgba(25, 135, 84, 0.1);">
                        <i class="bi bi-check-circle-fill me-2" style="font-size: 1rem;"></i> 
                        <span>Ongkos kirim gratis untuk semua pesanan!</span>
                    </div>

                    <hr class="my-4 border-light opacity-50">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="fw-bold fs-5">Total</span>
                        <span class="fw-bold fs-4 text-primary">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </span>
                    </div>

                    <a href="{{ route('checkout.create') }}" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-sm {{ $items->isEmpty() ? 'disabled' : '' }}">
                        Lanjut ke Checkout
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('.js-qty-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const action = this.dataset.action;
            const input = this.parentElement.querySelector('input');
            const form = this.closest('form');
            let value = parseInt(input.value);

            if (action === 'increase') {
                value++;
            } else if (action === 'decrease') {
                if (value > 1) value--;
            }

            input.value = value;
            form.submit();
        });
    });
</script>
@endpush

@endsection
