<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Lógica para verificar autenticación y propiedad 'is_admin'
        $user = Auth::user();
        if (!$user || !$user->is_admin) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        // Lógica de verificación de correo electrónico existente (solo se ejecuta si el usuario está autenticado y es admin)
        if (Str::endsWith($user->email, '@admin.egm.edu.hn')) {
            return $next($request);
        }

        // Si la verificación de correo electrónico falla, se deniega el acceso.
        abort(403, 'Acceso no autorizado.');
    }
}