@extends('layouts.app')

@section('title', 'Editar Calificación')

@section('page-title', 'Calificaciones')


@section('content')
<div class="container" style="max-width: 720px;">

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-3" style="border-radius: 10px; border-left: 4px solid #d32f2f !important;">
            <ul class="mb-0 small">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    {{-- Info estudiante --}}
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
        <div class="card-body p-3">
            <div class="d-flex align-items-center gap-4 flex-wrap">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-user-graduate" style="color: #00508f; font-size: 0.9rem;"></i>
                    <span class="small fw-semibold" style="color: #003b73;">
                        {{ $calificacion->estudiante->nombre_completo ?? '—' }}
                    </span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-book" style="color: #4ec7d2; font-size: 0.9rem;"></i>
                    <span class="small text-muted">{{ $calificacion->materia->nombre ?? '—' }}</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-school" style="color: #4ec7d2; font-size: 0.9rem;"></i>
                    <span class="small text-muted">{{ $calificacion->grado_nombre }} · Sección {{ $calificacion->seccion }}</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-calendar-alt" style="color: #4ec7d2; font-size: 0.9rem;"></i>
                    <span class="small text-muted">{{ $calificacion->periodo->nombre_periodo ?? $calificacion->periodo->nombre ?? '—' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 10px;">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('calificaciones.update', $calificacion) }}">
                @csrf
                @method('PUT')

                {{-- Parciales --}}
                <div class="row g-3 mb-3">
                    @foreach(['primer_parcial' => '1er Parcial', 'segundo_parcial' => '2do Parcial', 'tercer_parcial' => '3er Parcial', 'recuperacion' => 'Recuperación'] as $campo => $label)
                    <div class="col-md-3 col-6">
                        <label class="form-label fw-semibold small mb-1" style="color: #003b73; font-size: 0.85rem;">{{ $label }}</label>
                        <input type="number" name="{{ $campo }}"
                               value="{{ old($campo, $calificacion->$campo) }}"
                               min="0" max="100" step="0.01"
                               id="{{ $campo }}"
                               class="form-control text-center @error($campo) is-invalid @enderror"
                               style="border: 1.5px solid #e2e8f0; border-radius: 8px;"
                               placeholder="—">
                        @error($campo)<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    @endforeach
                </div>

                {{-- Nota final calculada --}}
                <div class="d-flex align-items-center justify-content-between p-3 mb-3"
                     style="background: rgba(0,80,143,0.04); border-radius: 10px; border: 1.5px solid #e2e8f0;">
                    <span class="small fw-semibold" style="color: #003b73;">
                        <i class="fas fa-calculator me-2" style="color: #4ec7d2;"></i>
                        Nota final calculada
                    </span>
                    <span id="notaFinalDisplay" class="fw-bold" style="font-size: 1.5rem;
                        {{ $calificacion->nota_final !== null ? ($calificacion->nota_final >= 60 ? 'color: #388e3c;' : 'color: #d32f2f;') : 'color: #c0c0c0;' }}">
                        {{ $calificacion->nota_final !== null ? number_format($calificacion->nota_final, 1) : '—' }}
                    </span>
                </div>

                {{-- Observación --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold small mb-1" style="color: #003b73; font-size: 0.85rem;">
                        Observación <span class="text-muted fw-normal">(opcional)</span>
                    </label>
                    <textarea name="observacion" maxlength="500" rows="2"
                              class="form-control @error('observacion') is-invalid @enderror"
                              style="border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: 0.875rem; resize: none;"
                              placeholder="Comentario…">{{ old('observacion', $calificacion->observacion) }}</textarea>
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" class="btn fw-semibold"
                            style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; box-shadow: 0 2px 8px rgba(78,199,210,0.3); padding: 0.5rem 1.5rem; border-radius: 8px;">
                        <i class="fas fa-save me-2"></i>Guardar cambios
                    </button>
                    <a href="{{ route('calificaciones.index') }}" class="small text-muted align-self-center" style="text-decoration: none;">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .form-control:focus { border-color: #4ec7d2 !important; box-shadow: 0 0 0 0.15rem rgba(78,199,210,0.2) !important; }
    .btn-back:hover { background: #00508f !important; color: white !important; transform: translateY(-2px); }
    button[type="submit"]:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(78,199,210,0.4) !important; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ids = ['primer_parcial','segundo_parcial','tercer_parcial','recuperacion'];
    const display = document.getElementById('notaFinalDisplay');
    ids.forEach(id => { const el = document.getElementById(id); if(el) el.addEventListener('input', recalcular); });

    function recalcular() {
        const get = id => { const el = document.getElementById(id); return el && el.value !== '' ? parseFloat(el.value) : null; };
        const p1 = get('primer_parcial'), p2 = get('segundo_parcial'), p3 = get('tercer_parcial'), rec = get('recuperacion');
        const parciales = [p1,p2,p3].filter(v => v !== null);
        if (parciales.length === 0) { display.textContent = '—'; display.style.color = '#c0c0c0'; return; }
        const promedio = parciales.reduce((a,b) => a+b, 0) / parciales.length;
        const nf = (promedio < 60 && rec !== null) ? Math.max(promedio, rec) : promedio;
        display.textContent = nf.toFixed(1);
        display.style.color = nf >= 60 ? '#388e3c' : '#d32f2f';
    }
});
</script>
@endpush
@endsection
