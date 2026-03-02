@extends('layouts.app')

@section('title', 'Todas las Calificaciones')
@section('page-title', 'Listado General de Calificaciones')

@section('content')
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <strong>Calificaciones Registradas</strong>
            </div>

            <div class="card-body">

                {{-- Barra de desplazamiento horizontal --}}
                <div style="overflow-x: auto;">

                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th style="min-width:200px;">Estudiante</th>
                            <th style="min-width:180px;">Grado</th>
                            <th style="min-width:150px;">Materia</th>
                            <th style="min-width:150px;">Periodo Académico</th>
                            <th style="min-width:100px;">Nota</th>
                            <th style="min-width:200px;">Observación</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($calificaciones as $calificacion)
                            <tr>
                                <td>
                                    {{ $calificacion->estudiante->apellido1 ?? '' }}
                                    {{ $calificacion->estudiante->nombre1 ?? '' }}
                                </td>
                                <td>
                                    {{ $calificacion->grado->numero ?? '' }}°
                                    {{ ucfirst($calificacion->grado->nivel ?? '') }}
                                    - Sección {{ $calificacion->grado->seccion ?? '' }}
                                </td>
                                <td>
                                    {{ $calificacion->materia->nombre ?? '' }}
                                </td>
                                <td>
                                    {{ $calificacion->periodoAcademico->nombre_periodo ?? 'No asignado' }}
                                </td>
                                <td>
                                    {{ $calificacion->nota }}
                                </td>
                                <td>
                                    {{ $calificacion->observacion ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    No hay calificaciones registradas.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                </div>

                {{-- Paginación --}}
                <div class="mt-3">
                    {{ $calificaciones->links() }}
                </div>

            </div>
        </div>

    </div>
@endsection
