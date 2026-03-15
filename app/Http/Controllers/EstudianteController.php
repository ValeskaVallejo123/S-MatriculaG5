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
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // Si la ruta que se está pidiendo es el historial, DEJA PASAR al estudiante
            if ($request->routeIs('estudiante.historial')) {
                return $next($request);
            }

            // Para todo lo demás (crear, editar, borrar), se mantiene la regla de tus compañeros
            if (!Auth::check() || !in_array(Auth::user()->id_rol, [1, 2])) {
                abort(403, 'No tienes permisos para gestionar estudiantes.');
            }
            return $next($request);
        });
    }

    private function normalizarTexto(string $texto): string
    {
        $texto = mb_strtolower($texto, 'UTF-8');
        $buscar  = ['á','é','í','ó','ú','ñ','ü'];
        $reempl  = ['a','e','i','o','u','n','u'];
        $texto = str_replace($buscar, $reempl, $texto);
        return preg_replace('/[^a-z]/', '', $texto);
    }

    /* ============================================================
       LISTAR ESTUDIANTES
       ============================================================ */
    public function index()
    {
        $estudiantes = Estudiante::orderBy('apellido1')
            ->orderBy('apellido2')
            ->orderBy('nombre1')
            ->orderBy('nombre2')
            ->paginate(10);

        return view('estudiantes.index', compact('estudiantes'));
    }

    /* ============================================================
       BUSCAR ESTUDIANTES
       ============================================================ */
    public function buscar(Request $request)
    {
        $nombre  = $request->input('nombre');
        $dni     = $request->input('dni');
        $grado   = $request->input('grado');
        $estado  = $request->input('estado');

        // Se considera que hay búsqueda si al menos un campo fue enviado
        $busquedaRealizada = $request->hasAny(['nombre','dni','grado','estado'])
            && ($nombre || $dni || $grado || $estado);

        $estudiantes = Estudiante::when($nombre, function ($q) use ($nombre) {
            $q->where(function ($sub) use ($nombre) {
                $sub->where('nombre1',   'like', "%{$nombre}%")
                    ->orWhere('nombre2',   'like', "%{$nombre}%")
                    ->orWhere('apellido1', 'like', "%{$nombre}%")
                    ->orWhere('apellido2', 'like', "%{$nombre}%")
                    ->orWhereRaw("CONCAT(nombre1, ' ', apellido1) LIKE ?", ["%{$nombre}%"])
                    ->orWhereRaw("CONCAT(nombre1, ' ', nombre2, ' ', apellido1, ' ', apellido2) LIKE ?", ["%{$nombre}%"]);
            });
        })
            ->when($dni, fn($q) => $q->where('dni', 'like', "%{$dni}%"))
            ->when($grado, fn($q) => $q->where('grado', 'like', "%{$grado}%"))
            ->when($estado, fn($q) => $q->where('estado', $estado))
            ->orderBy('apellido1')
            ->orderBy('nombre1')
            ->paginate(15)
            ->appends($request->only(['nombre','dni','grado','estado']));

        return view('estudiantes.buscar', compact('estudiantes', 'busquedaRealizada'));
    }
    /* ============================================================
       CONSULTA PÚBLICA
       ============================================================ */
    public function consultarPublico(Request $request)
    {
        $dni = $request->input('dni');

        $estudiante = Estudiante::where('dni', $dni)->first();

        return view('publico.consultar-estudiante', compact('estudiante', 'dni'));
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
            'acta_nacimiento'  => 'nullable|file|mimes:jpg,png,pdf|max:5120',
            'calificaciones'   => 'nullable|file|mimes:jpg,png,pdf|max:5120',
        ]);

        $data = $request->only([
            'nombre1', 'nombre2', 'apellido1', 'apellido2', 'dni',
            'fecha_nacimiento', 'sexo', 'telefono', 'direccion',
            'grado', 'seccion', 'estado', 'observaciones'
        ]);

        if (empty($data['estado'])) {
            $data['estado'] = 'activo';
        }

        $nombreNorm   = $this->normalizarTexto($data['nombre1']);
        $apellidoNorm = $this->normalizarTexto($data['apellido1']);
        $email        = "{$nombreNorm}.{$apellidoNorm}@egm.edu.hn";
        $data['email'] = $email;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('estudiantes', 'public');
        }

        $estudiante = Estudiante::create($data);

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

        \App\Models\User::create([
            'name'     => $estudiante->nombre_completo,
            'email'    => $email,
            'password' => Hash::make('egm2025'),
            'id_rol'   => 4,
            'activo'   => 1,
        ]);

        return redirect()
            ->route('estudiantes.show', $estudiante->id)
            ->with('success', "Estudiante registrado correctamente. Correo: $email | Contraseña: egm2025");
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

    public function historial()
    {
        $user = auth()->user();

        // Buscamos al estudiante que tenga vinculado el ID del usuario que inició sesión
        $estudiante = \App\Models\Estudiante::with([
            'calificaciones.materia',
            'calificaciones.periodo'
        ])->where('user_id', $user->id) // <--- Esta es la clave: buscar por ID, no por nombre
        ->first();

        // Si no lo encuentra por ID, intentamos por el email exacto como respaldo
        if (!$estudiante) {
            $estudiante = \App\Models\Estudiante::where('email', $user->email)->firstOrFail();
        }

        $promedio = $estudiante->calificaciones->avg('nota_final') ?? 0;

        $historialAgrupado = $estudiante->calificaciones->groupBy(function($nota) {
            return $nota->periodo->anio_lectivo ?? 'Ciclo Actual';
        });

        return view('historial.show', compact('estudiante', 'historialAgrupado', 'promedio'));
    }
}
