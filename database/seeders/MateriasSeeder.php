<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MateriasSeeder extends Seeder
{
    
    public function run(): void
    {
        $now = Carbon::now();

        $materias = [

            // ══════════════════════════════════════════════════════════
            // PRIMARIA (1° a 6° Grado)
            // ══════════════════════════════════════════════════════════

            [
                'nombre'      => 'Español',
                'codigo'      => 'ESP-PRI',
                'descripcion' => 'Desarrollo de habilidades de lectura, escritura y comunicación oral en idioma español.',
                'nivel'       => 'primaria',
                'area'        => 'Español',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Matemáticas',
                'codigo'      => 'MAT-PRI',
                'descripcion' => 'Fundamentos de aritmética, geometría y resolución de problemas matemáticos.',
                'nivel'       => 'primaria',
                'area'        => 'Matemáticas',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Ciencias Naturales',
                'codigo'      => 'CN-PRI',
                'descripcion' => 'Estudio del entorno natural, seres vivos, ecosistemas y fenómenos naturales.',
                'nivel'       => 'primaria',
                'area'        => 'Ciencias Naturales',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Estudios Sociales',
                'codigo'      => 'SS-PRI',
                'descripcion' => 'Historia, geografía y formación social de Honduras y el mundo.',
                'nivel'       => 'primaria',
                'area'        => 'Ciencias Sociales',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Educación Cívica',
                'codigo'      => 'CIV-PRI',
                'descripcion' => 'Formación en valores, ciudadanía, derechos y deberes civiles.',
                'nivel'       => 'primaria',
                'area'        => 'Formación Cívica y Ética',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Inglés',
                'codigo'      => 'ING-PRI',
                'descripcion' => 'Introducción al idioma inglés: vocabulario, gramática básica y conversación.',
                'nivel'       => 'primaria',
                'area'        => 'Inglés',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Educación Artística',
                'codigo'      => 'ART-PRI',
                'descripcion' => 'Expresión artística a través de dibujo, pintura, música y manualidades.',
                'nivel'       => 'primaria',
                'area'        => 'Educación Artística',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Educación Física',
                'codigo'      => 'EF-PRI',
                'descripcion' => 'Actividades físicas, deportes y hábitos de vida saludable.',
                'nivel'       => 'primaria',
                'area'        => 'Educación Física',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Informática',
                'codigo'      => 'INFO-PRI',
                'descripcion' => 'Uso básico de computadoras, manejo de herramientas digitales y tecnología educativa.',
                'nivel'       => 'primaria',
                'area'        => 'Tecnología',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Biblioteca',
                'codigo'      => 'BIB-PRI',
                'descripcion' => 'Fomento a la lectura, uso de recursos bibliográficos y hábitos de estudio.',
                'nivel'       => 'primaria',
                'area'        => 'Español',
                'activo'      => true,
            ],

            // ══════════════════════════════════════════════════════════
            // SECUNDARIA (7°, 8°, 9° — III Ciclo)
            // ══════════════════════════════════════════════════════════

            [
                'nombre'      => 'Español',
                'codigo'      => 'ESP-SEC',
                'descripcion' => 'Literatura, gramática avanzada, redacción y análisis de textos.',
                'nivel'       => 'secundaria',
                'area'        => 'Español',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Matemáticas',
                'codigo'      => 'MAT-SEC',
                'descripcion' => 'Álgebra, geometría analítica, estadística y cálculo introductorio.',
                'nivel'       => 'secundaria',
                'area'        => 'Matemáticas',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Ciencias Naturales',
                'codigo'      => 'CN-SEC',
                'descripcion' => 'Biología, química y física básica aplicada al entorno.',
                'nivel'       => 'secundaria',
                'area'        => 'Ciencias Naturales',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Estudios Sociales',
                'codigo'      => 'SS-SEC',
                'descripcion' => 'Historia universal, geografía mundial y relaciones internacionales.',
                'nivel'       => 'secundaria',
                'area'        => 'Ciencias Sociales',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Inglés',
                'codigo'      => 'ING-SEC',
                'descripcion' => 'Inglés intermedio: comprensión lectora, escritura y conversación.',
                'nivel'       => 'secundaria',
                'area'        => 'Inglés',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Educación Artística',
                'codigo'      => 'ART-SEC',
                'descripcion' => 'Expresión artística avanzada: artes visuales, música y cultura.',
                'nivel'       => 'secundaria',
                'area'        => 'Educación Artística',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Educación Física',
                'codigo'      => 'EF-SEC',
                'descripcion' => 'Deporte, salud física y desarrollo de habilidades motrices.',
                'nivel'       => 'secundaria',
                'area'        => 'Educación Física',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Tecnología',
                'codigo'      => 'TEC-SEC',
                'descripcion' => 'Tecnología aplicada, programación básica y herramientas digitales.',
                'nivel'       => 'secundaria',
                'area'        => 'Tecnología',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Formación Cívica y Ética',
                'codigo'      => 'FCE-SEC',
                'descripcion' => 'Ciudadanía, ética, derechos humanos y participación democrática.',
                'nivel'       => 'secundaria',
                'area'        => 'Formación Cívica y Ética',
                'activo'      => true,
            ],
        ];

        $insertados = 0;
        $omitidos   = 0;

        foreach ($materias as $materia) {
            $existe = DB::table('materias')
                ->where('codigo', $materia['codigo'])
                ->exists();

            if (!$existe) {
                DB::table('materias')->insert([
                    ...$materia,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
                $insertados++;
            } else {
                $omitidos++;
            }
        }

        $this->command->info("✅ {$insertados} materias insertadas correctamente.");
        if ($omitidos > 0) {
            $this->command->warn("  {$omitidos} materias omitidas (ya existían).");
        }
    }
}
