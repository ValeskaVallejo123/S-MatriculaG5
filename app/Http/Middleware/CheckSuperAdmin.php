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
        if (!Auth::check()) {
            abort(403, 'No has iniciado sesión.');
        }

        /** @var User $user */
        $user = Auth::user();

        if (!$user->isSuperAdmin()) {
            abort(403, 'No tienes permisos para acceder a esta sección');
        }

        return $next($request);
    }
}
