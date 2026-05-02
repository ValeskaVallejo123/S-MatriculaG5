<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PeriodoAcademico;

class PeriodoAcademicoSeeder extends Seeder
{
    public function run(): void
    {
        // No insertar si ya existen períodos
        if (PeriodoAcademico::count() > 0) {
            $this->command->info('Ya existen períodos académicos. Seeder omitido.');
            return;
        }

        $periodos = [
            [
                'nombre_periodo' => 'I Parcial',
                'tipo'           => 'clases',
                'fecha_inicio'   => '2026-02-02',
                'fecha_fin'      => '2026-04-10',
            ],
            [
                'nombre_periodo' => 'Vacaciones de Semana Santa',
                'tipo'           => 'vacaciones',
                'fecha_inicio'   => '2026-04-13',
                'fecha_fin'      => '2026-04-17',
            ],
            [
                'nombre_periodo' => 'II Parcial',
                'tipo'           => 'clases',
                'fecha_inicio'   => '2026-04-20',
                'fecha_fin'      => '2026-06-26',
            ],
            [
                'nombre_periodo' => 'Vacaciones de Verano',
                'tipo'           => 'vacaciones',
                'fecha_inicio'   => '2026-06-29',
                'fecha_fin'      => '2026-07-17',
            ],
            [
                'nombre_periodo' => 'III Parcial',
                'tipo'           => 'clases',
                'fecha_inicio'   => '2026-07-20',
                'fecha_fin'      => '2026-10-02',
            ],
            [
                'nombre_periodo' => 'Exámenes Finales',
                'tipo'           => 'examenes',
                'fecha_inicio'   => '2026-10-05',
                'fecha_fin'      => '2026-10-23',
            ],
        ];

        foreach ($periodos as $periodo) {
            PeriodoAcademico::create($periodo);
        }

        $this->command->info('✓ ' . count($periodos) . ' períodos académicos creados.');
    }
}
