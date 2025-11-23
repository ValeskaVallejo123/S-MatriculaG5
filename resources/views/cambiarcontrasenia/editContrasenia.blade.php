@extends('layouts.app')

@section('title', 'Cambiar Contraseña')

@section('page-title', 'Cambiar Contraseña')

@section('topbar-actions')
    <a href="{{ route('dashboard') }}" class="btn-back" style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #00508f; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
@endsection

@section('content')
    <div class="container" style="max-width: 1200px;">

        <!-- Header compacto -->
        <div class="card border-0 shadow-sm mb-3" style="background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 10px;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="icon-box me-3" style="width: 45px; height: 45px; background: rgba(78, 199, 210, 0.3); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-key text-white" style="font-size: 1.3rem;"></i>
                        </div>
                        <div class="text-white">
                            <h5 class="mb-0 fw-bold" style="font-size: 1.1rem;">Cambiar Contraseña</h5>
                            <p class="mb-0 opacity-90" style="font-size: 0.8rem;">Complete los campos para actualizar su contraseña</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulario compacto -->
        <div class="card border-0 shadow-sm" style="border-radius: 10px;">
            <div class="card-body p-3">
                @if (session('success'))
                    <div class="alert border-0 mb-3 py-2 px-3" style="border-radius: 8px; background: rgba(76, 175, 80, 0.1); border-left: 3px solid #4caf50 !important; font-size: 0.85rem;">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-check-circle me-2 mt-1" style="font-size: 0.9rem; color: #4caf50;"></i>
                            <div>
                                <strong style="color: #4caf50;">Éxito:</strong>
                                <span class="text-muted"> {{ session('success') }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert border-0 mb-3 py-2 px-3" style="border-radius: 8px; background: rgba(244, 67, 54, 0.1); border-left: 3px solid #f44336 !important; font-size: 0.85rem;">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-exclamation-circle me-2 mt-1" style="font-size: 0.9rem; color: #f44336;"></i>
                            <div>
                                <strong style="color: #f44336;">Error:</strong>
                                <span class="text-muted"> {{ session('error') }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('cambiarcontrasenia.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Contraseña Actual -->
                    <div class="mb-3">
                        <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center" style="color: #00508f; font-weight: 600; font-size: 0.95rem;">
                            <i class="fas fa-lock me-2" style="font-size: 0.9rem;"></i>Contraseña Actual
                        </h6>

                        <div class="row g-2">
                            <div class="col-12">
                                <label class="form-label fw-semibold small mb-1">
                                    Contraseña Actual <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="password"
                                    name="current_password"
                                    id="current_password"
                                    class="form-control form-control-sm @error('current_password') is-invalid @enderror"
                                    placeholder="Ingrese su contraseña actual"
                                    required
                                >
                                @error('current_password')
                                <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Nueva Contraseña -->
                    <div class="mb-3">
                        <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center" style="color: #00508f; font-weight: 600; font-size: 0.95rem;">
                            <i class="fas fa-key me-2" style="font-size: 0.9rem;"></i>Nueva Contraseña
                        </h6>

                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small mb-1">
                                    Nueva Contraseña <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="password"
                                    name="new_password"
                                    id="new_password"
                                    class="form-control form-control-sm @error('new_password') is-invalid @enderror"
                                    placeholder="Mínimo 8 caracteres"
                                    required
                                    minlength="8"
                                >
                                @error('new_password')
                                <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                                <small class="text-muted" style="font-size: 0.7rem;">Mínimo 8 caracteres</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold small mb-1">
                                    Confirmar Contraseña <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="password"
                                    name="new_password_confirmation"
                                    id="new_password_confirmation"
                                    class="form-control form-control-sm"
                                    placeholder="Repita la contraseña"
                                    required
                                    minlength="8"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Botones compactos -->
                    <div class="d-flex gap-2 pt-2 border-top">
                        <button type="submit" class="btn btn-sm fw-semibold flex-fill" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); padding: 0.6rem; border-radius: 8px;">
                            <i class="fas fa-save me-1"></i>Actualizar Contraseña
                        </button>
                        <a href="{{ route('dashboard') }}" class="btn btn-sm fw-semibold flex-fill" style="border: 2px solid #00508f; color: #00508f; background: white; padding: 0.6rem; border-radius: 8px;">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Nota compacta -->
        <div class="alert border-0 mt-2 py-2 px-3" style="border-radius: 8px; background: rgba(78, 199, 210, 0.1); border-left: 3px solid #4ec7d2 !important; font-size: 0.85rem;">
            <div class="d-flex align-items-start">
                <i class="fas fa-info-circle me-2 mt-1" style="font-size: 0.9rem; color: #00508f;"></i>
                <div>
                    <strong style="color: #00508f;">Importante:</strong>
                    <span class="text-muted"> Por seguridad, debe ingresar su contraseña actual. La nueva contraseña debe tener mínimo 8 caracteres.</span>
                </div>
            </div>
        </div>

    </div>

    @push('styles')
        <style>
            .form-control-sm {
                border-radius: 6px;
                border: 1.5px solid #e2e8f0;
                padding: 0.5rem 0.75rem;
                transition: all 0.3s ease;
                font-size: 0.875rem;
            }

            .form-control-sm:focus {
                border-color: #4ec7d2;
                box-shadow: 0 0 0 0.15rem rgba(78, 199, 210, 0.15);
                outline: none;
            }

            .form-label {
                color: #003b73;
                font-size: 0.85rem;
                margin-bottom: 0.3rem;
            }

            small.text-muted {
                font-size: 0.7rem;
                display: block;
                margin-top: 0.15rem;
            }

            .btn:hover {
                transform: translateY(-2px);
                transition: all 0.3s ease;
            }

            .btn-back:hover {
                background: #00508f !important;
                color: white !important;
                transform: translateY(-2px);
            }

            button[type="submit"]:hover {
                box-shadow: 0 4px 12px rgba(78, 199, 210, 0.4) !important;
            }

            .border-bottom {
                border-color: rgba(0, 80, 143, 0.15) !important;
            }

            .invalid-feedback {
                display: block;
                color: #dc3545;
                font-size: 0.75rem;
                margin-top: 0.25rem;
            }
        </style>
    @endpush
@endsection
