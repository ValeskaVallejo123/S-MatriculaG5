@extends('layouts.app')

@section('title', 'Gestión de Permisos de Padres')

@section('content')
<div class="container-fluid" style="max-width: 1400px;">

    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #003b73; font-weight: 700;">
                <i class="fas fa-user-lock"></i> Gestión de Permisos de Padres
            </h2>
            <p class="text-muted mb-0">Configure qué información y acciones puede realizar cada padre/tutor</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Volver al Dashboard
        </a>
    </div>

    <!-- Mensajes de éxito/error -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Información de ayuda -->
    <div class="alert alert-info mb-4">
        <i class="fas fa-info-circle"></i>
        <strong>Instrucciones:</strong>
        Seleccione un padre/tutor para configurar los permisos específicos de acceso a la información de sus hijos.
    </div>

    <!-- Barra de búsqueda -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.permisos.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-10">
                        <div class="input-group">
                            <span class="input-group-text bg-white">
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
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de Padres -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background: linear-gradient(135deg, #003b73 0%, #00508f 100%); color: white;">
                        <tr>
                            <th class="px-4 py-3">
                                <i class="fas fa-user"></i> Padre/Tutor
                            </th>
                            <th class="px-4 py-3">
                                <i class="fas fa-id-card"></i> DNI
                            </th>
                            <th class="px-4 py-3">
                                <i class="fas fa-users"></i> Parentesco
                            </th>
                            <th class="px-4 py-3">
                                <i class="fas fa-envelope"></i> Contacto
                            </th>
                            <th class="px-4 py-3">
                                <i class="fas fa-child"></i> Hijos
                            </th>
                            <th class="px-4 py-3 text-center">
                                <i class="fas fa-cogs"></i> Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($padres as $padre)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, #4ec7d2, #3ba5b0); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700;">
                                        {{ strtoupper(substr($padre->nombre, 0, 1)) }}{{ strtoupper(substr($padre->apellido, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $padre->nombre }} {{ $padre->apellido }}</div>
                                        <small class="text-muted">
                                            @if($padre->estado === 'activo')
                                                <span class="badge bg-success">Activo</span>
                                            @else
                                                <span class="badge bg-secondary">Inactivo</span>
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-muted">{{ $padre->dni ?? 'N/A' }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="badge" style="background-color: #e8f4f8; color: #003b73;">
                                    {{ $padre->parentesco_formateado }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div>
                                    <small class="d-block text-muted">
                                        <i class="fas fa-envelope"></i> {{ $padre->email ?? 'N/A' }}
                                    </small>
                                    <small class="d-block text-muted">
                                        <i class="fas fa-phone"></i> {{ $padre->telefono ?? 'N/A' }}
                                    </small>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="badge bg-info">
                                    {{ $padre->estudiantes->count() }}
                                    {{ $padre->estudiantes->count() === 1 ? 'hijo' : 'hijos' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a
                                    href="{{ route('admin.permisos.configurar', $padre->id) }}"
                                    class="btn btn-sm btn-primary"
                                    title="Configurar permisos"
                                >
                                    <i class="fas fa-cog"></i> Configurar
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">No se encontraron padres registrados</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($padres->hasPages())
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Mostrando {{ $padres->firstItem() }} - {{ $padres->lastItem() }} de {{ $padres->total() }} padres
                </div>
                {{ $padres->links() }}
            </div>
        </div>
        @endif
    </div>
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
