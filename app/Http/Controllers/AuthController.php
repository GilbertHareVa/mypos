<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        // Jika sudah login, arahkan ke halamannya masing-masing
        if (Auth::check()) {
            return Auth::user()->role === 'admin' ? redirect()->route('admin.dashboard') : redirect()->route('pos.index');
        }
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Cek apakah akun aktif
            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun dinonaktifkan oleh Admin.']);
            }

            // Aturan redirect Kasir vs Admin sesuai spesifikasi
            if ($user->role === 'kasir') {
                $request->session()->forget('url.intended');
                return redirect()->route('pos.index');
            }
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}