<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BuscarEstudianteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Estudiante::factory(1)->create();
    }
}
