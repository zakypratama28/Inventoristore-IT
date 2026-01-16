<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('home') }}">
            <img src="{{ asset('material-dashboard/assets/iconigg.svg') }}" alt="IGG Logo" width="30" height="30" class="d-inline-block align-text-top">
            IGG Store
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                        href="{{ route('home') }}">{{ __('messages.home') }}</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('orders.index') ? 'active' : '' }}"
                            href="{{ route('orders.index') }}">{{ __('messages.my_orders') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('wishlist.*') ? 'active' : '' }}"
                            href="{{ route('wishlist.index') }}">
                            <i class="bi bi-heart"></i> {{ __('messages.wishlist') }}
                        </a>
                    </li>
                @endauth
                {{-- Blog & FAQ visible to all users (including guests) --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}"
                        href="{{ route('blog.index') }}">
                        <i class="bi bi-newspaper"></i> Blog
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('faq.*') ? 'active' : '' }}"
                        href="{{ route('faq.index') }}">
                        <i class="bi bi-question-circle"></i> FAQ
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <!-- Language Switcher -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-globe"></i> {{ app()->getLocale() == 'id' ? 'ID' : 'EN' }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                        <li>
                            <a class="dropdown-item {{ app()->getLocale() == 'id' ? 'active' : '' }}" 
                               href="{{ route('language.switch', 'id') }}">
                                <i class="bi bi-check-circle me-2 {{ app()->getLocale() == 'id' ? '' : 'invisible' }}"></i>Bahasa Indonesia
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}" 
                               href="{{ route('language.switch', 'en') }}">
                                <i class="bi bi-check-circle me-2 {{ app()->getLocale() == 'en' ? '' : 'invisible' }}"></i>English
                            </a>
                        </li>
                    </ul>
                </li>
                
                @auth
                    <li class="nav-item me-3">
                        <a class="nav-link" href="{{ route('cart.index') }}" id="cartLink">
                            <i class="bi bi-cart-fill"></i> {{ __('messages.cart') }}
                            <span class="badge bg-danger rounded-pill" id="cartBadge">
                                {{ \App\Models\CartItem::where('user_id', auth()->id())->count() }}
                            </span>
                        </a>
                    </li>
                @endauth

                @guest
                    <li class="nav-item">
                        <button class="btn nav-link" onclick="toggleTheme()" title="Toggle Theme">
                            <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
                        </button>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('messages.login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('messages.register') }}</a>
                    </li>
                @else
                    <li class="nav-item">
                        <button class="btn nav-link" onclick="toggleTheme()" title="Toggle Theme">
                            <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
                        </button>
                    </li>
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
                                    <i class="bi bi-person-circle me-2"></i>{{ __('messages.profile') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('addresses.index') }}">
                                    <i class="bi bi-geo-alt me-2"></i>{{ __('messages.my_addresses') }}
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i>{{ __('messages.logout') }}
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

<script>
    function toggleTheme() {
        const html = document.documentElement;
        const currentTheme = html.getAttribute('data-theme');
        const icon = document.getElementById('themeIcon');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        
        if (newTheme === 'light') {
            html.setAttribute('data-theme', 'light');
            localStorage.setItem('theme', 'light');
            if(icon) icon.className = 'bi bi-sun-fill';
        } else {
            html.removeAttribute('data-theme');
            localStorage.setItem('theme', 'dark');
            if(icon) icon.className = 'bi bi-moon-stars-fill';
        }
    }

    // Initialize icon
    document.addEventListener('DOMContentLoaded', () => {
        const savedTheme = localStorage.getItem('theme');
        const icon = document.getElementById('themeIcon');
        if (savedTheme === 'light' && icon) {
            icon.className = 'bi bi-sun-fill';
        }
    });
</script>
