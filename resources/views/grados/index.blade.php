@extends('layouts.app')

@section('title', 'Grados')

@section('page-title', 'Gestión de Grados y Secciones')

@section('topbar-actions')
    <a href="{{ route('grados.create') }}" class="btn-back" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); font-size: 0.9rem;">
        <i class="fas fa-plus"></i>
        Nuevo Grado
    </a>
@endsection

@section('content')
<div class="container-fluid">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 10px; border-left: 4px solid #10b981;">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="border-radius: 10px; border-left: 4px solid #ef4444;">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Filtros -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
        <div class="card-body p-4">
            <div class="row align-items-center g-3">
                <div class="col-md-3">
                    <div class="position-relative">
                        <i class="fas fa-search position-absolute" style="left: 14px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.938rem;"></i>
                        <input type="text"
                               id="searchInput"
                               class="form-control ps-5"
                               placeholder="Buscar grado..."
                               style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 3rem; transition: all 0.3s ease;">
                    </div>
                </div>

                <div class="col-md-2">
                    {{-- Los value deben coincidir con el ENUM de la BD: primaria | secundaria --}}
                    <select id="filterNivel" class="form-select" style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem;">
                        <option value="">Todos los niveles</option>
                        <option value="primaria">Primaria</option>
                        <option value="secundaria">Secundaria</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <select id="perPageSelect" class="form-select" style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem;" onchange="changePerPage(this.value)">
                        <option value="10"  {{ request('per_page') == 10  ? 'selected' : '' }}>10 por página</option>
                        <option value="15"  {{ request('per_page') == 15 || !request('per_page') ? 'selected' : '' }}>15 por página</option>
                        <option value="20"  {{ request('per_page') == 20  ? 'selected' : '' }}>20 por página</option>
                        <option value="30"  {{ request('per_page') == 30  ? 'selected' : '' }}>30 por página</option>
                        <option value="50"  {{ request('per_page') == 50  ? 'selected' : '' }}>50 por página</option>
                    </select>
                </div>

                <div class="col-md-5">
                    <div class="d-flex align-items-center justify-content-md-end gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-school" style="color: #00508f; font-size: 1rem;"></i>
                            <span class="small">
                                <strong style="color: #00508f; font-size: 1rem;">{{ $grados->total() }}</strong>
                                <span class="text-muted">Total</span>
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-check-circle" style="color: #10b981; font-size: 1rem;"></i>
                            <span class="small">
                                {{-- Contamos solo la página actual (paginator ya filtrado) --}}
                                <strong style="color: #10b981; font-size: 1rem;">{{ $grados->where('activo', true)->count() }}</strong>
                                <span class="text-muted">Activos</span>
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-layer-group" style="color: #6366f1; font-size: 1rem;"></i>
                            <span class="small">
                                <strong style="color: #6366f1; font-size: 1rem;">{{ $grados->lastPage() }}</strong>
                                <span class="text-muted">Páginas</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs: data-nivel debe coincidir con ENUM → primaria | secundaria -->
    <ul class="nav nav-tabs mb-4" id="nivelTabs" style="border: none;">
        <li class="nav-item">
            <button class="nav-link active" data-nivel="" data-bs-toggle="tab" type="button"
                style="border-radius: 10px 10px 0 0; border: 2px solid #e2e8f0; border-bottom: none; color: #00508f; font-weight: 600; padding: 0.75rem 1.5rem;">
                <i class="fas fa-th-large me-2"></i>Todos
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-nivel="primaria" data-bs-toggle="tab" type="button"
                style="border-radius: 10px 10px 0 0; border: 2px solid #e2e8f0; border-bottom: none; color: #00508f; font-weight: 600; padding: 0.75rem 1.5rem;">
                <i class="fas fa-child me-2"></i>Primaria
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-nivel="secundaria" data-bs-toggle="tab" type="button"
                style="border-radius: 10px 10px 0 0; border: 2px solid #e2e8f0; border-bottom: none; color: #00508f; font-weight: 600; padding: 0.75rem 1.5rem;">
                <i class="fas fa-user-graduate me-2"></i>Secundaria
            </button>
        </li>
    </ul>

    <!-- Tarjetas -->
    <div class="row g-4" id="gradosContainer">
        @forelse($grados as $grado)
            {{--
                data-nivel usa el valor tal como viene de la BD: primaria | secundaria
                No hace falta strtolower() porque ya vienen en minúsculas desde el ENUM
            --}}
            <div class="col-md-6 col-lg-4 col-xl-3 grado-card" data-nivel="{{ $grado->nivel }}">
                <div class="card border-0 shadow-sm h-100"
                     style="border-radius: 12px;
                            border-left: 4px solid {{ $grado->nivel === 'secundaria' ? '#00508f' : '#4ec7d2' }};">
                    <div class="card-body p-4">

                        <!-- Encabezado: número, sección y badge de nivel -->
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="fw-bold mb-0">{{ $grado->numero }}° {{ $grado->seccion }}</h5>
                            <span class="badge"
                                  style="background: {{ $grado->nivel === 'secundaria' ? '#00508f' : '#4ec7d2' }};
                                         font-size: 0.75rem; border-radius: 6px;">
                                {{ ucfirst($grado->nivel) }}
                            </span>
                        </div>

                        <!-- Año lectivo -->
                        <p class="text-muted small mb-1">
                            <i class="fas fa-calendar-alt me-1"></i>
                            Año lectivo: {{ $grado->anio_lectivo }}
                        </p>

                        <!-- Materias asignadas -->
                        <p class="text-muted small mb-3">
                            <i class="fas fa-book me-1"></i>
                            {{ $grado->materias->count() }} materia(s)
                        </p>

                        <!-- Estado activo / inactivo -->
                        <p class="mb-3">
                            @if($grado->activo)
                                <span class="badge bg-success-subtle text-success" style="border-radius: 6px;">
                                    <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>Activo
                                </span>
                            @else
                                <span class="badge bg-danger-subtle text-danger" style="border-radius: 6px;">
                                    <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>Inactivo
                                </span>
                            @endif
                        </p>

                        <!-- Acciones -->
                        <div class="d-flex gap-2">
                            <a href="{{ route('grados.show', $grado) }}"
                               class="btn btn-sm btn-outline-primary"
                               title="Ver detalle">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('grados.asignar-materias', $grado) }}"
                               class="btn btn-sm btn-outline-info"
                               title="Asignar materias">
                                <i class="fas fa-tasks"></i>
                            </a>
                            <a href="{{ route('grados.edit', $grado) }}"
                               class="btn btn-sm btn-outline-warning"
                               title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('grados.destroy', $grado) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('¿Eliminar este grado?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn btn-sm btn-outline-danger"
                                        title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-school fa-3x mb-3" style="color: #bfd9ea;"></i>
                    <p class="mb-0">No hay grados registrados.</p>
                    <a href="{{ route('grados.create') }}" class="btn btn-sm mt-3"
                       style="background: linear-gradient(135deg, #4ec7d2, #00508f); color: white; border-radius: 8px;">
                        <i class="fas fa-plus me-1"></i> Crear primer grado
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Paginación -->
    @if($grados->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $grados->appends(request()->query())->links() }}
    </div>
    @endif

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput  = document.getElementById('searchInput');
    const filterNivel  = document.getElementById('filterNivel');
    const tabButtons   = document.querySelectorAll('#nivelTabs button');
    const cards        = document.querySelectorAll('.grado-card');

    function filterCards() {
        const searchTerm  = searchInput.value.toLowerCase().trim();
        const nivelFilter = filterNivel.value; // ya viene en minúsculas del ENUM

        cards.forEach(function (card) {
            const text  = card.textContent.toLowerCase();
            const nivel = card.dataset.nivel; // 'primaria' | 'secundaria'

            const matchesSearch = text.includes(searchTerm);
            const matchesNivel  = nivelFilter === '' || nivel === nivelFilter;

            card.style.display = (matchesSearch && matchesNivel) ? '' : 'none';
        });
    }

    // Sincronizar Select → Tabs
    filterNivel.addEventListener('change', function () {
        const val = this.value;
        const targetTab = document.querySelector(`#nivelTabs button[data-nivel="${val}"]`);
        if (targetTab) {
            new bootstrap.Tab(targetTab).show();
        }
        filterCards();
    });

    // Sincronizar Tabs → Select
    tabButtons.forEach(function (button) {
        button.addEventListener('shown.bs.tab', function (event) {
            filterNivel.value = event.target.getAttribute('data-nivel');
            filterCards();
        });
    });

    searchInput.addEventListener('keyup', filterCards);
});

function changePerPage(value) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', value);
    url.searchParams.delete('page');
    window.location.href = url.toString();
}
</script>
@endpush
@endsection
