<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;

class HistorialController extends Controller
{
    /**
     * Muestra el historial académico de un estudiante específico.
     */
    public function show($id)
    {
        $user = auth()->user();

        // Seguridad: El estudiante solo ve lo suyo
        if ($user->id_rol == 3 && $user->estudiante_id != $id) {
            abort(403, 'Solo puedes consultar tu propio historial académico.');
        }

        /** * CARGA AUTOMÁTICA:
         * Usamos 'with' para traer las calificaciones, las materias y el periodo
         * de un solo golpe desde las tablas que creaste.
         */
        $estudiante = Estudiante::with([
            'calificaciones.materia',
            'calificaciones.periodo',
            'matriculas.seccion'
        ])->findOrFail($id);

        // El promedio se calcula solo de la columna 'nota_final' de tu tabla calificaciones
        $promedio = $estudiante->calificaciones->avg('nota_final') ?? 0;

        /**
         * Agrupamos por Año Lectivo automáticamente usando la relación
         * con la tabla periodos_academicos.
         */
        $historialAgrupado = $estudiante->calificaciones->groupBy(function($nota) {
            return $nota->periodo->anio_lectivo ?? 'Ciclo Actual';
        });

        return view('historial.show', compact('estudiante', 'historialAgrupado', 'promedio'));
    }
}
