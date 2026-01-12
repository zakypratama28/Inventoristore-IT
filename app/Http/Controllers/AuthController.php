<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect based on role
            if (Auth::user()->role === 'customer') {
                return redirect()->intended(route('home'));
            }

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer', // Default role
            'verification_code' => $code,
        ]);

        // Kirim email verifikasi
        try {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\VerifyEmail($user));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Mail Error: ' . $e->getMessage());
            // Simpan flash message agar user tahu mail gagal tapi kode ada di log
            session()->flash('warning', 'Sistem gagal mengirim email. Jika Anda di localhost, cek storage/logs/laravel.log untuk kodenya.');
        }

        Auth::login($user);

        return redirect(route('verification.notice'));
    }

    public function resendVerificationCode(Request $request)
    {
        $user = Auth::user();
        
        // Generate kode baru
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $user->update(['verification_code' => $code]);

        try {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\VerifyEmail($user));
            return back()->with('success', 'Kode verifikasi baru telah dikirim.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Mail Error: ' . $e->getMessage());
            return back()->with('warning', 'Gagal mengirim email. Cek file log untuk kode: ' . $code);
        }
    }

    public function showVerify()
    {
        return view('auth.verify');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        $user = Auth::user();

        if ($request->code === $user->verification_code) {
            $user->update([
                'email_verified_at' => now(),
                'verification_code' => null,
            ]);

            return redirect(route('home'))->with('success', 'Email berhasil diverifikasi.');
        }

        return back()->withErrors(['code' => 'Kode verifikasi tidak valid atau kadaluarsa.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
