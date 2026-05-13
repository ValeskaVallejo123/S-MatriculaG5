@extends('layouts.app')

@section('title', 'Mis Calificaciones')
@section('page-title', 'Mis Calificaciones')


@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

:root {
    --blue:   #00508f;
    --dark:   #003b73;
    --teal:   #4ec7d2;
    --border: #e2e8f0;
    --muted:  #64748b;
}

.nc-wrap { font-family: 'Inter', sans-serif; }

/* ── Header ── */
.nc-header {
    border-radius: 14px;
    background: linear-gradient(135deg, #002d5a 0%, #00508f 55%, #0077b6 100%);
    padding: 1.5rem 1.75rem; margin-bottom: 1.5rem;
    display: flex; align-items: center; gap: 1.1rem;
    position: relative; overflow: hidden;
}
.nc-header::before {
    content:''; position:absolute; right:-40px; top:-40px;
    width:160px; height:160px; border-radius:50%;
    background:rgba(78,199,210,.12); pointer-events:none;
}
.nc-header-icon {
    width: 56px; height: 56px; border-radius: 14px;
    background: rgba(255,255,255,.15);
    border: 2px solid rgba(78,199,210,.5);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    position: relative; z-index: 1;
}
.nc-header-icon i { color: #fff; font-size: 1.4rem; }
.nc-header-info { position: relative; z-index: 1; }
.nc-header h5 { color: #fff; font-weight: 800; margin: 0 0 .2rem; font-size: 1.15rem; }
.nc-header p  { color: rgba(255,255,255,.75); font-size: .82rem; margin: 0; }

/* ── Stats ── */
.nc-stats { display: grid; grid-template-columns: repeat(4,1fr); gap: 1rem; margin-bottom: 1.5rem; }
@media(max-width:768px){ .nc-stats { grid-template-columns: repeat(2,1fr); } }
@media(max-width:480px){ .nc-stats { grid-template-columns: 1fr; } }

.nc-stat {
    background: #fff; border: 1px solid var(--border); border-radius: 12px;
    padding: 1rem 1.1rem; display: flex; align-items: center; gap: .8rem;
    box-shadow: 0 1px 4px rgba(0,0,0,.05);
}
.nc-stat-icon {
    width: 42px; height: 42px; border-radius: 10px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
}
.nc-stat-icon i { color: #fff; font-size: 1rem; }
.nc-stat-lbl { font-size: .68rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: .05em; }
.nc-stat-num { font-size: 1.55rem; font-weight: 800; color: #0f172a; line-height: 1.1; }

/* ── Card ── */
.nc-card {
    background: #fff; border: 1px solid var(--border); border-radius: 14px;
    overflow: hidden; box-shadow: 0 2px 8px rgba(0,59,115,.07); margin-bottom: 1.5rem;
}
.nc-card-head {
    background: var(--dark); padding: .8rem 1.25rem;
    display: flex; align-items: center; gap: .6rem;
}
.nc-card-head i    { color: var(--teal); }
.nc-card-head span { color: #fff; font-weight: 700; font-size: .9rem; }

/* ── Tabla ── */
.nc-tbl { width: 100%; border-collapse: collapse; }
.nc-tbl thead th {
    background: #f8fafc; padding: .65rem 1rem;
    font-size: .67rem; font-weight: 700; letter-spacing: .07em;
    text-transform: uppercase; color: var(--muted);
    border-bottom: 1.5px solid var(--border); white-space: nowrap;
}
.nc-tbl thead th.tc { text-align: center; }
.nc-tbl tbody td {
    padding: .7rem 1rem; border-bottom: 1px solid #f1f5f9;
    font-size: .82rem; color: #334155; vertical-align: middle;
}
.nc-tbl tbody td.tc { text-align: center; }
.nc-tbl tbody tr:last-child td { border-bottom: none; }
.nc-tbl tbody tr:hover { background: #fafbfc; }

/* ── Badges de nota ── */
.nota-badge {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 46px; padding: .28rem .6rem; border-radius: 8px;
    font-weight: 800; font-size: .88rem;
}
.nota-aprobado  { background: #ecfdf5; color: #059669; }
.nota-reprobado { background: #fee2e2; color: #dc2626; }
.nota-parcial   { background: #f0f9ff; color: #0284c7; }
.nota-sin       { background: #f1f5f9; color: #94a3b8; font-weight: 500; font-size: .75rem; }

/* ── Período title ── */
.nc-periodo-title {
    display: flex; align-items: center; gap: .5rem;
    font-size: .8rem; font-weight: 700; color: var(--dark);
    background: linear-gradient(135deg, rgba(78,199,210,.08), rgba(0,80,143,.04));
    padding: .6rem 1.25rem; border-left: 3px solid var(--teal);
}

/* ── Estado badge ── */
.estado-aprobado  { background:#ecfdf5; color:#059669; padding:.2rem .7rem; border-radius:999px; font-size:.72rem; font-weight:700; }
.estado-reprobado { background:#fee2e2; color:#dc2626; padding:.2rem .7rem; border-radius:999px; font-size:.72rem; font-weight:700; }
.estado-pendiente { background:#f1f5f9; color:#94a3b8; padding:.2rem .7rem; border-radius:999px; font-size:.72rem; font-weight:600; }

/* ── Empty ── */
.nc-empty { padding: 3.5rem 1rem; text-align: center; }
.nc-empty i { font-size: 2.2rem; color: #cbd5e1; display: block; margin-bottom: .7rem; }
.nc-empty p { color: #94a3b8; font-size: .85rem; margin: 0 0 .3rem; font-weight: 600; }
.nc-empty small { color: #b0bec5; font-size: .78rem; }
</style>
@endpush

@section('content')
<div class="nc-wrap">

    {{-- ── Header ── --}}
    <div class="nc-header">
        <div class="nc-header-icon"><i class="fas fa-graduation-cap"></i></div>
        <div class="nc-header-info">
            <h5>Mis Calificaciones</h5>
            <p>
                @if($estudiante)
                    {{ $estudiante->nombre_completo }}
                    @if($estudiante->gradoAsignado)
                        · {{ $estudiante->gradoAsignado->numero }}°
                        {{ ucfirst($estudiante->gradoAsignado->nivel) }}
                        — Sección {{ $estudiante->gradoAsignado->seccion }}
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
                <p>Tu cuenta no está vinculada a un registro de estudiante.</p>
                <small>Contacta al administrador del sistema.</small>
            </div>
        </div>

    @else

        {{-- ── Stats ── --}}
        @php
            $totalMaterias = $resumenMaterias->count();
            $aprobadas     = $resumenMaterias->filter(fn($r) => $r['aprobado'])->count();
            $reprobadas    = $resumenMaterias->filter(fn($r) => $r['promedio'] !== null && !$r['aprobado'])->count();
            $pendientes    = $resumenMaterias->filter(fn($r) => $r['promedio'] === null)->count();
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
                <div class="nc-stat-icon" style="background:linear-gradient(135deg,#f87171,#dc2626);">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div>
                    <div class="nc-stat-lbl">Reprobadas</div>
                    <div class="nc-stat-num">{{ $reprobadas }}</div>
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

        {{-- ── Resumen por materia ── --}}
        <div class="nc-card">
            <div class="nc-card-head">
                <i class="fas fa-chart-bar"></i>
                <span>Resumen por Materia</span>
            </div>

            @if($resumenMaterias->isEmpty())
                <div class="nc-empty">
                    <i class="fas fa-inbox"></i>
                    <p>Aún no hay calificaciones registradas</p>
                    <small>Cuando tu profesor registre notas, aparecerán aquí.</small>
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
                                <th class="tc">Promedio Final</th>
                                <th class="tc">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($resumenMaterias as $resumen)
                            <tr>
                                <td style="font-weight:600;color:var(--dark);">
                                    <i class="fas fa-book" style="color:var(--teal);margin-right:.4rem;font-size:.75rem;"></i>
                                    {{ $resumen['materia']->nombre ?? '—' }}
                                </td>
                                @foreach($periodos as $periodo)
                                    @php
                                        $notaPeriodo = $resumen['notas']
                                            ->where('periodo_id', $periodo->id)
                                            ->first();
                                    @endphp
                                    <td class="tc">
                                        @if($notaPeriodo && $notaPeriodo->nota_final !== null)
                                            <span class="nota-badge {{ $notaPeriodo->nota_final >= 60 ? 'nota-aprobado' : 'nota-reprobado' }}">
                                                {{ number_format($notaPeriodo->nota_final, 1) }}
                                            </span>
                                        @else
                                            <span class="nota-badge nota-sin">—</span>
                                        @endif
                                    </td>
                                @endforeach
                                <td class="tc">
                                    @if($resumen['promedio'] !== null)
                                        <span class="nota-badge {{ $resumen['aprobado'] ? 'nota-aprobado' : 'nota-reprobado' }}" style="font-size:.95rem;">
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
                                        <span class="estado-pendiente">Pendiente</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- ── Detalle por período ── --}}
        @if($porPeriodo->isNotEmpty())
        <div class="nc-card">
            <div class="nc-card-head">
                <i class="fas fa-list-alt"></i>
                <span>Detalle por Período</span>
            </div>

            @foreach($porPeriodo as $periodoId => $notas)
                @php $per = $periodos[$periodoId] ?? null; @endphp
                <div class="nc-periodo-title">
                    <i class="fas fa-calendar-check" style="color:var(--teal);"></i>
                    {{ $per?->nombre_periodo ?? 'Período ' . $periodoId }}
                </div>
                <div class="table-responsive">
                    <table class="nc-tbl">
                        <thead>
                            <tr>
                                <th>Materia</th>
                                <th class="tc">1er Parcial</th>
                                <th class="tc">2do Parcial</th>
                                <th class="tc">3er Parcial</th>
                                <th class="tc">Recuperación</th>
                                <th class="tc">Nota Final</th>
                                <th class="tc">Estado</th>
                                <th>Observación</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($notas as $cal)
                            <tr>
                                <td style="font-weight:600;color:var(--dark);">
                                    <i class="fas fa-book" style="color:var(--teal);margin-right:.35rem;font-size:.72rem;"></i>
                                    {{ $cal->materia->nombre ?? '—' }}
                                </td>
                                {{-- Parcial 1 --}}
                                <td class="tc">
                                    @if($cal->primer_parcial !== null)
                                        <span class="nota-badge nota-parcial">{{ number_format($cal->primer_parcial, 1) }}</span>
                                    @else <span class="nota-badge nota-sin">—</span> @endif
                                </td>
                                {{-- Parcial 2 --}}
                                <td class="tc">
                                    @if($cal->segundo_parcial !== null)
                                        <span class="nota-badge nota-parcial">{{ number_format($cal->segundo_parcial, 1) }}</span>
                                    @else <span class="nota-badge nota-sin">—</span> @endif
                                </td>
                                {{-- Parcial 3 --}}
                                <td class="tc">
                                    @if($cal->tercer_parcial !== null)
                                        <span class="nota-badge nota-parcial">{{ number_format($cal->tercer_parcial, 1) }}</span>
                                    @else <span class="nota-badge nota-sin">—</span> @endif
                                </td>
                                {{-- Recuperación --}}
                                <td class="tc">
                                    @if($cal->recuperacion !== null)
                                        <span class="nota-badge" style="background:#fff7ed;color:#c2410c;">
                                            {{ number_format($cal->recuperacion, 1) }}
                                        </span>
                                    @else <span class="nota-badge nota-sin">—</span> @endif
                                </td>
                                {{-- Nota final --}}
                                <td class="tc">
                                    @if($cal->nota_final !== null)
                                        <span class="nota-badge {{ $cal->nota_final >= 60 ? 'nota-aprobado' : 'nota-reprobado' }}" style="font-size:.92rem;">
                                            {{ number_format($cal->nota_final, 1) }}
                                        </span>
                                    @else <span class="nota-badge nota-sin">—</span> @endif
                                </td>
                                {{-- Estado --}}
                                <td class="tc">
                                    @if($cal->nota_final !== null)
                                        <span class="{{ $cal->nota_final >= 60 ? 'estado-aprobado' : 'estado-reprobado' }}">
                                            {{ $cal->nota_final >= 60 ? 'Aprobado' : 'Reprobado' }}
                                        </span>
                                    @else
                                        <span class="estado-pendiente">Pendiente</span>
                                    @endif
                                </td>
                                {{-- Observación --}}
                                <td style="font-size:.78rem;color:var(--muted);max-width:180px;">
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
