<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Models\Category;

Route::get('/', function () {
    $totalProducts   = Product::count();
    $totalCategories = Category::count();
    $maxPrice        = Product::max('price') ?? 0;
    $minPrice        = Product::min('price') ?? 0;
    $totalStock      = Product::sum('stock');
    $avgPrice        = Product::avg('price') ?? 0;

    // DATA UNTUK CHART
    // Ambil max 10 produk buat grafik harga
    $productsForChart = Product::with('category')
        ->orderBy('name')
        ->take(10)
        ->get();

    // Rekap jumlah produk per kategori
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
