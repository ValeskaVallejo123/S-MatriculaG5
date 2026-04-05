<?php

namespace App\Http\Controllers;

use App\Models\HorarioGrado;
use App\Models\Grado;
use App\Models\Materia;
use App\Models\Profesor;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class HorarioGradoController extends Controller
{
    public function index()
    {
        $grados = Grado::orderBy('nivel')
            ->orderBy('numero')
            ->orderBy('seccion')
            ->get();

        return view('horarios_grado.index', compact('grados'));
    }

    public function show($grado_id, $jornada)
    {
        $grado = Grado::findOrFail($grado_id);

        $horarioGrado = HorarioGrado::firstOrCreate(
            ['grado_id' => $grado_id, 'jornada' => $jornada],
            ['horario' => HorarioGrado::estructuraPorJornada($jornada)]
        );

        // ← AGREGA ESTO: reordenar días correctamente
        $ordenDias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
        if ($horarioGrado->horario) {
         $horarioOrdenado = [];
         foreach ($ordenDias as $dia) {
            if (isset($horarioGrado->horario[$dia])) {
                $horarioOrdenado[$dia] = $horarioGrado->horario[$dia];
            }
        }
          $horarioGrado->horario = $horarioOrdenado;
       }

        $materias = Materia::orderBy('nombre')->get();
        $profesores = Profesor::orderBy('nombre')->get();

        return view('horarios_grado.show', compact(
            'grado',
            'jornada',
            'horarioGrado',
            'materias',
            'profesores'
        ));
    }

    public function edit($grado_id, $jornada)
    {
        $grado = Grado::findOrFail($grado_id);

        $horarioGrado = HorarioGrado::firstOrCreate(
            ['grado_id' => $grado_id, 'jornada' => $jornada],
            ['horario' => HorarioGrado::estructuraPorJornada($jornada)]
        );

        // ← AGREGA ESTO: reordenar días correctamente
        $ordenDias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
        if ($horarioGrado->horario) {
          $horarioOrdenado = [];
          foreach ($ordenDias as $dia) {
            if (isset($horarioGrado->horario[$dia])) {
                $horarioOrdenado[$dia] = $horarioGrado->horario[$dia];
            }
        }
         $horarioGrado->horario = $horarioOrdenado;
        }

        $materias = Materia::orderBy('nombre')->get();
        $profesores = Profesor::orderBy('nombre')->get();

        return view('horarios_grado.edit', compact(
            'grado',
            'jornada',
            'horarioGrado',
            'materias',
            'profesores'
        ));
    }

    public function update(Request $request, $grado_id, $jornada)
    {
        $horarioGrado = HorarioGrado::where('grado_id', $grado_id)
            ->where('jornada', $jornada)
            ->firstOrFail();

        $nuevoHorario = json_decode($request->horario, true);

        // ── Validar conflictos de profesor entre grados ──
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
                        $g    = $otro->grado;
                        $prof = \App\Models\Profesor::find($celda['profesor_id']);
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

        return redirect()->route('horarios_grado.show', [$grado_id, $jornada])
            ->with('success', 'Horario actualizado correctamente.');
    }

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

    /*
    |--------------------------------------------------------------------------
    | EXPORTAR PDF
    |--------------------------------------------------------------------------
    */
    public function exportarPdf($grado_id, $jornada)
{
    $grado = Grado::findOrFail($grado_id);

    $horarioGrado = HorarioGrado::where('grado_id', $grado_id)
        ->where('jornada', $jornada)
        ->firstOrFail();

    $materias   = \App\Models\Materia::orderBy('nombre')->get();
    $profesores = \App\Models\Profesor::orderBy('nombre')->get();

    $pdf = Pdf::loadView('horarios_grado.pdf', compact(
        'grado',
        'jornada',
        'horarioGrado',  // ← era 'horario', debe ser 'horarioGrado'
        'materias',
        'profesores'
    ));

    return $pdf->download(
        'Horario_'.$grado->nivel.'_'.$grado->numero.'_'.$grado->seccion.'_'.$jornada.'.pdf'
    );
}
}
