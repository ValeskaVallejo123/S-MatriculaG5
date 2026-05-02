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

        // Si no está autenticado → redirigir a login
        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Debes iniciar sesión para acceder.');
        }

        // Si es super admin → pasa automáticamente
        if ($user->is_super_admin === true || (int) $user->id_rol === 1) {
            return $next($request);
        }

        // Normalizar roles recibidos en la ruta
        $rolesNormalizados = array_map('strtolower', $roles);

        // Obtener rol del usuario (seguro contra null)
        $rolUsuario = strtolower(trim($user->rol->nombre ?? ''));

        // Si no tiene rol o no coincide
        if (!$user->rol || !in_array($rolUsuario, $rolesNormalizados)) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}
