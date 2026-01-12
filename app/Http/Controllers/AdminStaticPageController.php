<?php

namespace App\Http\Controllers;

use App\Models\StaticPage;
use Illuminate\Http\Request;

class AdminStaticPageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin,staff']);
    }

    /**
     * Display all static pages
     */
    public function index()
    {
        $pages = StaticPage::latest()->paginate(15);
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.pages.form');
    }

    /**
     * Store new static page
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:static_pages,slug',
            'content' => 'required|string',
            'meta_description' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        StaticPage::create($request->all());

        return redirect()->route('admin.pages.index')
                       ->with('success', 'Static page created successfully');
    }

    /**
     * Show edit form
     */
    public function edit(StaticPage $page)
    {
        return view('admin.pages.form', compact('page'));
    }

    /**
     * Update static page
     */
    public function update(Request $request, StaticPage $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:static_pages,slug,' . $page->id,
            'content' => 'required|string',
            'meta_description' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $page->update($request->all());

        return redirect()->route('admin.pages.index')
                       ->with('success', 'Static page updated successfully');
    }

    /**
     * Delete static page
     */
    public function destroy(StaticPage $page)
    {
        $page->delete();

        return redirect()->route('admin.pages.index')
                       ->with('success', 'Static page deleted successfully');
    }
}
