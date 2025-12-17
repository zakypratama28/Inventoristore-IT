@extends('layouts.inventory')

@section('title', 'Dashboard')
@section('page-title', 'Overview')

@section('content')
<div class="row g-4 mb-4">
    {{-- STATS CARDS --}}
    @if(auth()->user()->role === 'admin')
    <div class="col-xl-3 col-sm-6">
        <div class="card h-100 border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-2">
                    <div class="flex-shrink-0 me-3">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3">
                            <i class="bi bi-currency-dollar fs-4"></i>
                        </div>
                    </div>
                    <div>
                        <p class="text-muted small text-uppercase fw-bold mb-0 spacing-1">Total Pendapatan</p>
                    </div>
                </div>
                <h3 class="fw-bold mb-0">Rp {{ number_format($revenue, 0, ',', '.') }}</h3>
                <div class="mt-2 text-success small fw-medium">
                    <i class="bi bi-arrow-up-short"></i> +12% <span class="text-muted fw-normal ms-1">dari bulan lalu</span>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="col-xl-3 col-sm-6">
        <div class="card h-100 border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-2">
                    <div class="flex-shrink-0 me-3">
                        <div class="bg-info bg-opacity-10 text-info rounded-3 p-3">
                            <i class="bi bi-bag-check fs-4"></i>
                        </div>
                    </div>
                    <div>
                        <p class="text-muted small text-uppercase fw-bold mb-0 spacing-1">Total Pesanan</p>
                    </div>
                </div>
                <h3 class="fw-bold mb-0">{{ $totalOrders }}</h3>
                <div class="mt-2 text-success small fw-medium">
                    <i class="bi bi-arrow-up-short"></i> +5% <span class="text-muted fw-normal ms-1">minggu ini</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card h-100 border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-2">
                    <div class="flex-shrink-0 me-3">
                        <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-3">
                            <i class="bi bi-box-seam fs-4"></i>
                        </div>
                    </div>
                    <div>
                        <p class="text-muted small text-uppercase fw-bold mb-0 spacing-1">Total Produk</p>
                    </div>
                </div>
                <h3 class="fw-bold mb-0">{{ $totalProducts }}</h3>
                <div class="mt-2 text-muted small">
                    <span class="fw-medium">{{ $totalCategories }}</span> Kategori Aktif
                </div>
            </div>
        </div>
    </div>

    @if(auth()->user()->role === 'admin')
    <div class="col-xl-3 col-sm-6">
        <div class="card h-100 border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-2">
                    <div class="flex-shrink-0 me-3">
                        <div class="bg-danger bg-opacity-10 text-danger rounded-3 p-3">
                            <i class="bi bi-people fs-4"></i>
                        </div>
                    </div>
                    <div>
                        <p class="text-muted small text-uppercase fw-bold mb-0 spacing-1">Pelanggan</p>
                    </div>
                </div>
                <h3 class="fw-bold mb-0">{{ $totalUsers }}</h3>
                <div class="mt-2 text-success small fw-medium">
                    <i class="bi bi-arrow-up-short"></i> +3 <span class="text-muted fw-normal ms-1">user baru</span>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<div class="row g-4">
    {{-- CHART SECTION --}}
    @if(auth()->user()->role === 'admin')
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold mb-0">Statistik Penjualan</h6>
            </div>
            <div class="card-body">
                <canvas id="salesChart" height="300"></canvas>
            </div>
        </div>
    </div>
    @endif

    {{-- RECENT ORDERS --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">Pesanan Terbaru</h6>
                <a href="#" class="text-decoration-none small text-primary fw-bold">Lihat Semua</a>
            </div>
            <div class="list-group list-group-flush">
                @forelse($recentOrders as $order)
                <div class="list-group-item border-0 d-flex align-items-center px-4 py-3">
                    <div class="flex-shrink-0 me-3">
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center text-secondary" style="width: 40px; height: 40px;">
                            <i class="bi bi-receipt"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 min-width-0">
                        <p class="mb-0 fw-bold text-dark text-truncate">{{ $order->user->name }}</p>
                        <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="text-end ms-2">
                        <span class="d-block fw-bold text-dark">Total</span>
                        <small class="fw-bold text-primary">Rp {{ number_format($order->total/1000, 0) }}k</small>
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-muted small">Belum ada pesanan.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Pendapatan (Juta)',
                data: [12, 19, 3, 5, 2, 3], // Dummy data for visual
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [2, 4] } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endpush
