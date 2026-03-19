@extends('layouts.app')

@section('title', 'Carga Docente')
@section('page-title', 'Carga Docente')

@section('topbar-actions')
    <a href="{{ route('superadmin.dashboard') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Volver
    </a>
@endsection

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

.cd-wrap { font-family: 'Inter', sans-serif; }

/* ─── Stats ─────────────────────────────────── */
.cd-stats {
    display: grid; grid-template-columns: repeat(4,1fr);
    gap: 1rem; margin-bottom: 1.5rem;
}
@media(max-width:900px){ .cd-stats { grid-template-columns: repeat(2,1fr); } }
@media(max-width:480px){ .cd-stats { grid-template-columns: 1fr; } }

.cd-stat {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    padding: 1.1rem 1.25rem; display: flex; align-items: center; gap: .9rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.cd-stat-icon {
    width: 44px; height: 44px; border-radius: 10px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
}
.cd-stat-icon i { font-size: 1.1rem; color: #fff; }
.cd-stat-lbl { font-size: .71rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: .05em; margin-bottom: .15rem; }
.cd-stat-num { font-size: 1.7rem; font-weight: 700; color: #0f172a; line-height: 1; }

/* ─── Toolbar ────────────────────────────────── */
.cd-toolbar {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    padding: .85rem 1.25rem; margin-bottom: 1.25rem;
    display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.cd-toolbar-form { display: flex; align-items: center; gap: .6rem; flex-wrap: wrap; flex: 1; }
.cd-select {
    padding: .38rem .75rem; border: 1.5px solid #e2e8f0; border-radius: 8px;
    font-size: .82rem; color: #0f172a; background: #f8fafc; outline: none; cursor: pointer;
    font-family: 'Inter', sans-serif;
}
.cd-select:focus { border-color: #4ec7d2; }
.cd-btn {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .38rem 1rem; border-radius: 8px; font-size: .82rem; font-weight: 600;
    background: linear-gradient(135deg, #4ec7d2, #00508f); color: #fff;
    border: none; cursor: pointer; font-family: 'Inter', sans-serif; transition: opacity .15s;
}
.cd-btn:hover { opacity: .88; }
.cd-search-wrap { position: relative; }
.cd-search-wrap i { position: absolute; left: 9px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: .78rem; pointer-events: none; }
.cd-search {
    padding: .38rem .75rem .38rem 2rem; border: 1.5px solid #e2e8f0; border-radius: 8px;
    font-size: .82rem; outline: none; font-family: 'Inter', sans-serif; background: #f8fafc;
    min-width: 200px;
}
.cd-search:focus { border-color: #4ec7d2; background: #fff; }

/* ─── View tabs ──────────────────────────────── */
.cd-view-tabs { display: flex; gap: .4rem; margin-bottom: 1.25rem; }
.cd-vtab {
    padding: .42rem 1rem; border-radius: 8px; font-size: .82rem; font-weight: 600;
    border: 1.5px solid #e2e8f0; background: #fff; color: #64748b; cursor: pointer; transition: all .15s;
    display: inline-flex; align-items: center; gap: .4rem;
}
.cd-vtab.active { background: linear-gradient(135deg,#4ec7d2,#00508f); color: #fff; border-color: transparent; }
.cd-vtab:not(.active):hover { border-color: #4ec7d2; color: #00508f; background: #e8f8f9; }

/* ─── Card ───────────────────────────────────── */
.cd-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.cd-card-head {
    background: #003b73; padding: .85rem 1.25rem;
    display: flex; align-items: center; justify-content: space-between;
}
.cd-card-head-left { display: flex; align-items: center; gap: .6rem; }
.cd-card-head i   { color: #4ec7d2; font-size: 1rem; }
.cd-card-head span { color: #fff; font-weight: 700; font-size: .95rem; }
.cd-card-head-sub { color: rgba(255,255,255,.55); font-size: .78rem; }

/* ─── Tabla ──────────────────────────────────── */
.cd-tbl { width: 100%; border-collapse: collapse; }
.cd-tbl thead th {
    background: #f8fafc; padding: .6rem 1rem;
    font-size: .7rem; font-weight: 700; letter-spacing: .07em;
    text-transform: uppercase; color: #64748b;
    border-bottom: 1.5px solid #e2e8f0; white-space: nowrap;
}
.cd-tbl thead th.tc { text-align: center; }
.cd-tbl tbody td {
    padding: .7rem 1rem; border-bottom: 1px solid #f1f5f9;
    font-size: .82rem; color: #334155; vertical-align: middle;
}
.cd-tbl tbody td.tc { text-align: center; }
.cd-tbl tbody tr:last-child td { border-bottom: none; }
.cd-tbl tbody tr:hover { background: #fafbfc; }

/* Ranking */
.cd-rank {
    width: 28px; height: 28px; border-radius: 6px;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: .75rem; font-weight: 700;
}
.rk-1 { background: #fef3c7; color: #b45309; }
.rk-2 { background: #f1f5f9; color: #475569; }
.rk-3 { background: #fef2f2; color: #b91c1c; }
.rk-n { background: #f1f5f9; color: #94a3b8; }

/* Avatar */
.cd-av {
    width: 36px; height: 36px; border-radius: 9px; flex-shrink: 0;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; color: #fff; font-size: .9rem;
}
.cd-name { font-weight: 600; color: #0f172a; font-size: .83rem; }
.cd-spec { font-size: .73rem; color: #64748b; margin-top: .1rem; }

/* Barra de carga */
.cd-bar-wrap { display: flex; align-items: center; gap: .6rem; }
.cd-bar-bg { flex: 1; height: 7px; background: #f1f5f9; border-radius: 99px; overflow: hidden; min-width: 80px; }
.cd-bar-fill { height: 100%; border-radius: 99px; transition: width .5s ease; }
.cd-bar-num { font-size: .78rem; font-weight: 700; color: #0f172a; white-space: nowrap; min-width: 28px; text-align: right; }

/* Chips materias */
.cd-chips { display: flex; flex-wrap: wrap; gap: .3rem; max-width: 240px; }
.cd-chip {
    display: inline-flex; align-items: center; padding: .18rem .55rem;
    border-radius: 999px; font-size: .68rem; font-weight: 600;
    background: #e8f8f9; color: #00508f; white-space: nowrap;
}
.cd-chip-gray { background: #f1f5f9; color: #64748b; }

/* Grados inline */
.cd-grado-badge {
    display: inline-flex; align-items: center; gap: .2rem;
    padding: .18rem .6rem; border-radius: 6px; font-size: .7rem; font-weight: 700;
    background: #eef2ff; color: #4f46e5;
}

/* Badges contrato */
.bpill {
    display: inline-flex; align-items: center; gap: .2rem;
    padding: .2rem .6rem; border-radius: 999px;
    font-size: .69rem; font-weight: 600; white-space: nowrap;
}
.b-full  { background: #ecfdf5; color: #059669; }
.b-half  { background: #eff6ff; color: #3b82f6; }
.b-hours { background: #fffbeb; color: #92400e; }

/* Botón detalle */
.btn-det {
    display: inline-flex; align-items: center; justify-content: center;
    width: 30px; height: 30px; border-radius: 7px; border: none;
    cursor: pointer; font-size: .78rem; transition: all .15s;
    background: #e8f8f9; color: #00508f;
}
.btn-det:hover { background: #00508f; color: #fff; transform: translateY(-1px); }

/* Gráficas */
.cd-charts-grid {
    display: grid; grid-template-columns: repeat(2,1fr); gap: 1.25rem;
}
@media(max-width:768px){ .cd-charts-grid { grid-template-columns: 1fr; } }

.cd-chart-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.cd-chart-head {
    padding: .75rem 1.1rem; border-bottom: 1px solid #f1f5f9;
    display: flex; align-items: center; gap: .5rem;
}
.cd-chart-head i { color: #4ec7d2; }
.cd-chart-head span { font-weight: 700; font-size: .88rem; color: #0f172a; }
.cd-chart-body { padding: 1.25rem; }

/* Detalle expandible */
.cd-detail-panel {
    background: #f8fafc; border-top: 2px solid #4ec7d2; padding: 1rem 1.25rem;
}
.dp-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: .75rem; }
@media(max-width:700px){ .dp-grid { grid-template-columns: 1fr; } }

.dp-block {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: .85rem 1rem;
}
.dp-block-title {
    font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em;
    color: #64748b; margin-bottom: .6rem; display: flex; align-items: center; gap: .4rem;
}
.dp-block-title i { color: #4ec7d2; }
.dp-grado-row {
    display: flex; align-items: center; justify-content: space-between;
    padding: .3rem 0; border-bottom: 1px solid #f1f5f9; font-size: .8rem;
}
.dp-grado-row:last-child { border-bottom: none; }
.dp-grado-name { font-weight: 600; color: #0f172a; }
.dp-grado-count { font-size: .75rem; color: #64748b; }
.dp-materia-chip {
    display: inline-flex; align-items: center; padding: .2rem .65rem;
    border-radius: 7px; font-size: .73rem; font-weight: 600;
    background: linear-gradient(135deg,rgba(78,199,210,.12),rgba(0,80,143,.08));
    color: #00508f; border: 1px solid rgba(78,199,210,.3); margin: .15rem;
}
.dp-empty { color: #94a3b8; font-size: .8rem; padding: .4rem 0; }

/* Empty */
.cd-empty { padding: 4rem 1rem; text-align: center; }
.cd-empty i { font-size: 2.2rem; color: #cbd5e1; display: block; margin-bottom: .75rem; }
.cd-empty p { color: #94a3b8; font-size: .85rem; margin: 0; }

/* Footer */
.cd-footer {
    padding: .85rem 1.25rem; border-top: 1px solid #f1f5f9;
    font-size: .78rem; color: #94a3b8; background: #fafafa;
    display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .5rem;
}

/* Modal */
.modal-content { border-radius: 12px; border: none; overflow: hidden; }
.modal-header-cd {
    background: #003b73; padding: 1rem 1.25rem; border-bottom: none;
    display: flex; align-items: center; justify-content: space-between;
}
.modal-header-cd h6 { color: #fff; font-weight: 700; font-size: .95rem; margin: 0; display: flex; align-items: center; gap: .5rem; }
.modal-header-cd .btn-close { filter: invert(1) brightness(2); }
.modal-body-cd { padding: 0; }
.modal-search-bar { padding: .85rem 1.25rem; border-bottom: 1px solid #f1f5f9; position: relative; }
.modal-search-bar i { position: absolute; left: calc(1.25rem + 9px); top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: .8rem; pointer-events: none; }
.modal-search-bar input {
    width: 100%; padding: .4rem .75rem .4rem 2.2rem;
    border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: .82rem; outline: none;
    font-family: 'Inter', sans-serif; background: #f8fafc;
}
.modal-search-bar input:focus { border-color: #4ec7d2; }
.est-list { max-height: 380px; overflow-y: auto; }
.est-row {
    display: flex; align-items: center; gap: .85rem;
    padding: .65rem 1.25rem; border-bottom: 1px solid #f8f9fa; transition: background .12s;
}
.est-row:hover { background: #f8fafc; }
.est-row:last-child { border-bottom: none; }
.est-av {
    width: 34px; height: 34px; border-radius: 8px; flex-shrink: 0;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; color: #fff; font-size: .85rem;
}
.est-av-alt { background: linear-gradient(135deg, #a78bfa, #7c3aed); }
.est-info { flex: 1; }
.est-name { font-weight: 600; color: #0f172a; font-size: .82rem; }
.est-meta { font-size: .72rem; color: #64748b; }
.est-grade-badge {
    padding: .18rem .6rem; border-radius: 6px; font-size: .7rem; font-weight: 700;
    background: #eef2ff; color: #4f46e5; white-space: nowrap;
}
.modal-footer-cd {
    padding: .75rem 1.25rem; border-top: 1px solid #f1f5f9;
    background: #fafafa; display: flex; align-items: center; justify-content: space-between;
}
.modal-footer-cd span { font-size: .78rem; color: #94a3b8; }
.modal-filter-tabs {
    display: flex; gap: .35rem; padding: .75rem 1.25rem; border-bottom: 1px solid #f1f5f9; flex-wrap: wrap;
}
.mft {
    padding: .22rem .7rem; border-radius: 6px; font-size: .72rem; font-weight: 600;
    border: 1.5px solid #e2e8f0; background: #fff; color: #64748b; cursor: pointer; transition: all .12s;
}
.mft.active { background: linear-gradient(135deg,#4ec7d2,#00508f); color: #fff; border-color: transparent; }
.mft:not(.active):hover { border-color: #4ec7d2; color: #00508f; }
.est-list::-webkit-scrollbar { width: 5px; }
.est-list::-webkit-scrollbar-track { background: #f1f5f9; }
.est-list::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }
</style>
@endpush

@section('content')

{{-- ✅ JSON embebido AQUÍ (en @section content, NO en @push scripts) para evitar ParseError de Blade --}}
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
        'grados_list'         => $p->nombres_grados ? explode(', ', $p->nombres_grados) : [],
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
        <form method="GET" action="{{ route('carga-docente.index') }}" class="cd-toolbar-form">
            <label style="font-size:.82rem;font-weight:600;color:#64748b;">Año lectivo:</label>
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
        <button class="cd-vtab active" id="tab-tabla" onclick="switchView('tabla', this)">
            <i class="fas fa-table"></i> Tabla
        </button>
        <button class="cd-vtab" id="tab-graficas" onclick="switchView('graficas', this)">
            <i class="fas fa-chart-bar"></i> Gráficas
        </button>
    </div>

    {{-- Vista Tabla --}}
    <div id="view-tabla">
        <div class="cd-card">
            <div class="cd-card-head">
                <div class="cd-card-head-left">
                    <i class="fas fa-chart-bar"></i>
                    <span>Distribución de Carga Docente — {{ $anio }}</span>
                </div>
                <span class="cd-card-head-sub">
                    Clic en <i class="fas fa-chevron-down" style="font-size:.7rem;"></i> para ver detalle
                </span>
            </div>

            @php $maxEst = $profesores->max('total_estudiantes') ?: 1; @endphp

            <div style="overflow-x:auto;">
                <table class="cd-tbl" id="cdTable">
                    <thead>
                        <tr>
                            <th class="tc">#</th>
                            <th>Profesor</th>
                            <th class="tc">Contrato</th>
                            <th>Materias</th>
                            <th class="tc">Grados</th>
                            <th class="tc">Horas/sem</th>
                            <th style="min-width:160px;">Estudiantes</th>
                            <th class="tc">Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($profesores as $i => $p)
                        @php
                            $pct      = ($p->total_estudiantes / $maxEst) * 100;
                            $barColor = $pct >= 80 ? '#ef4444' : ($pct >= 50 ? '#f59e0b' : '#4ec7d2');
                            $rkClass  = ['rk-1','rk-2','rk-3'][$i] ?? 'rk-n';
                            $contrato = match($p->tipo_contrato ?? '') {
                                'tiempo_completo' => ['Tiempo Completo', 'b-full'],
                                'medio_tiempo'    => ['Medio Tiempo',    'b-half'],
                                'por_horas'       => ['Por Horas',       'b-hours'],
                                default           => ['—',               'b-half'],
                            };
                            $materiasList        = $p->nombres_materias ? explode(', ', $p->nombres_materias) : [];
                            $gradosList          = $p->nombres_grados   ? explode(', ', $p->nombres_grados)   : [];
                            $estudiantesPorGrado = json_decode($p->estudiantes_por_grado ?? '[]', true);
                        @endphp

                        <tr data-name="{{ strtolower($p->nombre . ' ' . $p->apellido) }}" class="cd-main-row">
                            <td class="tc"><span class="cd-rank {{ $rkClass }}">{{ $i + 1 }}</span></td>
                            <td>
                                <div style="display:flex;align-items:center;gap:.65rem;">
                                    <div class="cd-av">{{ strtoupper(substr($p->nombre, 0, 1)) }}</div>
                                    <div>
                                        <div class="cd-name">{{ $p->nombre }} {{ $p->apellido }}</div>
                                        <div class="cd-spec">{{ $p->especialidad ?? '—' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="tc">
                                <span class="bpill {{ $contrato[1] }}">{{ $contrato[0] }}</span>
                            </td>
                            <td>
                                @if(count($materiasList))
                                    <div class="cd-chips">
                                        @foreach(array_slice($materiasList, 0, 3) as $m)
                                            <span class="cd-chip">{{ $m }}</span>
                                        @endforeach
                                        @if(count($materiasList) > 3)
                                            <span class="cd-chip cd-chip-gray">+{{ count($materiasList) - 3 }}</span>
                                        @endif
                                    </div>
                                @else
                                    <span style="color:#cbd5e1;font-size:.75rem;">Sin materias</span>
                                @endif
                            </td>
                            <td class="tc">
                                <div style="display:flex;flex-wrap:wrap;gap:.25rem;justify-content:center;">
                                    @foreach(array_slice($gradosList, 0, 3) as $g)
                                        <span class="cd-grado-badge">{{ $g }}</span>
                                    @endforeach
                                    @if(count($gradosList) > 3)
                                        <span class="cd-grado-badge" style="background:#f1f5f9;color:#64748b;">+{{ count($gradosList) - 3 }}</span>
                                    @endif
                                    @if(!count($gradosList))
                                        <span style="color:#cbd5e1;font-size:.75rem;">—</span>
                                    @endif
                                </div>
                            </td>
                            <td class="tc">
                                <span style="font-weight:700;color:#00508f;font-size:.9rem;">{{ $p->total_horas ?? 0 }}</span>
                            </td>
                            <td>
                                <div class="cd-bar-wrap">
                                    <div class="cd-bar-bg">
                                        <div class="cd-bar-fill" style="width:{{ $pct }}%;background:{{ $barColor }};"></div>
                                    </div>
                                    <span class="cd-bar-num">{{ $p->total_estudiantes }}</span>
                                </div>
                            </td>
                            <td class="tc">
                                {{-- ✅ Usamos data-id, SIN parámetros en onclick --}}
                                <button class="btn-det btn-toggle-detail"
                                        data-id="{{ $p->id }}"
                                        title="Ver detalle">
                                    <i class="fas fa-chevron-down" id="icon-{{ $p->id }}"></i>
                                </button>
                            </td>
                        </tr>

                        {{-- Fila expandible --}}
                        <tr id="detail-row-{{ $p->id }}" class="detail-row" style="display:none;">
                            <td colspan="8" style="padding:0;background:#f8fafc;">
                                <div class="cd-detail-panel">
                                    <div class="dp-grid">

                                        {{-- Grados --}}
                                        <div class="dp-block">
                                            <div class="dp-block-title">
                                                <i class="fas fa-layer-group"></i> Grados Asignados
                                            </div>
                                            @if(count($gradosList))
                                                @foreach($gradosList as $g)
                                                <div class="dp-grado-row">
                                                    <span class="dp-grado-name">
                                                        <i class="fas fa-circle" style="font-size:.45rem;color:#4ec7d2;vertical-align:middle;margin-right:.3rem;"></i>
                                                        {{ $g }}
                                                    </span>
                                                    <span class="dp-grado-count">
                                                        <i class="fas fa-users" style="font-size:.65rem;"></i>
                                                        {{ $estudiantesPorGrado[$g] ?? '—' }} est.
                                                    </span>
                                                </div>
                                                @endforeach
                                            @else
                                                <p class="dp-empty">Sin grados asignados</p>
                                            @endif
                                        </div>

                                        {{-- Materias --}}
                                        <div class="dp-block">
                                            <div class="dp-block-title">
                                                <i class="fas fa-book-open"></i> Materias que Imparte
                                            </div>
                                            @if(count($materiasList))
                                                <div style="display:flex;flex-wrap:wrap;gap:.2rem;">
                                                    @foreach($materiasList as $m)
                                                        <span class="dp-materia-chip">{{ $m }}</span>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="dp-empty">Sin materias asignadas</p>
                                            @endif
                                        </div>

                                        {{-- Resumen --}}
                                        <div class="dp-block">
                                            <div class="dp-block-title">
                                                <i class="fas fa-chart-pie"></i> Resumen
                                            </div>
                                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.5rem;margin-bottom:.85rem;">
                                                @php
                                                    $resumenItems = [
                                                        ['icon' => 'fas fa-layer-group', 'label' => 'Grados',      'val' => count($gradosList),   'color' => '#4f46e5'],
                                                        ['icon' => 'fas fa-book',         'label' => 'Materias',    'val' => count($materiasList), 'color' => '#00508f'],
                                                        ['icon' => 'fas fa-clock',        'label' => 'Horas/sem',   'val' => $p->total_horas ?? 0, 'color' => '#0891b2'],
                                                        ['icon' => 'fas fa-users',        'label' => 'Estudiantes', 'val' => $p->total_estudiantes,'color' => '#059669'],
                                                    ];
                                                @endphp
                                                @foreach($resumenItems as $it)
                                                <div style="background:#f8fafc;border-radius:8px;padding:.55rem .7rem;display:flex;align-items:center;gap:.5rem;">
                                                    <i class="{{ $it['icon'] }}" style="color:{{ $it['color'] }};font-size:.8rem;"></i>
                                                    <div>
                                                        <div style="font-size:.68rem;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.05em;">{{ $it['label'] }}</div>
                                                        <div style="font-size:1.05rem;font-weight:700;color:#0f172a;line-height:1.1;">{{ $it['val'] }}</div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            {{-- ✅ data-id y data-nombre, SIN parámetros en onclick --}}
                                            <button class="cd-btn btn-ver-estudiantes"
                                                    data-id="{{ $p->id }}"
                                                    data-nombre="{{ $p->nombre }} {{ $p->apellido }}"
                                                    style="width:100%;justify-content:center;font-size:.8rem;padding:.45rem;">
                                                <i class="fas fa-users"></i> Ver Lista de Estudiantes
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="8">
                                <div class="cd-empty">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                    <p>No hay datos de carga docente para este año lectivo</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="cd-footer">
                <span>Mostrando {{ $profesores->count() }} profesores activos · Año {{ $anio }}</span>
                <span>Total estudiantes: <strong style="color:#00508f;">{{ $profesores->sum('total_estudiantes') }}</strong></span>
            </div>
        </div>
    </div>

    {{-- Vista Gráficas --}}
    <div id="view-graficas" style="display:none;">
        <div class="cd-charts-grid">

            <div class="cd-chart-card" style="grid-column:1/-1;">
                <div class="cd-chart-head"><i class="fas fa-chart-bar"></i><span>Estudiantes por Profesor</span></div>
                <div class="cd-chart-body" style="height:300px;"><canvas id="chartEstudiantes"></canvas></div>
            </div>

            <div class="cd-chart-card">
                <div class="cd-chart-head"><i class="fas fa-clock"></i><span>Horas Semanales por Profesor</span></div>
                <div class="cd-chart-body" style="height:260px;"><canvas id="chartHoras"></canvas></div>
            </div>

            <div class="cd-chart-card">
                <div class="cd-chart-head"><i class="fas fa-book"></i><span>Materias Asignadas por Profesor</span></div>
                <div class="cd-chart-body" style="height:260px;"><canvas id="chartMaterias"></canvas></div>
            </div>

            <div class="cd-chart-card">
                <div class="cd-chart-head"><i class="fas fa-file-contract"></i><span>Distribución por Contrato</span></div>
                <div class="cd-chart-body" style="height:260px;display:flex;align-items:center;justify-content:center;">
                    <canvas id="chartContrato" style="max-height:220px;max-width:220px;"></canvas>
                </div>
            </div>

            <div class="cd-chart-card">
                <div class="cd-chart-head"><i class="fas fa-layer-group"></i><span>Grados Asignados por Profesor</span></div>
                <div class="cd-chart-body" style="height:260px;"><canvas id="chartGrados"></canvas></div>
            </div>

        </div>
    </div>

</div>

{{-- Modal Estudiantes --}}
<div class="modal fade" id="modalEstudiantes" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:540px;">
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
            <div class="modal-body-cd">
                <div class="est-list" id="estList"></div>
            </div>
            <div class="modal-footer-cd">
                <span id="estCount">0 estudiantes</span>
                <button type="button" data-bs-dismiss="modal"
                        style="padding:.38rem 1rem;border-radius:7px;border:1.5px solid #e2e8f0;background:#fff;color:#64748b;font-size:.82rem;font-weight:600;cursor:pointer;">
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

    /* ── Leer JSON embebido ─────────────────────────────────── */
    var profesoresData = JSON.parse(
        document.getElementById('profesores-data').textContent
    );

    /* ── Labels cortos ──────────────────────────────────────── */
    var labels = profesoresData.map(function(p) {
        var parts = p.nombre.split(' ');
        return parts[0] + (parts.length > 1 ? ' ' + parts[parts.length - 1][0] + '.' : '');
    });

    var gradientColors = [
        'rgba(78,199,210,.85)', 'rgba(0,80,143,.8)',   'rgba(52,211,153,.8)',
        'rgba(167,139,250,.8)', 'rgba(251,191,36,.8)',  'rgba(248,113,113,.8)',
        'rgba(14,165,233,.8)',  'rgba(236,72,153,.8)',  'rgba(234,88,12,.8)',
        'rgba(16,185,129,.8)',
    ];

    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#64748b';
    var chartsInitialized = false;

    /* ── Switch de vista ────────────────────────────────────── */
    window.switchView = function(view, btn) {
        document.querySelectorAll('.cd-vtab').forEach(function(b) { b.classList.remove('active'); });
        btn.classList.add('active');
        document.getElementById('view-tabla').style.display    = (view === 'tabla')    ? '' : 'none';
        document.getElementById('view-graficas').style.display = (view === 'graficas') ? '' : 'none';
        if (view === 'graficas' && !chartsInitialized) {
            initCharts();
            chartsInitialized = true;
        }
    };

    /* ── Toggle detalle (usando delegación en document) ─────── */
    document.addEventListener('click', function(e) {
        var btn = e.target.closest('.btn-toggle-detail');
        if (!btn) return;
        var id   = btn.dataset.id;
        var row  = document.getElementById('detail-row-' + id);
        var icon = document.getElementById('icon-' + id);
        if (!row) return;
        var isOpen = row.style.display !== 'none';
        row.style.display    = isOpen ? 'none' : 'table-row';
        icon.style.transform  = isOpen ? '' : 'rotate(180deg)';
        icon.style.transition = 'transform .2s';
    });

    /* ── Búsqueda en tabla ──────────────────────────────────── */
    var cdSearch = document.getElementById('cdSearch');
    if (cdSearch) {
        cdSearch.addEventListener('input', function() {
            var q = this.value.toLowerCase();
            document.querySelectorAll('#cdTable tbody tr.cd-main-row').forEach(function(row) {
                var visible = row.dataset.name.includes(q);
                row.style.display = visible ? '' : 'none';
                var toggler = row.querySelector('.btn-toggle-detail');
                if (toggler) {
                    var dr = document.getElementById('detail-row-' + toggler.dataset.id);
                    if (dr && !visible) dr.style.display = 'none';
                }
            });
        });
    }

    /* ── Modal Estudiantes ──────────────────────────────────── */
    var estudiantesActuales = [];
    var gradoFiltroActual   = '';
    var modalBS = new bootstrap.Modal(document.getElementById('modalEstudiantes'));

    /* Abrir modal (delegación en document) */
    document.addEventListener('click', function(e) {
        var btn = e.target.closest('.btn-ver-estudiantes');
        if (!btn) return;
        abrirModalEstudiantes(btn.dataset.id, btn.dataset.nombre);
    });

    function abrirModalEstudiantes(profesorId, nombre) {
        document.getElementById('modalProfesorNombre').textContent = nombre;
        document.getElementById('estSearch').value = '';
        gradoFiltroActual = '';

        var p           = profesoresData.find(function(x) { return String(x.id) === String(profesorId); });
        var estudiantes = (p && p.estudiantes_detalle) ? p.estudiantes_detalle : [];
        estudiantesActuales = estudiantes;

        /* Tabs de grado */
        var tabsEl = document.getElementById('gradoFilterTabs');
        var grados = Array.from(new Set(
            estudiantes.map(function(e) { return e.grado; }).filter(Boolean)
        )).sort();

        tabsEl.innerHTML = '<button class="mft active" data-grado="">Todos (' + estudiantes.length + ')</button>';
        grados.forEach(function(g) {
            var cnt = estudiantes.filter(function(e) { return e.grado === g; }).length;
            tabsEl.innerHTML += '<button class="mft" data-grado="' + g + '">' + g + ' (' + cnt + ')</button>';
        });

        /* Eventos de tabs */
        tabsEl.querySelectorAll('.mft').forEach(function(tab) {
            tab.addEventListener('click', function() {
                tabsEl.querySelectorAll('.mft').forEach(function(t) { t.classList.remove('active'); });
                this.classList.add('active');
                gradoFiltroActual = this.dataset.grado;
                document.getElementById('estSearch').value = '';
                var filtered = gradoFiltroActual
                    ? estudiantesActuales.filter(function(e) { return e.grado === gradoFiltroActual; })
                    : estudiantesActuales;
                renderEstudiantes(filtered);
            });
        });

        renderEstudiantes(estudiantes);
        modalBS.show();
    }

    /* Búsqueda en modal */
    document.getElementById('estSearch').addEventListener('input', function() {
        var q    = this.value.toLowerCase();
        var base = gradoFiltroActual
            ? estudiantesActuales.filter(function(e) { return e.grado === gradoFiltroActual; })
            : estudiantesActuales;
        var filtered = q ? base.filter(function(e) { return (e.nombre || '').toLowerCase().includes(q); }) : base;
        renderEstudiantes(filtered);
    });

    function renderEstudiantes(lista) {
        var el = document.getElementById('estList');
        document.getElementById('estCount').textContent =
            lista.length + ' estudiante' + (lista.length !== 1 ? 's' : '');

        if (!lista.length) {
            el.innerHTML = '<div style="padding:3rem;text-align:center;color:#94a3b8;">' +
                '<i class="fas fa-search" style="font-size:1.5rem;display:block;margin-bottom:.5rem;"></i>Sin resultados</div>';
            return;
        }

        el.innerHTML = lista.map(function(e, idx) {
            return '<div class="est-row">' +
                '<div class="est-av ' + (idx % 2 === 1 ? 'est-av-alt' : '') + '">' +
                    (e.nombre || '?')[0].toUpperCase() +
                '</div>' +
                '<div class="est-info">' +
                    '<div class="est-name">' + (e.nombre || '—') + '</div>' +
                    '<div class="est-meta">' +
                        (e.dni || '') + (e.dni && e.materia ? ' · ' : '') + (e.materia || '') +
                    '</div>' +
                '</div>' +
                (e.grado ? '<span class="est-grade-badge">' + e.grado + '</span>' : '') +
            '</div>';
        }).join('');
    }

    /* ── Gráficas ───────────────────────────────────────────── */
    function initCharts() {

        /* 1. Estudiantes (horizontal) */
        new Chart(document.getElementById('chartEstudiantes'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Estudiantes',
                    data: profesoresData.map(function(p) { return p.total_estudiantes; }),
                    backgroundColor: gradientColors,
                    borderRadius: 6, borderSkipped: false,
                }]
            },
            options: {
                indexAxis: 'y', responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { color: '#f1f5f9' }, ticks: { font: { size: 11 } } },
                    y: { grid: { display: false },   ticks: { font: { size: 11 } } }
                }
            }
        });

        /* 2. Horas */
        new Chart(document.getElementById('chartHoras'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Horas/semana',
                    data: profesoresData.map(function(p) { return p.total_horas; }),
                    backgroundColor: 'rgba(0,80,143,.75)',
                    borderRadius: 6, borderSkipped: false,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 10 }, maxRotation: 35 } },
                    y: { grid: { color: '#f1f5f9' }, beginAtZero: true }
                }
            }
        });

        /* 3. Materias */
        new Chart(document.getElementById('chartMaterias'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Materias',
                    data: profesoresData.map(function(p) { return p.total_materias; }),
                    backgroundColor: 'rgba(78,199,210,.75)',
                    borderRadius: 6, borderSkipped: false,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 10 }, maxRotation: 35 } },
                    y: { grid: { color: '#f1f5f9' }, beginAtZero: true, ticks: { stepSize: 1 } }
                }
            }
        });

        /* 4. Contrato (dona) */
        var cc = { tiempo_completo: 0, medio_tiempo: 0, por_horas: 0, otro: 0 };
        profesoresData.forEach(function(p) {
            if (cc[p.tipo_contrato] !== undefined) cc[p.tipo_contrato]++;
            else cc.otro++;
        });
        new Chart(document.getElementById('chartContrato'), {
            type: 'doughnut',
            data: {
                labels: ['Tiempo Completo', 'Medio Tiempo', 'Por Horas', 'Otro'],
                datasets: [{
                    data: Object.values(cc),
                    backgroundColor: ['#059669', '#3b82f6', '#f59e0b', '#94a3b8'],
                    borderWidth: 2, borderColor: '#fff',
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom', labels: { font: { size: 11 }, padding: 12, boxWidth: 12 } } },
                cutout: '62%',
            }
        });

        /* 5. Grados */
        new Chart(document.getElementById('chartGrados'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Grados',
                    data: profesoresData.map(function(p) { return p.total_grados; }),
                    backgroundColor: 'rgba(99,102,241,.75)',
                    borderRadius: 6, borderSkipped: false,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 10 }, maxRotation: 35 } },
                    y: { grid: { color: '#f1f5f9' }, beginAtZero: true, ticks: { stepSize: 1 } }
                }
            }
        });
    }

}); // fin DOMContentLoaded
</script>
@endpush
