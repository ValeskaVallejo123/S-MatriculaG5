@extends('layouts.app')

@section('title', 'Editar Administrador')
@section('page-title', 'Editar Administrador')

@section('content-class', 'p-0')

@push('styles')
<style>
.content-wrapper.p-0 {
    height: calc(100vh - 64px);
    display: flex;
    flex-direction: column;
    overflow: hidden;
}
.sa-edit-wrapper {
    height: 100%;
    display: flex;
    overflow: hidden;
}
.sa-form-panel {
    flex: 1;
    overflow-y: auto;
    padding: 2rem 2.5rem;
    background: #f8fafc;
}
.sa-field-card {
    background: white;
    border-radius: 12px;
    padding: 1.4rem;
    box-shadow: 0 1px 4px rgba(0,59,115,.07);
    margin-bottom: 1.25rem;
    border: 1px solid #e8eef5;
}
.sa-section-title {
    font-size: .7rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .08em;
    color: #00508f; margin-bottom: 1.1rem;
    padding-bottom: .45rem; border-bottom: 1px solid #e8f4fb;
}
.form-control:focus, .form-select:focus {
    border-color: #4ec7d2 !important;
    box-shadow: 0 0 0 0.15rem rgba(78,199,210,.2) !important;
}
.role-card {
    display: flex; align-items: flex-start; gap: .75rem;
    padding: .85rem 1rem;
    background: #f8fafc; border: 2px solid #e2e8f0;
    border-radius: 10px; cursor: pointer; transition: all .15s;
}
.role-card:hover { border-color: #4ec7d2; background: #f0fafa; }
.role-card.selected-super { border-color: #ef4444; background: #fff5f5; }
.role-card.selected-admin { border-color: #4ec7d2; background: #f0fafa; }

.perm-group-title {
    font-size: .68rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .07em; color: #00508f;
    margin-bottom: .6rem; margin-top: .9rem;
}
.perm-item {
    display: flex; align-items: center; gap: .5rem;
    padding: .4rem .65rem;
    background: #f8fafc; border: 1px solid #e2e8f0;
    border-radius: 7px; transition: all .15s; cursor: pointer;
    font-size: .8rem; color: #374151;
}
.perm-item:hover { border-color: #4ec7d2; background: #f0fafa; }
.perm-item input { width: 14px; height: 14px; accent-color: #00508f; flex-shrink: 0; }

.meta-row {
    display: flex; gap: 1.5rem; flex-wrap: wrap;
    padding: .9rem 1rem;
    background: #f8fafc; border: 1px solid #e8eef5;
    border-radius: 9px;
}
.meta-item { font-size: .78rem; color: #64748b; }
.meta-item strong { color: #003b73; display: block; font-size: .82rem; }

body.dark-mode .sa-form-panel    { background: #0f172a !important; }
body.dark-mode .sa-field-card    { background: #1e293b !important; border-color: #334155 !important; }
body.dark-mode .sa-section-title { color: #4ec7d2 !important; border-bottom-color: #334155 !important; }
body.dark-mode .role-card        { background: #0f172a !important; border-color: #334155 !important; }
body.dark-mode .perm-item        { background: #0f172a !important; border-color: #334155 !important; }
body.dark-mode .meta-row         { background: #0f172a !important; border-color: #334155 !important; }
</style>
@endpush

@section('content')
<div class="sa-edit-wrapper">

    {{-- Panel izquierdo: formulario --}}
    <div class="sa-form-panel">

        <form action="{{ route('superadmin.administradores.update', $administrador->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Datos Personales --}}
            <div class="sa-field-card">
                <div class="sa-section-title"><i class="fas fa-user me-1"></i>Información Personal</div>
                <div class="row g-3">
                    <div class="col-lg-6">
                        <label for="name" class="form-label small fw-semibold" style="color:#003b73;">
                            Nombre Completo <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" id="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $administrador->name) }}"
                               placeholder="Ej: Juan Pérez" required
                               style="border-radius:8px;border:1.5px solid #e2e8f0;">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-lg-6">
                        <label for="email" class="form-label small fw-semibold" style="color:#003b73;">
                            Correo Electrónico <span class="text-danger">*</span>
                        </label>
                        <input type="email" name="email" id="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $administrador->email) }}"
                               placeholder="admin@ejemplo.com" required
                               style="border-radius:8px;border:1.5px solid #e2e8f0;">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- Contraseña --}}
            <div class="sa-field-card">
                <div class="sa-section-title">
                    <i class="fas fa-lock me-1"></i>Cambiar Contraseña
                    <span style="font-size:.68rem;font-weight:400;color:#94a3b8;text-transform:none;letter-spacing:0;margin-left:.4rem;">
                        (dejar en blanco para no cambiar)
                    </span>
                </div>
                <div class="row g-3">
                    <div class="col-lg-6">
                        <label for="password" class="form-label small fw-semibold" style="color:#003b73;">Nueva Contraseña</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Mínimo 8 caracteres"
                                   style="border-radius:8px 0 0 8px;border:1.5px solid #e2e8f0;border-right:none;">
                            <button type="button" class="btn btn-outline-secondary"
                                    onclick="togglePwd('password')"
                                    style="border-radius:0 8px 8px 0;border:1.5px solid #e2e8f0;border-left:none;">
                                <i class="fas fa-eye" id="icon-password"></i>
                            </button>
                        </div>
                        @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-lg-6">
                        <label for="password_confirmation" class="form-label small fw-semibold" style="color:#003b73;">Confirmar Contraseña</label>
                        <div class="input-group">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   placeholder="Repite la contraseña"
                                   class="form-control"
                                   style="border-radius:8px 0 0 8px;border:1.5px solid #e2e8f0;border-right:none;">
                            <button type="button" class="btn btn-outline-secondary"
                                    onclick="togglePwd('password_confirmation')"
                                    style="border-radius:0 8px 8px 0;border:1.5px solid #e2e8f0;border-left:none;">
                                <i class="fas fa-eye" id="icon-password_confirmation"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Rol --}}
            <div class="sa-field-card">
                <div class="sa-section-title"><i class="fas fa-shield-alt me-1"></i>Rol y Permisos</div>

                <label class="form-label small fw-semibold mb-2" style="color:#003b73;">
                    Tipo de Administrador <span class="text-danger">*</span>
                </label>
                <div class="row g-2 mb-3">
                    <div class="col-lg-6">
                        <label class="role-card w-100 mb-0 {{ old('role', $administrador->is_super_admin ? 'super_admin' : 'admin') == 'super_admin' ? 'selected-super' : '' }}"
                               for="role_super_admin" id="card-super">
                            <input class="form-check-input m-0" type="radio" name="role"
                                   id="role_super_admin" value="super_admin"
                                   style="width:18px;height:18px;flex-shrink:0;accent-color:#ef4444;"
                                   {{ old('role', $administrador->is_super_admin ? 'super_admin' : 'admin') == 'super_admin' ? 'checked' : '' }}>
                            <div>
                                <div style="font-size:.85rem;font-weight:700;color:#ef4444;">Super Administrador</div>
                                <div style="font-size:.75rem;color:#64748b;">Acceso total al sistema</div>
                            </div>
                        </label>
                    </div>
                    <div class="col-lg-6">
                        <label class="role-card w-100 mb-0 {{ old('role', $administrador->is_super_admin ? 'super_admin' : 'admin') == 'admin' ? 'selected-admin' : '' }}"
                               for="role_admin" id="card-admin">
                            <input class="form-check-input m-0" type="radio" name="role"
                                   id="role_admin" value="admin"
                                   style="width:18px;height:18px;flex-shrink:0;accent-color:#00508f;"
                                   {{ old('role', $administrador->is_super_admin ? 'super_admin' : 'admin') == 'admin' ? 'checked' : '' }}>
                            <div>
                                <div style="font-size:.85rem;font-weight:700;color:#00508f;">Administrador</div>
                                <div style="font-size:.75rem;color:#64748b;">Permisos configurables</div>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Toggle protegido --}}
                <label class="role-card w-100 mb-0" for="is_protected" style="margin-bottom:.5rem!important;">
                    <input class="form-check-input m-0" type="checkbox"
                           name="is_protected" id="is_protected" value="1"
                           style="width:18px;height:18px;flex-shrink:0;accent-color:#00508f;"
                           {{ old('is_protected', $administrador->is_protected) ? 'checked' : '' }}>
                    <div>
                        <div style="font-size:.85rem;font-weight:700;color:#1e293b;">Usuario Protegido</div>
                        <div style="font-size:.75rem;color:#64748b;">No se puede editar ni eliminar (recomendado para cuentas críticas)</div>
                    </div>
                </label>
            </div>

            {{-- Permisos específicos --}}
            @php
                $permisosDisponibles = [
                    'Estudiantes' => ['ver_estudiantes'=>'Ver Estudiantes','crear_estudiantes'=>'Crear Estudiantes','editar_estudiantes'=>'Editar Estudiantes','eliminar_estudiantes'=>'Eliminar Estudiantes'],
                    'Profesores'  => ['ver_profesores'=>'Ver Profesores','crear_profesores'=>'Crear Profesores','editar_profesores'=>'Editar Profesores','eliminar_profesores'=>'Eliminar Profesores'],
                    'Matrículas'  => ['ver_matriculas'=>'Ver Matrículas','crear_matriculas'=>'Crear Matrículas','aprobar_matriculas'=>'Aprobar Matrículas','rechazar_matriculas'=>'Rechazar Matrículas'],
                    'Académico'   => ['ver_grados'=>'Ver Grados','gestionar_grados'=>'Gestionar Grados','ver_secciones'=>'Ver Secciones','gestionar_secciones'=>'Gestionar Secciones','ver_materias'=>'Ver Materias','gestionar_materias'=>'Gestionar Materias'],
                    'Reportes'    => ['ver_reportes'=>'Ver Reportes','generar_reportes'=>'Generar Reportes','exportar_datos'=>'Exportar Datos'],
                ];
                $permisosActuales = is_array($administrador->permissions)
                    ? $administrador->permissions
                    : (is_string($administrador->permissions) ? json_decode($administrador->permissions, true) : []);
                $permisosActuales = $permisosActuales ?? [];
            @endphp

            <div class="sa-field-card" id="permisosSection"
                 style="{{ old('role', $administrador->is_super_admin ? 'super_admin' : 'admin') == 'admin' ? '' : 'display:none;' }}">
                <div class="sa-section-title">
                    <i class="fas fa-tasks me-1"></i>Permisos Específicos
                    <span style="margin-left:auto;display:inline-flex;gap:.4rem;">
                        <button type="button" onclick="selectAll(true)"
                                style="font-size:.68rem;padding:.2rem .55rem;border-radius:5px;border:1px solid #4ec7d2;background:rgba(78,199,210,.1);color:#00508f;cursor:pointer;">
                            Todos
                        </button>
                        <button type="button" onclick="selectAll(false)"
                                style="font-size:.68rem;padding:.2rem .55rem;border-radius:5px;border:1px solid #ef4444;background:rgba(239,68,68,.08);color:#ef4444;cursor:pointer;">
                            Ninguno
                        </button>
                    </span>
                </div>
                @foreach($permisosDisponibles as $cat => $perms)
                    <div class="perm-group-title">{{ $cat }}</div>
                    <div class="row g-2 mb-1">
                        @foreach($perms as $key => $nombre)
                        <div class="col-lg-6 col-md-6">
                            <label class="perm-item w-100 mb-0" for="perm_{{ $key }}">
                                <input type="checkbox" name="permissions[]" value="{{ $key }}"
                                       id="perm_{{ $key }}" class="permiso-checkbox"
                                       {{ in_array($key, old('permissions', $permisosActuales)) ? 'checked' : '' }}>
                                {{ $nombre }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                @endforeach
            </div>

            {{-- Fechas --}}
            <div class="sa-field-card">
                <div class="sa-section-title"><i class="fas fa-history me-1"></i>Información de Registro</div>
                <div class="meta-row">
                    <div class="meta-item">
                        <span>Registrado el</span>
                        <strong><i class="fas fa-calendar-alt me-1" style="color:#4ec7d2;"></i>{{ $administrador->created_at->format('d/m/Y H:i') }}</strong>
                    </div>
                    <div class="meta-item">
                        <span>Última actualización</span>
                        <strong><i class="fas fa-clock me-1" style="color:#4ec7d2;"></i>{{ $administrador->updated_at->format('d/m/Y H:i') }}</strong>
                    </div>
                </div>
            </div>

            {{-- Botones --}}
            <div class="d-flex gap-3 align-items-center mt-1">
                <button type="submit"
                        style="background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;border:none;
                               padding:.6rem 2rem;border-radius:9px;font-weight:700;font-size:.9rem;
                               box-shadow:0 2px 10px rgba(78,199,210,.3);cursor:pointer;">
                    <i class="fas fa-save me-2"></i>Guardar Cambios
                </button>
                <a href="{{ route('superadmin.administradores.index') }}"
                   style="color:#64748b;font-size:.85rem;text-decoration:none;font-weight:600;">
                    Cancelar
                </a>
            </div>

        </form>
    </div>


</div>
@endsection

@push('scripts')
<script>
function togglePwd(id) {
    const input = document.getElementById(id);
    const icon  = document.getElementById('icon-' + id);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

function selectAll(val) {
    document.querySelectorAll('.permiso-checkbox').forEach(c => c.checked = val);
}

document.addEventListener('DOMContentLoaded', function () {
    const radios = document.querySelectorAll('input[name="role"]');
    const section = document.getElementById('permisosSection');
    const cardSuper = document.getElementById('card-super');
    const cardAdmin = document.getElementById('card-admin');

    radios.forEach(r => r.addEventListener('change', function () {
        section.style.display = this.value === 'admin' ? 'block' : 'none';
        cardSuper.className = 'role-card w-100 mb-0' + (document.getElementById('role_super_admin').checked ? ' selected-super' : '');
        cardAdmin.className = 'role-card w-100 mb-0' + (document.getElementById('role_admin').checked ? ' selected-admin' : '');
    }));
});
</script>
@endpush
