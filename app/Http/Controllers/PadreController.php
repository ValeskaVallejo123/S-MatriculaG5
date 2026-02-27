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
     * Mostrar lista de padres con filtros y paginación
     */
    public function index(Request $request)
    {
        $query = Padre::with(['estudiantes']);

        // Filtros de búsqueda
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                  ->orWhere('apellido', 'like', "%{$buscar}%")
                  ->orWhere('dni', 'like', "%{$buscar}%")
                  ->orWhere('correo', 'like', "%{$buscar}%");
            });
        }

        $padres = $query->paginate(15)->withQueryString();

        return view('padre.index', compact('padres'));
    }

    /**
     * Mostrar formulario para crear nuevo padre
     */
    public function create()
    {
        $this->authorizeRol();
        return view('padre.create');
    }

    /**
     * Guardar nuevo padre
     */
    public function store(Request $request)
    {
        $this->authorizeRol();

        $validated = $this->validarPadre($request);
        $validated['estado'] = $validated['estado'] ?? 'activo';

        Padre::create($validated);

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
        $this->authorizeRol();
        $padre = Padre::findOrFail($id);
        return view('padre.edit', compact('padre'));
    }

    /**
     * Actualizar padre
     */
    public function update(Request $request, $id)
    {
        $this->authorizeRol();
        $padre = Padre::findOrFail($id);

        $validated = $this->validarPadre($request, $id);
        $padre->update($validated);

        return redirect()->route('padre.show', $padre->id)
            ->with('success', 'Información del padre/tutor actualizada correctamente.');
    }

    /**
     * Eliminar padre
     */
    public function destroy($id)
    {
        $this->authorizeRol();
        $padre = Padre::findOrFail($id);

        if ($padre->estudiantes()->count() > 0) {
            return back()->with('error', 'No se puede eliminar. Este padre/tutor tiene estudiantes vinculados.');
        }

        $padre->delete();

        return redirect()->route('padre.index')
            ->with('success', 'Padre/tutor eliminado correctamente.');
    }

    /**
     * Buscar padres en el sistema
     */
    public function buscar(Request $request)
    {
        $query = Padre::query();

        // Filtros
        foreach (['nombre','apellido','dni','correo','telefono'] as $campo) {
            if ($request->filled($campo)) {
                $query->where($campo, 'like', '%' . $request->$campo . '%');
            }
        }

        $padres = $request->anyFilled(['nombre','apellido','dni','correo','telefono'])
            ? $query->with('estudiantes')->paginate(15)->withQueryString()
            : collect();

        $estudianteId = $request->input('estudiante_id');
        $estudiante = $estudianteId ? Estudiante::find($estudianteId) : null;

        return view('padre.buscar', compact('padres','estudiante'));
    }

    /**
     * Vincular padre con estudiante
     */
    public function vincular(Request $request)
    {
        $this->authorizeRol();
        $request->validate([
            'padre_id' => 'required|exists:padres,id',
            'estudiante_id' => 'required|exists:estudiantes,id',
        ]);

        try {
            DB::beginTransaction();

            $padre = Padre::findOrFail($request->padre_id);
            $estudiante = Estudiante::findOrFail($request->estudiante_id);

            $matriculaExistente = Matricula::where('padre_id', $padre->id)
                ->where('estudiante_id', $estudiante->id)
                ->first();

            if ($matriculaExistente) {
                return back()->with('error', 'Este padre ya está vinculado con el estudiante.');
            }

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
        $this->authorizeRol();
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

    /**
     * Validar datos de padre/tutor
     */
    private function validarPadre(Request $request, $id = null)
    {
        return $request->validate([
            'nombre' => 'required|string|min:2|max:50',
            'apellido' => 'required|string|min:2|max:50',
            'dni' => [
                'nullable','string','max:20',
                function($attribute, $value, $fail) use ($id) {
                    if (!empty($value)) {
                        $query = Padre::where('dni', $value);
                        if ($id) $query->where('id','!=',$id);
                        if ($query->exists()) $fail('Este DNI ya está registrado.');
                    }
                }
            ],
            'parentesco' => 'required|string|in:padre,madre,tutor_legal,abuelo,abuela,tio,tia,otro',
            'parentesco_otro' => 'nullable|required_if:parentesco,otro|string|max:50',
            'correo' => [
                'nullable','email','max:100',
                function($attribute, $value, $fail) use ($id) {
                    if (!empty($value)) {
                        $query = Padre::where('correo', $value);
                        if ($id) $query->where('id','!=',$id);
                        if ($query->exists()) $fail('Este correo ya está registrado.');
                    }
                }
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
    }

    /**
     * Autorizar solo SuperAdmin o Administrador
     */
    private function authorizeRol()
    {
        if (!auth()->user()->isSuperAdmin() && !auth()->user()->isAdministrador()) {
            abort(403, 'No autorizado');
        }
    }
}
