{{-- resources/views/matriculas/create-public.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Matrícula en Línea – Escuela Gabriela Mistral</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #003b73 0%, #00508f 40%, #07196b 100%);
            min-height: 100vh;
            padding: 40px 15px 60px;
        }
        body::before {
            content: '';
            position: fixed; inset: 0; pointer-events: none; z-index: 0;
            background-image:
                radial-gradient(circle at 15% 80%, rgba(78,199,210,.12) 0%, transparent 50%),
                radial-gradient(circle at 85% 20%, rgba(78,199,210,.10) 0%, transparent 50%);
            animation: bgPulse 10s ease-in-out infinite;
        }
        @keyframes bgPulse { 0%,100%{opacity:1} 50%{opacity:.6} }

        .form-wrapper { max-width: 900px; margin: 0 auto; position: relative; z-index: 1; }

        /* ── Header ── */
        .form-header { text-align: center; color: white; margin-bottom: 36px; }
        .form-header .logo-icon {
            width: 80px; height: 80px;
            background: rgba(78,199,210,.25); border: 2px solid #4ec7d2;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 2.2rem; color: #4ec7d2; margin: 0 auto 18px;
        }
        .form-header h1 { font-size: 2rem; font-weight: 800; }
        .form-header p  { color: #bfd9ea; font-size: 1rem; margin-top: 6px; }

        /* ── Steps ── */
        .steps-bar { display: flex; justify-content: center; align-items: center; margin-bottom: 36px; }
        .step { display: flex; flex-direction: column; align-items: center; }
        .step-circle {
            width: 44px; height: 44px; border-radius: 50%;
            background: rgba(255,255,255,.15); border: 2px solid rgba(255,255,255,.3);
            color: rgba(255,255,255,.5);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: .95rem; transition: all .3s;
        }
        .step.active .step-circle { background: #4ec7d2; border-color: #4ec7d2; color: #003b73; }
        .step.done   .step-circle { background: #003b73; border-color: #4ec7d2; color: #4ec7d2; }
        .step-label  { font-size: .72rem; color: rgba(255,255,255,.5); margin-top: 6px; text-align: center; max-width: 80px; }
        .step.active .step-label, .step.done .step-label { color: #4ec7d2; }
        .step-line   { width: 70px; height: 2px; background: rgba(255,255,255,.15); margin-bottom: 22px; transition: background .3s; }
        .step-line.done { background: #4ec7d2; }

        /* ── Card ── */
        .card-form { background: white; border-radius: 24px; overflow: hidden; box-shadow: 0 25px 70px rgba(0,0,0,.25); }

        /* ── Secciones wizard ── */
        .form-section { display: none; padding: 40px 50px; animation: fadeSlide .4s ease; }
        .form-section.active { display: block; }
        @keyframes fadeSlide { from{opacity:0;transform:translateX(20px)} to{opacity:1;transform:translateX(0)} }

        .section-title    { font-size: 1.3rem; font-weight: 700; color: #003b73; margin-bottom: 6px; }
        .section-subtitle { color: #6c757d; font-size: .9rem; margin-bottom: 28px; }
        .section-divider  { height: 4px; width: 60px; background: linear-gradient(90deg,#4ec7d2,#00508f); border-radius: 4px; margin-bottom: 20px; }

        /* ── Campos ── */
        .form-label { font-weight: 600; color: #003b73; font-size: .875rem; margin-bottom: 5px; }
        .form-control, .form-select {
            border: 1.5px solid #dee2e6; border-radius: 10px;
            padding: 10px 14px; font-size: .925rem;
            transition: border-color .25s, box-shadow .25s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #4ec7d2; box-shadow: 0 0 0 3px rgba(78,199,210,.2); outline: none;
        }
        .form-control.is-invalid, .form-select.is-invalid { border-color: #dc3545; }
        .required-star { color: #dc3545; margin-left: 2px; }

        /* ── Upload ── */
        .upload-zone {
            border: 2px dashed #c8d8e8; border-radius: 12px; padding: 22px;
            text-align: center; cursor: pointer; transition: all .3s; background: #f8fbff;
        }
        .upload-zone:hover { border-color: #4ec7d2; background: rgba(78,199,210,.05); }
        .upload-zone i { font-size: 1.8rem; color: #4ec7d2; display: block; margin-bottom: 8px; }
        .upload-zone p { color: #6c757d; font-size: .82rem; margin: 0; }
        .upload-zone input[type="file"] { display: none; }
        .file-chosen { font-size: .8rem; color: #003b73; margin-top: 8px; font-weight: 600; min-height: 18px; }

        /* ── Botones nav ── */
        .btn-nav { padding: 12px 32px; border-radius: 30px; font-weight: 600; font-size: .95rem; border: none; cursor: pointer; transition: all .3s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-prev { background: #f1f3f5; color: #495057; }
        .btn-prev:hover { background: #e2e6ea; }
        .btn-next { background: linear-gradient(135deg,#4ec7d2,#00508f); color: white; }
        .btn-next:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(78,199,210,.4); }
        .btn-submit {
            background: linear-gradient(135deg,#003b73,#00508f); color: white;
            padding: 14px 48px; border-radius: 50px; font-weight: 700; font-size: 1rem;
            border: none; cursor: pointer; transition: all .3s;
            box-shadow: 0 8px 25px rgba(0,59,115,.3); display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-submit:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(78,199,210,.4); background: linear-gradient(135deg,#4ec7d2,#003b73); }

        /* ── Nav bar inferior ── */
        .form-nav {
            display: flex; justify-content: space-between; align-items: center;
            padding: 24px 50px; border-top: 1px solid #f0f0f0; background: #fafbfc;
        }

        /* ── Resumen paso 4 ── */
        .summary-block { background: #f8fbff; border-radius: 14px; border: 1.5px solid #e3eef7; padding: 22px 28px; margin-bottom: 20px; }
        .summary-block h6 { color: #4ec7d2; font-weight: 700; font-size: .78rem; letter-spacing: .08em; text-transform: uppercase; margin-bottom: 14px; }
        .summary-row { display: flex; gap: 8px; margin-bottom: 8px; font-size: .875rem; flex-wrap: wrap; }
        .summary-row .lbl { color: #6c757d; min-width: 170px; }
        .summary-row .val { color: #003b73; font-weight: 600; }

        .alert-form { border-radius: 12px; border: none; padding: 14px 18px; font-size: .875rem; }

        @media(max-width:600px){
            .form-section { padding: 26px 18px; }
            .form-nav { padding: 16px 18px; }
            .step-line { width: 28px; }
            .form-header h1 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>
<div class="form-wrapper">

    {{-- Encabezado --}}
    <div class="form-header">
        <div class="logo-icon"><i class="fas fa-graduation-cap"></i></div>
        <h1>Matrícula en Línea {{ date('Y') }}</h1>
        <p>Centro de Educación Básico Gabriela Mistral · Danlí, El Paraíso</p>
    </div>

    {{-- Barra de pasos --}}
    <div class="steps-bar">
        <div class="step active" id="step-ind-1">
            <div class="step-circle">1</div>
            <div class="step-label">Estudiante</div>
        </div>
        <div class="step-line" id="line-1"></div>
        <div class="step" id="step-ind-2">
            <div class="step-circle">2</div>
            <div class="step-label">Padre / Tutor</div>
        </div>
        <div class="step-line" id="line-2"></div>
        <div class="step" id="step-ind-3">
            <div class="step-circle">3</div>
            <div class="step-label">Documentos</div>
        </div>
        <div class="step-line" id="line-3"></div>
        <div class="step" id="step-ind-4">
            <div class="step-circle">4</div>
            <div class="step-label">Confirmar</div>
        </div>
    </div>

    <div class="card-form">

        {{-- Errores del servidor --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-form m-4 mb-0">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong>Corrige los siguientes errores:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{--
            ╔══════════════════════════════════════════════════════════════╗
            ║  Apunta al store() del MatriculaController existente.        ║
            ║  El campo "publico=1" activa la rama pública del store().    ║
            ║  El store() usa explode(' ', estudiante_nombre, 2) para      ║
            ║  separar nombre1 y nombre2 — por eso usamos campos hidden    ║
            ║  que combinamos con JS justo antes de enviar.                ║
            ╚══════════════════════════════════════════════════════════════╝
        --}}
        <form action="{{ route('matriculas.store') }}"
              method="POST"
              enctype="multipart/form-data"
              id="matriculaForm"
              novalidate>
            @csrf

            {{-- Flags requeridos por el store() --}}
            <input type="hidden" name="publico"      value="1">
            <input type="hidden" name="anio_lectivo" value="{{ date('Y') }}">
            <input type="hidden" name="estado"       value="pendiente">

            {{-- Campos que el store() recibe y separa internamente con explode() --}}
            <input type="hidden" name="estudiante_nombre"   id="campo_est_nombre">
            <input type="hidden" name="estudiante_apellido" id="campo_est_apellido">


            {{-- ════════════════════════════════
                 PASO 1 — Datos del Estudiante
            ═════════════════════════════════ --}}
            <div class="form-section active" id="section-1">
                <div class="section-title">
                    <i class="fas fa-user-graduate me-2" style="color:#4ec7d2"></i>Datos del Estudiante
                </div>
                <div class="section-divider"></div>
                <p class="section-subtitle">Información personal del alumno a matricular.</p>

                <div class="row g-3">

                    {{-- Campos UI — se concatenan al campo hidden al enviar --}}
                    <div class="col-md-6">
                        <label class="form-label">
                            Primer Nombre <span class="required-star">*</span>
                        </label>
                        <input type="text" id="ui_nombre1"
                               class="form-control @error('estudiante_nombre') is-invalid @enderror"
                               placeholder="Ej: María" required>
                        @error('estudiante_nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Segundo Nombre</label>
                        <input type="text" id="ui_nombre2" class="form-control" placeholder="Opcional">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            Primer Apellido <span class="required-star">*</span>
                        </label>
                        <input type="text" id="ui_apellido1"
                               class="form-control @error('estudiante_apellido') is-invalid @enderror"
                               placeholder="Ej: López" required>
                        @error('estudiante_apellido')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Segundo Apellido</label>
                        <input type="text" id="ui_apellido2" class="form-control" placeholder="Opcional">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">
                            DNI (Identidad) <span class="required-star">*</span>
                        </label>
                        <input type="text" name="estudiante_dni"
                               class="form-control @error('estudiante_dni') is-invalid @enderror"
                               value="{{ old('estudiante_dni') }}"
                               placeholder="0000-0000-00000" maxlength="13" required>
                        @error('estudiante_dni')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">
                            Fecha de Nacimiento <span class="required-star">*</span>
                        </label>
                        <input type="date" name="estudiante_fecha_nacimiento"
                               class="form-control @error('estudiante_fecha_nacimiento') is-invalid @enderror"
                               value="{{ old('estudiante_fecha_nacimiento') }}" required>
                        @error('estudiante_fecha_nacimiento')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Sexo <span class="required-star">*</span></label>
                        <select name="estudiante_sexo"
                                class="form-select @error('estudiante_sexo') is-invalid @enderror" required>
                            <option value="">Seleccionar...</option>
                            <option value="masculino" {{ old('estudiante_sexo')=='masculino'?'selected':'' }}>Masculino</option>
                            <option value="femenino"  {{ old('estudiante_sexo')=='femenino' ?'selected':'' }}>Femenino</option>
                        </select>
                        @error('estudiante_sexo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">
                            Grado que Solicita <span class="required-star">*</span>
                        </label>
                        {{-- Mismos valores que usa MatriculaController::GRADOS --}}
                        <select name="estudiante_grado"
                                class="form-select @error('estudiante_grado') is-invalid @enderror" required>
                            <option value="">Seleccionar grado...</option>
                            @foreach(['Primero','Segundo','Tercero','Cuarto','Quinto','Sexto','I curso','II curso','III curso'] as $g)
                                <option value="{{ $g }}" {{ old('estudiante_grado')==$g?'selected':'' }}>
                                    {{ $g }}
                                </option>
                            @endforeach
                        </select>
                        @error('estudiante_grado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Teléfono del Estudiante</label>
                        <input type="text" name="estudiante_telefono"
                               class="form-control @error('estudiante_telefono') is-invalid @enderror"
                               value="{{ old('estudiante_telefono') }}" placeholder="+504 9999-9999">
                        @error('estudiante_telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Correo del Estudiante</label>
                        <input type="email" name="estudiante_email"
                               class="form-control @error('estudiante_email') is-invalid @enderror"
                               value="{{ old('estudiante_email') }}" placeholder="correo@ejemplo.com">
                        @error('estudiante_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Dirección del Estudiante</label>
                        <input type="text" name="estudiante_direccion"
                               class="form-control @error('estudiante_direccion') is-invalid @enderror"
                               value="{{ old('estudiante_direccion') }}"
                               placeholder="Barrio, Colonia, Municipio...">
                        @error('estudiante_direccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>{{-- /section-1 --}}


            {{-- ════════════════════════════════
                 PASO 2 — Datos del Padre/Tutor
            ═════════════════════════════════ --}}
            <div class="form-section" id="section-2">
                <div class="section-title">
                    <i class="fas fa-users me-2" style="color:#4ec7d2"></i>Datos del Padre / Tutor
                </div>
                <div class="section-divider"></div>
                <p class="section-subtitle">Información del responsable legal del estudiante.</p>

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">
                            Nombre(s) <span class="required-star">*</span>
                        </label>
                        <input type="text" name="padre_nombre"
                               class="form-control @error('padre_nombre') is-invalid @enderror"
                               value="{{ old('padre_nombre') }}" placeholder="Nombre" required>
                        @error('padre_nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            Apellido(s) <span class="required-star">*</span>
                        </label>
                        <input type="text" name="padre_apellido"
                               class="form-control @error('padre_apellido') is-invalid @enderror"
                               value="{{ old('padre_apellido') }}" placeholder="Apellido" required>
                        @error('padre_apellido')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">
                            DNI del Tutor <span class="required-star">*</span>
                        </label>
                        <input type="text" name="padre_dni"
                               class="form-control @error('padre_dni') is-invalid @enderror"
                               value="{{ old('padre_dni') }}"
                               placeholder="0000-0000-00000" maxlength="13" required>
                        @error('padre_dni')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{--
                        store() valida padre_parentesco in:padre,madre,otro
                        Solo esos 3 valores son aceptados.
                    --}}
                    <div class="col-md-4">
                        <label class="form-label">
                            Parentesco <span class="required-star">*</span>
                        </label>
                        <select name="padre_parentesco"
                                class="form-select @error('padre_parentesco') is-invalid @enderror"
                                id="parentescoSelect" required>
                            <option value="">Seleccionar...</option>
                            <option value="padre" {{ old('padre_parentesco')=='padre'?'selected':'' }}>Padre</option>
                            <option value="madre" {{ old('padre_parentesco')=='madre'?'selected':'' }}>Madre</option>
                            <option value="otro"  {{ old('padre_parentesco')=='otro' ?'selected':'' }}>Otro (abuelo, tío, tutor…)</option>
                        </select>
                        @error('padre_parentesco')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4" id="wrap-parentesco-otro"
                         style="{{ old('padre_parentesco')=='otro' ? '' : 'display:none' }}">
                        <label class="form-label">Especificar parentesco</label>
                        <input type="text" name="padre_parentesco_otro"
                               class="form-control @error('padre_parentesco_otro') is-invalid @enderror"
                               value="{{ old('padre_parentesco_otro') }}"
                               placeholder="Ej: Abuelo, Tío...">
                        @error('padre_parentesco_otro')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            Teléfono Principal <span class="required-star">*</span>
                        </label>
                        <input type="text" name="padre_telefono"
                               class="form-control @error('padre_telefono') is-invalid @enderror"
                               value="{{ old('padre_telefono') }}"
                               placeholder="+504 9999-9999" required>
                        @error('padre_telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{--
                        padre_email es OPCIONAL.
                        Si se provee → store() crea usuario padre con activo=0.
                        Al aprobar la matrícula → procesarAprobacion() activa el usuario.
                        Contraseña inicial = DNI del padre.
                    --}}
                    <div class="col-md-6">
                        <label class="form-label">
                            Correo Electrónico
                            <small class="text-muted fw-normal">(recomendado para notificaciones)</small>
                        </label>
                        <input type="email" name="padre_email"
                               class="form-control @error('padre_email') is-invalid @enderror"
                               value="{{ old('padre_email') }}" placeholder="correo@ejemplo.com">
                        @error('padre_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">
                            Dirección <span class="required-star">*</span>
                        </label>
                        <input type="text" name="padre_direccion"
                               class="form-control @error('padre_direccion') is-invalid @enderror"
                               value="{{ old('padre_direccion') }}"
                               placeholder="Barrio, Colonia, Municipio..." required>
                        @error('padre_direccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>{{-- /section-2 --}}


            {{-- ════════════════════════════════
                 PASO 3 — Documentos
                 store() acepta: foto_perfil, acta_nacimiento, calificaciones
            ═════════════════════════════════ --}}
            <div class="form-section" id="section-3">
                <div class="section-title">
                    <i class="fas fa-file-upload me-2" style="color:#4ec7d2"></i>Documentos
                </div>
                <div class="section-divider"></div>
                <p class="section-subtitle">
                    Todos opcionales en línea. Podrás presentar originales en tu cita presencial.
                </p>

                <div class="row g-4">

                    <div class="col-md-4">
                        <label class="form-label">Foto del Estudiante</label>
                        <div class="upload-zone" onclick="document.getElementById('foto_perfil').click()">
                            <i class="fas fa-camera"></i>
                            <p>Clic para subir foto<br><small>JPG, PNG – máx. 2 MB</small></p>
                            <input type="file" id="foto_perfil" name="foto_perfil"
                                   accept="image/jpg,image/jpeg,image/png"
                                   onchange="mostrarArchivo(this,'lbl_foto')">
                            <div class="file-chosen" id="lbl_foto"></div>
                        </div>
                        @error('foto_perfil')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Acta de Nacimiento</label>
                        <div class="upload-zone" onclick="document.getElementById('acta_nacimiento').click()">
                            <i class="fas fa-file-alt"></i>
                            <p>Clic para subir acta<br><small>PDF, JPG, PNG – máx. 5 MB</small></p>
                            <input type="file" id="acta_nacimiento" name="acta_nacimiento"
                                   accept=".pdf,image/*"
                                   onchange="mostrarArchivo(this,'lbl_acta')">
                            <div class="file-chosen" id="lbl_acta"></div>
                        </div>
                        @error('acta_nacimiento')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Certificado / Calificaciones Previas</label>
                        <div class="upload-zone" onclick="document.getElementById('calificaciones').click()">
                            <i class="fas fa-certificate"></i>
                            <p>Clic para subir certificado<br><small>PDF, JPG, PNG – máx. 5 MB</small></p>
                            <input type="file" id="calificaciones" name="calificaciones"
                                   accept=".pdf,image/*"
                                   onchange="mostrarArchivo(this,'lbl_cert')">
                            <div class="file-chosen" id="lbl_cert"></div>
                        </div>
                        @error('calificaciones')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="alert alert-info alert-form mt-4">
                    <i class="fas fa-info-circle me-2"></i>
                    Si proporcionas tu correo, recibirás una notificación cuando la solicitud sea revisada.
                    Si es aprobada, podrás acceder al portal con tu DNI como contraseña inicial.
                </div>
            </div>{{-- /section-3 --}}


            {{-- ════════════════════════════════
                 PASO 4 — Resumen y confirmación
            ═════════════════════════════════ --}}
            <div class="form-section" id="section-4">
                <div class="section-title">
                    <i class="fas fa-check-circle me-2" style="color:#4ec7d2"></i>Confirma tu Solicitud
                </div>
                <div class="section-divider"></div>
                <p class="section-subtitle">Revisa que todo esté correcto antes de enviar.</p>

                <div class="summary-block">
                    <h6><i class="fas fa-user-graduate me-1"></i> Estudiante</h6>
                    <div id="resumen-estudiante"></div>
                </div>

                <div class="summary-block">
                    <h6><i class="fas fa-users me-1"></i> Padre / Tutor</h6>
                    <div id="resumen-padre"></div>
                </div>

                <div class="summary-block">
                    <h6><i class="fas fa-paperclip me-1"></i> Documentos Adjuntos</h6>
                    <div id="resumen-docs"></div>
                </div>

                <div class="alert alert-warning alert-form">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Al enviar, un administrador revisará tu solicitud y te contactará para continuar el proceso.
                </div>
            </div>{{-- /section-4 --}}


            {{-- Navegación del wizard --}}
            <div class="form-nav">
                <button type="button" class="btn-nav btn-prev" id="btnPrev"
                        onclick="cambiarPaso(-1)" style="visibility:hidden">
                    <i class="fas fa-arrow-left"></i> Anterior
                </button>

                <span style="font-size:.8rem;color:#adb5bd" id="contador-paso">Paso 1 de 4</span>

                <div>
                    <button type="button" class="btn-nav btn-next" id="btnNext" onclick="cambiarPaso(1)">
                        Siguiente <i class="fas fa-arrow-right"></i>
                    </button>
                    <button type="submit" class="btn-submit" id="btnSubmit"
                            style="display:none" onclick="combinarNombres()">
                        <i class="fas fa-paper-plane"></i> Enviar Solicitud
                    </button>
                </div>
            </div>

        </form>
    </div>{{-- /card-form --}}

    <p class="text-center mt-4" style="color:rgba(255,255,255,.6);font-size:.82rem">
        ¿Ya enviaste tu solicitud?
        <a href="{{ route('matriculas.index') }}" style="color:#4ec7d2;font-weight:600">
            Consultar estado aquí
        </a>
    </p>

</div>{{-- /form-wrapper --}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ── Wizard: estado ──────────────────────────────────────────────────────────
let pasoActual = 1;
const TOTAL    = 4;

function cambiarPaso(dir) {
    if (dir === 1 && !validarPaso(pasoActual)) return;

    // Quitar active del paso actual
    document.getElementById('section-'  + pasoActual).classList.remove('active');
    document.getElementById('step-ind-' + pasoActual).classList.remove('active');

    if (dir === 1) {
        // Marcar como completado al avanzar
        document.getElementById('step-ind-' + pasoActual).classList.add('done');
    } else {
        // Al retroceder, quitar "done" del paso al que volvemos
        document.getElementById('step-ind-' + pasoActual).classList.remove('done');
    }

    pasoActual += dir;

    document.getElementById('section-'  + pasoActual).classList.add('active');
    document.getElementById('step-ind-' + pasoActual).classList.add('active');

    // Actualizar líneas
    for (let i = 1; i < TOTAL; i++) {
        const ln = document.getElementById('line-' + i);
        if (ln) ln.classList.toggle('done', i < pasoActual);
    }

    // Botones
    document.getElementById('btnPrev').style.visibility = pasoActual > 1 ? 'visible' : 'hidden';
    document.getElementById('btnNext').style.display    = pasoActual < TOTAL ? 'inline-flex' : 'none';
    document.getElementById('btnSubmit').style.display  = pasoActual === TOTAL ? 'inline-flex' : 'none';
    document.getElementById('contador-paso').textContent = `Paso ${pasoActual} de ${TOTAL}`;

    if (pasoActual === 4) construirResumen();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// ── Validación cliente por paso ─────────────────────────────────────────────
function validarPaso(paso) {
    const sec    = document.getElementById('section-' + paso);
    const campos = sec.querySelectorAll('[required]');
    let ok = true;

    campos.forEach(c => {
        c.classList.remove('is-invalid');
        if (!c.value.trim()) {
            c.classList.add('is-invalid');
            ok = false;
        }
    });

    if (!ok) sec.querySelector('.is-invalid')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
    return ok;
}

// ── Mostrar/ocultar campo "otro parentesco" ─────────────────────────────────
document.getElementById('parentescoSelect').addEventListener('change', function () {
    document.getElementById('wrap-parentesco-otro').style.display =
        this.value === 'otro' ? '' : 'none';
});

// ── Mostrar nombre del archivo ──────────────────────────────────────────────
function mostrarArchivo(input, labelId) {
    document.getElementById(labelId).textContent =
        input.files.length ? '✔ ' + input.files[0].name : '';
}

// ── Combinar campos UI → hidden antes de enviar ─────────────────────────────
// El store() hace: explode(' ', estudiante_nombre, 2) → nombre1 / nombre2
//                  explode(' ', estudiante_apellido, 2) → apellido1 / apellido2
function combinarNombres() {
    const n1 = (document.getElementById('ui_nombre1').value   || '').trim();
    const n2 = (document.getElementById('ui_nombre2').value   || '').trim();
    const a1 = (document.getElementById('ui_apellido1').value || '').trim();
    const a2 = (document.getElementById('ui_apellido2').value || '').trim();

    document.getElementById('campo_est_nombre').value   = n2 ? `${n1} ${n2}` : n1;
    document.getElementById('campo_est_apellido').value = a2 ? `${a1} ${a2}` : a1;
}

// ── Helpers para resumen ────────────────────────────────────────────────────
function leer(name) {
    const el = document.querySelector(`[name="${name}"]`);
    if (!el) return '—';
    if (el.tagName === 'SELECT') return el.options[el.selectedIndex]?.text || '—';
    return el.value.trim() || '—';
}
function fila(lbl, val) {
    if (!val || val === '—') return '';
    return `<div class="summary-row"><span class="lbl">${lbl}</span><span class="val">${val}</span></div>`;
}

// ── Construir resumen en paso 4 ─────────────────────────────────────────────
function construirResumen() {
    const n1 = document.getElementById('ui_nombre1').value.trim();
    const n2 = document.getElementById('ui_nombre2').value.trim();
    const a1 = document.getElementById('ui_apellido1').value.trim();
    const a2 = document.getElementById('ui_apellido2').value.trim();

    document.getElementById('resumen-estudiante').innerHTML =
        fila('Nombre completo',   [n1,n2,a1,a2].filter(Boolean).join(' ')) +
        fila('DNI',               leer('estudiante_dni')) +
        fila('Fecha nacimiento',  leer('estudiante_fecha_nacimiento')) +
        fila('Sexo',              leer('estudiante_sexo')) +
        fila('Grado solicitado',  leer('estudiante_grado')) +
        fila('Teléfono',          leer('estudiante_telefono')) +
        fila('Correo',            leer('estudiante_email')) +
        fila('Dirección',         leer('estudiante_direccion'));

    document.getElementById('resumen-padre').innerHTML =
        fila('Nombre completo', leer('padre_nombre') + ' ' + leer('padre_apellido')) +
        fila('DNI',             leer('padre_dni')) +
        fila('Parentesco',      leer('padre_parentesco')) +
        fila('Teléfono',        leer('padre_telefono')) +
        fila('Correo',          leer('padre_email')) +
        fila('Dirección',       leer('padre_direccion'));

    const docs = [];
    ['foto_perfil','acta_nacimiento','calificaciones'].forEach(id => {
        const el = document.getElementById(id);
        if (el?.files?.length) docs.push(el.files[0].name);
    });

    document.getElementById('resumen-docs').innerHTML = docs.length
        ? docs.map(d => `<div class="summary-row">
                            <i class="fas fa-paperclip me-2" style="color:#4ec7d2"></i>
                            <span class="val">${d}</span>
                         </div>`).join('')
        : '<div class="summary-row"><span class="lbl">Sin documentos adjuntos</span></div>';
}
</script>
</body>
</html>
