@extends('layouts.app')

@section('title', 'Detalles del Ciclo')

@section('page-title', 'Detalles del Ciclo')

@section('topbar-actions')
    <div class="d-flex gap-2">
        <a href="{{ route('ciclos.edit', $ciclo) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none; font-weight: 600; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3);">
            <i class="fas fa-edit me-1"></i>Editar
        </a>
        <a href="{{ route('ciclos.index') }}" class="btn btn-sm" style="background: white; color: #00508f; padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none; font-weight: 600; border: 2px solid #00508f;">
            <i class="fas fa-arrow-left me-1"></i>Volver
        </a>
    </div>
@endsection

@section('content')
<div class="container" style="max-width: 900px;">
    
    <!-- Tarjeta Principal del Ciclo -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 10px; overflow: hidden;">
        
        <!-- Header con gradiente (Información principal del Ciclo) -->
        <div style="background: linear-gradient(135deg, #00508f 0%, #003b73 100%); padding: 1.5rem;">
            <div class="d-flex align-items-center gap-3">
                
                <!-- Icono del Ciclo -->
                <div style="width: 70px; height: 70px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); border: 3px solid #4ec7d2;">
                    <i class="fas fa-school" style="color: #00508f; font-size: 2rem;"></i>
                </div>
                
                <!-- Info principal -->
                <div class="flex-grow-1">
                    <h2 class="mb-1 fw-bold text-white" style="font-size: 1.4rem;">
                        {{ $ciclo->nombre }}
                    </h2>
                    <p class="mb-0 text-white opacity-75" style="font-size: 0.9rem;">
                        <i class="fas fa-layer-group me-1"></i>
                        Sección: {{ $ciclo->seccion ?? 'N/A' }}
                    </p>
                </div>

                <!-- Badge de ID -->
                <div>
                    <span class="badge" style="background: white; color: #00508f; padding: 0.5rem 1rem; font-size: 0.85rem; font-weight: 700; border-radius: 8px; border: 2px solid #4ec7d2;">
                        ID: {{ $ciclo->id }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Cuerpo del Card con Detalles -->
        <div class="card-body p-4">
            
            <!-- Información General -->
            <div class="mb-4">
                <h6 class="mb-3 pb-2 border-bottom d-flex align-items-center" style="color: #00508f; font-weight: 600; font-size: 0.95rem;">
                    <i class="fas fa-info-circle me-2" style="font-size: 0.9rem;"></i>Información General
                </h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-2" style="background: rgba(78, 199, 210, 0.08); border-radius: 8px; border-left: 3px solid #4ec7d2;">
                            <p class="text-muted mb-0" style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Nombre Completo</p>
                            <p class="mb-0 fw-semibold" style="color: #003b73; font-size: 0.9rem;">{{ $ciclo->nombre }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-2" style="background: rgba(78, 199, 210, 0.08); border-radius: 8px; border-left: 3px solid #4ec7d2;">
                            <p class="text-muted mb-0" style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Sección</p>
                            <p class="mb-0 fw-semibold" style="color: #003b73; font-size: 0.9rem;">{{ $ciclo->seccion ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-2" style="background: rgba(78, 199, 210, 0.08); border-radius: 8px; border-left: 3px solid #4ec7d2;">
                            <p class="text-muted mb-0" style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Jornada</p>
                            <p class="mb-0 fw-semibold" style="color: #003b73; font-size: 0.9rem;">{{ $ciclo->jornada ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-2" style="background: rgba(78, 199, 210, 0.08); border-radius: 8px; border-left: 3px solid #4ec7d2;">
                            <p class="text-muted mb-0" style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Última Actualización</p>
                            <p class="mb-0 fw-semibold" style="color: #003b73; font-size: 0.9rem;">
                                {{ $ciclo->updated_at?->format('d/m/Y H:i') ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección de Clases -->
            <div class="mb-4">
                <h6 class="mb-3 pb-2 border-bottom d-flex align-items-center" style="color: #00508f; font-weight: 600; font-size: 0.95rem;">
                    <i class="fas fa-book me-2" style="font-size: 0.9rem;"></i>Clases Asignadas
                </h6>
                
                <div class="row g-2">
                    @php
                        // Simulación de colores para cada clase usando las variables de color del diseño
                        $clases = [
                            ['nombre' => 'Lenguaje y Literatura', 'color' => '#4ec7d2'], // Cian
                            ['nombre' => 'Matemáticas', 'color' => '#00508f'], // Azul
                            ['nombre' => 'Ciencias Naturales', 'color' => '#9333ea'], // Púrpura
                            ['nombre' => 'Ciencias Sociales', 'color' => '#f59e0b'], // Ámbar/Amarillo
                            ['nombre' => 'Formación en Tecnología e Informática', 'color' => '#4f46e5'], // Índigo
                            ['nombre' => 'Inglés', 'color' => '#ef4444'], // Rojo
                            ['nombre' => 'Educación Física', 'color' => '#f97316'], // Naranja
                            ['nombre' => 'Educación Artística', 'color' => '#ec4899'], // Rosa
                        ];
                    @endphp

                    @foreach($clases as $clase)
                    <div class="col-md-6">
                        <div class="p-2" style="background: rgba(0, 80, 143, 0.05); border-radius: 8px; border-left: 3px solid {{ $clase['color'] }};">
                            <h5 class="mb-0" style="font-size: 0.9rem; font-weight: 600; color: #003b73;">
                                {{ $clase['nombre'] }}
                            </h5>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Botones de Acción (al final del card) -->
            <div class="pt-3 border-top mt-3">
                <div class="d-flex gap-2">
                    <a href="{{ route('ciclos.edit', $ciclo) }}" class="btn btn-sm flex-fill" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); padding: 0.6rem; border-radius: 8px; font-weight: 600;">
                        <i class="fas fa-edit me-1"></i>Editar
                    </a>
                    
                    <button type="button" onclick="confirmDelete()" class="btn btn-sm flex-fill" style="border: 2px solid #ef4444; color: #ef4444; background: white; padding: 0.6rem; border-radius: 8px; font-weight: 600;">
                        <i class="fas fa-trash me-1"></i>Eliminar
                    </button>
                    
                    <!-- Form oculto para eliminar -->
                    <form id="delete-form" action="{{ route('ciclos.destroy', $ciclo) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación -->
<div id="deleteModal" class="modal fade" tabindex="-1">
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
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- Body -->
            <div class="modal-body" style="padding: 1.5rem;">
                <p class="mb-2" style="color: #003b73; font-size: 0.95rem;">
                    ¿Está seguro que desea eliminar el ciclo <strong>{{ $ciclo->nombre }}</strong>?
                </p>
                <p class="text-muted small mb-0">
                    Se perderán todos los datos asociados (incluyendo estudiantes y clases) de forma permanente.
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
        // Asegúrate de que 'bootstrap' esté cargado para usar Modal
        if (typeof bootstrap !== 'undefined' && document.getElementById('deleteModal')) {
            deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        }
    });

    function confirmDelete() {
        if (deleteModal) {
            deleteModal.show();
        } else {
            // Fallback en caso de que Bootstrap no se cargue correctamente
            if (confirm('¿Está seguro de eliminar este ciclo?')) {
                submitDelete();
            }
        }
    }

    function submitDelete() {
        document.getElementById('delete-form').submit();
    }
</script>
@endpush

@push('styles')
<style>
    .border-bottom {
        /* Color de línea divisoria más suave, usando el tono primario */
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
</style>
@endpush
@endsection