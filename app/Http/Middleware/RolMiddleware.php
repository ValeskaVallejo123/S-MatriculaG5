<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/*class RolMiddleware
{
    public function handle(Request $request, Closure $next, $rol)
    {
        if (Auth::check() && Auth::user()->rol === $rol) {
            return $next($request);
        }
        abort(403, 'Acceso denegado');
    }
}
*/
class RolMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $rol
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $rol)
    {
        if (!Auth::check()) {
            return redirect()->route('login.show');
        }

        $user = Auth::user();

        if ($user->rol !== $rol) {
            // Opcional: redirigir a una página de "acceso denegado"
            return redirect('/')->with('error', 'No tienes permisos para acceder a esta página.');
        }

        return $next($request);
    }
}
