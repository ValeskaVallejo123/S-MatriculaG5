<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class H20CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cursos = [
            ['nombre' => 'Séptimo', 'cupo_maximo' => 35, 'seccion' => 'A', 'nivel' => 'Secundaria', 'anio_lectivo' => 2025, 'activo' => true],
            ['nombre' => 'Octavo', 'cupo_maximo' => 35, 'seccion' => 'A', 'nivel' => 'Secundaria', 'anio_lectivo' => 2025, 'activo' => true],
            ['nombre' => 'Noveno', 'cupo_maximo' => 35, 'seccion' => 'A', 'nivel' => 'Secundaria', 'anio_lectivo' => 2025, 'activo' => true],
        ];

        foreach ($cursos as $curso) {
            H20Curso::updateOrCreate(['nombre' => $curso['nombre']], $curso);
        }

    }
}
