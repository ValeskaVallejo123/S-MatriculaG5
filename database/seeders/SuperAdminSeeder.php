<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Super Administrador',
            'email' => 'admin@escuela.com',
            'password' => Hash::make('12345678'),
            'role' => 'super_admin',
        ]);

        User::create([
            'name' => 'Administrador',
            'email' => 'admin2@escuela.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Estudiante',
            'email' => 'estudiante@escuela.com',
            'password' => Hash::make('12345678'),
            'role' => 'estudiante',
        ]);
    }
}