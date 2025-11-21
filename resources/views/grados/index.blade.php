@extends('layouts.app')

@section('title', 'Grados')

<<<<<<< HEAD
@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Gestión de Grados</h1>
            <a href="{{ route('grados.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                + Nuevo Grado
            </a>
            <a href="{{ route('plantilla') }}"
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition">
                Volver
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sección</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre del Maestro</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jornada</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($grados as $grado)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $grado->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $grado->nombre }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $grado->seccion ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span class="font-medium text-indigo-600">
                                    {{ $grado->nombre_maestro ?? 'Sin asignar' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span
                                    class="px-2 py-1 text-xs rounded-full {{ $grado->jornada == 'Matutina' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $grado->jornada == 'Matutina' ? '☀️ Matutina' : '🌙 Vespertina' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('grados.show', $grado) }}"
                                    class="text-blue-600 hover:text-blue-900 mr-3">Clases</a>
                                <a href="{{ route('grados.edit', $grado) }}"
                                    class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                                <form action="{{ route('grados.destroy', $grado) }}" method="POST" class="inline"
                                    onsubmit="return confirm('¿Está seguro de eliminar este grado?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No hay grados registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
=======
@section('page-title', 'Gestión de Grados y Secciones')

@section('topbar-actions')
    <a href="{{ route('grados.create') }}" class="btn-back" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); font-size: 0.9rem;">
        <i class="fas fa-plus"></i>
        Nuevo Grado
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 1400px;">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert" style="border-radius: 10px; border-left: 4px solid #4ec7d2;">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
        <div class="card-body p-3">
            <div class="row align-items-center g-2">
                <div class="col-md-4">
                    <div class="position-relative">
                        <i class="fas fa-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.9rem;"></i>
                        <input type="text" 
                               id="searchInput" 
                               class="form-control form-control-sm ps-5" 
                               placeholder="Buscar por grado, sección, año..." 
                               style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.5rem 1rem 0.5rem 2.5rem; transition: all 0.3s ease;">
                    </div>
                </div>

                <div class="col-md-3">
                    <select id="filterNivel" class="form-select form-select-sm" style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.5rem 1rem;">
                        <option value="">Todos los niveles</option>
                        <option value="primaria">Primaria (1° - 6°)</option>
                        <option value="secundaria">Secundaria (7° - 9°)</option>
                    </select>
                </div>
                
                <div class="col-md-5">
                    <div class="d-flex align-items-center justify-content-md-end gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-school" style="color: #00508f; font-size: 0.9rem;"></i>
                            <span class="small"><strong style="color: #00508f;">{{ $grados->total() }}</strong> <span class="text-muted">Total</span></span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-check-circle" style="color: #4ec7d2; font-size: 0.9rem;"></i>
                            <span class="small"><strong style="color: #4ec7d2;">{{ $grados->where('activo', true)->count() }}</strong> <span class="text-muted">Activos</span></span>
                        </div>
                        <button class="btn btn-sm" style="border: 2px solid #4ec7d2; color: #4ec7d2; background: white; border-radius: 6px; padding: 0.3rem 0.8rem; font-size: 0.85rem;">
                            <i class="fas fa-download"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <ul class="nav nav-tabs mb-3" id="nivelTabs" style="border: none;">
        <li class="nav-item">
            <button class="nav-link active" id="todos-tab" data-bs-toggle="tab" data-bs-target="#todos" type="button" style="border-radius: 8px 8px 0 0; border: 2px solid #bfd9ea; border-bottom: none; color: #00508f; font-weight: 600;">
                <i class="fas fa-th-large"></i> Todos
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="primaria-tab" data-bs-toggle="tab" data-bs-target="#primaria" type="button" style="border-radius: 8px 8px 0 0; border: 2px solid #bfd9ea; border-bottom: none; color: #00508f; font-weight: 600;">
                <i class="fas fa-child"></i> Primaria (1° - 6°)
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="secundaria-tab" data-bs-toggle="tab" data-bs-target="#secundaria" type="button" style="border-radius: 8px 8px 0 0; border: 2px solid #bfd9ea; border-bottom: none; color: #00508f; font-weight: 600;">
                <i class="fas fa-user-graduate"></i> Secundaria (7° - 9°)
            </button>
        </li>
    </ul>

    <div class="tab-content" id="nivelTabsContent">
        <div class="tab-pane fade show active" id="todos">
            <div class="row g-3">
            @forelse($grados as $grado)
<div class="col-md-6 col-lg-4 grado-card" data-nivel="{{ $grado->nivel }}">
    <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; transition: all 0.3s ease; border-left: 4px solid #4ec7d2;">
        <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h5 class="mb-1 fw-bold" style="color: #003b73; font-size: 1rem;">
                        <i class="fas fa-graduation-cap" style="color: #4ec7d2;"></i>
                        {{ $grado->numero }}° Grado
                        @if($grado->seccion)
                            <span style="color: #4ec7d2;">{{ $grado->seccion }}</span>
                        @endif
                    </h5>
                    <span class="badge" style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.25rem 0.5rem; font-size: 0.7rem;">
                        <i class="fas fa-child"></i>
                        {{ ucfirst($grado->nivel) }}
                    </span>
                </div>
                @if($grado->activo)
                    <span class="badge rounded-pill" style="background: rgba(78, 199, 210, 0.2); color: #00508f; padding: 0.3rem 0.7rem; border: 1px solid #4ec7d2; font-size: 0.7rem;">
                        <i class="fas fa-circle" style="font-size: 0.35rem;"></i> Activo
                    </span>
                @else
                    <span class="badge rounded-pill" style="background: #fee2e2; color: #991b1b; padding: 0.3rem 0.7rem; border: 1px solid #ef4444; font-size: 0.7rem;">
                        <i class="fas fa-circle" style="font-size: 0.35rem;"></i> Inactivo
                    </span>
                @endif
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-center mb-2" style="font-size: 0.85rem;">
                    <i class="fas fa-calendar-alt me-2" style="color: #00508f; width: 16px;"></i>
                    <span class="text-muted small">Año Lectivo:</span>
                    <strong class="ms-auto" style="color: #003b73;">{{ $grado->anio_lectivo }}</strong>
                </div>
                <div class="d-flex align-items-center" style="font-size: 0.85rem;">
                    <i class="fas fa-book me-2" style="color: #4ec7d2; width: 16px;"></i>
                    <span class="text-muted small">Materias asignadas:</span>
                    <span class="badge ms-auto" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.25rem 0.6rem; font-size: 0.75rem;">
                        {{ $grado->materias->count() }}
                    </span>
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('grados.show', $grado) }}" 
                   class="btn btn-sm flex-fill" 
                   style="border: 1.5px solid #00508f; color: #00508f; background: white; border-radius: 6px; font-size: 0.8rem; padding: 0.4rem;">
                    <i class="fas fa-eye"></i> Ver
                </a>
                <a href="{{ route('grados.asignar-materias', $grado) }}" 
                   class="btn btn-sm flex-fill" 
                   style="border: 1.5px solid #4ec7d2; color: #4ec7d2; background: white; border-radius: 6px; font-size: 0.8rem; padding: 0.4rem;">
                    <i class="fas fa-tasks"></i> Materias
                </a>
                <a href="{{ route('grados.edit', $grado) }}" 
                   class="btn btn-sm" 
                   style="border: 1.5px solid #f59e0b; color: #f59e0b; background: white; border-radius: 6px; font-size: 0.8rem; padding: 0.4rem 0.5rem;">
                    <i class="fas fa-edit"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@empty
<div class="col-12">
    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body text-center py-5">
            <i class="fas fa-inbox fa-3x mb-3" style="color: #00508f; opacity: 0.5;"></i>
            <h5 style="color: #003b73;">No hay grados registrados</h5>
            <p class="text-muted mb-3">Comienza agregando el primer grado</p>
            <a href="{{ route('grados.create') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 8px; padding: 0.5rem 1.2rem;">
                <i class="fas fa-plus me-1"></i>Crear Grado
            </a>
        </div>
    </div>
</div>
@endforelse
            </div>

            @if($grados->hasPages())
            <div class="mt-3 d-flex justify-content-between align-items-center">
                <div class="text-muted small" style="font-size: 0.85rem;">
                    Mostrando {{ $grados->firstItem() }} - {{ $grados->lastItem() }} de {{ $grados->total() }} grados
                </div>
                <div>
                    {{ $grados->links() }}
                </div>
            </div>
            @endif
        </div>

        <div class="tab-pane fade" id="primaria">
            <div class="row g-3">
                @forelse($grados->where('nivel', 'primaria') as $grado)
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #4ec7d2;">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="mb-1 fw-bold" style="color: #003b73; font-size: 1rem;">
                                        <i class="fas fa-child" style="color: #4ec7d2;"></i>
                                        {{ $grado->numero }}° Grado {{ $grado->seccion }}
                                    </h5>
                                    <span class="badge" style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.25rem 0.5rem; font-size: 0.7rem;">
                                        Primaria
                                    </span>
                                </div>
                                @if($grado->activo)
                                    <span class="badge rounded-pill" style="background: rgba(78, 199, 210, 0.2); color: #00508f; border: 1px solid #4ec7d2; font-size: 0.7rem;">Activo</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2" style="font-size: 0.85rem;">
                                    <span class="text-muted">Año:</span>
                                    <strong style="color: #003b73;">{{ $grado->anio_lectivo }}</strong>
                                </div>
                                <div class="d-flex justify-content-between" style="font-size: 0.85rem;">
                                    <span class="text-muted">Materias:</span>
                                    <span class="badge" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white;">{{ $grado->materias->count() }}</span>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('grados.show', $grado) }}" class="btn btn-sm flex-fill" style="border: 1.5px solid #00508f; color: #00508f; background: white; border-radius: 6px; font-size: 0.8rem;"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('grados.asignar-materias', $grado) }}" class="btn btn-sm flex-fill" style="border: 1.5px solid #4ec7d2; color: #4ec7d2; background: white; border-radius: 6px; font-size: 0.8rem;"><i class="fas fa-tasks"></i></a>
                                <a href="{{ route('grados.edit', $grado) }}" class="btn btn-sm" style="border: 1.5px solid #f59e0b; color: #f59e0b; background: white; border-radius: 6px; font-size: 0.8rem;"><i class="fas fa-edit"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-2x mb-3 text-muted"></i>
                        <p class="text-muted">No hay grados de primaria registrados</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>

        <div class="tab-pane fade" id="secundaria">
            <div class="row g-3">
                @forelse($grados->where('nivel', 'secundaria') as $grado)
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #00508f;">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="mb-1 fw-bold" style="color: #003b73; font-size: 1rem;">
                                        <i class="fas fa-user-graduate" style="color: #00508f;"></i>
                                        {{ $grado->numero }}° Grado {{ $grado->seccion }}
                                    </h5>
                                    <span class="badge" style="background: rgba(0, 80, 143, 0.15); color: #003b73; border: 1px solid #00508f; padding: 0.25rem 0.5rem; font-size: 0.7rem;">
                                        Secundaria
                                    </span>
                                </div>
                                @if($grado->activo)
                                    <span class="badge rounded-pill" style="background: rgba(78, 199, 210, 0.2); color: #00508f; border: 1px solid #4ec7d2; font-size: 0.7rem;">Activo</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2" style="font-size: 0.85rem;">
                                    <span class="text-muted">Año:</span>
                                    <strong style="color: #003b73;">{{ $grado->anio_lectivo }}</strong>
                                </div>
                                <div class="d-flex justify-content-between" style="font-size: 0.85rem;">
                                    <span class="text-muted">Materias:</span>
                                    <span class="badge" style="background: linear-gradient(135deg, #00508f 0%, #003b73 100%); color: white;">{{ $grado->materias->count() }}</span>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('grados.show', $grado) }}" class="btn btn-sm flex-fill" style="border: 1.5px solid #00508f; color: #00508f; background: white; border-radius: 6px; font-size: 0.8rem;"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('grados.asignar-materias', $grado) }}" class="btn btn-sm flex-fill" style="border: 1.5px solid #4ec7d2; color: #4ec7d2; background: white; border-radius: 6px; font-size: 0.8rem;"><i class="fas fa-tasks"></i></a>
                                <a href="{{ route('grados.edit', $grado) }}" class="btn btn-sm" style="border: 1.5px solid #f59e0b; color: #f59e0b; background: white; border-radius: 6px; font-size: 0.8rem;"><i class="fas fa-edit"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-2x mb-3 text-muted"></i>
                        <p class="text-muted">No hay grados de secundaria registrados</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>

@push('styles')
<style>
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12) !important;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .pagination {
        margin-bottom: 0;
    }

    .pagination .page-link {
        border-radius: 6px;
        margin: 0 2px;
        border: 1px solid #e2e8f0;
        color: #00508f;
        transition: all 0.3s ease;
        padding: 0.3rem 0.6rem;
        font-size: 0.85rem;
    }

    .pagination .page-link:hover {
        background: #bfd9ea;
        border-color: #4ec7d2;
        color: #003b73;
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
        border-color: #4ec7d2;
        color: white;
    }

    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(78, 199, 210, 0.4) !important;
    }

    #searchInput:focus, .form-select:focus {
        border-color: #4ec7d2;
        box-shadow: 0 0 0 0.2rem rgba(78, 199, 210, 0.15);
        outline: none;
    }

    .nav-tabs {
        border-bottom: 2px solid #bfd9ea;
    }

    .nav-tabs .nav-link {
        border: none;
        background: transparent;
        margin-right: 0.5rem;
    }

    .nav-tabs .nav-link.active {
        background: white;
        border: 2px solid #4ec7d2;
        border-bottom: 2px solid white;
        margin-bottom: -2px;
        color: #00508f !important;
    }

    .nav-tabs .nav-link:hover {
        background: rgba(78, 199, 210, 0.1);
    }
</style>
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
</script>
@endpush
>>>>>>> 0c60f43d83749cde12f470882b2070e271fe5d92
@endsection