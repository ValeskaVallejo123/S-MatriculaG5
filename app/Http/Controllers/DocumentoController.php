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
            'foto'            => 'nullable|image|mimes:jpg,png|max:5120',
            'acta_nacimiento' => 'required|file|mimes:jpg,png,pdf|max:5120',
            'calificaciones'  => 'required|file|mimes:jpg,png,pdf|max:5120',
        ]);

        $archivos = [
            'foto'            => $request->file('foto')?->store('documentos/foto', 'public'),
            'acta_nacimiento' => $request->file('acta_nacimiento')->store('documentos/actas', 'public'),
            'calificaciones'  => $request->file('calificaciones')->store('documentos/calificaciones', 'public'),
        ];

        Documento::create($archivos);

        return redirect()->route('documentos.index')
                         ->with('success', 'Documentos guardados correctamente.');
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
            'foto'            => 'nullable|image|mimes:jpg,png|max:5120',
            'acta_nacimiento' => 'nullable|file|mimes:jpg,png,pdf|max:5120',
            'calificaciones'  => 'nullable|file|mimes:jpg,png,pdf|max:5120',
        ]);

        $campos = ['foto', 'acta_nacimiento', 'calificaciones'];

        foreach ($campos as $campo) {
            if ($request->hasFile($campo)) {
                if (!empty($documento->$campo) && Storage::disk('public')->exists($documento->$campo)) {
                    Storage::disk('public')->delete($documento->$campo);
                }
                $documento->$campo = $request->file($campo)->store("documentos/{$campo}", 'public');
            }
        }

        $documento->save();

        return redirect()->route('documentos.index')
                         ->with('success', 'Documentos actualizados correctamente.');
    }

    public function destroy($id)
    {
        $documento = Documento::findOrFail($id);

        foreach (['foto', 'acta_nacimiento', 'calificaciones'] as $campo) {
            if (!empty($documento->$campo) && Storage::disk('public')->exists($documento->$campo)) {
                Storage::disk('public')->delete($documento->$campo);
            }
        }

        $documento->delete();

        return redirect()->route('documentos.index')
                         ->with('success', 'Documentos eliminados correctamente.');
    }
}
