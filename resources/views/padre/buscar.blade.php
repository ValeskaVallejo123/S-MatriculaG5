@extends('layouts.app')

@section('title', 'Buscar Padre/Tutor')

@section('content')
<div class="container-fluid" style="max-width: 1200px;">

    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #003b73; font-weight: 700;">
                <i class="fas fa-search"></i> Buscar Padre/Tutor
            </h2>
            @if($estudiante)
            <p class="text-muted mb-0">
                Para vincular con: <strong>{{ $estudiante->nombre }} {{ $estudiante->apellido }}</strong>
            </p>
            @else
            <p class="text-muted mb-0">Busca un padre/tutor registrado en el sistema</p>
            @endif
        </div>
        <a href="{{ $estudiante ? route('estudiantes.show', $estudiante->id) : route('padres.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <!-- Mensajes -->
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

    <!-- Formulario de Búsqueda -->
    <div class="card shadow-sm mb-4">
        <div class="card-header" style="background: linear-gradient(135deg, #003b73 0%, #00508f 100%); color: white;">
            <h5 class="mb-0">
                <i class="fas fa-filter"></i> Filtros de Búsqueda
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('padres.buscar') }}" method="GET" id="search-form">
                @if($estudiante)
                    <input type="hidden" name="estudiante_id" value="{{ $estudiante->id }}">
                @endif
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="nombre" class="form-label fw-bold">
                            <i class="fas fa-user"></i> Nombre
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="nombre"
                            name="nombre"
                            value="{{ request('nombre') }}"
                            placeholder="Ej: Juan"
                        >
                    </div>

                    <div class="col-md-3">
                        <label for="apellido" class="form-label fw-bold">
                            <i class="fas fa-user"></i> Apellido
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="apellido"
                            name="apellido"
                            value="{{ request('apellido') }}"
                            placeholder="Ej: Pérez"
                        >
                    </div>

                    <div class="col-md-2">
                        <label for="dni" class="form-label fw-bold">
                            <i class="fas fa-id-card"></i> DNI
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="dni"
                            name="dni"
                            value="{{ request('dni') }}"
                            placeholder="0801-1990-12345"
                        >
                    </div>

                    <div class="col-md-2">
                        <label for="telefono" class="form-label fw-bold">
                            <i class="fas fa-phone"></i> Teléfono
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="telefono"
                            name="telefono"
                            value="{{ request('telefono') }}"
                            placeholder="9876-5432"
                        >
                    </div>

                    <div class="col-md-2">
                        <label for="correo" class="form-label fw-bold">
                            <i class="fas fa-envelope"></i> Correo
                        </label>
                        <input
                            type="email"
                            class="form-control"
                            id="correo"
                            name="correo"
                            value="{{ request('correo') }}"
                            placeholder="ejemplo@gm.hn"
                        >
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                        <a href="{{ route('padres.buscar') }}{{ $estudiante ? '?estudiante_id=' . $estudiante->id : '' }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Limpiar Filtros
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Resultados de Búsqueda -->
    @if(request()->hasAny(['nombre', 'apellido', 'dni', 'correo', 'telefono']))
        @if($padres->count() > 0)
        <div class="card shadow-sm">
            <div class="card-header" style="background-color: #e8f4f8;">
                <h5 class="mb-0" style="color: #003b73;">
                    <i class="fas fa-list"></i> Resultados de Búsqueda ({{ $padres->count() }})
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background-color: #f8f9fa;">
                            <tr>
                                <th class="px-4 py-3">Padre/Tutor</th>
                                <th class="px-4 py-3">DNI</th>
                                <th class="px-4 py-3">Contacto</th>
                                <th class="px-4 py-3">Hijos Vinculados</th>
                                <th class="px-4 py-3 text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($padres as $padre)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; border: 2px solid #4ec7d2;">
                                            <span class="text-white fw-bold" style="font-size: 0.9rem;">
                                                {{ strtoupper(substr($padre->nombre, 0, 1) . substr($padre->apellido, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="fw-bold" style="color: #003b73;">
                                                {{ $padre->nombre }} {{ $padre->apellido }}
                                            </div>
                                            <small class="text-muted">
                                                {{ $padre->parentesco_formateado ?? ucfirst($padre->parentesco) }}
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-muted">{{ $padre->dni ?? 'N/A' }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <small class="d-block">
                                        <i class="fas fa-envelope text-primary"></i> {{ $padre->correo ?? 'N/A' }}
                                    </small>
                                    <small class="d-block">
                                        <i class="fas fa-phone text-success"></i> {{ $padre->telefono ?? 'N/A' }}
                                    </small>
                                </td>
                                <td class="px-4 py-3">
                                    @if($padre->estudiantes->count() > 0)
                                        <div class="badge bg-info">
                                            {{ $padre->estudiantes->count() }}
                                            {{ $padre->estudiantes->count() === 1 ? 'hijo' : 'hijos' }}
                                        </div>
                                        <div class="mt-1">
                                            @foreach($padre->estudiantes->take(2) as $hijo)
                                                <small class="d-block text-muted">
                                                    • {{ $hijo->nombre }} {{ $hijo->apellido }}
                                                </small>
                                            @endforeach
                                            @if($padre->estudiantes->count() > 2)
                                                <small class="text-muted">
                                                    ...y {{ $padre->estudiantes->count() - 2 }} más
                                                </small>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-muted">Sin hijos vinculados</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($estudiante)
                                        @php
                                            $yaVinculado = $padre->estudiantes->contains($estudiante->id);
                                        @endphp
                                        @if($yaVinculado)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle"></i> Ya vinculado
                                            </span>
                                     @else
    <button type="button"
            class="btn btn-sm btn-vincular"
            style="border-radius: 6px; border: 1.5px solid #00508f; color: #00508f; background: white; padding: 0.3rem 0.8rem; font-size: 0.8rem; font-weight: 600;"
            data-padre-id="{{ $padre->id }}"
            data-padre-nombre="{{ $padre->nombre }} {{ $padre->apellido }}"
            onmouseover="this.style.background='#00508f'; this.style.color='white';"
            onmouseout="this.style.background='white'; this.style.color='#00508f';">
        <i class="fas fa-link me-1"></i> Seleccionar
    </button>
@endif
                                        <a href="{{ route('padres.show', $padre->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i> Ver
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @else
        <!-- Sin Resultados -->
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-search fa-3x mb-3" style="color: #00508f; opacity: 0.3;"></i>
                <h5 style="color: #003b73;">No se encontraron resultados</h5>
                <p class="text-muted mb-3">
                    No hay padres/tutores registrados con los criterios de búsqueda especificados.
                </p>
                <a href="{{ route('padres.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Crear Nuevo Padre/Tutor
                </a>
            </div>
        </div>
        @endif
    @else
        <!-- Mensaje inicial -->
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-search fa-3x mb-3" style="color: #4ec7d2;"></i>
                <h5 style="color: #003b73;">Busca un Padre/Tutor</h5>
                <p class="text-muted mb-0">
                    Utiliza los filtros de arriba para buscar un padre/tutor registrado en el sistema.
                </p>
            </div>
        </div>
    @endif
</div>

<!-- Modal de Confirmación -->
<div class="modal fade" id="modalConfirmacion" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #003b73 0%, #00508f 100%); color: white;">
                <h5 class="modal-title">
                    <i class="fas fa-link"></i> Confirmar Vinculación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">
                    ¿Está seguro de vincular a <strong id="nombre-padre"></strong> con el estudiante
                    <strong>{{ $estudiante->nombre ?? '' }} {{ $estudiante->apellido ?? '' }}</strong>?
                </p>
                <div class="alert alert-info mb-0">
                    <i class="fas fa-info-circle"></i>
                    <strong>Nota:</strong> Esta acción creará una matrícula activa entre el padre y el estudiante.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cancelar
                </button>
                <form action="{{ route('padres.vincular') }}" method="POST" id="form-vincular">
                    @csrf
                    <input type="hidden" name="padre_id" id="padre-id-hidden">
                    <input type="hidden" name="estudiante_id" value="{{ $estudiante->id ?? '' }}">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check"></i> Confirmar Vinculación
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .table tbody tr:hover {
        background-color: #f8f9fa;
    }
    .form-control:focus {
        border-color: #4ec7d2;
        box-shadow: 0 0 0 0.25rem rgba(78, 199, 210, 0.25);
    }
</style>

<script>
function confirmarVinculacion(padreId, nombrePadre) {
    document.getElementById('nombre-padre').textContent = nombrePadre;
    document.getElementById('padre-id-hidden').value = padreId;
    const modal = new bootstrap.Modal(document.getElementById('modalConfirmacion'));
    modal.show();
}
</script>
@endsection
