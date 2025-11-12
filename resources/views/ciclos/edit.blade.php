@extends('layouts.app')

@section('title', 'Editar Ciclo')

@section('page-title', 'Editar Ciclo')

@section('topbar-actions')
    <a href="{{ route('ciclos.index') }}" class="btn-back"
        style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #00508f; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
@endsection

@section('content')
    <div class="container" style="max-width: 800px;">

        <!-- Header compacto (Similar al de Estudiante) -->
        <div class="card border-0 shadow-sm mb-3"
            style="background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 10px;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="icon-box me-3"
                            style="width: 45px; height: 45px; background: rgba(78, 199, 210, 0.3); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            {{-- Icono representativo para Ciclos --}}
                            <i class="fas fa-calendar-alt text-white" style="font-size: 1.3rem;"></i>
                        </div>
                        <div class="text-white">
                            <h5 class="mb-0 fw-bold" style="font-size: 1.1rem;">Editar Ciclo</h5>
                            <p class="mb-0 opacity-90" style="font-size: 0.8rem;">Actualice los detalles del período escolar
                            </p>
                        </div>
                    </div>
                    <div style="background: rgba(78, 199, 210, 0.2); padding: 0.4rem 0.8rem; border-radius: 6px;">
                        <p class="text-white mb-0 small fw-semibold" style="font-size: 0.8rem;">ID: #{{ $ciclo->id }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulario compacto -->
        <div class="card border-0 shadow-sm" style="border-radius: 10px;">
            <div class="card-body p-3">
                <form action="{{ route('ciclos.update', $ciclo) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Sección: Detalles del Ciclo (Nombre, Sección, Jornada) -->
                    <div class="mb-3">
                        <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center"
                            style="color: #00508f; font-weight: 600; font-size: 0.95rem;">
                            <i class="fas fa-book-reader me-2" style="font-size: 0.9rem;"></i>Información del Período
                        </h6>

                        <div class="row g-2">

                            <!-- Nombre del Ciclo (Select) -->
                            <div class="col-md-4">
                                <label for="nombre" class="form-label fw-semibold small mb-1">
                                    Nombre del Ciclo <span class="text-danger">*</span>
                                </label>
                                <select name="nombre" id="nombre"
                                    class="form-select form-select-sm @error('nombre') is-invalid @enderror" required>
                                    <option value="">Seleccione un ciclo</option>
                                    <option value="Primer Ciclo" {{ old('nombre', $ciclo->nombre) == 'Primer Ciclo' ? 'selected' : '' }}>Primer Ciclo</option>
                                    <option value="Segundo Ciclo" {{ old('nombre', $ciclo->nombre) == 'Segundo Ciclo' ? 'selected' : '' }}>Segundo Ciclo</option>
                                    <option value="Tercer Ciclo" {{ old('nombre', $ciclo->nombre) == 'Tercer Ciclo' ? 'selected' : '' }}>Tercer Ciclo</option>
                                </select>
                                @error('nombre')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Sección (Input Text) -->
                            <div class="col-md-4">
                                <label for="seccion" class="form-label fw-semibold small mb-1">
                                    Sección <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="seccion" id="seccion" value="{{ old('seccion', $ciclo->seccion) }}"
                                    placeholder="Ej: A, B, Nocturna" required maxlength="20"
                                    class="form-control form-control-sm @error('seccion') is-invalid @enderror">

                                @error('seccion')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Jornada (Select) -->
                            <div class="col-md-4">
                                <label for="jornada" class="form-label fw-semibold small mb-1">
                                    Jornada <span class="text-danger">*</span>
                                </label>
                                <select name="jornada" id="jornada"
                                    class="form-select form-select-sm @error('jornada') is-invalid @enderror" required>
                                    <option value="">Seleccione una jornada</option>

                                    {{-- NOTA: Se corrige el acceso de $grado->jornada a $ciclo->jornada --}}
                                    <option value="Matutina" {{ old('jornada', $ciclo->jornada ?? '') == 'Matutina' ? 'selected' : '' }}>
                                        Matutina
                                    </option>

                                    <option value="Vespertina" {{ old('jornada', $ciclo->jornada ?? '') == 'Vespertina' ? 'selected' : '' }}>
                                        Vespertina
                                    </option>
                                </select>

                                @error('jornada')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <!-- Botones compactos -->
                    <div class="d-flex gap-2 pt-2 border-top">
                        <button type="submit" class="btn btn-sm fw-semibold flex-fill"
                            style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); padding: 0.6rem; border-radius: 8px;">
                            <i class="fas fa-save me-1"></i>Actualizar Ciclo
                        </button>
                        <a href="{{ route('ciclos.index') }}" class="btn btn-sm fw-semibold flex-fill"
                            style="border: 2px solid #00508f; color: #00508f; background: white; padding: 0.6rem; border-radius: 8px;">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Nota compacta -->
        <div class="alert border-0 mt-2 py-2 px-3"
            style="border-radius: 8px; background: rgba(78, 199, 210, 0.1); border-left: 3px solid #4ec7d2 !important; font-size: 0.85rem;">
            <div class="d-flex align-items-start">
                <i class="fas fa-info-circle me-2 mt-1" style="font-size: 0.9rem; color: #00508f;"></i>
                <div>
                    <strong style="color: #00508f;">Importante:</strong>
                    <span class="text-muted"> Los cambios se aplicarán inmediatamente al ciclo.</span>
                </div>
            </div>
        </div>

    </div>

    @push('styles')
        <style>
            /* Estilos copiados del formulario de estudiante para consistencia */
            .form-control-sm,
            .form-select-sm {
                border-radius: 6px;
                border: 1.5px solid #e2e8f0;
                padding: 0.5rem 0.75rem;
                transition: all 0.3s ease;
                font-size: 0.875rem;
            }

            .form-control-sm:focus,
            .form-select-sm:focus {
                border-color: #4ec7d2;
                box-shadow: 0 0 0 0.15rem rgba(78, 199, 210, 0.15);
            }

            .form-label {
                color: #003b73;
                font-size: 0.85rem;
                margin-bottom: 0.3rem;
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
        </style>
    @endpush
@endsection