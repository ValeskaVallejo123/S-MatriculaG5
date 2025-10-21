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
        $request->validate([
            'nombre_estudiante' => 'required|string|max:255',
            'acta_nacimiento' => 'required|mimes:png,jpg,pdf|max:5120',
            'calificaciones' => 'required|mimes:png,jpg,pdf|max:5120',
        ]);

        // Guardar archivos en carpetas separadas dentro de /storage/app/public/documentos/
        $actaPath = $request->file('acta_nacimiento')->store('documentos/actas', 'public');
        $calificacionesPath = $request->file('calificaciones')->store('documentos/calificaciones', 'public');

        Documento::create([
            'nombre_estudiante' => $request->nombre_estudiante,
            'acta_nacimiento' => $actaPath,
            'calificaciones' => $calificacionesPath,
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

        $request->validate([
            'nombre_estudiante' => 'required|string|max:255',
            'acta_nacimiento' => 'nullable|mimes:png,jpg,pdf|max:5120',
            'calificaciones' => 'nullable|mimes:png,jpg,pdf|max:5120',
        ]);

        // Si se sube una nueva acta, eliminar la anterior y guardar la nueva
        if ($request->hasFile('acta_nacimiento')) {
            Storage::disk('public')->delete($documento->acta_nacimiento);
            $documento->acta_nacimiento = $request->file('acta_nacimiento')->store('documentos/actas', 'public');
        }

        // Si se suben nuevas calificaciones, eliminar las anteriores y guardar las nuevas
        if ($request->hasFile('calificaciones')) {
            Storage::disk('public')->delete($documento->calificaciones);
            $documento->calificaciones = $request->file('calificaciones')->store('documentos/calificaciones', 'public');
        }

        $documento->nombre_estudiante = $request->nombre_estudiante;
        $documento->save();

        return redirect()->route('documentos.index')->with('success', 'Documentos actualizados correctamente.');
    }

    public function destroy($id)
    {
        $documento = Documento::findOrFail($id);

        Storage::disk('public')->delete([$documento->acta_nacimiento, $documento->calificaciones]);
        $documento->delete();

        return redirect()->route('documentos.index')->with('success', 'Documentos eliminados correctamente.');
    }
}





















