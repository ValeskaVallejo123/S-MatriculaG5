<?php

namespace App\Http\Controllers;

use App\Models\HorarioGrado;
use App\Models\Grado;
use App\Models\Materia;
use App\Models\Profesor;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class HorarioGradoController extends Controller
{
    // ── Ordenar días correctamente ────────────────────────────────
    private const ORDEN_DIAS = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];

    private function ordenarHorario(array $horario): array
    {
        $ordenado = [];
        foreach (self::ORDEN_DIAS as $dia) {
            if (isset($horario[$dia])) {
                $ordenado[$dia] = $horario[$dia];
            }
        }
        return $ordenado;
    }

    // ══════════════════════════════════════════════════════════════
    // INDEX
    // ══════════════════════════════════════════════════════════════

    public function index()
    {
        $grados = Grado::orderBy('nivel')
            ->orderBy('numero')
            ->orderBy('seccion')
            ->get();

        return view('horarios_grado.index', compact('grados'));
    }

    // ══════════════════════════════════════════════════════════════
    // GESTIONAR — vista unificada de asignación de horario
    // ══════════════════════════════════════════════════════════════

    public function gestionar()
    {
        $gradosAgrupados = Grado::where('activo', true)
            ->orderBy('numero')
            ->orderBy('seccion')
            ->get()
            ->groupBy('nivel')
            ->map(fn($g) => $g->map(fn($x) => [
                'id'           => $x->id,
                'numero'       => $x->numero,
                'seccion'      => $x->seccion,
                'anio_lectivo' => $x->anio_lectivo,
            ])->values())
            ->toArray();

        $profesores = Profesor::where('estado', 'activo')
            ->orderBy('nombre')
            ->get(['id', 'nombre', 'apellido', 'especialidad'])
            ->toArray();

        return view('horarios_grado.gestionar', compact('gradosAgrupados', 'profesores'));
    }

    // ══════════════════════════════════════════════════════════════
    // API — horario de un grado/jornada (JSON)
    // ══════════════════════════════════════════════════════════════

    public function apiHorario($grado_id, $jornada)
    {
        $horarioGrado = HorarioGrado::firstOrCreate(
            ['grado_id' => $grado_id, 'jornada' => $jornada],
            ['horario'  => HorarioGrado::estructuraPorJornada($jornada)]
        );

        $horario = $horarioGrado->horario
            ? $this->ordenarHorario($horarioGrado->horario)
            : [];

        return response()->json(['horario' => $horario]);
    }

    // ══════════════════════════════════════════════════════════════
    // API — materias del nivel del grado (JSON)
    // ══════════════════════════════════════════════════════════════

    public function apiMaterias($grado_id)
    {
        $grado = Grado::findOrFail($grado_id);

        $materias = Materia::where('nivel', $grado->nivel)
            ->where('activo', true)
            ->orderBy('nombre')
            ->get(['id', 'nombre', 'area'])
            ->toArray();

        return response()->json(['materias' => $materias]);
    }

    // ══════════════════════════════════════════════════════════════
    // API — estudiantes del grado (JSON)
    // ══════════════════════════════════════════════════════════════

    public function apiEstudiantes($grado_id)
    {
        $estudiantes = Estudiante::where('grado_id', $grado_id)
            ->where('estado', 'activo')
            ->orderBy('apellido1')
            ->orderBy('nombre1')
            ->get(['id', 'nombre1', 'nombre2', 'apellido1', 'apellido2', 'dni'])
            ->toArray();

        return response()->json(['estudiantes' => $estudiantes]);
    }

    // ══════════════════════════════════════════════════════════════
    // SHOW
    // ══════════════════════════════════════════════════════════════

    public function show($grado_id, $jornada)
    {
        $grado = Grado::findOrFail($grado_id);

        $horarioGrado = HorarioGrado::firstOrCreate(
            ['grado_id' => $grado_id, 'jornada' => $jornada],
            ['horario'  => HorarioGrado::estructuraPorJornada($jornada)]
        );

        if ($horarioGrado->horario) {
            $horarioGrado->horario = $this->ordenarHorario($horarioGrado->horario);
        }

        $materias   = Materia::orderBy('nombre')->get();
        $profesores = Profesor::orderBy('nombre')->get();

        return view('horarios_grado.show', compact(
            'grado', 'jornada', 'horarioGrado', 'materias', 'profesores'
        ));
    }

    // ══════════════════════════════════════════════════════════════
    // EDIT
    // ══════════════════════════════════════════════════════════════

    public function edit($grado_id, $jornada)
    {
        $grado = Grado::findOrFail($grado_id);

        $horarioGrado = HorarioGrado::firstOrCreate(
            ['grado_id' => $grado_id, 'jornada' => $jornada],
            ['horario'  => HorarioGrado::estructuraPorJornada($jornada)]
        );

        if ($horarioGrado->horario) {
            $horarioGrado->horario = $this->ordenarHorario($horarioGrado->horario);
        }

        $materias   = Materia::orderBy('nombre')->get();
        $profesores = Profesor::orderBy('nombre')->get();

        return view('horarios_grado.edit', compact(
            'grado', 'jornada', 'horarioGrado', 'materias', 'profesores'
        ));
    }

    // ══════════════════════════════════════════════════════════════
    // UPDATE
    // ══════════════════════════════════════════════════════════════

    public function update(Request $request, $grado_id, $jornada)
    {
        $horarioGrado = HorarioGrado::where('grado_id', $grado_id)
            ->where('jornada', $jornada)
            ->firstOrFail();

        $nuevoHorario = json_decode($request->horario, true);

        // Validar conflictos de profesor entre grados
        $otrosHorarios = HorarioGrado::where('jornada', $jornada)
            ->where('grado_id', '!=', $grado_id)
            ->with('grado')
            ->get();

        $conflictos = [];
        foreach ($nuevoHorario as $dia => $horas) {
            if (!is_array($horas)) continue;
            foreach ($horas as $hora => $celda) {
                if (str_contains($hora, 'RECREO')) continue;
                if (!is_array($celda) || !($celda['profesor_id'] ?? null)) continue;

                foreach ($otrosHorarios as $otro) {
                    $oData = $otro->horario;
                    if (isset($oData[$dia][$hora]) &&
                        is_array($oData[$dia][$hora]) &&
                        ($oData[$dia][$hora]['profesor_id'] ?? null) == $celda['profesor_id']) {
                        $g      = $otro->grado;
                        $prof   = Profesor::find($celda['profesor_id']);
                        $nombre = $prof ? $prof->nombre : "Prof. #{$celda['profesor_id']}";
                        $conflictos[] = "{$nombre} — {$dia} {$hora} ya está asignado en {$g->numero}° {$g->seccion}";
                    }
                }
            }
        }

        if (!empty($conflictos)) {
            return redirect()->back()
                ->with('conflictos', $conflictos)
                ->with('horario_rechazado', $request->horario);
        }

        $horarioGrado->update(['horario' => $nuevoHorario]);

        // Si viene de la vista gestionar, redirigir allá
        if ($request->has('desde_gestionar')) {
            return redirect()->route('horarios_grado.gestionar')
                ->with('success', 'Horario guardado correctamente.');
        }

        return redirect()->route('horarios_grado.show', [$grado_id, $jornada])
            ->with('success', 'Horario actualizado correctamente.');
    }

    // ══════════════════════════════════════════════════════════════
    // VERIFICAR CONFLICTO (AJAX)
    // ══════════════════════════════════════════════════════════════

    public function verificarConflicto(Request $request, $grado_id, $jornada)
    {
        $profesorId = $request->profesor_id;
        $dia        = $request->dia;
        $hora       = $request->hora;

        if (!$profesorId || str_contains($hora ?? '', 'RECREO')) {
            return response()->json(['conflicto' => false, 'grados' => []]);
        }

        $horarios = HorarioGrado::where('jornada', $jornada)
            ->where('grado_id', '!=', $grado_id)
            ->with('grado')
            ->get();

        $conflictos = [];
        foreach ($horarios as $h) {
            $data = $h->horario;
            if (isset($data[$dia][$hora]) &&
                is_array($data[$dia][$hora]) &&
                ($data[$dia][$hora]['profesor_id'] ?? null) == $profesorId) {
                $g = $h->grado;
                $conflictos[] = $g->numero . '° ' . $g->seccion;
            }
        }

        return response()->json([
            'conflicto' => !empty($conflictos),
            'grados'    => $conflictos,
        ]);
    }

    // ══════════════════════════════════════════════════════════════
    // EXPORTAR PDF
    // ══════════════════════════════════════════════════════════════

    public function exportarPdf($grado_id, $jornada)
    {
        $grado = Grado::findOrFail($grado_id);

        $horarioGrado = HorarioGrado::where('grado_id', $grado_id)
            ->where('jornada', $jornada)
            ->firstOrFail();

        $materias   = Materia::orderBy('nombre')->get();
        $profesores = Profesor::orderBy('nombre')->get();

        $pdf = Pdf::loadView('horarios_grado.pdf', compact(
            'grado', 'jornada', 'horarioGrado', 'materias', 'profesores'
        ));

        return $pdf->download(
            'Horario_' . $grado->nivel . '_' . $grado->numero . '_' . $grado->seccion . '_' . $jornada . '.pdf'
        );
    }
}