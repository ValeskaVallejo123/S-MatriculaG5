<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PermisoMiddleware
{
    public function handle(Request $request, Closure $next, string $permiso): Response
    {
        // Verificar autenticación
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Verificar que el usuario tenga un rol
        if (!$user->id_rol) {
            abort(403, 'No tiene un rol asignado.');
        }

        // Verificar permiso directamente con query
        $tienePermiso = DB::table('permiso_rol')
            ->join('permisos', 'permiso_rol.id_permiso', '=', 'permisos.id')
            ->where('permiso_rol.id_rol', $user->id_rol)
            ->where('permisos.nombre', $permiso)
            ->exists();

        if (!$tienePermiso) {
            abort(403, 'No tiene permiso para realizar esta acción.');
        }

        return $next($request);
    }
}