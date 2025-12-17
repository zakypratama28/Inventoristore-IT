@extends('layouts.inventory')
@section('title', 'Daftar Pesanan')
@section('page-title', 'Data Pesanan')

@section('page-actions')
    <!-- Filter or Export buttons could go here -->
@endsection

@section('content')
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Kode Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="ps-4 fw-medium text-dark">{{ $order->code }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-initial rounded-circle bg-light text-primary fw-bold me-2 px-2 py-1 small">
                                    {{ substr($order->user->name, 0, 1) }}
                                </div>
                                <span class="fw-medium">{{ $order->user->name }}</span>
                            </div>
                        </td>
                        <td class="fw-bold text-dark">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        <td>
                            @php
                                $badgeClass = match($order->status) {
                                    'completed' => 'success',
                                    'paid' => 'info',
                                    'pending' => 'warning',
                                    'cancelled' => 'danger',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="badge bg-{{ $badgeClass }} bg-opacity-10 text-{{ $badgeClass }} px-2 py-1 rounded-pill">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="text-muted small">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary opacity-25"></i>
                            Belum ada pesanan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-0 py-3">
        {{ $orders->links() }}
    </div>
</div>
@endsection
