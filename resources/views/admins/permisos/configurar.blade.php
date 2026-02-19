@extends('layouts.app')

@section('title', 'Configurar Permisos')
@section('page-title', 'Configurar Permisos')

@push('styles')
<style>
    .form-check-input:checked {
        background-color: #003b73;
        border-color: #003b73;
    }
    .form-check-input:focus {
        border-color: #4ec7d2;
        box-shadow: 0 0 0 0.25rem rgba(78,199,210,0.25);
    }
    .border.rounded {
        transition: all 0.3s ease;
    }
    .border.rounded:hover {
        box-shadow: 0 2px 8px rgba(0,59,115,0.1);
        border-color: #4ec7d2 !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid" style="max-width: 1200px;">

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold" style="color:#003b73;">
                <i class="fas fa-user-shield me-2"></i>Configurar Permisos
            </h2>
            <p class="text-muted mb-0">{{ $padre->nombre_completo }}</p>
        </div>
        <a href="{{ route('admin.permisos.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Volver
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

    {{-- Información del Padre --}}
    <div class="card shadow-sm mb-4 border-0" style="border-radius:12px;">
        <div class="card-header border-0 py-3 px-4"
             style="background:linear-gradient(135deg,#003b73 0%,#00508f 100%);border-radius:12px 12px 0 0;">
            <h5 class="text-white fw-bold mb-0">
                <i class="fas fa-user me-2"></i>Información del Padre/Tutor
            </h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <p class="mb-0">
                        <small class="text-muted fw-semibold text-uppercase" style="font-size:0.7rem;">Nombre</small><br>
                        <span class="fw-semibold" style="color:#003b73;">{{ $padre->nombre_completo }}</span>
                    </p>
                </div>
                <div class="col-md-4">
                    <p class="mb-0">
                        <small class="text-muted fw-semibold text-uppercase" style="font-size:0.7rem;">DNI</small><br>
                        <span class="fw-semibold" style="color:#003b73;">{{ $padre->dni ?? 'N/A' }}</span>
                    </p>
                </div>
                <div class="col-md-4">
                    <p class="mb-0">
                        <small class="text-muted fw-semibold text-uppercase" style="font-size:0.7rem;">Parentesco</small><br>
                        <span class="fw-semibold" style="color:#003b73;">{{ $padre->parentesco_formateado }}</span>
                    </p>
                </div>
                <div class="col-md-6">
                    <p class="mb-0">
                        <small class="text-muted fw-semibold text-uppercase" style="font-size:0.7rem;">Correo</small><br>
                        <span class="fw-semibold" style="color:#003b73;">{{ $padre->correo ?? 'N/A' }}</span>
                    </p>
                </div>
                <div class="col-md-6">
                    <p class="mb-0">
                        <small class="text-muted fw-semibold text-uppercase" style="font-size:0.7rem;">Teléfono</small><br>
                        <span class="fw-semibold" style="color:#003b73;">{{ $padre->telefono ?? 'N/A' }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Hijos del Padre --}}
    @if($padre->estudiantes->count() > 0)
        @foreach($padre->estudiantes as $estudiante)
        <div class="card shadow-sm mb-4 border-0" style="border-radius:12px;">

            <div class="card-header border-0 py-3 px-4"
                 style="background:rgba(0,80,143,0.07);border-radius:12px 12px 0 0;">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="fw-bold mb-0" style="color:#003b73;">
                        <i class="fas fa-child me-2" style="color:#4ec7d2;"></i>
                        {{-- Corregido: nombre1 y apellido1 según modelo Estudiante --}}
                        {{ $estudiante->nombre1 ?? 'N/A' }} {{ $estudiante->apellido1 ?? '' }}
                        <small class="text-muted fw-normal ms-2" style="font-size:0.8rem;">
                            ({{ $estudiante->grado ?? 'N/A' }} — {{ $estudiante->seccion ?? 'N/A' }})
                        </small>
                    </h5>
                    <div class="d-flex gap-2 flex-wrap">
                        <button type="button" class="btn btn-success btn-sm"
                                onclick="activarTodos({{ $padre->id }}, {{ $estudiante->id }})">
                            <i class="fas fa-check-double me-1"></i>Activar Todos
                        </button>
                        <button type="button" class="btn btn-warning btn-sm"
                                onclick="desactivarTodos({{ $padre->id }}, {{ $estudiante->id }})">
                            <i class="fas fa-times-circle me-1"></i>Desactivar Todos
                        </button>
                        <button type="button" class="btn btn-info btn-sm text-white"
                                onclick="establecerDefecto({{ $padre->id }}, {{ $estudiante->id }})">
                            <i class="fas fa-undo me-1"></i>Por Defecto
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('admin.permisos.guardar', $padre->id) }}"
                      method="POST"
                      id="form-{{ $estudiante->id }}">
                    @csrf
                    <input type="hidden" name="estudiante_id" value="{{ $estudiante->id }}">

                    <div class="row g-3">

                        {{-- Permisos de Visualización --}}
                        <div class="col-12">
                            <h6 class="fw-bold mb-3" style="color:#00508f;">
                                <i class="fas fa-eye me-2"></i>Permisos de Visualización
                            </h6>
                        </div>

                        @php $pe = $permisosExistentes[$estudiante->id] ?? null; @endphp

                        <div class="col-md-6">
                            <div class="form-check form-switch p-3 border rounded">
                                <input class="form-check-input" type="checkbox"
                                       name="ver_calificaciones"
                                       id="ver_calificaciones_{{ $estudiante->id }}"
                                       {{ $pe?->ver_calificaciones ? 'checked' : '' }}>
                                <label class="form-check-label" for="ver_calificaciones_{{ $estudiante->id }}">
                                    <i class="fas fa-star text-warning me-1"></i>
                                    <strong>Ver Calificaciones</strong>
                                    <small class="d-block text-muted">Permite ver las notas del estudiante</small>
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-check form-switch p-3 border rounded">
                                <input class="form-check-input" type="checkbox"
                                       name="ver_asistencias"
                                       id="ver_asistencias_{{ $estudiante->id }}"
                                       {{ $pe?->ver_asistencias ? 'checked' : '' }}>
                                <label class="form-check-label" for="ver_asistencias_{{ $estudiante->id }}">
                                    <i class="fas fa-calendar-check text-success me-1"></i>
                                    <strong>Ver Asistencias</strong>
                                    <small class="d-block text-muted">Permite ver el registro de asistencias</small>
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-check form-switch p-3 border rounded">
                                <input class="form-check-input" type="checkbox"
                                       name="ver_comportamiento"
                                       id="ver_comportamiento_{{ $estudiante->id }}"
                                       {{ $pe?->ver_comportamiento ? 'checked' : '' }}>
                                <label class="form-check-label" for="ver_comportamiento_{{ $estudiante->id }}">
                                    <i class="fas fa-smile text-info me-1"></i>
                                    <strong>Ver Comportamiento</strong>
                                    <small class="d-block text-muted">Permite ver reportes de conducta</small>
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-check form-switch p-3 border rounded">
                                <input class="form-check-input" type="checkbox"
                                       name="ver_tareas"
                                       id="ver_tareas_{{ $estudiante->id }}"
                                       {{ $pe?->ver_tareas ? 'checked' : '' }}>
                                <label class="form-check-label" for="ver_tareas_{{ $estudiante->id }}">
                                    <i class="fas fa-tasks text-primary me-1"></i>
                                    <strong>Ver Tareas</strong>
                                    <small class="d-block text-muted">Permite ver las tareas asignadas</small>
                                </label>
                            </div>
                        </div>

                        {{-- Permisos de Acción --}}
                        <div class="col-12 mt-2">
                            <h6 class="fw-bold mb-3" style="color:#00508f;">
                                <i class="fas fa-check-circle me-2"></i>Permisos de Acción
                            </h6>
                        </div>

                        <div class="col-md-6">
                            <div class="form-check form-switch p-3 border rounded">
                                <input class="form-check-input" type="checkbox"
                                       name="comunicarse_profesores"
                                       id="comunicarse_profesores_{{ $estudiante->id }}"
                                       {{ $pe?->comunicarse_profesores ? 'checked' : '' }}>
                                <label class="form-check-label" for="comunicarse_profesores_{{ $estudiante->id }}">
                                    <i class="fas fa-comments text-success me-1"></i>
                                    <strong>Comunicarse con Profesores</strong>
                                    <small class="d-block text-muted">Permite enviar mensajes a profesores</small>
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-check form-switch p-3 border rounded">
                                <input class="form-check-input" type="checkbox"
                                       name="autorizar_salidas"
                                       id="autorizar_salidas_{{ $estudiante->id }}"
                                       {{ $pe?->autorizar_salidas ? 'checked' : '' }}>
                                <label class="form-check-label" for="autorizar_salidas_{{ $estudiante->id }}">
                                    <i class="fas fa-door-open text-warning me-1"></i>
                                    <strong>Autorizar Salidas o Permisos</strong>
                                    <small class="d-block text-muted">Permite autorizar salidas anticipadas</small>
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-check form-switch p-3 border rounded">
                                <input class="form-check-input" type="checkbox"
                                       name="modificar_datos_contacto"
                                       id="modificar_datos_contacto_{{ $estudiante->id }}"
                                       {{ $pe?->modificar_datos_contacto ? 'checked' : '' }}>
                                <label class="form-check-label" for="modificar_datos_contacto_{{ $estudiante->id }}">
                                    <i class="fas fa-edit text-danger me-1"></i>
                                    <strong>Modificar Datos de Contacto</strong>
                                    <small class="d-block text-muted">Permite actualizar información personal</small>
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-check form-switch p-3 border rounded">
                                <input class="form-check-input" type="checkbox"
                                       name="descargar_boletas"
                                       id="descargar_boletas_{{ $estudiante->id }}"
                                       {{ $pe?->descargar_boletas ? 'checked' : '' }}>
                                <label class="form-check-label" for="descargar_boletas_{{ $estudiante->id }}">
                                    <i class="fas fa-download text-info me-1"></i>
                                    <strong>Descargar Boletas</strong>
                                    <small class="d-block text-muted">Permite descargar reportes académicos</small>
                                </label>
                            </div>
                        </div>

                        {{-- Notificaciones --}}
                        <div class="col-12 mt-2">
                            <h6 class="fw-bold mb-3" style="color:#00508f;">
                                <i class="fas fa-bell me-2"></i>Notificaciones
                            </h6>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch p-3 border rounded">
                                <input class="form-check-input" type="checkbox"
                                       name="recibir_notificaciones"
                                       id="recibir_notificaciones_{{ $estudiante->id }}"
                                       {{ $pe?->recibir_notificaciones ? 'checked' : '' }}>
                                <label class="form-check-label" for="recibir_notificaciones_{{ $estudiante->id }}">
                                    <i class="fas fa-envelope text-primary me-1"></i>
                                    <strong>Recibir Notificaciones</strong>
                                    <small class="d-block text-muted">Recibe alertas por email sobre el estudiante</small>
                                </label>
                            </div>
                        </div>

                        {{-- Notas Adicionales --}}
                        <div class="col-12 mt-2">
                            <label for="notas_adicionales_{{ $estudiante->id }}"
                                   class="form-label fw-bold" style="color:#003b73;">
                                <i class="fas fa-sticky-note text-warning me-1"></i>Notas Adicionales
                            </label>
                            <textarea class="form-control"
                                      id="notas_adicionales_{{ $estudiante->id }}"
                                      name="notas_adicionales"
                                      rows="3"
                                      placeholder="Agregar notas u observaciones especiales sobre estos permisos..."
                                      style="border-radius:8px;">{{ $pe->notas_adicionales ?? '' }}</textarea>
                        </div>

                        {{-- Botón Guardar --}}
                        <div class="col-12 mt-2">
                            <button type="submit" class="btn btn-primary fw-semibold w-100"
                                    style="border-radius:8px; padding:0.65rem;">
                                <i class="fas fa-save me-2"></i>Guardar Configuración
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        @endforeach

    @else
        <div class="alert alert-warning border-0"
             style="border-left:4px solid #f59e0b !important; border-radius:8px;">
            <i class="fas fa-exclamation-triangle me-2"></i>
            Este padre/tutor no tiene hijos registrados en el sistema.
        </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
function activarTodos(padreId, estudianteId) {
    document.getElementById(`form-${estudianteId}`)
            .querySelectorAll('input[type="checkbox"]')
            .forEach(cb => cb.checked = true);
}

function desactivarTodos(padreId, estudianteId) {
    document.getElementById(`form-${estudianteId}`)
            .querySelectorAll('input[type="checkbox"]')
            .forEach(cb => cb.checked = false);
}

function establecerDefecto(padreId, estudianteId) {
    if (confirm('¿Está seguro de establecer los permisos por defecto? Esto sobrescribirá la configuración actual.')) {
        window.location.href = `/admin/permisos/${padreId}/${estudianteId}/defecto`;
    }
}
</script>
@endpush
