<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Estudiante;
use App\Models\Padre;

class BuscarEstudianteSeeder extends Seeder
{
    public function run(): void
    {
        // Crear algunos padres primero (opcional)
        $padres = Padre::factory(5)->create();

        // Crear estudiantes
        Estudiante::factory(6)->create([
            'padre_id' => function() use ($padres) {
                return $padres->random()->id;
            }
        ]);
    }
}