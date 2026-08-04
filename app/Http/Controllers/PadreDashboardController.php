<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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

        // Matrículas aprobadas con estudiante y sus calificaciones
        $matriculas = $padre->matriculas()
            ->with([
                'estudiante.calificaciones.materia',
                'estudiante.calificaciones.periodo',
            ])
            ->where('estado', 'aprobada')
            ->orderBy('anio_lectivo', 'desc')
            ->get();

        // Todas las matrículas (para historial)
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
            ->with([
                'estudiante.calificaciones.materia',
                'estudiante.calificaciones.periodo',
            ])
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

        /** @var User $user */
        $user = Auth::user();

        if (!Hash::check($request->password_actual, $user->password)) {
            return back()->with('pw_error', 'La contraseña actual es incorrecta.');
        }

        $user->update([
            'password' => Hash::make($request->password_nuevo),
        ]);

        return back()->with('pw_success', 'Contraseña actualizada correctamente.');
    }
}