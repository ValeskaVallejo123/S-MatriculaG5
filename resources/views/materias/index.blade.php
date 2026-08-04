@extends('layouts.app')

@section('title', 'Materias')
@section('page-title', 'Gestión de Materias')

@section('topbar-actions')
    <a href="{{ route('superadmin.materias.create') }}" class="mat-topbar-btn">
        <i class="fas fa-plus"></i>
        <span class="mat-btn-text">Nueva Materia</span>
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
    @media(max-width:600px) {
        .mat-btn-text { display: none; }
        .mat-topbar-btn { padding: .5rem .65rem; }
    }

    /* ── Variables ── */
    :root {
        --blue-dark:  #003b73; --blue-mid: #00508f;
        --teal:       #4ec7d2; --teal-light: rgba(78,199,210,0.12);
        --border:     #e8edf4; --surface: #f5f8fc;
        --text-main:  #0d2137; --text-muted: #6b7a90;
        --green:      #10b981; --amber: #f59e0b; --red: #ef4444;
        --radius-lg:  14px; --radius-sm: 7px;
        --shadow-sm:  0 1px 4px rgba(0,59,115,0.07);
        --shadow-md:  0 4px 16px rgba(0,59,115,0.10);
    }

    /* ── Stats ── */
    .mat-stats {
        display: grid; grid-template-columns: repeat(4,1fr);
        gap: 1rem; margin-bottom: 1.5rem;
    }
    @media(max-width:900px){ .mat-stats { grid-template-columns: repeat(2,1fr); } }
    @media(max-width:480px){ .mat-stats { grid-template-columns: 1fr 1fr; gap:.75rem; } }

    .mat-stat {
        background: white; border-radius: var(--radius-lg);
        border: 1px solid var(--border);
        padding: 1.1rem 1.25rem; display: flex; align-items: center; gap: 1rem;
        box-shadow: var(--shadow-sm);
        transition: transform .2s, box-shadow .2s;
        position: relative; overflow: hidden;
    }
    .mat-stat::before {
        content: ''; position: absolute; top: 0; left: 0;
        width: 4px; height: 100%; border-radius: 4px 0 0 4px;
    }
    .ms-total::before      { background: var(--teal); }
    .ms-activas::before    { background: var(--green); }
    .ms-primaria::before   { background: #4ec7d2; }
    .ms-secundaria::before { background: #818cf8; }
    .mat-stat:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

    .mat-stat-icon {
        width: 46px; height: 46px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-size: 1.15rem;
    }
    .ms-total      .mat-stat-icon { background: var(--teal-light);     color: var(--teal); }
    .ms-activas    .mat-stat-icon { background: rgba(16,185,129,.12);   color: var(--green); }
    .ms-primaria   .mat-stat-icon { background: rgba(78,199,210,.15);   color: var(--teal); }
    .ms-secundaria .mat-stat-icon { background: rgba(129,140,248,.15);  color: #4f46e5; }

    .mat-stat-lbl { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--text-muted); margin-bottom: .2rem; }
    .mat-stat-num { font-size: 1.75rem; font-weight: 800; color: var(--blue-dark); line-height: 1; margin-bottom: .1rem; }
    .mat-stat-sub { font-size: .73rem; color: var(--text-muted); }

    /* ── Toolbar ── */
    .mat-toolbar {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); padding: .9rem 1.25rem;
        margin-bottom: 1.25rem;
        display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;
        box-shadow: var(--shadow-sm);
    }
    .mat-search-wrap { position: relative; flex: 1; min-width: 220px; }
    .mat-search-wrap i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--blue-mid); font-size: .85rem; pointer-events: none; }
    .mat-search {
        width: 100%; padding: .5rem 1rem .5rem 2.4rem;
        border: 1.5px solid var(--border); border-radius: var(--radius-sm);
        font-size: .85rem; background: var(--surface); outline: none;
        transition: border-color .2s, box-shadow .2s; font-family: inherit; color: var(--text-main);
    }
    .mat-search:focus { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(78,199,210,.15); background: white; }

    .mat-filter select {
        padding: .42rem .75rem; border: 1.5px solid var(--border); border-radius: 7px;
        font-size: .82rem; color: var(--text-main); background: var(--surface);
        outline: none; cursor: pointer; font-family: inherit;
    }
    .mat-filter select:focus { border-color: var(--teal); }

    .mat-badge-info { display: flex; align-items: center; gap: 1.25rem; flex-shrink: 0; }
    .mat-badge-info span { display: flex; align-items: center; gap: .4rem; font-size: .82rem; }

    /* ── Tabs ── */
    .mat-tabs { display: flex; gap: .4rem; margin-bottom: 1.25rem; flex-wrap: wrap; }
    .mat-tab {
        padding: .42rem 1.1rem; border-radius: 8px; font-size: .82rem; font-weight: 600;
        border: 1.5px solid var(--border); background: white; color: #64748b;
        cursor: pointer; transition: all .15s; display: inline-flex; align-items: center; gap: .4rem;
    }
    .mat-tab.active { background: linear-gradient(135deg,var(--teal),var(--blue-mid)); color: #fff; border-color: transparent; }
    .mat-tab:not(.active):hover { border-color: var(--teal); color: var(--blue-mid); background: #e8f8f9; }

    /* ── Tabla card ── */
    .mat-card {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); overflow: hidden;
        box-shadow: var(--shadow-sm);
    }
    .mat-card-head {
        background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-mid) 100%);
        padding: .9rem 1.4rem; display: flex; align-items: center; gap: .6rem;
    }
    .mat-card-head i    { color: var(--teal); font-size: 1rem; }
    .mat-card-head span { color: white; font-weight: 700; font-size: .95rem; }

    /* ── Scroll horizontal — nunca ocultar columnas ── */
    .mat-tbl-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .mat-tbl { width: 100%; border-collapse: collapse; min-width: 680px; }
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
    .mat-tbl tbody tr.hidden { display: none; }

    /* Columna acciones fija */
    .col-acciones { width: 105px; min-width: 105px; }

    /* Número de fila */
    .row-num {
        width: 24px; height: 24px; border-radius: 6px;
        background: var(--surface); border: 1px solid var(--border);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: .7rem; font-weight: 700; color: var(--text-muted);
    }

    .mat-nombre { font-weight: 600; color: var(--blue-dark); font-size: .86rem; }
    .mat-desc   { font-size: .71rem; color: var(--text-muted); margin-top: .1rem; }

    .mat-code {
        font-family: 'Courier New', monospace; font-size: .78rem;
        color: var(--blue-mid); font-weight: 600;
        background: rgba(0,80,143,.06); padding: .18rem .45rem; border-radius: 5px;
        white-space: nowrap;
    }

    .bpill {
        display: inline-flex; align-items: center; gap: .25rem;
        padding: .2rem .6rem; border-radius: 999px;
        font-size: .7rem; font-weight: 600; white-space: nowrap;
    }
    .b-teal   { background: var(--teal-light); color: var(--blue-mid); border: 1px solid rgba(78,199,210,.35); }
    .b-indigo { background: rgba(99,102,241,.1); color: #4f46e5; border: 1px solid rgba(99,102,241,.25); }
    .b-blue   { background: rgba(0,80,143,.08); color: var(--blue-dark); border: 1px solid rgba(0,80,143,.2); }
    .b-green  { background: rgba(16,185,129,.1); color: #059669; border: 1px solid rgba(16,185,129,.3); }
    .b-red    { background: rgba(239,68,68,.1); color: #dc2626; border: 1px solid rgba(239,68,68,.25); }
    .dot { width: 5px; height: 5px; border-radius: 50%; display: inline-block; flex-shrink: 0; }
    .dot-teal { background: var(--teal); }
    .dot-red  { background: var(--red); }

    /* ── Botones acción compactos — todos visibles ── */
    .act-wrap {
        display: inline-flex;
        gap: 3px;
        align-items: center;
        flex-wrap: nowrap;
        justify-content: flex-end;
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

    .mat-empty { padding: 4rem 1rem; text-align: center; }
    .mat-empty i  { font-size: 2.5rem; color: #cbd5e1; display: block; margin-bottom: 1rem; }
    .mat-empty h6 { color: var(--blue-dark); font-weight: 600; margin-bottom: .4rem; }
    .mat-empty p  { font-size: .83rem; color: var(--text-muted); margin: 0; }

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
    .pagination .page-item.disabled .page-link { opacity: .45; }

    .no-results-row td { padding: 2rem; text-align: center; color: #94a3b8; font-size: .83rem; }

    /* ── Responsive — sin ocultar columnas ── */
    @media(max-width:768px) {
        .mat-toolbar { flex-direction: column; align-items: stretch; gap: .75rem; }
        .mat-badge-info { justify-content: center; flex-wrap: wrap; gap: .75rem; }
        .mat-footer { flex-direction: column; align-items: center; gap: .75rem; }
        .mat-tbl thead th, .mat-tbl tbody td { padding: .5rem .45rem; font-size: .74rem; }
    }
    @media(max-width:480px) {
        .mat-stats { grid-template-columns: repeat(2,1fr); gap: .65rem; }
        .mat-stat  { padding: .85rem .9rem; gap: .75rem; }
        .mat-stat-num { font-size: 1.45rem; }
        .mat-stat-icon { width: 38px; height: 38px; font-size: .95rem; }
        .mat-nombre { font-size: .8rem; }
        .mat-desc   { font-size: .67rem; }
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
    <div class="mat-stats">
        <div class="mat-stat ms-total">
            <div class="mat-stat-icon"><i class="fas fa-book"></i></div>
            <div>
                <div class="mat-stat-lbl">Total</div>
                <div class="mat-stat-num">{{ $materias->total() }}</div>
                <div class="mat-stat-sub">Materias</div>
            </div>
        </div>
        <div class="mat-stat ms-activas">
            <div class="mat-stat-icon"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="mat-stat-lbl">Activas</div>
                <div class="mat-stat-num">{{ $materias->getCollection()->where('activo', true)->count() }}</div>
                <div class="mat-stat-sub">Disponibles</div>
            </div>
        </div>
        <div class="mat-stat ms-primaria">
            <div class="mat-stat-icon"><i class="fas fa-school"></i></div>
            <div>
                <div class="mat-stat-lbl">Primaria</div>
                <div class="mat-stat-num">{{ $materias->getCollection()->where('nivel','primaria')->count() }}</div>
                <div class="mat-stat-sub">En esta página</div>
            </div>
        </div>
        <div class="mat-stat ms-secundaria">
            <div class="mat-stat-icon"><i class="fas fa-university"></i></div>
            <div>
                <div class="mat-stat-lbl">Secundaria</div>
                <div class="mat-stat-num">{{ $materias->getCollection()->where('nivel','secundaria')->count() }}</div>
                <div class="mat-stat-sub">En esta página</div>
            </div>
        </div>
    </div>

    {{-- ── TOOLBAR ── --}}
    <div class="mat-toolbar">
        <div class="mat-search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" class="mat-search"
                   placeholder="Buscar por nombre, código, área...">
        </div>
        <div class="mat-filter">
            <select id="filterNivel">
                <option value="">Todos los niveles</option>
                <option value="primaria">Primaria</option>
                <option value="secundaria">Secundaria</option>
            </select>
        </div>
        <div class="mat-badge-info">
            <span>
                <i class="fas fa-book" style="color:var(--blue-mid);"></i>
                <strong id="visibleCount" style="color:var(--blue-mid);">{{ $materias->total() }}</strong>
                <span style="color:var(--text-muted);">Total</span>
            </span>
            <span>
                <i class="fas fa-check-circle" style="color:var(--green);"></i>
                <strong style="color:var(--green);">{{ $materias->getCollection()->where('activo', true)->count() }}</strong>
                <span style="color:var(--text-muted);">Activas</span>
            </span>
        </div>
    </div>

    {{-- ── TABS ── --}}
    <div class="mat-tabs">
        <button class="mat-tab active" data-nivel="" onclick="setTab(this,'')">
            <i class="fas fa-list"></i> Todas
        </button>
        <button class="mat-tab" data-nivel="primaria" onclick="setTab(this,'primaria')">
            <i class="fas fa-school"></i> Primaria
        </button>
        <button class="mat-tab" data-nivel="secundaria" onclick="setTab(this,'secundaria')">
            <i class="fas fa-university"></i> Secundaria
        </button>
    </div>

    {{-- ── TABLA ── --}}
    <div class="mat-card">
        <div class="mat-card-head">
            <i class="fas fa-list-ul"></i>
            <span>Lista de Materias</span>
        </div>

        <div class="mat-tbl-wrapper">
            <table class="mat-tbl" id="materiasTable">
                <thead>
                    <tr>
                        <th class="tc" style="width:44px;">#</th>
                        <th style="width:95px;">Código</th>
                        <th>Nombre</th>
                        <th style="width:120px;">Área</th>
                        <th class="tc" style="width:100px;">Nivel</th>
                        <th class="tc" style="width:90px;">Estado</th>
                        <th class="tr col-acciones">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @forelse($materias as $i => $materia)
                    <tr class="mat-row"
                        data-nivel="{{ $materia->nivel }}"
                        data-search="{{ strtolower(($materia->codigo ?? '') . ' ' . $materia->nombre . ' ' . ($materia->area ?? '') . ' ' . ($materia->nivel ?? '')) }}">

                        {{-- Número de fila --}}
                        <td class="tc">
                            <span class="row-num">{{ $materias->firstItem() + $i }}</span>
                        </td>

                        {{-- Código --}}
                        <td>
                            <span class="mat-code">{{ $materia->codigo ?? '—' }}</span>
                        </td>

                        {{-- Nombre --}}
                        <td>
                            <div class="mat-nombre">{{ $materia->nombre }}</div>
                            @if($materia->descripcion)
                                <div class="mat-desc">{{ Str::limit($materia->descripcion, 55) }}</div>
                            @endif
                        </td>

                        {{-- Área --}}
                        <td>
                            @if($materia->area)
                                <span class="bpill b-blue">{{ $materia->area }}</span>
                            @else
                                <span style="color:#cbd5e1;font-size:.75rem;">—</span>
                            @endif
                        </td>

                        {{-- Nivel --}}
                        <td class="tc">
                            @if($materia->nivel === 'primaria')
                                <span class="bpill b-teal">
                                    <i class="fas fa-school" style="font-size:.63rem;"></i> Primaria
                                </span>
                            @elseif($materia->nivel === 'secundaria')
                                <span class="bpill b-indigo">
                                    <i class="fas fa-university" style="font-size:.63rem;"></i> Secundaria
                                </span>
                            @else
                                <span style="color:#cbd5e1;font-size:.75rem;">—</span>
                            @endif
                        </td>

                        {{-- Estado --}}
                        <td class="tc">
                            @if($materia->activo)
                                <span class="bpill b-green">
                                    <span class="dot dot-teal"></span> Activa
                                </span>
                            @else
                                <span class="bpill b-red">
                                    <span class="dot dot-red"></span> Inactiva
                                </span>
                            @endif
                        </td>

                        {{-- Acciones — 3 botones siempre completos --}}
                        <td class="tr col-acciones">
                            <div class="act-wrap">
                                <a href="{{ route('superadmin.materias.show', $materia) }}"
                                   class="act-btn act-view" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('superadmin.materias.edit', $materia) }}"
                                   class="act-btn act-edit" title="Editar">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <button type="button"
                                        class="act-btn act-del" title="Eliminar"
                                        onclick="mostrarModalDeleteData(this)"
                                        data-route="{{ route('superadmin.materias.destroy', $materia) }}"
                                        data-name="{{ $materia->nombre }}"
                                        data-message="¿Estás seguro de eliminar esta materia?">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="mat-empty">
                                <i class="fas fa-book"></i>
                                <h6>No hay materias registradas</h6>
                                <p>Comienza agregando la primera materia al sistema</p>
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
                    Mostrando {{ $materias->firstItem() }}–{{ $materias->lastItem() }}
                    de {{ $materias->total() }} materias
                </span>
                {{ $materias->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput  = document.getElementById('searchInput');
    const filterNivel  = document.getElementById('filterNivel');
    const tbody        = document.getElementById('tableBody');
    const visibleCount = document.getElementById('visibleCount');
    let   currentNivel = '';

    function filterRows() {
        const term  = searchInput.value.toLowerCase().trim();
        const noRow = tbody.querySelector('.no-results-row');
        if (noRow) noRow.remove();

        let visible = 0;

        tbody.querySelectorAll('.mat-row').forEach(function (row) {
            const text   = row.dataset.search || '';
            const nivel  = row.dataset.nivel  || '';
            const matchS = !term         || text.includes(term);
            const matchN = !currentNivel || nivel === currentNivel;
            const show   = matchS && matchN;
            row.classList.toggle('hidden', !show);
            if (show) visible++;
        });

        if (visibleCount) visibleCount.textContent = visible;

        if (visible === 0 && (term || currentNivel)) {
            const tr = document.createElement('tr');
            tr.className = 'no-results-row';
            tr.innerHTML = `<td colspan="7" style="text-align:center;padding:3rem 1rem;">
                <i class="fas fa-search" style="font-size:1.75rem;color:#cbd5e1;display:block;margin-bottom:.75rem;"></i>
                <p style="color:#94a3b8;margin:0;font-size:.85rem;">Sin resultados para los filtros aplicados</p>
            </td>`;
            tbody.appendChild(tr);
        }
    }

    searchInput.addEventListener('input', filterRows);

    filterNivel.addEventListener('change', function () {
        currentNivel = this.value;
        document.querySelectorAll('.mat-tab').forEach(function (t) {
            t.classList.toggle('active', t.dataset.nivel === currentNivel);
        });
        filterRows();
    });

    window.setTab = function (btn, nivel) {
        document.querySelectorAll('.mat-tab').forEach(function (t) { t.classList.remove('active'); });
        btn.classList.add('active');
        currentNivel = nivel;
        filterNivel.value = nivel;
        filterRows();
    };
});
</script>
@endpush