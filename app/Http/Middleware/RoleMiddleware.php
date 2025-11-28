<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        // Verificar que el usuario esté autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Validar que el usuario tenga un rol asignado
        if (!$user->rol) {
            abort(403, 'No tiene un rol asignado.');
        }

        // Comparar el nombre del rol recibido con el del usuario
        if ($user->rol->nombre !== $role) {
            abort(403, 'No tiene permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}
