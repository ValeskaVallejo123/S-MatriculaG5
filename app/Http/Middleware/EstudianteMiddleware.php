<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EstudianteMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Str::endsWith(Auth::user()->email, '@estudiante.egm.edu.hn')) {
            return $next($request);
        }

        abort(403, 'Acceso no autorizado.');
    }
}
