<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class EstudiantesSeeder extends Seeder
{
    /**
     * 625 estudiantes de prueba — 25 por cada sección
     * CEB Gabriela Mistral — Año 2026
     *
     * Secciones (25 total):
     * Matutina:   1A,1B | 2A,2B | 3A,3B | 4A,4B | 5A,5B | 6A,6B,6C
     * Vespertina: 1C    | 2C    | 3C,3D | 4C,4D | 5C,5D | 6D
     * Secundaria: 7A    | 8A    | 9A
     *
     * ⚠️  DNI ficticios de 13 dígitos. Reemplaza con datos reales.
     * ⚠️  Correos y contraseñas generados automáticamente. Actualizar con datos reales.
     *     Contraseña por defecto: Alumno2025!
     */

    private array $nombres_f = [
        'María','Ana','Sofía','Valentina','Camila','Isabella','Lucía','Daniela',
        'Valeria','Gabriela','Fernanda','Paola','Andrea','Karla','Diana',
        'Laura','Mónica','Patricia','Sandra','Rosa','Elena','Claudia','Alicia',
        'Rebeca','Yessenia',
    ];

    private array $nombres_m = [
        'Carlos','José','Diego','Andrés','Fernando','Sebastián','Mateo','Luis',
        'Jorge','Miguel','Ricardo','Roberto','Alejandro','Héctor','Manuel',
        'Óscar','David','Iván','Pablo','Erick','Josué','Kevin','Bryan',
        'Jonathan','Cristian',
    ];

    private array $apellidos = [
        'Martínez','López','González','Rodríguez','Pérez','Hernández','García',
        'Torres','Ramírez','Flores','Castro','Morales','Ortiz','Mendoza','Reyes',
        'Cruz','Vargas','Jiménez','Soto','Aguilar','Sandoval','Mejía','Paredes',
        'Vega','Molina','Espinoza','Gutiérrez','Fuentes','Ríos','Barrera',
        'Núñez','Serrano','Pacheco','Velásquez','Campos','Murillo','Rivas',
        'Zelaya','Lagos','Bautista',
    ];

    /** Convierte texto con tildes/ñ a ASCII puro para usar en emails */
    private function slug(string $texto): string
    {
        $mapa = [
            'á'=>'a','é'=>'e','í'=>'i','ó'=>'o','ú'=>'u','ü'=>'u','ñ'=>'n',
            'Á'=>'a','É'=>'e','Í'=>'i','Ó'=>'o','Ú'=>'u','Ü'=>'u','Ñ'=>'n',
        ];
        return strtolower(strtr($texto, $mapa));
    }

    public function run(): void
    {
        $now = Carbon::now();

        // Obtener el ID del rol Estudiante (si ya fue creado por RolesPermisosSeeder)
        $estudianteRolId = DB::table('roles')->where('nombre', 'Estudiante')->value('id');

        // [ grado, seccion, anio_nacimiento_base ]
        $secciones = [
            ['Primero',   'A', 2019],
            ['Primero',   'B', 2019],
            ['Primero',   'C', 2019],
            ['Segundo',   'A', 2018],
            ['Segundo',   'B', 2018],
            ['Segundo',   'C', 2018],
            ['Tercero',   'A', 2017],
            ['Tercero',   'B', 2017],
            ['Tercero',   'C', 2017],
            ['Tercero',   'D', 2017],
            ['Cuarto',    'A', 2016],
            ['Cuarto',    'B', 2016],
            ['Cuarto',    'C', 2016],
            ['Cuarto',    'D', 2016],
            ['Quinto',    'A', 2015],
            ['Quinto',    'B', 2015],
            ['Quinto',    'C', 2015],
            ['Quinto',    'D', 2015],
            ['Sexto',     'A', 2014],
            ['Sexto',     'B', 2014],
            ['Sexto',     'C', 2014],
            ['Sexto',     'D', 2014],
            ['I curso',   'A', 2013],
            ['II curso',  'A', 2012],
            ['III curso', 'A', 2011],
        ];

        $insertados = 0;
        $omitidos   = 0;
        $contador   = 100; // Empieza en 100 para no chocar con los 15 anteriores

        foreach ($secciones as $idx => [$grado, $seccion, $anioBase]) {

            for ($i = 1; $i <= 25; $i++) {

                $esFemenino = ($i % 2 === 0);
                $sexo       = $esFemenino ? 'femenino' : 'masculino';

                $nombresPool = $esFemenino ? $this->nombres_f : $this->nombres_m;
                $nombre1     = $nombresPool[($i - 1) % count($nombresPool)];
                $nombre2     = $nombresPool[$i         % count($nombresPool)];

                $ap1 = $this->apellidos[(($idx * 25 + $i - 1)) % count($this->apellidos)];
                $ap2 = $this->apellidos[(($idx * 25 + $i + 15)) % count($this->apellidos)];

                // DNI: exactamente 13 dígitos
                $dni = str_pad($contador, 13, '0', STR_PAD_LEFT);

                $mes  = str_pad(($i % 12) + 1,  2, '0', STR_PAD_LEFT);
                $dia  = str_pad(($i % 28) + 1,  2, '0', STR_PAD_LEFT);
                $anio = $anioBase - ($i % 2);
                $fechaNacimiento = "{$anio}-{$mes}-{$dia}";

                // Email único: nombre.apellido{contador}@egm.edu.hn
                $email = $this->slug($nombre1) . '.' . $this->slug($ap1) . $contador . '@egm.edu.hn';

                $existe = DB::table('estudiantes')->where('dni', $dni)->exists();

                if (! $existe) {
                    // 1) Crear usuario en la tabla users
                    $userId = DB::table('users')->insertGetId([
                        'name'              => "{$nombre1} {$nombre2} {$ap1} {$ap2}",
                        'email'             => $email,
                        'password'          => Hash::make('Alumno2025!'),
                        'user_type'         => 'estudiante',
                        'id_rol'            => $estudianteRolId,
                        'activo'            => true,
                        'is_super_admin'    => false,
                        'is_protected'      => false,
                        'email_verified_at' => $now,
                        'created_at'        => $now,
                        'updated_at'        => $now,
                    ]);

                    // 2) Insertar el estudiante vinculado al usuario
                    DB::table('estudiantes')->insert([
                        'nombre1'          => $nombre1,
                        'nombre2'          => $nombre2,
                        'apellido1'        => $ap1,
                        'apellido2'        => $ap2,
                        'dni'              => $dni,
                        'fecha_nacimiento' => $fechaNacimiento,
                        'sexo'             => $sexo,
                        'email'            => $email,
                        'grado'            => $grado,
                        'seccion'          => $seccion,
                        'estado'           => 'activo',
                        'padre_id'         => null,
                        'user_id'          => $userId,
                        'created_at'       => $now,
                        'updated_at'       => $now,
                    ]);

                    $insertados++;
                } else {
                    $omitidos++;
                }

                $contador++;
            }

            $this->command->line("  ✔ {$grado} — Sección {$seccion} completada");
        }

        $this->command->info("✅ {$insertados} estudiantes insertados.");
        $this->command->info("✅ {$insertados} usuarios creados para los estudiantes.");
        if ($omitidos > 0) {
            $this->command->warn("⚠️  {$omitidos} omitidos (DNI ya existía).");
        }
        $this->command->info("📊 Secciones: " . count($secciones) . " | Total esperado: " . (count($secciones) * 25));
        $this->command->line('');
        $this->command->line('  Contraseña por defecto : Alumno2025!');
        $this->command->line('  Formato de correos     : nombre.apellido{N}@egm.edu.hn');
        $this->command->line('');
        $this->command->warn('⚠️  Recuerda actualizar los datos con la información real de los estudiantes.');
    }
}
