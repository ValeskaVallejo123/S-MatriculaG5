<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\Matricula;

class SolicitudController extends Controller
{
    public function verEstado()
    {
        return view('solicitudes.estado');
    }

    public function consultarPorDNI(Request $request)
    {
        // Validar formato del DNI
        $request->validate([
            'dni' => ['required']
        ]);

        // 1️⃣ Buscar estudiante por DNI
        $estudiante = Estudiante::where('dni', $request->dni)->first();

        if (!$estudiante) {
            return view('solicitudes.estado')->with([
                'error' => 'No se encontró ningún estudiante con ese DNI.',
                'solicitud' => null
            ]);
        }

        // 2️⃣ Buscar matrícula asociada a ese estudiante
        $matricula = Matricula::where('estudiante_id', $estudiante->id)
            ->latest()
            ->first();

        if (!$matricula) {
            return view('solicitudes.estado')->with([
                'error' => 'El estudiante existe, pero no tiene una solicitud de matrícula registrada.',
                'solicitud' => null
            ]);
        }

        // 3️⃣ Devolver los datos a la vista
        return view('solicitudes.estado')->with([
            'estudiante' => $estudiante,
            'matricula' => $matricula,
        ]);
    }
}
