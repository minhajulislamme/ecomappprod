<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class User
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return match (Auth::user()->role) {
            'user' => $next($request),
            'admin' => redirect()->route('admin.dashboard'),
            'super_admin' => redirect()->route('superadmin.dashboard'),
            default => redirect()->route('login')->with('error', 'Invalid role')
        };
    }
}
