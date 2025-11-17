<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\Padre;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class MatriculaController extends Controller
{
    /**
     * Listado de matrículas
     */
    public function index()
    {
        $matriculas = Matricula::with(['padre', 'estudiante'])
            ->paginate(15);

        // Estadísticas
        $counts = [
            'total' => Matricula::count(),
            'pendiente' => Matricula::where('estado', 'pendiente')->count(),
            'aprobada' => Matricula::where('estado', 'aprobada')->count(),
            'rechazada' => Matricula::where('estado', 'rechazada')->count(),
        ];

        return view('matriculas.index', compact('matriculas', 'counts'));
    }

    /**
     * Formulario para crear matrícula
     */
    public function create()
    {
        $estudiantes = Estudiante::orderBy('nombre', 'asc')->get();
        $padres = Padre::orderBy('nombre', 'asc')->get();

        $parentescos = [
            'padre' => 'Padre',
            'madre' => 'Madre',
            'abuelo' => 'Abuelo',
            'abuela' => 'Abuela',
            'tio' => 'Tío',
            'tia' => 'Tía',
            'tutor' => 'Tutor Legal',
        ];

        $grados = Estudiante::grados();
        $secciones = ['A', 'B', 'C', 'D'];

        return view('matriculas.create', compact('estudiantes', 'padres', 'parentescos', 'grados', 'secciones'));
    }

    /**
     * Guardar nueva matrícula
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'padre_id' => 'required|exists:padres,id',
            'parentesco' => 'required|string',
            'grado' => 'required|string',
            'seccion' => 'required|string',
            'anio_lectivo' => 'required|integer|between:2020,2099',
            'observaciones' => 'nullable|string|max:500',
        ], [
            'estudiante_id.required' => 'Debe seleccionar un estudiante.',
            'padre_id.required' => 'Debe seleccionar un padre/tutor.',
            'grado.required' => 'Debe seleccionar el grado.',
            'seccion.required' => 'Debe seleccionar la sección.',
        ]);

        try {
            $matricula = Matricula::create([
                'estudiante_id' => $validated['estudiante_id'],
                'padre_id' => $validated['padre_id'],
                'parentesco' => $validated['parentesco'],
                'grado' => $validated['grado'],
                'seccion' => $validated['seccion'],
                'anio_lectivo' => $validated['anio_lectivo'],
                'estado' => 'pendiente',
                'observaciones' => $validated['observaciones'] ?? null,
            ]);

            return redirect()->route('matriculas.index')
                ->with('success', 'Matrícula creada exitosamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al crear la matrícula: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar detalles de la matrícula
     */
    public function show(Matricula $matricula)
    {
        $matricula->load(['padre', 'estudiante']);
        return view('matriculas.show', compact('matricula'));
    }

    /**
     * Formulario para editar matrícula
     */
    public function edit(Matricula $matricula)
    {
        $matricula->load(['padre', 'estudiante']);

        $estudiantes = Estudiante::orderBy('nombre', 'asc')->get();
        $padres = Padre::orderBy('nombre', 'asc')->get();

        $parentescos = [
            'padre' => 'Padre',
            'madre' => 'Madre',
            'abuelo' => 'Abuelo',
            'abuela' => 'Abuela',
            'tio' => 'Tío',
            'tia' => 'Tía',
            'tutor' => 'Tutor Legal',
        ];

        $grados = Estudiante::grados();
        $secciones = ['A', 'B', 'C', 'D'];

        return view('matriculas.edit', compact('matricula', 'estudiantes', 'padres', 'parentescos', 'grados', 'secciones'));
    }

    /**
     * Actualizar matrícula
     */
    public function update(Request $request, Matricula $matricula)
    {
        $validated = $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'padre_id' => 'required|exists:padres,id',
            'parentesco' => 'required|string',
            'grado' => 'required|string',
            'seccion' => 'required|string',
            'anio_lectivo' => 'required|integer|between:2020,2099',
            'observaciones' => 'nullable|string|max:500',
        ], [
            'anio_lectivo.max' => 'El año lectivo no puede ser mayor a 2099.',
        ]);

        try {
            $matricula->update([
                'estudiante_id' => $validated['estudiante_id'],
                'padre_id' => $validated['padre_id'],
                'parentesco' => $validated['parentesco'],
                'grado' => $validated['grado'],
                'seccion' => $validated['seccion'],
                'anio_lectivo' => $validated['anio_lectivo'],
                'observaciones' => $validated['observaciones'] ?? null,
            ]);

            return redirect()->route('matriculas.index')
                ->with('success', 'Matrícula actualizada exitosamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar la matrícula: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar matrícula
     */
    public function destroy(Matricula $matricula)
    {
        try {
            $matricula->delete();
            return redirect()->route('matriculas.index')
                ->with('success', 'Matrícula eliminada exitosamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar la matrícula: ' . $e->getMessage());
        }
    }

    /**
     * Confirmar/Aprobar matrícula
     */
    public function confirmar(Matricula $matricula)
    {
        try {
            $matricula->update(['estado' => 'aprobada']);
            return redirect()->route('matriculas.index')
                ->with('success', 'Matrícula aprobada exitosamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al aprobar la matrícula: ' . $e->getMessage());
        }
    }

    /**
     * Rechazar matrícula
     */
    public function rechazar(Request $request, Matricula $matricula)
    {
        $validated = $request->validate([
            'motivo_rechazo' => 'nullable|string|max:500',
        ]);

        try {
            $matricula->update([
                'estado' => 'rechazada',
                'observaciones' => $validated['motivo_rechazo'] ?? null,
            ]);

            return redirect()->route('matriculas.index')
                ->with('success', 'Matrícula rechazada exitosamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al rechazar la matrícula: ' . $e->getMessage());
        }
    }

    /**
     * Cancelar matrícula
     */
    public function cancelar(Matricula $matricula)
    {
        try {
            $matricula->update(['estado' => 'cancelada']);
            return redirect()->route('matriculas.index')
                ->with('success', 'Matrícula cancelada exitosamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al cancelar la matrícula: ' . $e->getMessage());
        }
    }

    /**
     * Descargar comprobante de matrícula en PDF
     */
    public function descargarComprobante(Matricula $matricula)
    {
        $matricula->load(['padre', 'estudiante']);

        try {
            $pdf = Pdf::loadView('matriculas.comprobante', compact('matricula'));

            // Nombre del archivo: comprobante_matricula_6digitos.pdf
            $nombreArchivo = "comprobante_matricula_" . str_pad($matricula->id, 6, '0', STR_PAD_LEFT) . ".pdf";

            return $pdf->download($nombreArchivo);
        } catch (\Exception $e) {
            return back()->with('error', 'Error al generar el comprobante: ' . $e->getMessage());
        }
    }

    /**
     * Ver comprobante en línea (sin descargar)
     */
    public function verComprobante(Matricula $matricula)
    {
        $matricula->load(['padre', 'estudiante']);

        try {
            $pdf = Pdf::loadView('matriculas.comprobante', compact('matricula'));
            return $pdf->stream();
        } catch (\Exception $e) {
            return back()->with('error', 'Error al generar el comprobante: ' . $e->getMessage());
        }
    }
}
