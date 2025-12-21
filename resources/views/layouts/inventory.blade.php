<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --font-main: 'Outfit', sans-serif;
            --color-primary: #0d6efd;
            --color-primary-dark: #0a58ca;
            --color-secondary: #64748b;
            --sidebar-width: 280px;
            --sidebar-width-collapsed: 80px;
        }

        body {
            font-family: var(--font-main);
            background-color: #f1f5f9;
            color: #334155;
        }

        /* ===== SIDEBAR ===== */
        .sidebar-wrapper {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: #ffffff;
            border-right: 1px solid #e2e8f0;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-x: hidden;
        }
        
        /* Collapsed Sidebar */
        .sidebar-wrapper.collapsed {
            width: var(--sidebar-width-collapsed);
        }

        /* Adjust main content when sidebar is collapsed */
        .main-content-wrapper {
            margin-left: var(--sidebar-width);
            transition: all 0.3s ease;
        }
        .main-content-wrapper.expanded {
            margin-left: var(--sidebar-width-collapsed) !important;
        }

        /* Hide elements in collapsed state */
        .sidebar-wrapper.collapsed .sidebar-text,
        .sidebar-wrapper.collapsed .sidebar-menu-title {
            display: none;
        }
        
        /* Center icons in collapsed state */
        .sidebar-wrapper.collapsed .nav-link {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }
        .sidebar-wrapper.collapsed .brand-gradient {
            padding: 0.5rem;
            justify-content: center;
        }
        .sidebar-wrapper.collapsed .brand-gradient .bg-white {
            margin: 0 !important;
        }

        .brand-gradient {
            background: linear-gradient(135deg, #0d6efd, #0dcaf0);
            border-radius: 1rem;
            padding: 1rem;
            color: #fff;
            box-shadow: 0 4px 6px -1px rgba(13, 110, 253, 0.2);
            white-space: nowrap; /* Prevent text wrap */
        }

        .sidebar-menu-title {
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .05em;
            color: #94a3b8;
            margin-bottom: .5rem;
            margin-top: 1.5rem;
            padding-left: 1rem;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .nav-inventory .nav-link {
            font-size: .95rem;
            color: #64748b;
            border-radius: .5rem;
            padding: .75rem 1rem;
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: .25rem;
            font-weight: 500;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .nav-inventory .nav-link i {
            font-size: 1.1rem;
            min-width: 1.5rem; /* Ensure icon doesn't shift */
            text-align: center;
        }

        .nav-inventory .nav-link.active {
            background-color: #eff6ff;
            color: var(--color-primary);
            font-weight: 600;
        }

        .nav-inventory .nav-link.active i {
            color: var(--color-primary);
        }

        .nav-inventory .nav-link:hover:not(.active) {
            background-color: #f8fafc;
            color: var(--color-primary);
        }

        /* ===== TOPBAR ===== */
        .topbar {
            height: 64px;
            border-bottom: 1px solid #e5e7eb;
            background-color: #ffffff;
        }

        /* ===== KOMPONEN KHUSUS LIST PRODUK ===== */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #4f46e5, #ec4899);
        }

        .shadow-primary {
            box-shadow: 0 .5rem 1.5rem rgba(79, 70, 229, .35);
        }

        .border-radius-lg {
            border-radius: 1rem;
        }

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
        <aside class="sidebar-wrapper d-flex flex-column p-3" id="sidebar">
            {{-- Brand --}}
            <div class="mb-4">
                <div class="brand-gradient d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center bg-white bg-opacity-20 rounded-3 p-2">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>
                    <div class="sidebar-text">
                        <div class="fw-bold small text-uppercase ls-1">IGG Store</div>
                        <div class="small text-white-50" style="font-size: 0.8rem;">Admin Panel</div>
                    </div>
                </div>
            </div>

            {{-- MENU --}}
            <nav class="nav flex-column nav-inventory">

                <div class="sidebar-menu-title">MAIN</div>
                
                {{-- Overview Link (Admin Dashboard) --}}
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span class="sidebar-text">Overview</span>
                </a>

                {{-- Link to Frontend --}}
                <a href="{{ route('home') }}" class="nav-link">
                    <i class="bi bi-shop"></i>
                    <span class="sidebar-text">Lihat Toko</span>
                </a>

                <div class="sidebar-menu-title">MASTER</div>
                <a href="{{ route('products') }}"
                    class="nav-link {{ request()->routeIs('products*') ? 'active' : '' }}">
                    <i class="bi bi-box"></i>
                    <span class="sidebar-text">Barang</span>
                </a>
                <a href="{{ route('categories.index') }}"
                    class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <i class="bi bi-tags"></i>
                    <span class="sidebar-text">Kategori</span>
                </a>

                <div class="sidebar-menu-title">TRANSAKSI</div>
                <a href="{{ route('admin.orders.index') }}"
                    class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                    <i class="bi bi-cart-check"></i>
                    <span class="sidebar-text">Pesanan</span>
                </a>

                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.customers.index') }}"
                        class="nav-link {{ request()->routeIs('admin.customers*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        <span class="sidebar-text">Pelanggan</span>
                    </a>

                    <div class="sidebar-menu-title">LAPORAN</div>
                    <a href="{{ route('admin.reports.index') }}"
                        class="nav-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-bar-graph"></i>
                        <span class="sidebar-text">Penjualan</span>
                    </a>
                @endif

            </nav>

            <div class="mt-auto small text-muted pt-3 border-top pb-3">
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="nav-link border-0 bg-transparent text-danger w-100 text-start" title="Logout">
                        <i class="bi bi-box-arrow-right"></i>
                        <span class="sidebar-text">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- MAIN CONTENT AREA --}}
        <div class="flex-grow-1 d-flex flex-column main-content-wrapper" id="mainContent">

            {{-- TOPBAR --}}
            <header class="topbar d-flex align-items-center justify-content-between px-4">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-light btn-sm border-0 shadow-sm rounded-circle d-flex align-items-center justify-content-center" 
                            style="width: 32px; height: 32px;"
                            onclick="toggleSidebar()">
                        <i class="bi bi-list fs-5"></i>
                    </button>
                    <div class="fw-semibold text-muted">
                        @yield('page-title', 'Dashboard Barang')
                    </div>
                </div>
                
                <div class="d-flex align-items-center gap-2">
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
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        }
    </script>
    @stack('scripts')
</body>

</html>
