<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SeccionSeeder extends Seeder
{
    /**
     * Secciones según distribución docente
     * CEB Gabriela Mistral — Año 2026
     *
     * Tabla 'seccion' solo tiene: id, nombre, capacidad
     *
     * Matutina:   1°(A,B), 2°(A,B), 3°(A,B), 4°(A,B), 5°(A,B), 6°(A,B,C)
     * Vespertina: 1°(C),   2°(C),   3°(C,D), 4°(C,D), 5°(C,D), 6°(D)
     * III Ciclo:  7°(A),   8°(A),   9°(A)
     */
    public function run(): void
    {
        $now = Carbon::now();

        $secciones = [
            // 1°
            ['nombre' => '1° A', 'capacidad' => 35],
            ['nombre' => '1° B', 'capacidad' => 35],
            ['nombre' => '1° C', 'capacidad' => 35],
            // 2°
            ['nombre' => '2° A', 'capacidad' => 35],
            ['nombre' => '2° B', 'capacidad' => 35],
            ['nombre' => '2° C', 'capacidad' => 35],
            // 3°
            ['nombre' => '3° A', 'capacidad' => 35],
            ['nombre' => '3° B', 'capacidad' => 35],
            ['nombre' => '3° C', 'capacidad' => 35],
            ['nombre' => '3° D', 'capacidad' => 35],
            // 4°
            ['nombre' => '4° A', 'capacidad' => 35],
            ['nombre' => '4° B', 'capacidad' => 35],
            ['nombre' => '4° C', 'capacidad' => 35],
            ['nombre' => '4° D', 'capacidad' => 35],
            // 5°
            ['nombre' => '5° A', 'capacidad' => 35],
            ['nombre' => '5° B', 'capacidad' => 35],
            ['nombre' => '5° C', 'capacidad' => 35],
            ['nombre' => '5° D', 'capacidad' => 35],
            // 6°
            ['nombre' => '6° A', 'capacidad' => 35],
            ['nombre' => '6° B', 'capacidad' => 35],
            ['nombre' => '6° C', 'capacidad' => 35],
            ['nombre' => '6° D', 'capacidad' => 35],
            // III Ciclo
            ['nombre' => '7° A', 'capacidad' => 35],
            ['nombre' => '8° A', 'capacidad' => 35],
            ['nombre' => '9° A', 'capacidad' => 35],
        ];

        $insertados = 0;
        $omitidos   = 0;

        foreach ($secciones as $sec) {
            $existe = DB::table('seccion')
                ->where('nombre', $sec['nombre'])
                ->exists();

            if (!$existe) {
                DB::table('seccion')->insert([
                    'nombre'     => $sec['nombre'],
                    'capacidad'  => $sec['capacidad'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
                $insertados++;
            } else {
                $omitidos++;
            }
        }

        echo "✔ {$insertados} secciones insertadas correctamente.\n";
        if ($omitidos > 0) {
            echo "⚠  {$omitidos} secciones omitidas (ya existían).\n";
        }
    }
}
