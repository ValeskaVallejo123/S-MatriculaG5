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
    /**
     * Middleware para verificar que un padre tenga permiso específico
     * para realizar una acción sobre un estudiante.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permiso): Response
    {
        // Verificar autenticación
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Debe iniciar sesión.');
        }

        $user = Auth::user();
        
        // Obtener el rol del usuario
        if (!$user->id_rol) {
            return redirect()->back()
                ->with('error', 'Usuario sin rol asignado.');
        }

        $rol = Rol::find($user->id_rol);
        
        if (!$rol) {
            return redirect()->back()
                ->with('error', 'Rol no encontrado.');
        }

        // Verificar si el rol es de padre/tutor
        $nombreRol = strtolower($rol->nombre);
        $esPadre = in_array($nombreRol, ['padre', 'tutor', 'padre/tutor']);
        
        if (!$esPadre) {
            return redirect()->back()
                ->with('error', 'Esta acción solo está disponible para padres/tutores.');
        }

        // Buscar el registro del padre en la tabla padres
        $padre = Padre::where('user_id', $user->id)->first();
        
        if (!$padre) {
            return redirect()->back()
                ->with('error', 'No se encontró el perfil de padre asociado a su usuario.');
        }
        
        $padreId = $padre->id;
        $estudianteId = $request->route('estudiante') ?? $request->input('estudiante_id');
        
        if (!$estudianteId) {
            return back()->with('error', 'No se especificó el estudiante.');
        }
        
        // Buscar el permiso
        $permisoConfig = PadrePermiso::where('padre_id', $padreId)
                                    ->where('estudiante_id', $estudianteId)
                                    ->first();
        
        // Si no existe configuración, denegar por defecto
        if (!$permisoConfig) {
            return back()->with('error', 'No tiene permisos configurados para este estudiante.');
        }
        
        // Verificar el permiso específico
        if (!isset($permisoConfig->{$permiso}) || !$permisoConfig->{$permiso}) {
            return back()->with('error', 'No tiene autorización para realizar esta acción.');
        }
        
        return $next($request);
    }
}