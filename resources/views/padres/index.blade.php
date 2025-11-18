@extends('layouts.app')

@section('title', 'Padres/Tutores')

@section('page-title', 'Gestión de Padres/Tutores')

@section('topbar-actions')
    <a href="{{ route('padres.create') }}" class="btn-back" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); font-size: 0.9rem;">
        <i class="fas fa-plus"></i>
        Nuevo Padre/Tutor
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 1400px;">

    <!-- Mensajes -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Resumen de padres -->
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm" style="border-radius: 10px; background: linear-gradient(135deg, rgba(78, 199, 210, 0.1) 0%, rgba(0, 80, 143, 0.05) 100%);">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user-friends" style="color: white; font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">Total Padres/Tutores</p>
                            <h4 class="mb-0 fw-bold" style="color: #003b73;">{{ $padres->total() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros de búsqueda -->
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
        <div class="card-body p-3">
            <form action="{{ route('padres.index') }}" method="GET">
                <div class="row g-2 align-items-end">
                    <div class="col-md-10">
                        <label class="form-label small fw-semibold mb-1" style="color: #003b73;">
                            <i class="fas fa-search"></i> Buscar
                        </label>
                        <input 
                            type="text" 
                            name="buscar" 
                            class="form-control form-control-sm" 
                            placeholder="Nombre, apellido, DNI o correo..."
                            value="{{ request('buscar') }}"
                            style="border-radius: 8px; border: 1.5px solid #e0e0e0; padding: 0.5rem 0.75rem;"
                        >
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm w-100" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; border-radius: 8px; padding: 0.5rem; font-weight: 600;">
                            <i class="fas fa-filter"></i> Filtrar
                        </button>
                    </div>
                </div>

                @if(request()->has('buscar'))
                <div class="mt-2">
                    <a href="{{ route('padres.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 8px;">
                        <i class="fas fa-times"></i> Limpiar filtros
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Lista de padres -->
    @forelse($padres as $padre)
    <div class="card border-0 shadow-sm mb-2" style="border-radius: 10px; transition: all 0.2s ease;">
        <div class="card-body p-2">
            <div class="row align-items-center g-2">
                
                <!-- Avatar y Datos -->
                <div class="col-lg-5">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 2px solid #4ec7d2;">
                            <span class="text-white fw-bold" style="font-size: 1rem;">
                                {{ strtoupper(substr($padre->nombre, 0, 1) . substr($padre->apellido ?? '', 0, 1)) }}
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <h6 class="mb-0 fw-semibold text-truncate" style="color: #003b73; font-size: 0.95rem;">
                                {{ $padre->nombre }} {{ $padre->apellido }}
                            </h6>
                            <small class="text-muted d-flex align-items-center gap-2" style="font-size: 0.75rem;">
                                <span><i class="fas fa-id-card me-1"></i>{{ $padre->dni ?? 'Sin DNI' }}</span>
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Información de contacto -->
                <div class="col-lg-4">
                    <small class="d-block" style="color: #003b73; font-size: 0.8rem;">
                        <i class="fas fa-envelope text-primary"></i> {{ $padre->correo ?? 'Sin correo' }}
                    </small>
                    <small class="text-muted d-block" style="font-size: 0.75rem;">
                        <i class="fas fa-phone"></i> {{ $padre->telefono ?? 'Sin teléfono' }}
                    </small>
                </div>

                <!-- Acciones -->
                <div class="col-lg-3">
                    <div class="d-flex align-items-center justify-content-end gap-2">
                        <span class="badge" style="background: rgba(78, 199, 210, 0.15); color: #00508f; padding: 0.35rem 0.7rem; font-weight: 600; border: 1px solid #4ec7d2; font-size: 0.75rem;">
                            {{ ucfirst($padre->parentesco ?? 'Tutor') }}
                        </span>

                        <div class="btn-group" role="group">
                            <a href="{{ route('padres.show', $padre->id) }}" 
                               class="btn btn-sm" 
                               style="border-radius: 6px 0 0 6px; border: 1.5px solid #00508f; color: #00508f; background: white; padding: 0.35rem 0.7rem; font-size: 0.8rem;"
                               title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('padres.edit', $padre->id) }}" 
                               class="btn btn-sm" 
                               style="border-radius: 0 6px 6px 0; border: 1.5px solid #4ec7d2; border-left: none; color: #4ec7d2; background: white; padding: 0.35rem 0.7rem; font-size: 0.8rem;"
                               title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @empty
        <div class="card border-0 shadow-sm" style="border-radius: 10px;">
            <div class="card-body text-center py-5">
                <i class="fas fa-user-friends mb-3" style="font-size: 3rem; color: #00508f; opacity: 0.3;"></i>
                <h5 style="color: #003b73;">No hay padres/tutores registrados</h5>
                <p class="text-muted mb-3">
                    @if(request()->has('buscar'))
                        No se encontraron resultados con los filtros aplicados
                    @else
                        Comienza registrando el primer padre/tutor
                    @endif
                </p>
                <a href="{{ route('padres.create') }}" class="btn" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; border-radius: 8px; padding: 0.6rem 1.5rem; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3);">
                    <i class="fas fa-plus me-1"></i>Nuevo Padre/Tutor
                </a>
            </div>
        </div>
    @endforelse

    <!-- Paginación -->
    @if($padres->hasPages())
    <div class="card border-0 shadow-sm mt-3" style="border-radius: 10px;">
        <div class="card-body py-2 px-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="text-muted small" style="font-size: 0.85rem;">
                    <i class="fas fa-list-ol"></i> Mostrando {{ $padres->firstItem() }} - {{ $padres->lastItem() }} de {{ $padres->total() }}
                </div>
                <div>
                    {{ $padres->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
    @endif

</div>

<style>
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 59, 115, 0.15) !important;
    }
</style>
@endsection