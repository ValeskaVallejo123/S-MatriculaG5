@extends('layouts.app')

@section('title', 'Ciclos')

@section('page-title', 'Gestión de Ciclos')

@section('topbar-actions')
    {{-- Botón para crear un nuevo ciclo --}}
    <a href="{{ route('ciclos.create') }}" class="btn-back" 
       style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); font-size: 0.9rem;">
        <i class="fas fa-plus"></i>
        Nuevo Ciclo
    </a>
    {{-- Botón para volver (si es necesario) --}}
    <a href="{{ route('plantilla') }}" class="btn-back" 
       style="background: #e2e8f0; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 1px solid #bfd9ea; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 1400px;">

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 8px; background-color: #d1f7e0; border-color: #4ec7d2; color: #00508f;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Barra de búsqueda y resumen compacto -->
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
        <div class="card-body p-3">
            <div class="row align-items-center g-2">
                <!-- Buscador -->
                <div class="col-md-6">
                    <div class="position-relative">
                        <i class="fas fa-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.9rem;"></i>
                        <input type="text" 
                               id="searchInput" 
                               class="form-control form-control-sm ps-5" 
                               placeholder="Buscar por nombre, sección o jornada..." 
                               style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.5rem 1rem 0.5rem 2.5rem; transition: all 0.3s ease;">
                    </div>
                </div>
                
                <!-- Resumen compacto -->
                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-md-end gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-calendar-alt" style="color: #00508f; font-size: 0.9rem;"></i>
                            <span class="small"><strong style="color: #00508f;">{{ $ciclos->count() }}</strong> <span class="text-muted">Total de Ciclos</span></span>
                        </div>
                        {{-- Ejemplo de badge para Matutina/Vespertina --}}
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-sun" style="color: #4ec7d2; font-size: 0.9rem;"></i>
                            <span class="small"><strong style="color: #4ec7d2;">{{ $ciclos->where('jornada', 'Matutina')->count() }}</strong> <span class="text-muted">Matutinos</span></span>
                        </div>
                        <button class="btn btn-sm" style="border: 2px solid #4ec7d2; color: #4ec7d2; background: white; border-radius: 6px; padding: 0.3rem 0.8rem; font-size: 0.85rem;">
                            <i class="fas fa-download"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla compacta de Ciclos -->
    <div class="card border-0 shadow-sm" style="border-radius: 10px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="ciclosTable">
                    <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
                        <tr>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">ID</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Nombre</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Sección</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Maestro Encargado</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Jornada</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold text-end" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ciclos as $ciclo)
                            <tr style="border-bottom: 1px solid #f1f5f9; transition: all 0.2s ease;" class="ciclo-row">
                                <td class="px-3 py-2">
                                    <span class="font-monospace small" style="color: #00508f; font-size: 0.85rem;">{{ $ciclo->id }}</span>
                                </td>
                                <td class="px-3 py-2">
                                    <div class="fw-semibold" style="color: #003b73; font-size: 0.9rem;">{{ $ciclo->nombre }}</div>
                                </td>
                                <td class="px-3 py-2">
                                     <span class="badge" style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.3rem 0.6rem; font-weight: 600; font-size: 0.75rem;">
                                        {{ $ciclo->seccion ?? 'Sin asignar' }}
                                    </span>
                                </td>
                                <td class="px-3 py-2">
                                    <small class="text-muted" style="font-size: 0.8rem;">
                                        <i class="fas fa-chalkboard-teacher me-1" style="color: #00508f;"></i>
                                        {{ $ciclo->maestro ?? 'Sin asignar' }}
                                    </small>
                                </td>
                                <td class="px-3 py-2">
                                    @php
                                        $isMatutina = ($ciclo->jornada ?? '') === 'Matutina';
                                        $badgeBg = $isMatutina ? 'rgba(0, 80, 143, 0.1)' : 'rgba(255, 193, 7, 0.1)';
                                        $badgeColor = $isMatutina ? '#00508f' : '#856404';
                                        $badgeBorder = $isMatutina ? '#00508f' : '#ffc107';
                                    @endphp
                                    <span class="badge rounded-pill" style="background: {{ $badgeBg }}; color: {{ $badgeColor }}; padding: 0.3rem 0.7rem; font-weight: 600; border: 1px solid {{ $badgeBorder }}; font-size: 0.75rem;">
                                        <i class="fas fa-circle" style="font-size: 0.4rem;"></i> {{ $ciclo->jornada ?? 'Sin asignar' }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-end">
                                    <div class="btn-group" role="group">
                                        {{-- Botón de Clases (similar a Ver) --}}
                                        <a href="{{ route('ciclos.show', $ciclo) }}" 
                                           class="btn btn-sm" 
                                           style="border-radius: 6px 0 0 6px; border: 1.5px solid #00508f; color: #00508f; background: white; padding: 0.3rem 0.6rem; font-size: 0.8rem;"
                                           title="Ver Clases"
                                           onmouseover="this.style.background='#00508f'; this.style.color='white';"
                                           onmouseout="this.style.background='white'; this.style.color='#00508f';">
                                            <i class="fas fa-book-open"></i>
                                        </a>
                                        {{-- Botón de Editar --}}
                                        <a href="{{ route('ciclos.edit', $ciclo) }}" 
                                           class="btn btn-sm" 
                                           style="border-radius: 0; border: 1.5px solid #4ec7d2; border-left: none; color: #4ec7d2; background: white; padding: 0.3rem 0.6rem; font-size: 0.8rem;"
                                           title="Editar Ciclo"
                                           onmouseover="this.style.background='#4ec7d2'; this.style.color='white';"
                                           onmouseout="this.style.background='white'; this.style.color='#4ec7d2';">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        {{-- Formulario de Eliminar --}}
                                        <form action="{{ route('ciclos.destroy', $ciclo) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('¿Está seguro de eliminar el ciclo {{ $ciclo->nombre }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm" 
                                                    style="border-radius: 0 6px 6px 0; border: 1.5px solid #ef4444; border-left: none; color: #ef4444; background: white; padding: 0.3rem 0.6rem; font-size: 0.8rem;"
                                                    title="Eliminar Ciclo"
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
                                        <h6 style="color: #003b73;">No hay ciclos registrados</h6>
                                        <p class="small mb-3">Comienza agregando el primer ciclo</p>
                                        <a href="{{ route('ciclos.create') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 8px; padding: 0.5rem 1.2rem;">
                                            <i class="fas fa-plus me-1"></i>Registrar Ciclo
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- La paginación original no estaba disponible en el código proporcionado, pero si usas $ciclos->links(), esta sección la mostraría --}}
        {{-- @if($ciclos->hasPages()) 
        <div class="card-footer bg-white border-0 py-2 px-3">
            ... Paginación
        </div>
        @endif --}}

    </div>
</div>

@push('styles')
<style>
    /* Estilos del index de Estudiantes reutilizados para mantener la consistencia */
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

    /* Estilos del buscador y botones principales */
    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(78, 199, 210, 0.4) !important;
    }

    #searchInput:focus {
        border-color: #4ec7d2;
        box-shadow: 0 0 0 0.2rem rgba(78, 199, 210, 0.15);
        outline: none;
    }

    .table tbody tr:hover {
        background-color: rgba(191, 217, 234, 0.08);
    }

    /* Estilo de la fila de no resultados */
    .no-results-row {
        display: none; /* Oculto por defecto */
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const table = document.getElementById('ciclosTable');
    // Las filas deben tener la clase 'ciclo-row'
    const rows = table.querySelectorAll('tbody .ciclo-row');
    
    searchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase().trim();
        let visibleCount = 0;
        
        rows.forEach(function(row) {
            // Buscamos en el texto de toda la fila
            const text = row.textContent.toLowerCase();
            
            if (text.includes(searchTerm)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        // Manejo del mensaje de "No se encontraron resultados"
        let noResultsRow = document.querySelector('.no-results-row');
        
        if (visibleCount === 0 && searchTerm !== '') {
            if (!noResultsRow) {
                noResultsRow = document.createElement('tr');
                noResultsRow.className = 'no-results-row';
                noResultsRow.innerHTML = `
                    <td colspan="6" class="text-center py-4">
                        <i class="fas fa-search" style="color: #00508f; opacity: 0.5; font-size: 1.5rem;"></i>
                        <p class="text-muted mt-2 mb-0">No se encontraron resultados para "<strong>${searchTerm}</strong>"</p>
                    </td>
                `;
                table.querySelector('tbody').appendChild(noResultsRow);
            } else {
                // Actualiza el término de búsqueda si ya existía la fila
                noResultsRow.querySelector('strong').textContent = searchTerm;
                noResultsRow.style.display = '';
            }
        } else {
            if (noResultsRow) {
                noResultsRow.remove();
            }
        }

        // Ocultar la fila de "No hay ciclos registrados" si hay una búsqueda
        const emptyDataRow = table.querySelector('tbody tr:not(.ciclo-row):not(.no-results-row)');
        if (emptyDataRow) {
            emptyDataRow.style.display = (visibleCount === 0 && searchTerm === '') ? '' : 'none';
        }
    });
});
</script>
@endpush
@endsection