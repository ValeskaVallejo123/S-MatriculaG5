<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfesorDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:profesor']);
    }

    public function index()
    {
        $user = Auth::user();
        $anio = date('Y');

        // Buscar el perfil del profesor por email
        $profesor = DB::table('profesores')
            ->where('email', $user->email)
            ->first();

        if (!$profesor) {
            return view('profesor.dashboard.index', [
                'totalEstudiantes'      => 0,
                'totalClases'           => 0,
                'clasesHoy'             => 0,
                'tareasPendientes'      => 0,
                'misClases'             => [],
                'estudiantesDestacados' => collect(),
            ]);
        }

        // Asignaciones del año lectivo actual (igual que CargaDocente)
        $asignaciones = DB::table('profesor_materia_grados as pmg')
            ->join('grados',   function ($j) use ($anio) {
                $j->on('pmg.grado_id', '=', 'grados.id')
                  ->where('grados.anio_lectivo', $anio);
            })
            ->join('materias', 'pmg.materia_id', '=', 'materias.id')
            ->where('pmg.profesor_id', $profesor->id)
            ->select(
                'grados.id as grado_id',
                'grados.numero',
                'grados.seccion',
                'grados.nivel',
                'materias.nombre as materia_nombre'
            )
            ->get();

        // IDs únicos de grados
        $gradoIds = $asignaciones->pluck('grado_id')->unique()->values();

        // Totales reales
        $totalClases      = $gradoIds->count();
        $totalEstudiantes = DB::table('estudiantes')
            ->whereIn('grado_id', $gradoIds)
            ->where('estado', 'activo')
            ->count();

        // Lista de clases agrupada por grado (igual que Carga Docente)
        $misClases = [];
        foreach ($gradoIds as $gradoId) {
            $materiasGrado = $asignaciones
                ->where('grado_id', $gradoId)
                ->pluck('materia_nombre')
                ->implode(', ');

            $gradoInfo = $asignaciones->firstWhere('grado_id', $gradoId);

            $estudiantesGrado = DB::table('estudiantes')
                ->where('grado_id', $gradoId)
                ->where('estado', 'activo')
                ->count();

            $misClases[] = [
                'nombre'      => $materiasGrado,
                'grado'       => $gradoInfo->numero . '° ' . ucfirst($gradoInfo->nivel),
                'seccion'     => $gradoInfo->seccion,
                'estudiantes' => $estudiantesGrado,
                'horario'     => '—',
            ];
        }

        // Estudiantes de los grados del profesor (máx. 5, igual que Carga Docente)
        $estudiantesDestacados = DB::table('estudiantes')
            ->join('grados', 'estudiantes.grado_id', '=', 'grados.id')
            ->whereIn('estudiantes.grado_id', $gradoIds->toArray())
            ->where('estudiantes.estado', 'activo')
            ->select('estudiantes.*', 'grados.numero as grado_numero', 'grados.seccion as grado_seccion', 'grados.nivel as grado_nivel')
            ->orderBy('grados.numero')
            ->orderBy('estudiantes.apellido1')
            ->limit(5)
            ->get();

        return view('profesor.dashboard.index', [
            'totalEstudiantes'      => $totalEstudiantes,
            'totalClases'           => $totalClases,
            'clasesHoy'             => $totalClases,
            'tareasPendientes'      => 0,
            'misClases'             => $misClases,
            'estudiantesDestacados' => $estudiantesDestacados,
        ]);
    }
}
