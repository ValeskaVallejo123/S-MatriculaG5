@extends('layouts.app')

@section('title', 'Detalles del Grado')

@section('page-title', 'Detalles del Grado')

@section('topbar-actions')
    <div class="d-flex gap-2">
        <a href="{{ route('grados.edit', $grado) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none; font-weight: 600; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3);">
            <i class="fas fa-edit me-1"></i>Editar
        </a>
        <a href="{{ route('grados.index') }}" class="btn btn-sm" style="background: white; color: #00508f; padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none; font-weight: 600; border: 2px solid #00508f;">
            <i class="fas fa-arrow-left me-1"></i>Volver
        </a>
    </div>
@endsection

@section('content')
<div class="container" style="max-width: 1200px;">
    
    <!-- Tarjeta de Perfil del Grado -->
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px; overflow: hidden;">
        <!-- Header con gradiente -->
        <div style="background: linear-gradient(135deg, #00508f 0%, #003b73 100%); padding: 1.5rem;">
            <div class="d-flex align-items-center gap-3">
                <!-- Icono del grado -->
                <div style="width: 70px; height: 70px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); border: 3px solid #4ec7d2;">
                    <i class="fas fa-graduation-cap" style="color: #00508f; font-size: 2rem;"></i>
                </div>
                
                <!-- Info principal -->
                <div class="flex-grow-1">
                    <h2 class="mb-1 fw-bold text-white" style="font-size: 1.4rem;">
                        {{ $grado->nombre }}
                    </h2>
                    <p class="mb-0 text-white opacity-75" style="font-size: 0.9rem;">
                        <i class="fas fa-users me-1"></i>
                        Sección {{ $grado->seccion ?? 'N/A' }}
                    </p>
                </div>

                <!-- Badge de jornada -->
                <div>
                    @if($grado->jornada == 'Matutina')
                        <span class="badge" style="background: white; color: #00508f; padding: 0.5rem 1rem; font-size: 0.85rem; font-weight: 700; border-radius: 8px; border: 2px solid #4ec7d2;">
                            <i class="fas fa-sun" style="font-size: 0.7rem; color: #4ec7d2;"></i> Matutina
                        </span>
                    @else
                        <span class="badge" style="background: white; color: #00508f; padding: 0.5rem 1rem; font-size: 0.85rem; font-weight: 700; border-radius: 8px; border: 2px solid #00508f;">
                            <i class="fas fa-moon" style="font-size: 0.7rem;"></i> Vespertina
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Contenido -->
        <div class="card-body p-3">
            
            <!-- Información General -->
            <div class="mb-3">
                <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center" style="color: #00508f; font-weight: 600; font-size: 0.95rem;">
                    <i class="fas fa-info-circle me-2" style="font-size: 0.9rem;"></i>Información General
                </h6>
                <div class="row g-2">
                    <div class="col-md-6">
                        <div class="p-2" style="background: rgba(78, 199, 210, 0.08); border-radius: 8px; border-left: 3px solid #4ec7d2;">
                            <p class="text-muted mb-0" style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">ID</p>
                            <p class="mb-0 fw-semibold font-monospace" style="color: #003b73; font-size: 0.9rem;">{{ $grado->id }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-2" style="background: rgba(78, 199, 210, 0.08); border-radius: 8px; border-left: 3px solid #4ec7d2;">
                            <p class="text-muted mb-0" style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Nombre del Grado</p>
                            <p class="mb-0 fw-semibold" style="color: #003b73; font-size: 0.9rem;">{{ $grado->nombre }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-2" style="background: rgba(78, 199, 210, 0.08); border-radius: 8px; border-left: 3px solid #4ec7d2;">
                            <p class="text-muted mb-0" style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Sección</p>
                            <p class="mb-0 fw-semibold" style="color: #003b73; font-size: 0.9rem;">{{ $grado->seccion ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-2" style="background: rgba(78, 199, 210, 0.08); border-radius: 8px; border-left: 3px solid #4ec7d2;">
                            <p class="text-muted mb-0" style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Jornada</p>
                            <p class="mb-0 fw-semibold" style="color: #003b73; font-size: 0.9rem;">
                                @if($grado->jornada == 'Matutina')
                                    ☀️ Matutina
                                @else
                                    🌙 Vespertina
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del Docente -->
            <div class="mb-3">
                <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center" style="color: #00508f; font-weight: 600; font-size: 0.95rem;">
                    <i class="fas fa-chalkboard-teacher me-2" style="font-size: 0.9rem;"></i>Docente Asignado
                </h6>
                <div class="row g-2">
                    <div class="col-12">
                        <div class="p-3 d-flex align-items-center gap-3" style="background: rgba(78, 199, 210, 0.08); border-radius: 8px; border-left: 3px solid #4ec7d2;">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);">
                                <i class="fas fa-user-tie" style="color: white; font-size: 1.3rem;"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-0" style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Maestro Titular</p>
                                <p class="mb-0 fw-semibold" style="color: #003b73; font-size: 1rem;">{{ $grado->nombre_maestro ?? 'Sin asignar' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Descripción -->
            @if($grado->descripcion)
            <div class="mb-3">
                <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center" style="color: #00508f; font-weight: 600; font-size: 0.95rem;">
                    <i class="fas fa-clipboard me-2" style="font-size: 0.9rem;"></i>Descripción
                </h6>
                <div class="p-2" style="background: rgba(78, 199, 210, 0.08); border-radius: 8px; border-left: 3px solid #4ec7d2;">
                    <p class="mb-0" style="color: #003b73; font-size: 0.9rem; line-height: 1.6;">{{ $grado->descripcion }}</p>
                </div>
            </div>
            @endif

            <!-- Asignaturas Comunes -->
            <div class="mb-3">
                <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center" style="color: #00508f; font-weight: 600; font-size: 0.95rem;">
                    <i class="fas fa-book me-2" style="font-size: 0.9rem;"></i>Asignaturas del Grado
                </h6>
                
                <div class="row g-2">
                    @php
                        $asignaturas = [
                            ['nombre' => 'Español', 'icono' => '📖', 'color' => '#ef4444'],
                            ['nombre' => 'Matemáticas', 'icono' => '🔢', 'color' => '#3b82f6'],
                            ['nombre' => 'Ciencias Naturales', 'icono' => '🔬', 'color' => '#10b981'],
                            ['nombre' => 'Ciencias Sociales', 'icono' => '🌍', 'color' => '#f59e0b'],
                            ['nombre' => 'Inglés', 'icono' => '🗣️', 'color' => '#8b5cf6'],
                            ['nombre' => 'Educación Física', 'icono' => '⚽', 'color' => '#f97316'],
                            ['nombre' => 'Formación Ciudadana', 'icono' => '🏛️', 'color' => '#6366f1'],
                            ['nombre' => 'Arte', 'icono' => '🎨', 'color' => '#ec4899'],
                        ];
                    @endphp

                    @foreach($asignaturas as $asignatura)
                    <div class="col-md-6 col-lg-3">
                        <div class="p-2 text-center" style="background: rgba(78, 199, 210, 0.08); border-radius: 8px; border: 1px solid rgba(78, 199, 210, 0.2); transition: all 0.2s ease;">
                            <span style="font-size: 2rem;">{{ $asignatura['icono'] }}</span>
                            <p class="mb-0 mt-1 fw-semibold" style="color: #003b73; font-size: 0.8rem;">{{ $asignatura['nombre'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-3 p-2" style="background: rgba(59, 130, 246, 0.1); border-left: 3px solid #3b82f6; border-radius: 8px;">
                    <p class="mb-0" style="color: #003b73; font-size: 0.85rem;">
                        <i class="fas fa-info-circle me-1" style="color: #3b82f6;"></i>
                        <strong>Nota:</strong> Estas son las asignaturas comunes del plan educativo hondureño.
                    </p>
                </div>
            </div>

            <!-- Información del Sistema -->
            <div class="mb-2">
                <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center" style="color: #00508f; font-weight: 600; font-size: 0.95rem;">
                    <i class="fas fa-clock me-2" style="font-size: 0.9rem;"></i>Datos del Sistema
                </h6>
                <div class="row g-2">
                    <div class="col-md-6">
                        <div class="p-2" style="background: rgba(78, 199, 210, 0.08); border-radius: 8px; border-left: 3px solid #4ec7d2;">
                            <p class="text-muted mb-0" style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Fecha de Creación</p>
                            <p class="mb-0 fw-semibold" style="color: #003b73; font-size: 0.9rem;">
                                {{ $grado->created_at ? $grado->created_at->format('d/m/Y H:i') : 'N/A' }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-2" style="background: rgba(78, 199, 210, 0.08); border-radius: 8px; border-left: 3px solid #4ec7d2;">
                            <p class="text-muted mb-0" style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Última Actualización</p>
                            <p class="mb-0 fw-semibold" style="color: #003b73; font-size: 0.9rem;">
                                {{ $grado->updated_at ? $grado->updated_at->format('d/m/Y H:i') : 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="pt-3 border-top mt-3">
                <div class="d-flex gap-2">
                    <a href="{{ route('grados.edit', $grado) }}" class="btn btn-sm flex-fill" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); padding: 0.6rem; border-radius: 8px; font-weight: 600;">
                        <i class="fas fa-edit me-1"></i>Editar
                    </a>
                    <a href="{{ route('grados.index') }}" class="btn btn-sm flex-fill" style="border: 2px solid #00508f; color: #00508f; background: white; padding: 0.6rem; border-radius: 8px; font-weight: 600;">
                        <i class="fas fa-arrow-left me-1"></i>Volver
                    </a>
                    <button type="button" onclick="confirmDelete()" class="btn btn-sm flex-fill" style="border: 2px solid #ef4444; color: #ef4444; background: white; padding: 0.6rem; border-radius: 8px; font-weight: 600;">
                        <i class="fas fa-trash me-1"></i>Eliminar
                    </button>
                    
                    <!-- Form oculto para eliminar -->
                    <form id="delete-form" action="{{ route('grados.destroy', $grado) }}" method="POST" style="display: none;">
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
                    ¿Está seguro que desea eliminar el grado <strong>{{ $grado->nombre }}</strong>?
                </p>
                <p class="text-muted small mb-0">
                    Se perderán todos los datos asociados a este grado de forma permanente.
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

    .col-md-6.col-lg-3 > div:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(78, 199, 210, 0.2);
    }
</style>
@endpush
@endsection