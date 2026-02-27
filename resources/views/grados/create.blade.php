@extends('layouts.app')

@section('title', 'Nuevo Grado')

@section('page-title', 'Crear Nuevo Grado')

@section('topbar-actions')
    <a href="{{ route('grados.index') }}" class="btn-back" style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #00508f; box-shadow: 0 2px 8px rgba(0, 80, 143, 0.2); font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 900px;">

    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-header" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 12px 12px 0 0; padding: 1.2rem;">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-graduation-cap"></i> Formulario de Nuevo Grado
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('grados.store') }}" method="POST">
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
                            {{-- Los values deben coincidir EXACTAMENTE con la validación del controlador --}}
                            <option value="Primaria" {{ old('nivel') == 'Primaria' ? 'selected' : '' }}>
                                Primaria (1° - 6° Grado)
                            </option>
                            <option value="Básica" {{ old('nivel') == 'Básica' ? 'selected' : '' }}>
                                Básica (7° - 9° Grado)
                            </option>
                            <option value="Secundaria" {{ old('nivel') == 'Secundaria' ? 'selected' : '' }}>
                                Secundaria (10° - 12° Grado)
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
                            <option value="1" {{ old('numero') == 1 ? 'selected' : '' }}>1° Grado</option>
                            <option value="2" {{ old('numero') == 2 ? 'selected' : '' }}>2° Grado</option>
                            <option value="3" {{ old('numero') == 3 ? 'selected' : '' }}>3° Grado</option>
                            <option value="4" {{ old('numero') == 4 ? 'selected' : '' }}>4° Grado</option>
                            <option value="5" {{ old('numero') == 5 ? 'selected' : '' }}>5° Grado</option>
                            <option value="6" {{ old('numero') == 6 ? 'selected' : '' }}>6° Grado</option>
                            <option value="7" {{ old('numero') == 7 ? 'selected' : '' }}>7° Grado</option>
                            <option value="8" {{ old('numero') == 8 ? 'selected' : '' }}>8° Grado</option>
                            <option value="9" {{ old('numero') == 9 ? 'selected' : '' }}>9° Grado</option>
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
                            <option value="A" {{ old('seccion') == 'A' ? 'selected' : '' }}>Sección A</option>
                            <option value="B" {{ old('seccion') == 'B' ? 'selected' : '' }}>Sección B</option>
                            <option value="C" {{ old('seccion') == 'C' ? 'selected' : '' }}>Sección C</option>
                            <option value="D" {{ old('seccion') == 'D' ? 'selected' : '' }}>Sección D</option>
                            <option value="E" {{ old('seccion') == 'E' ? 'selected' : '' }}>Sección E</option>
                        </select>
                        @error('seccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Opcional: Deja vacío si no aplica</small>
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
                               value="{{ old('anio_lectivo', date('Y')) }}"
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
                                   {{ old('activo', true) ? 'checked' : '' }}
                                   style="width: 3rem; height: 1.5rem; cursor: pointer;">
                            <label class="form-check-label fw-semibold" for="activo" style="color: #003b73; margin-left: 0.5rem;">
                                <i class="fas fa-toggle-on text-success"></i> Grado Activo
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Información adicional dinámica según nivel -->
                <div id="info-primaria" class="alert alert-success mt-3 d-none d-flex align-items-start" style="border-radius: 8px; border-left: 4px solid #10b981; background: rgba(16, 185, 129, 0.08);">
                    <i class="fas fa-magic me-2 mt-1" style="color: #10b981;"></i>
                    <div>
                        <strong style="color: #065f46;">Asignación automática:</strong>
                        <p class="mb-0 small text-muted">Al guardar, se asignarán automáticamente las materias de Primaria: Español, Matemáticas, Ciencias Naturales, Ciencias Sociales, Educación Artística, Educación Física, Inglés y Educación Cívica/Valores.</p>
                    </div>
                </div>

                <div id="info-otros" class="alert alert-info mt-3 d-flex align-items-start" style="border-radius: 8px; border-left: 4px solid #4ec7d2; background: rgba(78, 199, 210, 0.1);">
                    <i class="fas fa-info-circle me-2 mt-1" style="color: #00508f;"></i>
                    <div>
                        <strong style="color: #003b73;">Nota:</strong>
                        <p class="mb-0 small text-muted">Selecciona el nivel educativo para ver las opciones de asignación de materias.</p>
                    </div>
                </div>

                <!-- Botones -->
                <div class="d-flex gap-2 mt-4 pt-3 border-top">
                    <button type="submit" class="btn flex-fill" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 8px; padding: 0.7rem; font-weight: 600; border: none;">
                        <i class="fas fa-save"></i> Guardar Grado
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const nivelSelect   = document.getElementById('nivel');
    const numeroSelect  = document.getElementById('numero');
    const infoPrimaria  = document.getElementById('info-primaria');
    const infoOtros     = document.getElementById('info-otros');

    const MENSAJES = {
        'Básica':      'Después de guardar podrás asignar las materias de Básica desde la gestión de grados.',
        'Secundaria':  'Después de guardar podrás asignar las materias de Secundaria desde la gestión de grados.',
    };

    function actualizarUI() {
        const nivel = nivelSelect.value;
        const options = numeroSelect.querySelectorAll('option');

        // Filtrar opciones de número según nivel
        options.forEach(opt => {
            if (opt.value === '') return;
            const n = parseInt(opt.value);
            if (nivel === 'Primaria')   opt.style.display = (n >= 1 && n <= 6) ? '' : 'none';
            else if (nivel === 'Básica') opt.style.display = (n >= 7 && n <= 9) ? '' : 'none';
            else                        opt.style.display = '';
        });

        // Reset número si no es válido para el nivel
        const current = parseInt(numeroSelect.value);
        if (nivel === 'Primaria' && (current < 1 || current > 6)) numeroSelect.value = '';
        if (nivel === 'Básica'   && (current < 7 || current > 9)) numeroSelect.value = '';

        // Mostrar info contextual
        if (nivel === 'Primaria') {
            infoPrimaria.classList.remove('d-none');
            infoOtros.classList.add('d-none');
        } else if (nivel === 'Básica' || nivel === 'Secundaria') {
            infoPrimaria.classList.add('d-none');
            infoOtros.querySelector('p').textContent = MENSAJES[nivel];
            infoOtros.classList.remove('d-none');
        } else {
            infoPrimaria.classList.add('d-none');
            infoOtros.querySelector('p').textContent = 'Selecciona el nivel educativo para ver las opciones de asignación de materias.';
            infoOtros.classList.remove('d-none');
        }
    }

    nivelSelect.addEventListener('change', actualizarUI);

    // Ejecutar al cargar si hay valor previo (old())
    if (nivelSelect.value) actualizarUI();
});
</script>
@endpush
@endsection