<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitud;

class SolicitudController extends Controller
{
    public function verestado()
    {
        return view('solicitudes.estado');
    }

    public function consultarPorDNI(Request $request)
    {
        $request->validate([
            'dni' => ['required', 'regex:/^\d{4}-\d{4}-\d{5}$/']
        ]);

        try {
            $solicitud = Solicitud::where('dni', $request->dni)->first();
        } catch (\Exception $e) {

            return back()->with('error', 'Hubo un problema al consultar la solicitud. Intenta más tarde.');
        }

        return view('solicitudes.estado', ['solicitud' => $solicitud]);
    }
}
