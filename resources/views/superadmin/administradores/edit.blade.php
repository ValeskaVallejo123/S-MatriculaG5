@extends('layouts.app')

@section('title', 'Editar Administrador')
@section('page-title', 'Editar Administrador')

@section('topbar-actions')
    <a href="{{ route('superadmin.administradores.index') }}" 
       style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #4ec7d2; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 800px;">
    
    <!-- Formulario -->
    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-header text-white" style="background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%); border-radius: 12px 12px 0 0; padding: 1.25rem 1.5rem;">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-user-edit" style="font-size: 1.25rem;"></i>
                <h5 class="mb-0 fw-bold">Actualizar Información</h5>
            </div>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('superadmin.administradores.update', $administrador->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Información Personal -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3" style="color: #003b73;">
                        <i class="fas fa-user me-2" style="color: #4ec7d2;"></i>Información Personal
                    </h6>

                    <div class="row g-3">
                        <!-- Nombre -->
                        <div class="col-md-6">
                            <label for="name" class="form-label small fw-semibold" style="color: #003b73;">
                                Nombre Completo <span style="color: #ef4444;">*</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-user position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                <input type="text" 
                                       class="form-control ps-5 @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $administrador->name) }}" 
                                       placeholder="Ej: Juan Pérez"
                                       required
                                       style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                @error('name')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="email" class="form-label small fw-semibold" style="color: #003b73;">
                                Email <span style="color: #ef4444;">*</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-envelope position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                <input type="email" 
                                       class="form-control ps-5 @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $administrador->email) }}" 
                                       placeholder="admin@ejemplo.com"
                                       required
                                       style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                @error('email')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cambiar Contraseña (Opcional) -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3" style="color: #003b73;">
                        <i class="fas fa-lock me-2" style="color: #4ec7d2;"></i>Cambiar Contraseña (Opcional)
                    </h6>

                    <div class="alert mb-3" style="background: rgba(78, 199, 210, 0.1); border: 1px solid rgba(78, 199, 210, 0.2); border-radius: 10px;">
                        <small style="color: #00508f;">
                            <i class="fas fa-info-circle me-1"></i>
                            Deja estos campos vacíos si no deseas cambiar la contraseña
                        </small>
                    </div>

                    <div class="row g-3">
                        <!-- Nueva Contraseña -->
                        <div class="col-md-6">
                            <label for="password" class="form-label small fw-semibold" style="color: #003b73;">
                                Nueva Contraseña
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-key position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                <input type="password" 
                                       class="form-control ps-5 @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Mínimo 8 caracteres"
                                       style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                @error('password')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <small class="text-muted" style="font-size: 0.75rem;">
                                <i class="fas fa-info-circle me-1"></i>Mínimo 8 caracteres
                            </small>
                        </div>

                        <!-- Confirmar Nueva Contraseña -->
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label small fw-semibold" style="color: #003b73;">
                                Confirmar Nueva Contraseña
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-key position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                <input type="password" 
                                       class="form-control ps-5" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       placeholder="Repite la contraseña"
                                       style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rol y Permisos -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3" style="color: #003b73;">
                        <i class="fas fa-shield-alt me-2" style="color: #4ec7d2;"></i>Rol y Permisos
                    </h6>

                    <!-- Tipo de Rol -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold" style="color: #003b73;">
                            Tipo de Administrador <span style="color: #ef4444;">*</span>
                        </label>
                        
                        <div class="row g-3">
                            <!-- Super Admin -->
                            <div class="col-md-6">
                                <div class="form-check p-3 border rounded" style="border: 2px solid #bfd9ea; border-radius: 10px; cursor: pointer;" onclick="document.getElementById('role_super_admin').click()">
                                    <input class="form-check-input" 
                                           type="radio" 
                                           name="role" 
                                           id="role_super_admin" 
                                           value="super_admin"
                                           {{ old('role', $administrador->is_super_admin ? 'super_admin' : 'admin') == 'super_admin' ? 'checked' : '' }}
                                           style="width: 20px; height: 20px; cursor: pointer;">
                                    <label class="form-check-label ms-2" for="role_super_admin" style="cursor: pointer;">
                                        <strong style="color: #ef4444;">Super Administrador</strong>
                                        <small class="d-block text-muted">Acceso total al sistema</small>
                                    </label>
                                </div>
                            </div>

                            <!-- Admin Regular -->
                            <div class="col-md-6">
                                <div class="form-check p-3 border rounded" style="border: 2px solid #bfd9ea; border-radius: 10px; cursor: pointer;" onclick="document.getElementById('role_admin').click()">
                                    <input class="form-check-input" 
                                           type="radio" 
                                           name="role" 
                                           id="role_admin" 
                                           value="admin"
                                           {{ old('role', $administrador->is_super_admin ? 'super_admin' : 'admin') == 'admin' ? 'checked' : '' }}
                                           style="width: 20px; height: 20px; cursor: pointer;">
                                    <label class="form-check-label ms-2" for="role_admin" style="cursor: pointer;">
                                        <strong style="color: #00508f;">Administrador</strong>
                                        <small class="d-block text-muted">Permisos configurables</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Usuario Protegido -->
                    <div class="form-check form-switch p-3 border rounded" style="border: 2px solid #bfd9ea; border-radius: 10px;">
                        <input class="form-check-input" 
                               type="checkbox" 
                               name="is_protected" 
                               id="is_protected"
                               value="1"
                               {{ old('is_protected', $administrador->is_protected) ? 'checked' : '' }}
                               style="width: 40px; height: 20px; cursor: pointer;">
                        <label class="form-check-label ms-2" for="is_protected" style="cursor: pointer;">
                            <strong style="color: #1e293b;">Usuario Protegido</strong>
                            <small class="d-block text-muted">No se puede editar ni eliminar (recomendado para cuentas críticas)</small>
                        </label>
                    </div>
                </div>

                <!-- Permisos Específicos (Solo para Admin Regular) -->
                <div class="mb-4" id="permisosSection" style="{{ old('role', $administrador->is_super_admin ? 'super_admin' : 'admin') == 'admin' ? '' : 'display: none;' }}">
                    <h6 class="fw-bold mb-3" style="color: #003b73;">
                        <i class="fas fa-tasks me-2" style="color: #4ec7d2;"></i>Permisos Específicos
                    </h6>

                    <div class="alert mb-3" style="background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2); border-radius: 10px;">
                        <small style="color: #1e3a8a;">
                            <i class="fas fa-info-circle me-1"></i>
                            Selecciona los permisos que tendrá este administrador
                        </small>
                    </div>

                    @php
                        $permisosDisponibles = [
                            'Estudiantes' => [
                                'ver_estudiantes' => 'Ver Estudiantes',
                                'crear_estudiantes' => 'Crear Estudiantes',
                                'editar_estudiantes' => 'Editar Estudiantes',
                                'eliminar_estudiantes' => 'Eliminar Estudiantes',
                            ],
                            'Profesores' => [
                                'ver_profesores' => 'Ver Profesores',
                                'crear_profesores' => 'Crear Profesores',
                                'editar_profesores' => 'Editar Profesores',
                                'eliminar_profesores' => 'Eliminar Profesores',
                            ],
                            'Matrículas' => [
                                'ver_matriculas' => 'Ver Matrículas',
                                'crear_matriculas' => 'Crear Matrículas',
                                'aprobar_matriculas' => 'Aprobar Matrículas',
                                'rechazar_matriculas' => 'Rechazar Matrículas',
                            ],
                            'Académico' => [
                                'ver_grados' => 'Ver Grados',
                                'gestionar_grados' => 'Gestionar Grados',
                                'ver_secciones' => 'Ver Secciones',
                                'gestionar_secciones' => 'Gestionar Secciones',
                                'ver_materias' => 'Ver Materias',
                                'gestionar_materias' => 'Gestionar Materias',
                            ],
                            'Reportes' => [
                                'ver_reportes' => 'Ver Reportes',
                                'generar_reportes' => 'Generar Reportes',
                                'exportar_datos' => 'Exportar Datos',
                            ],
                        ];

                        $permisosActuales = is_array($administrador->permissions) 
                            ? $administrador->permissions 
                            : (is_string($administrador->permissions) 
                                ? json_decode($administrador->permissions, true) 
                                : []);
                        $permisosActuales = $permisosActuales ?? [];
                    @endphp

                    <div class="accordion" id="permisosAccordion">
                        @foreach($permisosDisponibles as $categoria => $permisos)
                        <div class="accordion-item border-0 mb-2" style="border-radius: 10px; overflow: hidden; border: 2px solid #bfd9ea;">
                            <h2 class="accordion-header">
                                <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->index }}" style="background: #f8fafc; color: #003b73; font-weight: 600; font-size: 0.9rem;">
                                    <i class="fas fa-folder me-2" style="color: #4ec7d2;"></i>
                                    {{ $categoria }}
                                    <span class="badge ms-2" style="background: rgba(78, 199, 210, 0.2); color: #00508f; font-size: 0.7rem;">
                                        {{ count($permisos) }} permisos
                                    </span>
                                </button>
                            </h2>
                            <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#permisosAccordion">
                                <div class="accordion-body p-3">
                                    <div class="row g-2">
                                        @foreach($permisos as $key => $nombre)
                                        <div class="col-md-6">
                                            <div class="form-check p-2 border rounded" style="border: 1px solid #e2e8f0; border-radius: 6px;">
                                                <input class="form-check-input permiso-checkbox" 
                                                       type="checkbox" 
                                                       name="permissions[]" 
                                                       value="{{ $key }}" 
                                                       id="perm_{{ $key }}"
                                                       {{ in_array($key, old('permissions', $permisosActuales)) ? 'checked' : '' }}
                                                       style="cursor: pointer;">
                                                <label class="form-check-label small" for="perm_{{ $key }}" style="cursor: pointer; color: #334155;">
                                                    {{ $nombre }}
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button type="button" class="btn btn-sm" onclick="seleccionarTodos(true)" style="background: rgba(78, 199, 210, 0.1); color: #00508f; border: 1px solid #4ec7d2; font-size: 0.8rem; padding: 0.4rem 0.85rem; border-radius: 6px;">
                            <i class="fas fa-check-double me-1"></i>Seleccionar Todos
                        </button>
                        <button type="button" class="btn btn-sm" onclick="seleccionarTodos(false)" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid #ef4444; font-size: 0.8rem; padding: 0.4rem 0.85rem; border-radius: 6px;">
                            <i class="fas fa-times me-1"></i>Deseleccionar Todos
                        </button>
                    </div>
                </div>

                <!-- Información de Registro -->
                <div class="mb-4 p-3 border rounded" style="border: 2px solid #e2e8f0; border-radius: 10px; background: #f8fafc;">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1" style="font-size: 0.75rem;">Registrado el</small>
                            <strong style="color: #003b73; font-size: 0.85rem;">
                                <i class="fas fa-calendar-alt me-1" style="color: #4ec7d2;"></i>
                                {{ $administrador->created_at->format('d/m/Y H:i') }}
                            </strong>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1" style="font-size: 0.75rem;">Última actualización</small>
                            <strong style="color: #003b73; font-size: 0.85rem;">
                                <i class="fas fa-clock me-1" style="color: #4ec7d2;"></i>
                                {{ $administrador->updated_at->format('d/m/Y H:i') }}
                            </strong>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('superadmin.administradores.index') }}" 
                       class="btn" 
                       style="border: 2px solid #00508f; color: #00508f; background: white; padding: 0.6rem 1.5rem; border-radius: 8px; font-weight: 600; transition: all 0.3s ease;">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </a>
                    <button type="submit" 
                            class="btn" 
                            style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; padding: 0.6rem 1.5rem; border-radius: 8px; font-weight: 600; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); transition: all 0.3s ease;">
                        <i class="fas fa-save me-1"></i>Guardar Cambios
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>

@push('styles')
<style>
    .form-control:focus,
    .form-select:focus {
        border-color: #4ec7d2;
        box-shadow: 0 0 0 0.2rem rgba(78, 199, 210, 0.15);
        outline: none;
    }

    .form-control.is-invalid {
        border-color: #ef4444;
        background-image: none;
    }

    .form-control.is-invalid:focus {
        border-color: #ef4444;
        box-shadow: 0 0 0 0.2rem rgba(239, 68, 68, 0.15);
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .form-check-input:checked {
        background-color: #4ec7d2;
        border-color: #4ec7d2;
    }

    .form-check:has(input:checked) {
        border-color: #4ec7d2 !important;
        background: linear-gradient(135deg, rgba(78, 199, 210, 0.05) 0%, rgba(0, 80, 143, 0.05) 100%);
    }

    .accordion-button:not(.collapsed) {
        background: #f8fafc;
        color: #003b73;
    }

    .accordion-button:focus {
        box-shadow: none;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSuperAdmin = document.getElementById('role_super_admin');
    const roleAdmin = document.getElementById('role_admin');
    const permisosSection = document.getElementById('permisosSection');

    // Mostrar/ocultar permisos según rol
    function togglePermisos() {
        if (roleAdmin.checked) {
            permisosSection.style.display = 'block';
        } else {
            permisosSection.style.display = 'none';
        }
    }

    roleSuperAdmin.addEventListener('change', togglePermisos);
    roleAdmin.addEventListener('change', togglePermisos);
});

// Seleccionar/Deseleccionar todos los permisos
function seleccionarTodos(seleccionar) {
    document.querySelectorAll('.permiso-checkbox').forEach(checkbox => {
        checkbox.checked = seleccionar;
    });
}
</script>
@endpush
@endsection