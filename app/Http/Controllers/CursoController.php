<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;

class CursoController extends Controller
{
    public function __construct()
    {
        // Solo usuarios autenticados pueden acceder
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // Obtener filtros del request
        $searchNombre = $request->input('searchNombre');
        $filterJornada = $request->input('filterJornada');
        $filterSeccion = $request->input('filterSeccion');

        // Construir consulta
        $query = Curso::query();

        if ($searchNombre) {
            $query->where('nombre', 'LIKE', '%' . $searchNombre . '%');
        }

        if ($filterJornada) {
            $query->where('jornada', $filterJornada);
        }

        if ($filterSeccion) {
            $query->where('seccion', $filterSeccion);
        }

        // Paginación con 10 cursos por página
        $cursos = $query->orderBy('nombre')->paginate(10)->appends($request->all());

        return view('cupos_maximos.index', compact('cursos'));
    }

    public function create()
    {
        return view('cupos_maximos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'cupo_maximo' => 'required|integer|min:30|max:35',
            'jornada' => 'required|string|max:50',
            'seccion' => 'required|string|max:50',
        ], [
            'cupo_maximo.min' => 'El cupo mínimo debe ser 30.',
            'cupo_maximo.max' => 'El cupo máximo no puede exceder 35.',
        ]);

        Curso::create($validated);

        return redirect()->route('cupos_maximos.index')
            ->with('success', 'Cupo creado correctamente.');
    }

    public function edit($id)
    {
        $curso = Curso::findOrFail($id);
        return view('cupos_maximos.edit', compact('curso'));
    }

    public function update(Request $request, $id)
    {
        $curso = Curso::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'cupo_maximo' => 'required|integer|min:30|max:35',
            'jornada' => 'required|string|max:50',
            'seccion' => 'required|string|max:50',
        ], [
            'cupo_maximo.min' => 'El cupo mínimo debe ser 30.',
            'cupo_maximo.max' => 'El cupo máximo no puede exceder 35.',
        ]);

        // Verificar si hay cambios
        $cambios = false;
        foreach ($validated as $campo => $valor) {
            if ($curso->$campo != $valor) {
                $cambios = true;
                break;
            }
        }

        if (!$cambios) {
            return redirect()->route('cupos_maximos.index')
                ->with('info', 'No se realizaron cambios en el cupo.');
        }

        $curso->update($validated);

        return redirect()->route('cupos_maximos.index')
            ->with('success', 'Cupo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $curso = Curso::findOrFail($id);
        $curso->delete();

        return redirect()->route('cupos_maximos.index')
            ->with('success', 'Cupo eliminado correctamente.');
    }
}
