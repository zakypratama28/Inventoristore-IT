<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the FAQs
     */
    public function index()
    {
        $faqs = Faq::ordered()->paginate(20);
        return view('admin.faq.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new FAQ
     */
    public function create()
    {
        return view('admin.faq.create');
    }

    /**
     * Store a newly created FAQ
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.faq.index')
                        ->with('success', 'FAQ berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the FAQ
     */
    public function edit(Faq $faq)
    {
        return view('admin.faq.edit', compact('faq'));
    }

    /**
     * Update the specified FAQ
     */
    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.faq.index')
                        ->with('success', 'FAQ berhasil diperbarui!');
    }

    /**
     * Remove the specified FAQ
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('admin.faq.index')
                        ->with('success', 'FAQ berhasil dihapus!');
    }
}
