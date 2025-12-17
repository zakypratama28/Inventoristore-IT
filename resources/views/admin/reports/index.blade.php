@extends('layouts.inventory')
@section('title', 'Laporan Penjualan')
@section('page-title', 'Laporan Penjualan')

@section('content')
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body text-center py-5">
        <div class="mb-4">
            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                <i class="bi bi-bar-chart-line fs-1 text-muted"></i>
            </div>
        </div>
        <h5 class="fw-bold text-dark">Laporan Penjualan</h5>
        <p class="text-muted mb-4 max-w-md mx-auto">
            Fitur laporan lengkap dengan filter tanggal dan ekspor PDF/Excel akan segera hadir.
        </p>
        <button class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-download me-2"></i> Download Summary
        </button>
    </div>
</div>
@endsection
