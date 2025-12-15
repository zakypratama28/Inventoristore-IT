@extends('layouts.inventory')

@section('title', 'Riwayat Pesanan')
@section('page-title', 'Riwayat Pesanan')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0">
            <h6 class="mb-0">Daftar Pesanan</h6>
            <small class="text-muted">Lihat semua pesanan yang pernah Anda buat.</small>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th class="text-end">Total</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>{{ $order->code }}</td>
                            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                            <td class="text-end">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </td>
                            <td>
                                <span class="badge bg-secondary text-capitalize">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Belum ada pesanan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white border-0">
            {{ $orders->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
