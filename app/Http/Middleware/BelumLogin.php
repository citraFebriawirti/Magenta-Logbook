<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class BelumLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $currentPath = $request->path();
            if (Auth::user()->role === 'admin' && $currentPath !== 'admin-dashboard') {
                return redirect('/admin-dashboard');
            } elseif (Auth::user()->role === 'mentor' && $currentPath !== 'mentor-dashboard') {
                return redirect('/mentor-dashboard');
            } elseif (Auth::user()->role === 'peserta' && $currentPath !== 'peserta-dashboard') {
                return redirect('/peserta-dashboard');
            }
        }
        return $next($request);
    }
}