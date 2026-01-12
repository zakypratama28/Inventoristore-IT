<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display public FAQ page
     */
    public function index()
    {
        $faqs = Faq::active()->ordered()->get();
        return view('faq.index', compact('faqs'));
    }
}
