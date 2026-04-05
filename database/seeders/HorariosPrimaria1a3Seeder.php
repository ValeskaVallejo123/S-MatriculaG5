<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HorarioGrado;

class HorariosPrimaria1a3Seeder extends Seeder
{
    // ── Profesor IDs ──
    const LEDA    = 20; // Informática
    const FRANCIS = 21; // Biblioteca

    // ── Materia IDs ──
    const ESP = 14; // Español
    const MAT = 15; // Matemáticas
    const CNT = 16; // C. Naturales
    const SOC = 17; // Est. Sociales
    const CIV = 18; // Ed. Cívica
    const ING = 19; // Inglés
    const ART = 20; // Ed. Artística
    const EFI = 21; // Ed. Física
    const INF = 22; // Informática
    const BIB = 23; // Biblioteca

    private function c($mat, $prof, $salon)
    {
        return [
            'materia_id'  => $mat,
            'profesor_id' => $prof,
            'salon'       => (string) $salon,
        ];
    }

    /**
     * Construye el horario de una sección a partir de la plantilla base.
     * $iDay/$iSlot: día y franja donde va Informática (Leda)
     * $bDay/$bSlot: día y franja donde va Biblioteca (Francis)
     */
    private function buildSchedule($guia, $salon, $iDay, $iSlot, $bDay, $bSlot): array
    {
        $g = $guia;   // alias corto
        $a = $salon;

        $s = [
            'Lunes' => [
                '07:00-07:40'        => $this->c(self::CIV, $g, $a),
                '07:40-08:20'        => $this->c(self::ESP, $g, $a),
                '08:20-09:00'        => $this->c(self::ESP, $g, $a),
                'RECREO 09:00-09:20' => null,
                '09:20-10:00'        => $this->c(self::MAT, $g, $a),
                '10:00-10:40'        => $this->c(self::MAT, $g, $a),
                '10:40-11:20'        => $this->c(self::CNT, $g, $a),
                '11:20-12:00'        => $this->c(self::SOC, $g, $a),
                '12:00-12:40'        => null,
            ],
            'Martes' => [
                '07:00-07:40'        => $this->c(self::ESP, $g, $a),
                '07:40-08:20'        => $this->c(self::ESP, $g, $a),
                '08:20-09:00'        => $this->c(self::ESP, $g, $a),
                'RECREO 09:00-09:20' => null,
                '09:20-10:00'        => $this->c(self::MAT, $g, $a),
                '10:00-10:40'        => $this->c(self::CNT, $g, $a),
                '10:40-11:20'        => $this->c(self::SOC, $g, $a),
                '11:20-12:00'        => $this->c(self::ING, null, $a),
                '12:00-12:40'        => null,
            ],
            'Miércoles' => [
                '07:00-07:40'        => $this->c(self::EFI, null, $a),
                '07:40-08:20'        => $this->c(self::EFI, null, $a),
                '08:20-09:00'        => $this->c(self::ESP, $g, $a),
                'RECREO 09:00-09:20' => null,
                '09:20-10:00'        => $this->c(self::MAT, $g, $a),
                '10:00-10:40'        => $this->c(self::SOC, $g, $a),
                '10:40-11:20'        => $this->c(self::SOC, $g, $a),
                '11:20-12:00'        => $this->c(self::CNT, $g, $a),
                '12:00-12:40'        => $this->c(self::CNT, $g, $a),
            ],
            'Jueves' => [
                '07:00-07:40'        => $this->c(self::ESP, $g, $a),
                '07:40-08:20'        => $this->c(self::ESP, $g, $a),
                '08:20-09:00'        => $this->c(self::MAT, $g, $a),
                'RECREO 09:00-09:20' => null,
                '09:20-10:00'        => $this->c(self::MAT, $g, $a),
                '10:00-10:40'        => $this->c(self::CNT, $g, $a),
                '10:40-11:20'        => $this->c(self::ING, null, $a),
                '11:20-12:00'        => $this->c(self::CIV, $g, $a),
                '12:00-12:40'        => null,
            ],
            'Viernes' => [
                '07:00-07:40'        => $this->c(self::ESP, $g, $a),
                '07:40-08:20'        => $this->c(self::ESP, $g, $a),
                '08:20-09:00'        => $this->c(self::MAT, $g, $a),
                'RECREO 09:00-09:20' => null,
                '09:20-10:00'        => $this->c(self::MAT, $g, $a),
                '10:00-10:40'        => $this->c(self::CNT, $g, $a),
                '10:40-11:20'        => $this->c(self::ART, null, $a),
                '11:20-12:00'        => $this->c(self::ART, null, $a),
                '12:00-12:40'        => null,
            ],
        ];

        // ── Aplicar Informática (Leda) ──
        $s[$iDay][$iSlot] = $this->c(self::INF, self::LEDA, 'Sala Informática');

        // ── Aplicar Biblioteca (Francis) ──
        $s[$bDay][$bSlot] = $this->c(self::BIB, self::FRANCIS, 'Biblioteca');

        return $s;
    }

    public function run(): void
    {
        /*
         * Distribución sin conflictos de Leda (Informática) y Francis (Biblioteca):
         *
         * Sección  | grado_id | guía | aula | Info (día, slot)         | Bib (día, slot)
         * ---------|----------|------|------|--------------------------|-------------------------
         * 1°A      |   19     |   7  |  9   | Lunes     08:20-09:00   | Martes    07:40-08:20
         * 1°B      |   20     |   8  |  2   | Martes    08:20-09:00   | Lunes     07:40-08:20
         * 1°C      |   32     | null |  -   | Miércoles 08:20-09:00   | Jueves    07:40-08:20
         * 2°A      |   21     |   9  |  1   | Jueves    08:20-09:00   | Viernes   07:40-08:20
         * 2°B      |   22     |  10  |  4   | Viernes   08:20-09:00   | Lunes     10:00-10:40
         * 2°C      |   33     | null |  -   | Lunes     09:20-10:00   | Martes    10:00-10:40
         * 3°A      |   23     |  11  |  7   | Martes    09:20-10:00   | Miércoles 10:00-10:40
         * 3°B      |   24     |  12  |  6   | Miércoles 09:20-10:00   | Jueves    10:00-10:40
         * 3°C      |   34     | null |  -   | Jueves    09:20-10:00   | Viernes   10:00-10:40
         * 3°D      |   35     | null |  -   | Viernes   09:20-10:00   | Lunes     10:40-11:20
         */
        $sections = [
            // [grado_id, guia_id, salon, iDay,        iSlot,         bDay,        bSlot]
            [19, 7,    '9', 'Lunes',      '08:20-09:00', 'Martes',    '07:40-08:20'],
            [20, 8,    '2', 'Martes',     '08:20-09:00', 'Lunes',     '07:40-08:20'],
            [32, null, '-', 'Miércoles',  '08:20-09:00', 'Jueves',    '07:40-08:20'],
            [21, 9,    '1', 'Jueves',     '08:20-09:00', 'Viernes',   '07:40-08:20'],
            [22, 10,   '4', 'Viernes',    '08:20-09:00', 'Lunes',     '10:00-10:40'],
            [33, null, '-', 'Lunes',      '09:20-10:00', 'Martes',    '10:00-10:40'],
            [23, 11,   '7', 'Martes',     '09:20-10:00', 'Miércoles', '10:00-10:40'],
            [24, 12,   '6', 'Miércoles',  '09:20-10:00', 'Jueves',    '10:00-10:40'],
            [34, null, '-', 'Jueves',     '09:20-10:00', 'Viernes',   '10:00-10:40'],
            [35, null, '-', 'Viernes',    '09:20-10:00', 'Lunes',     '10:40-11:20'],
        ];

        foreach ($sections as [$gradoId, $guiaId, $salon, $iDay, $iSlot, $bDay, $bSlot]) {
            $horario = $this->buildSchedule($guiaId, $salon, $iDay, $iSlot, $bDay, $bSlot);

            HorarioGrado::updateOrCreate(
                ['grado_id' => $gradoId, 'jornada' => 'matutina'],
                ['horario'  => $horario]
            );

            $this->command->line("  ✓ grado_id={$gradoId} actualizado.");
        }

        $this->command->info('Horarios 1°–3° matutina creados/actualizados correctamente.');
    }
}
