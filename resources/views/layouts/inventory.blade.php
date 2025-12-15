<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Barang')</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background-color: #f3f4f6;
        }

        /* ===== SIDEBAR ===== */
        .sidebar-wrapper {
            width: 260px;
            min-height: 100vh;
            background: #ffffff;
            border-right: 1px solid #e5e7eb;
        }

        .brand-gradient {
            background: linear-gradient(135deg, #6366f1, #ec4899);
            border-radius: 1.2rem;
            padding: 0.75rem 1rem;
            color: #fff;
        }

        .sidebar-menu-title {
            font-size: .72rem;
            font-weight: 600;
            letter-spacing: .08em;
            color: #9ca3af;
            margin-bottom: .35rem;
            margin-top: 1.2rem;
        }

        .nav-inventory .nav-link {
            font-size: .9rem;
            color: #4b5563;
            border-radius: .75rem;
            padding: .55rem .9rem;
            display: flex;
            align-items: center;
            gap: .55rem;
        }

        .nav-inventory .nav-link i {
            font-size: 1rem;
        }

        .nav-inventory .nav-link.active {
            background: linear-gradient(135deg, #6366f1, #ec4899);
            color: #ffffff;
            box-shadow: 0 10px 15px rgba(99, 102, 241, .3);
        }

        .nav-inventory .nav-link.active i {
            color: #ffffff;
        }

        .nav-inventory .nav-link:hover:not(.active) {
            background-color: #f3f4ff;
            color: #4338ca;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            height: 64px;
            border-bottom: 1px solid #e5e7eb;
            background-color: #ffffff;
        }

        /* ===== KOMPONEN KHUSUS LIST PRODUK ===== */

        /* Card header ungu ala Material Dashboard */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #4f46e5, #ec4899);
        }

        .shadow-primary {
            box-shadow: 0 .5rem 1.5rem rgba(79, 70, 229, .35);
        }

        .border-radius-lg {
            border-radius: 1rem;
        }

        /* Chip info filter */
        .filter-chip {
            display: inline-flex;
            align-items: center;
            padding: .15rem .75rem;
            border-radius: 999px;
            background-color: #eef2ff;
            color: #4f46e5;
            font-size: .75rem;
            font-weight: 500;
        }

        /* Tabel modern */
        .table-modern thead tr th {
            font-size: .7rem;
            letter-spacing: .08em;
            text-transform: uppercase;
            border-bottom-width: 1px;
            border-color: #e5e7eb;
        }

        .table-modern tbody tr td {
            font-size: .85rem;
            padding-top: .6rem;
            padding-bottom: .6rem;
            vertical-align: middle;
        }

        .table-modern tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .table-modern tbody tr:hover {
            background-color: #eef2ff;
        }

        .badge-category {
            display: inline-flex;
            align-items: center;
            padding: .15rem .6rem;
            border-radius: 999px;
            background-color: #eef2ff;
            color: #4338ca;
            font-size: .75rem;
            font-weight: 500;
        }

        .cell-name {
            font-weight: 500;
            color: #111827;
        }

        .price-text {
            font-weight: 600;
            color: #111827;
        }

        .table-actions .btn {
            padding-inline: .65rem;
            font-size: .75rem;
        }

        .btn-primary-dark {
            background-color: #111827;
            color: #fff;
            border-color: #111827;
        }

        .btn-primary-dark:hover {
            background-color: #020617;
            border-color: #020617;
            color: #fff;
        }
    </style>

    @stack('styles')
</head>

<body>
    <div class="d-flex">

        {{-- SIDEBAR --}}
        <aside class="sidebar-wrapper d-flex flex-column p-3">
            {{-- Brand --}}
            <div class="mb-4">
                <div class="brand-gradient d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center bg-white bg-opacity-20 rounded-3 p-2">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>
                    <div>
                        <div class="fw-semibold small text-uppercase">PERSEDIAAN</div>
                        <div class="small text-white-50">Gudang Barang</div>
                    </div>
                </div>
            </div>

            {{-- MENU --}}
            <nav class="nav flex-column nav-inventory">

                <div class="sidebar-menu-title">MAIN</div>
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>

                <div class="sidebar-menu-title">MASTER</div>
                <a href="{{ route('products') }}"
                    class="nav-link {{ request()->routeIs('products*') ? 'active' : '' }}">
                    <i class="bi bi-box"></i>
                    <span>Barang</span>
                </a>
                <a href="{{ route('categories.index') }}"
                    class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <i class="bi bi-tags"></i>
                    <span>Kategori</span>
                </a>
            </nav>

            <div class="mt-auto small text-muted pt-3">
                <span class="d-block">© {{ date('Y') }} Persediaan Barang</span>
            </div>
        </aside>

        {{-- MAIN CONTENT AREA --}}
        <div class="flex-grow-1 d-flex flex-column">

            {{-- TOPBAR --}}
            <header class="topbar d-flex align-items-center justify-content-between px-4">
                <div class="fw-semibold text-muted">
                    @yield('page-title', 'Dashboard Barang')
                </div>
                <div class="d-flex align-items-center gap-2">
                    {{-- diisi dari tiap halaman, misalnya tombol "Kembali ke Dashboard" --}}
                    @yield('page-actions')
                </div>
            </header>

            {{-- PAGE BODY --}}
            <main class="flex-grow-1">
                <div class="container-fluid py-4">
                    @yield('content')
                </div>
            </main>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
