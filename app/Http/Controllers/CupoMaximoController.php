<?php

namespace App\Http\Controllers;

use App\Models\CupoMaximo;
use Illuminate\Http\Request;

class CupoMaximoController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:super_admin');
    }

    /**
     * Listado de cupos máximos.
     */
    public function index(Request $request)
    {
        $perPage = in_array($request->per_page, [10, 25, 50]) ? $request->per_page : 15;

        $query = CupoMaximo::orderBy('nombre');

        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', '%' . $request->buscar . '%');
        }
        if ($request->filled('jornada')) {
            $query->where('jornada', $request->jornada);
        }
        if ($request->filled('seccion')) {
            $query->where('seccion', $request->seccion);
        }

        $cursos          = $query->paginate($perPage)->withQueryString();
        $totalCupos      = CupoMaximo::count();
        $totalMatutina   = CupoMaximo::where('jornada', 'Matutina')->count();
        $totalVespertina = CupoMaximo::where('jornada', 'Vespertina')->count();

        return view('cupos_maximos.index', compact('cursos', 'totalCupos', 'totalMatutina', 'totalVespertina'));
    }

    /**
     * Formulario para crear un nuevo cupo.
     */
    public function create()
    {
        return view('cupos_maximos.create');
    }

    /**
     * Guardar un nuevo cupo en la BD.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:100',
            'cupo_maximo' => 'required|integer|min:1|max:35',
            'jornada'     => 'required|in:Matutina,Vespertina',
            'seccion'     => 'required|in:A,B,C,D',
        ], [
            'nombre.required'      => 'El nombre del curso es obligatorio.',
            'cupo_maximo.required' => 'El cupo máximo es obligatorio.',
            'cupo_maximo.integer'  => 'El cupo máximo debe ser un número entero.',
            'cupo_maximo.min'      => 'El cupo máximo debe ser al menos 1.',
            'cupo_maximo.max'      => 'El cupo máximo no puede superar 35 estudiantes.',
            'jornada.required'     => 'La jornada es obligatoria.',
            'jornada.in'           => 'La jornada debe ser Matutina o Vespertina.',
            'seccion.required'     => 'La sección es obligatoria.',
            'seccion.in'           => 'La sección debe ser A, B, C o D.',
        ]);

        CupoMaximo::create($request->only(['nombre', 'cupo_maximo', 'jornada', 'seccion']));

        return redirect()
            ->route('superadmin.cupos_maximos.index')
            ->with('success', 'Cupo registrado correctamente.');
    }

    /**
     * No se usa — redirige al listado.
     */
    public function show(string $id)
    {
        return redirect()->route('superadmin.cupos_maximos.index');
    }

    /**
     * Formulario para editar un cupo existente.
     */
    public function edit(string $id)
    {
        $curso = CupoMaximo::findOrFail($id);

        return view('cupos_maximos.edit', compact('curso'));
    }

    /**
     * Actualizar el cupo en la BD.
     */
    public function update(Request $request, string $id)
    {
        $curso = CupoMaximo::findOrFail($id);

        $request->validate([
            'nombre'      => 'required|string|max:100',
            'cupo_maximo' => 'required|integer|min:1|max:35',
            'jornada'     => 'required|in:Matutina,Vespertina',
            'seccion'     => 'required|in:A,B,C,D',
        ], [
            'nombre.required'      => 'El nombre del curso es obligatorio.',
            'cupo_maximo.required' => 'El cupo máximo es obligatorio.',
            'cupo_maximo.integer'  => 'El cupo máximo debe ser un número entero.',
            'cupo_maximo.min'      => 'El cupo máximo debe ser al menos 1.',
            'cupo_maximo.max'      => 'El cupo máximo no puede superar 35 estudiantes.',
            'jornada.required'     => 'La jornada es obligatoria.',
            'jornada.in'           => 'La jornada debe ser Matutina o Vespertina.',
            'seccion.required'     => 'La sección es obligatoria.',
            'seccion.in'           => 'La sección debe ser A, B, C o D.',
        ]);

        $curso->update($request->only(['nombre', 'cupo_maximo', 'jornada', 'seccion']));

        return redirect()
            ->route('superadmin.cupos_maximos.index')
            ->with('success', 'Cupo actualizado correctamente.');
    }

    /**
     * Eliminar un cupo de la BD.
     */
    public function destroy(Request $request, string $id)
    {
        $curso = CupoMaximo::findOrFail($id);
        $curso->delete();

        return redirect()
            ->route('superadmin.cupos_maximos.index', ['page' => $request->input('page', 1)])
            ->with('success', 'Cupo eliminado correctamente.');
    }
}
