<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PadrePermiso;
use App\Models\Padre;
use App\Models\Rol;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerificarPermisoPadre
{
    public function handle(Request $request, Closure $next, string $permiso): Response
    {
        // 1. Autenticación
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Debe iniciar sesión.');
        }

        $user = Auth::user();

        // 2. Validar rol asignado
        if (!$user->id_rol) {
            return back()->with('error', 'Usuario sin rol asignado.');
        }

        // 3. Cargar rol
        $rol = Rol::find($user->id_rol);

        if (!$rol) {
            return back()->with('error', 'Rol no encontrado.');
        }

        // 4. Verificar si el rol es padre/tutor
        $nombreRol = strtolower(trim($rol->nombre));
        $esPadre = in_array($nombreRol, ['padre', 'tutor', 'padre/tutor']);

        if (!$esPadre) {
            return back()->with('error', 'Esta acción solo está disponible para padres/tutores.');
        }

        // 5. Buscar registro en la tabla padres
        $padre = Padre::where('user_id', $user->id)->first();

        if (!$padre) {
            return back()->with('error', 'No se encontró un perfil de padre asociado a este usuario.');
        }

        $padreId = $padre->id;

        // 6. Obtener ID del estudiante
        $estudianteId = $request->route('estudiante')
                        ?? $request->route('id')
                        ?? $request->input('estudiante_id');

        if (!$estudianteId) {
            return back()->with('error', 'No se especificó el estudiante.');
        }

        // 7. Buscar configuración de permisos para ese estudiante
        $permisoConfig = PadrePermiso::where('padre_id', $padreId)
            ->where('estudiante_id', $estudianteId)
            ->first();

        if (!$permisoConfig) {
            return back()->with('error', 'No tiene permisos configurados para este estudiante.');
        }

        // 8. Validar que el permiso solicitado exista y sea true
        if (!property_exists($permisoConfig, $permiso)) {
            return back()->with('error', "El permiso '$permiso' no existe en la configuración.");
        }

        if (!$permisoConfig->{$permiso}) {
            return back()->with('error', 'No tiene autorización para realizar esta acción.');
        }

        // 9. Continuar
        return $next($request);
    }
}
