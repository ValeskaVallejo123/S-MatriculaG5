<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grado;

class GradosSeeder extends Seeder
{
    public function run(): void
    {
        $anio = 2025;

        $niveles = [
            'primaria' => [1, 2, 3, 4, 5, 6],
            'secundaria' => [7, 8, 9],
        ];

        $secciones = ['A', 'B'];

        foreach ($niveles as $nivel => $numeros) {
            foreach ($numeros as $numero) {
                foreach ($secciones as $seccion) {

                    // Evitar duplicados (gracias al índice único)
                    Grado::firstOrCreate(
                        [
                            'nivel' => $nivel,
                            'numero' => $numero,
                            'seccion' => $seccion,
                            'anio_lectivo' => $anio,
                        ],
                        [
                            'activo' => true,
                        ]
                    );
                }
            }
        }

        echo "✔ Grados creados correctamente.\n";
    }
}
