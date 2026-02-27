@extends('layouts.app')

@section('title', 'Crear Administrador')
@section('page-title', 'Nuevo Administrador')

@section('content')
<div class="container" style="max-width: 900px;">

    <a href="{{ route('superadmin.administradores.index') }}" class="btn btn-primary mb-3">
        <i class="fas fa-arrow-left me-1"></i> Volver
    </a>

    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-header border-0 py-3 px-4"
             style="background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%); border-radius: 12px 12px 0 0;">
            <h5 class="text-white fw-bold mb-0">
                <i class="fas fa-user-shield me-2"></i>Información del Administrador
            </h5>
            <small class="text-white" style="opacity: 0.85;">Campos marcados con * son obligatorios</small>
        </div>

        <div class="card-body p-4">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" style="border-left: 4px solid #10b981; border-radius: 8px;">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" style="border-left: 4px solid #ef4444; border-radius: 8px;">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('superadmin.administradores.store') }}" method="POST">
                @csrf

                {{-- Datos Personales --}}
                <h6 class="fw-bold mb-3 pb-2"
                    style="color:#003b73; border-bottom: 2px solid rgba(78,199,210,0.3);">
                    <i class="fas fa-user me-2" style="color:#4ec7d2;"></i>Datos Personales
                </h6>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label fw-semibold" style="color:#003b73;">
                            Nombre(s) <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text" style="background:rgba(78,199,210,0.1);border-color:#4ec7d2;">
                                <i class="fas fa-user" style="color:#4ec7d2;"></i>
                            </span>
                            <input type="text" name="nombre" id="nombre"
                                   class="form-control @error('nombre') is-invalid @enderror"
                                   placeholder="Ej: Juan Carlos"
                                   value="{{ old('nombre') }}"
                                   required minlength="3" maxlength="50"
                                   style="border-radius: 0 8px 8px 0;">
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="apellido" class="form-label fw-semibold" style="color:#003b73;">
                            Apellido(s) <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text" style="background:rgba(78,199,210,0.1);border-color:#4ec7d2;">
                                <i class="fas fa-user" style="color:#4ec7d2;"></i>
                            </span>
                            <input type="text" name="apellido" id="apellido"
                                   class="form-control @error('apellido') is-invalid @enderror"
                                   placeholder="Ej: Pérez González"
                                   value="{{ old('apellido') }}"
                                   required minlength="3" maxlength="50"
                                   style="border-radius: 0 8px 8px 0;">
                            @error('apellido')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label fw-semibold" style="color:#003b73;">
                            Correo Electrónico <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text" style="background:rgba(78,199,210,0.1);border-color:#4ec7d2;">
                                <i class="fas fa-envelope" style="color:#4ec7d2;"></i>
                            </span>
                            <input type="email" name="email" id="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="correo@admin.edu"
                                   value="{{ old('email') }}"
                                   required maxlength="100"
                                   style="border-radius: 0 8px 8px 0;">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Credenciales --}}
                <h6 class="fw-bold mb-3 pb-2"
                    style="color:#003b73; border-bottom: 2px solid rgba(78,199,210,0.3);">
                    <i class="fas fa-lock me-2" style="color:#4ec7d2;"></i>Credenciales
                </h6>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="password" class="form-label fw-semibold" style="color:#003b73;">
                            Contraseña <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text" style="background:rgba(78,199,210,0.1);border-color:#4ec7d2;">
                                <i class="fas fa-lock" style="color:#4ec7d2;"></i>
                            </span>
                            <input type="password" name="password" id="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Mínimo 8 caracteres"
                                   required minlength="8" maxlength="50">
                            <button type="button" class="btn btn-outline-secondary"
                                    onclick="togglePassword('password')"
                                    style="border-radius: 0 8px 8px 0;">
                                <i class="fas fa-eye" id="icon-password"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label fw-semibold" style="color:#003b73;">
                            Confirmar Contraseña <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text" style="background:rgba(78,199,210,0.1);border-color:#4ec7d2;">
                                <i class="fas fa-check-circle" style="color:#4ec7d2;"></i>
                            </span>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="form-control"
                                   placeholder="Repita la contraseña"
                                   required minlength="8" maxlength="50">
                            <button type="button" class="btn btn-outline-secondary"
                                    onclick="togglePassword('password_confirmation')"
                                    style="border-radius: 0 8px 8px 0;">
                                <i class="fas fa-eye" id="icon-password_confirmation"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Permisos --}}
                <h6 class="fw-bold mb-3 pb-2"
                    style="color:#003b73; border-bottom: 2px solid rgba(78,199,210,0.3);">
                    <i class="fas fa-key me-2" style="color:#4ec7d2;"></i>Permisos y Privilegios
                </h6>

                <div class="card border-0 mb-4" style="background:#f8fafc; border-radius:10px;">
                    <div class="card-body p-3">
                        <div class="row g-2">
                            @foreach($permisos as $key => $label)
                                <div class="col-md-6">
                                    <div class="form-check p-2 rounded"
                                         style="background:white; border:1px solid #e2e8f0;">
                                        <input class="form-check-input" type="checkbox"
                                               name="permisos[]"
                                               value="{{ $key }}"
                                               id="permiso_{{ $key }}"
                                               {{ in_array($key, old('permisos', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="permiso_{{ $key }}"
                                               style="font-size:0.875rem; color:#374151;">
                                            {{ $label }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Nota informativa --}}
                <div class="alert alert-info border-0 mb-4"
                     style="background:rgba(78,199,210,0.08); border-left:4px solid #4ec7d2 !important; border-radius:8px;">
                    <i class="fas fa-info-circle me-2" style="color:#4ec7d2;"></i>
                    <strong>Nota:</strong> El correo institucional puede generarse automáticamente como
                    <em>nombre.apellido@admin.edu</em> según la configuración del sistema.
                </div>

                {{-- Botones --}}
                <div class="d-flex gap-3 pt-3" style="border-top: 1px solid #e2e8f0;">
                    <button type="submit" class="btn btn-primary fw-semibold flex-fill"
                            style="border-radius:8px; padding:0.65rem;">
                        <i class="fas fa-user-plus me-2"></i>Crear Administrador
                    </button>
                    <a href="{{ route('superadmin.administradores.index') }}"
                       class="btn btn-outline-secondary fw-semibold flex-fill"
                       style="border-radius:8px; padding:0.65rem;">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </a>
                </div>

            </form>
        </div>
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
