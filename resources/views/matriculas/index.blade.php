@extends('layouts.app')

@section('title', 'Matrículas')
@section('page-title', 'Gestión de Matrículas')

@section('topbar-actions')
    <a href="{{ route('matriculas.create') }}" class="mat-topbar-btn">
        <i class="fas fa-plus"></i>
        <span class="mat-btn-text">Nueva Matrícula</span>
    </a>
@endsection

@push('styles')
<style>
    /* ── Botón topbar ── */
    .mat-topbar-btn {
        display: inline-flex; align-items: center; gap: .45rem;
        background: linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);
        color: white; padding: .5rem .9rem; border-radius: 8px;
        text-decoration: none; font-weight: 600; font-size: .83rem;
        box-shadow: 0 2px 8px rgba(78,199,210,0.3); white-space: nowrap;
    }
    .mat-topbar-btn:hover { opacity: .88; color: white; }
    @media(max-width: 600px) {
        .mat-btn-text { display: none; }
        .mat-topbar-btn { padding: .5rem .65rem; }
    }

    /* ── Variables ── */
    :root {
        --blue-dark:   #003b73;
        --blue-mid:    #00508f;
        --teal:        #4ec7d2;
        --teal-light:  rgba(78,199,210,0.12);
        --border:      #e8edf4;
        --surface:     #f5f8fc;
        --text-main:   #0d2137;
        --text-muted:  #6b7a90;
        --green:       #10b981;
        --amber:       #f59e0b;
        --red:         #ef4444;
        --radius-lg:   14px;
        --radius-sm:   7px;
        --shadow-sm:   0 1px 4px rgba(0,59,115,0.07);
        --shadow-md:   0 4px 16px rgba(0,59,115,0.10);
    }

    /* ── Stats ── */
    .mat-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    @media(max-width:900px){ .mat-stats { grid-template-columns: repeat(2,1fr); } }
    @media(max-width:540px){ .mat-stats { grid-template-columns: 1fr 1fr; gap:.75rem; } }

    .mat-stat {
        background: white; border-radius: var(--radius-lg);
        border: 1px solid var(--border); padding: 1.1rem 1.25rem;
        display: flex; align-items: center; gap: 1rem;
        box-shadow: var(--shadow-sm); transition: transform .2s, box-shadow .2s;
        position: relative; overflow: hidden;
    }
    .mat-stat::before {
        content: ''; position: absolute; top: 0; left: 0;
        width: 4px; height: 100%; border-radius: 4px 0 0 4px;
    }
    .mat-stat-total::before     { background: var(--teal); }
    .mat-stat-aprobadas::before { background: var(--green); }
    .mat-stat-pendientes::before{ background: var(--amber); }
    .mat-stat-rechazadas::before{ background: var(--red); }
    .mat-stat:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

    .mat-stat-icon {
        width: 46px; height: 46px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-size: 1.15rem;
    }
    .mat-stat-total     .mat-stat-icon { background: var(--teal-light);     color: var(--teal); }
    .mat-stat-aprobadas .mat-stat-icon { background: rgba(16,185,129,.12);  color: var(--green); }
    .mat-stat-pendientes .mat-stat-icon{ background: rgba(245,158,11,.12);  color: var(--amber); }
    .mat-stat-rechazadas .mat-stat-icon{ background: rgba(239,68,68,.12);   color: var(--red); }

    .mat-stat-lbl { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--text-muted); margin-bottom: .2rem; }
    .mat-stat-num { font-size: 1.75rem; font-weight: 800; color: var(--blue-dark); line-height: 1; margin-bottom: .1rem; }
    .mat-stat-sub { font-size: .73rem; color: var(--text-muted); }

    /* ── Filtros ── */
    .mat-filter {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); padding: 1rem 1.25rem;
        margin-bottom: 1.25rem; box-shadow: var(--shadow-sm);
    }
    .filter-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr auto;
        gap: .65rem; align-items: end;
    }
    @media(max-width:900px){ .filter-grid { grid-template-columns: 1fr 1fr; } }
    @media(max-width:500px){ .filter-grid { grid-template-columns: 1fr; } }

    .filter-label {
        font-size: .7rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .05em; color: var(--blue-dark);
        margin-bottom: .35rem; display: block;
    }
    .filter-input, .filter-select {
        width: 100%; padding: .45rem .8rem;
        border: 2px solid #bfd9ea; border-radius: 8px;
        font-size: .85rem; font-family: inherit;
        color: var(--text-main); outline: none;
        transition: border-color .2s, box-shadow .2s; background: white;
    }
    .filter-input:focus, .filter-select:focus {
        border-color: var(--teal); box-shadow: 0 0 0 3px rgba(78,199,210,.12);
    }
    .filter-btn {
        display: inline-flex; align-items: center; justify-content: center; gap: .35rem;
        padding: .45rem 1rem; border-radius: 8px;
        background: linear-gradient(135deg, var(--teal), var(--blue-mid));
        color: #fff; border: none; font-size: .82rem; font-weight: 600;
        cursor: pointer; white-space: nowrap; width: 100%; font-family: inherit;
    }
    .filter-btn:hover { opacity: .88; }
    .filter-clear {
        font-size: .75rem; color: var(--text-muted); text-decoration: none;
        display: inline-flex; align-items: center; gap: .3rem; margin-top: .5rem;
        transition: color .15s;
    }
    .filter-clear:hover { color: var(--red); }

    /* ── Tabla card ── */
    .mat-card {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-sm);
    }
    .mat-card-head {
        background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-mid) 100%);
        padding: .9rem 1.4rem; display: flex; align-items: center; gap: .6rem;
    }
    .mat-card-head i    { color: var(--teal); font-size: 1rem; }
    .mat-card-head span { color: white; font-weight: 700; font-size: .95rem; }

    /* ── Scroll horizontal — sin ocultar columnas ── */
    .mat-tbl-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .mat-tbl { width: 100%; border-collapse: collapse; min-width: 750px; }
    .mat-tbl thead th {
        background: var(--surface); padding: .6rem .75rem;
        font-size: .67rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .06em; color: var(--text-muted);
        border-bottom: 1.5px solid var(--border); white-space: nowrap;
    }
    .mat-tbl thead th.tc { text-align: center; }
    .mat-tbl thead th.tr { text-align: right; }
    .mat-tbl tbody td {
        padding: .65rem .75rem; border-bottom: 1px solid #f1f5f9;
        font-size: .82rem; color: var(--text-main); vertical-align: middle;
    }
    .mat-tbl tbody td.tc { text-align: center; }
    .mat-tbl tbody td.tr { text-align: right; }
    .mat-tbl tbody tr:last-child td { border-bottom: none; }
    .mat-tbl tbody tr { transition: background .15s; }
    .mat-tbl tbody tr:hover { background: #f7fbff; }

    /* Columna acciones fija */
    .col-acciones { width: 80px; min-width: 80px; }

    /* Número de fila */
    .row-num {
        width: 24px; height: 24px; border-radius: 6px;
        background: var(--surface); border: 1px solid var(--border);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: .7rem; font-weight: 700; color: var(--text-muted);
    }

    /* Avatar */
    .mat-av {
        width: 36px; height: 36px; border-radius: 9px; flex-shrink: 0;
        background: linear-gradient(135deg, var(--teal), var(--blue-mid));
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; color: #fff; font-size: .85rem;
        border: 2px solid rgba(78,199,210,.3);
    }
    .mat-name { font-weight: 600; color: var(--blue-dark); font-size: .85rem; }
    .mat-sub  { font-size: .71rem; color: var(--text-muted); margin-top: .1rem; }
    .mat-code { font-family: 'Courier New', monospace; font-size: .7rem; color: var(--text-muted); }

    /* Badges */
    .bpill {
        display: inline-flex; align-items: center; gap: .22rem;
        padding: .2rem .6rem; border-radius: 999px;
        font-size: .7rem; font-weight: 600; white-space: nowrap;
    }
    .b-cyan   { background: var(--teal-light); color: var(--blue-mid); border: 1px solid rgba(78,199,210,.35); }
    .b-green  { background: rgba(16,185,129,.1); color: #059669; border: 1px solid rgba(16,185,129,.3); }
    .b-yellow { background: rgba(245,158,11,.1); color: #92400e; border: 1px solid rgba(245,158,11,.3); }
    .b-red    { background: rgba(239,68,68,.1); color: #dc2626; border: 1px solid rgba(239,68,68,.25); }
    .b-gray   { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }

    /* Botón aprobar inline */
    .btn-aprobar-inline {
        display: inline-flex; align-items: center; gap: .25rem;
        padding: .2rem .6rem; border-radius: 999px;
        font-size: .7rem; font-weight: 600; white-space: nowrap;
        background: rgba(245,158,11,.1); color: #92400e;
        border: 1px solid rgba(245,158,11,.3);
        cursor: pointer; font-family: inherit; transition: all .15s;
    }
    .btn-aprobar-inline:hover {
        background: rgba(16,185,129,.15); color: #059669; border-color: rgba(16,185,129,.3);
    }

    /* ── Botones acción compactos — todos visibles ── */
    .act-wrap {
        display: inline-flex; gap: 3px;
        align-items: center; flex-wrap: nowrap; justify-content: flex-end;
    }
    .act-btn {
        width: 26px; height: 26px; border-radius: 6px;
        display: inline-flex; align-items: center; justify-content: center;
        border: 1.5px solid; font-size: .7rem;
        background: white; cursor: pointer;
        transition: all .15s; text-decoration: none;
        flex-shrink: 0; padding: 0;
    }
    .act-view { border-color: var(--blue-mid); color: var(--blue-mid); }
    .act-edit { border-color: var(--teal);     color: var(--teal); }
    .act-view:hover { background: var(--blue-mid); color: white; }
    .act-edit:hover { background: var(--teal);     color: white; }

    /* Empty */
    .mat-empty { padding: 4rem 1rem; text-align: center; }
    .mat-empty i  { font-size: 2.5rem; color: #cbd5e1; display: block; margin-bottom: 1rem; }
    .mat-empty h6 { color: var(--blue-dark); font-weight: 600; margin-bottom: .4rem; }
    .mat-empty p  { font-size: .83rem; color: var(--text-muted); margin: 0 0 1.25rem; }

    /* Footer */
    .mat-footer {
        padding: .85rem 1.25rem; border-top: 1px solid var(--border);
        background: var(--surface);
        display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .5rem;
    }
    .mat-footer-info { font-size: .78rem; color: var(--text-muted); }

    .pagination { margin: 0; }
    .pagination .page-link {
        border-radius: 7px; margin: 0 2px; border: 1.5px solid var(--border);
        color: var(--blue-mid); padding: .28rem .6rem; font-size: .82rem; transition: all .15s;
    }
    .pagination .page-link:hover { background: var(--teal-light); border-color: var(--teal); color: var(--blue-dark); }
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, var(--teal), var(--blue-mid));
        border-color: var(--teal); color: white; box-shadow: 0 2px 6px rgba(78,199,210,.35);
    }

    /* ── Responsive — sin ocultar columnas ── */
    @media(max-width: 768px) {
        .mat-footer { flex-direction: column; align-items: center; gap: .75rem; }
        .mat-tbl thead th, .mat-tbl tbody td { padding: .5rem .45rem; font-size: .74rem; }
    }
    @media(max-width: 480px) {
        .mat-stats { grid-template-columns: repeat(2,1fr); gap: .65rem; }
        .mat-stat  { padding: .85rem .9rem; gap: .75rem; }
        .mat-stat-num  { font-size: 1.45rem; }
        .mat-stat-icon { width: 38px; height: 38px; font-size: .95rem; }
        .mat-name { font-size: .8rem; }
        .mat-sub  { font-size: .67rem; }
    }
</style>
@endpush

@section('content')
<div>

    {{-- ── STATS ── --}}
    <div class="mat-stats">
        <div class="mat-stat mat-stat-total">
            <div class="mat-stat-icon"><i class="fas fa-clipboard-list"></i></div>
            <div>
                <div class="mat-stat-lbl">Total</div>
                <div class="mat-stat-num">{{ $matriculas->total() }}</div>
                <div class="mat-stat-sub">Matrículas</div>
            </div>
        </div>
        <div class="mat-stat mat-stat-aprobadas">
            <div class="mat-stat-icon"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="mat-stat-lbl">Aprobadas</div>
                <div class="mat-stat-num">{{ $aprobadas ?? 0 }}</div>
                <div class="mat-stat-sub">Confirmadas</div>
            </div>
        </div>
        <div class="mat-stat mat-stat-pendientes">
            <div class="mat-stat-icon"><i class="fas fa-clock"></i></div>
            <div>
                <div class="mat-stat-lbl">Pendientes</div>
                <div class="mat-stat-num">{{ $pendientes ?? 0 }}</div>
                <div class="mat-stat-sub">En revisión</div>
            </div>
        </div>
        <div class="mat-stat mat-stat-rechazadas">
            <div class="mat-stat-icon"><i class="fas fa-times-circle"></i></div>
            <div>
                <div class="mat-stat-lbl">Rechazadas</div>
                <div class="mat-stat-num">{{ $rechazadas ?? 0 }}</div>
                <div class="mat-stat-sub">No aprobadas</div>
            </div>
        </div>
    </div>

    {{-- ── FILTROS ── --}}
    <div class="mat-filter">
        <form action="{{ route('matriculas.index') }}" method="GET">
            <div class="filter-grid">
                <div>
                    <label class="filter-label"><i class="fas fa-search me-1"></i> Buscar</label>
                    <input type="text" name="buscar" class="filter-input"
                           placeholder="Nombre, apellido o DNI..."
                           value="{{ request('buscar') }}">
                </div>
                <div>
                    <label class="filter-label"><i class="fas fa-graduation-cap me-1"></i> Grado</label>
                    <select name="grado" class="filter-select">
                        <option value="">Todos</option>
                        @foreach(['Primer Grado','Segundo Grado','Tercer Grado','Cuarto Grado','Quinto Grado','Sexto Grado','Séptimo Grado','Octavo Grado','Noveno Grado'] as $g)
                            <option value="{{ $g }}" {{ request('grado') === $g ? 'selected' : '' }}>{{ $g }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="filter-label"><i class="fas fa-flag me-1"></i> Estado</label>
                    <select name="estado" class="filter-select">
                        <option value="">Todos</option>
                        <option value="aprobada"  {{ request('estado') === 'aprobada'  ? 'selected' : '' }}>Aprobada</option>
                        <option value="pendiente" {{ request('estado') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="rechazada" {{ request('estado') === 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                    </select>
                </div>
                <div>
                    <label class="filter-label"><i class="fas fa-calendar me-1"></i> Año</label>
                    <select name="anio" class="filter-select">
                        <option value="">Todos</option>
                        <option value="2026" {{ request('anio') === '2026' ? 'selected' : '' }}>2026</option>
                        <option value="2025" {{ request('anio') === '2025' ? 'selected' : '' }}>2025</option>
                        <option value="2024" {{ request('anio') === '2024' ? 'selected' : '' }}>2024</option>
                    </select>
                </div>
                <div>
                    <label class="filter-label" style="opacity:0;">-</label>
                    <button type="submit" class="filter-btn">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                </div>
            </div>
            @if(request('buscar') || request('grado') || request('estado') || request('anio'))
                <a href="{{ route('matriculas.index') }}" class="filter-clear">
                    <i class="fas fa-times"></i> Limpiar filtros
                </a>
            @endif
        </form>
    </div>

    {{-- ── TABLA ── --}}
    <div class="mat-card">
        <div class="mat-card-head">
            <i class="fas fa-list-ul"></i>
            <span>Lista de Matrículas</span>
        </div>

        <div class="mat-tbl-wrapper">
            <table class="mat-tbl">
                <thead>
                    <tr>
                        <th class="tc" style="width:44px;">#</th>
                        <th>Estudiante</th>
                        <th class="tc" style="width:150px;">Grado / Sección</th>
                        <th class="tc" style="width:65px;">Año</th>
                        <th style="width:170px;">Padre / Tutor</th>
                        <th class="tc" style="width:115px;">Estado</th>
                        <th class="tr col-acciones">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($matriculas as $i => $matricula)
                    <tr>
                        {{-- Número de fila --}}
                        <td class="tc">
                            <span class="row-num">{{ $matriculas->firstItem() + $i }}</span>
                        </td>

                        {{-- Estudiante --}}
                        <td>
                            <div style="display:flex;align-items:center;gap:.6rem;">
                                <div class="mat-av">
                                    {{ strtoupper(substr($matricula->estudiante->nombre1 ?? $matricula->estudiante->nombre ?? 'N', 0, 1) . substr($matricula->estudiante->apellido1 ?? $matricula->estudiante->apellido ?? 'A', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="mat-name">
                                        {{ $matricula->estudiante->nombre1 ?? $matricula->estudiante->nombre ?? 'N/A' }}
                                        {{ $matricula->estudiante->apellido1 ?? $matricula->estudiante->apellido ?? '' }}
                                    </div>
                                    <div class="mat-sub">
                                        <i class="fas fa-id-card" style="font-size:.63rem;"></i>
                                        {{ $matricula->estudiante->dni ?? 'Sin DNI' }}
                                        &nbsp;·&nbsp;
                                        <span class="mat-code">{{ $matricula->codigo_matricula }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Grado / Sección --}}
                        <td class="tc">
                            <span class="bpill b-cyan" style="margin-right:.25rem;">
                                {{ $matricula->estudiante->grado ?? 'N/A' }}
                            </span>
                            <span class="bpill b-gray">Sec. {{ $matricula->estudiante->seccion ?? 'N/A' }}</span>
                        </td>

                        {{-- Año --}}
                        <td class="tc">
                            <span style="font-size:.82rem;font-weight:700;color:var(--blue-dark);">
                                {{ $matricula->anio_lectivo ?? '—' }}
                            </span>
                        </td>

                        {{-- Padre / Tutor --}}
                        <td>
                            @if($matricula->padre)
                                <div class="mat-name">{{ $matricula->padre->nombre }} {{ $matricula->padre->apellido }}</div>
                                <div class="mat-sub">
                                    <i class="fas fa-phone" style="font-size:.63rem;"></i>
                                    {{ $matricula->padre->telefono ?? 'Sin teléfono' }}
                                </div>
                            @else
                                <span style="font-size:.76rem;color:#cbd5e1;font-style:italic;">Sin padre asignado</span>
                            @endif
                        </td>

                        {{-- Estado --}}
                        <td class="tc">
                            @if($matricula->estado === 'aprobada')
                                <span class="bpill b-green">
                                    <i class="fas fa-check-circle"></i> Aprobada
                                </span>
                            @elseif($matricula->estado === 'pendiente')
                                <form action="{{ route('matriculas.aprobar', $matricula->id) }}" method="POST"
                                      style="display:inline;" data-confirm="¿Aprobar esta matrícula?">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-aprobar-inline" title="Clic para aprobar">
                                        <i class="fas fa-clock"></i> Pendiente
                                        <i class="fas fa-arrow-right" style="font-size:.58rem;opacity:.6;"></i>
                                    </button>
                                </form>
                            @elseif($matricula->estado === 'rechazada')
                                <span class="bpill b-red">
                                    <i class="fas fa-times-circle"></i> Rechazada
                                </span>
                            @else
                                <span class="bpill b-gray">{{ ucfirst($matricula->estado) }}</span>
                            @endif
                        </td>

                        {{-- Acciones — 2 botones siempre visibles --}}
                        <td class="tr col-acciones">
                            <div class="act-wrap">
                                <a href="{{ route('matriculas.show', $matricula->id) }}"
                                   class="act-btn act-view" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('matriculas.edit', $matricula->id) }}"
                                   class="act-btn act-edit" title="Editar">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="mat-empty">
                                <i class="fas fa-clipboard-list"></i>
                                <h6>No hay matrículas registradas</h6>
                                <p>
                                    @if(request('buscar') || request('grado') || request('estado') || request('anio'))
                                        No se encontraron resultados con los filtros aplicados
                                    @else
                                        Comienza registrando la primera matrícula del sistema
                                    @endif
                                </p>
                                <a href="{{ route('matriculas.create') }}" class="mat-topbar-btn">
                                    <i class="fas fa-plus"></i> Nueva Matrícula
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($matriculas->hasPages())
            <div class="mat-footer">
                <span class="mat-footer-info">
                    Mostrando {{ $matriculas->firstItem() }}–{{ $matriculas->lastItem() }}
                    de {{ $matriculas->total() }} matrículas
                </span>
                {{ $matriculas->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

</div>
@endsection