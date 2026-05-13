<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EsPadre
{
    /**
     * Solo permite el acceso a usuarios con rol de padre/tutor.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!$user->estaActivo()) {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Tu cuenta está desactivada. Contacta al administrador.');
        }

        if (!$user->isPadre()) {
            abort(403, 'Acceso exclusivo para padres/tutores.');
        }

        return $next($request);
    }
}