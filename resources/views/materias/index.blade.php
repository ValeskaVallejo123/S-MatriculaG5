@extends('layouts.app')

@section('title', 'Materias')
@section('page-title', 'Materias')
@section('content-class', 'p-0')

@push('styles')
<style>
/* ── Layout ── */
.mat-wrap {
    height: calc(100vh - 64px);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    background: #f0f4f8;
}

/* ── Hero ── */
.mat-hero {
    background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #4ec7d2 100%);
    padding: 1.2rem 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-shrink: 0;
}
.mat-hero-left { display: flex; align-items: center; gap: 1rem; }
.mat-hero-icon {
    width: 48px; height: 48px; border-radius: 12px;
    background: rgba(255,255,255,.15);
    border: 2px solid rgba(255,255,255,.3);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.mat-hero-icon i { font-size: 1.3rem; color: white; }
.mat-hero-title { font-size: 1.2rem; font-weight: 700; color: white; margin: 0 0 .15rem; }
.mat-hero-sub   { color: rgba(255,255,255,.7); font-size: .8rem; margin: 0; }

.mat-stat {
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.25);
    border-radius: 10px;
    padding: .4rem .9rem;
    text-align: center;
    min-width: 80px;
}
.mat-stat-num { font-size: 1.15rem; font-weight: 700; color: white; line-height: 1; }
.mat-stat-lbl { font-size: .65rem; color: rgba(255,255,255,.65); margin-top: .1rem; text-transform: uppercase; letter-spacing: .04em; }

.mat-btn-new {
    display: inline-flex; align-items: center; gap: .45rem;
    background: rgba(255,255,255,.18); border: 1.5px solid rgba(255,255,255,.4);
    color: white; padding: .45rem 1.1rem; border-radius: 8px;
    font-size: .82rem; font-weight: 700; text-decoration: none;
    transition: all .2s; white-space: nowrap;
}
.mat-btn-new:hover { background: rgba(255,255,255,.28); color: white; text-decoration: none; }

/* ── Toolbar ── */
.mat-toolbar {
    background: white;
    border-bottom: 1px solid #e8eef5;
    padding: .8rem 2rem;
    display: flex;
    align-items: center;
    gap: .75rem;
    flex-shrink: 0;
    flex-wrap: wrap;
}
.mat-search-wrap { position: relative; flex: 1; min-width: 200px; max-width: 400px; }
.mat-search-wrap i {
    position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
    color: #94a3b8; font-size: .8rem; pointer-events: none;
}
.mat-search {
    width: 100%; padding: .45rem 1rem .45rem 2.3rem;
    border: 1.5px solid #e2e8f0; border-radius: 8px;
    font-size: .85rem; background: #f8fafc;
    transition: border-color .2s, box-shadow .2s;
}
.mat-search:focus {
    border-color: #4ec7d2;
    box-shadow: 0 0 0 3px rgba(78,199,210,.12);
    outline: none; background: white;
}
.mat-select {
    padding: .45rem .85rem; border: 1.5px solid #e2e8f0;
    border-radius: 8px; font-size: .82rem; background: #f8fafc;
    color: #003b73; cursor: pointer; transition: border-color .2s;
}
.mat-select:focus { border-color: #4ec7d2; outline: none; }

/* ── Tabs ── */
.mat-tabs {
    display: flex; gap: .3rem;
    border-bottom: 2px solid #e8eef5;
    padding: 0 2rem;
    background: white;
    flex-shrink: 0;
}
.mat-tab {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .55rem 1rem; border-radius: 8px 8px 0 0;
    font-size: .78rem; font-weight: 700; color: #6b7a90;
    background: #f5f8fc; border: 1px solid #e8eef5;
    border-bottom: none; cursor: pointer;
    transition: all .18s; margin-bottom: -2px;
    white-space: nowrap;
}
.mat-tab.active, .mat-tab:hover {
    background: white; color: #00508f;
    border-color: rgba(78,199,210,.5);
    border-bottom: 2px solid white;
}
.mat-tab i { color: #4ec7d2; }
.mat-tab .cnt {
    background: #4ec7d2; color: white;
    font-size: .62rem; font-weight: 800;
    padding: .08rem .4rem; border-radius: 999px;
}
.mat-tab.active .cnt { background: #00508f; }

/* ── Body (scrollable) ── */
.mat-body { flex: 1; overflow-y: auto; padding: 1.5rem 2rem; }

/* ── Panels ── */
.mat-panel { display: none; }
.mat-panel.active { display: block; }

/* ── Table card ── */
.mat-card {
    background: white; border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,59,115,.08);
    overflow: hidden;
}
.mat-tbl { width: 100%; border-collapse: collapse; }
.mat-tbl thead th {
    background: #003b73; color: white;
    padding: .72rem 1rem;
    font-size: .68rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .07em;
    border: none; white-space: nowrap;
}
.mat-tbl thead th.tc { text-align: center; }
.mat-tbl tbody td {
    padding: .7rem 1rem; border-bottom: 1px solid #f1f5f9;
    font-size: .84rem; color: #1e293b; vertical-align: middle;
}
.mat-tbl tbody td.tc { text-align: center; }
.mat-tbl tbody tr:last-child td { border-bottom: none; }
.mat-tbl tbody tr:hover td { background: rgba(78,199,210,.04); }

/* Code badge */
.mat-code {
    font-family: 'Courier New', monospace;
    background: rgba(78,199,210,.1);
    color: #00508f;
    border: 1px solid rgba(78,199,210,.35);
    padding: .18rem .55rem; border-radius: 6px;
    font-size: .72rem; font-weight: 700;
}

/* Area badges */
.mat-area {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .22rem .65rem; border-radius: 999px;
    font-size: .7rem; font-weight: 700;
}
.area-mat  { background: #fff7ed; color: #c2410c; }
.area-esp  { background: #fdf4ff; color: #7e22ce; }
.area-cien { background: #ecfdf5; color: #065f46; }
.area-soc  { background: #eff6ff; color: #1e40af; }
.area-ef   { background: #fef9c3; color: #854d0e; }
.area-art  { background: #fce7f3; color: #9d174d; }
.area-ing  { background: #f0fdfa; color: #134e4a; }
.area-inf  { background: #f5f3ff; color: #4c1d95; }
.area-oth  { background: #f8fafc; color: #475569; }

/* Level badges */
.mat-nivel {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .22rem .65rem; border-radius: 7px;
    font-size: .7rem; font-weight: 700;
}
.niv-pri { background: #e0f7fa; color: #006064; }
.niv-sec { background: #e8eaf6; color: #283593; }

/* Status badges */
.mat-estado {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .22rem .65rem; border-radius: 999px;
    font-size: .7rem; font-weight: 700;
}
.est-on  { background: rgba(78,199,210,.12); color: #00508f; border: 1px solid rgba(78,199,210,.4); }
.est-off { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

/* Action buttons */
.act-btn {
    display: inline-flex; align-items: center; justify-content: center;
    width: 30px; height: 30px; border-radius: 7px;
    border: none; cursor: pointer; font-size: .75rem;
    text-decoration: none; transition: all .15s;
}
.act-btn:hover { transform: translateY(-1px); }
.act-view { background: #e8f8f9; color: #00508f; }
.act-view:hover { background: #4ec7d2; color: white; }
.act-edit { background: #eff6ff; color: #3b82f6; }
.act-edit:hover { background: #3b82f6; color: white; }
.act-del  { background: #fef2f2; color: #ef4444; }
.act-del:hover  { background: #ef4444; color: white; }

/* Empty state */
.mat-empty { padding: 3.5rem 1rem; text-align: center; }
.mat-empty i { font-size: 2.2rem; color: rgba(78,199,210,.35); display: block; margin-bottom: .75rem; }
.mat-empty p { font-size: .85rem; color: #94a3b8; margin: .25rem 0 0; }

/* Pagination */
.mat-pag {
    padding: .75rem 1.25rem; border-top: 1px solid #f1f5f9;
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: .5rem;
}
.pagination { margin: 0; }
.pagination .page-link {
    border-radius: 6px; margin: 0 2px; border: 1px solid #e2e8f0;
    color: #00508f; font-size: .82rem; padding: .3rem .65rem; transition: all .2s;
}
.pagination .page-link:hover { background: #bfd9ea; border-color: #4ec7d2; }
.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    border-color: #4ec7d2; color: white;
}

/* Dark mode */
body.dark-mode .mat-wrap       { background: #0f172a; }
body.dark-mode .mat-toolbar    { background: #1e293b; border-color: #334155; }
body.dark-mode .mat-tabs       { background: #1e293b; border-color: #334155; }
body.dark-mode .mat-tab        { background: #0f172a; color: #94a3b8; border-color: #334155; }
body.dark-mode .mat-tab.active { background: #1e293b; color: #4ec7d2; }
body.dark-mode .mat-search     { background: #0f172a; border-color: #334155; color: #e2e8f0; }
body.dark-mode .mat-select     { background: #0f172a; border-color: #334155; color: #e2e8f0; }
body.dark-mode .mat-card       { background: #1e293b; }
body.dark-mode .mat-tbl tbody td { color: #cbd5e1; border-color: #334155; }
body.dark-mode .mat-tbl tbody tr:hover td { background: rgba(78,199,210,.06); }
body.dark-mode .mat-pag        { border-color: #334155; }
</style>
@endpush

@section('content')

@php
    $total      = $materias->total();
    $activas    = $materias->getCollection()->where('activo', true)->count();
    $primaria   = $materias->getCollection()->where('nivel', 'primaria')->count();
    $secundaria = $materias->getCollection()->where('nivel', 'secundaria')->count();

    function areaClass($area) {
        return match(true) {
            str_contains($area, 'Matemát')                               => 'area-mat',
            str_contains($area, 'Español') || str_contains($area, 'Lengua') => 'area-esp',
            str_contains($area, 'Ciencias N')                            => 'area-cien',
            str_contains($area, 'Sociales') || str_contains($area, 'Cívica') => 'area-soc',
            str_contains($area, 'Física')                                => 'area-ef',
            str_contains($area, 'Artística') || str_contains($area, 'Arte')  => 'area-art',
            str_contains($area, 'Inglés')                                => 'area-ing',
            str_contains($area, 'Inform')                                => 'area-inf',
            default                                                      => 'area-oth',
        };
    }
@endphp

<div class="mat-wrap">

    {{-- Hero --}}
    <div class="mat-hero">
        <div class="mat-hero-left">
            <div class="mat-hero-icon"><i class="fas fa-book-open"></i></div>
            <div>
                <h2 class="mat-hero-title">Plan de Estudios</h2>
                <p class="mat-hero-sub">Gestión de asignaturas por nivel educativo</p>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <div class="mat-stat">
                <div class="mat-stat-num">{{ $total }}</div>
                <div class="mat-stat-lbl">Total</div>
            </div>
            <div class="mat-stat">
                <div class="mat-stat-num">{{ $activas }}</div>
                <div class="mat-stat-lbl">Activas</div>
            </div>
            <div class="mat-stat">
                <div class="mat-stat-num">{{ $primaria }}</div>
                <div class="mat-stat-lbl">Primaria</div>
            </div>
            <div class="mat-stat">
                <div class="mat-stat-num">{{ $secundaria }}</div>
                <div class="mat-stat-lbl">Secundaria</div>
            </div>
            <a href="{{ route('materias.create') }}" class="mat-btn-new ms-2">
                <i class="fas fa-plus"></i> Nueva Materia
            </a>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="mat-toolbar">
        <div class="mat-search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="matSearch" class="mat-search" placeholder="Buscar por nombre, código o área…">
        </div>
        <select id="matFiltroNivel" class="mat-select">
            <option value="">Todos los niveles</option>
            <option value="primaria">Primaria</option>
            <option value="secundaria">Secundaria</option>
        </select>
        <select id="matFiltroEstado" class="mat-select">
            <option value="">Todos los estados</option>
            <option value="1">Activas</option>
            <option value="0">Inactivas</option>
        </select>
        <small class="text-muted ms-auto" id="matCount"></small>
    </div>

    {{-- Tabs --}}
    <div class="mat-tabs">
        <button class="mat-tab active" data-tab="todas">
            <i class="fas fa-list"></i> Todas
            <span class="cnt" id="cnt-todas">{{ $total }}</span>
        </button>
        <button class="mat-tab" data-tab="primaria">
            <i class="fas fa-child"></i> Primaria
            <span class="cnt" id="cnt-primaria">{{ $primaria }}</span>
        </button>
        <button class="mat-tab" data-tab="secundaria">
            <i class="fas fa-user-graduate"></i> Secundaria
            <span class="cnt" id="cnt-secundaria">{{ $secundaria }}</span>
        </button>
    </div>

    {{-- Body scrollable --}}
    <div class="mat-body">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3 border-0 shadow-sm"
                 style="border-radius:10px;border-left:4px solid #4ec7d2 !important;">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Panel: TODAS --}}
        <div class="mat-panel active" id="panel-todas">
            <div class="mat-card">
                <div class="table-responsive">
                    <table class="mat-tbl" id="tbl-todas">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Materia</th>
                                <th>Área</th>
                                <th class="tc">Nivel</th>
                                <th class="tc">Estado</th>
                                <th class="tc">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($materias as $m)
                            <tr data-nivel="{{ $m->nivel }}"
                                data-activo="{{ $m->activo ? '1' : '0' }}"
                                data-search="{{ strtolower($m->nombre . ' ' . $m->codigo . ' ' . $m->area) }}">
                                <td><span class="mat-code">{{ $m->codigo }}</span></td>
                                <td>
                                    <div class="fw-semibold" style="color:#003b73;font-size:.87rem;">{{ $m->nombre }}</div>
                                    @if($m->descripcion)
                                        <div style="font-size:.73rem;color:#94a3b8;margin-top:.1rem;">{{ Str::limit($m->descripcion, 60) }}</div>
                                    @endif
                                </td>
                                <td>
                                    <span class="mat-area {{ areaClass($m->area) }}">{{ $m->area }}</span>
                                </td>
                                <td class="tc">
                                    @if($m->nivel === 'primaria')
                                        <span class="mat-nivel niv-pri"><i class="fas fa-child"></i> Primaria</span>
                                    @else
                                        <span class="mat-nivel niv-sec"><i class="fas fa-user-graduate"></i> Secundaria</span>
                                    @endif
                                </td>
                                <td class="tc">
                                    @if($m->activo)
                                        <span class="mat-estado est-on">
                                            <i class="fas fa-circle" style="font-size:.4rem;vertical-align:middle;"></i> Activa
                                        </span>
                                    @else
                                        <span class="mat-estado est-off">
                                            <i class="fas fa-circle" style="font-size:.4rem;vertical-align:middle;"></i> Inactiva
                                        </span>
                                    @endif
                                </td>
                                <td class="tc">
                                    <div style="display:inline-flex;gap:.3rem;">
                                        <a href="{{ route('materias.show', $m) }}" class="act-btn act-view" title="Ver"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('materias.edit', $m) }}" class="act-btn act-edit" title="Editar"><i class="fas fa-edit"></i></a>
                                        <button type="button" class="act-btn act-del"
                                                data-route="{{ route('materias.destroy', $m) }}"
                                                data-name="{{ $m->nombre }}"
                                                data-message="¿Estás seguro de eliminar la materia {{ $m->nombre }}?"
                                                onclick="mostrarModalDeleteData(this)" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">
                                    <div class="mat-empty">
                                        <i class="fas fa-book-open"></i>
                                        <strong style="color:#003b73;">No hay materias registradas</strong>
                                        <p>Agrega la primera materia con el botón "Nueva Materia"</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($materias->hasPages())
                <div class="mat-pag">
                    <small class="text-muted">
                        {{ $materias->firstItem() }}–{{ $materias->lastItem() }} de {{ $materias->total() }} registros
                    </small>
                    {{ $materias->links() }}
                </div>
                @endif
            </div>
        </div>

        {{-- Panel: PRIMARIA --}}
        <div class="mat-panel" id="panel-primaria">
            <div class="mat-card">
                <div class="table-responsive">
                    <table class="mat-tbl">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Materia</th>
                                <th>Área</th>
                                <th class="tc">Estado</th>
                                <th class="tc">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($materias->getCollection()->where('nivel', 'primaria') as $m)
                            <tr>
                                <td><span class="mat-code">{{ $m->codigo }}</span></td>
                                <td>
                                    <div class="fw-semibold" style="color:#003b73;font-size:.87rem;">{{ $m->nombre }}</div>
                                    @if($m->descripcion)<div style="font-size:.73rem;color:#94a3b8;margin-top:.1rem;">{{ Str::limit($m->descripcion, 60) }}</div>@endif
                                </td>
                                <td><span class="mat-area {{ areaClass($m->area) }}">{{ $m->area }}</span></td>
                                <td class="tc">
                                    @if($m->activo)
                                        <span class="mat-estado est-on"><i class="fas fa-circle" style="font-size:.4rem;vertical-align:middle;"></i> Activa</span>
                                    @else
                                        <span class="mat-estado est-off"><i class="fas fa-circle" style="font-size:.4rem;vertical-align:middle;"></i> Inactiva</span>
                                    @endif
                                </td>
                                <td class="tc">
                                    <div style="display:inline-flex;gap:.3rem;">
                                        <a href="{{ route('materias.show', $m) }}" class="act-btn act-view" title="Ver"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('materias.edit', $m) }}" class="act-btn act-edit" title="Editar"><i class="fas fa-edit"></i></a>
                                        <button type="button" class="act-btn act-del"
                                                data-route="{{ route('materias.destroy', $m) }}"
                                                data-name="{{ $m->nombre }}"
                                                data-message="¿Estás seguro de eliminar la materia {{ $m->nombre }}?"
                                                onclick="mostrarModalDeleteData(this)" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">
                                    <div class="mat-empty">
                                        <i class="fas fa-child"></i>
                                        <strong style="color:#003b73;">No hay materias de Primaria</strong>
                                        <p>Aún no se han registrado materias para este nivel</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Panel: SECUNDARIA --}}
        <div class="mat-panel" id="panel-secundaria">
            <div class="mat-card">
                <div class="table-responsive">
                    <table class="mat-tbl">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Materia</th>
                                <th>Área</th>
                                <th class="tc">Estado</th>
                                <th class="tc">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($materias->getCollection()->where('nivel', 'secundaria') as $m)
                            <tr>
                                <td><span class="mat-code">{{ $m->codigo }}</span></td>
                                <td>
                                    <div class="fw-semibold" style="color:#003b73;font-size:.87rem;">{{ $m->nombre }}</div>
                                    @if($m->descripcion)<div style="font-size:.73rem;color:#94a3b8;margin-top:.1rem;">{{ Str::limit($m->descripcion, 60) }}</div>@endif
                                </td>
                                <td><span class="mat-area {{ areaClass($m->area) }}">{{ $m->area }}</span></td>
                                <td class="tc">
                                    @if($m->activo)
                                        <span class="mat-estado est-on"><i class="fas fa-circle" style="font-size:.4rem;vertical-align:middle;"></i> Activa</span>
                                    @else
                                        <span class="mat-estado est-off"><i class="fas fa-circle" style="font-size:.4rem;vertical-align:middle;"></i> Inactiva</span>
                                    @endif
                                </td>
                                <td class="tc">
                                    <div style="display:inline-flex;gap:.3rem;">
                                        <a href="{{ route('materias.show', $m) }}" class="act-btn act-view" title="Ver"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('materias.edit', $m) }}" class="act-btn act-edit" title="Editar"><i class="fas fa-edit"></i></a>
                                        <button type="button" class="act-btn act-del"
                                                data-route="{{ route('materias.destroy', $m) }}"
                                                data-name="{{ $m->nombre }}"
                                                data-message="¿Estás seguro de eliminar la materia {{ $m->nombre }}?"
                                                onclick="mostrarModalDeleteData(this)" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">
                                    <div class="mat-empty">
                                        <i class="fas fa-user-graduate"></i>
                                        <strong style="color:#003b73;">No hay materias de Secundaria</strong>
                                        <p>Aún no se han registrado materias para este nivel</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>{{-- /mat-body --}}
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Tabs
    document.querySelectorAll('.mat-tab').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.mat-tab').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.mat-panel').forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('panel-' + this.dataset.tab).classList.add('active');
        });
    });

    // Filtros en la tabla "todas"
    const search      = document.getElementById('matSearch');
    const filtroNivel = document.getElementById('matFiltroNivel');
    const filtroEst   = document.getElementById('matFiltroEstado');
    const counter     = document.getElementById('matCount');
    const rows        = document.querySelectorAll('#tbl-todas tbody tr[data-search]');

    function filtrar() {
        const q     = search.value.toLowerCase();
        const nivel = filtroNivel.value;
        const est   = filtroEst.value;
        let vis = { todas: 0, primaria: 0, secundaria: 0 };

        rows.forEach(row => {
            const show = row.dataset.search.includes(q)
                      && (!nivel || row.dataset.nivel === nivel)
                      && (!est   || row.dataset.activo === est);
            row.style.display = show ? '' : 'none';
            if (show) { vis.todas++; vis[row.dataset.nivel]++; }
        });

        document.getElementById('cnt-todas').textContent      = vis.todas;
        document.getElementById('cnt-primaria').textContent   = vis.primaria;
        document.getElementById('cnt-secundaria').textContent = vis.secundaria;
        counter.textContent = q || nivel || est ? `${vis.todas} resultado${vis.todas !== 1 ? 's' : ''}` : '';
    }

    search.addEventListener('input', filtrar);
    filtroNivel.addEventListener('change', filtrar);
    filtroEst.addEventListener('change', filtrar);
});
</script>
@endpush
@endsection
