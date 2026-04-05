<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

/**
 * Crea/sincroniza cuentas de usuario para profesores, estudiantes y padres
 * que existen en sus tablas pero no tienen registro en users.
 *
 * Ejecutar: php artisan db:seed --class=SincronizarUsuariosSeeder
 */
class SincronizarUsuariosSeeder extends Seeder
{
    public function run(): void
    {
        $ahora        = Carbon::now();
        $maestroRolId = DB::table('roles')->where('nombre', 'Maestro')->value('id');
        $estudianteId = DB::table('roles')->where('nombre', 'Estudiante')->value('id');
        $padreRolId   = DB::table('roles')->where('nombre', 'Padre')->value('id');

        // ── 1. PROFESORES sin cuenta de usuario ───────────────────────────
        $this->command->info('');
        $this->command->info('── Sincronizando PROFESORES ──');

        if ($maestroRolId) {
            $emailsEnUsers = DB::table('users')->pluck('email')
                ->map(fn($e) => strtolower(trim($e)))
                ->flip();

            $profesoresSinUsuario = DB::table('profesores')
                ->whereNotNull('email')
                ->where('email', '!=', '')
                ->get()
                ->filter(fn($p) => !isset($emailsEnUsers[strtolower(trim($p->email))]));

            $creados = 0;
            foreach ($profesoresSinUsuario as $p) {
                DB::table('users')->insert([
                    'name'              => trim($p->nombre . ' ' . $p->apellido),
                    'email'             => strtolower(trim($p->email)),
                    'password'          => Hash::make('Docente2025!'),
                    'id_rol'            => $maestroRolId,
                    'activo'            => true,
                    'is_super_admin'    => false,
                    'is_protected'      => false,
                    'email_verified_at' => $ahora,
                    'created_at'        => $ahora,
                    'updated_at'        => $ahora,
                ]);
                $creados++;
            }
            $this->command->info("  ✅ {$creados} nuevas cuentas de profesor creadas (Docente2025!)");
        } else {
            $this->command->warn('  ⚠️  No se encontró el rol "Maestro".');
        }

        // ── 2. ESTUDIANTES sin cuenta de usuario ──────────────────────────
        $this->command->info('── Sincronizando ESTUDIANTES ──');

        if ($estudianteId) {
            // Recargar emails existentes en users
            $emailsEnUsers = DB::table('users')->pluck('email')
                ->map(fn($e) => strtolower(trim($e)))
                ->flip();

            // Contar cuántos emails ya se usaron para manejar duplicados
            $contadorEmails = [];

            $estudiantes = DB::table('estudiantes')->get();
            $creados = 0;

            foreach ($estudiantes as $est) {
                // Si ya tiene email en la tabla estudiantes y ese email ya tiene user → saltar
                if ($est->email && isset($emailsEnUsers[strtolower(trim($est->email))])) {
                    continue;
                }

                // Generar email a partir del nombre
                $nombre   = $this->normalizar($est->nombre1 ?? 'alumno');
                $apellido = $this->normalizar($est->apellido1 ?? 'apellido');
                $baseEmail = "{$nombre}.{$apellido}@egm.edu.hn";

                // Manejar duplicados
                $emailFinal = $baseEmail;
                if (isset($emailsEnUsers[$emailFinal]) || isset($contadorEmails[$emailFinal])) {
                    $contador = ($contadorEmails[$baseEmail] ?? 1) + 1;
                    $contadorEmails[$baseEmail] = $contador;
                    $emailFinal = "{$nombre}.{$apellido}{$contador}@egm.edu.hn";
                } else {
                    $contadorEmails[$baseEmail] = 1;
                }

                // Guardar email en la tabla estudiantes si no tiene
                if (!$est->email) {
                    DB::table('estudiantes')
                        ->where('id', $est->id)
                        ->update(['email' => $emailFinal, 'updated_at' => $ahora]);
                }

                DB::table('users')->insert([
                    'name'              => trim(collect([$est->nombre1, $est->nombre2, $est->apellido1, $est->apellido2])->filter()->implode(' ')),
                    'email'             => $emailFinal,
                    'password'          => Hash::make('egm2025'),
                    'id_rol'            => $estudianteId,
                    'activo'            => true,
                    'is_super_admin'    => false,
                    'is_protected'      => false,
                    'email_verified_at' => $ahora,
                    'created_at'        => $ahora,
                    'updated_at'        => $ahora,
                ]);

                $emailsEnUsers[$emailFinal] = true; // registrar para evitar duplicados en esta corrida
                $creados++;
            }

            $this->command->info("  ✅ {$creados} nuevas cuentas de estudiante creadas (egm2025)");
        } else {
            $this->command->warn('  ⚠️  No se encontró el rol "Estudiante".');
        }

        // ── 3. PADRES con correo pero sin cuenta de usuario ───────────────
        $this->command->info('── Sincronizando PADRES ──');

        if ($padreRolId) {
            $emailsEnUsers = DB::table('users')->pluck('email')
                ->map(fn($e) => strtolower(trim($e)))
                ->flip();

            $padresSinUsuario = DB::table('padres')
                ->whereNotNull('correo')
                ->where('correo', '!=', '')
                ->get()
                ->filter(fn($p) => !isset($emailsEnUsers[strtolower(trim($p->correo))]));

            $creados = 0;
            foreach ($padresSinUsuario as $p) {
                DB::table('users')->insert([
                    'name'              => trim($p->nombre . ' ' . $p->apellido),
                    'email'             => strtolower(trim($p->correo)),
                    'password'          => Hash::make('Padre2025!'),
                    'id_rol'            => $padreRolId,
                    'activo'            => true,
                    'is_super_admin'    => false,
                    'is_protected'      => false,
                    'email_verified_at' => $ahora,
                    'created_at'        => $ahora,
                    'updated_at'        => $ahora,
                ]);
                $creados++;
            }
            $this->command->info("  ✅ {$creados} nuevas cuentas de padre creadas (Padre2025!)");
        } else {
            $this->command->warn('  ⚠️  No se encontró el rol "Padre".');
        }

        $this->command->info('');
        $this->command->line('  Resumen de contraseñas por defecto:');
        $this->command->line('    Profesores  → Docente2025!');
        $this->command->line('    Estudiantes → egm2025');
        $this->command->line('    Padres      → Padre2025!');
        $this->command->info('');
    }

    /** Convierte texto con tildes a ASCII puro para usar en emails */
    private function normalizar(string $texto): string
    {
        $texto   = mb_strtolower($texto, 'UTF-8');
        $buscar  = ['á','é','í','ó','ú','ñ','ü','à','è','ì','ò','ù','â','ê','î','ô','û'];
        $reempl  = ['a','e','i','o','u','n','u','a','e','i','o','u','a','e','i','o','u'];
        $texto   = str_replace($buscar, $reempl, $texto);
        return preg_replace('/[^a-z]/', '', $texto);
    }
}
