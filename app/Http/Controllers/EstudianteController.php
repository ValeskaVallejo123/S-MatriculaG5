<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Notificacion;
use App\Models\Documento;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EstudianteController extends Controller
{
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
        $buscar  = ['á','é','í','ó','ú','ñ','ü'];
        $reempl  = ['a','e','i','o','u','n','u'];
        $texto = str_replace($buscar, $reempl, $texto);
        return preg_replace('/[^a-z]/', '', $texto);
    }

    public function index()
    {
        $estudiantes = Estudiante::orderBy('apellido1')
            ->orderBy('apellido2')
            ->orderBy('nombre1')
            ->orderBy('nombre2')
            ->paginate(10);

        return view('estudiantes.index', compact('estudiantes'));
    }

    public function create()
    {
        $grados = Estudiante::grados();
        $secciones = Estudiante::secciones();
        return view('estudiantes.create', compact('grados', 'secciones'));
    }

    /* ============================================================
       GUARDAR ESTUDIANTE (CORREGIDO)
       ============================================================ */
    public function store(Request $request)
    {
        $request->validate([
            'nombre1'          => 'required|string|max:50',
            'apellido1'        => 'required|string|max:50',
            'dni'              => 'required|string|size:13|unique:estudiantes,dni',
            'fecha_nacimiento' => 'required|date',
            'sexo'             => 'required|in:masculino,femenino',
            'grado'            => 'required|string',
            'seccion'          => 'required|string',
            'foto'             => 'nullable|image|max:2048',
            'acta_nacimiento'  => 'required|file|mimes:jpg,png,pdf|max:5120',
            'calificaciones'   => 'required|file|mimes:jpg,png,pdf|max:5120',
        ]);

        $data = $request->except(['acta_nacimiento', 'calificaciones']);

        // Procesar Foto de Perfil
        if ($request->hasFile('foto')) {
            $extension = $request->file('foto')->getClientOriginalExtension();
            $nombreFoto = $request->dni . '_' . time() . '.' . $extension;
            // Guardamos en la ruta correcta: expedientes/fotos
            $request->file('foto')->storeAs('public/expedientes/fotos', $nombreFoto);
            $data['foto'] = $nombreFoto; // Guardamos solo el nombre
        }

        // Generar Email
        $nombreNorm = $this->normalizarTexto($request->nombre1);
        $apellidoNorm = $this->normalizarTexto($request->apellido1);
        $data['email'] = "{$nombreNorm}.{$apellidoNorm}@egm.edu.hn";
        $data['estado'] = $data['estado'] ?? 'activo';

        // Crear Estudiante
        $estudiante = Estudiante::create($data);

        // Crear Documentos
        Documento::create([
            'estudiante_id'    => $estudiante->id,
            'foto'             => $estudiante->foto,
            'acta_nacimiento'  => $request->file('acta_nacimiento')->store('expedientes/actas', 'public'),
            'calificaciones'   => $request->file('calificaciones')->store('expedientes/notas', 'public'),
        ]);

        // Crear Usuario
        User::create([
            'name'      => $estudiante->nombre_completo,
            'email'     => $data['email'],
            'password'  => Hash::make('egm2025'),
            'id_rol'    => 4,
            'activo'    => 1
        ]);

        return redirect()->route('estudiantes.show', $estudiante->id)
            ->with('success', "Estudiante registrado. Correo: {$data['email']}");
    }

    public function show(Estudiante $estudiante)
    {
        $estudiante->load('documentos');
        return view('estudiantes.show', compact('estudiante'));
    }

    public function edit(Estudiante $estudiante)
    {
        $grados = Estudiante::grados();
        $secciones = Estudiante::secciones();
        return view('estudiantes.edit', compact('estudiante', 'grados', 'secciones'));
    }

    /* ============================================================
       ACTUALIZAR ESTUDIANTE (CORREGIDO)
       ============================================================ */
    public function update(Request $request, Estudiante $estudiante)
    {
        $request->validate([
            'nombre1' => 'required',
            'apellido1' => 'required',
            'dni' => 'required|string|size:13|unique:estudiantes,dni,' . $estudiante->id,
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            // Eliminar foto anterior si existe
            if ($estudiante->foto) {
                Storage::disk('public')->delete('expedientes/fotos/' . $estudiante->foto);
            }

            $extension = $request->file('foto')->getClientOriginalExtension();
            $nombreFoto = $request->dni . '_' . time() . '.' . $extension;

            // Subir nueva foto
            $request->file('foto')->storeAs('public/expedientes/fotos', $nombreFoto);
            $data['foto'] = $nombreFoto;

            // Sincronizar con la tabla documentos (opcional, actualiza el último)
            $documento = Documento::where('estudiante_id', $estudiante->id)->latest()->first();
            if($documento) {
                $documento->update(['foto' => $nombreFoto]);
            }
        }

        $estudiante->update($data);

        return redirect()->route('estudiantes.show', $estudiante->id)
            ->with('success', 'Estudiante actualizado correctamente.');
    }

    public function destroy(Estudiante $estudiante)
    {
        if ($estudiante->foto) {
            Storage::disk('public')->delete('expedientes/fotos/' . $estudiante->foto);
        }
        $estudiante->delete();
        return redirect()->route('estudiantes.index')->with('success', 'Eliminado.');
    }
}
