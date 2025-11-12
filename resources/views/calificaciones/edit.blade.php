@extends('layouts.app')

@section('title', 'Editar Calificación')

@section('page-title', 'Editar Calificación')

@section('topbar-actions')
    <a href="{{ route('calificaciones.index') }}" class="btn-back" style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #00508f; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 1000px;">

    <!-- Encabezado -->
    <div class="card border-0 shadow-sm mb-3" style="background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 10px;">
        <div class="card-body p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3" style="width: 45px; height: 45px; background: rgba(78, 199, 210, 0.3); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-edit text-white" style="font-size: 1.3rem;"></i>
                    </div>
                    <div class="text-white">
                        <h5 class="mb-0 fw-bold" style="font-size: 1.1rem;">Editar Calificación</h5>
                        <p class="mb-0 opacity-90" style="font-size: 0.8rem;">Actualice las notas del alumno</p>
                    </div>
                </div>
                <div style="background: rgba(78, 199, 210, 0.2); padding: 0.4rem 0.8rem; border-radius: 6px;">
                    <p class="text-white mb-0 small fw-semibold" style="font-size: 0.8rem;">ID: #{{ $calificacion->id }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario -->
    <div class="card border-0 shadow-sm" style="border-radius: 10px;">
        <div class="card-body p-3">
            <form action="{{ route('calificaciones.update', $calificacion) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Información General -->
                <div class="mb-3">
                    <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center" style="color: #00508f; font-weight: 600; font-size: 0.95rem;">
                        <i class="fas fa-user me-2" style="font-size: 0.9rem;"></i>Información General
                    </h6>

                    <div class="row g-2">
                        <div class="col-md-12">
                            <label class="form-label fw-semibold small mb-1">Nombre del Alumno <span class="text-danger">*</span></label>
                            <input 
                                type="text"
                                name="nombre_alumno"
                                value="{{ old('nombre_alumno', $calificacion->nombre_alumno) }}"
                                class="form-control form-control-sm @error('nombre_alumno') is-invalid @enderror"
                                placeholder="Ej: Juan Pérez López"
                                required
                            >
                            @error('nombre_alumno')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Calificaciones -->
                <div class="mb-3">
                    <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center" style="color: #00508f; font-weight: 600; font-size: 0.95rem;">
                        <i class="fas fa-star me-2" style="font-size: 0.9rem;"></i>Calificaciones (0.00 - 100.00)
                    </h6>

                    <div class="row g-2">
                        @foreach(['primer' => '1er', 'segundo' => '2do', 'tercer' => '3er', 'cuarto' => '4to'] as $key => $label)
                        <div class="col-md-3 col-sm-6">
                            <label class="form-label fw-semibold small mb-1">{{ $label }} Parcial</label>
                            <input 
                                type="number" 
                                name="{{ $key }}_parcial" 
                                value="{{ old($key.'_parcial', $calificacion->{$key.'_parcial'}) }}"
                                step="0.01"
                                min="0"
                                max="100"
                                placeholder="0.00"
                                class="form-control form-control-sm text-center @error($key.'_parcial') is-invalid @enderror"
                            >
                            @error($key.'_parcial')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Recuperación -->
                <div class="mb-3">
                    <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center" style="color: #00508f; font-weight: 600; font-size: 0.95rem;">
                        <i class="fas fa-undo me-2" style="font-size: 0.9rem;"></i>Recuperación
                    </h6>

                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small mb-1">Nota de Recuperación (Opcional)</label>
                            <input 
                                type="number"
                                name="recuperacion"
                                value="{{ old('recuperacion', $calificacion->recuperacion) }}"
                                step="0.01"
                                min="0"
                                max="100"
                                placeholder="0.00"
                                class="form-control form-control-sm text-center @error('recuperacion') is-invalid @enderror"
                            >
                            @error('recuperacion')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Ingrese la nota solo si el alumno realizó recuperación.</small>
                        </div>
                    </div>
                </div>

                <!-- Aviso -->
                <div class="alert border-0 mt-2 py-2 px-3" style="border-radius: 8px; background: rgba(78, 199, 210, 0.1); border-left: 3px solid #4ec7d2 !important; font-size: 0.85rem;">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-info-circle me-2 mt-1" style="font-size: 0.9rem; color: #00508f;"></i>
                        <div>
                            <strong style="color: #00508f;">Importante:</strong>
                            <span class="text-muted"> La nota final se recalculará automáticamente al guardar los cambios.</span>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="d-flex gap-2 pt-2 border-top">
                    <button type="submit" class="btn btn-sm fw-semibold flex-fill" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); padding: 0.6rem; border-radius: 8px;">
                        <i class="fas fa-save me-1"></i>Actualizar Calificación
                    </button>
                    <a href="{{ route('calificaciones.index') }}" class="btn btn-sm fw-semibold flex-fill" style="border: 2px solid #00508f; color: #00508f; background: white; padding: 0.6rem; border-radius: 8px;">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </a>
                </div>
            </form>
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

    .border-bottom {
        border-color: rgba(0, 80, 143, 0.15) !important;
    }
</style>
@endpush
@endsection
