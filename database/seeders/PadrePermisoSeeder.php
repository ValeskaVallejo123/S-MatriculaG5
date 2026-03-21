<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Padre;
use App\Models\Estudiante;
use App\Models\PadrePermiso;

class PadrePermisoSeeder extends Seeder
{
    /**
     * Ejecutar los seeders.
     *
     * Este seeder crea permisos de ejemplo para padres y estudiantes existentes
     */
    public function run(): void
    {
        // Obtener algunos padres y estudiantes de ejemplo
        $padres = Padre::take(5)->get();

        foreach ($padres as $padre) {
            // Obtener los estudiantes asociados a este padre
            $estudiantes = $padre->estudiantes;

            foreach ($estudiantes as $estudiante) {
                // Crear configuración de permisos con valores variados
                PadrePermiso::create([
                    'padre_id' => $padre->id,
                    'estudiante_id' => $estudiante->id,
                    'ver_calificaciones' => true,
                    'ver_asistencias' => true,
                    'comunicarse_profesores' => true,
                    'autorizar_salidas' => rand(0, 1) == 1, // Aleatorio
                    'modificar_datos_contacto' => false,
                    'ver_comportamiento' => true,
                    'descargar_boletas' => true,
                    'ver_tareas' => true,
                    'recibir_notificaciones' => true,
                    'notas_adicionales' => 'Configuración de permisos estándar'
                ]);
            }
        }

        $this->command->info(' Permisos de padres creados exitosamente.');
        $this->command->info('   Total de configuraciones: ' . PadrePermiso::count());
    }
}
