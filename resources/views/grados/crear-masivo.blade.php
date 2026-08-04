@extends('layouts.app')

@section('title', 'Crear Grados Masivo')
@section('page-title', 'Creación Masiva de Grados')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    .adm-wrap { font-family: 'Inter', sans-serif; }

    /* Hero banner */
    .adm-hero {
        background: linear-gradient(135deg, #4ec7d2 0%, #00508f 60%, #003b73 100%);
        border-radius: 14px; padding: 1.6rem 1.75rem; margin-bottom: 1.5rem;
        display: flex; align-items: center; gap: 1.25rem;
        box-shadow: 0 4px 18px rgba(0,59,115,.18);
    }
    .adm-hero-icon {
        width: 56px; height: 56px; border-radius: 14px;
        background: rgba(255,255,255,.18); backdrop-filter: blur(6px);
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .adm-hero-icon i { font-size: 1.5rem; color: #fff; }
    .adm-hero-title { font-size: 1.35rem; font-weight: 700; color: #fff; margin: 0; line-height: 1.2; }
    .adm-hero-sub   { font-size: .82rem; color: rgba(255,255,255,.78); margin-top: .25rem; }

    /* Card sin max-width */
    .adm-card {
        background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
        overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.05);
    }
    .adm-card-head {
        background: #003b73; padding: .85rem 1.25rem;
        display: flex; align-items: center; gap: .6rem;
    }
    .adm-card-head i    { color: #4ec7d2; font-size: 1rem; }
    .adm-card-head span { color: #fff; font-weight: 700; font-size: .95rem; }
    .adm-card-body { padding: 1.5rem 1.25rem; }

    .frm-label {
        display: block; font-size: .75rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: .05em;
        color: #64748b; margin-bottom: .4rem;
    }
    .frm-label i { color: #4ec7d2; margin-right: .3rem; }

    .frm-control {
        width: 100%; padding: .45rem .75rem;
        border: 1.5px solid #e2e8f0; border-radius: 8px;
        font-size: .82rem; color: #0f172a;
        background: #f8fafc; outline: none;
        transition: border-color .15s, box-shadow .15s;
        font-family: 'Inter', sans-serif;
    }
    .frm-control:focus {
        border-color: #4ec7d2;
        box-shadow: 0 0 0 3px rgba(78,199,210,.12);
        background: #fff;
    }
    .frm-hint    { font-size: .72rem; color: #94a3b8; margin-top: .3rem; }
    .frm-divider { border: none; border-top: 1px solid #f1f5f9; margin: 1.25rem 0; }

    /* Dos columnas */
    .frm-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
    @media(max-width:600px){ .frm-row { grid-template-columns: 1fr; } }

    /* Info box */
    .cm-info-box {
        background: rgba(78,199,210,.08);
        border: 1px solid rgba(78,199,210,.3);
        border-left: 4px solid #4ec7d2;
        border-radius: 0 8px 8px 0;
        padding: .85rem 1rem; margin-bottom: 1.1rem;
    }
    .cm-info-title {
        font-size: .72rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .06em; color: #00508f; margin-bottom: .65rem;
    }
    .cm-grados-grid {
        display: grid; grid-template-columns: repeat(3,1fr); gap: .4rem;
    }
    @media(max-width:500px){ .cm-grados-grid { grid-template-columns: repeat(2,1fr); } }
    .cm-grado-chip {
        display: flex; align-items: center; gap: .35rem;
        padding: .28rem .65rem; border-radius: 6px; font-size: .75rem; font-weight: 600;
        background: white; color: #003b73; border: 1px solid rgba(78,199,210,.3);
    }
    .cm-grado-chip i { color: #4ec7d2; font-size: .65rem; }
    .cm-grado-chip.secundaria { background: #eef2ff; color: #4f46e5; border-color: rgba(99,102,241,.3); }
    .cm-grado-chip.secundaria i { color: #4f46e5; }

    /* Nota */
    .cm-note {
        background: rgba(245,158,11,.08);
        border: 1px solid rgba(245,158,11,.3);
        border-left: 4px solid #f59e0b;
        border-radius: 0 8px 8px 0;
        padding: .75rem 1rem; font-size: .82rem;
        color: #92400e; display: flex; align-items: flex-start; gap: .6rem;
        margin-bottom: 1.1rem;
    }
    .cm-note i { color: #f59e0b; margin-top: .1rem; flex-shrink: 0; }

    /* Switch */
    .perm-switch {
        border: 1.5px solid #e2e8f0; border-radius: 10px;
        background: #f8fafc; padding: .75rem 1rem;
        transition: border-color .18s, background .18s;
        height: 100%; box-sizing: border-box;
    }
    .perm-switch:hover { border-color: #4ec7d2; background: rgba(78,199,210,.04); }
    .perm-switch .form-check-input { width: 2.2em; height: 1.15em; cursor: pointer; }
    .perm-switch .form-check-input:checked { background-color: #003b73; border-color: #003b73; }
    .perm-switch strong { font-size: .88rem; color: #0f172a; }
    .perm-switch small  { font-size: .73rem; color: #64748b; }

    /* Botones */
    .frm-actions {
        display: flex; align-items: center; justify-content: space-between;
        gap: .75rem; flex-wrap: wrap;
    }
    .btn-cancel {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .45rem 1.1rem; border-radius: 7px; font-size: .82rem; font-weight: 600;
        background: #fff; color: #64748b; border: 1.5px solid #e2e8f0;
        text-decoration: none; cursor: pointer; transition: all .15s;
        font-family: 'Inter', sans-serif;
    }
    .btn-cancel:hover { border-color: #94a3b8; color: #334155; background: #f8fafc; }

    .btn-save {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .45rem 1.25rem; border-radius: 7px; font-size: .82rem; font-weight: 600;
        background: linear-gradient(135deg, #4ec7d2, #00508f);
        color: #fff; border: none; cursor: pointer;
        box-shadow: 0 4px 10px rgba(0,80,143,.25);
        transition: opacity .15s; font-family: 'Inter', sans-serif;
    }
    .btn-save:hover { opacity: .88; }
</style>
@endpush

@section('content')
<div class="adm-wrap container-fluid px-4">

    {{-- Hero --}}
    <div class="adm-hero">
        <div class="adm-hero-icon">
            <i class="fas fa-th"></i>
        </div>
        <div>
            <div class="adm-hero-title">Creación masiva de grados</div>
            <div class="adm-hero-sub">Genera automáticamente los 9 grados × 4 secciones para el año 2026</div>
        </div>
    </div>

    <div class="adm-card">
        <div class="adm-card-head">
            <i class="fas fa-sliders-h"></i>
            <span>Configuración de generación</span>
        </div>
        <div class="adm-card-body">

            {{-- Info: qué se va a crear --}}
            <div class="cm-info-box">
                <div class="cm-info-title">
                    <i class="fas fa-info-circle me-1"></i>
                    Se crearán los siguientes grados (secciones A, B, C, D por cada uno)
                </div>
                <div class="cm-grados-grid">
                    @foreach(['Primer Grado','Segundo Grado','Tercer Grado','Cuarto Grado','Quinto Grado','Sexto Grado'] as $g)
                        <span class="cm-grado-chip">
                            <i class="fas fa-school"></i> {{ $g }}
                        </span>
                    @endforeach
                    @foreach(['Séptimo Grado','Octavo Grado','Noveno Grado'] as $g)
                        <span class="cm-grado-chip secundaria">
                            <i class="fas fa-university"></i> {{ $g }}
                        </span>
                    @endforeach
                </div>
                <div style="margin-top:.65rem;font-size:.75rem;color:#94a3b8;">
                    <i class="fas fa-equals me-1" style="color:#4ec7d2;"></i>
                    Total: <strong style="color:#003b73;">36 grados</strong> (9 grados × 4 secciones)
                </div>
            </div>

            {{-- Nota --}}
            <div class="cm-note">
                <i class="fas fa-exclamation-triangle"></i>
                <div>
                    Los grados que ya existan no se duplicarán — se actualizarán con el estado seleccionado.
                    Las materias por defecto se asignarán solo a los grados de primaria que se creen por primera vez.
                </div>
            </div>

            {{-- Errores --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"
                     style="border-left:4px solid #ef4444;border-radius:8px;font-size:.82rem;">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Corrige los siguientes errores:</strong>
                    <ul class="mb-0 mt-1 ps-3">
                        @foreach (collect($errors->all())->unique() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Formulario --}}
            <form id="gradosForm"
                  action="{{ route('superadmin.grados.generar-masivo') }}"
                  method="POST"
                  data-confirm="¿Generar los 36 grados (9 × 4 secciones) para el año 2026?">
                @csrf

                {{-- Fila: capacidad + toggle --}}
                <div class="frm-row mb-3">

                    <div>
                        <label for="capacidad_maxima" class="frm-label">
                            <i class="fas fa-users"></i> Capacidad máxima por sección
                        </label>
                        <input type="number"
                               id="capacidad_maxima"
                               name="capacidad_maxima"
                               class="frm-control @error('capacidad_maxima') is-invalid @enderror"
                               value="{{ old('capacidad_maxima', 30) }}"
                               min="1" max="60" required>
                        @error('capacidad_maxima')
                            <div style="font-size:.78rem;color:#ef4444;margin-top:.3rem;">{{ $message }}</div>
                        @enderror
                        <p class="frm-hint">Entre 1 y 60 estudiantes por sección.</p>
                    </div>

                    <div>
                        <label class="frm-label">
                            <i class="fas fa-toggle-on"></i> Estado de los grados
                        </label>
                        <div class="perm-switch form-check form-switch">
                            <input class="form-check-input me-2" type="checkbox"
                                   id="activo" name="activo" value="1"
                                   {{ old('activo', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="activo">
                                <strong>Crear grados como activos</strong>
                                <small class="d-block">Los grados aparecerán disponibles inmediatamente en el sistema</small>
                            </label>
                        </div>
                    </div>

                </div>

                <hr class="frm-divider">

                <div class="frm-actions">
                    <a href="{{ route('superadmin.grados.index') }}" class="btn-cancel">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <button type="submit" class="btn-save">
                        <i class="fas fa-th"></i> Generar 36 grados
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection