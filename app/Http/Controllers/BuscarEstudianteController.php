<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;

class BuscarEstudianteController extends Controller
{
    public function buscar(Request $request)
    {
        $nombre = $request->input('nombre');
        $dni = $request->input('dni');
        $codigo = $request->input('codigo');
        $grado = $request->input('grado');

        $estudiantes = collect();
        $busquedaRealizada = false;
        $mensaje = null;

        // Verificar si se realizó alguna búsqueda
        if ($nombre || $dni || $codigo || $grado) {
            $busquedaRealizada = true;

            $query = Estudiante::query();


            if ($nombre) {
                $query->where(function($q) use ($nombre) {
                    $q->where('nombre1', 'like', "%$nombre%")
                      ->orWhere('nombre2', 'like', "%$nombre%")
                      ->orWhere('apellido1', 'like', "%$nombre%")
                      ->orWhere('apellido2', 'like', "%$nombre%")
                      ->orWhereRaw("CONCAT(COALESCE(nombre1, ''), ' ', COALESCE(nombre2, ''), ' ', COALESCE(apellido1, ''), ' ', COALESCE(apellido2, '')) LIKE ?", ["%$nombre%"]);
                });
            }

            // Búsqueda por DNI/Identidad
            if ($dni) {
                $query->where('dni', 'like', "%$dni%");
            }

            // Búsqueda por código
            if ($codigo) {
                $query->where('codigo', 'like', "%$codigo%");
            }

            // Búsqueda por grado
            if ($grado) {
                $query->where('grado', 'like', "%$grado%");
            }

            $estudiantes = $query->get();

            if ($estudiantes->isEmpty()) {
                $mensaje = 'No se encontraron estudiantes con los criterios de búsqueda';
            }
        }

        return view('estudiantes.buscar', compact('estudiantes', 'busquedaRealizada', 'mensaje'));
    }
}
