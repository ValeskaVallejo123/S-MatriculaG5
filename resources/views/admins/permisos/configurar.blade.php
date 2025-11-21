@extends('layouts.app')

@section('title', 'Configurar Permisos')

@section('content')

<script>
function activarTodos(padreId, estudianteId) {
    const form = document.getElementById(`form-${estudianteId}`);
    const checkboxes = form.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(cb => cb.checked = true);
}

function desactivarTodos(padreId, estudianteId) {
    const form = document.getElementById(`form-${estudianteId}`);
    const checkboxes = form.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(cb => cb.checked = false);
}

function establecerDefecto(padreId, estudianteId) {
    if (confirm('¿Está seguro de establecer los permisos por defecto? Esto sobrescribirá la configuración actual.')) {
        window.location.href = `/admin/permisos/${padreId}/${estudianteId}/defecto`;
    }
}
</script>

<div class="container-fluid" style="max-width: 1200px;">
<<<<<<< HEAD

=======
    
>>>>>>> 0c60f43d83749cde12f470882b2070e271fe5d92
    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #003b73; font-weight: 700;">
                <i class="fas fa-user-shield"></i> Configurar Permisos
            </h2>
            <p class="text-muted mb-0">{{ $padre->nombre_completo }}</p>
        </div>
        <a href="{{ route('admin.permisos.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Volver
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

    <!-- Información del Padre -->
    <div class="card shadow-sm mb-4">
        <div class="card-header" style="background: linear-gradient(135deg, #003b73 0%, #00508f 100%); color: white;">
            <h5 class="mb-0">
                <i class="fas fa-user"></i> Información del Padre/Tutor
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <p class="mb-2">
                        <strong><i class="fas fa-user text-primary"></i> Nombre:</strong><br>
                        {{ $padre->nombre_completo }}
                    </p>
                </div>
                <div class="col-md-4">
                    <p class="mb-2">
                        <strong><i class="fas fa-id-card text-primary"></i> DNI:</strong><br>
                        {{ $padre->dni ?? 'N/A' }}
                    </p>
                </div>
                <div class="col-md-4">
                    <p class="mb-2">
                        <strong><i class="fas fa-users text-primary"></i> Parentesco:</strong><br>
                        {{ $padre->parentesco_formateado }}
                    </p>
                </div>
                <div class="col-md-6">
                    <p class="mb-2">
                        <strong><i class="fas fa-envelope text-primary"></i> Correo:</strong><br>
                        {{ $padre->correo ?? 'N/A' }}
                    </p>
                </div>
                <div class="col-md-6">
                    <p class="mb-2">
                        <strong><i class="fas fa-phone text-primary"></i> Teléfono:</strong><br>
                        {{ $padre->telefono ?? 'N/A' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Hijos del Padre -->
    @if($padre->estudiantes->count() > 0)
    <div class="row">
        @foreach($padre->estudiantes as $estudiante)
        <div class="col-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header" style="background-color: #e8f4f8;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0" style="color: #003b73;">
<<<<<<< HEAD
                            <i class="fas fa-child"></i>
=======
                            <i class="fas fa-child"></i> 
>>>>>>> 0c60f43d83749cde12f470882b2070e271fe5d92
                            {{ $estudiante->nombre }} {{ $estudiante->apellido }}
                            <small class="text-muted">({{ $estudiante->grado ?? 'N/A' }} - {{ $estudiante->seccion ?? 'N/A' }})</small>
                        </h5>
                        <div>
<<<<<<< HEAD
                            <button
                                type="button"
=======
                            <button 
                                type="button" 
>>>>>>> 0c60f43d83749cde12f470882b2070e271fe5d92
                                class="btn btn-sm btn-success me-2"
                                onclick="activarTodos({{ $padre->id }}, {{ $estudiante->id }})"
                            >
                                <i class="fas fa-check-double"></i> Activar Todos
                            </button>
<<<<<<< HEAD
                            <button
                                type="button"
=======
                            <button 
                                type="button" 
>>>>>>> 0c60f43d83749cde12f470882b2070e271fe5d92
                                class="btn btn-sm btn-warning me-2"
                                onclick="desactivarTodos({{ $padre->id }}, {{ $estudiante->id }})"
                            >
                                <i class="fas fa-times-circle"></i> Desactivar Todos
                            </button>
<<<<<<< HEAD
                            <button
                                type="button"
=======
                            <button 
                                type="button" 
>>>>>>> 0c60f43d83749cde12f470882b2070e271fe5d92
                                class="btn btn-sm btn-info"
                                onclick="establecerDefecto({{ $padre->id }}, {{ $estudiante->id }})"
                            >
                                <i class="fas fa-undo"></i> Por Defecto
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
<<<<<<< HEAD
                    <form
                        action="{{ route('admin.permisos.guardar', $padre->id) }}"
=======
                    <form 
                        action="{{ route('admin.permisos.guardar', $padre->id) }}" 
>>>>>>> 0c60f43d83749cde12f470882b2070e271fe5d92
                        method="POST"
                        id="form-{{ $estudiante->id }}"
                    >
                        @csrf
                        <input type="hidden" name="estudiante_id" value="{{ $estudiante->id }}">
<<<<<<< HEAD

=======
                        
>>>>>>> 0c60f43d83749cde12f470882b2070e271fe5d92
                        <div class="row g-3">
                            <!-- Permisos de Visualización -->
                            <div class="col-12">
                                <h6 class="fw-bold text-primary mb-3">
                                    <i class="fas fa-eye"></i> Permisos de Visualización
                                </h6>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded">
<<<<<<< HEAD
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="ver_calificaciones"
=======
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        name="ver_calificaciones" 
>>>>>>> 0c60f43d83749cde12f470882b2070e271fe5d92
                                        id="ver_calificaciones_{{ $estudiante->id }}"
                                        {{ isset($permisosExistentes[$estudiante->id]) && $permisosExistentes[$estudiante->id]->ver_calificaciones ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="ver_calificaciones_{{ $estudiante->id }}">
                                        <i class="fas fa-star text-warning"></i>
                                        <strong>Ver Calificaciones</strong>
                                        <small class="d-block text-muted">Permite ver las notas del estudiante</small>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded">
<<<<<<< HEAD
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="ver_asistencias"
=======
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        name="ver_asistencias" 
>>>>>>> 0c60f43d83749cde12f470882b2070e271fe5d92
                                        id="ver_asistencias_{{ $estudiante->id }}"
                                        {{ isset($permisosExistentes[$estudiante->id]) && $permisosExistentes[$estudiante->id]->ver_asistencias ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="ver_asistencias_{{ $estudiante->id }}">
                                        <i class="fas fa-calendar-check text-success"></i>
                                        <strong>Ver Asistencias</strong>
                                        <small class="d-block text-muted">Permite ver el registro de asistencias</small>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded">
<<<<<<< HEAD
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="ver_comportamiento"
=======
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        name="ver_comportamiento" 
>>>>>>> 0c60f43d83749cde12f470882b2070e271fe5d92
                                        id="ver_comportamiento_{{ $estudiante->id }}"
                                        {{ isset($permisosExistentes[$estudiante->id]) && $permisosExistentes[$estudiante->id]->ver_comportamiento ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="ver_comportamiento_{{ $estudiante->id }}">
                                        <i class="fas fa-smile text-info"></i>
                                        <strong>Ver Comportamiento</strong>
                                        <small class="d-block text-muted">Permite ver reportes de conducta</small>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded">
<<<<<<< HEAD
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="ver_tareas"
=======
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        name="ver_tareas" 
>>>>>>> 0c60f43d83749cde12f470882b2070e271fe5d92
                                        id="ver_tareas_{{ $estudiante->id }}"
                                        {{ isset($permisosExistentes[$estudiante->id]) && $permisosExistentes[$estudiante->id]->ver_tareas ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="ver_tareas_{{ $estudiante->id }}">
                                        <i class="fas fa-tasks text-primary"></i>
                                        <strong>Ver Tareas</strong>
                                        <small class="d-block text-muted">Permite ver las tareas asignadas</small>
                                    </label>
                                </div>
                            </div>

                            <!-- Permisos de Acción -->
                            <div class="col-12 mt-4">
                                <h6 class="fw-bold text-primary mb-3">
                                    <i class="fas fa-check-circle"></i> Permisos de Acción
                                </h6>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded">
<<<<<<< HEAD
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="comunicarse_profesores"
=======
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        name="comunicarse_profesores" 
>>>>>>> 0c60f43d83749cde12f470882b2070e271fe5d92
                                        id="comunicarse_profesores_{{ $estudiante->id }}"
                                        {{ isset($permisosExistentes[$estudiante->id]) && $permisosExistentes[$estudiante->id]->comunicarse_profesores ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="comunicarse_profesores_{{ $estudiante->id }}">
                                        <i class="fas fa-comments text-success"></i>
                                        <strong>Comunicarse con Profesores</strong>
                                        <small class="d-block text-muted">Permite enviar mensajes a profesores</small>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded">
<<<<<<< HEAD
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="autorizar_salidas"
=======
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        name="autorizar_salidas" 
>>>>>>> 0c60f43d83749cde12f470882b2070e271fe5d92
                                        id="autorizar_salidas_{{ $estudiante->id }}"
                                        {{ isset($permisosExistentes[$estudiante->id]) && $permisosExistentes[$estudiante->id]->autorizar_salidas ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="autorizar_salidas_{{ $estudiante->id }}">
                                        <i class="fas fa-door-open text-warning"></i>
                                        <strong>Autorizar Salidas o Permisos</strong>
                                        <small class="d-block text-muted">Permite autorizar salidas anticipadas</small>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded">
<<<<<<< HEAD
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="modificar_datos_contacto"
=======
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        name="modificar_datos_contacto" 
>>>>>>> 0c60f43d83749cde12f470882b2070e271fe5d92
                                        id="modificar_datos_contacto_{{ $estudiante->id }}"
                                        {{ isset($permisosExistentes[$estudiante->id]) && $permisosExistentes[$estudiante->id]->modificar_datos_contacto ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="modificar_datos_contacto_{{ $estudiante->id }}">
                                        <i class="fas fa-edit text-danger"></i>
                                        <strong>Modificar Datos de Contacto</strong>
                                        <small class="d-block text-muted">Permite actualizar información personal</small>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded">
<<<<<<< HEAD
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="descargar_boletas"
=======
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        name="descargar_boletas" 
>>>>>>> 0c60f43d83749cde12f470882b2070e271fe5d92
                                        id="descargar_boletas_{{ $estudiante->id }}"
                                        {{ isset($permisosExistentes[$estudiante->id]) && $permisosExistentes[$estudiante->id]->descargar_boletas ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="descargar_boletas_{{ $estudiante->id }}">
                                        <i class="fas fa-download text-info"></i>
                                        <strong>Descargar Boletas</strong>
                                        <small class="d-block text-muted">Permite descargar reportes académicos</small>
                                    </label>
                                </div>
                            </div>

                            <!-- Notificaciones -->
                            <div class="col-12 mt-4">
                                <h6 class="fw-bold text-primary mb-3">
                                    <i class="fas fa-bell"></i> Notificaciones
                                </h6>
                            </div>

                            <div class="col-md-12">
                                <div class="form-check form-switch p-3 border rounded">
<<<<<<< HEAD
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="recibir_notificaciones"
=======
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        name="recibir_notificaciones" 
>>>>>>> 0c60f43d83749cde12f470882b2070e271fe5d92
                                        id="recibir_notificaciones_{{ $estudiante->id }}"
                                        {{ isset($permisosExistentes[$estudiante->id]) && $permisosExistentes[$estudiante->id]->recibir_notificaciones ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="recibir_notificaciones_{{ $estudiante->id }}">
                                        <i class="fas fa-envelope text-primary"></i>
                                        <strong>Recibir Notificaciones</strong>
                                        <small class="d-block text-muted">Recibe alertas por email sobre el estudiante</small>
                                    </label>
                                </div>
                            </div>

                            <!-- Notas Adicionales -->
                            <div class="col-12 mt-4">
                                <label for="notas_adicionales_{{ $estudiante->id }}" class="form-label fw-bold">
                                    <i class="fas fa-sticky-note text-warning"></i> Notas Adicionales
                                </label>
<<<<<<< HEAD
                                <textarea
                                    class="form-control"
                                    id="notas_adicionales_{{ $estudiante->id }}"
                                    name="notas_adicionales"
=======
                                <textarea 
                                    class="form-control" 
                                    id="notas_adicionales_{{ $estudiante->id }}" 
                                    name="notas_adicionales" 
>>>>>>> 0c60f43d83749cde12f470882b2070e271fe5d92
                                    rows="3"
                                    placeholder="Agregar notas u observaciones especiales sobre estos permisos..."
                                >{{ $permisosExistentes[$estudiante->id]->notas_adicionales ?? '' }}</textarea>
                            </div>

                            <!-- Botón de Guardar -->
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-save"></i> Guardar Configuración
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle"></i>
        Este padre/tutor no tiene hijos registrados en el sistema.
    </div>
    @endif
</div>

<style>
    .form-check-input:checked {
        background-color: #003b73;
        border-color: #003b73;
    }
<<<<<<< HEAD

=======
    
>>>>>>> 0c60f43d83749cde12f470882b2070e271fe5d92
    .form-check-input:focus {
        border-color: #4ec7d2;
        box-shadow: 0 0 0 0.25rem rgba(78, 199, 210, 0.25);
    }
<<<<<<< HEAD

    .border.rounded {
        transition: all 0.3s ease;
    }

=======
    
    .border.rounded {
        transition: all 0.3s ease;
    }
    
>>>>>>> 0c60f43d83749cde12f470882b2070e271fe5d92
    .border.rounded:hover {
        box-shadow: 0 2px 8px rgba(0, 59, 115, 0.1);
        border-color: #4ec7d2 !important;
    }
</style>

<<<<<<< HEAD
@endsection
=======
@endsection
>>>>>>> 0c60f43d83749cde12f470882b2070e271fe5d92
