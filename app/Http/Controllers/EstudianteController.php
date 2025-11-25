<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EstudianteController extends Controller
{
    public function index()
    {
        $estudiantes = Estudiante::latest()->paginate(10);
        return view('estudiante.index', compact('estudiantes'));
    }

    public function create()
    {
        $grados = Estudiante::grados();
        $secciones = Estudiante::secciones();
        return view('estudiante.create', compact('grados', 'secciones'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre1' => 'required|string|min:2|max:50',
            'nombre2' => 'string|min:2|max:50',
            'apellido1' => 'required|string|min:2|max:50',
            'apellido2' => 'string|min:2|max:50',
            'dni' => 'nullable|string|max:13',
            'fecha_nacimiento' => 'required|date|before:today',
            'sexo' => 'required|in:masculino,femenino',
            'email' => 'nullable|email|max:100',
            'telefono' => 'nullable|string|max:15',
            'direccion' => 'nullable|string|max:255',
            'grado' => 'required|string',
            'seccion' => 'required|string|max:1',
            'estado' => 'nullable|string|in:activo,inactivo,retirado',
            'observaciones' => 'nullable|string|max:500',
            'nombre_padre' => 'nullable|string|max:100',
            'telefono_padre' => 'nullable|string|max:15',
            'email_padre' => 'nullable|email|max:100',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'dni_doc' => 'nullable|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('fotos', 'public');
        }

        if ($request->hasFile('dni_doc')) {
            $validated['dni_doc'] = $request->file('dni_doc')->store('documentos', 'public');
        }

        Estudiante::create($validated);

        return redirect()->route('estudiante.index')
            ->with('success', 'Estudiante registrado exitosamente.');
    }

    public function show($id)
    {
        $estudiante = Estudiante::findOrFail($id);
        return view('estudiante.show', compact('estudiante'));
    }

    public function edit($id)
    {
        $estudiante = Estudiante::findOrFail($id);
        $grados = Estudiante::grados();
        $secciones = Estudiante::secciones();
        return view('estudiante.edit', compact('estudiante', 'grados', 'secciones'));
    }

    public function update(Request $request, $id)
    {
        $estudiante = Estudiante::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|min:2|max:50',
            'apellido' => 'required|string|min:2|max:50',
            'dni' => 'nullable|string|max:13',
            'fecha_nacimiento' => 'required|date|before:today',
            'sexo' => 'required|in:masculino,femenino',
            'email' => 'nullable|email|max:100',
            'telefono' => 'nullable|string|max:15',
            'direccion' => 'nullable|string|max:255',
            'grado' => 'required|string',
            'seccion' => 'required|string|max:1',
            'estado' => 'nullable|string|in:activo,inactivo,retirado',
            'observaciones' => 'nullable|string|max:500',
            'nombre_padre' => 'nullable|string|max:100',
            'telefono_padre' => 'nullable|string|max:15',
            'email_padre' => 'nullable|email|max:100',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'dni_doc' => 'nullable|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        if ($request->hasFile('foto')) {
            if ($estudiante->foto && Storage::disk('public')->exists($estudiante->foto)) {
                Storage::disk('public')->delete($estudiante->foto);
            }
            $validated['foto'] = $request->file('foto')->store('fotos', 'public');
        }

        if ($request->hasFile('dni_doc')) {
            if ($estudiante->dni_doc && Storage::disk('public')->exists($estudiante->dni_doc)) {
                Storage::disk('public')->delete($estudiante->dni_doc);
            }
            $validated['dni_doc'] = $request->file('dni_doc')->store('documentos', 'public');
        }

        $estudiante->update($validated);

        return redirect()->route('estudiante.index')
            ->with('success', 'Estudiante actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $estudiante = Estudiante::findOrFail($id);

        if ($estudiante->foto && Storage::disk('public')->exists($estudiante->foto)) {
            Storage::disk('public')->delete($estudiante->foto);
        }

        if ($estudiante->dni_doc && Storage::disk('public')->exists($estudiante->dni_doc)) {
            Storage::disk('public')->delete($estudiante->dni_doc);
        }

        $estudiante->delete();

        return redirect()->route('estudiante.index')
            ->with('success', 'Estudiante eliminado exitosamente.');
    }
}
