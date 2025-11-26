<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BuscarEstudiante;

class BuscarEstudianteController extends Controller
{
    public function buscarregistro(Request $request)
    {
        $nombre = $request->input('nombre');
        $dni = $request->input('dni');

        $resultados = collect();
        $busquedaRealizada = false;
        $mensaje = null;

        if ($nombre || $dni) {
            $busquedaRealizada = true;

            $estudiantes = BuscarEstudiante::query();

            // Buscar por nombre (nombre1 y apellido1 incluidos)
            if ($nombre) {
                $estudiantes->where(function ($q) use ($nombre) {
                    $q->where('nombre1', 'like', "%$nombre%")
                        ->orWhere('nombre2', 'like', "%$nombre%")
                        ->orWhere('apellido1', 'like', "%$nombre%")
                        ->orWhere('apellido2', 'like', "%$nombre%");
                });
            }

            // Normalizar el DNI (eliminar guiones y espacios)
            if ($dni) {
                $dni = preg_replace('/[^0-9]/', '', $dni);
                $estudiantes->orWhere('dni', 'like', "%$dni%");
            }

            $resultados = $estudiantes->get();

            if ($resultados->isEmpty()) {
                $mensaje = 'Estudiante no encontrado';
            }
        }

        return view('buscar.busqueda', compact('resultados', 'busquedaRealizada', 'mensaje'));
    }
}
