<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PembimbingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $user = \App\User::where('email', $request->email)->first();
        if (auth()->user()->role == 'pembimbing' || auth()->user()->role == 'super_admin') {
            return $next($request);
        }

        alert()->error('Akses Dilarang', 'Anda tidak memiliki hak akses untuk halaman ini.');

        return redirect()->back();

    }
}
