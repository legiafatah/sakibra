<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperadminAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('superadmin')->check()) {
            return redirect()->to('/superadmin/login')->with('error', 'Silakan login terlebih dahulu');
        }

        return $next($request);
    }
}
