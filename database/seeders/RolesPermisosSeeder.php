<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;
use App\Models\Permiso;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesPermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ========================================
        // CREAR PERMISOS
        // ========================================
        $permisos = [
            // Permisos de Usuarios
            ['nombre' => 'ver_usuarios', 'descripcion' => 'Ver lista de usuarios'],
            ['nombre' => 'crear_usuarios', 'descripcion' => 'Crear nuevos usuarios'],
            ['nombre' => 'editar_usuarios', 'descripcion' => 'Editar usuarios existentes'],
            ['nombre' => 'eliminar_usuarios', 'descripcion' => 'Eliminar usuarios'],

            // Permisos de Estudiantes
            ['nombre' => 'ver_estudiantes', 'descripcion' => 'Ver lista de estudiantes'],
            ['nombre' => 'crear_estudiantes', 'descripcion' => 'Crear nuevos estudiantes'],
            ['nombre' => 'editar_estudiantes', 'descripcion' => 'Editar estudiantes existentes'],
            ['nombre' => 'eliminar_estudiantes', 'descripcion' => 'Eliminar estudiantes'],

            // Permisos de Profesores
            ['nombre' => 'ver_profesores', 'descripcion' => 'Ver lista de profesores'],
            ['nombre' => 'crear_profesores', 'descripcion' => 'Crear nuevos profesores'],
            ['nombre' => 'editar_profesores', 'descripcion' => 'Editar profesores existentes'],
            ['nombre' => 'eliminar_profesores', 'descripcion' => 'Eliminar profesores'],

            // Permisos de Matrículas
            ['nombre' => 'ver_matriculas', 'descripcion' => 'Ver matrículas'],
            ['nombre' => 'crear_matriculas', 'descripcion' => 'Crear matrículas'],
            ['nombre' => 'editar_matriculas', 'descripcion' => 'Editar matrículas'],
            ['nombre' => 'eliminar_matriculas', 'descripcion' => 'Eliminar matrículas'],

            // Permisos de Cursos
            ['nombre' => 'ver_cursos', 'descripcion' => 'Ver cursos'],
            ['nombre' => 'crear_cursos', 'descripcion' => 'Crear cursos'],
            ['nombre' => 'editar_cursos', 'descripcion' => 'Editar cursos'],
            ['nombre' => 'eliminar_cursos', 'descripcion' => 'Eliminar cursos'],

            // Permisos de Secciones
            ['nombre' => 'ver_secciones', 'descripcion' => 'Ver secciones'],
            ['nombre' => 'crear_secciones', 'descripcion' => 'Crear secciones'],
            ['nombre' => 'editar_secciones', 'descripcion' => 'Editar secciones'],
            ['nombre' => 'eliminar_secciones', 'descripcion' => 'Eliminar secciones'],

            // Permisos de Calificaciones
            ['nombre' => 'ver_calificaciones', 'descripcion' => 'Ver calificaciones'],
            ['nombre' => 'registrar_calificaciones', 'descripcion' => 'Registrar calificaciones'],
            ['nombre' => 'editar_calificaciones', 'descripcion' => 'Editar calificaciones'],

            // Permisos de Reportes
            ['nombre' => 'ver_reportes', 'descripcion' => 'Ver reportes del sistema'],
            ['nombre' => 'generar_reportes', 'descripcion' => 'Generar reportes'],
            ['nombre' => 'exportar_datos', 'descripcion' => 'Exportar datos del sistema'],

            // Permisos de Configuración
            ['nombre' => 'configurar_sistema', 'descripcion' => 'Configurar parámetros del sistema'],
            ['nombre' => 'gestionar_roles', 'descripcion' => 'Gestionar roles y permisos'],
            ['nombre' => 'ver_logs', 'descripcion' => 'Ver registros del sistema'],
        ];

        foreach ($permisos as $permiso) {
            Permiso::firstOrCreate(
                ['nombre' => $permiso['nombre']],
                ['descripcion' => $permiso['descripcion']]
            );
        }

        // ========================================
        // CREAR ROLES
        // ========================================
        
        // 1. Super Administrador (Acceso total)
        $superAdmin = Rol::firstOrCreate(
            ['nombre' => 'Super Administrador'],
            ['descripcion' => 'Acceso completo al sistema']
        );
        
        // Asignar TODOS los permisos al Super Administrador
        $todosLosPermisos = Permiso::all();
        $superAdmin->permisos()->sync($todosLosPermisos->pluck('id'));

        // 2. Administrador (Acceso amplio pero limitado)
        $admin = Rol::firstOrCreate(
            ['nombre' => 'Administrador'],
            ['descripcion' => 'Administrador de área específica']
        );
        
        $permisosAdmin = Permiso::whereIn('nombre', [
            'ver_usuarios', 'crear_usuarios', 'editar_usuarios',
            'ver_estudiantes', 'crear_estudiantes', 'editar_estudiantes',
            'ver_profesores', 'crear_profesores', 'editar_profesores',
            'ver_matriculas', 'crear_matriculas', 'editar_matriculas',
            'ver_cursos', 'crear_cursos', 'editar_cursos',
            'ver_secciones', 'crear_secciones', 'editar_secciones',
            'ver_calificaciones', 'ver_reportes', 'generar_reportes',
        ])->get();
        $admin->permisos()->sync($permisosAdmin->pluck('id'));

        // 3. Profesor
        $profesor = Rol::firstOrCreate(
            ['nombre' => 'Profesor'],
            ['descripcion' => 'Docente del centro educativo']
        );
        
        $permisosProfesor = Permiso::whereIn('nombre', [
            'ver_estudiantes',
            'ver_cursos',
            'ver_secciones',
            'ver_calificaciones', 'registrar_calificaciones', 'editar_calificaciones',
            'ver_reportes',
        ])->get();
        $profesor->permisos()->sync($permisosProfesor->pluck('id'));

        // 4. Estudiante
        $estudiante = Rol::firstOrCreate(
            ['nombre' => 'Estudiante'],
            ['descripcion' => 'Alumno del centro educativo']
        );
        
        $permisosEstudiante = Permiso::whereIn('nombre', [
            'ver_cursos',
            'ver_calificaciones', // Solo las propias
        ])->get();
        $estudiante->permisos()->sync($permisosEstudiante->pluck('id'));

        // 5. Padre/Tutor
        $padre = Rol::firstOrCreate(
            ['nombre' => 'Padre'],
            ['descripcion' => 'Padre o tutor legal del estudiante']
        );
        
        $permisosPadre = Permiso::whereIn('nombre', [
            'ver_estudiantes', // Solo sus hijos
            'ver_calificaciones', // Solo de sus hijos
            'ver_reportes', // Solo de sus hijos
        ])->get();
        $padre->permisos()->sync($permisosPadre->pluck('id'));

        // ========================================
        // CREAR SUPER ADMINISTRADOR POR DEFECTO
        // ========================================
        User::firstOrCreate(
            ['email' => 'superadmin@egm.edu.hn'],
            [
                'name' => 'Super Administrador',
                'password' => Hash::make('SuperAdmin2024#'),
                'id_rol' => $superAdmin->id,
            ]
        );

        $this->command->info(' Roles, permisos y super administrador creados exitosamente.');
    }
}