@extends('layouts.app')

@section('title', 'Profesores')
@section('page-title', 'Gestión de Profesores')

@section('topbar-actions')
    <a href="{{ route('profesores.create') }}" class="prof-topbar-btn">
        <i class="fas fa-plus"></i>
        <span class="prof-btn-text">Nuevo Profesor</span>
    </a>
@endsection

@push('styles')
<style>
    /* ── Botón topbar ── */
    .prof-topbar-btn {
        display: inline-flex; align-items: center; gap: .45rem;
        background: linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);
        color: white; padding: .5rem .9rem; border-radius: 8px;
        text-decoration: none; font-weight: 600; font-size: .83rem;
        box-shadow: 0 2px 8px rgba(78,199,210,0.3); white-space: nowrap;
    }
    .prof-topbar-btn:hover { opacity: .88; color: white; }
    @media(max-width: 600px) {
        .prof-btn-text { display: none; }
        .prof-topbar-btn { padding: .5rem .65rem; }
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
        --purple:      #8b5cf6;
        --radius-lg:   14px;
        --radius-md:   10px;
        --radius-sm:   7px;
        --shadow-sm:   0 1px 4px rgba(0,59,115,0.07);
        --shadow-md:   0 4px 16px rgba(0,59,115,0.10);
    }

    /* ── Stats ── */
    .prof-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    @media(max-width:900px){ .prof-stats { grid-template-columns: repeat(2,1fr); } }
    @media(max-width:540px){ .prof-stats { grid-template-columns: 1fr 1fr; gap:.75rem; } }

    .prof-stat {
        background: white; border-radius: var(--radius-lg);
        border: 1px solid var(--border); padding: 1.1rem 1.25rem;
        display: flex; align-items: center; gap: 1rem;
        box-shadow: var(--shadow-sm); transition: transform .2s, box-shadow .2s;
        position: relative; overflow: hidden;
    }
    .prof-stat::before {
        content: ''; position: absolute; top: 0; left: 0;
        width: 4px; height: 100%; border-radius: 4px 0 0 4px;
    }
    .prof-stat-total::before    { background: var(--teal); }
    .prof-stat-active::before   { background: var(--green); }
    .prof-stat-licencia::before { background: var(--amber); }
    .prof-stat-inactive::before { background: var(--red); }
    .prof-stat:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

    .prof-stat-icon {
        width: 46px; height: 46px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-size: 1.15rem;
    }
    .prof-stat-total    .prof-stat-icon { background: var(--teal-light);        color: var(--teal); }
    .prof-stat-active   .prof-stat-icon { background: rgba(16,185,129,.12);     color: var(--green); }
    .prof-stat-licencia .prof-stat-icon { background: rgba(245,158,11,.12);     color: var(--amber); }
    .prof-stat-inactive .prof-stat-icon { background: rgba(239,68,68,.12);      color: var(--red); }

    .prof-stat-lbl { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--text-muted); margin-bottom: .2rem; }
    .prof-stat-num { font-size: 1.75rem; font-weight: 800; color: var(--blue-dark); line-height: 1; margin-bottom: .1rem; }
    .prof-stat-sub { font-size: .73rem; color: var(--text-muted); }

    /* ── Toolbar ── */
    .prof-toolbar {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); padding: .9rem 1.25rem;
        margin-bottom: 1.25rem;
        display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;
        box-shadow: var(--shadow-sm);
    }
    .prof-search-wrap { position: relative; flex: 1; min-width: 220px; }
    .prof-search-wrap i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--blue-mid); font-size: .85rem; pointer-events: none; }
    .prof-search {
        width: 100%; padding: .5rem 1rem .5rem 2.4rem;
        border: 1.5px solid var(--border); border-radius: var(--radius-sm);
        font-size: .85rem; background: var(--surface); outline: none;
        transition: border-color .2s, box-shadow .2s;
        font-family: inherit; color: var(--text-main);
    }
    .prof-search:focus { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(78,199,210,.15); background: white; }

    .prof-badge-info { display: flex; align-items: center; gap: 1.25rem; flex-shrink: 0; }
    .prof-badge-info span { display: flex; align-items: center; gap: .4rem; font-size: .82rem; }

    .prof-perpage { display: flex; align-items: center; gap: .5rem; font-size: .8rem; color: #64748b; }
    .prof-perpage label { white-space: nowrap; font-weight: 500; }
    .prof-perpage select {
        padding: .3rem .6rem; border: 1.5px solid #e2e8f0; border-radius: 7px;
        font-size: .8rem; font-family: inherit; color: #0f172a;
        background: #f8fafc; outline: none; cursor: pointer; transition: border-color .2s;
    }
    .prof-perpage select:focus { border-color: #4ec7d2; }

    /* ── Tabla card ── */
    .prof-card {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-sm);
    }
    .prof-card-head {
        background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-mid) 100%);
        padding: .9rem 1.4rem; display: flex; align-items: center; gap: .6rem;
    }
    .prof-card-head i    { color: var(--teal); font-size: 1rem; }
    .prof-card-head span { color: white; font-weight: 700; font-size: .95rem; }

    /* ── Scroll horizontal — sin ocultar columnas ── */
    .prof-tbl-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .prof-tbl { width: 100%; border-collapse: collapse; min-width: 730px; }
    .prof-tbl thead th {
        background: var(--surface); padding: .6rem .75rem;
        font-size: .67rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .06em; color: var(--text-muted);
        border-bottom: 1.5px solid var(--border); white-space: nowrap;
    }
    .prof-tbl thead th.tc { text-align: center; }
    .prof-tbl tbody td {
        padding: .65rem .75rem; border-bottom: 1px solid #f1f5f9;
        font-size: .82rem; color: var(--text-main); vertical-align: middle;
    }
    .prof-tbl tbody td.tc { text-align: center; }
    .prof-tbl tbody tr:last-child td { border-bottom: none; }
    .prof-tbl tbody tr { transition: background .15s; }
    .prof-tbl tbody tr:hover { background: #f7fbff; }
    .prof-tbl tbody tr.hidden { display: none; }

    /* Columna acciones fija */
    .col-acciones { width: 105px; min-width: 105px; }

    .row-num {
        width: 24px; height: 24px; border-radius: 6px;
        background: var(--surface); border: 1px solid var(--border);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: .7rem; font-weight: 700; color: var(--text-muted);
    }

    .prof-av {
        width: 36px; height: 36px; border-radius: 9px;
        background: linear-gradient(135deg, var(--teal), var(--blue-mid));
        display: inline-flex; align-items: center; justify-content: center;
        color: white; font-weight: 700; font-size: .85rem; flex-shrink: 0;
        border: 2px solid rgba(78,199,210,.3);
    }
    .prof-name  { font-weight: 600; color: var(--blue-dark); font-size: .85rem; }
    .prof-email { font-size: .71rem; color: var(--text-muted); margin-top: .1rem; }

    .prof-dni {
        font-family: 'Courier New', monospace;
        font-size: .79rem; color: var(--blue-mid); font-weight: 600;
        background: rgba(0,80,143,.06); padding: .18rem .45rem;
        border-radius: 5px; white-space: nowrap;
    }

    .chip { display: inline-flex; align-items: center; padding: .2rem .55rem; border-radius: 999px; font-size: .7rem; font-weight: 600; white-space: nowrap; }
    .chip-teal   { background: var(--teal-light); color: var(--blue-mid); border: 1px solid rgba(78,199,210,.35); }
    .chip-blue   { background: rgba(0,80,143,.08); color: var(--blue-dark); border: 1px solid rgba(0,80,143,.2); }
    .chip-indigo { background: rgba(99,102,241,.1); color: #4f46e5; border: 1px solid rgba(99,102,241,.25); }

    .badge-estado { display: inline-flex; align-items: center; gap: .28rem; padding: .22rem .6rem; border-radius: 999px; font-size: .7rem; font-weight: 700; white-space: nowrap; }
    .badge-activo   { background: rgba(16,185,129,.12); color: #059669; border: 1px solid rgba(16,185,129,.35); }
    .badge-licencia { background: rgba(245,158,11,.12); color: #92400e; border: 1px solid rgba(245,158,11,.35); }
    .badge-inactivo { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
    .dot { width: 5px; height: 5px; border-radius: 50%; display: inline-block; flex-shrink: 0; }
    .dot-green { background: var(--green); }
    .dot-amber { background: var(--amber); }
    .dot-red   { background: var(--red); }

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

    .prof-empty { padding: 4rem 1rem; text-align: center; }
    .prof-empty i  { font-size: 2.5rem; color: #cbd5e1; display: block; margin-bottom: 1rem; }
    .prof-empty h6 { color: var(--blue-dark); font-weight: 600; margin-bottom: .4rem; }
    .prof-empty p  { font-size: .83rem; color: var(--text-muted); margin-bottom: 1.25rem; }

    .prof-footer {
        padding: .85rem 1.25rem; border-top: 1px solid var(--border);
        background: var(--surface);
        display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .5rem;
    }
    .prof-footer-info { font-size: .78rem; color: var(--text-muted); }

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
        .prof-toolbar { flex-direction: column; align-items: stretch; gap: .75rem; }
        .prof-search-wrap { min-width: unset; }
        .prof-badge-info { justify-content: center; flex-wrap: wrap; gap: .75rem; }
        .prof-footer { flex-direction: column; align-items: center; text-align: center; gap: .75rem; }
        .prof-tbl thead th, .prof-tbl tbody td { padding: .5rem .45rem; font-size: .74rem; }
    }
    @media(max-width: 480px) {
        .prof-stats { grid-template-columns: repeat(2,1fr); gap: .65rem; }
        .prof-stat  { padding: .85rem .9rem; gap: .75rem; }
        .prof-stat-num  { font-size: 1.45rem; }
        .prof-stat-icon { width: 38px; height: 38px; font-size: .95rem; }
        .prof-name  { font-size: .8rem; }
        .prof-email { font-size: .67rem; }
    }
</style>
@endpush

@section('content')
<div>

    {{-- ── STATS ── --}}
    <div class="prof-stats">
        <div class="prof-stat prof-stat-total">
            <div class="prof-stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
            <div>
                <div class="prof-stat-lbl">Total</div>
                <div class="prof-stat-num">{{ $profesores->total() }}</div>
                <div class="prof-stat-sub">Profesores</div>
            </div>
        </div>
        <div class="prof-stat prof-stat-active">
            <div class="prof-stat-icon"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="prof-stat-lbl">Activos</div>
                <div class="prof-stat-num">{{ $profesores->getCollection()->where('estado','activo')->count() }}</div>
                <div class="prof-stat-sub">En servicio</div>
            </div>
        </div>
        <div class="prof-stat prof-stat-licencia">
            <div class="prof-stat-icon"><i class="fas fa-clock"></i></div>
            <div>
                <div class="prof-stat-lbl">Licencia</div>
                <div class="prof-stat-num">{{ $profesores->getCollection()->where('estado','licencia')->count() }}</div>
                <div class="prof-stat-sub">Con permiso</div>
            </div>
        </div>
        <div class="prof-stat prof-stat-inactive">
            <div class="prof-stat-icon"><i class="fas fa-user-times"></i></div>
            <div>
                <div class="prof-stat-lbl">Inactivos</div>
                <div class="prof-stat-num">{{ $profesores->getCollection()->where('estado','inactivo')->count() }}</div>
                <div class="prof-stat-sub">Sin actividad</div>
            </div>
        </div>
    </div>

    {{-- ── TOOLBAR ── --}}
    <div class="prof-toolbar">
        <div class="prof-search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" class="prof-search"
                   placeholder="Buscar por nombre, DNI, especialidad...">
        </div>
        <div class="prof-badge-info">
            <span>
                <i class="fas fa-chalkboard-teacher" style="color:var(--blue-mid);"></i>
                <strong id="visibleCount" style="color:var(--blue-mid);">{{ $profesores->total() }}</strong>
                <span style="color:var(--text-muted);">Total</span>
            </span>
            <span>
                <i class="fas fa-check-circle" style="color:var(--green);"></i>
                <strong style="color:var(--green);">{{ $profesores->getCollection()->where('estado','activo')->count() }}</strong>
                <span style="color:var(--text-muted);">Activos</span>
            </span>
        </div>
        <div class="prof-perpage">
            <label for="perPageSelect"><i class="fas fa-list-ol" style="color:#4ec7d2;"></i> Mostrar:</label>
            <select id="perPageSelect" onchange="cambiarPerPage(this.value)">
                @foreach([10, 25, 50] as $op)
                    <option value="{{ $op }}" {{ request('per_page', 10) == $op ? 'selected' : '' }}>
                        {{ $op }} por página
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- ── TABLA ── --}}
    <div class="prof-card">
        <div class="prof-card-head">
            <i class="fas fa-list-ul"></i>
            <span>Lista de Profesores</span>
        </div>

        <div class="prof-tbl-wrapper">
            <table class="prof-tbl" id="profsTable">
                <thead>
                    <tr>
                        <th class="tc" style="width:44px;">#</th>
                        <th style="width:48px;">Foto</th>
                        <th>Profesor</th>
                        <th style="width:120px;">DNI</th>
                        <th class="tc" style="width:130px;">Especialidad</th>
                        <th class="tc" style="width:110px;">Contrato</th>
                        <th class="tc" style="width:90px;">Estado</th>
                        <th class="tc col-acciones">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @forelse($profesores as $i => $profesor)
                    <tr class="prof-row"
                        data-search="{{ strtolower(($profesor->nombre ?? '') . ' ' . ($profesor->apellido ?? '') . ' ' . ($profesor->dni ?? '') . ' ' . ($profesor->especialidad ?? '') . ' ' . ($profesor->email ?? '')) }}">

                        {{-- Número de fila --}}
                        <td class="tc">
                            <span class="row-num">{{ $profesores->firstItem() + $i }}</span>
                        </td>

                        {{-- Avatar --}}
                        <td>
                            <div class="prof-av">
                                {{ strtoupper(substr($profesor->nombre ?? 'P', 0, 1) . substr($profesor->apellido ?? '', 0, 1)) }}
                            </div>
                        </td>

                        {{-- Nombre --}}
                        <td>
                            <div class="prof-name">{{ $profesor->nombre_completo }}</div>
                            @if($profesor->email)
                                <div class="prof-email">{{ $profesor->email }}</div>
                            @endif
                        </td>

                        {{-- DNI --}}
                        <td>
                            @if($profesor->dni)
                                <span class="prof-dni">{{ $profesor->dni }}</span>
                            @else
                                <span style="color:#cbd5e1;">—</span>
                            @endif
                        </td>

                        {{-- Especialidad --}}
                        <td class="tc">
                            @if($profesor->especialidad)
                                <span class="chip chip-teal">{{ $profesor->especialidad }}</span>
                            @else
                                <span style="color:#cbd5e1;font-size:.75rem;">—</span>
                            @endif
                        </td>

                        {{-- Contrato --}}
                        <td class="tc">
                            @if($profesor->tipo_contrato)
                                <span class="chip chip-indigo">
                                    {{ ucwords(str_replace('_', ' ', $profesor->tipo_contrato)) }}
                                </span>
                            @else
                                <span style="color:#cbd5e1;font-size:.75rem;">—</span>
                            @endif
                        </td>

                        {{-- Estado --}}
                        <td class="tc">
                            @if($profesor->estado === 'activo')
                                <span class="badge-estado badge-activo">
                                    <span class="dot dot-green"></span> Activo
                                </span>
                            @elseif($profesor->estado === 'licencia')
                                <span class="badge-estado badge-licencia">
                                    <span class="dot dot-amber"></span> Licencia
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
                                <a href="{{ route('profesores.show', $profesor->id) }}"
                                   class="act-btn act-view" title="Ver Perfil">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('profesores.edit', $profesor->id) }}"
                                   class="act-btn act-edit" title="Editar">
                                    <i class="fas fa-pen"></i>
                                </a>
                               <button type="button"
        class="act-btn act-del" title="Eliminar"
        onclick="mostrarModalDelete(
            '{{ route('profesores.destroy', $profesor->id) }}',
            '{{ addslashes($profesor->nombre_completo) }}'
        )">
    <i class="fas fa-trash"></i>
</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="prof-empty">
                                <i class="fas fa-chalkboard-teacher"></i>
                                <h6>No hay profesores registrados</h6>
                                <p>Comienza agregando el primer profesor al sistema</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($profesores->hasPages())
            <div class="prof-footer">
                <span class="prof-footer-info">
                    Mostrando {{ $profesores->firstItem() }}–{{ $profesores->lastItem() }}
                    de {{ $profesores->total() }} profesores
                </span>
                {{ $profesores->appends(request()->query())->links() }}
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

        tbody.querySelectorAll('.prof-row').forEach(function (row) {
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