<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matricula;
use Illuminate\Support\Facades\Auth;

class MatriculaController extends Controller
{
    /**
     * Mostrar listado de matrículas.
     * - Admin/SuperAdmin: todas
     * - Estudiante/Padre: solo las propias
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->id_rol == 1 || $user->id_rol == 2) {
            // SuperAdmin o Admin
            $matriculas = Matricula::all();
        } else {
            // Estudiante o Padre (solo las suyas)
            $matriculas = Matricula::where('user_id', $user->id)->get();
        }

        return view('matriculas.index', compact('matriculas'));
    }

    /**
     * Mostrar matrícula individual
     * Solo Admin/SuperAdmin pueden ver cualquiera.
     * Estudiantes y Padres solo pueden ver las suyas.
     */
    public function show($id)
    {
        $matricula = Matricula::findOrFail($id);
        $user = Auth::user();

        if (($user->id_rol == 3 || $user->id_rol == 4) && $matricula->user_id != $user->id) {
            abort(403, 'No tienes permiso para ver esta matrícula.');
        }

        return view('matriculas.show', compact('matricula'));
    }

    /**
     * Aprobar matrícula (solo Admin/SuperAdmin)
     */
    public function aprobar($id)
    {
        $user = Auth::user();

        if (!in_array($user->id_rol, [1,2])) {
            abort(403, 'No tienes permiso para aprobar matrículas.');
        }

        $matricula = Matricula::findOrFail($id);
        $matricula->estado = 'aprobada';
        $matricula->save();

        return redirect()->back()->with('success', 'Matrícula aprobada correctamente.');
    }

    /**
     * Rechazar matrícula (solo Admin/SuperAdmin)
     */
    public function rechazar($id)
    {
        $user = Auth::user();

        if (!in_array($user->id_rol, [1,2])) {
            abort(403, 'No tienes permiso para rechazar matrículas.');
        }

        $matricula = Matricula::findOrFail($id);
        $matricula->estado = 'rechazada';
        $matricula->save();

        return redirect()->back()->with('success', 'Matrícula rechazada correctamente.');
    }

    /**
     * Eliminar matrícula (solo Admin/SuperAdmin)
     */
    public function destroy($id)
    {
        $user = Auth::user();

        if (!in_array($user->id_rol, [1,2])) {
            abort(403, 'No tienes permiso para eliminar matrículas.');
        }

        Matricula::destroy($id);

        return redirect()->route('matriculas.index')->with('success', 'Matrícula eliminada.');
    }
}
