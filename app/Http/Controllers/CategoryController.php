<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // ambil semua kategori untuk ditampilkan di tabel
        $categories = Category::orderBy('name')->get();

        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100', 'unique:categories,name'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        Category::create($data);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori baru berhasil ditambahkan.');
    }
}
