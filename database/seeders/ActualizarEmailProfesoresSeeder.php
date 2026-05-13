<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ActualizarEmailProfesoresSeeder extends Seeder
{
    /**
     * Actualiza el email de cada profesor por su DNI
     * y crea (o actualiza) su usuario de acceso al sistema.
     *
     * Contraseña por defecto: Docente2025!
     */
    public function run(): void
    {
        $maestroRolId = DB::table('roles')->where('nombre', 'Maestro')->value('id');

        // DNI => email  (los mismos DNI del ProfesorSeeder)
        $emails = [
            '0101-1990-00001' => 'jennifer.mascareno@egm.edu.hn',
            '0101-1991-00002' => 'concepcion.sierra@egm.edu.hn',
            '0101-1985-00003' => 'juana.leon@egm.edu.hn',
            '0101-1988-00004' => 'liz.veliz@egm.edu.hn',
            '0101-1987-00005' => 'paula.sauceda@egm.edu.hn',
            '0101-1992-00006' => 'elia.sosa@egm.edu.hn',
            '0101-1983-00007' => 'mirian.carias@egm.edu.hn',
            '0101-1980-00008' => 'rolan.espinal@egm.edu.hn',
            '0101-1986-00009' => 'angel.sanchez@egm.edu.hn',
            '0101-1984-00010' => 'pedro.nufio@egm.edu.hn',
            '0101-1979-00011' => 'bivilia.salgado@egm.edu.hn',
            '0101-1981-00012' => 'bernarda.turcios@egm.edu.hn',
            '0101-1982-00013' => 'nancy.avila@egm.edu.hn',
            '0101-1989-00014' => 'leda.avila@egm.edu.hn',
            '0101-1993-00015' => 'francis.reyes@egm.edu.hn',
            '0101-1988-00016' => 'lourdes.maradiaga@egm.edu.hn',
            '0101-1990-00017' => 'sayda.garcia@egm.edu.hn',
            '0101-1985-00018' => 'aminta.rojas@egm.edu.hn',
            '0101-1987-00019' => 'claudia.artica@egm.edu.hn',
            '0101-1991-00020' => 'sofia.briseno@egm.edu.hn',
            '0101-1986-00021' => 'aida.lewis@egm.edu.hn',
            '0101-1983-00022' => 'francis.valladares@egm.edu.hn',
            '0101-1989-00023' => 'xiomara.gomez@egm.edu.hn',
            '0101-1984-00024' => 'nancy.ramirez@egm.edu.hn',
            '0101-1992-00025' => 'ruth.salinas@egm.edu.hn',
            '0101-1993-00026' => 'justina.castellanos@egm.edu.hn',
            '0101-1980-00027' => 'gladys.mendoza@egm.edu.hn',
            '0101-1995-00028' => 'flora.gonzalez@egm.edu.hn',
            '0101-1978-00029' => 'carlos.oyuela@egm.edu.hn',
            '0101-1982-00030' => 'angela.salinas@egm.edu.hn',
            '0101-1990-00031' => 'karla.sauceda@egm.edu.hn',
            '0101-1979-00032' => 'blanca.salinas@egm.edu.hn',
        ];

        $actualizados  = 0;
        $usuariosNuevos = 0;

        foreach ($emails as $dni => $email) {
            // 1) Actualizar email en la tabla profesores
            $profesor = DB::table('profesores')->where('dni', $dni)->first();

            if (! $profesor) {
                $this->command->warn("  ⚠  DNI {$dni} no encontrado en profesores — omitido");
                continue;
            }

            DB::table('profesores')
                ->where('dni', $dni)
                ->update(['email' => $email]);

            $actualizados++;

            // 2) Crear usuario si no existe
            $existeUser = DB::table('users')->where('email', $email)->exists();

            if (! $existeUser) {
                DB::table('users')->insert([
                    'name'              => $profesor->nombre . ' ' . $profesor->apellido,
                    'email'             => $email,
                    'password'          => Hash::make('Docente2025!'),
                    'user_type'         => 'profesor',
                    'id_rol'            => $maestroRolId,
                    'activo'            => true,
                    'is_super_admin'    => false,
                    'is_protected'      => false,
                    'email_verified_at' => now(),
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]);
                $usuariosNuevos++;
            }
        }

        $this->command->info("✅ {$actualizados} profesores actualizados con email.");
        $this->command->info("✅ {$usuariosNuevos} usuarios creados.");
        $this->command->line('');
        $this->command->line('  Contraseña por defecto : Docente2025!');
        $this->command->warn('⚠️  Ahora corre: php artisan db:seed --class=AsignarMateriasGradoSeeder');
    }
}
