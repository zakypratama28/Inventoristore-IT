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
    {{-- Produk per Kategori --}}
    <div class="card my-4">
        <div class="card-header pb-0">
            <h6 class="mb-1">Produk per Kategori</h6>
            <p class="text-sm text-muted mb-0">
                Menampilkan jumlah produk di setiap kategori.
            </p>
        </div>
        <div class="card-body">
            <div style="min-height:260px;">
                <canvas id="chart-product-category"></canvas>
            </div>
        </div>
    </div>

    {{-- Harga Produk --}}
    <div class="card my-4">
        <div class="card-header pb-0">
            <h6 class="mb-1">Harga Produk</h6>
            <p class="text-sm text-muted mb-0">
                Menampilkan harga beberapa produk beserta kategorinya.
            </p>
        </div>
        <div class="card-body">
            <div style="min-height:260px;">
                <canvas id="chart-product-prices"></canvas>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ---------- DATA DARI PHP ----------
            const categoryLabels = @json($categorySummary->pluck('name'));
            const categoryData = @json($categorySummary->pluck('products_count'));

            const priceLabels = @json($productsForChart->pluck('name'));
            const priceData = @json($productsForChart->pluck('price'));
            const priceCategories = @json($productsForChart->pluck('category.name'));

            // ---------- PALET WARNA KATEGORI ----------
            const categoryPalette = [
                'rgba(91, 155, 213, 0.85)', // biru
                'rgba(237, 125, 49, 0.85)', // oranye
                'rgba(112, 173, 71, 0.85)', // hijau
                'rgba(255, 192, 0, 0.85)', // kuning
                'rgba(192, 80, 77, 0.85)', // merah
                'rgba(128, 100, 162, 0.85)', // ungu
            ];
            const categoryBg = categoryLabels.map((_, i) => categoryPalette[i % categoryPalette.length]);
            const categoryBorder = categoryBg.map(c => c.replace('0.85', '1'));

            // ---------- CHART PRODUK PER KATEGORI (BAR) ----------
            const catCanvas = document.getElementById('chart-product-category');
            if (catCanvas && categoryLabels.length) {
                const ctxCat = catCanvas.getContext('2d');

                new Chart(ctxCat, {
                    type: 'bar',
                    data: {
                        labels: categoryLabels,
                        datasets: [{
                            label: 'Jumlah Produk',
                            data: categoryData,
                            backgroundColor: categoryBg,
                            borderColor: categoryBorder,
                            borderWidth: 1,
                            borderRadius: 10,
                            maxBarThickness: 40,
                            hoverBackgroundColor: categoryBorder,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#111827',
                                titleColor: '#ffffff',
                                bodyColor: '#e5e7eb',
                                padding: 10,
                                cornerRadius: 8
                            }
                        },
                        scales: {
                            x: {
                                ticks: {
                                    color: '#6b7280',
                                    font: {
                                        size: 11
                                    }
                                },
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    color: '#9ca3af',
                                    stepSize: 2
                                },
                                grid: {
                                    color: 'rgba(148, 163, 184, 0.15)'
                                }
                            }
                        }
                    }
                });
            }

            // ---------- WARNA TITIK UNTUK CHART HARGA ----------
            const categoryColorMap = {
                'Aksesoris Komputer': '#6366f1', // indigo
                'Elektronik': '#0ea5e9', // sky
                'Perlengkapan Kantor': '#22c55e', // green
                'Alat Tulis Kantor': '#f97316', // orange
                'Kendaraan Operasional': '#e11d48', // rose
                'default': '#a855f7', // purple
            };
            const pricePointColors = priceCategories.map(cat => categoryColorMap[cat] || categoryColorMap.default);

            // ---------- CHART HARGA PRODUK (LINE) ----------
            const priceCanvas = document.getElementById('chart-product-prices');
            if (priceCanvas && priceLabels.length) {
                const ctxPrice = priceCanvas.getContext('2d');

                new Chart(ctxPrice, {
                    type: 'line',
                    data: {
                        labels: priceLabels,
                        datasets: [{
                            label: 'Harga (Rp)',
                            data: priceData,
                            borderColor: '#6366f1',
                            backgroundColor: 'rgba(99, 102, 241, 0.08)',
                            borderWidth: 2,
                            tension: 0.35,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            pointBackgroundColor: pricePointColors,
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                labels: {
                                    color: '#4b5563'
                                }
                            },
                            tooltip: {
                                backgroundColor: '#111827',
                                titleColor: '#ffffff',
                                bodyColor: '#e5e7eb',
                                callbacks: {
                                    label: function(context) {
                                        const value = context.parsed.y || 0;
                                        return ' Rp ' + value.toLocaleString('id-ID');
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                ticks: {
                                    color: '#6b7280',
                                    maxRotation: 60,
                                    minRotation: 45,
                                    font: {
                                        size: 10
                                    }
                                },
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    color: '#9ca3af',
                                    callback: value => value.toLocaleString('id-ID')
                                },
                                grid: {
                                    color: 'rgba(148, 163, 184, 0.15)'
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endpush
