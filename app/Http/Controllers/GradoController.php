<?php

namespace App\Http\Controllers;

use App\Models\Grado;
use App\Models\Materia;
use App\Models\Profesor;
use App\Models\Seccion;
use App\Helpers\GradoHelper;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class GradoController extends Controller
{
    private const MATERIAS_DEFAULT_PRIMARIA = [
        'Español', 'Matemáticas', 'Ciencias Naturales', 'Ciencias Sociales',
        'Educación Artística', 'Educación Física', 'Inglés', 'Informática',
    ];

    private const MATERIAS_DEFAULT_SECUNDARIA = [
        'Español', 'Matemáticas', 'Ciencias Naturales', 'Ciencias Sociales',
        'Educación Física', 'Educación Artística', 'Inglés', 'Informática',
        'Química', 'Física', 'Biología', 'Historia', 'Geografía', 'Formación Ciudadana',
    ];

    private function asignarMateriasPorDefecto(Grado $grado): void
    {
        $nombres = $grado->nivel === 'primaria'
            ? self::MATERIAS_DEFAULT_PRIMARIA
            : self::MATERIAS_DEFAULT_SECUNDARIA;

        $ids = Materia::whereIn('nombre', $nombres)
            ->where('nivel', $grado->nivel)
            ->where('activo', true)
            ->pluck('id')
            ->toArray();

        if (empty($ids)) return;

        $syncData = [];
        foreach ($ids as $id) {
            $syncData[$id] = ['horas_semanales' => 4, 'profesor_id' => null];
        }

        $grado->materias()->syncWithoutDetaching($syncData);
    }

    // ── Index ──────────────────────────────────────────────────────
    public function index()
    {
        $grados = Grado::with(['materias', 'estudiantes'])
            ->orderBy('nivel')->orderBy('numero')->orderBy('seccion')
            ->paginate(request('per_page', 15));

        return view('grados.index', compact('grados'));
    }

    // ── Create / Store ─────────────────────────────────────────────
    public function create()
    {
        return view('grados.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nivel'        => 'required|in:primaria,secundaria',
            'numero'       => 'required|integer|min:1|max:9',
            'seccion'      => 'required|in:A,B,C,D',
            'anio_lectivo' => 'required|integer|min:2020|max:2100',
            'capacidad'    => 'required|integer|min:1|max:60',
            'activo'       => 'nullable|boolean',
        ]);

        if ($validated['nivel'] === 'primaria' && $validated['numero'] > 6)
            return back()->withInput()->with('error', 'Primaria solo puede tener grados del 1° al 6°.');

        if ($validated['nivel'] === 'secundaria' && $validated['numero'] < 7)
            return back()->withInput()->with('error', 'Secundaria solo puede tener grados del 7° al 9°.');

        if (Grado::where('nivel', $validated['nivel'])
                 ->where('numero', $validated['numero'])
                 ->where('seccion', $validated['seccion'])
                 ->where('anio_lectivo', $validated['anio_lectivo'])
                 ->exists()) {
            return back()->withInput()->with('error', '¡Este grado ya existe para ese año lectivo!');
        }

        $grado = Grado::create([
            'nivel'        => $validated['nivel'],
            'numero'       => $validated['numero'],
            'seccion'      => $validated['seccion'],
            'anio_lectivo' => $validated['anio_lectivo'],
            'capacidad'    => $validated['capacidad'],
            'activo'       => $request->boolean('activo', true),
        ]);

        $gradoNombre = GradoHelper::GRADOS[$validated['numero'] - 1] ?? $validated['numero'] . '° Grado';
        Seccion::firstOrCreate(
            ['grado' => $gradoNombre, 'nombre' => $validated['seccion']],
            ['capacidad' => $validated['capacidad']]
        );

        $this->asignarMateriasPorDefecto($grado);

        return redirect()->route('grados.index')
            ->with('success', 'Grado creado y materias asignadas correctamente.');
    }

    // ── Show ───────────────────────────────────────────────────────
    public function show(Grado $grado)
    {
        $grado->load('materias');
        $estudiantes = $grado->estudiantes()->orderBy('apellido1')->orderBy('nombre1')->get();
        return view('grados.show', compact('grado', 'estudiantes'));
    }

    // ── Edit / Update ──────────────────────────────────────────────
    public function edit(Grado $grado)
    {
        return view('grados.edit', compact('grado'));
    }

    public function update(Request $request, Grado $grado): RedirectResponse
    {
        $validated = $request->validate([
            'nivel'        => 'required|in:primaria,secundaria',
            'numero'       => 'required|integer|min:1|max:9',
            'seccion'      => 'required|in:A,B,C,D',
            'anio_lectivo' => 'required|integer|min:2020|max:2100',
            'capacidad'    => 'required|integer|min:1|max:60',
            'activo'       => 'nullable|boolean',
        ]);

        $grado->update([
            'nivel'        => $validated['nivel'],
            'numero'       => $validated['numero'],
            'seccion'      => $validated['seccion'],
            'anio_lectivo' => $validated['anio_lectivo'],
            'capacidad'    => $validated['capacidad'],
            'activo'       => $request->boolean('activo'),
        ]);

        $gradoNombre = GradoHelper::GRADOS[$validated['numero'] - 1] ?? $validated['numero'] . '° Grado';
        Seccion::firstOrCreate(
            ['grado' => $gradoNombre, 'nombre' => $validated['seccion']],
            ['capacidad' => $validated['capacidad']]
        )->update(['capacidad' => $validated['capacidad']]);

        return redirect()->route('grados.index')->with('success', 'Grado actualizado correctamente.');
    }

    // ── Destroy ────────────────────────────────────────────────────
    public function destroy(Grado $grado): RedirectResponse
    {
        $grado->materias()->detach();
        $grado->delete();
        return redirect()->route('grados.index')->with('success', 'Grado eliminado exitosamente.');
    }

    // ── Asignar Materias ───────────────────────────────────────────
    public function asignarMaterias(Grado $grado)
    {
        $grado->load('materias');

        // Solo materias del mismo nivel, ordenadas: básicas primero, especialidad al final
        $especialidad = ['Inglés', 'Educación Física', 'Educación Artística', 'Informática'];

        $materias = Materia::where('activo', true)
            ->where('nivel', $grado->nivel)
            ->orderByRaw('FIELD(area, "' . implode('","', $especialidad) . '") ASC')
            ->orderBy('nombre')
            ->get();

        $profesores        = Profesor::where('estado', 'activo')->orderBy('nombre')->get();
        $materiasAsignadas = $grado->materias->pluck('id')->toArray();

        return view('grados.asignar-materias', compact(
            'grado', 'materias', 'profesores', 'materiasAsignadas'
        ));
    }

    // ── Guardar Materias ───────────────────────────────────────────
    /**
     * El formulario envía:
     *   materias[]       → IDs de materias seleccionadas
     *   profesor[{id}]   → profesor_id por materia   ← campo correcto
     *   horas[{id}]      → horas_semanales por materia
     */
    public function guardarMaterias(Request $request, Grado $grado): RedirectResponse
    {
        $request->validate([
            'materias'   => 'nullable|array',
            'materias.*' => 'exists:materias,id',
            'horas'      => 'nullable|array',
            'horas.*'    => 'nullable|integer|min:1|max:40',
            'profesor'   => 'nullable|array',
            'profesor.*' => 'nullable|exists:profesores,id',
        ]);

        $materiaIds = $request->input('materias', []);

        // Validar nivel correcto
        if (!empty($materiaIds)) {
            $invalidas = Materia::whereIn('id', $materiaIds)
                ->where('nivel', '!=', $grado->nivel)
                ->count();

            if ($invalidas > 0) {
                return back()->with('error',
                    'Algunas materias no corresponden al nivel ' . ucfirst($grado->nivel) . '.'
                );
            }
        }

        // Construir datos de sync
        $syncData = [];
        foreach ($materiaIds as $materiaId) {
            $id = (int) $materiaId;
            $syncData[$id] = [
                'horas_semanales' => (int) ($request->input("horas.{$id}") ?? 4),
                // ← Lee profesor[{id}] correctamente
                'profesor_id'     => $request->input("profesor.{$id}") ?: null,
            ];
        }

        // 1. Guardar en grado_materia (fuente de verdad)
        $grado->materias()->sync($syncData);

        // 2. Sincronizar profesor_materia_grados (compatibilidad con dashboard y calificaciones)
        DB::table('profesor_materia_grados')->where('grado_id', $grado->id)->delete();

        foreach ($syncData as $materiaId => $pivot) {
            DB::table('profesor_materia_grados')->insert([
                'grado_id'        => $grado->id,
                'materia_id'      => $materiaId,
                'profesor_id'     => $pivot['profesor_id'],
                'seccion'         => $grado->seccion,
                'horas_semanales' => $pivot['horas_semanales'],
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }

        return redirect()->route('grados.show', $grado)
            ->with('success', 'Materias y profesores asignados correctamente.');
    }

    // ── Creación Masiva ────────────────────────────────────────────
    public function crearMasivo()
    {
        return view('grados.crear-masivo');
    }

    public function generarMasivo(Request $request)
    {
        $validated = $request->validate([
            'capacidad_maxima' => 'required|integer|min:1|max:60',
            'activo'           => 'nullable|boolean',
        ]);

        $gradosData = [
            ['nivel' => 'primaria',   'numero' => 1],
            ['nivel' => 'primaria',   'numero' => 2],
            ['nivel' => 'primaria',   'numero' => 3],
            ['nivel' => 'primaria',   'numero' => 4],
            ['nivel' => 'primaria',   'numero' => 5],
            ['nivel' => 'primaria',   'numero' => 6],
            ['nivel' => 'secundaria', 'numero' => 7],
            ['nivel' => 'secundaria', 'numero' => 8],
            ['nivel' => 'secundaria', 'numero' => 9],
        ];

        $secciones = ['A', 'B', 'C', 'D'];
        $contador  = 0;

        foreach ($gradosData as $data) {
            foreach ($secciones as $letra) {
                $grado = Grado::updateOrCreate(
                    ['nivel' => $data['nivel'], 'numero' => $data['numero'],
                     'seccion' => $letra, 'anio_lectivo' => 2026],
                    ['activo' => $request->boolean('activo', true)]
                );

                $gradoNombre = GradoHelper::GRADOS[$data['numero'] - 1] ?? $data['numero'] . '° Grado';
                Seccion::firstOrCreate(
                    ['grado' => $gradoNombre, 'nombre' => $letra],
                    ['capacidad' => $validated['capacidad_maxima']]
                );

                if ($grado->wasRecentlyCreated) {
                    $this->asignarMateriasPorDefecto($grado);
                }

                $contador++;
            }
        }

        return redirect()->route('grados.index')
            ->with('success', "Se han procesado {$contador} grados correctamente.");
    }

    // Accesor para mostrar el nombre completo del grado
public function getNombreAttribute(): string
{
    $numero = match($this->numero) {
        1 => '1ro', 2 => '2do', 3 => '3ro',
        4 => '4to', 5 => '5to', 6 => '6to', default => $this->numero
    };
    $nivel   = ucfirst($this->nivel);
    $seccion = $this->seccion ? " — Sección {$this->seccion}" : '';
    return "{$numero} {$nivel}{$seccion}";
}

// Relación con profesor_materia_grados
public function profesorMateriaGrados()
{
    return $this->hasMany(\App\Models\ProfesorMateriaGrado::class, 'grado_id');
}
}
