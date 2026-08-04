@extends('layouts.app')
@section('title', 'Asistencias')
@section('page-title', 'Registro de Asistencias')

@push('styles')
<style>
:root {
    --c-primary:#00508f; --c-dark:#003b73; --c-teal:#4ec7d2;
    --c-green:#10b981; --c-amber:#f59e0b; --c-red:#ef4444;
    --c-border:#e2e8f0; --c-surface:#f8fafc; --c-muted:#64748b; --c-text:#1e293b;
}

/* ── Hero ── */
.adm-hero {
    background:linear-gradient(135deg,#4ec7d2 0%,#00508f 60%,#003b73 100%);
    border-radius:14px; padding:1.5rem 1.75rem; margin-bottom:1.5rem;
    display:flex; align-items:center; justify-content:space-between;
    flex-wrap:wrap; gap:1rem;
    box-shadow:0 4px 18px rgba(0,59,115,.18);
}
.adm-hero-left   { display:flex; align-items:center; gap:1.25rem; }
.adm-hero-icon   {
    width:56px; height:56px; border-radius:14px; flex-shrink:0;
    background:rgba(255,255,255,.18);
    display:flex; align-items:center; justify-content:center;
}
.adm-hero-icon i { font-size:1.5rem; color:#fff; }
.adm-hero-title  { font-size:1.3rem; font-weight:700; color:#fff; margin:0; }
.adm-hero-sub    { font-size:.82rem; color:rgba(255,255,255,.78); margin-top:.2rem; }

/* ── Card ── */
.adm-card {
    background:#fff; border:1px solid var(--c-border);
    border-radius:12px; overflow:hidden;
    box-shadow:0 1px 3px rgba(0,0,0,.05); margin-bottom:1.25rem;
}
.adm-card-head {
    background:var(--c-dark); padding:.85rem 1.25rem;
    display:flex; align-items:center; gap:.6rem;
}
.adm-card-head i    { color:var(--c-teal); font-size:1rem; }
.adm-card-head span { color:#fff; font-weight:700; font-size:.95rem; }
.adm-card-body { padding:1.25rem 1.5rem; }

/* ── Filtros ── */
.as-filters {
    display:flex; gap:.75rem; flex-wrap:wrap; align-items:flex-end;
    margin-bottom:1.25rem; padding:.85rem 1rem;
    background:var(--c-surface); border-radius:10px; border:1px solid var(--c-border);
}
.as-filter-field { display:flex; flex-direction:column; gap:.3rem; }
.as-filter-label {
    font-size:.68rem; font-weight:700; text-transform:uppercase;
    letter-spacing:.06em; color:var(--c-muted);
}
.as-select, .as-input {
    padding:.42rem .75rem; border:1.5px solid var(--c-border); border-radius:8px;
    font-size:.82rem; color:#0f172a; background:white; outline:none;
    transition:border-color .15s; min-width:150px; font-family:inherit;
}
.as-select:focus, .as-input:focus { border-color:var(--c-teal); }
.btn-filtrar {
    padding:.45rem 1rem; border-radius:8px; font-size:.82rem; font-weight:700;
    background:var(--c-primary); color:white; border:none; cursor:pointer;
    display:flex; align-items:center; gap:.35rem; white-space:nowrap;
    transition:background .15s;
}
.btn-filtrar:hover { background:var(--c-dark); }

/* ── Tabla ── */
.ses-table { width:100%; border-collapse:collapse; }
.ses-table thead th {
    font-size:.65rem; font-weight:700; text-transform:uppercase; letter-spacing:.07em;
    color:var(--c-muted); background:var(--c-surface); padding:.65rem .9rem;
    border-bottom:1.5px solid var(--c-border); text-align:left; white-space:nowrap;
}
.ses-table tbody td {
    padding:.7rem .9rem; border-bottom:1px solid #f1f5f9;
    font-size:.82rem; vertical-align:middle;
}
.ses-table tbody tr:last-child td { border-bottom:none; }
.ses-table tbody tr:hover td { background:#f0f7ff; }
.ses-table tbody td:last-child { white-space:nowrap; text-align:right; }

/* ── Pills ── */
.pill {
    display:inline-flex; align-items:center; gap:.25rem;
    padding:.2rem .6rem; border-radius:999px; font-size:.7rem; font-weight:700;
}
.pill-green { background:rgba(16,185,129,.1);  color:#065f46; }
.pill-red   { background:rgba(239,68,68,.1);   color:#991b1b; }
.pill-amber { background:rgba(245,158,11,.1);  color:#92400e; }
.pill-blue  { background:rgba(78,199,210,.1);  color:#0e7490; }

/* ── Barra de porcentaje ── */
.pct-bar  { height:6px; background:#f1f5f9; border-radius:99px; width:80px; margin-top:.25rem; }
.pct-fill { height:100%; border-radius:99px; }

/* ── Botón Ver ── */
.btn-ver {
    display:inline-flex; align-items:center; gap:.35rem;
    padding:.32rem .8rem; border-radius:7px;
    font-size:.75rem; font-weight:700; white-space:nowrap;
    background:white; color:var(--c-primary);
    border:1.5px solid var(--c-primary);
    text-decoration:none; transition:all .15s;
}
.btn-ver:hover { background:var(--c-primary); color:white; }

.btn-nueva {
    display:inline-flex; align-items:center; gap:.4rem;
    padding:.48rem 1.25rem; border-radius:8px; font-size:.85rem; font-weight:700;
    background:rgba(255,255,255,.2); color:white;
    border:1.5px solid rgba(255,255,255,.4);
    text-decoration:none; transition:background .15s; white-space:nowrap;
}
.btn-nueva:hover { background:rgba(255,255,255,.3); color:white; }

/* ── Empty ── */
.as-empty { text-align:center; padding:3rem 1rem; color:var(--c-muted); }
.as-empty i { font-size:2.5rem; color:#cbd5e1; display:block; margin-bottom:.75rem; }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">

    {{-- Hero --}}
    <div class="adm-hero">
        <div class="adm-hero-left">
            <div class="adm-hero-icon">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <div>
                <div class="adm-hero-title">Asistencias</div>
                <div class="adm-hero-sub">Historial de asistencia por clase y fecha</div>
            </div>
        </div>
        <a href="{{ route('asistencias.create') }}" class="btn-nueva">
            <i class="fas fa-plus"></i> Registrar Asistencia
        </a>
    </div>

    <div class="adm-card">
        <div class="adm-card-head">
            <i class="fas fa-filter"></i>
            <span>Filtros</span>
        </div>
        <div class="adm-card-body">

            {{-- Filtros --}}
            <form method="GET" action="{{ route('asistencias.index') }}">
                <div class="as-filters">
                    <div class="as-filter-field">
                        <span class="as-filter-label">Grado</span>
                        <select name="grado_id" class="as-select">
                            <option value="">Todos los grados</option>
                            @foreach($grados as $g)
                                <option value="{{ $g->id }}" {{ request('grado_id') == $g->id ? 'selected' : '' }}>
                                    {{ $g->numero }}&deg; {{ ucfirst($g->nivel) }} &mdash; Sec. {{ $g->seccion }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="as-filter-field">
                        <span class="as-filter-label">Materia</span>
                        <select name="materia_id" class="as-select">
                            <option value="">Todas las materias</option>
                            @foreach($materias as $m)
                                <option value="{{ $m->id }}" {{ request('materia_id') == $m->id ? 'selected' : '' }}>
                                    {{ $m->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="as-filter-field">
                        <span class="as-filter-label">Fecha</span>
                        <input type="date" name="fecha" class="as-input"
                               value="{{ request('fecha') }}" max="{{ now()->toDateString() }}">
                    </div>
                    <button type="submit" class="btn-filtrar">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                    <a href="{{ route('asistencias.index') }}"
                       style="font-size:.78rem;color:var(--c-muted);text-decoration:none;align-self:center;">
                        Limpiar
                    </a>
                </div>
            </form>

            {{-- Acceso rápido al reporte --}}
            <div style="display:flex;justify-content:flex-end;margin-bottom:1rem;">
                <a href="{{ route('asistencias.reporte') }}"
                   style="font-size:.8rem;font-weight:700;color:var(--c-primary);text-decoration:none;
                          display:flex;align-items:center;gap:.35rem;">
                    <i class="fas fa-chart-bar"></i> Ver Informe General
                </a>
            </div>

            {{-- Tabla --}}
            @if($sesiones->isEmpty())
                <div class="as-empty">
                    <i class="fas fa-clipboard"></i>
                    <p style="font-weight:600;">No hay registros de asistencia a&uacute;n</p>
                    <a href="{{ route('asistencias.create') }}" class="btn-nueva"
                       style="display:inline-flex;margin-top:.5rem;background:var(--c-primary);
                              border-color:var(--c-primary);">
                        <i class="fas fa-plus"></i> Registrar ahora
                    </a>
                </div>
            @else
                <div style="overflow-x:auto;">
                    <table class="ses-table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Grado</th>
                                <th>Materia</th>
                                <th>Total</th>
                                <th><i class="fas fa-check-circle" style="color:#10b981;"></i> Presentes</th>
                                <th><i class="fas fa-times-circle" style="color:#ef4444;"></i> Ausentes</th>
                                <th><i class="fas fa-clock" style="color:#f59e0b;"></i> Tardanzas</th>
                                <th>% Asistencia</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sesiones as $s)
                            @php
                                $pct      = $s->total > 0 ? round($s->presentes / $s->total * 100) : 0;
                                $barColor = $pct >= 80 ? '#10b981' : ($pct >= 60 ? '#f59e0b' : '#ef4444');
                                $grado    = $grados->find($s->grado_id);
                                $materia  = $materias->find($s->materia_id);
                                $fechaStr = $s->fecha;
                            @endphp
                            <tr>
                                <td style="font-weight:600;color:var(--c-dark);">
                                    {{ \Carbon\Carbon::parse($s->fecha)->format('d/m/Y') }}
                                    <div style="font-size:.7rem;color:var(--c-muted);">
                                        {{ \Carbon\Carbon::parse($s->fecha)->isoFormat('dddd') }}
                                    </div>
                                </td>
                                <td>
                                    @if($grado)
                                        <span style="font-weight:600;">{{ $grado->numero }}&deg; {{ ucfirst($grado->nivel) }}</span><br>
                                        <span style="font-size:.72rem;color:var(--c-muted);">Secci&oacute;n {{ $grado->seccion }}</span>
                                    @else &mdash;
                                    @endif
                                </td>
                                <td style="font-weight:600;">{{ $materia?->nombre ?? '&mdash;' }}</td>
                                <td style="font-weight:700;font-size:1rem;color:var(--c-dark);">{{ $s->total }}</td>
                                <td><span class="pill pill-green"><i class="fas fa-check-circle"></i> {{ $s->presentes }}</span></td>
                                <td><span class="pill pill-red"><i class="fas fa-times-circle"></i> {{ $s->ausentes }}</span></td>
                                <td><span class="pill pill-amber"><i class="fas fa-clock"></i> {{ $s->tardanzas }}</span></td>
                                <td>
                                    <div style="font-weight:700;font-size:.85rem;color:{{ $barColor }};">{{ $pct }}%</div>
                                    <div class="pct-bar">
                                        <div class="pct-fill" style="width:{{ $pct }}%;background:{{ $barColor }};"></div>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('asistencias.show') }}?grado_id={{ $s->grado_id }}&materia_id={{ $s->materia_id }}&fecha={{ $fechaStr }}"
                                       class="btn-ver">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">{{ $sesiones->withQueryString()->links() }}</div>
            @endif

        </div>
    </div>

</div>
@endsection