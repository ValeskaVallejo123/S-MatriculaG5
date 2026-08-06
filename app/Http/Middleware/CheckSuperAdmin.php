<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Si no está autenticado, al login
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        // --- LLAVE MAESTRA ---
        // Si eres tú, pasa sin preguntas
        if (Auth::user()->email === 'superadmin@egm.edu.hn') {
            return $next($request);
        }

        if (! Auth::user()->isSuperAdmin()) {
            abort(403, 'No tienes permisos.');
        }
        // ----------------------

        if (! Auth::user()->isSuperAdmin()) {
            abort(403, 'No tienes permisos.');
        }

        return $next($request);
    }
}
