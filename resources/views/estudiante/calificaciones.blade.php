@extends('layouts.app')

@section('title', 'Mis Calificaciones')
@section('page-title', 'Mis Calificaciones')

@section('topbar-actions')
    <a href="{{ route('estudiante.dashboard') }}"
       class="btn btn-sm"
       style="border:2px solid #00508f;color:#00508f;border-radius:8px;font-weight:600;">
        <i class="fas fa-arrow-left me-1"></i> Volver
    </a>
@endsection

@push('styles')
<style>
.nc-wrap { font-family: 'Inter', sans-serif; }

.nc-header {
    border-radius: 12px;
    background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
    padding: 1.25rem 1.5rem; margin-bottom: 1.5rem;
    display: flex; align-items: center; gap: 1rem;
}
.nc-header-icon {
    width: 52px; height: 52px; border-radius: 12px;
    background: rgba(255,255,255,0.2);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.nc-header-icon i { color: #fff; font-size: 1.4rem; }
.nc-header h5 { color: #fff; font-weight: 800; margin: 0 0 .2rem; }
.nc-header p  { color: rgba(255,255,255,.8); font-size: .83rem; margin: 0; }

/* Stat cards */
.nc-stats { display: grid; grid-template-columns: repeat(3,1fr); gap: 1rem; margin-bottom: 1.5rem; }
@media(max-width:600px){ .nc-stats { grid-template-columns: 1fr; } }

.nc-stat {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    padding: 1rem 1.25rem; display: flex; align-items: center; gap: .85rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.nc-stat-icon {
    width: 42px; height: 42px; border-radius: 10px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
}
.nc-stat-icon i { color: #fff; font-size: 1rem; }
.nc-stat-lbl { font-size: .7rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: .05em; }
.nc-stat-num { font-size: 1.6rem; font-weight: 800; color: #0f172a; line-height: 1; }

/* Tabla de resumen */
.nc-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.05); margin-bottom: 1.5rem;
}
.nc-card-head {
    background: #003b73; padding: .75rem 1.25rem;
    display: flex; align-items: center; gap: .6rem;
}
.nc-card-head i   { color: #4ec7d2; }
.nc-card-head span { color: #fff; font-weight: 700; font-size: .9rem; }

.nc-tbl { width: 100%; border-collapse: collapse; }
.nc-tbl thead th {
    background: #f8fafc; padding: .6rem 1rem;
    font-size: .7rem; font-weight: 700; letter-spacing: .07em;
    text-transform: uppercase; color: #64748b;
    border-bottom: 1.5px solid #e2e8f0;
}
.nc-tbl thead th.tc { text-align: center; }
.nc-tbl tbody td {
    padding: .7rem 1rem; border-bottom: 1px solid #f1f5f9;
    font-size: .82rem; color: #334155; vertical-align: middle;
}
.nc-tbl tbody td.tc { text-align: center; }
.nc-tbl tbody tr:last-child td { border-bottom: none; }
.nc-tbl tbody tr:hover { background: #fafbfc; }

/* Badges de nota */
.nota-badge {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 52px; padding: .3rem .7rem; border-radius: 8px;
    font-weight: 800; font-size: .9rem;
}
.nota-aprobado { background: #ecfdf5; color: #059669; }
.nota-reprobado { background: #fee2e2; color: #dc2626; }
.nota-sin  { background: #f1f5f9; color: #94a3b8; font-weight: 500; font-size: .78rem; }

/* Badge estado */
.estado-aprobado  { background: #ecfdf5; color: #059669; padding: .2rem .65rem; border-radius: 999px; font-size: .72rem; font-weight: 700; }
.estado-reprobado { background: #fee2e2; color: #dc2626; padding: .2rem .65rem; border-radius: 999px; font-size: .72rem; font-weight: 700; }

/* Períodos */
.nc-periodo-title {
    display: flex; align-items: center; gap: .5rem;
    font-size: .8rem; font-weight: 700; color: #003b73;
    background: #f0f9ff; padding: .5rem 1rem; border-left: 3px solid #4ec7d2;
    margin-bottom: 0;
}

/* Empty */
.nc-empty { padding: 3.5rem 1rem; text-align: center; }
.nc-empty i { font-size: 2rem; color: #cbd5e1; display: block; margin-bottom: .6rem; }
.nc-empty p { color: #94a3b8; font-size: .85rem; margin: 0; }
</style>
@endpush

@section('content')
<div class="nc-wrap">

    {{-- Header --}}
    <div class="nc-header">
        <div class="nc-header-icon"><i class="fas fa-graduation-cap"></i></div>
        <div>
            <h5>Mis Calificaciones</h5>
            <p>
                @if($estudiante)
                    {{ $estudiante->nombre_completo }}
                    @if($estudiante->gradoAsignado)
                        · {{ $estudiante->gradoAsignado->numero }}° {{ ucfirst($estudiante->gradoAsignado->nivel) }} — Sección {{ $estudiante->gradoAsignado->seccion }}
                    @endif
                @else
                    Estudiante
                @endif
            </p>
        </div>
    </div>

    @if(!$estudiante)
        <div class="nc-card">
            <div class="nc-empty">
                <i class="fas fa-user-times"></i>
                <p>Tu cuenta no está vinculada a un registro de estudiante.<br>Contacta al administrador.</p>
            </div>
        </div>
    @else

        {{-- Stats --}}
        @php
            $totalMaterias  = $resumenMaterias->count();
            $aprobadas      = $resumenMaterias->filter(fn($r) => $r['aprobado'])->count();
            $reprobadas     = $resumenMaterias->filter(fn($r) => $r['promedio'] !== null && !$r['aprobado'])->count();
        @endphp

        <div class="nc-stats">
            <div class="nc-stat">
                <div class="nc-stat-icon" style="background:linear-gradient(135deg,#4ec7d2,#00508f);">
                    <i class="fas fa-book-open"></i>
                </div>
                <div>
                    <div class="nc-stat-lbl">Materias</div>
                    <div class="nc-stat-num">{{ $totalMaterias }}</div>
                </div>
            </div>
            <div class="nc-stat">
                <div class="nc-stat-icon" style="background:linear-gradient(135deg,#34d399,#059669);">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <div class="nc-stat-lbl">Aprobadas</div>
                    <div class="nc-stat-num">{{ $aprobadas }}</div>
                </div>
            </div>
            <div class="nc-stat">
                <div class="nc-stat-icon" style="background:linear-gradient(135deg,#a78bfa,#7c3aed);">
                    <i class="fas fa-star"></i>
                </div>
                <div>
                    <div class="nc-stat-lbl">Promedio General</div>
                    <div class="nc-stat-num">{{ $promedioGeneral ?? '—' }}</div>
                </div>
            </div>
        </div>

        {{-- Resumen por materia --}}
        <div class="nc-card">
            <div class="nc-card-head">
                <i class="fas fa-chart-bar"></i>
                <span>Resumen por Materia</span>
            </div>
            @if($resumenMaterias->isEmpty())
                <div class="nc-empty">
                    <i class="fas fa-inbox"></i>
                    <p>Aún no hay calificaciones registradas para tu cuenta.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="nc-tbl">
                        <thead>
                            <tr>
                                <th>Materia</th>
                                @foreach($periodos as $periodo)
                                    <th class="tc">{{ $periodo->nombre_periodo }}</th>
                                @endforeach
                                <th class="tc">Promedio</th>
                                <th class="tc">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($resumenMaterias as $resumen)
                            <tr>
                                <td style="font-weight:600;color:#003b73;">
                                    <i class="fas fa-book" style="color:#4ec7d2;margin-right:.4rem;font-size:.75rem;"></i>
                                    {{ $resumen['materia']->nombre ?? '—' }}
                                </td>
                                @foreach($periodos as $periodo)
                                    @php
                                        $notaPeriodo = $resumen['notas']
                                            ->where('periodo_academico_id', $periodo->id)
                                            ->first();
                                    @endphp
                                    <td class="tc">
                                        @if($notaPeriodo && $notaPeriodo->nota !== null)
                                            <span class="nota-badge {{ $notaPeriodo->nota >= 60 ? 'nota-aprobado' : 'nota-reprobado' }}">
                                                {{ number_format($notaPeriodo->nota, 1) }}
                                            </span>
                                        @else
                                            <span class="nota-badge nota-sin">—</span>
                                        @endif
                                    </td>
                                @endforeach
                                <td class="tc">
                                    @if($resumen['promedio'] !== null)
                                        <span class="nota-badge {{ $resumen['aprobado'] ? 'nota-aprobado' : 'nota-reprobado' }}">
                                            {{ $resumen['promedio'] }}
                                        </span>
                                    @else
                                        <span class="nota-badge nota-sin">—</span>
                                    @endif
                                </td>
                                <td class="tc">
                                    @if($resumen['promedio'] !== null)
                                        <span class="{{ $resumen['aprobado'] ? 'estado-aprobado' : 'estado-reprobado' }}">
                                            <i class="fas fa-{{ $resumen['aprobado'] ? 'check' : 'times' }}"></i>
                                            {{ $resumen['aprobado'] ? 'Aprobado' : 'Reprobado' }}
                                        </span>
                                    @else
                                        <span style="color:#94a3b8;font-size:.75rem;">Pendiente</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- Detalle por período --}}
        @if($porPeriodo->isNotEmpty())
        <div class="nc-card">
            <div class="nc-card-head">
                <i class="fas fa-list-alt"></i>
                <span>Detalle por Período</span>
            </div>
            @foreach($porPeriodo as $periodoId => $notas)
                @php $per = $periodos[$periodoId] ?? null; @endphp
                <div class="nc-periodo-title">
                    <i class="fas fa-calendar-check"></i>
                    {{ $per?->nombre_periodo ?? 'Período ' . $periodoId }}
                </div>
                <div class="table-responsive">
                    <table class="nc-tbl">
                        <thead>
                            <tr>
                                <th>Materia</th>
                                <th>Profesor</th>
                                <th class="tc">Nota</th>
                                <th>Observación</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($notas as $cal)
                            <tr>
                                <td style="font-weight:600;">{{ $cal->materia->nombre ?? '—' }}</td>
                                <td style="font-size:.78rem;color:#64748b;">
                                    {{ $cal->profesor ? $cal->profesor->nombre . ' ' . $cal->profesor->apellido : '—' }}
                                </td>
                                <td class="tc">
                                    @if($cal->nota !== null)
                                        <span class="nota-badge {{ $cal->nota >= 60 ? 'nota-aprobado' : 'nota-reprobado' }}">
                                            {{ number_format($cal->nota, 1) }}
                                        </span>
                                    @else
                                        <span class="nota-badge nota-sin">—</span>
                                    @endif
                                </td>
                                <td style="font-size:.78rem;color:#64748b;">
                                    {{ $cal->observacion ?? '—' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
        @endif

    @endif

</div>
@endsection
