@extends('layouts.app')

@section('title', 'Matrículas')

@section('page-title', 'Gestión de Matrículas')

@section('topbar-actions')
    <a href="{{ route('matriculas.create') }}" class="btn-back" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); font-size: 0.9rem;">
        <i class="fas fa-plus"></i>
        Nueva Matrícula
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

    <!-- Resumen de matrículas -->
    <div class="row g-3 mb-3">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 10px; background: linear-gradient(135deg, rgba(78, 199, 210, 0.1) 0%, rgba(0, 80, 143, 0.05) 100%);">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-clipboard-check" style="color: white; font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">Total</p>
                            <h4 class="mb-0 fw-bold" style="color: #003b73;">{{ $matriculas->total() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 10px; background: linear-gradient(135deg, rgba(40, 167, 69, 0.1) 0%, rgba(40, 167, 69, 0.05) 100%);">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-check-circle" style="color: white; font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">Aprobadas</p>
                            <h4 class="mb-0 fw-bold" style="color: #28a745;">{{ $aprobadas ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 10px; background: linear-gradient(135deg, rgba(255, 193, 7, 0.1) 0%, rgba(255, 193, 7, 0.05) 100%);">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-clock" style="color: white; font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">Pendientes</p>
                            <h4 class="mb-0 fw-bold" style="color: #ffc107;">{{ $pendientes ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 10px; background: linear-gradient(135deg, rgba(220, 53, 69, 0.1) 0%, rgba(220, 53, 69, 0.05) 100%);">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-times-circle" style="color: white; font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">Rechazadas</p>
                            <h4 class="mb-0 fw-bold" style="color: #dc3545;">{{ $rechazadas ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros de búsqueda -->
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
        <div class="card-body p-3">
            <form action="{{ route('matriculas.index') }}" method="GET">
                <div class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold mb-1" style="color: #003b73;">
                            <i class="fas fa-search"></i> Buscar
                        </label>
                        <input
                            type="text"
                            name="buscar"
                            class="form-control form-control-sm"
                            placeholder="Nombre, apellido o DNI..."
                            value="{{ request('buscar') }}"
                            style="border-radius: 8px; border: 1.5px solid #e0e0e0; padding: 0.5rem 0.75rem;"
                        >
                    </div>

                    <div class="col-md-2">
                        <label class="form-label small fw-semibold mb-1" style="color: #003b73;">
                            <i class="fas fa-graduation-cap"></i> Grado
                        </label>
                        <select
                            name="grado"
                            class="form-select form-select-sm"
                            style="border-radius: 8px; border: 1.5px solid #e0e0e0; padding: 0.5rem 0.75rem;"
                        >
                            <option value="">Todos</option>
                            <option value="1°" {{ request('grado') === '1°' ? 'selected' : '' }}>1°</option>
                            <option value="2°" {{ request('grado') === '2°' ? 'selected' : '' }}>2°</option>
                            <option value="3°" {{ request('grado') === '3°' ? 'selected' : '' }}>3°</option>
                            <option value="4°" {{ request('grado') === '4°' ? 'selected' : '' }}>4°</option>
                            <option value="5°" {{ request('grado') === '5°' ? 'selected' : '' }}>5°</option>
                            <option value="6°" {{ request('grado') === '6°' ? 'selected' : '' }}>6°</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label small fw-semibold mb-1" style="color: #003b73;">
                            <i class="fas fa-flag"></i> Estado
                        </label>
                        <select
                            name="estado"
                            class="form-select form-select-sm"
                            style="border-radius: 8px; border: 1.5px solid #e0e0e0; padding: 0.5rem 0.75rem;"
                        >
                            <option value="">Todos</option>
                            <option value="aprobada" {{ request('estado') === 'aprobada' ? 'selected' : '' }}>Aprobada</option>
                            <option value="pendiente" {{ request('estado') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="rechazada" {{ request('estado') === 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label small fw-semibold mb-1" style="color: #003b73;">
                            <i class="fas fa-calendar"></i> Año Lectivo
                        </label>
                        <select
                            name="anio"
                            class="form-select form-select-sm"
                            style="border-radius: 8px; border: 1.5px solid #e0e0e0; padding: 0.5rem 0.75rem;"
                        >
                            <option value="">Todos</option>
                            <option value="2025" {{ request('anio') === '2025' ? 'selected' : '' }}>2025</option>
                            <option value="2024" {{ request('anio') === '2024' ? 'selected' : '' }}>2024</option>
                            <option value="2023" {{ request('anio') === '2023' ? 'selected' : '' }}>2023</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm w-100" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; border-radius: 8px; padding: 0.5rem; font-weight: 600;">
                            <i class="fas fa-filter"></i> Filtrar
                        </button>
                    </div>
                </div>

                @if(request()->has('buscar') || request()->has('grado') || request()->has('estado') || request()->has('anio'))
                <div class="mt-2">
                    <a href="{{ route('matriculas.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 8px;">
                        <i class="fas fa-times"></i> Limpiar filtros
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Lista de matrículas -->
    @forelse($matriculas as $matricula)
    <div class="card border-0 shadow-sm mb-2 matricula-card" style="border-radius: 10px; transition: all 0.2s ease;">
        <div class="card-body p-2">
            <div class="row align-items-center g-2">

                <!-- Avatar y Datos -->
                <div class="col-lg-4">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 2px solid #4ec7d2;">
                            <span class="text-white fw-bold" style="font-size: 1rem;">
                                {{ strtoupper(substr($matricula->estudiante->nombre ?? 'N', 0, 1) . substr($matricula->estudiante->apellido ?? 'A', 0, 1)) }}
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <h6 class="mb-0 fw-semibold text-truncate" style="color: #003b73; font-size: 0.95rem;">
                                {{ $matricula->estudiante->nombre ?? 'N/A' }} {{ $matricula->estudiante->apellido ?? '' }}
                            </h6>
                            <small class="text-muted d-flex align-items-center gap-2" style="font-size: 0.75rem;">
                                <span><i class="fas fa-id-card me-1"></i>{{ $matricula->estudiante->dni ?? 'Sin DNI' }}</span>
                                <span><i class="fas fa-barcode me-1"></i>{{ $matricula->codigo_matricula }}</span>
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Información Académica -->
                <div class="col-lg-3">
                    <div class="d-flex flex-wrap gap-1">
                        <span class="badge" style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.35rem 0.7rem; font-weight: 600; font-size: 0.75rem;">
                            <i class="fas fa-graduation-cap me-1"></i>{{ $matricula->estudiante->grado ?? 'N/A' }}
                        </span>
                        <span class="badge" style="background: rgba(0, 59, 115, 0.1); color: #003b73; border: 1px solid #00508f; padding: 0.35rem 0.7rem; font-weight: 600; font-size: 0.75rem;">
                            <i class="fas fa-chalkboard me-1"></i>Sección {{ $matricula->estudiante->seccion ?? 'N/A' }}
                        </span>
                    </div>
                    <small class="text-muted d-block mt-1" style="font-size: 0.7rem;">
                        <i class="fas fa-calendar-alt"></i> {{ $matricula->anio_lectivo ?? 'N/A' }}
                    </small>
                </div>

                <!-- Información del Padre -->
                <div class="col-lg-2">
                    @if($matricula->padre)
                    <small class="d-block text-truncate" style="color: #003b73; font-size: 0.8rem;">
                        <i class="fas fa-user-friends text-muted"></i>
                        {{ $matricula->padre->nombre }} {{ $matricula->padre->apellido }}
                    </small>
                    <small class="text-muted d-block" style="font-size: 0.7rem;">
                        <i class="fas fa-phone"></i> {{ $matricula->padre->telefono ?? 'Sin teléfono' }}
                    </small>
                    @else
                    <small class="text-muted" style="font-size: 0.8rem;">
                        <i class="fas fa-user-times"></i> Sin padre asignado
                    </small>
                    @endif
                </div>

                <!-- Estado y Acciones -->
                <div class="col-lg-3">
                    <div class="d-flex align-items-center justify-content-end gap-2">
                        @if($matricula->estado === 'aprobada')
                            <span class="badge rounded-pill" style="background: rgba(40, 167, 69, 0.15); color: #28a745; padding: 0.35rem 0.8rem; font-weight: 600; border: 1px solid #28a745; font-size: 0.75rem;">
                                <i class="fas fa-check-circle"></i> Aprobada
                            </span>
                        @elseif($matricula->estado === 'pendiente')
                            <span class="badge rounded-pill" style="background: rgba(255, 193, 7, 0.15); color: #ffc107; padding: 0.35rem 0.8rem; font-weight: 600; border: 1px solid #ffc107; font-size: 0.75rem;">
                                <i class="fas fa-clock"></i> Pendiente
                            </span>
                        @elseif($matricula->estado === 'rechazada')
                            <span class="badge rounded-pill" style="background: rgba(220, 53, 69, 0.15); color: #dc3545; padding: 0.35rem 0.8rem; font-weight: 600; border: 1px solid #dc3545; font-size: 0.75rem;">
                                <i class="fas fa-times-circle"></i> Rechazada
                            </span>
                        @else
                            <span class="badge rounded-pill" style="background: rgba(108, 117, 125, 0.15); color: #6c757d; padding: 0.35rem 0.8rem; font-weight: 600; border: 1px solid #6c757d; font-size: 0.75rem;">
                                <i class="fas fa-circle"></i> {{ ucfirst($matricula->estado) }}
                            </span>
                        @endif

                        <div class="btn-group" role="group">
                            <a href="{{ route('matriculas.show', $matricula->id) }}"
                               class="btn btn-sm"
                               style="border-radius: 6px 0 0 6px; border: 1.5px solid #00508f; color: #00508f; background: white; padding: 0.35rem 0.7rem; font-size: 0.8rem;"
                               title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('matriculas.edit', $matricula->id) }}"
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
                <i class="fas fa-clipboard-list mb-3" style="font-size: 3rem; color: #00508f; opacity: 0.3;"></i>
                <h5 style="color: #003b73;">No hay matrículas registradas</h5>
                <p class="text-muted mb-3">
                    @if(request()->has('buscar') || request()->has('grado') || request()->has('estado') || request()->has('anio'))
                        No se encontraron resultados con los filtros aplicados
                    @else
                        Comienza registrando la primera matrícula
                    @endif
                </p>
                <a href="{{ route('matriculas.create') }}" class="btn" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; border-radius: 8px; padding: 0.6rem 1.5rem; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3);">
                    <i class="fas fa-plus me-1"></i>Nueva Matrícula
                </a>
            </div>
        </div>
    @endforelse

    <!-- Paginación -->
    @if($matriculas->hasPages())
    <div class="card border-0 shadow-sm mt-3" style="border-radius: 10px;">
        <div class="card-body py-2 px-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="text-muted small" style="font-size: 0.85rem;">
                    <i class="fas fa-list-ol"></i> Mostrando {{ $matriculas->firstItem() }} - {{ $matriculas->lastItem() }} de {{ $matriculas->total() }} matrículas
                </div>
                <div>
                    {{ $matriculas->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
    @endif

</div>

<style>
    .matricula-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 59, 115, 0.15) !important;
    }

    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .form-control:focus, .form-select:focus {
        border-color: #4ec7d2 !important;
        box-shadow: 0 0 0 0.2rem rgba(78, 199, 210, 0.25) !important;
    }
</style>
@endsection
