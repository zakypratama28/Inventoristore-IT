<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title', 'Dashboard') - InventoriStore</title>

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet" />
    {{-- Material Icons --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />

    {{-- Icons + CSS dari Material Dashboard --}}
    <link href="{{ asset('material-dashboard/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('material-dashboard/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <link id="pagestyle" href="{{ asset('material-dashboard/assets/css/material-dashboard.css') }}" rel="stylesheet" />

    @stack('styles')
</head>


<body class="g-sidenav-show bg-gray-100">

    {{-- Sidebar (optional, bisa kosong / diisi nanti) --}}
    {{-- <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 fixed-start bg-gradient-dark" id="sidenav-main">
        ...
    </aside> --}}

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <nav
            class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl bg-transparent position-sticky z-index-sticky top-0">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb" class="w-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="font-weight-bolder mb-0">
                            @yield('page-title', 'Dashboard')
                        </h6>

                        {{-- tombol / aksi di samping judul halaman --}}
                        @yield('page-actions')
                    </div>
                </nav>
            </div>
        </nav>

        {{-- Konten utama --}}
        <div class="container-fluid py-4">
            @yield('content')
        </div>

    </main>

    {{-- Core JS --}}
    <script src="{{ asset('material-dashboard/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('material-dashboard/assets/js/core/bootstrap.min.js') }}"></script>

    {{-- Chart.js --}}
    <script src="{{ asset('material-dashboard/assets/js/plugins/chartjs.min.js') }}"></script>

    {{-- Material Dashboard control center --}}
    <script src="{{ asset('material-dashboard/assets/js/material-dashboard.min.js') }}"></script>

    @stack('scripts')
</body>

</html>
