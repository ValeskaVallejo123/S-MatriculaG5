<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerificarRol
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Verificar autenticación
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Debes iniciar sesión para acceder.');
        }

        $usuario = Auth::user();

        // Si no se especificaron roles, permitir acceso
        if (empty($roles)) {
            return $next($request);
        }

        // Verificar si el usuario tiene un rol asignado
        if (!$usuario->rol) {
            abort(403, 'Usuario sin rol asignado.');
        }

        // Normalizar roles: minúsculas, separados por coma, sin duplicados
        $roles = collect($roles)
            ->map(fn($r) => explode(',', $r))   // soporta "Admin,Profesor"
            ->flatten()
            ->map(fn($r) => strtolower(trim($r)))
            ->unique()
            ->toArray();

        // Rol del usuario en minúsculas
        $rolUsuario = strtolower(trim($usuario->rol->nombre));

        // Verificar si coincide con alguno
        if (in_array($rolUsuario, $roles)) {
            return $next($request);
        }

        abort(403, 'No tienes el rol necesario para acceder a esta sección.');
    }
}
