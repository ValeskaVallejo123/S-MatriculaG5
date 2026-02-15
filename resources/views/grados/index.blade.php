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
                    <select id="filterNivel" class="form-select" style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem;">
                        <option value="">Todos los niveles</option>
                        <option value="primaria">Primaria</option>
                        <option value="secundaria">Secundaria</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <select id="perPageSelect" class="form-select" style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem;" onchange="changePerPage(this.value)">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 por página</option>
                        <option value="15" {{ request('per_page') == 15 || !request('per_page') ? 'selected' : '' }}>15 por página</option>
                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20 por página</option>
                        <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30 por página</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 por página</option>
                    </select>
                </div>

                <div class="col-md-5">
                    <div class="d-flex align-items-center justify-content-md-end gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-school" style="color: #00508f; font-size: 1rem;"></i>
                            <span class="small"><strong style="color: #00508f; font-size: 1rem;">{{ $grados->total() }}</strong> <span class="text-muted">Total</span></span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-check-circle" style="color: #10b981; font-size: 1rem;"></i>
                            <span class="small"><strong style="color: #10b981; font-size: 1rem;">{{ $grados->where('activo', true)->count() }}</strong> <span class="text-muted">Activos</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs mb-4" id="nivelTabs" style="border: none;">
        <li class="nav-item">
            <button class="nav-link active" id="todos-tab" data-bs-toggle="tab" data-bs-target="#todos" type="button" style="border-radius: 10px 10px 0 0; border: 2px solid #e2e8f0; border-bottom: none; color: #00508f; font-weight: 600; padding: 0.75rem 1.5rem;">
                <i class="fas fa-th-large me-2"></i>Todos
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="primaria-tab" data-bs-toggle="tab" data-bs-target="#primaria" type="button" style="border-radius: 10px 10px 0 0; border: 2px solid #e2e8f0; border-bottom: none; color: #00508f; font-weight: 600; padding: 0.75rem 1.5rem;">
                <i class="fas fa-child me-2"></i>Primaria
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="secundaria-tab" data-bs-toggle="tab" data-bs-target="#secundaria" type="button" style="border-radius: 10px 10px 0 0; border: 2px solid #e2e8f0; border-bottom: none; color: #00508f; font-weight: 600; padding: 0.75rem 1.5rem;">
                <i class="fas fa-user-graduate me-2"></i>Secundaria
            </button>
        </li>
    </ul>

    <!-- Contenido de Tabs -->
    <ul class="nav nav-tabs mb-4" id="nivelTabs" style="border: none;">
    <li class="nav-item">
        <button class="nav-link active" id="todos-tab" data-nivel="" data-bs-toggle="tab" type="button">
            <i class="fas fa-th-large me-2"></i>Todos
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" id="primaria-tab" data-nivel="primaria" data-bs-toggle="tab" type="button">
            <i class="fas fa-child me-2"></i>Primaria
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" id="secundaria-tab" data-nivel="secundaria" data-bs-toggle="tab" type="button">
            <i class="fas fa-user-graduate me-2"></i>Secundaria
        </button>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane fade show active">
        <div class="row g-4" id="gradosContainer">
            @forelse($grados as $grado)
                <div class="col-md-6 col-lg-4 col-xl-3 grado-card" data-nivel="{{ strtolower($grado->nivel) }}">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid {{ $grado->nivel == 'secundaria' ? '#00508f' : '#4ec7d2' }};">
                        <div class="card-body p-4">
                            <h5 class="fw-bold">{{ $grado->numero }}° {{ $grado->seccion }}</h5>
                            <p class="text-muted small">{{ ucfirst($grado->nivel) }}</p>
                            <div class="d-flex gap-2 mt-3">
                                <a href="{{ route('grados.show', $grado) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('grados.asignar-materias', $grado) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-tasks"></i></a>
                                <a href="{{ route('grados.edit', $grado) }}" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                @endforelse
        </div>
    </div>
</div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const filterNivelSelect = document.getElementById('filterNivel');
    const tabButtons = document.querySelectorAll('#nivelTabs button');
    const cards = document.querySelectorAll('.grado-card');

    function filterLogic() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const nivelValue = filterNivelSelect.value.toLowerCase();

        cards.forEach(card => {
            const text = card.textContent.toLowerCase();
            const cardNivel = card.dataset.nivel.toLowerCase();

            const matchesSearch = text.includes(searchTerm);
            const matchesNivel = nivelValue === "" || cardNivel === nivelValue;

            card.style.display = (matchesSearch && matchesNivel) ? '' : 'none';
        });
    }

    // 1. Sincronizar de Select a Tabs
    filterNivelSelect.addEventListener('change', function() {
        const val = this.value;
        const targetTab = document.querySelector(`#nivelTabs button[data-nivel="${val}"]`);
        
        if (targetTab) {
            const tabInstance = new bootstrap.Tab(targetTab);
            tabInstance.show();
        }
        filterLogic();
    });

    // 2. Sincronizar de Tabs a Select
    tabButtons.forEach(button => {
        button.addEventListener('shown.bs.tab', function (event) {
            const selectedNivel = event.target.getAttribute('data-nivel');
            filterNivelSelect.value = selectedNivel; // Actualiza el select
            filterLogic();
        });
    });

    // 3. Buscador
    searchInput.addEventListener('keyup', filterLogic);
});
</script>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const filterNivel = document.getElementById('filterNivel');
    const cards = document.querySelectorAll('.grado-card');

    function filterCards() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const nivelFilter = filterNivel.value;
        let visibleCount = 0;

        cards.forEach(function(card) {
            const text = card.textContent.toLowerCase();
            const nivel = card.dataset.nivel;

            const matchesSearch = text.includes(searchTerm);
            const matchesNivel = !nivelFilter || nivel === nivelFilter;

            if (matchesSearch && matchesNivel) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('keyup', filterCards);
    filterNivel.addEventListener('change', filterCards);
});

function changePerPage(value) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', value);
    url.searchParams.delete('page'); // Reset a página 1
    window.location.href = url.toString();
}
</script>
@endpush
@endsection