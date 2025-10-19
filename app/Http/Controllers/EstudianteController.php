<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    public function buscar(Request $request)
    {
        $nombre = $request->input('nombre');
        $dni = $request->input('dni');

        $resultados = collect(); // colección vacía por defecto
        $busquedaRealizada = false;

        if ($nombre || $dni) {
            $busquedaRealizada = true;

            $estudiantes = \App\Models\Estudiante::query();

            if ($nombre) {
                $estudiantes->whereRaw("CONCAT(nombre1, ' ', nombre2, ' ', apellido1, ' ', apellido2) LIKE ?", ["%$nombre%"]);
            }

            if ($dni) {
                $estudiantes->orWhere('dni', 'like', "%$dni%");
            }

            $resultados = $estudiantes->get();
        }

        return view('estudiantes.buscar', compact('resultados', 'busquedaRealizada'));
    }
}
