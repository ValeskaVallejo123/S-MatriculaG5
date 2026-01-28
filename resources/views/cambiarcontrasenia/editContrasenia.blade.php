@extends('layouts.app')

@section('title', 'Cambiar Contraseña')

@section('page-title', 'Actualizar Contraseña')

@section('content')
<div class="container-fluid px-4">



    <!-- CARD -->
    <div class="card shadow-sm border-0 col-lg-6 mx-auto">
        <div class="card-body p-4">

            <div class="text-center mb-3">
                <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle shadow"
                     style="width:65px; height:65px;">
                    <i class="fas fa-lock fa-lg"></i>
                </div>
                <h4 class="mt-3 fw-bold text-primary">Actualizar tu contraseña</h4>
                <p class="text-muted small">Ingresa tu contraseña actual y una nueva contraseña segura</p>
            </div>

            <!-- Éxito -->
            @if (session('success'))
                <div class="alert alert-success d-flex align-items-center">
                    <i class="fas fa-check-circle me-2"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            <!-- Error -->
            @if (session('error'))
                <div class="alert alert-danger d-flex align-items-center">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            <!-- FORMULARIO -->
            <form action="{{ route('cambiarcontrasenia.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Contraseña actual</label>
                    <input type="password" name="current_password" class="form-control" required>
                    @error('current_password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nueva contraseña</label>
                    <input type="password" name="new_password" class="form-control" required>
                    @error('new_password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Confirmar nueva contraseña</label>
                    <input type="password" name="new_password_confirmation" class="form-control" required>
                </div>

                <button type="submit"
                        class="btn btn-primary w-100 py-2 fw-semibold shadow-sm">
                    <i class="fas fa-save me-2"></i>
                    Actualizar contraseña
                </button>

            </form>

        </div>
    </div>

</div>
@endsection
