<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Validar que exista el rol
        if (!$user->rol) {
            abort(403, 'No tiene un rol asignado.');
        }

        // Comparar con el rol requerido
        if (strtolower($user->rol->nombre) !== strtolower($role)) {
            abort(403, 'No tiene permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}
