@extends('layouts.app')

@section('title', 'Ciclos - Administración')

@section('page-title', 'Gestión de Ciclos Académicos')

@section('topbar-actions')
    {{-- Botón para crear un nuevo ciclo --}}
    <a href="{{ route('ciclos.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="fas fa-plus-circle"></i> Crear Nuevo Ciclo
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 1400px;">

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
        <div class="card-body p-3">
            <div class="row align-items-center g-2">
                <div class="col-md-6">
                    <div class="position-relative">
                        <i class="fas fa-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.9rem;"></i>
                        <input type="text" 
                               id="searchInput" 
                               class="form-control form-control-sm ps-5" 
                               placeholder="Buscar por nombre, sección o jornada..." 
                               style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.5rem 1rem 0.5rem 2.5rem;">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-md-end gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-calendar-alt" style="color: #00508f; font-size: 0.9rem;"></i>
                            <span class="small"><strong style="color: #00508f;">{{ $ciclos->total() }}</strong> <span class="text-muted">Total de Ciclos</span></span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-sun" style="color: #4ec7d2; font-size: 0.9rem;"></i>
                            <span class="small"><strong style="color: #4ec7d2;">{{ $ciclos->where('jornada', 'Matutina')->count() }}</strong> <span class="text-muted">Matutinos</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 10px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="ciclosTable">
                    <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
                        <tr>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; color: #003b73;">ID</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; color: #003b73;">Nombre</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; color: #003b73;">Sección</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; color: #003b73;">Maestro Encargado</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; color: #003b73;">Jornada</th>
                            {{-- COLUMNA DE ACCIONES AÑADIDA --}}
                            <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem; color: #003b73;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ciclos as $ciclo)
                            <tr style="border-bottom: 1px solid #f1f5f9;" class="ciclo-row">
                                <td class="px-3 py-2">
                                    <span class="font-monospace small" style="color: #00508f; font-size: 0.85rem;">{{ $ciclo->id }}</span>
                                </td>
                                <td class="px-3 py-2">
                                    <div class="fw-semibold" style="color: #003b73; font-size: 0.9rem;">{{ $ciclo->nombre }}</div>
                                </td>
                                <td class="px-3 py-2">
                                    <span class="badge" style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.3rem 0.6rem; font-size: 0.75rem;">
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
                                    <span class="badge rounded-pill" style="background: {{ $badgeBg }}; color: {{ $badgeColor }}; padding: 0.3rem 0.7rem; border: 1px solid {{ $badgeBorder }}; font-size: 0.75rem;">
                                        <i class="fas fa-circle" style="font-size: 0.4rem;"></i> {{ $ciclo->jornada ?? 'Sin asignar' }}
                                    </span>
                                </td>
                                
                                {{-- CELDA DE ACCIONES CORREGIDA --}}
                                <td class="px-3 py-2 text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        {{-- Botón Ver Detalle Público --}}
                                        <a href="{{ route('publico.ciclos.show', $ciclo->id) }}" 
                                           class="btn btn-sm" 
                                           style="background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%); color: white; padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none; font-weight: 600; border: none; box-shadow: 0 2px 8px rgba(0, 80, 143, 0.3);">
                                            <i class="fas fa-eye me-1"></i>Ver Detalle Público
                                        </a>
                                        {{-- Aquí puedes añadir Botón Editar y Botón Eliminar si lo deseas --}}
                                    </div>
                                </td>
                                {{-- FIN CELDA DE ACCIONES --}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="fas fa-inbox fa-2x mb-2" style="color: #00508f; opacity: 0.5;"></i>
                                    <h6 style="color: #003b73;">No hay ciclos registrados</h6>
                                    <a href="{{ route('ciclos.create') }}" class="btn btn-sm btn-primary mt-2">Crear el primer ciclo</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-sm-12">
                        {{-- Muestra los enlaces de paginación --}}
                        {{ $ciclos->links() }}
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

    .table tbody tr:hover {
        background-color: rgba(191, 217, 234, 0.08);
    }

    #searchInput:focus {
        border-color: #4ec7d2;
        box-shadow: 0 0 0 0.2rem rgba(78, 199, 210, 0.15);
        outline: none;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const rows = document.querySelectorAll('.ciclo-row');
    
    searchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase().trim();
        
        rows.forEach(function(row) {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
});
</script>
@endpush
@endsection