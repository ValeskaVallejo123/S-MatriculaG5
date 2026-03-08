<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documento;
use App\Models\Estudiante;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    /**
     * Muestra la lista de documentos con sus estudiantes relacionados.
     */
    public function index()
    {
        $documentos = Documento::with('estudiante')->get();
        return view('Documentos.indexDocumento', compact('documentos'));
    }

    /**
     * Muestra el formulario para crear un nuevo expediente.
     */
    public function create()
    {
        $estudiantes = Estudiante::all();
        return view('Documentos.createDocumento', compact('estudiantes'));
    }

    /**
     * Guarda el expediente y los archivos físicos en el storage.
     */
    public function store(Request $request)
    {
        // 1. Validación estricta de archivos y relación
        $request->validate([
            'estudiante_id'    => 'required|exists:estudiantes,id',
            'foto'             => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'acta_nacimiento'  => 'nullable|file|mimes:pdf,jpg,png|max:5120',
            'calificaciones'   => 'nullable|file|mimes:pdf,jpg,png|max:5120',
        ]);

        $documento = new Documento();
        $documento->estudiante_id = $request->estudiante_id;

        // 2. Procesamiento de archivos (Usa el disco 'public')
        if ($request->hasFile('foto')) {
            $documento->foto = $request->file('foto')->store('expedientes/fotos', 'public');
        }

        if ($request->hasFile('acta_nacimiento')) {
            $documento->acta_nacimiento = $request->file('acta_nacimiento')->store('expedientes/actas', 'public');
        }

        if ($request->hasFile('calificaciones')) {
            $documento->calificaciones = $request->file('calificaciones')->store('expedientes/notas', 'public');
        }

        $documento->save();

        return redirect()->route('documentos.index')
            ->with('success', 'Expediente creado y documentos guardados correctamente.');
    }

    /**
     * Muestra el formulario de edición.
     */
    public function edit($id)
    {
        $documento = Documento::findOrFail($id);
        $estudiantes = Estudiante::all();
        return view('Documentos.editDocumento', compact('documento', 'estudiantes'));
    }

    /**
     * Actualiza el expediente y reemplaza archivos si es necesario.
     */
    public function update(Request $request, $id)
    {
        $documento = Documento::findOrFail($id);

        $request->validate([
            'estudiante_id'    => 'required|exists:estudiantes,id',
            'foto'             => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'acta_nacimiento'  => 'nullable|file|mimes:pdf,jpg,png|max:5120',
            'calificaciones'   => 'nullable|file|mimes:pdf,jpg,png|max:5120',
        ]);

        $documento->estudiante_id = $request->estudiante_id;

        // Actualizar Foto (y eliminar la anterior para no llenar el servidor de basura)
        if ($request->hasFile('foto')) {
            if ($documento->foto) {
                Storage::disk('public')->delete($documento->foto);
            }
            $documento->foto = $request->file('foto')->store('expedientes/fotos', 'public');
        }

        // Actualizar Acta
        if ($request->hasFile('acta_nacimiento')) {
            if ($documento->acta_nacimiento) {
                Storage::disk('public')->delete($documento->acta_nacimiento);
            }
            $documento->acta_nacimiento = $request->file('acta_nacimiento')->store('expedientes/actas', 'public');
        }

        $documento->save();

        return redirect()->route('documentos.index')
            ->with('success', 'Expediente actualizado correctamente.');
    }

    /**
     * Elimina el registro y sus archivos físicos.
     */
    public function destroy($id)
    {
        $documento = Documento::findOrFail($id);

        // Borrar archivos del storage antes de eliminar el registro
        Storage::disk('public')->delete([
            $documento->foto,
            $documento->acta_nacimiento,
            $documento->calificaciones
        ]);

        $documento->delete();

        return redirect()->route('documentos.index')
            ->with('success', 'Expediente eliminado por completo.');
    }
}
