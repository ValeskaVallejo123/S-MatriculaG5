@extends('layouts.app')

@section('title', 'Grados')
@section('page-title', 'Gestión de Grados y Secciones')
@section('content-class', 'p-0')

@push('styles')
<style>
.gr-wrap {
    height: calc(100vh - 64px);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    background: #f0f4f8;
}

/* Hero */
.gr-hero {
    background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #4ec7d2 100%);
    padding: 1.25rem 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-shrink: 0;
}
.gr-hero-left { display: flex; align-items: center; gap: 1rem; }
.gr-hero-icon {
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,255,255,0.15);
    border: 2px solid rgba(255,255,255,0.3);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.gr-hero-icon i { font-size: 1.3rem; color: white; }
.gr-hero-title { font-size: 1.2rem; font-weight: 700; color: white; margin: 0 0 .15rem; }
.gr-hero-sub   { color: rgba(255,255,255,.7); font-size: .82rem; margin: 0; }

.gr-stat {
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.25);
    border-radius: 10px;
    padding: .45rem 1rem;
    text-align: center;
    min-width: 80px;
}
.gr-stat-num { font-size: 1.2rem; font-weight: 700; color: white; line-height: 1; }
.gr-stat-lbl { font-size: .7rem; color: rgba(255,255,255,.7); margin-top: .15rem; }

.gr-btn-new {
    display: inline-flex; align-items: center; gap: .4rem;
    background: white; color: #003b73; border: none;
    border-radius: 8px; padding: .5rem 1.1rem;
    font-size: .85rem; font-weight: 700; text-decoration: none;
    box-shadow: 0 2px 8px rgba(0,0,0,.15); flex-shrink: 0; transition: all .2s;
}
.gr-btn-new:hover { background: #f0f4f8; color: #003b73; transform: translateY(-1px); }

/* Toolbar */
.gr-toolbar {
    padding: .9rem 2rem;
    background: white;
    border-bottom: 1px solid #e8eef5;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}
.gr-search {
    position: relative;
    flex: 1;
    max-width: 320px;
}
.gr-search i {
    position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
    color: #94a3b8; font-size: .85rem;
}
.gr-search input {
    width: 100%;
    padding: .45rem 1rem .45rem 2.4rem;
    border: 1.5px solid #e2e8f0; border-radius: 8px;
    font-size: .875rem; background: #f8fafc;
}
.gr-search input:focus {
    border-color: #4ec7d2; box-shadow: 0 0 0 3px rgba(78,199,210,.12);
    outline: none; background: white;
}
.gr-filter select {
    padding: .42rem .75rem; border: 1.5px solid #e2e8f0; border-radius: 8px;
    font-size: .82rem; background: #f8fafc; outline: none; cursor: pointer;
}
.gr-filter select:focus { border-color: #4ec7d2; }
.gr-perpage { display: flex; align-items: center; gap: .5rem; font-size: .8rem; color: #64748b; }
.gr-perpage select {
    padding: .35rem .65rem; border: 1.5px solid #e2e8f0; border-radius: 7px;
    font-size: .8rem; background: #f8fafc; outline: none; cursor: pointer;
}
.gr-perpage select:focus { border-color: #4ec7d2; }

/* Tabs */
.gr-tabs {
    padding: .7rem 2rem 0;
    background: white;
    border-bottom: 1px solid #e8eef5;
    flex-shrink: 0;
    display: flex;
    gap: .4rem;
}
.gr-tab {
    padding: .4rem 1.1rem; border-radius: 8px 8px 0 0; font-size: .82rem; font-weight: 600;
    border: 1.5px solid #e2e8f0; border-bottom: none; background: #f8fafc; color: #64748b;
    cursor: pointer; transition: all .15s;
}
.gr-tab.active { background: #003b73; color: white; border-color: #003b73; }
.gr-tab:not(.active):hover { border-color: #4ec7d2; color: #00508f; background: #e8f8f9; }

/* Scrollable body */
.gr-body { flex: 1; overflow-y: auto; padding: 1.5rem 2rem; }

/* Cards grid */
.grados-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 1rem; }
@media(max-width:900px){ .grados-grid { grid-template-columns: repeat(2,1fr); } }
@media(max-width:500px){ .grados-grid { grid-template-columns: 1fr; } }

.grado-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,.05); overflow: hidden;
    transition: box-shadow .2s, transform .2s;
}
.grado-card:hover { box-shadow: 0 4px 14px rgba(0,80,143,.1); transform: translateY(-2px); }

.grado-card-head { padding: .75rem 1rem; display: flex; align-items: center; gap: .75rem; }
.grado-numero-badge {
    width: 46px; height: 46px; border-radius: 10px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-weight: 800; font-size: 1.15rem; color: #fff;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
}
.grado-title   { font-weight: 700; color: #0f172a; font-size: .95rem; margin: 0; }
.grado-subtitle{ font-size: .75rem; color: #64748b; margin: 0; }

.grado-card-body {
    padding: .65rem 1rem; border-top: 1px solid #f1f5f9;
    display: flex; gap: .5rem; flex-wrap: wrap;
}
.grado-meta {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .2rem .6rem; border-radius: 6px;
    font-size: .72rem; font-weight: 600; background: #f8fafc; color: #64748b;
}
.grado-meta i { font-size: .65rem; }
.nivel-primaria   { background: #ecfdf5; color: #059669; }
.nivel-secundaria { background: #eef2ff; color: #4f46e5; }
.badge-activo   { background: #ecfdf5; color: #059669; padding: .2rem .6rem; border-radius: 6px; font-size: .72rem; font-weight: 600; }
.badge-inactivo { background: #fee2e2; color: #dc2626; padding: .2rem .6rem; border-radius: 6px; font-size: .72rem; font-weight: 600; }

.grado-card-actions { padding: .65rem 1rem; border-top: 1px solid #f1f5f9; display: flex; gap: .4rem; }
.act-btn {
    display: inline-flex; align-items: center; justify-content: center;
    width: 30px; height: 30px; border-radius: 7px; border: none;
    cursor: pointer; font-size: .75rem; text-decoration: none; transition: all .15s;
}
.act-btn:hover { transform: translateY(-1px); }
.act-view   { background: #f1f5f9; color: #475569; }
.act-view:hover   { background: #475569; color: #fff; }
.act-assign { background: #e8f8f9; color: #0891b2; }
.act-assign:hover { background: #0891b2; color: #fff; }
.act-edit   { background: #fef9c3; color: #ca8a04; }
.act-edit:hover   { background: #ca8a04; color: #fff; }
.act-delete { background: #fee2e2; color: #dc2626; }
.act-delete:hover { background: #dc2626; color: #fff; }

/* Pagination */
.gr-pag-wrap {
    background: white; border: 1px solid #e2e8f0; border-radius: 12px;
    padding: .75rem 1.25rem; margin-top: 1.25rem;
    display: flex; align-items: center; justify-content: space-between;
    box-shadow: 0 1px 3px rgba(0,0,0,.05); flex-wrap: wrap; gap: .5rem;
}
.pagination { margin: 0; }
.pagination .page-link {
    border-radius: 6px; margin: 0 2px; border: 1px solid #e2e8f0;
    color: #00508f; font-size: .82rem; padding: .3rem .65rem; transition: all .2s;
}
.pagination .page-link:hover { background: #bfd9ea; border-color: #4ec7d2; }
.pagination .page-item.active .page-link {
    background: linear-gradient(135deg,#4ec7d2,#00508f);
    border-color: #4ec7d2; color: white;
}

/* Dark mode */
body.dark-mode .gr-wrap  { background: #0f172a; }
body.dark-mode .gr-toolbar, body.dark-mode .gr-tabs { background: #1e293b; border-color: #334155; }
body.dark-mode .gr-search input, body.dark-mode .gr-filter select, body.dark-mode .gr-perpage select { background: #0f172a; border-color: #334155; color: #e2e8f0; }
body.dark-mode .grado-card { background: #1e293b; border-color: #334155; }
body.dark-mode .grado-card-body, body.dark-mode .grado-card-actions { border-color: #334155; }
body.dark-mode .grado-title { color: #e2e8f0; }
body.dark-mode .gr-pag-wrap { background: #1e293b; border-color: #334155; }
</style>
@endpush

@section('content')
<div class="gr-wrap">

    {{-- Hero --}}
    <div class="gr-hero">
        <div class="gr-hero-left">
            <div class="gr-hero-icon"><i class="fas fa-layer-group"></i></div>
            <div>
                <h2 class="gr-hero-title">Gestión de Grados y Secciones</h2>
                <p class="gr-hero-sub">Organiza los grados y niveles de la institución</p>
            </div>
        </div>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <div class="gr-stat">
                <div class="gr-stat-num">{{ $grados->total() }}</div>
                <div class="gr-stat-lbl">Total</div>
            </div>
            <div class="gr-stat">
                <div class="gr-stat-num">{{ $grados->getCollection()->where('nivel','primaria')->count() }}</div>
                <div class="gr-stat-lbl">Primaria</div>
            </div>
            <div class="gr-stat">
                <div class="gr-stat-num">{{ $grados->getCollection()->where('nivel','secundaria')->count() }}</div>
                <div class="gr-stat-lbl">Secundaria</div>
            </div>
            <a href="{{ route('superadmin.grados.create') }}" class="gr-btn-new">
                <i class="fas fa-plus"></i> Nuevo Grado
            </a>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="gr-toolbar">
        <div class="gr-search">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Buscar grado...">
        </div>
        <div class="gr-filter">
            <select id="filterNivel">
                <option value="">Todos los niveles</option>
                <option value="primaria">Primaria</option>
                <option value="secundaria">Secundaria</option>
            </select>
        </div>
        <div class="gr-perpage ms-auto">
            <label>Mostrar:</label>
            <select onchange="changePerPage(this.value)">
                @foreach([10,15,20,30,50] as $op)
                    <option value="{{ $op }}" {{ request('per_page', 15) == $op ? 'selected' : '' }}>{{ $op }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="gr-tabs">
        <button class="gr-tab active" data-nivel="" onclick="setTab(this,'')">
            <i class="fas fa-layer-group"></i> Todos
        </button>
        <button class="gr-tab" data-nivel="primaria" onclick="setTab(this,'primaria')">
            <i class="fas fa-school"></i> Primaria
        </button>
        <button class="gr-tab" data-nivel="secundaria" onclick="setTab(this,'secundaria')">
            <i class="fas fa-university"></i> Secundaria
        </button>
    </div>

    {{-- Body --}}
    <div class="gr-body">

        {{-- Flash messages --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3 border-0 shadow-sm" role="alert"
             style="border-radius:10px;border-left:4px solid #4ec7d2 !important;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3 border-0 shadow-sm" role="alert"
             style="border-radius:10px;border-left:4px solid #ef4444 !important;">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- Grid --}}
        <div class="grados-grid" id="gradosContainer">
            @forelse($grados as $grado)
            <div class="grado-card"
                 data-nivel="{{ $grado->nivel }}"
                 data-text="{{ strtolower($grado->numero.' '.($grado->seccion ?? '').' '.$grado->nivel.' '.$grado->anio_lectivo) }}">

                <div class="grado-card-head">
                    <div class="grado-numero-badge">{{ $grado->numero }}</div>
                    <div>
                        <p class="grado-title">
                            {{ $grado->numero }}° Grado
                            @if($grado->seccion) — Sección {{ $grado->seccion }} @endif
                        </p>
                        <p class="grado-subtitle">
                            <span class="grado-meta {{ $grado->nivel === 'primaria' ? 'nivel-primaria' : 'nivel-secundaria' }}"
                                  style="padding:.15rem .55rem;">
                                {{ ucfirst($grado->nivel) }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="grado-card-body">
                    <span class="grado-meta">
                        <i class="fas fa-calendar-alt"></i> {{ $grado->anio_lectivo }}
                    </span>
                    <span class="grado-meta">
                        <i class="fas fa-book"></i> {{ $grado->materias->count() }} materias
                    </span>
                    <span class="grado-meta" style="background:#f0fdf4;color:#059669;">
                        <i class="fas fa-user-graduate"></i> {{ $grado->estudiantes->count() }} alumnos
                    </span>
                    @if(isset($grado->activo))
                        <span class="{{ $grado->activo ? 'badge-activo' : 'badge-inactivo' }}">
                            <i class="fas fa-circle" style="font-size:.5rem;"></i>
                            {{ $grado->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                    @endif
                </div>

                <div class="grado-card-actions">
                    <a href="{{ route('superadmin.grados.show', $grado) }}" class="act-btn act-view" title="Ver detalle">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('superadmin.grados.asignar-materias', $grado) }}" class="act-btn act-assign" title="Asignar materias">
                        <i class="fas fa-tasks"></i>
                    </a>
                    <a href="{{ route('superadmin.grados.edit', $grado) }}" class="act-btn act-edit" title="Editar">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button type="button" class="act-btn act-delete" title="Eliminar"
                        onclick="mostrarModalDelete(
                            '{{ route('superadmin.grados.destroy', $grado) }}',
                            '¿Estás seguro de que deseas eliminar este grado? Esta acción no se puede deshacer.',
                            '{{ $grado->numero }}° Grado{{ $grado->seccion ? " — Sección " . $grado->seccion : "" }}'
                        )">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>

            </div>
            @empty
            <div style="grid-column:1/-1;text-align:center;padding:3rem 1rem;">
                <i class="fas fa-layer-group fa-2x mb-3" style="color:#cbd5e1;display:block;"></i>
                <div class="fw-semibold" style="color:#003b73;">No hay grados registrados</div>
            </div>
            @endforelse
        </div>

        {{-- Paginación --}}
        @if($grados->hasPages())
        <div class="gr-pag-wrap">
            <small class="text-muted">
                Mostrando {{ $grados->firstItem() }}–{{ $grados->lastItem() }} de {{ $grados->total() }} grados
            </small>
            {{ $grados->appends(['per_page' => request('per_page', 15)])->links() }}
        </div>
        @endif

    </div>{{-- /gr-body --}}
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput  = document.getElementById('searchInput');
    const filterNivel  = document.getElementById('filterNivel');
    const cards        = document.querySelectorAll('.grado-card');
    let   currentNivel = '';

    function filterCards() {
        const term = searchInput.value.toLowerCase().trim();
        cards.forEach(card => {
            const text  = card.dataset.text || '';
            const nivel = card.dataset.nivel || '';
            const matchSearch = !term || text.includes(term);
            const matchNivel  = !currentNivel || nivel === currentNivel;
            card.style.display = (matchSearch && matchNivel) ? '' : 'none';
        });
    }

    searchInput.addEventListener('keyup', filterCards);

    filterNivel.addEventListener('change', function () {
        currentNivel = this.value;
        document.querySelectorAll('.gr-tab').forEach(t => {
            t.classList.toggle('active', t.dataset.nivel === currentNivel);
        });
        filterCards();
    });

    window.setTab = function(btn, nivel) {
        document.querySelectorAll('.gr-tab').forEach(t => t.classList.remove('active'));
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
