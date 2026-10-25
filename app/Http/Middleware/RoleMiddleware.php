<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2. Cek apakah role user ada di dalam daftar role yang diizinkan
        $user = Auth::user();
        if (in_array($user->role, $roles)) {
            return $next($request); // Izinkan masuk
        }

        // 3. Jika tidak punya akses, lempar kembali
        if ($user->role === 'customer') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }

        return redirect('/dashboard')->with('error', 'Akses ditolak.');
    }
}