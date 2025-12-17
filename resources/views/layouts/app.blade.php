<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InventoriStore - Belanja Kebutuhan Anda</title>

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
            --font-main: 'Outfit', sans-serif;
            --color-primary: #0d6efd; /* Bootstrap Blue */
            --color-primary-dark: #0a58ca;
            --color-secondary: #6c757d;
            --color-dark: #212529;
            --color-light: #f8fafc;
        }

        /* ... unchanged ... */

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%); /* Blue to Cyan */
            color: white;
            padding: 5rem 0;
            border-radius: 0 0 50% 50% / 4%;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
            padding: 0.6rem 1.25rem;
            font-weight: 500;
            border-radius: 0.5rem;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            background-color: var(--color-primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.4);
        }

        /* Product Cards */
        .card-product {
            border: none;
            border-radius: 1rem;
            background: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            height: 100%;
        }
        .card-product:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .card-product .img-wrapper {
            position: relative;
            padding-top: 75%; /* 4:3 Aspect Ratio */
            overflow: hidden;
            background-color: #f1f5f9;
        }
        .card-product img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }
        .card-product:hover img {
            transform: scale(1.05);
        }
        .category-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(4px);
            padding: 0.25rem 0.75rem;
            border-radius: 2rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--color-primary-dark);
        }

        /* Footer */
        .footer {
            background-color: white;
            border-top: 1px solid #e2e8f0;
            margin-top: auto;
            padding: 4rem 0 2rem;
        }
        .footer h5 {
            font-weight: 700;
            color: var(--color-dark);
            margin-bottom: 1.5rem;
        }
        .footer-link {
            color: #64748b;
            text-decoration: none;
            margin-bottom: 0.75rem;
            display: block;
            transition: color 0.2s;
        }
        .footer-link:hover {
            color: var(--color-primary);
        }

        /* Navbar Glassmorphism */
        .navbar {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            z-index: 9999; /* Ensure it stays on top */
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }
    </style>

    @stack('styles')
</head>

<body>
    {{-- Blade Component Navbar --}}
    <x-navbar />

    {{-- Main Content --}}
    <main>
        
        {{-- Flash message (Conditional render) --}}
        @if (session('success') && !request()->routeIs('home'))
            <div class="container mt-4">
                 <x-alert type="success" :message="session('success')" />
            </div>
        @endif

        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="footer">
        <div class="container">
            {{-- 
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="text-primary fw-bold">InventoriStore</h5>
                    <p class="text-muted">Platform e-commerce terpercaya untuk memenuhi segala kebutuhan Anda dengan kualitas terbaik dan harga terjangkau.</p>
                </div>
                <div class="col-lg-2 col-6 mb-4">
                    <h5>Belanja</h5>
                    <a href="#" class="footer-link">Semua Produk</a>
                    <a href="#" class="footer-link">Kategori</a>
                    <a href="#" class="footer-link">Promo</a>
                </div>
                <div class="col-lg-2 col-6 mb-4">
                    <h5>Bantuan</h5>
                    <a href="#" class="footer-link">Cara Pesan</a>
                    <a href="#" class="footer-link">Pengiriman</a>
                    <a href="#" class="footer-link">Hubungi Kami</a>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5>Newsletter</h5>
                    <p class="text-muted small">Dapatkan info promo terbaru.</p>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Email Anda" aria-label="Email Anda">
                        <button class="btn btn-primary" type="button">Subscribe</button>
                    </div>
                </div>
            </div>
            --}}
            <div class="row mt-4 pt-4 border-top">
                <div class="col text-center text-muted small">
                    &copy; {{ date('Y') }} InventoriStore. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    @stack('scripts')
</body>

</html>

