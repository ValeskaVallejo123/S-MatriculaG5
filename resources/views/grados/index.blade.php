@extends('layouts.app')

@section('title', 'Grados')
@section('page-title', 'Gestión de Grados y Secciones')

@section('topbar-actions')
    <a href="{{ route('superadmin.grados.create') }}" class="adm-btn-solid">
        <i class="fas fa-plus"></i> Nuevo Grado
    </a>
@endsection

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

.adm-wrap { font-family: 'Inter', sans-serif; }

.adm-btn-outline {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .42rem 1rem; border-radius: 7px; font-size: .82rem; font-weight: 600;
    background: #fff; color: #00508f; border: 1.5px solid #4ec7d2;
    text-decoration: none; transition: background .15s;
}
.adm-btn-outline:hover { background: #e8f8f9; }
.adm-btn-solid {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .42rem 1rem; border-radius: 7px; font-size: .82rem; font-weight: 600;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: #fff; border: none; text-decoration: none; transition: opacity .15s;
}
.adm-btn-solid:hover { opacity: .88; color: #fff; }

/* Stats */
.adm-stats {
    display: grid; grid-template-columns: repeat(4,1fr);
    gap: 1rem; margin-bottom: 1.5rem;
}
@media(max-width:768px){ .adm-stats { grid-template-columns: repeat(2,1fr); } }
@media(max-width:480px){ .adm-stats { grid-template-columns: 1fr; } }

.adm-stat {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    padding: 1.1rem 1.25rem; display: flex; align-items: center; gap: .9rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.adm-stat-icon {
    width: 44px; height: 44px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.adm-stat-icon i { font-size: 1.15rem; color: #fff; }
.adm-stat-lbl { font-size: .72rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: .05em; margin-bottom: .15rem; }
.adm-stat-num { font-size: 1.75rem; font-weight: 700; color: #0f172a; line-height: 1; }

/* Toolbar */
.adm-toolbar {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    padding: .85rem 1.25rem; margin-bottom: 1.25rem;
    display: flex; align-items: center; justify-content: space-between;
    box-shadow: 0 1px 3px rgba(0,0,0,.05); gap: .75rem; flex-wrap: wrap;
}
.adm-search-wrap { display: flex; align-items: center; gap: .5rem; flex: 1; min-width: 180px; }
.adm-search-inner { position: relative; flex: 1; max-width: 280px; }
.adm-search-inner i { position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:.78rem;pointer-events:none; }
.adm-search-inner input {
    width: 100%; padding: .38rem .75rem .38rem 2rem;
    border: 1.5px solid #e2e8f0; border-radius: 7px;
    font-size: .82rem; color: #0f172a; background: #f8fafc; outline: none;
}
.adm-search-inner input:focus { border-color: #4ec7d2; }
.adm-filter select, .adm-perpage select {
    padding: .35rem .65rem; border: 1.5px solid #e2e8f0; border-radius: 7px;
    font-size: .8rem; color: #0f172a; background: #f8fafc; outline: none; cursor: pointer;
}
.adm-filter select:focus, .adm-perpage select:focus { border-color: #4ec7d2; }
.adm-perpage { display: flex; align-items: center; gap: .5rem; font-size: .8rem; color: #64748b; }

/* Tabs */
.adm-tabs { display: flex; gap: .4rem; margin-bottom: 1.25rem; }
.adm-tab {
    padding: .42rem 1.1rem; border-radius: 8px; font-size: .82rem; font-weight: 600;
    border: 1.5px solid #e2e8f0; background: #fff; color: #64748b; cursor: pointer; transition: all .15s;
}
.adm-tab.active { background: linear-gradient(135deg,#4ec7d2,#00508f); color: #fff; border-color: transparent; }
.adm-tab:not(.active):hover { border-color: #4ec7d2; color: #00508f; background: #e8f8f9; }

/* Grid de grados */
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

/* Nivel badges */
.nivel-primaria   { background: #ecfdf5; color: #059669; }
.nivel-secundaria { background: #eef2ff; color: #4f46e5; }

/* Estado activo/inactivo */
.badge-activo   { background: #ecfdf5; color: #059669; padding: .2rem .6rem; border-radius: 6px; font-size: .72rem; font-weight: 600; }
.badge-inactivo { background: #fee2e2; color: #dc2626; padding: .2rem .6rem; border-radius: 6px; font-size: .72rem; font-weight: 600; }

/* empty */
.adm-empty { padding: 3rem 1rem; text-align: center; grid-column: 1/-1; }
.adm-empty i { font-size: 2rem; color: #cbd5e1; margin-bottom: .65rem; display: block; }
.adm-empty p { color: #94a3b8; font-size: .85rem; margin: 0; }

/* Pagination */
.adm-pagination-wrap {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
    padding: .75rem 1.25rem; margin-top: 1.25rem;
    display: flex; align-items: center; justify-content: space-between;
    box-shadow: 0 1px 3px rgba(0,0,0,.05); flex-wrap: wrap; gap: .5rem;
}
.adm-pages { font-size: .78rem; color: #94a3b8; }
.pagination { margin: 0; gap: 3px; display: flex; }
.pagination .page-link {
    border-radius: 7px; padding: .3rem .65rem;
    font-size: .78rem; font-weight: 500;
    border: 1px solid #e2e8f0; color: #00508f; transition: all .15s; line-height: 1.4;
}
.pagination .page-link:hover { background: #e8f8f9; border-color: #4ec7d2; }
.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    border-color: #4ec7d2; color: #fff;
}
.pagination .page-item.disabled .page-link { opacity: .45; }
</style>
@endpush

@section('content')
<div class="adm-wrap">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" style="border-radius:10px;border:none;background:#ecfdf5;color:#059669;font-size:.85rem;">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4" style="border-radius:10px;border-left:4px solid #ef4444;font-size:.85rem;">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Stats --}}
    <div class="adm-stats">
        <div class="adm-stat">
            <div class="adm-stat-icon" style="background:linear-gradient(135deg,#4ec7d2,#00508f);">
                <i class="fas fa-layer-group"></i>
            </div>
            <div>
                <div class="adm-stat-lbl">Total Grados</div>
                <div class="adm-stat-num">{{ $grados->total() }}</div>
            </div>
        </div>
        <div class="adm-stat">
            <div class="adm-stat-icon" style="background:linear-gradient(135deg,#34d399,#059669);">
                <i class="fas fa-school"></i>
            </div>
            <div>
                <div class="adm-stat-lbl">Primaria</div>
                <div class="adm-stat-num">{{ $grados->getCollection()->where('nivel','primaria')->count() }}</div>
            </div>
        </div>
        <div class="adm-stat">
            <div class="adm-stat-icon" style="background:linear-gradient(135deg,#818cf8,#4f46e5);">
                <i class="fas fa-university"></i>
            </div>
            <div>
                <div class="adm-stat-lbl">Secundaria</div>
                <div class="adm-stat-num">{{ $grados->getCollection()->where('nivel','secundaria')->count() }}</div>
            </div>
        </div>
        <div class="adm-stat">
            <div class="adm-stat-icon" style="background:linear-gradient(135deg,#fb923c,#ea580c);">
                <i class="fas fa-book-open"></i>
            </div>
            <div>
                <div class="adm-stat-lbl">Total Materias</div>
                <div class="adm-stat-num">{{ $grados->getCollection()->sum(fn($g) => $g->materias->count()) }}</div>
            </div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="adm-toolbar">
        <div class="adm-search-wrap">
            <div class="adm-search-inner">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Buscar grado...">
            </div>
        </div>
        <div class="adm-filter">
            <select id="filterNivel">
                <option value="">Todos los niveles</option>
                <option value="primaria">Primaria</option>
                <option value="secundaria">Secundaria</option>
            </select>
        </div>
        <div class="adm-perpage">
            <label>Mostrar:</label>
            <select onchange="changePerPage(this.value)">
                @foreach([10,15,20,30,50] as $op)
                    <option value="{{ $op }}" {{ request('per_page', 15) == $op ? 'selected' : '' }}>{{ $op }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="adm-tabs">
        <button class="adm-tab active" data-nivel="" onclick="setTab(this,'')">
            <i class="fas fa-layer-group"></i> Todos
        </button>
        <button class="adm-tab" data-nivel="primaria" onclick="setTab(this,'primaria')">
            <i class="fas fa-school"></i> Primaria
        </button>
        <button class="adm-tab" data-nivel="secundaria" onclick="setTab(this,'secundaria')">
            <i class="fas fa-university"></i> Secundaria
        </button>
    </div>

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
                {{-- Estado activo/inactivo (nuevo del main) --}}
                @if(isset($grado->activo))
                    <span class="{{ $grado->activo ? 'badge-activo' : 'badge-inactivo' }}">
                        <i class="fas fa-circle" style="font-size:.5rem;"></i>
                        {{ $grado->activo ? 'Activo' : 'Inactivo' }}
                    </span>
                @endif
            </div>

            <div class="grado-card-actions">
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
                {{-- Eliminar (nuevo del main) --}}
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
        <div class="adm-empty">
            <i class="fas fa-layer-group"></i>
            <p>No hay grados registrados</p>
        </div>
        @endforelse
    </div>

    {{-- Paginación --}}
    @if($grados->hasPages())
    <div class="adm-pagination-wrap">
        <span class="adm-pages">
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
        document.querySelectorAll('.adm-tab').forEach(t => {
            t.classList.toggle('active', t.dataset.nivel === currentNivel);
        });
        filterCards();
    });

    window.setTab = function(btn, nivel) {
        document.querySelectorAll('.adm-tab').forEach(t => t.classList.remove('active'));
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