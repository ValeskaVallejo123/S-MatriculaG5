<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grado;
use App\Models\Materia;

class GradoMateriaSeeder extends Seeder
{
    public function run(): void
    {
        // Crear grados de primaria
        for ($i = 1; $i <= 6; $i++) {
            Grado::create([
                'nivel' => 'primaria',
                'numero' => $i,
                'seccion' => 'A',
                'anio_lectivo' => 2025,
                'activo' => true,
            ]);
        }

        // Crear grados de secundaria
        for ($i = 7; $i <= 9; $i++) {
            Grado::create([
                'nivel' => 'secundaria',
                'numero' => $i,
                'seccion' => 'A',
                'anio_lectivo' => 2025,
                'activo' => true,
            ]);
        }

        // Crear materias de primaria
        $materiasPrimaria = [
            ['nombre' => 'Matemáticas', 'codigo' => 'MAT-P', 'area' => 'Matemáticas'],
            ['nombre' => 'Español', 'codigo' => 'ESP-P', 'area' => 'Español'],
            ['nombre' => 'Ciencias Naturales', 'codigo' => 'CN-P', 'area' => 'Ciencias Naturales'],
            ['nombre' => 'Ciencias Sociales', 'codigo' => 'CS-P', 'area' => 'Ciencias Sociales'],
            ['nombre' => 'Educación Física', 'codigo' => 'EF-P', 'area' => 'Educación Física'],
        ];

        foreach ($materiasPrimaria as $materia) {
            Materia::create([
                'nombre' => $materia['nombre'],
                'codigo' => $materia['codigo'],
                'area' => $materia['area'],
                'nivel' => 'primaria',
                'activo' => true,
            ]);
        }

        // Crear materias de secundaria
        $materiasSecundaria = [
            ['nombre' => 'Matemáticas', 'codigo' => 'MAT-S', 'area' => 'Matemáticas'],
            ['nombre' => 'Español', 'codigo' => 'ESP-S', 'area' => 'Español'],
            ['nombre' => 'Ciencias Naturales', 'codigo' => 'CN-S', 'area' => 'Ciencias Naturales'],
            ['nombre' => 'Ciencias Sociales', 'codigo' => 'CS-S', 'area' => 'Ciencias Sociales'],
            ['nombre' => 'Inglés', 'codigo' => 'ING-S', 'area' => 'Inglés'],
            ['nombre' => 'Informática', 'codigo' => 'INF-S', 'area' => 'Informática'],
        ];

        foreach ($materiasSecundaria as $materia) {
            Materia::create([
                'nombre' => $materia['nombre'],
                'codigo' => $materia['codigo'],
                'area' => $materia['area'],
                'nivel' => 'secundaria',
                'activo' => true,
            ]);
        }
    }
}