@extends('layouts.app')

@section('title', 'Mi Horario')
@section('page-title', 'Horario de Clases')

@section('content')
<div class="container" style="max-width: 1000px;">

    <!-- Tarjeta principal -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
        <div class="card-body">
            <h4 class="fw-bold mb-3" style="color: #003b73;">Mi Horario de Clases</h4>

            @if($horario->isEmpty())
                <p class="text-muted">No tienes clases asignadas por el momento.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0" style="color: #003b73;">
                        <thead style="background: linear-gradient(135deg, rgba(78, 199, 210, 0.15), rgba(0, 80, 143, 0.1)); border-bottom: 2px solid #4ec7d2;">
                            <tr>
                                <th>Día</th>
                                <th>Hora Inicio</th>
                                <th>Hora Fin</th>
                                <th>Materia</th>
                                <th>Profesor</th>
                                <th>Salón</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($horario as $clase)
                                @php
                                    // Resaltar filas actualizadas en las últimas 24 horas
                                    $resaltado = $clase->updated_at->diffInHours(now()) < 24;
                                @endphp

                                <tr style="{{ $resaltado ? 'background-color: rgba(78, 199, 210, 0.1); border-left: 4px solid #4ec7d2;' : '' }}">

                                    <td>{{ $clase->dia }}</td>

                                    <td>{{ $clase->hora_inicio->format('H:i') }}</td>

                                    <td>{{ $clase->hora_fin->format('H:i') }}</td>

                                    <td>{{ $clase->materia->nombre ?? '—' }}</td>

                                    <td>{{ $clase->profesor->nombre ?? '—' }}</td>

                                    <td>{{ $clase->salon ?? '—' }}</td>

                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>

</div>
@endsection
