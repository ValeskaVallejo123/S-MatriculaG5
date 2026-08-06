<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grado;

class GradosSeeder extends Seeder
{
    /**
     * Grados y secciones según distribución docente
     * CEB Gabriela Mistral — Año 2026
     *
     * Matutina:  1°(A,B), 2°(A,B), 3°(A,B), 4°(A,B), 5°(A,B), 6°(A,B,C)
     * Vespertina: 1°(C), 2°(C), 3°(C,D), 4°(C,D), 5°(C,D), 6°(D)
     * III Ciclo:  7°(A), 8°(A), 9°(A)
     */
    public function run(): void
    {
        $anio = 2026;

        $grados = [
            // ── Primaria Matutina ──────────────────────
            ['primaria',   1, 'A'],
            ['primaria',   1, 'B'],
            ['primaria',   2, 'A'],
            ['primaria',   2, 'B'],
            ['primaria',   3, 'A'],
            ['primaria',   3, 'B'],
            ['primaria',   4, 'A'],
            ['primaria',   4, 'B'],
            ['primaria',   5, 'A'],
            ['primaria',   5, 'B'],
            ['primaria',   6, 'A'],
            ['primaria',   6, 'B'],
            ['primaria',   6, 'C'],

            // ── Primaria Vespertina ────────────────────
            ['primaria',   1, 'C'],
            ['primaria',   2, 'C'],
            ['primaria',   3, 'C'],
            ['primaria',   3, 'D'],
            ['primaria',   4, 'C'],
            ['primaria',   4, 'D'],
            ['primaria',   5, 'C'],
            ['primaria',   5, 'D'],
            ['primaria',   6, 'D'],

            // ── Secundaria III Ciclo ───────────────────
            ['secundaria', 7, 'A'],
            ['secundaria', 8, 'A'],
            ['secundaria', 9, 'A'],
        ];

        foreach ($grados as [$nivel, $numero, $seccion]) {
            Grado::firstOrCreate(
                [
                    'nivel'        => $nivel,
                    'numero'       => $numero,
                    'seccion'      => $seccion,
                    'anio_lectivo' => $anio,
                ],
                [
                    'activo' => true,
                ]
            );
        }

        echo "✔ " . count($grados) . " grados creados correctamente.\n";
    }
}
