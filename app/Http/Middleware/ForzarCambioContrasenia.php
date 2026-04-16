<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForzarCambioContrasenia
{
    /**
     * Rutas que se permiten aunque deba cambiar contraseña.
     * Incluye todas las variantes de nombre de ruta que existen en el sistema.
     */
    protected array $rutasPermitidas = [
        '*cambiarcontrasenia.edit',
        '*cambiarcontrasenia.update',
        'logout',
    ];

    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->debe_cambiar_contrasenia) {

            // Permitir la ruta de cambio de contraseña y logout
            foreach ($this->rutasPermitidas as $ruta) {
                if ($request->routeIs($ruta)) {
                    return $next($request);
                }
            }

            // Evitar redirección infinita si ya está en la URL de cambio
            if ($request->is('cambiar-contrasenia', 'cambiarcontrasenia')) {
                return $next($request);
            }

            return redirect()
                ->route('cambiarcontrasenia.edit')
                ->with('warning', 'Debes cambiar tu contraseña antes de continuar.');
        }

        return $next($request);
    }
}
