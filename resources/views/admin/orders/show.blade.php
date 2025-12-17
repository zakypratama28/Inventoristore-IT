@extends('layouts.inventory')
@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')

@section('page-actions')
    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
@endsection

@section('content')
<div class="row g-4">
    {{-- Order Info --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-bottom py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Item Pesanan</h6>
                    <span class="badge bg-light text-dark border">{{ $order->items->count() }} Item</span>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Produk</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end pe-4">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        @if($item->product->image_url)
                                            <img src="{{ asset($item->product->image_url) }}" class="rounded me-3" width="40" height="40" style="object-fit:cover;">
                                        @else
                                            <div class="rounded me-3 bg-light d-flex align-items-center justify-content-center" style="width:40px; height:40px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-0 small fw-bold">{{ $item->product->name }}</h6>
                                            <small class="text-muted">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end pe-4 fw-bold">
                                    Rp {{ number_format($item->unit_price * $item->quantity, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-light">
                            <tr>
                                <td colspan="2" class="text-end fw-bold pt-3">Total Pesanan</td>
                                <td class="text-end pe-4 fw-bold pt-3 text-primary fs-5">
                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Customer & Shipping --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="fw-bold mb-0">Info Pelanggan</h6>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar-initial rounded-circle bg-primary bg-opacity-10 text-primary fw-bold me-3 px-3 py-2">
                        {{ substr($order->user->name, 0, 1) }}
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">{{ $order->user->name }}</h6>
                        <small class="text-muted">{{ $order->user->email }}</small>
                    </div>
                </div>
                <hr class="border-light">
                <h6 class="small fw-bold text-uppercase text-muted mb-2">Alamat Pengiriman</h6>
                <p class="small text-dark mb-3">
                    {{ $order->shipping_address }}
                </p>
                <h6 class="small fw-bold text-uppercase text-muted mb-2">Status Pesanan</h6>
                 @php
                    $badgeClass = match($order->status) {
                        'completed' => 'success',
                        'paid' => 'info',
                        'pending' => 'warning',
                        'cancelled' => 'danger',
                        default => 'secondary'
                    };
                @endphp
                <span class="badge bg-{{ $badgeClass }} w-100 py-2">{{ ucfirst($order->status) }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
