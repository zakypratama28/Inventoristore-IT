<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingPageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LandingPageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $sections = LandingPageSection::orderBy('order')->get();
        return view('admin.landing.index', compact('sections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:hero,features,products,promo,categories,testimonials',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('image');
        
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('landing', 'public');
        }

        $data['order'] = LandingPageSection::max('order') + 1;
        $data['is_active'] = $request->has('is_active');

        LandingPageSection::create($data);

        return redirect()->route('admin.landing.index')
            ->with('success', 'Section created successfully');
    }

    public function update(Request $request, LandingPageSection $section)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('image');
        
        if ($request->hasFile('image')) {
            if ($section->image_path) {
                Storage::disk('public')->delete($section->image_path);
            }
            $data['image_path'] = $request->file('image')->store('landing', 'public');
        }

        $data['is_active'] = $request->has('is_active');
        $section->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Section updated successfully'
        ]);
    }

    public function destroy(LandingPageSection $section)
    {
        if ($section->image_path) {
            Storage::disk('public')->delete($section->image_path);
        }
        
        $section->delete();

        return redirect()->route('admin.landing.index')
            ->with('success', 'Section deleted successfully');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'sections' => 'required|array',
            'sections.*.id' => 'required|exists:landing_page_sections,id',
            'sections.*.order' => 'required|integer',
        ]);

        foreach ($request->sections as $section) {
            LandingPageSection::where('id', $section['id'])
                ->update(['order' => $section['order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully'
        ]);
    }
}
