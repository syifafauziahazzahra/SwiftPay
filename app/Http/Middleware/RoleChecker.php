<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        $ps = explode('|', $permission);

        // Untuk Mengecek apakah user memiliki role yang diizinkan admin petugas dan useer
        if (in_array(Auth::user()->role, $ps)) {
            return $next($request);
        }
        return redirect('/');
    }
}
