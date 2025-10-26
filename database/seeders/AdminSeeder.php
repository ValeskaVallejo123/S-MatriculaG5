<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $nombres = ['Juan', 'María', 'Roberto', 'Ana', 'Carlos'];
        $apellidos = ['Martínez', 'García', 'Hernández', 'López', 'Ramírez'];

        for ($i = 0; $i < 5; $i++) {
            DB::table('admins')->insert([
                'nombre' => $nombres[$i],
                'apellido' => $apellidos[$i],
                'email' => strtolower($nombres[$i]) . '@sistema.edu',
                'telefono' => '504-' . rand(2000, 9999) . '-' . rand(1000, 9999),
                'direccion' => 'Tegucigalpa, Honduras',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}