<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Roles creados por RolesPermisosSeeder (debe correr antes que este seeder)
        $rolSuperAdmin  = \App\Models\Rol::where('nombre', 'Super Administrador')->value('id');
        $rolAdmin       = \App\Models\Rol::where('nombre', 'Administrador')->value('id');
        $rolEstudiante  = \App\Models\Rol::where('nombre', 'Estudiante')->value('id');

        $usuarios = [
            [
                'name'           => 'Super Administrador',
                'email'          => 'superadmin@egm.edu.hn',
                'password'       => Hash::make('Admin123!'),
                'user_type'      => 'super_admin',
                'id_rol'         => $rolSuperAdmin,
                'is_super_admin' => true,
                'is_protected'   => true,
                'activo'         => true,
                'email_verified_at' => now(),
            ],
            [
                'name'           => 'Administrador',
                'email'          => 'admin@egm.edu.hn',
                'password'       => Hash::make('12345678'),
                'user_type'      => 'admin',
                'id_rol'         => $rolAdmin,
                'is_super_admin' => false,
                'is_protected'   => false,
                'activo'         => true,
                'email_verified_at' => now(),
            ],
            [
                'name'           => 'Estudiante Prueba',
                'email'          => 'estudiante@egm.edu.hn',
                'password'       => Hash::make('12345678'),
                'user_type'      => 'estudiante',
                'id_rol'         => $rolEstudiante,
                'is_super_admin' => false,
                'is_protected'   => false,
                'activo'         => true,
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