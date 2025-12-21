@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->code)

@section('content')
<div class="container mt-5 pt-5">
    <div class="row g-4 mb-5">
        {{-- Header Section --}}
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center bg-white p-4 rounded-4 shadow-sm border mb-4">
                <div class="mb-3 mb-md-0">
                    <h4 class="fw-bold mb-1 text-primary">Pesanan #{{ $order->code }}</h4>
                    <p class="text-muted mb-0 small">
                        Dipesan pada {{ $order->created_at->format('d M Y, H:i') }}
                    </p>
                </div>
                <div class="text-end">
                    @php
                        $statusColor = match($order->status) {
                            'paid', 'completed' => 'success',
                            'cancelled' => 'danger',
                            default => 'warning'
                        };
                        $statusLabel = match($order->status) {
                            'paid' => 'Sudah Dibayar',
                            'pending' => 'Menunggu Pembayaran',
                            'cancelled' => 'Dibatalkan',
                            'completed' => 'Selesai',
                            'shipped' => 'Dikirim',
                            default => ucfirst($order->status)
                        };
                    @endphp
                    <span class="badge bg-{{ $statusColor }} fs-6 px-4 py-2 rounded-pill shadow-sm">
                        {{ $statusLabel }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Left Column --}}
        <div class="col-lg-8">
            {{-- Product List --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="card-header bg-white border-0 py-3 border-bottom">
                    <h6 class="fw-bold mb-0">Daftar Produk</h6>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-secondary text-uppercase text-xs font-weight-bold" style="width: 45%">Produk</th>
                                <th class="text-center py-3 text-secondary text-uppercase text-xs font-weight-bold">Harga</th>
                                <th class="text-center py-3 text-secondary text-uppercase text-xs font-weight-bold">Qty</th>
                                <th class="text-end pe-4 py-3 text-secondary text-uppercase text-xs font-weight-bold">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            @if($item->product && $item->product->image_path)
                                                <img src="{{ asset('storage/' . $item->product->image_path) }}" 
                                                    class="rounded-3 border" 
                                                    style="width: 60px; height: 60px; object-fit: cover;" 
                                                    alt="{{ $item->product_name }}">
                                            @else
                                                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-secondary border" 
                                                    style="width: 60px; height: 60px;">
                                                    <i class="bi bi-box-seam fs-4"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-dark fw-bold text-sm">{{ $item->product_name }}</h6>
                                            <small class="text-muted text-xs">Category: {{ $item->product->category->name ?? '-' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center text-sm text-dark font-weight-semibold">
                                    Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                                </td>
                                <td class="text-center text-sm text-dark">
                                    x{{ $item->quantity }}
                                </td>
                                <td class="text-end pe-4 text-sm fw-bold text-dark">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Timeline --}}
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-3 border-bottom">
                    <h6 class="fw-bold mb-0">Status Pengiriman</h6>
                </div>
                <div class="card-body p-4">
                    <ul class="timeline">
                        <li class="timeline-item active">
                            <span class="timeline-icon bg-success text-white">
                                <i class="bi bi-bag-check"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="fw-bold text-dark mb-1">Pesanan Dibuat</h6>
                                <p class="text-muted small mb-0">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                <p class="text-muted small">Pesanan berhasil dibuat dan menunggu pembayaran.</p>
                            </div>
                        </li>
                        
                        @if($order->status == 'paid' || $order->status == 'processing' || $order->status == 'shipped' || $order->status == 'completed')
                        <li class="timeline-item active">
                            <span class="timeline-icon bg-info text-white">
                                <i class="bi bi-wallet2"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="fw-bold text-dark mb-1">Pembayaran Diterima</h6>
                                <p class="text-muted small mb-0">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                            </div>
                        </li>
                        @endif

                        @if($order->status == 'completed')
                        <li class="timeline-item active">
                            <span class="timeline-icon bg-primary text-white">
                                <i class="bi bi-box-seam"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="fw-bold text-dark mb-1">Pesanan Selesai</h6>
                                <p class="text-muted small mb-0">Barang telah diterima oleh pelanggan.</p>
                            </div>
                        </li>
                        @else
                        <li class="timeline-item">
                            <span class="timeline-icon bg-light text-secondary border">
                                <i class="bi bi-hourglass"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="fw-bold text-secondary mb-1">Proses Selanjutnya</h6>
                                <p class="text-muted small mb-0">Pesanan sedang diproses.</p>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        {{-- Right Column --}}
        <div class="col-lg-4">
            {{-- Shipping Info --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Informasi Pengiriman</h6>
                    <div class="d-flex mb-3">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-light p-2 rounded-circle text-primary">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                        </div>
                        <div>
                            <span class="text-uppercase text-xs fw-bold text-muted d-block">Informasi Penerima</span>
                            <div class="mt-2 text-dark">
                                <p class="mb-1 fw-bold">{{ $order->shipping_name ?? $order->user->name }}</p>
                                <p class="mb-2 text-sm text-secondary small"><i class="bi bi-telephone me-1"></i>{{ $order->shipping_phone ?? '-' }}</p>
                                
                                <span class="text-uppercase text-xs fw-bold text-muted d-block mt-3">Alamat Tujuan</span>
                                <p class="mb-0 text-sm fw-medium mt-1 lh-sm">
                                    {{ $order->shipping_address }}<br>
                                    @if($order->shipping_city)
                                        <small>{{ $order->shipping_city }}, {{ $order->shipping_province }} {{ $order->shipping_postal_code }}</small>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Summary --}}
            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Ringkasan Biaya</h5>
                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="opacity-75">Subtotal Produk</span>
                        <span class="fw-medium">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="opacity-75">Ongkos Kirim</span>
                        <span class="fw-medium">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    <hr class="border-white opacity-25 my-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold fs-6">Total Belanja</span>
                        <span class="fw-bold fs-4">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="mt-4 text-center">
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="bi bi-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Custom Timeline CSS */
.timeline {
    list-style: none;
    padding: 0;
    position: relative;
    margin: 0;
}
.timeline::before {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    left: 24px; /* Center with icon width (48px / 2) */
    width: 2px;
    background: #e9ecef;
    z-index: 0;
}
.timeline-item {
    position: relative;
    padding-left: 70px; /* Space for icon + gap */
    padding-bottom: 2rem;
    min-height: 60px;
}
.timeline-item:last-child {
    padding-bottom: 0;
}
.timeline-icon {
    position: absolute;
    left: 0;
    top: 0;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    z-index: 2;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.timeline-content {
    background: transparent;
}
.timeline-content h6 {
    font-size: 0.95rem;
    margin-bottom: 0.25rem;
}
.timeline-content p {
    font-size: 0.85rem;
    line-height: 1.4;
}
</style>
@endpush
