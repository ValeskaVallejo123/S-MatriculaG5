@extends('layouts.app')

@section('title', 'Editar Administrador')
@section('page-title', 'Editar Administrador')

@section('topbar-actions')
    <a href="{{ route('superadmin.administradores.index') }}"
       style="border:1.5px solid #e2e8f0;color:#6b7280;background:white;border-radius:8px;padding:.45rem 1rem;font-size:.88rem;font-weight:500;text-decoration:none;display:inline-flex;align-items:center;gap:.4rem;">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
@endsection

@push('styles')
<style>
    :root {
        --blue-dark: #003b73;
        --blue-mid:  #00508f;
        --teal:      #4ec7d2;
        --border:    #d1e0ee;
        --surface:   #f5f8fc;
        --red:       #ef4444;
        --green:     #10b981;
    }

    .frm-wrap { max-width: 820px; margin: 0 auto; }

    .frm-section {
        background: white; border: 1px solid #e2e8f0;
        border-radius: 14px; overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,59,115,.06);
        margin-bottom: 1.25rem;
    }
    .frm-section-header {
        background: rgba(0,80,143,.04);
        border-bottom: 2px solid var(--teal);
        padding: .85rem 1.5rem;
        display: flex; align-items: center; gap: .6rem;
    }
    .frm-section-header i    { color: var(--teal); font-size: .9rem; }
    .frm-section-header span { font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--blue-dark); }
    .frm-section-body { padding: 1.5rem; }

    .frm-group { margin-bottom: 1.1rem; }
    .frm-label {
        display: block; font-size: .76rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: .05em;
        color: var(--blue-dark); margin-bottom: .45rem;
    }
    .frm-label .req { color: var(--red); margin-left: .15rem; }

    .frm-input-wrap { position: relative; }
    .frm-input-wrap i.ico {
        position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
        color: var(--blue-mid); font-size: .82rem; pointer-events: none;
    }
    .frm-input {
        width: 100%; padding: .6rem 1rem .6rem 2.6rem;
        border: 1.5px solid var(--border); border-radius: 9px;
        font-size: .88rem; font-family: inherit; color: #0f172a;
        background: var(--surface); outline: none;
        transition: border-color .2s, box-shadow .2s, background .2s;
    }
    .frm-input:focus {
        border-color: var(--teal);
        box-shadow: 0 0 0 3px rgba(78,199,210,.15);
        background: white;
    }
    .frm-input.is-invalid { border-color: var(--red); background: #fff5f5; }
    .frm-input.is-invalid:focus { box-shadow: 0 0 0 3px rgba(239,68,68,.12); }

    .frm-input-wrap .eye-btn {
        position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
        background: none; border: none; cursor: pointer;
        color: #94a3b8; font-size: .85rem; padding: .2rem; transition: color .15s;
    }
    .frm-input-wrap .eye-btn:hover { color: var(--blue-mid); }
    .frm-input-has-eye { padding-right: 2.4rem; }

    .pwd-strength { margin-top: .4rem; }
    .pwd-strength-bar { height: 4px; border-radius: 999px; background: #e2e8f0; overflow: hidden; margin-bottom: .3rem; }
    .pwd-strength-fill { height: 100%; border-radius: 999px; width: 0; transition: width .3s, background .3s; }
    .pwd-strength-label { font-size: .7rem; font-weight: 600; }

    .frm-error {
        display: flex; align-items: center; gap: .35rem;
        margin-top: .4rem; font-size: .76rem;
        color: var(--red); font-weight: 600;
    }
    .frm-hint { margin-top: .35rem; font-size: .73rem; color: #94a3b8; display: flex; align-items: center; gap: .3rem; }

    /* Role cards */
    .role-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .85rem; }
    @media(max-width:580px){ .role-grid { grid-template-columns: 1fr; } }

    .role-card {
        border: 2px solid var(--border); border-radius: 11px;
        padding: 1rem 1.1rem; cursor: pointer;
        transition: border-color .2s, background .2s, box-shadow .2s;
        display: flex; align-items: flex-start; gap: .75rem;
    }
    .role-card:has(input:checked) {
        border-color: var(--teal);
        background: rgba(78,199,210,.06);
        box-shadow: 0 0 0 3px rgba(78,199,210,.12);
    }
    .role-card input[type="radio"] { margin-top: .2rem; accent-color: var(--teal); width: 17px; height: 17px; flex-shrink: 0; cursor: pointer; }
    .role-card-title { font-size: .88rem; font-weight: 700; margin-bottom: .15rem; }
    .role-card-desc  { font-size: .75rem; color: #64748b; line-height: 1.4; }

    .protected-row {
        border: 1.5px solid var(--border); border-radius: 11px;
        padding: .9rem 1.1rem; display: flex; align-items: center; gap: .85rem;
        transition: border-color .2s, background .2s;
    }
    .protected-row:has(input:checked) { border-color: #f59e0b; background: rgba(245,158,11,.05); }
    .protected-row input[type="checkbox"] { width: 42px; height: 22px; accent-color: #f59e0b; flex-shrink: 0; cursor: pointer; }
    .protected-label { font-size: .88rem; font-weight: 600; color: #1e293b; margin-bottom: .15rem; }
    .protected-desc  { font-size: .74rem; color: #64748b; }

    /* Info registro */
    .reg-info {
        background: var(--surface); border: 1px solid #e2e8f0;
        border-radius: 11px; padding: 1rem 1.25rem;
        display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;
        margin-bottom: 1.25rem;
    }
    @media(max-width:480px){ .reg-info { grid-template-columns: 1fr; } }
    .reg-info-lbl  { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: #94a3b8; margin-bottom: .25rem; }
    .reg-info-val  { font-size: .85rem; font-weight: 600; color: var(--blue-dark); display: flex; align-items: center; gap: .4rem; }
    .reg-info-val i { color: var(--teal); font-size: .8rem; }

    /* Info box */
    .info-box {
        background: rgba(78,199,210,.07); border: 1px solid rgba(78,199,210,.25);
        border-radius: 10px; padding: .85rem 1.1rem;
        display: flex; gap: .7rem; align-items: flex-start; margin-bottom: .85rem;
    }
    .info-box i { color: var(--teal); margin-top: .1rem; flex-shrink: 0; }
    .info-box p { margin: 0; font-size: .78rem; color: #475569; line-height: 1.5; }

    /* Permisos */
    .permisos-section { margin-top: 1.1rem; }
    .perm-category {
        border: 1.5px solid #e2e8f0; border-radius: 11px;
        overflow: hidden; margin-bottom: .75rem;
    }
    .perm-category-header {
        background: var(--surface); padding: .7rem 1rem;
        display: flex; align-items: center; justify-content: space-between;
        cursor: pointer; user-select: none;
        border-bottom: 1px solid #e2e8f0;
    }
    .perm-category-header:hover { background: #eef3f9; }
    .perm-category-title { font-size: .8rem; font-weight: 700; color: var(--blue-dark); display: flex; align-items: center; gap: .5rem; }
    .perm-category-title i { color: var(--teal); }
    .perm-category-arrow { color: #94a3b8; font-size: .72rem; transition: transform .2s; }
    .perm-category-arrow.open { transform: rotate(180deg); }
    .perm-category-body { padding: .85rem 1rem; display: grid; grid-template-columns: 1fr 1fr; gap: .5rem; }
    @media(max-width:480px){ .perm-category-body { grid-template-columns: 1fr; } }

    .perm-item {
        display: flex; align-items: center; gap: .5rem;
        padding: .45rem .65rem; border: 1px solid #e2e8f0;
        border-radius: 7px; cursor: pointer; transition: all .15s;
    }
    .perm-item:hover { border-color: var(--teal); background: rgba(78,199,210,.05); }
    .perm-item:has(input:checked) { border-color: var(--teal); background: rgba(78,199,210,.08); }
    .perm-item input[type="checkbox"] { accent-color: var(--teal); width: 15px; height: 15px; cursor: pointer; flex-shrink: 0; }
    .perm-item label { font-size: .78rem; color: #334155; cursor: pointer; margin: 0; }

    .perm-actions { display: flex; gap: .5rem; margin-top: .75rem; }
    .perm-btn {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .35rem .85rem; border-radius: 7px; font-size: .75rem;
        font-weight: 600; cursor: pointer; border: 1.5px solid; font-family: inherit;
        transition: all .15s;
    }
    .perm-btn-all  { background: rgba(78,199,210,.1); color: var(--blue-mid); border-color: var(--teal); }
    .perm-btn-none { background: rgba(239,68,68,.08); color: var(--red); border-color: #fca5a5; }
    .perm-btn:hover { opacity: .8; }

    /* Footer */
    .frm-footer {
        display: flex; justify-content: flex-end; gap: .75rem;
        padding-top: 1.25rem; border-top: 1px solid #f1f5f9; flex-wrap: wrap;
    }
    .btn-cancel {
        border: 1.5px solid #e2e8f0; color: #6b7280; background: white;
        border-radius: 9px; padding: .6rem 1.4rem; font-size: .88rem;
        font-weight: 600; cursor: pointer; font-family: inherit;
        display: inline-flex; align-items: center; gap: .4rem;
        text-decoration: none; transition: all .15s;
    }
    .btn-cancel:hover { background: #f8fafc; border-color: #cbd5e1; color: #374151; }
    .btn-submit {
        background: linear-gradient(135deg, var(--teal), var(--blue-mid));
        color: white; border: none; border-radius: 9px;
        padding: .6rem 1.6rem; font-size: .88rem; font-weight: 700;
        cursor: pointer; font-family: inherit;
        display: inline-flex; align-items: center; gap: .45rem;
        box-shadow: 0 2px 10px rgba(78,199,210,.35); transition: all .2s;
    }
    .btn-submit:hover { opacity: .9; transform: translateY(-1px); }
    .btn-submit:disabled { opacity: .6; cursor: not-allowed; transform: none; }

    .frm-alert-errors {
        background: #fef2f2; border: 1px solid #fca5a5;
        border-radius: 10px; padding: .9rem 1.1rem; margin-bottom: 1.25rem;
    }
    .frm-alert-errors-title {
        font-size: .8rem; font-weight: 700; color: #991b1b;
        display: flex; align-items: center; gap: .4rem; margin-bottom: .5rem;
    }
    .frm-alert-errors ul { margin: 0; padding-left: 1.25rem; }
    .frm-alert-errors ul li { font-size: .78rem; color: #b91c1c; margin-bottom: .2rem; }
</style>
@endpush

@section('content')
<div class="frm-wrap">

    {{-- Errores del servidor --}}
    @if($errors->any())
    <div class="frm-alert-errors">
        <div class="frm-alert-errors-title">
            <i class="fas fa-exclamation-circle"></i>
            Por favor corrige los siguientes errores:
        </div>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('superadmin.administradores.update', $administrador->id) }}" method="POST" id="frmEditar" novalidate>
        @csrf
        @method('PUT')

        {{-- ── Información Personal ── --}}
        <div class="frm-section">
            <div class="frm-section-header">
                <i class="fas fa-user"></i>
                <span>Información Personal</span>
            </div>
            <div class="frm-section-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="frm-group">
                            <label class="frm-label" for="name">
                                Nombre Completo <span class="req">*</span>
                            </label>
                            <div class="frm-input-wrap">
                                <i class="fas fa-user ico"></i>
                                <input type="text" id="name" name="name"
                                       class="frm-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                       value="{{ old('name', $administrador->name) }}"
                                       placeholder="Ej: Juan Pérez"
                                       autocomplete="name"
                                       oninput="validarNombre(this)">
                            </div>
                            @error('name')
                                <div class="frm-error" id="nameError"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                            @else
                                <div class="frm-error" id="nameError" style="display:none;"></div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="frm-group">
                            <label class="frm-label" for="email">
                                Correo Electrónico <span class="req">*</span>
                            </label>
                            <div class="frm-input-wrap">
                                <i class="fas fa-envelope ico"></i>
                                <input type="email" id="email" name="email"
                                       class="frm-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                       value="{{ old('email', $administrador->email) }}"
                                       placeholder="admin@ejemplo.com"
                                       autocomplete="email">
                            </div>
                            @error('email')
                                <div class="frm-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Cambiar Contraseña ── --}}
        <div class="frm-section">
            <div class="frm-section-header">
                <i class="fas fa-lock"></i>
                <span>Cambiar Contraseña (Opcional)</span>
            </div>
            <div class="frm-section-body">
                <div class="info-box" style="margin-bottom:1rem;">
                    <i class="fas fa-info-circle"></i>
                    <p>Deja estos campos vacíos si no deseas cambiar la contraseña.</p>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="frm-group">
                            <label class="frm-label" for="password">Nueva Contraseña</label>
                            <div class="frm-input-wrap">
                                <i class="fas fa-key ico"></i>
                                <input type="password" id="password" name="password"
                                       class="frm-input frm-input-has-eye {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                       placeholder="Mínimo 8 caracteres"
                                       autocomplete="new-password"
                                       oninput="checkPasswordStrength(this.value)">
                                <button type="button" class="eye-btn" onclick="togglePwd('password', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="pwd-strength" id="pwdStrength" style="display:none;">
                                <div class="pwd-strength-bar">
                                    <div class="pwd-strength-fill" id="pwdFill"></div>
                                </div>
                                <span class="pwd-strength-label" id="pwdLabel"></span>
                            </div>
                            @error('password')
                                <div class="frm-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                            @else
                                <div class="frm-hint"><i class="fas fa-info-circle"></i>Mínimo 8 caracteres</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="frm-group">
                            <label class="frm-label" for="password_confirmation">Confirmar Nueva Contraseña</label>
                            <div class="frm-input-wrap">
                                <i class="fas fa-key ico"></i>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                       class="frm-input frm-input-has-eye"
                                       placeholder="Repite la contraseña"
                                       autocomplete="new-password"
                                       oninput="checkConfirm()">
                                <button type="button" class="eye-btn" onclick="togglePwd('password_confirmation', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="frm-error" id="confirmError" style="display:none;">
                                <i class="fas fa-exclamation-circle"></i> Las contraseñas no coinciden
                            </div>
                            <div class="frm-hint" id="confirmOk" style="display:none;color:#10b981;">
                                <i class="fas fa-check-circle"></i> Las contraseñas coinciden
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Rol y Configuración ── --}}
        <div class="frm-section">
            <div class="frm-section-header">
                <i class="fas fa-shield-alt"></i>
                <span>Rol y Configuración</span>
            </div>
            <div class="frm-section-body">

                <div class="frm-group">
                    <label class="frm-label">Tipo de Administrador <span class="req">*</span></label>
                    <div class="role-grid">
                        <label class="role-card">
                            <input type="radio" name="role" id="role_super_admin" value="super_admin"
                                   {{ old('role', $administrador->is_super_admin ? 'super_admin' : 'admin') == 'super_admin' ? 'checked' : '' }}>
                            <div>
                                <div class="role-card-title" style="color:#dc2626;">
                                    <i class="fas fa-crown me-1"></i> Super Administrador
                                </div>
                                <div class="role-card-desc">Acceso total al sistema sin restricciones. Puede gestionar otros administradores.</div>
                            </div>
                        </label>
                        <label class="role-card">
                            <input type="radio" name="role" id="role_admin" value="admin"
                                   {{ old('role', $administrador->is_super_admin ? 'super_admin' : 'admin') == 'admin' ? 'checked' : '' }}>
                            <div>
                                <div class="role-card-title" style="color:var(--blue-mid);">
                                    <i class="fas fa-user-shield me-1"></i> Administrador
                                </div>
                                <div class="role-card-desc">Permisos configurables. Acceso limitado según los roles asignados.</div>
                            </div>
                        </label>
                    </div>
                    @error('role')
                        <div class="frm-error mt-2"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="frm-group mb-0">
                    <label class="frm-label">Protección de Cuenta</label>
                    <label class="protected-row">
                        <input type="checkbox" name="is_protected" value="1"
                               {{ old('is_protected', $administrador->is_protected) ? 'checked' : '' }}>
                        <div>
                            <div class="protected-label">
                                <i class="fas fa-lock me-1" style="color:#f59e0b;"></i> Usuario Protegido
                            </div>
                            <div class="protected-desc">
                                Esta cuenta no podrá ser editada ni eliminada por otros administradores. Recomendado para cuentas críticas del sistema.
                            </div>
                        </div>
                    </label>
                </div>

            </div>
        </div>

        {{-- ── Permisos Específicos ── --}}
        @php
            $permisosDisponibles = [
                'Estudiantes' => [
                    'ver_estudiantes'      => 'Ver Estudiantes',
                    'crear_estudiantes'    => 'Crear Estudiantes',
                    'editar_estudiantes'   => 'Editar Estudiantes',
                    'eliminar_estudiantes' => 'Eliminar Estudiantes',
                ],
                'Profesores' => [
                    'ver_profesores'      => 'Ver Profesores',
                    'crear_profesores'    => 'Crear Profesores',
                    'editar_profesores'   => 'Editar Profesores',
                    'eliminar_profesores' => 'Eliminar Profesores',
                ],
                'Matrículas' => [
                    'ver_matriculas'      => 'Ver Matrículas',
                    'crear_matriculas'    => 'Crear Matrículas',
                    'aprobar_matriculas'  => 'Aprobar Matrículas',
                    'rechazar_matriculas' => 'Rechazar Matrículas',
                ],
                'Académico' => [
                    'ver_grados'          => 'Ver Grados',
                    'gestionar_grados'    => 'Gestionar Grados',
                    'ver_secciones'       => 'Ver Secciones',
                    'gestionar_secciones' => 'Gestionar Secciones',
                    'ver_materias'        => 'Ver Materias',
                    'gestionar_materias'  => 'Gestionar Materias',
                ],
                'Reportes' => [
                    'ver_reportes'     => 'Ver Reportes',
                    'generar_reportes' => 'Generar Reportes',
                    'exportar_datos'   => 'Exportar Datos',
                ],
            ];

            $permisosActuales = is_array($administrador->permissions)
                ? $administrador->permissions
                : (is_string($administrador->permissions)
                    ? json_decode($administrador->permissions, true)
                    : []);
            $permisosActuales = $permisosActuales ?? [];
        @endphp

        <div class="frm-section" id="permisosSection"
             style="{{ old('role', $administrador->is_super_admin ? 'super_admin' : 'admin') == 'admin' ? '' : 'display:none;' }}">
            <div class="frm-section-header">
                <i class="fas fa-tasks"></i>
                <span>Permisos Específicos</span>
            </div>
            <div class="frm-section-body">
                <div class="info-box">
                    <i class="fas fa-info-circle"></i>
                    <p>Selecciona los permisos que tendrá este administrador. Solo aplica a administradores regulares.</p>
                </div>

                <div class="permisos-section">
                    @foreach($permisosDisponibles as $categoria => $permisos)
                    <div class="perm-category">
                        <div class="perm-category-header" onclick="toggleCategory(this)">
                            <div class="perm-category-title">
                                <i class="fas fa-folder"></i>
                                {{ $categoria }}
                                <span style="background:rgba(78,199,210,.15);color:#00508f;padding:.1rem .5rem;border-radius:999px;font-size:.68rem;">
                                    {{ count($permisos) }} permisos
                                </span>
                            </div>
                            <i class="fas fa-chevron-down perm-category-arrow {{ $loop->first ? 'open' : '' }}"></i>
                        </div>
                        <div class="perm-category-body" style="{{ $loop->first ? '' : 'display:none;' }}">
                            @foreach($permisos as $key => $nombre)
                            <label class="perm-item">
                                <input class="permiso-checkbox" type="checkbox"
                                       name="permissions[]" value="{{ $key }}"
                                       {{ in_array($key, old('permissions', $permisosActuales)) ? 'checked' : '' }}>
                                <span>{{ $nombre }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="perm-actions">
                    <button type="button" class="perm-btn perm-btn-all" onclick="seleccionarTodos(true)">
                        <i class="fas fa-check-double"></i> Seleccionar Todos
                    </button>
                    <button type="button" class="perm-btn perm-btn-none" onclick="seleccionarTodos(false)">
                        <i class="fas fa-times"></i> Deseleccionar Todos
                    </button>
                </div>
            </div>
        </div>

        {{-- ── Info de Registro ── --}}
        <div class="reg-info">
            <div>
                <div class="reg-info-lbl">Registrado el</div>
                <div class="reg-info-val">
                    <i class="fas fa-calendar-alt"></i>
                    {{ $administrador->created_at->format('d/m/Y H:i') }}
                </div>
            </div>
            <div>
                <div class="reg-info-lbl">Última actualización</div>
                <div class="reg-info-val">
                    <i class="fas fa-clock"></i>
                    {{ $administrador->updated_at->format('d/m/Y H:i') }}
                </div>
            </div>
        </div>

        {{-- Botones --}}
        <div class="frm-footer">
            <a href="{{ route('superadmin.administradores.index') }}" class="btn-cancel">
                <i class="fas fa-times"></i> Cancelar
            </a>
            <button type="submit" class="btn-submit" id="btnSubmit">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
/* ── Mostrar/ocultar contraseña ── */
function togglePwd(inputId, btn) {
    var input = document.getElementById(inputId);
    var icon  = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fas fa-eye';
    }
}

/* ── Validar nombre (solo letras y espacios) ── */
function validarNombre(input) {
    var val    = input.value;
    var limpio = val.replace(/[^a-záéíóúüñA-ZÁÉÍÓÚÜÑ\s]/g, '');
    if (val !== limpio) input.value = limpio;

    var errEl = document.getElementById('nameError');
    if (!errEl) return;
    if (!limpio.trim()) {
        errEl.innerHTML = '<i class="fas fa-exclamation-circle"></i> El nombre completo es obligatorio.';
        errEl.style.display = 'flex';
        input.classList.add('is-invalid');
    } else {
        errEl.style.display = 'none';
        input.classList.remove('is-invalid');
    }
}

/* ── Fuerza de contraseña ── */
function checkPasswordStrength(val) {
    var wrap  = document.getElementById('pwdStrength');
    var fill  = document.getElementById('pwdFill');
    var label = document.getElementById('pwdLabel');

    if (!val) { wrap.style.display = 'none'; return; }
    wrap.style.display = 'block';

    var score = 0;
    if (val.length >= 8)           score++;
    if (val.length >= 12)          score++;
    if (/[A-Z]/.test(val))         score++;
    if (/[0-9]/.test(val))         score++;
    if (/[^A-Za-z0-9]/.test(val))  score++;

    var levels = [
        { pct: '20%',  color: '#ef4444', text: 'Muy débil' },
        { pct: '40%',  color: '#f97316', text: 'Débil' },
        { pct: '60%',  color: '#f59e0b', text: 'Aceptable' },
        { pct: '80%',  color: '#10b981', text: 'Fuerte' },
        { pct: '100%', color: '#059669', text: 'Muy fuerte' },
    ];
    var lvl = levels[Math.min(score, 4)];
    fill.style.width      = lvl.pct;
    fill.style.background = lvl.color;
    label.textContent     = lvl.text;
    label.style.color     = lvl.color;

    checkConfirm();
}

/* ── Confirmar contraseña ── */
function checkConfirm() {
    var pwd     = document.getElementById('password').value;
    var confirm = document.getElementById('password_confirmation').value;
    var errEl   = document.getElementById('confirmError');
    var okEl    = document.getElementById('confirmOk');

    if (!confirm) { errEl.style.display='none'; okEl.style.display='none'; return; }

    if (pwd === confirm) {
        errEl.style.display = 'none';
        okEl.style.display  = 'flex';
    } else {
        errEl.style.display = 'flex';
        okEl.style.display  = 'none';
    }
}

/* ── Toggle categoría de permisos ── */
function toggleCategory(header) {
    var body  = header.nextElementSibling;
    var arrow = header.querySelector('.perm-category-arrow');
    var open  = body.style.display !== 'none';
    body.style.display = open ? 'none' : 'grid';
    arrow.classList.toggle('open', !open);
}

/* ── Mostrar/ocultar sección permisos según rol ── */
document.addEventListener('DOMContentLoaded', function () {
    var roleSA    = document.getElementById('role_super_admin');
    var roleAdmin = document.getElementById('role_admin');
    var permSec   = document.getElementById('permisosSection');

    function togglePermisos() {
        permSec.style.display = roleAdmin.checked ? 'block' : 'none';
    }

    roleSA.addEventListener('change', togglePermisos);
    roleAdmin.addEventListener('change', togglePermisos);
});

/* ── Seleccionar / deseleccionar todos los permisos ── */
function seleccionarTodos(val) {
    document.querySelectorAll('.permiso-checkbox').forEach(function(cb) {
        cb.checked = val;
    });
}

/* ── Validación antes de enviar ── */
document.getElementById('frmEditar').addEventListener('submit', function(e) {
    var name  = document.getElementById('name').value.trim();
    var email = document.getElementById('email').value.trim();
    var pwd   = document.getElementById('password').value;
    var conf  = document.getElementById('password_confirmation').value;
    var role  = document.querySelector('input[name="role"]:checked');

    var errors = [];

    if (!name)
        errors.push('El nombre completo es obligatorio.');
    if (name && /[^a-záéíóúüñA-ZÁÉÍÓÚÜÑ\s]/g.test(name))
        errors.push('El nombre solo puede contener letras y espacios.');
    if (!email)
        errors.push('El correo electrónico es obligatorio.');
    if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email))
        errors.push('El correo electrónico no es válido.');
    if (pwd && pwd.length < 8)
        errors.push('La contraseña debe tener al menos 8 caracteres.');
    if (pwd && pwd !== conf)
        errors.push('Las contraseñas no coinciden.');
    if (!role)
        errors.push('Debes seleccionar un tipo de administrador.');

    if (errors.length > 0) {
        e.preventDefault();
        var box = document.querySelector('.frm-alert-errors');
        if (!box) {
            box = document.createElement('div');
            box.className = 'frm-alert-errors';
            document.getElementById('frmEditar').prepend(box);
        }
        box.innerHTML = '<div class="frm-alert-errors-title"><i class="fas fa-exclamation-circle"></i> Por favor corrige los siguientes errores:</div><ul>' +
            errors.map(function(err){ return '<li>' + err + '</li>'; }).join('') + '</ul>';
        box.scrollIntoView({ behavior: 'smooth', block: 'center' });
    } else {
        document.getElementById('btnSubmit').disabled = true;
        document.getElementById('btnSubmit').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
    }
});
</script>
@endpush