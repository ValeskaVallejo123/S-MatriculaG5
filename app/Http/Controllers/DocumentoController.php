<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documento;
use App\Models\Estudiante;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    public function index()
    {
        // Carga los documentos con sus estudiantes para la tabla
        $documentos = Documento::with('estudiante')->get();

        // Carga TODOS los estudiantes para el modal de búsqueda
        $estudiantes = Estudiante::all();

        // IMPORTANTE: Asegúrate de pasar 'estudiantes' en el compact
        return view('Documentos.indexDocumento', compact('documentos', 'estudiantes'));
    }

    public function create()
    {
        $estudiantes = Estudiante::all();
        return view('Documentos.createDocumento', compact('estudiantes'));
    }

    /**
     * GUARDAR EXPEDIENTE (Corregido)
     */
    public function store(Request $request)
    {
        $request->validate([
            'estudiante_id'    => 'required|exists:estudiantes,id',
            'foto'             => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'acta_nacimiento'  => 'nullable|file|mimes:pdf,jpg,png|max:5120',
            'calificaciones'   => 'nullable|file|mimes:pdf,jpg,png|max:5120',
        ]);

        $documento = new Documento();
        $documento->estudiante_id = $request->estudiante_id;

        // 1. Procesar la Foto
        if ($request->hasFile('foto')) {
            // Guardamos el archivo
            $rutaFoto = $request->file('foto')->store('expedientes/fotos', 'public');
            $documento->foto = $rutaFoto;

            // 🔹 CRUCIAL: Actualizar la tabla estudiantes para que aparezca en la lista
            $estudiante = Estudiante::find($request->estudiante_id);
            $estudiante->update(['foto' => $rutaFoto]);
        }

        // 2. Procesar Acta y Notas
        if ($request->hasFile('acta_nacimiento')) {
            $documento->acta_nacimiento = $request->file('acta_nacimiento')->store('expedientes/actas', 'public');
        }

        if ($request->hasFile('calificaciones')) {
            $documento->calificaciones = $request->file('calificaciones')->store('expedientes/notas', 'public');
        }

        $documento->save();

        return redirect()->route('documentos.index')
            ->with('success', 'Expediente creado y foto de perfil actualizada correctamente.');
    }

    public function edit($id)
    {
        $documento = Documento::findOrFail($id);
        $estudiantes = Estudiante::all();
        return view('Documentos.editDocumento', compact('documento', 'estudiantes'));
    }

    /**
     * ACTUALIZAR EXPEDIENTE (Corregido y Limpiado)
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

        // Actualizar Foto
        if ($request->hasFile('foto')) {
            // Borrar vieja del storage
            if ($documento->foto) {
                Storage::disk('public')->delete($documento->foto);
            }

            $rutaFoto = $request->file('foto')->store('expedientes/fotos', 'public');
            $documento->foto = $rutaFoto;

            // 🔹 Actualizar también la ficha del estudiante
            $estudiante = Estudiante::find($request->estudiante_id);
            $estudiante->update(['foto' => $rutaFoto]);
        }

        if ($request->hasFile('acta_nacimiento')) {
            if ($documento->acta_nacimiento) { Storage::disk('public')->delete($documento->acta_nacimiento); }
            $documento->acta_nacimiento = $request->file('acta_nacimiento')->store('expedientes/actas', 'public');
        }

        if ($request->hasFile('calificaciones')) {
            if ($documento->calificaciones) { Storage::disk('public')->delete($documento->calificaciones); }
            $documento->calificaciones = $request->file('calificaciones')->store('expedientes/notas', 'public');
        }

        $documento->save();

        return redirect()->route('documentos.index')
            ->with('success', 'Expediente y foto de perfil actualizados.');
    }

    public function show(Documento $documento, Request $request)
    {
        $tipo = $request->query('tipo');
        $path = match($tipo) {
            'foto'            => $documento->foto,
            'acta'            => $documento->acta_nacimiento,
            'calificaciones'  => $documento->calificaciones,
            default           => null
        };

        if (!$path || !Storage::disk('public')->exists($path)) {
            return back()->with('error', 'El archivo no existe.');
        }

        return response()->file(Storage::disk('public')->path($path));
    }

    public function destroy($id)
    {
        $documento = Documento::findOrFail($id);

        // Al borrar el expediente, opcionalmente limpiamos la foto del estudiante
        $estudiante = Estudiante::find($documento->estudiante_id);
        if($estudiante) { $estudiante->update(['foto' => null]); }

        Storage::disk('public')->delete([
            $documento->foto,
            $documento->acta_nacimiento,
            $documento->calificaciones
        ]);

        $documento->delete();

        return redirect()->route('documentos.index')->with('success', 'Expediente eliminado.');
    }
}
