@extends('layouts.app')

@section('title', 'Materias')
@section('page-title', '')

@push('styles')
<style>
:root {
    --blue:     #00508f;
    --blue-mid: #003b73;
    --teal:     #4ec7d2;
    --border:   #e8edf4;
    --muted:    #6b7a90;
    --r:        14px;
}
.mi-wrap { width: 100%; box-sizing: border-box; }

/* HEADER COMPACTO */
.mi-header {
    border-radius: var(--r) var(--r) 0 0;
    background: linear-gradient(135deg, #002d5a 0%, #00508f 55%, #0077b6 100%);
    padding: 1.2rem 1.7rem; position: relative; overflow: hidden;
}
.mi-header::before {
    content:''; position:absolute; right:-50px; top:-50px;
    width:160px; height:160px; border-radius:50%;
    background:rgba(78,199,210,.13); pointer-events:none;
}
.mi-header-inner {
    position:relative; z-index:1;
    display:flex; align-items:center; justify-content:space-between;
    flex-wrap:wrap; gap:.85rem;
}
.mi-header-left { display:flex; align-items:center; gap:1rem; flex-wrap:wrap; }
.mi-avatar {
    width:52px; height:52px; border-radius:12px;
    border:2px solid rgba(78,199,210,.6);
    background:rgba(255,255,255,.12);
    display:flex; align-items:center; justify-content:center;
    box-shadow:0 4px 14px rgba(0,0,0,.2); flex-shrink:0;
}
.mi-avatar i { color:white; font-size:1.3rem; }
.mi-header h2 {
    font-size:1.15rem; font-weight:800; color:white;
    margin:0 0 .3rem; text-shadow:0 1px 4px rgba(0,0,0,.2);
}
.mi-stats { display:flex; gap:.5rem; flex-wrap:wrap; }
.mi-stat {
    background:rgba(255,255,255,.13); border:1px solid rgba(255,255,255,.2);
    border-radius:7px; padding:.25rem .7rem;
    display:inline-flex; align-items:center; gap:.35rem;
}
.mi-stat i { color:var(--teal); font-size:.72rem; }
.mi-stat-num { font-size:.95rem; font-weight:800; color:white; line-height:1; }
.mi-stat-lbl { font-size:.58rem; color:rgba(255,255,255,.65); font-weight:700; text-transform:uppercase; letter-spacing:.04em; }
.mi-btn-nuevo {
    display:inline-flex; align-items:center; gap:.4rem;
    background:rgba(255,255,255,.15); border:1px solid rgba(255,255,255,.35);
    color:white; padding:.42rem 1rem; border-radius:8px;
    font-size:.78rem; font-weight:700; text-decoration:none;
    transition:all .2s; white-space:nowrap;
}
.mi-btn-nuevo:hover { background:rgba(255,255,255,.25); color:white; text-decoration:none; }

/* BODY */
.mi-body {
    background:white; border:1px solid var(--border); border-top:none;
    border-radius:0 0 var(--r) var(--r);
    box-shadow:0 4px 16px rgba(0,59,115,.10);
    padding:1.4rem 1.7rem; margin-bottom:1.3rem;
}

/* FILTERS */
.mi-filters {
    display:flex; align-items:center; gap:.65rem;
    flex-wrap:wrap; margin-bottom:1.1rem;
}
.mi-search-wrap { position:relative; flex:1; min-width:200px; }
.mi-search {
    width:100%; padding:.52rem 1rem .52rem 2.3rem;
    border:1px solid var(--border); border-radius:8px;
    font-size:.82rem; color:var(--blue-mid);
    background:#f9fbfd; outline:none;
    transition:border-color .2s, box-shadow .2s;
}
.mi-search:focus {
    border-color:rgba(78,199,210,.5);
    box-shadow:0 0 0 3px rgba(78,199,210,.1); background:white;
}
.mi-search-icon {
    position:absolute; left:.8rem; top:50%; transform:translateY(-50%);
    color:var(--muted); font-size:.75rem; pointer-events:none;
}
.mi-select {
    padding:.52rem .85rem; border:1px solid var(--border);
    border-radius:8px; font-size:.8rem; color:var(--blue-mid);
    background:#f9fbfd; outline:none; cursor:pointer;
    transition:border-color .2s;
}
.mi-select:focus { border-color:rgba(78,199,210,.5); }

/* TABS */
.mi-tabs {
    display:flex; gap:.35rem; margin-bottom:0;
    border-bottom:2px solid var(--border);
}
.mi-tab {
    display:inline-flex; align-items:center; gap:.35rem;
    padding:.55rem 1.1rem; border-radius:8px 8px 0 0;
    font-size:.78rem; font-weight:700; color:var(--muted);
    background:#f5f8fc; border:1px solid var(--border);
    border-bottom:none; cursor:pointer;
    transition:all .18s; margin-bottom:-2px;
}
.mi-tab.active, .mi-tab:hover {
    background:white; color:var(--blue);
    border-color:rgba(78,199,210,.5);
    border-bottom:2px solid white;
}
.mi-tab i { color:var(--teal); }
.mi-tab .cnt {
    background:var(--teal); color:white;
    font-size:.62rem; font-weight:800;
    padding:.1rem .42rem; border-radius:999px;
}
.mi-tab.active .cnt { background:var(--blue); }

/* PANEL */
.mi-panel { display:none; }
.mi-panel.active { display:block; }

/* TABLE CARD */
.mi-card {
    background:white; border:1px solid var(--border);
    border-radius:0 0 12px 12px; overflow:hidden;
}

/* TABLE */
.mi-tbl { width:100%; border-collapse:collapse; }
.mi-tbl thead th {
    background:#f5f8fc; padding:.62rem .9rem;
    font-size:.63rem; font-weight:700; letter-spacing:.08em;
    text-transform:uppercase; color:var(--muted);
    border-bottom:2px solid var(--border);
    text-align:left; white-space:nowrap;
}
.mi-tbl thead th.tc { text-align:center; }
.mi-tbl tbody td {
    padding:.65rem .9rem; border-bottom:1px solid var(--border);
    font-size:.82rem; color:var(--blue-mid); vertical-align:middle;
}
.mi-tbl tbody td.tc { text-align:center; }
.mi-tbl tbody tr:last-child td { border-bottom:none; }
.mi-tbl tbody tr:hover td { background:#f5f9ff; }

.mi-code {
    font-family:'Courier New',monospace;
    background:rgba(78,199,210,.1); color:var(--blue);
    border:1px solid rgba(78,199,210,.3);
    padding:.18rem .5rem; border-radius:5px;
    font-size:.73rem; font-weight:700; display:inline-block;
}
.mi-nombre { font-weight:700; color:var(--blue-mid); font-size:.84rem; }
.mi-desc   { font-size:.72rem; color:var(--muted); margin-top:.1rem; }

.mi-area {
    display:inline-flex; align-items:center; gap:.3rem;
    padding:.2rem .6rem; border-radius:999px;
    font-size:.68rem; font-weight:700;
}
.area-mat  { background:#fff7ed; color:#c2410c; }
.area-esp  { background:#fdf4ff; color:#7e22ce; }
.area-cien { background:#ecfdf5; color:#065f46; }
.area-soc  { background:#eff6ff; color:#1e40af; }
.area-ef   { background:#fef9c3; color:#854d0e; }
.area-art  { background:#fce7f3; color:#9d174d; }
.area-ing  { background:#f0fdfa; color:#134e4a; }
.area-inf  { background:#f5f3ff; color:#4c1d95; }
.area-oth  { background:#f8fafc; color:#475569; }

.mi-nivel {
    display:inline-flex; align-items:center; gap:.3rem;
    padding:.2rem .6rem; border-radius:6px;
    font-size:.7rem; font-weight:700;
}
.niv-pri { background:#e0f7fa; color:#006064; }
.niv-sec { background:#e8eaf6; color:#283593; }

.mi-estado {
    display:inline-flex; align-items:center; gap:.3rem;
    padding:.2rem .6rem; border-radius:999px;
    font-size:.68rem; font-weight:700;
}
.est-on  { background:#ecfdf5; color:#059669; }
.est-off { background:#fef2f2; color:#dc2626; }

/* ACTION BUTTONS */
.act-btn {
    display:inline-flex; align-items:center; justify-content:center;
    width:28px; height:28px; border-radius:7px;
    border:none; cursor:pointer; font-size:.72rem;
    text-decoration:none; transition:all .15s;
}
.act-btn:hover { transform:translateY(-1px); }
.act-view { background:#e8f8f9; color:var(--blue); }
.act-view:hover { background:var(--teal); color:white; }
.act-edit { background:#eff6ff; color:#3b82f6; }
.act-edit:hover { background:#3b82f6; color:white; }
.act-del  { background:#fef2f2; color:#ef4444; }
.act-del:hover  { background:#ef4444; color:white; }

/* EMPTY */
.mi-empty { padding:3.5rem 1rem; text-align:center; color:var(--muted); }
.mi-empty i { font-size:2.5rem; display:block; margin-bottom:.75rem; color:rgba(78,199,210,.3); }
.mi-empty p { font-size:.85rem; margin:.25rem 0 0; }

/* FOOTER */
.mi-footer {
    padding:.75rem 1rem; border-top:1px solid var(--border);
    display:flex; align-items:center; justify-content:space-between;
    background:#f9fbfd; flex-wrap:wrap; gap:.5rem;
}
.mi-footer-info { font-size:.75rem; color:var(--muted); }

@media(max-width:640px) {
    .mi-header { padding:1.4rem 1.1rem; }
    .mi-body   { padding:1rem 1.1rem; }
    .mi-avatar { width:60px; height:60px; }
    .mi-avatar i { font-size:1.5rem; }
    .mi-header h2 { font-size:1.1rem; }
    .mi-tabs { overflow-x:auto; }
    .mi-tab  { white-space:nowrap; }
}
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
            str_contains($area, 'Matemát') => 'area-mat',
            str_contains($area, 'Español') || str_contains($area, 'Lengua') => 'area-esp',
            str_contains($area, 'Ciencias N') => 'area-cien',
            str_contains($area, 'Sociales') || str_contains($area, 'Cívica') => 'area-soc',
            str_contains($area, 'Física') => 'area-ef',
            str_contains($area, 'Artística') || str_contains($area, 'Arte') => 'area-art',
            str_contains($area, 'Inglés') => 'area-ing',
            str_contains($area, 'Inform') => 'area-inf',
            default => 'area-oth',
        };
    }
@endphp

<div class="container-fluid px-4">
<div class="mi-wrap">

    {{-- HEADER --}}
    <div class="mi-header">
        <div class="mi-header-inner">
            <div class="mi-header-left">
                <div class="mi-avatar"><i class="fas fa-book-open"></i></div>
                <div>
                    <h2>Plan de Estudios</h2>
                </div>
            </div>
            <a href="{{ route('materias.create') }}" class="mi-btn-nuevo">
                <i class="fas fa-plus"></i> Nueva Materia
            </a>
        </div>
    </div>

    {{-- BODY --}}
    <div class="mi-body">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4"
                 style="border-radius:10px; border-left:4px solid #10b981; font-size:.83rem;">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Filtros --}}
        <div class="mi-filters">
            <div class="mi-search-wrap">
                <i class="fas fa-search mi-search-icon"></i>
                <input type="text" id="matSearch" class="mi-search" placeholder="Buscar por nombre, código o área...">
            </div>
            <select id="matFiltroNivel" class="mi-select">
                <option value="">Todos los niveles</option>
                <option value="primaria">Primaria</option>
                <option value="secundaria">Secundaria</option>
            </select>
            <select id="matFiltroEstado" class="mi-select">
                <option value="">Todos los estados</option>
                <option value="1">Activas</option>
                <option value="0">Inactivas</option>
            </select>
        </div>

        {{-- Tabs --}}
        <div class="mi-tabs">
            <button class="mi-tab active" data-tab="todas">
                <i class="fas fa-list"></i> Todas
                <span class="cnt" id="cnt-todas">{{ $total }}</span>
            </button>
            <button class="mi-tab" data-tab="primaria">
                <i class="fas fa-child"></i> Primaria
                <span class="cnt" id="cnt-primaria">{{ $primaria }}</span>
            </button>
            <button class="mi-tab" data-tab="secundaria">
                <i class="fas fa-user-graduate"></i> Secundaria
                <span class="cnt" id="cnt-secundaria">{{ $secundaria }}</span>
            </button>
        </div>

        {{-- Panel: TODAS --}}
        <div class="mi-panel active" id="panel-todas">
            <div class="mi-card">
                <div style="overflow-x:auto;">
                    <table class="mi-tbl" id="tbl-todas">
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
                            <tr data-nivel="{{ $m->nivel }}" data-activo="{{ $m->activo ? '1' : '0' }}"
                                data-search="{{ strtolower($m->nombre . ' ' . $m->codigo . ' ' . $m->area) }}">
                                <td><span class="mi-code">{{ $m->codigo }}</span></td>
                                <td>
                                    <div class="mi-nombre">{{ $m->nombre }}</div>
                                    @if($m->descripcion)
                                        <div class="mi-desc">{{ Str::limit($m->descripcion, 55) }}</div>
                                    @endif
                                </td>
                                <td>
                                    <span class="mi-area {{ areaClass($m->area) }}">{{ $m->area }}</span>
                                </td>
                                <td class="tc">
                                    @if($m->nivel === 'primaria')
                                        <span class="mi-nivel niv-pri"><i class="fas fa-child"></i> Primaria</span>
                                    @else
                                        <span class="mi-nivel niv-sec"><i class="fas fa-user-graduate"></i> Secundaria</span>
                                    @endif
                                </td>
                                <td class="tc">
                                    @if($m->activo)
                                        <span class="mi-estado est-on"><i class="fas fa-circle" style="font-size:.4rem;vertical-align:middle;"></i> Activa</span>
                                    @else
                                        <span class="mi-estado est-off"><i class="fas fa-circle" style="font-size:.4rem;vertical-align:middle;"></i> Inactiva</span>
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
                                    <div class="mi-empty">
                                        <i class="fas fa-book-open"></i>
                                        <p>No hay materias registradas</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($materias->hasPages())
                <div class="mi-footer">
                    <span class="mi-footer-info">
                        Mostrando {{ $materias->firstItem() }}–{{ $materias->lastItem() }} de {{ $materias->total() }}
                    </span>
                    {{ $materias->links() }}
                </div>
                @endif
            </div>
        </div>

        {{-- Panel: PRIMARIA --}}
        <div class="mi-panel" id="panel-primaria">
            <div class="mi-card">
                <div style="overflow-x:auto;">
                    <table class="mi-tbl">
                        <thead>
                            <tr>
                                <th>Código</th><th>Materia</th><th>Área</th>
                                <th class="tc">Estado</th><th class="tc">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($materias->getCollection()->where('nivel', 'primaria') as $m)
                            <tr>
                                <td><span class="mi-code">{{ $m->codigo }}</span></td>
                                <td>
                                    <div class="mi-nombre">{{ $m->nombre }}</div>
                                    @if($m->descripcion)<div class="mi-desc">{{ Str::limit($m->descripcion, 55) }}</div>@endif
                                </td>
                                <td><span class="mi-area {{ areaClass($m->area) }}">{{ $m->area }}</span></td>
                                <td class="tc">
                                    @if($m->activo)
                                        <span class="mi-estado est-on"><i class="fas fa-circle" style="font-size:.4rem;vertical-align:middle;"></i> Activa</span>
                                    @else
                                        <span class="mi-estado est-off"><i class="fas fa-circle" style="font-size:.4rem;vertical-align:middle;"></i> Inactiva</span>
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
                            <tr><td colspan="5"><div class="mi-empty"><i class="fas fa-child"></i><p>No hay materias de Primaria registradas</p></div></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Panel: SECUNDARIA --}}
        <div class="mi-panel" id="panel-secundaria">
            <div class="mi-card">
                <div style="overflow-x:auto;">
                    <table class="mi-tbl">
                        <thead>
                            <tr>
                                <th>Código</th><th>Materia</th><th>Área</th>
                                <th class="tc">Estado</th><th class="tc">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($materias->getCollection()->where('nivel', 'secundaria') as $m)
                            <tr>
                                <td><span class="mi-code">{{ $m->codigo }}</span></td>
                                <td>
                                    <div class="mi-nombre">{{ $m->nombre }}</div>
                                    @if($m->descripcion)<div class="mi-desc">{{ Str::limit($m->descripcion, 55) }}</div>@endif
                                </td>
                                <td><span class="mi-area {{ areaClass($m->area) }}">{{ $m->area }}</span></td>
                                <td class="tc">
                                    @if($m->activo)
                                        <span class="mi-estado est-on"><i class="fas fa-circle" style="font-size:.4rem;vertical-align:middle;"></i> Activa</span>
                                    @else
                                        <span class="mi-estado est-off"><i class="fas fa-circle" style="font-size:.4rem;vertical-align:middle;"></i> Inactiva</span>
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
                            <tr><td colspan="5"><div class="mi-empty"><i class="fas fa-user-graduate"></i><p>No hay materias de Secundaria registradas</p></div></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>{{-- fin mi-body --}}

</div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.mi-tab').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.mi-tab').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.mi-panel').forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('panel-' + this.dataset.tab).classList.add('active');
        });
    });

    const search      = document.getElementById('matSearch');
    const filtroNivel = document.getElementById('matFiltroNivel');
    const filtroEst   = document.getElementById('matFiltroEstado');
    const rows        = document.querySelectorAll('#tbl-todas tbody tr[data-search]');

    function filtrar() {
        const q    = search.value.toLowerCase();
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
    }

    search.addEventListener('input', filtrar);
    filtroNivel.addEventListener('change', filtrar);
    filtroEst.addEventListener('change', filtrar);
});
</script>
@endpush
@endsection
