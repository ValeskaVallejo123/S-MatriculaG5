<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;

class CheckSuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión');
        }

        // Verificar si el usuario es super admin
        if (Auth::user()->user_type !== 'super_admin') {
            abort(403, 'No tienes permisos para acceder a esta sección');
        }

        return $next($request);
    }
}
