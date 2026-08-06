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
.edit-wrap { width: 100%; }

/* ── Alerts ── */
.em-alert {
    display: flex; align-items: flex-start; gap: .75rem;
    padding: .9rem 1.1rem; border-radius: 10px;
    font-size: .83rem; margin-bottom: 1rem;
}
.em-alert-success { background: #f0fdf4; border: 1px solid #86efac; color: #166534; }
.em-alert-danger  { background: #fef2f2; border: 1px solid #fca5a5; color: #991b1b; }
.em-alert-info    { background: var(--cyan-light); border: 1px solid var(--cyan-border); color: var(--blue-dark); }

/* ── Labels ── */
.em-label {
    display: block;
    font-size: .63rem; font-weight: 700;
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
    border: 2px solid #bfd9ea;
    border-radius: 10px;
    padding: 0.68rem 1rem;
    font-size: .88rem; font-weight: 500;
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
.em-input.readonly { background: #f1f5f9; color: var(--muted); cursor: not-allowed; }
.em-input.is-invalid, .em-select.is-invalid, .em-textarea.is-invalid { border-color: var(--red); }

.em-select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748b' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right .75rem center;
    padding-right: 2.5rem;
}

/* inputs con ícono izquierdo */
.em-input-icon {
    width: 100%;
    background: #fff;
    border: 2px solid #bfd9ea;
    border-radius: 10px;
    padding: 0.68rem 1rem 0.68rem 2.8rem;
    font-size: .88rem; font-weight: 500;
    color: var(--text);
    transition: border-color .2s, box-shadow .2s;
    font-family: inherit;
    appearance: none;
    height: auto;
}
.em-input-icon:focus {
    outline: none;
    border-color: var(--cyan);
    box-shadow: 0 0 0 0.15rem rgba(78,199,210,.15);
}
.em-input-icon.is-invalid { border-color: var(--red); }

.em-select-icon {
    width: 100%;
    background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748b' d='M6 8L1 3h10z'/%3E%3C/svg%3E") no-repeat right .75rem center;
    border: 2px solid #bfd9ea;
    border-radius: 10px;
    padding: 0.68rem 2.5rem 0.68rem 2.8rem;
    font-size: .88rem; font-weight: 500;
    color: var(--text);
    transition: border-color .2s, box-shadow .2s;
    font-family: inherit;
    appearance: none;
    height: auto;
}
.em-select-icon:focus {
    outline: none;
    border-color: var(--cyan);
    box-shadow: 0 0 0 0.15rem rgba(78,199,210,.15);
}
.em-select-icon.is-invalid { border-color: var(--red); }

.field-icon {
    position: absolute;
    left: 12px; top: 50%;
    transform: translateY(-50%);
    color: var(--blue-mid);
    font-size: .68rem;
    z-index: 10;
    pointer-events: none;
}
.field-icon-top {
    position: absolute;
    left: 12px; top: 14px;
    color: var(--blue-mid);
    font-size: .68rem;
    z-index: 10;
    pointer-events: none;
}

/* ── Mensajes error ── */
.em-error {
    font-size: .7rem; color: var(--red);
    margin-top: .22rem; font-weight: 500;
    display: flex; align-items: center; gap: .3rem;
}

/* ── Fields grid ── */
.fields-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.1rem; }
.fields-grid.cols-3 { grid-template-columns: 1fr 1fr 1fr; }
@media(max-width:640px) { .fields-grid, .fields-grid.cols-3 { grid-template-columns: 1fr; } }
.col-full { grid-column: 1 / -1; }

/* ── Bootstrap-style row/col ── */
.row { display: flex; flex-wrap: wrap; margin: -0.5rem; }
.row.g-3 { margin: -0.5rem; }
.row.g-3 > [class^="col-"] { padding: 0.5rem; }
.col-md-4 { flex: 0 0 33.333%; max-width: 33.333%; }
.col-md-6 { flex: 0 0 50%; max-width: 50%; }
.col-12   { flex: 0 0 100%; max-width: 100%; }
@media(max-width:768px) {
    .col-md-4, .col-md-6 { flex: 0 0 100%; max-width: 100%; }
}

/* ── Títulos ── */
.sm-sec-title, .sm-sec-title-light {
    display: flex; align-items: center; gap: .5rem;
    font-size: .75rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .08em;
    margin-bottom: .95rem; padding-bottom: .55rem;
}
.sm-sec-title { color: var(--blue-mid); border-bottom: 2px solid rgba(78,199,210,.1); }
.sm-sec-title-light { color: var(--blue-dark); border-bottom: 2px solid var(--cyan-border); }

/* ── Doc rows ── */
.doc-row {
    background: var(--surface);
    border: 2px solid #bfd9ea;
    border-radius: 10px;
    padding: .85rem 1rem;
}
.doc-icon {
    width: 34px; height: 34px; border-radius: 8px;
    background: linear-gradient(135deg, var(--cyan), var(--blue-mid));
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: .78rem;
}

/* ── Buttons ── */
.btn-save {
    background: linear-gradient(135deg, var(--cyan), var(--blue-mid));
    color: white; border: none; border-radius: 9px;
    padding: .6rem .75rem; font-size: .83rem; font-weight: 600;
    display: inline-flex; align-items: center; gap: .45rem; cursor: pointer;
}
.btn-cancel {
    border: 1.5px solid var(--blue-mid); color: var(--blue-mid); background: white;
    border-radius: 9px; padding: .6rem .75rem; font-size: .83rem; font-weight: 600;
    display: inline-flex; align-items: center; gap: .45rem; text-decoration: none;
}

/* ── Info box ── */
.info-box {
    background: linear-gradient(135deg, rgba(78,199,210,.08), rgba(0,80,143,.04));
    border-left: 3px solid #4ec7d2;
    border-radius: 10px;
    padding: .75rem 1rem;
}
</style>
@endpush

@section('content')
<div class="edit-wrap">
    {{-- HEADER --}}
    <div style="border-radius:14px 14px 0 0; background:linear-gradient(135deg,#002d5a 0%,#00508f 55%,#0077b6 100%); padding:2rem 1.7rem; position:relative; overflow:hidden;">
        <div style="position:absolute;right:-50px;top:-50px;width:200px;height:200px;border-radius:50%;background:rgba(78,199,210,.13);pointer-events:none;"></div>
        <div style="position:relative;z-index:1;display:flex;align-items:center;gap:1.4rem;flex-wrap:wrap;">
            <div style="width:80px;height:80px; border-radius:18px; border:3px solid rgba(78,199,210,.7); background:rgba(255,255,255,.12); display:flex;align-items:center;justify-content:center; box-shadow:0 6px 20px rgba(0,0,0,.25);">
                <i class="fas fa-clipboard-check" style="color:white;font-size:2rem;"></i>
            </div>
            <div>
                <h2 style="font-size:1.45rem;font-weight:800;color:white; margin:0 0 .4rem; text-shadow:0 1px 4px rgba(0,0,0,.2);">Editar Matrícula</h2>
                <span style="display:inline-flex;align-items:center;gap:.3rem; padding:.2rem .65rem;border-radius:999px; background:rgba(255,255,255,.14); color:white; font-size:.72rem; font-weight:600; border:1px solid rgba(255,255,255,.18);">
                    <i class="fas fa-pen"></i> {{ $matricula->codigo_matricula }}
                </span>
            </div>
        </div>
    </div>

    {{-- BODY --}}
    <div style="background:white; border:1px solid #e8edf4; border-top:none; border-radius:0 0 14px 14px; box-shadow:0 2px 16px rgba(0,59,115,.09);">

        @if($errors->any())
        <div style="padding:1rem 1.7rem 0;">
            <div class="em-alert em-alert-danger">
                <i class="fas fa-exclamation-circle" style="flex-shrink:0;margin-top:2px;"></i>
                <div>
                    <strong>Por favor corrige los siguientes errores:</strong>
                    <ul style="margin:.3rem 0 0 1rem;padding:0;">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
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
                    <i class="fas fa-clipboard-check" style="color:#4ec7d2;font-size:.88rem;"></i>
                    Información de la Matrícula
                </div>

                <div class="fields-grid cols-3">
                    {{-- Código --}}
                    <div>
                        <label class="em-label"><i class="fas fa-barcode"></i> Código</label>
                        <input type="text" class="em-input readonly" value="{{ $matricula->codigo_matricula }}" readonly>
                    </div>

                    {{-- Año Lectivo --}}
                    <div>
                        <label class="em-label" for="anio_lectivo">
                            <i class="fas fa-calendar-alt"></i> Año Lectivo <span class="req">*</span>
                        </label>
                        <input type="text" class="em-input @error('anio_lectivo') is-invalid @enderror"
                               id="anio_lectivo" name="anio_lectivo"
                               value="{{ old('anio_lectivo', $matricula->anio_lectivo) }}">
                        @error('anio_lectivo') <div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                    </div>

                    {{-- Grado de la matrícula --}}
                    <div>
                        <label class="em-label" for="grado">
                            <i class="fas fa-graduation-cap"></i> Grado <span class="req">*</span>
                        </label>
                        <select class="em-select @error('grado') is-invalid @enderror" id="grado" name="grado">
                            <option value="">Seleccione un grado...</option>
                            @foreach(App\Helpers\GradoHelper::GRADOS as $grado)
                                <option value="{{ $grado }}" {{ old('grado', $matricula->grado) == $grado ? 'selected' : '' }}>
                                    {{ $grado }}
                                </option>
                            @endforeach
                        </select>
                        @error('grado') <div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                    </div>

                    {{-- Fecha --}}
                    <div>
                        <label class="em-label" for="fecha_matricula">
                            <i class="fas fa-calendar"></i> Fecha de Matrícula <span class="req">*</span>
                        </label>
                        <input type="date" class="em-input @error('fecha_matricula') is-invalid @enderror"
                               id="fecha_matricula" name="fecha_matricula"
                               value="{{ old('fecha_matricula', \Carbon\Carbon::parse($matricula->fecha_matricula)->format('Y-m-d')) }}">
                        @error('fecha_matricula') <div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                    </div>

                    {{-- Estado --}}
                    <div>
                        <label class="em-label" for="estado">
                            <i class="fas fa-flag"></i> Estado <span class="req">*</span>
                        </label>
                        <select class="em-select" id="estado" name="estado">
                            <option value="pendiente"  {{ $matricula->estado == 'pendiente'  ? 'selected' : '' }}>Pendiente</option>
                            <option value="aprobada"   {{ $matricula->estado == 'aprobada'   ? 'selected' : '' }}>Aprobada</option>
                            <option value="rechazada"  {{ $matricula->estado == 'rechazada'  ? 'selected' : '' }}>Rechazada</option>
                        </select>
                    </div>

                    {{-- Motivo Rechazo --}}
                    <div id="motivo-rechazo-container"
                         style="{{ old('estado', $matricula->estado) === 'rechazada' ? '' : 'display:none;' }} grid-column: span 2;">
                        <label class="em-label" for="motivo_rechazo">
                            <i class="fas fa-exclamation-triangle"></i> Motivo del Rechazo
                        </label>
                        <input type="text" class="em-input" id="motivo_rechazo" name="motivo_rechazo"
                               value="{{ old('motivo_rechazo', $matricula->motivo_rechazo) }}"
                               placeholder="Describa el motivo del rechazo">
                    </div>

                    <div class="col-full">
                        <label class="em-label" for="observaciones">
                            <i class="fas fa-sticky-note"></i> Observaciones
                        </label>
                        <textarea class="em-textarea" id="observaciones" name="observaciones" rows="2"
                                  placeholder="Notas adicionales sobre la matrícula...">{{ old('observaciones', $matricula->observaciones) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- ══════════════════════════════════════
                 SECCIÓN 2 · DATOS DEL ESTUDIANTE
            ══════════════════════════════════════ --}}
            <div style="padding:1.4rem 1.7rem; border-bottom:1px solid #f0f4f9;">
                <div class="sm-sec-title">
                    <i class="fas fa-user-graduate" style="color:#4ec7d2;font-size:.88rem;"></i>
                    Datos del Estudiante
                </div>

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="em-label">Nombres <span class="req">*</span></label>
                        <div style="position:relative;">
                            <i class="fas fa-user field-icon"></i>
                            <input type="text"
                                   class="em-input-icon @error('estudiante_nombre') is-invalid @enderror"
                                   name="estudiante_nombre"
                                   value="{{ old('estudiante_nombre', $matricula->estudiante_nombre ?? '') }}"
                                   placeholder="Ej: María José" required>
                            @error('estudiante_nombre') <div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="em-label">Apellidos <span class="req">*</span></label>
                        <div style="position:relative;">
                            <i class="fas fa-user field-icon"></i>
                            <input type="text"
                                   class="em-input-icon @error('estudiante_apellido') is-invalid @enderror"
                                   name="estudiante_apellido"
                                   value="{{ old('estudiante_apellido', $matricula->estudiante_apellido ?? '') }}"
                                   placeholder="Ej: López Martínez" required>
                            @error('estudiante_apellido') <div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="em-label">DNI <span class="req">*</span></label>
                        <div style="position:relative;">
                            <i class="fas fa-id-card field-icon"></i>
                            <input type="text"
                                   class="em-input-icon @error('estudiante_dni') is-invalid @enderror"
                                   name="estudiante_dni"
                                   value="{{ old('estudiante_dni', $matricula->estudiante_dni ?? '') }}"
                                   placeholder="0801201012345" maxlength="13" pattern="[0-9]{13}" required>
                            @error('estudiante_dni') <div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                        </div>
                        <small style="font-size:.68rem;color:#6b7a90;"><i class="fas fa-info-circle"></i> 13 dígitos</small>
                    </div>

                    <div class="col-md-4">
                        <label class="em-label">Fecha de Nacimiento <span class="req">*</span></label>
                        <div style="position:relative;">
                            <i class="fas fa-calendar field-icon"></i>
                            <input type="date"
                                   class="em-input-icon @error('estudiante_fecha_nacimiento') is-invalid @enderror"
                                   name="estudiante_fecha_nacimiento"
                                   value="{{ old('estudiante_fecha_nacimiento', isset($matricula->estudiante_fecha_nacimiento) ? \Carbon\Carbon::parse($matricula->estudiante_fecha_nacimiento)->format('Y-m-d') : '') }}"
                                   required>
                            @error('estudiante_fecha_nacimiento') <div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="em-label">Sexo <span class="req">*</span></label>
                        <div style="position:relative;">
                            <i class="fas fa-venus-mars field-icon"></i>
                            <select class="em-select-icon @error('estudiante_sexo') is-invalid @enderror"
                                    name="estudiante_sexo" required>
                                <option value="">Seleccionar...</option>
                                <option value="masculino" {{ old('estudiante_sexo', $matricula->estudiante_sexo ?? '') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="femenino"  {{ old('estudiante_sexo', $matricula->estudiante_sexo ?? '') == 'femenino'  ? 'selected' : '' }}>Femenino</option>
                            </select>
                            @error('estudiante_sexo') <div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="em-label">Grado <span class="req">*</span></label>
                        <div style="position:relative;">
                            <i class="fas fa-graduation-cap field-icon"></i>
                            <select class="em-select-icon @error('estudiante_grado') is-invalid @enderror"
                                    name="estudiante_grado" required>
                                <option value="">Seleccionar...</option>
                                @foreach($grados as $g)
                                    <option value="{{ $g }}" {{ old('estudiante_grado', $matricula->estudiante_grado ?? '') == $g ? 'selected' : '' }}>{{ $g }}</option>
                                @endforeach
                            </select>
                            @error('estudiante_grado') <div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="em-label">Sección <span class="req">*</span></label>
                        <div style="position:relative;">
                            <i class="fas fa-door-open field-icon"></i>
                            <select class="em-select-icon @error('estudiante_seccion') is-invalid @enderror"
                                    name="estudiante_seccion" required>
                                <option value="">Seleccionar...</option>
                                @foreach($secciones as $seccion)
                                    <option value="{{ $seccion }}" {{ old('estudiante_seccion', $matricula->estudiante_seccion ?? '') == $seccion ? 'selected' : '' }}>{{ $seccion }}</option>
                                @endforeach
                            </select>
                            @error('estudiante_seccion') <div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="em-label">Teléfono</label>
                        <div style="position:relative;">
                            <i class="fas fa-phone field-icon"></i>
                            <input type="text"
                                   class="em-input-icon @error('estudiante_telefono') is-invalid @enderror"
                                   name="estudiante_telefono"
                                   value="{{ old('estudiante_telefono', $matricula->estudiante_telefono ?? '') }}"
                                   placeholder="98765432" maxlength="8">
                            @error('estudiante_telefono') <div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="em-label">Correo Electrónico</label>
                        <div style="position:relative;">
                            <i class="fas fa-envelope field-icon"></i>
                            <input type="email"
                                   class="em-input-icon @error('estudiante_email') is-invalid @enderror"
                                   name="estudiante_email"
                                   value="{{ old('estudiante_email', $matricula->estudiante_email ?? '') }}"
                                   placeholder="estudiante@ejemplo.com">
                            @error('estudiante_email') <div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="em-label">Dirección</label>
                        <div style="position:relative;">
                            <i class="fas fa-map-marker-alt field-icon-top"></i>
                            <textarea class="em-textarea @error('estudiante_direccion') is-invalid @enderror"
                                      name="estudiante_direccion" rows="2"
                                      style="padding-left:2.8rem;"
                                      placeholder="Dirección del estudiante">{{ old('estudiante_direccion', $matricula->estudiante_direccion ?? '') }}</textarea>
                            @error('estudiante_direccion') <div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                        </div>
                    </div>

                </div>
            </div>

            {{-- ══════════════════════════════════════
                 SECCIÓN 3 · DATOS DEL PADRE / TUTOR
            ══════════════════════════════════════ --}}
            <div style="padding:1.4rem 1.7rem; border-bottom:1px solid #f0f4f9;">
                <div class="sm-sec-title">
                    <i class="fas fa-user-shield" style="color:#4ec7d2;font-size:.88rem;"></i>
                    Datos del Padre / Tutor
                </div>

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="em-label">Nombres <span class="req">*</span></label>
                        <div style="position:relative;">
                            <i class="fas fa-user field-icon"></i>
                            <input type="text"
                                   class="em-input-icon @error('padre_nombre') is-invalid @enderror"
                                   name="padre_nombre"
                                   value="{{ old('padre_nombre', $matricula->padre_nombre ?? '') }}"
                                   placeholder="Ej: Juan Carlos" required>
                            @error('padre_nombre') <div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="em-label">Apellidos <span class="req">*</span></label>
                        <div style="position:relative;">
                            <i class="fas fa-user field-icon"></i>
                            <input type="text"
                                   class="em-input-icon @error('padre_apellido') is-invalid @enderror"
                                   name="padre_apellido"
                                   value="{{ old('padre_apellido', $matricula->padre_apellido ?? '') }}"
                                   placeholder="Ej: Pérez García" required>
                            @error('padre_apellido') <div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="em-label">DNI <span class="req">*</span></label>
                        <div style="position:relative;">
                            <i class="fas fa-id-card field-icon"></i>
                            <input type="text"
                                   class="em-input-icon @error('padre_dni') is-invalid @enderror"
                                   name="padre_dni"
                                   value="{{ old('padre_dni', $matricula->padre_dni ?? '') }}"
                                   placeholder="0801199512345" maxlength="13" pattern="[0-9]{13}" required>
                            @error('padre_dni') <div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                        </div>
                        <small style="font-size:.68rem;color:#6b7a90;"><i class="fas fa-info-circle"></i> 13 dígitos</small>
                    </div>

                    <div class="col-md-4">
                        <label class="em-label">Parentesco <span class="req">*</span></label>
                        <div style="position:relative;">
                            <i class="fas fa-users field-icon"></i>
                            <select class="em-select-icon @error('padre_parentesco') is-invalid @enderror"
                                    name="padre_parentesco" id="parentescoSelect"
                                    onchange="toggleOtroParentesco()" required>
                                <option value="">Seleccionar...</option>
                                @foreach($parentescos as $key => $value)
                                    <option value="{{ $key }}" {{ old('padre_parentesco', $matricula->padre_parentesco ?? '') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('padre_parentesco') <div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-4" id="otroParentescoDiv"
                         style="{{ old('padre_parentesco', $matricula->padre_parentesco ?? '') == 'otro' ? '' : 'display:none;' }}">
                        <label class="em-label">Especificar Parentesco</label>
                        <div style="position:relative;">
                            <i class="fas fa-pen field-icon"></i>
                            <input type="text"
                                   class="em-input-icon @error('padre_parentesco_otro') is-invalid @enderror"
                                   name="padre_parentesco_otro"
                                   value="{{ old('padre_parentesco_otro', $matricula->padre_parentesco_otro ?? '') }}"
                                   placeholder="Ej: Tío, Hermano">
                            @error('padre_parentesco_otro') <div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="em-label">Teléfono <span class="req">*</span></label>
                        <div style="position:relative;">
                            <i class="fas fa-phone field-icon"></i>
                            <input type="text"
                                   class="em-input-icon @error('padre_telefono') is-invalid @enderror"
                                   name="padre_telefono"
                                   value="{{ old('padre_telefono', $matricula->padre_telefono ?? '') }}"
                                   placeholder="98765432" maxlength="8" pattern="[0-9]{8}" required>
                            @error('padre_telefono') <div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="em-label">Correo Electrónico</label>
                        <div style="position:relative;">
                            <i class="fas fa-envelope field-icon"></i>
                            <input type="email"
                                   class="em-input-icon @error('padre_email') is-invalid @enderror"
                                   name="padre_email"
                                   value="{{ old('padre_email', $matricula->padre_email ?? '') }}"
                                   placeholder="padre@ejemplo.com">
                            @error('padre_email') <div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="em-label">Dirección <span class="req">*</span></label>
                        <div style="position:relative;">
                            <i class="fas fa-map-marker-alt field-icon-top"></i>
                            <textarea class="em-textarea @error('padre_direccion') is-invalid @enderror"
                                      name="padre_direccion" rows="2"
                                      style="padding-left:2.8rem;"
                                      placeholder="Dirección completa del padre/tutor"
                                      required>{{ old('padre_direccion', $matricula->padre_direccion ?? '') }}</textarea>
                            @error('padre_direccion') <div class="em-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                        </div>
                    </div>

                </div>
            </div>

            {{-- ══════════════════════════════════════
                 SECCIÓN 4 · DOCUMENTOS ADJUNTOS
            ══════════════════════════════════════ --}}
            <div style="padding:1.4rem 1.7rem; border-bottom:1px solid #f0f4f9;">
                <div class="sm-sec-title-light">
                    <i class="fas fa-paperclip" style="color:#4ec7d2;font-size:.88rem;"></i>
                    Documentos Adjuntos
                </div>

                <div class="info-box mb-3" style="margin-bottom:1rem;">
                    <p style="font-size:.78rem;font-weight:700;color:#003b73;margin:0 0 .4rem;">
                        <i class="fas fa-info-circle" style="color:#4ec7d2;margin-right:.4rem;"></i>
                        Sube un nuevo archivo solo si deseas reemplazar el documento actual.
                    </p>
                </div>

                <div class="fields-grid">
                    @php
                        $docs = [
                            ['foto_estudiante',     'Foto del Estudiante',      'fa-camera'],
                            ['acta_nacimiento',     'Acta de Nacimiento',       'fa-file-alt'],
                            ['certificado_estudios','Certificado de Estudios',  'fa-certificate'],
                            ['constancia_conducta', 'Constancia de Conducta',   'fa-award'],
                            ['foto_dni_estudiante', 'DNI del Estudiante',       'fa-id-card'],
                            ['foto_dni_padre',      'DNI del Padre/Tutor',      'fa-id-card-alt']
                        ];
                    @endphp

                    @foreach($docs as $doc)
                    <div class="doc-row">
                        <div style="display:flex; align-items:center; gap:.6rem; margin-bottom:.55rem;">
                            <div class="doc-icon"><i class="fas {{ $doc[2] }}"></i></div>
                            <div>
                                <div style="font-size:.83rem; font-weight:700; color:var(--blue-dark);">{{ $doc[1] }}</div>
                                @if($matricula->{$doc[0]})
                                    <a href="{{ asset('storage/'.$matricula->{$doc[0]}) }}" target="_blank"
                                       style="font-size:.7rem; color:#16a34a; background:#f0fdf4; padding:.1rem .5rem; border-radius:10px; text-decoration:none;">
                                        <i class="fas fa-eye"></i> Ver actual
                                    </a>
                                @else
                                    <span style="font-size:.7rem; color:#94a3b8;">Sin archivo</span>
                                @endif
                            </div>
                        </div>
                        <input type="file" name="{{ $doc[0] }}" class="em-input" style="padding:.4rem; font-size:.75rem;">
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- FOOTER --}}
            <div style="display:flex; gap:.6rem; flex-wrap:wrap; padding:1.1rem 1.7rem; background:#f5f8fc; border-top:1px solid #e8edf4; border-radius:0 0 14px 14px;">
                <button type="submit" class="btn-save"><i class="fas fa-save"></i> Guardar Cambios</button>
                <a href="{{ route('matriculas.show', $matricula->id) }}" class="btn-cancel"><i class="fas fa-times"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const estadoSelect = document.getElementById('estado');
    const motivoContainer = document.getElementById('motivo-rechazo-container');

    estadoSelect.addEventListener('change', function () {
        if (this.value === 'rechazada') {
            motivoContainer.style.display = 'block';
        } else {
            motivoContainer.style.display = 'none';
            document.getElementById('motivo_rechazo').value = '';
        }
    });
});

function toggleOtroParentesco() {
    const select = document.getElementById('parentescoSelect');
    const div    = document.getElementById('otroParentescoDiv');
    div.style.display = select.value === 'otro' ? 'block' : 'none';
}
</script>
@endpush