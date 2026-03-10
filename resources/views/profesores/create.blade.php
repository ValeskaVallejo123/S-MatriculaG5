@extends('layouts.app')

@section('title', 'Nuevo Profesor')
@section('page-title', 'Registrar Nuevo Profesor')

@section('topbar-actions')
    <a href="{{ route('profesores.index') }}"
       style="background:white; color:#00508f;
              padding:.6rem .75rem;
              border-radius:9px;
              text-decoration:none; font-weight:600; display:inline-flex; align-items:center;
              gap:0.4rem; transition:all 0.2s ease; border:1.5px solid #00508f;
              font-size:.83rem;">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
@endsection

@push('styles')
<style>
/* ════════════════════════════════════════════════
   TAMAÑOS — igualados al perfil del estudiante
   ════════════════════════════════════════════════ */

/* ── Inputs y Selects ── */
.form-control,
.form-select {
    border: 2px solid #bfd9ea !important;
    border-radius: 10px;                             /* ← REDONDEZ inputs */
    padding: 0.68rem 1rem 0.68rem 2.8rem !important; /* ← ALTO inputs */
    font-size: .88rem !important;                    /* ← TEXTO inputs */
    transition: all 0.3s ease;
    height: auto !important;
}

.form-control:focus,
.form-select:focus {
    border-color: #4ec7d2 !important;
    box-shadow: 0 0 0 0.15rem rgba(78,199,210,0.15);
    outline: none;
}

.form-control.is-invalid,
.form-select.is-invalid {
    border-color: #ef4444 !important;
    background-image: none;
}

/* ── Labels ── */
.form-label {
    color: #003b73 !important;
    font-size: .63rem !important;                    /* ← TAMAÑO labels */
    font-weight: 700 !important;
    text-transform: uppercase;
    letter-spacing: .08em;
    margin-bottom: .22rem;
}

/* ── Títulos de sección ── */
.sec-title {
    color: #00508f;
    font-weight: 700;
    font-size: .75rem;                               /* ← TAMAÑO títulos sección */
    text-transform: uppercase;
    letter-spacing: .08em;
}

/* ── Mensajes de error ── */
.invalid-feedback {
    font-size: .7rem;                                /* ← TAMAÑO mensajes error */
    display: block;
    margin-top: 0.35rem;
}

/* ── Hint / small text ── */
.hint-text {
    font-size: .68rem;                               /* ← TAMAÑO texto ayuda */
    color: #6b7a90;
}

/* ── Botón Guardar ── */
.btn-primary-custom {
    background: linear-gradient(135deg, #4ec7d2, #00508f);
    color: white;
    border: none;
    border-radius: 9px;                              /* ← REDONDEZ botón */
    padding: .6rem .75rem;                           /* ← TAMAÑO botón guardar */
    font-size: .83rem;                               /* ← TEXTO botón guardar */
    font-weight: 600;
    box-shadow: 0 2px 10px rgba(78,199,210,.3);
    transition: all .2s;
}
.btn-primary-custom:hover {
    color: white;
    box-shadow: 0 4px 16px rgba(78,199,210,.4);
    transform: translateY(-2px);
}

/* ── Botón Cancelar ── */
.btn-cancel-custom {
    border: 1.5px solid #00508f;                     /* ← GROSOR borde */
    color: #00508f;
    background: white;
    border-radius: 9px;                              /* ← REDONDEZ botón */
    padding: .6rem .75rem;                           /* ← TAMAÑO botón cancelar */
    font-size: .83rem;                               /* ← TEXTO botón cancelar */
    font-weight: 600;
    transition: all .2s;
}
.btn-cancel-custom:hover {
    background: #eff6ff;
    color: #00508f;
    transform: translateY(-2px);
}

/* ── Separadores ── */
.sec-divider {
    border-color: rgba(78,199,210,.1) !important;
}
</style>
@endpush

@section('content')

{{-- ← width:100% sin container, igual que el perfil --}}
<div style="width:100%;">

    {{-- ── HEADER ── --}}
    <div style="border-radius:14px 14px 0 0;
                background:linear-gradient(135deg,#002d5a 0%,#00508f 55%,#0077b6 100%);
                padding:2rem; position:relative; overflow:hidden;">

        {{-- burbujas decorativas --}}
        <div style="position:absolute;right:-50px;top:-50px;width:200px;height:200px;
                    border-radius:50%;background:rgba(78,199,210,.13);pointer-events:none;"></div>
        <div style="position:absolute;right:100px;bottom:-45px;width:120px;height:120px;
                    border-radius:50%;background:rgba(255,255,255,.05);pointer-events:none;"></div>

        <div style="position:relative;z-index:1;display:flex;align-items:center;gap:1.4rem;flex-wrap:wrap;">
            <div style="width:80px; height:80px;            {{-- ← TAMAÑO ícono header --}}
                        border-radius:18px;
                        border:3px solid rgba(78,199,210,.7);
                        background:rgba(255,255,255,.12);
                        display:flex; align-items:center; justify-content:center;
                        box-shadow:0 6px 20px rgba(0,0,0,.25);">
                <i class="fas fa-chalkboard-teacher" style="color:white; font-size:2rem;"></i> {{-- ← ÍCONO interno --}}
            </div>
            <div>
                <h2 style="font-size:1.45rem; font-weight:800; color:white; {{-- ← TÍTULO header --}}
                           margin:0 0 .4rem; text-shadow:0 1px 4px rgba(0,0,0,.2);">
                    Registro de Profesor
                </h2>
                <span style="display:inline-flex; align-items:center; gap:.3rem;
                             padding:.2rem .65rem; border-radius:999px;
                             background:rgba(255,255,255,.14); color:rgba(255,255,255,.92);
                             font-size:.72rem; font-weight:600;  {{-- ← TEXTO tag header --}}
                             border:1px solid rgba(255,255,255,.18);">
                    <i class="fas fa-pen"></i> Complete la información requerida
                </span>
            </div>
        </div>
    </div>

    {{-- ── BODY ── --}}
    <div style="background:white; border:1px solid #e8edf4; border-top:none;
                border-radius:0 0 14px 14px; box-shadow:0 2px 16px rgba(0,59,115,.09);">

        <form action="{{ route('profesores.store') }}" method="POST">
            @csrf

            {{-- ══════════════════════════════════════
                 SECCIÓN 1 · INFORMACIÓN PERSONAL
            ══════════════════════════════════════ --}}
            <div style="padding:1.4rem 1.7rem; border-bottom:1px solid #f0f4f9;">

                <div style="display:flex; align-items:center; justify-content:space-between;
                            margin-bottom:.95rem; padding-bottom:.55rem;
                            border-bottom:2px solid rgba(78,199,210,.1);">
                    <div style="display:flex; align-items:center; gap:.5rem;
                                font-size:.75rem; font-weight:700; color:#00508f;
                                text-transform:uppercase; letter-spacing:.08em;">
                        <i class="fas fa-user" style="color:#4ec7d2; font-size:.88rem;"></i>
                        Información Personal
                    </div>
                </div>

                <div class="row g-3">

                    {{-- Nombre --}}
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">
                            Nombre <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-user position-absolute"
                               style="left:12px; top:50%; transform:translateY(-50%);
                                      color:#00508f; font-size:.68rem;"></i>
                            <input type="text"
                                   class="form-control @error('nombre') is-invalid @enderror"
                                   id="nombre" name="nombre"
                                   value="{{ old('nombre') }}"
                                   placeholder="Ej: Juan Carlos">
                            @error('nombre')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    {{-- Apellido --}}
                    <div class="col-md-6">
                        <label for="apellido" class="form-label">
                            Apellido <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-user position-absolute"
                               style="left:12px; top:50%; transform:translateY(-50%);
                                      color:#00508f; font-size:.68rem;"></i>
                            <input type="text"
                                   class="form-control @error('apellido') is-invalid @enderror"
                                   id="apellido" name="apellido"
                                   value="{{ old('apellido') }}"
                                   placeholder="Ej: Pérez García">
                            @error('apellido')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    {{-- DNI --}}
                    <div class="col-md-6">
                        <label for="dni" class="form-label">
                            DNI <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-id-card position-absolute"
                               style="left:12px; top:50%; transform:translateY(-50%);
                                      color:#00508f; font-size:.68rem;"></i>
                            <input type="text"
                                   class="form-control @error('dni') is-invalid @enderror"
                                   id="dni" name="dni"
                                   value="{{ old('dni') }}"
                                   placeholder="Ej: 0801199512345" maxlength="13">
                            @error('dni')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                        <small class="hint-text">
                            <i class="fas fa-info-circle me-1"></i>Formato: 13 dígitos
                        </small>
                    </div>

                    {{-- Fecha de Nacimiento --}}
                    <div class="col-md-6">
                        <label for="fecha_nacimiento" class="form-label">
                            Fecha de Nacimiento
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-calendar position-absolute"
                               style="left:12px; top:50%; transform:translateY(-50%);
                                      color:#00508f; font-size:.68rem;"></i>
                            <input type="date"
                                   class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                                   id="fecha_nacimiento" name="fecha_nacimiento"
                                   value="{{ old('fecha_nacimiento') }}">
                            @error('fecha_nacimiento')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    {{-- Género --}}
                    <div class="col-md-6">
                        <label for="genero" class="form-label">Género</label>
                        <div class="position-relative">
                            <i class="fas fa-venus-mars position-absolute"
                               style="left:12px; top:50%; transform:translateY(-50%);
                                      color:#00508f; font-size:.68rem; z-index:10;"></i>
                            <select class="form-select @error('genero') is-invalid @enderror"
                                    id="genero" name="genero">
                                <option value="">Seleccionar...</option>
                                <option value="masculino" {{ old('genero')=='masculino'?'selected':'' }}>Masculino</option>
                                <option value="femenino"  {{ old('genero')=='femenino' ?'selected':'' }}>Femenino</option>
                                <option value="otro"      {{ old('genero')=='otro'     ?'selected':'' }}>Otro</option>
                            </select>
                            @error('genero')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    {{-- Teléfono --}}
                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <div class="position-relative">
                            <i class="fas fa-phone position-absolute"
                               style="left:12px; top:50%; transform:translateY(-50%);
                                      color:#00508f; font-size:.68rem;"></i>
                            <input type="text"
                                   class="form-control @error('telefono') is-invalid @enderror"
                                   id="telefono" name="telefono"
                                   value="{{ old('telefono') }}"
                                   placeholder="Ej: 9876-5432">
                            @error('telefono')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>{{-- fin sección Personal --}}

            {{-- ══════════════════════════════════════
                 SECCIÓN 2 · INFORMACIÓN DE CONTACTO
            ══════════════════════════════════════ --}}
            <div style="padding:1.4rem 1.7rem; border-bottom:1px solid #f0f4f9;">

                <div style="display:flex; align-items:center; justify-content:space-between;
                            margin-bottom:.95rem; padding-bottom:.55rem;
                            border-bottom:2px solid rgba(78,199,210,.1);">
                    <div style="display:flex; align-items:center; gap:.5rem;
                                font-size:.75rem; font-weight:700; color:#00508f;
                                text-transform:uppercase; letter-spacing:.08em;">
                        <i class="fas fa-envelope" style="color:#4ec7d2; font-size:.88rem;"></i>
                        Información de Contacto
                    </div>
                </div>

                <div class="row g-3">

                    {{-- Email --}}
                    <div class="col-md-6">
                        <label for="email" class="form-label">
                            Email <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-envelope position-absolute"
                               style="left:12px; top:50%; transform:translateY(-50%);
                                      color:#00508f; font-size:.68rem;"></i>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email"
                                   value="{{ old('email') }}"
                                   placeholder="profesor@ejemplo.com">
                            @error('email')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    {{-- Dirección --}}
                    <div class="col-md-6">
                        <label for="direccion" class="form-label">Dirección</label>
                        <div class="position-relative">
                            <i class="fas fa-map-marker-alt position-absolute"
                               style="left:12px; top:50%; transform:translateY(-50%);
                                      color:#00508f; font-size:.68rem;"></i>
                            <input type="text"
                                   class="form-control @error('direccion') is-invalid @enderror"
                                   id="direccion" name="direccion"
                                   value="{{ old('direccion') }}"
                                   placeholder="Ej: Barrio El Centro, Calle Principal">
                            @error('direccion')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>{{-- fin sección Contacto --}}

            {{-- ══════════════════════════════════════
                 SECCIÓN 3 · INFORMACIÓN ACADÉMICA
            ══════════════════════════════════════ --}}
            <div style="padding:1.4rem 1.7rem; border-bottom:1px solid #f0f4f9;">

                <div style="display:flex; align-items:center; justify-content:space-between;
                            margin-bottom:.95rem; padding-bottom:.55rem;
                            border-bottom:2px solid rgba(78,199,210,.1);">
                    <div style="display:flex; align-items:center; gap:.5rem;
                                font-size:.75rem; font-weight:700; color:#00508f;
                                text-transform:uppercase; letter-spacing:.08em;">
                        <i class="fas fa-graduation-cap" style="color:#4ec7d2; font-size:.88rem;"></i>
                        Información Académica
                    </div>
                </div>

                <div class="row g-3">

                    {{-- Especialidad --}}
                    <div class="col-md-6">
                        <label for="especialidad" class="form-label">
                            Especialidad <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-book position-absolute"
                               style="left:12px; top:50%; transform:translateY(-50%);
                                      color:#00508f; font-size:.68rem;"></i>
                            <input type="text"
                                   class="form-control @error('especialidad') is-invalid @enderror"
                                   id="especialidad" name="especialidad"
                                   value="{{ old('especialidad') }}"
                                   placeholder="Ej: Matemáticas, Español, Ciencias">
                            @error('especialidad')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    {{-- Nivel Académico --}}
                    <div class="col-md-6">
                        <label for="nivel_academico" class="form-label">Nivel Académico</label>
                        <div class="position-relative">
                            <i class="fas fa-certificate position-absolute"
                               style="left:12px; top:50%; transform:translateY(-50%);
                                      color:#00508f; font-size:.68rem; z-index:10;"></i>
                            <select class="form-select @error('nivel_academico') is-invalid @enderror"
                                    id="nivel_academico" name="nivel_academico">
                                <option value="">Seleccionar...</option>
                                <option value="bachillerato" {{ old('nivel_academico')=='bachillerato'?'selected':'' }}>Bachillerato</option>
                                <option value="licenciatura" {{ old('nivel_academico')=='licenciatura'?'selected':'' }}>Licenciatura</option>
                                <option value="maestria"     {{ old('nivel_academico')=='maestria'    ?'selected':'' }}>Maestría</option>
                                <option value="doctorado"    {{ old('nivel_academico')=='doctorado'   ?'selected':'' }}>Doctorado</option>
                            </select>
                            @error('nivel_academico')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>{{-- fin sección Académica --}}

            {{-- ══════════════════════════════════════
                 SECCIÓN 4 · INFORMACIÓN LABORAL
            ══════════════════════════════════════ --}}
            <div style="padding:1.4rem 1.7rem; border-bottom:1px solid #f0f4f9;">

                <div style="display:flex; align-items:center; justify-content:space-between;
                            margin-bottom:.95rem; padding-bottom:.55rem;
                            border-bottom:2px solid rgba(78,199,210,.1);">
                    <div style="display:flex; align-items:center; gap:.5rem;
                                font-size:.75rem; font-weight:700; color:#00508f;
                                text-transform:uppercase; letter-spacing:.08em;">
                        <i class="fas fa-briefcase" style="color:#4ec7d2; font-size:.88rem;"></i>
                        Información Laboral
                    </div>
                </div>

                <div class="row g-3">

                    {{-- Fecha de Contratación --}}
                    <div class="col-md-6">
                        <label for="fecha_contratacion" class="form-label">
                            Fecha de Contratación
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-calendar-check position-absolute"
                               style="left:12px; top:50%; transform:translateY(-50%);
                                      color:#00508f; font-size:.68rem;"></i>
                            <input type="date"
                                   class="form-control @error('fecha_contratacion') is-invalid @enderror"
                                   id="fecha_contratacion" name="fecha_contratacion"
                                   value="{{ old('fecha_contratacion') }}">
                            @error('fecha_contratacion')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    {{-- Tipo de Contrato --}}
                    <div class="col-md-6">
                        <label for="tipo_contrato" class="form-label">Tipo de Contrato</label>
                        <div class="position-relative">
                            <i class="fas fa-file-contract position-absolute"
                               style="left:12px; top:50%; transform:translateY(-50%);
                                      color:#00508f; font-size:.68rem; z-index:10;"></i>
                            <select class="form-select @error('tipo_contrato') is-invalid @enderror"
                                    id="tipo_contrato" name="tipo_contrato">
                                <option value="">Seleccionar...</option>
                                <option value="tiempo_completo" {{ old('tipo_contrato')=='tiempo_completo'?'selected':'' }}>Tiempo Completo</option>
                                <option value="medio_tiempo"    {{ old('tipo_contrato')=='medio_tiempo'   ?'selected':'' }}>Medio Tiempo</option>
                                <option value="por_horas"       {{ old('tipo_contrato')=='por_horas'      ?'selected':'' }}>Por Horas</option>
                            </select>
                            @error('tipo_contrato')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    {{-- Estado --}}
                    <div class="col-md-6">
                        <label for="estado" class="form-label">
                            Estado <span style="color:#ef4444;">*</span>
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-toggle-on position-absolute"
                               style="left:12px; top:50%; transform:translateY(-50%);
                                      color:#00508f; font-size:.68rem; z-index:10;"></i>
                            <select class="form-select @error('estado') is-invalid @enderror"
                                    id="estado" name="estado">
                                <option value="activo"   {{ old('estado')=='activo'  ?'selected':'' }}>Activo</option>
                                <option value="inactivo" {{ old('estado')=='inactivo'?'selected':'' }}>Inactivo</option>
                                <option value="licencia" {{ old('estado')=='licencia'?'selected':'' }}>En Licencia</option>
                            </select>
                            @error('estado')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>{{-- fin sección Laboral --}}

            {{-- ══════════════════════════════════════
                 BOTONES — igual que pf-footer del perfil
            ══════════════════════════════════════ --}}
            <div style="display:flex; gap:.6rem; flex-wrap:wrap;
                        padding:1.1rem 1.7rem;
                        background:#f5f8fc; border-top:1px solid #e8edf4;
                        border-radius:0 0 14px 14px;">
                <button type="submit" class="btn btn-primary-custom flex-fill">
                    <i class="fas fa-save me-1"></i>Guardar Profesor
                </button>
                <a href="{{ route('profesores.index') }}" class="btn btn-cancel-custom flex-fill">
                    <i class="fas fa-times me-1"></i>Cancelar
                </a>
            </div>

        </form>
    </div>{{-- fin body --}}
</div>{{-- fin width:100% --}}

@endsection
