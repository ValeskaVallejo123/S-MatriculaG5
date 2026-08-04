<?php
// ── Reemplaza solo estos dos métodos en EstudianteController.php ──────────────

/* ============================================================
   HISTORIAL — FORMULARIO DE EDICIÓN (Admin)
============================================================ */
public function editHistorialAdmin($id)
{
    $estudiante = Estudiante::with([
        'calificaciones.materia',
        'calificaciones.periodo',
    ])->findOrFail($id);

    return view('historial.edit', compact('estudiante'));
}

/* ============================================================
   HISTORIAL — GUARDAR CAMBIOS (Admin)
============================================================ */
public function updateHistorialAdmin(Request $request, $id)
{
    $estudiante = Estudiante::findOrFail($id);

    $request->validate([
        'notas'              => ['required', 'array'],
        'notas.*.nota_tarea'   => ['nullable', 'numeric', 'min:0', 'max:100'],
        'notas.*.nota_parcial' => ['nullable', 'numeric', 'min:0', 'max:100'],
        'notas.*.nota_final'   => ['nullable', 'numeric', 'min:0', 'max:100'],
    ], [
        'notas.required'               => 'Debes enviar al menos una nota.',
        'notas.*.nota_tarea.numeric'   => 'La nota de tarea debe ser un número.',
        'notas.*.nota_parcial.numeric' => 'La nota parcial debe ser un número.',
        'notas.*.nota_final.numeric'   => 'La nota final debe ser un número.',
        'notas.*.nota_tarea.min'       => 'Las notas no pueden ser menores a 0.',
        'notas.*.nota_tarea.max'       => 'Las notas no pueden ser mayores a 100.',
        'notas.*.nota_parcial.min'     => 'Las notas no pueden ser menores a 0.',
        'notas.*.nota_parcial.max'     => 'Las notas no pueden ser mayores a 100.',
        'notas.*.nota_final.min'       => 'Las notas no pueden ser menores a 0.',
        'notas.*.nota_final.max'       => 'Las notas no pueden ser mayores a 100.',
    ]);

    $cambiosRealizados = false;

    foreach ($request->notas as $calificacionId => $valores) {
        if (!ctype_digit((string) $calificacionId)) continue;

        $calificacion = Calificacion::find((int) $calificacionId);

        if (!$calificacion || $calificacion->estudiante_id != $estudiante->id) continue;

        $notaTarea   = isset($valores['nota_tarea'])   && $valores['nota_tarea']   !== '' ? (float) $valores['nota_tarea']   : null;
        $notaParcial = isset($valores['nota_parcial']) && $valores['nota_parcial'] !== '' ? (float) $valores['nota_parcial'] : null;
        $notaFinal   = isset($valores['nota_final'])   && $valores['nota_final']   !== '' ? (float) $valores['nota_final']   : null;

        if (
            $calificacion->nota_tarea   != $notaTarea   ||
            $calificacion->nota_parcial != $notaParcial ||
            $calificacion->nota_final   != $notaFinal
        ) {
            // El modelo recalcula promedio y estado automáticamente en el evento saving()
            $calificacion->nota_tarea   = $notaTarea;
            $calificacion->nota_parcial = $notaParcial;
            $calificacion->nota_final   = $notaFinal;
            $calificacion->save();

            $cambiosRealizados = true;
        }
    }

    if ($cambiosRealizados) {
        return redirect()
            ->route('superadmin.estudiantes.historial.show', $id)
            ->with('success', 'Calificaciones actualizadas correctamente.');
    }

    return redirect()
        ->route('superadmin.estudiantes.historial.show', $id)
        ->with('info', 'No se realizaron cambios en el historial académico.');
}