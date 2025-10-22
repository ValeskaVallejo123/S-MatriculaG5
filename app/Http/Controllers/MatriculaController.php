<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\Padre;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class MatriculaController extends Controller
{
    public function index()
    {
        $matriculas = Matricula::with(['padre', 'estudiante'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('matriculas.index', compact('matriculas'));
    }

    public function create()
    {
        $grados = ['1° Grado', '2° Grado', '3° Grado', '4° Grado', '5° Grado', '6° Grado', '7° Grado', '8° Grado', '9° Grado'];
        $secciones = ['A', 'B', 'C', 'D'];
        $parentescos = [
            'padre' => 'Padre',
            'madre' => 'Madre',
            'tutor_legal' => 'Tutor Legal',
            'abuelo' => 'Abuelo',
            'abuela' => 'Abuela',
            'tio' => 'Tío',
            'tia' => 'Tía',
            'otro' => 'Otro'
        ];
        
        return view('matriculas.create', compact('grados', 'secciones', 'parentescos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Datos del Padre/Tutor
            'padre_nombre' => 'required|string|min:2|max:50',
            'padre_apellido' => 'required|string|min:2|max:50',
            'padre_dni' => 'required|digits:13|unique:padres,dni',
            'padre_parentesco' => 'required|in:padre,madre,tutor_legal,abuelo,abuela,tio,tia,otro',
            'padre_parentesco_otro' => 'required_if:padre_parentesco,otro|nullable|string|max:50',
            'padre_email' => 'required|email|max:100|unique:padres,email',
            'padre_telefono' => 'required|digits:8',
            'padre_telefono_secundario' => 'nullable|digits:8',
            'padre_direccion' => 'required|string|max:200',
            'padre_ocupacion' => 'nullable|string|max:100',
            'padre_lugar_trabajo' => 'nullable|string|max:100',
            'padre_telefono_trabajo' => 'nullable|digits:8',
            
            // Datos del Estudiante
            'estudiante_nombre' => 'required|string|min:2|max:50',
            'estudiante_apellido' => 'required|string|min:2|max:50',
            'estudiante_dni' => 'required|digits:13|unique:estudiantes,dni',
            'estudiante_fecha_nacimiento' => 'required|date|before:today',
            'estudiante_email' => 'nullable|email|max:100',
            'estudiante_telefono' => 'nullable|digits:8',
            'estudiante_grado' => 'required|string',
            'estudiante_seccion' => 'required|string',
            
            // Documentos (obligatorios)
            'foto_estudiante' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'acta_nacimiento' => 'required|file|mimes:pdf,jpeg,jpg,png|max:5120',
            'foto_dni_estudiante' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'foto_dni_padre' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            
            // Documentos opcionales
            'certificado_estudios' => 'nullable|file|mimes:pdf,jpeg,jpg,png|max:5120',
            'constancia_conducta' => 'nullable|file|mimes:pdf,jpeg,jpg,png|max:5120',
        ], [
            'padre_dni.unique' => 'Este DNI ya está registrado en el sistema.',
            'padre_email.unique' => 'Este correo electrónico ya está registrado.',
            'estudiante_dni.unique' => 'El DNI del estudiante ya está registrado.',
            'foto_estudiante.required' => 'La foto del estudiante es obligatoria.',
            'acta_nacimiento.required' => 'El acta de nacimiento es obligatoria.',
            'foto_dni_estudiante.required' => 'La foto del DNI del estudiante es obligatoria.',
            'foto_dni_padre.required' => 'La foto del DNI del padre/tutor es obligatoria.',
        ]);

        DB::beginTransaction();
        
        try {
            // 1. Crear Padre/Tutor
            $padre = Padre::create([
                'nombre' => $validated['padre_nombre'],
                'apellido' => $validated['padre_apellido'],
                'dni' => $validated['padre_dni'],
                'parentesco' => $validated['padre_parentesco'],
                'parentesco_otro' => $validated['padre_parentesco_otro'] ?? null,
                'email' => $validated['padre_email'],
                'telefono' => $validated['padre_telefono'],
                'telefono_secundario' => $validated['padre_telefono_secundario'] ?? null,
                'direccion' => $validated['padre_direccion'],
                'ocupacion' => $validated['padre_ocupacion'] ?? null,
                'lugar_trabajo' => $validated['padre_lugar_trabajo'] ?? null,
                'telefono_trabajo' => $validated['padre_telefono_trabajo'] ?? null,
                'estado' => 'activo'
            ]);

            // 2. Crear Estudiante
            $estudiante = Estudiante::create([
                'nombre' => $validated['estudiante_nombre'],
                'apellido' => $validated['estudiante_apellido'],
                'dni' => $validated['estudiante_dni'],
                'fecha_nacimiento' => $validated['estudiante_fecha_nacimiento'],
                'email' => $validated['estudiante_email'] ?? null,
                'telefono' => $validated['estudiante_telefono'] ?? null,
                'direccion' => $validated['padre_direccion'], // Usa la misma dirección del padre
                'grado' => $validated['estudiante_grado'],
                'seccion' => $validated['estudiante_seccion'],
                'estado' => 'activo'
            ]);

            // 3. Subir documentos
            $documentos = [];
            
            if ($request->hasFile('foto_estudiante')) {
                $documentos['foto_estudiante'] = $request->file('foto_estudiante')
                    ->store('matriculas/fotos', 'public');
            }
            
            if ($request->hasFile('acta_nacimiento')) {
                $documentos['acta_nacimiento'] = $request->file('acta_nacimiento')
                    ->store('matriculas/actas', 'public');
            }
            
            if ($request->hasFile('certificado_estudios')) {
                $documentos['certificado_estudios'] = $request->file('certificado_estudios')
                    ->store('matriculas/certificados', 'public');
            }
            
            if ($request->hasFile('constancia_conducta')) {
                $documentos['constancia_conducta'] = $request->file('constancia_conducta')
                    ->store('matriculas/constancias', 'public');
            }
            
            if ($request->hasFile('foto_dni_estudiante')) {
                $documentos['foto_dni_estudiante'] = $request->file('foto_dni_estudiante')
                    ->store('matriculas/dni_estudiantes', 'public');
            }
            
            if ($request->hasFile('foto_dni_padre')) {
                $documentos['foto_dni_padre'] = $request->file('foto_dni_padre')
                    ->store('matriculas/dni_padres', 'public');
            }

            // 4. Crear Matrícula
            $matricula = Matricula::create([
                'padre_id' => $padre->id,
                'estudiante_id' => $estudiante->id,
                'codigo_matricula' => Matricula::generarCodigoMatricula(),
                'anio_lectivo' => date('Y'),
                'fecha_matricula' => now(),
                'foto_estudiante' => $documentos['foto_estudiante'] ?? null,
                'acta_nacimiento' => $documentos['acta_nacimiento'] ?? null,
                'certificado_estudios' => $documentos['certificado_estudios'] ?? null,
                'constancia_conducta' => $documentos['constancia_conducta'] ?? null,
                'foto_dni_estudiante' => $documentos['foto_dni_estudiante'] ?? null,
                'foto_dni_padre' => $documentos['foto_dni_padre'] ?? null,
                'estado' => 'pendiente'
            ]);

            DB::commit();

            return redirect()->route('matriculas.show', $matricula)
                ->with('success', '¡Matrícula registrada exitosamente! Código: ' . $matricula->codigo_matricula);

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Eliminar archivos subidos si hubo error
            foreach ($documentos ?? [] as $documento) {
                if (Storage::disk('public')->exists($documento)) {
                    Storage::disk('public')->delete($documento);
                }
            }

            return back()->withInput()
                ->with('error', 'Error al procesar la matrícula: ' . $e->getMessage());
        }
    }

    public function show(Matricula $matricula)
    {
        $matricula->load(['padre', 'estudiante']);
        return view('matriculas.show', compact('matricula'));
    }
}