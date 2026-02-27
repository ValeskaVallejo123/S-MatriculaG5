<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PermisoMiddleware
{
    public function handle(Request $request, Closure $next, string $permiso)
    {
        // 1. Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Debe iniciar sesión para continuar.');
        }

        $user = Auth::user();

        // 2. Validar que tenga rol asignado
        if (!$user->id_rol) {
            abort(403, 'No tiene un rol asignado.');
        }

        // 3. Validar que el permiso solicitado exista
        $existePermiso = DB::table('permisos')
            ->where('nombre', $permiso)
            ->exists();

        if (!$existePermiso) {
            abort(404, 'El permiso solicitado no existe.');
        }

        // 4. Verificar si su rol tiene el permiso asociado
        $tienePermiso = DB::table('permiso_rol')
            ->join('permisos', 'permiso_rol.id_permiso', '=', 'permisos.id')
            ->where('permiso_rol.id_rol', $user->id_rol)
            ->where('permisos.nombre', $permiso)
            ->exists();

        if (!$tienePermiso) {
            abort(403, 'No tiene permiso para realizar esta acción.');
        }

        // 5. Si todo está bien, continuar
        return $next($request);
    }
}
