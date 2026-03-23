@extends('layouts.app')

@section('title', 'Registrar Matrícula')


@push('styles')
<style>
/* ════════════════════════════════════════════════
   TAMAÑOS — igualados al perfil del estudiante
   ════════════════════════════════════════════════ */

/* ── Inputs, Selects, Textarea ── */
.form-control,
.form-select {
    border: 2px solid #bfd9ea !important;
    border-radius: 10px !important;               /* ← REDONDEZ inputs */
    padding: 0.68rem 1rem 0.68rem 2.8rem !important; /* ← ALTO inputs con ícono */
    font-size: .88rem !important;                 /* ← TEXTO dentro de inputs */
    transition: all 0.2s ease;
    height: auto !important;
}

/* inputs sin ícono (file) */
.form-control[type="file"] {
    padding: 0.45rem .75rem !important;
    font-size: .78rem !important;                 /* ← TEXTO input file */
}

.form-control:focus,
.form-select:focus {
    border-color: #4ec7d2 !important;
    box-shadow: 0 0 0 0.15rem rgba(78,199,210,.15) !important;
}

.form-control.is-invalid,
.form-select.is-invalid {
    border-color: #ef4444 !important;
    background-image: none !important;
}

/* ── Labels ── */
.form-label {
    font-size: .63rem !important;                 /* ← TAMAÑO labels */
    font-weight: 700 !important;
    color: #003b73 !important;
    text-transform: uppercase;
    letter-spacing: .08em;
    margin-bottom: .22rem;
}

/* ── Títulos de sección ── */
.sec-title {
    font-size: .75rem;                            /* ← TAMAÑO títulos de sección */
    font-weight: 700;
    color: #00508f;
    text-transform: uppercase;
    letter-spacing: .08em;
}

/* ── Mensajes de error ── */
.invalid-feedback {
    font-size: .7rem !important;                  /* ← TAMAÑO mensajes error */
    display: block;
    margin-top: .22rem;
}

/* ── Texto ayuda small ── */
.hint-text,
.text-muted.small-hint {
    font-size: .68rem !important;                 /* ← TAMAÑO texto ayuda */
    color: #6b7a90;
}

/* ── Ícono dentro del campo ── */
.field-icon {
    left: 12px; top: 50%;
    transform: translateY(-50%);
    color: #00508f;
    font-size: .68rem;                            /* ← TAMAÑO íconos en inputs */
    z-index: 10;
}

.field-icon-top {
    left: 12px; top: 14px;
    color: #00508f;
    font-size: .68rem;                            /* ← TAMAÑO íconos textarea */
}

/* ── Info box documentos ── */
.info-box {
    background: linear-gradient(135deg, rgba(78,199,210,.08), rgba(0,80,143,.04));
    border-left: 3px solid #4ec7d2;
    border-radius: 10px;
    padding: .75rem 1rem;
    font-size: .83rem;                            /* ← TAMAÑO texto info-box */
}

.info-box ul li {
    font-size: .8rem;                             /* ← TAMAÑO lista documentos */
}

/* ── Botón Guardar ── */
.btn-primary-custom {
    flex: 1; min-width: 140px;
    justify-content: center;
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: white; border: none;
    border-radius: 9px;                           /* ← REDONDEZ botón guardar */
    padding: .6rem .75rem;                       /* ← TAMAÑO botón guardar */
    font-size: .83rem; font-weight: 600;          /* ← TEXTO botón guardar */
    box-shadow: 0 2px 10px rgba(78,199,210,.3);
    transition: all .2s;
    display: inline-flex; align-items: center; gap: .45rem;
    cursor: pointer;
}
.btn-primary-custom:hover {
    color: white;
    box-shadow: 0 4px 16px rgba(78,199,210,.4);
    transform: translateY(-2px);
}

/* ── Botón Cancelar ── */
.btn-cancel-custom {
    flex: 1; min-width: 120px;
    justify-content: center;
    border: 1.5px solid #00508f;                  /* ← GROSOR borde cancelar */
    color: #00508f; background: white;
    border-radius: 9px;                           /* ← REDONDEZ botón cancelar */
    padding: .6rem .75rem;                       /* ← TAMAÑO botón cancelar */
    font-size: .83rem; font-weight: 600;          /* ← TEXTO botón cancelar */
    transition: all .2s;
    display: inline-flex; align-items: center; gap: .45rem;
    text-decoration: none;
}
.btn-cancel-custom:hover {
    background: #eff6ff; color: #00508f;
    transform: translateY(-2px);
}
</style>
@endpush

@section('content')
<div style="width:100%;">

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
                    Registrar Matrícula
                </h2>
                <span style="display:inline-flex;align-items:center;gap:.3rem;
                             padding:.2rem .65rem;border-radius:999px;
                             background:rgba(255,255,255,.14);color:rgba(255,255,255,.92);
                             font-size:.72rem;font-weight:600; {{-- ← TEXTO tag subtítulo --}}
                             border:1px solid rgba(255,255,255,.18);">
                    <i class="fas fa-pen"></i> Complete todos los datos requeridos
                </span>
            </div>
        </div>
    </div>

    {{-- ── BODY ── --}}
    <div style="background:white;border:1px solid #e8edf4;border-top:none;
                border-radius:0 0 14px 14px;box-shadow:0 2px 16px rgba(0,59,115,.09);">

        {{-- Alerta errores --}}
        @if ($errors->any())
        <div style="padding:1rem 1.7rem 0;">
            <div style="display:flex;align-items:flex-start;gap:.75rem;
                        padding:.9rem 1.1rem;border-radius:10px;
                        background:#fef2f2;border:1px solid #fca5a5;color:#991b1b;
                        font-size:.83rem;">
                <i class="fas fa-exclamation-circle" style="flex-shrink:0;margin-top:2px;"></i>
                <div>
                    <strong>Por favor corrige los siguientes errores:</strong>
                    <ul style="margin:.3rem 0 0 1rem;padding:0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('matriculas.store') }}" method="POST"
              enctype="multipart/form-data" id="formMatricula">
            @csrf

            {{-- ══════════════════════════════════════
                 SECCIÓN 1 · DATOS DE LA MATRÍCULA
            ══════════════════════════════════════ --}}
            <div style="padding:1.4rem 1.7rem;border-bottom:1px solid #f0f4f9;">

                <div style="display:flex;align-items:center;gap:.5rem;
                            font-size:.75rem;font-weight:700;color:#00508f;
                            text-transform:uppercase;letter-spacing:.08em;
                            margin-bottom:.95rem;padding-bottom:.55rem;
                            border-bottom:2px solid rgba(78,199,210,.1);">
                    <i class="fas fa-clipboard-list" style="color:#4ec7d2;font-size:.88rem;"></i>
                    Datos de la Matrícula
                </div>

                <div class="row g-3">

                    {{-- Código --}}
                    <div class="col-md-4">
                        <label class="form-label">
                            <i class="fas fa-barcode me-1"></i> Código de Matrícula
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-barcode position-absolute field-icon"></i>
                            <input type="text"
                                   class="form-control @error('codigo_matricula') is-invalid @enderror"
                                   name="codigo_matricula"
                                   value="{{ old('codigo_matricula', $matricula->codigo_matricula ?? '') }}"
                                   placeholder="Auto-generado" readonly
                                   style="background:#f5f8fc; color:#6b7a90;">
                            @error('codigo_matricula')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Año Lectivo --}}
                    <div class="col-md-4">
                        <label class="form-label">
                            Año Lectivo <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-calendar-alt position-absolute field-icon"></i>
                            <input type="number"
                                   class="form-control @error('anio_lectivo') is-invalid @enderror"
                                   name="anio_lectivo"
                                   value="{{ old('anio_lectivo', date('Y')) }}"
                                   placeholder="{{ date('Y') }}"
                                   min="2020" max="2099" required>
                            @error('anio_lectivo')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Fecha --}}
                    <div class="col-md-4">
                        <label class="form-label">
                            Fecha de Matrícula <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-calendar position-absolute field-icon"></i>
                            <input type="date"
                                   class="form-control @error('fecha_matricula') is-invalid @enderror"
                                   name="fecha_matricula"
                                   value="{{ old('fecha_matricula', isset($matricula)
                                       ? \Carbon\Carbon::parse($matricula->fecha_matricula)->format('Y-m-d')
                                       : date('Y-m-d')) }}"
                                   required>
                            @error('fecha_matricula')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Estado --}}
                    <div class="col-md-6">
                        <label class="form-label">
                            Estado <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-info-circle position-absolute field-icon"></i>
                            <select class="form-select @error('estado') is-invalid @enderror"
                                    name="estado" id="estadoSelect" required>
                                <option value="pendiente"  {{ old('estado', $matricula->estado ?? 'pendiente') == 'pendiente'  ? 'selected' : '' }}>Pendiente</option>
                                <option value="aprobada"   {{ old('estado', $matricula->estado ?? '') == 'aprobada'   ? 'selected' : '' }}>Aprobada</option>
                                <option value="rechazada"  {{ old('estado', $matricula->estado ?? '') == 'rechazada'  ? 'selected' : '' }}>Rechazada</option>
                            </select>
                            @error('estado')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Motivo rechazo --}}
                    <div class="col-md-6" id="motivoRechazoContainer"
                         style="{{ old('estado', $matricula->estado ?? '') == 'rechazada' ? '' : 'display:none;' }}">
                        <label class="form-label">
                            <i class="fas fa-exclamation-triangle me-1" style="color:#f59e0b;"></i>
                            Motivo del Rechazo
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-comment-alt position-absolute field-icon"></i>
                            <input type="text"
                                   class="form-control @error('motivo_rechazo') is-invalid @enderror"
                                   name="motivo_rechazo"
                                   value="{{ old('motivo_rechazo', $matricula->motivo_rechazo ?? '') }}"
                                   placeholder="Describa el motivo del rechazo">
                            @error('motivo_rechazo')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Observaciones --}}
                    <div class="col-12">
                        <label class="form-label">Observaciones</label>
                        <div class="position-relative">
                            <i class="fas fa-comment-alt position-absolute field-icon-top"></i>
                            <textarea class="form-control @error('observaciones') is-invalid @enderror"
                                      name="observaciones" rows="2"
                                      style="padding-top:.68rem !important; padding-left:2.8rem !important;"
                                      placeholder="Notas adicionales sobre la matrícula...">{{ old('observaciones', $matricula->observaciones ?? '') }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>{{-- fin sección 1 --}}

            {{-- ══════════════════════════════════════
                 SECCIÓN 2 · DATOS DEL ESTUDIANTE
            ══════════════════════════════════════ --}}
            <div style="padding:1.4rem 1.7rem;border-bottom:1px solid #f0f4f9;">

                <div style="display:flex;align-items:center;gap:.5rem;
                            font-size:.75rem;font-weight:700;color:#00508f;
                            text-transform:uppercase;letter-spacing:.08em;
                            margin-bottom:.95rem;padding-bottom:.55rem;
                            border-bottom:2px solid rgba(78,199,210,.1);">
                    <i class="fas fa-user-graduate" style="color:#4ec7d2;font-size:.88rem;"></i>
                    Datos del Estudiante
                </div>

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Nombres <span style="color:#ef4444;">*</span></label>
                        <div class="position-relative">
                            <i class="fas fa-user position-absolute field-icon"></i>
                            <input type="text"
                                   class="form-control @error('estudiante_nombre') is-invalid @enderror"
                                   name="estudiante_nombre" value="{{ old('estudiante_nombre') }}"
                                   placeholder="Ej: María José" required>
                            @error('estudiante_nombre')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Apellidos <span style="color:#ef4444;">*</span></label>
                        <div class="position-relative">
                            <i class="fas fa-user position-absolute field-icon"></i>
                            <input type="text"
                                   class="form-control @error('estudiante_apellido') is-invalid @enderror"
                                   name="estudiante_apellido" value="{{ old('estudiante_apellido') }}"
                                   placeholder="Ej: López Martínez" required>
                            @error('estudiante_apellido')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">DNI <span style="color:#ef4444;">*</span></label>
                        <div class="position-relative">
                            <i class="fas fa-id-card position-absolute field-icon"></i>
                            <input type="text"
                                   class="form-control @error('estudiante_dni') is-invalid @enderror"
                                   name="estudiante_dni" value="{{ old('estudiante_dni') }}"
                                   placeholder="0801201012345" maxlength="13" pattern="[0-9]{13}" required>
                            @error('estudiante_dni')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                        <small style="font-size:.68rem;color:#6b7a90;">
                            <i class="fas fa-info-circle me-1"></i>13 dígitos
                        </small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Fecha de Nacimiento <span style="color:#ef4444;">*</span></label>
                        <div class="position-relative">
                            <i class="fas fa-calendar position-absolute field-icon"></i>
                            <input type="date"
                                   class="form-control @error('estudiante_fecha_nacimiento') is-invalid @enderror"
                                   name="estudiante_fecha_nacimiento"
                                   value="{{ old('estudiante_fecha_nacimiento') }}" required>
                            @error('estudiante_fecha_nacimiento')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Sexo <span style="color:#ef4444;">*</span></label>
                        <div class="position-relative">
                            <i class="fas fa-venus-mars position-absolute field-icon"></i>
                            <select class="form-select @error('estudiante_sexo') is-invalid @enderror"
                                    name="estudiante_sexo" required>
                                <option value="">Seleccionar...</option>
                                <option value="masculino" {{ old('estudiante_sexo')=='masculino'?'selected':'' }}>Masculino</option>
                                <option value="femenino"  {{ old('estudiante_sexo')=='femenino' ?'selected':'' }}>Femenino</option>
                            </select>
                            @error('estudiante_sexo')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Grado <span style="color:#ef4444;">*</span></label>
                        <div class="position-relative">
                            <i class="fas fa-graduation-cap position-absolute field-icon"></i>
                            <select class="form-select @error('estudiante_grado') is-invalid @enderror"
                                    name="estudiante_grado" required>
                                <option value="">Seleccionar...</option>
                                @foreach($grados as $grado)
                                    <option value="{{ $grado }}" {{ old('estudiante_grado')==$grado?'selected':'' }}>{{ $grado }}</option>
                                @endforeach
                            </select>
                            @error('estudiante_grado')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Sección <span style="color:#ef4444;">*</span></label>
                        <div class="position-relative">
                            <i class="fas fa-door-open position-absolute field-icon"></i>
                            <select class="form-select @error('estudiante_seccion') is-invalid @enderror"
                                    name="estudiante_seccion" required>
                                <option value="">Seleccionar...</option>
                                @foreach($secciones as $seccion)
                                    <option value="{{ $seccion }}" {{ old('estudiante_seccion')==$seccion?'selected':'' }}>{{ $seccion }}</option>
                                @endforeach
                            </select>
                            @error('estudiante_seccion')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Teléfono</label>
                        <div class="position-relative">
                            <i class="fas fa-phone position-absolute field-icon"></i>
                            <input type="text"
                                   class="form-control @error('estudiante_telefono') is-invalid @enderror"
                                   name="estudiante_telefono" value="{{ old('estudiante_telefono') }}"
                                   placeholder="98765432" maxlength="8">
                            @error('estudiante_telefono')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Correo Electrónico</label>
                        <div class="position-relative">
                            <i class="fas fa-envelope position-absolute field-icon"></i>
                            <input type="email"
                                   class="form-control @error('estudiante_email') is-invalid @enderror"
                                   name="estudiante_email" value="{{ old('estudiante_email') }}"
                                   placeholder="estudiante@ejemplo.com">
                            @error('estudiante_email')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Dirección</label>
                        <div class="position-relative">
                            <i class="fas fa-map-marker-alt position-absolute field-icon-top"></i>
                            <textarea class="form-control @error('estudiante_direccion') is-invalid @enderror"
                                      name="estudiante_direccion" rows="2"
                                      style="padding-top:.68rem !important; padding-left:2.8rem !important;"
                                      placeholder="Dirección del estudiante">{{ old('estudiante_direccion') }}</textarea>
                            @error('estudiante_direccion')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>{{-- fin sección 2 --}}

            {{-- ══════════════════════════════════════
                 SECCIÓN 3 · DATOS DEL PADRE / TUTOR
            ══════════════════════════════════════ --}}
            <div style="padding:1.4rem 1.7rem;border-bottom:1px solid #f0f4f9;">

                <div style="display:flex;align-items:center;gap:.5rem;
                            font-size:.75rem;font-weight:700;color:#00508f;
                            text-transform:uppercase;letter-spacing:.08em;
                            margin-bottom:.95rem;padding-bottom:.55rem;
                            border-bottom:2px solid rgba(78,199,210,.1);">
                    <i class="fas fa-user-shield" style="color:#4ec7d2;font-size:.88rem;"></i>
                    Datos del Padre / Tutor
                </div>

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Nombres <span style="color:#ef4444;">*</span></label>
                        <div class="position-relative">
                            <i class="fas fa-user position-absolute field-icon"></i>
                            <input type="text"
                                   class="form-control @error('padre_nombre') is-invalid @enderror"
                                   name="padre_nombre" value="{{ old('padre_nombre') }}"
                                   placeholder="Ej: Juan Carlos" required>
                            @error('padre_nombre')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Apellidos <span style="color:#ef4444;">*</span></label>
                        <div class="position-relative">
                            <i class="fas fa-user position-absolute field-icon"></i>
                            <input type="text"
                                   class="form-control @error('padre_apellido') is-invalid @enderror"
                                   name="padre_apellido" value="{{ old('padre_apellido') }}"
                                   placeholder="Ej: Pérez García" required>
                            @error('padre_apellido')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">DNI <span style="color:#ef4444;">*</span></label>
                        <div class="position-relative">
                            <i class="fas fa-id-card position-absolute field-icon"></i>
                            <input type="text"
                                   class="form-control @error('padre_dni') is-invalid @enderror"
                                   name="padre_dni" value="{{ old('padre_dni') }}"
                                   placeholder="0801199512345" maxlength="13" pattern="[0-9]{13}" required>
                            @error('padre_dni')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                        <small style="font-size:.68rem;color:#6b7a90;">
                            <i class="fas fa-info-circle me-1"></i>13 dígitos
                        </small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Parentesco <span style="color:#ef4444;">*</span></label>
                        <div class="position-relative">
                            <i class="fas fa-users position-absolute field-icon"></i>
                            <select class="form-select @error('padre_parentesco') is-invalid @enderror"
                                    name="padre_parentesco" id="parentescoSelect"
                                    onchange="toggleOtroParentesco()" required>
                                <option value="">Seleccionar...</option>
                                @foreach($parentescos as $key => $value)
                                    <option value="{{ $key }}" {{ old('padre_parentesco')==$key?'selected':'' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('padre_parentesco')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Otro parentesco --}}
                    <div class="col-md-4" id="otroParentescoDiv"
                         style="{{ old('padre_parentesco')=='otro' ? '' : 'display:none;' }}">
                        <label class="form-label">Especificar Parentesco</label>
                        <div class="position-relative">
                            <i class="fas fa-pen position-absolute field-icon"></i>
                            <input type="text"
                                   class="form-control @error('padre_parentesco_otro') is-invalid @enderror"
                                   name="padre_parentesco_otro" value="{{ old('padre_parentesco_otro') }}"
                                   placeholder="Ej: Tío, Hermano">
                            @error('padre_parentesco_otro')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Teléfono <span style="color:#ef4444;">*</span></label>
                        <div class="position-relative">
                            <i class="fas fa-phone position-absolute field-icon"></i>
                            <input type="text"
                                   class="form-control @error('padre_telefono') is-invalid @enderror"
                                   name="padre_telefono" value="{{ old('padre_telefono') }}"
                                   placeholder="98765432" maxlength="8" pattern="[0-9]{8}" required>
                            @error('padre_telefono')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Correo Electrónico</label>
                        <div class="position-relative">
                            <i class="fas fa-envelope position-absolute field-icon"></i>
                            <input type="email"
                                   class="form-control @error('padre_email') is-invalid @enderror"
                                   name="padre_email" value="{{ old('padre_email') }}"
                                   placeholder="padre@ejemplo.com">
                            @error('padre_email')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Dirección <span style="color:#ef4444;">*</span></label>
                        <div class="position-relative">
                            <i class="fas fa-map-marker-alt position-absolute field-icon-top"></i>
                            <textarea class="form-control @error('padre_direccion') is-invalid @enderror"
                                      name="padre_direccion" rows="2"
                                      style="padding-top:.68rem !important; padding-left:2.8rem !important;"
                                      placeholder="Dirección completa del padre/tutor"
                                      required>{{ old('padre_direccion') }}</textarea>
                            @error('padre_direccion')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>{{-- fin sección 3 --}}

            {{-- ══════════════════════════════════════
                 SECCIÓN 4 · DOCUMENTOS ADJUNTOS
            ══════════════════════════════════════ --}}
            <div style="padding:1.4rem 1.7rem;border-bottom:1px solid #f0f4f9;">

                <div style="display:flex;align-items:center;gap:.5rem;
                            font-size:.75rem;font-weight:700;color:#00508f;
                            text-transform:uppercase;letter-spacing:.08em;
                            margin-bottom:.95rem;padding-bottom:.55rem;
                            border-bottom:2px solid rgba(78,199,210,.1);">
                    <i class="fas fa-folder-open" style="color:#4ec7d2;font-size:.88rem;"></i>
                    Documentos Adjuntos
                </div>

                {{-- Info box --}}
                <div class="info-box mb-3">
                    <p style="font-size:.78rem;font-weight:700;color:#003b73;margin:0 0 .4rem;">
                        <i class="fas fa-clipboard-check me-2" style="color:#4ec7d2;"></i>
                        Documentos requeridos:
                    </p>
                    <ul style="margin:0;padding-left:0;list-style:none;line-height:1.9;">
                        <li style="font-size:.78rem;color:#003b73;"><i class="fas fa-check-circle me-2" style="color:#4ec7d2;"></i>Foto del estudiante (JPG/PNG)</li>
                        <li style="font-size:.78rem;color:#003b73;"><i class="fas fa-check-circle me-2" style="color:#4ec7d2;"></i>Acta de nacimiento</li>
                        <li style="font-size:.78rem;color:#003b73;"><i class="fas fa-check-circle me-2" style="color:#4ec7d2;"></i>Certificado de estudios del año anterior</li>
                        <li style="font-size:.78rem;color:#003b73;"><i class="fas fa-check-circle me-2" style="color:#4ec7d2;"></i>Constancia de conducta</li>
                        <li style="font-size:.78rem;color:#003b73;"><i class="fas fa-check-circle me-2" style="color:#4ec7d2;"></i>DNI del estudiante y del padre/tutor</li>
                    </ul>
                </div>

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-camera me-1"></i> Foto del Estudiante
                        </label>
                        <input type="file"
                               class="form-control @error('foto_estudiante') is-invalid @enderror"
                               name="foto_estudiante" accept="image/*">
                        <small style="font-size:.68rem;color:#6b7a90;">JPG, PNG — Máx. 2MB</small>
                        @error('foto_estudiante')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-file-alt me-1"></i> Acta de Nacimiento
                        </label>
                        <input type="file"
                               class="form-control @error('acta_nacimiento') is-invalid @enderror"
                               name="acta_nacimiento" accept=".pdf,image/*">
                        <small style="font-size:.68rem;color:#6b7a90;">PDF, JPG, PNG — Máx. 5MB</small>
                        @error('acta_nacimiento')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-certificate me-1"></i> Certificado de Estudios
                        </label>
                        <input type="file"
                               class="form-control @error('certificado_estudios') is-invalid @enderror"
                               name="certificado_estudios" accept=".pdf,image/*">
                        <small style="font-size:.68rem;color:#6b7a90;">PDF, JPG, PNG — Máx. 5MB</small>
                        @error('certificado_estudios')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-award me-1"></i> Constancia de Conducta
                        </label>
                        <input type="file"
                               class="form-control @error('constancia_conducta') is-invalid @enderror"
                               name="constancia_conducta" accept=".pdf,image/*">
                        <small style="font-size:.68rem;color:#6b7a90;">PDF, JPG, PNG — Máx. 5MB</small>
                        @error('constancia_conducta')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-id-card me-1"></i> DNI del Estudiante (foto)
                        </label>
                        <input type="file"
                               class="form-control @error('foto_dni_estudiante') is-invalid @enderror"
                               name="foto_dni_estudiante" accept="image/*">
                        <small style="font-size:.68rem;color:#6b7a90;">JPG, PNG — Máx. 2MB</small>
                        @error('foto_dni_estudiante')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-id-card-alt me-1"></i> DNI del Padre / Tutor (foto)
                        </label>
                        <input type="file"
                               class="form-control @error('foto_dni_padre') is-invalid @enderror"
                               name="foto_dni_padre" accept="image/*">
                        <small style="font-size:.68rem;color:#6b7a90;">JPG, PNG — Máx. 2MB</small>
                        @error('foto_dni_padre')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>{{-- fin sección 4 --}}

            {{-- ══════════════════════════════════════
                 BOTONES
            ══════════════════════════════════════ --}}
            <div style="display:flex;gap:.6rem;flex-wrap:wrap;
                        padding:1.1rem 1.7rem;
                        background:#f5f8fc;border-top:1px solid #e8edf4;
                        border-radius:0 0 14px 14px;">

                <button type="submit" class="btn-primary-custom">
                    <i class="fas fa-save"></i> Registrar Matrícula
                </button>
                <a href="{{ route('matriculas.index') }}" class="btn-cancel-custom">
                    <i class="fas fa-times"></i> Cancelar
                </a>

            </div>

        </form>
    </div>{{-- fin body --}}
</div>{{-- fin width:100% --}}
@endsection

@push('scripts')
<script>
    document.getElementById('estadoSelect').addEventListener('change', function () {
        const container = document.getElementById('motivoRechazoContainer');
        if (this.value === 'rechazada') {
            container.style.display = 'block';
        } else {
            container.style.display = 'none';
            container.querySelector('input').value = '';
        }
    });

    function toggleOtroParentesco() {
        const select = document.getElementById('parentescoSelect');
        const div    = document.getElementById('otroParentescoDiv');
        div.style.display = select.value === 'otro' ? 'block' : 'none';
    }
</script>
@endpush

