<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">IGG Store</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                        href="{{ route('home') }}">Home</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('orders.index') ? 'active' : '' }}"
                            href="{{ route('orders.index') }}">Pesanan Saya</a>
                    </li>
                @endauth
            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item me-3">
                    <a class="nav-link" href="{{ route('cart.index') }}">
                        <i class="bi bi-cart-fill"></i> Keranjang
                        @auth
                            <span class="badge bg-danger rounded-pill">
                                {{ \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity') }}
                            </span>
                        @endauth
                    </a>
                </li>

                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            @if (in_array(Auth::user()->role, ['admin', 'staff']))
                                Admin System ({{ ucfirst(Auth::user()->role) }})
                            @else
                                {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            @if (in_array(Auth::user()->role, ['admin', 'staff']))
                                <li>
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                                        <i class="bi bi-speedometer2 me-2"></i>Dashboard Admin
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.show') }}">
                                    <i class="bi bi-person-circle me-2"></i>Profile
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
