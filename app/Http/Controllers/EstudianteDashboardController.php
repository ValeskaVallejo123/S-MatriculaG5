<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\Calificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EstudianteDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Usuario no autenticado');
        }

        $estudiante = $user->estudiante;

        if (!$estudiante) {
            abort(403, 'Este usuario no tiene perfil de estudiante');
        }

        // ══════════════════════════════════════════════════════════════════
        // MATERIAS con su profesor y promedio real
        // Viene de profesor_materia_grados filtrando por grado_id y seccion
        // ══════════════════════════════════════════════════════════════════
        $asignaciones = DB::table('profesor_materia_grados as pmg')
            ->join('materias as m',    'pmg.materia_id',   '=', 'm.id')
            ->join('profesores as p',  'pmg.profesor_id',  '=', 'p.id')
            ->where('pmg.grado_id',  $estudiante->grado_id)
            ->where('pmg.seccion',   $estudiante->seccion)
            ->select(
                'm.id as materia_id',
                'm.nombre as materia_nombre',
                'p.nombre as profesor_nombre',
                'p.apellido as profesor_apellido',
                'pmg.horas_semanales'
            )
            ->get();

        // Calificaciones del estudiante indexadas por materia_id
        $calificacionesDB = DB::table('calificaciones')
            ->where('estudiante_id', $estudiante->id)
            ->get()
            ->keyBy('materia_id');

        $misMaterias = $asignaciones->map(function ($asig) use ($calificacionesDB) {
            $cal = $calificacionesDB->get($asig->materia_id);

            $promedio = 0;
            if ($cal) {
                // Usar nota_final si existe, sino promediar los parciales disponibles
                if ($cal->nota_final) {
                    $promedio = round($cal->nota_final, 1);
                } else {
                    $parciales = array_filter([
                        $cal->primer_parcial,
                        $cal->segundo_parcial,
                        $cal->tercer_parcial,
                    ], fn($v) => !is_null($v));

                    $promedio = count($parciales)
                        ? round(array_sum($parciales) / count($parciales), 1)
                        : 0;
                }
            }

            return [
                'materia_id' => $asig->materia_id,
                'nombre'     => $asig->materia_nombre,
                'profesor'   => 'Prof. ' . $asig->profesor_nombre . ' ' . $asig->profesor_apellido,
                'promedio'   => $promedio,
                'asistencia' => 100, // placeholder hasta que tengas tabla asistencias
                'parcial1'   => $cal->primer_parcial   ?? '—',
                'parcial2'   => $cal->segundo_parcial  ?? '—',
                'parcial3'   => $cal->tercer_parcial   ?? '—',
                'nota_final' => $cal->nota_final       ?? '—',
            ];
        })->toArray();

        // ══════════════════════════════════════════════════════════════════
        // PROMEDIO GENERAL
        // ══════════════════════════════════════════════════════════════════
        $promediosValidos = array_filter(
            array_column($misMaterias, 'promedio'),
            fn($p) => $p > 0
        );

        $promedioGeneral = count($promediosValidos)
            ? round(array_sum($promediosValidos) / count($promediosValidos), 1)
            : 0;

        // ══════════════════════════════════════════════════════════════════
        // HORARIO
        // Viene de horarios_grado — columna `horario` guarda JSON/texto
        // ══════════════════════════════════════════════════════════════════
        $horarioGrado = null;
        if ($estudiante->grado_id) {
            $horarioGrado = DB::table('horarios_grado')
                ->where('grado_id', $estudiante->grado_id)
                ->first();
        }

        // ══════════════════════════════════════════════════════════════════
        // HISTORIAL ACADÉMICO
        // ══════════════════════════════════════════════════════════════════
        $historialAcademico = DB::table('historial_academicos as h')
            ->leftJoin('cursos as c', 'h.curso_id', '=', 'c.id')
            ->where('h.estudiante_id', $estudiante->id)
            ->orderByDesc('h.anio')
            ->select(
                'h.id',
                'h.anio',
                'h.periodo',
                'h.nota',
                'h.resultado',
                DB::raw("COALESCE(c.nombre, 'Sin curso') as curso_nombre")
            )
            ->get();

        // ══════════════════════════════════════════════════════════════════
        // CALIFICACIONES COMPLETAS (para la sección de calificaciones)
        // ══════════════════════════════════════════════════════════════════
        $calificaciones = DB::table('calificaciones as cal')
            ->leftJoin('materias as m',            'cal.materia_id', '=', 'm.id')
            ->leftJoin('periodos_academicos as pa', 'cal.periodo_id', '=', 'pa.id')
            ->where('cal.estudiante_id', $estudiante->id)
            ->select(
                'cal.*',
                'm.nombre as materia_nombre',
                'pa.nombre_periodo'
            )
            ->orderByDesc('cal.created_at')
            ->get();

        // Agrupar calificaciones por período
        $calificacionesPorPeriodo = $calificaciones->groupBy('nombre_periodo');

        // ══════════════════════════════════════════════════════════════════
        // ESTADÍSTICAS RÁPIDAS
        // ══════════════════════════════════════════════════════════════════
        $misClases       = count($misMaterias);
        $asistencia      = 95; // placeholder
        $tareasPendientes = 0; // placeholder hasta que tengas tabla tareas
        $tareasProximas  = []; // placeholder

        // ══════════════════════════════════════════════════════════════════
        // NOTIFICACIONES
        // ══════════════════════════════════════════════════════════════════
        $notificacionesNoLeidas = Notificacion::where('user_id', $user->id)
            ->where('leida', false)
            ->get();

        $todasNotificaciones = Notificacion::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        // ══════════════════════════════════════════════════════════════════
        // RETORNAR VISTA
        // ══════════════════════════════════════════════════════════════════
        return view('estudiante.dashboard.index', compact(
            'user',
            'estudiante',
            'misClases',
            'asistencia',
            'promedioGeneral',
            'tareasPendientes',
            'misMaterias',
            'tareasProximas',
            'notificacionesNoLeidas',
            'todasNotificaciones',
            'horarioGrado',
            'historialAcademico',
            'calificaciones',
            'calificacionesPorPeriodo'
        ));
    }
}