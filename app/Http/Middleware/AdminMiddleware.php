<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     * Hanya mengizinkan user dengan role 'admin' untuk masuk.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'superadmin'])) {
            abort(403, 'Akses ditolak. Halaman ini khusus untuk Administrator.');
        }

        return $next($request);
    }
}
