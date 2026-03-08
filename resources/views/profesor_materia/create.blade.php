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

        <div class="card border-0 shadow-sm mb-3" style="background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 10px;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3" style="width: 45px; height: 45px; background: rgba(78, 199, 210, 0.3); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-chalkboard-teacher text-white" style="font-size: 1.3rem;"></i>
                    </div>
                    <div class="text-white">
                        <h5 class="mb-0 fw-bold" style="font-size: 1.1rem;">Nueva Asignación Académica</h5>
                        <p class="mb-0 opacity-90" style="font-size: 0.8rem;">Configure la relación entre profesor, grado y materias</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius: 10px;">
            <div class="card-body p-4">
                <form action="{{ route('profesor_materia.store') }}" method="POST">
                    @csrf

                    <div class="mb-5">
                        <div class="d-flex align-items-center gap-2 mb-4">
                            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-cog" style="color: white; font-size: 0.9rem;"></i>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color: #003b73; font-size: 1.1rem;">1. Detalles de la Asignación</h6>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="profesor_id" class="form-label fw-semibold">Profesor <span class="text-danger">*</span></label>
                                <div class="position-relative">
                                    <i class="fas fa-user-tie position-absolute" style="left: 15px; top: 50%; transform: translateY(-50%); color: #00508f; z-index: 5;"></i>
                                    <select class="form-select ps-5 @error('profesor_id') is-invalid @enderror"
                                            id="profesor_id" name="profesor_id" required>
                                        <option value="">Seleccione un profesor...</option>
                                        @foreach($profesores as $profesor)
                                            <option value="{{ $profesor->id }}" {{ old('profesor_id') == $profesor->id ? 'selected' : '' }}>
                                                {{ $profesor->nombre }} {{ $profesor->apellido }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('profesor_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="grado_id" class="form-label fw-semibold">Grado <span class="text-danger">*</span></label>
                                <div class="position-relative">
                                    <i class="fas fa-graduation-cap position-absolute" style="left: 15px; top: 50%; transform: translateY(-50%); color: #00508f; z-index: 5;"></i>
                                    <select class="form-select ps-5 @error('grado_id') is-invalid @enderror"
                                            id="grado_id" name="grado_id" required>
                                        <option value="">Seleccione grado...</option>
                                        @foreach($grados as $grado)
                                            <option value="{{ $grado->id }}" {{ old('grado_id') == $grado->id ? 'selected' : '' }}>
                                                {{ $grado->nombre }} ({{ $grado->nivel }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label for="seccion" class="form-label fw-semibold">Sección <span class="text-danger">*</span></label>
                                <div class="position-relative">
                                    <i class="fas fa-layer-group position-absolute" style="left: 15px; top: 50%; transform: translateY(-50%); color: #00508f; z-index: 5;"></i>
                                    <select class="form-select ps-5 @error('seccion') is-invalid @enderror"
                                            id="seccion" name="seccion" required>
                                        <option value="A" {{ old('seccion') == 'A' ? 'selected' : '' }}>A</option>
                                        <option value="B" {{ old('seccion') == 'B' ? 'selected' : '' }}>B</option>
                                        <option value="C" {{ old('seccion') == 'C' ? 'selected' : '' }}>C</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-4">
                            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-book-open" style="color: white; font-size: 0.9rem;"></i>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color: #003b73; font-size: 1.1rem;">2. Selección de Materias</h6>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Materias disponibles <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <i class="fas fa-list-check position-absolute" style="left: 15px; top: 20px; color: #00508f; z-index: 5;"></i>
                                <select class="form-select ps-5 @error('materia_ids') is-invalid @enderror"
                                        id="materia_ids" name="materia_ids[]" multiple required size="10">
                                    @foreach($materias as $materia)
                                        <option value="{{ $materia->id }}"
                                            {{ (is_array(old('materia_ids')) && in_array($materia->id, old('materia_ids'))) ? 'selected' : '' }}>
                                            {{ $materia->nombre }} ({{ $materia->nivel }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <small class="text-muted mt-2 d-block">
                                <i class="fas fa-info-circle me-1"></i> Use <strong>Ctrl + Click</strong> para seleccionar varias materias a la vez.
                            </small>
                            @error('materia_ids') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-3 pt-4 border-top">
                        <button type="submit" class="btn fw-bold flex-fill py-3" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(78, 199, 210, 0.3);">
                            <i class="fas fa-save me-2"></i> Guardar Asignación
                        </button>
                        <a href="{{ route('profesor_materia.index') }}" class="btn fw-bold flex-fill py-3" style="border: 2px solid #00508f; color: #00508f; background: white; border-radius: 12px;">
                            <i class="fas fa-times me-2"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </div>

    @push('styles')
        <style>
            .form-select {
                border: 2px solid #bfd9ea;
                border-radius: 10px;
                padding: 0.7rem 1rem;
                transition: all 0.3s ease;
            }
            .form-select:focus {
                border-color: #4ec7d2;
                box-shadow: 0 0 0 0.25rem rgba(78, 199, 210, 0.1);
            }
            .form-select[multiple] option {
                padding: 10px 15px;
                margin-bottom: 2px;
                border-radius: 5px;
            }
            .form-select[multiple] option:checked {
                background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%) !important;
                color: white;
            }
            .btn:hover {
                transform: translateY(-2px);
                opacity: 0.9;
            }
        </style>
    @endpush
@endsection
