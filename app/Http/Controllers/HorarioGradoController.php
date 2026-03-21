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

        $horarioGrado->update([
            'horario' => json_decode($request->horario, true)
        ]);

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

        return redirect()->route('superadmin.horarios_grado.show', [$grado_id, $jornada])
            ->with('success', 'Horario actualizado correctamente.');
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
