<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Switch language
     */
    public function switch($locale)
    {
        if (!in_array($locale, ['id', 'en'])) {
            abort(400);
        }

        // Save to session
        session(['locale' => $locale]);

        // Save to user profile if authenticated
        if (auth()->check()) {
            auth()->user()->update(['locale' => $locale]);
        }

        return redirect()->back();
    }
}
