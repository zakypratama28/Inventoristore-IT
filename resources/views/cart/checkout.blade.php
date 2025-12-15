@extends('layouts.inventory')

@section('title', 'Checkout')
@section('page-title', 'Checkout')

@section('content')
    <div class="row">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0">
                    <h6 class="mb-0">Alamat Pengiriman</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('cart.checkout') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small">Alamat Lengkap</label>
                            <textarea name="shipping_address" class="form-control" rows="3" required>{{ old('shipping_address') }}</textarea>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small">Kota</label>
                                <input type="text" name="shipping_city" class="form-control"
                                    value="{{ old('shipping_city') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Kode Pos</label>
                                <input type="text" name="shipping_postal_code" class="form-control"
                                    value="{{ old('shipping_postal_code') }}">
                            </div>
                        </div>

                        <hr class="my-4">

                        <h6 class="mb-3">Metode Pembayaran</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment_method" id="pm1"
                                value="bank_transfer" checked>
                            <label class="form-check-label" for="pm1">
                                Transfer Bank
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment_method" id="pm2"
                                value="cod">
                            <label class="form-check-label" for="pm2">
                                Bayar di Tempat (COD)
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="payment_method" id="pm3"
                                value="ewallet">
                            <label class="form-check-label" for="pm3">
                                E-Wallet
                            </label>
                        </div>

                        <button type="submit" class="btn btn-success">
                            Buat Pesanan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h6 class="mb-0">Ringkasan Pesanan</h6>
                </div>
                <div class="card-body">
                    @foreach ($items as $item)
                        <div class="d-flex mb-3">
                            <img src="{{ $item->product->image_url }}" class="rounded me-3"
                                style="width:60px;height:60px;object-fit:cover;">
                            <div class="flex-grow-1">
                                <div class="fw-semibold">{{ $item->product->name }}</div>
                                <small class="text-muted">
                                    {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                                </small>
                            </div>
                            <div class="text-end">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                    <hr>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Ongkos Kirim</span>
                        <span>Rp {{ number_format($shipping, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <strong>Total</strong>
                        <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
