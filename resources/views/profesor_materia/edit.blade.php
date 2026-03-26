@extends('layouts.app')

@section('title', 'Editar Asignaciones')
@section('page-title', 'Editar Asignaciones')

@section('topbar-actions')
    <a href="{{ route('profesor_materia.index') }}"
       style="background:white;color:#00508f;padding:0.5rem 1.2rem;border-radius:8px;text-decoration:none;font-weight:600;display:inline-flex;align-items:center;gap:0.5rem;border:2px solid #00508f;font-size:0.9rem;">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 1000px;">

    {{-- Header --}}
    <div class="card border-0 shadow-sm mb-3"
         style="background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 10px;">
        <div class="card-body p-3 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <div style="width: 45px; height: 45px; background: rgba(78,199,210,0.3);
                            border-radius: 10px; display: flex; align-items: center;
                            justify-content: center; margin-right: 1rem; flex-shrink: 0;">
                    <i class="fas fa-user-edit text-white" style="font-size: 1.3rem;"></i>
                </div>
                <div class="text-white">
                    <h5 class="mb-0 fw-bold" style="font-size: 1.1rem;">
                        {{ $profesor->nombre }} {{ $profesor->apellido }}
                    </h5>
                    <p class="mb-0 opacity-90" style="font-size: 0.8rem;">
                        {{ $profesor->materiasGrupos->count() }} asignación(es) activas
                    </p>
                </div>
            </div>
            <div style="background: rgba(78,199,210,0.2); padding: 0.4rem 0.8rem; border-radius: 6px;">
                <p class="text-white mb-0 small fw-semibold" style="font-size: 0.8rem;">
                    ID: #{{ $profesor->id }}
                </p>
            </div>
        </div>
    </div>

    {{-- Alertas --}}
    @if(session('success'))
        <div class="alert border-0 mb-3 py-2 px-3"
             style="border-radius: 8px; background: rgba(34,197,94,0.1);
                    border-left: 3px solid #22c55e !important; font-size: 0.85rem;">
            <i class="fas fa-check-circle me-2" style="color: #22c55e;"></i>
            {{ session('success') }}
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
    @endif

    <div class="row g-3">

        {{-- Columna izquierda: asignaciones actuales --}}
        <div class="col-md-5">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 10px;">
                <div class="card-body p-3">
                    <h6 class="fw-bold mb-3 pb-2 border-bottom"
                        style="color: #00508f; font-size: 0.88rem;">
                        <i class="fas fa-list-check me-2"></i>
                        Asignaciones Actuales
                        <span class="badge ms-1"
                              style="background: rgba(78,199,210,0.15); color: #00508f;
                                     border: 1px solid #4ec7d2; font-size: 0.7rem;">
                            {{ $profesor->materiasGrupos->count() }}
                        </span>
                    </h6>

                    @forelse($profesor->materiasGrupos as $mg)
                        <div class="d-flex align-items-start justify-content-between mb-2 p-2"
                             style="background: rgba(191,217,234,0.12); border-radius: 8px;
                                    border: 1px solid #e2e8f0;">
                            <div style="flex: 1; min-width: 0;">
                                <div class="fw-semibold text-truncate"
                                     style="color: #003b73; font-size: 0.82rem;">
                                    <i class="fas fa-book"
                                       style="color: #4ec7d2; font-size: 0.7rem; margin-right: 4px;"></i>
                                    {{ $mg->materia->nombre }}
                                </div>
                                <small class="text-muted" style="font-size: 0.72rem;">
                                    <i class="fas fa-layer-group" style="font-size: 0.65rem;"></i>
                                    {{ $mg->grado->numero }}° {{ $mg->grado->nombre }}
                                    &nbsp;·&nbsp;
                                    <i class="fas fa-tag" style="font-size: 0.65rem;"></i>
                                    Sección {{ $mg->seccion }}
                                </small>
                            </div>
                            <form action="{{ route('profesor_materia.destroyAsignacion', $mg->id) }}"
                                  method="POST"
                                  class="ms-2"
                                  onsubmit="return confirm('¿Eliminar esta asignación?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn btn-sm p-1"
                                        style="border: 1px solid #ef4444; color: #ef4444;
                                               background: white; border-radius: 5px; line-height: 1;"
                                        title="Eliminar">
                                    <i class="fas fa-times" style="font-size: 0.7rem;"></i>
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-inbox mb-2 d-block"
                               style="font-size: 1.8rem; opacity: 0.35; color: #00508f;"></i>
                            <p class="small mb-0">Sin asignaciones aún</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Columna derecha: agregar nueva asignación --}}
        <div class="col-md-7">
            <div class="card border-0 shadow-sm" style="border-radius: 10px;">
                <div class="card-body p-3">
                    <h6 class="fw-bold mb-3 pb-2 border-bottom"
                        style="color: #00508f; font-size: 0.88rem;">
                        <i class="fas fa-plus-circle me-2"></i>Agregar Nueva Asignación
                    </h6>

                    <form action="{{ route('profesor_materia.update', $profesor->id) }}"
                          method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Grado (Código Integrado) --}}
                        <div class="mb-3">
                            <label class="form-label">
                                Grado <span class="text-danger">*</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-layer-group position-absolute"
                                   style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.8rem; z-index: 10;"></i>
                                
                                <select name="grado_id" class="form-select form-select-sm ps-5 @error('grado_id') is-invalid @enderror" required>
                                    <option value="">Seleccione un grado...</option>
                                    @foreach($grados as $grado)
                                        <option value="{{ $grado->id }}" {{ old('grado_id') == $grado->id ? 'selected' : '' }}>
                                            {{ $grado->numero }}° Grado - Sección {{ $grado->seccion }} ({{ $grado->anio_lectivo }})
                                        </option>
                                    @endforeach
                                </select>
                                
                                @error('grado_id')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Materia --}}
                        <div class="mb-3">
                            <label class="form-label">
                                Materia <span class="text-danger">*</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-book-open position-absolute"
                                   style="left: 12px; top: 50%; transform: translateY(-50%);
                                          color: #00508f; font-size: 0.8rem; z-index: 10;"></i>
                                <select name="materia_id"
                                        class="form-select form-select-sm ps-5
                                               @error('materia_id') is-invalid @enderror"
                                        required>
                                    <option value="">Seleccione una materia...</option>
                                    @foreach($materias as $materia)
                                        <option value="{{ $materia->id }}"
                                            {{ old('materia_id') == $materia->id ? 'selected' : '' }}>
                                            {{ $materia->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('materia_id')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Sección --}}
                        <div class="mb-3">
                            <label class="form-label">
                                Sección <span class="text-danger">*</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-tag position-absolute"
                                   style="left: 12px; top: 50%; transform: translateY(-50%);
                                          color: #00508f; font-size: 0.8rem; z-index: 10;"></i>
                                <select name="seccion"
                                        class="form-select form-select-sm ps-5
                                               @error('seccion') is-invalid @enderror"
                                        required>
                                    <option value="">Seleccione una sección...</option>
                                    @foreach($secciones as $sec)
                                        <option value="{{ $sec }}"
                                            {{ old('seccion') == $sec ? 'selected' : '' }}>
                                            Sección {{ $sec }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('seccion')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit"
                                class="btn btn-sm w-100 fw-semibold"
                                style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
                                       color: white; border: none; border-radius: 8px; padding: 0.65rem;">
                            <i class="fas fa-plus me-1"></i> Agregar Asignación
                        </button>
                    </form>
                </div>
            </div>

            <div class="alert border-0 mt-2 py-2 px-3"
                 style="border-radius: 8px; background: rgba(78,199,210,0.08);
                        border-left: 3px solid #4ec7d2 !important; font-size: 0.82rem;">
                <i class="fas fa-info-circle me-2" style="color: #00508f;"></i>
                <span class="text-muted">
                    Selecciona el grado del sistema, la materia y la sección.
                    Puedes agregar múltiples asignaciones al mismo profesor.
                </span>
            </div>
        </div>

    </div>
</div>

@push('styles')
<style>
    .form-select-sm, .form-control-sm {
        border-radius: 7px;
        border: 1.5px solid #e2e8f0;
        font-size: 0.875rem;
        transition: all 0.25s ease;
    }
    .form-select-sm:focus, .form-control-sm:focus {
        border-color: #4ec7d2;
        box-shadow: 0 0 0 0.15rem rgba(78,199,210,0.15);
    }
    .form-label { color: #003b73; font-size: 0.83rem; margin-bottom: 0.3rem; }
    .border-bottom { border-color: rgba(0,80,143,0.12) !important; }
    .btn:hover { transform: translateY(-1px); transition: all 0.25s ease; }
    .btn-back:hover { background: #00508f !important; color: white !important; }
    .invalid-feedback { display: block; font-size: 0.75rem; margin-top: 0.2rem; }
</style>
@endpush
@endsection