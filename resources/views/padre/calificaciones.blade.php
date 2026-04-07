@extends('layouts.app')

@section('title', 'Calificaciones de mis Hijos')
@section('page-title', 'Calificaciones de mis Hijos')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

:root {
    --blue-dark:  #003b73;
    --blue-mid:   #00508f;
    --cyan:       #4ec7d2;
    --surface:    #f8fafc;
    --border:     #e2e8f0;
    --text:       #0f172a;
    --muted:      #64748b;
    --subtle:     #94a3b8;
}

.cal-wrap { font-family: 'Inter', sans-serif; }

/* ── HERO ── */
.cal-hero {
    background: linear-gradient(135deg, var(--cyan) 0%, var(--blue-mid) 55%, var(--blue-dark) 100%);
    border-radius: 14px; padding: 2rem; margin-bottom: 1.5rem;
    position: relative; overflow: hidden;
    box-shadow: 0 6px 24px rgba(0,59,115,.2);
}
.cal-hero::before {
    content: ''; position: absolute; right: -60px; top: -60px;
    width: 220px; height: 220px; border-radius: 50%;
    background: rgba(255,255,255,.08); pointer-events: none;
}
.cal-hero-inner {
    position: relative; z-index: 1;
    display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;
}
.cal-hero-icon {
    width: 72px; height: 72px; border-radius: 16px;
    background: rgba(255,255,255,.15); backdrop-filter: blur(6px);
    border: 2.5px solid rgba(255,255,255,.3);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    box-shadow: 0 4px 16px rgba(0,0,0,.2);
    font-size: 1.8rem; color: #fff;
}
.cal-hero-text { flex: 1; }
.cal-hero-title { font-size: 1.5rem; font-weight: 800; color: #fff; margin: 0 0 .3rem; }
.cal-hero-desc { color: rgba(255,255,255,.8); font-size: .9rem; margin: 0; }

/* ── STATS ── */
.cal-stats-grid {
    display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 1rem; margin-bottom: 2rem;
}
.cal-stat {
    background: #fff; border: 1px solid var(--border); border-radius: 12px;
    padding: 1.1rem 1.2rem; display: flex; align-items: center; gap: 1rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
    position: relative; overflow: hidden;
    transition: all .18s;
}
.cal-stat:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(0,59,115,.12); }
.cal-stat::before {
    content: ''; position: absolute; left: 0; top: 0; bottom: 0;
    width: 4px; border-radius: 4px 0 0 4px;
}
.cal-s1::before { background: var(--cyan); }
.cal-s2::before { background: var(--blue-mid); }
.cal-s3::before { background: #f59e0b; }
.cal-s4::before { background: #10b981; }

.cal-stat-icon {
    width: 44px; height: 44px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; font-size: 1.1rem; font-weight: 700;
}
.cal-s1 .cal-stat-icon { background: rgba(78,199,210,.12);  color: var(--cyan); }
.cal-s2 .cal-stat-icon { background: rgba(0,80,143,.1);     color: var(--blue-mid); }
.cal-s3 .cal-stat-icon { background: rgba(245,158,11,.1);   color: #f59e0b; }
.cal-s4 .cal-stat-icon { background: rgba(16,185,129,.1);   color: #10b981; }

.cal-stat-content { display: flex; flex-direction: column; gap: .2rem; }
.cal-stat-label { font-size: .65rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--subtle); }
.cal-stat-value { font-size: 1.6rem; font-weight: 800; color: var(--text); line-height: 1; }

/* ── CARD ESTUDIANTE ── */
.cal-card {
    background: #fff; border: 1px solid var(--border); border-radius: 14px;
    overflow: hidden; margin-bottom: 2rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.cal-card-header {
    padding: 1.3rem 1.5rem;
    background: linear-gradient(135deg, rgba(0,80,143,.08), rgba(78,199,210,.08));
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; gap: 1rem;
}
.cal-card-avatar {
    width: 48px; height: 48px; border-radius: 12px;
    background: linear-gradient(135deg, var(--cyan), var(--blue-mid));
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-weight: 700; font-size: 1.1rem; flex-shrink: 0;
}
.cal-card-info h6 { margin: 0; font-size: .95rem; font-weight: 700; color: var(--text); }
.cal-card-info p  { margin: 0; font-size: .75rem; color: var(--muted); }

/* ── STATS MINI ── */
.cal-mini-stats {
    padding: 1rem 1.5rem;
    background: var(--surface);
    display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: .8rem;
    border-bottom: 1px solid var(--border);
}
.cal-mini-stat {
    text-align: center;
}
.cal-mini-stat-label { font-size: .65rem; font-weight: 700; text-transform: uppercase; color: var(--subtle); margin-bottom: .2rem; }
.cal-mini-stat-value { font-size: 1.3rem; font-weight: 800; color: var(--text); }

/* ── PERÍODO HEADER ── */
.cal-periodo-header {
    padding: .8rem 1.5rem;
    background: linear-gradient(135deg, var(--blue-dark), var(--blue-mid));
    color: #fff;
    font-size: .80rem; font-weight: 700;
    display: flex; align-items: center; gap: 8px;
    letter-spacing: .5px;
}

/* ── TABLA ── */
.cal-table-wrap { overflow-x: auto; }
.cal-table {
    width: 100%; border-collapse: collapse;
    font-size: .88rem;
}
.cal-table thead th {
    background: var(--surface);
    padding: .8rem 1rem;
    border-bottom: 2px solid var(--border);
    color: var(--text);
    font-size: .70rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .07em;
    text-align: left;
}
.cal-table thead th:first-child { width: 40px; text-align: center; }
.cal-table thead th:nth-child(3) { text-align: center; }
.cal-table thead th:nth-child(4) { width: 120px; }
.cal-table tbody tr {
    border-bottom: 1px solid var(--border);
    transition: background .15s;
}
.cal-table tbody tr:hover { background: var(--surface); }
.cal-table tbody td {
    padding: .85rem 1rem;
    color: var(--text);
    vertical-align: middle;
}
.cal-table tbody td:first-child {
    text-align: center;
    color: var(--subtle);
    font-weight: 600;
}
.cal-table tbody td:nth-child(3) {
    text-align: center;
}

/* ── PROGRESS CONTAINER ── */
.cal-progress-container {
    display: flex;
    align-items: center;
    gap: .6rem;
}
.cal-progress-percent {
    font-size: .75rem;
    color: var(--subtle);
    width: 30px;
    text-align: right;
    font-weight: 600;
}

.cal-materia-name { font-weight: 600; color: var(--text); }
.cal-materia-code { font-size: .72rem; color: var(--muted); margin-top: .15rem; }

/* ── NOTA BADGE ── */
.nota-badge {
    display: inline-flex; align-items: center; justify-content: center;
    width: 50px; height: 32px; border-radius: 8px;
    font-weight: 700; font-size: .85rem;
}
.nota-pass { background: rgba(16,185,129,.12); color: #059669; }
.nota-mid  { background: rgba(245,158,11,.12); color: #b45309; }
.nota-fail { background: rgba(239,68,68,.12); color: #991b1b; }
.nota-null { background: var(--border); color: var(--muted); }

/* ── ESTADO BADGE ── */
.estado-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .25rem .6rem; border-radius: 6px;
    font-size: .75rem; font-weight: 600;
}
.estado-aprobado { background: rgba(16,185,129,.12); color: #059669; }
.estado-riesgo   { background: rgba(245,158,11,.12); color: #b45309; }
.estado-reprobado { background: rgba(239,68,68,.12); color: #991b1b; }
.estado-sin-nota { background: var(--border); color: var(--muted); }

/* ── PROGRESS BAR ── */
.cal-progress-container {
    display: flex; align-items: center; gap: .6rem;
}
.cal-progress-bar {
    height: 6px; background: var(--border); border-radius: 3px;
    overflow: hidden; flex: 1; min-width: 60px;
}
.cal-progress-fill {
    height: 100%; border-radius: 3px;
    background: var(--blue-mid);
}

/* ── PIE DE TABLA ── */
.cal-table-footer {
    padding: .8rem 1.5rem;
    background: var(--surface);
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: .8rem;
    font-size: .85rem; color: var(--muted);
    border-top: 1px solid var(--border);
}
.cal-footer-avg {
    background: linear-gradient(135deg, var(--blue-dark), var(--blue-mid));
    color: #fff; border-radius: 8px;
    padding: .4rem .9rem; font-size: .8rem; font-weight: 700;
    display: inline-flex; align-items: center; gap: .4rem;
}

/* ── VACÍO ── */
.cal-empty {
    text-align: center; padding: 2rem 1rem;
}
.cal-empty i {
    font-size: 2.5rem; color: var(--border);
    margin-bottom: 1rem; display: block;
}
.cal-empty p {
    font-size: .92rem; color: var(--muted);
}

/* ── MODO OSCURO ── */
body.dark-mode .cal-card,
body.dark-mode .cal-stat { background: #1e293b !important; border-color: #334155 !important; }
body.dark-mode .cal-card-header { background: rgba(15,23,42,.6) !important; border-color: #334155 !important; }
body.dark-mode .cal-mini-stats { background: #0f172a !important; }
body.dark-mode .cal-stat-value,
body.dark-mode .cal-materia-name { color: #f1f5f9 !important; }
body.dark-mode .cal-stat-label,
body.dark-mode .cal-materia-code,
body.dark-mode .cal-table-footer { color: #94a3b8 !important; }
body.dark-mode .cal-table thead th { background: #0f172a !important; color: #f1f5f9 !important; }
body.dark-mode .cal-table tbody tr:hover { background: rgba(255,255,255,.05) !important; }
body.dark-mode .cal-table tbody td { color: #e2e8f0 !important; border-color: #1e293b !important; }

@media(max-width: 768px) {
    .cal-stats-grid { grid-template-columns: repeat(2, 1fr); }
    .cal-mini-stats { grid-template-columns: repeat(2, 1fr); }
}

@media(max-width: 500px) {
    .cal-hero { padding: 1.5rem 1rem; }
    .cal-hero-inner { flex-direction: column; text-align: center; }
    .cal-stats-grid { grid-template-columns: 1fr; }
    .cal-mini-stats { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')
<div class="cal-wrap">

    {{-- HERO HEADER --}}
    <div class="cal-hero">
        <div class="cal-hero-inner">
            <div class="cal-hero-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="cal-hero-text">
                <div class="cal-hero-title">Calificaciones de mis Hijos</div>
                <div class="cal-hero-desc">Consulta el desempeño académico de tus hijos</div>
            </div>
        </div>
    </div>

    @if($estudiantesConCalificaciones->isEmpty())
        <div class="cal-card">
            <div class="cal-empty">
                <i class="fas fa-clipboard-list"></i>
                <p>No se encontraron calificaciones registradas para tus hijos.</p>
            </div>
        </div>
    @else
        @foreach($estudiantesConCalificaciones as $item)
        @php
            $estudiante = $item['estudiante'];
            $resumenMaterias = $item['resumenMaterias'];
            $porPeriodo = $item['porPeriodo'];
            $promedioGeneral = $item['promedioGeneral'];

            $totalMaterias  = $resumenMaterias->count();
            $aprobadas      = $resumenMaterias->where('aprobado', true)->count();
            $reprobadas     = $resumenMaterias->where('aprobado', false)->filter(fn($m) => $m['promedio'] !== null)->count();
        @endphp

        {{-- CARD POR ESTUDIANTE --}}
        <div class="cal-card">
            {{-- Header --}}
            <div class="cal-card-header">
                <div class="cal-card-avatar">
                    {{ substr($estudiante->nombre1, 0, 1) }}{{ substr($estudiante->apellido1, 0, 1) }}
                </div>
                <div class="cal-card-info">
                    <h6>{{ $estudiante->nombre1 }} {{ $estudiante->apellido1 }}</h6>
                    <p>{{ $estudiante->grado ?? 'Grado sin asignar' }} • Sección {{ $estudiante->seccion ?? '—' }}</p>
                </div>
            </div>

            {{-- Mini Stats --}}
            <div class="cal-mini-stats">
                <div class="cal-mini-stat">
                    <div class="cal-mini-stat-label">Materias</div>
                    <div class="cal-mini-stat-value">{{ $totalMaterias }}</div>
                </div>
                <div class="cal-mini-stat">
                    <div class="cal-mini-stat-label">Aprobadas</div>
                    <div class="cal-mini-stat-value" style="color: #10b981; font-weight: 800;">{{ $aprobadas }}</div>
                </div>
                <div class="cal-mini-stat">
                    <div class="cal-mini-stat-label">Reprobadas</div>
                    <div class="cal-mini-stat-value" style="color: #ef4444; font-weight: 800;">{{ $reprobadas }}</div>
                </div>
                <div class="cal-mini-stat">
                    <div class="cal-mini-stat-label">Promedio General</div>
                    <div class="cal-mini-stat-value" style="color: #4ec7d2; font-weight: 800;">{{ $promedioGeneral ?? '—' }}</div>
                </div>
            </div>

            {{-- Períodos --}}
            @forelse($porPeriodo as $periodoId => $califs)
            @php $periodo = $periodos->get($periodoId); @endphp

                <div class="cal-periodo-header">
                    <i class="fas fa-calendar-alt"></i>
                    <span>{{ $periodo?->nombre ?? 'Período ' . $periodoId }}</span>
                    <span style="margin-left: auto; font-weight: 500; opacity: .85;">
                        {{ $califs->count() }} {{ Str::plural('materia', $califs->count()) }}
                    </span>
                </div>

                <div class="cal-table-wrap">
                    <table class="cal-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Materia</th>
                                <th>Calificación</th>
                                <th>Progreso</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($califs as $i => $c)
                            @php
                                $n    = $c->nota_final;
                                $pct  = $n !== null ? min((int) $n, 100) : 0;

                                $notaClass  = $n === null ? 'nota-null'  : ($n >= 80 ? 'nota-pass'  : ($n >= 60 ? 'nota-mid'  : 'nota-fail'));
                                $estadoClass = $n === null ? 'estado-sin-nota' : ($n >= 80 ? 'estado-aprobado' : ($n >= 60 ? 'estado-riesgo' : 'estado-reprobado'));
                                $estadoText  = $n === null ? 'Sin nota'    : ($n >= 80 ? 'Aprobado'    : ($n >= 60 ? 'En riesgo' : 'Reprobado'));
                                $progColor   = $n >= 80 ? '#10b981' : ($n >= 60 ? '#f59e0b' : '#ef4444');
                            @endphp
                            <tr>
                                <td>{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</td>
                                <td>
                                    <div class="cal-materia-name">{{ $c->materia->nombre ?? '—' }}</div>
                                    <div class="cal-materia-code">{{ $c->materia->codigo ?? '' }}</div>
                                </td>
                                <td>
                                    <span class="nota-badge {{ $notaClass }}">
                                        {{ $n !== null ? number_format($n, 1) : '—' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="cal-progress-container">
                                        <div class="cal-progress-bar">
                                            <div class="cal-progress-fill" style="width: {{ $pct }}%; background: {{ $progColor }};"></div>
                                        </div>
                                        <span class="cal-progress-percent">{{ $n !== null ? $n . '%' : '—' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="estado-badge {{ $estadoClass }}">
                                        <i class="fas fa-circle" style="font-size: 6px;"></i>
                                        {{ $estadoText }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="cal-table-footer">
                    <span>{{ $califs->count() }} {{ Str::plural('registro', $califs->count()) }} en este período</span>
                    @php
                        $conNota  = $califs->whereNotNull('nota_final');
                        $promPer  = $conNota->isNotEmpty() ? round($conNota->avg('nota_final'), 2) : null;
                    @endphp
                    @if($promPer !== null)
                    <span class="cal-footer-avg">
                        <i class="fas fa-chart-line"></i>
                        Promedio: {{ $promPer }}
                    </span>
                    @endif
                </div>

            @empty
                <div class="cal-empty">
                    <i class="fas fa-inbox"></i>
                    <p>No hay calificaciones registradas para {{ $estudiante->nombre1 }} en este período.</p>
                </div>
            @endforelse

        </div><!-- FIN CARD ESTUDIANTE -->
        @endforeach

    @endif

</div>
@endsection
