<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarPermiso
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$permisos - Lista de permisos requeridos
     */
    public function handle(Request $request, Closure $next, ...$permisos): Response
    {
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder.');
        }

        $usuario = auth()->user();

        // Si no se especifican permisos, solo verificar que esté autenticado
        if (empty($permisos)) {
            return $next($request);
        }

        // Verificar si el usuario tiene al menos uno de los permisos requeridos
        foreach ($permisos as $permiso) {
            if ($usuario->tienePermiso($permiso)) {
                return $next($request);
            }
        }

        // Si no tiene ninguno de los permisos, denegar acceso
        abort(403, 'No tienes permisos para acceder a esta sección.');
    }
}