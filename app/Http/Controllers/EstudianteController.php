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
      private function normalizarTexto(string $texto): string
    {
        $texto = mb_strtolower($texto, 'UTF-8');

        // Quitar tildes
        $buscar  = ['á','é','í','ó','ú','ñ','ü'];
        $reempl  = ['a','e','i','o','u','n','u'];
        $texto = str_replace($buscar, $reempl, $texto);

        // Dejar solo letras
        return preg_replace('/[^a-z]/', '', $texto);
    }

    /* ============================================================
       LISTAR ESTUDIANTES
       ============================================================ */
    public function index()
    {
        // Paginación para que funcionen ->total(), ->links(), etc.
        $estudiantes = Estudiante::orderBy('apellido1')
            ->orderBy('apellido2')
            ->orderBy('nombre1')
            ->orderBy('nombre2')
            ->paginate(10);

        return view('estudiantes.index', compact('estudiantes'));
    }

    /* ============================================================
       FORMULARIO DE CREACIÓN
       ============================================================ */
    public function create()
    {
        $grados = Estudiante::grados();
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

            // Documentos:
            'acta_nacimiento'  => 'required|file|mimes:jpg,png,pdf|max:5120',
            'calificaciones'   => 'required|file|mimes:jpg,png,pdf|max:5120',
        ]);

        /* ============================================================
           1. Preparar datos reales de estudiante
        ============================================================ */
        $data = $request->only([
            'nombre1', 'nombre2', 'apellido1', 'apellido2', 'dni',
            'fecha_nacimiento', 'sexo', 'telefono', 'direccion',
            'grado', 'seccion', 'estado', 'observaciones'
        ]);

        if (empty($data['estado'])) {
            $data['estado'] = 'activo';
        }

        /* ============================================================
           2. GENERAR CORREO AUTOMÁTICO
        ============================================================ */
        $nombreNorm = $this->normalizarTexto($data['nombre1']);
        $apellidoNorm = $this->normalizarTexto($data['apellido1']);

        $email = "{$nombreNorm}.{$apellidoNorm}@egm.edu.hn";
        $data['email'] = $email;

        /* ============================================================
           3. Subir foto del estudiante (opcional)
        ============================================================ */
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('estudiantes', 'public');
        }

        /* ============================================================
           4. Crear Estudiante
        ============================================================ */
        $estudiante = Estudiante::create($data);

        /* ============================================================
           5. Crear Documentos del estudiante
        ============================================================ */
        Documento::create([
            'estudiante_id'    => $estudiante->id,
            'foto'             => $estudiante->foto ?? null,
            'acta_nacimiento'  => $request->file('acta_nacimiento')->store('documentos/actas', 'public'),
            'calificaciones'   => $request->file('calificaciones')->store('documentos/calificaciones', 'public'),
        ]);

        /* ============================================================
           6. CREAR USUARIO DEL SISTEMA PARA EL ESTUDIANTE
           contraseña genérica:  egm2025
        ============================================================ */

        \App\Models\User::create([
            'name'      => $estudiante->nombre_completo,
            'email'     => $email,
            'password'  => Hash::make('egm2025'),
            'id_rol'    => 4, // Rol estudiante
            'activo'    => 1
        ]);

        /* ============================================================
           7. Redirigir a vista de documentos o al perfil del estudiante
        ============================================================ */

        return redirect()
            ->route('estudiantes.show', $estudiante->id)
            ->with('success', "Estudiante registrado correctamente.
             Correo: $email | Contraseña: egm2025");
    }

        /* ============================================================
       VER DETALLE DE ESTUDIANTE
       ============================================================ */
    public function show(Estudiante $estudiante)
    {
        return view('estudiantes.show', compact('estudiante'));
    }


    /* ============================================================
       FORMULARIO DE EDICIÓN
       ============================================================ */
    public function edit(Estudiante $estudiante)
    {
        $grados = Estudiante::grados();
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

        /* ============================================================
           Actualizar FOTO si viene una nueva
        ============================================================ */
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
        // Eliminar foto
        if ($estudiante->foto && Storage::disk('public')->exists($estudiante->foto)) {
            Storage::disk('public')->delete($estudiante->foto);
        }

        // Eliminar documentos asociados
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
}







