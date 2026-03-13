@extends('layouts.app')

@section('title', 'Nuevo Grado')
@section('page-title', 'Crear Nuevo Grado')

@section('topbar-actions')
    <a href="{{ route('grados.index') }}"
       class="btn-back"
       style="background:white; color:#00508f; padding:0.5rem 1.2rem; border-radius:8px;
              text-decoration:none; font-weight:600; display:inline-flex; align-items:center;
              gap:0.5rem; transition:all 0.3s ease; border:2px solid #00508f;
              box-shadow:0 2px 8px rgba(0,80,143,0.2); font-size:0.9rem;">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
@endsection

@section('content')
<div class="container" style="max-width:900px;">

<<<<<<< HEAD
    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-header" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 12px 12px 0 0; padding: 1.2rem;">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-graduation-cap"></i> Formulario de Nuevo Grado
=======
    <div class="card border-0 shadow-sm" style="border-radius:12px;">

        <div class="card-header border-0"
             style="background:linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);
                    border-radius:12px 12px 0 0; padding:1.2rem;">
            <h5 class="mb-0 fw-bold text-white">
                <i class="fas fa-graduation-cap me-2"></i>Formulario de Nuevo Grado
>>>>>>> cesia-dev
            </h5>
        </div>

        <div class="card-body p-4">

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert"
                 style="border-radius: 8px; border-left: 4px solid #ef4444;">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <form action="{{ route('grados.store') }}" method="POST">
                @csrf

                <div class="row g-3">

<<<<<<< HEAD
                    <!-- Nivel Educativo -->
=======
                    {{-- Nivel Educativo --}}
>>>>>>> cesia-dev
                    <div class="col-md-6">
                        <label for="nivel" class="form-label fw-semibold" style="color:#003b73;">
                            <i class="fas fa-layer-group text-primary me-1"></i>Nivel Educativo
                            <span class="text-danger">*</span>
                        </label>
                        <select id="nivel" name="nivel" required
                                class="form-select @error('nivel') is-invalid @enderror"
                                style="border:2px solid #bfd9ea; border-radius:8px; padding:0.6rem 1rem;">
                            <option value="">Seleccionar nivel...</option>
<<<<<<< HEAD
                            {{-- Values en minúsculas: coinciden con ENUM BD y validación del controlador --}}
                            <option value="primaria"   {{ old('nivel') === 'primaria'   ? 'selected' : '' }}>
                                Primaria (1° - 6° Grado)
                            </option>
                            <option value="secundaria" {{ old('nivel') === 'secundaria' ? 'selected' : '' }}>
                                Secundaria (7° - 9° Grado)
=======
                            <option value="Primaria"   {{ old('nivel') == 'Primaria'   ? 'selected' : '' }}>
                                Primaria (1° – 6° Grado)
                            </option>
                            <option value="Básica"     {{ old('nivel') == 'Básica'     ? 'selected' : '' }}>
                                Básica (7° – 9° Grado)
                            </option>
                            <option value="Secundaria" {{ old('nivel') == 'Secundaria' ? 'selected' : '' }}>
                                Secundaria (10° – 12° Grado)
>>>>>>> cesia-dev
                            </option>
                        </select>
                        @error('nivel')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Número de Grado --}}
                    <div class="col-md-6">
                        <label for="numero" class="form-label fw-semibold" style="color:#003b73;">
                            <i class="fas fa-sort-numeric-up text-success me-1"></i>Número de Grado
                            <span class="text-danger">*</span>
                        </label>
                        <select id="numero" name="numero" required
                                class="form-select @error('numero') is-invalid @enderror"
                                style="border:2px solid #bfd9ea; border-radius:8px; padding:0.6rem 1rem;">
                            <option value="">Seleccionar grado...</option>
<<<<<<< HEAD
                            {{-- 1-6 Primaria | 7-9 Secundaria --}}
=======
>>>>>>> cesia-dev
                            @for($i = 1; $i <= 9; $i++)
                                <option value="{{ $i }}" {{ old('numero') == $i ? 'selected' : '' }}>
                                    {{ $i }}° Grado
                                </option>
                            @endfor
                        </select>
                        @error('numero')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Sección --}}
                    <div class="col-md-6">
<<<<<<< HEAD
                        <label for="seccion" class="form-label fw-semibold" style="color: #003b73;">
                            <i class="fas fa-list-ol text-info"></i> Sección *
                        </label>
                        <select class="form-select @error('seccion') is-invalid @enderror"
                                id="seccion"
                                name="seccion"
                                required
                                style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem;">
                            <option value="">Seleccionar sección...</option>
                            {{-- Solo A, B, C, D → coincide con ENUM BD y validación 'in:A,B,C,D' --}}
                            @foreach(['A','B','C','D'] as $sec)
                                <option value="{{ $sec }}" {{ old('seccion') === $sec ? 'selected' : '' }}>
=======
                        <label for="seccion" class="form-label fw-semibold" style="color:#003b73;">
                            <i class="fas fa-list-ol text-info me-1"></i>Sección
                        </label>
                        <select id="seccion" name="seccion"
                                class="form-select @error('seccion') is-invalid @enderror"
                                style="border:2px solid #bfd9ea; border-radius:8px; padding:0.6rem 1rem;">
                            <option value="">Sin sección</option>
                            @foreach(['A','B','C','D','E'] as $sec)
                                <option value="{{ $sec }}" {{ old('seccion') == $sec ? 'selected' : '' }}>
>>>>>>> cesia-dev
                                    Sección {{ $sec }}
                                </option>
                            @endforeach
                        </select>
                        @error('seccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
<<<<<<< HEAD
=======
                        <small class="text-muted">Opcional: deja vacío si no aplica.</small>
>>>>>>> cesia-dev
                    </div>

                    {{-- Año Lectivo --}}
                    <div class="col-md-6">
                        <label for="anio_lectivo" class="form-label fw-semibold" style="color:#003b73;">
                            <i class="fas fa-calendar-alt text-warning me-1"></i>Año Lectivo
                            <span class="text-danger">*</span>
                        </label>
                        <input type="number" id="anio_lectivo" name="anio_lectivo"
                               class="form-control @error('anio_lectivo') is-invalid @enderror"
                               value="{{ old('anio_lectivo', date('Y')) }}"
                               min="2020" max="2100" required
                               style="border:2px solid #bfd9ea; border-radius:8px; padding:0.6rem 1rem;">
                        @error('anio_lectivo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Estado Activo --}}
                    <div class="col-12">
                        <div class="form-check form-switch" style="padding-left:2.5rem;">
                            <input class="form-check-input" type="checkbox"
                                   id="activo" name="activo" value="1"
                                   {{ old('activo', true) ? 'checked' : '' }}
<<<<<<< HEAD
                                   style="width: 3rem; height: 1.5rem; cursor: pointer;">
                            <label class="form-check-label fw-semibold" for="activo"
                                   style="color: #003b73; margin-left: 0.5rem;">
                                <i class="fas fa-toggle-on text-success"></i> Grado Activo
=======
                                   style="width:3rem; height:1.5rem; cursor:pointer;">
                            <label class="form-check-label fw-semibold" for="activo"
                                   style="color:#003b73; margin-left:0.5rem;">
                                <i class="fas fa-toggle-on text-success me-1"></i>Grado Activo
>>>>>>> cesia-dev
                            </label>
                        </div>
                    </div>

<<<<<<< HEAD
                <!-- Info contextual según nivel -->
                <div id="info-primaria" class="alert mt-3 d-none d-flex align-items-start"
                     style="border-radius: 8px; border-left: 4px solid #10b981; background: rgba(16,185,129,0.08);">
                    <i class="fas fa-magic me-2 mt-1" style="color: #10b981;"></i>
                    <div>
                        <strong style="color: #065f46;">Asignación automática:</strong>
                        <p class="mb-0 small text-muted">
                            Al guardar se asignarán automáticamente: Español, Matemáticas, Ciencias Naturales,
                            Ciencias Sociales, Educación Artística, Educación Física, Inglés y Educación Cívica/Valores.
=======
                </div>{{-- fin row --}}

                {{-- Info dinámica: Primaria --}}
                <div id="info-primaria"
                     class="alert mt-3 d-none d-flex align-items-start border-0"
                     style="border-radius:8px; border-left:4px solid #10b981 !important;
                            background:rgba(16,185,129,0.08);">
                    <i class="fas fa-magic me-2 mt-1" style="color:#10b981;"></i>
                    <div>
                        <strong style="color:#065f46;">Asignación automática:</strong>
                        <p class="mb-0 small text-muted">
                            Al guardar se asignarán automáticamente las materias de Primaria:
                            Español, Matemáticas, Ciencias Naturales, Ciencias Sociales,
                            Educación Artística, Educación Física, Inglés y Educación Cívica/Valores.
>>>>>>> cesia-dev
                        </p>
                    </div>
                </div>

<<<<<<< HEAD
                <div id="info-secundaria" class="alert mt-3 d-none d-flex align-items-start"
                     style="border-radius: 8px; border-left: 4px solid #4ec7d2; background: rgba(78,199,210,0.1);">
                    <i class="fas fa-info-circle me-2 mt-1" style="color: #00508f;"></i>
                    <div>
                        <strong style="color: #003b73;">Secundaria:</strong>
                        <p class="mb-0 small text-muted">
                            Después de guardar podrás asignar las materias desde la gestión del grado.
                        </p>
                    </div>
                </div>

                <div id="info-default" class="alert alert-info mt-3 d-flex align-items-start"
                     style="border-radius: 8px; border-left: 4px solid #4ec7d2; background: rgba(78,199,210,0.1);">
                    <i class="fas fa-info-circle me-2 mt-1" style="color: #00508f;"></i>
                    <div>
                        <strong style="color: #003b73;">Nota:</strong>
                        <p class="mb-0 small text-muted">
=======
                {{-- Info dinámica: Básica / Secundaria / sin selección --}}
                <div id="info-otros"
                     class="alert mt-3 d-flex align-items-start border-0"
                     style="border-radius:8px; border-left:4px solid #4ec7d2 !important;
                            background:rgba(78,199,210,0.1);">
                    <i class="fas fa-info-circle me-2 mt-1" style="color:#00508f;"></i>
                    <div>
                        <strong style="color:#003b73;">Nota:</strong>
                        <p class="mb-0 small text-muted" id="info-otros-texto">
>>>>>>> cesia-dev
                            Selecciona el nivel educativo para ver las opciones de asignación de materias.
                        </p>
                    </div>
                </div>

                {{-- Botones --}}
                <div class="d-flex gap-2 mt-4 pt-3 border-top">
<<<<<<< HEAD
                    <button type="submit" class="btn flex-fill"
                            style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 8px; padding: 0.7rem; font-weight: 600; border: none;">
                        <i class="fas fa-save"></i> Guardar Grado
                    </button>
                    <a href="{{ route('grados.index') }}" class="btn flex-fill"
                       style="background: white; color: #6b7280; border: 2px solid #e5e7eb; border-radius: 8px; padding: 0.7rem; font-weight: 600;">
                        <i class="fas fa-times"></i> Cancelar
=======
                    <button type="submit"
                            class="btn flex-fill fw-semibold"
                            style="background:linear-gradient(135deg,#4ec7d2,#00508f);
                                   color:white; border:none; border-radius:8px; padding:0.7rem;">
                        <i class="fas fa-save me-1"></i>Guardar Grado
                    </button>
                    <a href="{{ route('grados.index') }}"
                       class="btn flex-fill fw-semibold"
                       style="background:white; color:#6b7280;
                              border:2px solid #e5e7eb; border-radius:8px; padding:0.7rem;">
                        <i class="fas fa-times me-1"></i>Cancelar
>>>>>>> cesia-dev
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection

{{-- ── Estilos ─────────────────────────────────────────────────────────── --}}
@push('styles')
<style>
    .form-control:focus, .form-select:focus {
        border-color: #4ec7d2;
        box-shadow: 0 0 0 0.2rem rgba(78,199,210,0.15);
        outline: none;
    }
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .btn-back:hover {
        background: #00508f !important;
        color: white !important;
        transform: translateY(-2px);
    }
</style>
@endpush

{{-- ── Scripts ─────────────────────────────────────────────────────────── --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
<<<<<<< HEAD
    const nivelSelect    = document.getElementById('nivel');
    const numeroSelect   = document.getElementById('numero');
    const infoPrimaria   = document.getElementById('info-primaria');
    const infoSecundaria = document.getElementById('info-secundaria');
    const infoDefault    = document.getElementById('info-default');

    // Rangos de grado por nivel (alineados con generarMasivo del controlador)
    const RANGOS = {
        primaria:   { min: 1, max: 6 },
        secundaria: { min: 7, max: 9 },
    };

    function actualizarUI() {
        const nivel = nivelSelect.value;

        // Filtrar opciones de número según nivel
        Array.from(numeroSelect.querySelectorAll('option')).forEach(opt => {
            if (opt.value === '') return;
            const n = parseInt(opt.value);
            const rango = RANGOS[nivel];
            opt.style.display = rango ? (n >= rango.min && n <= rango.max ? '' : 'none') : '';
        });

        // Reset número si el valor actual no es válido para el nivel elegido
        const current = parseInt(numeroSelect.value);
        const rango = RANGOS[nivel];
=======

    const nivelSelect  = document.getElementById('nivel');
    const numeroSelect = document.getElementById('numero');
    const infoPrimaria = document.getElementById('info-primaria');
    const infoOtros    = document.getElementById('info-otros');
    const infoTexto    = document.getElementById('info-otros-texto');

    const MENSAJES = {
        'Básica':     'Después de guardar podrás asignar las materias de Básica desde la gestión de grados.',
        'Secundaria': 'Después de guardar podrás asignar las materias de Secundaria desde la gestión de grados.',
    };

    const RANGOS = {
        'Primaria':   { min: 1, max: 6 },
        'Básica':     { min: 7, max: 9 },
        'Secundaria': { min: 1, max: 9 },
    };

    function actualizarUI() {
        const nivel   = nivelSelect.value;
        const rango   = RANGOS[nivel] ?? null;
        const options = numeroSelect.querySelectorAll('option');

        // Filtrar opciones de número según nivel
        options.forEach(function (opt) {
            if (opt.value === '') return;
            const n = parseInt(opt.value);
            opt.style.display = (!rango || (n >= rango.min && n <= rango.max)) ? '' : 'none';
        });

        // Resetear número si el valor actual ya no es válido para el nivel
        const current = parseInt(numeroSelect.value);
>>>>>>> cesia-dev
        if (rango && (current < rango.min || current > rango.max)) {
            numeroSelect.value = '';
        }

<<<<<<< HEAD
        // Mostrar info contextual
        infoPrimaria.classList.add('d-none');
        infoSecundaria.classList.add('d-none');
        infoDefault.classList.add('d-none');

        if (nivel === 'primaria') {
            infoPrimaria.classList.remove('d-none');
        } else if (nivel === 'secundaria') {
            infoSecundaria.classList.remove('d-none');
        } else {
            infoDefault.classList.remove('d-none');
=======
        // Mostrar bloque informativo según nivel
        if (nivel === 'Primaria') {
            infoPrimaria.classList.remove('d-none');
            infoOtros.classList.add('d-none');
        } else {
            infoPrimaria.classList.add('d-none');
            infoTexto.textContent = MENSAJES[nivel]
                ?? 'Selecciona el nivel educativo para ver las opciones de asignación de materias.';
            infoOtros.classList.remove('d-none');
>>>>>>> cesia-dev
        }
    }

    nivelSelect.addEventListener('change', actualizarUI);

    // Ejecutar al cargar si hay valor previo (old())
    actualizarUI();
});
</script>
@endpush
<<<<<<< HEAD
@endsection
=======

@endsection

>>>>>>> cesia-dev
