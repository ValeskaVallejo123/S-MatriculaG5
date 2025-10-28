<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    public function index()
    {
        $estudiantes = Estudiante::latest()->paginate(10);
        return view('estudiantes.index', compact('estudiantes'));
    }

    public function create()
    {
        $grados = Estudiante::grados();
        $secciones = Estudiante::secciones();
        return view('estudiantes.create', compact('grados', 'secciones'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|min:2|max:50',
            'apellido' => 'required|string|min:2|max:50',
            'fecha_nacimiento' => 'required|date|before:today',
            'grado' => 'required|string',
            'seccion' => 'required|string|size:1',
            'nombre_padre' => 'required|string|max:100',
            'telefono_padre' => 'required|string|max:15',
            'email_padre' => 'nullable|email|max:100',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'dni_doc' => 'required|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        // Subida de archivos
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('fotos', 'public');
        }

        if ($request->hasFile('dni_doc')) {
            $validated['dni_doc'] = $request->file('dni_doc')->store('documentos', 'public');
        }

        Estudiante::create($validated);

        return redirect()->route('estudiantes.index')->with('success', 'Matrícula creada exitosamente.');
    }
}
