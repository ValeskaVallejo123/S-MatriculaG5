@extends('layouts.app')

@section('title', 'Mi Horario')
@section('page-title', 'Horario de Clases')

@section('content')
<div class="container" style="max-width: 1000px;">

    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">

        <div class="card-header border-0 py-3 px-4"
             style="background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%); border-radius: 12px 12px 0 0;">
            <h5 class="text-white fw-bold mb-0">
                <i class="fas fa-calendar-alt me-2"></i>Mi Horario de Clases
            </h5>
        </div>

        <div class="card-body p-0">

            @if($horario->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-calendar-times fa-3x mb-3" style="color:#cbd5e1;"></i>
                    <p class="fw-semibold text-muted mb-0">No tienes clases asignadas por el momento.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background: linear-gradient(135deg, rgba(78,199,210,0.15), rgba(0,80,143,0.1)); border-bottom: 2px solid #4ec7d2;">
                            <tr>
                                <th class="px-3 py-3" style="color:#003b73;font-size:0.8rem;text-transform:uppercase;letter-spacing:0.3px;">Día</th>
                                <th class="px-3 py-3" style="color:#003b73;font-size:0.8rem;text-transform:uppercase;letter-spacing:0.3px;">Hora Inicio</th>
                                <th class="px-3 py-3" style="color:#003b73;font-size:0.8rem;text-transform:uppercase;letter-spacing:0.3px;">Hora Fin</th>
                                <th class="px-3 py-3" style="color:#003b73;font-size:0.8rem;text-transform:uppercase;letter-spacing:0.3px;">Materia</th>
                                <th class="px-3 py-3" style="color:#003b73;font-size:0.8rem;text-transform:uppercase;letter-spacing:0.3px;">Profesor</th>
                                <th class="px-3 py-3" style="color:#003b73;font-size:0.8rem;text-transform:uppercase;letter-spacing:0.3px;">Salón</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($horario as $clase)
                                @php
                                    {{-- Resaltar filas actualizadas en las últimas 24 horas --}}
                                    $resaltado = $clase->updated_at->diffInHours(now()) < 24;

                                    {{-- Proteger hora_inicio y hora_fin por si son strings y no Carbon --}}
                                    $horaInicio = $clase->hora_inicio instanceof \Carbon\Carbon
                                        ? $clase->hora_inicio
                                        : \Carbon\Carbon::parse($clase->hora_inicio);

                                    $horaFin = $clase->hora_fin instanceof \Carbon\Carbon
                                        ? $clase->hora_fin
                                        : \Carbon\Carbon::parse($clase->hora_fin);
                                @endphp

                                <tr style="{{ $resaltado ? 'background-color: rgba(78,199,210,0.08); border-left: 4px solid #4ec7d2;' : '' }}">

                                    <td class="px-3 py-2 fw-semibold" style="color:#003b73;">
                                        {{ $clase->dia }}
                                    </td>

                                    <td class="px-3 py-2">
                                        <span class="badge" style="background:rgba(78,199,210,0.15);color:#00508f;border:1px solid #4ec7d2;font-size:0.8rem;">
                                            <i class="fas fa-clock me-1"></i>{{ $horaInicio->format('H:i') }}
                                        </span>
                                    </td>

                                    <td class="px-3 py-2">
                                        <span class="badge" style="background:rgba(78,199,210,0.15);color:#00508f;border:1px solid #4ec7d2;font-size:0.8rem;">
                                            <i class="fas fa-clock me-1"></i>{{ $horaFin->format('H:i') }}
                                        </span>
                                    </td>

                                    <td class="px-3 py-2 fw-semibold" style="color:#003b73;">
                                        {{ $clase->materia->nombre ?? '—' }}
                                    </td>

                                    <td class="px-3 py-2 text-muted">
                                        {{-- Protegido: puede venir de profesor->nombre o profesor->user->name --}}
                                        {{ $clase->profesor->nombre ?? $clase->profesor->user->name ?? '—' }}
                                    </td>

                                    <td class="px-3 py-2 text-muted">
                                        {{ $clase->salon ?? '—' }}
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Leyenda de resaltado --}}
                <div class="px-4 py-2 border-top">
                    <small class="text-muted">
                        <span style="display:inline-block;width:12px;height:12px;background:rgba(78,199,210,0.3);border-left:3px solid #4ec7d2;margin-right:4px;"></span>
                        Clases actualizadas en las últimas 24 horas
                    </small>
                </div>
            @endif

        </div>
    </div>

</div>
@endsection
