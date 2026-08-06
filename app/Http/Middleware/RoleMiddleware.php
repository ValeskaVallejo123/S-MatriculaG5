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

        // 1. Si no está autenticado → redirigir a login
        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Debes iniciar sesión para acceder.');
        }

        // 2. Si es super admin → pasa automáticamente
        if ($user->is_super_admin === true || (int) $user->id_rol === 1) {
            return $next($request);
        }

        // 3. Verificamos si el usuario tiene alguno de los roles permitidos
        // Usamos el método tieneRol del modelo User que es más completo
        foreach ($roles as $role) {
            if ($user->tieneRol($role)) {
                return $next($request);
            }
        }

        // 4. Si después de revisar todos los roles no coincide ninguno
        abort(403, 'No tienes permiso para acceder a esta sección.');

    }
}
