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
.edit-wrapper {
    height: 100%;
    display: flex;
    overflow: hidden;
}
.edit-form-panel {
    flex: 1;
    overflow-y: auto;
    padding: 2rem 2.5rem;
    background: #f8fafc;
}
.edit-field-card {
    background: white;
    border-radius: 12px;
    padding: 1.4rem;
    box-shadow: 0 1px 4px rgba(0,59,115,.07);
    margin-bottom: 1.25rem;
    border: 1px solid #e8eef5;
}
.edit-section-title {
    font-size: .7rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .08em;
    color: #ea580c; margin-bottom: 1.1rem;
    padding-bottom: .45rem; border-bottom: 1px solid #fef3c7;
}
.form-control:focus, .form-select:focus {
    border-color: #f59e0b !important;
    box-shadow: 0 0 0 0.15rem rgba(245,158,11,.2) !important;
}
.perm-item {
    display: flex; align-items: center; gap: .6rem;
    padding: .55rem .75rem;
    background: #f8fafc; border: 1px solid #e2e8f0;
    border-radius: 8px; transition: all .15s; cursor: pointer;
}
.perm-item:hover { border-color: #f59e0b; background: #fffbeb; }

body.dark-mode .edit-form-panel   { background: #0f172a !important; }
body.dark-mode .edit-field-card   { background: #1e293b !important; border-color: #334155 !important; }
body.dark-mode .edit-section-title { color: #f59e0b !important; border-bottom-color: #334155 !important; }
body.dark-mode .perm-item { background: #0f172a !important; border-color: #334155 !important; }
body.dark-mode .perm-item:hover { background: #1c1708 !important; border-color: #f59e0b !important; }
</style>
@endpush

@section('content')
<div class="edit-wrapper">

    {{-- Panel izquierdo: formulario --}}
    <div class="edit-form-panel">

        <form action="{{ route('superadmin.administradores.update', $admin->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Datos Personales --}}
            <div class="edit-field-card">
                <div class="edit-section-title"><i class="fas fa-user me-1"></i>Datos Personales</div>
                <div class="row g-3">
                    <div class="col-lg-6">
                        <label for="nombre" class="form-label small fw-semibold" style="color:#003b73;">
                            Nombre Completo <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nombre" id="nombre"
                               class="form-control @error('nombre') is-invalid @enderror"
                               value="{{ old('nombre', $admin->nombre) }}"
                               required minlength="3" maxlength="50"
                               style="border-radius:8px;border:1.5px solid #e2e8f0;">
                        @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-lg-6">
                        <label for="email" class="form-label small fw-semibold" style="color:#003b73;">
                            Correo Electrónico <span class="text-danger">*</span>
                        </label>
                        <input type="email" name="email" id="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $admin->email) }}"
                               required maxlength="100"
                               style="border-radius:8px;border:1.5px solid #e2e8f0;">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- Contraseña --}}
            <div class="edit-field-card">
                <div class="edit-section-title">
                    <i class="fas fa-lock me-1"></i>Cambiar Contraseña
                    <span style="font-size:.68rem;font-weight:400;color:#94a3b8;text-transform:none;letter-spacing:0;margin-left:.4rem;">
                        (dejar en blanco para no cambiar)
                    </span>
                </div>
                <div class="row g-3">
                    <div class="col-lg-6">
                        <label for="password" class="form-label small fw-semibold" style="color:#003b73;">
                            Nueva Contraseña
                        </label>
                        <div class="input-group">
                            <input type="password" name="password" id="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Mínimo 8 caracteres"
                                   minlength="8" maxlength="50"
                                   style="border-radius:8px 0 0 8px;border:1.5px solid #e2e8f0;border-right:none;">
                            <button type="button" class="btn btn-outline-secondary"
                                    onclick="togglePassword('password')"
                                    style="border-radius:0 8px 8px 0;border:1.5px solid #e2e8f0;border-left:none;">
                                <i class="fas fa-eye" id="icon-password"></i>
                            </button>
                        </div>
                        @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-lg-6">
                        <label for="password_confirmation" class="form-label small fw-semibold" style="color:#003b73;">
                            Confirmar Nueva Contraseña
                        </label>
                        <div class="input-group">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="form-control"
                                   placeholder="Repita la contraseña"
                                   style="border-radius:8px 0 0 8px;border:1.5px solid #e2e8f0;border-right:none;">
                            <button type="button" class="btn btn-outline-separator"
                                    onclick="togglePassword('password_confirmation')"
                                    style="border-radius:0 8px 8px 0;border:1.5px solid #e2e8f0;border-left:none;background:white;color:#6b7280;">
                                <i class="fas fa-eye" id="icon-password_confirmation"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Permisos --}}
            <div class="edit-field-card">
                <div class="edit-section-title"><i class="fas fa-key me-1"></i>Permisos y Privilegios</div>
                <div class="row g-2">
                    @foreach($permisos as $key => $label)
                        <div class="col-lg-6">
                            <label class="perm-item w-100 mb-0" for="permiso_{{ $key }}">
                                <input class="form-check-input m-0" type="checkbox"
                                       name="permisos[]"
                                       value="{{ $key }}"
                                       id="permiso_{{ $key }}"
                                       style="width:16px;height:16px;accent-color:#ea580c;flex-shrink:0;"
                                       {{ in_array($key, old('permisos', $admin->permissions ?? [])) ? 'checked' : '' }}>
                                <span style="font-size:.83rem;color:#374151;">{{ $label }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Botones --}}
            <div class="d-flex gap-3 align-items-center mt-1">
                <button type="submit"
                        style="background:linear-gradient(135deg,#f59e0b,#ea580c);color:white;border:none;
                               padding:.6rem 2rem;border-radius:9px;font-weight:700;font-size:.9rem;
                               box-shadow:0 2px 10px rgba(245,158,11,.3);cursor:pointer;">
                    <i class="fas fa-save me-2"></i>Actualizar Información
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
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById('icon-' + inputId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
@endpush
