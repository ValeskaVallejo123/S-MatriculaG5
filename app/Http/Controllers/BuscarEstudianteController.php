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

            // Buscar por nombre
            if ($nombre) {
                $query->where(function ($q) use ($nombre) {
                    $q->where('nombre1', 'like', "%$nombre%")
                        ->orWhere('nombre2', 'like', "%$nombre%")
                        ->orWhere('apellido1', 'like', "%$nombre%")
                        ->orWhere('apellido2', 'like', "%$nombre%");
                });
            }

            // Buscar por DNI normalizado
            if ($dni) {
                $dni = preg_replace('/[^0-9]/', '', $dni);
                $query->orWhere('dni', 'like', "%$dni%");
            }

            // Buscar por código
            if ($codigo) {
                $query->where('codigo', 'like', "%$codigo%");
            }

            // Buscar por grado
            if ($grado) {
                $query->where('grado', 'like', "%$grado%");
            }

            $estudiantes = $query->get();

            if ($estudiantes->isEmpty()) {
                $mensaje = 'No se encontraron estudiantes con los criterios de búsqueda';
            }
        }

        return view('buscar.busqueda', compact('estudiantes', 'busquedaRealizada', 'mensaje'));
    }
}
