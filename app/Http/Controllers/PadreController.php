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
     * Mostrar lista de padres
     */
    public function index(Request $request)
    {
        if (in_array(Auth::user()->id_rol, [1, 2, 3])) {
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

            $padres        = $query->orderBy('nombre')->paginate($perPage)->withQueryString();
            $totalPadres   = Padre::count();
            $totalActivos  = Padre::where('estado', 'activo')->count();
            $totalConHijos = Padre::has('estudiantes')->count();

            return view('padre.admin-index', compact(
                'padres', 'totalPadres', 'totalActivos', 'totalConHijos'
            ));
        }

        return view('padre.index');
    }

    /**
     * Mostrar formulario de creación
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
        $validated['estado'] = 'activo';

        // Manejar foto
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('padres', 'public');
        }

        $padre = Padre::create($validated);

        // Crear usuario si tiene correo y no existe
        $correoPadre = $padre->correo ?? null;
        $padreRolId  = DB::table('roles')->where('nombre', 'Padre')->value('id');

        if ($padreRolId && $correoPadre && !DB::table('users')->where('email', $correoPadre)->exists()) {
            DB::table('users')->insert([
                'name'              => $padre->nombre . ' ' . $padre->apellido,
                'email'             => $correoPadre,
                'password'          => Hash::make('Padre2025!'),
                'id_rol'            => $padreRolId,
                'user_type'         => 'padre',
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
            $msg .= ' Contraseña inicial: Padre2025!';
        }

        return redirect()->route('padres.index')->with('success', $msg);
    }

    /**
     * Mostrar detalles
     */
    public function show($id)
    {
        $padre = Padre::with(['estudiantes.gradoAsignado'])->findOrFail($id);
        return view('padre.show', compact('padre'));
    }

    /**
     * Formulario de edición
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
        $padre     = Padre::findOrFail($id);
        $validated = $this->validarPadre($request, $id);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('padres', 'public');
        }

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
     * Buscar padres
     */
    public function buscar(Request $request)
    {
        $query = Padre::query();

        foreach (['nombre', 'apellido', 'dni', 'correo', 'telefono'] as $campo) {
            if ($request->filled($campo)) {
                $query->where($campo, 'like', '%' . $request->$campo . '%');
            }
        }

        $padres = $request->anyFilled(['nombre', 'apellido', 'dni', 'correo', 'telefono'])
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
        ], [
            'estudiante_id.required' => 'Debes seleccionar un estudiante.',
            'estudiante_id.exists'   => 'El estudiante seleccionado no existe.',
        ]);

        try {
            DB::beginTransaction();

            $estudiante = Estudiante::findOrFail($request->estudiante_id);

            $matriculaExistente = Matricula::where('padre_id', $padre->id)
                ->where('estudiante_id', $estudiante->id)
                ->first();

            if ($matriculaExistente) {
                return back()->with('error', 'Este padre ya está vinculado con el estudiante seleccionado.');
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
                ->with('success', 'Padre/tutor vinculado correctamente al estudiante.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un error al vincular: ' . $e->getMessage());
        }
    }

    /**
     * Desvincular padre de estudiante
     */
    public function desvincular(Request $request)
    {
        $this->authorizeRol();

        $request->validate([
            'padre_id'      => 'required|exists:padres,id',
            'estudiante_id' => 'required|exists:estudiantes,id',
        ], [
            'padre_id.required'      => 'El padre es requerido.',
            'estudiante_id.required' => 'El estudiante es requerido.',
        ]);

        try {
            DB::beginTransaction();

            $matricula = Matricula::where('padre_id', $request->padre_id)
                ->where('estudiante_id', $request->estudiante_id)
                ->first();

            if (!$matricula) {
                return back()->with('error', 'No existe vinculación entre este padre y el estudiante.');
            }

            $matricula->delete();
            DB::commit();

            return back()->with('success', 'Vinculación eliminada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un error al desvincular: ' . $e->getMessage());
        }
    }

    // ──────────────────────────────────────────
    //  PRIVADOS
    // ──────────────────────────────────────────

    /**
     * Validar y mapear campos del formulario al modelo
     */
    private function validarPadre(Request $request, $id = null)
    {
        // Mapear campos del formulario → campos del modelo
        $request->merge([
            'nombre'              => trim(($request->nombre1 ?? '') . ' ' . ($request->nombre2 ?? '')),
            'apellido'            => trim(($request->apellido1 ?? '') . ' ' . ($request->apellido2 ?? '')),
            'parentesco'          => $request->relacion ?? $request->parentesco,
            'telefono_secundario' => $request->telefono_alt ?? $request->telefono_secundario,
        ]);

        return $request->validate([
            'nombre'              => 'required|string|min:2|max:100',
            'apellido'            => 'required|string|min:2|max:100',
            'dni'                 => [
                'nullable', 'string', 'max:20',
                function ($attribute, $value, $fail) use ($id) {
                    if (!empty($value)) {
                        $query = Padre::where('dni', $value);
                        if ($id) $query->where('id', '!=', $id);
                        if ($query->exists()) {
                            $fail('Este número de DNI ya está registrado en el sistema.');
                        }
                    }
                },
            ],
            'parentesco'          => 'required|string|in:padre,madre,tutor_legal,abuelo,abuela,tio,tia,hermano,tutor,otro',
            'parentesco_otro'     => 'nullable|string|max:50',
            'correo'              => [
                'nullable', 'email', 'max:100',
                function ($attribute, $value, $fail) use ($id) {
                    if (!empty($value)) {
                        $query = Padre::where('correo', $value);
                        if ($id) $query->where('id', '!=', $id);
                        if ($query->exists()) {
                            $fail('Este correo electrónico ya está registrado en el sistema.');
                        }
                    }
                },
            ],
            'telefono'            => 'nullable|string|max:15',
            'telefono_secundario' => 'nullable|string|max:15',
            'direccion'           => 'nullable|string|max:255',
            'ocupacion'           => 'nullable|string|max:100',
            'lugar_trabajo'       => 'nullable|string|max:100',
            'telefono_trabajo'    => 'nullable|string|max:15',
            'estado'              => 'nullable|string|in:activo,inactivo',
            'observaciones'       => 'nullable|string|max:500',
        ], [
            // Mensajes en español
            'nombre.required'        => 'El nombre es obligatorio.',
            'nombre.min'             => 'El nombre debe tener al menos 2 caracteres.',
            'nombre.max'             => 'El nombre no puede superar 100 caracteres.',
            'nombre.string'          => 'El nombre debe ser texto.',
            'apellido.required'      => 'El apellido es obligatorio.',
            'apellido.min'           => 'El apellido debe tener al menos 2 caracteres.',
            'apellido.max'           => 'El apellido no puede superar 100 caracteres.',
            'apellido.string'        => 'El apellido debe ser texto.',
            'parentesco.required'    => 'Debes seleccionar la relación con el estudiante.',
            'parentesco.in'          => 'La relación seleccionada no es válida.',
            'correo.email'           => 'El correo electrónico no tiene un formato válido.',
            'correo.max'             => 'El correo no puede superar 100 caracteres.',
            'dni.max'                => 'El DNI no puede superar 20 caracteres.',
            'telefono.max'           => 'El teléfono no puede superar 15 caracteres.',
            'telefono_secundario.max'=> 'El teléfono alternativo no puede superar 15 caracteres.',
            'direccion.max'          => 'La dirección no puede superar 255 caracteres.',
            'ocupacion.max'          => 'La ocupación no puede superar 100 caracteres.',
            'lugar_trabajo.max'      => 'El lugar de trabajo no puede superar 100 caracteres.',
            'observaciones.max'      => 'Las observaciones no pueden superar 500 caracteres.',
            'estado.in'              => 'El estado debe ser activo o inactivo.',
        ]);
    }

    /**
     * Autorizar solo SuperAdmin o Administrador
     */
    private function authorizeRol()
    {
        $user = auth()->user();
        if (!$user->isSuperAdmin() && !$user->isAdmin() && !method_exists($user, 'isAdministrador')) {
            if (!in_array($user->id_rol, [1, 2, 3])) {
                abort(403, 'No tienes permiso para realizar esta acción.');
            }
        }
    }
}