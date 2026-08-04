@extends('layouts.app')
@section('title', 'Detalle de Asistencia')
@section('page-title', 'Detalle de Asistencia')

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
.adm-hero-left { display:flex; align-items:center; gap:1.25rem; }
.adm-hero-icon {
    width:56px; height:56px; border-radius:14px; flex-shrink:0;
    background:rgba(255,255,255,.18);
    display:flex; align-items:center; justify-content:center;
}
.adm-hero-icon i { font-size:1.5rem; color:#fff; }
.adm-hero-title { font-size:1.3rem; font-weight:700; color:#fff; margin:0; }
.adm-hero-chips { display:flex; flex-wrap:wrap; gap:.5rem; margin-top:.35rem; }
.hero-chip {
    display:inline-flex; align-items:center; gap:.3rem;
    background:rgba(255,255,255,.18); color:rgba(255,255,255,.92);
    padding:.22rem .65rem; border-radius:7px; font-size:.75rem; font-weight:600;
}
.btn-volver-hero {
    display:inline-flex; align-items:center; gap:.4rem;
    padding:.45rem 1.1rem; border-radius:8px; font-size:.82rem; font-weight:600;
    background:rgba(255,255,255,.15); color:#fff;
    border:1.5px solid rgba(255,255,255,.35); cursor:pointer;
    font-family:inherit; white-space:nowrap; flex-shrink:0; text-decoration:none;
    transition:background .15s;
}
.btn-volver-hero:hover { background:rgba(255,255,255,.25); color:#fff; }

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

/* ── Stat cards ── */
.det-stats {
    display:grid; grid-template-columns:repeat(auto-fit,minmax(130px,1fr));
    gap:1rem; margin-bottom:1.5rem;
}
.det-stat {
    background:var(--c-surface); border:1.5px solid var(--c-border);
    border-radius:12px; padding:1rem 1.1rem;
    display:flex; flex-direction:column; align-items:center; text-align:center;
    transition:transform .2s;
}
.det-stat:hover { transform:translateY(-2px); }
.det-stat-icon {
    width:40px; height:40px; border-radius:10px; margin-bottom:.5rem;
    display:flex; align-items:center; justify-content:center; font-size:1.1rem;
}
.ds-total   .det-stat-icon { background:#e0f9fb; color:var(--c-teal); }
.ds-present .det-stat-icon { background:#d1fae5; color:var(--c-green); }
.ds-absent  .det-stat-icon { background:#fee2e2; color:var(--c-red); }
.ds-late    .det-stat-icon { background:#fef3c7; color:var(--c-amber); }
.ds-pct     .det-stat-icon { background:#ede9fe; color:#6366f1; }
.det-stat-num { font-size:1.65rem; font-weight:800; color:var(--c-text); line-height:1; }
.det-stat-lbl { font-size:.68rem; font-weight:700; color:var(--c-muted); text-transform:uppercase; letter-spacing:.05em; margin-top:.3rem; }

/* Barra global */
.global-bar-wrap {
    background:var(--c-surface); border:1px solid var(--c-border);
    border-radius:10px; padding:.85rem 1.1rem; margin-bottom:1.5rem;
}
.global-bar-label {
    display:flex; justify-content:space-between; align-items:center;
    margin-bottom:.45rem;
}
.global-bar-label span { font-size:.8rem; font-weight:700; color:var(--c-text); }
.global-bar-track { height:10px; background:#f1f5f9; border-radius:99px; overflow:hidden; }
.global-bar-fill  { height:100%; border-radius:99px; transition:width .6s ease; }

/* Buscador y filtros */
.det-search-wrap {
    display:flex; align-items:center; gap:.75rem;
    margin-bottom:1rem; flex-wrap:wrap;
}
.det-search {
    flex:1; min-width:200px; padding:.42rem .85rem;
    border:1.5px solid var(--c-border); border-radius:8px;
    font-size:.82rem; color:var(--c-text); outline:none;
    transition:border-color .15s; font-family:inherit;
}
.det-search:focus { border-color:var(--c-teal); box-shadow:0 0 0 3px rgba(78,199,210,.1); }
.det-filter-btns { display:flex; gap:.4rem; flex-wrap:wrap; }
.fbtn {
    padding:.32rem .75rem; border-radius:7px; font-size:.75rem; font-weight:700;
    border:1.5px solid var(--c-border); background:white; color:var(--c-muted);
    cursor:pointer; transition:all .15s; white-space:nowrap;
}
.fbtn:hover { border-color:var(--c-primary); color:var(--c-primary); background:#e0f4ff; }
.fbtn.active { background:var(--c-primary); color:white; border-color:var(--c-primary); }

/* Tabla */
.est-table { width:100%; border-collapse:collapse; }
.est-table thead th {
    font-size:.65rem; font-weight:700; text-transform:uppercase; letter-spacing:.07em;
    color:var(--c-muted); background:var(--c-surface); padding:.65rem .9rem;
    border-bottom:1.5px solid var(--c-border); text-align:left; white-space:nowrap;
}
.est-table tbody td {
    padding:.65rem .9rem; border-bottom:1px solid #f1f5f9;
    font-size:.82rem; vertical-align:middle;
}
.est-table tbody tr:last-child td { border-bottom:none; }
.est-table tbody tr:hover td { background:#f8fbff; }

/* Avatar */
.est-avatar {
    width:34px; height:34px; border-radius:50%;
    display:inline-flex; align-items:center; justify-content:center;
    font-size:.85rem; font-weight:700; flex-shrink:0;
    background:linear-gradient(135deg,#e0f9fb,#b3e8f0); color:var(--c-primary);
}

/* Estado chips */
.estado-chip {
    display:inline-flex; align-items:center; gap:.3rem;
    padding:.22rem .65rem; border-radius:999px;
    font-size:.72rem; font-weight:700; white-space:nowrap;
}
.ec-presente    { background:rgba(16,185,129,.1);  color:#065f46; }
.ec-ausente     { background:rgba(239,68,68,.1);   color:#991b1b; }
.ec-tardanza    { background:rgba(245,158,11,.1);  color:#92400e; }
.ec-justificado { background:rgba(78,199,210,.1);  color:#0e7490; }

.obs-text {
    font-size:.72rem; color:var(--c-muted); max-width:200px;
    white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
}

.det-empty { text-align:center; padding:2.5rem 1rem; color:var(--c-muted); }
.det-empty i { font-size:2rem; color:#cbd5e1; display:block; margin-bottom:.5rem; }

/* Footer acciones */
.det-footer {
    display:flex; justify-content:space-between; align-items:center;
    gap:.75rem; margin-top:1.5rem;
    padding-top:1rem; border-top:1px solid var(--c-border);
    flex-wrap:wrap;
}
.btn-secondary {
    padding:.45rem 1rem; border-radius:8px; font-size:.82rem; font-weight:600;
    border:1.5px solid var(--c-border); background:white; color:var(--c-muted);
    text-decoration:none; display:inline-flex; align-items:center; gap:.4rem;
    transition:border-color .15s;
}
.btn-secondary:hover { border-color:#94a3b8; color:#334155; }
.btn-primary-solid {
    padding:.45rem 1rem; border-radius:8px; font-size:.82rem; font-weight:700;
    background:linear-gradient(135deg,var(--c-teal),var(--c-primary));
    color:white; text-decoration:none;
    display:inline-flex; align-items:center; gap:.4rem; border:none;
    transition:opacity .15s;
}
.btn-primary-solid:hover { opacity:.88; color:white; }

@media(max-width:768px){
    .det-stats { grid-template-columns:repeat(2,1fr); }
    .adm-card-body { padding:1rem; }
    .est-table thead th, .est-table tbody td { padding:.55rem .65rem; }
}
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
                <div class="adm-hero-title">Detalle de Asistencia</div>
                <div class="adm-hero-chips">
                    <span class="hero-chip">
                        <i class="fas fa-calendar-day"></i>
                        {{ \Carbon\Carbon::parse($fecha)->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                    </span>
                    <span class="hero-chip">
                        <i class="fas fa-layer-group"></i>
                        {{ $grado->numero }}&deg; {{ ucfirst($grado->nivel) }} &mdash; Secci&oacute;n {{ $grado->seccion }}
                    </span>
                    <span class="hero-chip">
                        <i class="fas fa-book"></i>
                        {{ $materia->nombre }}
                    </span>
                </div>
            </div>
        </div>
        <a href="{{ route('asistencias.index') }}" class="btn-volver-hero">
            <i class="fas fa-arrow-left" style="font-size:.75rem;"></i> Volver
        </a>
    </div>

    {{-- Card principal --}}
    <div class="adm-card">
        <div class="adm-card-head">
            <i class="fas fa-chart-bar"></i>
            <span>Resumen de la sesi&oacute;n</span>
        </div>
        <div class="adm-card-body">

            @php
                $total     = $asistencias->count();
                $presentes = $asistencias->where('estado','presente')->count();
                $ausentes  = $asistencias->where('estado','ausente')->count();
                $tardanzas = $asistencias->where('estado','tardanza')->count();
                $justif    = $asistencias->where('estado','justificado')->count();
                $pct       = $total > 0 ? round($presentes / $total * 100) : 0;
                $barColor  = $pct >= 80 ? '#10b981' : ($pct >= 60 ? '#f59e0b' : '#ef4444');
            @endphp

            {{-- Stat cards --}}
            <div class="det-stats">
                <div class="det-stat ds-total">
                    <div class="det-stat-icon"><i class="fas fa-users"></i></div>
                    <div class="det-stat-num">{{ $total }}</div>
                    <div class="det-stat-lbl">Total</div>
                </div>
                <div class="det-stat ds-present">
                    <div class="det-stat-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="det-stat-num" style="color:var(--c-green);">{{ $presentes }}</div>
                    <div class="det-stat-lbl">Presentes</div>
                </div>
                <div class="det-stat ds-absent">
                    <div class="det-stat-icon"><i class="fas fa-times-circle"></i></div>
                    <div class="det-stat-num" style="color:var(--c-red);">{{ $ausentes }}</div>
                    <div class="det-stat-lbl">Ausentes</div>
                </div>
                <div class="det-stat ds-late">
                    <div class="det-stat-icon"><i class="fas fa-clock"></i></div>
                    <div class="det-stat-num" style="color:var(--c-amber);">{{ $tardanzas }}</div>
                    <div class="det-stat-lbl">Tardanzas</div>
                </div>
                <div class="det-stat ds-pct">
                    <div class="det-stat-icon"><i class="fas fa-chart-pie"></i></div>
                    <div class="det-stat-num" style="color:{{ $barColor }};">{{ $pct }}%</div>
                    <div class="det-stat-lbl">Asistencia</div>
                </div>
            </div>

            {{-- Barra global --}}
            <div class="global-bar-wrap">
                <div class="global-bar-label">
                    <span><i class="fas fa-chart-bar me-1"></i>Tasa de asistencia del d&iacute;a</span>
                    <span style="color:{{ $barColor }};font-size:.88rem;">{{ $pct }}%</span>
                </div>
                <div class="global-bar-track">
                    <div class="global-bar-fill" style="width:{{ $pct }}%;background:{{ $barColor }};"></div>
                </div>
            </div>

        </div>
    </div>

    {{-- Card tabla --}}
    <div class="adm-card">
        <div class="adm-card-head">
            <i class="fas fa-list-ul"></i>
            <span>Registro de estudiantes</span>
        </div>
        <div class="adm-card-body">

            {{-- Buscador y filtros --}}
            <div class="det-search-wrap">
                <input type="text" class="det-search" id="buscador"
                       placeholder="Buscar por nombre o DNI&hellip;">
                <div class="det-filter-btns">
                    <button type="button" class="fbtn active" data-estado="todos">Todos</button>
                    <button type="button" class="fbtn" data-estado="presente">
                        <i class="fas fa-check-circle me-1" style="color:#10b981;"></i>Presentes
                    </button>
                    <button type="button" class="fbtn" data-estado="ausente">
                        <i class="fas fa-times-circle me-1" style="color:#ef4444;"></i>Ausentes
                    </button>
                    <button type="button" class="fbtn" data-estado="tardanza">
                        <i class="fas fa-clock me-1" style="color:#f59e0b;"></i>Tardanzas
                    </button>
                    @if($justif > 0)
                    <button type="button" class="fbtn" data-estado="justificado">
                        <i class="fas fa-file-alt me-1" style="color:#4ec7d2;"></i>Justificados
                    </button>
                    @endif
                </div>
            </div>

            @if($asistencias->isEmpty())
                <div class="det-empty">
                    <i class="fas fa-user-slash"></i>
                    <p style="font-weight:600;">No hay registros para esta sesi&oacute;n</p>
                </div>
            @else
                <div style="overflow-x:auto;">
                    <table class="est-table" id="tablaEstudiantes">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Estudiante</th>
                                <th>DNI</th>
                                <th>Estado</th>
                                <th>Observaci&oacute;n</th>
                                <th>Hora registro</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asistencias->sortBy('estudiante.apellido1') as $a)
                            @php
                                $est    = $a->estudiante;
                                $nombre = trim(($est->nombre1 ?? '') . ' ' . ($est->apellido1 ?? '') . ' ' . ($est->apellido2 ?? ''));
                                $inicial = strtoupper(substr($est->nombre1 ?? 'E', 0, 1));
                                $claseChip = match($a->estado) {
                                    'presente'    => 'ec-presente',
                                    'ausente'     => 'ec-ausente',
                                    'tardanza'    => 'ec-tardanza',
                                    'justificado' => 'ec-justificado',
                                    default       => 'ec-presente',
                                };
                                $iconChip = match($a->estado) {
                                    'presente'    => 'fa-check-circle',
                                    'ausente'     => 'fa-times-circle',
                                    'tardanza'    => 'fa-clock',
                                    'justificado' => 'fa-file-alt',
                                    default       => 'fa-check-circle',
                                };
                                $labelChip = match($a->estado) {
                                    'presente'    => 'Presente',
                                    'ausente'     => 'Ausente',
                                    'tardanza'    => 'Tardanza',
                                    'justificado' => 'Justificado',
                                    default       => ucfirst($a->estado),
                                };
                            @endphp
                            <tr data-estado="{{ $a->estado }}"
                                data-nombre="{{ strtolower($nombre) }}"
                                data-dni="{{ $est->dni ?? '' }}">
                                <td style="color:var(--c-muted);font-weight:600;">{{ $loop->iteration }}</td>
                                <td>
                                    <div style="display:flex;align-items:center;gap:.65rem;">
                                        <div class="est-avatar">{{ $inicial }}</div>
                                        <div>
                                            <div style="font-weight:700;color:var(--c-text);">{{ $nombre }}</div>
                                            @if($est->seccion ?? false)
                                                <div style="font-size:.7rem;color:var(--c-muted);">Sec. {{ $est->seccion }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td style="color:var(--c-muted);font-size:.78rem;font-family:monospace;">
                                    {{ $est->dni ?? '&mdash;' }}
                                </td>
                                <td>
                                    <span class="estado-chip {{ $claseChip }}">
                                        <i class="fas {{ $iconChip }}"></i>
                                        {{ $labelChip }}
                                    </span>
                                </td>
                                <td>
                                    @if($a->observacion)
                                        <span class="obs-text" title="{{ $a->observacion }}">
                                            {{ $a->observacion }}
                                        </span>
                                    @else
                                        <span style="color:#cbd5e1;font-size:.75rem;">&mdash;</span>
                                    @endif
                                </td>
                                <td style="color:var(--c-muted);font-size:.78rem;">
                                    {{ $a->created_at ? $a->created_at->format('H:i') : '&mdash;' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="margin-top:.85rem;font-size:.78rem;color:var(--c-muted);"
                     id="contadorVisible">
                    Mostrando {{ $asistencias->count() }} registros
                </div>
            @endif

            {{-- Footer --}}
            <div class="det-footer">
                <a href="{{ route('asistencias.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver al listado
                </a>
                {{--
                    La ruta asistencias.show usa query params: ?grado_id=&materia_id=&fecha=
                    Para editar esta sesion pasamos los mismos params al formulario de create.
                --}}
                <a href="{{ route('asistencias.create', ['grado_id' => $grado->id, 'materia_id' => $materia->id, 'fecha' => $fecha]) }}"
                   class="btn-primary-solid">
                    <i class="fas fa-edit"></i> Editar esta sesi&oacute;n
                </a>
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    const tabla    = document.getElementById('tablaEstudiantes');
    const buscador = document.getElementById('buscador');
    const contador = document.getElementById('contadorVisible');
    const fbtns    = document.querySelectorAll('.fbtn');
    let   filtroEstado = 'todos';

    function filtrar() {
        if (!tabla) return;
        const q    = (buscador?.value ?? '').toLowerCase().trim();
        const rows = tabla.querySelectorAll('tbody tr');
        let   visible = 0;

        rows.forEach(function (row) {
            const matchEstado = filtroEstado === 'todos' || row.dataset.estado === filtroEstado;
            const matchBusq   = !q || (row.dataset.nombre ?? '').includes(q) || (row.dataset.dni ?? '').includes(q);
            const mostrar     = matchEstado && matchBusq;
            row.style.display = mostrar ? '' : 'none';
            if (mostrar) visible++;
        });

        if (contador) {
            contador.textContent = 'Mostrando ' + visible + ' registro' + (visible !== 1 ? 's' : '');
        }
    }

    fbtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            fbtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            filtroEstado = btn.dataset.estado;
            filtrar();
        });
    });

    buscador?.addEventListener('input', filtrar);
})();
</script>
@endpush