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
        // 1. Verificar si está autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder.');
        }

        $usuario = Auth::user();

        // 2. Si no se definieron permisos en el middleware, permitir el acceso
        if (empty($permisos)) {
            return $next($request);
        }

        // 3. Verificar que el usuario tenga rol asignado
        if (!$usuario->rol) {
            abort(403, 'Usuario sin rol asignado.');
        }

        // ⚠ Importante: convertir listas tipo "crear-user,eliminar-user" a array normal
        $permisos = collect($permisos)
            ->map(fn($p) => explode(',', $p))
            ->flatten()
            ->unique()
            ->toArray();

        // 4. Obtener todos los permisos del rol una sola vez (mejor rendimiento)
        $permisosUsuario = $usuario->rol->permisos->pluck('nombre')->toArray();

        // 5. Verificar si el usuario tiene al menos uno de los permisos requeridos
        foreach ($permisos as $permiso) {
            if (in_array($permiso, $permisosUsuario)) {
                return $next($request);
            }
        }

        // 6. Si no tiene ninguno, denegar acceso
        abort(403, 'No tienes permisos para acceder a esta sección.');
    }
}
