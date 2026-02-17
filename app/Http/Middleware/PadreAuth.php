<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PadreAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el padre está autenticado
        if (!Session::has('padre_autenticado') || !Session::get('padre_autenticado')) {
            return redirect()->route('padres.login')
                ->with('error', 'Debe iniciar sesión para acceder a esta página');
        }

        // Verificar que tenga una solicitud asociada
        if (!Session::has('solicitud_id')) {
            return redirect()->route('padres.login')
                ->with('error', 'Sesión inválida, por favor inicie sesión nuevamente');
        }

        return $next($request);
    }
}