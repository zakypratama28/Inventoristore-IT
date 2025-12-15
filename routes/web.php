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

Route::middleware('auth')->group(function () {
    // keranjang
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{item}', [CartController::class, 'destroy'])->name('cart.destroy');

    // checkout
    Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

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

    return view('home', compact(
        'totalProducts',
        'totalCategories',
        'maxPrice',
        'minPrice',
        'totalStock',
        'avgPrice',
        'productsForChart',
        'categorySummary'
    ));
})->name('home');

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
        Route::delete('/{category}', 'destroy')->name('categories.destroy');
    });
