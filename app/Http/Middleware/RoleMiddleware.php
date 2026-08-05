<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        // No autenticado → login
        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Debes iniciar sesión para acceder.');
        }

        // Super admin pasa siempre
        if ($user->is_super_admin === true || (int) $user->id_rol === 1) {
            return $next($request);
        }

        // Roles permitidos normalizados (minúsculas, sin tildes)
        $rolesNormalizados = array_map(fn($r) => $this->normalizar($r), $roles);

        // Candidatos del usuario — tomamos el primero que no esté vacío
        $candidatos = array_filter([
            $user->rol->nombre ?? null,   // nombre del rol en BD
            $user->user_type   ?? null,   // columna user_type
        ]);

        $coincide = false;
        foreach ($candidatos as $candidato) {
            if (in_array($this->normalizar($candidato), $rolesNormalizados)) {
                $coincide = true;
                break;
            }
        }

        Log::info('RoleMiddleware', [
            'user_id'           => $user->id,
            'id_rol'            => $user->id_rol,
            'rol_nombre'        => $user->rol->nombre ?? 'null',
            'user_type'         => $user->user_type,
            'rolesNormalizados' => $rolesNormalizados,
            'coincide'          => $coincide,
        ]);

        if (!$coincide) {
            abort(403, 'No tienes permiso para acceder a esta página.');
        }

        // 4. Si después de revisar todos los roles no coincide ninguno
        abort(403, 'No tienes permiso para acceder a esta sección.');

    }

    /**
     * Normaliza un string: minúsculas y sin tildes comunes.
     */
    private function normalizar(string $valor): string
    {
        $valor = strtolower(trim($valor));

        $mapa = [
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
            'ü' => 'u', 'ñ' => 'n',
        ];

        return strtr($valor, $mapa);
    }
}