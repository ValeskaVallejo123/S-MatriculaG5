@extends('layouts.app')

@section('title', 'Dashboard Padre')
@section('page-title', 'Portal de Padres')

@push('styles')
<style>
    :root {
        --blue-dark: #003b73; --blue-mid: #00508f;
        --teal: #4ec7d2; --teal-light: rgba(78,199,210,0.12);
        --border: #e8edf4; --surface: #f5f8fc;
        --text-main: #0d2137; --text-muted: #6b7a90;
        --green: #10b981; --amber: #f59e0b; --red: #ef4444;
        --radius-lg: 14px; --shadow-sm: 0 1px 4px rgba(0,59,115,0.07);
        --shadow-md: 0 4px 16px rgba(0,59,115,0.10);
    }

    /* ── Banner bienvenida ── */
    .pad-banner {
        background: linear-gradient(135deg, var(--blue-dark), var(--blue-mid) 60%, var(--teal));
        border-radius: var(--radius-lg); padding: 1.4rem 1.75rem;
        display: flex; align-items: center; gap: 1.25rem;
        box-shadow: var(--shadow-md); position: relative; overflow: hidden; margin-bottom: 1.5rem;
    }
    .pad-banner::before {
        content:''; position:absolute; top:-40%; right:-4%;
        width:200px; height:200px; background:rgba(255,255,255,.07); border-radius:50%;
    }
    .pad-banner-icon {
        width: 58px; height: 58px; border-radius: 14px; flex-shrink: 0;
        background: rgba(255,255,255,.18); border: 2px solid rgba(255,255,255,.3);
        display: flex; align-items: center; justify-content: center;
        color: white; font-size: 1.5rem; position: relative; z-index: 1;
    }
    .pad-banner-name { color: white; font-weight: 700; font-size: 1.15rem; margin: 0 0 .2rem; }
    .pad-banner-sub  { color: rgba(255,255,255,.7); font-size: .82rem; margin: 0; }

    /* ── Stats ── */
    .pad-stats {
        display: grid; grid-template-columns: repeat(3,1fr);
        gap: 1rem; margin-bottom: 1.5rem;
    }
    @media(max-width:768px){ .pad-stats { grid-template-columns: 1fr 1fr; } }
    @media(max-width:480px){ .pad-stats { grid-template-columns: 1fr; } }

    .pad-stat {
        background: white; border-radius: var(--radius-lg);
        border: 1px solid var(--border); padding: 1.1rem 1.25rem;
        display: flex; align-items: center; gap: 1rem;
        box-shadow: var(--shadow-sm); transition: transform .2s, box-shadow .2s;
        position: relative; overflow: hidden;
    }
    .pad-stat::before { content:''; position:absolute; top:0; left:0; width:4px; height:100%; border-radius:4px 0 0 4px; }
    .ps-teal::before  { background: var(--teal); }
    .ps-blue::before  { background: var(--blue-mid); }
    .ps-indigo::before{ background: #818cf8; }
    .pad-stat:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

    .pad-stat-icon { width:46px; height:46px; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0; font-size:1.15rem; }
    .ps-teal   .pad-stat-icon { background: var(--teal-light);       color: var(--teal); }
    .ps-blue   .pad-stat-icon { background: rgba(0,80,143,.1);        color: var(--blue-mid); }
    .ps-indigo .pad-stat-icon { background: rgba(129,140,248,.15);    color: #4f46e5; }

    .pad-stat-lbl { font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:var(--text-muted); margin-bottom:.2rem; }
    .pad-stat-num { font-size:1.75rem; font-weight:800; color:var(--blue-dark); line-height:1; }

    /* ── Section card ── */
    .pad-card {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); overflow: hidden;
        box-shadow: var(--shadow-sm); margin-bottom: 1.25rem;
    }
    .pad-card-head {
        background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-mid) 100%);
        padding: .9rem 1.4rem; display: flex; align-items: center; gap: .6rem;
    }
    .pad-card-head i    { color: var(--teal); font-size: 1rem; }
    .pad-card-head span { color: white; font-weight: 700; font-size: .95rem; }
    .pad-card-body { padding: 1.25rem; }

    /* ── Tabs de hijos ── */
    .hijo-tabs {
        display: flex; gap: .4rem; flex-wrap: wrap; margin-bottom: 1.25rem;
        border-bottom: 2px solid var(--border); padding-bottom: 0;
    }
    .hijo-tab {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .55rem 1.1rem; border-radius: 8px 8px 0 0;
        font-size: .83rem; font-weight: 600; cursor: pointer;
        border: none; background: var(--surface); color: var(--text-muted);
        border-bottom: 2px solid transparent; margin-bottom: -2px;
        transition: all .15s;
    }
    .hijo-tab.active {
        background: white; color: var(--blue-dark);
        border-bottom-color: var(--teal); border-left: 1px solid var(--border);
        border-right: 1px solid var(--border); border-top: 1px solid var(--border);
    }
    .hijo-tab:hover:not(.active) { color: var(--blue-mid); background: white; }
    .hijo-av-sm {
        width: 26px; height: 26px; border-radius: 7px; flex-shrink: 0;
        background: linear-gradient(135deg, var(--teal), var(--blue-mid));
        display: inline-flex; align-items: center; justify-content: center;
        color: white; font-weight: 700; font-size: .72rem;
    }

    .hijo-panel { display: none; }
    .hijo-panel.active { display: block; }

    /* ── Info estudiante ── */
    .est-info-bar {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: 10px; padding: .85rem 1.1rem;
        display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;
        margin-bottom: 1.25rem;
    }
    .est-info-av {
        width: 46px; height: 46px; border-radius: 11px; flex-shrink: 0;
        background: linear-gradient(135deg, var(--teal), var(--blue-mid));
        display: flex; align-items: center; justify-content: center;
        color: white; font-weight: 700; font-size: 1rem;
        border: 2px solid rgba(78,199,210,.3);
    }
    .est-info-name { font-weight: 700; color: var(--blue-dark); font-size: .92rem; }
    .est-info-sub  { font-size: .73rem; color: var(--text-muted); margin-top: .1rem; }
    .bpill { display:inline-flex; align-items:center; gap:.25rem; padding:.22rem .65rem; border-radius:999px; font-size:.72rem; font-weight:600; white-space:nowrap; }
    .b-teal  { background:var(--teal-light); color:var(--blue-mid); border:1px solid rgba(78,199,210,.35); }
    .b-green { background:rgba(16,185,129,.1); color:#059669; border:1px solid rgba(16,185,129,.3); }
    .b-gray  { background:#f1f5f9; color:#64748b; border:1px solid #e2e8f0; }

    /* ── Calificaciones por período ── */
    .periodo-block { margin-bottom: 1.25rem; }
    .periodo-block:last-child { margin-bottom: 0; }
    .periodo-title {
        font-size: .72rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .07em; color: var(--teal); margin-bottom: .65rem;
        display: flex; align-items: center; gap: .4rem;
    }
    .periodo-title i { font-size: .65rem; }

    .cal-tbl { width: 100%; border-collapse: collapse; }
    .cal-tbl thead th {
        background: var(--surface); padding: .55rem .9rem;
        font-size: .67rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .06em; color: var(--text-muted);
        border-bottom: 1.5px solid var(--border);
    }
    .cal-tbl thead th.tc { text-align: center; }
    .cal-tbl tbody td { padding: .65rem .9rem; border-bottom: 1px solid #f1f5f9; font-size: .83rem; color: var(--text-main); vertical-align: middle; }
    .cal-tbl tbody td.tc { text-align: center; }
    .cal-tbl tbody tr:last-child td { border-bottom: none; }
    .cal-tbl tbody tr:hover { background: #f7fbff; }

    .nota-badge {
        display: inline-flex; align-items: center; justify-content: center;
        width: 38px; height: 28px; border-radius: 7px;
        font-size: .8rem; font-weight: 800;
    }
    .nota-excelente { background: rgba(16,185,129,.12); color: #059669; }
    .nota-buena     { background: rgba(78,199,210,.12); color: var(--blue-mid); }
    .nota-regular   { background: rgba(245,158,11,.12); color: #92400e; }
    .nota-baja      { background: rgba(239,68,68,.12);  color: #dc2626; }

    /* ── Promedio general ── */
    .promedio-card {
        background: linear-gradient(135deg, var(--blue-dark), var(--blue-mid));
        border-radius: 10px; padding: .85rem 1.1rem;
        display: flex; align-items: center; justify-content: space-between;
        margin-top: 1rem;
    }
    .promedio-label { font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: rgba(255,255,255,.65); }
    .promedio-val   { font-size: 1.6rem; font-weight: 800; color: white; }

    /* ── Vacío ── */
    .pad-empty { text-align: center; padding: 3.5rem 1rem; }
    .pad-empty i  { font-size: 2.5rem; color: #cbd5e1; display: block; margin-bottom: 1rem; }
    .pad-empty h6 { color: var(--blue-dark); font-weight: 600; margin-bottom: .4rem; }
    .pad-empty p  { font-size: .83rem; color: var(--text-muted); margin: 0; }

    /* ── Features próximas ── */
    .feature-list { display:flex; flex-wrap:wrap; justify-content:center; gap:.5rem; max-width:520px; margin:0 auto 1.5rem; }
    .feature-pill { display:inline-flex; align-items:center; gap:.4rem; padding:.38rem .9rem; border-radius:999px; font-size:.78rem; font-weight:600; background:var(--surface); border:1px solid var(--border); color:#64748b; }
    .feature-pill i { color:var(--teal); }

    .info-row { display:grid; grid-template-columns:repeat(2,1fr); gap:1rem; }
    @media(max-width:600px){ .info-row { grid-template-columns:1fr; } }
    .info-item { display:flex; align-items:flex-start; gap:.75rem; padding:.9rem 1rem; background:var(--surface); border-radius:10px; border:1px solid var(--border); }
    .info-item-icon { width:36px; height:36px; border-radius:9px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:.9rem; }
    .info-item-title { font-size:.83rem; font-weight:700; color:var(--text-main); margin-bottom:.15rem; }
    .info-item-desc  { font-size:.76rem; color:var(--text-muted); margin:0; line-height:1.4; }
</style>
@endpush

@section('content')
<div style="max-width:1100px;margin:0 auto;">

    {{-- ── BANNER ── --}}
    <div class="pad-banner">
        <div class="pad-banner-icon"><i class="fas fa-user-friends"></i></div>
        <div style="position:relative;z-index:1;">
            <div class="pad-banner-name">Bienvenido, {{ auth()->user()->name }}</div>
            <div class="pad-banner-sub">Portal de seguimiento escolar de sus hijos</div>
        </div>
    </div>

    {{-- ── STATS ── --}}
    <div class="pad-stats">
        <div class="pad-stat ps-teal">
            <div class="pad-stat-icon"><i class="fas fa-child"></i></div>
            <div>
                <div class="pad-stat-lbl">Hijos vinculados</div>
                <div class="pad-stat-num">{{ $matriculas->count() }}</div>
            </div>
        </div>
        <div class="pad-stat ps-blue">
            <div class="pad-stat-icon"><i class="fas fa-clipboard-check"></i></div>
            <div>
                <div class="pad-stat-lbl">Matrículas aprobadas</div>
                <div class="pad-stat-num">{{ $matriculas->count() }}</div>
            </div>
        </div>
        <div class="pad-stat ps-indigo">
            <div class="pad-stat-icon"><i class="fas fa-star"></i></div>
            <div>
                <div class="pad-stat-lbl">Calificaciones</div>
                <div class="pad-stat-num">
                    {{ $matriculas->sum(fn($m) => $m->estudiante?->calificaciones?->count() ?? 0) }}
                </div>
            </div>
        </div>
    </div>

    {{-- ── CALIFICACIONES POR HIJO ── --}}
    @if($matriculas->isNotEmpty())
    <div class="pad-card">
        <div class="pad-card-head">
            <i class="fas fa-star"></i>
            <span>Calificaciones por Hijo</span>
        </div>
        <div class="pad-card-body">

            {{-- Tabs de hijos --}}
            @if($matriculas->count() > 1)
            <div class="hijo-tabs">
                @foreach($matriculas as $i => $mat)
                @php $est = $mat->estudiante; @endphp
                @if($est)
                <button class="hijo-tab {{ $i === 0 ? 'active' : '' }}"
                        onclick="switchHijo({{ $i }}, this)">
                    <div class="hijo-av-sm">
                        {{ strtoupper(substr($est->nombre1 ?? 'E', 0, 1)) }}
                    </div>
                    {{ $est->nombre1 }} {{ $est->apellido1 }}
                </button>
                @endif
                @endforeach
            </div>
            @endif

            {{-- Panel por hijo --}}
            @foreach($matriculas as $i => $mat)
            @php
                $est          = $mat->estudiante;
                $calificaciones = $est?->calificaciones ?? collect();
                $porPeriodo   = $calificaciones->groupBy(fn($c) => $c->periodo?->nombre_periodo ?? 'Sin período');
                $promedio     = $calificaciones->avg('nota');
            @endphp
            @if(!$est) @continue @endif

            <div class="hijo-panel {{ $i === 0 ? 'active' : '' }}" id="hijo-panel-{{ $i }}">

                {{-- Info estudiante ── --}}
                <div class="est-info-bar">
                    <div class="est-info-av">
                        {{ strtoupper(substr($est->nombre1 ?? 'E', 0, 1)) }}
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div class="est-info-name">
                            {{ trim(($est->nombre1 ?? '') . ' ' . ($est->nombre2 ?? '') . ' ' . ($est->apellido1 ?? '') . ' ' . ($est->apellido2 ?? '')) }}
                        </div>
                        <div class="est-info-sub">
                            <i class="fas fa-id-card" style="font-size:.65rem;"></i>
                            DNI: {{ $est->dni ?? '—' }}
                        </div>
                    </div>
                    <div style="display:flex;gap:.4rem;flex-wrap:wrap;">
                        <span class="bpill b-teal">
                            <i class="fas fa-graduation-cap" style="font-size:.65rem;"></i>
                            {{ $est->grado ?? '—' }} — Sección {{ $est->seccion ?? '—' }}
                        </span>
                        <span class="bpill {{ ($est->estado ?? '') === 'activo' ? 'b-green' : 'b-gray' }}">
                            <i class="fas fa-circle" style="font-size:.4rem;"></i>
                            {{ ucfirst($est->estado ?? 'N/A') }}
                        </span>
                        <span class="bpill b-gray">
                            <i class="fas fa-calendar" style="font-size:.65rem;"></i>
                            {{ $mat->anio_lectivo ?? '—' }}
                        </span>
                    </div>
                </div>

                {{-- Calificaciones --}}
                @if($calificaciones->isEmpty())
                    <div class="pad-empty">
                        <i class="fas fa-clipboard"></i>
                        <h6>Sin calificaciones registradas</h6>
                        <p>Aún no hay notas registradas para este período.</p>
                    </div>
                @else
                    @foreach($porPeriodo as $nombrePeriodo => $calsPeriodo)
                    <div class="periodo-block">
                        <div class="periodo-title">
                            <i class="fas fa-calendar-check"></i>
                            {{ $nombrePeriodo }}
                            <span style="margin-left:auto;font-size:.68rem;color:var(--text-muted);font-weight:600;text-transform:none;">
                                {{ $calsPeriodo->count() }} materia(s)
                            </span>
                        </div>
                        <div style="overflow-x:auto;">
                            <table class="cal-tbl">
                                <thead>
                                    <tr>
                                        <th>Materia</th>
                                        <th class="tc">Nota</th>
                                        <th class="tc">Estado</th>
                                        @if($calsPeriodo->first()?->observacion)
                                            <th>Observación</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($calsPeriodo->sortBy(fn($c) => $c->materia?->nombre) as $cal)
                                    @php
                                        $nota = $cal->nota ?? 0;
                                        $notaClass = $nota >= 90 ? 'nota-excelente'
                                            : ($nota >= 70 ? 'nota-buena'
                                            : ($nota >= 60 ? 'nota-regular' : 'nota-baja'));
                                        $estadoLabel = $nota >= 60 ? 'Aprobado' : 'Reprobado';
                                        $estadoClass = $nota >= 60 ? 'b-green' : 'b-red';
                                    @endphp
                                    <tr>
                                        <td>
                                            <span style="font-weight:600;color:var(--blue-dark);">
                                                {{ $cal->materia?->nombre ?? '—' }}
                                            </span>
                                        </td>
                                        <td class="tc">
                                            <span class="nota-badge {{ $notaClass }}">
                                                {{ number_format($nota, 1) }}
                                            </span>
                                        </td>
                                        <td class="tc">
                                            <span class="bpill {{ $estadoClass }}">
                                                {{ $estadoLabel }}
                                            </span>
                                        </td>
                                        @if($calsPeriodo->first()?->observacion)
                                        <td style="font-size:.78rem;color:var(--text-muted);">
                                            {{ $cal->observacion ?? '—' }}
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endforeach

                    {{-- Promedio general --}}
                    @if($promedio)
                    @php
                        $promClass = $promedio >= 90 ? 'nota-excelente'
                            : ($promedio >= 70 ? 'nota-buena'
                            : ($promedio >= 60 ? 'nota-regular' : 'nota-baja'));
                    @endphp
                    <div class="promedio-card">
                        <div>
                            <div class="promedio-label">Promedio General</div>
                            <div style="font-size:.75rem;color:rgba(255,255,255,.6);">Todas las materias</div>
                        </div>
                        <div style="text-align:right;">
                            <div class="promedio-val">{{ number_format($promedio, 1) }}</div>
                            <div style="font-size:.72rem;color:rgba(255,255,255,.65);">
                                {{ $promedio >= 60 ? '✓ Aprobado' : '✗ Reprobado' }}
                            </div>
                        </div>
                    </div>
                    @endif
                @endif

            </div>
            @endforeach

        </div>
    </div>
    @endif

    {{-- ── FUNCIONES PRÓXIMAMENTE ── --}}
    <div class="pad-card">
        <div class="pad-card-head">
            <i class="fas fa-rocket"></i>
            <span>Funciones Disponibles Próximamente</span>
        </div>
        <div class="pad-card-body">
            <div style="text-align:center;padding:2rem 1rem 1.5rem;">
                <div style="width:72px;height:72px;border-radius:18px;background:var(--teal-light);display:flex;align-items:center;justify-content:center;margin:0 auto .9rem;font-size:1.8rem;color:var(--blue-mid);">
                    <i class="fas fa-tools"></i>
                </div>
                <h6 style="color:var(--text-main);font-weight:700;margin-bottom:.35rem;">Portal en Construcción</h6>
                <p style="color:var(--text-muted);font-size:.83rem;margin:0 0 1.25rem;">Pronto tendrá acceso a toda la información escolar de sus hijos.</p>
                <div class="feature-list">
                    <span class="feature-pill"><i class="fas fa-calendar-check"></i> Asistencia</span>
                    <span class="feature-pill"><i class="fas fa-comment-alt"></i> Observaciones</span>
                    <span class="feature-pill"><i class="fas fa-file-alt"></i> Reportes</span>
                    <span class="feature-pill"><i class="fas fa-bell"></i> Notificaciones</span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-item">
                    <div class="info-item-icon" style="background:rgba(16,185,129,.1);"><i class="fas fa-calendar-check" style="color:#059669;"></i></div>
                    <div>
                        <div class="info-item-title">Control de asistencia</div>
                        <p class="info-item-desc">Vea el registro de asistencias, tardanzas y ausencias.</p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-item-icon" style="background:rgba(245,158,11,.1);"><i class="fas fa-comment-alt" style="color:#d97706;"></i></div>
                    <div>
                        <div class="info-item-title">Observaciones de profesores</div>
                        <p class="info-item-desc">Reciba notificaciones con las observaciones de los docentes.</p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-item-icon" style="background:rgba(99,102,241,.1);"><i class="fas fa-file-alt" style="color:#4f46e5;"></i></div>
                    <div>
                        <div class="info-item-title">Reportes y constancias</div>
                        <p class="info-item-desc">Descargue reportes de rendimiento y constancias de matrícula.</p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-item-icon" style="background:var(--teal-light);"><i class="fas fa-bell" style="color:var(--teal);"></i></div>
                    <div>
                        <div class="info-item-title">Notificaciones en tiempo real</div>
                        <p class="info-item-desc">Alertas sobre calificaciones, eventos y comunicados.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
function switchHijo(index, btn) {
    // Tabs
    document.querySelectorAll('.hijo-tab').forEach(function(t) { t.classList.remove('active'); });
    btn.classList.add('active');
    // Panels
    document.querySelectorAll('.hijo-panel').forEach(function(p) { p.classList.remove('active'); });
    document.getElementById('hijo-panel-' + index).classList.add('active');
}
</script>
@endpush