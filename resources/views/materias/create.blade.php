@extends('layouts.app')

@section('title', 'Nueva Materia')

@section('page-title', 'Crear Nueva Materia')

@section('topbar-actions')
    <a href="{{ route('materias.index') }}" class="btn-back" style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #00508f; box-shadow: 0 2px 8px rgba(0, 80, 143, 0.2); font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 900px;">

    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-header" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 12px 12px 0 0; padding: 1.2rem;">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-book-medical"></i> Formulario de Nueva Materia
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('materias.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <!-- Nivel Educativo -->
                    <div class="col-md-6">
                        <label for="nivel" class="form-label fw-semibold" style="color: #003b73;">
                            <i class="fas fa-layer-group text-primary"></i> Nivel Educativo *
                        </label>
                        <select class="form-select @error('nivel') is-invalid @enderror" 
                                id="nivel" 
                                name="nivel"
                                required
                                style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem;">
                            <option value="">Seleccionar nivel...</option>
                            <option value="primaria" {{ old('nivel') == 'primaria' ? 'selected' : '' }}>
                                 Primaria (1° - 6° Grado)
                            </option>
                            <option value="secundaria" {{ old('nivel') == 'secundaria' ? 'selected' : '' }}>
                                 Secundaria (7° - 9° Grado)
                            </option>
                        </select>
                        @error('nivel')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nombre de la Materia -->
                    <div class="col-md-6">
                        <label for="nombre" class="form-label fw-semibold" style="color: #003b73;">
                            <i class="fas fa-book text-success"></i> Nombre de la Materia *
                        </label>
                        <input type="text" 
                               class="form-control @error('nombre') is-invalid @enderror" 
                               id="nombre" 
                               name="nombre" 
                               value="{{ old('nombre') }}"
                               placeholder="Ej: Matemáticas"
                               required
                               style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem;">
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Código -->
                    <div class="col-md-6">
                        <label for="codigo" class="form-label fw-semibold" style="color: #003b73;">
                            <i class="fas fa-barcode text-info"></i> Código *
                        </label>
                        <input type="text" 
                               class="form-control @error('codigo') is-invalid @enderror" 
                               id="codigo" 
                               name="codigo" 
                               value="{{ old('codigo') }}"
                               placeholder="Ej: MAT-P1 o MAT-S7"
                               required
                               style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem; font-family: monospace;">
                        <small class="text-muted">Sugerencia: MAT-P1 (Matemáticas Primaria 1°) o MAT-S7 (Matemáticas Secundaria 7°)</small>
                        @error('codigo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Área -->
                    <div class="col-md-6">
                        <label for="area" class="form-label fw-semibold" style="color: #003b73;">
                            <i class="fas fa-shapes text-warning"></i> Área *
                        </label>
                        <select class="form-select @error('area') is-invalid @enderror" 
                                id="area" 
                                name="area"
                                required
                                style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem;">
                            <option value="">Seleccionar área...</option>
                            <option value="Matemáticas" {{ old('area') == 'Matemáticas' ? 'selected' : '' }}> Matemáticas</option>
                            <option value="Español" {{ old('area') == 'Español' ? 'selected' : '' }}> Español</option>
                            <option value="Ciencias Naturales" {{ old('area') == 'Ciencias Naturales' ? 'selected' : '' }}> Ciencias Naturales</option>
                            <option value="Ciencias Sociales" {{ old('area') == 'Ciencias Sociales' ? 'selected' : '' }}> Ciencias Sociales</option>
                            <option value="Educación Física" {{ old('area') == 'Educación Física' ? 'selected' : '' }}> Educación Física</option>
                            <option value="Educación Artística" {{ old('area') == 'Educación Artística' ? 'selected' : '' }}> Educación Artística</option>
                            <option value="Inglés" {{ old('area') == 'Inglés' ? 'selected' : '' }}> Inglés</option>
                            <option value="Informática" {{ old('area') == 'Informática' ? 'selected' : '' }}> Informática</option>
                            <option value="Formación Ciudadana" {{ old('area') == 'Formación Ciudadana' ? 'selected' : '' }}> Formación Ciudadana</option>
                        </select>
                        @error('area')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Descripción -->
                    <div class="col-12">
                        <label for="descripcion" class="form-label fw-semibold" style="color: #003b73;">
                            <i class="fas fa-align-left text-secondary"></i> Descripción
                        </label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                  id="descripcion" 
                                  name="descripcion" 
                                  rows="3"
                                  placeholder="Descripción opcional de la materia..."
                                  style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem;">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Estado Activo -->
                    <div class="col-12">
                        <div class="form-check form-switch" style="padding-left: 2.5rem;">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="activo" 
                                   name="activo" 
                                   value="1"
                                   {{ old('activo', true) ? 'checked' : '' }}
                                   style="width: 3rem; height: 1.5rem; cursor: pointer;">
                            <label class="form-check-label fw-semibold" for="activo" style="color: #003b73; margin-left: 0.5rem;">
                                <i class="fas fa-toggle-on text-success"></i> Materia Activa
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="d-flex gap-2 mt-4 pt-3 border-top">
                    <button type="submit" class="btn flex-fill" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 8px; padding: 0.7rem; font-weight: 600; border: none;">
                        <i class="fas fa-save"></i> Guardar Materia
                    </button>
                    <a href="{{ route('materias.index') }}" class="btn flex-fill" style="background: white; color: #6b7280; border: 2px solid #e5e7eb; border-radius: 8px; padding: 0.7rem; font-weight: 600;">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>

@push('styles')
<style>
    .form-control:focus, .form-select:focus {
        border-color: #4ec7d2;
        box-shadow: 0 0 0 0.2rem rgba(78, 199, 210, 0.15);
        outline: none;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-back:hover {
        background: #00508f !important;
        color: white !important;
        transform: translateY(-2px);
    }
</style>
@endpush

@endsection