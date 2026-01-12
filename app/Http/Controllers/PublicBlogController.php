<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class PublicBlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::published()->with('user');
        
        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }
        
        $posts = $query->latest('published_at')->paginate(9);
        $featuredPost = BlogPost::published()
            ->orderBy('views', 'desc')
            ->first();
        
        return view('blog.index', compact('posts', 'featuredPost'));
    }

    public function show($slug)
    {
        $post = BlogPost::where('slug', $slug)
            ->published()
            ->with('user')
            ->firstOrFail();
        
        // Increment views
        $post->incrementViews();
        
        // Get related posts
        $relatedPosts = BlogPost::published()
            ->where('category', $post->category)
            ->where('id', '!=', $post->id)
            ->take(3)
            ->get();
        
        return view('blog.show', compact('post', 'relatedPosts'));
    }
}
