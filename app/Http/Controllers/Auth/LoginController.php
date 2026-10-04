<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Rate Limiting Key: IP + Email
        $throttleKey = Str::transliterate(Str::lower($request->input('email', '')) . '|' . $request->ip());

        // Maximum 5 failed attempts per 60 seconds
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'email' => "Terlalu banyak percobaan login gagal. Demi keamanan, akun ini dikunci sementara selama {$seconds} detik.",
            ])->onlyInput('email');
        }

        $credentials = $request->validate([
            'email' => 'required|email|max:100',
            'password' => 'required|string|min:6|max:100',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Clear rate limiting upon successful authentication
            RateLimiter::clear($throttleKey);

            // Regenerate session to prevent session fixation attacks
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Selamat datang di Dashboard Admin Life Solution Connection.');
        }

        // Increment failed attempts
        RateLimiter::hit($throttleKey, 60);

        $remaining = RateLimiter::remaining($throttleKey, 5);
        $errorMessage = 'Email atau kata sandi yang Anda masukkan salah.';
        if ($remaining > 0 && $remaining <= 3) {
            $errorMessage .= " Peringatan: Sisa kesempatan login adalah {$remaining} kali.";
        }

        return back()->withErrors([
            'email' => $errorMessage,
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate session and regenerate CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('info', 'Sesi Anda telah berakhir. Anda telah berhasil keluar dari sistem.');
    }
}
