@extends('layouts.app')

@section('title', 'Horarios Públicos')
@section('page-title', 'Horarios Académicos')

@section('content')
<div class="container" style="max-width: 1200px;">

    <!-- Tabla de horarios públicos -->
    <div class="card border-0 shadow-sm" style="border-radius: 10px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="color: #003b73;">
                    <thead style="background: linear-gradient(135deg, rgba(78, 199, 210, 0.15), rgba(0, 80, 143, 0.1)); border-bottom: 2px solid #4ec7d2;">
                        <tr>
                            @if(Auth::check() && Auth::user()->user_type === 'admin')
                                <th style="padding: 15px; font-weight: 700; color: #003b73;">Profesor</th>
                            @endif
                            <th style="padding: 15px; font-weight: 700; color: #003b73;">Día</th>
                            <th style="padding: 15px; font-weight: 700; color: #003b73;">Hora Inicio</th>
                            <th style="padding: 15px; font-weight: 700; color: #003b73;">Hora Fin</th>
                            <th style="padding: 15px; font-weight: 700; color: #003b73;">Grado</th>
                            <th style="padding: 15px; font-weight: 700; color: #003b73;">Sección</th>
                            <th style="padding: 15px; font-weight: 700; color: #003b73;">Aula</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($horarios as $horario)
                            <tr>
                                @if(Auth::check() && Auth::user()->user_type === 'admin')
                                    <td style="padding: 12px 15px;">{{ $horario->profesor->nombre ?? 'Sin asignar' }}</td>
                                @endif
                                <td style="padding: 12px 15px;">{{ $horario->dia }}</td>
                                <td style="padding: 12px 15px;">{{ \Carbon\Carbon::createFromFormat('H:i:s', $horario->hora_inicio)->format('H:i') }}</td>
                                <td style="padding: 12px 15px;">{{ \Carbon\Carbon::createFromFormat('H:i:s', $horario->hora_fin)->format('H:i') }}</td>
                                <td style="padding: 12px 15px;">{{ $horario->grado }}</td>
                                <td style="padding: 12px 15px;">{{ $horario->seccion }}</td>
                                <td style="padding: 12px 15px;">{{ $horario->aula ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ Auth::check() && Auth::user()->user_type === 'admin' ? 7 : 6 }}"
                                    style="padding: 40px; text-align: center; color: #95a5a6;">
                                    <i class="fas fa-calendar-times" style="font-size: 2rem; opacity: 0.5;"></i>
                                    <p class="mt-2">No hay horarios disponibles públicamente</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
