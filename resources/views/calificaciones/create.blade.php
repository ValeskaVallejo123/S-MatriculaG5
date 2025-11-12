@extends('layouts.app')

@section('title', 'Crear Calificación')

@section('page-title', 'Registrar Nueva Calificación')

@section('topbar-actions')
    <a href="{{ route('calificaciones.index') }}" class="btn-back"
        style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #00508f; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
@endsection

@section('content')
    <div class="container" style="max-width: 1200px;">

        <!-- Header compacto (Calificaciones) -->
        <div class="card border-0 shadow-sm mb-3"
            style="background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 10px;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3"
                        style="width: 45px; height: 45px; background: rgba(255, 204, 0, 0.3); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-graduation-cap text-white" style="font-size: 1.3rem;"></i>
                    </div>
                    <div class="text-white">
                        <h5 class="mb-0 fw-bold" style="font-size: 1.1rem;">Registro de Calificación</h5>
                        <p class="mb-0 opacity-90" style="font-size: 0.8rem;">Complete las notas del alumno</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulario compacto -->
        <div class="card border-0 shadow-sm" style="border-radius: 10px;">
            <div class="card-body p-3">
                <form action="{{ route('calificaciones.store') }}" method="POST">
                    @csrf

                    <!-- Sección: Información del Alumno -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div
                                style="width: 36px; height: 36px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user-graduate" style="color: white; font-size: 0.9rem;"></i>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color: #003b73; font-size: 1rem;">Detalles del Alumno</h6>
                        </div>

                        <div class="row g-3">
                            <!-- Nombre del Alumno -->
                            <div class="col-md-12">
                                <label for="nombre_alumno" class="form-label small fw-semibold" style="color: #003b73;">
                                    Nombre del Alumno <span style="color: #ef4444;">*</span>
                                </label>
                                <div class="position-relative">
                                    <i class="fas fa-user-tag position-absolute"
                                        style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                    <input type="text"
                                        class="form-control ps-5 @error('nombre_alumno') is-invalid @enderror"
                                        id="nombre_alumno" name="nombre_alumno" value="{{ old('nombre_alumno') }}"
                                        placeholder="Ej: Juan Pérez López" required
                                        style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                    @error('nombre_alumno')
                                        <div class="invalid-feedback" style="font-size: 0.8rem;">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección: Calificaciones Parciales -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3 pt-3 border-top"
                            style="border-color: rgba(0, 80, 143, 0.15) !important;">
                            <div
                                style="width: 36px; height: 36px; background: linear-gradient(135deg, #FFCC00 0%, #FFA000 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-percent" style="color: white; font-size: 0.9rem;"></i>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color: #003b73; font-size: 1rem;">Notas Parciales (0.00 -
                                100.00)</h6>
                        </div>

                        <div class="row g-3">

                            <!-- Primer Parcial -->
                            <div class="col-md-3 col-sm-6">
                                <label for="primer_parcial" class="form-label small fw-semibold"
                                    style="color: #003b73;">Primer Parcial</label>
                                <div class="position-relative">
                                    <i class="fas fa-pencil-alt position-absolute"
                                        style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                    <input type="number"
                                        class="form-control ps-5 @error('primer_parcial') is-invalid @enderror"
                                        id="primer_parcial" name="primer_parcial" value="{{ old('primer_parcial') }}"
                                        step="0.01" min="0" max="100" placeholder="0.00"
                                        style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                    @error('primer_parcial')
                                        <div class="invalid-feedback" style="font-size: 0.8rem;">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Segundo Parcial -->
                            <div class="col-md-3 col-sm-6">
                                <label for="segundo_parcial" class="form-label small fw-semibold"
                                    style="color: #003b73;">Segundo Parcial</label>
                                <div class="position-relative">
                                    <i class="fas fa-pencil-alt position-absolute"
                                        style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                    <input type="number"
                                        class="form-control ps-5 @error('segundo_parcial') is-invalid @enderror"
                                        id="segundo_parcial" name="segundo_parcial" value="{{ old('segundo_parcial') }}"
                                        step="0.01" min="0" max="100" placeholder="0.00"
                                        style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                    @error('segundo_parcial')
                                        <div class="invalid-feedback" style="font-size: 0.8rem;">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Tercer Parcial -->
                            <div class="col-md-3 col-sm-6">
                                <label for="tercer_parcial" class="form-label small fw-semibold"
                                    style="color: #003b73;">Tercer Parcial</label>
                                <div class="position-relative">
                                    <i class="fas fa-pencil-alt position-absolute"
                                        style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                    <input type="number"
                                        class="form-control ps-5 @error('tercer_parcial') is-invalid @enderror"
                                        id="tercer_parcial" name="tercer_parcial" value="{{ old('tercer_parcial') }}"
                                        step="0.01" min="0" max="100" placeholder="0.00"
                                        style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                    @error('tercer_parcial')
                                        <div class="invalid-feedback" style="font-size: 0.8rem;">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Cuarto Parcial -->
                            <div class="col-md-3 col-sm-6">
                                <label for="cuarto_parcial" class="form-label small fw-semibold"
                                    style="color: #003b73;">Cuarto Parcial</label>
                                <div class="position-relative">
                                    <i class="fas fa-pencil-alt position-absolute"
                                        style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                    <input type="number"
                                        class="form-control ps-5 @error('cuarto_parcial') is-invalid @enderror"
                                        id="cuarto_parcial" name="cuarto_parcial" value="{{ old('cuarto_parcial') }}"
                                        step="0.01" min="0" max="100" placeholder="0.00"
                                        style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                    @error('cuarto_parcial')
                                        <div class="invalid-feedback" style="font-size: 0.8rem;">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Recuperación -->
                            <div class="col-md-6 mt-3">
                                <label for="recuperacion" class="form-label small fw-semibold"
                                    style="color: #003b73;">Recuperación (Opcional)</label>
                                <div class="position-relative">
                                    <i class="fas fa-redo-alt position-absolute"
                                        style="left: 12px; top: 50%; transform: translateY(-50%); color: #dc3545; font-size: 0.85rem;"></i>
                                    <input type="number"
                                        class="form-control ps-5 @error('recuperacion') is-invalid @enderror"
                                        id="recuperacion" name="recuperacion" value="{{ old('recuperacion') }}" step="0.01"
                                        min="0" max="100" placeholder="0.00"
                                        style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                    <small class="text-muted d-block mt-1">Solo ingrese nota si el alumno necesita
                                        recuperar.</small>
                                    @error('recuperacion')
                                        <div class="invalid-feedback" style="font-size: 0.8rem;">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Botones compactos -->
                    <div class="d-flex gap-2 pt-3 border-top">
                        <button type="submit" class="btn btn-sm fw-semibold flex-fill"
                            style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); padding: 0.6rem; border-radius: 8px;">
                            <i class="fas fa-save me-1"></i>Registrar Calificación
                        </button>
                        <a href="{{ route('calificaciones.index') }}" class="btn btn-sm fw-semibold flex-fill"
                            style="border: 2px solid #00508f; color: #00508f; background: white; padding: 0.6rem; border-radius: 8px;">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Nota compacta (Cálculo) -->
        <div class="alert border-0 mt-3 py-2 px-3"
            style="border-radius: 8px; background: rgba(0, 80, 143, 0.1); border-left: 3px solid #00508f !important; font-size: 0.85rem;">
            <div class="d-flex align-items-start">
                <i class="fas fa-calculator me-2 mt-1" style="font-size: 0.9rem; color: #00508f;"></i>
                <div>
                    <strong style="color: #00508f;">Cálculo de Nota Final:</strong>
                    <span class="text-muted">La nota final se calcula automáticamente como el promedio de los 4 parciales.
                        Si el promedio es menor a 60 y existe una nota de **Recuperación**, se tomará la mayor nota entre el
                        promedio y la recuperación.</span>
                </div>
            </div>
        </div>

    </div>

    @push('styles')
        <style>
            /* Estilos base de los inputs */
            .form-control,
            .form-select {
                border-radius: 8px;
                border: 2px solid #bfd9ea;
                padding: 0.6rem 1rem 0.6rem 2.8rem;
                /* Espacio para el icono */
                transition: all 0.3s ease;
                font-size: 0.9rem;
            }

            /* Estilos para inputs pequeños (parciales/recuperación) */
            .form-control-sm,
            .form-select-sm {
                border-radius: 6px;
                border: 1.5px solid #e2e8f0;
                padding: 0.5rem 0.75rem;
                transition: all 0.3s ease;
                font-size: 0.875rem;
            }

            /* Foco y validación */
            .form-control:focus,
            .form-select:focus {
                border-color: #4ec7d2;
                box-shadow: 0 0 0 0.15rem rgba(78, 199, 210, 0.15);
                outline: none;
            }

            .is-invalid.form-control {
                border-color: #ef4444;
                padding-right: 2.8rem !important;
                /* Ajuste para el icono de error */
            }

            .form-label {
                color: #003b73;
                font-size: 0.85rem;
                margin-bottom: 0.3rem;
            }

            small.text-muted {
                font-size: 0.75rem;
                display: block;
                margin-top: 0.15rem;
            }

            /* Estilos de botones y transiciones */
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

            .border-top {
                border-color: rgba(0, 80, 143, 0.15) !important;
            }

            /* Media Query para móvil */
            @media (max-width: 767px) {
                .col-md-3 {
                    flex-basis: 50%;
                    max-width: 50%;
                }

                .col-md-6.mt-3 {
                    flex-basis: 100%;
                    max-width: 100%;
                }
            }
        </style>
    @endpush
@endsection