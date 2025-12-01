@extends('layouts.material')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('page-actions')
    <a href="{{ route('products') }}" class="btn btn-sm bg-gradient-primary mb-0">
        Lihat semua produk
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    {{-- ICON: gunakan kelas seperti di contoh Material Dashboard --}}
                    <div
                        class="icon icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons text-white opacity-10">inventory_2</i>
                    </div>

                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Total Produk</p>
                        <h4 class="mb-0">{{ $totalProducts }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <span class="text-muted text-sm mb-0">
                        Jumlah semua produk di daftar.
                    </span>
                </div>
            </div>
        </div>

        {{-- Total Kategori --}}
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons text-white opacity-10">category</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Total Kategori</p>
                        <h4 class="mb-0">{{ $totalCategories }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <span class="text-muted text-sm mb-0">Jumlah kategori produk.</span>
                </div>
            </div>
        </div>

        {{-- Harga Paling Mahal --}}
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-shape bg-gradient-warning shadow-warning text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons text-white opacity-10">trending_up</i>
                    </div>

                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Harga Paling Mahal</p>
                        <h4 class="mb-0">
                            Rp {{ number_format($maxPrice, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <span class="text-muted text-sm mb-0">Produk dengan harga tertinggi.</span>
                </div>
            </div>
        </div>

        {{-- Harga Paling Murah --}}
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons text-white opacity-10">trending_down</i>
                    </div>

                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Harga Paling Murah</p>
                        <h4 class="mb-0">
                            Rp {{ number_format($minPrice, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <span class="text-muted text-sm mb-0">Produk dengan harga terendah.</span>
                </div>
            </div>
        </div>
    </div>


    {{-- Row Chart: Produk per Kategori & Harga Produk --}}
    <div class="row mt-4">
        {{-- Chart 1: Produk per Kategori --}}
        <div class="col-lg-6 mb-4">
            <div class="card z-index-2">
                <div class="card-header p-3 pb-0">
                    <h6>Produk per Kategori</h6>
                    <p class="text-sm mb-0">
                        Menampilkan jumlah produk di setiap kategori.
                    </p>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="chart-products-per-category" class="chart-canvas" height="170"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Chart 2: Harga Produk (Nama Barang + Kategori) --}}
        <div class="col-lg-6 mb-4">
            <div class="card z-index-2">
                <div class="card-header p-3 pb-0">
                    <h6>Harga Produk</h6>
                    <p class="text-sm mb-0">
                        Menampilkan harga beberapa produk beserta kategorinya.
                    </p>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="chart-product-prices" class="chart-canvas" height="170"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Data dari Laravel (PHP) -> JavaScript
        const categoriesData = @json($categorySummary);
        const productsData = @json($productsForChart);

        // --- Chart 1: Produk per Kategori ---
        const ctxCategory = document.getElementById('chart-products-per-category').getContext('2d');

        const categoryLabels = categoriesData.map(cat => cat.name);
        const categoryCounts = categoriesData.map(cat => cat.products_count);

        new Chart(ctxCategory, {
            type: 'bar',
            data: {
                labels: categoryLabels,
                datasets: [{
                    label: 'Jumlah Produk',
                    data: categoryCounts,
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // --- Chart 2: Harga Produk (Nama Barang + Kategori) ---
        const ctxProduct = document.getElementById('chart-product-prices').getContext('2d');

        const productLabels = productsData.map(p => {
            const catName = p.category ? p.category.name : '-';
            return `${p.name} (${catName})`;
        });

        const productPrices = productsData.map(p => p.price);

        new Chart(ctxProduct, {
            type: 'line',
            data: {
                labels: productLabels,
                datasets: [{
                    label: 'Harga Produk',
                    data: productPrices,
                    borderWidth: 3,
                    tension: 0.3
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.parsed.y || 0;
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    },
                    x: {
                        ticks: {
                            maxRotation: 60,
                            minRotation: 45
                        }
                    }
                }
            }
        });
    </script>
@endpush
