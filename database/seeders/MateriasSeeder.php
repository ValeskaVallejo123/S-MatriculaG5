<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Materia;

class MateriasSeeder extends Seeder
{
    public function run(): void
    {
        $materias = [
            // PRIMARIA
            ['nombre' => 'Español',              'codigo' => 'ESP', 'nivel' => 'primaria', 'area' => 'Español'],
            ['nombre' => 'Matemáticas',          'codigo' => 'MAT', 'nivel' => 'primaria', 'area' => 'Matemáticas'],
            ['nombre' => 'Ciencias Naturales',   'codigo' => 'CN',  'nivel' => 'primaria', 'area' => 'Ciencias Naturales'],
            ['nombre' => 'Ciencias Sociales',    'codigo' => 'CS',  'nivel' => 'primaria', 'area' => 'Ciencias Sociales'],
            ['nombre' => 'Inglés',               'codigo' => 'ING', 'nivel' => 'primaria', 'area' => 'Inglés'],
            ['nombre' => 'Educación Artística',  'codigo' => 'ART', 'nivel' => 'primaria', 'area' => 'Educación Artística'],
            ['nombre' => 'Educación Física',     'codigo' => 'EDF', 'nivel' => 'primaria', 'area' => 'Educación Física'],
            ['nombre' => 'Tecnología',           'codigo' => 'TEC', 'nivel' => 'primaria', 'area' => 'Tecnología'],
            ['nombre' => 'Formación Cívica y Ética', 'codigo' => 'FCE', 'nivel' => 'primaria', 'area' => 'Formación Cívica y Ética'],

            // SECUNDARIA (puedes repetirlas o modificarlas)
            ['nombre' => 'Español',              'codigo' => 'ESP2', 'nivel' => 'secundaria', 'area' => 'Español'],
            ['nombre' => 'Matemáticas',          'codigo' => 'MAT2', 'nivel' => 'secundaria', 'area' => 'Matemáticas'],
            ['nombre' => 'Ciencias Naturales',   'codigo' => 'CN2',  'nivel' => 'secundaria', 'area' => 'Ciencias Naturales'],
            ['nombre' => 'Inglés',               'codigo' => 'ING2', 'nivel' => 'secundaria', 'area' => 'Inglés'],
        ];

        foreach ($materias as $m) {
            Materia::firstOrCreate(
                ['codigo' => $m['codigo']],
                $m
            );
        }
        echo "✔ Materias creadas correctamente.\n";
    }
}
