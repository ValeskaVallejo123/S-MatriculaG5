<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Insertar Roles
        $roles = [
            ['nombre' => 'Super Administrador', 'descripcion' => 'Acceso total al sistema', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Administrador', 'descripcion' => 'Gestión general del sistema escolar', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Maestro', 'descripcion' => 'Gestión de clases, calificaciones y asistencias', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Estudiante', 'descripcion' => 'Acceso a consultas de calificaciones y asistencias', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Padre', 'descripcion' => 'Consulta de información de sus hijos', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($roles as $rol) {
            DB::table('roles')->updateOrInsert(
                ['nombre' => $rol['nombre']],
                $rol
            );
        }

        // Insertar Permisos
        $permisos = [
            // Dashboard
            ['nombre' => 'ver-dashboard', 'descripcion' => 'Ver panel principal', 'created_at' => now(), 'updated_at' => now()],
            
            // Usuarios
            ['nombre' => 'gestionar-usuarios', 'descripcion' => 'Gestión completa de usuarios', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'crear-usuarios', 'descripcion' => 'Crear nuevos usuarios', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'editar-usuarios', 'descripcion' => 'Editar usuarios existentes', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'eliminar-usuarios', 'descripcion' => 'Eliminar usuarios', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'ver-usuarios', 'descripcion' => 'Ver listado de usuarios', 'created_at' => now(), 'updated_at' => now()],
            
            // Roles
            ['nombre' => 'gestionar-roles', 'descripcion' => 'Gestión completa de roles', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'crear-roles', 'descripcion' => 'Crear nuevos roles', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'editar-roles', 'descripcion' => 'Editar roles existentes', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'eliminar-roles', 'descripcion' => 'Eliminar roles', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'ver-roles', 'descripcion' => 'Ver listado de roles', 'created_at' => now(), 'updated_at' => now()],
            
            // Permisos
            ['nombre' => 'gestionar-permisos', 'descripcion' => 'Gestión completa de permisos', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'asignar-permisos', 'descripcion' => 'Asignar permisos a roles', 'created_at' => now(), 'updated_at' => now()],
            
            // Estudiantes
            ['nombre' => 'gestionar-estudiantes', 'descripcion' => 'Gestión completa de estudiantes', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'crear-estudiantes', 'descripcion' => 'Crear nuevos estudiantes', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'editar-estudiantes', 'descripcion' => 'Editar estudiantes existentes', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'eliminar-estudiantes', 'descripcion' => 'Eliminar estudiantes', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'ver-estudiantes', 'descripcion' => 'Ver listado de estudiantes', 'created_at' => now(), 'updated_at' => now()],
            
            // Maestros
            ['nombre' => 'gestionar-maestros', 'descripcion' => 'Gestión completa de maestros', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'crear-maestros', 'descripcion' => 'Crear nuevos maestros', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'editar-maestros', 'descripcion' => 'Editar maestros existentes', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'eliminar-maestros', 'descripcion' => 'Eliminar maestros', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'ver-maestros', 'descripcion' => 'Ver listado de maestros', 'created_at' => now(), 'updated_at' => now()],
            
            // Grados
            ['nombre' => 'gestionar-grados', 'descripcion' => 'Gestión completa de grados', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'crear-grados', 'descripcion' => 'Crear nuevos grados', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'editar-grados', 'descripcion' => 'Editar grados existentes', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'eliminar-grados', 'descripcion' => 'Eliminar grados', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'ver-grados', 'descripcion' => 'Ver listado de grados', 'created_at' => now(), 'updated_at' => now()],
            
            // Materias
            ['nombre' => 'gestionar-materias', 'descripcion' => 'Gestión completa de materias', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'crear-materias', 'descripcion' => 'Crear nuevas materias', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'editar-materias', 'descripcion' => 'Editar materias existentes', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'eliminar-materias', 'descripcion' => 'Eliminar materias', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'ver-materias', 'descripcion' => 'Ver listado de materias', 'created_at' => now(), 'updated_at' => now()],
            
            // Calificaciones
            ['nombre' => 'gestionar-calificaciones', 'descripcion' => 'Gestión completa de calificaciones', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'crear-calificaciones', 'descripcion' => 'Crear nuevas calificaciones', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'editar-calificaciones', 'descripcion' => 'Editar calificaciones existentes', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'eliminar-calificaciones', 'descripcion' => 'Eliminar calificaciones', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'ver-calificaciones', 'descripcion' => 'Ver calificaciones', 'created_at' => now(), 'updated_at' => now()],
            
            // Asistencias
            ['nombre' => 'gestionar-asistencias', 'descripcion' => 'Gestión completa de asistencias', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'crear-asistencias', 'descripcion' => 'Registrar asistencias', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'editar-asistencias', 'descripcion' => 'Editar asistencias', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'eliminar-asistencias', 'descripcion' => 'Eliminar registros de asistencia', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'ver-asistencias', 'descripcion' => 'Ver registros de asistencia', 'created_at' => now(), 'updated_at' => now()],
            
            // Reportes
            ['nombre' => 'gestionar-reportes', 'descripcion' => 'Gestión completa de reportes', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'ver-reportes', 'descripcion' => 'Ver reportes', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'exportar-reportes', 'descripcion' => 'Exportar reportes', 'created_at' => now(), 'updated_at' => now()],
            
            // Configuración
            ['nombre' => 'gestionar-configuracion', 'descripcion' => 'Gestión de configuración del sistema', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'ver-configuracion', 'descripcion' => 'Ver configuración', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($permisos as $permiso) {
            DB::table('permisos')->updateOrInsert(
                ['nombre' => $permiso['nombre']],
                $permiso
            );
        }

        // Obtener IDs de roles
        $superAdminId = DB::table('roles')->where('nombre', 'Super Administrador')->value('id');
        $administradorId = DB::table('roles')->where('nombre', 'Administrador')->value('id');
        $maestroId = DB::table('roles')->where('nombre', 'Maestro')->value('id');
        $estudianteId = DB::table('roles')->where('nombre', 'Estudiante')->value('id');
        $padreId = DB::table('roles')->where('nombre', 'Padre')->value('id');

        // Obtener todos los IDs de permisos
        $todosLosPermisos = DB::table('permisos')->pluck('id')->toArray();

        // Asignar TODOS los permisos al Super Administrador
        foreach ($todosLosPermisos as $permisoId) {
            DB::table('roles_permisos')->updateOrInsert(
                ['id_rol' => $superAdminId, 'id_permiso' => $permisoId],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }

        // Permisos para Administrador
        $permisosAdministrador = DB::table('permisos')->whereIn('nombre', [
            'ver-dashboard',
            'gestionar-estudiantes', 'crear-estudiantes', 'editar-estudiantes', 'ver-estudiantes',
            'gestionar-maestros', 'crear-maestros', 'editar-maestros', 'ver-maestros',
            'gestionar-grados', 'crear-grados', 'editar-grados', 'ver-grados',
            'gestionar-materias', 'crear-materias', 'editar-materias', 'ver-materias',
            'ver-calificaciones', 'ver-asistencias',
            'ver-reportes', 'exportar-reportes',
        ])->pluck('id')->toArray();

        foreach ($permisosAdministrador as $permisoId) {
            DB::table('roles_permisos')->updateOrInsert(
                ['id_rol' => $administradorId, 'id_permiso' => $permisoId],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }

        // Permisos para Maestro
        $permisosMaestro = DB::table('permisos')->whereIn('nombre', [
            'ver-dashboard',
            'ver-estudiantes',
            'gestionar-calificaciones', 'crear-calificaciones', 'editar-calificaciones', 'ver-calificaciones',
            'gestionar-asistencias', 'crear-asistencias', 'editar-asistencias', 'ver-asistencias',
            'ver-reportes',
        ])->pluck('id')->toArray();

        foreach ($permisosMaestro as $permisoId) {
            DB::table('roles_permisos')->updateOrInsert(
                ['id_rol' => $maestroId, 'id_permiso' => $permisoId],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }

        // Permisos para Estudiante
        $permisosEstudiante = DB::table('permisos')->whereIn('nombre', [
            'ver-dashboard',
            'ver-calificaciones',
            'ver-asistencias',
        ])->pluck('id')->toArray();

        foreach ($permisosEstudiante as $permisoId) {
            DB::table('roles_permisos')->updateOrInsert(
                ['id_rol' => $estudianteId, 'id_permiso' => $permisoId],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }

        // Permisos para Padre
        $permisosPadre = DB::table('permisos')->whereIn('nombre', [
            'ver-dashboard',
            'ver-calificaciones',
            'ver-asistencias',
        ])->pluck('id')->toArray();

        foreach ($permisosPadre as $permisoId) {
            DB::table('roles_permisos')->updateOrInsert(
                ['id_rol' => $padreId, 'id_permiso' => $permisoId],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }

        // Asignar rol de Super Administrador al primer usuario
        $primerUsuario = DB::table('users')->orderBy('id')->first();
        if ($primerUsuario) {
            DB::table('users')->where('id', $primerUsuario->id)->update([
                'id_rol' => $superAdminId,
                'updated_at' => now()
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Limpiar las tablas
        DB::table('roles_permisos')->truncate();
        DB::table('permisos')->truncate();
        DB::table('roles')->truncate();
        DB::table('users')->update(['id_rol' => null]);
    }
};