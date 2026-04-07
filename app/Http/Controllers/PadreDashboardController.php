<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // ← Asegúrate de importar tu modelo User
class PadreDashboardController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user  = Auth::user();
        $padre = $user->padre;

        if (!$padre) {
            abort(403, 'No tienes un perfil de padre/tutor vinculado.');
        }

        $matriculas = $padre->matriculas()
            ->with('estudiante')
            ->where('estado', 'aprobada')
            ->orderBy('anio_lectivo', 'desc')
            ->get();

        $todasMatriculas = $padre->matriculas()
            ->with('estudiante')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('padre.dashboard', compact('padre', 'matriculas', 'todasMatriculas'));
    }

    public function verHijo($estudianteId)
    {
        /** @var User $user */
        $user  = Auth::user();
        $padre = $user->padre;

        if (!$padre) {
            abort(403);
        }

        $matricula = $padre->matriculas()
            ->with('estudiante')
            ->where('estudiante_id', $estudianteId)
            ->where('estado', 'aprobada')
            ->firstOrFail();

        $estudiante = $matricula->estudiante;

        return view('padre.hijo', compact('padre', 'estudiante', 'matricula'));
    }

    public function cambiarPassword(Request $request)
    {
        $request->validate([
            'password_actual' => 'required',
            'password_nuevo'  => 'required|min:8|confirmed',
        ]);

        /** @var User $user */  // ← Este comentario elimina el "undefined method" del IDE
        $user = Auth::user();   // ← Unificado con Auth facade

        if (!Hash::check($request->password_actual, $user->password)) {
            return back()->with('pw_error', 'La contraseña actual es incorrecta.');
        }

        $user->update([
            'password' => Hash::make($request->password_nuevo),
        ]);

        return back()->with('pw_success', 'Contraseña actualizada correctamente.');
    }

    public function calificaciones()
    {
        /** @var User $user */
        $user  = Auth::user();
        $padre = $user->padre;

        if (!$padre) {
            abort(403, 'No tienes un perfil de padre/tutor vinculado.');
        }

        // Obtener todos los estudiantes del padre (matriculados)
        $estudiantes = $padre->estudiantes()->with('calificaciones.materia', 'calificaciones.periodo')->get();

        // Si no hay estudiantes, retornar vista vacía
        if ($estudiantes->isEmpty()) {
            return view('padre.calificaciones', [
                'padre' => $padre,
                'estudiantes' => collect(),
                'estudiantesConCalificaciones' => collect(),
                'periodos' => collect(),
            ]);
        }

        // Procesar calificaciones por estudiante
        $estudiantesConCalificaciones = $estudiantes->map(function ($estudiante) {
            $calificaciones = $estudiante->calificaciones;

            // Agrupar por período
            $porPeriodo = $calificaciones->groupBy('periodo_id');

            // Resumen por materia
            $resumenMaterias = $calificaciones
                ->groupBy('materia_id')
                ->map(function ($notas) {
                    $conNota = $notas->whereNotNull('nota_final');
                    return [
                        'materia'  => $notas->first()->materia,
                        'promedio' => $conNota->isNotEmpty() ? round($conNota->avg('nota_final'), 2) : null,
                        'aprobado' => $conNota->isNotEmpty() && $conNota->avg('nota_final') >= 60,
                        'notas'    => $notas,
                    ];
                });

            // Promedio general
            $conNota = $calificaciones->whereNotNull('nota_final');
            $promedioGeneral = $conNota->isNotEmpty() ? round($conNota->avg('nota_final'), 2) : null;

            return [
                'estudiante' => $estudiante,
                'porPeriodo' => $porPeriodo,
                'resumenMaterias' => $resumenMaterias,
                'promedioGeneral' => $promedioGeneral,
            ];
        });

        // Obtener todos los períodos únicos
        $periodos = \App\Models\PeriodoAcademico::whereIn(
            'id',
            $estudiantes->flatMap(fn($e) => $e->calificaciones->pluck('periodo_id'))->unique()
        )->get()->keyBy('id');

        return view('padre.calificaciones', compact('padre', 'estudiantes', 'estudiantesConCalificaciones', 'periodos'));
    }
}
