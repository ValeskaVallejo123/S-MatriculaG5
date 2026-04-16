@extends('layouts.app')

@section('title', 'Editar Asignación')
@section('page-title', 'Editar Asignación Docente')

@section('content-class', 'p-0')

@push('styles')
<style>
.edit-wrapper {
    height: calc(100vh - 64px);
    display: flex;
    overflow: hidden;
}

/* Panel izquierdo — formulario */
.edit-form-panel {
    flex: 1;
    overflow-y: auto;
    padding: 2rem 2.5rem;
    background: #f8fafc;
}


.edit-field-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 1px 4px rgba(0,59,115,.07);
    margin-bottom: 1.25rem;
    border: 1px solid #e8eef5;
}

.edit-section-title {
    font-size: .7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: #4ec7d2;
    margin-bottom: 1.25rem;
    padding-bottom: .5rem;
    border-bottom: 1px solid #f1f5f9;
}

.btn-check:checked + label {
    background: linear-gradient(135deg, #4ec7d2, #00508f) !important;
    color: white !important;
    border-color: #00508f !important;
}
.form-select:focus {
    border-color: #4ec7d2 !important;
    box-shadow: 0 0 0 0.15rem rgba(78,199,210,0.2) !important;
}

/* Modo oscuro */
body.dark-mode .edit-form-panel  { background: #0f172a !important; }
body.dark-mode .edit-field-card  { background: #1e293b !important; border-color: #334155 !important; }
body.dark-mode .edit-section-title { color: #4ec7d2 !important; border-bottom-color: #334155 !important; }
</style>
@endpush

@section('content')
<div class="edit-wrapper">

    {{-- ── Panel izquierdo: formulario ── --}}
    <div class="edit-form-panel">

        @if($errors->any())
            <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius:10px;border-left:4px solid #d32f2f !important;">
                @foreach($errors->all() as $error)
                    <div><i class="fas fa-exclamation-circle me-1"></i>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('profesor_materia_grado.update', $profesor_materia_grado->id) }}">
            @csrf
            @method('PUT')

            {{-- Fila 1: Profesor + Materia --}}
            <div class="row g-4 mb-0">
                <div class="col-lg-6">
                    <div class="edit-field-card">
                        <div class="edit-section-title"><i class="fas fa-user-tie me-1"></i>Docente</div>
                        <label class="form-label fw-semibold small mb-1" style="color:#003b73;">
                            Profesor <span class="text-danger">*</span>
                        </label>
                        <select name="profesor_id" required
                                class="form-select @error('profesor_id') is-invalid @enderror"
                                style="border:1.5px solid #e2e8f0;border-radius:8px;font-size:0.875rem;">
                            <option value="">Seleccione un profesor…</option>
                            @foreach($profesores as $p)
                                <option value="{{ $p->id }}"
                                    {{ old('profesor_id', $profesor_materia_grado->profesor_id) == $p->id ? 'selected' : '' }}>
                                    {{ $p->nombre_completo ?? $p->nombre . ' ' . $p->apellido }}
                                </option>
                            @endforeach
                        </select>
                        @error('profesor_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="edit-field-card">
                        <div class="edit-section-title"><i class="fas fa-book me-1"></i>Asignatura</div>
                        <label class="form-label fw-semibold small mb-1" style="color:#003b73;">
                            Materia <span class="text-danger">*</span>
                        </label>
                        <select name="materia_id" required
                                class="form-select @error('materia_id') is-invalid @enderror"
                                style="border:1.5px solid #e2e8f0;border-radius:8px;font-size:0.875rem;">
                            <option value="">Seleccione una materia…</option>
                            @foreach($materias as $m)
                                <option value="{{ $m->id }}"
                                    {{ old('materia_id', $profesor_materia_grado->materia_id) == $m->id ? 'selected' : '' }}>
                                    {{ $m->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('materia_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- Fila 2: Grado + Sección --}}
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="edit-field-card">
                        <div class="edit-section-title"><i class="fas fa-school me-1"></i>Grupo</div>
                        <label class="form-label fw-semibold small mb-1" style="color:#003b73;">
                            Grado <span class="text-danger">*</span>
                        </label>
                        <select name="grado_id" required
                                class="form-select @error('grado_id') is-invalid @enderror"
                                style="border:1.5px solid #e2e8f0;border-radius:8px;font-size:0.875rem;">
                            <option value="">Seleccione un grado…</option>
                            @foreach($grados as $g)
                                <option value="{{ $g->id }}"
                                    {{ old('grado_id', $profesor_materia_grado->grado_id) == $g->id ? 'selected' : '' }}>
                                    {{ $g->numero }}° {{ ucfirst($g->nivel) }} - Sección {{ $g->seccion }} ({{ $g->anio_lectivo }})
                                </option>
                            @endforeach
                        </select>
                        @error('grado_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="edit-field-card">
                        <div class="edit-section-title"><i class="fas fa-door-open me-1"></i>Sección</div>
                        <label class="form-label fw-semibold small mb-2" style="color:#003b73;">
                            Sección <span class="text-danger">*</span>
                        </label>
                        <div class="d-flex gap-2 flex-wrap">
                            @foreach($secciones as $s)
                                <div>
                                    <input type="radio" name="seccion" value="{{ $s }}"
                                           id="sec_{{ $s }}"
                                           class="btn-check"
                                           {{ old('seccion', $profesor_materia_grado->seccion) == $s ? 'checked' : '' }}>
                                    <label for="sec_{{ $s }}"
                                           class="btn btn-sm fw-bold"
                                           style="border:2px solid #00508f;color:#00508f;background:white;border-radius:8px;min-width:50px;padding:0.4rem 0.8rem;transition:all 0.2s;">
                                        {{ $s }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('seccion')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- Botones --}}
            <div class="d-flex gap-3 align-items-center mt-2">
                <button type="submit" class="btn fw-semibold px-4"
                        style="background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;border:none;padding:0.55rem 1.8rem;border-radius:8px;box-shadow:0 2px 8px rgba(78,199,210,0.3);font-size:.9rem;">
                    <i class="fas fa-save me-2"></i>Actualizar Asignación
                </button>
                <a href="{{ route('profesor_materia_grado.index') }}" class="small text-muted" style="text-decoration:none;">
                    Cancelar
                </a>
            </div>

        </form>
    </div>


</div>
@endsection
