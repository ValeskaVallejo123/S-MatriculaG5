<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\Padre;
use App\Models\Estudiante;
use App\Models\User;
use App\Models\Notificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MatriculaController extends Controller
{
    /**
     * Listado de matrículas (Admin/SuperAdmin)
     */
    public function index(Request $request)
    {
        $query = Matricula::with(['estudiante', 'padre']);

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->whereHas('estudiante', function ($q) use ($buscar) {
                $q->where('nombre1', 'like', "%$buscar%")
                  ->orWhere('apellido1', 'like', "%$buscar%")
                  ->orWhere('dni', 'like', "%$buscar%");
            });
        }

        if ($request->filled('grado')) {
            $query->whereHas('estudiante', fn($q) => $q->where('grado', $request->grado));
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('anio')) {
            $query->where('anio_lectivo', $request->anio);
        }

        $matriculas = $query->latest()->paginate(15);

        return view('matriculas.index', [
            'matriculas' => $matriculas,
            'aprobadas' => Matricula::where('estado','aprobada')->count(),
            'pendientes' => Matricula::where('estado','pendiente')->count(),
            'rechazadas' => Matricula::where('estado','rechazada')->count(),
        ]);
    }

    /**
     * Guardar matrícula
     */
    public function store(Request $request)
    {
        $esPublico = $request->is('matricula-publica');

        $validated = $request->validate([
            'padre_nombre' => 'required|string|max:50',
            'padre_apellido' => 'required|string|max:50',
            'padre_dni' => 'required|string|max:13',
            'padre_parentesco' => 'required|string',
            'padre_email' => $esPublico ? 'required|email|unique:users,email' : 'nullable|email',
            'padre_telefono' => 'required|string|max:15',
            'padre_direccion' => 'required|string|max:255',

            'estudiante_nombre' => 'required|string|max:100',
            'estudiante_apellido' => 'required|string|max:100',
            'estudiante_dni' => 'required|string|max:13',
            'estudiante_fecha_nacimiento' => 'required|date',
            'estudiante_sexo' => 'required',
            'estudiante_grado' => 'required',
            'estudiante_seccion' => 'required',

            'anio_lectivo' => 'required|digits:4',
        ]);

        try {
            DB::beginTransaction();

            $padre = Padre::firstOrCreate(
                ['dni' => $validated['padre_dni']],
                [
                    'nombre' => $validated['padre_nombre'],
                    'apellido' => $validated['padre_apellido'],
                    'correo' => $validated['padre_email'] ?? null,
                    'telefono' => $validated['padre_telefono'],
                    'direccion' => $validated['padre_direccion'],
                    'parentesco' => $validated['padre_parentesco'],
                    'estado' => 1,
                ]
            );

            if ($esPublico && !User::where('email', $validated['padre_email'])->exists()) {
                User::create([
                    'name' => "{$validated['padre_nombre']} {$validated['padre_apellido']}",
                    'email' => $validated['padre_email'],
                    'password' => Hash::make($validated['padre_dni']),
                    'id_rol' => 5,
                    'email_verified_at' => now(),
                ]);
            }

            $estudiante = Estudiante::create([
                'nombre1' => $validated['estudiante_nombre'],
                'apellido1' => $validated['estudiante_apellido'],
                'dni' => $validated['estudiante_dni'],
                'fecha_nacimiento' => $validated['estudiante_fecha_nacimiento'],
                'sexo' => ucfirst($validated['estudiante_sexo']),
                'grado' => $validated['estudiante_grado'],
                'seccion' => $validated['estudiante_seccion'],
                'estado' => 'activo',
                'padre_id' => $padre->id,
            ]);

            $codigo = 'MAT-' . $validated['anio_lectivo'] . '-' .
                      str_pad(Matricula::count() + 1, 4, '0', STR_PAD_LEFT);

            $matricula = Matricula::create([
                'padre_id' => $padre->id,
                'estudiante_id' => $estudiante->id,
                'codigo_matricula' => $codigo,
                'anio_lectivo' => $validated['anio_lectivo'],
                'estado' => 'pendiente',
            ]);

            DB::commit();

            // 🔔 NOTIFICAR ADMIN Y SUPERADMIN
            $this->notificarAdmins(
                'Nueva matrícula',
                "Matrícula {$codigo} pendiente de aprobación"
            );

            return redirect()->route('matriculas.index')
                ->with('success', "Matrícula creada correctamente ({$codigo})");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Aprobar matrícula
     */
    public function confirmar(Matricula $matricula)
    {
        $matricula->update(['estado' => 'aprobada']);

        $this->notificarAdmins(
            'Matrícula aprobada',
            "La matrícula {$matricula->codigo_matricula} fue aprobada"
        );

        return back()->with('success', 'Matrícula aprobada correctamente.');
    }

    /**
     * Rechazar matrícula
     */
    public function rechazar(Request $request, Matricula $matricula)
    {
        $request->validate(['motivo_rechazo' => 'required|string|max:500']);

        $matricula->update([
            'estado' => 'rechazada',
            'motivo_rechazo' => $request->motivo_rechazo
        ]);

        $this->notificarAdmins(
            'Matrícula rechazada',
            "La matrícula {$matricula->codigo_matricula} fue rechazada"
        );

        return back()->with('success', 'Matrícula rechazada.');
    }

    /**
     * 🔔 Método reutilizable de notificación
     */
    private function notificarAdmins(string $titulo, string $mensaje)
    {
        $usuarios = User::whereIn('id_rol', [1, 2])->get();

        foreach ($usuarios as $usuario) {
            $pref = $usuario->notificacionPreferencias;

            if (!$pref || !$pref->mensaje_interno || !$pref->notificacion_matricula) {
                continue;
            }

            Notificacion::create([
                'user_id' => $usuario->id,
                'titulo' => $titulo,
                'mensaje' => $mensaje,
                'tipo' => 'notificacion_matricula',
                'leida' => false,
            ]);
        }
    }
}
