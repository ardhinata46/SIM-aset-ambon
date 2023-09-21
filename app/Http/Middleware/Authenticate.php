<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (Auth::guard('admin')->check()) {
            // Admin yang sudah login akan diarahkan ke halaman dashboard admin
            return '/admin/dashboard';
        } elseif (Auth::guard('superadmin')->check()) {
            // Superadmin yang sudah login akan diarahkan ke halaman dashboard superadmin
            return '/superadmin/dashboard';
        } else {
            // Pengguna yang belum login atau bukan admin akan diarahkan ke halaman login
            return '/login';
        }
    }
}
