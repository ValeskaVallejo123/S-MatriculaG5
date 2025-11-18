<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // OPCIÓN 1: Validar por dominio de email
        $isAdminByEmail = Str::endsWith($user->email, '@admin.egm.edu.hn');
        
        // OPCIÓN 2: Validar si es Super Admin (termina en @egm.edu.hn)
        $isSuperAdminByEmail = Str::endsWith($user->email, '@egm.edu.hn');

        // OPCIÓN 3: Validar por user_type
        $isAdminByType = in_array($user->user_type ?? '', ['admin', 'super_admin']);

        // OPCIÓN 4: Validar por rol (si tienes campo 'role')
        $isAdminByRole = isset($user->role) && in_array($user->role, ['admin', 'super_admin']);

        // Si cumple con CUALQUIERA de las condiciones, permitir acceso
        if ($isAdminByEmail || $isSuperAdminByEmail || $isAdminByType || $isAdminByRole) {
            return $next($request);
        }

        abort(403, 'Acceso no autorizado. Solo administradores pueden acceder a esta sección.');
    }
}