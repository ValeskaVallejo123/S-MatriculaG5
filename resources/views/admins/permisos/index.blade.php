@extends('layouts.app')

@section('title', 'Gestión de Permisos de Padres')
@section('page-title', 'Gestión de Permisos de Padres')

@push('styles')
<style>
    .avatar-circle {
        box-shadow: 0 2px 8px rgba(0,59,115,0.15);
    }
    .table tbody tr {
        transition: all 0.2s ease;
    }
    .table tbody tr:hover {
        background-color: #f8f9fa;
        transform: translateX(2px);
    }
</style>
@endpush

@section('content')
<div class="container-fluid" style="max-width: 1400px;">

    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold" style="color:#003b73;">
                <i class="fas fa-user-lock me-2"></i>Gestión de Permisos de Padres
            </h2>
            <p class="text-muted mb-0">Configure qué información y acciones puede realizar cada padre/tutor</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>Volver al Dashboard
        </a>
    </div>

    {{-- Mensajes --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-1"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Info --}}
    <div class="alert alert-info mb-4 border-0"
         style="border-left:4px solid #4ec7d2 !important; border-radius:8px; background:rgba(78,199,210,0.08);">
        <i class="fas fa-info-circle me-2" style="color:#00508f;"></i>
        <strong style="color:#00508f;">Instrucciones:</strong>
        <span class="text-muted"> Seleccione un padre/tutor para configurar los permisos específicos de acceso a la información de sus hijos.</span>
    </div>

    {{-- Buscador --}}
    <div class="card shadow-sm mb-4 border-0" style="border-radius:10px;">
        <div class="card-body">
            <form action="{{ route('admin.permisos.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-10">
                        <div class="input-group">
                            <span class="input-group-text bg-white" style="border-color:#dee2e6;">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input
                                type="text"
                                name="buscar"
                                class="form-control"
                                placeholder="Buscar por nombre, apellido, DNI o email..."
                                value="{{ request('buscar') }}"
                            >
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100" style="border-radius:8px;">
                            <i class="fas fa-search me-1"></i>Buscar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="card shadow-sm border-0" style="border-radius:12px;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:linear-gradient(135deg,#003b73 0%,#00508f 100%);">
                    <tr>
                        <th class="px-4 py-3 text-white fw-semibold">
                            <i class="fas fa-user me-1"></i>Padre/Tutor
                        </th>
                        <th class="px-4 py-3 text-white fw-semibold">
                            <i class="fas fa-id-card me-1"></i>DNI
                        </th>
                        <th class="px-4 py-3 text-white fw-semibold">
                            <i class="fas fa-users me-1"></i>Parentesco
                        </th>
                        <th class="px-4 py-3 text-white fw-semibold">
                            <i class="fas fa-envelope me-1"></i>Contacto
                        </th>
                        <th class="px-4 py-3 text-white fw-semibold">
                            <i class="fas fa-child me-1"></i>Hijos
                        </th>
                        <th class="px-4 py-3 text-white fw-semibold text-center">
                            <i class="fas fa-cogs me-1"></i>Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($padres as $padre)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center gap-3">
                                {{-- Iniciales protegidas con ?? para evitar crash si es null --}}
                                <div class="avatar-circle"
                                     style="width:40px;height:40px;background:linear-gradient(135deg,#4ec7d2,#3ba5b0);color:white;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0;">
                                    {{ strtoupper(substr($padre->nombre ?? 'P', 0, 1)) }}{{ strtoupper(substr($padre->apellido ?? 'A', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold" style="color:#003b73;">
                                        {{ $padre->nombre ?? 'N/A' }} {{ $padre->apellido ?? '' }}
                                    </div>
                                    <small>
                                        @if(($padre->estado ?? '') === 'activo')
                                            <span class="badge bg-success">Activo</span>
                                        @else
                                            <span class="badge bg-secondary">Inactivo</span>
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </td>

                        <td class="px-4 py-3 text-muted">{{ $padre->dni ?? 'N/A' }}</td>

                        <td class="px-4 py-3">
                            <span class="badge"
                                  style="background:rgba(0,80,143,0.1);color:#003b73;border:1px solid #4ec7d2;">
                                {{ $padre->parentesco_formateado }}
                            </span>
                        </td>

                        <td class="px-4 py-3">
                            <small class="d-block text-muted">
                                <i class="fas fa-envelope me-1"></i>{{ $padre->correo ?? 'N/A' }}
                            </small>
                            <small class="d-block text-muted">
                                <i class="fas fa-phone me-1"></i>{{ $padre->telefono ?? 'N/A' }}
                            </small>
                        </td>

                        <td class="px-4 py-3">
                            <span class="badge bg-info">
                                {{ $padre->estudiantes->count() }}
                                {{ $padre->estudiantes->count() === 1 ? 'hijo' : 'hijos' }}
                            </span>
                        </td>

                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('admin.permisos.configurar', $padre->id) }}"
                               class="btn btn-sm btn-primary"
                               style="border-radius:6px;"
                               title="Configurar permisos">
                                <i class="fas fa-cog me-1"></i>Configurar
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="fas fa-users fa-3x mb-3" style="color:#cbd5e1;"></i>
                            <p class="text-muted mb-0 fw-semibold">No se encontraron padres registrados</p>
                            <small class="text-muted">Intente con otros términos de búsqueda</small>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        @if($padres->hasPages())
        <div class="card-footer bg-white py-3 px-4" style="border-radius:0 0 12px 12px;">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <small class="text-muted">
                    Mostrando {{ $padres->firstItem() }}–{{ $padres->lastItem() }} de {{ $padres->total() }} padres
                </small>
                {{ $padres->links() }}
            </div>
        </div>
        @endif
    </div>

<style>
    .avatar-circle {
        box-shadow: 0 2px 8px rgba(0, 59, 115, 0.15);
    }

    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
        transform: translateX(2px);
    }

    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
</style>
@endsection
