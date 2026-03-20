@extends('layouts.app')

@section('title', 'Editar Asignación')
@section('page-title', 'Editar Asignación Docente')

@section('topbar-actions')
    <a href="{{ route('profesor_materia.index') }}"
       style="background:white;color:#00508f;padding:0.5rem 1.2rem;border-radius:8px;text-decoration:none;font-weight:600;display:inline-flex;align-items:center;gap:0.5rem;border:2px solid #00508f;font-size:0.9rem;">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 680px;">

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-3" style="border-radius:10px;border-left:4px solid #d32f2f !important;">
            @foreach($errors->all() as $error)
                <div><i class="fas fa-exclamation-circle me-1"></i>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="card border-0 shadow-sm" style="border-radius:10px;">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('profesor_materia.update', $profesor_materia_grado->id)}}">
                @csrf
                @method('PUT')

                {{-- Profesor --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold small mb-1" style="color:#003b73;">
                        <i class="fas fa-user-tie me-1" style="color:#4ec7d2;"></i>
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

                {{-- Materia --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold small mb-1" style="color:#003b73;">
                        <i class="fas fa-book me-1" style="color:#4ec7d2;"></i>
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

                {{-- Grado --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold small mb-1" style="color:#003b73;">
                        <i class="fas fa-school me-1" style="color:#4ec7d2;"></i>
                        Grado <span class="text-danger">*</span>
                    </label>
                    <select name="grado_id" required
                            class="form-select @error('grado_id') is-invalid @enderror"
                            style="border:1.5px solid #e2e8f0;border-radius:8px;font-size:0.875rem;">
                        <option value="">Seleccione un grado…</option>
                        @foreach($grados as $g)
                            <option value="{{ $g->id }}"
                                {{ old('grado_id', $profesor_materia_grado->grado_id) == $g->id ? 'selected' : '' }}>
                                {{ $g->numero }}° Grado
                                @if($g->seccion) — Sección {{ $g->seccion }} @endif
                                ({{ ucfirst($g->nivel) }})
                            </option>
                        @endforeach
                    </select>
                    @error('grado_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Sección --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold small mb-1" style="color:#003b73;">
                        <i class="fas fa-door-open me-1" style="color:#4ec7d2;"></i>
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

                {{-- Botones --}}
                <div class="d-flex gap-3 align-items-center">
                    <button type="submit" class="btn fw-semibold"
                            style="background:linear-gradient(135deg,#4ec7d2,#00508f);color:white;border:none;padding:0.5rem 1.5rem;border-radius:8px;box-shadow:0 2px 8px rgba(78,199,210,0.3);">
                        <i class="fas fa-save me-2"></i>Actualizar Asignación
                    </button>
                    <a href="{{ route('profesor_materia.index') }}" class="small text-muted" style="text-decoration:none;">
                        Cancelar
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
.btn-check:checked + label {
    background: linear-gradient(135deg, #4ec7d2, #00508f) !important;
    color: white !important;
    border-color: #00508f !important;
}
.form-select:focus { border-color: #4ec7d2 !important; box-shadow: 0 0 0 0.15rem rgba(78,199,210,0.2) !important; }
</style>
@endpush
@endsection