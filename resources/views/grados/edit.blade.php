@extends('layouts.app')

@section('title', 'Editar Grado')

@section('page-title', 'Editar Grado')

@section('topbar-actions')
    <a href="{{ route('grados.index') }}" class="btn-back" style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #00508f; box-shadow: 0 2px 8px rgba(0, 80, 143, 0.2); font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 900px;">

    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-header" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; border-radius: 12px 12px 0 0; padding: 1.2rem;">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-edit"></i> Editar Grado: {{ $grado->numero }}° {{ $grado->seccion ? 'Sección ' . $grado->seccion : '' }}
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('grados.update', $grado) }}" method="POST">
                @csrf
                @method('PUT')

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
                            <option value="primaria" {{ old('nivel', $grado->nivel) == 'primaria' ? 'selected' : '' }}>
                                🎒 Primaria (1° - 6° Grado)
                            </option>
                            <option value="secundaria" {{ old('nivel', $grado->nivel) == 'secundaria' ? 'selected' : '' }}>
                                🎓 Secundaria (7° - 9° Grado)
                            </option>
                        </select>
                        @error('nivel')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Número de Grado -->
                    <div class="col-md-6">
                        <label for="numero" class="form-label fw-semibold" style="color: #003b73;">
                            <i class="fas fa-sort-numeric-up text-success"></i> Número de Grado *
                        </label>
                        <select class="form-select @error('numero') is-invalid @enderror" 
                                id="numero" 
                                name="numero"
                                required
                                style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem;">
                            <option value="">Seleccionar grado...</option>
                            <option value="1" {{ old('numero', $grado->numero) == 1 ? 'selected' : '' }}>1° Grado</option>
                            <option value="2" {{ old('numero', $grado->numero) == 2 ? 'selected' : '' }}>2° Grado</option>
                            <option value="3" {{ old('numero', $grado->numero) == 3 ? 'selected' : '' }}>3° Grado</option>
                            <option value="4" {{ old('numero', $grado->numero) == 4 ? 'selected' : '' }}>4° Grado</option>
                            <option value="5" {{ old('numero', $grado->numero) == 5 ? 'selected' : '' }}>5° Grado</option>
                            <option value="6" {{ old('numero', $grado->numero) == 6 ? 'selected' : '' }}>6° Grado</option>
                            <option value="7" {{ old('numero', $grado->numero) == 7 ? 'selected' : '' }}>7° Grado</option>
                            <option value="8" {{ old('numero', $grado->numero) == 8 ? 'selected' : '' }}>8° Grado</option>
                            <option value="9" {{ old('numero', $grado->numero) == 9 ? 'selected' : '' }}>9° Grado</option>
                        </select>
                        @error('numero')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Sección -->
                    <div class="col-md-6">
                        <label for="seccion" class="form-label fw-semibold" style="color: #003b73;">
                            <i class="fas fa-list-ol text-info"></i> Sección
                        </label>
                        <select class="form-select @error('seccion') is-invalid @enderror" 
                                id="seccion" 
                                name="seccion"
                                style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem;">
                            <option value="">Sin sección</option>
                            <option value="A" {{ old('seccion', $grado->seccion) == 'A' ? 'selected' : '' }}>Sección A</option>
                            <option value="B" {{ old('seccion', $grado->seccion) == 'B' ? 'selected' : '' }}>Sección B</option>
                            <option value="C" {{ old('seccion', $grado->seccion) == 'C' ? 'selected' : '' }}>Sección C</option>
                            <option value="D" {{ old('seccion', $grado->seccion) == 'D' ? 'selected' : '' }}>Sección D</option>
                            <option value="E" {{ old('seccion', $grado->seccion) == 'E' ? 'selected' : '' }}>Sección E</option>
                        </select>
                        @error('seccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Año Lectivo -->
                    <div class="col-md-6">
                        <label for="anio_lectivo" class="form-label fw-semibold" style="color: #003b73;">
                            <i class="fas fa-calendar-alt text-warning"></i> Año Lectivo *
                        </label>
                        <input type="number" 
                               class="form-control @error('anio_lectivo') is-invalid @enderror" 
                               id="anio_lectivo" 
                               name="anio_lectivo" 
                               value="{{ old('anio_lectivo', $grado->anio_lectivo) }}"
                               min="2020"
                               max="2100"
                               required
                               style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem;">
                        @error('anio_lectivo')
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
                                   {{ old('activo', $grado->activo) ? 'checked' : '' }}
                                   style="width: 3rem; height: 1.5rem; cursor: pointer;">
                            <label class="form-check-label fw-semibold" for="activo" style="color: #003b73; margin-left: 0.5rem;">
                                <i class="fas fa-toggle-on text-success"></i> Grado Activo
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Información adicional -->
                <div class="alert alert-info mt-3 d-flex align-items-start" style="border-radius: 8px; border-left: 4px solid #4ec7d2; background: rgba(78, 199, 210, 0.1);">
                    <i class="fas fa-info-circle me-2 mt-1" style="color: #00508f;"></i>
                    <div>
                        <strong style="color: #003b73;">Materias asignadas:</strong>
                        <p class="mb-0 small text-muted">Este grado tiene {{ $grado->materias->count() }} materia(s) asignada(s). Puedes gestionar las asignaciones desde el botón "Gestionar Materias" en la lista de grados.</p>
                    </div>
                </div>

                <!-- Botones -->
                <div class="d-flex gap-2 mt-4 pt-3 border-top">
                    <button type="submit" class="btn flex-fill" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; border-radius: 8px; padding: 0.7rem; font-weight: 600; border: none;">
                        <i class="fas fa-save"></i> Actualizar Grado
                    </button>
                    <a href="{{ route('grados.index') }}" class="btn flex-fill" style="background: white; color: #6b7280; border: 2px solid #e5e7eb; border-radius: 8px; padding: 0.7rem; font-weight: 600;">
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
        border-color: #f59e0b;
        box-shadow: 0 0 0 0.2rem rgba(245, 158, 11, 0.15);
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

@push('scripts')
<script>
    // Filtrar números de grado según el nivel seleccionado
    document.getElementById('nivel').addEventListener('change', function() {
        const nivel = this.value;
        const numeroSelect = document.getElementById('numero');
        const options = numeroSelect.querySelectorAll('option');
        
        options.forEach(option => {
            if (option.value === '') return;
            
            const numero = parseInt(option.value);
            
            if (nivel === 'primaria') {
                option.style.display = (numero >= 1 && numero <= 6) ? '' : 'none';
            } else if (nivel === 'secundaria') {
                option.style.display = (numero >= 7 && numero <= 9) ? '' : 'none';
            } else {
                option.style.display = '';
            }
        });
        
        // Reset selection if current value is not valid
        const currentValue = parseInt(numeroSelect.value);
        if (nivel === 'primaria' && (currentValue < 1 || currentValue > 6)) {
            numeroSelect.value = '';
        } else if (nivel === 'secundaria' && (currentValue < 7 || currentValue > 9)) {
            numeroSelect.value = '';
        }
    });
    
    // Trigger on page load to filter initial options
    document.getElementById('nivel').dispatchEvent(new Event('change'));
</script>
@endpush

@endsection