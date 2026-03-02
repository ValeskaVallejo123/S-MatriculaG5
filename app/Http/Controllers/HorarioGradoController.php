<?php

namespace App\Http\Controllers;

use App\Models\HorarioGrado;
use App\Models\Grado;
use App\Models\Materia;
use App\Models\Profesor;
use Illuminate\Http\Request;

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

        return redirect()->route('horarios_grado.show', [$grado_id, $jornada])
            ->with('success', 'Horario actualizado correctamente.');
    }

}
