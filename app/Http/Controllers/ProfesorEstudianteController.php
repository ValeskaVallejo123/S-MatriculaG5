<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class ProfesorEstudianteController extends Controller
{
    public function index()
    {
        $usuario = Auth::user(); // Usuario autenticado
        $profesor = $usuario->docente;

        if (!$profesor) {
            Session::flash('error', 'No se encontró información del profesor.');
            return redirect()->back();
        }

        $estudiantes = Estudiante::where('profesor_id', $profesor->id)->get();

        if ($estudiantes->isEmpty()) {
            Session::flash('info', 'No tienes estudiantes asignados aún.');
        }

        return view('profesor.estudiantes.index', compact('estudiantes'));
    }

    public function exportPDF()
    {
        $usuario = Auth::user();
        $profesor = $usuario->docente;

        if (!$profesor) {
            Session::flash('error', 'No se encontró información del profesor.');
            return redirect()->route('profesor.estudiantes.index');
        }

        $estudiantes = Estudiante::where('profesor_id', $profesor->id)->get();

        if ($estudiantes->isEmpty()) {
            Session::flash('error', 'No hay estudiantes para generar el PDF.');
            return redirect()->route('profesor.estudiantes.index');
        }

        try {
            $pdf = Pdf::loadView('profesor.estudiantes.pdf', compact('estudiantes'));
            return $pdf->download('lista_estudiantes.pdf');
        } catch (\Exception $e) {
            Session::flash('error', 'Ocurrió un error al generar el PDF.');
            return redirect()->route('profesor.estudiantes.index');
        }
    }
}
