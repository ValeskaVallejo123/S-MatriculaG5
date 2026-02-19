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
        $documentos = Documento::with('estudiante')->get();
        return view('Documentos.indexDocumento', compact('documentos'));
    }

    public function create()
    {
        $estudiantes = Estudiante::all();
        return view('Documentos.createDocumento', compact('estudiantes'));
    }

    public function store(Request $request)
    {
        // 1. Validación (Importante para tu Historia de Usuario 50)
        $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:5120', // Max 5MB
        ]);

        $documento = new Documento();
        $documento->estudiante_id = $request->estudiante_id;

        // 2. Guardar archivos en el disco 'public'
        if($request->hasFile('foto')) {
            $documento->foto = $request->file('foto')->store('expedientes/fotos', 'public');
        }

        if($request->hasFile('acta_nacimiento')) {
            $documento->acta_nacimiento = $request->file('acta_nacimiento')->store('expedientes/actas', 'public');
        }

        if($request->hasFile('calificaciones')) {
            $documento->calificaciones = $request->file('calificaciones')->store('expedientes/notas', 'public');
        }

        $documento->save();
        return redirect()->route('documentos.index')->with('success', 'Documentos guardados.');
    }
    public function edit($id)
    {
        $documento = Documento::findOrFail($id);
        $estudiantes = Estudiante::all(); // Agregado para que el select de edit funcione
        return view('Documentos.editDocumento', compact('documento', 'estudiantes'));
    }

    public function update(Request $request, $id)
    {
        $documento = Documento::findOrFail($id);

        $request->validate([
            'foto'              => 'nullable|image|mimes:jpg,png|max:5120',
            'acta_nacimiento'   => 'nullable|file|mimes:jpg,png,pdf|max:5120',
            'calificaciones'    => 'nullable|file|mimes:jpg,png,pdf|max:5120',
        ]);

        if ($request->hasFile('foto')) {
            if ($documento->foto) Storage::disk('public')->delete($documento->foto);
            $documento->foto = $request->file('foto')->store('expedientes/fotos', 'public');
        }

        if ($request->hasFile('acta_nacimiento')) {
            if ($documento->acta_nacimiento) Storage::disk('public')->delete($documento->acta_nacimiento);
            $documento->acta_nacimiento = $request->file('acta_nacimiento')->store('documentos/actas', 'public');
        }

        if ($request->hasFile('calificaciones')) {
            if ($documento->calificaciones) Storage::disk('public')->delete($documento->calificaciones);
            $documento->calificaciones = $request->file('calificaciones')->store('documentos/calificaciones', 'public');
        }

        $documento->save();

        return redirect()->route('documentos.index')->with('success', 'Documentos actualizados correctamente.');
    }

    public function destroy($id)
    {
        $documento = Documento::findOrFail($id);

        // Borrar archivos del storage antes de eliminar el registro
        if ($documento->foto) Storage::disk('public')->delete($documento->foto);
        if ($documento->acta_nacimiento) Storage::disk('public')->delete($documento->acta_nacimiento);
        if ($documento->calificaciones) Storage::disk('public')->delete($documento->calificaciones);

        $documento->delete();

        return redirect()->route('documentos.index')->with('success', 'Expediente eliminado correctamente.');
    }
    public function up(): void
    {
        Schema::table('documentos', function (Blueprint $table) {
            // Esto crea la columna y la relaciona con la tabla estudiantes
            $table->foreignId('estudiante_id')->after('id')->constrained('estudiantes')->onDelete('cascade');
        });
    }
} // <--- Esta es la única llave que debe cerrar la clase al final de TODO.
