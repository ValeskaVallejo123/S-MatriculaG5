<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Notificacion;
use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EstudianteController extends Controller
{
    /**
     * Middleware: solo SuperAdmin (id_rol = 1) y Admin (id_rol = 2)
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || !in_array(Auth::user()->id_rol, [1, 2])) {
                abort(403, 'No tienes permisos para gestionar estudiantes.');
            }
            return $next($request);
        });
    }

    /* ============================================================
       NORMALIZAR TEXTO (quitar tildes, espacios, caracteres especiales)
       ============================================================ */
    private function normalizarTexto(string $texto): string
    {
        $texto = mb_strtolower($texto, 'UTF-8');

        $buscar  = ['á','é','í','ó','ú','ñ','ü','Á','É','Í','Ó','Ú','Ñ','Ü'];
        $reempl  = ['a','e','i','o','u','n','u','a','e','i','o','u','n','u'];
        $texto   = str_replace($buscar, $reempl, $texto);

        return preg_replace('/[^a-z]/', '', $texto);
    }

    /* ============================================================
       GENERAR EMAIL ÚNICO
       Estrategia:
         1. nombre1.apellido1
         2. nombre1.nombre2.apellido1
         3. nombre1.apellido1.apellido2
         4. nombre1.nombre2.apellido1.apellido2
         5. nombre1.apellido1.2, .3, .4 ... (incremental)
       ============================================================ */
    private function generarEmailUnico(
        string $nombre1,
        ?string $nombre2,
        string $apellido1,
        ?string $apellido2
    ): string {
        $n1 = $this->normalizarTexto($nombre1);
        $n2 = $nombre2  ? $this->normalizarTexto($nombre2)  : null;
        $a1 = $this->normalizarTexto($apellido1);
        $a2 = $apellido2 ? $this->normalizarTexto($apellido2) : null;

        $dominio = '@egm.edu.hn';

        // Candidatos en orden de preferencia
        $candidatos = [
            "{$n1}.{$a1}",
        ];

        if ($n2) {
            $candidatos[] = "{$n1}.{$n2}.{$a1}";
        }
        if ($a2) {
            $candidatos[] = "{$n1}.{$a1}.{$a2}";
        }
        if ($n2 && $a2) {
            $candidatos[] = "{$n1}.{$n2}.{$a1}.{$a2}";
        }

        // Intentar cada combinación
        foreach ($candidatos as $base) {
            $email = $base . $dominio;
            if (!\App\Models\User::where('email', $email)->exists()) {
                return $email;
            }
        }

        // Si todos existen → incremental: nombre1.apellido1.2@, .3@, ...
        $baseIncremental = "{$n1}.{$a1}";
        $contador = 2;
        do {
            $email = "{$baseIncremental}.{$contador}{$dominio}";
            $contador++;
        } while (\App\Models\User::where('email', $email)->exists());

        return $email;
    }

    /* ============================================================
       LISTAR ESTUDIANTES
       ============================================================ */
public function index(Request $request)
{
    $perPage = in_array((int) $request->get('per_page'), [10, 25, 50])
        ? (int) $request->get('per_page')
        : 10;

    $query = Estudiante::orderBy('apellido1')->orderBy('apellido2')
                       ->orderBy('nombre1')->orderBy('nombre2');

    if ($request->filled('buscar')) {
        $buscar = $request->buscar;
        $query->where(function ($q) use ($buscar) {
            $q->where('nombre1',   'like', "%{$buscar}%")
              ->orWhere('nombre2',   'like', "%{$buscar}%")
              ->orWhere('apellido1', 'like', "%{$buscar}%")
              ->orWhere('apellido2', 'like', "%{$buscar}%")
              ->orWhere('dni',       'like', "%{$buscar}%")
              ->orWhere('grado',     'like', "%{$buscar}%")
              ->orWhere('email',     'like', "%{$buscar}%");
        });
    }

    $estudiantes = $query->paginate($perPage)->withQueryString();

    if ($request->ajax()) {
        return response()->json([
            'html'       => view('estudiantes.partials.tabla', compact('estudiantes'))->render(),
            'pagination' => view('estudiantes.partials.paginacion', compact('estudiantes'))->render(),
            'total'      => $estudiantes->total(),
            'desde'      => $estudiantes->firstItem() ?? 0,
            'hasta'      => $estudiantes->lastItem()  ?? 0,
        ]);
    }

    return view('estudiantes.index', compact('estudiantes'));

}
    /* ============================================================
       FORMULARIO DE CREACIÓN
       ============================================================ */
    public function create()
    {
        $grados    = Estudiante::grados();
        $secciones = Estudiante::secciones();

        return view('estudiantes.create', compact('grados', 'secciones'));
    }

    /* ============================================================
       GUARDAR ESTUDIANTE
       ============================================================ */
    public function store(Request $request)
    {
        $request->validate([
            'nombre1'          => 'required|string|max:50',
            'nombre2'          => 'nullable|string|max:50',
            'apellido1'        => 'required|string|max:50',
            'apellido2'        => 'nullable|string|max:50',
            'dni'              => 'required|string|size:13|unique:estudiantes,dni',
            'fecha_nacimiento' => 'required|date',
            'sexo'             => 'required|in:masculino,femenino',
            'telefono'         => 'nullable|string|max:15',
            'direccion'        => 'nullable|string|max:200',
            'grado'            => 'required|string',
            'seccion'          => 'required|string',
            'estado'           => 'nullable|in:activo,inactivo,retirado,suspendido',
            'observaciones'    => 'nullable|string|max:500',
            'foto'             => 'nullable|image|max:2048',
            'acta_nacimiento'  => 'required|file|mimes:jpg,png,pdf|max:5120',
            'calificaciones'   => 'required|file|mimes:jpg,png,pdf|max:5120',
        ]);

        /* ------------------------------------------------------------
           1. Preparar datos del estudiante
        ------------------------------------------------------------ */
        $data = $request->only([
            'nombre1', 'nombre2', 'apellido1', 'apellido2', 'dni',
            'fecha_nacimiento', 'sexo', 'telefono', 'direccion',
            'grado', 'seccion', 'estado', 'observaciones',
        ]);

        if (empty($data['estado'])) {
            $data['estado'] = 'activo';
        }

        /* ------------------------------------------------------------
           2. Generar correo único automático
        ------------------------------------------------------------ */
        $email = $this->generarEmailUnico(
            $data['nombre1'],
            $data['nombre2']  ?? null,
            $data['apellido1'],
            $data['apellido2'] ?? null
        );

        $data['email'] = $email;

        /* ------------------------------------------------------------
           3. Subir foto del estudiante (opcional)
        ------------------------------------------------------------ */
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('estudiantes', 'public');
        }

        /* ------------------------------------------------------------
           4. Crear estudiante
        ------------------------------------------------------------ */
        $estudiante = Estudiante::create($data);

        /* ------------------------------------------------------------
           5. Crear documentos asociados
        ------------------------------------------------------------ */
        Documento::create([
            'estudiante_id'   => $estudiante->id,
            'foto'            => $estudiante->foto ?? null,
            'acta_nacimiento' => $request->hasFile('acta_nacimiento')
                ? $request->file('acta_nacimiento')->store('documentos/actas', 'public')
                : null,
            'calificaciones'  => $request->hasFile('calificaciones')
                ? $request->file('calificaciones')->store('documentos/calificaciones', 'public')
                : null,
        ]);

        /* ------------------------------------------------------------
           6. Crear usuario del sistema para el estudiante
        ------------------------------------------------------------ */
        \App\Models\User::create([
            'name'     => $estudiante->nombre_completo,
            'email'    => $email,
            'password' => Hash::make('egm2025'),
            'id_rol'   => 4,
            'activo'   => 1,
        ]);

        return redirect()
            ->route('estudiantes.show', $estudiante->id)
            ->with('success', "Estudiante registrado correctamente. Correo: {$email} | Contraseña: egm2025");
    }

    /* ============================================================
       VER DETALLE DE ESTUDIANTE
       ============================================================ */
    public function show(Estudiante $estudiante)
    {
        $estudiante->load('padres');
        return view('estudiantes.show', compact('estudiante'));
    }

    /* ============================================================
       FORMULARIO DE EDICIÓN
       ============================================================ */
    public function edit(Estudiante $estudiante)
    {
        $grados    = Estudiante::grados();
        $secciones = Estudiante::secciones();

        return view('estudiantes.edit', compact('estudiante', 'grados', 'secciones'));
    }

    /* ============================================================
       ACTUALIZAR ESTUDIANTE
       ============================================================ */
    public function update(Request $request, Estudiante $estudiante)
    {
        $request->validate([
            'nombre1'          => 'required|string|max:50',
            'nombre2'          => 'nullable|string|max:50',
            'apellido1'        => 'required|string|max:50',
            'apellido2'        => 'nullable|string|max:50',
            'dni'              => 'required|string|size:13|unique:estudiantes,dni,' . $estudiante->id,
            'fecha_nacimiento' => 'required|date',
            'sexo'             => 'required|in:masculino,femenino',
            'email'            => 'nullable|email|max:100',
            'telefono'         => 'nullable|string|max:15',
            'direccion'        => 'nullable|string|max:200',
            'grado'            => 'required|string',
            'seccion'          => 'required|string',
            'estado'           => 'required|in:activo,inactivo,retirado,suspendido',
            'observaciones'    => 'nullable|string|max:500',
            'foto'             => 'nullable|image|max:2048',
        ]);

        $data = $request->only([
            'nombre1', 'nombre2', 'apellido1', 'apellido2',
            'dni', 'fecha_nacimiento', 'sexo', 'email',
            'telefono', 'direccion', 'grado', 'seccion',
            'estado', 'observaciones',
        ]);

        if ($request->hasFile('foto')) {
            if ($estudiante->foto && Storage::disk('public')->exists($estudiante->foto)) {
                Storage::disk('public')->delete($estudiante->foto);
            }
            $data['foto'] = $request->file('foto')->store('estudiantes', 'public');
        }

        $estudiante->update($data);

        return redirect()
            ->route('estudiantes.show', $estudiante->id)
            ->with('success', 'Estudiante actualizado correctamente.');
    }

    /* ============================================================
       ELIMINAR ESTUDIANTE
       ============================================================ */
    public function destroy(Estudiante $estudiante)
    {
        if ($estudiante->foto && Storage::disk('public')->exists($estudiante->foto)) {
            Storage::disk('public')->delete($estudiante->foto);
        }

        if ($estudiante->documentos) {
            $docs = $estudiante->documentos;

            foreach (['foto','acta_nacimiento','calificaciones','tarjeta_identidad_padre','constancia_medica'] as $campo) {
                if ($docs->$campo && Storage::disk('public')->exists($docs->$campo)) {
                    Storage::disk('public')->delete($docs->$campo);
                }
            }

            $docs->delete();
        }

        $estudiante->delete();

        return redirect()
            ->route('estudiantes.index')
            ->with('success', 'Estudiante eliminado correctamente.');
    }

    /* ============================================================
       VER NOTIFICACIONES DEL ESTUDIANTE
       ============================================================ */
    public function notificaciones($id)
    {
        $estudiante = Estudiante::findOrFail($id);

        $notificaciones = Notificacion::where('estudiante_id', $estudiante->id)
            ->orderByDesc('created_at')
            ->get();

        return view('estudiantes.notificaciones', compact('estudiante', 'notificaciones'));
    }

    /* ============================================================
       MARCAR NOTIFICACIÓN COMO LEÍDA
       ============================================================ */
    public function marcarLeida($id)
    {
        $notificacion = Notificacion::findOrFail($id);
        $notificacion->update(['leida' => true]);

        return back()->with('success', 'Notificación marcada como leída.');
    }

    /* ============================================================
       HISTORIAL PARA EL ESTUDIANTE (Solo Lectura)
       ============================================================ */
    public function historial()
    {
        $user = auth()->user();

        $estudiante = \App\Models\Estudiante::with(['calificaciones.materia', 'calificaciones.periodo'])
            ->where('email', $user->email)
            ->first();

        if (!$estudiante) {
            return redirect()->route('estudiante.dashboard')
                ->with('error', 'No se encontró tu perfil de estudiante.');
        }

        $promedio          = $estudiante->calificaciones->avg('nota_final') ?? 0;
        $historialAgrupado = $estudiante->calificaciones
            ->groupBy(fn($n) => $n->periodo->anio_lectivo ?? 'Ciclo Actual');

        return view('historial.show', compact('estudiante', 'historialAgrupado', 'promedio'))
            ->with('readonly', true);
    }

    /* ============================================================
       HISTORIAL PARA ADMIN (Lectura y Edición)
       ============================================================ */
    public function verHistorialAdmin($id)
    {
        $estudiante = \App\Models\Estudiante::with(['calificaciones.materia', 'calificaciones.periodo'])
            ->findOrFail($id);

        $promedio          = $estudiante->calificaciones->avg('nota_final') ?? 0;
        $historialAgrupado = $estudiante->calificaciones
            ->groupBy(fn($n) => $n->periodo->anio_lectivo ?? 'Ciclo Actual');

        return view('historial.show', compact('estudiante', 'historialAgrupado', 'promedio'))
            ->with('readonly', false);
    }

    public function editHistorialAdmin($id)
    {
        $estudiante     = \App\Models\Estudiante::findOrFail($id);
        $calificaciones = \App\Models\Calificacion::where('estudiante_id', $id)
            ->with('materia')
            ->get();

        return view('historial.edit', compact('estudiante', 'calificaciones'));
    }

    public function updateHistorialAdmin(Request $request, $id)
    {
        $estudiante        = \App\Models\Estudiante::findOrFail($id);
        $cambiosRealizados = false;

        if ($request->has('notas')) {
            foreach ($request->notas as $calificacionId => $nuevoValor) {
                $calificacion = \App\Models\Calificacion::find($calificacionId);

                if ($calificacion && $calificacion->estudiante_id == $id) {
                    if ($calificacion->nota != $nuevoValor) {
                        $calificacion->update(['nota' => $nuevoValor]);
                        $cambiosRealizados = true;
                    }
                }
            }
        }

        $mensaje = $cambiosRealizados
            ? ['success' => '¡Éxito! Los cambios se han guardado correctamente.']
            : ['info'    => 'No se realizaron cambios en el historial académico.'];

        return redirect()
            ->route('superadmin.estudiantes.historial.show', $id)
            ->with($mensaje);
    }
}