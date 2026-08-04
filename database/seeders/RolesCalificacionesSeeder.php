<?php
// ─────────────────────────────────────────────────────────────
//  database/seeders/RolesCalificacionesSeeder.php
//  Ejecutar con: php artisan db:seed --class=RolesCalificacionesSeeder
// ─────────────────────────────────────────────────────────────

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesCalificacionesSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar caché de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ── Crear permisos ────────────────────────────────────
        $permisos = [
            'ver-calificaciones-profesor',
            'ver-calificaciones-padre',
            'ver-calificaciones-alumno',
            'editar-calificaciones',
            'configurar-porcentajes',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        // ── Crear / actualizar roles ──────────────────────────
        $rolProfesor = Role::firstOrCreate(['name' => 'profesor']);
        $rolProfesor->syncPermissions([
            'ver-calificaciones-profesor',
            'editar-calificaciones',
            'configurar-porcentajes',
        ]);

        $rolPadre = Role::firstOrCreate(['name' => 'padre']);
        $rolPadre->syncPermissions([
            'ver-calificaciones-padre',
        ]);

        $rolAlumno = Role::firstOrCreate(['name' => 'alumno']);
        $rolAlumno->syncPermissions([
            'ver-calificaciones-alumno',
        ]);

        $rolAdmin = Role::firstOrCreate(['name' => 'admin']);
        $rolAdmin->syncPermissions(Permission::all());

        $this->command->info('Roles y permisos de calificaciones creados correctamente.');
    }
}


/*
──────────────────────────────────────────────────────────────
  AuthServiceProvider.php  —  Registrar las policies (opcional)
──────────────────────────────────────────────────────────────
  Agrega esto dentro de boot() si usas Policy en vez del
  middleware de Spatie:

  Gate::define('ver-calificaciones-profesor', fn($user) =>
      $user->hasRole('profesor') || $user->hasRole('admin')
  );
  Gate::define('ver-calificaciones-padre',   fn($user) =>
      $user->hasRole('padre')    || $user->hasRole('admin')
  );
  Gate::define('ver-calificaciones-alumno',  fn($user) =>
      $user->hasRole('alumno')   || $user->hasRole('admin')
  );
*/