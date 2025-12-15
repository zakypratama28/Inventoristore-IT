@extends('layouts.inventory')

@section('title', 'Keranjang Belanja')
@section('page-title', 'Keranjang Belanja')

@section('page-actions')
    <a href="{{ route('checkout.create') }}" class="btn btn-sm btn-success {{ $items->isEmpty() ? 'disabled' : '' }}">
        Checkout
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h6 class="mb-0">Produk dalam Keranjang</h6>
                    <small class="text-muted">Kelola jumlah, hapus produk, atau lanjutkan ke checkout.</small>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end">Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $item)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $item->product->name }}</div>
                                        <div class="text-muted small">
                                            {{ $item->product->category->name ?? 'Tanpa kategori' }}
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                                    </td>

                                    <td class="text-center" style="width: 150px;">
                                        <form action="{{ route('cart.update', $item) }}" method="POST"
                                            class="d-inline-flex">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantity"
                                                class="form-control form-control-sm text-center" min="1"
                                                max="100" value="{{ $item->quantity }}">
                                            <button class="btn btn-sm btn-link text-primary">
                                                <i class="bi bi-check2"></i>
                                            </button>
                                        </form>
                                    </td>

                                    <td class="text-end">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </td>

                                    <td class="text-end">
                                        <form action="{{ route('cart.destroy', $item) }}" method="POST"
                                            onsubmit="return confirm('Hapus produk ini dari keranjang?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        Keranjang masih kosong. Tambahkan produk dari daftar barang.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Ringkasan total --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-primary text-white border-0">
                    <h6 class="mb-0">Ringkasan Belanja</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Ongkos Kirim</span>
                        <span>Rp {{ number_format($shipping, 0, ',', '.') }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="fw-semibold">Total</span>
                        <span class="fw-bold text-success">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </span>
                    </div>

                    <a href="{{ route('checkout.create') }}"
                        class="btn btn-success w-100 {{ $items->isEmpty() ? 'disabled' : '' }}">
                        Lanjut ke Checkout
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
