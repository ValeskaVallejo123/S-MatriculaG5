<?php

namespace App\Http\Controllers;

use App\Models\Padre;
use App\Models\Estudiante;
use App\Models\Matricula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PadreController extends Controller
{
    /**
     * Mostrar lista de padres
     */
    public function index(Request $request)
    {
        $query = Padre::with(['estudiantes']);

        // Búsqueda
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                  ->orWhere('apellido', 'like', "%{$buscar}%")
                  ->orWhere('dni', 'like', "%{$buscar}%")
                  ->orWhere('correo', 'like', "%{$buscar}%");
            });
        }

        $padres = $query->paginate(15);

        return view('padre.index', compact('padres'));
    }

    /**
     * Mostrar formulario para crear nuevo padre
     */
    public function create()
    {
        return view('padre.create');
    }

    /**
     * Guardar nuevo padre
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|min:2|max:50',
            'apellido' => 'required|string|min:2|max:50',
            'dni' => [
                'nullable',
                'string',
                'max:20',
                function ($attribute, $value, $fail) {
                    if (!empty($value)) {
                        $existe = Padre::where('dni', $value)->exists();
                        if ($existe) {
                            $fail('Este DNI ya está registrado en el sistema. Por favor, verifica o déjalo vacío si no lo tienes.');
                        }
                    }
                },
            ],
            'parentesco' => 'required|string|in:padre,madre,tutor_legal,abuelo,abuela,tio,tia,otro',
            'parentesco_otro' => 'nullable|required_if:parentesco,otro|string|max:50',
            'correo' => [
                'nullable',
                'email',
                'max:100',
                function ($attribute, $value, $fail) {
                    if (!empty($value)) {
                        $existe = Padre::where('correo', $value)->exists();
                        if ($existe) {
                            $fail('Este correo ya está registrado en el sistema. Por favor, usa otro correo o déjalo vacío.');
                        }
                    }
                },
            ],
            'telefono' => 'nullable|string|max:15',
            'telefono_secundario' => 'nullable|string|max:15',
            'direccion' => 'nullable|string|max:255',
            'ocupacion' => 'nullable|string|max:100',
            'lugar_trabajo' => 'nullable|string|max:100',
            'telefono_trabajo' => 'nullable|string|max:15',
            'estado' => 'nullable|string|in:activo,inactivo',
            'observaciones' => 'nullable|string|max:500',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.min' => 'El nombre debe tener al menos 2 caracteres.',
            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.min' => 'El apellido debe tener al menos 2 caracteres.',
            'parentesco.required' => 'El parentesco es obligatorio.',
            'parentesco.in' => 'El parentesco seleccionado no es válido.',
        ]);

        // Estado por defecto
        $validated['estado'] = $validated['estado'] ?? 'activo';

        $padre = Padre::create($validated);

        return redirect()->route('padre.index')
            ->with('success', 'Padre/tutor registrado exitosamente.');
    }

    /**
     * Mostrar detalles de un padre
     */
    public function show($id)
    {
        $padre = Padre::with(['estudiantes'])->findOrFail($id);
        return view('padre.show', compact('padre'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($id)
{
    $padre = Padre::findOrFail($id);
    return view('padre.edit', compact('padre'));
}
    /**
     * Actualizar padre
     */
    public function update(Request $request, $id)
    {
        $padre = Padre::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|min:2|max:50',
            'apellido' => 'required|string|min:2|max:50',
            'dni' => [
                'nullable',
                'string',
                'max:20',
                function ($attribute, $value, $fail) use ($id) {
                    if (!empty($value)) {
                        $existe = Padre::where('dni', $value)
                            ->where('id', '!=', $id)
                            ->exists();
                        if ($existe) {
                            $fail('Este DNI ya está registrado por otro padre/tutor.');
                        }
                    }
                },
            ],
            'parentesco' => 'required|string|in:padre,madre,tutor_legal,abuelo,abuela,tio,tia,otro',
            'parentesco_otro' => 'nullable|required_if:parentesco,otro|string|max:50',
            'correo' => [
                'nullable',
                'email',
                'max:100',
                function ($attribute, $value, $fail) use ($id) {
                    if (!empty($value)) {
                        $existe = Padre::where('correo', $value)
                            ->where('id', '!=', $id)
                            ->exists();
                        if ($existe) {
                            $fail('Este correo ya está registrado por otro padre/tutor.');
                        }
                    }
                },
            ],
            'telefono' => 'nullable|string|max:15',
            'telefono_secundario' => 'nullable|string|max:15',
            'direccion' => 'nullable|string|max:255',
            'ocupacion' => 'nullable|string|max:100',
            'lugar_trabajo' => 'nullable|string|max:100',
            'telefono_trabajo' => 'nullable|string|max:15',
            'estado' => 'nullable|string|in:activo,inactivo',
            'observaciones' => 'nullable|string|max:500',
        ]);

        $padre->update($validated);

        return redirect()->route('padre.show', $padre->id)
            ->with('success', 'Información del padre/tutor actualizada correctamente.');
    }

    /**
     * Eliminar padre
     */
    public function destroy($id)
    {
        try {
            $padre = Padre::findOrFail($id);
            // Verificar si tiene estudiantes vinculados
            if ($padre->estudiantes()->count() > 0) {
                return back()->with('error', 'No se puede eliminar. Este padre/tutor tiene estudiantes vinculados.');
            }

            $padre->delete();

            return redirect()->route('padre.index')
                ->with('success', 'Padre/tutor eliminado correctamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar: ' . $e->getMessage());
        }
    }

    /**
     * Buscar padres en el sistema
     */
    public function buscar(Request $request)
    {
        $query = Padre::query();
        // Filtros de búsqueda
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->filled('apellido')) {
            $query->where('apellido', 'like', '%' . $request->apellido . '%');
        }

        if ($request->filled('dni')) {
            $query->where('dni', 'like', '%' . $request->dni . '%');
        }

        if ($request->filled('correo')) {
            $query->where('correo', 'like', '%' . $request->correo . '%');
        }

        if ($request->filled('telefono')) {
            $query->where('telefono', 'like', '%' . $request->telefono . '%');
        }

        // Obtener resultados (solo si hay búsqueda)
        $padres = $request->anyFilled(['nombre', 'apellido', 'dni', 'correo', 'telefono'])
            ? $query->with('estudiantes')->get()
            : collect();

        // Si viene un estudiante_id, verificar vinculaciones existentes
        $estudianteId = $request->input('estudiante_id');
        $estudiante = $estudianteId ? Estudiante::find($estudianteId) : null;

        return view('padre.buscar', compact('padres', 'estudiante'));
    }

    /**
     * Vincular padre con estudiante
     */
    public function vincular(Request $request)
    {
        $request->validate([
            'padre_id' => 'required|exists:padres,id',
            'estudiante_id' => 'required|exists:estudiantes,id',
        ]);

        try {
            DB::beginTransaction();

            $padre = Padre::findOrFail($request->padre_id);
            $estudiante = Estudiante::findOrFail($request->estudiante_id);

            // Verificar si ya existe una matrícula
            $matriculaExistente = Matricula::where('padre_id', $padre->id)
                ->where('estudiante_id', $estudiante->id)
                ->first();

            if ($matriculaExistente) {
                return back()->with('error', 'Este padre ya está vinculado con el estudiante.');
            }

            // Crear la vinculación (matrícula)
            $codigoMatricula = 'MAT-' . date('Y') . '-' . str_pad(Matricula::count() + 1, 4, '0', STR_PAD_LEFT);

            Matricula::create([
                'padre_id' => $padre->id,
                'estudiante_id' => $estudiante->id,
                'codigo_matricula' => $codigoMatricula,
                'anio_lectivo' => date('Y'),
                'fecha_matricula' => now(),
                'estado' => 'aprobada',
            ]);

            DB::commit();

            return redirect()->route('estudiante.show', $estudiante->id)
                ->with('success', 'Padre/tutor vinculado correctamente con el estudiante.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al vincular: ' . $e->getMessage());
        }
    }

    /**
     * Desvincular padre de un estudiante
     */
    public function desvincular(Request $request)
    {
        $request->validate([
            'padre_id' => 'required|exists:padres,id',
            'estudiante_id' => 'required|exists:estudiantes,id',
        ]);

        try {
            DB::beginTransaction();

            $matricula = Matricula::where('padre_id', $request->padre_id)
                ->where('estudiante_id', $request->estudiante_id)
                ->first();

            if (!$matricula) {
                return back()->with('error', 'No existe vinculación entre este padre y estudiante.');
            }

            $matricula->delete();

            DB::commit();

            return back()->with('success', 'Vinculación eliminada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al desvincular: ' . $e->getMessage());
        }
    }
}
