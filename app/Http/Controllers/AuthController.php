<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Tampilan Login Utama (Menggunakan file login.blade.php)
    public function customerLoginForm()
    {
        return view('auth.login');
    }

    // 2. Tampilan Login Admin & Staff
    public function adminLoginForm()
    {
        return view('auth.admin_login');
    }

    // 3. Proses Data Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            if (in_array(Auth::user()->role, ['admin', 'staff'])) {
                return redirect()->route('dashboard'); 
            }
            
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // 4. Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah berhasil logout.');
    }
}