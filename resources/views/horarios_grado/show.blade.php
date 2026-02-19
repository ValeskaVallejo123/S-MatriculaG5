@extends('layouts.app')

@section('title', "Horario {$grado->numero}°{$grado->seccion}")
@section('page-title', "Horario — {$grado->numero}°{$grado->seccion} (" . ucfirst($jornada) . ")")

@section('content')
<div class="container" style="max-width: 1100px;">

    <a href="{{ url()->previous() }}" class="btn btn-primary mb-3">
        <i class="fas fa-arrow-left me-1"></i> Volver
    </a>

    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-header border-0 py-3 px-4" style="background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%); border-radius: 12px 12px 0 0;">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="text-white fw-bold mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Horario de {{ $grado->numero }}°{{ $grado->seccion }} — {{ ucfirst($jornada) }}
                </h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('horarios_grado.edit', [$grado->id, $jornada]) }}"
                       class="btn btn-light btn-sm fw-semibold">
                        <i class="fas fa-edit me-1"></i> Editar
                    </a>
                    <a href="{{ route('horarios_grado.pdf', [$grado->id, $jornada]) }}"
                       class="btn btn-danger btn-sm fw-semibold">
                        <i class="fas fa-file-pdf me-1"></i> PDF
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body p-4">

            @if(!$horarioGrado || empty($horarioGrado->horario))
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-calendar-times fa-3x mb-3" style="color: #cbd5e1;"></i>
                    <p class="fw-semibold mb-1">No hay horario registrado para esta jornada.</p>
                    <small>Use el botón "Editar" para crear el horario.</small>
                </div>
            @else
                @php
                    $estructura = $horarioGrado->horario;
                    $dias = array_keys($estructura);
                    $horas = array_keys(reset($estructura));
                @endphp

                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead style="background: linear-gradient(135deg, rgba(78,199,210,0.15), rgba(0,80,143,0.2));">
                            <tr>
                                <th style="width: 150px; color: #003b73;">Hora</th>
                                @foreach($dias as $dia)
                                    <th style="color: #003b73;">{{ $dia }}</th>
                                @endforeach
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($horas as $hora)
                                <tr>
                                    <td class="fw-bold text-start" style="color: #003b73;">{{ $hora }}</td>

                                    @foreach($dias as $dia)
                                        @php $c = $estructura[$dia][$hora] ?? null; @endphp

                                        <td style="min-width: 150px;">
                                            @if($c)
                                                <strong style="color: #003b73;">
                                                    {{ optional($materias->find($c['materia_id']))->nombre ?? '—' }}
                                                </strong>
                                                <br>
                                                <small class="text-muted">
                                                    {{ optional($profesores->find($c['profesor_id']))->nombre ?? '—' }}
                                                </small>
                                                <br>
                                                <small class="text-muted">Aula: {{ $c['salon'] ?? '—' }}</small>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                    @endforeach
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
