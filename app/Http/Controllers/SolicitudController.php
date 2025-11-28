<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\Matricula;

class SolicitudController extends Controller
{
    /**
     * Vista principal del estado de solicitudes
     */
    public function verEstado()
    {
        return view('solicitudes.estado');
    }

    /**
     * Consultar estado de matrícula por DNI
     */
    public function consultarPorDNI(Request $request)
    {
        // Validación mejorada
        $request->validate([
            'dni' => ['required', 'string', 'min:5', 'max:20']
        ], [
            'dni.required' => 'El DNI es obligatorio.',
            'dni.min' => 'El DNI es demasiado corto.',
            'dni.max' => 'El DNI es demasiado largo.',
        ]);

        // 1️ Buscar estudiante
        $estudiante = Estudiante::where('dni', $request->dni)->first();

        if (!$estudiante) {
            return view('solicitudes.estado', [
                'error' => 'No se encontró ningún estudiante con ese DNI.',
                'estudiante' => null,
                'matricula' => null
            ]);
        }

        // 2️ Buscar su matrícula más reciente
        $matricula = Matricula::where('estudiante_id', $estudiante->id)
            ->latest()
            ->first();

        if (!$matricula) {
            return view('solicitudes.estado', [
                'error' => 'El estudiante existe, pero aún no tiene registrada una solicitud de matrícula.',
                'estudiante' => $estudiante,
                'matricula' => null
            ]);
        }

        // 3️Retornar datos a la vista
        return view('solicitudes.estado', compact('estudiante', 'matricula'));
    }
}
