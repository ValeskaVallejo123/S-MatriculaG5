@extends('layouts.app')

@section('title', 'Cambiar Contraseña')

@section('content')
    <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center py-5"
         style="background: radial-gradient(circle at top right, #eef2f3 0%, #d5e1e6 100%);">

        <div class="row w-100 justify-content-center">
            <div class="col-12 col-md-11 col-lg-10 col-xl-9">

                <div class="card shadow-lg border-0" style="border-radius: 25px; overflow: hidden;">
                    <div class="row g-0">

                        <div class="col-lg-4 d-none d-lg-flex flex-column align-items-center justify-content-center text-white p-5 text-center"
                             style="background: linear-gradient(135deg, #004a77 0%, #227199 100%);">
                            <div class="mb-4 shadow-lg rounded-circle bg-white bg-opacity-10 p-4">
                                <i class="bi bi-shield-lock" style="font-size: 6rem;"></i>
                            </div>
                            <h2 class="fw-bold mb-3">Seguridad Avanzada</h2>
                            <p class="lead opacity-75">Mantener tu contraseña actualizada es la primera línea de defensa de tu cuenta.</p>

                            <div class="mt-5 w-100 border-top border-white border-opacity-25 pt-4">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-check2-circle me-3 fs-3 text-info"></i>
                                    <span class="text-start small">Protección de datos personales</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-check2-circle me-3 fs-3 text-info"></i>
                                    <span class="text-start small">Acceso seguro garantizado</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-8 bg-white">
                            <div class="card-body p-4 p-md-5">

                                <div class="mb-5">
                                    <h1 class="display-6 fw-bold text-dark mb-2">Actualizar Contraseña</h1>
                                    <p class="text-muted fs-5">Por favor, complete los siguientes campos para proceder.</p>
                                </div>

                                <form action="{{ route('cambiarcontrasenia.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="row g-4">
                                        <div class="col-12">
                                            <label class="form-label h6 fw-bold text-primary mb-3">Contraseña Actual</label>
                                            <div class="input-group input-group-lg border rounded-3 overflow-hidden shadow-sm">
                                                <span class="input-group-text bg-light border-0 px-4 text-primary"><i class="bi bi-shield-fill"></i></span>
                                                <input type="password" name="current_password"
                                                       class="form-control border-0 py-3 @error('current_password') is-invalid @enderror"
                                                       placeholder="Ingrese su contraseña actual" required>
                                            </div>
                                            @error('current_password')
                                            <div class="text-danger mt-2 small fw-bold">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mt-5">
                                            <label class="form-label h6 fw-bold text-primary mb-3">Nueva Contraseña</label>
                                            <div class="input-group input-group-lg border rounded-3 overflow-hidden shadow-sm">
                                                <span class="input-group-text bg-light border-0 px-3 text-primary"><i class="bi bi-key-fill"></i></span>
                                                <input type="password" name="new_password"
                                                       class="form-control border-0 py-3 @error('new_password') is-invalid @enderror"
                                                       placeholder="Mínimo 8 caracteres" required minlength="8">
                                            </div>
                                            @error('new_password')
                                            <div class="text-danger mt-2 small fw-bold">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mt-md-5">
                                            <label class="form-label h6 fw-bold text-primary mb-3">Confirmar Nueva Contraseña</label>
                                            <div class="input-group input-group-lg border rounded-3 overflow-hidden shadow-sm">
                                                <span class="input-group-text bg-light border-0 px-3 text-primary"><i class="bi bi-shield-check-fill"></i></span>
                                                <input type="password" name="new_password_confirmation"
                                                       class="form-control border-0 py-3"
                                                       placeholder="Repita la nueva contraseña" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-5 pt-4 border-top">
                                        <div class="col-md-8">
                                            <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-bold shadow"
                                                    style="background: #004a77; border: none; border-radius: 12px; font-size: 1.2rem;">
                                                <i class="bi bi-arrow-repeat me-2"></i>Actualizar Mi Contraseña
                                            </button>
                                        </div>
                                        <div class="col-md-4 mt-3 mt-md-0">
                                            <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-lg w-100 py-3 fw-semibold border-2"
                                               style="border-radius: 12px;">
                                                Cancelar
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-md-4 text-center">
                        <p class="text-muted mb-0"><i class="bi bi-info-circle-fill text-primary me-2"></i> Use al menos un símbolo (!@#$)</p>
                    </div>
                    <div class="col-md-4 text-center border-start border-end">
                        <p class="text-muted mb-0"><i class="bi bi-exclamation-triangle-fill text-warning me-2"></i> No use nombres comunes</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <p class="text-muted mb-0"><i class="bi bi-clock-fill text-primary me-2"></i> Actualizada: {{ now()->format('d/m/Y') }}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        /* Efecto para que los campos se sientan más "vivos" */
        .input-group:focus-within {
            border-color: #004a77 !important;
            box-shadow: 0 0 15px rgba(0, 74, 119, 0.15) !important;
        }
        .input-group-text {
            font-size: 1.3rem;
        }
        input::placeholder {
            color: #adb5bd !important;
            font-size: 0.95rem;
        }
    </style>
@endsection
