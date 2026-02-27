@extends('layouts.app')

@section('title', 'Inscripciones')

@section('page-title', 'Gestión de Inscripciones')

@section('topbar-actions')
    <button type="button" class="btn-back" data-bs-toggle="modal" data-bs-target="#nuevaInscripcionModal" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); font-size: 0.9rem;">
        <i class="fas fa-plus"></i>
        Nueva Asignación
    </button>
@endsection

@section('content')
<div class="container" style="max-width: 1400px;">

    

    {{-- Mensajes --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Stats --}}
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="border-radius: 10px; background: linear-gradient(135deg, rgba(78, 199, 210, 0.1) 0%, rgba(0, 80, 143, 0.05) 100%);">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-clipboard-check" style="color: white; font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">Total Inscripciones</p>
                            <h4 class="mb-0 fw-bold" style="color: #003b73;">{{ $inscripciones->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="border-radius: 10px; background: linear-gradient(135deg, rgba(40, 167, 69, 0.1) 0%, rgba(40, 167, 69, 0.05) 100%);">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-check-circle" style="color: white; font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">Con Sección</p>
                            <h4 class="mb-0 fw-bold" style="color: #28a745;">{{ $inscripciones->whereNotNull('seccion_id')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="border-radius: 10px; background: linear-gradient(135deg, rgba(255, 193, 7, 0.1) 0%, rgba(255, 193, 7, 0.05) 100%);">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-clock" style="color: white; font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">Sin Asignar</p>
                            <h4 class="mb-0 fw-bold" style="color: #ffc107;">{{ $inscripciones->whereNull('seccion_id')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
        <div class="card-body p-3">
            <form action="{{ request()->url() }}" method="GET">
                <div class="row g-2 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label small fw-semibold mb-1" style="color: #003b73;">
                            <i class="fas fa-search"></i> Buscar
                        </label>
                        <input
                            type="text"
                            name="buscar"
                            class="form-control form-control-sm"
                            placeholder="Nombre o email del alumno..."
                            value="{{ request('buscar') }}"
                            style="border-radius: 8px; border: 1.5px solid #e0e0e0; padding: 0.5rem 0.75rem;"
                        >
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-semibold mb-1" style="color: #003b73;">
                            <i class="fas fa-chalkboard"></i> Estado de Sección
                        </label>
                        <select name="estado" class="form-select form-select-sm" style="border-radius: 8px; border: 1.5px solid #e0e0e0; padding: 0.5rem 0.75rem;">
                            <option value="">Todos</option>
                            <option value="asignada"   {{ request('estado') === 'asignada'   ? 'selected' : '' }}>Con sección</option>
                            <option value="sin_asignar"{{ request('estado') === 'sin_asignar' ? 'selected' : '' }}>Sin asignar</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm w-100" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; border-radius: 8px; padding: 0.5rem; font-weight: 600;">
                            <i class="fas fa-filter"></i> Filtrar
                        </button>
                    </div>
                </div>

                @if(request()->has('buscar') || request()->has('estado'))
                <div class="mt-2">
                    <a href="{{ request()->url() }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 8px;">
                        <i class="fas fa-times"></i> Limpiar filtros
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>

    {{-- Lista de inscripciones --}}
    @forelse($secciones as $seccion)
    <div class="card border-0 shadow-sm mb-2 inscripcion-card" style="border-radius: 10px; transition: all 0.2s ease;">
        <div class="card-body p-2">
            <div class="row align-items-center g-2">

                {{-- Avatar y datos del alumno --}}
                <div class="col-lg-4">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 2px solid #4ec7d2;">
                            <span class="text-white fw-bold" style="font-size: 1rem;">
                                {{ strtoupper(substr($seccion->estudiante->nombre ?? 'N', 0, 1) . substr($seccion->estudiante->nombre ?? 'A', 1, 1)) }}
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <h6 class="mb-0 fw-semibold text-truncate" style="color: #003b73; font-size: 0.95rem;">
                                {{ $seccion->estudiante->nombre ?? 'N/A' }}
                            </h6>
                            <small class="text-muted d-flex align-items-center gap-2" style="font-size: 0.75rem;">
                                <span><i class="fas fa-envelope me-1"></i>{{ $seccion->estudiante->email ?? 'Sin email' }}</span>
                            </small>
                        </div>
                    </div>
                </div>

                {{-- Información de sección --}}
                <div class="col-lg-3">
                    <div class="d-flex flex-wrap gap-1">
                        @if($seccion->seccion)
                            <span class="badge" style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.35rem 0.7rem; font-weight: 600; font-size: 0.75rem;">
                                <i class="fas fa-chalkboard me-1"></i>{{ $seccion->seccion->nombre }}
                            </span>
                        @else
                            <span class="badge" style="background: rgba(255, 193, 7, 0.15); color: #b45309; border: 1px solid #ffc107; padding: 0.35rem 0.7rem; font-weight: 600; font-size: 0.75rem;">
                                <i class="fas fa-exclamation-triangle me-1"></i>Sin asignar
                            </span>
                        @endif
                    </div>
                    @if($seccion->seccion)
                    <small class="text-muted d-block mt-1" style="font-size: 0.7rem;">
                        <i class="fas fa-users"></i> Disponibles: {{ $seccion->seccion->capacidadRestante() }}
                    </small>
                    @endif
                </div>

                {{-- Fecha de inscripción --}}
                <div class="col-lg-3">
                    <small class="d-block" style="color: #003b73; font-size: 0.8rem;">
                        <i class="fas fa-calendar-alt text-muted me-1"></i>
                        {{ \Carbon\Carbon::parse($seccion->fecha_inscripcion)->format('d/m/Y') }}
                    </small>
                    <small class="text-muted d-block" style="font-size: 0.7rem;">
                        <i class="fas fa-clock me-1"></i>{{ \Carbon\Carbon::parse($seccion->fecha_inscripcion)->format('H:i') }}
                    </small>
                </div>

                {{-- Estado badge + acción --}}
                <div class="col-lg-2">
                    <div class="d-flex align-items-center justify-content-end gap-2">

                        {{-- Badge de estado --}}
                        @if($seccion->seccion)
                            <span class="badge rounded-pill" style="background: rgba(40, 167, 69, 0.15); color: #28a745; padding: 0.35rem 0.8rem; font-weight: 600; border: 1px solid #28a745; font-size: 0.75rem;">
                                <i class="fas fa-check-circle"></i> Asignada
                            </span>
                        @else
                            <span class="badge rounded-pill" style="background: rgba(255, 193, 7, 0.15); color: #b45309; padding: 0.35rem 0.8rem; font-weight: 600; border: 1px solid #ffc107; font-size: 0.75rem;">
                                <i class="fas fa-clock"></i> Pendiente
                            </span>
                        @endif

                        {{-- Botón acción --}}
                        @if(!$seccion->seccion)
                            <button type="button"
                                    class="btn btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#asignarSeccionModal{{ $seccion->id }}"
                                    style="border-radius: 6px; border: 1.5px solid #4ec7d2; color: #4ec7d2; background: white; padding: 0.35rem 0.7rem; font-size: 0.8rem;"
                                    title="Asignar sección">
                                <i class="fas fa-user-check"></i>
                            </button>
                        @else
                            <button type="button"
                                    class="btn btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#asignarSeccionModal{{ $seccion->id }}"
                                    style="border-radius: 6px; border: 1.5px solid #00508f; color: #00508f; background: white; padding: 0.35rem 0.7rem; font-size: 0.8rem;"
                                    title="Cambiar sección">
                                <i class="fas fa-exchange-alt"></i>
                            </button>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Modal asignar sección individual --}}
    <div class="modal fade" id="asignarSeccionModal{{ $seccion->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
                <div class="modal-header" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 12px 12px 0 0; border: none;">
                    <h5 class="modal-title text-white">
                        <i class="fas fa-user-check me-2"></i>Asignar Sección
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('secciones.asignar') }}" method="POST">
                    @csrf
                    <input type="hidden" name="estudiante_id" value="{{ $seccion->estudiante->id }}">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: #003b73;">
                                <i class="fas fa-user"></i> Alumno
                            </label>
                            <input type="text" class="form-control" value="{{ $seccion->estudiante->nombre }}" disabled style="background: #f8f9fa; border-radius: 8px;">
                        </div>
                        <div class="mb-3">
                            <label for="seccion_id{{ $seccion->id }}" class="form-label fw-semibold" style="color: #003b73;">
                                <i class="fas fa-chalkboard"></i> Sección *
                            </label>
                            <select name="seccion_id" id="seccion_id{{ $seccion->id }}" class="form-select" required style="border-radius: 8px; border: 1.5px solid #e0e0e0;">
                                <option value="">-- Seleccione una sección --</option>
                                @foreach ($secciones as $s)
                                    <option value="{{ $s->id }}" {{ isset($s->seccion_id) && $s->seccion_id == $s->id ? 'selected' : '' }}>
                                        {{ $s->nombre }} (Disponibles: {{ $s->capacidadRestante() }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid #e0e0e0; padding: 1rem 1.5rem;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">
                            <i class="fas fa-times"></i> Cancelar
                        </button>
                        <button type="submit" class="btn" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; border-radius: 8px; box-shadow: 0 2px 8px rgba(78,199,210,0.3);">
                            <i class="fas fa-check"></i> Confirmar Asignación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @empty
        <div class="card border-0 shadow-sm" style="border-radius: 10px;">
            <div class="card-body text-center py-5">
                <i class="fas fa-clipboard-list mb-3" style="font-size: 3rem; color: #00508f; opacity: 0.3;"></i>
                <h5 style="color: #003b73;">No hay inscripciones registradas</h5>
                <p class="text-muted mb-3">
                    @if(request()->has('buscar') || request()->has('estado'))
                        No se encontraron resultados con los filtros aplicados
                    @else
                        Comienza asignando secciones a los alumnos inscritos
                    @endif
                </p>
            </div>
        </div>
    @endforelse

    {{-- Paginación (si $secciones es paginado) --}}
    @if(method_exists($secciones, 'hasPages') && $secciones->hasPages())
    <div class="card border-0 shadow-sm mt-3" style="border-radius: 10px;">
        <div class="card-body py-2 px-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="text-muted small" style="font-size: 0.85rem;">
                    <i class="fas fa-list-ol"></i> Mostrando {{ $secciones->firstItem() }} - {{ $secciones->lastItem() }} de {{ $secciones->total() }} inscripciones
                </div>
                <div>
                    {{ $secciones->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
    @endif

</div>

{{-- Modal nueva asignación --}}
<div class="modal fade" id="nuevaInscripcionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
            <div class="modal-header" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 12px 12px 0 0; border: none;">
                <h5 class="modal-title text-white">
                    <i class="fas fa-plus-circle me-2"></i>Nueva Asignación de Sección
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('secciones.asignar') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="estudiante_id" class="form-label fw-semibold" style="color: #003b73;">
                            <i class="fas fa-user"></i> Alumno *
                        </label>
                        <select name="estudiante_id" id="estudiante_id" class="form-select" required style="border-radius: 8px; border: 1.5px solid #e0e0e0;">
                            <option value="">-- Seleccione un alumno --</option>
                            @foreach ($alumnos as $alumno)
                                <option value="{{ $alumno->id }}">{{ $alumno->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="seccion_id_new" class="form-label fw-semibold" style="color: #003b73;">
                            <i class="fas fa-chalkboard"></i> Sección *
                        </label>
                        <select name="seccion_id" id="seccion_id_new" class="form-select" required style="border-radius: 8px; border: 1.5px solid #e0e0e0;">
                            <option value="">-- Seleccione una sección --</option>
                            @foreach ($secciones as $s)
                                <option value="{{ $s->id }}">{{ $s->nombre }} (Disponibles: {{ $s->capacidadRestante() }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e0e0e0; padding: 1rem 1.5rem;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; border-radius: 8px; box-shadow: 0 2px 8px rgba(78,199,210,0.3);">
                        <i class="fas fa-check"></i> Confirmar Asignación
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .inscripcion-card:hover {
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
    .modal-content {
        animation: slideDown 0.3s ease-out;
    }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection