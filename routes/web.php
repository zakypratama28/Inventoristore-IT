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

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Public Storefront
Route::get('/', [StoreController::class, 'index'])->name('home');

// Authenticated Routes (Customer & General)
Route::middleware('auth')->group(function () {
    // keranjang
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{item}', [CartController::class, 'destroy'])->name('cart.destroy');

    // checkout
    Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // orders (Customer view)
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{order}', [OrderController::class, 'show'])->name('orders.show');
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

        // New Stats for E-commerce
        $totalOrders = \App\Models\Order::count();
        $revenue = \App\Models\Order::sum('total');
        $recentOrders = \App\Models\Order::with('user')->latest()->take(5)->get();
        $totalUsers = \App\Models\User::where('role', 'customer')->count();

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
            'totalUsers'
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
            Route::get('/show/{id}', 'show')->name('products.show');
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
    Route::get('/customers', [\App\Http\Controllers\AdminCustomerController::class, 'index'])->name('admin.customers.index');
    Route::get('/reports', [\App\Http\Controllers\AdminReportController::class, 'index'])->name('admin.reports.index');
});
