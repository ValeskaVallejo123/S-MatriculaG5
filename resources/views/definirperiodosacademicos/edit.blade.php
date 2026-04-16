@extends('layouts.app')

@section('title', 'Editar Período Académico')
@section('page-title', 'Editar Período Académico')
@section('content-class', 'p-0')

@push('styles')
<style>
.epa-wrap {
    height: calc(100vh - 64px);
    display: flex; flex-direction: column;
    overflow: hidden; background: #f0f4f8;
}

/* Hero */
.epa-hero {
    background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #4ec7d2 100%);
    padding: 1.25rem 2rem; display: flex; align-items: center;
    justify-content: space-between; gap: 1rem; flex-shrink: 0;
}
.epa-hero-left { display: flex; align-items: center; gap: 1rem; }
.epa-hero-icon {
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,255,255,.15); border: 2px solid rgba(255,255,255,.3);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.epa-hero-icon i { font-size: 1.3rem; color: white; }
.epa-hero-title { font-size: 1.2rem; font-weight: 700; color: white; margin: 0 0 .15rem; }
.epa-hero-sub   { color: rgba(255,255,255,.7); font-size: .82rem; margin: 0; }
.epa-back-btn {
    display: inline-flex; align-items: center; gap: .4rem;
    background: white; color: #003b73; border: none;
    border-radius: 8px; padding: .5rem 1.1rem;
    font-size: .82rem; font-weight: 700; text-decoration: none;
    box-shadow: 0 2px 8px rgba(0,0,0,.15); flex-shrink: 0; transition: all .2s;
}
.epa-back-btn:hover { background: #f0f4f8; color: #003b73; }

/* Body */
.epa-body { flex: 1; overflow-y: auto; padding: 1.5rem 2rem; }

/* Form card */
.epa-card {
    background: white; border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,59,115,.08);
    border: 1px solid #e2e8f0;
    padding: 1.5rem; margin-bottom: 1rem;
}
.epa-section-title {
    font-size: .7rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .08em;
    color: #4ec7d2; margin-bottom: 1.1rem;
    padding-bottom: .5rem; border-bottom: 1px solid #f1f5f9;
    display: flex; align-items: center; gap: .4rem;
}

.form-control-sm, .form-select-sm {
    border-radius: 8px; border: 1.5px solid #e2e8f0;
    padding: .55rem .75rem; font-size: .875rem;
    transition: border-color .2s, box-shadow .2s;
}
.form-control-sm:focus, .form-select-sm:focus {
    border-color: #4ec7d2;
    box-shadow: 0 0 0 3px rgba(78,199,210,.12);
    outline: none;
}
.position-relative .fas { pointer-events: none; }

.epa-btn-save {
    display: inline-flex; align-items: center; gap: .4rem;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: white; border: none; border-radius: 8px;
    padding: .55rem 1.8rem; font-size: .9rem; font-weight: 700;
    box-shadow: 0 2px 8px rgba(78,199,210,.3); cursor: pointer;
    transition: opacity .2s;
}
.epa-btn-save:hover { opacity: .9; }
.epa-btn-cancel {
    display: inline-flex; align-items: center; gap: .4rem;
    border: 2px solid #00508f; color: #00508f; background: white;
    border-radius: 8px; padding: .5rem 1.2rem;
    font-size: .85rem; font-weight: 600; text-decoration: none;
    transition: all .2s;
}
.epa-btn-cancel:hover { background: #eff6ff; color: #003b73; }

/* Dark mode */
body.dark-mode .epa-wrap { background: #0f172a; }
body.dark-mode .epa-card { background: #1e293b; border-color: #334155; }
body.dark-mode .epa-section-title { border-color: #334155; }
body.dark-mode .form-control-sm,
body.dark-mode .form-select-sm { background: #0f172a; border-color: #334155; color: #cbd5e1; }
</style>
@endpush

@section('content')
<div class="epa-wrap">

    {{-- Hero --}}
    <div class="epa-hero">
        <div class="epa-hero-left">
            <div class="epa-hero-icon"><i class="fas fa-calendar-edit"></i></div>
            <div>
                <h2 class="epa-hero-title">Editar Período Académico</h2>
                <p class="epa-hero-sub">{{ $periodo->nombre_periodo }}</p>
            </div>
        </div>
        <a href="{{ route('periodos-academicos.index') }}" class="epa-back-btn">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    {{-- Body --}}
    <div class="epa-body">

        @if($errors->any())
            <div class="alert alert-danger border-0 shadow-sm mb-4"
                 style="border-radius:10px;border-left:4px solid #d32f2f !important;">
                @foreach($errors->all() as $error)
                    <div><i class="fas fa-exclamation-circle me-1"></i>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('periodos-academicos.update', $periodo->id) }}">
            @csrf
            @method('PUT')

            {{-- Fila 1: Nombre + Tipo --}}
            <div class="row g-3 mb-0">
                <div class="col-lg-6">
                    <div class="epa-card">
                        <div class="epa-section-title"><i class="fas fa-tag"></i> Identificación</div>
                        <label for="nombre_periodo" class="form-label small fw-semibold" style="color:#003b73;">
                            Nombre del período <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-tag position-absolute" style="left:12px;top:50%;transform:translateY(-50%);color:#00508f;font-size:.85rem;"></i>
                            <input type="text"
                                   class="form-control ps-5 form-control-sm @error('nombre_periodo') is-invalid @enderror"
                                   id="nombre_periodo" name="nombre_periodo"
                                   value="{{ old('nombre_periodo', $periodo->nombre_periodo) }}"
                                   placeholder="Ej: Primer Trimestre" required>
                            @error('nombre_periodo')
                                <div class="invalid-feedback" style="font-size:.8rem;"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="epa-card">
                        <div class="epa-section-title"><i class="fas fa-list"></i> Clasificación</div>
                        <label for="tipo" class="form-label small fw-semibold" style="color:#003b73;">
                            Tipo de período <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-list position-absolute" style="left:12px;top:50%;transform:translateY(-50%);color:#00508f;font-size:.85rem;"></i>
                            <select name="tipo" id="tipo"
                                    class="form-select form-select-sm ps-5 @error('tipo') is-invalid @enderror"
                                    required>
                                <option value="">Seleccione…</option>
                                <option value="clases"     {{ old('tipo', $periodo->tipo) == 'clases'     ? 'selected' : '' }}>Clases</option>
                                <option value="vacaciones" {{ old('tipo', $periodo->tipo) == 'vacaciones' ? 'selected' : '' }}>Vacaciones</option>
                                <option value="examenes"   {{ old('tipo', $periodo->tipo) == 'examenes'   ? 'selected' : '' }}>Exámenes</option>
                            </select>
                            @error('tipo')
                                <div class="invalid-feedback" style="font-size:.8rem;"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Fila 2: Fecha inicio + Fecha fin --}}
            <div class="row g-3">
                <div class="col-lg-6">
                    <div class="epa-card">
                        <div class="epa-section-title"><i class="fas fa-calendar-alt"></i> Fecha de Inicio</div>
                        <label for="fecha_inicio" class="form-label small fw-semibold" style="color:#003b73;">
                            Fecha de inicio <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-calendar-alt position-absolute" style="left:12px;top:50%;transform:translateY(-50%);color:#00508f;font-size:.85rem;"></i>
                            <input type="date"
                                   class="form-control ps-5 form-control-sm @error('fecha_inicio') is-invalid @enderror"
                                   id="fecha_inicio" name="fecha_inicio"
                                   value="{{ old('fecha_inicio', \Carbon\Carbon::parse($periodo->fecha_inicio)->format('Y-m-d')) }}"
                                   required>
                            @error('fecha_inicio')
                                <div class="invalid-feedback" style="font-size:.8rem;"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="epa-card">
                        <div class="epa-section-title"><i class="fas fa-calendar-check"></i> Fecha de Fin</div>
                        <label for="fecha_fin" class="form-label small fw-semibold" style="color:#003b73;">
                            Fecha de fin <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-calendar-check position-absolute" style="left:12px;top:50%;transform:translateY(-50%);color:#00508f;font-size:.85rem;"></i>
                            <input type="date"
                                   class="form-control ps-5 form-control-sm @error('fecha_fin') is-invalid @enderror"
                                   id="fecha_fin" name="fecha_fin"
                                   value="{{ old('fecha_fin', \Carbon\Carbon::parse($periodo->fecha_fin)->format('Y-m-d')) }}"
                                   required>
                            @error('fecha_fin')
                                <div class="invalid-feedback" style="font-size:.8rem;"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Nota --}}
            <div class="alert border-0 mb-4"
                 style="border-radius:8px;background:rgba(78,199,210,.08);border-left:3px solid #4ec7d2 !important;font-size:.85rem;">
                <i class="fas fa-info-circle me-2" style="color:#00508f;"></i>
                <strong style="color:#00508f;">Información importante:</strong>
                <span class="text-muted"> Verifique todos los datos. Las fechas deben ser válidas y la combinación nombre + período no debe repetirse.</span>
            </div>

            {{-- Botones --}}
            <div class="d-flex gap-3 align-items-center">
                <button type="submit" class="epa-btn-save">
                    <i class="fas fa-save"></i> Actualizar período
                </button>
                <a href="{{ route('periodos-academicos.index') }}" class="epa-btn-cancel">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>

        </form>
    </div>{{-- /epa-body --}}
</div>
@endsection
