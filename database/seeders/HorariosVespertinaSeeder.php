<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grado;
use App\Models\HorarioGrado;

class HorariosVespertinaSeeder extends Seeder
{
    // ── Profesores vespertina ──
    const JUSTINA = 192; // Informática vespertina
    const GLADYS  = 193; // Biblioteca vespertina

    // ── Materia IDs (igual que matutina) ──
    const ESP = 14;
    const MAT = 15;
    const CNT = 16;
    const SOC = 17;
    const CIV = 18;
    const ING = 19;
    const ART = 20;
    const EFI = 21;
    const INF = 22;
    const BIB = 23;

    private function c($mat, $prof, $salon)
    {
        return [
            'materia_id'  => $mat,
            'profesor_id' => $prof,
            'salon'       => (string) $salon,
        ];
    }

    /**
     * Plantilla vespertina (6 períodos × 5 días = 30 períodos/semana).
     * Franja: 13:00-13:40 / 13:40-14:20 / 14:20-15:00 / RECREO / 15:20-16:00 / 16:00-16:40 / 16:40-17:20
     *
     * Distribución:
     *   Español 7 · Matemáticas 7 · C.Naturales 4 · Est.Sociales 4
     *   Ed.Cívica 2 · Inglés 2 · Ed.Física 2 · Artística 2
     *   Informática 1 · Biblioteca 1 = 32 → al aplicar Info y Bib desplazan 2 materias
     */
    private function buildSchedule($guia, $salon, $iDay, $iSlot, $bDay, $bSlot): array
    {
        $g = $guia;
        $a = $salon;

        $s = [
            'Lunes' => [
                '13:00-13:40'        => $this->c(self::MAT, $g, $a),
                '13:40-14:20'        => $this->c(self::MAT, $g, $a),
                '14:20-15:00'        => $this->c(self::ESP, $g, $a),
                'RECREO 15:00-15:20' => null,
                '15:20-16:00'        => $this->c(self::CNT, $g, $a),
                '16:00-16:40'        => $this->c(self::SOC, $g, $a),
                '16:40-17:20'        => $this->c(self::EFI, null, $a),
            ],
            'Martes' => [
                '13:00-13:40'        => $this->c(self::ESP, $g, $a),
                '13:40-14:20'        => $this->c(self::ESP, $g, $a),
                '14:20-15:00'        => $this->c(self::MAT, $g, $a),
                'RECREO 15:00-15:20' => null,
                '15:20-16:00'        => $this->c(self::SOC, $g, $a),
                '16:00-16:40'        => $this->c(self::SOC, $g, $a),
                '16:40-17:20'        => $this->c(self::CNT, $g, $a),
            ],
            'Miércoles' => [
                '13:00-13:40'        => $this->c(self::MAT, $g, $a),
                '13:40-14:20'        => $this->c(self::ING, null, $a),
                '14:20-15:00'        => $this->c(self::ESP, $g, $a),
                'RECREO 15:00-15:20' => null,
                '15:20-16:00'        => $this->c(self::SOC, $g, $a),
                '16:00-16:40'        => $this->c(self::CNT, $g, $a),
                '16:40-17:20'        => $this->c(self::MAT, $g, $a),
            ],
            'Jueves' => [
                '13:00-13:40'        => $this->c(self::ESP, $g, $a),
                '13:40-14:20'        => $this->c(self::ESP, $g, $a),
                '14:20-15:00'        => $this->c(self::MAT, $g, $a),
                'RECREO 15:00-15:20' => null,
                '15:20-16:00'        => $this->c(self::CIV, $g, $a),
                '16:00-16:40'        => $this->c(self::CNT, $g, $a),
                '16:40-17:20'        => $this->c(self::ART, null, $a),
            ],
            'Viernes' => [
                '13:00-13:40'        => $this->c(self::MAT, $g, $a),
                '13:40-14:20'        => $this->c(self::ESP, $g, $a),
                '14:20-15:00'        => $this->c(self::ING, null, $a),
                'RECREO 15:00-15:20' => null,
                '15:20-16:00'        => $this->c(self::CIV, $g, $a),
                '16:00-16:40'        => $this->c(self::EFI, null, $a),
                '16:40-17:20'        => $this->c(self::ART, null, $a),
            ],
        ];

        // ── Override Informática (Justina) ──
        $s[$iDay][$iSlot] = $this->c(self::INF, self::JUSTINA, 'Sala Informática');

        // ── Override Biblioteca (Gladys) ──
        $s[$bDay][$bSlot] = $this->c(self::BIB, self::GLADYS, 'Biblioteca');

        return $s;
    }

    public function run(): void
    {
        // ── Crear 6°E 2026 si no existe ──
        $grado6E = Grado::firstOrCreate(
            ['numero' => 6, 'seccion' => 'E', 'anio_lectivo' => 2026],
            ['nivel' => 'primaria', 'activo' => 1]
        );
        $this->command->line("  6°E grado_id={$grado6E->id} (" . ($grado6E->wasRecentlyCreated ? 'creado' : 'existente') . ')');

        /*
         * Distribución sin conflictos de Justina (Informática) y Gladys (Biblioteca).
         *
         * Sección | grado_id   | guía | aula | Info (día, slot)          | Bib (día, slot)
         * --------|------------|------|------|---------------------------|---------------------------
         * 1°C     |   32       | 182  |  2   | Lunes      15:20-16:00   | Martes     13:00-13:40
         * 2°C     |   33       | 183  |  1   | Martes     15:20-16:00   | Miércoles  13:00-13:40
         * 3°C     |   34       | 184  |  7   | Miércoles  15:20-16:00   | Jueves     13:00-13:40
         * 3°D     |   35       | 185  |  8   | Jueves     15:20-16:00   | Viernes    13:00-13:40
         * 4°C     |   36       | 186  | 13   | Viernes    15:20-16:00   | Lunes      13:00-13:40
         * 4°D     |   37       | 187  | 10   | Lunes      16:00-16:40   | Lunes      13:40-14:20
         * 5°C     |   38       | 188  | 11   | Martes     16:00-16:40   | Martes     13:40-14:20
         * 5°D     |   39       | 189  |  9   | Miércoles  16:00-16:40   | Miércoles  13:40-14:20
         * 6°D     |   40       | 190  | 14   | Jueves     16:00-16:40   | Jueves     13:40-14:20
         * 6°E     | (dinámico) | 191  | 12   | Viernes    16:00-16:40   | Viernes    13:40-14:20
         */
        $sections = [
            // [grado_id,       guia_id, salon, iDay,       iSlot,         bDay,        bSlot]
            [32,                182, '2',  'Lunes',      '15:20-16:00', 'Martes',    '13:00-13:40'],
            [33,                183, '1',  'Martes',     '15:20-16:00', 'Miércoles', '13:00-13:40'],
            [34,                184, '7',  'Miércoles',  '15:20-16:00', 'Jueves',    '13:00-13:40'],
            [35,                185, '8',  'Jueves',     '15:20-16:00', 'Viernes',   '13:00-13:40'],
            [36,                186, '13', 'Viernes',    '15:20-16:00', 'Lunes',     '13:00-13:40'],
            [37,                187, '10', 'Lunes',      '16:00-16:40', 'Lunes',     '13:40-14:20'],
            [38,                188, '11', 'Martes',     '16:00-16:40', 'Martes',    '13:40-14:20'],
            [39,                189, '9',  'Miércoles',  '16:00-16:40', 'Miércoles', '13:40-14:20'],
            [40,                190, '14', 'Jueves',     '16:00-16:40', 'Jueves',    '13:40-14:20'],
            [$grado6E->id,      191, '12', 'Viernes',    '16:00-16:40', 'Viernes',   '13:40-14:20'],
        ];

        foreach ($sections as [$gradoId, $guiaId, $salon, $iDay, $iSlot, $bDay, $bSlot]) {
            $horario = $this->buildSchedule($guiaId, $salon, $iDay, $iSlot, $bDay, $bSlot);

            HorarioGrado::updateOrCreate(
                ['grado_id' => $gradoId, 'jornada' => 'vespertina'],
                ['horario'  => $horario]
            );

            $this->command->line("  ✓ grado_id={$gradoId} vespertina actualizado.");
        }

        $this->command->info('Horarios vespertina (primaria 1°-6°) creados/actualizados correctamente.');
    }
}
