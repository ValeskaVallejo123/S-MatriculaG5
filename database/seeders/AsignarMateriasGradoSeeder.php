<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AsignarMateriasGradoSeeder extends Seeder
{
    /**
     * Asigna todas las materias de cada grado al docente guía correspondiente.
     *
     * Cada docente enseña TODAS las materias de su sección.
     * profesor_id se resuelve por email desde la tabla profesores.
     *
     * Primaria  (1°–6°): 10 materias (ESP-PRI … BIB-PRI)
     * Secundaria (7°–9°):  9 materias (ESP-SEC … FCE-SEC)
     */
    public function run(): void
    {
        $now = Carbon::now();

        // ── Mapa: [nivel, numero_grado, seccion] => email del profesor ──
        $asignaciones = [
            // ── 1° Grado ──────────────────────────────────────────────
            ['primaria',   1, 'A', 'jennifer.mascareno@egm.edu.hn'],
            ['primaria',   1, 'B', 'concepcion.sierra@egm.edu.hn'],
            ['primaria',   1, 'C', 'lourdes.maradiaga@egm.edu.hn'],

            // ── 2° Grado ──────────────────────────────────────────────
            ['primaria',   2, 'A', 'juana.leon@egm.edu.hn'],
            ['primaria',   2, 'B', 'liz.veliz@egm.edu.hn'],
            ['primaria',   2, 'C', 'sayda.garcia@egm.edu.hn'],

            // ── 3° Grado ──────────────────────────────────────────────
            ['primaria',   3, 'A', 'paula.sauceda@egm.edu.hn'],
            ['primaria',   3, 'B', 'elia.sosa@egm.edu.hn'],
            ['primaria',   3, 'C', 'aminta.rojas@egm.edu.hn'],
            ['primaria',   3, 'D', 'claudia.artica@egm.edu.hn'],

            // ── 4° Grado ──────────────────────────────────────────────
            ['primaria',   4, 'A', 'mirian.carias@egm.edu.hn'],
            ['primaria',   4, 'B', 'rolan.espinal@egm.edu.hn'],
            ['primaria',   4, 'C', 'sofia.briseno@egm.edu.hn'],
            ['primaria',   4, 'D', 'aida.lewis@egm.edu.hn'],

            // ── 5° Grado ──────────────────────────────────────────────
            ['primaria',   5, 'A', 'angel.sanchez@egm.edu.hn'],
            ['primaria',   5, 'B', 'pedro.nufio@egm.edu.hn'],
            ['primaria',   5, 'C', 'francis.valladares@egm.edu.hn'],
            ['primaria',   5, 'D', 'xiomara.gomez@egm.edu.hn'],

            // ── 6° Grado ──────────────────────────────────────────────
            ['primaria',   6, 'A', 'bivilia.salgado@egm.edu.hn'],
            ['primaria',   6, 'B', 'bernarda.turcios@egm.edu.hn'],
            ['primaria',   6, 'C', 'nancy.avila@egm.edu.hn'],
            ['primaria',   6, 'D', 'nancy.ramirez@egm.edu.hn'],

            // ── 7° Grado ──────────────────────────────────────────────
            ['secundaria', 7, 'A', 'carlos.oyuela@egm.edu.hn'],
            ['secundaria', 7, 'B', 'ruth.salinas@egm.edu.hn'],   // Si la sección no existe, se omite

            // ── 8° Grado ──────────────────────────────────────────────
            ['secundaria', 8, 'A', 'angela.salinas@egm.edu.hn'],

            // ── 9° Grado ──────────────────────────────────────────────
            ['secundaria', 9, 'A', 'karla.sauceda@egm.edu.hn'],
        ];

        // ── Materias por nivel ─────────────────────────────────────────
        $codigosPrimaria = [
            'ESP-PRI', 'MAT-PRI', 'CN-PRI',   'SS-PRI',   'CIV-PRI',
            'ING-PRI', 'ART-PRI', 'EF-PRI',   'INFO-PRI', 'BIB-PRI',
        ];

        $codigosSecundaria = [
            'ESP-SEC', 'MAT-SEC', 'CN-SEC', 'SS-SEC', 'ING-SEC',
            'ART-SEC', 'EF-SEC',  'TEC-SEC', 'FCE-SEC',
        ];

        $idsPrimaria    = DB::table('materias')->whereIn('codigo', $codigosPrimaria)->pluck('id', 'codigo');
        $idsSecundaria  = DB::table('materias')->whereIn('codigo', $codigosSecundaria)->pluck('id', 'codigo');

        $insertados  = 0;
        $actualizados = 0;
        $omitidos    = 0;

        foreach ($asignaciones as [$nivel, $numero, $seccion, $email]) {

            // 1) Resolver profesor por email
            $profesorId = DB::table('profesores')->where('email', $email)->value('id');
            if (! $profesorId) {
                $this->command->warn("  ⚠  Profesor no encontrado: {$email} — omitido");
                $omitidos++;
                continue;
            }

            // 2) Resolver grado
            $gradoId = DB::table('grados')
                ->where('nivel',   $nivel)
                ->where('numero',  $numero)
                ->where('seccion', $seccion)
                ->value('id');

            if (! $gradoId) {
                $this->command->warn("  ⚠  Grado {$numero}° {$nivel} Sección {$seccion} no existe — omitido");
                $omitidos++;
                continue;
            }

            // 3) Seleccionar materias según nivel
            $materiaIds = $nivel === 'primaria' ? $idsPrimaria : $idsSecundaria;

            // 4) Eliminar asignaciones anteriores de este grado-sección
            //    para reemplazarlas con el profesor correcto
            DB::table('profesor_materia_grados')
                ->where('grado_id', $gradoId)
                ->where('seccion',  $seccion)
                ->delete();

            // 5) Insertar una fila por cada materia
            foreach ($materiaIds as $codigo => $materiaId) {
                DB::table('profesor_materia_grados')->insert([
                    'profesor_id' => $profesorId,
                    'materia_id'  => $materiaId,
                    'grado_id'    => $gradoId,
                    'seccion'     => $seccion,
                    'created_at'  => $now,
                    'updated_at'  => $now,
                ]);
                $insertados++;
            }

            $this->command->line("  ✔ {$numero}° " . ucfirst($nivel) . " — Sección {$seccion} → {$email} (" . $materiaIds->count() . " materias)");
        }

        $this->command->line('');
        $this->command->info("✅ {$insertados} asignaciones insertadas.");
        if ($omitidos > 0) {
            $this->command->warn("⚠️  {$omitidos} entradas omitidas (profesor o grado no encontrado).");
        }
        $this->command->line('');
        $this->command->warn('💡 Informática y Biblioteca: asígnalos manualmente desde el panel en cada grado.');
    }
}
