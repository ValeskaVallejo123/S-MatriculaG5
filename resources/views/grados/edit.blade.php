@extends('layouts.app')

@section('title', 'Editar Grado')
@section('page-title', 'Editar Grado')

@section('topbar-actions')
    <a href="{{ route('grados.index') }}"
       style="background:white;color:#00508f;padding:.5rem .85rem;border-radius:7px;text-decoration:none;font-weight:600;display:inline-flex;align-items:center;gap:.4rem;border:1.5px solid #00508f;font-size:0.8rem;transition:all .2s;">
        <i class="fas fa-arrow-left" style="font-size:.75rem;"></i> Volver
    </a>
@endsection

@push('styles')
<style>
.form-control:focus, .form-select:focus {
    border-color: #4ec7d2 !important;
    box-shadow: 0 0 0 3px rgba(78,199,210,.15) !important;
    outline: none;
}
</style>
@endpush

@section('content')
<div style="max-width:820px;margin:0 auto;">

    <div class="card border-0 shadow-sm" style="border-radius:12px;overflow:hidden;">

        {{-- Header --}}
        <div style="background:linear-gradient(135deg,#003b73,#00508f);padding:.85rem 1.25rem;display:flex;align-items:center;gap:.5rem;">
            <i class="fas fa-edit" style="color:#4ec7d2;font-size:.95rem;"></i>
            <span style="color:white;font-weight:700;font-size:.95rem;">
                Editar Grado: {{ $grado->numero }}°{{ $grado->seccion ? ' Sección ' . $grado->seccion : '' }}
            </span>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('grados.update', $grado) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    {{-- Nivel Educativo --}}
                    <div class="col-md-6">
                        <label for="nivel" class="form-label fw-semibold" style="font-size:.83rem;color:#003b73;">
                            Nivel Educativo *
                        </label>
                        <select class="form-select @error('nivel') is-invalid @enderror"
                                id="nivel" name="nivel" required
                                style="border:1.5px solid #d0dce8;border-radius:8px;font-size:.85rem;">
                            <option value="">Seleccionar nivel...</option>
                            <option value="primaria"   {{ old('nivel', $grado->nivel) == 'primaria'   ? 'selected' : '' }}>Primaria (1° - 6° Grado)</option>
                            <option value="secundaria" {{ old('nivel', $grado->nivel) == 'secundaria' ? 'selected' : '' }}>Secundaria (7° - 9° Grado)</option>
                        </select>
                        @error('nivel')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Número de Grado --}}
                    <div class="col-md-6">
                        <label for="numero" class="form-label fw-semibold" style="font-size:.83rem;color:#003b73;">
                            Número de Grado *
                        </label>
                        <select class="form-select @error('numero') is-invalid @enderror"
                                id="numero" name="numero" required
                                style="border:1.5px solid #d0dce8;border-radius:8px;font-size:.85rem;">
                            <option value="">Seleccionar grado...</option>
                            @for($i = 1; $i <= 9; $i++)
                                <option value="{{ $i }}" {{ old('numero', $grado->numero) == $i ? 'selected' : '' }}>
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
                        <label for="seccion" class="form-label fw-semibold" style="font-size:.83rem;color:#003b73;">
                            Sección
                        </label>
                        <select class="form-select @error('seccion') is-invalid @enderror"
                                id="seccion" name="seccion"
                                style="border:1.5px solid #d0dce8;border-radius:8px;font-size:.85rem;">
                            <option value="">Sin sección</option>
                            @foreach(['A','B','C','D','E'] as $sec)
                                <option value="{{ $sec }}" {{ old('seccion', $grado->seccion) == $sec ? 'selected' : '' }}>
                                    Sección {{ $sec }}
                                </option>
                            @endforeach
                        </select>
                        @error('seccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Año Lectivo --}}
                    <div class="col-md-6">
                        <label for="anio_lectivo" class="form-label fw-semibold" style="font-size:.83rem;color:#003b73;">
                            Año Lectivo *
                        </label>
                        <input type="number"
                               class="form-control @error('anio_lectivo') is-invalid @enderror"
                               id="anio_lectivo" name="anio_lectivo"
                               value="{{ old('anio_lectivo', $grado->anio_lectivo) }}"
                               min="2020" max="2100" required
                               style="border:1.5px solid #d0dce8;border-radius:8px;font-size:.85rem;">
                        @error('anio_lectivo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Activo --}}
                    <div class="col-12">
                        <div class="form-check form-switch" style="padding-left:3.5rem;">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="activo" name="activo" value="1"
                                   {{ old('activo', $grado->activo) ? 'checked' : '' }}
                                   style="width:3rem;height:1.5rem;cursor:pointer;">
                            <label class="form-check-label fw-semibold" for="activo"
                                   style="color:#003b73;margin-left:.5rem;font-size:.83rem;">
                                Grado Activo
                            </label>
                        </div>
                    </div>

                </div>

                {{-- Info materias --}}
                <div class="mt-3"
                     style="border-radius:8px;border-left:4px solid #4ec7d2;background:rgba(78,199,210,0.08);padding:.75rem 1rem;">
                    <p class="mb-0" style="font-size:.82rem;color:#003b73;">
                        <strong>Materias asignadas:</strong>
                        Este grado tiene {{ $grado->materias->count() }} materia(s) asignada(s).
                        Puedes gestionar las asignaciones desde "Gestionar Materias" en la lista de grados.
                    </p>
                </div>

                {{-- Botones --}}
                <div class="d-flex gap-2 mt-4 pt-3" style="border-top:1px solid #e8edf4;">
                    <button type="submit" class="btn flex-fill"
                            style="background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;border-radius:8px;padding:.65rem;font-weight:600;border:none;font-size:.88rem;">
                        <i class="fas fa-save me-1"></i> Actualizar Grado
                    </button>
                    <a href="{{ route('grados.index') }}" class="btn flex-fill"
                       style="background:white;color:#6b7280;border:1.5px solid #e5e7eb;border-radius:8px;padding:.65rem;font-weight:600;font-size:.88rem;">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const nivelSelect  = document.getElementById('nivel');
    const numeroSelect = document.getElementById('numero');

    const RANGOS = {
        primaria:   { min: 1, max: 6 },
        secundaria: { min: 7, max: 9 },
    };

    function filtrarNumeros() {
        const nivel = nivelSelect.value;
        Array.from(numeroSelect.querySelectorAll('option')).forEach(opt => {
            if (opt.value === '') return;
            const n = parseInt(opt.value);
            const rango = RANGOS[nivel];
            opt.style.display = rango ? (n >= rango.min && n <= rango.max ? '' : 'none') : '';
        });

        const current = parseInt(numeroSelect.value);
        const rango = RANGOS[nivel];
        if (rango && (current < rango.min || current > rango.max)) {
            numeroSelect.value = '';
        }
    }

    nivelSelect.addEventListener('change', filtrarNumeros);
    filtrarNumeros();
});
</script>
@endpush