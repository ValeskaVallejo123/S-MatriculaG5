@extends('layouts.app')

@section('title', 'Grados')
@section('page-title', 'Gestión de Grados y Secciones')

@section('topbar-actions')
    <a href="{{ route('superadmin.grados.crear-masivo') }}" class="grado-topbar-btn-outline">
        <i class="fas fa-th"></i>
        <span class="grado-btn-text">Crear Masivo</span>
    </a>
    <a href="{{ route('superadmin.grados.create') }}" class="grado-topbar-btn">
        <i class="fas fa-plus"></i>
        <span class="grado-btn-text">Nuevo Grado</span>
    </a>
@endsection

@push('styles')
<style>
    /* ── Botones topbar ── */
    .grado-topbar-btn {
        display: inline-flex; align-items: center; gap: .45rem;
        background: linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);
        color: white; padding: .5rem .9rem; border-radius: 8px;
        text-decoration: none; font-weight: 600; font-size: .83rem;
        box-shadow: 0 2px 8px rgba(78,199,210,0.3); white-space: nowrap;
    }
    .grado-topbar-btn:hover { opacity: .88; color: white; }
    .grado-topbar-btn-outline {
        display: inline-flex; align-items: center; gap: .45rem;
        background: white; color: #00508f; border: 1.5px solid #4ec7d2;
        padding: .48rem .9rem; border-radius: 8px;
        text-decoration: none; font-weight: 600; font-size: .83rem; white-space: nowrap;
        transition: background .15s;
    }
    .grado-topbar-btn-outline:hover { background: #e8f8f9; color: #00508f; }
    @media(max-width: 600px) {
        .grado-btn-text { display: none; }
        .grado-topbar-btn, .grado-topbar-btn-outline { padding: .5rem .65rem; }
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
    .grado-stats {
        display: grid; grid-template-columns: repeat(4, 1fr);
        gap: 1rem; margin-bottom: 1.5rem;
    }
    @media(max-width:900px){ .grado-stats { grid-template-columns: repeat(2,1fr); } }
    @media(max-width:480px){ .grado-stats { grid-template-columns: 1fr 1fr; gap:.75rem; } }

    .grado-stat {
        background: white; border-radius: var(--radius-lg);
        border: 1px solid var(--border);
        padding: 1.1rem 1.25rem; display: flex; align-items: center; gap: 1rem;
        box-shadow: var(--shadow-sm);
        transition: transform .2s, box-shadow .2s;
        position: relative; overflow: hidden;
    }
    .grado-stat::before {
        content: ''; position: absolute; top: 0; left: 0;
        width: 4px; height: 100%; border-radius: 4px 0 0 4px;
    }
    .gs-total::before     { background: var(--teal); }
    .gs-primaria::before  { background: var(--green); }
    .gs-secundaria::before{ background: #818cf8; }
    .gs-alumnos::before   { background: var(--amber); }
    .grado-stat:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

    .grado-stat-icon {
        width: 46px; height: 46px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-size: 1.15rem;
    }
    .gs-total     .grado-stat-icon { background: var(--teal-light);       color: var(--teal); }
    .gs-primaria  .grado-stat-icon { background: rgba(16,185,129,.12);     color: var(--green); }
    .gs-secundaria .grado-stat-icon{ background: rgba(129,140,248,.15);    color: #4f46e5; }
    .gs-alumnos   .grado-stat-icon { background: rgba(245,158,11,.12);     color: var(--amber); }

    .grado-stat-lbl { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--text-muted); margin-bottom: .2rem; }
    .grado-stat-num { font-size: 1.75rem; font-weight: 800; color: var(--blue-dark); line-height: 1; margin-bottom: .1rem; }
    .grado-stat-sub { font-size: .73rem; color: var(--text-muted); }

    /* ── Toolbar ── */
    .grado-toolbar {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); padding: .9rem 1.25rem;
        margin-bottom: 1.25rem;
        display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;
        box-shadow: var(--shadow-sm);
    }
    .grado-search-wrap { position: relative; flex: 1; min-width: 200px; }
    .grado-search-wrap i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--blue-mid); font-size: .85rem; pointer-events: none; }
    .grado-search {
        width: 100%; padding: .5rem 1rem .5rem 2.4rem;
        border: 1.5px solid var(--border); border-radius: var(--radius-sm);
        font-size: .85rem; background: var(--surface); outline: none;
        transition: border-color .2s, box-shadow .2s; font-family: inherit; color: var(--text-main);
    }
    .grado-search:focus { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(78,199,210,.15); background: white; }

    .grado-filter select, .grado-perpage select {
        padding: .4rem .75rem; border: 1.5px solid var(--border); border-radius: 7px;
        font-size: .82rem; color: var(--text-main); background: var(--surface);
        outline: none; cursor: pointer; font-family: inherit;
    }
    .grado-filter select:focus, .grado-perpage select:focus { border-color: var(--teal); }
    .grado-perpage { display: flex; align-items: center; gap: .5rem; font-size: .8rem; color: #64748b; }
    .grado-perpage label { white-space: nowrap; font-weight: 500; }

    /* ── Tabs ── */
    .grado-tabs { display: flex; gap: .4rem; margin-bottom: 1.25rem; }
    .grado-tab {
        padding: .42rem 1.1rem; border-radius: 8px; font-size: .82rem; font-weight: 600;
        border: 1.5px solid var(--border); background: white; color: #64748b;
        cursor: pointer; transition: all .15s; display: inline-flex; align-items: center; gap: .4rem;
    }
    .grado-tab.active { background: linear-gradient(135deg,var(--teal),var(--blue-mid)); color: #fff; border-color: transparent; }
    .grado-tab:not(.active):hover { border-color: var(--teal); color: var(--blue-mid); background: #e8f8f9; }

    /* ── Grid de cards ── */
    .grados-grid {
        display: grid; grid-template-columns: repeat(3,1fr); gap: 1rem;
    }
    @media(max-width:900px){ .grados-grid { grid-template-columns: repeat(2,1fr); } }
    @media(max-width:500px){ .grados-grid { grid-template-columns: 1fr; } }

    /* ── Card de grado ── */
    .grado-card {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: transform .18s, box-shadow .18s;
    }
    .grado-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); }

    /* Header card */
    .grado-card-header {
        background: linear-gradient(135deg, var(--blue-dark), var(--blue-mid));
        padding: 1rem 1.1rem;
        display: flex; align-items: center; gap: .85rem;
    }
    .grado-num-badge {
        width: 46px; height: 46px; border-radius: 11px; flex-shrink: 0;
        background: rgba(255,255,255,.15); border: 2px solid var(--teal);
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; color: var(--teal); font-size: 1.15rem;
    }
    .grado-card-title    { font-weight: 700; color: white; font-size: .92rem; line-height: 1.2; }
    .grado-card-subtitle { font-size: .72rem; color: rgba(255,255,255,.6); margin-top: .2rem; }

    /* Chips header */
    .hchip {
        display: inline-flex; align-items: center; gap: .2rem;
        background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.25);
        border-radius: 999px; padding: .18rem .55rem;
        font-size: .67rem; font-weight: 700; color: white;
    }
    .hchip-activo   { background: rgba(16,185,129,.25); border-color: rgba(16,185,129,.4); color: #6ee7b7; }
    .hchip-inactivo { background: rgba(239,68,68,.2);   border-color: rgba(239,68,68,.3);  color: #fca5a5; }

    /* Body card */
    .grado-card-body { padding: .85rem 1.1rem; border-top: 1px solid #f1f5f9; }

    .grado-meta-row {
        display: flex; align-items: center; justify-content: space-between;
        background: var(--surface); border: 1px solid var(--border);
        border-radius: 8px; padding: .5rem .75rem; margin-bottom: .5rem;
    }
    .grado-meta-row:last-child { margin-bottom: 0; }
    .grado-meta-label { font-size: .7rem; font-weight: 600; color: var(--text-muted); display: flex; align-items: center; gap: .35rem; }
    .grado-meta-label i { color: var(--teal); font-size: .65rem; }
    .grado-meta-val { font-size: .82rem; font-weight: 700; color: var(--blue-dark); }

    /* Chips materias */
    .mat-chips { display: flex; flex-wrap: wrap; gap: .25rem; margin-top: .6rem; }
    .mat-chip {
        padding: .18rem .55rem; border-radius: 6px; font-size: .67rem; font-weight: 600;
        background: var(--teal-light); color: var(--blue-mid);
        border: 1px solid rgba(78,199,210,.25);
    }
    .mat-chip-more { background: #f1f5f9; color: #64748b; border-color: var(--border); }

    /* Footer card */
    .grado-card-footer {
        padding: .75rem 1.1rem; border-top: 1px solid #f1f5f9;
        display: grid; grid-template-columns: repeat(3, 1fr) auto; gap: .4rem;
        background: var(--surface);
    }
    .act-btn {
        width: 30px; height: 30px; border-radius: 7px;
        display: inline-flex; align-items: center; justify-content: center;
        border: 1.5px solid; font-size: .78rem;
        background: white; cursor: pointer; transition: all .15s; text-decoration: none;
    }
    .act-view   { border-color: var(--blue-mid); color: var(--blue-mid); }
    .act-assign { border-color: var(--teal);     color: var(--teal); }
    .act-edit   { border-color: var(--amber);    color: var(--amber); }
    .act-delete { border-color: var(--red);      color: var(--red); }
    .act-view:hover   { background: var(--blue-mid); color: white; transform: translateY(-1px); }
    .act-assign:hover { background: var(--teal);     color: white; transform: translateY(-1px); }
    .act-edit:hover   { background: var(--amber);    color: white; transform: translateY(-1px); }
    .act-delete:hover { background: var(--red);      color: white; transform: translateY(-1px); }

    /* Empty */
    .grado-empty { padding: 4rem 1rem; text-align: center; grid-column: 1/-1; }
    .grado-empty i { font-size: 2.5rem; color: #cbd5e1; display: block; margin-bottom: 1rem; }
    .grado-empty h6 { color: var(--blue-dark); font-weight: 600; margin-bottom: .4rem; }
    .grado-empty p  { font-size: .83rem; color: var(--text-muted); margin: 0; }

    /* Paginación */
    .grado-pagination-wrap {
        background: white; border: 1px solid var(--border); border-radius: var(--radius-lg);
        padding: .85rem 1.25rem; margin-top: 1.25rem;
        display: flex; align-items: center; justify-content: space-between;
        box-shadow: var(--shadow-sm); flex-wrap: wrap; gap: .5rem;
    }
    .grado-pages { font-size: .78rem; color: var(--text-muted); }
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
    @if(session('error'))
    <div style="background:#fef2f2;border:1px solid #fca5a5;border-radius:10px;color:#991b1b;padding:1rem 1.25rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:.75rem;">
        <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
        <button onclick="this.parentElement.remove()" style="margin-left:auto;background:none;border:none;color:#991b1b;font-size:1.2rem;cursor:pointer;">&times;</button>
    </div>
    @endif

    {{-- ── STATS ── --}}
    <div class="grado-stats">
        <div class="grado-stat gs-total">
            <div class="grado-stat-icon"><i class="fas fa-layer-group"></i></div>
            <div>
                <div class="grado-stat-lbl">Total Grados</div>
                <div class="grado-stat-num">{{ $grados->total() }}</div>
                <div class="grado-stat-sub">Registrados</div>
            </div>
        </div>
        <div class="grado-stat gs-primaria">
            <div class="grado-stat-icon"><i class="fas fa-school"></i></div>
            <div>
                <div class="grado-stat-lbl">Primaria</div>
                <div class="grado-stat-num">{{ $grados->getCollection()->where('nivel','primaria')->count() }}</div>
                <div class="grado-stat-sub">En esta página</div>
            </div>
        </div>
        <div class="grado-stat gs-secundaria">
            <div class="grado-stat-icon"><i class="fas fa-university"></i></div>
            <div>
                <div class="grado-stat-lbl">Secundaria</div>
                <div class="grado-stat-num">{{ $grados->getCollection()->where('nivel','secundaria')->count() }}</div>
                <div class="grado-stat-sub">En esta página</div>
            </div>
        </div>
        <div class="grado-stat gs-alumnos">
            <div class="grado-stat-icon"><i class="fas fa-user-graduate"></i></div>
            <div>
                <div class="grado-stat-lbl">Estudiantes</div>
                <div class="grado-stat-num">{{ $grados->getCollection()->sum(fn($g) => $g->estudiantes->count()) }}</div>
                <div class="grado-stat-sub">En esta página</div>
            </div>
        </div>
    </div>

    {{-- ── TOOLBAR ── --}}
    <div class="grado-toolbar">
        <div class="grado-search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" class="grado-search" placeholder="Buscar grado, sección, nivel...">
        </div>
        <div class="grado-filter">
            <select id="filterNivel">
                <option value="">Todos los niveles</option>
                <option value="primaria">Primaria</option>
                <option value="secundaria">Secundaria</option>
            </select>
        </div>
        <div class="grado-perpage">
            <label><i class="fas fa-list-ol" style="color:#4ec7d2;"></i> Mostrar:</label>
            <select onchange="changePerPage(this.value)">
                @foreach([10,15,20,30,50] as $op)
                    <option value="{{ $op }}" {{ request('per_page', 15) == $op ? 'selected' : '' }}>{{ $op }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- ── TABS ── --}}
    <div class="grado-tabs">
        <button class="grado-tab active" data-nivel="" onclick="setTab(this,'')">
            <i class="fas fa-layer-group"></i> Todos
        </button>
        <button class="grado-tab" data-nivel="primaria" onclick="setTab(this,'primaria')">
            <i class="fas fa-school"></i> Primaria
        </button>
        <button class="grado-tab" data-nivel="secundaria" onclick="setTab(this,'secundaria')">
            <i class="fas fa-university"></i> Secundaria
        </button>
    </div>

    {{-- ── GRID ── --}}
    <div class="grados-grid" id="gradosContainer">
        @forelse($grados as $grado)
        <div class="grado-card"
             data-nivel="{{ $grado->nivel }}"
             data-text="{{ strtolower($grado->numero.' '.($grado->seccion ?? '').' '.$grado->nivel.' '.$grado->anio_lectivo) }}">

            {{-- Header --}}
            <div class="grado-card-header">
                <div class="grado-num-badge">{{ $grado->numero }}</div>
                <div style="flex:1;min-width:0;">
                    <div class="grado-card-title">
                        {{ $grado->numero }}° Grado
                        @if($grado->seccion) — Sección {{ $grado->seccion }} @endif
                    </div>
                    <div style="display:flex;gap:.3rem;flex-wrap:wrap;margin-top:.35rem;">
                        <span class="hchip">
                            <i class="fas fa-layer-group" style="font-size:.5rem;"></i>
                            {{ ucfirst($grado->nivel) }}
                        </span>
                        <span class="hchip">
                            <i class="fas fa-calendar" style="font-size:.5rem;"></i>
                            {{ $grado->anio_lectivo }}
                        </span>
                        @if(isset($grado->activo))
                            <span class="hchip {{ $grado->activo ? 'hchip-activo' : 'hchip-inactivo' }}">
                                <i class="fas fa-circle" style="font-size:.4rem;"></i>
                                {{ $grado->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Body --}}
            <div class="grado-card-body">
                <div class="grado-meta-row">
                    <span class="grado-meta-label"><i class="fas fa-book"></i> Materias</span>
                    <span class="grado-meta-val">{{ $grado->materias->count() }}</span>
                </div>
                <div class="grado-meta-row">
                    <span class="grado-meta-label"><i class="fas fa-user-graduate"></i> Estudiantes</span>
                    <span class="grado-meta-val">{{ $grado->estudiantes->count() }}</span>
                </div>

                @if($grado->materias->isNotEmpty())
                <div class="mat-chips">
                    @foreach($grado->materias->take(3) as $materia)
                        <span class="mat-chip">{{ $materia->nombre }}</span>
                    @endforeach
                    @if($grado->materias->count() > 3)
                        <span class="mat-chip mat-chip-more">+{{ $grado->materias->count() - 3 }} más</span>
                    @endif
                </div>
                @endif
            </div>

            {{-- Footer acciones --}}
            <div class="grado-card-footer">
                <a href="{{ route('superadmin.grados.show', $grado) }}"
                   class="act-btn act-view" title="Ver detalle">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('superadmin.grados.asignar-materias', $grado) }}"
                   class="act-btn act-assign" title="Asignar materias">
                    <i class="fas fa-tasks"></i>
                </a>
                <a href="{{ route('superadmin.grados.edit', $grado) }}"
                   class="act-btn act-edit" title="Editar">
                    <i class="fas fa-edit"></i>
                </a>
                <button type="button" class="act-btn act-delete" title="Eliminar"
                        onclick="mostrarModalDeleteData(this)"
                        data-route="{{ route('superadmin.grados.destroy', $grado) }}"
                        data-name="{{ $grado->numero }}° Grado{{ $grado->seccion ? ' — Sección ' . $grado->seccion : '' }}"
                        data-message="¿Estás seguro de eliminar este grado?">
                    <i class="fas fa-trash"></i>
                </button>
            </div>

        </div>
        @empty
        <div class="grado-empty">
            <i class="fas fa-layer-group"></i>
            <h6>No hay grados registrados</h6>
            <p>Comienza creando el primer grado del sistema</p>
        </div>
        @endforelse
    </div>

    {{-- ── PAGINACIÓN ── --}}
    @if($grados->hasPages())
    <div class="grado-pagination-wrap">
        <span class="grado-pages">
            Mostrando {{ $grados->firstItem() }}–{{ $grados->lastItem() }}
            de {{ $grados->total() }} grados
        </span>
        {{ $grados->appends(['per_page' => request('per_page', 15)])->links() }}
    </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const filterNivel = document.getElementById('filterNivel');
    const cards       = document.querySelectorAll('.grado-card');
    let   currentNivel = '';

    function filterCards() {
        const term = searchInput.value.toLowerCase().trim();
        cards.forEach(function (card) {
            const text  = card.dataset.text || '';
            const nivel = card.dataset.nivel || '';
            const matchSearch = !term  || text.includes(term);
            const matchNivel  = !currentNivel || nivel === currentNivel;
            card.style.display = (matchSearch && matchNivel) ? '' : 'none';
        });
    }

    searchInput.addEventListener('keyup', filterCards);

    filterNivel.addEventListener('change', function () {
        currentNivel = this.value;
        document.querySelectorAll('.grado-tab').forEach(function (t) {
            t.classList.toggle('active', t.dataset.nivel === currentNivel);
        });
        filterCards();
    });

    window.setTab = function (btn, nivel) {
        document.querySelectorAll('.grado-tab').forEach(function (t) { t.classList.remove('active'); });
        btn.classList.add('active');
        currentNivel = nivel;
        filterNivel.value = nivel;
        filterCards();
    };
});

function changePerPage(val) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', val);
    url.searchParams.delete('page');
    window.location.href = url.toString();
}
</script>
@endpush