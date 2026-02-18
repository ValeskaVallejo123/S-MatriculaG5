@extends('layouts.app')

@section('title', 'Detalles del Profesor')

@section('page-title', 'Detalles del Profesor')

@section('topbar-actions')
    <a href="{{ route('profesores.index') }}" class="btn-back" style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #4ec7d2; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 1000px;">
    
    <!-- Tarjeta Principal del Profesor -->
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px; background: linear-gradient(135deg, rgba(78, 199, 210, 0.15) 0%, rgba(0, 80, 143, 0.1) 100%);">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <!-- Avatar -->
                <div class="col-auto">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 16px; display: flex; align-items: center; justify-content: center; border: 4px solid #4ec7d2; box-shadow: 0 4px 12px rgba(78, 199, 210, 0.3);">
                        <span class="text-white fw-bold" style="font-size: 2rem;">
                            {{ strtoupper(substr($profesor->nombre, 0, 1) . substr($profesor->apellido ?? '', 0, 1)) }}
                        </span>
                    </div>
                </div>
                
                <!-- Info Principal -->
                <div class="col">
                    <h2 class="mb-2 fw-bold" style="color: #003b73; font-size: 1.5rem;">{{ $profesor->nombre_completo }}</h2>
                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        @if($profesor->especialidad)
                        <span class="badge" style="background: rgba(78, 199, 210, 0.2); color: #00508f; border: 1px solid #4ec7d2; padding: 0.4rem 0.8rem; font-size: 0.8rem; font-weight: 600;">
                            <i class="fas fa-book me-1"></i>{{ $profesor->especialidad }}
                        </span>
                        @endif
                        @if($profesor->dni)
                        <span class="badge" style="background: rgba(0, 80, 143, 0.15); color: #003b73; border: 1px solid #00508f; padding: 0.4rem 0.8rem; font-size: 0.8rem; font-weight: 600;">
                            <i class="fas fa-id-card me-1"></i>{{ $profesor->dni }}
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Estado Badge -->
                <div class="col-auto">
                    @if($profesor->estado === 'activo')
                        <span class="badge rounded-pill" style="background: rgba(78, 199, 210, 0.2); color: #00508f; padding: 0.5rem 1rem; font-weight: 600; border: 2px solid #4ec7d2; font-size: 0.85rem;">
                            <i class="fas fa-circle" style="font-size: 0.5rem; color: #4ec7d2;"></i> Activo
                        </span>
                    @elseif($profesor->estado === 'licencia')
                        <span class="badge rounded-pill" style="background: #fef3c7; color: #92400e; padding: 0.5rem 1rem; font-weight: 600; border: 2px solid #fde68a; font-size: 0.85rem;">
                            <i class="fas fa-clock" style="font-size: 0.5rem;"></i> Licencia
                        </span>
                    @else
                        <span class="badge rounded-pill" style="background: #fee2e2; color: #991b1b; padding: 0.5rem 1rem; font-weight: 600; border: 2px solid #ef4444; font-size: 0.85rem;">
                            <i class="fas fa-circle" style="font-size: 0.5rem;"></i> Inactivo
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Información Personal -->
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-user" style="color: white; font-size: 0.9rem;"></i>
                </div>
                <h5 class="mb-0 fw-bold" style="color: #003b73;">Información Personal</h5>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="p-3 rounded" style="background: #f8f9fa; border-left: 3px solid #4ec7d2;">
                        <p class="text-muted mb-1 small fw-semibold" style="font-size: 0.75rem;">NOMBRE</p>
                        <p class="mb-0 fw-bold" style="color: #003b73;">{{ $profesor->nombre ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 rounded" style="background: #f8f9fa; border-left: 3px solid #4ec7d2;">
                        <p class="text-muted mb-1 small fw-semibold" style="font-size: 0.75rem;">APELLIDO</p>
                        <p class="mb-0 fw-bold" style="color: #003b73;">{{ $profesor->apellido ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 rounded" style="background: #f8f9fa; border-left: 3px solid #00508f;">
                        <p class="text-muted mb-1 small fw-semibold" style="font-size: 0.75rem;">DNI</p>
                        <p class="mb-0 fw-bold font-monospace" style="color: #003b73;">{{ $profesor->dni ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 rounded" style="background: #f8f9fa; border-left: 3px solid #00508f;">
                        <p class="text-muted mb-1 small fw-semibold" style="font-size: 0.75rem;">FECHA DE NACIMIENTO</p>
                        @if($profesor->fecha_nacimiento)
                            <p class="mb-0 fw-bold" style="color: #003b73;">{{ \Carbon\Carbon::parse($profesor->fecha_nacimiento)->format('d/m/Y') }}</p>
                            <p class="mb-0 small" style="color: #4ec7d2; font-weight: 600;">{{ \Carbon\Carbon::parse($profesor->fecha_nacimiento)->age }} años</p>
                        @else
                            <p class="mb-0 text-muted">No registrada</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 rounded" style="background: #f8f9fa; border-left: 3px solid #4ec7d2;">
                        <p class="text-muted mb-1 small fw-semibold" style="font-size: 0.75rem;">GÉNERO</p>
                        <p class="mb-0 fw-bold" style="color: #003b73;">{{ $profesor->genero ? ucfirst($profesor->genero) : 'N/A' }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 rounded" style="background: #f8f9fa; border-left: 3px solid #4ec7d2;">
                        <p class="text-muted mb-1 small fw-semibold" style="font-size: 0.75rem;">TELÉFONO</p>
                        <p class="mb-0 fw-bold font-monospace" style="color: #003b73;">{{ $profesor->telefono ?? 'No registrado' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información de Contacto -->
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-envelope" style="color: white; font-size: 0.9rem;"></i>
                </div>
                <h5 class="mb-0 fw-bold" style="color: #003b73;">Información de Contacto</h5>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="p-3 rounded" style="background: #f8f9fa; border-left: 3px solid #4ec7d2;">
                        <p class="text-muted mb-1 small fw-semibold" style="font-size: 0.75rem;">EMAIL</p>
                        <p class="mb-0 fw-bold text-break" style="color: #003b73;">{{ $profesor->email ?? 'No registrado' }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 rounded" style="background: #f8f9fa; border-left: 3px solid #4ec7d2;">
                        <p class="text-muted mb-1 small fw-semibold" style="font-size: 0.75rem;">DIRECCIÓN</p>
                        <p class="mb-0 fw-bold" style="color: #003b73;">{{ $profesor->direccion ?? 'No registrada' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información Académica -->
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-graduation-cap" style="color: white; font-size: 0.9rem;"></i>
                </div>
                <h5 class="mb-0 fw-bold" style="color: #003b73;">Información Académica</h5>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="p-3 rounded" style="background: #f8f9fa; border-left: 3px solid #4ec7d2;">
                        <p class="text-muted mb-1 small fw-semibold" style="font-size: 0.75rem;">ESPECIALIDAD</p>
                        <p class="mb-0 fw-bold" style="color: #003b73;">{{ $profesor->especialidad ?? 'No especificada' }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 rounded" style="background: #f8f9fa; border-left: 3px solid #4ec7d2;">
                        <p class="text-muted mb-1 small fw-semibold" style="font-size: 0.75rem;">NIVEL ACADÉMICO</p>
                        <p class="mb-0 fw-bold" style="color: #003b73;">{{ $profesor->nivel_academico ? ucfirst($profesor->nivel_academico) : 'No especificado' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información Laboral -->
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-briefcase" style="color: white; font-size: 0.9rem;"></i>
                </div>
                <h5 class="mb-0 fw-bold" style="color: #003b73;">Información Laboral</h5>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="p-3 rounded" style="background: #f8f9fa; border-left: 3px solid #00508f;">
                        <p class="text-muted mb-1 small fw-semibold" style="font-size: 0.75rem;">FECHA DE CONTRATACIÓN</p>
                        @if($profesor->fecha_contratacion)
                            <p class="mb-0 fw-bold" style="color: #003b73;">{{ \Carbon\Carbon::parse($profesor->fecha_contratacion)->format('d/m/Y') }}</p>
                            <p class="mb-0 small" style="color: #4ec7d2; font-weight: 600;">{{ \Carbon\Carbon::parse($profesor->fecha_contratacion)->diffForHumans() }}</p>
                        @else
                            <p class="mb-0 text-muted">No registrada</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 rounded" style="background: #f8f9fa; border-left: 3px solid #00508f;">
                        <p class="text-muted mb-1 small fw-semibold" style="font-size: 0.75rem;">TIPO DE CONTRATO</p>
                        <p class="mb-0 fw-bold" style="color: #003b73;">{{ $profesor->tipo_contrato ? ucwords(str_replace('_', ' ', $profesor->tipo_contrato)) : 'No especificado' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información del Sistema -->
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-info-circle" style="color: white; font-size: 0.9rem;"></i>
                </div>
                <h5 class="mb-0 fw-bold" style="color: #003b73;">Información del Sistema</h5>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="p-3 rounded" style="background: #f8f9fa; border-left: 3px solid #6c757d;">
                        <p class="text-muted mb-1 small fw-semibold" style="font-size: 0.75rem;">FECHA DE REGISTRO</p>
                        <p class="mb-0 fw-bold" style="color: #003b73;">{{ $profesor->created_at ? $profesor->created_at->format('d/m/Y H:i') : 'No disponible' }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 rounded" style="background: #f8f9fa; border-left: 3px solid #6c757d;">
                        <p class="text-muted mb-1 small fw-semibold" style="font-size: 0.75rem;">ÚLTIMA ACTUALIZACIÓN</p>
                        <p class="mb-0 fw-bold" style="color: #003b73;">{{ $profesor->updated_at ? $profesor->updated_at->format('d/m/Y H:i') : 'No disponible' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botones de Acción -->
    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('profesores.edit', $profesor->id) }}" class="btn flex-fill" style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); color: white; border: none; padding: 0.6rem 1.5rem; border-radius: 8px; font-weight: 600; box-shadow: 0 2px 8px rgba(251, 191, 36, 0.3); transition: all 0.3s ease;">
    <i class="fas fa-edit me-1"></i> Editar
</a>
                 
                </a>
                <a href="{{ route('profesores.index') }}" class="btn flex-fill" style="border: 2px solid #00508f; color: #00508f; background: white; padding: 0.6rem 1.5rem; border-radius: 8px; font-weight: 600; transition: all 0.3s ease;">
                    <i class="fas fa-arrow-left me-1"></i>Volver a la Lista
                </a>
                <button type="button" onclick="confirmDelete()" class="btn flex-fill" style="background: #ef4444; color: white; border: none; padding: 0.6rem 1.5rem; border-radius: 8px; font-weight: 600; box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3); transition: all 0.3s ease;">
                    <i class="fas fa-trash me-1"></i>Eliminar
                </button>
            </div>
        </div>
    </div>

</div>

<!-- Modal de Confirmación -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden;">
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
            <div class="modal-body" style="padding: 1.5rem;">
                <p class="mb-2" style="color: #003b73; font-size: 0.95rem;">
                    ¿Está seguro que desea eliminar al profesor <strong style="color: #ef4444;">{{ $profesor->nombre_completo }}</strong>?
                </p>
                <p class="text-muted small mb-0">Se perderán todos los datos asociados a este profesor.</p>
            </div>
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

<!-- Form oculto para eliminar -->
<form id="delete-form" action="{{ route('profesores.destroy', $profesor) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('styles')
<style>
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-close:focus {
        box-shadow: none;
    }
</style>
@endpush

@push('scripts')
<script>
let deleteModal = null;

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