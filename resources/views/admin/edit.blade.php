@extends('layouts.app')

@section('title', 'Editar Administrador')
@section('page-title', 'Editar Administrador')

@section('content')
<div class="container" style="max-width: 900px;">

    <a href="{{ route('superadmin.administradores.index') }}" class="btn btn-primary mb-3">
        <i class="fas fa-arrow-left me-1"></i> Volver
    </a>

    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-header border-0 py-3 px-4"
             style="background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%); border-radius: 12px 12px 0 0;">
            <h5 class="text-white fw-bold mb-0">
                <i class="fas fa-user-edit me-2"></i>Información del Administrador
            </h5>
            <small class="text-white" style="opacity: 0.85;">Modifique los campos que desea actualizar</small>
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

            {{-- FORM — faltaba en el original --}}
            <form action="{{ route('superadmin.administradores.update', $admin->id) }}"
                  method="POST">
                @csrf
                @method('PUT')

                {{-- Datos Personales --}}
                <h6 class="fw-bold mb-3 pb-2" style="color:#003b73; border-bottom: 2px solid rgba(245,158,11,0.3);">
                    <i class="fas fa-user me-2" style="color:#f59e0b;"></i>Datos Personales
                </h6>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label fw-semibold" style="color:#003b73;">
                            Nombre Completo <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nombre" id="nombre"
                               class="form-control @error('nombre') is-invalid @enderror"
                               value="{{ old('nombre', $admin->nombre) }}"
                               required minlength="3" maxlength="50"
                               style="border-radius: 8px;">
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label fw-semibold" style="color:#003b73;">
                            Correo Electrónico <span class="text-danger">*</span>
                        </label>
                        <input type="email" name="email" id="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $admin->email) }}"
                               required maxlength="100"
                               style="border-radius: 8px;">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Cambiar Contraseña --}}
                <h6 class="fw-bold mb-3 pb-2" style="color:#003b73; border-bottom: 2px solid rgba(245,158,11,0.3);">
                    <i class="fas fa-lock me-2" style="color:#f59e0b;"></i>Cambiar Contraseña
                    <small class="text-muted fw-normal ms-2" style="font-size: 0.75rem;">(Dejar en blanco para no cambiar)</small>
                </h6>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="password" class="form-label fw-semibold" style="color:#003b73;">
                            Nueva Contraseña
                        </label>
                        <div class="input-group">
                            <input type="password" name="password" id="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Mínimo 8 caracteres"
                                   minlength="8" maxlength="50"
                                   style="border-radius: 8px 0 0 8px;">
                            <button type="button" class="btn btn-outline-secondary"
                                    onclick="togglePassword('password')"
                                    style="border-radius: 0 8px 8px 0;">
                                <i class="fas fa-eye" id="icon-password"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label fw-semibold" style="color:#003b73;">
                            Confirmar Nueva Contraseña
                        </label>
                        <div class="input-group">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="form-control"
                                   placeholder="Repita la contraseña"
                                   style="border-radius: 8px 0 0 8px;">
                            <button type="button" class="btn btn-outline-secondary"
                                    onclick="togglePassword('password_confirmation')"
                                    style="border-radius: 0 8px 8px 0;">
                                <i class="fas fa-eye" id="icon-password_confirmation"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Permisos --}}
                <h6 class="fw-bold mb-3 pb-2" style="color:#003b73; border-bottom: 2px solid rgba(245,158,11,0.3);">
                    <i class="fas fa-key me-2" style="color:#f59e0b;"></i>Permisos y Privilegios
                </h6>

                <div class="card border-0 mb-4" style="background: #f8fafc; border-radius: 10px;">
                    <div class="card-body p-3">
                        <div class="row g-2">
                            @foreach($permisos as $key => $label)
                                <div class="col-md-6">
                                    <div class="form-check p-2 rounded" style="background: white; border: 1px solid #e2e8f0;">
                                        <input class="form-check-input" type="checkbox"
                                               name="permisos[]"
                                               value="{{ $key }}"
                                               id="permiso_{{ $key }}"
                                               {{ in_array($key, old('permisos', $admin->permissions ?? [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="permiso_{{ $key }}"
                                               style="font-size: 0.875rem; color: #374151;">
                                            {{ $label }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Botones --}}
                <div class="d-flex gap-3 pt-3" style="border-top: 1px solid #e2e8f0;">
                    <button type="submit" class="btn fw-semibold flex-fill"
                            style="background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%); color: white; border: none; border-radius: 8px; padding: 0.65rem;">
                        <i class="fas fa-save me-2"></i>Actualizar Información
                    </button>
                    <a href="{{ route('superadmin.administradores.index') }}"
                       class="btn btn-outline-secondary fw-semibold flex-fill"
                       style="border-radius: 8px; padding: 0.65rem;">
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
