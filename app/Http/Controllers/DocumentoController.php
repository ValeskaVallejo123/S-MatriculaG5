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
            'foto'              => 'nullable|image|mimes:jpg,png|max:5120',
            'acta_nacimiento'   => 'required|file|mimes:jpg,png,pdf|max:5120',
            'calificaciones'    => 'required|file|mimes:jpg,png,pdf|max:5120',
        ]);

        $fotoPath = $request->hasFile('foto') ? $request->file('foto')->store('documentos/foto', 'public') : null;
        $actaPath = $request->file('acta_nacimiento')->store('documentos/actas', 'public');
        $calificacionesPath = $request->file('calificaciones')->store('documentos/calificaciones', 'public');

        Documento::create([
            'nombre_estudiante' => $request->nombre_estudiante,
            'foto'              => $fotoPath,
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

        $request->validate([
            'nombre_estudiante' => 'required|string|max:255',
            'foto'              => 'nullable|image|mimes:jpg,png|max:5120',
            'acta_nacimiento'   => 'nullable|file|mimes:jpg,png,pdf|max:5120',
            'calificaciones'    => 'nullable|file|mimes:jpg,png,pdf|max:5120',
        ]);

        if ($request->hasFile('foto')) {
            if (!empty($documento->foto) && Storage::disk('public')->exists($documento->foto)) {
                Storage::disk('public')->delete($documento->foto);
            }
            $documento->foto = $request->file('foto')->store('documentos/foto', 'public');
        }

        if ($request->hasFile('acta_nacimiento')) {
            if (!empty($documento->acta_nacimiento) && Storage::disk('public')->exists($documento->acta_nacimiento)) {
                Storage::disk('public')->delete($documento->acta_nacimiento);
            }
            $documento->acta_nacimiento = $request->file('acta_nacimiento')->store('documentos/actas', 'public');
        }

        if ($request->hasFile('calificaciones')) {
            if (!empty($documento->calificaciones) && Storage::disk('public')->exists($documento->calificaciones)) {
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

        // Lista de archivos a eliminar
        $archivos = [
            'foto' => $documento->foto,
            'acta_nacimiento' => $documento->acta_nacimiento,
            'calificaciones' => $documento->calificaciones,
        ];

        foreach ($archivos as $tipo => $archivo) {
            if (!empty($archivo) && Storage::disk('public')->exists($archivo)) {
                Storage::disk('public')->delete($archivo);
            }
        }

        $documento->delete();

        return redirect()->route('documentos.index')->with('success', 'Documentos eliminados correctamente.');
    }
}
























