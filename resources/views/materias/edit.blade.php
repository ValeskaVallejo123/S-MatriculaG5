@extends('layouts.app')

@section('title', 'Editar Materia')

@section('page-title', 'Editar Materia')

@section('topbar-actions')
    <a href="{{ route('materias.index') }}" class="btn-back" style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #4ec7d2; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 900px;">
    
    <!-- Header compacto -->
    <div class="card border-0 shadow-sm mb-3" style="background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%); border-radius: 10px;">
        <div class="card-body p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3" style="width: 45px; height: 45px; background: rgba(255, 255, 255, 0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-book text-white" style="font-size: 1.3rem;"></i>
                    </div>
                    <div class="text-white">
                        <h5 class="mb-0 fw-bold" style="font-size: 1.1rem;">Editar Materia</h5>
                        <p class="mb-0 opacity-90" style="font-size: 0.8rem;">Actualice la información necesaria</p>
                    </div>
                </div>
                <div style="background: rgba(255, 255, 255, 0.2); padding: 0.4rem 0.8rem; border-radius: 6px;">
                    <p class="text-white mb-0 small fw-semibold" style="font-size: 0.8rem;">ID: #{{ $materia->id }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario compacto -->
    <div class="card border-0 shadow-sm" style="border-radius: 10px;">
        <div class="card-body p-3">
            <form action="{{ route('materias.update', $materia) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Información Básica -->
                <div class="mb-3">
                    <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center" style="color: #00508f; font-weight: 600; font-size: 0.95rem;">
                        <i class="fas fa-info-circle me-2" style="font-size: 0.9rem;"></i>Información Básica
                    </h6>

                    <div class="row g-2">
                        <!-- Nivel Educativo -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small mb-1">
                                Nivel Educativo <span class="text-danger">*</span>
                            </label>
                            <select name="nivel" class="form-select form-select-sm @error('nivel') is-invalid @enderror" required>
                                <option value="">Seleccione...</option>
                                <option value="primaria" {{ old('nivel', $materia->nivel) == 'primaria' ? 'selected' : '' }}> Primaria</option>
                                <option value="secundaria" {{ old('nivel', $materia->nivel) == 'secundaria' ? 'selected' : '' }}> Secundaria</option>
                            </select>
                            @error('nivel')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nombre de Materia -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small mb-1">
                                Nombre de la Materia <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="nombre" 
                                   value="{{ old('nombre', $materia->nombre) }}" 
                                   class="form-control form-control-sm @error('nombre') is-invalid @enderror" 
                                   placeholder="Ej: Matemáticas" 
                                   required
                            >
                            @error('nombre')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Código -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small mb-1">
                                Código <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="codigo" 
                                   value="{{ old('codigo', $materia->codigo) }}" 
                                   class="form-control form-control-sm @error('codigo') is-invalid @enderror" 
                                   placeholder="Ej: MAT-101" 
                                   required
                            >
                            @error('codigo')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Área de Conocimiento -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small mb-1">
                                Área de Conocimiento <span class="text-danger">*</span>
                            </label>
                            <select name="area" class="form-select form-select-sm @error('area') is-invalid @enderror" required>
                                <option value="">Seleccione...</option>
                                <option value="Matemáticas" {{ old('area', $materia->area) == 'Matemáticas' ? 'selected' : '' }}> Matemáticas</option>
                                <option value="Español" {{ old('area', $materia->area) == 'Español' ? 'selected' : '' }}> Español</option>
                                <option value="Ciencias Naturales" {{ old('area', $materia->area) == 'Ciencias Naturales' ? 'selected' : '' }}> Ciencias Naturales</option>
                                <option value="Ciencias Sociales" {{ old('area', $materia->area) == 'Ciencias Sociales' ? 'selected' : '' }}> Ciencias Sociales</option>
                                <option value="Educación Física" {{ old('area', $materia->area) == 'Educación Física' ? 'selected' : '' }}> Educación Física</option>
                                <option value="Educación Artística" {{ old('area', $materia->area) == 'Educación Artística' ? 'selected' : '' }}> Educación Artística</option>
                                <option value="Inglés" {{ old('area', $materia->area) == 'Inglés' ? 'selected' : '' }}>🇬🇧 Inglés</option>
                                <option value="Informática" {{ old('area', $materia->area) == 'Informática' ? 'selected' : '' }}> Informática</option>
                                <option value="Formación Ciudadana" {{ old('area', $materia->area) == 'Formación Ciudadana' ? 'selected' : '' }}> Formación Ciudadana</option>
                            </select>
                            @error('area')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Detalles Adicionales -->
                <div class="mb-3">
                    <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center" style="color: #00508f; font-weight: 600; font-size: 0.95rem;">
                        <i class="fas fa-clipboard me-2" style="font-size: 0.9rem;"></i>Detalles Adicionales
                    </h6>
                    <div class="row g-2">
                        <div class="col-12">
                            <label class="form-label fw-semibold small mb-1">Descripción</label>
                            <textarea name="descripcion" rows="3" class="form-control form-control-sm @error('descripcion') is-invalid @enderror" placeholder="Descripción de la materia">{{ old('descripcion', $materia->descripcion) }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="d-flex gap-2 pt-2 border-top">
                    <button type="submit" class="btn btn-sm fw-semibold flex-fill" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; padding: 0.6rem; border-radius: 8px;">
                        <i class="fas fa-save me-1"></i>Actualizar Materia
                    </button>
                    <a href="{{ route('materias.index') }}" class="btn btn-sm fw-semibold flex-fill" style="border: 2px solid #4ec7d2; color: #00508f; background: white; padding: 0.6rem; border-radius: 8px;">
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
        font-size: 0.875rem;
        transition: all 0.3s ease;
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
    .btn-back:hover {
        background: #00508f !important;
        color: white !important;
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }
    .btn:hover {
        transform: translateY(-2px);
    }
    .border-bottom {
        border-color: rgba(0, 80, 143, 0.15) !important;
    }
</style>
@endpush
@endsection
