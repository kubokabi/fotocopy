<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            // Jika pengguna sudah login, redirect ke halaman dashboard
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
