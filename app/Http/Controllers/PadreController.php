<?php

namespace App\Http\Controllers;

use App\Models\Padre;
use App\Models\Estudiante;
use App\Models\Matricula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PadreController extends Controller
{
    /**
     * Mostrar lista de padres con filtros y paginación
     */
    public function index(Request $request)
    {
        // Vista para admin/superadmin
        if (in_array(Auth::user()->id_rol, [1, 2])) {
            $perPage = in_array(request('per_page'), [10, 25, 50]) ? request('per_page') : 15;

            $query = Padre::with(['estudiantes']);

            if ($request->filled('buscar')) {
                $buscar = $request->buscar;
                $query->where(function ($q) use ($buscar) {
                    $q->where('nombre', 'like', "%{$buscar}%")
                      ->orWhere('apellido', 'like', "%{$buscar}%")
                      ->orWhere('dni', 'like', "%{$buscar}%")
                      ->orWhere('correo', 'like', "%{$buscar}%");
                });
            }

            $padres = $query->orderBy('nombre')->paginate($perPage)->withQueryString();

            // ── Conteos globales (sin paginación) ─────────────────────
            $totalPadres   = Padre::count();
            $totalActivos  = Padre::where('estado', 1)->count();
            $totalConHijos = Padre::has('estudiantes')->count();

            return view('padre.admin-index', compact(
                'padres',
                'totalPadres',
                'totalActivos',
                'totalConHijos'
            ));
        }

        // Vista para padre/tutor
        return view('padre.index');
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
        $validated['estado'] = $validated['estado'] ?? 1;

        $padre = Padre::create($validated);

        // Crear cuenta de usuario si el padre tiene correo y no existe ya un usuario con ese email
        $correoPadre = $padre->correo ?? null;
        $padreRolId  = DB::table('roles')->where('nombre', 'Padre')->value('id');
        if ($padreRolId && $correoPadre && !DB::table('users')->where('email', $correoPadre)->exists()) {
            DB::table('users')->insert([
                'name'              => $padre->nombre . ' ' . $padre->apellido,
                'email'             => $correoPadre,
                'password'          => Hash::make('Padre2025!'),
                'id_rol'            => $padreRolId,
                'activo'            => true,
                'is_super_admin'    => false,
                'is_protected'      => false,
                'email_verified_at' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }

        $msg = 'Padre/tutor registrado exitosamente.';
        if ($correoPadre) {
            $msg .= " Contraseña inicial: Padre2025!";
        }

        return redirect()->route('padres.index')->with('success', $msg);
    }

    /**
     * Mostrar detalles de un padre
     */
    public function show($id)
    {
        $padre = Padre::with(['estudiantes.gradoAsignado'])->findOrFail($id);
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

        return redirect()->route('padres.show', $padre->id)
            ->with('success', 'Información del padre/tutor actualizada correctamente.');
    }

    /**
     * Eliminar padre
     */
    public function destroy(Request $request, $id)
    {
        $this->authorizeRol();
        $padre = Padre::findOrFail($id);

        if ($padre->estudiantes()->count() > 0) {
            return back()->with('error', 'No se puede eliminar. Este padre/tutor tiene estudiantes vinculados.');
        }

        $padre->delete();

        return redirect()->route('padres.index', ['page' => $request->input('page', 1)])
            ->with('success', 'Padre/tutor eliminado correctamente.');
    }

    /**
     * Buscar padres en el sistema
     */
    public function buscar(Request $request)
    {
        $query = Padre::query();

        foreach (['nombre','apellido','dni','correo','telefono'] as $campo) {
            if ($request->filled($campo)) {
                $query->where($campo, 'like', '%' . $request->$campo . '%');
            }
        }

        $padres = $request->anyFilled(['nombre','apellido','dni','correo','telefono'])
            ? $query->orderBy('apellido')->with('estudiantes')->paginate(15)->withQueryString()
            : collect();

        $estudianteId = $request->input('estudiante_id');
        $estudiante   = $estudianteId ? Estudiante::find($estudianteId) : null;

        return view('padre.buscar', compact('padres', 'estudiante'));
    }

    /**
     * Vincular padre con estudiante
     */
    public function vincular(Request $request, Padre $padre)
    {
        $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
        ]);

        try {
            DB::beginTransaction();

            $estudiante = Estudiante::findOrFail($request->estudiante_id);

            $matriculaExistente = Matricula::where('padre_id', $padre->id)
                ->where('estudiante_id', $estudiante->id)
                ->first();

            if ($matriculaExistente) {
                return back()->with('error', 'Este padre ya está vinculado con el estudiante.');
            }

            $ultimoId        = Matricula::max('id') + 1;
            $codigoMatricula = 'MAT-' . date('Y') . '-' . str_pad($ultimoId, 4, '0', STR_PAD_LEFT);

            Matricula::create([
                'padre_id'         => $padre->id,
                'estudiante_id'    => $estudiante->id,
                'codigo_matricula' => $codigoMatricula,
                'anio_lectivo'     => date('Y'),
                'fecha_matricula'  => now(),
                'estado'           => 'aprobada',
            ]);

            DB::commit();

            return redirect()->route('estudiantes.show', $estudiante->id)
                ->with('success', 'Padre/tutor vinculado correctamente.');

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
            'padre_id'     => 'required|exists:padres,id',
            'estudiante_id'=> 'required|exists:estudiantes,id',
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
            'nombre'              => 'required|string|min:2|max:50',
            'apellido'            => 'required|string|min:2|max:50',
            'dni'                 => [
                'nullable','string','max:20',
                function ($attribute, $value, $fail) use ($id) {
                    if (!empty($value)) {
                        $query = Padre::where('dni', $value);
                        if ($id) $query->where('id', '!=', $id);
                        if ($query->exists()) $fail('Este DNI ya está registrado.');
                    }
                },
            ],
            'parentesco'          => 'required|string|in:padre,madre,tutor_legal,abuelo,abuela,tio,tia,otro',
            'parentesco_otro'     => 'nullable|required_if:parentesco,otro|string|max:50',
            'correo'              => [
                'nullable','email','max:100',
                function ($attribute, $value, $fail) use ($id) {
                    if (!empty($value)) {
                        $query = Padre::where('correo', $value);
                        if ($id) $query->where('id', '!=', $id);
                        if ($query->exists()) $fail('Este correo ya está registrado.');
                    }
                },
            ],
            'telefono'            => 'nullable|string|max:15',
            'telefono_secundario' => 'nullable|string|max:15',
            'direccion'           => 'nullable|string|max:255',
            'ocupacion'           => 'nullable|string|max:100',
            'lugar_trabajo'       => 'nullable|string|max:100',
            'telefono_trabajo'    => 'nullable|string|max:15',
            'estado'              => 'nullable|in:0,1',
            'observaciones'       => 'nullable|string|max:500',
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

    /**
     * Mostrar calificaciones de los hijos vinculados al padre.
     */
    public function calificaciones()
    {
        $padre = auth()->user()->padre; // Obtener el padre autenticado

        if (!$padre) {
            return redirect()->route('padres.login')->withErrors('No se encontró información del padre.');
        }

        $calificaciones = $padre->calificacionesEstudiantes();

        return view('padres.calificaciones', compact('calificaciones'));
    }
}
