@extends('layouts.app')

@section('title', 'Padres y Tutores')
@section('page-title', 'Gestión de Padres y Tutores')

@section('topbar-actions')
    <a href="{{ route('padres.create') }}" class="pad-topbar-btn">
        <i class="fas fa-plus"></i>
        <span class="pad-btn-text">Agregar Padre/Tutor</span>
    </a>
@endsection

@push('styles')
<style>
    /* ── Botón topbar ── */
    .pad-topbar-btn {
        display: inline-flex; align-items: center; gap: .45rem;
        background: linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);
        color: white; padding: .5rem .9rem; border-radius: 8px;
        text-decoration: none; font-weight: 600; font-size: .83rem;
        box-shadow: 0 2px 8px rgba(78,199,210,0.3); white-space: nowrap;
    }
    .pad-topbar-btn:hover { opacity: .88; color: white; }
    @media(max-width: 600px) {
        .pad-btn-text { display: none; }
        .pad-topbar-btn { padding: .5rem .65rem; }
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
    .pad-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
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
    .pad-stat::before {
        content: ''; position: absolute; top: 0; left: 0;
        width: 4px; height: 100%; border-radius: 4px 0 0 4px;
    }
    .pad-stat-total::before  { background: var(--teal); }
    .pad-stat-active::before { background: var(--green); }
    .pad-stat-hijos::before  { background: var(--amber); }
    .pad-stat:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

    .pad-stat-icon {
        width: 46px; height: 46px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-size: 1.15rem;
    }
    .pad-stat-total  .pad-stat-icon { background: var(--teal-light);     color: var(--teal); }
    .pad-stat-active .pad-stat-icon { background: rgba(16,185,129,.12);  color: var(--green); }
    .pad-stat-hijos  .pad-stat-icon { background: rgba(245,158,11,.12);  color: var(--amber); }

    .pad-stat-lbl { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--text-muted); margin-bottom: .2rem; }
    .pad-stat-num { font-size: 1.75rem; font-weight: 800; color: var(--blue-dark); line-height: 1; margin-bottom: .1rem; }
    .pad-stat-sub { font-size: .73rem; color: var(--text-muted); }

    /* ── Toolbar ── */
    .pad-toolbar {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); padding: .9rem 1.25rem;
        margin-bottom: 1.25rem;
        display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;
        box-shadow: var(--shadow-sm);
    }
    .pad-search-wrap { position: relative; flex: 1; min-width: 220px; }
    .pad-search-wrap i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--blue-mid); font-size: .85rem; pointer-events: none; }
    .pad-search {
        width: 100%; padding: .5rem 1rem .5rem 2.4rem;
        border: 1.5px solid var(--border); border-radius: var(--radius-sm);
        font-size: .85rem; background: var(--surface); outline: none;
        transition: border-color .2s, box-shadow .2s;
        font-family: inherit; color: var(--text-main);
    }
    .pad-search:focus { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(78,199,210,.15); background: white; }

    .pad-badge-info { display: flex; align-items: center; gap: 1.25rem; flex-shrink: 0; }
    .pad-badge-info span { display: flex; align-items: center; gap: .4rem; font-size: .82rem; }

    .pad-perpage { display: flex; align-items: center; gap: .5rem; font-size: .8rem; color: #64748b; }
    .pad-perpage label { white-space: nowrap; font-weight: 500; }
    .pad-perpage select {
        padding: .3rem .6rem; border: 1.5px solid #e2e8f0; border-radius: 7px;
        font-size: .8rem; font-family: inherit; color: #0f172a;
        background: #f8fafc; outline: none; cursor: pointer; transition: border-color .2s;
    }
    .pad-perpage select:focus { border-color: #4ec7d2; }

    /* ── Tabla card ── */
    .pad-card {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-sm);
    }
    .pad-card-head {
        background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-mid) 100%);
        padding: .9rem 1.4rem; display: flex; align-items: center; gap: .6rem;
    }
    .pad-card-head i    { color: var(--teal); font-size: 1rem; }
    .pad-card-head span { color: white; font-weight: 700; font-size: .95rem; }

    /* ── Scroll horizontal — sin ocultar columnas ── */
    .pad-tbl-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .pad-tbl { width: 100%; border-collapse: collapse; min-width: 760px; }
    .pad-tbl thead th {
        background: var(--surface); padding: .6rem .75rem;
        font-size: .67rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .06em; color: var(--text-muted);
        border-bottom: 1.5px solid var(--border); white-space: nowrap;
    }
    .pad-tbl thead th.tc { text-align: center; }
    .pad-tbl tbody td {
        padding: .65rem .75rem; border-bottom: 1px solid #f1f5f9;
        font-size: .82rem; color: var(--text-main); vertical-align: middle;
    }
    .pad-tbl tbody td.tc { text-align: center; }
    .pad-tbl tbody tr:last-child td { border-bottom: none; }
    .pad-tbl tbody tr { transition: background .15s; }
    .pad-tbl tbody tr:hover { background: #f7fbff; }
    .pad-tbl tbody tr.hidden { display: none; }

    /* Columna acciones fija */
    .col-acciones { width: 105px; min-width: 105px; }

    .row-num {
        width: 24px; height: 24px; border-radius: 6px;
        background: var(--surface); border: 1px solid var(--border);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: .7rem; font-weight: 700; color: var(--text-muted);
    }

    .pad-av {
        width: 36px; height: 36px; border-radius: 9px;
        background: linear-gradient(135deg, var(--teal), var(--blue-mid));
        display: inline-flex; align-items: center; justify-content: center;
        color: white; font-weight: 700; font-size: .85rem; flex-shrink: 0;
        border: 2px solid rgba(78,199,210,.3);
    }
    .pad-name { font-weight: 600; color: var(--blue-dark); font-size: .85rem; }
    .pad-sub  { font-size: .71rem; color: var(--text-muted); margin-top: .1rem; }

    .bpill {
        display: inline-flex; align-items: center; gap: .22rem;
        padding: .2rem .6rem; border-radius: 999px;
        font-size: .7rem; font-weight: 600; white-space: nowrap;
    }
    .b-blue  { background: var(--teal-light); color: var(--blue-mid); border: 1px solid rgba(78,199,210,.35); }
    .b-green { background: rgba(16,185,129,.1); color: #059669; border: 1px solid rgba(16,185,129,.3); }
    .b-red   { background: rgba(239,68,68,.1); color: #dc2626; border: 1px solid rgba(239,68,68,.25); }
    .b-amber { background: rgba(245,158,11,.1); color: #92400e; border: 1px solid rgba(245,158,11,.3); }
    .b-gray  { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }

    .hijo-chip {
        display: inline-flex; align-items: center; gap: .22rem;
        padding: .18rem .5rem; border-radius: 6px;
        background: rgba(78,199,210,.1); color: var(--blue-mid);
        font-size: .68rem; font-weight: 600;
        border: 1px solid rgba(78,199,210,.25); margin: .1rem;
    }

    .badge-estado { display: inline-flex; align-items: center; gap: .28rem; padding: .22rem .6rem; border-radius: 999px; font-size: .7rem; font-weight: 700; white-space: nowrap; }
    .badge-activo   { background: rgba(78,199,210,.15); color: var(--blue-mid); border: 1px solid rgba(78,199,210,.4); }
    .badge-inactivo { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
    .dot { width: 5px; height: 5px; border-radius: 50%; display: inline-block; flex-shrink: 0; }
    .dot-teal { background: var(--teal); }
    .dot-red  { background: var(--red); }

    /* ── Botones acción compactos — todos visibles ── */
    .act-wrap {
        display: inline-flex; gap: 3px;
        align-items: center; flex-wrap: nowrap; justify-content: center;
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
    .act-del  { border-color: var(--red);      color: var(--red); }
    .act-view:hover { background: var(--blue-mid); color: white; }
    .act-edit:hover { background: var(--teal);     color: white; }
    .act-del:hover  { background: var(--red);      color: white; }

    .pad-empty { padding: 4rem 1rem; text-align: center; }
    .pad-empty i  { font-size: 2.5rem; color: #cbd5e1; display: block; margin-bottom: 1rem; }
    .pad-empty h6 { color: var(--blue-dark); font-weight: 600; margin-bottom: .4rem; }
    .pad-empty p  { font-size: .83rem; color: var(--text-muted); margin: 0; }

    .pad-footer {
        padding: .85rem 1.25rem; border-top: 1px solid var(--border);
        background: var(--surface);
        display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .5rem;
    }
    .pad-footer-info { font-size: .78rem; color: var(--text-muted); }

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

    .no-results-row td { padding: 2rem; text-align: center; color: #94a3b8; font-size: .83rem; }

    /* ── Responsive — sin ocultar columnas ── */
    @media(max-width: 768px) {
        .pad-toolbar { flex-direction: column; align-items: stretch; gap: .75rem; }
        .pad-badge-info { justify-content: center; flex-wrap: wrap; gap: .75rem; }
        .pad-footer { flex-direction: column; align-items: center; gap: .75rem; }
        .pad-tbl thead th, .pad-tbl tbody td { padding: .5rem .45rem; font-size: .74rem; }
    }
    @media(max-width: 480px) {
        .pad-stats { grid-template-columns: 1fr; }
        .pad-name  { font-size: .8rem; }
        .pad-sub   { font-size: .67rem; }
    }
</style>
@endpush

@section('content')
<div>

    {{-- ── STATS ── --}}
    <div class="pad-stats">
        <div class="pad-stat pad-stat-total">
            <div class="pad-stat-icon"><i class="fas fa-users"></i></div>
            <div>
                <div class="pad-stat-lbl">Total</div>
                <div class="pad-stat-num">{{ $padres->total() }}</div>
                <div class="pad-stat-sub">Padres / Tutores</div>
            </div>
        </div>
        <div class="pad-stat pad-stat-active">
            <div class="pad-stat-icon"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="pad-stat-lbl">Activos</div>
                <div class="pad-stat-num">{{ $padres->getCollection()->where('estado', 1)->count() }}</div>
                <div class="pad-stat-sub">Con acceso al sistema</div>
            </div>
        </div>
        <div class="pad-stat pad-stat-hijos">
            <div class="pad-stat-icon"><i class="fas fa-child"></i></div>
            <div>
                <div class="pad-stat-lbl">Con Hijos</div>
                <div class="pad-stat-num">{{ $padres->getCollection()->filter(fn($p) => $p->estudiantes->count() > 0)->count() }}</div>
                <div class="pad-stat-sub">Hijos vinculados</div>
            </div>
        </div>
    </div>

    {{-- ── TOOLBAR ── --}}
    <div class="pad-toolbar">
        <div class="pad-search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" class="pad-search"
                   placeholder="Buscar por nombre, DNI o correo...">
        </div>
        <div class="pad-badge-info">
            <span>
                <i class="fas fa-users" style="color:var(--blue-mid);"></i>
                <strong id="visibleCount" style="color:var(--blue-mid);">{{ $padres->total() }}</strong>
                <span style="color:var(--text-muted);">Total</span>
            </span>
            <span>
                <i class="fas fa-check-circle" style="color:var(--green);"></i>
                <strong style="color:var(--green);">{{ $padres->getCollection()->where('estado', 1)->count() }}</strong>
                <span style="color:var(--text-muted);">Activos</span>
            </span>
        </div>
        <div class="pad-perpage">
            <label><i class="fas fa-list-ol" style="color:#4ec7d2;"></i> Mostrar:</label>
            <select onchange="cambiarPerPage(this.value)">
                @foreach([10, 25, 50] as $op)
                    <option value="{{ $op }}" {{ request('per_page', 15) == $op ? 'selected' : '' }}>
                        {{ $op }} por página
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- ── TABLA ── --}}
    <div class="pad-card">
        <div class="pad-card-head">
            <i class="fas fa-list-ul"></i>
            <span>Lista de Padres y Tutores</span>
        </div>

        <div class="pad-tbl-wrapper">
            <table class="pad-tbl" id="padsTable">
                <thead>
                    <tr>
                        <th class="tc" style="width:44px;">#</th>
                        <th style="width:48px;">Foto</th>
                        <th>Padre / Tutor</th>
                        <th style="width:160px;">Contacto</th>
                        <th class="tc" style="width:100px;">Parentesco</th>
                        <th>Hijos Vinculados</th>
                        <th class="tc" style="width:90px;">Estado</th>
                        <th class="tc col-acciones">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @forelse($padres as $i => $padre)
                    <tr class="pad-row"
                        data-search="{{ strtolower(($padre->nombre ?? '') . ' ' . ($padre->apellido ?? '') . ' ' . ($padre->dni ?? '') . ' ' . ($padre->correo ?? '')) }}">

                        {{-- Número de fila --}}
                        <td class="tc">
                            <span class="row-num">{{ $padres->firstItem() + $i }}</span>
                        </td>

                        {{-- Avatar --}}
                        <td>
                            <div class="pad-av">{{ strtoupper(substr($padre->nombre ?? 'P', 0, 1)) }}</div>
                        </td>

                        {{-- Nombre --}}
                        <td>
                            <div class="pad-name">{{ $padre->nombre }} {{ $padre->apellido }}</div>
                            @if($padre->dni)
                                <div class="pad-sub">
                                    <i class="fas fa-id-card" style="font-size:.63rem;"></i> {{ $padre->dni }}
                                </div>
                            @endif
                        </td>

                        {{-- Contacto --}}
                        <td>
                            @if($padre->correo)
                                <div class="pad-sub">
                                    <i class="fas fa-envelope" style="color:var(--teal);font-size:.68rem;"></i> {{ $padre->correo }}
                                </div>
                            @endif
                            @if($padre->telefono)
                                <div class="pad-sub">
                                    <i class="fas fa-phone" style="color:var(--teal);font-size:.68rem;"></i> {{ $padre->telefono }}
                                </div>
                            @endif
                            @if(!$padre->correo && !$padre->telefono)
                                <span style="color:#cbd5e1;font-size:.73rem;font-style:italic;">Sin contacto</span>
                            @endif
                        </td>

                        {{-- Parentesco --}}
                        <td class="tc">
                            @php
                                $parentesco = match($padre->parentesco ?? '') {
                                    'padre'            => ['Padre',      'b-blue'],
                                    'madre'            => ['Madre',      'b-green'],
                                    'tutor_legal'      => ['Tutor Legal','b-amber'],
                                    'abuelo', 'abuela' => ['Abuelo/a',  'b-gray'],
                                    default            => [ucfirst($padre->parentesco ?? '—'), 'b-gray'],
                                };
                            @endphp
                            <span class="bpill {{ $parentesco[1] }}">{{ $parentesco[0] }}</span>
                        </td>

                        {{-- Hijos Vinculados --}}
                        <td>
                            @if($padre->estudiantes->count() > 0)
                                @foreach($padre->estudiantes as $est)
                                    <span class="hijo-chip">
                                        <i class="fas fa-user-graduate" style="font-size:.58rem;"></i>
                                        {{ $est->nombre1 }} {{ $est->apellido1 }}
                                    </span>
                                @endforeach
                            @else
                                <span style="color:#cbd5e1;font-size:.73rem;font-style:italic;">Sin hijos vinculados</span>
                            @endif
                        </td>

                        {{-- Estado --}}
                        <td class="tc">
                            @if($padre->estado)
                                <span class="badge-estado badge-activo">
                                    <span class="dot dot-teal"></span> Activo
                                </span>
                            @else
                                <span class="badge-estado badge-inactivo">
                                    <span class="dot dot-red"></span> Inactivo
                                </span>
                            @endif
                        </td>

                        {{-- Acciones — 3 botones siempre visibles --}}
                        <td class="tc col-acciones">
                            <div class="act-wrap">
                                <a href="{{ route('padres.show', $padre->id) }}"
                                   class="act-btn act-view" title="Ver detalle">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('padres.edit', $padre->id) }}"
                                   class="act-btn act-edit" title="Editar">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <button type="button"
                                        class="act-btn act-del" title="Eliminar"
                                        onclick="mostrarModalDeleteData(this)"
                                        data-route="{{ route('padres.destroy', $padre->id) }}"
                                        data-name="{{ $padre->nombre }} {{ $padre->apellido }}"
                                        data-message="¿Estás seguro de eliminar a este padre/tutor?">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="pad-empty">
                                <i class="fas fa-users"></i>
                                <h6>No hay padres/tutores registrados</h6>
                                <p>Comienza agregando el primer padre o tutor al sistema</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($padres->hasPages())
            <div class="pad-footer">
                <span class="pad-footer-info">
                    Mostrando {{ $padres->firstItem() }}–{{ $padres->lastItem() }}
                    de {{ $padres->total() }} padres/tutores
                </span>
                {{ $padres->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input        = document.getElementById('searchInput');
    const tbody        = document.getElementById('tableBody');
    const visibleCount = document.getElementById('visibleCount');

    if (!input || !tbody) return;

    input.addEventListener('input', function () {
        const term = this.value.toLowerCase().trim();

        const noRow = tbody.querySelector('.no-results-row');
        if (noRow) noRow.remove();

        let visible = 0;

        tbody.querySelectorAll('.pad-row').forEach(function (row) {
            const texto = row.dataset.search || row.textContent.toLowerCase();
            const match = term === '' || texto.includes(term);
            row.classList.toggle('hidden', !match);
            if (match) visible++;
        });

        if (visibleCount) visibleCount.textContent = visible;

        if (visible === 0 && term !== '') {
            const tr = document.createElement('tr');
            tr.className = 'no-results-row';
            tr.innerHTML = `<td colspan="8" style="text-align:center;padding:3rem 1rem;">
                <i class="fas fa-search" style="font-size:1.75rem;color:#cbd5e1;display:block;margin-bottom:.75rem;"></i>
                <p style="color:#94a3b8;margin:0;font-size:.85rem;">
                    Sin resultados para <strong style="color:#0d2137;">"${term}"</strong>
                </p>
            </td>`;
            tbody.appendChild(tr);
        }
    });
});

function cambiarPerPage(val) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', val);
    url.searchParams.set('page', 1);
    window.location.href = url.toString();
}
</script>
@endpush