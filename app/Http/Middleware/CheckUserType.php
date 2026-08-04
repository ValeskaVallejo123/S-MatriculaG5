<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserType
{
    public function handle(Request $request, Closure $next, string ...$types): mixed
    {
        if (!auth()->check() || !in_array(auth()->user()->user_type, $types)) {
            abort(403, 'No tienes permiso para acceder aquí.');
        }

        return $next($request);
    }
}