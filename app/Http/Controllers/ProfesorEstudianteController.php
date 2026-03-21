<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfesorEstudianteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:profesor']);
    }

    public function index($grado, $seccion)
    {
        $user = Auth::user();

        // Buscar el profesor por email
        $profesor = DB::table('profesores')
            ->where('email', $user->email)
            ->first();

        if (!$profesor) {
            return redirect()->route('profesor.dashboard')
                ->with('error', 'No tienes perfil de profesor asignado.');
        }

        // Verificar que el profesor tiene asignado ese grado/sección
        $tieneAcceso = DB::table('profesor_materia_grados')
            ->join('grados', 'profesor_materia_grados.grado_id', '=', 'grados.id')
            ->where('profesor_materia_grados.profesor_id', $profesor->id)
            ->where('grados.numero', $grado)
            ->where('grados.seccion', $seccion)
            ->exists();

        if (!$tieneAcceso) {
            return redirect()->route('profesor.mis-cursos')
                ->with('error', 'No tienes acceso a este grado.');
        }

        // Obtener estudiantes activos del grado y sección
        $estudiantes = DB::table('estudiantes')
            ->where('grado', $grado)
            ->where('seccion', $seccion)
            ->where('estado', 'activo')
            ->orderBy('apellido1')
            ->orderBy('nombre1')
            ->get();

        // Obtener materias que imparte el profesor en este grado
        $materias = DB::table('profesor_materia_grados')
            ->join('grados', 'profesor_materia_grados.grado_id', '=', 'grados.id')
            ->join('materias', 'profesor_materia_grados.materia_id', '=', 'materias.id')
            ->where('profesor_materia_grados.profesor_id', $profesor->id)
            ->where('grados.numero', $grado)
            ->where('grados.seccion', $seccion)
            ->pluck('materias.nombre')
            ->toArray();

        return view('profesor.estudiantes.index', compact(
            'profesor',
            'estudiantes',
            'materias',
            'grado',
            'seccion'
        ));
    }
}
