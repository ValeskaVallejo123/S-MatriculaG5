<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si no está autenticado → prohibido
        if (!auth()->check()) {
            abort(403, 'No has iniciado sesión.');
        }

        // Si el usuario no es super admin → prohibido
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'No tienes permisos para acceder a esta sección');
        }

        return $next($request);
    }
}


