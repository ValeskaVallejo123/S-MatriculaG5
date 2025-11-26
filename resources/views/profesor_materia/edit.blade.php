@extends('layouts.app')

@section('title', 'Editar Materias de Profesor')

@section('page-title', 'Editar Materias')

@section('topbar-actions')
    <a href="{{ route('profesor_materia.index') }}" class="btn-back" style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #00508f; font-size: 0.9rem;">
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
                            <i class="fas fa-user-edit text-white" style="font-size: 1.3rem;"></i>
                        </div>
                        <div class="text-white">
                            <h5 class="mb-0 fw-bold" style="font-size: 1.1rem;">Editar Materias de Profesor</h5>
                            <p class="mb-0 opacity-90" style="font-size: 0.8rem;">{{ $profesor->nombre }} {{ $profesor->apellido }}</p>
                        </div>
                    </div>
                    <div style="background: rgba(78, 199, 210, 0.2); padding: 0.4rem 0.8rem; border-radius: 6px;">
                        <p class="text-white mb-0 small fw-semibold" style="font-size: 0.8rem;">ID: #{{ $profesor->id }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alertas de error -->
        @if ($errors->any())
            <div class="alert border-0 mb-3 py-2 px-3" style="border-radius: 8px; background: rgba(244, 67, 54, 0.1); border-left: 3px solid #f44336 !important; font-size: 0.85rem;">
                <div class="d-flex align-items-start">
                    <i class="fas fa-exclamation-circle me-2 mt-1" style="font-size: 0.9rem; color: #f44336;"></i>
                    <div>
                        <strong style="color: #f44336;">Se encontraron los siguientes errores:</strong>
                        <ul class="mb-0 mt-1" style="padding-left: 1.2rem;">
                            @foreach ($errors->all() as $error)
                                <li class="text-muted">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Formulario compacto -->
        <div class="card border-0 shadow-sm" style="border-radius: 10px;">
            <div class="card-body p-3">
                <form action="{{ route('profesor_materia.update', $profesor->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Información del Profesor -->
                    <div class="mb-3">
                        <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center" style="color: #00508f; font-weight: 600; font-size: 0.95rem;">
                            <i class="fas fa-user-tie me-2" style="font-size: 0.9rem;"></i>Información del Profesor
                        </h6>

                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small mb-1">Nombre Completo</label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    value="{{ $profesor->nombre }} {{ $profesor->apellido }}"
                                    readonly
                                    style="background-color: #f8fafc;"
                                >
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold small mb-1">Total de Materias Asignadas</label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    value="{{ count($selectedMaterias) }} materia(s)"
                                    readonly
                                    style="background-color: #f8fafc;"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Selección de Materias -->
                    <div class="mb-3">
                        <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center" style="color: #00508f; font-weight: 600; font-size: 0.95rem;">
                            <i class="fas fa-book-open me-2" style="font-size: 0.9rem;"></i>Materias Asignadas
                        </h6>

                        <div class="row g-2">
                            <div class="col-12">
                                <label class="form-label fw-semibold small mb-1">
                                    Materias <span class="text-danger">*</span>
                                </label>
                                <select
                                    name="materia_ids[]"
                                    multiple
                                    class="form-select form-select-sm @error('materia_ids') is-invalid @enderror"
                                    size="10"
                                    required
                                    style="border: 1.5px solid #e2e8f0; padding: 0.5rem 0.75rem;"
                                >
                                    @foreach($materias as $materia)
                                        <option
                                            value="{{ $materia->id }}"
                                            {{ in_array($materia->id, $selectedMaterias) ? 'selected' : '' }}
                                            style="padding: 0.5rem; margin-bottom: 0.2rem;"
                                        >
                                            {{ $materia->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('materia_ids')
                                <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                                <small class="text-muted" style="font-size: 0.7rem; display: block; margin-top: 0.3rem;">
                                    <i class="fas fa-info-circle me-1"></i>Mantenga presionado Ctrl (Windows) o Cmd (Mac) para seleccionar múltiples materias
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Resumen de selección -->
                    <div class="mb-3">
                        <div class="alert border-0 mb-0" style="border-radius: 8px; background: rgba(78, 199, 210, 0.08); border-left: 3px solid #4ec7d2 !important; font-size: 0.85rem;">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-clipboard-check me-2 mt-1" style="font-size: 0.9rem; color: #00508f;"></i>
                                <div>
                                    <strong style="color: #00508f;">Materias actuales:</strong>
                                    <span class="text-muted"> {{ count($selectedMaterias) }} asignada(s)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones compactos -->
                    <div class="d-flex gap-2 pt-2 border-top">
                        <button type="submit" class="btn btn-sm fw-semibold flex-fill" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); padding: 0.6rem; border-radius: 8px;">
                            <i class="fas fa-save me-1"></i>Actualizar Asignación
                        </button>
                        <a href="{{ route('profesor_materia.index') }}" class="btn btn-sm fw-semibold flex-fill" style="border: 2px solid #00508f; color: #00508f; background: white; padding: 0.6rem; border-radius: 8px;">
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
                    <span class="text-muted"> Los cambios se aplicarán inmediatamente. Puede quitar materias deseleccionándolas.</span>
                </div>
            </div>
        </div>

    </div>

    @push('styles')
        <style>
            .form-control-sm, .form-select-sm {
                border-radius: 6px;
                border: 1.5px solid #e2e8f0;
                padding: 0.5rem 0.75rem;
                transition: all 0.3s ease;
                font-size: 0.875rem;
            }

            .form-control-sm:focus, .form-select-sm:focus {
                border-color: #4ec7d2;
                box-shadow: 0 0 0 0.15rem rgba(78, 199, 210, 0.15);
            }

            .form-select-sm[multiple] {
                background-image: none;
            }

            .form-select-sm option {
                padding: 0.5rem;
                border-radius: 4px;
            }

            .form-select-sm option:hover {
                background-color: rgba(78, 199, 210, 0.1);
            }

            .form-select-sm[multiple] option:checked {
                background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
                color: white;
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

            .border-bottom, .border-top {
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
