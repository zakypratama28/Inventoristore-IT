<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(12);

        return view('shop.index', compact('products'));
    }
}
