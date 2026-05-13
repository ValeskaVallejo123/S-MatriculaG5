@extends('layouts.app')

@section('title', 'Consultar Solicitud')

@section('content')
<div class="container-fluid" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px;">
    <div class="login-card" style="background: white; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); padding: 40px; max-width: 500px; width: 100%;">
        
        <!-- Header -->
        <div class="text-center mb-4">
            <h2 style="color: #667eea; font-weight: bold;">🎓 Consultar Solicitud</h2>
            <p class="text-muted">Ingrese sus datos para ver el estado de su matrícula</p>
        </div>

        <!-- Mensajes de alerta -->
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Info box -->
        <div class="alert alert-light border-start border-4 border-primary mb-4">
            <small>
                <strong><i class="fas fa-info-circle text-primary me-2"></i>Puede ingresar de dos formas:</strong><br>
                • Con su <strong>correo electrónico</strong> registrado<br>
                • Con su <strong>código de matrícula</strong> (Ej: MAT-2026-0004)
            </small>
        </div>

        <!-- Formulario SIN validación HTML del navegador -->
        <form method="POST" action="{{ route('padres.login.post') }}" novalidate>
            @csrf

            <!-- Campo identificador -->
            <div class="mb-3">
                <label for="identificador" class="form-label fw-semibold">
                    <i class="fas fa-envelope me-2" style="color: #667eea;"></i>Correo Electrónico o Código de Matrícula
                </label>
                <input type="text"
                       class="form-control form-control-lg @error('identificador') is-invalid @enderror" 
                       id="identificador" 
                       name="identificador" 
                       placeholder="ejemplo@correo.com o MAT-2026-0004"
                       value="{{ old('identificador') }}"
                       autofocus
                       autocomplete="off"
                       style="border-radius: 10px; border: 2px solid #e0e0e0;">
                @error('identificador')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">
                    <i class="fas fa-lightbulb me-1"></i>Ingrese su correo o el código que recibió al enviar la solicitud
                </small>
            </div>

            <!-- Campo contraseña -->
            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">
                    <i class="fas fa-lock me-2" style="color: #667eea;"></i>Contraseña (Identidad del Estudiante)
                </label>
                <input type="password" 
                       class="form-control form-control-lg @error('password') is-invalid @enderror" 
                       id="password" 
                       name="password" 
                       placeholder="0703197502001"
                       autocomplete="off"
                       style="border-radius: 10px; border: 2px solid #e0e0e0;">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">
                    <i class="fas fa-id-card me-1"></i>Ingrese el número de identidad del estudiante (sin guiones)
                </small>
            </div>

            <!-- Recordar -->
            <div class="mb-4 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">
                    Recordar mis datos
                </label>
            </div>

            <!-- Botón submit -->
            <button type="submit" 
                    class="btn btn-lg w-100 text-white fw-semibold"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 10px; padding: 12px;">
                <i class="fas fa-search me-2"></i>Consultar Estado de Solicitud
            </button>
        </form>

        <!-- Enlaces adicionales -->
        <div class="text-center mt-4">
            <small class="text-muted">
                ¿Problemas para ingresar? Contacte a la institución<br>
                <a href="{{ route('inicio') }}" class="text-decoration-none" style="color: #667eea;">
                    <i class="fas fa-arrow-left me-1"></i>Volver al inicio
                </a>
            </small>
        </div>
    </div>
</div>

<style>
    .login-card {
        animation: fadeInUp 0.5s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
</style>
@endsection