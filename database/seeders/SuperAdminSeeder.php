<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            [
                'name'           => 'Super Administrador',
                'email'          => 'superadmin@egm.edu.hn',
                'password'       => Hash::make('Admin123!'),
                'user_type'      => 'super_admin',
                'is_super_admin' => true,
                'is_protected'   => true,
                'email_verified_at' => now(),
            ],
            [
                'name'           => 'Administrador',
                'email'          => 'admin@egm.edu.hn',
                'password'       => Hash::make('12345678'),
                'user_type'      => 'admin',
                'is_super_admin' => false,
                'is_protected'   => false,
                'email_verified_at' => now(),
            ],
            [
                'name'           => 'Estudiante Prueba',
                'email'          => 'estudiante@egm.edu.hn',
                'password'       => Hash::make('12345678'),
                'user_type'      => 'estudiante',
                'is_super_admin' => false,
                'is_protected'   => false,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($usuarios as $datos) {
            User::firstOrCreate(
                ['email' => $datos['email']],
                $datos
            );
        }
    }
}
