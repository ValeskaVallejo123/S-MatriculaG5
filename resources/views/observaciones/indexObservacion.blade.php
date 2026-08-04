@extends('layouts.app')

@section('title', 'Observaciones Conductuales')
@section('page-title', 'Gestión de Observaciones')

@section('topbar-actions')
    <a href="{{ route('observaciones.create') }}" class="obs-topbar-btn">
        <i class="fas fa-plus"></i>
        <span class="obs-btn-text">Nueva Observación</span>
    </a>
@endsection

@push('styles')
<style>
    /* ── Botón topbar ── */
    .obs-topbar-btn {
        display: inline-flex; align-items: center; gap: .45rem;
        background: linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);
        color: white; padding: .5rem .9rem; border-radius: 8px;
        text-decoration: none; font-weight: 600; font-size: .83rem;
        box-shadow: 0 2px 8px rgba(78,199,210,0.3); white-space: nowrap;
    }
    .obs-topbar-btn:hover { opacity: .88; color: white; }
    @media(max-width: 600px) {
        .obs-btn-text { display: none; }
        .obs-topbar-btn { padding: .5rem .65rem; }
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
    .obs-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    @media(max-width:900px){ .obs-stats { grid-template-columns: repeat(2,1fr); } }
    @media(max-width:540px){ .obs-stats { grid-template-columns: 1fr 1fr; gap:.75rem; } }

    .obs-stat {
        background: white; border-radius: var(--radius-lg);
        border: 1px solid var(--border); padding: 1.1rem 1.25rem;
        display: flex; align-items: center; gap: 1rem;
        box-shadow: var(--shadow-sm); transition: transform .2s, box-shadow .2s;
        position: relative; overflow: hidden;
    }
    .obs-stat::before {
        content: ''; position: absolute; top: 0; left: 0;
        width: 4px; height: 100%; border-radius: 4px 0 0 4px;
    }
    .obs-stat-total::before     { background: var(--teal); }
    .obs-stat-academica::before { background: #3b82f6; }
    .obs-stat-conductual::before{ background: var(--red); }
    .obs-stat-salud::before     { background: var(--green); }
    .obs-stat:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

    .obs-stat-icon {
        width: 46px; height: 46px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-size: 1.15rem;
    }
    .obs-stat-total     .obs-stat-icon { background: var(--teal-light);       color: var(--teal); }
    .obs-stat-academica .obs-stat-icon { background: rgba(59,130,246,.12);     color: #3b82f6; }
    .obs-stat-conductual .obs-stat-icon{ background: rgba(239,68,68,.12);      color: var(--red); }
    .obs-stat-salud     .obs-stat-icon { background: rgba(16,185,129,.12);     color: var(--green); }

    .obs-stat-lbl { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--text-muted); margin-bottom: .2rem; }
    .obs-stat-num { font-size: 1.75rem; font-weight: 800; color: var(--blue-dark); line-height: 1; margin-bottom: .1rem; }
    .obs-stat-sub { font-size: .73rem; color: var(--text-muted); }

    /* ── Filtros ── */
    .obs-filter {
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

    /* ── Toolbar resumen ── */
    .obs-toolbar {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); padding: .75rem 1.25rem;
        margin-bottom: 1.25rem; display: flex; align-items: center;
        gap: 1rem; box-shadow: var(--shadow-sm);
    }

    /* ── Tabla card ── */
    .obs-card {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-sm);
    }
    .obs-card-head {
        background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-mid) 100%);
        padding: .9rem 1.4rem; display: flex; align-items: center; gap: .6rem;
    }
    .obs-card-head i    { color: var(--teal); font-size: 1rem; }
    .obs-card-head span { color: white; font-weight: 700; font-size: .95rem; }

    /* ── Scroll horizontal — sin ocultar columnas ── */
    .obs-tbl-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .obs-tbl { width: 100%; border-collapse: collapse; min-width: 750px; }
    .obs-tbl thead th {
        background: var(--surface); padding: .6rem .75rem;
        font-size: .67rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .06em; color: var(--text-muted);
        border-bottom: 1.5px solid var(--border); white-space: nowrap;
    }
    .obs-tbl thead th.tc { text-align: center; }
    .obs-tbl thead th.tr { text-align: right; }
    .obs-tbl tbody td {
        padding: .65rem .75rem; border-bottom: 1px solid #f1f5f9;
        font-size: .82rem; color: var(--text-main); vertical-align: middle;
    }
    .obs-tbl tbody td.tc { text-align: center; }
    .obs-tbl tbody td.tr { text-align: right; }
    .obs-tbl tbody tr:last-child td { border-bottom: none; }
    .obs-tbl tbody tr { transition: background .15s; }
    .obs-tbl tbody tr:hover { background: #f7fbff; }

    /* Columna acciones fija */
    .col-acciones { width: 80px; min-width: 80px; }

    /* Número de fila */
    .row-num {
        width: 24px; height: 24px; border-radius: 6px;
        background: var(--surface); border: 1px solid var(--border);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: .7rem; font-weight: 700; color: var(--text-muted);
    }

    .obs-name { font-weight: 600; color: var(--blue-dark); font-size: .85rem; }
    .obs-sub  { font-size: .71rem; color: var(--text-muted); margin-top: .1rem; }

    /* Badges tipo */
    .bpill {
        display: inline-flex; align-items: center; gap: .22rem;
        padding: .2rem .6rem; border-radius: 999px;
        font-size: .7rem; font-weight: 600; white-space: nowrap;
    }
    .b-blue     { background: rgba(59,130,246,.12);  color: #1d4ed8; border: 1px solid rgba(59,130,246,.3); }
    .b-red      { background: rgba(239,68,68,.1);    color: #dc2626; border: 1px solid rgba(239,68,68,.25); }
    .b-green    { background: rgba(16,185,129,.1);   color: #059669; border: 1px solid rgba(16,185,129,.3); }
    .b-gray     { background: #f1f5f9;               color: #64748b; border: 1px solid #e2e8f0; }

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
    .act-edit { border-color: var(--teal); color: var(--teal); }
    .act-del  { border-color: var(--red);  color: var(--red); }
    .act-edit:hover { background: var(--teal); color: white; }
    .act-del:hover  { background: var(--red);  color: white; }

    /* Empty */
    .obs-empty { padding: 4rem 1rem; text-align: center; }
    .obs-empty i  { font-size: 2.5rem; color: #cbd5e1; display: block; margin-bottom: 1rem; }
    .obs-empty h6 { color: var(--blue-dark); font-weight: 600; margin-bottom: .4rem; }
    .obs-empty p  { font-size: .83rem; color: var(--text-muted); margin: 0 0 1.25rem; }

    /* Footer */
    .obs-footer {
        padding: .85rem 1.25rem; border-top: 1px solid var(--border);
        background: var(--surface);
        display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .5rem;
    }
    .obs-footer-info { font-size: .78rem; color: var(--text-muted); }

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

    /* ── Responsive ── */
    @media(max-width: 768px) {
        .obs-footer { flex-direction: column; align-items: center; gap: .75rem; }
        .obs-tbl thead th, .obs-tbl tbody td { padding: .5rem .45rem; font-size: .74rem; }
    }
    @media(max-width: 480px) {
        .obs-stats { grid-template-columns: repeat(2,1fr); gap: .65rem; }
        .obs-stat  { padding: .85rem .9rem; gap: .75rem; }
        .obs-stat-num  { font-size: 1.45rem; }
        .obs-stat-icon { width: 38px; height: 38px; font-size: .95rem; }
    }
</style>
@endpush

@section('content')
<div>

    @if(session('success'))
    <div style="background:#f0fdf4;border:1px solid #86efac;border-radius:10px;color:#065f46;padding:1rem 1.25rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:.75rem;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button onclick="this.parentElement.remove()" style="margin-left:auto;background:none;border:none;color:#065f46;font-size:1.2rem;cursor:pointer;">&times;</button>
    </div>
    @endif

    {{-- ── STATS ── --}}
    <div class="obs-stats">
        <div class="obs-stat obs-stat-total">
            <div class="obs-stat-icon"><i class="fas fa-clipboard-list"></i></div>
            <div>
                <div class="obs-stat-lbl">Total</div>
                <div class="obs-stat-num">{{ $observaciones->total() }}</div>
                <div class="obs-stat-sub">Observaciones</div>
            </div>
        </div>
        <div class="obs-stat obs-stat-academica">
            <div class="obs-stat-icon"><i class="fas fa-book-open"></i></div>
            <div>
                <div class="obs-stat-lbl">Académica</div>
                <div class="obs-stat-num">{{ $observaciones->getCollection()->where('tipo','academica')->count() }}</div>
                <div class="obs-stat-sub">En esta página</div>
            </div>
        </div>
        <div class="obs-stat obs-stat-conductual">
            <div class="obs-stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
            <div>
                <div class="obs-stat-lbl">Conductual</div>
                <div class="obs-stat-num">{{ $observaciones->getCollection()->where('tipo','conductual')->count() }}</div>
                <div class="obs-stat-sub">En esta página</div>
            </div>
        </div>
        <div class="obs-stat obs-stat-salud">
            <div class="obs-stat-icon"><i class="fas fa-heartbeat"></i></div>
            <div>
                <div class="obs-stat-lbl">Salud</div>
                <div class="obs-stat-num">{{ $observaciones->getCollection()->where('tipo','salud')->count() }}</div>
                <div class="obs-stat-sub">En esta página</div>
            </div>
        </div>
    </div>

    {{-- ── FILTROS ── --}}
    <div class="obs-filter">
        <form method="GET" action="{{ route('observaciones.index') }}">
            <div class="filter-grid">
                <div>
                    <label class="filter-label"><i class="fas fa-search me-1"></i> Estudiante</label>
                    <input type="text" name="nombre" class="filter-input"
                           placeholder="Buscar por nombre..."
                           value="{{ $filtros['nombre'] ?? '' }}">
                </div>
                <div>
                    <label class="filter-label"><i class="fas fa-tag me-1"></i> Tipo</label>
                    <select name="tipo" class="filter-select">
                        <option value="">Todos</option>
                        <option value="academica"  @selected(($filtros['tipo'] ?? '') === 'academica')>Académica</option>
                        <option value="conductual" @selected(($filtros['tipo'] ?? '') === 'conductual')>Conductual</option>
                        <option value="salud"      @selected(($filtros['tipo'] ?? '') === 'salud')>Salud</option>
                        <option value="otro"       @selected(($filtros['tipo'] ?? '') === 'otro')>Otro</option>
                    </select>
                </div>
                <div>
                    <label class="filter-label"><i class="fas fa-calendar me-1"></i> Fecha Inicio</label>
                    <input type="date" name="fecha_desde" class="filter-input"
                           value="{{ $filtros['fecha_desde'] ?? '' }}">
                </div>
                <div>
                    <label class="filter-label"><i class="fas fa-calendar me-1"></i> Fecha Fin</label>
                    <input type="date" name="fecha_hasta" class="filter-input"
                           value="{{ $filtros['fecha_hasta'] ?? '' }}">
                </div>
                <div>
                    <label class="filter-label" style="opacity:0;">-</label>
                    <button type="submit" class="filter-btn">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                </div>
            </div>
            @if(($filtros['nombre'] ?? '') || ($filtros['tipo'] ?? '') || ($filtros['fecha_desde'] ?? '') || ($filtros['fecha_hasta'] ?? ''))
                <a href="{{ route('observaciones.index') }}" class="filter-clear">
                    <i class="fas fa-times"></i> Limpiar filtros
                </a>
            @endif
        </form>
    </div>

    {{-- ── RESUMEN ── --}}
    <div class="obs-toolbar">
        <i class="fas fa-list" style="color:var(--blue-mid);font-size:.9rem;"></i>
        <span style="font-size:.82rem;">
            <strong style="color:var(--blue-mid);">{{ $observaciones->total() }}</strong>
            <span style="color:var(--text-muted);">registros totales</span>
        </span>
    </div>

    {{-- ── TABLA ── --}}
    <div class="obs-card">
        <div class="obs-card-head">
            <i class="fas fa-list-ul"></i>
            <span>Lista de Observaciones</span>
        </div>

        <div class="obs-tbl-wrapper">
            <table class="obs-tbl">
                <thead>
                    <tr>
                        <th class="tc" style="width:44px;">#</th>
                        <th style="width:170px;">Estudiante</th>
                        <th style="width:150px;">Profesor</th>
                        <th>Descripción</th>
                        <th class="tc" style="width:100px;">Tipo</th>
                        <th class="tc" style="width:90px;">Fecha</th>
                        <th class="tr col-acciones">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($observaciones as $i => $obs)
                    <tr>
                        {{-- Número de fila --}}
                        <td class="tc">
                            <span class="row-num">{{ $observaciones->firstItem() + $i }}</span>
                        </td>

                        {{-- Estudiante --}}
                        <td>
                            <div class="obs-name">{{ $obs->estudiante->nombreCompleto ?? '—' }}</div>
                        </td>

                        {{-- Profesor --}}
                        <td>
                            <div style="font-size:.82rem;color:var(--blue-mid);font-weight:500;">
                                {{ $obs->profesor->nombreCompleto ?? '—' }}
                            </div>
                        </td>

                        {{-- Descripción --}}
                        <td>
                            <span style="font-size:.82rem;color:var(--text-main);">
                                {{ Str::limit($obs->descripcion, 80) }}
                            </span>
                        </td>

                        {{-- Tipo --}}
                        <td class="tc">
                            @php
                                $tipoConfig = match($obs->tipo) {
                                    'academica'  => ['Académica',  'b-blue'],
                                    'conductual' => ['Conductual', 'b-red'],
                                    'salud'      => ['Salud',      'b-green'],
                                    default      => ['Otro',       'b-gray'],
                                };
                            @endphp
                            <span class="bpill {{ $tipoConfig[1] }}">{{ $tipoConfig[0] }}</span>
                        </td>

                        {{-- Fecha --}}
                        <td class="tc">
                            <span style="font-size:.79rem;color:var(--text-muted);">
                                {{ $obs->created_at->format('d/m/Y') }}
                            </span>
                        </td>

                        {{-- Acciones — 2 botones siempre visibles --}}
                        <td class="tr col-acciones">
                            <div class="act-wrap">
                                <a href="{{ route('observaciones.edit', $obs) }}"
                                   class="act-btn act-edit" title="Editar">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <button type="button"
                                        class="act-btn act-del" title="Eliminar"
                                        onclick="mostrarModalDelete(
                                            '{{ route('observaciones.destroy', $obs) }}',
                                            '¿Estás seguro de eliminar esta observación? Esta acción no se puede deshacer.',
                                            '{{ Str::limit($obs->descripcion, 40) }}'
                                        )">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="obs-empty">
                                <i class="fas fa-clipboard-list"></i>
                                <h6>No hay observaciones registradas</h6>
                                <p>Comienza registrando la primera observación del sistema</p>
                                <a href="{{ route('observaciones.create') }}" class="obs-topbar-btn" style="display:inline-flex;">
                                    <i class="fas fa-plus"></i> Nueva Observación
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($observaciones->hasPages())
            <div class="obs-footer">
                <span class="obs-footer-info">
                    Mostrando {{ $observaciones->firstItem() }}–{{ $observaciones->lastItem() }}
                    de {{ $observaciones->total() }} observaciones
                </span>
                {{ $observaciones->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

</div>
@endsection