<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\AuthController;

// Auth Routes Password Reset
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    // Password Reset Routes
    Route::get('/forgot-password', [\App\Http\Controllers\PasswordResetController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [\App\Http\Controllers\PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [\App\Http\Controllers\PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [\App\Http\Controllers\PasswordResetController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Static Pages
Route::get('/pages/{slug}', [\App\Http\Controllers\StaticPageController::class, 'show'])->name('pages.show');

// Product Detail
Route::get('/products/{product}', [\App\Http\Controllers\ProductController::class, 'show'])->name('products.show');

// Blog (Public)
Route::get('/blog', [\App\Http\Controllers\PublicBlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [\App\Http\Controllers\PublicBlogController::class, 'show'])->name('blog.show');

// FAQ (Public)
Route::get('/faq', [\App\Http\Controllers\FaqController::class, 'index'])->name('faq.index');

// Language Switcher
Route::get('/language/{locale}', [\App\Http\Controllers\LanguageController::class, 'switch'])->name('language.switch');

// Public Storefront
Route::get('/', [StoreController::class, 'index'])->name('home');

// Authenticated Routes (Customer & General)
Route::middleware(['auth', 'verified'])->group(function () {
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{item}', [CartController::class, 'destroy'])->name('cart.destroy');
    
    // Cart API for sidebar
    Route::get('/api/cart/items', [CartController::class, 'getItems'])->name('cart.api.items');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // Profile
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    // Orders (Customer view)
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    
    // Wishlist
    Route::get('/wishlist', [\App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist', [\App\Http\Controllers\WishlistController::class, 'store'])->name('wishlist.store');
    Route::get('/wishlist/check/{product}', [\App\Http\Controllers\WishlistController::class, 'check'])->name('wishlist.check');
    Route::delete('/wishlist/{wishlist}', [\App\Http\Controllers\WishlistController::class, 'destroy'])->name('wishlist.destroy');
    
    // Reviews
    Route::post('/products/{product}/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
    Route::post('/orders/reviews', [\App\Http\Controllers\ReviewController::class, 'storeFromOrder'])->name('orders.reviews.store');
    Route::put('/reviews/{review}', [\App\Http\Controllers\ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [\App\Http\Controllers\ReviewController::class, 'destroy'])->name('reviews.destroy');
    
    // User Addresses
    Route::get('/addresses', [\App\Http\Controllers\UserAddressController::class, 'index'])->name('addresses.index');
    Route::post('/addresses', [\App\Http\Controllers\UserAddressController::class, 'store'])->name('addresses.store');
    Route::put('/addresses/{address}', [\App\Http\Controllers\UserAddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{address}', [\App\Http\Controllers\UserAddressController::class, 'destroy'])->name('addresses.destroy');
    Route::post('/addresses/{address}/set-default', [\App\Http\Controllers\UserAddressController::class, 'setDefault'])->name('addresses.set-default');
    
    // Chat
    Route::get('/chat', [\App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat', [\App\Http\Controllers\ChatController::class, 'store'])->name('chat.store');
    Route::get('/chat/messages', [\App\Http\Controllers\ChatController::class, 'getMessages'])->name('chat.messages');
});

// Authenticated but not necessarily verified (verification routes)
Route::middleware('auth')->group(function () {
    // Email verification
    Route::get('/verify', [AuthController::class, 'showVerify'])->name('verification.notice');
    Route::post('/verify', [AuthController::class, 'verify'])->name('verify.store');
    Route::post('/verify/resend', [AuthController::class, 'resendVerificationCode'])->name('verify.resend');
});

// Admin & Staff Area
Route::middleware(['auth', 'role:admin,staff'])->prefix('admin')->group(function () {
    
    Route::get('/', function () {
        $totalProducts   = Product::count();
        $totalCategories = Category::count();
        $maxPrice        = Product::max('price') ?? 0;
        $minPrice        = Product::min('price') ?? 0;
        $totalStock      = Product::sum('stock');
        $avgPrice        = Product::avg('price') ?? 0;

        $productsForChart = Product::with('category')
            ->orderBy('name')
            ->take(10)
            ->get();

        $categorySummary = Category::withCount('products')
            ->orderBy('name')
            ->get();

        // Real-time Stats
        $totalOrders = \App\Models\Order::count();
        $revenue = \App\Models\Order::sum('total');
        $recentOrders = \App\Models\Order::with('user')->latest()->take(5)->get();
        $totalUsers = \App\Models\User::where('role', 'customer')->count();

        // Growth Metrics
        $lastMonthRevenue = \App\Models\Order::whereMonth('created_at', now()->subMonth()->month)->sum('total');
        $thisMonthRevenue = \App\Models\Order::whereMonth('created_at', now()->month)->sum('total');
        $revenueGrowth = $lastMonthRevenue > 0 ? (($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 : 0;

        $lastWeekOrders = \App\Models\Order::whereBetween('created_at', [now()->subWeeks(2), now()->subWeek()])->count();
        $thisWeekOrders = \App\Models\Order::whereBetween('created_at', [now()->subWeek(), now()])->count();
        $orderGrowth = $lastWeekOrders > 0 ? (($thisWeekOrders - $lastWeekOrders) / $lastWeekOrders) * 100 : 0;

        $newUsersLast30Days = \App\Models\User::where('role', 'customer')->where('created_at', '>=', now()->subDays(30))->count();

        // Chart Data (Last 6 Months)
        $chartLabels = [];
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $chartLabels[] = $date->format('M');
            $chartData[] = \App\Models\Order::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('total') / 1000; // In thousands
        }

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCategories',
            'maxPrice',
            'minPrice',
            'totalStock',
            'avgPrice',
            'productsForChart',
            'categorySummary',
            'totalOrders',
            'revenue',
            'recentOrders',
            'totalUsers',
            'revenueGrowth',
            'orderGrowth',
            'newUsersLast30Days',
            'chartLabels',
            'chartData'
        ));
    })->name('dashboard');

    Route::prefix('products')
        ->controller(ProductController::class)
        ->group(function () {

            Route::get('/', 'index')->name('products');
            Route::get('/create', 'create')->name('products.create');
            Route::get('/edit/{id}', 'edit')->name('products.edit');
            Route::post('/store', 'store')->name('products.store');
            Route::post('/update/{id}', 'update')->name('products.update');
            Route::get('/show/{id}', function($id) {
                return redirect()->route('products.show', $id);
            })->name('admin.products.show');
            Route::delete('/delete/{id}', 'destroy')->name('products.destroy');
        });

    Route::prefix('categories')
        ->controller(CategoryController::class)
        ->group(function () {
            Route::get('/', 'index')->name('categories.index');
            Route::post('/', 'store')->name('categories.store');
            Route::put('/{category}', 'update')->name('categories.update');
            Route::delete('/{category}', 'destroy')->name('categories.destroy');
        });

    // Admin Transactions & Features
    Route::get('/orders', [\App\Http\Controllers\AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::patch('/orders/{order}/status', [\App\Http\Controllers\AdminOrderController::class, 'updateStatus'])->name('admin.orders.update-status');
    Route::get('/customers', [\App\Http\Controllers\AdminCustomerController::class, 'index'])->name('admin.customers.index');
    Route::delete('/customers/{customer}', [\App\Http\Controllers\AdminCustomerController::class, 'destroy'])->name('admin.customers.destroy');
    Route::get('/reports', [\App\Http\Controllers\AdminReportController::class, 'index'])->name('admin.reports.index');
    
    // User Management
    Route::prefix('users')->controller(\App\Http\Controllers\Admin\UserManagementController::class)->group(function () {
        Route::get('/', 'index')->name('admin.users.index');
        Route::put('/{user}', 'update')->name('admin.users.update');
        Route::delete('/{user}', 'destroy')->name('admin.users.destroy');
        Route::post('/{user}/toggle-status', 'toggleStatus')->name('admin.users.toggle-status');
    });
    
    // Review Management
    Route::prefix('reviews')->controller(\App\Http\Controllers\Admin\ReviewManagementController::class)->group(function () {
        Route::get('/', 'index')->name('admin.reviews.index');
        Route::delete('/{review}', 'destroy')->name('admin.reviews.destroy');
        Route::get('/product/{product}', 'getByProduct')->name('admin.reviews.by-product');
    });
    
    // Blog Management
    Route::prefix('blog')->controller(\App\Http\Controllers\Admin\AdminBlogController::class)->group(function () {
        Route::get('/', 'index')->name('admin.blog.index');
        Route::get('/create', 'create')->name('admin.blog.create');
        Route::post('/', 'store')->name('admin.blog.store');
        Route::get('/{post}/edit', 'edit')->name('admin.blog.edit');
        Route::put('/{post}', 'update')->name('admin.blog.update');
        Route::delete('/{post}', 'destroy')->name('admin.blog.destroy');
    });
    
    // FAQ Management
    Route::resource('faq', \App\Http\Controllers\Admin\FaqController::class, ['as' => 'admin']);
    

    
    // Static Pages Management
    Route::prefix('pages')->group(function () {
        Route::get('/', [\App\Http\Controllers\AdminStaticPageController::class, 'index'])->name('admin.pages.index');
        Route::get('/create', [\App\Http\Controllers\AdminStaticPageController::class, 'create'])->name('admin.pages.create');
        Route::post('/', [\App\Http\Controllers\AdminStaticPageController::class, 'store'])->name('admin.pages.store');
        Route::get('/{page}/edit', [\App\Http\Controllers\AdminStaticPageController::class, 'edit'])->name('admin.pages.edit');
        Route::put('/{page}', [\App\Http\Controllers\AdminStaticPageController::class, 'update'])->name('admin.pages.update');
        Route::delete('/{page}', [\App\Http\Controllers\AdminStaticPageController::class, 'destroy'])->name('admin.pages.destroy');
    });
    
    // Landing Page Management
    Route::prefix('landing')->controller(\App\Http\Controllers\Admin\LandingPageController::class)->group(function () {
        Route::get('/', 'index')->name('admin.landing.index');
        Route::post('/', 'store')->name('admin.landing.store');
        Route::put('/{section}', 'update')->name('admin.landing.update');
        Route::delete('/{section}', 'destroy')->name('admin.landing.destroy');
        Route::post('/reorder', 'reorder')->name('admin.landing.reorder');
    });
    
    // Chat Management
    Route::prefix('chats')->group(function () {
        Route::get('/', [\App\Http\Controllers\AdminChatController::class, 'index'])->name('admin.chats.index');
        Route::get('/{user}', [\App\Http\Controllers\AdminChatController::class, 'show'])->name('admin.chats.show');
        Route::post('/{user}', [\App\Http\Controllers\AdminChatController::class, 'store'])->name('admin.chats.store');
    });
    // Stock Management
Route::prefix('stock')->controller(\App\Http\Controllers\Admin\StockController::class)->group(function () {
    Route::get('/', 'index')->name('admin.stock.index');
    Route::post('/{product}/update', 'update')->name('admin.stock.update');
    Route::get('/{product}/history', 'history')->name('admin.stock.history');
    Route::get('/export', 'export')->name('admin.stock.export');
});
});
