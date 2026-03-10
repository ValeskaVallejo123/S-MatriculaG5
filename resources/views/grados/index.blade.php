@extends('layouts.app')

@section('title', 'Grados')
@section('page-title', 'Gestión de Grados y Secciones')

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

.gg-wrap { width: 100%; box-sizing: border-box; }

/* ── HEADER ── */
.gg-header {
    border-radius: var(--r) var(--r) 0 0;
    background: linear-gradient(135deg, #002d5a 0%, #00508f 55%, #0077b6 100%);
    padding: 2rem 1.7rem;
    position: relative; overflow: hidden;
}
.gg-header::before {
    content: ''; position: absolute; right: -50px; top: -50px;
    width: 200px; height: 200px; border-radius: 50%;
    background: rgba(78,199,210,.13); pointer-events: none;
}
.gg-header::after {
    content: ''; position: absolute; right: 100px; bottom: -45px;
    width: 120px; height: 120px; border-radius: 50%;
    background: rgba(255,255,255,.05); pointer-events: none;
}
.gg-header-inner {
    position: relative; z-index: 1;
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 1rem;
}
.gg-header-left { display: flex; align-items: center; gap: 1.4rem; flex-wrap: wrap; }
.gg-avatar {
    width: 80px; height: 80px; border-radius: 18px;
    border: 3px solid rgba(78,199,210,.7);
    background: rgba(255,255,255,.12);
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 6px 20px rgba(0,0,0,.25); flex-shrink: 0;
}
.gg-avatar i { color: white; font-size: 2rem; }
.gg-header h2 {
    font-size: 1.45rem; font-weight: 800; color: white;
    margin: 0 0 .5rem; text-shadow: 0 1px 4px rgba(0,0,0,.2);
}
.gg-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .22rem .7rem; border-radius: 999px;
    font-size: .72rem; font-weight: 700;
    border: 1px solid rgba(255,255,255,.35);
    background: rgba(255,255,255,.15); color: white;
    margin-right: .4rem;
}
.gg-btn-nuevo {
    display: inline-flex; align-items: center; gap: .4rem;
    background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.35);
    color: white; padding: .5rem 1.2rem; border-radius: 8px;
    font-size: .82rem; font-weight: 700; text-decoration: none;
    transition: all .2s; white-space: nowrap;
}
.gg-btn-nuevo:hover {
    background: rgba(255,255,255,.25); color: white; text-decoration: none;
}

/* ── BODY ── */
.gg-body {
    background: white;
    border: 1px solid var(--border);
    border-top: none;
    border-radius: 0 0 var(--r) var(--r);
    box-shadow: 0 4px 16px rgba(0,59,115,.10);
    padding: 1.4rem 1.7rem;
    margin-bottom: 1.3rem;
}

/* ── FILTROS ── */
.gg-filters {
    display: flex; align-items: center; gap: .75rem;
    flex-wrap: wrap; margin-bottom: 1.2rem;
}
.gg-search-wrap { position: relative; flex: 1; min-width: 200px; }
.gg-search {
    width: 100%; padding: .55rem 1rem .55rem 2.4rem;
    border: 1px solid var(--border); border-radius: 8px;
    font-size: .82rem; color: var(--blue-mid);
    background: #f9fbfd; outline: none;
    transition: border-color .2s, box-shadow .2s;
}
.gg-search:focus {
    border-color: rgba(78,199,210,.5);
    box-shadow: 0 0 0 3px rgba(78,199,210,.1);
    background: white;
}
.gg-search-icon {
    position: absolute; left: .8rem; top: 50%; transform: translateY(-50%);
    color: var(--muted); font-size: .75rem; pointer-events: none;
}
.gg-select {
    padding: .55rem .85rem; border: 1px solid var(--border);
    border-radius: 8px; font-size: .8rem; color: var(--blue-mid);
    background: #f9fbfd; outline: none; cursor: pointer;
    transition: border-color .2s;
}
.gg-select:focus { border-color: rgba(78,199,210,.5); }

/* stats */
.gg-stats-row {
    display: flex; align-items: center; gap: 1rem;
    flex-wrap: wrap; margin-left: auto;
}
.gg-stat-pill {
    display: inline-flex; align-items: center; gap: .35rem;
    font-size: .75rem; font-weight: 700; color: var(--blue-mid);
    background: #f5f8fc; border: 1px solid var(--border);
    border-radius: 999px; padding: .3rem .85rem;
}
.gg-stat-pill i { color: var(--teal); font-size: .7rem; }

/* ── TABS ── */
.gg-tabs {
    display: flex; gap: .4rem; margin-bottom: 1.2rem;
    border-bottom: 2px solid var(--border); padding-bottom: 0;
}
.gg-tab {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .55rem 1.1rem; border-radius: 8px 8px 0 0;
    font-size: .78rem; font-weight: 700; color: var(--muted);
    background: #f5f8fc; border: 1px solid var(--border);
    border-bottom: none; cursor: pointer;
    transition: all .18s; margin-bottom: -2px;
    text-decoration: none;
}
.gg-tab.active, .gg-tab:hover {
    background: white; color: var(--blue);
    border-color: rgba(78,199,210,.5);
    border-bottom: 2px solid white;
}
.gg-tab i { color: var(--teal); }

/* ── SECTION TITLE ── */
.gg-sec {
    display: flex; align-items: center; gap: .5rem;
    font-size: .75rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .08em;
    color: var(--blue); margin-bottom: .95rem;
    padding-bottom: .55rem;
    border-bottom: 2px solid rgba(78,199,210,.15);
}
.gg-sec i { color: var(--teal); }

/* ── GRID ── */
.gg-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 1rem;
}

/* ── GRADO CARD ── */
.gg-card {
    border: 1px solid var(--border);
    border-radius: 12px; overflow: hidden;
    background: white;
    transition: box-shadow .2s, transform .2s, border-color .2s;
}
.gg-card:hover {
    box-shadow: 0 6px 24px rgba(0,80,143,.13);
    border-color: rgba(78,199,210,.5);
    transform: translateY(-2px);
}
.gg-card-top {
    background: linear-gradient(135deg, #002d5a 0%, #00508f 60%, #0077b6 100%);
    padding: 1rem 1.1rem .85rem;
    position: relative; overflow: hidden;
}
.gg-card-top::after {
    content: ''; position: absolute; right: -20px; top: -20px;
    width: 80px; height: 80px; border-radius: 50%;
    background: rgba(78,199,210,.12); pointer-events: none;
}
.gg-card-nivel {
    font-size: .62rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .08em; color: rgba(78,199,210,.9); margin-bottom: .25rem;
}
.gg-card-grado {
    font-size: 1.15rem; font-weight: 800; color: white; line-height: 1.1;
}
.gg-card-badges { margin-top: .4rem; display: flex; flex-wrap: wrap; gap: .3rem; }
.gg-card-badge {
    display: inline-flex; align-items: center; gap: .2rem;
    background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.25);
    border-radius: 999px; padding: .15rem .55rem;
    font-size: .65rem; font-weight: 700; color: white;
}
.gg-card-badge.activo {
    background: rgba(16,185,129,.25); border-color: rgba(16,185,129,.4); color: #6ee7b7;
}
.gg-card-badge.inactivo {
    background: rgba(239,68,68,.2); border-color: rgba(239,68,68,.3); color: #fca5a5;
}

.gg-card-body { padding: .85rem 1rem; }
.gg-card-info {
    display: flex; align-items: center; justify-content: space-between;
    background: #f5f8fc; border: 1px solid var(--border); border-radius: 7px;
    padding: .5rem .75rem; margin-bottom: .65rem;
    font-size: .72rem;
}
.gg-card-info-label { color: var(--muted); font-weight: 600; display: flex; align-items: center; gap: .3rem; }
.gg-card-info-label i { color: var(--teal); }
.gg-card-info-val { font-weight: 800; color: var(--blue-mid); }

.gg-materia-tag {
    display: inline-flex; align-items: center; gap: .2rem;
    background: linear-gradient(135deg, rgba(78,199,210,.12), rgba(0,80,143,.07));
    border: 1px solid rgba(78,199,210,.3); border-radius: 999px;
    padding: .18rem .55rem; font-size: .65rem; font-weight: 600;
    color: var(--blue-mid); margin: .1rem .1rem 0 0;
}
.gg-materia-tag i { color: var(--teal); font-size: .4rem; }

.gg-card-footer {
    border-top: 1px solid var(--border); padding: .65rem 1rem;
    background: #f9fbfd; display: grid;
    grid-template-columns: 1fr 1fr; gap: .4rem;
}
.gg-card-footer-full { grid-column: 1 / -1; }
.gg-btn-sm {
    display: flex; align-items: center; justify-content: center; gap: .3rem;
    padding: .4rem .5rem; border-radius: 7px;
    font-size: .7rem; font-weight: 700; text-decoration: none;
    transition: all .18s; border: 1px solid transparent;
}
.gg-btn-ver   { background: #f0f7ff; color: var(--blue); border-color: rgba(0,80,143,.2); }
.gg-btn-edit  { background: #fff8eb; color: #92400e; border-color: #fde68a; }
.gg-btn-mat   { background: linear-gradient(135deg, var(--teal), var(--blue)); color: white; }
.gg-btn-sm:hover { opacity: .85; transform: translateY(-1px); text-decoration: none; }

/* ── EMPTY ── */
.gg-empty {
    text-align: center; padding: 3.5rem 1rem; color: var(--muted);
}
.gg-empty i { font-size: 2.8rem; display: block; margin-bottom: .75rem; color: rgba(78,199,210,.35); }
.gg-empty p  { font-size: .9rem; font-weight: 600; margin: 0 0 .25rem; }

/* ── PAGINATION ── */
.gg-pagination {
    display: flex; flex-direction: column; align-items: center;
    gap: .75rem; margin-top: 1.5rem;
}
.gg-pag-info {
    font-size: .75rem; color: var(--muted);
    background: #f5f8fc; border: 1px solid var(--border);
    border-radius: 8px; padding: .4rem 1rem;
}
.gg-pag-info strong { color: var(--blue); }
.gg-pag-list { display: flex; gap: .35rem; flex-wrap: wrap; justify-content: center; list-style: none; margin: 0; padding: 0; }
.gg-pag-list .page-link {
    display: flex; align-items: center; justify-content: center;
    min-width: 36px; height: 36px; padding: .4rem .65rem;
    background: white; border: 1px solid var(--border); border-radius: 7px;
    color: var(--muted); font-weight: 700; font-size: .78rem;
    text-decoration: none; transition: all .18s;
}
.gg-pag-list .page-link:hover { border-color: var(--teal); color: var(--blue); }
.gg-pag-list .page-item.active .page-link {
    background: linear-gradient(135deg, var(--teal), var(--blue));
    border-color: var(--teal); color: white;
}
.gg-pag-list .page-item.disabled .page-link { opacity: .5; pointer-events: none; }

@media(max-width: 768px) {
    .gg-header { padding: 1.4rem 1.1rem; }
    .gg-body   { padding: 1rem 1.1rem; }
    .gg-avatar { width: 60px; height: 60px; }
    .gg-avatar i { font-size: 1.5rem; }
    .gg-header h2 { font-size: 1.1rem; }
    .gg-grid { grid-template-columns: 1fr 1fr; }
}
@media(max-width: 480px) {
    .gg-grid { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
<div class="gg-wrap">

    {{-- ── HEADER ── --}}
    <div class="gg-header">
        <div class="gg-header-inner">
            <div class="gg-header-left">
                <div class="gg-avatar">
                    <i class="fas fa-school"></i>
                </div>
                <div>
                    <h2>Gestión de Grados</h2>
                    <span class="gg-badge">
                        <i class="fas fa-layer-group"></i>
                        {{ $grados->total() }} grados registrados
                    </span>
                    <span class="gg-badge">
                        <i class="fas fa-calendar"></i> {{ now()->format('Y') }}
                    </span>
                </div>
            </div>
            <a href="{{ route('superadmin.grados.create') }}" class="gg-btn-nuevo">
                <i class="fas fa-plus"></i> Nuevo Grado
            </a>
        </div>
    </div>

    {{-- ── BODY ── --}}
    <div class="gg-body">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4"
                 style="border-radius:10px; border-left:4px solid #10b981; font-size:.83rem;">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Filtros --}}
        <div class="gg-filters">
            <div class="gg-search-wrap">
                <i class="fas fa-search gg-search-icon"></i>
                <input type="text" id="searchInput" class="gg-search" placeholder="Buscar grado...">
            </div>
            <select id="filterNivel" class="gg-select">
                <option value="">Todos los niveles</option>
                <option value="primaria">Primaria</option>
                <option value="básica">Básica</option>
                <option value="secundaria">Secundaria</option>
            </select>
            <select class="gg-select" onchange="changePerPage(this.value)">
                <option value="10"  {{ request('per_page') == 10  ? 'selected' : '' }}>10 / pág</option>
                <option value="15"  {{ !request('per_page') || request('per_page') == 15 ? 'selected' : '' }}>15 / pág</option>
                <option value="20"  {{ request('per_page') == 20  ? 'selected' : '' }}>20 / pág</option>
                <option value="30"  {{ request('per_page') == 30  ? 'selected' : '' }}>30 / pág</option>
                <option value="50"  {{ request('per_page') == 50  ? 'selected' : '' }}>50 / pág</option>
            </select>
            <div class="gg-stats-row">
                <span class="gg-stat-pill">
                    <i class="fas fa-check-circle"></i>
                    {{ $grados->where('activo', true)->count() }} activos
                </span>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="gg-tabs" id="nivelTabs">
            <a class="gg-tab active" data-nivel="" href="#">
                <i class="fas fa-th-large"></i> Todos
            </a>
            <a class="gg-tab" data-nivel="primaria" href="#">
                <i class="fas fa-child"></i> Primaria
            </a>
            <a class="gg-tab" data-nivel="básica" href="#">
                <i class="fas fa-book"></i> Básica
            </a>
            <a class="gg-tab" data-nivel="secundaria" href="#">
                <i class="fas fa-user-graduate"></i> Secundaria
            </a>
        </div>

        <div class="gg-sec">
            <i class="fas fa-layer-group"></i> Grados Registrados
        </div>

        {{-- Grid --}}
        @if($grados->isEmpty())
            <div class="gg-empty">
                <i class="fas fa-inbox"></i>
                <p>No hay grados registrados</p>
                <a href="{{ route('superadmin.grados.create') }}"
                   style="display:inline-flex;align-items:center;gap:.4rem;margin-top:.75rem;
                          background:linear-gradient(135deg,var(--teal),var(--blue));color:white;
                          padding:.5rem 1.2rem;border-radius:8px;text-decoration:none;font-size:.8rem;font-weight:700;">
                    <i class="fas fa-plus"></i> Crear Grado
                </a>
            </div>
        @else
            <div class="gg-grid" id="gradosContainer">
                @foreach($grados as $grado)
                    <div class="gg-card-wrap"
                         data-nivel="{{ strtolower($grado->nivel) }}"
                         data-search="{{ strtolower($grado->nivel . ' ' . $grado->numero . ' ' . $grado->seccion . ' ' . $grado->anio_lectivo) }}">
                        @include('superadmin.grados._card', ['grado' => $grado])
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Paginación --}}
        @if($grados->hasPages())
            <div class="gg-pagination">
                <div class="gg-pag-info">
                    Mostrando <strong>{{ $grados->firstItem() }}</strong>
                    a <strong>{{ $grados->lastItem() }}</strong>
                    de <strong>{{ $grados->total() }}</strong> resultados
                </div>
                <ul class="gg-pag-list">
                    <li class="page-item {{ $grados->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link"
                           href="{{ $grados->appends(['per_page' => request('per_page', 15)])->previousPageUrl() ?? '#' }}">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                    @for($i = max(1, $grados->currentPage() - 2); $i <= min($grados->lastPage(), $grados->currentPage() + 2); $i++)
                        <li class="page-item {{ $i == $grados->currentPage() ? 'active' : '' }}">
                            <a class="page-link"
                               href="{{ $grados->appends(['per_page' => request('per_page', 15)])->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ !$grados->hasMorePages() ? 'disabled' : '' }}">
                        <a class="page-link"
                           href="{{ $grados->appends(['per_page' => request('per_page', 15)])->nextPageUrl() ?? '#' }}">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </div>
        @endif

    </div>{{-- fin gg-body --}}

</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const tabs        = document.querySelectorAll('.gg-tab');
    const cards       = document.querySelectorAll('.gg-card-wrap');
    let activeNivel   = '';

    function filterCards() {
        const term = searchInput.value.toLowerCase().trim();
        cards.forEach(function (card) {
            const matchSearch = card.dataset.search.includes(term);
            const matchNivel  = !activeNivel || card.dataset.nivel === activeNivel;
            card.style.display = (matchSearch && matchNivel) ? '' : 'none';
        });
    }

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function (e) {
            e.preventDefault();
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            activeNivel = this.dataset.nivel;
            filterCards();
        });
    });

    searchInput.addEventListener('input', filterCards);
    document.getElementById('filterNivel').addEventListener('change', function () {
        activeNivel = this.value.toLowerCase();
        tabs.forEach(t => t.classList.remove('active'));
        const match = document.querySelector(`.gg-tab[data-nivel="${activeNivel}"]`);
        if (match) match.classList.add('active');
        filterCards();
    });
});

function changePerPage(value) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', value);
    url.searchParams.delete('page');
    window.location.href = url.toString();
}
</script>
@endsection
