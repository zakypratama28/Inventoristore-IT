@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container py-5">
    <div class="row g-4">
        {{-- Left Column: Forms --}}
        <div class="col-lg-8">
            <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
                @csrf
                
                {{-- Shipping Address --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="fw-bold mb-0">Alamat Pengiriman</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-medium text-muted small text-uppercase ls-1">Alamat Lengkap</label>
                            <textarea name="shipping_address" rows="4" 
                                class="form-control bg-light border-0 rounded-3 @error('shipping_address') is-invalid @enderror"
                                placeholder="Masukkan nama jalan, nomor rumah, kecamatan, dan kota..."
                                required>{{ old('shipping_address') }}</textarea>
                            @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="alert alert-info border-0 d-flex align-items-center small mb-0">
                            <i class="bi bi-info-circle me-2 fs-5"></i>
                            <div>pastikan alamat yang anda masukkan sudah benar untuk memudahkan pengiriman.</div>
                        </div>
                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="fw-bold mb-0">Metode Pembayaran</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex flex-column gap-3">
                            @foreach ($methods as $method)
                                <label class="card border p-3 rounded-3 cursor-pointer position-relative hover-shadow transition-all" 
                                    for="pm-{{ $method->value }}">
                                    <div class="d-flex align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input fs-5" type="radio" name="payment_method"
                                                id="pm-{{ $method->value }}" value="{{ $method->value }}"
                                                {{ old('payment_method', $methods[0]->value) === $method->value ? 'checked' : '' }}>
                                        </div>
                                        <div class="ms-3">
                                            <span class="fw-bold d-block text-dark">{{ $method->label() }}</span>
                                            <small class="text-muted">
                                                @if($method->value === 'cod')
                                                    Bayar tunai saat kurir tiba di alamat Anda.
                                                @elseif($method->value === 'bank_transfer')
                                                    Transfer manual ke rekening BCA/Mandiri kami.
                                                @else
                                                    Pembayaran digital (OVO/GoPay/Dana).
                                                @endif
                                            </small>
                                        </div>
                                        <div class="ms-auto text-muted">
                                            @if($method->value === 'cod')
                                                <i class="bi bi-cash-coin fs-4"></i>
                                            @elseif($method->value === 'bank_transfer')
                                                <i class="bi bi-bank fs-4"></i>
                                            @else
                                                <i class="bi bi-wallet2 fs-4"></i>
                                            @endif
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('payment_method')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </form>
        </div>

        {{-- Right Column: Order Summary --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4" style="position: sticky; top: 100px;">
                <div class="card-header bg-primary text-white border-0 py-3 rounded-top-4">
                    <h5 class="fw-bold mb-0 text-center">Ringkasan Pesanan</h5>
                </div>
                <div class="card-body p-4">
                    
                    {{-- Product List (Compact) --}}
                    <div class="mb-4">
                        <h6 class="text-muted small text-uppercase ls-1 fw-bold mb-3">Item Dibeli ({{ $items->count() }})</h6>
                        <div class="d-flex flex-column gap-3 max-h-300 overflow-auto pe-1">
                            @foreach ($items as $item)
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 position-relative">
                                         @if($item->product->image_url)
                                            <img src="{{ asset($item->product->image_url) }}" class="rounded bg-light" width="48" height="48" style="object-fit:cover">
                                        @else
                                            <div class="rounded bg-light d-flex align-items-center justify-content-center text-muted" style="width:48px; height:48px">
                                                <i class="bi bi-box"></i>
                                            </div>
                                        @endif
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark border border-white small">
                                            {{ $item->quantity }}
                                        </span>
                                    </div>
                                    <div class="ms-3 flex-grow-1">
                                        <h6 class="mb-0 small fw-bold text-truncate" style="max-width: 150px;">{{ $item->product->name }}</h6>
                                        <small class="text-muted">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="fw-medium small">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <hr class="border-light opacity-50">

                    {{-- Totals --}}
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Ongkos Kirim</span>
                        <span class="text-success fw-medium">Gratis</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4 pt-2 border-top">
                        <span class="fw-bold fs-5">Total</span>
                        <span class="fw-bold fs-4 text-primary">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </span>
                    </div>

                    {{-- Actions --}}
                    <button type="submit" form="checkoutForm" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-sm mb-3">
                        Buat Pesanan Sekarang
                    </button>
                    
                    <div class="text-center">
                        <a href="{{ route('cart.index') }}" class="text-muted text-decoration-none small">
                            <i class="bi bi-arrow-left me-1"></i> Kembali ke Keranjang
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .cursor-pointer { cursor: pointer; }
    .hover-shadow:hover { box-shadow: 0 .5rem 1rem rgba(0,0,0,.08) !important; border-color: var(--color-primary) !important; background-color: #f8faff; }
    .transition-all { transition: all 0.2s ease; }
    
    /* Highlight selected radio card */
    input[type="radio"]:checked + div + div i { color: var(--color-primary); }
    input[type="radio"]:checked ~ div small { color: #4b5563 !important; }
</style>

<script>
    // Optional: Add active class styling to selected radio card parent label
    document.querySelectorAll('input[type="radio"][name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('input[name="payment_method"]').forEach(r => {
                r.closest('label').classList.remove('border-primary', 'bg-light');
            });
            if(this.checked) {
                this.closest('label').classList.add('border-primary', 'bg-light');
            }
        });
        // Init state
        if(radio.checked) {
            radio.closest('label').classList.add('border-primary', 'bg-light');
        }
    });
</script>
@endsection
