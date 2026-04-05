<?php

namespace App\Helpers;

class GradoHelper 
{
    public const GRADOS = [
        '1er Grado', '2do Grado', '3er Grado',
        '4to Grado', '5to Grado', '6to Grado',
        '7mo Grado', '8vo Grado', '9no Grado',
    ];

    public const GRADO_MAP = [
        // Texto
        'primero'   => '1er Grado',
        'segundo'   => '2do Grado',
        'tercero'   => '3er Grado',
        'cuarto'    => '4to Grado',
        'quinto'    => '5to Grado',
        'sexto'     => '6to Grado',
        'séptimo'   => '7mo Grado',
        'septimo'   => '7mo Grado',
        'octavo'    => '8vo Grado',
        'noveno'    => '9no Grado',

        // Números
        '1' => '1er Grado',
        '2' => '2do Grado',
        '3' => '3er Grado',
        '4' => '4to Grado',
        '5' => '5to Grado',
        '6' => '6to Grado',
        '7' => '7mo Grado',
        '8' => '8vo Grado',
        '9' => '9no Grado',

        // Ya normalizados (en minúscula)
        '1er grado' => '1er Grado',
        '2do grado' => '2do Grado',
        '3er grado' => '3er Grado',
        '4to grado' => '4to Grado',
        '5to grado' => '5to Grado',
        '6to grado' => '6to Grado',
        '7mo grado' => '7mo Grado',
        '8vo grado' => '8vo Grado',
        '9no grado' => '9no Grado',
    ];

    public static function normalizar(?string $grado): string
    {
        if (empty($grado)) {
            return 'Sin Grado';
        }

        // 🔥 NORMALIZACIÓN FUERTE
        $grado = trim($grado);
        $grado = mb_strtolower($grado, 'UTF-8');

        // Quitar espacios dobles
        $grado = preg_replace('/\s+/', ' ', $grado);

        // Buscar en el mapa
        if (isset(self::GRADO_MAP[$grado])) {
            return self::GRADO_MAP[$grado];
        }

        // 🔥 EXTRA: intentar detectar número dentro del texto
        if (preg_match('/([1-9])/', $grado, $match)) {
            return self::GRADO_MAP[$match[1]] ?? 'Sin Grado';
        }

        // Fallback seguro
        return 'Sin Grado';
    }
}