@extends('layouts.app')

@section('title', 'Crear Estudiante')
@section('page-title', 'Nuevo Estudiante')


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
            padding: 0.68rem 1rem 0.68rem 2.8rem !important; /* ← ALTO inputs: cambia 0.68rem */
            font-size: .88rem !important;                    /* ← TEXTO inputs: cambia .88rem */
            transition: all 0.3s ease;
            height: auto !important;
        }

        /* Inputs/Selects SIN ícono (académica y adicional) */
        select[name="grado"],
        select[name="seccion"],
        select[name="estado"],
        textarea[name="observaciones"] {
            padding: 0.68rem 1rem !important;                /* ← mismo alto, sin espacio ícono */
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #4ec7d2 !important;
            box-shadow: 0 0 0 0.15rem rgba(78,199,210,0.15);
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
            font-size: .75rem;                               /* ← TAMAÑO títulos de sección */
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        /* ── Mensajes de error ── */
        .invalid-feedback {
            font-size: .7rem;                                /* ← TAMAÑO mensajes error */
        }

        /* ── Textarea ── */
        textarea.form-control {
            padding-left: 1rem !important;
            resize: none;
            min-height: 80px;                                /* ← ALTO textarea */
        }

        /* ── Botón Registrar ── */
        .btn-primary-custom {
            background: linear-gradient(135deg, #4ec7d2, #00508f);
            color: white;
            border: none;
            border-radius: 9px;                              /* ← REDONDEZ botón */
            padding: .6rem .75rem;                           /* ← TAMAÑO botón registrar */
            font-size: .83rem;                               /* ← TEXTO botón registrar */
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
            border: 1.5px solid #00508f;                     /* ← GROSOR borde botón cancelar */
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
        .border-bottom {
            border-color: rgba(78,199,210,.1) !important;
        }
    </style>
@endpush

@section('content')

    {{-- ← SIN container ni max-width, igual que el perfil --}}
    <div style="width:100%;">

        {{-- ── HEADER ── --}}
        <div style="border-radius:14px 14px 0 0;
                background:linear-gradient(135deg,#002d5a 0%,#00508f 55%,#0077b6 100%);
                padding:2rem; position:relative; overflow:hidden;">

            {{-- burbujas decorativas igual que el perfil --}}
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
                    <i class="fas fa-user-plus" style="color:white; font-size:2rem;"></i> {{-- ← ÍCONO interno --}}
                </div>
                <div>
                    <h2 style="font-size:1.45rem; font-weight:800; color:white; {{-- ← TÍTULO header --}}
                           margin:0 0 .4rem; text-shadow:0 1px 4px rgba(0,0,0,.2);">
                        Registro de Estudiante
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

        {{-- ── BODY DEL FORMULARIO — igual estructura que pf-body del perfil ── --}}
        <div style="background:white; border:1px solid #e8edf4; border-top:none;
                border-radius:0 0 14px 14px; box-shadow:0 2px 16px rgba(0,59,115,.09);">

            <form action="{{ route('estudiantes.store') }}" method="POST">
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

                        {{-- Primer Nombre --}}
                        <div class="col-md-6">
                            <label for="nombre1" class="form-label">
                                Primer Nombre <span style="color:#ef4444;">*</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-user position-absolute"
                                   style="left:12px; top:50%; transform:translateY(-50%);
                                      color:#00508f; font-size:.68rem;"></i>
                                <input type="text"
                                       class="form-control @error('nombre1') is-invalid @enderror"
                                       id="nombre1" name="nombre1"
                                       value="{{ old('nombre1') }}"
                                       placeholder="Ej: Juan" required>
                                @error('nombre1')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Segundo Nombre --}}
                        <div class="col-md-6">
                            <label for="nombre2" class="form-label">
                                Segundo Nombre
                                <span style="color:#6b7a90; font-weight:400; text-transform:none; font-size:.72rem;">(Opcional)</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-user position-absolute"
                                   style="left:12px; top:50%; transform:translateY(-50%);
                                      color:#00508f; font-size:.68rem;"></i>
                                <input type="text"
                                       class="form-control @error('nombre2') is-invalid @enderror"
                                       id="nombre2" name="nombre2"
                                       value="{{ old('nombre2') }}"
                                       placeholder="Ej: Carlos">
                                @error('nombre2')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Primer Apellido --}}
                        <div class="col-md-6">
                            <label for="apellido1" class="form-label">
                                Primer Apellido <span style="color:#ef4444;">*</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-user position-absolute"
                                   style="left:12px; top:50%; transform:translateY(-50%);
                                      color:#00508f; font-size:.68rem;"></i>
                                <input type="text"
                                       class="form-control @error('apellido1') is-invalid @enderror"
                                       id="apellido1" name="apellido1"
                                       value="{{ old('apellido1') }}"
                                       placeholder="Ej: Pérez" required>
                                @error('apellido1')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Segundo Apellido --}}
                        <div class="col-md-6">
                            <label for="apellido2" class="form-label">
                                Segundo Apellido
                                <span style="color:#6b7a90; font-weight:400; text-transform:none; font-size:.72rem;">(Opcional)</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-user position-absolute"
                                   style="left:12px; top:50%; transform:translateY(-50%);
                                      color:#00508f; font-size:.68rem;"></i>
                                <input type="text"
                                       class="form-control @error('apellido2') is-invalid @enderror"
                                       id="apellido2" name="apellido2"
                                       value="{{ old('apellido2') }}"
                                       placeholder="Ej: García">
                                @error('apellido2')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        {{-- DNI --}}
                        <div class="col-md-6">
                            <label for="dni" class="form-label">DNI</label>
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
                        </div>

                        {{-- Fecha de Nacimiento --}}
                        <div class="col-md-6">
                            <label for="fecha_nacimiento" class="form-label">
                                Fecha de Nacimiento <span style="color:#ef4444;">*</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-calendar position-absolute"
                                   style="left:12px; top:50%; transform:translateY(-50%);
                                      color:#00508f; font-size:.68rem;"></i>
                                <input type="date"
                                       class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                                       id="fecha_nacimiento" name="fecha_nacimiento"
                                       value="{{ old('fecha_nacimiento') }}" required>
                                @error('fecha_nacimiento')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Género --}}
                        <div class="col-md-6">
                            <label for="sexo" class="form-label">
                                Género <span style="color:#ef4444;">*</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-venus-mars position-absolute"
                                   style="left:12px; top:50%; transform:translateY(-50%);
                                      color:#00508f; font-size:.68rem; z-index:10;"></i>
                                <select class="form-select @error('sexo') is-invalid @enderror"
                                        id="sexo" name="sexo" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="masculino" {{ old('sexo')=='masculino'?'selected':'' }}>Masculino</option>
                                    <option value="femenino"  {{ old('sexo')=='femenino' ?'selected':'' }}>Femenino</option>
                                </select>
                                @error('sexo')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <div class="position-relative">
                                <i class="fas fa-envelope position-absolute"
                                   style="left:12px; top:50%; transform:translateY(-50%);
                                      color:#00508f; font-size:.68rem;"></i>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email"
                                       value="{{ old('email') }}"
                                       placeholder="estudiante@ejemplo.com">
                                @error('email')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                    </div>{{-- fin row Personal --}}
                </div>{{-- fin sección Personal --}}

                {{-- ══════════════════════════════════════
                     SECCIÓN 2 · INFORMACIÓN ACADÉMICA
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

                        {{-- Grado --}}
                        <div class="col-md-4">
                            <label class="form-label">
                                Grado <span style="color:#ef4444;">*</span>
                            </label>
                            <select name="grado"
                                    class="form-select @error('grado') is-invalid @enderror"
                                    required>
                                <option value="">Seleccione</option>
                                @foreach($grados as $grado)
                                    <option value="{{ $grado }}" {{ old('grado')==$grado?'selected':'' }}>
                                        {{ $grado }}
                                    </option>
                                @endforeach
                            </select>
                            @error('grado')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Sección --}}
                        <div class="col-md-4">
                            <label class="form-label">
                                Sección <span style="color:#ef4444;">*</span>
                            </label>
                            <select name="seccion"
                                    class="form-select @error('seccion') is-invalid @enderror"
                                    required>
                                <option value="">Seleccione</option>
                                @foreach($secciones as $seccion)
                                    <option value="{{ $seccion }}" {{ old('seccion')==$seccion?'selected':'' }}>
                                        {{ $seccion }}
                                    </option>
                                @endforeach
                            </select>
                            @error('seccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Estado --}}
                        <div class="col-md-4">
                            <label class="form-label">
                                Estado <span style="color:#ef4444;">*</span>
                            </label>
                            <select name="estado"
                                    class="form-select @error('estado') is-invalid @enderror"
                                    required>
                                <option value="activo"   {{ old('estado')=='activo'  ?'selected':'' }}>Activo</option>
                                <option value="inactivo" {{ old('estado')=='inactivo'?'selected':'' }}>Inactivo</option>
                            </select>
                            @error('estado')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>{{-- fin sección Académica --}}

                {{-- ══════════════════════════════════════
                     SECCIÓN 3 · INFORMACIÓN ADICIONAL
                ══════════════════════════════════════ --}}
                <div style="padding:1.4rem 1.7rem; border-bottom:1px solid #f0f4f9;">

                    <div style="display:flex; align-items:center; justify-content:space-between;
                            margin-bottom:.95rem; padding-bottom:.55rem;
                            border-bottom:2px solid rgba(78,199,210,.1);">
                        <div style="display:flex; align-items:center; gap:.5rem;
                                font-size:.75rem; font-weight:700; color:#00508f;
                                text-transform:uppercase; letter-spacing:.08em;">
                            <i class="fas fa-clipboard" style="color:#4ec7d2; font-size:.88rem;"></i>
                            Información Adicional
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Observaciones</label>
                            <textarea name="observaciones" rows="3" maxlength="500"
                                      class="form-control @error('observaciones') is-invalid @enderror"
                                      placeholder="Información adicional (alergias, condiciones médicas, notas especiales)"
                            >{{ old('observaciones') }}</textarea>
                            @error('observaciones')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>{{-- fin sección Adicional --}}

                {{-- ══════════════════════════════════════
                     BOTONES — igual que pf-footer del perfil
                ══════════════════════════════════════ --}}
                <div style="display:flex; gap:.6rem; flex-wrap:wrap;
                        padding:1.1rem 1.7rem;
                        background:#f5f8fc; border-top:1px solid #e8edf4;
                        border-radius:0 0 14px 14px;">
                    <button type="submit" class="btn btn-primary-custom flex-fill">
                        <i class="fas fa-save me-1"></i>Registrar Estudiante
                    </button>
                    <a href="{{ route('estudiantes.index') }}" class="btn btn-cancel-custom flex-fill">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </a>
                </div>

            </form>
        </div>{{-- fin body --}}
    </div>{{-- fin width:100% --}}

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nombre1Input   = document.getElementById('nombre1');
            const apellido1Input = document.getElementById('apellido1');
            const emailInput     = document.getElementById('email');

            function normalizar(txt) {
                return txt.normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')
                    .replace(/[^a-zA-Z]/g, '')
                    .toLowerCase();
            }

            function generarCorreo() {
                const nombre   = normalizar(nombre1Input.value   || '');
                const apellido = normalizar(apellido1Input.value || '');
                emailInput.value = (nombre && apellido)
                    ? `${nombre}.${apellido}@egm.edu.hn`
                    : '';
            }

            nombre1Input.addEventListener('input', generarCorreo);
            apellido1Input.addEventListener('input', generarCorreo);
        });
    </script>
@endpush
