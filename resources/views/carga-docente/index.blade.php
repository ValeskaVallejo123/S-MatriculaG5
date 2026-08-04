@extends('layouts.app')

@section('title', 'Carga Docente')
@section('page-title', 'Carga Docente')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap');

:root {
    --navy:   #003b73;
    --blue:   #00508f;
    --teal:   #4ec7d2;
    --teal-l: rgba(78,199,210,.12);
    --slate:  #64748b;
    --muted:  #94a3b8;
    --border: #e2e8f0;
    --bg:     #f8fafc;
}

.cd-wrap { font-family: 'DM Sans', sans-serif; }

/* ── Stats ─────────────────────────────────────────── */
.cd-stats {
    display: grid; grid-template-columns: repeat(4,1fr);
    gap: .85rem; margin-bottom: 1.25rem;
}
@media(max-width:900px){ .cd-stats { grid-template-columns: repeat(2,1fr); } }
@media(max-width:480px){ .cd-stats { grid-template-columns: 1fr; } }

.cd-stat {
    background: #fff; border: 1px solid var(--border); border-radius: 12px;
    padding: 1rem 1.2rem; display: flex; align-items: center; gap: .85rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.04);
}
.cd-stat-icon {
    width: 42px; height: 42px; border-radius: 10px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
}
.cd-stat-icon i { font-size: 1rem; color: #fff; }
.cd-stat-lbl { font-size: .68rem; font-weight: 600; color: var(--muted);
    text-transform: uppercase; letter-spacing: .06em; margin-bottom: .1rem; }
.cd-stat-num { font-size: 1.55rem; font-weight: 700; color: #0f172a; line-height: 1; }

/* ── Toolbar ────────────────────────────────────────── */
.cd-toolbar {
    background: #fff; border: 1px solid var(--border); border-radius: 12px;
    padding: .8rem 1.2rem; margin-bottom: 1.25rem;
    display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;
    box-shadow: 0 1px 3px rgba(0,0,0,.04);
}
.cd-select {
    padding: .38rem .75rem; border: 1.5px solid var(--border); border-radius: 8px;
    font-size: .82rem; color: #0f172a; background: var(--bg); font-family: 'DM Sans', sans-serif;
}
.cd-select:focus { border-color: var(--teal); outline: none; }
.cd-btn {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .4rem 1.1rem; border-radius: 8px; font-size: .82rem; font-weight: 600;
    background: linear-gradient(135deg, var(--teal), var(--blue)); color: #fff;
    border: none; cursor: pointer; font-family: 'DM Sans', sans-serif; transition: opacity .15s;
}
.cd-btn:hover { opacity: .88; }
.cd-search-wrap { position: relative; flex: 1; max-width: 260px; }
.cd-search-wrap i { position: absolute; left: 9px; top: 50%; transform: translateY(-50%);
    color: var(--muted); font-size: .78rem; pointer-events: none; }
.cd-search {
    width: 100%; padding: .4rem .75rem .4rem 2rem; border: 1.5px solid var(--border);
    border-radius: 8px; font-size: .82rem; font-family: 'DM Sans', sans-serif; background: var(--bg);
}
.cd-search:focus { border-color: var(--teal); outline: none; background: #fff; }

/* ── View tabs ──────────────────────────────────────── */
.cd-view-tabs { display: flex; gap: .4rem; margin-bottom: 1.25rem; }
.cd-vtab {
    padding: .4rem 1rem; border-radius: 8px; font-size: .82rem; font-weight: 600;
    border: 1.5px solid var(--border); background: #fff; color: var(--slate);
    cursor: pointer; transition: all .15s; display: inline-flex; align-items: center; gap: .4rem;
}
.cd-vtab.active { background: linear-gradient(135deg,var(--teal),var(--blue)); color: #fff; border-color: transparent; }
.cd-vtab:not(.active):hover { border-color: var(--teal); color: var(--blue); }

/* ── Grid de cards ──────────────────────────────────── */
.cd-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    gap: 1rem;
}
@media(max-width:480px){ .cd-grid { grid-template-columns: 1fr; } }

/* ── Card profesor ──────────────────────────────────── */
.prof-card {
    background: #fff; border: 1px solid var(--border); border-radius: 14px;
    overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,.05);
    transition: transform .18s, box-shadow .18s;
    display: flex; flex-direction: column;
}
.prof-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0,59,115,.1);
}

/* Header card */
.prof-card-header {
    background: linear-gradient(135deg, var(--navy), var(--blue));
    padding: 1rem 1.2rem;
    display: flex; align-items: center; gap: .85rem;
}
.prof-av {
    width: 46px; height: 46px; border-radius: 11px; flex-shrink: 0;
    background: rgba(255,255,255,.15); border: 2px solid var(--teal);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; color: var(--teal); font-size: 1.1rem;
}
.prof-name { font-weight: 700; color: #fff; font-size: .92rem; line-height: 1.2; }
.prof-esp  { font-size: .72rem; color: rgba(255,255,255,.6); margin-top: .15rem; }
.prof-contrato {
    margin-left: auto; padding: .22rem .65rem; border-radius: 20px;
    font-size: .67rem; font-weight: 700; white-space: nowrap; flex-shrink: 0;
}
.c-full  { background: rgba(52,211,153,.2);  color: #6ee7b7; }
.c-half  { background: rgba(147,197,253,.2); color: #93c5fd; }
.c-hours { background: rgba(251,191,36,.2);  color: #fde68a; }

/* Cuerpo card */
.prof-card-body { padding: 1rem 1.2rem; flex: 1; }

/* Mini stat row */
.prof-mini-stats {
    display: grid; grid-template-columns: repeat(3,1fr);
    gap: .5rem; margin-bottom: 1rem;
}
.prof-mini {
    background: var(--bg); border-radius: 9px;
    padding: .55rem .6rem; text-align: center;
}
.prof-mini-num { font-size: 1.25rem; font-weight: 700; color: var(--navy); line-height: 1; }
.prof-mini-lbl { font-size: .63rem; font-weight: 600; color: var(--muted);
    text-transform: uppercase; letter-spacing: .05em; margin-top: .15rem; }

/* Sección */
.prof-section { margin-bottom: .85rem; }
.prof-section-title {
    font-size: .65rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .07em; color: var(--teal); margin-bottom: .45rem;
    display: flex; align-items: center; gap: .35rem;
}
.prof-section-title i { font-size: .65rem; }

/* Materias chips */
.mat-chips { display: flex; flex-wrap: wrap; gap: .3rem; }
.mat-chip {
    padding: .2rem .6rem; border-radius: 6px; font-size: .7rem; font-weight: 600;
    background: var(--teal-l); color: var(--blue); border: 1px solid rgba(78,199,210,.25);
}
.mat-chip-more { background: #f1f5f9; color: var(--slate); border-color: var(--border); }

/* Grados list */
.grado-list { display: flex; flex-direction: column; gap: .3rem; }
.grado-row {
    display: flex; align-items: center; justify-content: space-between;
    background: var(--bg); border-radius: 7px; padding: .35rem .65rem;
}
.grado-tag {
    font-size: .73rem; font-weight: 700; color: var(--navy);
    display: flex; align-items: center; gap: .4rem;
}
.grado-tag i { color: var(--teal); font-size: .65rem; }
.grado-count {
    font-size: .68rem; font-weight: 700; color: var(--blue);
    background: var(--teal-l); padding: .1rem .45rem; border-radius: 4px;
    display: flex; align-items: center; gap: .25rem;
}

/* Barra estudiantes */
.est-bar-wrap { margin-top: .85rem; }
.est-bar-header {
    display: flex; align-items: center; justify-content: space-between; margin-bottom: .35rem;
}
.est-bar-label { font-size: .65rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .07em; color: var(--muted); }
.est-bar-count { font-size: .85rem; font-weight: 700; color: var(--navy); }
.est-bar-bg { height: 6px; background: #f1f5f9; border-radius: 99px; overflow: hidden; }
.est-bar-fill { height: 100%; border-radius: 99px; transition: width .6s ease; }

/* Footer card */
.prof-card-footer {
    padding: .75rem 1.2rem; border-top: 1px solid #f1f5f9;
    background: #fafbfc;
}
.btn-ver-est {
    width: 100%; padding: .42rem; border-radius: 8px; border: none;
    background: linear-gradient(135deg, var(--teal), var(--blue));
    color: #fff; font-size: .78rem; font-weight: 700;
    font-family: 'DM Sans', sans-serif; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: .4rem;
    transition: opacity .15s;
}
.btn-ver-est:hover { opacity: .88; }

/* Empty */
.cd-empty { padding: 4rem 1rem; text-align: center; }
.cd-empty i { font-size: 2.5rem; color: #cbd5e1; display: block; margin-bottom: .75rem; }
.cd-empty p { color: var(--muted); font-size: .88rem; margin: 0; }

/* ── Gráficas ────────────────────────────────────────── */
.cd-charts-grid { display: grid; grid-template-columns: repeat(2,1fr); gap: 1rem; }
@media(max-width:768px){ .cd-charts-grid { grid-template-columns: 1fr; } }
.cd-chart-card {
    background: #fff; border: 1px solid var(--border); border-radius: 12px;
    overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.04);
}
.cd-chart-head {
    padding: .75rem 1.1rem; border-bottom: 1px solid #f1f5f9;
    display: flex; align-items: center; gap: .5rem;
}
.cd-chart-head i { color: var(--teal); }
.cd-chart-head span { font-weight: 700; font-size: .88rem; color: #0f172a; }
.cd-chart-body { padding: 1.1rem; }

/* ── Modal ───────────────────────────────────────────── */
.modal-content { border-radius: 14px; border: none; overflow: hidden; box-shadow: 0 8px 30px rgba(0,0,0,.15); }
.modal-header-cd {
    background: linear-gradient(135deg, var(--navy), var(--blue));
    padding: 1rem 1.25rem; border-bottom: none;
    display: flex; align-items: center; justify-content: space-between;
}
.modal-header-cd h6 { color: #fff; font-weight: 700; font-size: .95rem; margin: 0; display: flex; align-items: center; gap: .5rem; }
.modal-header-cd .btn-close { filter: invert(1) brightness(2); }
.modal-filter-tabs {
    display: flex; gap: .3rem; padding: .75rem 1.2rem; border-bottom: 1px solid #f1f5f9; flex-wrap: wrap;
}
.mft {
    padding: .22rem .7rem; border-radius: 6px; font-size: .72rem; font-weight: 600;
    border: 1.5px solid var(--border); background: #fff; color: var(--slate); cursor: pointer; transition: all .12s;
}
.mft.active { background: linear-gradient(135deg,var(--teal),var(--blue)); color: #fff; border-color: transparent; }
.mft:not(.active):hover { border-color: var(--teal); color: var(--blue); }
.modal-search-bar { padding: .75rem 1.2rem; border-bottom: 1px solid #f1f5f9; position: relative; }
.modal-search-bar i { position: absolute; left: calc(1.2rem + 9px); top: 50%; transform: translateY(-50%); color: var(--muted); font-size: .78rem; pointer-events: none; }
.modal-search-bar input {
    width: 100%; padding: .4rem .75rem .4rem 2.1rem;
    border: 1.5px solid var(--border); border-radius: 8px; font-size: .82rem;
    font-family: 'DM Sans', sans-serif; background: var(--bg);
}
.modal-search-bar input:focus { border-color: var(--teal); outline: none; }
.est-list { max-height: 360px; overflow-y: auto; }
.est-row {
    display: flex; align-items: center; gap: .85rem;
    padding: .65rem 1.2rem; border-bottom: 1px solid #f8f9fa; transition: background .12s;
}
.est-row:hover { background: var(--bg); }
.est-row:last-child { border-bottom: none; }
.est-av {
    width: 34px; height: 34px; border-radius: 8px; flex-shrink: 0;
    background: linear-gradient(135deg, var(--teal), var(--blue));
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; color: #fff; font-size: .85rem;
}
.est-av-alt { background: linear-gradient(135deg, #a78bfa, #7c3aed); }
.est-name  { font-weight: 600; color: #0f172a; font-size: .82rem; }
.est-meta  { font-size: .72rem; color: var(--slate); }
.est-grade-badge {
    padding: .18rem .6rem; border-radius: 6px; font-size: .68rem; font-weight: 700;
    background: #eef2ff; color: #4f46e5; white-space: nowrap;
}
.modal-footer-cd {
    padding: .75rem 1.2rem; border-top: 1px solid #f1f5f9;
    background: #fafafa; display: flex; align-items: center; justify-content: space-between;
}
.modal-footer-cd span { font-size: .78rem; color: var(--muted); }
.est-list::-webkit-scrollbar { width: 4px; }
.est-list::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }
</style>
@endpush

@section('content')

{{-- JSON embebido --}}
<script id="profesores-data" type="application/json">
{!! json_encode($profesores->map(function($p) {
    return [
        'id'                  => $p->id,
        'nombre'              => $p->nombre . ' ' . $p->apellido,
        'total_estudiantes'   => (int) $p->total_estudiantes,
        'total_horas'         => (int) ($p->total_horas ?? 0),
        'total_grados'        => (int) ($p->total_grados ?? 0),
        'total_materias'      => $p->nombres_materias ? count(explode(', ', $p->nombres_materias)) : 0,
        'tipo_contrato'       => $p->tipo_contrato ?? '',
        'estudiantes_detalle' => json_decode($p->estudiantes_detalle ?? '[]', true),
        'grados_list'         => $p->nombres_grados   ? explode(', ', $p->nombres_grados)   : [],
    ];
})->values()) !!}
</script>

<div class="cd-wrap">

    {{-- Stats --}}
    <div class="cd-stats">
        <div class="cd-stat">
            <div class="cd-stat-icon" style="background:linear-gradient(135deg,#4ec7d2,#00508f);">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div>
                <div class="cd-stat-lbl">Total Profesores</div>
                <div class="cd-stat-num">{{ $totalProfesores }}</div>
            </div>
        </div>
        <div class="cd-stat">
            <div class="cd-stat-icon" style="background:linear-gradient(135deg,#34d399,#059669);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <div class="cd-stat-lbl">Con Carga</div>
                <div class="cd-stat-num">{{ $totalConCarga }}</div>
            </div>
        </div>
        <div class="cd-stat">
            <div class="cd-stat-icon" style="background:linear-gradient(135deg,#f87171,#dc2626);">
                <i class="fas fa-user-times"></i>
            </div>
            <div>
                <div class="cd-stat-lbl">Sin Carga</div>
                <div class="cd-stat-num">{{ $totalSinCarga }}</div>
            </div>
        </div>
        <div class="cd-stat">
            <div class="cd-stat-icon" style="background:linear-gradient(135deg,#a78bfa,#7c3aed);">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <div class="cd-stat-lbl">Prom. Estudiantes</div>
                <div class="cd-stat-num">{{ $promEstudiantes }}</div>
            </div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="cd-toolbar">
        <form method="GET" action="{{ route('carga-docente.index') }}" style="display:flex;align-items:center;gap:.6rem;flex-wrap:wrap;">
            <label style="font-size:.82rem;font-weight:600;color:var(--slate);">Año lectivo:</label>
            <select name="anio" class="cd-select">
                @foreach($aniosDisponibles as $a)
                    <option value="{{ $a }}" {{ $anio == $a ? 'selected' : '' }}>{{ $a }}</option>
                @endforeach
                @if($aniosDisponibles->isEmpty())
                    <option value="{{ date('Y') }}" selected>{{ date('Y') }}</option>
                @endif
            </select>
            <button type="submit" class="cd-btn">
                <i class="fas fa-filter"></i> Filtrar
            </button>
        </form>
        <div class="cd-search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="cdSearch" class="cd-search" placeholder="Buscar profesor...">
        </div>
    </div>

    {{-- View Tabs --}}
    <div class="cd-view-tabs">
        <button class="cd-vtab active" onclick="switchView('cards', this)">
            <i class="fas fa-th-large"></i> Tarjetas
        </button>
        <button class="cd-vtab" onclick="switchView('graficas', this)">
            <i class="fas fa-chart-bar"></i> Gráficas
        </button>
    </div>

    {{-- Vista Cards --}}
    @php $maxEst = $profesores->max('total_estudiantes') ?: 1; @endphp

    <div id="view-cards">
        @if($profesores->isEmpty())
            <div style="background:#fff;border:1px solid var(--border);border-radius:14px;box-shadow:0 1px 3px rgba(0,0,0,.04);">
                <div class="cd-empty">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <p>No hay datos de carga docente para el año {{ $anio }}</p>
                </div>
            </div>
        @else
        <div class="cd-grid" id="cdGrid">
            @foreach($profesores as $i => $p)
            @php
                $pct      = ($p->total_estudiantes / $maxEst) * 100;
                $barColor = $pct >= 80 ? '#ef4444' : ($pct >= 50 ? '#f59e0b' : '#4ec7d2');
                [$cLabel, $cClass] = match($p->tipo_contrato ?? '') {
                    'tiempo_completo' => ['Tiempo Completo', 'c-full'],
                    'medio_tiempo'    => ['Medio Tiempo',    'c-half'],
                    'por_horas'       => ['Por Horas',       'c-hours'],
                    default           => ['—',               'c-half'],
                };
                $materiasList        = $p->nombres_materias ? explode(', ', $p->nombres_materias) : [];
                $gradosList          = $p->nombres_grados   ? explode(', ', $p->nombres_grados)   : [];
                $estudiantesPorGrado = json_decode($p->estudiantes_por_grado ?? '{}', true);
            @endphp

            <div class="prof-card" data-name="{{ strtolower($p->nombre . ' ' . $p->apellido) }}">

                {{-- Header --}}
                <div class="prof-card-header">
                    <div class="prof-av">{{ strtoupper(substr($p->nombre, 0, 1)) }}</div>
                    <div style="flex:1;min-width:0;">
                        <div class="prof-name text-truncate">{{ $p->nombre }} {{ $p->apellido }}</div>
                        <div class="prof-esp">{{ $p->especialidad ?? '—' }}</div>
                    </div>
                    <span class="prof-contrato {{ $cClass }}">{{ $cLabel }}</span>
                </div>

                {{-- Body --}}
                <div class="prof-card-body">

                    {{-- Mini stats --}}
                    <div class="prof-mini-stats">
                        <div class="prof-mini">
                            <div class="prof-mini-num">{{ count($materiasList) }}</div>
                            <div class="prof-mini-lbl">Materias</div>
                        </div>
                        <div class="prof-mini">
                            <div class="prof-mini-num">{{ count($gradosList) }}</div>
                            <div class="prof-mini-lbl">Grados</div>
                        </div>
                        <div class="prof-mini">
                            <div class="prof-mini-num">{{ $p->total_horas ?? 0 }}</div>
                            <div class="prof-mini-lbl">Hrs/sem</div>
                        </div>
                    </div>

                    {{-- Materias --}}
                    @if(count($materiasList))
                    <div class="prof-section">
                        <div class="prof-section-title">
                            <i class="fas fa-book-open"></i> Materias que imparte
                        </div>
                        <div class="mat-chips">
                            @foreach(array_slice($materiasList, 0, 4) as $m)
                                <span class="mat-chip">{{ $m }}</span>
                            @endforeach
                            @if(count($materiasList) > 4)
                                <span class="mat-chip mat-chip-more">+{{ count($materiasList) - 4 }} más</span>
                            @endif
                        </div>
                    </div>
                    @endif

                    {{-- Grados --}}
                    @if(count($gradosList))
                    <div class="prof-section">
                        <div class="prof-section-title">
                            <i class="fas fa-layer-group"></i> Grados a cargo
                        </div>
                        <div class="grado-list">
                            @foreach(array_slice($gradosList, 0, 4) as $g)
                            <div class="grado-row">
                                <span class="grado-tag">
                                    <i class="fas fa-circle"></i> {{ $g }}
                                </span>
                                @if(isset($estudiantesPorGrado[$g]))
                                <span class="grado-count">
                                    <i class="fas fa-users" style="font-size:.6rem;"></i>
                                    {{ $estudiantesPorGrado[$g] }} est.
                                </span>
                                @endif
                            </div>
                            @endforeach
                            @if(count($gradosList) > 4)
                            <div class="grado-row" style="justify-content:center;">
                                <span style="font-size:.72rem;color:var(--muted);font-weight:600;">
                                    +{{ count($gradosList) - 4 }} grados más
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    {{-- Barra estudiantes --}}
                    <div class="est-bar-wrap">
                        <div class="est-bar-header">
                            <span class="est-bar-label"><i class="fas fa-users me-1"></i>Estudiantes totales</span>
                            <span class="est-bar-count">{{ $p->total_estudiantes }}</span>
                        </div>
                        <div class="est-bar-bg">
                            <div class="est-bar-fill" style="width:{{ $pct }}%;background:{{ $barColor }};"></div>
                        </div>
                    </div>

                </div>

                {{-- Footer --}}
                <div class="prof-card-footer">
                    <button class="btn-ver-est btn-ver-estudiantes"
                            data-id="{{ $p->id }}"
                            data-nombre="{{ $p->nombre }} {{ $p->apellido }}">
                        <i class="fas fa-list-ul"></i> Ver lista de estudiantes
                    </button>
                </div>

            </div>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Vista Gráficas --}}
    <div id="view-graficas" style="display:none;">
        <div class="cd-charts-grid">
            <div class="cd-chart-card" style="grid-column:1/-1;">
                <div class="cd-chart-head"><i class="fas fa-chart-bar"></i><span>Estudiantes por Profesor</span></div>
                <div class="cd-chart-body" style="height:280px;"><canvas id="chartEstudiantes"></canvas></div>
            </div>
            <div class="cd-chart-card">
                <div class="cd-chart-head"><i class="fas fa-clock"></i><span>Horas Semanales</span></div>
                <div class="cd-chart-body" style="height:240px;"><canvas id="chartHoras"></canvas></div>
            </div>
            <div class="cd-chart-card">
                <div class="cd-chart-head"><i class="fas fa-book"></i><span>Materias Asignadas</span></div>
                <div class="cd-chart-body" style="height:240px;"><canvas id="chartMaterias"></canvas></div>
            </div>
            <div class="cd-chart-card">
                <div class="cd-chart-head"><i class="fas fa-file-contract"></i><span>Distribución por Contrato</span></div>
                <div class="cd-chart-body" style="height:240px;display:flex;align-items:center;justify-content:center;">
                    <canvas id="chartContrato" style="max-height:200px;max-width:200px;"></canvas>
                </div>
            </div>
            <div class="cd-chart-card">
                <div class="cd-chart-head"><i class="fas fa-layer-group"></i><span>Grados por Profesor</span></div>
                <div class="cd-chart-body" style="height:240px;"><canvas id="chartGrados"></canvas></div>
            </div>
        </div>
    </div>

</div>

{{-- Modal Estudiantes --}}
<div class="modal fade" id="modalEstudiantes" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:520px;">
        <div class="modal-content">
            <div class="modal-header-cd">
                <h6><i class="fas fa-users"></i> <span id="modalProfesorNombre">Estudiantes</span></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-filter-tabs" id="gradoFilterTabs">
                <button class="mft active" data-grado="">Todos</button>
            </div>
            <div class="modal-search-bar">
                <i class="fas fa-search"></i>
                <input type="text" id="estSearch" placeholder="Buscar estudiante...">
            </div>
            <div class="est-list" id="estList"></div>
            <div class="modal-footer-cd">
                <span id="estCount">0 estudiantes</span>
                <button type="button" data-bs-dismiss="modal"
                        style="padding:.36rem 1rem;border-radius:7px;border:1.5px solid var(--border);background:#fff;color:var(--slate);font-size:.82rem;font-weight:600;cursor:pointer;">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    var profesoresData = JSON.parse(document.getElementById('profesores-data').textContent);
    var chartsInit = false;

    var labels = profesoresData.map(function(p) {
        var parts = p.nombre.split(' ');
        return parts[0] + (parts.length > 1 ? ' ' + parts[parts.length-1][0] + '.' : '');
    });

    var palette = [
        'rgba(78,199,210,.8)', 'rgba(0,80,143,.8)', 'rgba(52,211,153,.8)',
        'rgba(167,139,250,.8)', 'rgba(251,191,36,.8)', 'rgba(248,113,113,.8)',
        'rgba(14,165,233,.8)', 'rgba(236,72,153,.8)', 'rgba(234,88,12,.8)',
    ];

    Chart.defaults.font.family = "'DM Sans', sans-serif";
    Chart.defaults.color = '#64748b';

    /* ── Switch view ───────────────────────────── */
    window.switchView = function(view, btn) {
        document.querySelectorAll('.cd-vtab').forEach(function(b) { b.classList.remove('active'); });
        btn.classList.add('active');
        document.getElementById('view-cards').style.display    = view === 'cards'    ? '' : 'none';
        document.getElementById('view-graficas').style.display = view === 'graficas' ? '' : 'none';
        if (view === 'graficas' && !chartsInit) { initCharts(); chartsInit = true; }
    };

    /* ── Búsqueda ──────────────────────────────── */
    var cdSearch = document.getElementById('cdSearch');
    if (cdSearch) {
        cdSearch.addEventListener('input', function() {
            var q = this.value.toLowerCase();
            document.querySelectorAll('#cdGrid .prof-card').forEach(function(card) {
                card.style.display = card.dataset.name.includes(q) ? '' : 'none';
            });
        });
    }

    /* ── Modal estudiantes ─────────────────────── */
    var estudiantesActuales = [];
    var gradoFiltro = '';
    var modalBS = new bootstrap.Modal(document.getElementById('modalEstudiantes'));

    document.addEventListener('click', function(e) {
        var btn = e.target.closest('.btn-ver-estudiantes');
        if (!btn) return;
        abrirModal(btn.dataset.id, btn.dataset.nombre);
    });

    function abrirModal(id, nombre) {
        document.getElementById('modalProfesorNombre').textContent = nombre;
        document.getElementById('estSearch').value = '';
        gradoFiltro = '';

        var p = profesoresData.find(function(x) { return String(x.id) === String(id); });
        estudiantesActuales = (p && p.estudiantes_detalle) ? p.estudiantes_detalle : [];

        var tabs = document.getElementById('gradoFilterTabs');
        var grados = Array.from(new Set(estudiantesActuales.map(function(e) { return e.grado; }).filter(Boolean))).sort();

        tabs.innerHTML = '<button class="mft active" data-grado="">Todos (' + estudiantesActuales.length + ')</button>';
        grados.forEach(function(g) {
            var cnt = estudiantesActuales.filter(function(e) { return e.grado === g; }).length;
            tabs.innerHTML += '<button class="mft" data-grado="' + g + '">' + g + ' (' + cnt + ')</button>';
        });

        tabs.querySelectorAll('.mft').forEach(function(tab) {
            tab.addEventListener('click', function() {
                tabs.querySelectorAll('.mft').forEach(function(t) { t.classList.remove('active'); });
                this.classList.add('active');
                gradoFiltro = this.dataset.grado;
                document.getElementById('estSearch').value = '';
                renderEst(gradoFiltro ? estudiantesActuales.filter(function(e) { return e.grado === gradoFiltro; }) : estudiantesActuales);
            });
        });

        renderEst(estudiantesActuales);
        modalBS.show();
    }

    document.getElementById('estSearch').addEventListener('input', function() {
        var q = this.value.toLowerCase();
        var base = gradoFiltro ? estudiantesActuales.filter(function(e) { return e.grado === gradoFiltro; }) : estudiantesActuales;
        renderEst(q ? base.filter(function(e) { return (e.nombre||'').toLowerCase().includes(q); }) : base);
    });

    function renderEst(lista) {
        var el = document.getElementById('estList');
        document.getElementById('estCount').textContent = lista.length + ' estudiante' + (lista.length !== 1 ? 's' : '');
        if (!lista.length) {
            el.innerHTML = '<div style="padding:2.5rem;text-align:center;color:#94a3b8;"><i class="fas fa-search" style="font-size:1.4rem;display:block;margin-bottom:.5rem;"></i>Sin resultados</div>';
            return;
        }
        el.innerHTML = lista.map(function(e, i) {
            return '<div class="est-row">' +
                '<div class="est-av ' + (i % 2 === 1 ? 'est-av-alt' : '') + '">' + (e.nombre||'?')[0].toUpperCase() + '</div>' +
                '<div style="flex:1;min-width:0;">' +
                    '<div class="est-name text-truncate">' + (e.nombre||'—') + '</div>' +
                    '<div class="est-meta">' + (e.dni||'') + (e.dni && e.materia ? ' · ' : '') + (e.materia||'') + '</div>' +
                '</div>' +
                (e.grado ? '<span class="est-grade-badge">' + e.grado + '</span>' : '') +
            '</div>';
        }).join('');
    }

    /* ── Gráficas ──────────────────────────────── */
    function initCharts() {
        var opts = { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } };

        new Chart(document.getElementById('chartEstudiantes'), {
            type: 'bar',
            data: { labels: labels, datasets: [{ label: 'Estudiantes', data: profesoresData.map(function(p){ return p.total_estudiantes; }), backgroundColor: palette, borderRadius: 6, borderSkipped: false }] },
            options: { ...opts, indexAxis: 'y', scales: { x: { grid: { color: '#f1f5f9' } }, y: { grid: { display: false } } } }
        });

        new Chart(document.getElementById('chartHoras'), {
            type: 'bar',
            data: { labels: labels, datasets: [{ data: profesoresData.map(function(p){ return p.total_horas; }), backgroundColor: 'rgba(0,80,143,.75)', borderRadius: 6, borderSkipped: false }] },
            options: { ...opts, scales: { x: { grid: { display: false }, ticks: { maxRotation: 35, font: { size: 10 } } }, y: { grid: { color: '#f1f5f9' }, beginAtZero: true } } }
        });

        new Chart(document.getElementById('chartMaterias'), {
            type: 'bar',
            data: { labels: labels, datasets: [{ data: profesoresData.map(function(p){ return p.total_materias; }), backgroundColor: 'rgba(78,199,210,.75)', borderRadius: 6, borderSkipped: false }] },
            options: { ...opts, scales: { x: { grid: { display: false }, ticks: { maxRotation: 35, font: { size: 10 } } }, y: { grid: { color: '#f1f5f9' }, beginAtZero: true, ticks: { stepSize: 1 } } } }
        });

        var cc = { tiempo_completo: 0, medio_tiempo: 0, por_horas: 0, otro: 0 };
        profesoresData.forEach(function(p) { if (cc[p.tipo_contrato] !== undefined) cc[p.tipo_contrato]++; else cc.otro++; });
        new Chart(document.getElementById('chartContrato'), {
            type: 'doughnut',
            data: { labels: ['Tiempo Completo','Medio Tiempo','Por Horas','Otro'], datasets: [{ data: Object.values(cc), backgroundColor: ['#059669','#3b82f6','#f59e0b','#94a3b8'], borderWidth: 2, borderColor: '#fff' }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { font: { size: 11 }, padding: 10, boxWidth: 11 } } }, cutout: '60%' }
        });

        new Chart(document.getElementById('chartGrados'), {
            type: 'bar',
            data: { labels: labels, datasets: [{ data: profesoresData.map(function(p){ return p.total_grados; }), backgroundColor: 'rgba(99,102,241,.75)', borderRadius: 6, borderSkipped: false }] },
            options: { ...opts, scales: { x: { grid: { display: false }, ticks: { maxRotation: 35, font: { size: 10 } } }, y: { grid: { color: '#f1f5f9' }, beginAtZero: true, ticks: { stepSize: 1 } } } }
        });
    }

});
</script>
@endpush