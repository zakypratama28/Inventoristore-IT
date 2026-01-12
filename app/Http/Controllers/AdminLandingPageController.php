<?php

namespace App\Http\Controllers;

use App\Models\LandingPageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminLandingPageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin,staff']);
    }

    /**
     * Display landing page sections for management
     */
    public function index()
    {
        $sections = LandingPageSection::orderBy('order')->get();
        return view('admin.landing.index', compact('sections'));
    }

    /**
     * Update landing page section
     */
    public function update(Request $request, LandingPageSection $section)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($section->image_path) {
                Storage::disk('public')->delete($section->image_path);
            }
            $data['image_path'] = $request->file('image')->store('landing', 'public');
        }

        $section->update($data);

        return redirect()->route('admin.landing.index')
                       ->with('success', 'Section updated successfully');
    }
}
