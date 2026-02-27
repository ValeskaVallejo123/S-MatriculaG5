<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grado;

class GradoMateriaSeeder extends Seeder
{
    public function run()
    {
        // Eliminar grados existentes del año actual
        $anioActual = date('Y');
        Grado::where('anio_lectivo', $anioActual)->delete();
        
        $this->command->warn('🗑️  Grados del año ' . $anioActual . ' eliminados');

        $grados = [
            ['numero' => 1, 'nivel' => 'primaria'],
            ['numero' => 2, 'nivel' => 'primaria'],
            ['numero' => 3, 'nivel' => 'primaria'],
            ['numero' => 4, 'nivel' => 'primaria'],
            ['numero' => 5, 'nivel' => 'primaria'],
            ['numero' => 6, 'nivel' => 'primaria'],
            ['numero' => 7, 'nivel' => 'secundaria'],
            ['numero' => 8, 'nivel' => 'secundaria'],
            ['numero' => 9, 'nivel' => 'secundaria'],
        ];

        $secciones = ['A', 'B', 'C', 'D'];

        foreach ($grados as $gradoData) {
            foreach ($secciones as $seccion) {
                Grado::create([
                    'nivel' => $gradoData['nivel'],
                    'numero' => $gradoData['numero'],
                    'seccion' => $seccion,
                    'anio_lectivo' => $anioActual,
                    'activo' => true,
                ]);
            }
        }

        $this->command->info(' Se han creado 9 grados con 4 secciones cada uno (36 grados en total)');
        $this->command->info('   • Primaria: 1° a 6° (24 grados)');
        $this->command->info('   • Secundaria: 7° a 9° (12 grados)');
    }
}