@extends('layouts.app')

@section('title', 'Seguridad - Cambiar Contraseña')

@section('content')
    <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center py-5"
         style="background-color: #f8fafc;">

        <div class="col-12 col-md-8 col-lg-6 col-xl-4">
            <div class="text-center mb-4">
                <div class="bg-primary bg-opacity-10 d-inline-block p-3 rounded-circle mb-3">
                    <i class="fas fa-lock text-primary fs-3"></i>
                </div>
                <h3 class="fw-bold text-dark">Configuración de Seguridad</h3>
                <p class="text-muted">Actualiza tus credenciales para mantener tu cuenta protegida</p>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-body p-4 p-md-5">

                    <form action="{{ route('cambiarcontrasenia.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary small">CONTRASEÑA ACTUAL</label>
                            <div class="input-group custom-input-group">
                            <span class="input-group-text bg-transparent border-end-0 text-muted">
                                <i class="fas fa-shield-alt"></i>
                            </span>
                                <input type="password" name="current_password"
                                       class="form-control border-start-0 ps-0 @error('current_password') is-invalid @enderror"
                                       placeholder="Introduce tu clave actual" required>
                            </div>
                            @error('current_password')
                            <div class="text-danger mt-1 small fw-medium">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4 text-light">

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary small">NUEVA CONTRASEÑA</label>
                            <div class="input-group custom-input-group">
                            <span class="input-group-text bg-transparent border-end-0 text-muted">
                                <i class="fas fa-key"></i>
                            </span>
                                <input type="password" name="new_password"
                                       class="form-control border-start-0 ps-0 @error('new_password') is-invalid @enderror"
                                       placeholder="Mínimo 8 caracteres" required>
                            </div>
                            @error('new_password')
                            <div class="text-danger mt-1 small fw-medium">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary small">CONFIRMAR NUEVA CONTRASEÑA</label>
                            <div class="input-group custom-input-group">
                            <span class="input-group-text bg-transparent border-end-0 text-muted">
                                <i class="fas fa-check-double"></i>
                            </span>
                                <input type="password" name="new_password_confirmation"
                                       class="form-control border-start-0 ps-0"
                                       placeholder="Repite tu nueva clave" required>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-5">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold"
                                    style="border-radius: 10px; background-color: #003b73; border: none; padding: 12px;">
                                Guardar Cambios
                            </button>
                            <a href="{{ url('/') }}" class="btn btn-link text-muted text-decoration-none small mt-2">
                                <i class="fas fa-chevron-left me-1"></i> Volver al inicio
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-4 p-3 rounded-3 bg-white shadow-sm border">
                <h6 class="small fw-bold text-dark mb-2">Tu contraseña debe tener:</h6>
                <div class="d-flex flex-wrap gap-3">
                    <span class="small text-muted"><i class="fas fa-check-circle text-success me-1"></i> 8+ caracteres</span>
                    <span class="small text-muted"><i class="fas fa-check-circle text-success me-1"></i> Un símbolo</span>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Estilos personalizados para un look moderno */
        .custom-input-group {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            transition: all 0.2s ease;
            overflow: hidden;
        }

        .custom-input-group:focus-within {
            border-color: #003b73;
            box-shadow: 0 0 0 3px rgba(0, 59, 115, 0.1);
        }

        .custom-input-group .form-control {
            border: none;
            padding: 10px 12px;
            font-size: 0.95rem;
        }

        .custom-input-group .form-control:focus {
            box-shadow: none;
        }

        .custom-input-group .input-group-text {
            border: none;
            padding-left: 15px;
        }

        .btn-primary:hover {
            background-color: #002a52 !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 59, 115, 0.2);
        }

        body {
            background-color: #f8fafc;
        }
    </style>
@endsection
