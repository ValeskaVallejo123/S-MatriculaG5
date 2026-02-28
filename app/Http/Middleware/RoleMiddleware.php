<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'No autenticado');
        }

        // ✅ SUPER ADMINISTRADOR: acceso total
        if ($user->is_super_admin == 1 || $user->id_rol == 1) {
            return $next($request);
        }

        // Validar rol normal
        if (!$user->rol || !in_array(strtolower($user->rol->nombre), $roles)) {
            abort(403, 'Acceso denegado');
        }

        return $next($request);
    }
}
