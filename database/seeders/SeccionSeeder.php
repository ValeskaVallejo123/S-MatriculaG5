<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seccion;

class SeccionSeeder extends Seeder
{
    public function run(): void
    {
        $grados  = ['1°', '2°', '3°', '4°', '5°', '6°'];
        $letras  = ['A', 'B', 'C'];

        foreach ($grados as $grado) {
            foreach ($letras as $letra) {
                Seccion::firstOrCreate(
                    ['grado' => $grado, 'letra' => $letra],
                    [
                        'nombre'    => "$grado $letra",
                        'capacidad' => 30,
                    ]
                );
            }
        }
    }
}