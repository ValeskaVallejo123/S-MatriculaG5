<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PadresSeeder extends Seeder
{
    /**
     * 30 padres vinculados a 30 estudiantes diferentes
     * CEB Gabriela Mistral — Año 2026
     *
     * ⚠️  DNI ficticios de 13 dígitos. Reemplaza con datos reales.
     * El proceso:
     *   1. Crea el padre en tabla 'padres'
     *   2. Actualiza padre_id en el estudiante correspondiente
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Tomamos 30 estudiantes que NO tienen padre asignado aún
        $estudiantes = DB::table('estudiantes')
            ->whereNull('padre_id')
            ->limit(30)
            ->get();

        if ($estudiantes->count() < 30) {
            $this->command->warn("⚠️  Solo hay {$estudiantes->count()} estudiantes sin padre. Se crearán {$estudiantes->count()} padres.");
        }

        $padres = [
            // ── 1 ─────────────────────────────────────────────────────
            ['nombre'=>'Roberto',    'apellido'=>'Martínez Reyes',   'dni'=>'0801198000001', 'parentesco'=>'padre',      'telefono'=>'+50499100001', 'correo'=>'roberto.martinez@gmail.com',  'direccion'=>'Col. Las Flores, Danlí',          'ocupacion'=>'Agricultor'],
            // ── 2 ─────────────────────────────────────────────────────
            ['nombre'=>'Carmen',     'apellido'=>'López Fuentes',     'dni'=>'0801198200002', 'parentesco'=>'madre',      'telefono'=>'+50499100002', 'correo'=>'carmen.lopez@gmail.com',      'direccion'=>'Barrio El Centro, Danlí',          'ocupacion'=>'Comerciante'],
            // ── 3 ─────────────────────────────────────────────────────
            ['nombre'=>'Miguel',     'apellido'=>'González Pérez',    'dni'=>'0801197900003', 'parentesco'=>'padre',      'telefono'=>'+50499100003', 'correo'=>null,                          'direccion'=>'Col. La Esperanza, Danlí',         'ocupacion'=>'Ganadero'],
            // ── 4 ─────────────────────────────────────────────────────
            ['nombre'=>'Ana',        'apellido'=>'Rodríguez Molina',  'dni'=>'0801198500004', 'parentesco'=>'madre',      'telefono'=>'+50499100004', 'correo'=>'ana.rodriguez@hotmail.com',   'direccion'=>'Barrio San José, Danlí',           'ocupacion'=>'Maestra'],
            // ── 5 ─────────────────────────────────────────────────────
            ['nombre'=>'Jorge',      'apellido'=>'Hernández Cruz',    'dni'=>'0801198100005', 'parentesco'=>'padre',      'telefono'=>'+50499100005', 'correo'=>null,                          'direccion'=>'Col. San Juan, Danlí',             'ocupacion'=>'Conductor'],
            // ── 6 ─────────────────────────────────────────────────────
            ['nombre'=>'Sandra',     'apellido'=>'Morales Aguilar',   'dni'=>'0801198400006', 'parentesco'=>'madre',      'telefono'=>'+50499100006', 'correo'=>'sandra.morales@gmail.com',    'direccion'=>'Barrio El Calvario, Danlí',        'ocupacion'=>'Enfermera'],
            // ── 7 ─────────────────────────────────────────────────────
            ['nombre'=>'Luis',       'apellido'=>'Torres Vega',       'dni'=>'0801197800007', 'parentesco'=>'padre',      'telefono'=>'+50499100007', 'correo'=>null,                          'direccion'=>'Aldea El Paraíso, Danlí',          'ocupacion'=>'Albañil'],
            // ── 8 ─────────────────────────────────────────────────────
            ['nombre'=>'María',      'apellido'=>'Ramírez Soto',      'dni'=>'0801198600008', 'parentesco'=>'madre',      'telefono'=>'+50499100008', 'correo'=>'maria.ramirez@gmail.com',     'direccion'=>'Col. Divina Providencia, Danlí',   'ocupacion'=>'Secretaria'],
            // ── 9 ─────────────────────────────────────────────────────
            ['nombre'=>'Carlos',     'apellido'=>'Flores Mendoza',    'dni'=>'0801198300009', 'parentesco'=>'padre',      'telefono'=>'+50499100009', 'correo'=>null,                          'direccion'=>'Barrio La Concordia, Danlí',       'ocupacion'=>'Mecánico'],
            // ── 10 ────────────────────────────────────────────────────
            ['nombre'=>'Patricia',   'apellido'=>'Castro Ríos',       'dni'=>'0801198700010', 'parentesco'=>'madre',      'telefono'=>'+50499100010', 'correo'=>'patricia.castro@yahoo.com',   'direccion'=>'Col. Las Brisas, Danlí',           'ocupacion'=>'Contadora'],
            // ── 11 ────────────────────────────────────────────────────
            ['nombre'=>'Héctor',     'apellido'=>'Vargas Jiménez',    'dni'=>'0801197700011', 'parentesco'=>'padre',      'telefono'=>'+50499100011', 'correo'=>null,                          'direccion'=>'Barrio El Porvenir, Danlí',        'ocupacion'=>'Carpintero'],
            // ── 12 ────────────────────────────────────────────────────
            ['nombre'=>'Rosa',       'apellido'=>'Espinoza Gutiérrez','dni'=>'0801198800012', 'parentesco'=>'madre',      'telefono'=>'+50499100012', 'correo'=>'rosa.espinoza@gmail.com',     'direccion'=>'Col. La Ceiba, Danlí',             'ocupacion'=>'Cocinera'],
            // ── 13 ────────────────────────────────────────────────────
            ['nombre'=>'Óscar',      'apellido'=>'Sandoval Paredes',  'dni'=>'0801198000013', 'parentesco'=>'padre',      'telefono'=>'+50499100013', 'correo'=>null,                          'direccion'=>'Barrio San Miguel, Danlí',         'ocupacion'=>'Electricista'],
            // ── 14 ────────────────────────────────────────────────────
            ['nombre'=>'Gabriela',   'apellido'=>'Núñez Barrera',     'dni'=>'0801198900014', 'parentesco'=>'madre',      'telefono'=>'+50499100014', 'correo'=>'gabriela.nunez@gmail.com',    'direccion'=>'Col. El Carmen, Danlí',            'ocupacion'=>'Vendedora'],
            // ── 15 ────────────────────────────────────────────────────
            ['nombre'=>'Ricardo',    'apellido'=>'Mejía Serrano',     'dni'=>'0801197600015', 'parentesco'=>'padre',      'telefono'=>'+50499100015', 'correo'=>null,                          'direccion'=>'Aldea Los Planes, Danlí',          'ocupacion'=>'Agricultor'],
            // ── 16 ────────────────────────────────────────────────────
            ['nombre'=>'Elena',      'apellido'=>'Zelaya Lagos',      'dni'=>'0801199000016', 'parentesco'=>'madre',      'telefono'=>'+50499100016', 'correo'=>'elena.zelaya@hotmail.com',    'direccion'=>'Barrio El Estadio, Danlí',         'ocupacion'=>'Costurera'],
            // ── 17 ────────────────────────────────────────────────────
            ['nombre'=>'Manuel',     'apellido'=>'Pacheco Velásquez', 'dni'=>'0801197500017', 'parentesco'=>'padre',      'telefono'=>'+50499100017', 'correo'=>null,                          'direccion'=>'Col. Los Pinos, Danlí',            'ocupacion'=>'Zapatero'],
            // ── 18 ────────────────────────────────────────────────────
            ['nombre'=>'Claudia',    'apellido'=>'Campos Murillo',    'dni'=>'0801198800018', 'parentesco'=>'madre',      'telefono'=>'+50499100018', 'correo'=>'claudia.campos@gmail.com',    'direccion'=>'Barrio El Progreso, Danlí',        'ocupacion'=>'Doctora'],
            // ── 19 ────────────────────────────────────────────────────
            ['nombre'=>'Pablo',      'apellido'=>'Rivas Bautista',    'dni'=>'0801197400019', 'parentesco'=>'tutor_legal','telefono'=>'+50499100019', 'correo'=>null,                          'direccion'=>'Col. Nueva Esperanza, Danlí',      'ocupacion'=>'Abogado'],
            // ── 20 ────────────────────────────────────────────────────
            ['nombre'=>'Diana',      'apellido'=>'Ortiz Mendoza',     'dni'=>'0801199100020', 'parentesco'=>'madre',      'telefono'=>'+50499100020', 'correo'=>'diana.ortiz@gmail.com',       'direccion'=>'Barrio San Francisco, Danlí',      'ocupacion'=>'Enfermera'],
            // ── 21 ────────────────────────────────────────────────────
            ['nombre'=>'Iván',       'apellido'=>'Cruz García',       'dni'=>'0801197300021', 'parentesco'=>'padre',      'telefono'=>'+50499100021', 'correo'=>null,                          'direccion'=>'Aldea Las Mercedes, Danlí',        'ocupacion'=>'Ganadero'],
            // ── 22 ────────────────────────────────────────────────────
            ['nombre'=>'Karla',      'apellido'=>'Aguilar Torres',    'dni'=>'0801199200022', 'parentesco'=>'madre',      'telefono'=>'+50499100022', 'correo'=>'karla.aguilar@yahoo.com',     'direccion'=>'Col. Kennedy, Danlí',              'ocupacion'=>'Maestra'],
            // ── 23 ────────────────────────────────────────────────────
            ['nombre'=>'David',      'apellido'=>'Morales López',     'dni'=>'0801197200023', 'parentesco'=>'padre',      'telefono'=>'+50499100023', 'correo'=>null,                          'direccion'=>'Barrio La Trinidad, Danlí',        'ocupacion'=>'Conductor'],
            // ── 24 ────────────────────────────────────────────────────
            ['nombre'=>'Fernanda',   'apellido'=>'Reyes Hernández',   'dni'=>'0801199300024', 'parentesco'=>'madre',      'telefono'=>'+50499100024', 'correo'=>'fernanda.reyes@gmail.com',    'direccion'=>'Col. Los Almendros, Danlí',        'ocupacion'=>'Abogada'],
            // ── 25 ────────────────────────────────────────────────────
            ['nombre'=>'Alejandro',  'apellido'=>'Vega Ramírez',      'dni'=>'0801197100025', 'parentesco'=>'padre',      'telefono'=>'+50499100025', 'correo'=>null,                          'direccion'=>'Barrio El Bosque, Danlí',          'ocupacion'=>'Ingeniero'],
            // ── 26 ────────────────────────────────────────────────────
            ['nombre'=>'Mónica',     'apellido'=>'Molina Espinoza',   'dni'=>'0801199400026', 'parentesco'=>'madre',      'telefono'=>'+50499100026', 'correo'=>'monica.molina@gmail.com',     'direccion'=>'Col. La Paz, Danlí',               'ocupacion'=>'Contadora'],
            // ── 27 ────────────────────────────────────────────────────
            ['nombre'=>'Josué',      'apellido'=>'Gutiérrez Fuentes', 'dni'=>'0801197000027', 'parentesco'=>'padre',      'telefono'=>'+50499100027', 'correo'=>null,                          'direccion'=>'Barrio El Mirador, Danlí',         'ocupacion'=>'Policía'],
            // ── 28 ────────────────────────────────────────────────────
            ['nombre'=>'Paola',      'apellido'=>'Soto Vargas',       'dni'=>'0801199500028', 'parentesco'=>'madre',      'telefono'=>'+50499100028', 'correo'=>'paola.soto@hotmail.com',      'direccion'=>'Col. Las Palmas, Danlí',           'ocupacion'=>'Secretaria'],
            // ── 29 ────────────────────────────────────────────────────
            ['nombre'=>'Erick',      'apellido'=>'Jiménez Sandoval',  'dni'=>'0801196900029', 'parentesco'=>'padre',      'telefono'=>'+50499100029', 'correo'=>null,                          'direccion'=>'Barrio El Reparto, Danlí',         'ocupacion'=>'Técnico'],
            // ── 30 ────────────────────────────────────────────────────
            ['nombre'=>'Andrea',     'apellido'=>'Barrera Núñez',     'dni'=>'0801199600030', 'parentesco'=>'madre',      'telefono'=>'+50499100030', 'correo'=>'andrea.barrera@gmail.com',    'direccion'=>'Col. Villa Real, Danlí',           'ocupacion'=>'Profesora'],
        ];

        $insertados = 0;
        $omitidos   = 0;

        foreach ($estudiantes as $index => $estudiante) {
            if (!isset($padres[$index])) break;

            $datosPadre = $padres[$index];

            // Verificar que el DNI no exista ya
            $existe = DB::table('padres')->where('dni', $datosPadre['dni'])->exists();

            if ($existe) {
                $omitidos++;
                continue;
            }

            // 1. Insertar el padre
            $padreId = DB::table('padres')->insertGetId([
                'nombre'             => $datosPadre['nombre'],
                'apellido'           => $datosPadre['apellido'],
                'dni'                => $datosPadre['dni'],
                'parentesco'         => $datosPadre['parentesco'],
                'parentesco_otro'    => null,
                'correo'             => $datosPadre['correo'],
                'telefono'           => $datosPadre['telefono'],
                'telefono_secundario'=> null,
                'direccion'          => $datosPadre['direccion'],
                'ocupacion'          => $datosPadre['ocupacion'],
                'observaciones'      => null,
                'created_at'         => $now,
                'updated_at'         => $now,
            ]);

            // 2. Vincular al estudiante
            DB::table('estudiantes')
                ->where('id', $estudiante->id)
                ->update([
                    'padre_id'   => $padreId,
                    'updated_at' => $now,
                ]);

            $this->command->line(
                "  ✔ {$datosPadre['nombre']} {$datosPadre['apellido']} → " .
                "{$estudiante->nombre1} {$estudiante->apellido1} " .
                "({$estudiante->grado} {$estudiante->seccion})"
            );

            $insertados++;
        }

        $this->command->info("✅ {$insertados} padres insertados y vinculados correctamente.");
        if ($omitidos > 0) {
            $this->command->warn("⚠️  {$omitidos} omitidos (DNI ya existía).");
        }
    }
}
