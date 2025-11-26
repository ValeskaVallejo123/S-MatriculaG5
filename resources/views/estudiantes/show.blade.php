@extends('layouts.app')

@section('title', 'Detalles del Estudiante')

@section('page-title', 'Detalles del Estudiante')

@section('topbar-actions')
    <div class="d-flex gap-2">
        <a href="{{ route('estudiantes.edit', $estudiante) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none; font-weight: 600; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3);">
            <i class="fas fa-edit me-1"></i>Editar
        </a>
        <a href="{{ route('estudiantes.index') }}" class="btn btn-sm" style="background: white; color: #00508f; padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none; font-weight: 600; border: 2px solid #00508f;">
            <i class="fas fa-arrow-left me-1"></i>Volver

            <a href="{{ route('padres.buscar', ['estudiante_id' => $estudiante->id]) }}" class="btn btn-primary">
    <i class="fas fa-link"></i> Vincular Padre/Tutor
</a>
        </a>
    </div>
@endsection

@section('content')
<div class="container" style="max-width: 1200px;">
    
    <!-- Tarjeta de Perfil -->
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px; overflow: hidden;">
        <!-- Header con gradiente -->
        <div style="background: linear-gradient(135deg, #00508f 0%, #003b73 100%); padding: 1.5rem;">
            <div class="d-flex align-items-center gap-3">
                <!-- Foto del estudiante -->
                @if($estudiante->foto)
                    <img src="{{ asset('storage/' . $estudiante->foto) }}" 
                         alt="Foto de {{ $estudiante->nombre_completo }}" 
                         style="width: 70px; height: 70px; border-radius: 12px; object-fit: cover; flex-shrink: 0; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); border: 3px solid #4ec7d2;">
                @else
                    <!-- Avatar con iniciales si no hay foto -->
                    <div style="width: 70px; height: 70px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); border: 3px solid #4ec7d2;">
                        <span style="color: #00508f; font-weight: 800; font-size: 1.8rem;">
                            {{ strtoupper(substr($estudiante->nombre, 0, 1) . substr($estudiante->apellido ?? 'E', 0, 1)) }}
                        </span>
                    </div>
                @endif
                
                <!-- Info principal -->
                <div class="flex-grow-1">
                    <h2 class="mb-1 fw-bold text-white" style="font-size: 1.4rem;">
                        {{ $estudiante->nombre_completo }}
                    </h2>
                    <p class="mb-0 text-white opacity-75" style="font-size: 0.9rem;">
                        <i class="fas fa-graduation-cap me-1"></i>
                        {{ $estudiante->grado }} - Sección {{ $estudiante->seccion }}
                    </p>
                </div>

                <!-- Badge de estado -->
                <div>
                    @if($estudiante->estado === 'activo')
                        <span class="badge" style="background: white; color: #00508f; padding: 0.5rem 1rem; font-size: 0.85rem; font-weight: 700; border-radius: 8px; border: 2px solid #4ec7d2;">
                            <i class="fas fa-circle" style="font-size: 0.5rem; color: #4ec7d2;"></i> Activo
                        </span>
                    @else
                        <span class="badge" style="background: white; color: #ef4444; padding: 0.5rem 1rem; font-size: 0.85rem; font-weight: 700; border-radius: 8px; border: 2px solid #ef4444;">
                            <i class="fas fa-circle" style="font-size: 0.5rem;"></i> Inactivo
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Contenido -->
        <div class="card-body p-3">
            
            <!-- Información Personal -->
            <div class="mb-3">
                <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center" style="color: #00508f; font-weight: 600; font-size: 0.95rem;">
                    <i class="fas fa-user me-2" style="font-size: 0.9rem;"></i>Información Personal
                </h6>
                <div class="row g-2">
                    <div class="col-md-6">
                        <div class="p-2" style="background: rgba(78, 199, 210, 0.08); border-radius: 8px; border-left: 3px solid #4ec7d2;">
                            <p class="text-muted mb-0" style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Nombre</p>
                            <p class="mb-0 fw-semibold" style="color: #003b73; font-size: 0.9rem;">{{ $estudiante->nombre }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-2" style="background: rgba(78, 199, 210, 0.08); border-radius: 8px; border-left: 3px solid #4ec7d2;">
                            <p class="text-muted mb-0" style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Apellido</p>
                            <p class="mb-0 fw-semibold" style="color: #003b73; font-size: 0.9rem;">{{ $estudiante->apellido }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-2" style="background: rgba(78, 199, 210, 0.08); border-radius: 8px; border-left: 3px solid #4ec7d2;">
                            <p class="text-muted mb-0" style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">DNI</p>
                            <p class="mb-0 fw-semibold font-monospace" style="color: #003b73; font-size: 0.9rem;">{{ $estudiante->dni ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-2" style="background: rgba(78, 199, 210, 0.08); border-radius: 8px; border-left: 3px solid #4ec7d2;">
                            <p class="text-muted mb-0" style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Fecha de Nacimiento</p>
                            <p class="mb-0 fw-semibold" style="color: #003b73; font-size: 0.9rem;">
                                {{ $estudiante->fecha_nacimiento ? \Carbon\Carbon::parse($estudiante->fecha_nacimiento)->format('d/m/Y') : 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información de Contacto -->
            <div class="mb-3">
                <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center" style="color: #00508f; font-weight: 600; font-size: 0.95rem;">
                    <i class="fas fa-address-book me-2" style="font-size: 0.9rem;"></i>Información de Contacto
                </h6>
                <div class="row g-2">
                    <div class="col-md-6">
                        <div class="p-2" style="background: rgba(78, 199, 210, 0.08); border-radius: 8px; border-left: 3px solid #4ec7d2;">
                            <p class="text-muted mb-0" style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Email</p>
                            <p class="mb-0 fw-semibold text-break" style="color: #003b73; font-size: 0.85rem;">{{ $estudiante->email ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-2" style="background: rgba(78, 199, 210, 0.08); border-radius: 8px; border-left: 3px solid #4ec7d2;">
                            <p class="text-muted mb-0" style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Teléfono</p>
                            <p class="mb-0 fw-semibold" style="color: #003b73; font-size: 0.9rem;">{{ $estudiante->telefono ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-2" style="background: rgba(78, 199, 210, 0.08); border-radius: 8px; border-left: 3px solid #4ec7d2;">
                            <p class="text-muted mb-0" style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Dirección</p>
                            <p class="mb-0 fw-semibold" style="color: #003b73; font-size: 0.9rem;">{{ $estudiante->direccion ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información Académica -->
            <div class="mb-3">
                <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center" style="color: #00508f; font-weight: 600; font-size: 0.95rem;">
                    <i class="fas fa-graduation-cap me-2" style="font-size: 0.9rem;"></i>Información Académica
                </h6>
                <div class="row g-2">
                    <div class="col-md-6">
                        <div class="p-2" style="background: rgba(78, 199, 210, 0.08); border-radius: 8px; border-left: 3px solid #4ec7d2;">
                            <p class="text-muted mb-0" style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Grado</p>
                            <p class="mb-0 fw-semibold" style="color: #003b73; font-size: 0.9rem;">{{ $estudiante->grado }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-2" style="background: rgba(78, 199, 210, 0.08); border-radius: 8px; border-left: 3px solid #4ec7d2;">
                            <p class="text-muted mb-0" style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Sección</p>
                            <p class="mb-0 fw-semibold" style="color: #003b73; font-size: 0.9rem;">{{ $estudiante->seccion }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Observaciones -->
            @if($estudiante->observaciones)
            <div class="mb-3">
                <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center" style="color: #00508f; font-weight: 600; font-size: 0.95rem;">
                    <i class="fas fa-clipboard me-2" style="font-size: 0.9rem;"></i>Observaciones
                </h6>
                <div class="p-2" style="background: rgba(78, 199, 210, 0.08); border-radius: 8px; border-left: 3px solid #4ec7d2;">
                    <p class="mb-0" style="color: #003b73; font-size: 0.9rem; line-height: 1.6;">{{ $estudiante->observaciones }}</p>
                </div>
            </div>
            @endif

            <!-- Información del Sistema -->
            <div class="mb-2">
                <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center" style="color: #00508f; font-weight: 600; font-size: 0.95rem;">
                    <i class="fas fa-clock me-2" style="font-size: 0.9rem;"></i>Datos del Sistema
                </h6>
                <div class="row g-2">
                    <div class="col-md-6">
                        <div class="p-2" style="background: rgba(78, 199, 210, 0.08); border-radius: 8px; border-left: 3px solid #4ec7d2;">
                            <p class="text-muted mb-0" style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Fecha de Registro</p>
                            <p class="mb-0 fw-semibold" style="color: #003b73; font-size: 0.9rem;">
                                {{ $estudiante->created_at ? $estudiante->created_at->format('d/m/Y H:i') : 'N/A' }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-2" style="background: rgba(78, 199, 210, 0.08); border-radius: 8px; border-left: 3px solid #4ec7d2;">
                            <p class="text-muted mb-0" style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Última Actualización</p>
                            <p class="mb-0 fw-semibold" style="color: #003b73; font-size: 0.9rem;">
                                {{ $estudiante->updated_at ? $estudiante->updated_at->format('d/m/Y H:i') : 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="pt-3 border-top mt-3">
                <div class="d-flex gap-2">
                    <a href="{{ route('estudiantes.edit', $estudiante) }}" class="btn btn-sm flex-fill" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); padding: 0.6rem; border-radius: 8px; font-weight: 600;">
                        <i class="fas fa-edit me-1"></i>Editar
                    </a>
                    <a href="{{ route('estudiantes.index') }}" class="btn btn-sm flex-fill" style="border: 2px solid #00508f; color: #00508f; background: white; padding: 0.6rem; border-radius: 8px; font-weight: 600;">
                        <i class="fas fa-arrow-left me-1"></i>Volver
                    </a>
                    <button type="button" onclick="confirmDelete()" class="btn btn-sm flex-fill" style="border: 2px solid #ef4444; color: #ef4444; background: white; padding: 0.6rem; border-radius: 8px; font-weight: 600;">
                        <i class="fas fa-trash me-1"></i>Eliminar
                    </button>
                    
                    <!-- Form oculto para eliminar -->
                    <form id="delete-form" action="{{ route('estudiantes.destroy', $estudiante) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación -->
<div id="deleteModal" class="modal fade" tabindex="-1" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden;">
            <!-- Header -->
            <div class="modal-header border-0" style="background: rgba(239, 68, 68, 0.1); padding: 1.2rem;">
                <div class="d-flex align-items-center gap-2">
                    <div style="width: 40px; height: 40px; background: rgba(239, 68, 68, 0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-exclamation-triangle" style="color: #ef4444; font-size: 1.2rem;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title mb-0 fw-bold" style="color: #003b73;">Confirmar Eliminación</h5>
                        <p class="mb-0 small text-muted">Esta acción no se puede deshacer</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <!-- Body -->
            <div class="modal-body" style="padding: 1.5rem;">
                <p class="mb-2" style="color: #003b73; font-size: 0.95rem;">
                    ¿Está seguro que desea eliminar al estudiante <strong>{{ $estudiante->nombre_completo }}</strong>?
                </p>
                <p class="text-muted small mb-0">
                    Se perderán todos los datos asociados a este estudiante de forma permanente.
                </p>
            </div>
            
            <!-- Footer -->
            <div class="modal-footer border-0" style="background: #f8f9fa; padding: 1rem 1.5rem;">
                <button type="button" class="btn btn-sm" data-bs-dismiss="modal" style="border: 2px solid #00508f; color: #00508f; background: white; padding: 0.5rem 1.2rem; border-radius: 8px; font-weight: 600;">
                    Cancelar
                </button>
                <button type="button" onclick="submitDelete()" class="btn btn-sm" style="background: #ef4444; color: white; border: none; padding: 0.5rem 1.2rem; border-radius: 8px; font-weight: 600; box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);">
                    Sí, Eliminar
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let deleteModal;

document.addEventListener('DOMContentLoaded', function() {
    deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
});

function confirmDelete() {
    deleteModal.show();
}

function submitDelete() {
    document.getElementById('delete-form').submit();
}
</script>
@endpush

@push('styles')
<style>
    .border-bottom {
        border-color: rgba(0, 80, 143, 0.15) !important;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }
    
    button[style*="border: 2px solid #ef4444"]:hover {
        background: #ef4444 !important;
        color: white !important;
    }
    
    a[style*="border: 2px solid #00508f"]:hover {
        background: #00508f !important;
        color: white !important;
    }
</style>
@endpush
@endsection