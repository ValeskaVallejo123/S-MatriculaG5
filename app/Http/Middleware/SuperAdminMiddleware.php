<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Maneja la solicitud entrante.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Verificar si el usuario está autenticado.
        if (!Auth::check()) {
            // Si no está autenticado, redirigir al login.
            return redirect('/login');
        }

        $user = Auth::user();

        // 2. Verificar las dos condiciones de acceso (Rol Y Dominio de Email).
        $isSuperAdmin = ($user->role === 'super_admin');
        $hasCorrectDomain = Str::endsWith($user->email, '@egm.edu.hn');

        // Si se cumplen ambas condiciones, permitir el acceso.
        if ($isSuperAdmin && $hasCorrectDomain) {
            return $next($request);
        }

        // Si el usuario está autenticado pero no cumple alguna de las condiciones,
        // abortar la solicitud con un error 403 (Prohibido).
        abort(403, 'Acceso Denegado. Se requiere ser Super Administrador y pertenecer al dominio @egm.edu.hn.');
    }
}