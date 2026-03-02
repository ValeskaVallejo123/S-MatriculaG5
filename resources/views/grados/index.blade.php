@extends('layouts.app')

@section('title', 'Grados')
@section('page-title', 'Gestión de Grados y Secciones')

@section('topbar-actions')
    <a href="{{ route('superadmin.grados.create') }}"
       style="background:linear-gradient(135deg,#4ec7d2 0%,#00508f 100%); color:white;
              padding:0.5rem 1.2rem; border-radius:8px; text-decoration:none; font-weight:600;
              display:inline-flex; align-items:center; gap:0.5rem; transition:all 0.3s ease;
              border:none; box-shadow:0 2px 8px rgba(78,199,210,0.3); font-size:0.9rem;">
        <i class="fas fa-plus me-1"></i>Nuevo Grado
    </a>
@endsection

@section('content')
<div class="container-fluid">

    {{-- Alerta de éxito --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert"
         style="border-radius:10px; border-left:4px solid #10b981;">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- ── Filtros ───────────────────────────────────────────────────────── --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
        <div class="card-body p-4">
            <div class="row align-items-center g-3">

                {{-- Buscador --}}
                <div class="col-md-3">
                    <div class="position-relative">
                        <i class="fas fa-search position-absolute"
                           style="left:14px; top:50%; transform:translateY(-50%);
                                  color:#00508f; font-size:0.938rem;"></i>
                        <input type="text" id="searchInput" class="form-control ps-5"
                               placeholder="Buscar grado..."
                               style="border:2px solid #bfd9ea; border-radius:8px;
                                      padding:0.6rem 1rem 0.6rem 3rem; transition:all 0.3s ease;">
                    </div>
                </div>

                {{-- Filtro por nivel --}}
                <div class="col-md-2">
                    <select id="filterNivel" class="form-select"
                            style="border:2px solid #bfd9ea; border-radius:8px; padding:0.6rem 1rem;">
                        <option value="">Todos los niveles</option>
                        <option value="primaria">Primaria</option>
                        <option value="básica">Básica</option>
                        <option value="secundaria">Secundaria</option>
                    </select>
                </div>

                {{-- Por página --}}
                <div class="col-md-2">
                    <select id="perPageSelect" class="form-select"
                            style="border:2px solid #bfd9ea; border-radius:8px; padding:0.6rem 1rem;"
                            onchange="changePerPage(this.value)">
                        <option value="10"  {{ request('per_page') == 10  ? 'selected' : '' }}>10 por página</option>
                        <option value="15"  {{ !request('per_page') || request('per_page') == 15 ? 'selected' : '' }}>15 por página</option>
                        <option value="20"  {{ request('per_page') == 20  ? 'selected' : '' }}>20 por página</option>
                        <option value="30"  {{ request('per_page') == 30  ? 'selected' : '' }}>30 por página</option>
                        <option value="50"  {{ request('per_page') == 50  ? 'selected' : '' }}>50 por página</option>
                    </select>
                </div>

                {{-- Estadísticas --}}
                <div class="col-md-5">
                    <div class="d-flex align-items-center justify-content-md-end gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-school" style="color:#00508f; font-size:1rem;"></i>
                            <span class="small">
                                <strong style="color:#00508f;">{{ $grados->total() }}</strong>
                                <span class="text-muted">Total</span>
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-check-circle" style="color:#10b981; font-size:1rem;"></i>
                            <span class="small">
                                <strong style="color:#10b981;">{{ $grados->where('activo', true)->count() }}</strong>
                                <span class="text-muted">Activos</span>
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ── Tabs de nivel ─────────────────────────────────────────────────── --}}
    <ul class="nav nav-tabs mb-4" id="nivelTabs">
        <li class="nav-item">
            <button class="nav-link active" data-nivel="" data-bs-toggle="tab"
                    data-bs-target="#tab-todos" type="button"
                    style="border-radius:10px 10px 0 0; font-weight:600; padding:0.75rem 1.5rem;">
                <i class="fas fa-th-large me-2"></i>Todos
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-nivel="primaria" data-bs-toggle="tab"
                    data-bs-target="#tab-primaria" type="button"
                    style="border-radius:10px 10px 0 0; font-weight:600; padding:0.75rem 1.5rem;">
                <i class="fas fa-child me-2"></i>Primaria
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-nivel="básica" data-bs-toggle="tab"
                    data-bs-target="#tab-basica" type="button"
                    style="border-radius:10px 10px 0 0; font-weight:600; padding:0.75rem 1.5rem;">
                <i class="fas fa-book me-2"></i>Básica
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-nivel="secundaria" data-bs-toggle="tab"
                    data-bs-target="#tab-secundaria" type="button"
                    style="border-radius:10px 10px 0 0; font-weight:600; padding:0.75rem 1.5rem;">
                <i class="fas fa-user-graduate me-2"></i>Secundaria
            </button>
        </li>
    </ul>

    {{-- ── Contenido de Tabs ─────────────────────────────────────────────── --}}
    <div class="tab-content" id="nivelTabsContent">

        {{-- Tab: Todos --}}
        <div class="tab-pane fade show active" id="tab-todos">
            <div class="row g-4" id="gradosContainer">

                @forelse($grados as $grado)
                <div class="col-md-6 col-lg-4 col-xl-3 grado-card"
                     data-nivel="{{ strtolower($grado->nivel) }}"
                     data-grado="{{ $grado->numero }}"
                     data-seccion="{{ $grado->seccion }}"
                     data-anio="{{ $grado->anio_lectivo }}">

                    @include('superadmin.grados._card', ['grado' => $grado])

                </div>
                @empty
                <div class="col-12">
                    <div class="card border-0 shadow-sm" style="border-radius:12px;">
                        <div class="card-body text-center py-5">
                            <div style="width:80px; height:80px;
                                        background:linear-gradient(135deg,rgba(78,199,210,0.1),rgba(0,80,143,0.1));
                                        border-radius:50%; display:flex; align-items:center;
                                        justify-content:center; margin:0 auto 1.5rem;">
                                <i class="fas fa-inbox" style="font-size:2rem; color:#4ec7d2;"></i>
                            </div>
                            <h5 class="fw-bold mb-2" style="color:#003b73;">No hay grados registrados</h5>
                            <p class="text-muted mb-4">Comienza agregando el primer grado</p>
                            <a href="{{ route('superadmin.grados.create') }}"
                               style="background:linear-gradient(135deg,#4ec7d2,#00508f); color:white;
                                      border-radius:8px; padding:0.6rem 1.5rem; text-decoration:none;
                                      font-weight:600; display:inline-flex; align-items:center; gap:0.5rem;">
                                <i class="fas fa-plus"></i>Crear Grado
                            </a>
                        </div>
                    </div>
                </div>
                @endforelse

            </div>

            {{-- Paginación --}}
            @if($grados->hasPages())
            <div class="pagination-wrapper mt-4">
                <div class="pagination-info">
                    Mostrando <strong>{{ $grados->firstItem() }}</strong>
                    a <strong>{{ $grados->lastItem() }}</strong>
                    de <strong>{{ $grados->total() }}</strong> resultados
                </div>
                <nav aria-label="Navegación de páginas">
                    <ul class="pagination">

                        {{-- Anterior --}}
                        @if($grados->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" rel="prev"
                                   href="{{ $grados->appends(['per_page' => request('per_page', 15)])->previousPageUrl() }}">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                        @endif

                        {{-- Primera página --}}
                        @if($grados->currentPage() > 3)
                            <li class="page-item">
                                <a class="page-link"
                                   href="{{ $grados->appends(['per_page' => request('per_page', 15)])->url(1) }}">1</a>
                            </li>
                            @if($grados->currentPage() > 4)
                                <li class="page-item disabled"><span class="page-link">…</span></li>
                            @endif
                        @endif

                        {{-- Páginas alrededor de la actual --}}
                        @for($i = max(1, $grados->currentPage() - 2); $i <= min($grados->lastPage(), $grados->currentPage() + 2); $i++)
                            @if($i == $grados->currentPage())
                                <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link"
                                       href="{{ $grados->appends(['per_page' => request('per_page', 15)])->url($i) }}">{{ $i }}</a>
                                </li>
                            @endif
                        @endfor

                        {{-- Última página --}}
                        @if($grados->currentPage() < $grados->lastPage() - 2)
                            @if($grados->currentPage() < $grados->lastPage() - 3)
                                <li class="page-item disabled"><span class="page-link">…</span></li>
                            @endif
                            <li class="page-item">
                                <a class="page-link"
                                   href="{{ $grados->appends(['per_page' => request('per_page', 15)])->url($grados->lastPage()) }}">
                                    {{ $grados->lastPage() }}
                                </a>
                            </li>
                        @endif

                        {{-- Siguiente --}}
                        @if($grados->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" rel="next"
                                   href="{{ $grados->appends(['per_page' => request('per_page', 15)])->nextPageUrl() }}">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link"><i class="fas fa-chevron-right"></i></span>
                            </li>
                        @endif

                    </ul>
                </nav>
            </div>
            @endif
        </div>{{-- fin tab-todos --}}

        {{-- Tab: Primaria --}}
        <div class="tab-pane fade" id="tab-primaria">
            <div class="row g-4">
                @forelse($grados->where('nivel', 'Primaria') as $grado)
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        @include('superadmin.grados._card', ['grado' => $grado])
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-inbox fa-2x mb-2 d-block" style="color:#4ec7d2; opacity:0.5;"></i>
                        <p class="text-muted">No hay grados de Primaria registrados.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Tab: Básica --}}
        <div class="tab-pane fade" id="tab-basica">
            <div class="row g-4">
                @forelse($grados->where('nivel', 'Básica') as $grado)
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        @include('superadmin.grados._card', ['grado' => $grado])
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-inbox fa-2x mb-2 d-block" style="color:#4ec7d2; opacity:0.5;"></i>
                        <p class="text-muted">No hay grados de Básica registrados.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Tab: Secundaria --}}
        <div class="tab-pane fade" id="tab-secundaria">
            <div class="row g-4">
                @forelse($grados->where('nivel', 'Secundaria') as $grado)
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        @include('superadmin.grados._card', ['grado' => $grado])
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-inbox fa-2x mb-2 d-block" style="color:#00508f; opacity:0.5;"></i>
                        <p class="text-muted">No hay grados de Secundaria registrados.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>{{-- fin tab-content --}}

</div>
@endsection

{{-- ── Partial: _card.blade.php ─────────────────────────────────────────
     Crea el archivo: resources/views/superadmin/grados/_card.blade.php
     con el contenido de la card para evitar triplicar HTML --}}

@push('styles')
<style>
    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.12) !important;
    }
    .btn-grado-view:hover     { background:#6366f1 !important; color:white !important; transform:translateY(-2px); }
    .btn-grado-materias:hover { background:#4ec7d2 !important; color:white !important; transform:translateY(-2px); }
    .btn-grado-edit:hover     { background:#f59e0b !important; color:white !important; transform:translateY(-2px); }

    #searchInput:focus, .form-select:focus {
        border-color: #4ec7d2;
        box-shadow: 0 0 0 0.2rem rgba(78,199,210,0.15);
        outline: none;
    }

    .nav-tabs { border-bottom: 2px solid #e2e8f0; }
    .nav-tabs .nav-link { border:none; background:transparent; margin-right:0.5rem; color:#64748b; }
    .nav-tabs .nav-link.active {
        background:white; color:#00508f !important;
        border:2px solid #4ec7d2 !important;
        border-bottom:2px solid white !important;
        margin-bottom:-2px;
    }
    .nav-tabs .nav-link:hover:not(.active) {
        background:linear-gradient(135deg,rgba(78,199,210,0.1),rgba(0,80,143,0.1));
    }

    .pagination-wrapper { display:flex; flex-direction:column; align-items:center; gap:1rem; margin-top:2rem; }
    .pagination-info {
        text-align:center; color:#64748b; font-size:0.875rem;
        padding:0.75rem 1.5rem; background:#f8fafc;
        border-radius:8px; border:1px solid #e2e8f0;
    }
    .pagination-info strong { color:#00508f; font-weight:600; }

    .pagination { display:flex; justify-content:center; align-items:center; gap:0.5rem; margin:0; padding:0; list-style:none; flex-wrap:wrap; }
    .page-link {
        display:flex; align-items:center; justify-content:center;
        min-width:40px; height:40px; padding:0.5rem 0.75rem;
        background:white; border:2px solid #e2e8f0; border-radius:8px;
        color:#64748b; font-weight:600; font-size:0.875rem;
        text-decoration:none; transition:all 0.2s ease;
    }
    .page-link:hover {
        background:linear-gradient(135deg,rgba(78,199,210,0.1),rgba(0,80,143,0.1));
        border-color:#4ec7d2; color:#00508f; transform:translateY(-2px);
    }
    .page-item.active .page-link {
        background:linear-gradient(135deg,#4ec7d2,#00508f);
        border-color:#4ec7d2; color:white;
        box-shadow:0 4px 12px rgba(78,199,210,0.3);
    }
    .page-item.disabled .page-link {
        background:#f8fafc; border-color:#e2e8f0;
        color:#cbd5e1; cursor:not-allowed; opacity:0.6;
    }
    .page-item.disabled .page-link:hover { transform:none; }

    @media (max-width: 768px) {
        .pagination { gap:0.25rem; }
        .page-link { min-width:36px; height:36px; padding:0.4rem 0.6rem; font-size:0.813rem; }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('searchInput');
    const filterNivel = document.getElementById('filterNivel');
    const tabButtons  = document.querySelectorAll('#nivelTabs button');
    const cards       = document.querySelectorAll('.grado-card');

    function filterCards() {
        const term  = searchInput.value.toLowerCase().trim();
        const nivel = filterNivel.value.toLowerCase();

        cards.forEach(function (card) {
            const matchesSearch = card.textContent.toLowerCase().includes(term);
            const matchesNivel  = nivel === '' || card.dataset.nivel === nivel;
            card.style.display  = (matchesSearch && matchesNivel) ? '' : 'none';
        });
    }

    // Sincronizar Select → Tab
    filterNivel.addEventListener('change', function () {
        const val = this.value;
        const target = document.querySelector(`#nivelTabs button[data-nivel="${val}"]`);
        if (target) new bootstrap.Tab(target).show();
        filterCards();
    });

    // Sincronizar Tab → Select
    tabButtons.forEach(function (btn) {
        btn.addEventListener('shown.bs.tab', function (e) {
            filterNivel.value = e.target.getAttribute('data-nivel');
            filterCards();
        });
    });

    // Buscador en tiempo real
    searchInput.addEventListener('input', filterCards);
});

function changePerPage(value) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', value);
    url.searchParams.delete('page');
    window.location.href = url.toString();
}
</script>
@endpush
