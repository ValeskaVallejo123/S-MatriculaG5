@extends('layouts.app')

@section('title', 'Asignar Profesor a Grado')

@section('page-title', 'Nueva Asignación')

@section('topbar-actions')
    <a href="{{ route('profesor_materia.index') }}" class="btn-back"
       style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none;
              font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease;
              border: 2px solid #00508f; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 760px;">

    {{-- Header --}}
    <div class="card border-0 shadow-sm mb-3"
         style="background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 10px;">
        <div class="card-body p-3 d-flex align-items-center">
            <div style="width: 45px; height: 45px; background: rgba(78,199,210,0.3); border-radius: 10px;
                        display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                <i class="fas fa-chalkboard-teacher text-white" style="font-size: 1.3rem;"></i>
            </div>
            <div class="text-white">
                <h5 class="mb-0 fw-bold" style="font-size: 1.1rem;">Asignar Profesor a Grado</h5>
                <p class="mb-0 opacity-90" style="font-size: 0.8rem;">
                    Seleccione el profesor, la materia, el grado y la sección
                </p>
            </div>
        </div>
    </div>

    {{-- Formulario --}}
    <div class="card border-0 shadow-sm" style="border-radius: 10px;">
        <div class="card-body p-4">
            <form action="{{ route('profesor_materia.store') }}" method="POST">
                @csrf

                {{-- Profesor --}}
                <div class="mb-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
                                    border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user-tie" style="color: white; font-size: 0.9rem;"></i>
                        </div>
                        <h6 class="mb-0 fw-bold" style="color: #003b73;">Profesor</h6>
                    </div>

                    <label for="profesor_id" class="form-label">
                        Profesor <span style="color: #ef4444;">*</span>
                    </label>
                    <div class="position-relative">
                        <i class="fas fa-user-tie position-absolute"
                           style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem; z-index: 10;"></i>
                        <select class="form-select ps-5 @error('profesor_id') is-invalid @enderror"
                                id="profesor_id" name="profesor_id" required>
                            <option value="">Seleccione un profesor...</option>
                            @foreach($profesores as $profesor)
                                <option value="{{ $profesor->id }}"
                                    {{ old('profesor_id') == $profesor->id ? 'selected' : '' }}>
                                    {{ $profesor->nombre }} {{ $profesor->apellido }}
                                </option>
                            @endforeach
                        </select>
                        @error('profesor_id')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                {{-- Materia --}}
                <div class="mb-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
                                    border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-book-open" style="color: white; font-size: 0.9rem;"></i>
                        </div>
                        <h6 class="mb-0 fw-bold" style="color: #003b73;">Materia</h6>
                    </div>

                    <label for="materia_id" class="form-label">
                        Materia <span style="color: #ef4444;">*</span>
                    </label>
                    <div class="position-relative">
                        <i class="fas fa-book-open position-absolute"
                           style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem; z-index: 10;"></i>
                        <select class="form-select ps-5 @error('materia_id') is-invalid @enderror"
                                id="materia_id" name="materia_id" required>
                            <option value="">Seleccione una materia...</option>
                            @foreach($materias as $materia)
                                <option value="{{ $materia->id }}"
                                    {{ old('materia_id') == $materia->id ? 'selected' : '' }}>
                                    {{ $materia->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('materia_id')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                {{-- Grado y Sección --}}
                <div class="mb-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
                                    border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-layer-group" style="color: white; font-size: 0.9rem;"></i>
                        </div>
                        <h6 class="mb-0 fw-bold" style="color: #003b73;">Grado y Sección</h6>
                    </div>

                    <div class="row g-3">
                        {{-- Grado --}}
                        <div class="col-md-8">
                            <label for="grado_id" class="form-label">
                                Grado <span style="color: #ef4444;">*</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-layer-group position-absolute"
                                   style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem; z-index: 10;"></i>
                                <select class="form-select ps-5 @error('grado_id') is-invalid @enderror"
                                        id="grado_id" name="grado_id" required>
                                    <option value="">Seleccione un grado...</option>
                                    @foreach($grados as $grado)
                                        <option value="{{ $grado->id }}"
                                            {{ old('grado_id') == $grado->id ? 'selected' : '' }}>
                                            {{ $grado->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('grado_id')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Sección --}}
                        <div class="col-md-4">
                            <label for="seccion" class="form-label">
                                Sección <span style="color: #ef4444;">*</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-tag position-absolute"
                                   style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem; z-index: 10;"></i>
                                <select class="form-select ps-5 @error('seccion') is-invalid @enderror"
                                        id="seccion" name="seccion" required>
                                    <option value="">Sección...</option>
                                    @foreach($secciones as $sec)
                                        <option value="{{ $sec }}"
                                            {{ old('seccion') == $sec ? 'selected' : '' }}>
                                            Sección {{ $sec }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('seccion')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Botones --}}
                <div class="d-flex gap-2 pt-3 border-top">
                    <button type="submit" class="btn btn-sm fw-semibold flex-fill"
                            style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white;
                                   border: none; box-shadow: 0 2px 8px rgba(78,199,210,0.3); padding: 0.65rem; border-radius: 8px;">
                        <i class="fas fa-check me-1"></i> Guardar Asignación
                    </button>
                    <a href="{{ route('profesor_materia.index') }}" class="btn btn-sm fw-semibold flex-fill"
                       style="border: 2px solid #00508f; color: #00508f; background: white; padding: 0.65rem; border-radius: 8px;">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Nota --}}
    <div class="alert border-0 mt-2 py-2 px-3"
         style="border-radius: 8px; background: rgba(78,199,210,0.1); border-left: 3px solid #4ec7d2 !important; font-size: 0.85rem;">
        <div class="d-flex align-items-start">
            <i class="fas fa-info-circle me-2 mt-1" style="color: #00508f;"></i>
            <div>
                <strong style="color: #00508f;">Nota:</strong>
                <span class="text-muted"> Cada asignación vincula un profesor con una materia, un grado y una sección específica.</span>
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
    .form-control:focus, .form-select:focus {
        border-color: #4ec7d2;
        box-shadow: 0 0 0 0.2rem rgba(78,199,210,0.15);
        outline: none;
    }
    .form-label { color: #003b73; font-size: 0.85rem; margin-bottom: 0.3rem; }
    .btn:hover { transform: translateY(-2px); transition: all 0.3s ease; }
    .btn-back:hover { background: #00508f !important; color: white !important; }
    .border-top { border-color: rgba(0,80,143,0.15) !important; }
    .invalid-feedback { display: block; color: #dc3545; font-size: 0.75rem; margin-top: 0.25rem; }
</style>
@endpush
@endsection