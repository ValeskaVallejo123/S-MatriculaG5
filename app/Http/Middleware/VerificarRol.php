<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerificarRol
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder.');
        }

        $usuario = Auth::user();

        if (empty($roles)) {
            return $next($request);
        }

        // Verificar si el usuario tiene rol
        if (!$usuario->rol) {
            abort(403, 'Usuario sin rol asignado.');
        }

        // Verificar cada rol directamente sin método
        foreach ($roles as $rol) {
            if ($usuario->rol->nombre === $rol) {
                return $next($request);
            }
        }

        abort(403, 'No tienes el rol necesario para acceder a esta sección.');
    }
}