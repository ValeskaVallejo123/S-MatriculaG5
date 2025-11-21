<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerificarPermiso
{
    public function handle(Request $request, Closure $next, ...$permisos): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder.');
        }

        $usuario = Auth::user();

        if (empty($permisos)) {
            return $next($request);
        }

        // Verificar si el usuario tiene rol
        if (!$usuario->rol) {
            abort(403, 'Usuario sin rol asignado.');
        }

        // Verificar cada permiso directamente sin método
        foreach ($permisos as $permiso) {
            $tienePermiso = $usuario->rol->permisos()->where('nombre', $permiso)->exists();
            if ($tienePermiso) {
                return $next($request);
            }
        }

        abort(403, 'No tienes permisos para acceder a esta sección.');
    }
}