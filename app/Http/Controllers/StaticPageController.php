<?php

namespace App\Http\Controllers;

use App\Models\StaticPage;

class StaticPageController extends Controller
{
    /**
     * Display static page by slug
     */
    public function show($slug)
    {
        $page = StaticPage::where('slug', $slug)
                         ->active()
                         ->firstOrFail();
        
        return view('pages.show', compact('page'));
    }
}
