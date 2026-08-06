<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsAndRolesSeeder extends Seeder
{
    public function run()
    {
        // Desactivar temporalmente las claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Limpiar las tablas en orden correcto
        DB::table('roles_permisos')->truncate(); // primero la tabla dependiente
        DB::table('permisos')->truncate();
        DB::table('roles')->truncate();

        // Reactivar las claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Insertar roles
        DB::table('roles')->insert([
            ['nombre' => 'Admin'],
            ['nombre' => 'Usuario'],
        ]);

        // Insertar permisos
        DB::table('permisos')->insert([
            ['nombre' => 'Crear'],
            ['nombre' => 'Editar'],
        ]);

        // Asignar permisos a roles usando los nombres correctos de columnas
        DB::table('roles_permisos')->insert([
            ['id_rol' => 1, 'id_permiso' => 1],
            ['id_rol' => 1, 'id_permiso' => 2],
        ]);
    }
}

