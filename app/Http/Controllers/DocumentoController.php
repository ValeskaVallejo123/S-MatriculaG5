<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    /**
     * Listar todos los documentos
     */
    public function index()
    {
        $documentos = Documento::with('estudiante')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('Documentos.indexDocumento', compact('documentos'));
    }

    /**
     * Mostrar formulario de creación
     * Si se recibe un estudiante_id, preselecciona al estudiante
     */
    public function create($estudiante_id = null)
    {
        $estudiantes = Estudiante::orderBy('nombre')->get();
        $estudiante  = $estudiante_id ? Estudiante::findOrFail($estudiante_id) : null;

        return view('Documentos.createDocumento', compact('estudiantes', 'estudiante'));
    }

    /**
     * Guardar documentos nuevos
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'estudiante_id'           => 'required|exists:estudiantes,id',
            'foto'                    => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'acta_nacimiento'         => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'calificaciones'          => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'tarjeta_identidad_padre' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'constancia_medica'       => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        Documento::create([
            'estudiante_id'           => $request->estudiante_id,
            'foto'                    => $request->file('foto')?->store('documentos/fotos', 'public'),
            'acta_nacimiento'         => $request->file('acta_nacimiento')->store('documentos/actas', 'public'),
            'calificaciones'          => $request->file('calificaciones')->store('documentos/calificaciones', 'public'),
            'tarjeta_identidad_padre' => $request->file('tarjeta_identidad_padre')?->store('documentos/padres', 'public'),
            'constancia_medica'       => $request->file('constancia_medica')?->store('documentos/medicas', 'public'),
        ]);

        return redirect()
            ->route('estudiantes.show', $request->estudiante_id)
            ->with('success', 'Documentos subidos correctamente.');
    }

    /**
     * Mostrar detalle de documentos de un estudiante
     */
    public function show($id)
    {
        $documento = Documento::with('estudiante')->findOrFail($id);

        return view('Documentos.showDocumento', compact('documento'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($id)
    {
        $documento   = Documento::findOrFail($id);
        $estudiantes = Estudiante::orderBy('nombre')->get();

        return view('Documentos.editDocumento', compact('documento', 'estudiantes'));
    }

    /**
     * Actualizar documentos existentes
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $documento = Documento::findOrFail($id);

        $request->validate([
            'foto'                    => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'acta_nacimiento'         => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'calificaciones'          => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'tarjeta_identidad_padre' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'constancia_medica'       => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        // Rutas de almacenamiento por campo
        $rutas = [
            'foto'                    => 'documentos/fotos',
            'acta_nacimiento'         => 'documentos/actas',
            'calificaciones'          => 'documentos/calificaciones',
            'tarjeta_identidad_padre' => 'documentos/padres',
            'constancia_medica'       => 'documentos/medicas',
        ];

        foreach ($rutas as $campo => $ruta) {
            if ($request->hasFile($campo)) {
                // Eliminar archivo anterior si existe
                if ($documento->$campo && Storage::disk('public')->exists($documento->$campo)) {
                    Storage::disk('public')->delete($documento->$campo);
                }
                // Guardar nuevo archivo
                $documento->$campo = $request->file($campo)->store($ruta, 'public');
            }
        }

        $documento->save();

        return redirect()
            ->route('estudiantes.show', $documento->estudiante_id)
            ->with('success', 'Documentos actualizados correctamente.');
    }

    /**
     * Eliminar documentos y sus archivos físicos
     */
    public function destroy($id): RedirectResponse
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

        $documento->delete();

        return redirect()
            ->route('documentos.index')
            ->with('success', 'Documentos eliminados correctamente.');
    }
}
