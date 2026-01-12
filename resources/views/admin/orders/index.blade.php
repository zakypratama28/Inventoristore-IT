@extends('layouts.inventory')
@section('title', 'Daftar Pesanan')
@section('page-title', 'Data Pesanan')

@section('page-actions')
    <!-- Filter or Export buttons could go here -->
@endsection

@section('content')
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        {{-- Filters --}}
        <div class="bg-light bg-opacity-50 p-3 mx-3 rounded-3 my-3 border">
            <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-3 align-items-end">
                <div class="col-lg-4">
                    <label class="form-label small text-muted fw-bold text-uppercase ls-1">Pencarian</label>
                    <div class="input-group bg-white rounded-3 border">
                        <span class="input-group-text bg-transparent border-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" name="q" class="form-control border-0 shadow-none ps-0" 
                            placeholder="Cari kode / nama pelanggan..." value="{{ request('q') }}">
                    </div>
                </div>
                <div class="col-lg-3">
                    <label class="form-label small text-muted fw-bold text-uppercase ls-1">Status</label>
                    <select name="status" class="form-select bg-white border-0 shadow-none rounded-3" style="border: 1px solid #dee2e6 !important;">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-lg-2 d-grid">
                    <button type="submit" class="btn btn-secondary w-100">
                        Filter
                    </button>
                </div>
            </form>
        </div>
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
                                    {{ $order->user ? substr($order->user->name, 0, 1) : 'G' }}
                                </div>
                                <span class="fw-medium">{{ $order->user->name ?? 'Guest' }}</span>
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
