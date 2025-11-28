<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;

class BuscarEstudianteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function buscar(Request $request)
    {
        $request->validate([
            'nombre' => 'nullable|string|max:50',
            'dni' => 'nullable|string|max:20',
            'codigo' => 'nullable|string|max:20',
            'grado' => 'nullable|string|max:20',
        ]);

        $nombre = $request->input('nombre');
        $dni = $request->input('dni');
        $codigo = $request->input('codigo');
        $grado = $request->input('grado');

        $estudiantes = collect();
        $busquedaRealizada = false;
        $mensaje = null;

        if ($nombre || $dni || $codigo || $grado) {
            $busquedaRealizada = true;

            $query = Estudiante::query();

            $query->where(function($q) use ($nombre, $dni, $codigo, $grado) {
                if ($nombre) {
                    $q->where(function($q2) use ($nombre) {
                        $q2->where('nombre1', 'like', "%$nombre%")
                           ->orWhere('nombre2', 'like', "%$nombre%")
                           ->orWhere('apellido1', 'like', "%$nombre%")
                           ->orWhere('apellido2', 'like', "%$nombre%");
                    });
                }

                if ($dni) {
                    $dni = preg_replace('/[^0-9]/', '', $dni);
                    $q->where('dni', 'like', "%$dni%");
                }

                if ($codigo) {
                    $q->where('codigo', 'like', "%$codigo%");
                }

                if ($grado) {
                    $q->where('grado', 'like', "%$grado%");
                }
            });

            $estudiantes = $query->get();

            if ($estudiantes->isEmpty()) {
                $mensaje = 'No se encontraron estudiantes con los criterios de búsqueda';
            }
        }

        return view('buscar.busqueda', compact('estudiantes', 'busquedaRealizada', 'mensaje'));
    }
}
