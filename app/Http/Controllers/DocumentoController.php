<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    public function create($estudiante_id)
    {
        $estudiante = Estudiante::findOrFail($estudiante_id);
        return view('Documentos.createDocumento', compact('estudiante'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'estudiante_id'           => 'required|exists:estudiantes,id',
            'foto'                    => 'nullable|image|max:5120',
            'acta_nacimiento'         => 'required|file|mimes:jpg,png,pdf|max:5120',
            'calificaciones'          => 'required|file|mimes:jpg,png,pdf|max:5120',
            'tarjeta_identidad_padre' => 'nullable|file|mimes:jpg,png,pdf|max:5120',
            'constancia_medica'       => 'nullable|file|mimes:jpg,png,pdf|max:5120',
        ]);

        $documento = Documento::create([
            'estudiante_id'           => $request->estudiante_id,
            'foto'                    => $request->file('foto')?->store('documentos/foto', 'public'),
            'acta_nacimiento'         => $request->file('acta_nacimiento')->store('documentos/actas', 'public'),
            'calificaciones'          => $request->file('calificaciones')->store('documentos/calificaciones', 'public'),
            'tarjeta_identidad_padre' => $request->file('tarjeta_identidad_padre')?->store('documentos/padres', 'public'),
            'constancia_medica'       => $request->file('constancia_medica')?->store('documentos/medicas', 'public'),
        ]);

        return redirect()
            ->route('estudiantes.show', $request->estudiante_id)
            ->with('success', 'Documentos subidos correctamente.');
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
            'foto'                    => 'nullable|image|max:5120',
            'acta_nacimiento'         => 'nullable|file|mimes:jpg,png,pdf|max:5120',
            'calificaciones'          => 'nullable|file|mimes:jpg,png,pdf|max:5120',
            'tarjeta_identidad_padre' => 'nullable|file|mimes:jpg,png,pdf|max:5120',
            'constancia_medica'       => 'nullable|file|mimes:jpg,png,pdf|max:5120',
        ]);

        $campos = ['foto','acta_nacimiento','calificaciones','tarjeta_identidad_padre','constancia_medica'];

        foreach ($campos as $campo) {
            if ($request->hasFile($campo)) {

                if ($documento->$campo && Storage::disk('public')->exists($documento->$campo)) {
                    Storage::disk('public')->delete($documento->$campo);
                }

                $documento->$campo = $request->file($campo)->store("documentos/$campo", 'public');
            }
        }

        $documento->save();

        return redirect()
            ->route('estudiantes.show', $documento->estudiante_id)
            ->with('success', 'Documentos actualizados correctamente.');
    }

    public function destroy($id)
    {
        $documento = Documento::findOrFail($id);

        $campos = ['foto','acta_nacimiento','calificaciones','tarjeta_identidad_padre','constancia_medica'];

        foreach ($campos as $campo) {
            if ($documento->$campo && Storage::disk('public')->exists($documento->$campo)) {
                Storage::disk('public')->delete($documento->$campo);
            }
        }

        $documento->delete();

        return back()->with('success', 'Documentos eliminados correctamente.');
    }
}
