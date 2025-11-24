<?php

namespace App\Http\Controllers;

use App\Models\Grado;
use App\Models\Clase; // Se añade esta importación asumiendo que el modelo Clase existe
use Illuminate\Http\Request;

class VerGradoController extends Controller
{
    /**
     * Vista pública (solo lectura)
     */
    public function indexPublico()
    {
        // Se obtienen los grados paginados para la vista pública
        $grados = Grado::paginate(10);
        return view('grados.public', compact('grados'));
    }

    /**
     * Vista administrativa (con edición)
     */
    public function index()
    {
        // Se obtienen los grados paginados para la vista administrativa
        $grados = Grado::paginate(10);
        return view('grados.index', compact('grados'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('grados.create');
    }

    /**
     * Guardar nuevo grado
     */
    public function store(Request $request)
    {
        // Reglas de validación para la creación de un nuevo grado
        $request->validate([
            'nombre' => 'required|string|max:50|unique:grados',
            'seccion' => 'nullable|string|max:2',
            'jornada' => 'required|in:Matutina,Vespertina',
            'nombre_maestro' => 'required|string|max:255',
        ]);

        // Creación del grado en la base de datos
        Grado::create($request->all());

        return redirect()->route('grados.index')
            ->with('success', 'Grado creado exitosamente.');
    }

    /**
     * Mostrar un grado específico
     */
    public function show(Grado $grado)
    {
        return view('grados.show', compact('grado'));
    }

    public function showPublico($id)
    {
        $grado = Grado::findOrFail($id);
        return view('grados.show', compact('grado'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Grado $grado)
    {
        return view('grados.edit', compact('grado'));
    }

    /**
     * Actualizar grado
     */
    public function update(Request $request, Grado $grado)
    {
        // Reglas de validación para la actualización (se ignora el ID actual para unique)
        $request->validate([
            'nombre' => 'required|string|max:50|unique:grados,nombre,' . $grado->id,
            'seccion' => 'nullable|string|max:255',
            'jornada' => 'required|in:Matutina,Vespertina',
            'nombre_maestro' => 'required|string|max:255',
        ]);

        // Actualización del grado
        $grado->update($request->all());

        return redirect()->route('grados.index')
            ->with('success', 'Grado actualizado exitosamente.');
    }

    /**
     * Muestra las clases/materias de un grado específico en la vista pública.
     * Este es el método que estaba faltando y causaba el error 500 en la ruta /publico/grados/{id}/clases
     *
     * @param int $id El ID del Grado.
     * @return \Illuminate\View\View
     */
    public function verClasesPublico(int $id)
    {
        // 1. Obtener el Grado o fallar (404) si no existe
        $grado = Grado::findOrFail($id);

        // 2. Obtener las clases a través de la relación 'clases' definida en el modelo Grado
        // Asegúrate de que tu modelo Grado tenga la relación: public function clases() { return $this->hasMany(Clase::class); }
        $clases = $grado->clases;
        
        // 3. Retornar la vista 'publico.clases' con los datos
        return view('grados.show', [ // Asume que la vista se llama 'publico/clases.blade.php'
            'grado' => $grado,
            'clases' => $clases,
        ]);
    }
    
    /**
     * Eliminar grado
     */
    public function destroy(Grado $grado)
    {
        // Eliminación del grado
        $grado->delete();

        return redirect()->route('grados.index')
            ->with('success', 'Grado eliminado exitosamente.');
    }
}