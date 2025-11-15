<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PadrePermiso;
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
        $user = auth()->user();
        
        // Verificar si el usuario es un padre
        if (!$user || !$user->padre) {
            return redirect()->route('login')
                ->with('error', 'Debe iniciar sesión como padre/tutor.');
        }
        
        $padreId = $user->padre->id;
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
        if (!$permisoConfig->{$permiso}) {
            return back()->with('error', 'No tiene autorización para realizar esta acción.');
        }
        
        return $next($request);
    }
}