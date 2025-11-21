<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Super Administrador PROTEGIDO - No se puede eliminar
        User::create([
            'name' => 'Super Administrador',
            'email' => 'superadmin@egm.edu.hn',
            'password' => Hash::make('Admin123!'), // Cambia esta contraseña después
            'user_type' => 'super_admin', // Cambié 'role' por 'user_type'
            'is_super_admin' => true,
            'is_protected' => true, // Protección contra eliminación
            'email_verified_at' => now(),
        ]);

        // Administrador normal
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@egm.edu.hn',
            'password' => Hash::make('12345678'),
            'user_type' => 'admin', // Cambié 'role' por 'user_type'
            'is_super_admin' => false,
            'is_protected' => false,
            'email_verified_at' => now(),
        ]);

        // Estudiante de prueba
        User::create([
            'name' => 'Estudiante Prueba',
            'email' => 'estudiante@egm.edu.hn',
            'password' => Hash::make('12345678'),
            'user_type' => 'estudiante', // Cambié 'role' por 'user_type'
            'is_super_admin' => false,
            'is_protected' => false,
            'email_verified_at' => now(),
        ]);
    }
}