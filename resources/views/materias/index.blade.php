@extends('layouts.app')

@section('title', 'Materias')

@section('page-title', 'Gestión de Materias')

@section('topbar-actions')
    <a href="{{ route('materias.create') }}" class="btn-back" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); font-size: 0.9rem;">
        <i class="fas fa-plus"></i>
        Nueva Materia
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 1400px;">

    <!-- Mensajes de éxito -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert" style="border-radius: 10px; border-left: 4px solid #4ec7d2;">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Barra de búsqueda y resumen compacto -->
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
        <div class="card-body p-3">
            <div class="row align-items-center g-2">
                <!-- Buscador -->
                <div class="col-md-4">
                    <div class="position-relative">
                        <i class="fas fa-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.9rem;"></i>
                        <input type="text" 
                               id="searchInput" 
                               class="form-control form-control-sm ps-5" 
                               placeholder="Buscar por nombre, código, área..." 
                               style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.5rem 1rem 0.5rem 2.5rem; transition: all 0.3s ease;">
                    </div>
                </div>

                <!-- Filtro por Nivel -->
                <div class="col-md-3">
                    <select id="filterNivel" class="form-select form-select-sm" style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.5rem 1rem;">
                        <option value="">Todos los niveles</option>
                        <option value="primaria">Primaria (1° - 6°)</option>
                        <option value="secundaria">Secundaria (7° - 9°)</option>
                    </select>
                </div>
                
                <!-- Resumen compacto -->
                <div class="col-md-5">
                    <div class="d-flex align-items-center justify-content-md-end gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-book" style="color: #00508f; font-size: 0.9rem;"></i>
                            <span class="small"><strong style="color: #00508f;">{{ $materias->total() }}</strong> <span class="text-muted">Total</span></span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-check-circle" style="color: #4ec7d2; font-size: 0.9rem;"></i>
                            <span class="small"><strong style="color: #4ec7d2;">{{ $materias->where('activo', true)->count() }}</strong> <span class="text-muted">Activas</span></span>
                        </div>
                        <button class="btn btn-sm" style="border: 2px solid #4ec7d2; color: #4ec7d2; background: white; border-radius: 6px; padding: 0.3rem 0.8rem; font-size: 0.85rem;">
                            <i class="fas fa-download"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs para Primaria y Secundaria -->
    <ul class="nav nav-tabs mb-3" id="nivelTabs" style="border: none;">
        <li class="nav-item">
            <button class="nav-link active" id="todas-tab" data-bs-toggle="tab" data-bs-target="#todas" type="button" style="border-radius: 8px 8px 0 0; border: 2px solid #bfd9ea; border-bottom: none; color: #00508f; font-weight: 600;">
                <i class="fas fa-list"></i> Todas
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
        <!-- TODAS LAS MATERIAS -->
        <div class="tab-pane fade show active" id="todas">
            <div class="card border-0 shadow-sm" style="border-radius: 10px;">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="materiasTable">
                            <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
                                <tr>
                                    <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Código</th>
                                    <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Nombre</th>
                                    <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Área</th>
                                    <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Nivel</th>
                                    <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Estado</th>
                                    <th class="px-3 py-2 text-uppercase small fw-semibold text-end" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($materias as $materia)
                                <tr style="border-bottom: 1px solid #f1f5f9; transition: all 0.2s ease;" class="materia-row" data-nivel="{{ $materia->nivel }}">
                                    <td class="px-3 py-2">
                                        <span class="badge" style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.3rem 0.6rem; font-weight: 600; font-size: 0.75rem; font-family: monospace;">{{ $materia->codigo }}</span>
                                    </td>
                                    <td class="px-3 py-2">
                                        <div class="fw-semibold" style="color: #003b73; font-size: 0.9rem;">{{ $materia->nombre }}</div>
                                        @if($materia->descripcion)
                                        <small class="text-muted" style="font-size: 0.75rem;">{{ Str::limit($materia->descripcion, 50) }}</small>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2">
                                        <span class="badge" style="background: rgba(0, 80, 143, 0.1); color: #00508f; padding: 0.3rem 0.6rem; font-weight: 600; font-size: 0.75rem;">{{ $materia->area }}</span>
                                    </td>
                                    <td class="px-3 py-2">
                                        @if($materia->nivel === 'primaria')
                                            <span class="badge" style="background: rgba(78, 199, 210, 0.2); color: #00508f; border: 1px solid #4ec7d2; padding: 0.3rem 0.6rem; font-weight: 600; font-size: 0.75rem;">
                                                <i class="fas fa-child"></i> Primaria
                                            </span>
                                        @else
                                            <span class="badge" style="background: rgba(0, 80, 143, 0.2); color: #003b73; border: 1px solid #00508f; padding: 0.3rem 0.6rem; font-weight: 600; font-size: 0.75rem;">
                                                <i class="fas fa-user-graduate"></i> Secundaria
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2">
                                        @if($materia->activo)
                                            <span class="badge rounded-pill" style="background: rgba(78, 199, 210, 0.2); color: #00508f; padding: 0.3rem 0.7rem; font-weight: 600; border: 1px solid #4ec7d2; font-size: 0.75rem;">
                                                <i class="fas fa-circle" style="font-size: 0.4rem; color: #4ec7d2;"></i> Activa
                                            </span>
                                        @else
                                            <span class="badge rounded-pill" style="background: #fee2e2; color: #991b1b; padding: 0.3rem 0.7rem; font-weight: 600; border: 1px solid #ef4444; font-size: 0.75rem;">
                                                <i class="fas fa-circle" style="font-size: 0.4rem;"></i> Inactiva
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 text-end">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('materias.show', $materia) }}" 
                                               class="btn btn-sm" 
                                               style="border-radius: 6px 0 0 6px; border: 1.5px solid #00508f; color: #00508f; background: white; padding: 0.3rem 0.6rem; font-size: 0.8rem;"
                                               title="Ver"
                                               onmouseover="this.style.background='#00508f'; this.style.color='white';"
                                               onmouseout="this.style.background='white'; this.style.color='#00508f';">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('materias.edit', $materia) }}" 
                                               class="btn btn-sm" 
                                               style="border-radius: 0; border: 1.5px solid #4ec7d2; border-left: none; color: #4ec7d2; background: white; padding: 0.3rem 0.6rem; font-size: 0.8rem;"
                                               title="Editar"
                                               onmouseover="this.style.background='#4ec7d2'; this.style.color='white';"
                                               onmouseout="this.style.background='white'; this.style.color='#4ec7d2';">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('materias.destroy', $materia) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('¿Está seguro de eliminar esta materia?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm" 
                                                        style="border-radius: 0 6px 6px 0; border: 1.5px solid #ef4444; border-left: none; color: #ef4444; background: white; padding: 0.3rem 0.6rem; font-size: 0.8rem;"
                                                        title="Eliminar"
                                                        onmouseover="this.style.background='#ef4444'; this.style.color='white';"
                                                        onmouseout="this.style.background='white'; this.style.color='#ef4444';">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-2x mb-2" style="color: #00508f; opacity: 0.5;"></i>
                                            <h6 style="color: #003b73;">No hay materias registradas</h6>
                                            <p class="small mb-3">Comienza agregando la primera materia</p>
                                            <a href="{{ route('materias.create') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 8px; padding: 0.5rem 1.2rem;">
                                                <i class="fas fa-plus me-1"></i>Crear Materia
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Paginación compacta -->
                @if($materias->hasPages())
                <div class="card-footer bg-white border-0 py-2 px-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small" style="font-size: 0.8rem;">
                            {{ $materias->firstItem() }} - {{ $materias->lastItem() }} de {{ $materias->total() }}
                        </div>
                        <div>
                            {{ $materias->links() }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- PRIMARIA -->
        <div class="tab-pane fade" id="primaria">
            <div class="card border-0 shadow-sm" style="border-radius: 10px;">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
                                <tr>
                                    <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem;">Código</th>
                                    <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem;">Nombre</th>
                                    <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem;">Área</th>
                                    <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem;">Estado</th>
                                    <th class="px-3 py-2 text-uppercase small fw-semibold text-end" style="font-size: 0.7rem;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($materias->where('nivel', 'primaria') as $materia)
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td class="px-3 py-2"><span class="badge" style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.3rem 0.6rem; font-family: monospace;">{{ $materia->codigo }}</span></td>
                                    <td class="px-3 py-2"><div class="fw-semibold" style="color: #003b73; font-size: 0.9rem;">{{ $materia->nombre }}</div></td>
                                    <td class="px-3 py-2"><span class="badge" style="background: rgba(0, 80, 143, 0.1); color: #00508f;">{{ $materia->area }}</span></td>
                                    <td class="px-3 py-2">
                                        @if($materia->activo)
                                            <span class="badge rounded-pill" style="background: rgba(78, 199, 210, 0.2); color: #00508f; border: 1px solid #4ec7d2;"><i class="fas fa-circle" style="font-size: 0.4rem;"></i> Activa</span>
                                        @else
                                            <span class="badge rounded-pill" style="background: #fee2e2; color: #991b1b; border: 1px solid #ef4444;"><i class="fas fa-circle" style="font-size: 0.4rem;"></i> Inactiva</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 text-end">
                                        <div class="btn-group">
                                            <a href="{{ route('materias.show', $materia) }}" class="btn btn-sm" style="border: 1.5px solid #00508f; color: #00508f; background: white; border-radius: 6px 0 0 6px;" title="Ver"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('materias.edit', $materia) }}" class="btn btn-sm" style="border: 1.5px solid #4ec7d2; border-left: none; color: #4ec7d2; background: white;" title="Editar"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('materias.destroy', $materia) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm" style="border: 1.5px solid #ef4444; border-left: none; color: #ef4444; background: white; border-radius: 0 6px 6px 0;"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="text-center py-5"><i class="fas fa-inbox fa-2x text-muted mb-2"></i><p class="text-muted">No hay materias de primaria</p></td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECUNDARIA -->
        <div class="tab-pane fade" id="secundaria">
            <div class="card border-0 shadow-sm" style="border-radius: 10px;">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
                                <tr>
                                    <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem;">Código</th>
                                    <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem;">Nombre</th>
                                    <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem;">Área</th>
                                    <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem;">Estado</th>
                                    <th class="px-3 py-2 text-uppercase small fw-semibold text-end" style="font-size: 0.7rem;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($materias->where('nivel', 'secundaria') as $materia)
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td class="px-3 py-2"><span class="badge" style="background: rgba(0, 80, 143, 0.15); color: #003b73; border: 1px solid #00508f; padding: 0.3rem 0.6rem; font-family: monospace;">{{ $materia->codigo }}</span></td>
                                    <td class="px-3 py-2"><div class="fw-semibold" style="color: #003b73; font-size: 0.9rem;">{{ $materia->nombre }}</div></td>
                                    <td class="px-3 py-2"><span class="badge" style="background: rgba(0, 80, 143, 0.1); color: #00508f;">{{ $materia->area }}</span></td>
                                    <td class="px-3 py-2">
                                        @if($materia->activo)
                                            <span class="badge rounded-pill" style="background: rgba(78, 199, 210, 0.2); color: #00508f; border: 1px solid #4ec7d2;"><i class="fas fa-circle" style="font-size: 0.4rem;"></i> Activa</span>
                                        @else
                                            <span class="badge rounded-pill" style="background: #fee2e2; color: #991b1b; border: 1px solid #ef4444;"><i class="fas fa-circle" style="font-size: 0.4rem;"></i> Inactiva</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 text-end">
                                        <div class="btn-group">
                                            <a href="{{ route('materias.show', $materia) }}" class="btn btn-sm" style="border: 1.5px solid #00508f; color: #00508f; background: white; border-radius: 6px 0 0 6px;" title="Ver"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('materias.edit', $materia) }}" class="btn btn-sm" style="border: 1.5px solid #4ec7d2; border-left: none; color: #4ec7d2; background: white;" title="Editar"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('materias.destroy', $materia) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm" style="border: 1.5px solid #ef4444; border-left: none; color: #ef4444; background: white; border-radius: 0 6px 6px 0;"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="text-center py-5"><i class="fas fa-inbox fa-2x text-muted mb-2"></i><p class="text-muted">No hay materias de secundaria</p></td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('styles')
<style>
    .table > :not(caption) > * > * {
        padding: 0.6rem 0.75rem;
    }

    .btn-group .btn:hover {
        transform: translateY(-1px);
        z-index: 1;
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

    .table tbody tr:hover {
        background-color: rgba(191, 217, 234, 0.08);
    }

    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(78, 199, 210, 0.4) !important;
    }

    #searchInput:focus {
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
    const rows = document.querySelectorAll('.materia-row');
    
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const nivelFilter = filterNivel.value;
        let visibleCount = 0;
        
        rows.forEach(function(row) {
            const text = row.textContent.toLowerCase();
            const nivel = row.dataset.nivel;
            
            const matchesSearch = text.includes(searchTerm);
            const matchesNivel = !nivelFilter || nivel === nivelFilter;
            
            if (matchesSearch && matchesNivel) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
    }
    
    searchInput.addEventListener('keyup', filterTable);
    filterNivel.addEventListener('change', filterTable);
});
</script>
@endpush
@endsection