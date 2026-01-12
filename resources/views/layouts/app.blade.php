<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>IGG Store - Gadget&Gaming Centre</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('material-dashboard/assets/iconigg.svg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('material-dashboard/assets/favicon-32x32.png') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap 5 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            /* Common Variables */
            --font-main: 'Outfit', sans-serif;
            
            /* Dark Theme (Default) */
            --color-bg: #0f172a; /* Slate 900 */
            --color-surface: #1e293b; /* Slate 800 */
            --color-primary: #0ea5e9; /* Sky 500 - Neon Cyan */
            --color-primary-dark: #0284c7; /* Sky 600 */
            --color-secondary: #64748b; /* Slate 500 */
            --color-text: #f1f5f9; /* Slate 100 */
            --color-text-muted: #94a3b8; /* Slate 400 */
            --color-border: #334155; /* Slate 700 */
            --color-card-hover: #334155;
            --shadow-glow: 0 0 15px rgba(14, 165, 233, 0.3);
        }

        /* Light Theme Variable Overrides */
        [data-theme="light"] {
            --color-bg: #f8fafc;
            --color-surface: #ffffff;
            --color-primary: #0d6efd;
            --color-primary-dark: #0a58ca;
            --color-secondary: #6c757d;
            --color-text: #212529;
            --color-text-muted: #6c757d;
            --color-border: #e2e8f0;
            --color-card-hover: #ffffff;
            --shadow-glow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: var(--font-main);
            background-color: var(--color-bg);
            color: var(--color-text);
            transition: background-color 0.3s, color 0.3s;
        }

        /* Component Theming */
        .card, .dropdown-menu, .modal-content {
            background-color: var(--color-surface);
            border-color: var(--color-border);
            color: var(--color-text);
        }

        /* Navbar */
        .navbar {
            background-color: rgba(30, 41, 59, 0.95); /* Dark surface with opacity */
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--color-border);
        }
        [data-theme="light"] .navbar {
            background-color: rgba(255, 255, 255, 0.95);
        }

        .navbar-brand, .nav-link {
            color: var(--color-text) !important;
        }
        
        .dropdown-item {
            color: var(--color-text);
        }
        .dropdown-item:hover {
            background-color: var(--color-border);
            color: var(--color-text);
        }

        /* Inputs */
        .form-control, .form-select {
            background-color: var(--color-bg);
            border-color: var(--color-border);
            color: var(--color-text);
        }
        .form-control:focus, .form-select:focus {
            background-color: var(--color-bg);
            color: var(--color-text);
            border-color: var(--color-primary);
            box-shadow: 0 0 0 0.25rem rgba(14, 165, 233, 0.25);
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
            color: #fff;
            padding: 0.6rem 1.25rem;
            font-weight: 500;
            border-radius: 0.5rem;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            background-color: var(--color-primary-dark);
            border-color: var(--color-primary-dark);
            box-shadow: var(--shadow-glow);
        }
        
        .btn-light {
            background-color: var(--color-surface);
            border-color: var(--color-border);
            color: var(--color-text);
        }
        .btn-light:hover {
            background-color: var(--color-border);
            color: var(--color-text);
        }

        /* Text Utilities Override */
        .text-muted {
            color: var(--color-text-muted) !important;
        }
        .text-dark {
            color: var(--color-text) !important;
        }
        .bg-white {
            background-color: var(--color-surface) !important;
        }
        .bg-light {
            background-color: var(--color-bg) !important;
        }

        /* Hero Section Update */
        .hero-section {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            position: relative;
            padding: 5rem 0;
            border-radius: 0 0 50% 50% / 4%;
            margin-bottom: 3rem;
            overflow: hidden;
            border-bottom: 2px solid var(--color-primary);
        }
        /* Tech/Gaming Grid Pattern */
        .hero-section::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image: 
                linear-gradient(rgba(14, 165, 233, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(14, 165, 233, 0.1) 1px, transparent 1px);
            background-size: 30px 30px;
            opacity: 0.3;
        }
        [data-theme="light"] .hero-section {
            background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);
            border-bottom: none;
        }
        [data-theme="light"] .hero-section::after {
            display: none;
        }

        /* Footer */
        .footer {
            background-color: var(--color-surface);
            border-top: 1px solid var(--color-border);
            margin-top: auto;
            padding: 4rem 0 2rem;
        }
        .footer h5 {
            color: var(--color-text);
        }
        .footer-link {
            color: var(--color-text-muted);
        }
        .footer-link:hover {
            color: var(--color-primary);
        }
    </style>

    <script>
        // Check local storage or system preference
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            document.documentElement.setAttribute('data-theme', savedTheme);
        } else {
            // Default to dark key (no attribute needed as it's default in CSS, 
            // but we can enforce logic if needed. Here we assume :root is dark)
        }
    </script>

    @stack('styles')
</head>

<body>
    {{-- Blade Component Navbar --}}
    <x-navbar />

    {{-- Main Content --}}
    <main>

        {{-- Flash message (Conditional render) --}}
        @if (session('success') && !request()->routeIs('home') && !request()->routeIs('cart.index') && !request()->routeIs('orders.show'))
            <div class="container mt-5 pt-5">
                <x-alert type="success" :message="session('success')" />
            </div>
        @endif

        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row g-4">
                {{-- Brand Section --}}
                <div class="col-lg-4 col-md-6">
                    <h5 class="fw-bold mb-3">IGGStore</h5>
                    <p class="text-white-50 mb-0">
                        Koleksi lengkap kebutuhan gaming & gadget terbaru dengan harga terbaik terpercaya.
                    </p>
                </div>

                {{-- Categories Section --}}
                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-bold text-uppercase mb-3" style="letter-spacing: 1px;">Kategori</h6>
                    <ul class="list-unstyled">
                        @php
                            $footerCategories = \App\Models\Category::orderBy('name')->limit(4)->get();
                        @endphp
                        @foreach($footerCategories as $category)
                            <li class="mb-2">
                                <a href="{{ route('home', ['category' => $category->id]) }}" class="text-white-50 text-decoration-none hover-primary">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Contact Section --}}
                <div class="col-lg-5 col-md-12">
                    <h6 class="fw-bold text-uppercase mb-3" style="letter-spacing: 1px;">Kontak</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2 d-flex align-items-start">
                            <i class="bi bi-house-fill text-white-50 me-2 mt-1"></i>
                            <span class="text-white-50">Batam, Kepulauan Riau</span>
                        </li>
                        <li class="mb-2 d-flex align-items-start">
                            <i class="bi bi-envelope-fill text-white-50 me-2 mt-1"></i>
                            <a href="mailto:iggstore@gmail.com" class="text-white-50 text-decoration-none hover-primary">
                                iggstore@gmail.com
                            </a>
                        </li>
                        <li class="mb-2 d-flex align-items-start">
                            <i class="bi bi-telephone-fill text-white-50 me-2 mt-1"></i>
                            <a href="tel:+6285968268782" class="text-white-50 text-decoration-none hover-primary">
                                +62 859-6826-8782
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Copyright --}}
            <div class="row mt-4 pt-4 border-top border-secondary">
                <div class="col text-center">
                    <p class="text-white-50 small mb-0">
                        Hak Cipta © {{ date('Y') }} IGGStore. Semua hak dilindungi.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <style>
        .hover-primary:hover {
            color: #0ea5e9 !important;
            transition: color 0.3s ease;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    @stack('scripts')
</body>

</html>
