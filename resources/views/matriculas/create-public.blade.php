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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 15px;
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

        .form-wrapper { max-width: 900px; margin: 0 auto; position: relative; z-index: 1; width: 100%; }

        /* ── Card ── */
        .card-form {
            background: white; border-radius: 24px; overflow: hidden;
            box-shadow: 0 25px 70px rgba(0,0,0,.25);
            display: flex; flex-direction: row;
        }
        .card-main { flex: 1; min-width: 0; display: flex; flex-direction: column; }

        /* ── Sidebar derecho de pasos ── */
        .card-sidebar {
            width: 220px; flex-shrink: 0;
            background: linear-gradient(175deg, #002d5a 0%, #003b73 55%, #00508f 100%);
            padding: 36px 20px;
            display: flex; flex-direction: column; align-items: center;
            border-left: 1px solid rgba(78,199,210,.15);
        }
        .sidebar-logo {
            width: 58px; height: 58px;
            background: rgba(78,199,210,.2); border: 2px solid rgba(78,199,210,.6);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; color: #4ec7d2; margin-bottom: 10px;
        }
        .sidebar-title-main { color: white; font-size: 1rem; font-weight: 800; text-align: center; margin-bottom: 6px; line-height: 1.3; }
        .sidebar-heading { color: #4ec7d2; font-size: .7rem; font-weight: 600; text-align: center; margin-bottom: 3px; }
        .sidebar-sub { color: rgba(255,255,255,.45); font-size: .62rem; text-align: center; margin-bottom: 24px; line-height: 1.5; }
        .sidebar-divider { width: 40px; height: 2px; background: rgba(78,199,210,.4); border-radius: 2px; margin-bottom: 24px; }

        /* ── Pasos verticales ── */
        .vsteps { width: 100%; }
        .vstep-item { display: flex; align-items: center; gap: 12px; }
        .vstep-circle {
            width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0;
            background: rgba(255,255,255,.08); border: 2px solid rgba(255,255,255,.2);
            color: rgba(255,255,255,.35);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: .82rem; transition: all .3s;
        }
        .vstep-item.active .vstep-circle { background: #4ec7d2; border-color: #4ec7d2; color: #003b73; }
        .vstep-item.done   .vstep-circle { background: rgba(78,199,210,.15); border-color: #4ec7d2; color: #4ec7d2; }
        .vstep-label { font-size: .73rem; color: rgba(255,255,255,.35); font-weight: 600; transition: color .3s; line-height: 1.3; }
        .vstep-item.active .vstep-label,
        .vstep-item.done   .vstep-label { color: #4ec7d2; }
        .vstep-line { width: 2px; height: 28px; background: rgba(255,255,255,.1); margin: 5px 0 5px 17px; border-radius: 2px; transition: background .3s; }
        .vstep-line.done { background: #4ec7d2; }

        @media(max-width:720px){ .card-sidebar { display: none; } }

        /* ── Secciones wizard ── */
        .form-section { display: none; padding: 36px 40px; animation: fadeSlide .4s ease; flex: 1; }
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
            padding: 14px 38px; border-radius: 50px; font-weight: 700; font-size: 1rem;
            border: none; cursor: pointer; transition: all .3s;
            box-shadow: 0 8px 25px rgba(0,59,115,.3); display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-submit:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(78,199,210,.4); background: linear-gradient(135deg,#4ec7d2,#003b73); }

        /* ── Nav bar inferior ── */
        .form-nav {
            display: flex; justify-content: space-between; align-items: center;
            padding: 20px 40px; border-top: 1px solid #f0f0f0; background: #fafbfc;
            margin-top: auto;
        }

        /* ── Resumen paso 4 ── */
        .summary-block { background: #f8fbff; border-radius: 14px; border: 1.5px solid #e3eef7; padding: 18px 24px; margin-bottom: 16px; }
        .summary-block h6 { color: #4ec7d2; font-weight: 700; font-size: .78rem; letter-spacing: .08em; text-transform: uppercase; margin-bottom: 10px; }
        .summary-row { display: flex; gap: 8px; margin-bottom: 6px; font-size: .85rem; flex-wrap: wrap; }
        .summary-row .lbl { color: #6c757d; min-width: 150px; }
        .summary-row .val { color: #003b73; font-weight: 600; }

        .alert-form { border-radius: 12px; border: none; padding: 14px 18px; font-size: .875rem; }

        /* ── Email auto-generado ── */
        .email-autogen-wrap { position: relative; }
        .email-autogen-badge {
            display: none; align-items: center; gap: 5px;
            margin-top: 5px; font-size: .72rem; font-weight: 600;
            color: #00508f; background: rgba(78,199,210,.12);
            border: 1px solid rgba(78,199,210,.35);
            padding: 4px 10px; border-radius: 20px;
            width: fit-content;
        }
        .email-autogen-badge.visible { display: inline-flex; }
        .email-autogen-badge i { color: #4ec7d2; font-size: .7rem; }
        .form-control.autogenerado { border-color: #4ec7d2; background: rgba(78,199,210,.04); }

        @media(max-width:600px){
            .form-section { padding: 22px 16px; }
            .form-nav { padding: 14px 16px; }
        }
    </style>
</head>
<body>
<div class="form-wrapper">

    <div class="card-form">

        {{-- ── Contenido principal ── --}}
        <div class="card-main">

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
                                   placeholder="0000000000000" maxlength="13" required>
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
                            <select name="estudiante_grado"
                                    class="form-select @error('estudiante_grado') is-invalid @enderror" required>
                                <option value="">Seleccionar grado...</option>
                                @foreach(['Primer Grado','Segundo Grado','Tercer Grado','Cuarto Grado','Quinto Grado','Sexto Grado','Séptimo Grado','Octavo Grado','Noveno Grado'] as $g)
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
                                   value="{{ old('estudiante_telefono') }}" placeholder="99999999" maxlength="8">
                            @error('estudiante_telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Correo del Estudiante</label>
                            <div class="email-autogen-wrap">
                                <input type="email" name="estudiante_email" id="est_email_field"
                                       class="form-control @error('estudiante_email') is-invalid @enderror"
                                       value="{{ old('estudiante_email') }}"
                                       placeholder="Se genera automáticamente">
                                <span class="email-autogen-badge" id="badge_est_email">
                                    <i class="fas fa-magic"></i> Correo de acceso generado
                                </span>
                            </div>
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
                            <input type="text" name="padre_nombre" id="ui_padre_nombre"
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
                            <input type="text" name="padre_apellido" id="ui_padre_apellido"
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
                                   placeholder="0000000000000" maxlength="13" required>
                            @error('padre_dni')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

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
                                Teléfono Principal <span class="required-star">*</span> <small class="text-muted">(8 dígitos)</small>
                            </label>
                            <input type="text" name="padre_telefono"
                                   class="form-control @error('padre_telefono') is-invalid @enderror"
                                   value="{{ old('padre_telefono') }}"
                                   placeholder="99999999" maxlength="8" required>
                            @error('padre_telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                Correo Electrónico
                                <small class="text-muted fw-normal">(será su usuario de acceso)</small>
                            </label>
                            <div class="email-autogen-wrap">
                                <input type="email" name="padre_email" id="padre_email_field"
                                       class="form-control @error('padre_email') is-invalid @enderror"
                                       value="{{ old('padre_email') }}"
                                       placeholder="Se genera automáticamente">
                                <span class="email-autogen-badge" id="badge_padre_email">
                                    <i class="fas fa-magic"></i> Correo de acceso generado
                                </span>
                            </div>
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
                    </div>
                </div>{{-- /section-3 --}}


                {{-- ════════════════════════════════
                     PASO 4 — Resumen y confirmación
                ═════════════════════════════════ --}}
                <div class="form-section" id="section-4">
                    <div class="section-title">
                        <i class="fas fa-check-circle me-2" style="color:#4ec7d2"></i>Resumen y Confirmación
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

                    <div class="summary-block" id="resumen-credenciales-block" style="display:none;border:1.5px solid rgba(78,199,210,.5);background:rgba(78,199,210,.06);">
                        <h6 style="color:#4ec7d2"><i class="fas fa-key me-1"></i> Acceso futuro al sistema</h6>
                        <p style="font-size:.78rem;color:#6c757d">Se generarán credenciales automáticas para que puedas consultar el estado de tu matrícula.</p>
                    </div>

                </div>{{-- /section-4 --}}


                {{-- Botones de Navegación del Asistente --}}
                <div class="form-nav">
                    <button type="button" class="btn-nav btn-prev" id="btnPrev" style="display:none;" onclick="cambiarPaso(-1)">
                        <i class="fas fa-arrow-left"></i> Anterior
                    </button>
                    <div></div> <!-- Espaciador -->
                    <button type="button" class="btn-nav btn-next" id="btnNext" onclick="cambiarPaso(1)">
                        Siguiente <i class="fas fa-arrow-right"></i>
                    </button>
                    <button type="submit" class="btn-submit" id="btnSubmit" style="display:none;">
                        <i class="fas fa-paper-plane"></i> Enviar Matrícula
                    </button>
                </div>

            </form>
        </div>

        {{-- ── Sidebar de Pasos ── --}}
        <div class="card-sidebar">
            <div class="sidebar-logo">
                <i class="fas fa-school"></i>
            </div>
            <div class="sidebar-title-main">Escuela Gabriela Mistral</div>
            <div class="sidebar-heading">MATRÍCULAS EN LÍNEA</div>
            <div class="sidebar-sub">Ciclo Lectivo {{ date('Y') }}</div>
            <div class="sidebar-divider"></div>

            <div class="vsteps">
                <div class="vstep-item active" id="vstep-1">
                    <div class="vstep-circle">1</div>
                    <div class="vstep-label">Estudiante</div>
                </div>
                <div class="vstep-line" id="vline-1"></div>

                <div class="vstep-item" id="vstep-2">
                    <div class="vstep-circle">2</div>
                    <div class="vstep-label">Padre / Tutor</div>
                </div>
                <div class="vstep-line" id="vline-2"></div>

                <div class="vstep-item" id="vstep-3">
                    <div class="vstep-circle">3</div>
                    <div class="vstep-label">Documentos</div>
                </div>
                <div class="vstep-line" id="vline-3"></div>

                <div class="vstep-item" id="vstep-4">
                    <div class="vstep-circle">4</div>
                    <div class="vstep-label">Confirmación</div>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
    let currentStep = 1;
    const totalSteps = 4;

    function mostrarArchivo(input, labelId) {
        const label = document.getElementById(labelId);
        if (input.files && input.files[0]) {
            label.textContent = "Archivo: " + input.files[0].name;
        } else {
            label.textContent = "";
        }
    }

    function cambiarPaso(direccion) {
        // Validaciones básicas antes de avanzar
        if (direccion === 1) {
            const currentSection = document.getElementById(`section-${currentStep}`);
            const inputs = currentSection.querySelectorAll('[required]');
            let valido = true;
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    valido = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });
            if (!valido) return;
        }

        document.getElementById(`section-${currentStep}`).classList.remove('active');
        document.getElementById(`vstep-${currentStep}`).classList.remove('active');
        document.getElementById(`vstep-${currentStep}`).classList.add('done');
        if(currentStep < totalSteps) {
            const line = document.getElementById(`vline-${currentStep}`);
            if(line) line.classList.add('done');
        }

        currentStep += direccion;

        document.getElementById(`section-${currentStep}`).classList.add('active');
        document.getElementById(`vstep-${currentStep}`).classList.add('active');

        // Mostrar / Ocultar botones de navegación
        document.getElementById('btnPrev').style.display = currentStep > 1 ? 'inline-flex' : 'none';
        if (currentStep === totalSteps) {
            document.getElementById('btnNext').style.display = 'none';
            document.getElementById('btnSubmit').style.display = 'inline-flex';
            generarResumen();
        } else {
            document.getElementById('btnNext').style.display = 'inline-flex';
            document.getElementById('btnSubmit').style.display = 'none';
        }
    }

    function generarResumen() {
        const n1 = document.getElementById('ui_nombre1').value;
        const n2 = document.getElementById('ui_nombre2').value;
        const a1 = document.getElementById('ui_apellido1').value;
        const a2 = document.getElementById('ui_apellido2').value;
        const dni = document.querySelector('input[name="estudiante_dni"]').value;
        const grado = document.querySelector('select[name="estudiante_grado"]').value;
        const estEmail = document.getElementById('est_email_field').value;

        document.getElementById('resumen-estudiante').innerHTML = `
            <div class="summary-row"><span class="lbl">Nombre completo:</span><span class="val">${n1} ${n2} ${a1} ${a2}</span></div>
            <div class="summary-row"><span class="lbl">DNI:</span><span class="val">${dni}</span></div>
            <div class="summary-row"><span class="lbl">Grado solicitado:</span><span class="val">${grado}</span></div>
            <div class="summary-row"><span class="lbl">Correo institucional:</span><span class="val">${estEmail || 'No asignado'}</span></div>
        `;

        const pNombre = document.getElementById('ui_padre_nombre').value;
        const pApellido = document.getElementById('ui_padre_apellido').value;
        const pDni = document.querySelector('input[name="padre_dni"]').value;
        const pTel = document.querySelector('input[name="padre_telefono"]').value;
        const pEmail = document.getElementById('padre_email_field').value;

        document.getElementById('resumen-padre').innerHTML = `
            <div class="summary-row"><span class="lbl">Tutor:</span><span class="val">${pNombre} ${pApellido}</span></div>
            <div class="summary-row"><span class="lbl">DNI Tutor:</span><span class="val">${pDni}</span></div>
            <div class="summary-row"><span class="lbl">Teléfono:</span><span class="val">${pTel}</span></div>
            <div class="summary-row"><span class="lbl">Correo:</span><span class="val">${pEmail || 'No asignado'}</span></div>
        `;

        const foto = document.getElementById('foto_perfil').files[0];
        const acta = document.getElementById('acta_nacimiento').files[0];
        const cert = document.getElementById('calificaciones').files[0];

        document.getElementById('resumen-docs').innerHTML = `
            <div class="summary-row"><span class="lbl">Foto Estudiante:</span><span class="val">${foto ? foto.name : 'No adjuntada'}</span></div>
            <div class="summary-row"><span class="lbl">Acta de Nacimiento:</span><span class="val">${acta ? acta.name : 'No adjuntada'}</span></div>
            <div class="summary-row"><span class="lbl">Certificado:</span><span class="val">${cert ? cert.name : 'No adjuntado'}</span></div>
        `;

        if (estEmail || pEmail) {
            document.getElementById('resumen-credenciales-block').style.display = 'block';
        }
    }

    // Lógica para autogenerar correos electrónicos y concatenar nombres
    document.addEventListener('DOMContentLoaded', function () {
        const nombre1 = document.getElementById('ui_nombre1');
        const apellido1 = document.getElementById('ui_apellido1');
        const estEmailField = document.getElementById('est_email_field');
        const badgeEstEmail = document.getElementById('badge_est_email');

        const campoEstNombre = document.getElementById('campo_est_nombre');
        const campoEstApellido = document.getElementById('campo_est_apellido');

        const padreNombre = document.getElementById('ui_padre_nombre');
        const padreApellido = document.getElementById('ui_padre_apellido');
        const padreEmailField = document.getElementById('padre_email_field');
        const badgePadreEmail = document.getElementById('badge_padre_email');

        const limpiarTexto = (texto) => {
            return texto.toLowerCase()
                .normalize("NFD").replace(/[\u0300-\u036f]/g, "")
                .replace(/[^a-z0-9]/g, '');
        };

        function actualizarDatosEstudiante() {
            const n1 = nombre1.value.trim();
            const n2 = document.getElementById('ui_nombre2').value.trim();
            const a1 = apellido1.value.trim();
            const a2 = document.getElementById('ui_apellido2').value.trim();

            campoEstNombre.value = n2 ? `${n1} ${n2}` : n1;
            campoEstApellido.value = a2 ? `${a1} ${a2}` : a1;

            if (n1 && a1) {
                const emailGenerado = `${limpiarTexto(n1)}.${limpiarTexto(a1)}@gabrielamistral.edu.hn`;
                if (!estEmailField.value || estEmailField.dataset.autogenerated === "true") {
                    estEmailField.value = emailGenerado;
                    estEmailField.dataset.autogenerated = "true";
                    badgeEstEmail.classList.add('visible');
                    estEmailField.classList.add('autogenerado');
                }
            }
        }

        function actualizarEmailPadre() {
            const pn = padreNombre.value.trim();
            const pa = padreApellido.value.trim();

            if (pn && pa) {
                const emailPadreGenerado = `${limpiarTexto(pn)}.${limpiarTexto(pa)}@tutor.gabrielamistral.edu.hn`;
                if (!padreEmailField.value || padreEmailField.dataset.autogenerated === "true") {
                    padreEmailField.value = emailPadreGenerado;
                    padreEmailField.dataset.autogenerated = "true";
                    badgePadreEmail.classList.add('visible');
                    padreEmailField.classList.add('autogenerado');
                }
            }
        }

        if (nombre1 && apellido1) {
            nombre1.addEventListener('input', actualizarDatosEstudiante);
            apellido1.addEventListener('input', actualizarDatosEstudiante);
            document.getElementById('ui_nombre2').addEventListener('input', actualizarDatosEstudiante);
            document.getElementById('ui_apellido2').addEventListener('input', actualizarDatosEstudiante);
        }

        if (padreNombre && padreApellido) {
            padreNombre.addEventListener('input', actualizarEmailPadre);
            padreApellido.addEventListener('input', actualizarEmailPadre);
        }

        // Manejo del campo condicional de parentesco "Otro"
        const parentescoSelect = document.getElementById('parentescoSelect');
        const wrapParentescoOtro = document.getElementById('wrap-parentesco-otro');
        if (parentescoSelect) {
            parentescoSelect.addEventListener('change', function () {
                if (this.value === 'otro') {
                    wrapParentescoOtro.style.display = 'block';
                } else {
                    wrapParentescoOtro.style.display = 'none';
                }
            });
        }
    });
</script>
</body>
</html>
