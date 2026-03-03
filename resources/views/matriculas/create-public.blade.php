<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrícula en Línea - Escuela Gabriela Mistral</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            padding: 20px 0;
        }

        /* ── Header ── */
        .header-section {
            background: linear-gradient(135deg, #003b73 0%, #00508f 100%);
            padding: 30px 0;
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(0,59,115,.3);
        }
        .header-content { text-align: center; color: white; }
        .header-content h1 { font-size: 2rem; font-weight: 700; margin-bottom: 10px; }

        /* ── Contenedor principal ── */
        .form-container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0,59,115,.1);
        }

        /* ── Botones de navegación ── */
        .btn-back {
            background: #6c757d;
            color: white;
            padding: 10px 25px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all .3s ease;
        }
        .btn-back:hover { background: #5a6268; color: white; transform: translateY(-2px); }

        /* ── Cards de sección ── */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,59,115,.1);
            margin-bottom: 20px;
        }
        .section-title { font-size: 1.1rem; font-weight: 700; color: #003b73; }

        /* ── Campos ── */
        .form-label { font-weight: 600; color: #00508f; font-size: .9rem; margin-bottom: 8px; }

        .form-control,
        .form-select {
            border: 2px solid #bfd9ea;
            border-radius: 8px;
            padding: .6rem 1rem .6rem 2.8rem;
            transition: all .3s ease;
            font-size: .95rem;
        }
        .form-control:focus,
        .form-select:focus {
            border-color: #4ec7d2;
            box-shadow: 0 0 0 3px rgba(78,199,210,.15);
            outline: none;
        }

        /* Campo rellenado → fondo azul claro */
        .form-control.campo-rellenado,
        .form-select.campo-rellenado {
            background-color: #e8f4fd;
            border-color: #4ec7d2;
        }

        /* Sin icono izquierdo (textarea dirección, observaciones) */
        textarea.form-control { padding-left: 2.8rem; }

        /* ── Indicadores ── */
        .required-mark  { color: #ef4444; font-weight: 700; }
        .optional-mark  { color: #6c757d; font-weight: 400; font-size: .8rem; }

        /* ── Alertas ── */
        .alert { border-radius: 12px; border: none; }
        .info-alert {
            background: rgba(78,199,210,.1);
            border: 2px solid #4ec7d2;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
        }

        /* ── Icono de sección ── */
        .icon-box {
            width: 36px; height: 36px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
        }

        /* ── Cajas de documentos ── */
        .file-upload-box {
            border: 2px dashed #4ec7d2;
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            background: rgba(78,199,210,.05);
            transition: all .3s ease;
            cursor: pointer;
            height: 100%;
            display: flex; flex-direction: column;
            justify-content: center; align-items: center;
            min-height: 150px;
        }
        .file-upload-box:hover { background: rgba(78,199,210,.1); border-color: #00508f; }
        .file-upload-box.archivo-subido { background: #e8f4fd; border-color: #4ec7d2; border-style: solid; }
        .file-upload-box i     { font-size: 2rem; color: #4ec7d2; margin-bottom: 8px; }
        .file-upload-box p     { color: #003b73; font-weight: 600; margin-bottom: 3px; font-size: .85rem; }
        .file-upload-box small { color: #6c757d; font-size: .7rem; }

        /* ── Preview de archivos ── */
        .file-preview {
            background: #f8f9fa;
            padding: 8px 12px;
            border-radius: 8px;
            margin-top: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #e1e8ed;
            font-size: .8rem;
        }
        .file-preview .btn-clear {
            background: #ef4444; color: white; border: none;
            padding: 3px 10px; border-radius: 6px;
            cursor: pointer; font-size: .7rem; transition: all .3s ease;
            white-space: nowrap;
        }
        .file-preview .btn-clear:hover { background: #dc2626; }
        .file-preview .file-name {
            font-size: .75rem; color: #003b73; font-weight: 500;
            white-space: nowrap; overflow: hidden;
            text-overflow: ellipsis; max-width: 150px;
        }

        /* ── Documentos ── */
        .documento-item   { display: flex; flex-direction: column; height: 100%; }
        .documento-label  { font-weight: 600; color: #00508f; font-size: .85rem; margin-bottom: 8px; text-align: center; }

        /* ── Botones de envío ── */
        .btn-submit {
            background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
            color: white; padding: 14px 45px;
            border: none; border-radius: 50px;
            font-weight: 700; font-size: 1.05rem;
            transition: all .3s ease;
            box-shadow: 0 8px 25px rgba(78,199,210,.3);
            display: inline-flex; align-items: center; gap: 10px;
            cursor: pointer;
        }
        .btn-submit:hover { transform: translateY(-3px); box-shadow: 0 12px 35px rgba(78,199,210,.5); color: white; }
        .btn-submit:disabled { opacity: .7; cursor: not-allowed; transform: none; }

        .btn-cancel {
            background: white; color: #003b73;
            padding: 14px 45px;
            border: 2px solid #bfd9ea; border-radius: 50px;
            font-weight: 700; font-size: 1.05rem;
            transition: all .3s ease;
            text-decoration: none;
            display: inline-flex; align-items: center; gap: 10px;
        }
        .btn-cancel:hover { background: #f8f9fa; color: #003b73; border-color: #4ec7d2; transform: translateY(-2px); }

        /* ── Validación ── */
        .invalid-feedback { display: block; color: #ef4444; font-size: .875rem; margin-top: 4px; }
        .is-invalid { border-color: #ef4444 !important; }

        /* ── Posición de íconos ── */
        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #00508f;
            font-size: .85rem;
            pointer-events: none;
            z-index: 5;
        }
        .input-icon-top {
            position: absolute;
            left: 12px;
            top: 18px;
            color: #00508f;
            font-size: .85rem;
            pointer-events: none;
            z-index: 5;
        }
    </style>
</head>
<body>

{{-- ============================================================
     HEADER
============================================================ --}}
<div class="header-section">
    <div class="container header-content">
        <h1><i class="fas fa-graduation-cap me-3"></i>Formulario de Matrícula en Línea</h1>
        <p>Escuela Gabriela Mistral - Año Escolar {{ date('Y') }}</p>
    </div>
</div>

<div class="container">
    <div class="form-container">

        {{-- Botón volver --}}
        <div class="mb-4">
            <a href="{{ route('plantilla') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                <span>Volver al Inicio</span>
            </a>
        </div>

        {{-- Información importante --}}
        <div class="info-alert">
            <h6 style="color:#003b73; font-weight:700; margin-bottom:10px;">
                <i class="fas fa-info-circle me-2"></i>Información Importante
            </h6>
            <ul style="color:#00508f; margin-bottom:0; font-size:.9rem; line-height:1.8;">
                <li>Tu solicitud será revisada por nuestro equipo administrativo</li>
                <li>Si proporcionas un correo electrónico, se creará automáticamente una cuenta de acceso</li>
                <li>Tu contraseña será tu número de DNI (podrás cambiarla después)</li>
                <li>El estado inicial será <strong>PENDIENTE</strong> hasta ser aprobado por el administrador</li>
                <li>La fecha de matrícula se registrará automáticamente al enviar el formulario</li>
                <li><strong>Debes adjuntar los 3 documentos requeridos para completar la matrícula</strong></li>
            </ul>
        </div>

        {{-- Errores de validación --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <h6><i class="fas fa-exclamation-triangle me-2"></i>Errores en el formulario:</h6>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ====================================================
             FORMULARIO
        ==================================================== --}}
        <form action="{{ route('matriculas.public.store') }}"
              method="POST"
              id="formMatricula"
              enctype="multipart/form-data"
              novalidate>
            @csrf
            <input type="hidden" name="publico" value="1">

            {{-- ================================================
                 SECCIÓN 1: PADRE / TUTOR
            ================================================ --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="icon-box" style="background:linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);">
                            <i class="fas fa-user-friends" style="color:white; font-size:.9rem;"></i>
                        </div>
                        <h6 class="mb-0 fw-bold section-title">Información del Padre/Tutor</h6>
                    </div>

                    <div class="row g-3">

                        {{-- Nombre --}}
                        <div class="col-md-6">
                            <label for="padre_nombre" class="form-label">
                                Nombre <span class="required-mark">*</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text"
                                       class="form-control @error('padre_nombre') is-invalid @enderror"
                                       id="padre_nombre" name="padre_nombre"
                                       value="{{ old('padre_nombre') }}"
                                       placeholder="Ej: Juan Carlos" required>
                                @error('padre_nombre')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Apellido --}}
                        <div class="col-md-6">
                            <label for="padre_apellido" class="form-label">
                                Apellido <span class="required-mark">*</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text"
                                       class="form-control @error('padre_apellido') is-invalid @enderror"
                                       id="padre_apellido" name="padre_apellido"
                                       value="{{ old('padre_apellido') }}"
                                       placeholder="Ej: Pérez García" required>
                                @error('padre_apellido')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- DNI Padre --}}
                        <div class="col-md-6">
                            <label for="padre_dni" class="form-label">
                                DNI <span class="required-mark">*</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-id-card input-icon"></i>
                                <input type="text"
                                       class="form-control @error('padre_dni') is-invalid @enderror"
                                       id="padre_dni" name="padre_dni"
                                       value="{{ old('padre_dni') }}"
                                       placeholder="0801199512345"
                                       maxlength="13"
                                       pattern="[0-9]{13}"
                                       inputmode="numeric"
                                       required>
                                @error('padre_dni')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <small class="text-muted" style="font-size:.75rem;">
                                <i class="fas fa-info-circle me-1"></i>13 dígitos (será tu contraseña de acceso)
                            </small>
                        </div>

                        {{-- Parentesco --}}
                        <div class="col-md-6">
                            <label for="padre_parentesco" class="form-label">
                                Parentesco <span class="required-mark">*</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-users input-icon" style="z-index:10;"></i>
                                <select class="form-select @error('padre_parentesco') is-invalid @enderror"
                                        id="padre_parentesco" name="padre_parentesco"
                                        required
                                        onchange="toggleOtroParentesco(); marcarCampo(this);">
                                    <option value="">Seleccionar...</option>
                                    @foreach($parentescos as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ old('padre_parentesco') == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('padre_parentesco')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Otro parentesco (condicional) --}}
                        <div class="col-md-6" id="otro_parentesco_div" style="display:none;">
                            <label for="padre_parentesco_otro" class="form-label">
                                Especificar Parentesco <span class="required-mark">*</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-pen input-icon"></i>
                                <input type="text"
                                       class="form-control @error('padre_parentesco_otro') is-invalid @enderror"
                                       id="padre_parentesco_otro"
                                       name="padre_parentesco_otro"
                                       value="{{ old('padre_parentesco_otro') }}"
                                       placeholder="Ej: Tío, Abuelo, Hermano">
                                @error('padre_parentesco_otro')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Teléfono --}}
                        <div class="col-md-6">
                            <label for="padre_telefono" class="form-label">
                                Teléfono <span class="required-mark">*</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-phone input-icon"></i>
                                <input type="tel"
                                       class="form-control @error('padre_telefono') is-invalid @enderror"
                                       id="padre_telefono" name="padre_telefono"
                                       value="{{ old('padre_telefono') }}"
                                       placeholder="98765432"
                                       maxlength="15"
                                       inputmode="tel"
                                       required>
                                @error('padre_telefono')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6">
                            <label for="padre_email" class="form-label">
                                Email <span class="optional-mark">(Opcional)</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-envelope input-icon"></i>
                                <input type="email"
                                       class="form-control @error('padre_email') is-invalid @enderror"
                                       id="padre_email" name="padre_email"
                                       value="{{ old('padre_email') }}"
                                       placeholder="padre@ejemplo.com"
                                       autocomplete="email">
                                @error('padre_email')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <small class="text-muted" style="font-size:.75rem;">
                                <i class="fas fa-info-circle me-1"></i>Si proporcionas un email, podrás acceder al sistema
                            </small>
                        </div>

                        {{-- Dirección --}}
                        <div class="col-12">
                            <label for="padre_direccion" class="form-label">
                                Dirección <span class="required-mark">*</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-map-marker-alt input-icon-top"></i>
                                <textarea class="form-control @error('padre_direccion') is-invalid @enderror"
                                          id="padre_direccion" name="padre_direccion"
                                          rows="2"
                                          placeholder="Dirección completa"
                                          required>{{ old('padre_direccion') }}</textarea>
                                @error('padre_direccion')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                    </div>{{-- fin .row --}}
                </div>
            </div>

            {{-- ================================================
                 SECCIÓN 2: ESTUDIANTE
            ================================================ --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="icon-box" style="background:linear-gradient(135deg,#00508f 0%,#003b73 100%);">
                            <i class="fas fa-user-graduate" style="color:white; font-size:.9rem;"></i>
                        </div>
                        <h6 class="mb-0 fw-bold section-title">Información del Estudiante</h6>
                    </div>

                    <div class="row g-3">

                        {{-- Nombre estudiante --}}
                        <div class="col-md-6">
                            <label for="estudiante_nombre" class="form-label">
                                Nombre <span class="required-mark">*</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text"
                                       class="form-control @error('estudiante_nombre') is-invalid @enderror"
                                       id="estudiante_nombre" name="estudiante_nombre"
                                       value="{{ old('estudiante_nombre') }}"
                                       placeholder="Ej: María José" required>
                                @error('estudiante_nombre')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Apellido estudiante --}}
                        <div class="col-md-6">
                            <label for="estudiante_apellido" class="form-label">
                                Apellido <span class="required-mark">*</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text"
                                       class="form-control @error('estudiante_apellido') is-invalid @enderror"
                                       id="estudiante_apellido" name="estudiante_apellido"
                                       value="{{ old('estudiante_apellido') }}"
                                       placeholder="Ej: López Martínez" required>
                                @error('estudiante_apellido')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- DNI Estudiante --}}
                        <div class="col-md-6">
                            <label for="estudiante_dni" class="form-label">
                                DNI <span class="required-mark">*</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-id-card input-icon"></i>
                                <input type="text"
                                       class="form-control @error('estudiante_dni') is-invalid @enderror"
                                       id="estudiante_dni" name="estudiante_dni"
                                       value="{{ old('estudiante_dni') }}"
                                       placeholder="0801201012345"
                                       maxlength="13"
                                       pattern="[0-9]{13}"
                                       inputmode="numeric"
                                       required>
                                @error('estudiante_dni')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <small class="text-muted" style="font-size:.75rem;">
                                <i class="fas fa-info-circle me-1"></i>13 dígitos
                            </small>
                        </div>

                        {{-- Fecha de nacimiento --}}
                        <div class="col-md-6">
                            <label for="estudiante_fecha_nacimiento" class="form-label">
                                Fecha de Nacimiento <span class="required-mark">*</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-calendar input-icon"></i>
                                <input type="date"
                                       class="form-control @error('estudiante_fecha_nacimiento') is-invalid @enderror"
                                       id="estudiante_fecha_nacimiento"
                                       name="estudiante_fecha_nacimiento"
                                       value="{{ old('estudiante_fecha_nacimiento') }}"
                                       max="{{ date('Y-m-d') }}"
                                       required>
                                @error('estudiante_fecha_nacimiento')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Sexo --}}
                        <div class="col-md-6">
                            <label for="estudiante_sexo" class="form-label">
                                Sexo <span class="required-mark">*</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-venus-mars input-icon" style="z-index:10;"></i>
                                <select class="form-select @error('estudiante_sexo') is-invalid @enderror"
                                        id="estudiante_sexo" name="estudiante_sexo" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="masculino" {{ old('estudiante_sexo') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                    <option value="femenino"  {{ old('estudiante_sexo') == 'femenino'  ? 'selected' : '' }}>Femenino</option>
                                </select>
                                @error('estudiante_sexo')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Grado --}}
                        <div class="col-md-6">
                            <label for="estudiante_grado" class="form-label">
                                Grado <span class="required-mark">*</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-graduation-cap input-icon" style="z-index:10;"></i>
                                <select class="form-select @error('estudiante_grado') is-invalid @enderror"
                                        id="estudiante_grado" name="estudiante_grado" required>
                                    <option value="">Seleccionar...</option>
                                    @foreach([
                                        'Primer Grado','Segundo Grado','Tercer Grado',
                                        'Cuarto Grado','Quinto Grado','Sexto Grado',
                                        'Séptimo Grado','Octavo Grado','Noveno Grado'
                                    ] as $grado)
                                        <option value="{{ $grado }}"
                                            {{ old('estudiante_grado') == $grado ? 'selected' : '' }}>
                                            {{ $grado }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('estudiante_grado')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <small class="text-muted" style="font-size:.75rem;">
                                <i class="fas fa-info-circle me-1"></i>La sección será asignada por el administrador
                            </small>
                        </div>

                    </div>{{-- fin .row --}}
                </div>
            </div>

            {{-- ================================================
                 SECCIÓN 3: DATOS DE MATRÍCULA
            ================================================ --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="icon-box" style="background:linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);">
                            <i class="fas fa-clipboard-list" style="color:white; font-size:.9rem;"></i>
                        </div>
                        <h6 class="mb-0 fw-bold section-title">Datos de Matrícula</h6>
                    </div>

                    <div class="row g-3">

                        {{-- Año lectivo --}}
                        <div class="col-md-6">
                            <label for="anio_lectivo" class="form-label">
                                Año Lectivo <span class="required-mark">*</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-calendar-alt input-icon"></i>
                                <input type="number"
                                       class="form-control @error('anio_lectivo') is-invalid @enderror"
                                       id="anio_lectivo" name="anio_lectivo"
                                       value="{{ old('anio_lectivo', date('Y')) }}"
                                       placeholder="{{ date('Y') }}"
                                       min="2020" max="2099"
                                       required>
                                @error('anio_lectivo')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Fecha automática --}}
                        <div class="col-md-6 d-flex align-items-center">
                            <div class="p-3 w-100"
                                 style="background:linear-gradient(135deg,rgba(78,199,210,.1) 0%,rgba(0,80,143,.05) 100%);
                                        border-radius:10px; border-left:4px solid #4ec7d2;">
                                <p class="small fw-semibold mb-1" style="color:#003b73;">
                                    <i class="fas fa-calendar-check me-2" style="color:#4ec7d2;"></i>
                                    Fecha de Matrícula
                                </p>
                                <p class="mb-0" style="color:#00508f; font-size:.9rem;">
                                    Se registrará automáticamente al enviar
                                </p>
                            </div>
                        </div>

                        {{-- Observaciones --}}
                        <div class="col-12">
                            <label for="observaciones" class="form-label">
                                Observaciones <span class="optional-mark">(Opcional)</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-comment-alt input-icon-top"></i>
                                <textarea class="form-control @error('observaciones') is-invalid @enderror"
                                          id="observaciones" name="observaciones"
                                          rows="3"
                                          placeholder="Notas adicionales sobre la matrícula">{{ old('observaciones') }}</textarea>
                                @error('observaciones')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ================================================
                 SECCIÓN 4: DOCUMENTOS
            ================================================ --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="icon-box" style="background:linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);">
                            <i class="fas fa-folder-open" style="color:white; font-size:.9rem;"></i>
                        </div>
                        <h6 class="mb-0 fw-bold section-title">Documentos Requeridos</h6>
                    </div>

                    <div class="mb-3 p-3"
                         style="background:linear-gradient(135deg,rgba(239,68,68,.1) 0%,rgba(220,38,38,.05) 100%);
                                border-radius:10px; border-left:4px solid #ef4444;">
                        <p class="small fw-semibold mb-0" style="color:#dc2626;">
                            <i class="fas fa-exclamation-triangle me-2" style="color:#ef4444;"></i>
                            Los 3 documentos son obligatorios para completar la matrícula
                        </p>
                    </div>

                    <div class="row g-3">

                        {{-- Foto de perfil --}}
                        <div class="col-md-4">
                            <div class="documento-item">
                                <label class="documento-label">
                                    <i class="fas fa-camera me-1" style="color:#4ec7d2;"></i>
                                    Foto del Estudiante <span class="required-mark">*</span>
                                </label>
                                <div class="file-upload-box"
                                     id="box_foto"
                                     onclick="document.getElementById('foto_perfil').click()"
                                     role="button"
                                     tabindex="0"
                                     aria-label="Subir foto del estudiante">
                                    <i class="fas fa-image"></i>
                                    <p>Subir foto</p>
                                    <small>JPG, PNG<br>(máx. 2MB)</small>
                                </div>
                                <input type="file"
                                       id="foto_perfil" name="foto_perfil"
                                       accept=".jpg,.jpeg,.png"
                                       style="display:none;"
                                       required>
                                @error('foto_perfil')
                                    <div class="invalid-feedback d-block">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                                <div id="preview_foto"></div>
                            </div>
                        </div>

                        {{-- Calificaciones --}}
                        <div class="col-md-4">
                            <div class="documento-item">
                                <label class="documento-label">
                                    <i class="fas fa-file-alt me-1" style="color:#4ec7d2;"></i>
                                    Calificaciones <span class="required-mark">*</span>
                                </label>
                                <div class="file-upload-box"
                                     id="box_calificaciones"
                                     onclick="document.getElementById('calificaciones').click()"
                                     role="button"
                                     tabindex="0"
                                     aria-label="Subir calificaciones">
                                    <i class="fas fa-file-pdf"></i>
                                    <p>Subir calificaciones</p>
                                    <small>PDF, JPG, PNG<br>(máx. 5MB)</small>
                                </div>
                                <input type="file"
                                       id="calificaciones" name="calificaciones"
                                       accept=".pdf,.jpg,.jpeg,.png"
                                       style="display:none;"
                                       required>
                                @error('calificaciones')
                                    <div class="invalid-feedback d-block">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                                <div id="preview_calificaciones"></div>
                            </div>
                        </div>

                        {{-- Acta de nacimiento --}}
                        <div class="col-md-4">
                            <div class="documento-item">
                                <label class="documento-label">
                                    <i class="fas fa-file-contract me-1" style="color:#4ec7d2;"></i>
                                    Acta de Nacimiento <span class="required-mark">*</span>
                                </label>
                                <div class="file-upload-box"
                                     id="box_acta"
                                     onclick="document.getElementById('acta_nacimiento').click()"
                                     role="button"
                                     tabindex="0"
                                     aria-label="Subir acta de nacimiento">
                                    <i class="fas fa-file-signature"></i>
                                    <p>Subir acta</p>
                                    <small>PDF, JPG, PNG<br>(máx. 5MB)</small>
                                </div>
                                <input type="file"
                                       id="acta_nacimiento" name="acta_nacimiento"
                                       accept=".pdf,.jpg,.jpeg,.png"
                                       style="display:none;"
                                       required>
                                @error('acta_nacimiento')
                                    <div class="invalid-feedback d-block">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                                <div id="preview_acta"></div>
                            </div>
                        </div>

                    </div>{{-- fin .row documentos --}}
                </div>
            </div>

            {{-- ================================================
                 BOTONES
            ================================================ --}}
            <div class="d-flex gap-3 justify-content-center flex-wrap mt-4">
                <button type="submit" class="btn-submit" id="btnEnviar">
                    <i class="fas fa-paper-plane"></i>
                    <span>Enviar Solicitud de Matrícula</span>
                </button>
                <a href="{{ route('plantilla') }}" class="btn-cancel">
                    <i class="fas fa-times"></i>
                    <span>Cancelar</span>
                </a>
            </div>

        </form>
    </div>{{-- fin .form-container --}}
</div>{{-- fin .container --}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
(function () {
    'use strict';

    /* ============================================================
       Marcar campos rellenados con fondo azul
    ============================================================ */
    function marcarCampo(el) {
        const tieneValor = el.tagName === 'SELECT'
            ? el.value !== ''
            : el.value.trim() !== '';
        el.classList.toggle('campo-rellenado', tieneValor);
    }

    function inicializarMarcadoCampos() {
        document.querySelectorAll('#formMatricula .form-control, #formMatricula .form-select')
            .forEach(function (campo) {
                campo.addEventListener('input',  function () { marcarCampo(this); });
                campo.addEventListener('change', function () { marcarCampo(this); });
                campo.addEventListener('blur',   function () { marcarCampo(this); });
                marcarCampo(campo); // marcar los ya rellenados por old()
            });
    }

    /* ============================================================
       Mostrar / ocultar campo "otro parentesco"
    ============================================================ */
    function toggleOtroParentesco() {
        const select  = document.getElementById('padre_parentesco');
        const otroDiv = document.getElementById('otro_parentesco_div');
        const otroInput = document.getElementById('padre_parentesco_otro');
        if (!select || !otroDiv || !otroInput) return;

        const esOtro = select.value === 'otro';
        otroDiv.style.display = esOtro ? 'block' : 'none';
        otroInput.required = esOtro;
        if (!esOtro) otroInput.value = '';
    }

    /* ============================================================
       Archivos: mostrar preview y marcar caja

       CORRECCIÓN: la función limpiarArchivo usaba `box` como
       variable no declarada. Ahora recibe el boxId correctamente.
    ============================================================ */
    function mostrarArchivo(inputEl, previewId, boxId) {
        const preview = document.getElementById(previewId);
        const box     = document.getElementById(boxId);
        if (!preview) return;

        preview.innerHTML = '';
        if (!inputEl.files || !inputEl.files[0]) {
            if (box) box.classList.remove('archivo-subido');
            return;
        }

        const file    = inputEl.files[0];
        const maxSize = inputEl.id === 'foto_perfil' ? 2 * 1024 * 1024 : 5 * 1024 * 1024;

        if (file.size > maxSize) {
            const mb = inputEl.id === 'foto_perfil' ? 2 : 5;
            alert(`El archivo "${file.name}" supera el tamaño máximo permitido (${mb} MB).`);
            inputEl.value = '';
            if (box) box.classList.remove('archivo-subido');
            return;
        }

        if (box) box.classList.add('archivo-subido');

        let icono = 'fa-file';
        if (file.type.includes('pdf'))   icono = 'fa-file-pdf';
        else if (file.type.includes('image')) icono = 'fa-file-image';

        const filePreview = document.createElement('div');
        filePreview.className = 'file-preview';
        filePreview.innerHTML = `
            <div style="display:flex; align-items:center; gap:6px; overflow:hidden; flex:1; min-width:0;">
                <i class="fas ${icono}" style="color:#4ec7d2; font-size:.9rem; flex-shrink:0;"></i>
                <span class="file-name">${file.name}</span>
            </div>
            <button type="button"
                    class="btn-clear ms-2"
                    data-input-id="${inputEl.id}"
                    data-preview-id="${previewId}"
                    data-box-id="${boxId}">
                <i class="fas fa-times me-1"></i>Quitar
            </button>`;
        preview.appendChild(filePreview);
    }

    /* ============================================================
       CORRECCIÓN: limpiarArchivo — antes usaba `box` sin declarar.
       Ahora el botón lleva data-* y se delega el evento al documento.
    ============================================================ */
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-clear');
        if (!btn) return;

        const inputEl = document.getElementById(btn.dataset.inputId);
        const preview = document.getElementById(btn.dataset.previewId);
        const box     = document.getElementById(btn.dataset.boxId);

        if (inputEl) inputEl.value = '';
        if (preview) preview.innerHTML = '';
        if (box)     box.classList.remove('archivo-subido');
    });

    /* ============================================================
       Enlazar inputs de archivo a sus cajas (sin onchange inline)
    ============================================================ */
    function enlazarInputsArchivo() {
        const archivos = [
            { inputId: 'foto_perfil',   previewId: 'preview_foto',           boxId: 'box_foto' },
            { inputId: 'calificaciones', previewId: 'preview_calificaciones', boxId: 'box_calificaciones' },
            { inputId: 'acta_nacimiento', previewId: 'preview_acta',         boxId: 'box_acta' },
        ];

        archivos.forEach(function (cfg) {
            const input = document.getElementById(cfg.inputId);
            if (input) {
                input.addEventListener('change', function () {
                    mostrarArchivo(this, cfg.previewId, cfg.boxId);
                });
            }
        });
    }

    /* ============================================================
       Accesibilidad: activar caja de upload con Enter / Space
    ============================================================ */
    document.querySelectorAll('.file-upload-box[tabindex]').forEach(function (box) {
        box.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                box.click();
            }
        });
    });

    /* ============================================================
       Prevenir doble envío del formulario
    ============================================================ */
    document.getElementById('formMatricula').addEventListener('submit', function () {
        const btn = document.getElementById('btnEnviar');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Enviando...';
        }
    });

    /* ============================================================
       Inicialización
    ============================================================ */
    document.addEventListener('DOMContentLoaded', function () {
        toggleOtroParentesco();
        inicializarMarcadoCampos();
        enlazarInputsArchivo();

        // Restaurar parentesco "otro" si viene de old()
        const selectParentesco = document.getElementById('padre_parentesco');
        if (selectParentesco) {
            selectParentesco.addEventListener('change', toggleOtroParentesco);
        }
    });

})();
</script>
</body>
</html>
