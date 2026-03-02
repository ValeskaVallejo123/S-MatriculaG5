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

        // CORRECCIÓN: el original hacía abort(403) cuando el usuario no estaba
        // autenticado. Esto causaba que en vez de redirigir al login, se mostrara
        // una página de error — y en algunos casos Laravel intentaba renderizar
        // esa página de error accediendo a auth()->user() nuevamente, causando
        // el error "undefined method user" en un loop.
        // La corrección correcta es redirigir al login.
        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Debes iniciar sesión para acceder.');
        }

        // CORRECCIÓN: el original usaba $user->is_super_admin == 1 (comparación
        // laxa) y $user->id_rol == 1. Si no se pasan roles al middleware (ej:
        // middleware('role:superadmin')), el superadmin igual pasa. Correcto.
        // Se mantiene la lógica pero se usa comparación estricta.
        if ($user->is_super_admin === true || (int) $user->id_rol === 1) {
            return $next($request);
        }

        // CORRECCIÓN: el original usaba strtolower() solo sobre el nombre del rol
        // pero no sobre los $roles recibidos como parámetro. Si en web.php se
        // escribe middleware('role:Admin') y en BD el rol es 'admin', no coincidía.
        // Ahora se normaliza ambos lados.
        $rolesNormalizados = array_map('strtolower', $roles);
        $rolUsuario        = strtolower(trim($user->rol->nombre ?? ''));

        if (!$user->rol || !in_array($rolUsuario, $rolesNormalizados)) {
            // CORRECCIÓN: devolver 403 con mensaje claro en vez de abort() vacío
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}
