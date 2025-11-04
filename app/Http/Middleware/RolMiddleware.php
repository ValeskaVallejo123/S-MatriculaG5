<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $rol
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $rol)
    {
        if (!Auth::check()) {
            return redirect()->route('login.show'); // usuario no autenticado
        }

        $user = Auth::user();

        if ($user->rol !== $rol) {
            return redirect('/')->with('error', 'No tienes permisos para acceder a esta página.');
        }

        return $next($request);
    }
}

