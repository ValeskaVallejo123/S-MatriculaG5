@extends('layouts.app')

@section('title', 'Asignar Materias a Profesor')

@section('page-title', 'Asignar Materias')

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
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3" style="width: 45px; height: 45px; background: rgba(78, 199, 210, 0.3); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-chalkboard-teacher text-white" style="font-size: 1.3rem;"></i>
                    </div>
                    <div class="text-white">
                        <h5 class="mb-0 fw-bold" style="font-size: 1.1rem;">Asignar Materias a Profesor</h5>
                        <p class="mb-0 opacity-90" style="font-size: 0.8rem;">Seleccione el profesor y las materias que impartirá</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulario compacto -->
        <div class="card border-0 shadow-sm" style="border-radius: 10px;">
            <div class="card-body p-3">
                <form action="{{ route('profesor_materia.store') }}" method="POST">
                    @csrf

                    <!-- Selección de Profesor -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user-tie" style="color: white; font-size: 0.9rem;"></i>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color: #003b73; font-size: 1rem;">Seleccionar Profesor</h6>
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="profesor_id" class="form-label small fw-semibold" style="color: #003b73;">
                                    Profesor <span style="color: #ef4444;">*</span>
                                </label>
                                <div class="position-relative">
                                    <i class="fas fa-user-tie position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem; z-index: 10;"></i>
                                    <select class="form-select ps-5 @error('profesor_id') is-invalid @enderror"
                                            id="profesor_id"
                                            name="profesor_id"
                                            required
                                            style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                        <option value="">Seleccione un profesor...</option>
                                        @foreach($profesores as $profesor)
                                            <option value="{{ $profesor->id }}" {{ old('profesor_id') == $profesor->id ? 'selected' : '' }}>
                                                {{ $profesor->nombre }} {{ $profesor->apellido }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('profesor_id')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <small class="text-muted" style="font-size: 0.75rem; display: block; margin-top: 0.3rem;">
                                    <i class="fas fa-info-circle me-1"></i>Seleccione el profesor al que desea asignar materias
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Selección de Materias -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-book-open" style="color: white; font-size: 0.9rem;"></i>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color: #003b73; font-size: 1rem;">Seleccionar Materias</h6>
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="materia_ids" class="form-label small fw-semibold" style="color: #003b73;">
                                    Materias <span style="color: #ef4444;">*</span>
                                </label>
                                <div class="position-relative">
                                    <i class="fas fa-book-open position-absolute" style="left: 12px; top: 18px; color: #00508f; font-size: 0.85rem; z-index: 10;"></i>
                                    <select class="form-select ps-5 @error('materia_ids') is-invalid @enderror"
                                            id="materia_ids"
                                            name="materia_ids[]"
                                            multiple
                                            required
                                            size="8"
                                            style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease; background-image: none;">
                                        @foreach($materias as $materia)
                                            <option value="{{ $materia->id }}"
                                                    {{ (is_array(old('materia_ids')) && in_array($materia->id, old('materia_ids'))) ? 'selected' : '' }}
                                                    style="padding: 0.5rem 0.5rem; margin-bottom: 0.2rem; cursor: pointer;">
                                                {{ $materia->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('materia_ids')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <small class="text-muted" style="font-size: 0.75rem; display: block; margin-top: 0.3rem;">
                                    <i class="fas fa-info-circle me-1"></i>Mantenga presionado Ctrl (Windows) o Cmd (Mac) para seleccionar múltiples materias
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Botones compactos -->
                    <div class="d-flex gap-2 pt-2 border-top">
                        <button type="submit" class="btn btn-sm fw-semibold flex-fill" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); padding: 0.6rem; border-radius: 8px;">
                            <i class="fas fa-check me-1"></i>Asignar Materias
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
                    <strong style="color: #00508f;">Información importante:</strong>
                    <span class="text-muted"> Puede asignar múltiples materias a un profesor. Las asignaciones se reflejarán inmediatamente en el sistema.</span>
                </div>
            </div>
        </div>

    </div>

    @push('styles')
        <style>
            .form-control, .form-select {
                border-radius: 8px;
                border: 2px solid #bfd9ea;
                transition: all 0.3s ease;
                font-size: 0.875rem;
            }

            .form-select {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2300508f' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
                background-repeat: no-repeat;
                background-position: right 0.75rem center;
                background-size: 1.5em 1.5em;
            }

            .form-select[multiple] {
                background-image: none;
            }

            .form-control:focus, .form-select:focus {
                border-color: #4ec7d2;
                box-shadow: 0 0 0 0.2rem rgba(78, 199, 210, 0.15);
                outline: none;
            }

            .form-select option {
                padding: 0.5rem;
                border-radius: 4px;
            }

            .form-select option:hover {
                background-color: rgba(78, 199, 210, 0.1);
            }

            .form-select[multiple] option:checked {
                background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
                color: white;
                font-weight: 600;
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

            .border-top {
                border-color: rgba(0, 80, 143, 0.15) !important;
            }

            .invalid-feedback {
                display: block;
                color: #dc3545;
                font-size: 0.75rem;
                margin-top: 0.25rem;
            }

            small.text-muted {
                color: #64748b;
            }
        </style>
    @endpush
@endsection
