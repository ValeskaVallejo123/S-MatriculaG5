@extends('layouts.app')

@section('title', 'Editar Documentos')
@section('page-title', 'Editar Documentos')

@section('topbar-actions')
    <a href="{{ route('estudiantes.show', $documento->estudiante_id) }}"
       class="doc-btn-ghost">
        <i class="fas fa-arrow-left"></i>
        <span class="doc-btn-text">Volver al perfil</span>
    </a>
@endsection

@push('styles')
<style>
    .doc-btn-ghost {
        display: inline-flex; align-items: center; gap: .45rem;
        background: transparent; color: white;
        padding: .5rem .9rem; border-radius: 8px;
        text-decoration: none; font-weight: 600; font-size: .83rem;
        border: 1.5px solid rgba(255,255,255,.35); white-space: nowrap;
        transition: background .2s;
    }
    .doc-btn-ghost:hover { background: rgba(255,255,255,.12); color: white; }
    @media(max-width:600px) {
        .doc-btn-text { display: none; }
        .doc-btn-ghost { padding: .5rem .65rem; }
    }

    :root {
        --blue-dark:  #003b73;
        --blue-mid:   #00508f;
        --teal:       #4ec7d2;
        --teal-light: rgba(78,199,210,0.12);
        --border:     #e8edf4;
        --surface:    #f5f8fc;
        --text-main:  #0d2137;
        --text-muted: #6b7a90;
        --green:      #10b981;
        --red:        #ef4444;
        --radius-lg:  14px;
        --shadow-sm:  0 1px 4px rgba(0,59,115,0.07);
    }

    /* ── Card base ── */
    .doc-card {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); overflow: hidden;
        box-shadow: var(--shadow-sm); margin-bottom: 1.25rem;
    }
    .doc-card-head {
        background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-mid) 100%);
        padding: .9rem 1.4rem; display: flex; align-items: center; gap: .6rem;
    }
    .doc-card-head i    { color: var(--teal); font-size: 1rem; }
    .doc-card-head span { color: white; font-weight: 700; font-size: .95rem; }
    .doc-card-body { padding: 1.5rem 1.4rem; }

    /* ── Perfil estudiante ── */
    .doc-estudiante {
        display: flex; align-items: center; gap: 1rem;
        padding: .9rem 1.1rem; border-radius: 10px;
        background: var(--surface); border: 1px solid var(--border);
        margin-bottom: 1.5rem;
    }
    .doc-av {
        width: 44px; height: 44px; border-radius: 11px; flex-shrink: 0;
        background: linear-gradient(135deg, var(--teal), var(--blue-mid));
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; color: white; font-size: 1rem;
        border: 2px solid rgba(78,199,210,.35);
        overflow: hidden;
    }
    .doc-av img { width: 100%; height: 100%; object-fit: cover; }
    .doc-est-name { font-weight: 700; color: var(--blue-dark); font-size: .9rem; }
    .doc-est-sub  { font-size: .75rem; color: var(--text-muted); margin-top: .1rem; }

    /* ── Sección ── */
    .doc-section-title {
        font-size: .72rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .07em; color: var(--teal);
        margin-bottom: 1rem; padding-bottom: .45rem;
        border-bottom: 1.5px solid var(--teal-light);
        display: flex; align-items: center; gap: .4rem;
    }

    /* ── Label / input ── */
    .doc-label {
        font-size: .72rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .05em; color: var(--blue-dark);
        margin-bottom: .4rem; display: block;
    }
    .doc-input {
        width: 100%; padding: .5rem .85rem;
        border: 2px solid #bfd9ea; border-radius: 8px;
        font-size: .88rem; font-family: inherit;
        color: var(--text-main); outline: none; background: white;
        transition: border-color .2s, box-shadow .2s;
    }
    .doc-input:focus {
        border-color: var(--teal);
        box-shadow: 0 0 0 3px rgba(78,199,210,.12);
    }
    .doc-hint {
        font-size: .72rem; color: var(--text-muted);
        margin-top: .35rem; display: flex; align-items: center; gap: .25rem;
    }
    .doc-error {
        font-size: .72rem; color: var(--red);
        margin-top: .35rem; display: flex; align-items: center; gap: .25rem;
    }

    /* ── Preview archivo actual ── */
    .doc-preview-btn {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .35rem .8rem; border-radius: 7px;
        font-size: .75rem; font-weight: 600;
        border: 1.5px solid var(--teal); color: var(--blue-mid);
        background: var(--teal-light); text-decoration: none;
        transition: all .15s; margin-bottom: .5rem;
    }
    .doc-preview-btn:hover { background: var(--teal); color: white; }

    .doc-no-file {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .35rem .8rem; border-radius: 7px;
        font-size: .75rem; color: #94a3b8;
        border: 1.5px dashed #e2e8f0; background: #f8fafc;
        margin-bottom: .5rem;
    }

    /* ── Foto preview ── */
    .foto-preview {
        width: 110px; height: 110px; border-radius: 12px; object-fit: cover;
        border: 3px solid var(--teal);
        box-shadow: 0 2px 8px rgba(78,199,210,.25);
    }
    .foto-placeholder {
        width: 110px; height: 110px; border-radius: 12px;
        border: 2px dashed #bfd9ea; background: var(--surface);
        display: flex; align-items: center; justify-content: center;
        color: #cbd5e1; font-size: 2rem;
    }

    /* ── Botones footer ── */
    .doc-footer {
        display: flex; align-items: center; gap: .75rem;
        padding-top: 1.25rem; border-top: 1px solid var(--border);
        flex-wrap: wrap;
    }
    .btn-guardar {
        display: inline-flex; align-items: center; gap: .45rem;
        padding: .65rem 1.6rem; border-radius: 9px;
        background: linear-gradient(135deg, var(--teal), var(--blue-mid));
        color: white; border: none; font-size: .88rem; font-weight: 700;
        cursor: pointer; font-family: inherit;
        box-shadow: 0 3px 10px rgba(0,80,143,.25);
        transition: opacity .2s, transform .15s;
    }
    .btn-guardar:hover  { opacity: .88; transform: translateY(-1px); }
    .btn-guardar:active { transform: translateY(0); }
    .btn-cancelar {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .65rem 1.1rem; border-radius: 9px;
        background: white; color: var(--text-muted);
        border: 1.5px solid var(--border);
        font-size: .88rem; font-weight: 600;
        text-decoration: none; transition: all .2s;
    }
    .btn-cancelar:hover { border-color: #94a3b8; color: var(--text-main); }
</style>
@endpush

@section('content')
<div style="max-width:860px;">

    {{-- ── Card principal ── --}}
    <div class="doc-card">
        <div class="doc-card-head">
            <i class="fas fa-file-edit"></i>
            <span>Actualizar expediente</span>
        </div>
        <div class="doc-card-body">

            {{-- Estudiante asociado (solo lectura) ── --}}
            <div class="doc-estudiante">
                <div class="doc-av">
                    @if($documento->estudiante?->foto)
                        <img src="{{ asset('storage/' . $documento->estudiante->foto) }}" alt="Foto">
                    @else
                        {{ strtoupper(substr($documento->estudiante?->nombre1 ?? 'E', 0, 1)) }}{{ strtoupper(substr($documento->estudiante?->apellido1 ?? '', 0, 1)) }}
                    @endif
                </div>
                <div>
                    <div class="doc-est-name">
                        {{ $documento->estudiante?->nombre1 }}
                        {{ $documento->estudiante?->nombre2 }}
                        {{ $documento->estudiante?->apellido1 }}
                        {{ $documento->estudiante?->apellido2 }}
                    </div>
                    <div class="doc-est-sub">
                        <i class="fas fa-id-card" style="font-size:.65rem;"></i>
                        {{ $documento->estudiante?->dni ?? 'Sin DNI' }}
                        &nbsp;·&nbsp;
                        {{ $documento->estudiante?->grado ?? '' }}
                        {{ $documento->estudiante?->seccion ? '— Sec. '.$documento->estudiante->seccion : '' }}
                    </div>
                </div>
                <span style="margin-left:auto;font-size:.72rem;color:var(--text-muted);
                             background:var(--surface);border:1px solid var(--border);
                             padding:.2rem .6rem;border-radius:6px;">
                    <i class="fas fa-lock" style="font-size:.65rem;"></i> Solo lectura
                </span>
            </div>

            <form action="{{ route('documentos.update', $documento->id) }}"
                  method="POST" enctype="multipart/form-data"
                  id="form-documentos">
                @csrf
                @method('PUT')

                {{-- ── Fotografía ── --}}
                <div style="margin-bottom:1.5rem;">
                    <div class="doc-section-title">
                        <i class="fas fa-camera"></i> Fotografía del estudiante
                    </div>
                    <div style="display:flex;align-items:flex-start;gap:1.25rem;flex-wrap:wrap;">
                        <div>
                            @if($documento->foto)
                                <img src="{{ asset('storage/' . $documento->foto) }}"
                                     class="foto-preview" alt="Foto actual">
                            @else
                                <div class="foto-placeholder">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                            <div style="font-size:.68rem;color:var(--text-muted);margin-top:.4rem;text-align:center;">
                                Foto actual
                            </div>
                        </div>
                        <div style="flex:1;min-width:200px;">
                            <label class="doc-label">
                                <i class="fas fa-upload" style="font-size:.75rem;color:var(--teal);"></i>
                                Reemplazar fotografía
                            </label>
                            <input type="file" name="foto" accept="image/jpeg,image/png"
                                   class="doc-input" style="padding:.42rem .85rem;">
                            <span class="doc-hint">
                                <i class="fas fa-info-circle"></i>
                                Deja vacío para conservar la actual. JPG o PNG, máx. 2 MB.
                            </span>
                            @error('foto')
                                <span class="doc-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- ── Documentos ── --}}
                <div style="margin-bottom:1.5rem;">
                    <div class="doc-section-title">
                        <i class="fas fa-folder-open"></i> Documentos del expediente
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">

                        {{-- Acta de nacimiento --}}
                        <div>
                            <label class="doc-label">
                                <i class="fas fa-file-alt" style="font-size:.75rem;color:var(--teal);"></i>
                                Acta de nacimiento
                            </label>
                            @if($documento->acta_nacimiento)
                                <a href="{{ asset('storage/' . $documento->acta_nacimiento) }}"
                                   target="_blank" class="doc-preview-btn">
                                    <i class="fas fa-eye"></i> Ver archivo actual
                                </a>
                            @else
                                <div class="doc-no-file">
                                    <i class="fas fa-times-circle"></i> Sin archivo
                                </div>
                            @endif
                            <input type="file" name="acta_nacimiento"
                                   accept=".pdf,.jpg,.jpeg,.png"
                                   class="doc-input" style="padding:.42rem .85rem;">
                            <span class="doc-hint">
                                <i class="fas fa-info-circle"></i>
                                Deja vacío para conservar el actual. PDF, JPG o PNG, máx. 5 MB.
                            </span>
                            @error('acta_nacimiento')
                                <span class="doc-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Calificaciones --}}
                        <div>
                            <label class="doc-label">
                                <i class="fas fa-graduation-cap" style="font-size:.75rem;color:var(--teal);"></i>
                                Calificaciones anteriores
                            </label>
                            @if($documento->calificaciones)
                                <a href="{{ asset('storage/' . $documento->calificaciones) }}"
                                   target="_blank" class="doc-preview-btn">
                                    <i class="fas fa-eye"></i> Ver archivo actual
                                </a>
                            @else
                                <div class="doc-no-file">
                                    <i class="fas fa-times-circle"></i> Sin archivo
                                </div>
                            @endif
                            <input type="file" name="calificaciones"
                                   accept=".pdf,.jpg,.jpeg,.png"
                                   class="doc-input" style="padding:.42rem .85rem;">
                            <span class="doc-hint">
                                <i class="fas fa-info-circle"></i>
                                Deja vacío para conservar el actual. PDF, JPG o PNG, máx. 5 MB.
                            </span>
                            @error('calificaciones')
                                <span class="doc-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Tarjeta identidad padre --}}
                        <div>
                            <label class="doc-label">
                                <i class="fas fa-id-card" style="font-size:.75rem;color:var(--teal);"></i>
                                Tarjeta identidad del padre
                            </label>
                            @if($documento->tarjeta_identidad_padre)
                                <a href="{{ asset('storage/' . $documento->tarjeta_identidad_padre) }}"
                                   target="_blank" class="doc-preview-btn">
                                    <i class="fas fa-eye"></i> Ver archivo actual
                                </a>
                            @else
                                <div class="doc-no-file">
                                    <i class="fas fa-times-circle"></i> Sin archivo
                                </div>
                            @endif
                            <input type="file" name="tarjeta_identidad_padre"
                                   accept=".pdf,.jpg,.jpeg,.png"
                                   class="doc-input" style="padding:.42rem .85rem;">
                            <span class="doc-hint">
                                <i class="fas fa-info-circle"></i>
                                Opcional. PDF, JPG o PNG, máx. 5 MB.
                            </span>
                            @error('tarjeta_identidad_padre')
                                <span class="doc-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Constancia médica --}}
                        <div>
                            <label class="doc-label">
                                <i class="fas fa-notes-medical" style="font-size:.75rem;color:var(--teal);"></i>
                                Constancia médica
                            </label>
                            @if($documento->constancia_medica)
                                <a href="{{ asset('storage/' . $documento->constancia_medica) }}"
                                   target="_blank" class="doc-preview-btn">
                                    <i class="fas fa-eye"></i> Ver archivo actual
                                </a>
                            @else
                                <div class="doc-no-file">
                                    <i class="fas fa-times-circle"></i> Sin archivo
                                </div>
                            @endif
                            <input type="file" name="constancia_medica"
                                   accept=".pdf,.jpg,.jpeg,.png"
                                   class="doc-input" style="padding:.42rem .85rem;">
                            <span class="doc-hint">
                                <i class="fas fa-info-circle"></i>
                                Opcional. PDF, JPG o PNG, máx. 5 MB.
                            </span>
                            @error('constancia_medica')
                                <span class="doc-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- ── Acciones ── --}}
                <div class="doc-footer">
                    <button type="submit" class="btn-guardar" id="btn-guardar">
                        <i class="fas fa-save"></i> Actualizar expediente
                    </button>
                    <a href="{{ route('estudiantes.show', $documento->estudiante_id) }}"
                       class="btn-cancelar">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.getElementById('form-documentos').addEventListener('submit', function () {
    var btn = document.getElementById('btn-guardar');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
});
</script>
@endpush