<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\BuscarEstudiante;

class BuscarEstudianteController extends Controller
{
    public function buscar(Request $request)
    {
        $nombre = $request->input('nombre');
        $dni = $request->input('dni');

        $resultados = collect(); // colección vacía por defecto
        $busquedaRealizada = false;
        $mensaje = null;

        if ($nombre || $dni) {
            $busquedaRealizada = true;

            $estudiantes = BuscarEstudiante::query();

            if ($nombre) {
                $estudiantes->whereRaw("CONCAT(nombre1, ' ', nombre2, ' ', apellido1, ' ', apellido2) LIKE ?", ["%$nombre%"]);
            }

            if ($dni) {
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
