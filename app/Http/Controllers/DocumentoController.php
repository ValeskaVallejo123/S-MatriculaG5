<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    public function index()
    {
        $documentos = Documento::all();
        return view('Documentos.indexDocumento', compact('documentos'));
    }

    public function create()
    {
        return view('Documentos.createDocumento');
    }

    public function store(Request $request)
    {
        // Validación de datos y archivos
        $request->validate([
            'nombre_estudiante' => 'required|string|max:255',
            'acta_nacimiento'   => 'required|file|mimes:jpg,png,pdf|max:5120', // 5 MB
            'calificaciones'    => 'required|file|mimes:jpg,png,pdf|max:5120',
        ]);

        // Guardar archivos en carpetas separadas
        $actaPath = $request->file('acta_nacimiento')->store('documentos/actas', 'public');
        $calificacionesPath = $request->file('calificaciones')->store('documentos/calificaciones', 'public');

        Documento::create([
            'nombre_estudiante' => $request->nombre_estudiante,
            'acta_nacimiento'   => $actaPath,
            'calificaciones'    => $calificacionesPath,
        ]);

        return redirect()->route('documentos.index')->with('success', 'Documentos guardados correctamente.');
    }

    public function edit($id)
    {
        $documento = Documento::findOrFail($id);
        return view('Documentos.editDocumento', compact('documento'));
    }

    public function update(Request $request, $id)
    {
        $documento = Documento::findOrFail($id);

        // Validación: archivos opcionales pero con restricciones
        $request->validate([
            'nombre_estudiante' => 'required|string|max:255',
            'acta_nacimiento'   => 'nullable|file|mimes:jpg,png,pdf|max:5120',
            'calificaciones'    => 'nullable|file|mimes:jpg,png,pdf|max:5120',
            'acta_nacimiento' => 'required|file|mimes:jpg,png,pdf|max:5120', // 5 MB
            'calificaciones'  => 'required|file|mimes:jpg,png,pdf|max:5120',


        ]);

        // Actualizar acta si se sube un nuevo archivo
        if ($request->hasFile('acta_nacimiento')) {
            if ($documento->acta_nacimiento) {
                Storage::disk('public')->delete($documento->acta_nacimiento);
            }
            $documento->acta_nacimiento = $request->file('acta_nacimiento')->store('documentos/actas', 'public');
        }

        // Actualizar calificaciones si se sube un nuevo archivo
        if ($request->hasFile('calificaciones')) {
            if ($documento->calificaciones) {
                Storage::disk('public')->delete($documento->calificaciones);
            }
            $documento->calificaciones = $request->file('calificaciones')->store('documentos/calificaciones', 'public');
        }

        $documento->nombre_estudiante = $request->nombre_estudiante;
        $documento->save();

        return redirect()->route('documentos.index')->with('success', 'Documentos actualizados correctamente.');
    }

    public function destroy($id)
    {
        $documento = Documento::findOrFail($id);

        // Eliminar archivos del storage
        Storage::disk('public')->delete([$documento->acta_nacimiento, $documento->calificaciones]);
        $documento->delete();

        return redirect()->route('documentos.index')->with('success', 'Documentos eliminados correctamente.');
    }
}






















