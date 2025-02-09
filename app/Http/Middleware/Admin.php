<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return match (Auth::user()->role) {
            'admin' => $next($request),
            'super_admin' => redirect()->route('superadmin.dashboard'),
            'user' => redirect()->route('dashboard'),
            default => redirect()->route('login')->with('error', 'Invalid role')
        };
    }
}
