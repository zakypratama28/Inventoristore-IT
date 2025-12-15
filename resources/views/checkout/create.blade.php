@extends('layouts.inventory')

@section('title', 'Checkout')
@section('page-title', 'Checkout')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0">
                    <h6 class="mb-0">Alamat Pengiriman</h6>
                    <small class="text-muted">Masukkan alamat lengkap tujuan pengiriman barang.</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('checkout.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small text-muted">Alamat Lengkap</label>
                            <textarea name="shipping_address" rows="3" class="form-control @error('shipping_address') is-invalid @enderror"
                                required>{{ old('shipping_address') }}</textarea>
                            @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-muted mb-2">Metode Pembayaran</label>
                            @foreach ($methods as $method)
                                <div class="form-check mb-1">
                                    <input class="form-check-input" type="radio" name="payment_method"
                                        id="pm-{{ $method->value }}" value="{{ $method->value }}"
                                        {{ old('payment_method', $methods[0]->value) === $method->value ? 'checked' : '' }}>
                                    <label class="form-check-label" for="pm-{{ $method->value }}">
                                        {{ $method->label() }}
                                    </label>
                                </div>
                            @endforeach
                            @error('payment_method')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Subtotal</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Ongkos Kirim</span>
                            <span>Rp {{ number_format($shipping, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-semibold">Total</span>
                            <span class="fw-bold text-success">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </span>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Buat Pesanan
                        </button>
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary ms-2">
                            Kembali ke Keranjang
                        </a>
                    </form>
                </div>
            </div>

            {{-- ringkas item --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h6 class="mb-0">Ringkasan Produk</h6>
                </div>
                <div class="card-body">
                    @foreach ($items as $item)
                        <div class="d-flex justify-content-between mb-2">
                            <div>
                                <div class="fw-semibold">{{ $item->product->name }}</div>
                                <div class="text-muted small">x{{ $item->quantity }}</div>
                            </div>
                            <div class="text-end">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
