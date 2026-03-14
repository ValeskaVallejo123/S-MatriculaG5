<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;

class HistorialController extends Controller
{
    /**
     * Muestra el historial académico (Vista SHOW)
     */
    public function showHistorial($id)
    {
        $user = auth()->user();

        // Seguridad: El estudiante solo ve lo suyo, el SuperAdmin (rol 1) ve todo
        if ($user->id_rol == 3 && $user->id != $id) {
            abort(403, 'Solo puedes consultar tu propio historial académico.');
        }

        $estudiante = Estudiante::with([
            'calificaciones.materia',
            'calificaciones.periodo',
            'matriculas.seccion'
        ])->findOrFail($id);

        $promedio = $estudiante->calificaciones->avg('nota_final') ?? 0;

        $historialAgrupado = $estudiante->calificaciones->groupBy(function($nota) {
            return $nota->periodo->anio_lectivo ?? 'Ciclo Actual';
        });

        // NOTA: Para el SuperAdmin podrías usar una vista diferente o la misma con botones extra
        return view('historial.show', compact('estudiante', 'historialAgrupado', 'promedio'));
    }

    /**
     * Formulario para EDITAR el historial (Vista EDIT)
     */
    public function editHistorial($id)
    {
        // Solo el SuperAdmin debería entrar aquí
        $estudiante = Estudiante::with(['calificaciones.materia', 'calificaciones.periodo'])->findOrFail($id);

        return view('historial.edit', compact('estudiante'));
    }

    /**
     * Guarda los cambios realizados (Acción UPDATE)
     */
    public function updateHistorial(Request $request, $id)
    {
        // Si el estudiante no tiene materias, 'notas' no llegará en el request.
        // Cambiamos 'required' por 'nullable' para que no explote si está vacío.
        $request->validate([
            'notas' => 'nullable|array',
            'notas.*.p1' => 'nullable|numeric|min:0|max:100',
            'notas.*.p2' => 'nullable|numeric|min:0|max:100',
            'notas.*.p3' => 'nullable|numeric|min:0|max:100',
        ]);

        try {
            $cambiosRealizados = false;

            // Si hay notas, las procesamos
            if ($request->has('notas')) {
                foreach ($request->notas as $notaId => $datos) {
                    $calificacion = \App\Models\Calificacion::findOrFail($notaId);

                    $p1 = (float)($datos['p1'] ?? 0);
                    $p2 = (float)($datos['p2'] ?? 0);
                    $p3 = (float)($datos['p3'] ?? 0);
                    $nuevaNotaFinal = ($p1 + $p2 + $p3) / 3;

                    if (
                        (float)$calificacion->primer_parcial !== $p1 ||
                        (float)$calificacion->segundo_parcial !== $p2 ||
                        (float)$calificacion->tercer_parcial !== $p3
                    ) {
                        $calificacion->update([
                            'primer_parcial'  => $p1,
                            'segundo_parcial' => $p2,
                            'tercer_parcial'  => $p3,
                            'nota_final'      => $nuevaNotaFinal,
                        ]);
                        $cambiosRealizados = true;
                    }
                }
            }

            // Si no hubo cambios (porque las notas eran iguales O porque no había notas que editar)
            if (!$cambiosRealizados) {
                return redirect('/estudiantes')
                    ->with('info', 'No se realizaron cambios (el estudiante no tiene materias o las notas son idénticas).');
            }

            return redirect()
                ->route('superadmin.estudiantes.historial.show', $id)
                ->with('success', 'Historial académico actualizado correctamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al procesar: ' . $e->getMessage());
        }
    }
}
