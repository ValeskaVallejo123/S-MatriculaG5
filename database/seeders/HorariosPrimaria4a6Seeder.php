<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HorarioGrado;

class HorariosPrimaria4a6Seeder extends Seeder
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
     * Plantilla base tomada del horario físico del 5to Grado (foto).
     * Info y Biblioteca se aplican como override sobre los slots regulares.
     *
     * Distribución garantiza CERO conflictos para Leda (Info) y Francis (Bib):
     *   • Leda  4°-6°: usa franjas 10:40-11:20 (Mon-Fri) y 11:20-12:00 (Mon-Fri)
     *                  y 12:00-12:40 (Lun/Mar)
     *   • Francis 4°-6°: usa franjas 08:20-09:00 y 09:20-10:00 en distintos días
     *
     * (Ninguna de estas franjas coincide con las ya asignadas en el seeder de 1°-3°.)
     */
    private function buildSchedule($guia, $salon, $iDay, $iSlot, $bDay, $bSlot): array
    {
        $g = $guia;
        $a = $salon;

        // Plantilla neutral (los slots donde va Info/Bib tienen materias regulares
        // que serán sobreescritas por los overrides de abajo).
        $s = [
            'Lunes' => [
                '07:00-07:40'        => $this->c(self::CIV, $g, $a),
                '07:40-08:20'        => $this->c(self::EFI, null, $a),
                '08:20-09:00'        => $this->c(self::EFI, null, $a),
                'RECREO 09:00-09:20' => null,
                '09:20-10:00'        => $this->c(self::MAT, $g, $a),
                '10:00-10:40'        => $this->c(self::MAT, $g, $a),
                '10:40-11:20'        => $this->c(self::ESP, $g, $a),
                '11:20-12:00'        => $this->c(self::CNT, $g, $a),
                '12:00-12:40'        => $this->c(self::CNT, $g, $a),
            ],
            'Martes' => [
                '07:00-07:40'        => $this->c(self::MAT, $g, $a),
                '07:40-08:20'        => $this->c(self::ESP, $g, $a),
                '08:20-09:00'        => $this->c(self::ESP, $g, $a),
                'RECREO 09:00-09:20' => null,
                '09:20-10:00'        => $this->c(self::SOC, $g, $a),
                '10:00-10:40'        => $this->c(self::SOC, $g, $a),
                '10:40-11:20'        => $this->c(self::SOC, $g, $a),
                '11:20-12:00'        => $this->c(self::CNT, $g, $a),
                '12:00-12:40'        => $this->c(self::CNT, $g, $a),
            ],
            'Miércoles' => [
                '07:00-07:40'        => $this->c(self::MAT, $g, $a),
                '07:40-08:20'        => $this->c(self::MAT, $g, $a),
                '08:20-09:00'        => $this->c(self::SOC, $g, $a),
                'RECREO 09:00-09:20' => null,
                '09:20-10:00'        => $this->c(self::SOC, $g, $a),
                '10:00-10:40'        => $this->c(self::ESP, $g, $a),
                '10:40-11:20'        => $this->c(self::CNT, $g, $a),
                '11:20-12:00'        => $this->c(self::CNT, $g, $a),
                '12:00-12:40'        => $this->c(self::ING, null, $a),
            ],
            'Jueves' => [
                '07:00-07:40'        => $this->c(self::ESP, $g, $a),
                '07:40-08:20'        => $this->c(self::ESP, $g, $a),
                '08:20-09:00'        => $this->c(self::ING, null, $a),
                'RECREO 09:00-09:20' => null,
                '09:20-10:00'        => $this->c(self::ING, null, $a),
                '10:00-10:40'        => $this->c(self::CIV, $g, $a),
                '10:40-11:20'        => $this->c(self::MAT, $g, $a),
                '11:20-12:00'        => $this->c(self::MAT, $g, $a),
                '12:00-12:40'        => null,
            ],
            'Viernes' => [
                '07:00-07:40'        => $this->c(self::MAT, $g, $a),
                '07:40-08:20'        => $this->c(self::ESP, $g, $a),
                '08:20-09:00'        => $this->c(self::ESP, $g, $a),
                'RECREO 09:00-09:20' => null,
                '09:20-10:00'        => $this->c(self::CNT, $g, $a),
                '10:00-10:40'        => $this->c(self::CNT, $g, $a),
                '10:40-11:20'        => $this->c(self::ART, null, $a),
                '11:20-12:00'        => $this->c(self::ART, null, $a),
                '12:00-12:40'        => null,
            ],
        ];

        // ── Override: Informática (Leda) ──
        $s[$iDay][$iSlot] = $this->c(self::INF, self::LEDA, 'Sala Informática');

        // ── Override: Biblioteca (Francis) ──
        $s[$bDay][$bSlot] = $this->c(self::BIB, self::FRANCIS, 'Biblioteca');

        return $s;
    }

    public function run(): void
    {
        /*
         * Distribución sin conflictos de Leda (Informática) y Francis (Biblioteca).
         * Ninguna franja se repite entre secciones (ni entre este seeder y el de 1°-3°).
         *
         * Sección | grado_id | guía | Info (día, slot)          | Bib (día, slot)
         * --------|----------|------|---------------------------|---------------------------
         * 4°A     |   25     |  13  | Lunes      10:40-11:20   | Lunes      08:20-09:00
         * 4°B     |   26     |  14  | Miércoles  10:40-11:20   | Martes     08:20-09:00
         * 4°C     |   36     | null | Jueves     10:40-11:20   | Miércoles  07:40-08:20
         * 4°D     |   37     | null | Viernes    10:40-11:20   | Miércoles  08:20-09:00
         * 5°A     |   27     |  15  | Martes     10:40-11:20   | Viernes    08:20-09:00
         * 5°B     |   28     |  16  | Lunes      11:20-12:00   | Jueves     08:20-09:00
         * 5°C     |   38     | null | Martes     11:20-12:00   | Lunes      09:20-10:00
         * 5°D     |   39     | null | Miércoles  11:20-12:00   | Martes     09:20-10:00
         * 6°A     |   29     |  17  | Jueves     11:20-12:00   | Miércoles  09:20-10:00
         * 6°B     |   30     |  18  | Viernes    11:20-12:00   | Jueves     09:20-10:00
         * 6°C     |   31     |  19  | Lunes      12:00-12:40   | Viernes    09:20-10:00
         * 6°D     |   40     | null | Martes     12:00-12:40   | Martes     10:40-11:20
         */
        $sections = [
            // [grado_id, guia_id, salon, iDay,       iSlot,         bDay,        bSlot]
            [25, 13,   '-', 'Lunes',      '10:40-11:20', 'Lunes',      '08:20-09:00'],
            [26, 14,   '-', 'Miércoles',  '10:40-11:20', 'Martes',     '08:20-09:00'],
            [36, null, '-', 'Jueves',     '10:40-11:20', 'Miércoles',  '07:40-08:20'],
            [37, null, '-', 'Viernes',    '10:40-11:20', 'Miércoles',  '08:20-09:00'],
            [27, 15,   '-', 'Martes',     '10:40-11:20', 'Viernes',    '08:20-09:00'],
            [28, 16,   '-', 'Lunes',      '11:20-12:00', 'Jueves',     '08:20-09:00'],
            [38, null, '-', 'Martes',     '11:20-12:00', 'Lunes',      '09:20-10:00'],
            [39, null, '-', 'Miércoles',  '11:20-12:00', 'Martes',     '09:20-10:00'],
            [29, 17,   '-', 'Jueves',     '11:20-12:00', 'Miércoles',  '09:20-10:00'],
            [30, 18,   '-', 'Viernes',    '11:20-12:00', 'Jueves',     '09:20-10:00'],
            [31, 19,   '-', 'Lunes',      '12:00-12:40', 'Viernes',    '09:20-10:00'],
            [40, null, '-', 'Martes',     '12:00-12:40', 'Martes',     '10:40-11:20'],
        ];

        foreach ($sections as [$gradoId, $guiaId, $salon, $iDay, $iSlot, $bDay, $bSlot]) {
            $horario = $this->buildSchedule($guiaId, $salon, $iDay, $iSlot, $bDay, $bSlot);

            HorarioGrado::updateOrCreate(
                ['grado_id' => $gradoId, 'jornada' => 'matutina'],
                ['horario'  => $horario]
            );

            $this->command->line("  ✓ grado_id={$gradoId} actualizado.");
        }

        $this->command->info('Horarios 4°–6° matutina creados/actualizados correctamente.');
    }
}
