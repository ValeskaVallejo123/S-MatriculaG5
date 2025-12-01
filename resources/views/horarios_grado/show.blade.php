@extends('layouts.app')

@section('title', "Horario {$grado->numero}°{$grado->seccion}")
@section('page-title', "Horario — {$grado->numero}°{$grado->seccion} (" . ucfirst($jornada) . ")")

@section('content')
<div class="container" style="max-width:1100px;">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">

            <div class="d-flex justify-content-between mb-3">
                <h4 class="fw-bold" style="color:#003b73;">
                    Horario de {{ $grado->numero }}°{{ $grado->seccion }} — {{ ucfirst($jornada) }}
                </h4>

                <div>
                    <a href="{{ route('horarios_grado.edit', [$grado->id, $jornada]) }}"
                       class="btn btn-primary btn-sm">Editar</a>
                    <a href="{{ route('horarios_grado.pdf', [$grado->id, $jornada]) }}"
                       class="btn btn-danger btn-sm">PDF</a>
                </div>
            </div>

            @php
                $estructura = $horarioGrado->horario;
                $dias = array_keys($estructura);
                $horas = array_keys(reset($estructura));
            @endphp

            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead style="background:linear-gradient(135deg, rgba(78,199,210,0.15), rgba(0,80,143,0.2));">
                        <tr>
                            <th style="width:150px;">Hora</th>
                            @foreach($dias as $dia)
                                <th>{{ $dia }}</th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($horas as $hora)
                            <tr>
                                <td class="fw-bold text-start">{{ $hora }}</td>

                                @foreach($dias as $dia)
                                    @php $c = $estructura[$dia][$hora]; @endphp

                                    <td style="min-width:150px;">
                                        @if($c)
                                            <strong>{{ optional($materias->find($c['materia_id']))->nombre }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                {{ optional($profesores->find($c['profesor_id']))->nombre ?? '—' }}
                                            </small>
                                            <br>
                                            <small>Aula: {{ $c['salon'] ?? '—' }}</small>
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

        </div>
    </div>
</div>
@endsection
