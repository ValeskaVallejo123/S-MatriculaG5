<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesPermisosSeeder extends Seeder
{
    public function run(): void
    {
        // ============================
        // 1️⃣ Insertar Roles
        // ============================
        $roles = [
            ['nombre' => 'Super Administrador', 'descripcion' => 'Acceso total al sistema', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Administrador', 'descripcion' => 'Gestión general del sistema escolar', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Maestro', 'descripcion' => 'Gestión de clases, calificaciones y asistencias', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Estudiante', 'descripcion' => 'Acceso a consultas de calificaciones y asistencias', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Padre', 'descripcion' => 'Consulta de información de sus hijos', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($roles as $rol) {
            DB::table('roles')->updateOrInsert(['nombre' => $rol['nombre']], $rol);
        }

        // ============================
        // 2️⃣ Insertar Permisos
        // ============================
        $permisos = [
            ['nombre' => 'ver-dashboard'],

            // Usuarios
            ['nombre' => 'gestionar-usuarios'],
            ['nombre' => 'crear-usuarios'],
            ['nombre' => 'editar-usuarios'],
            ['nombre' => 'eliminar-usuarios'],
            ['nombre' => 'ver-usuarios'],

            // Estudiantes
            ['nombre' => 'gestionar-estudiantes'],
            ['nombre' => 'crear-estudiantes'],
            ['nombre' => 'editar-estudiantes'],
            ['nombre' => 'eliminar-estudiantes'],
            ['nombre' => 'ver-estudiantes'],

            // Profesores
            ['nombre' => 'gestionar-profesores'],
            ['nombre' => 'crear-profesores'],
            ['nombre' => 'editar-profesores'],
            ['nombre' => 'eliminar-profesores'],
            ['nombre' => 'ver-profesores'],

            // Cursos
            ['nombre' => 'gestionar-cursos'],
            ['nombre' => 'crear-cursos'],
            ['nombre' => 'editar-cursos'],
            ['nombre' => 'eliminar-cursos'],
            ['nombre' => 'ver-cursos'],

            // Calificaciones
            ['nombre' => 'gestionar-calificaciones'],
            ['nombre' => 'crear-calificaciones'],
            ['nombre' => 'editar-calificaciones'],
            ['nombre' => 'ver-calificaciones'],

            // Reportes
            ['nombre' => 'ver-reportes'],
            ['nombre' => 'exportar-reportes'],

            // Notificaciones
            ['nombre' => 'notificacion'],
            ['nombre' => 'notificacionPreferencia'],
        ];

        foreach ($permisos as $permiso) {
            DB::table('permisos')->updateOrInsert(
                ['nombre' => $permiso['nombre']],
                [
                    'descripcion' => $permiso['descripcion'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }

        // ============================
        // 3️⃣ Obtener IDs de roles
        // ============================
        $superAdminId = DB::table('roles')->where('nombre', 'Super Administrador')->value('id');
        $adminId      = DB::table('roles')->where('nombre', 'Administrador')->value('id');
        $maestroId    = DB::table('roles')->where('nombre', 'Maestro')->value('id');
        $estudianteId = DB::table('roles')->where('nombre', 'Estudiante')->value('id');
        $padreId      = DB::table('roles')->where('nombre', 'Padre')->value('id');

        // ============================
        // 4️⃣ Asignar permisos al Super Admin
        // ============================
        $todosLosPermisos = DB::table('permisos')->pluck('id');

        foreach ($todosLosPermisos as $permisoId) {
            DB::table('permiso_rol')->updateOrInsert(
                ['rol_id' => $superAdminId, 'permiso_id' => $permisoId]
            );
        }

        // ============================
        // 5️⃣ Asignar permisos al Administrador
        // ============================
        $permisosAdmin = DB::table('permisos')
            ->whereIn('nombre', [
                'ver-dashboard',
                'ver-usuarios', 'crear-usuarios', 'editar-usuarios',
                'ver-estudiantes', 'crear-estudiantes', 'editar-estudiantes',
                'ver-profesores', 'crear-profesores', 'editar-profesores',
                'ver-cursos', 'crear-cursos', 'editar-cursos',
                'ver-reportes',
            ])
            ->pluck('id');

        foreach ($permisosAdmin as $permisoId) {
            DB::table('permiso_rol')->updateOrInsert(
                ['rol_id' => $adminId, 'permiso_id' => $permisoId]
            );
        }

        // ============================
        // 6️⃣ Asignar permisos al Maestro
        // ============================
        $permisosMaestro = DB::table('permisos')
            ->whereIn('nombre', [
                'ver-estudiantes',
                'ver-cursos',
                'gestionar-calificaciones',
                'crear-calificaciones',
                'editar-calificaciones',
                'ver-calificaciones',
                'ver-reportes',
            ])
            ->pluck('id');

        foreach ($permisosMaestro as $permisoId) {
            DB::table('permiso_rol')->updateOrInsert(
                ['rol_id' => $maestroId, 'permiso_id' => $permisoId]
            );
        }

        // ============================
        // 7️⃣ Asignar permisos al Estudiante
        // ============================
        $permisosEstudiante = DB::table('permisos')
            ->whereIn('nombre', [
                'ver-cursos',
                'ver-calificaciones',
            ])
            ->pluck('id');

        foreach ($permisosEstudiante as $permisoId) {
            DB::table('permiso_rol')->updateOrInsert(
                ['rol_id' => $estudianteId, 'permiso_id' => $permisoId]
            );
        }

        // ============================
        // 8️⃣ Asignar permisos al Padre
        // ============================
        $permisosPadre = DB::table('permisos')
            ->whereIn('nombre', [
                'ver-estudiantes',
                'ver-calificaciones',
                'ver-reportes',
            ])
            ->pluck('id');

        foreach ($permisosPadre as $permisoId) {
            DB::table('permiso_rol')->updateOrInsert(
                ['rol_id' => $padreId, 'permiso_id' => $permisoId]
            );
        }
    }
}
