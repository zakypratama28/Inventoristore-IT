<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminBlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::with('user');
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $request->search . '%');
            });
        }
        
        $posts = $query->latest()->paginate(15);
        
        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:300',
            'content' => 'required|string',
            'category' => 'required|in:Gaming,Gadgets,Smartphone,Tech,Review',
            'status' => 'required|in:published,draft',
            'featured_image' => 'nullable|image|max:2048'
        ]);

        $validated['user_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']);
        
        if ($request->status === 'published' && !isset($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // Handle image upload
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('blog-images', 'public');
            $validated['featured_image'] = $path;
        }

        BlogPost::create($validated);

        return redirect()->route('admin.blog.index')
            ->with('success', 'Blog post created successfully!');
    }

    public function edit(BlogPost $post)
    {
        return view('admin.blog.edit', compact('post'));
    }

    public function update(Request $request, BlogPost $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:300',
            'content' => 'required|string',
            'category' => 'required|in:Gaming,Gadgets,Smartphone,Tech,Review',
            'status' => 'required|in:published,draft',
            'featured_image' => 'nullable|image|max:2048'
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        
        if ($request->status === 'published' && !$post->published_at) {
            $validated['published_at'] = now();
        }

        // Handle image upload
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('blog-images', 'public');
            $validated['featured_image'] = $path;
        }

        $post->update($validated);

        return redirect()->route('admin.blog.index')
            ->with('success', 'Blog post updated successfully!');
    }

    public function destroy(BlogPost $post)
    {
        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Blog post deleted successfully!'
        ]);
    }
}
