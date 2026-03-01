@extends('layouts.app')

@section('title', 'Materias')
@section('page-title', 'Plan de Estudios')

@section('topbar-actions')
    <a href="{{ route('materias.create') }}"
       style="background: linear-gradient(135deg, #4ec7d2, #00508f); color: white; padding: 0.45rem 1.1rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; box-shadow: 0 2px 8px rgba(78,199,210,.35);">
        <i class="fas fa-plus"></i> Nueva Materia
    </a>
@endsection

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&family=Playfair+Display:wght@700&display=swap');

:root {
    --azul:    #00508f;
    --cian:    #4ec7d2;
    --azul-dark: #003b73;
    --bg:      #f0f4f8;
    --card-bg: #ffffff;
    --border:  #dde6ef;
    --text:    #1e293b;
    --muted:   #64748b;
}

.mat-wrap { font-family: 'Nunito', sans-serif; color: var(--text); }

/* ── Encabezado descriptivo ── */
.mat-hero {
    background: linear-gradient(135deg, var(--azul-dark) 0%, var(--azul) 60%, var(--cian) 100%);
    border-radius: 14px; padding: 1.5rem 1.75rem;
    margin-bottom: 1.5rem; position: relative; overflow: hidden;
    box-shadow: 0 4px 18px rgba(0,59,115,.18);
}
.mat-hero::before {
    content: ''; position: absolute; right: -30px; top: -30px;
    width: 180px; height: 180px; border-radius: 50%;
    background: rgba(78,199,210,.15);
}
.mat-hero::after {
    content: ''; position: absolute; right: 60px; bottom: -40px;
    width: 120px; height: 120px; border-radius: 50%;
    background: rgba(255,255,255,.07);
}
.mat-hero-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.5rem; color: #fff; margin: 0 0 .25rem; line-height: 1.2;
}
.mat-hero-sub { font-size: .85rem; color: rgba(255,255,255,.75); margin: 0; }
.mat-hero-stats { display: flex; gap: 1.5rem; margin-top: 1rem; flex-wrap: wrap; }
.mat-hero-stat {
    background: rgba(255,255,255,.13); border-radius: 10px;
    padding: .5rem 1rem; display: flex; align-items: center; gap: .6rem;
    backdrop-filter: blur(4px); border: 1px solid rgba(255,255,255,.15);
}
.mat-hero-stat i { color: var(--cian); font-size: 1rem; }
.mat-hero-stat-num { font-size: 1.3rem; font-weight: 800; color: #fff; line-height: 1; }
.mat-hero-stat-lbl { font-size: .7rem; color: rgba(255,255,255,.7); font-weight: 600; text-transform: uppercase; letter-spacing: .05em; }

/* ── Toolbar ── */
.mat-toolbar {
    background: var(--card-bg); border: 1px solid var(--border);
    border-radius: 12px; padding: .75rem 1.1rem;
    margin-bottom: 1.25rem;
    display: flex; align-items: center; gap: .75rem; flex-wrap: wrap;
    box-shadow: 0 1px 4px rgba(0,0,0,.05);
}
.mat-search {
    flex: 1; min-width: 180px;
    padding: .4rem .75rem .4rem 2.1rem;
    border: 1.5px solid var(--border); border-radius: 8px;
    font-size: .82rem; outline: none; font-family: 'Nunito', sans-serif;
    background: #f8fafc url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='13' height='13' fill='none' stroke='%236b7280' stroke-width='2' viewBox='0 0 24 24'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='M21 21l-4.35-4.35'/%3E%3C/svg%3E") no-repeat 10px center;
}
.mat-search:focus { border-color: var(--cian); background-color: #fff; }

.mat-select {
    padding: .4rem .75rem; border: 1.5px solid var(--border); border-radius: 8px;
    font-size: .82rem; outline: none; background: #f8fafc;
    font-family: 'Nunito', sans-serif; cursor: pointer; color: var(--text);
}
.mat-select:focus { border-color: var(--cian); }

/* ── Tabs estilo cuaderno ── */
.mat-tabs {
    display: flex; gap: 4px; margin-bottom: 0;
    border-bottom: 2.5px solid var(--border);
}
.mat-tab {
    padding: .6rem 1.25rem; font-size: .82rem; font-weight: 700;
    border: 1.5px solid transparent; border-bottom: none;
    border-radius: 9px 9px 0 0; cursor: pointer;
    color: var(--muted); background: #f0f4f8;
    transition: all .2s; font-family: 'Nunito', sans-serif;
    display: flex; align-items: center; gap: .4rem;
}
.mat-tab:hover { background: #e2eaf2; color: var(--azul); }
.mat-tab.active {
    background: var(--card-bg); color: var(--azul);
    border-color: var(--border); border-bottom-color: var(--card-bg);
    margin-bottom: -2.5px; position: relative; z-index: 1;
    box-shadow: 0 -2px 6px rgba(0,0,0,.05);
}
.mat-tab .tab-count {
    background: var(--cian); color: #fff;
    font-size: .65rem; font-weight: 800;
    padding: .1rem .45rem; border-radius: 99px; line-height: 1.4;
}
.mat-tab.active .tab-count { background: var(--azul); }

/* ── Panel ── */
.mat-panel { display: none; }
.mat-panel.active { display: block; }

/* ── Card tabla ── */
.mat-card {
    background: var(--card-bg); border: 1px solid var(--border);
    border-radius: 0 12px 12px 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,.05); overflow: hidden;
}

/* ── Tabla ── */
.mat-tbl { width: 100%; border-collapse: collapse; }
.mat-tbl thead th {
    background: linear-gradient(135deg, #f8fafc, #edf2f7);
    padding: .65rem 1rem;
    font-size: .68rem; font-weight: 800; letter-spacing: .08em;
    text-transform: uppercase; color: var(--azul-dark);
    border-bottom: 2px solid var(--border);
}
.mat-tbl thead th.tc { text-align: center; }
.mat-tbl tbody td {
    padding: .7rem 1rem; border-bottom: 1px solid #f1f5f9;
    font-size: .83rem; color: var(--text); vertical-align: middle;
}
.mat-tbl tbody td.tc { text-align: center; }
.mat-tbl tbody tr:last-child td { border-bottom: none; }
.mat-tbl tbody tr:hover { background: #f7fbfc; }

/* Código */
.mat-code {
    font-family: 'Courier New', monospace;
    background: rgba(78,199,210,.12); color: var(--azul);
    border: 1px solid rgba(78,199,210,.35);
    padding: .2rem .55rem; border-radius: 5px;
    font-size: .75rem; font-weight: 700; letter-spacing: .03em;
}

/* Nombre materia */
.mat-nombre { font-weight: 700; color: var(--azul-dark); font-size: .85rem; }
.mat-desc   { font-size: .73rem; color: var(--muted); margin-top: .1rem; }

/* Area badge */
.mat-area {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .22rem .65rem; border-radius: 999px;
    font-size: .7rem; font-weight: 700;
}

/* Nivel */
.mat-nivel {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .22rem .65rem; border-radius: 6px;
    font-size: .72rem; font-weight: 700;
}
.niv-pri { background: #e0f7fa; color: #006064; }
.niv-sec { background: #e8eaf6; color: #283593; }

/* Estado */
.mat-estado {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .22rem .65rem; border-radius: 999px;
    font-size: .7rem; font-weight: 700;
}
.est-on  { background: #ecfdf5; color: #059669; }
.est-off { background: #fef2f2; color: #dc2626; }

/* Acciones */
.act-btn {
    display: inline-flex; align-items: center; justify-content: center;
    width: 29px; height: 29px; border-radius: 7px;
    border: none; cursor: pointer; font-size: .73rem;
    text-decoration: none; transition: all .15s;
}
.act-btn:hover { transform: translateY(-1px); }
.act-view { background: #e8f8f9; color: var(--azul); }
.act-view:hover { background: var(--cian); color: #fff; }
.act-edit { background: #eff6ff; color: #3b82f6; }
.act-edit:hover { background: #3b82f6; color: #fff; }
.act-del  { background: #fef2f2; color: #ef4444; }
.act-del:hover  { background: #ef4444; color: #fff; }

/* Empty */
.mat-empty { padding: 4rem 1rem; text-align: center; }
.mat-empty i { font-size: 2.5rem; color: #cbd5e1; display: block; margin-bottom: .75rem; }
.mat-empty p { color: var(--muted); font-size: .85rem; margin: .25rem 0 0; }

/* Footer paginación */
.mat-footer {
    padding: .75rem 1rem; border-top: 1px solid #f1f5f9;
    display: flex; align-items: center; justify-content: space-between;
    background: #fafbfc; flex-wrap: wrap; gap: .5rem;
}
.mat-footer-info { font-size: .78rem; color: var(--muted); }

/* Colores de área */
.area-mat  { background: #fff7ed; color: #c2410c; }
.area-esp  { background: #fdf4ff; color: #7e22ce; }
.area-cien { background: #ecfdf5; color: #065f46; }
.area-soc  { background: #eff6ff; color: #1e40af; }
.area-ef   { background: #fef9c3; color: #854d0e; }
.area-art  { background: #fce7f3; color: #9d174d; }
.area-ing  { background: #f0fdfa; color: #134e4a; }
.area-inf  { background: #f5f3ff; color: #4c1d95; }
.area-oth  { background: #f8fafc; color: #475569; }

@media(max-width:640px){
    .mat-hero-stats { gap: .75rem; }
    .mat-tabs { overflow-x: auto; }
    .mat-tab { white-space: nowrap; }
}
</style>
@endpush

@section('content')

@php
    $total    = $materias->total();
    $activas  = $materias->getCollection()->where('activo', true)->count();
    $primaria = $materias->getCollection()->where('nivel', 'primaria')->count();
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

<div class="mat-wrap">

    

    {{-- Toolbar --}}
    <div class="mat-toolbar">
        <input type="text" id="matSearch" class="mat-search" placeholder="Buscar por nombre, código o área...">
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
    </div>

    {{-- Tabs --}}
    <div class="mat-tabs">
        <button class="mat-tab active" data-tab="todas">
            <i class="fas fa-list"></i> Todas
            <span class="tab-count" id="cnt-todas">{{ $total }}</span>
        </button>
        <button class="mat-tab" data-tab="primaria">
            <i class="fas fa-child"></i> Primaria
            <span class="tab-count" id="cnt-primaria">{{ $primaria }}</span>
        </button>
        <button class="mat-tab" data-tab="secundaria">
            <i class="fas fa-user-graduate"></i> Secundaria
            <span class="tab-count" id="cnt-secundaria">{{ $secundaria }}</span>
        </button>
    </div>

    {{-- Panel: TODAS --}}
    <div class="mat-panel active" id="panel-todas">
        <div class="mat-card">
            <div style="overflow-x:auto;">
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
                        <tr data-nivel="{{ $m->nivel }}" data-activo="{{ $m->activo ? '1' : '0' }}"
                            data-search="{{ strtolower($m->nombre . ' ' . $m->codigo . ' ' . $m->area) }}">
                            <td><span class="mat-code">{{ $m->codigo }}</span></td>
                            <td>
                                <div class="mat-nombre">{{ $m->nombre }}</div>
                                @if($m->descripcion)
                                <div class="mat-desc">{{ Str::limit($m->descripcion, 55) }}</div>
                                @endif
                            </td>
                            <td>
                                <span class="mat-area {{ areaClass($m->area) }}">
                                    {{ $m->area }}
                                </span>
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
                                            onclick="mostrarModalDeleteData(this)"
                                            title="Eliminar">
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
                                    <p>No hay materias registradas</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($materias->hasPages())
            <div class="mat-footer">
                <span class="mat-footer-info">
                    Mostrando {{ $materias->firstItem() }}–{{ $materias->lastItem() }} de {{ $materias->total() }}
                </span>
                {{ $materias->links() }}
            </div>
            @endif
        </div>
    </div>

    {{-- Panel: PRIMARIA --}}
    <div class="mat-panel" id="panel-primaria">
        <div class="mat-card">
            <div style="overflow-x:auto;">
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
                                <div class="mat-nombre">{{ $m->nombre }}</div>
                                @if($m->descripcion)
                                <div class="mat-desc">{{ Str::limit($m->descripcion, 55) }}</div>
                                @endif
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
                                            onclick="mostrarModalDeleteData(this)"
                                            title="Eliminar">
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
                                    <p>No hay materias de Primaria registradas</p>
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
            <div style="overflow-x:auto;">
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
                                <div class="mat-nombre">{{ $m->nombre }}</div>
                                @if($m->descripcion)
                                <div class="mat-desc">{{ Str::limit($m->descripcion, 55) }}</div>
                                @endif
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
                                            onclick="mostrarModalDeleteData(this)"
                                            title="Eliminar">
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
                                    <p>No hay materias de Secundaria registradas</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Tabs ── */
    document.querySelectorAll('.mat-tab').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.mat-tab').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.mat-panel').forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('panel-' + this.dataset.tab).classList.add('active');
        });
    });

    /* ── Filtros (solo en tab Todas) ── */
    const search      = document.getElementById('matSearch');
    const filtroNivel = document.getElementById('matFiltroNivel');
    const filtroEst   = document.getElementById('matFiltroEstado');
    const rows        = document.querySelectorAll('#tbl-todas tbody tr[data-search]');

    function filtrar() {
        const q     = search.value.toLowerCase();
        const nivel = filtroNivel.value;
        const est   = filtroEst.value;

        let vis = { todas: 0, primaria: 0, secundaria: 0 };

        rows.forEach(row => {
            const matchQ   = row.dataset.search.includes(q);
            const matchN   = !nivel || row.dataset.nivel === nivel;
            const matchE   = !est   || row.dataset.activo === est;
            const show     = matchQ && matchN && matchE;
            row.style.display = show ? '' : 'none';
            if (show) {
                vis.todas++;
                vis[row.dataset.nivel]++;
            }
        });

        document.getElementById('cnt-todas').textContent     = vis.todas;
        document.getElementById('cnt-primaria').textContent  = vis.primaria;
        document.getElementById('cnt-secundaria').textContent = vis.secundaria;
    }

    search.addEventListener('input', filtrar);
    filtroNivel.addEventListener('change', filtrar);
    filtroEst.addEventListener('change', filtrar);
});
</script>
@endpush