<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class ProfesorEstudianteController extends Controller
{
    public function __construct()
    {
        // Solo PROFESORES pueden ver esta sección
        $this->middleware(['auth', 'rol:profesor']);
    }

    /**
     * Lista de estudiantes asignados al profesor
     */
    public function index()
    {
        $usuario = Auth::user();
        $profesor = $usuario->docente;

        if (!$profesor) {
            return redirect()->back()->with('error', 'No se encontró información del profesor.');
        }

        // Buscar estudiantes asignados al profesor
        $estudiantes = Estudiante::where('profesor_id', $profesor->id)->get();

        if ($estudiantes->isEmpty()) {
            Session::flash('info', 'No tienes estudiantes asignados aún.');
        }

        return view('profesor.estudiantes.index', compact('estudiantes'));
    }

    /**
     * Exportar a PDF los estudiantes asignados al profesor
     */
    public function exportPDF()
    {
        $usuario = Auth::user();
        $profesor = $usuario->docente;

        if (!$profesor) {
            return redirect()->route('profesor.estudiantes.index')
                ->with('error', 'No se encontró información del profesor.');
        }

        $estudiantes = Estudiante::where('profesor_id', $profesor->id)->get();

        if ($estudiantes->isEmpty()) {
            return redirect()->route('profesor.estudiantes.index')
                ->with('error', 'No hay estudiantes para generar el PDF.');
        }

        try {
            $pdf = Pdf::loadView('profesor.estudiantes.pdf', [
                'estudiantes' => $estudiantes,
                'profesor' => $profesor
            ]);

            return $pdf->download('lista_estudiantes.pdf');

        } catch (\Exception $e) {
            return redirect()->route('profesor.estudiantes.index')
                ->with('error', 'Ocurrió un error al generar el PDF.');
        }
    }
}
