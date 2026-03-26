@extends('layouts.app')

@section('title', 'Editar Matrícula')
@section('page-title', 'Editar Matrícula')

@section('topbar-actions')
    <a href="{{ route('matriculas.show', $matricula->id) }}"
       style="background:white; color:#00508f;
              padding:.6rem .75rem; border-radius:9px; font-size:.83rem; font-weight:600;
              display:inline-flex; align-items:center; gap:.4rem;
              text-decoration:none; border:1.5px solid #00508f; transition:all .2s;">
        <i class="fas fa-eye"></i> Ver Detalles
    </a>
@endsection

@push('styles')
<style>
/* ════════════════════════════════════════════════
   TAMAÑOS — igualados al perfil del estudiante
   ════════════════════════════════════════════════ */
:root {
    --blue-dark:  #003b73;
    --blue-mid:   #00508f;
    --cyan:       #4ec7d2;
    --cyan-light: rgba(78,199,210,.1);
    --cyan-border:#b2e8ed;
    --red:        #ef4444;
    --surface:    #f5f8fc;
    --border:     #e8edf4;
    --text:       #0d2137;
    --muted:      #6b7a90;
    --subtle:     #94a3b8;
}

/* ── Wrapper ── */
.edit-wrap {
    width: 100%;                          /* ← sin max-width, igual que el perfil */
}

/* ── Alerts ── */
.em-alert {
    display: flex; align-items: flex-start; gap: .75rem;
    padding: .9rem 1.1rem; border-radius: 10px;
    font-size: .83rem;                    /* ← TAMAÑO texto alertas */
    margin-bottom: 1rem;
}
.em-alert-success { background: #f0fdf4; border: 1px solid #86efac; color: #166534; }
.em-alert-danger  { background: #fef2f2; border: 1px solid #fca5a5; color: #991b1b; }
.em-alert-info    { background: var(--cyan-light); border: 1px solid var(--cyan-border); color: var(--blue-dark); }
.em-alert i       { margin-top: .05rem; flex-shrink: 0; }
.em-alert ul      { margin: .4rem 0 0 1rem; padding: 0; }

/* ── Labels ── */
.em-label {
    display: block;
    font-size: .63rem; font-weight: 700;  /* ← TAMAÑO labels */
    letter-spacing: .08em; text-transform: uppercase;
    color: var(--blue-dark); margin-bottom: .22rem;
}
.em-label .req { color: var(--red); }

/* ── Inputs, Selects, Textarea ── */
.em-input,
.em-select,
.em-textarea {
    width: 100%;
    background: #fff;
    border: 2px solid #bfd9ea;            /* ← BORDE inputs */
    border-radius: 10px;                  /* ← REDONDEZ inputs */
    padding: 0.68rem 1rem;               /* ← ALTO inputs */
    font-size: .88rem; font-weight: 500;  /* ← TEXTO inputs */
    color: var(--text);
    transition: border-color .2s, box-shadow .2s;
    font-family: inherit;
    appearance: none;
    height: auto;
}
.em-input:focus, .em-select:focus, .em-textarea:focus {
    outline: none;
    border-color: var(--cyan);
    box-shadow: 0 0 0 0.15rem rgba(78,199,210,.15);
}
.em-input.readonly {
    background: #f1f5f9; color: var(--muted); cursor: not-allowed;
}
.em-input.is-invalid, .em-select.is-invalid, .em-textarea.is-invalid {
    border-color: var(--red);
    box-shadow: 0 0 0 0.15rem rgba(239,68,68,.1);
}
.em-select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748b' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right .75rem center;
    padding-right: 2.5rem;
}
.em-textarea {
    resize: vertical;
    min-height: 80px;                     /* ← ALTO textarea */
}

/* ── Mensajes error ── */
.em-error {
    font-size: .7rem; color: var(--red);  /* ← TAMAÑO mensajes error */
    margin-top: .22rem; font-weight: 500;
    display: flex; align-items: center; gap: .3rem;
}

/* ── Fields grid ── */
.fields-grid {
    display: grid; grid-template-columns: 1fr 1fr; gap: 1.1rem;
}
.fields-grid.cols-3 { grid-template-columns: 1fr 1fr 1fr; }
@media(max-width:640px) {
    .fields-grid, .fields-grid.cols-3 { grid-template-columns: 1fr; }
}
.col-full { grid-column: 1 / -1; }

/* ── Título de sección ── */
.sm-sec-title {
    display: flex; align-items: center; gap: .5rem;
    font-size: .75rem; font-weight: 700;  /* ← TAMAÑO títulos de sección */
    text-transform: uppercase; letter-spacing: .08em;
    color: var(--blue-mid);
    margin-bottom: .95rem; padding-bottom: .55rem;
    border-bottom: 2px solid rgba(78,199,210,.1);
}
.sm-sec-title i { color: var(--cyan); font-size: .88rem; }

/* ── Título sección claro ── */
.sm-sec-title-light {
    display: flex; align-items: center; gap: .5rem;
    font-size: .75rem; font-weight: 700;  /* ← TAMAÑO títulos sección clara */
    text-transform: uppercase; letter-spacing: .08em;
    color: var(--blue-dark);
    margin-bottom: .95rem; padding-bottom: .55rem;
    border-bottom: 2px solid var(--cyan-border);
}
.sm-sec-title-light i { color: var(--cyan); font-size: .88rem; }

/* ── Doc upload rows ── */
.doc-row {
    background: var(--surface);
    border: 2px solid #bfd9ea;            /* ← BORDE doc rows */
    border-radius: 10px;                  /* ← REDONDEZ doc rows */
    padding: .85rem 1rem;
    transition: border-color .2s;
}
.doc-row:hover { border-color: var(--cyan-border); }

.doc-row-top {
    display: flex; align-items: center; gap: .6rem;
    margin-bottom: .55rem;
}
.doc-icon {
    width: 34px; height: 34px; border-radius: 8px; flex-shrink: 0;
    background: linear-gradient(135deg, var(--cyan), var(--blue-mid));
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: .78rem;       /* ← TAMAÑO ícono doc */
}
.doc-label-text {
    font-size: .83rem; font-weight: 700;  /* ← TAMAÑO nombre doc */
    color: var(--blue-dark);
}
.doc-current {
    display: inline-flex; align-items: center; gap: .3rem;
    font-size: .7rem; color: #16a34a; font-weight: 600; /* ← TAMAÑO link archivo actual */
    background: #f0fdf4; border: 1px solid #86efac;
    border-radius: 999px; padding: .15rem .55rem;
    text-decoration: none;
}
.doc-current:hover { background: #dcfce7; color: #15803d; }
.doc-hint {
    font-size: .68rem; color: var(--subtle); /* ← TAMAÑO hint doc */
    margin-top: .3rem;
}

/* ── Motivo rechazo animation ── */
#motivo-rechazo-container {
    overflow: hidden;
    transition: max-height .25s ease, opacity .25s ease;
    max-height: 0; opacity: 0;
}
#motivo-rechazo-container.visible {
    max-height: 120px; opacity: 1;
}

/* ── Botón Guardar ── */
.btn-save {
    flex: 1; min-width: 140px;
    justify-content: center;
    background: linear-gradient(135deg, var(--cyan), var(--blue-mid));
    color: white; border: none;
    border-radius: 9px;                   /* ← REDONDEZ botón guardar */
    padding: .6rem .75rem;               /* ← TAMAÑO botón guardar */
    font-size: .83rem; font-weight: 600;  /* ← TEXTO botón guardar */
    box-shadow: 0 2px 10px rgba(78,199,210,.3);
    transition: all .2s;
    display: inline-flex; align-items: center; gap: .45rem;
    cursor: pointer; font-family: inherit;
}
.btn-save:hover {
    color: white;
    box-shadow: 0 4px 16px rgba(78,199,210,.4);
    transform: translateY(-2px);
}

/* ── Botón Cancelar ── */
.btn-cancel {
    flex: 1; min-width: 120px;
    justify-content: center;
    border: 1.5px solid var(--blue-mid);  /* ← GROSOR borde botón cancelar */
    color: var(--blue-mid); background: white;
    border-radius: 9px;                   /* ← REDONDEZ botón cancelar */
    padding: .6rem .75rem;               /* ← TAMAÑO botón cancelar */
    font-size: .83rem; font-weight: 600;  /* ← TEXTO botón cancelar */
    transition: all .2s;
    display: inline-flex; align-items: center; gap: .45rem;
    cursor: pointer; text-decoration: none; font-family: inherit;
}
.btn-cancel:hover {
    background: #eff6ff; color: var(--blue-mid);
    transform: translateY(-2px);
}
</style>
@endpush

@section('content')
<div class="edit-wrap">

    {{-- ── HEADER ── --}}
    <div style="border-radius:14px 14px 0 0;
                background:linear-gradient(135deg,#002d5a 0%,#00508f 55%,#0077b6 100%);
                padding:2rem 1.7rem; position:relative; overflow:hidden;">

        <div style="position:absolute;right:-50px;top:-50px;width:200px;height:200px;
                    border-radius:50%;background:rgba(78,199,210,.13);pointer-events:none;"></div>
        <div style="position:absolute;right:100px;bottom:-45px;width:120px;height:120px;
                    border-radius:50%;background:rgba(255,255,255,.05);pointer-events:none;"></div>

        <div style="position:relative;z-index:1;display:flex;align-items:center;gap:1.4rem;flex-wrap:wrap;">
            <div style="width:80px;height:80px;              {{-- ← TAMAÑO ícono header --}}
                        border-radius:18px;
                        border:3px solid rgba(78,199,210,.7);
                        background:rgba(255,255,255,.12);
                        display:flex;align-items:center;justify-content:center;
                        box-shadow:0 6px 20px rgba(0,0,0,.25);">
                <i class="fas fa-clipboard-check" style="color:white;font-size:2rem;"></i> {{-- ← ÍCONO interno --}}
            </div>
            <div>
                <h2 style="font-size:1.45rem;font-weight:800;color:white; {{-- ← TÍTULO header --}}
                           margin:0 0 .4rem;text-shadow:0 1px 4px rgba(0,0,0,.2);">
                    Editar Matrícula
                </h2>
                <span style="display:inline-flex;align-items:center;gap:.3rem;
                             padding:.2rem .65rem;border-radius:999px;
                             background:rgba(255,255,255,.14);color:rgba(255,255,255,.92);
                             font-size:.72rem;font-weight:600; {{-- ← TEXTO tag subtítulo --}}
                             border:1px solid rgba(255,255,255,.18);">
                    <i class="fas fa-pen"></i> {{ $matricula->codigo_matricula }}
                </span>
            </div>
        </div>
    </div>

    {{-- ── BODY ── --}}
    <div style="background:white;border:1px solid #e8edf4;border-top:none;
                border-radius:0 0 14px 14px;box-shadow:0 2px 16px rgba(0,59,115,.09);">

        {{-- Alerts --}}
        @if(session('success'))
        <div style="padding:1rem 1.7rem 0;">
            <div class="em-alert em-alert-success">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div style="padding:1rem 1.7rem 0;">
            <div class="em-alert em-alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    <strong>Por favor corrige los siguientes errores:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('matriculas.update', $matricula->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- ══════════════════════════════════════
                 SECCIÓN 1 · INFORMACIÓN DE LA MATRÍCULA
            ══════════════════════════════════════ --}}
            <div style="padding:1.4rem 1.7rem; border-bottom:1px solid #f0f4f9;">

                <div class="sm-sec-title">
                    <i class="fas fa-clipboard-check"></i> Información de la Matrícula
                </div>

                <div class="fields-grid cols-3">

                    {{-- Código --}}
                    <div>
                        <label class="em-label" for="codigo_matricula">
                            <i class="fas fa-barcode"></i> Código
                        </label>
                        <input type="text" class="em-input readonly"
                               id="codigo_matricula" name="codigo_matricula"
                               value="{{ old('codigo_matricula', $matricula->codigo_matricula) }}" readonly>
                    </div>

                    {{-- Año Lectivo --}}
                    <div>
                        <label class="em-label" for="anio_lectivo">
                            <i class="fas fa-calendar-alt"></i> Año Lectivo <span class="req">*</span>
                        </label>
                        <input type="text"
                               class="em-input @error('anio_lectivo') is-invalid @enderror"
                               id="anio_lectivo" name="anio_lectivo"
                               value="{{ old('anio_lectivo', $matricula->anio_lectivo) }}"
                               placeholder="2025">
                        @error('anio_lectivo')
                            <div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Fecha --}}
                    <div>
                        <label class="em-label" for="fecha_matricula">
                            <i class="fas fa-calendar"></i> Fecha de Matrícula <span class="req">*</span>
                        </label>
                        <input type="date"
                               class="em-input @error('fecha_matricula') is-invalid @enderror"
                               id="fecha_matricula" name="fecha_matricula"
                               value="{{ old('fecha_matricula', $matricula->fecha_matricula
                                   ? \Carbon\Carbon::parse($matricula->fecha_matricula)->format('Y-m-d')
                                   : '') }}">
                        @error('fecha_matricula')
                            <div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Estado --}}
                    <div>
                        <label class="em-label" for="estado">
                            <i class="fas fa-flag"></i> Estado <span class="req">*</span>
                        </label>
                        <select class="em-select @error('estado') is-invalid @enderror"
                                id="estado" name="estado">
                            <option value="pendiente"  {{ old('estado',$matricula->estado)==='pendiente' ?'selected':'' }}>Pendiente</option>
                            <option value="aprobada"   {{ old('estado',$matricula->estado)==='aprobada'  ?'selected':'' }}>Aprobada</option>
                            <option value="rechazada"  {{ old('estado',$matricula->estado)==='rechazada' ?'selected':'' }}>Rechazada</option>
                            <option value="cancelada"  {{ old('estado',$matricula->estado)==='cancelada' ?'selected':'' }}>Cancelada</option>
                        </select>
                        @error('estado')
                            <div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Motivo Rechazo --}}
                    <div id="motivo-rechazo-container"
                         class="{{ old('estado',$matricula->estado)==='rechazada' ? 'visible' : '' }}">
                        <label class="em-label" for="motivo_rechazo">
                            <i class="fas fa-exclamation-triangle"></i> Motivo del Rechazo
                        </label>
                        <input type="text"
                               class="em-input @error('motivo_rechazo') is-invalid @enderror"
                               id="motivo_rechazo" name="motivo_rechazo"
                               value="{{ old('motivo_rechazo', $matricula->motivo_rechazo) }}"
                               placeholder="Especificar motivo...">
                        @error('motivo_rechazo')
                            <div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Observaciones --}}
                    <div class="col-full">
                        <label class="em-label" for="observaciones">
                            <i class="fas fa-sticky-note"></i> Observaciones
                        </label>
                        <textarea class="em-textarea @error('observaciones') is-invalid @enderror"
                                  id="observaciones" name="observaciones"
                                  placeholder="Agregar observaciones adicionales...">{{ old('observaciones', $matricula->observaciones) }}</textarea>
                        @error('observaciones')
                            <div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>{{-- fin sección 1 --}}

            {{-- ══════════════════════════════════════
                 SECCIÓN 2 · DOCUMENTOS ADJUNTOS
            ══════════════════════════════════════ --}}
            <div style="padding:1.4rem 1.7rem; border-bottom:1px solid #f0f4f9;">

                <div class="sm-sec-title-light">
                    <i class="fas fa-paperclip"></i> Documentos Adjuntos
                </div>

                <div class="em-alert em-alert-info" style="margin-bottom:1.1rem;">
                    <i class="fas fa-info-circle"></i>
                    <span>Solo sube nuevos archivos si deseas reemplazar los existentes. Los archivos actuales se mantendrán si no subes ninguno nuevo.</span>
                </div>

                <div class="fields-grid">

                    {{-- Foto del Estudiante --}}
                    <div class="doc-row">
                        <div class="doc-row-top">
                            <div class="doc-icon"><i class="fas fa-camera"></i></div>
                            <div>
                                <div class="doc-label-text">Foto del Estudiante</div>
                                @if($matricula->foto_estudiante)
                                    <a href="{{ asset('storage/'.$matricula->foto_estudiante) }}" target="_blank" class="doc-current">
                                        <i class="fas fa-check-circle"></i> Ver archivo actual
                                    </a>
                                @endif
                            </div>
                        </div>
                        <input type="file"
                               class="em-input @error('foto_estudiante') is-invalid @enderror"
                               id="foto_estudiante" name="foto_estudiante" accept="image/*"
                               style="padding:.45rem .75rem; font-size:.78rem;">
                        <div class="doc-hint"><i class="fas fa-info-circle"></i> JPG, PNG · Máx. 2MB</div>
                        @error('foto_estudiante')
                            <div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Acta de Nacimiento --}}
                    <div class="doc-row">
                        <div class="doc-row-top">
                            <div class="doc-icon"><i class="fas fa-file-alt"></i></div>
                            <div>
                                <div class="doc-label-text">Acta de Nacimiento</div>
                                @if($matricula->acta_nacimiento)
                                    <a href="{{ asset('storage/'.$matricula->acta_nacimiento) }}" target="_blank" class="doc-current">
                                        <i class="fas fa-check-circle"></i> Ver archivo actual
                                    </a>
                                @endif
                            </div>
                        </div>
                        <input type="file"
                               class="em-input @error('acta_nacimiento') is-invalid @enderror"
                               id="acta_nacimiento" name="acta_nacimiento" accept=".pdf,image/*"
                               style="padding:.45rem .75rem; font-size:.78rem;">
                        <div class="doc-hint"><i class="fas fa-info-circle"></i> PDF, JPG, PNG · Máx. 5MB</div>
                        @error('acta_nacimiento')
                            <div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Certificado de Estudios --}}
                    <div class="doc-row">
                        <div class="doc-row-top">
                            <div class="doc-icon"><i class="fas fa-certificate"></i></div>
                            <div>
                                <div class="doc-label-text">Certificado de Estudios</div>
                                @if($matricula->certificado_estudios)
                                    <a href="{{ asset('storage/'.$matricula->certificado_estudios) }}" target="_blank" class="doc-current">
                                        <i class="fas fa-check-circle"></i> Ver archivo actual
                                    </a>
                                @endif
                            </div>
                        </div>
                        <input type="file"
                               class="em-input @error('certificado_estudios') is-invalid @enderror"
                               id="certificado_estudios" name="certificado_estudios" accept=".pdf,image/*"
                               style="padding:.45rem .75rem; font-size:.78rem;">
                        <div class="doc-hint"><i class="fas fa-info-circle"></i> PDF, JPG, PNG · Máx. 5MB</div>
                        @error('certificado_estudios')
                            <div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Constancia de Conducta --}}
                    <div class="doc-row">
                        <div class="doc-row-top">
                            <div class="doc-icon"><i class="fas fa-award"></i></div>
                            <div>
                                <div class="doc-label-text">Constancia de Conducta</div>
                                @if($matricula->constancia_conducta)
                                    <a href="{{ asset('storage/'.$matricula->constancia_conducta) }}" target="_blank" class="doc-current">
                                        <i class="fas fa-check-circle"></i> Ver archivo actual
                                    </a>
                                @endif
                            </div>
                        </div>
                        <input type="file"
                               class="em-input @error('constancia_conducta') is-invalid @enderror"
                               id="constancia_conducta" name="constancia_conducta" accept=".pdf,image/*"
                               style="padding:.45rem .75rem; font-size:.78rem;">
                        <div class="doc-hint"><i class="fas fa-info-circle"></i> PDF, JPG, PNG · Máx. 5MB</div>
                        @error('constancia_conducta')
                            <div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- DNI Estudiante --}}
                    <div class="doc-row">
                        <div class="doc-row-top">
                            <div class="doc-icon"><i class="fas fa-id-card"></i></div>
                            <div>
                                <div class="doc-label-text">DNI del Estudiante</div>
                                @if($matricula->foto_dni_estudiante)
                                    <a href="{{ asset('storage/'.$matricula->foto_dni_estudiante) }}" target="_blank" class="doc-current">
                                        <i class="fas fa-check-circle"></i> Ver archivo actual
                                    </a>
                                @endif
                            </div>
                        </div>
                        <input type="file"
                               class="em-input @error('foto_dni_estudiante') is-invalid @enderror"
                               id="foto_dni_estudiante" name="foto_dni_estudiante" accept="image/*"
                               style="padding:.45rem .75rem; font-size:.78rem;">
                        <div class="doc-hint"><i class="fas fa-info-circle"></i> JPG, PNG · Máx. 2MB</div>
                        @error('foto_dni_estudiante')
                            <div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- DNI Padre --}}
                    <div class="doc-row">
                        <div class="doc-row-top">
                            <div class="doc-icon"><i class="fas fa-id-card-alt"></i></div>
                            <div>
                                <div class="doc-label-text">DNI del Padre/Tutor</div>
                                @if($matricula->foto_dni_padre)
                                    <a href="{{ asset('storage/'.$matricula->foto_dni_padre) }}" target="_blank" class="doc-current">
                                        <i class="fas fa-check-circle"></i> Ver archivo actual
                                    </a>
                                @endif
                            </div>
                        </div>
                        <input type="file"
                               class="em-input @error('foto_dni_padre') is-invalid @enderror"
                               id="foto_dni_padre" name="foto_dni_padre" accept="image/*"
                               style="padding:.45rem .75rem; font-size:.78rem;">
                        <div class="doc-hint"><i class="fas fa-info-circle"></i> JPG, PNG · Máx. 2MB</div>
                        @error('foto_dni_padre')
                            <div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>{{-- fin sección 2 --}}

            {{-- ══════════════════════════════════════
                 BOTONES — igual que pf-footer del perfil
            ══════════════════════════════════════ --}}
            <div style="display:flex; gap:.6rem; flex-wrap:wrap;
                        padding:1.1rem 1.7rem;
                        background:#f5f8fc; border-top:1px solid #e8edf4;
                        border-radius:0 0 14px 14px;">

                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
                <a href="{{ route('matriculas.show', $matricula->id) }}" class="btn-cancel">
                    <i class="fas fa-times"></i> Cancelar
                </a>

            </div>

        </form>
    </div>{{-- fin body --}}
</div>{{-- fin edit-wrap --}}
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const estadoSelect    = document.getElementById('estado');
    const motivoContainer = document.getElementById('motivo-rechazo-container');

    estadoSelect.addEventListener('change', function () {
        if (this.value === 'rechazada') {
            motivoContainer.classList.add('visible');
        } else {
            motivoContainer.classList.remove('visible');
            document.getElementById('motivo_rechazo').value = '';
        }
    });
});
</script>
@endpush
