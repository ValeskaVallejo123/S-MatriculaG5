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
            'dni'    => 'nullable|string|max:20',
            'codigo' => 'nullable|string|max:20',
            'grado'  => 'nullable|string|max:20',
        ]);

        $nombre = $request->input('nombre');
        // ✅ Limpiar DNI aquí, antes de pasarlo al closure
        $dni    = preg_replace('/[^0-9]/', '', $request->input('dni') ?? '');
        $codigo = $request->input('codigo');
        $grado  = $request->input('grado');

        $estudiantes     = collect();
        $busquedaRealizada = false;
        $mensaje         = null;

        // ✅ Usar $dni ya limpio para la condición
        if ($nombre || $dni || $codigo || $grado) {
            $busquedaRealizada = true;

            $estudiantes = Estudiante::query()
                ->when($nombre, function ($q) use ($nombre) {
                    // ✅ Agrupar con where() para no romper otros filtros AND
                    $q->where(function ($q2) use ($nombre) {
                        $q2->where('nombre1',   'like', "%$nombre%")
                           ->orWhere('nombre2',  'like', "%$nombre%")
                           ->orWhere('apellido1','like', "%$nombre%")
                           ->orWhere('apellido2','like', "%$nombre%");
                    });
                })
                ->when($dni, function ($q) use ($dni) {
                    $q->where('dni', 'like', "%$dni%");
                })
                ->when($codigo, function ($q) use ($codigo) {
                    $q->where('codigo', 'like', "%$codigo%");
                })
                ->when($grado, function ($q) use ($grado) {
                    $q->where('grado', 'like', "%$grado%");
                })
                ->get();

            if ($estudiantes->isEmpty()) {
                $mensaje = 'No se encontraron estudiantes con los criterios de búsqueda.';
            }
        }

        return view('buscar.busqueda', compact('estudiantes', 'busquedaRealizada', 'mensaje'));
    }
}
