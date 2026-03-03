<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// CORRECCIÓN: el original importaba Documento y Estudiante DOS VECES,
// lo que causa un error fatal de PHP "Cannot redeclare use statement".
// También importaba Storage que faltaba en el original incompleto.

class DocumentoController extends Controller
{
    /**
     * Mostrar formulario de creación de documentos para un estudiante.
     *
     * CORRECCIÓN: el original recibía $estudiante_id como parámetro de ruta
     * pero la ruta en web.php pasa el parámetro como query string
     * (?estudiante_id=X) desde el botón "Subir Documentos" del show.
     * Se acepta ambas formas para mayor compatibilidad.
     */
    public function create(Request $request, $estudiante_id = null)
    {
        $id = $estudiante_id ?? $request->query('estudiante_id');

        if (!$id) {
            return redirect()->route('estudiantes.index')
                ->with('error', 'Debe especificar un estudiante.');
        }

        $estudiante = Estudiante::findOrFail($id);

        // Evitar crear documentos duplicados si ya tiene
        if ($estudiante->documentos) {
            return redirect()->route('documentos.edit', $estudiante->documentos->id)
                ->with('error', 'Este estudiante ya tiene documentos registrados. Puede editarlos aquí.');
        }

        return view('Documentos.createDocumento', compact('estudiante'));
    }

    /**
     * Guardar nuevos documentos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'estudiante_id'           => 'required|exists:estudiantes,id',
            'foto'                    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'acta_nacimiento'         => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'calificaciones'          => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'tarjeta_identidad_padre' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'constancia_medica'       => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        // CORRECCIÓN: verificar que el estudiante no tenga ya documentos
        // para evitar duplicados (la tabla tiene unique en estudiante_id)
        $yaExiste = Documento::where('estudiante_id', $request->estudiante_id)->exists();
        if ($yaExiste) {
            return redirect()
                ->route('estudiantes.show', $request->estudiante_id)
                ->with('error', 'Este estudiante ya tiene documentos registrados.');
        }

        Documento::create([
            'estudiante_id'           => $request->estudiante_id,
            'foto'                    => $request->file('foto')
                                            ?->store('documentos/foto', 'public'),
            'acta_nacimiento'         => $request->file('acta_nacimiento')
                                            ->store('documentos/actas', 'public'),
            'calificaciones'          => $request->file('calificaciones')
                                            ->store('documentos/calificaciones', 'public'),
            'tarjeta_identidad_padre' => $request->file('tarjeta_identidad_padre')
                                            ?->store('documentos/padres', 'public'),
            'constancia_medica'       => $request->file('constancia_medica')
                                            ?->store('documentos/medicas', 'public'),
        ]);

        return redirect()
            ->route('estudiantes.show', $request->estudiante_id)
            ->with('success', 'Documentos subidos correctamente.');
    }

    /**
     * Mostrar documentos de un estudiante.
     */
    public function show($id)
    {
        $documento = Documento::with('estudiante')->findOrFail($id);

        return view('Documentos.showDocumento', compact('documento'));
    }

    /**
     * Mostrar formulario de edición.
     *
     * CORRECCIÓN: el original cargaba Estudiante::all() para un select
     * que no tiene sentido en edición de documentos — los documentos
     * pertenecen a UN estudiante fijo y no se puede reasignar.
     * Se carga solo el estudiante relacionado.
     */
    public function edit($id)
    {
        $documento = Documento::with('estudiante')->findOrFail($id);

        return view('Documentos.editDocumento', compact('documento'));
    }

    /**
     * Actualizar documentos — reemplaza archivos solo si se sube uno nuevo.
     */
    public function update(Request $request, $id)
    {
        $documento = Documento::findOrFail($id);

        $request->validate([
            'foto'                    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'acta_nacimiento'         => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'calificaciones'          => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'tarjeta_identidad_padre' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'constancia_medica'       => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        // Carpetas por campo para organización en storage
        $carpetas = [
            'foto'                    => 'documentos/foto',
            'acta_nacimiento'         => 'documentos/actas',
            'calificaciones'          => 'documentos/calificaciones',
            'tarjeta_identidad_padre' => 'documentos/padres',
            'constancia_medica'       => 'documentos/medicas',
        ];

        foreach ($carpetas as $campo => $carpeta) {
            if ($request->hasFile($campo)) {
                // Eliminar archivo anterior si existe
                if ($documento->$campo && Storage::disk('public')->exists($documento->$campo)) {
                    Storage::disk('public')->delete($documento->$campo);
                }
                $documento->$campo = $request->file($campo)->store($carpeta, 'public');
            }
        }

        $documento->save();

        return redirect()
            ->route('estudiantes.show', $documento->estudiante_id)
            ->with('success', 'Documentos actualizados correctamente.');
    }

    /**
     * Eliminar todos los documentos de un estudiante.
     */
    public function destroy($id)
    {
        $documento = Documento::findOrFail($id);

        $campos = [
            'foto',
            'acta_nacimiento',
            'calificaciones',
            'tarjeta_identidad_padre',
            'constancia_medica',
        ];

        // Eliminar archivos físicos del storage
        foreach ($campos as $campo) {
            if ($documento->$campo && Storage::disk('public')->exists($documento->$campo)) {
                Storage::disk('public')->delete($documento->$campo);
            }
        }

        $estudianteId = $documento->estudiante_id;
        $documento->delete();

        return redirect()
            ->route('estudiantes.show', $estudianteId)
            ->with('success', 'Documentos eliminados correctamente.');
    }
}


