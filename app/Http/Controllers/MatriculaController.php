<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\Padre;
use App\Models\Estudiante;
use Illuminate\Http\Request;

class MatriculaController extends Controller
{
    // Listado de matrículas
    public function index()
    {
        $matriculas = Matricula::with(['padre', 'estudiante'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('matriculas.index', compact('matriculas'));
    }

    // Formulario para crear matrícula
    public function create()
    {
        $padres = Padre::all();
        $estudiantes = Estudiante::all();
        return view('matriculas.create', compact('padres', 'estudiantes'));
    }

    // Guardar matrícula con documento
    public function store(Request $request)
    {
        $request->validate([
            'padre_id' => 'required|exists:padres,id',
            'estudiante_id' => 'required|exists:estudiantes,id',
            'grado' => 'required|string|max:50',
            'seccion' => 'required|string|max:10',
            'documento' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ], [
            'documento.mimes' => 'El documento debe ser PDF, JPG o PNG.',
            'documento.max' => 'El archivo no debe superar los 2MB.'
        ]);

        $rutaDocumento = null;

        if ($request->hasFile('documento')) {
            $archivo = $request->file('documento');
            $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
            $rutaDocumento = $archivo->storeAs('documentos_matriculas', $nombreArchivo, 'public');
        }

        Matricula::create([
            'padre_id' => $request->padre_id,
            'estudiante_id' => $request->estudiante_id,
            'grado' => $request->grado,
            'seccion' => $request->seccion,
            'documento' => $rutaDocumento
        ]);

        return redirect()->route('matriculas.index')->with('success', 'Matrícula registrada correctamente.');
    }

    // Editar matrícula
    public function edit($id)
    {
        $matricula = Matricula::findOrFail($id);
        $padres = Padre::all();
        $estudiantes = Estudiante::all();
        return view('matriculas.edit', compact('matricula', 'padres', 'estudiantes'));
    }

    // Actualizar matrícula
    public function update(Request $request, $id)
    {
        $matricula = Matricula::findOrFail($id);

        $request->validate([
            'padre_id' => 'required|exists:padres,id',
            'estudiante_id' => 'required|exists:estudiantes,id',
            'grado' => 'required|string|max:50',
            'seccion' => 'required|string|max:10',
            'documento' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('documento')) {

            if ($matricula->documento && file_exists(storage_path('app/public/' . $matricula->documento))) {
                unlink(storage_path('app/public/' . $matricula->documento));
            }

            $archivo = $request->file('documento');
            $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
            $rutaDocumento = $archivo->storeAs('documentos_matriculas', $nombreArchivo, 'public');

            $matricula->documento = $rutaDocumento;
        }

        $matricula->update([
            'padre_id' => $request->padre_id,
            'estudiante_id' => $request->estudiante_id,
            'grado' => $request->grado,
            'seccion' => $request->seccion
        ]);

        $matricula->save();

        return redirect()->route('matriculas.index')->with('success', 'Matrícula actualizada correctamente.');
    }

    // Eliminar matrícula
    public function destroy($id)
    {
        $matricula = Matricula::findOrFail($id);

        if ($matricula->documento && file_exists(storage_path('app/public/' . $matricula->documento))) {
            unlink(storage_path('app/public/' . $matricula->documento));
        }

        $matricula->delete();

        return redirect()->route('matriculas.index')->with('success', 'Matrícula eliminada correctamente.');
    }
}
