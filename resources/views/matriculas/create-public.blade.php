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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            padding: 20px 0;
        }

        .header-section {
            background: linear-gradient(135deg, #003b73 0%, #00508f 100%);
            padding: 30px 0;
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(0, 59, 115, 0.3);
        }

        .header-content {
            text-align: center;
            color: white;
        }

        .header-content h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .form-container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 59, 115, 0.1);
        }

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
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background: #5a6268;
            color: white;
            transform: translateY(-2px);
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 59, 115, 0.1);
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #003b73;
        }

        .form-label {
            font-weight: 600;
            color: #00508f;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            border: 2px solid #bfd9ea;
            border-radius: 8px;
            padding: 0.6rem 1rem 0.6rem 2.8rem;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: #4ec7d2;
            box-shadow: 0 0 0 3px rgba(78, 199, 210, 0.1);
            outline: none;
        }

        .btn-submit {
            background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
            color: white;
            padding: 14px 45px;
            border: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.05rem;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(78, 199, 210, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(78, 199, 210, 0.5);
        }

        .btn-cancel {
            background: white;
            color: #003b73;
            padding: 14px 45px;
            border: 2px solid #bfd9ea;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.05rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-cancel:hover {
            background: #f8f9fa;
            color: #003b73;
            border-color: #4ec7d2;
            transform: translateY(-2px);
        }

        .required-mark {
            color: #ef4444;
            font-weight: 700;
        }

        .alert {
            border-radius: 12px;
            border: none;
        }

        .info-alert {
            background: rgba(78, 199, 210, 0.1);
            border: 2px solid #4ec7d2;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
        }

        .icon-box {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .file-upload-area {
            border: 2px dashed #4ec7d2;
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            background: rgba(78, 199, 210, 0.05);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .file-upload-area:hover {
            background: rgba(78, 199, 210, 0.1);
            border-color: #00508f;
        }

        .file-item {
            background: #f8f9fa;
            padding: 12px 15px;
            border-radius: 8px;
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #e1e8ed;
        }

        .file-item .btn-remove {
            background: #ef4444;
            color: white;
            border: none;
            padding: 6px 14px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .file-item .btn-remove:hover {
            background: #dc2626;
        }

        .position-relative {
            position: relative;
        }

        .position-absolute {
            position: absolute;
        }

        .invalid-feedback {
            display: block;
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 4px;
        }

        .is-invalid {
            border-color: #ef4444 !important;
        }
    </style>
</head>
<body>
    <div class="header-section">
        <div class="container header-content">
            <h1><i class="fas fa-graduation-cap me-3"></i>Formulario de Matrícula en Línea</h1>
            <p>Escuela Gabriela Mistral - Año Escolar {{ date('Y') }}</p>
        </div>
    </div>

    <div class="container">
        <div class="form-container">
           <div class="mb-4">
    <a href="{{ route('plantilla') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i>
        <span>Volver al Inicio</span>
    </a>
</div>

            <div class="info-alert">
                <h6 style="color: #003b73; font-weight: 700; margin-bottom: 10px;">
                    <i class="fas fa-info-circle me-2"></i>Información Importante
                </h6>
                <ul style="color: #00508f; margin-bottom: 0; font-size: 0.9rem; line-height: 1.8;">
                    <li>Tu solicitud será revisada por nuestro equipo administrativo</li>
                    <li>Se creará automáticamente una cuenta con tu correo electrónico</li>
                    <li>Tu contraseña será tu número de DNI (podrás cambiarla después)</li>
                    <li>El estado inicial será <strong>PENDIENTE</strong> hasta ser aprobado por el Super Administrador</li>
                </ul>
            </div>

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

            <form action="{{ route('matriculas.public.store') }}" method="POST" id="formMatricula" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="publico" value="1">

                {{-- INFORMACIÓN DEL PADRE/TUTOR --}}
                <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="icon-box" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);">
                                <i class="fas fa-user-friends" style="color: white; font-size: 0.9rem;"></i>
                            </div>
                            <h6 class="mb-0 fw-bold section-title">Información del Padre/Tutor</h6>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="padre_nombre" class="form-label">Nombre <span class="required-mark">*</span></label>
                                <div class="position-relative">
                                    <i class="fas fa-user position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                    <input type="text" class="form-control @error('padre_nombre') is-invalid @enderror" id="padre_nombre" name="padre_nombre" value="{{ old('padre_nombre') }}" placeholder="Ej: Juan Carlos" required>
                                    @error('padre_nombre')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="padre_apellido" class="form-label">Apellido <span class="required-mark">*</span></label>
                                <div class="position-relative">
                                    <i class="fas fa-user position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                    <input type="text" class="form-control @error('padre_apellido') is-invalid @enderror" id="padre_apellido" name="padre_apellido" value="{{ old('padre_apellido') }}" placeholder="Ej: Pérez García" required>
                                    @error('padre_apellido')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="padre_dni" class="form-label">DNI <span class="required-mark">*</span></label>
                                <div class="position-relative">
                                    <i class="fas fa-id-card position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                    <input type="text" class="form-control @error('padre_dni') is-invalid @enderror" id="padre_dni" name="padre_dni" value="{{ old('padre_dni') }}" placeholder="0801199512345" maxlength="13" pattern="[0-9]{13}" required>
                                    @error('padre_dni')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                                <small class="text-muted" style="font-size: 0.75rem;"><i class="fas fa-info-circle me-1"></i>13 dígitos (será tu contraseña de acceso)</small>
                            </div>

                            <div class="col-md-6">
                                <label for="padre_parentesco" class="form-label">Parentesco <span class="required-mark">*</span></label>
                                <div class="position-relative">
                                    <i class="fas fa-users position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem; z-index: 10;"></i>
                                    <select class="form-select @error('padre_parentesco') is-invalid @enderror" id="padre_parentesco" name="padre_parentesco" required onchange="toggleOtroParentesco()">
                                        <option value="">Seleccionar...</option>
                                        @foreach($parentescos as $key => $value)
                                            <option value="{{ $key }}" {{ old('padre_parentesco') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('padre_parentesco')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-6" id="otro_parentesco_div" style="display: none;">
                                <label for="padre_parentesco_otro" class="form-label">Especificar Parentesco</label>
                                <div class="position-relative">
                                    <i class="fas fa-pen position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                    <input type="text" class="form-control @error('padre_parentesco_otro') is-invalid @enderror" id="padre_parentesco_otro" name="padre_parentesco_otro" value="{{ old('padre_parentesco_otro') }}" placeholder="Ej: Tío, Hermano">
                                    @error('padre_parentesco_otro')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="padre_telefono" class="form-label">Teléfono <span class="required-mark">*</span></label>
                                <div class="position-relative">
                                    <i class="fas fa-phone position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                    <input type="text" class="form-control @error('padre_telefono') is-invalid @enderror" id="padre_telefono" name="padre_telefono" value="{{ old('padre_telefono') }}" placeholder="98765432" maxlength="8" pattern="[0-9]{8}" required>
                                    @error('padre_telefono')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="padre_email" class="form-label">Email <span class="required-mark">*</span></label>
                                <div class="position-relative">
                                    <i class="fas fa-envelope position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                    <input type="email" class="form-control @error('padre_email') is-invalid @enderror" id="padre_email" name="padre_email" value="{{ old('padre_email') }}" placeholder="padre@ejemplo.com" required>
                                    @error('padre_email')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                                <small class="text-muted" style="font-size: 0.75rem;"><i class="fas fa-info-circle me-1"></i>Usarás este correo para iniciar sesión</small>
                            </div>

                            <div class="col-12">
                                <label for="padre_direccion" class="form-label">Dirección <span class="required-mark">*</span></label>
                                <div class="position-relative">
                                    <i class="fas fa-map-marker-alt position-absolute" style="left: 12px; top: 18px; color: #00508f; font-size: 0.85rem;"></i>
                                    <textarea class="form-control @error('padre_direccion') is-invalid @enderror" id="padre_direccion" name="padre_direccion" rows="2" placeholder="Dirección completa" required style="padding-left: 2.8rem;">{{ old('padre_direccion') }}</textarea>
                                    @error('padre_direccion')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- INFORMACIÓN DEL ESTUDIANTE --}}
                <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="icon-box" style="background: linear-gradient(135deg, #00508f 0%, #003b73 100%);">
                                <i class="fas fa-user-graduate" style="color: white; font-size: 0.9rem;"></i>
                            </div>
                            <h6 class="mb-0 fw-bold section-title">Información del Estudiante</h6>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="estudiante_nombre" class="form-label">Nombre <span class="required-mark">*</span></label>
                                <div class="position-relative">
                                    <i class="fas fa-user position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                    <input type="text" class="form-control @error('estudiante_nombre') is-invalid @enderror" id="estudiante_nombre" name="estudiante_nombre" value="{{ old('estudiante_nombre') }}" placeholder="Ej: María José" required>
                                    @error('estudiante_nombre')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="estudiante_apellido" class="form-label">Apellido <span class="required-mark">*</span></label>
                                <div class="position-relative">
                                    <i class="fas fa-user position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                    <input type="text" class="form-control @error('estudiante_apellido') is-invalid @enderror" id="estudiante_apellido" name="estudiante_apellido" value="{{ old('estudiante_apellido') }}" placeholder="Ej: López Martínez" required>
                                    @error('estudiante_apellido')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="estudiante_dni" class="form-label">DNI <span class="required-mark">*</span></label>
                                <div class="position-relative">
                                    <i class="fas fa-id-card position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                    <input type="text" class="form-control @error('estudiante_dni') is-invalid @enderror" id="estudiante_dni" name="estudiante_dni" value="{{ old('estudiante_dni') }}" placeholder="0801201012345" maxlength="13" pattern="[0-9]{13}" required>
                                    @error('estudiante_dni')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                                <small class="text-muted" style="font-size: 0.75rem;"><i class="fas fa-info-circle me-1"></i>13 dígitos</small>
                            </div>

                            <div class="col-md-6">
                                <label for="estudiante_fecha_nacimiento" class="form-label">Fecha de Nacimiento <span class="required-mark">*</span></label>
                                <div class="position-relative">
                                    <i class="fas fa-calendar position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                    <input type="date" class="form-control @error('estudiante_fecha_nacimiento') is-invalid @enderror" id="estudiante_fecha_nacimiento" name="estudiante_fecha_nacimiento" value="{{ old('estudiante_fecha_nacimiento') }}" required>
                                    @error('estudiante_fecha_nacimiento')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="estudiante_sexo" class="form-label">Sexo <span class="required-mark">*</span></label>
                                <div class="position-relative">
                                    <i class="fas fa-venus-mars position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem; z-index: 10;"></i>
                                    <select class="form-select @error('estudiante_sexo') is-invalid @enderror" id="estudiante_sexo" name="estudiante_sexo" required>
                                        <option value="">Seleccionar...</option>
                                        <option value="masculino" {{ old('estudiante_sexo') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                        <option value="femenino" {{ old('estudiante_sexo') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                    </select>
                                    @error('estudiante_sexo')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="estudiante_grado" class="form-label">Grado <span class="required-mark">*</span></label>
                                <div class="position-relative">
                                    <i class="fas fa-graduation-cap position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem; z-index: 10;"></i>
                                    <select class="form-select @error('estudiante_grado') is-invalid @enderror" id="estudiante_grado" name="estudiante_grado" required>
                                        <option value="">Seleccionar...</option>
                                        @foreach($grados as $grado)
                                            <option value="{{ $grado }}" {{ old('estudiante_grado') == $grado ? 'selected' : '' }}>{{ $grado }}</option>
                                        @endforeach
                                    </select>
                                    @error('estudiante_grado')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="estudiante_seccion" class="form-label">Sección <span class="required-mark">*</span></label>
                                <div class="position-relative">
                                    <i class="fas fa-door-open position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem; z-index: 10;"></i>
                                    <select class="form-select @error('estudiante_seccion') is-invalid @enderror" id="estudiante_seccion" name="estudiante_seccion" required>
                                        <option value="">Seleccionar...</option>
                                        @foreach($secciones as $seccion)
                                            <option value="{{ $seccion }}" {{ old('estudiante_seccion') == $seccion ? 'selected' : '' }}>{{ $seccion }}</option>
                                        @endforeach
                                    </select>
                                    @error('estudiante_seccion')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- DATOS DE MATRÍCULA --}}
                <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="icon-box" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);">
                                <i class="fas fa-clipboard-list" style="color: white; font-size: 0.9rem;"></i>
                            </div>
                            <h6 class="mb-0 fw-bold section-title">Datos de Matrícula</h6>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="fecha_matricula" class="form-label">Fecha de Matrícula <span class="required-mark">*</span></label>
                                <div class="position-relative">
                                    <i class="fas fa-calendar position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                    <input type="date" class="form-control @error('fecha_matricula') is-invalid @enderror" id="fecha_matricula" name="fecha_matricula" value="{{ old('fecha_matricula', date('Y-m-d')) }}" required>
                                    @error('fecha_matricula')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="anio_lectivo" class="form-label">Año Lectivo <span class="required-mark">*</span></label>
                                <div class="position-relative">
                                    <i class="fas fa-calendar-alt position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                    <input type="number" class="form-control @error('anio_lectivo') is-invalid @enderror" id="anio_lectivo" name="anio_lectivo" value="{{ old('anio_lectivo', date('Y')) }}" placeholder="2025" min="2020" max="2099" required>
                                    @error('anio_lectivo')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="observaciones" class="form-label">Observaciones</label>
                                <div class="position-relative">
                                    <i class="fas fa-comment-alt position-absolute" style="left: 12px; top: 18px; color: #00508f; font-size: 0.85rem;"></i>
                                    <textarea class="form-control @error('observaciones') is-invalid @enderror" id="observaciones" name="observaciones" rows="3" placeholder="Notas adicionales sobre la matrícula" style="padding-left: 2.8rem;">{{ old('observaciones') }}</textarea>
                                    @error('observaciones')<div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- DOCUMENTOS --}}
                <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="icon-box" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);">
                                <i class="fas fa-folder-open" style="color: white; font-size: 0.9rem;"></i>
                            </div>
                            <h6 class="mb-0 fw-bold section-title">Documentos Requeridos</h6>
                        </div>

                        <div class="mb-3 p-3" style="background: linear-gradient(135deg, rgba(78, 199, 210, 0.1) 0%, rgba(0, 80, 143, 0.05) 100%); border-radius: 10px; border-left: 4px solid #4ec7d2;">
                            <p class="small fw-semibold mb-2" style="color: #003b73;">
                                <i class="fas fa-clipboard-check me-2" style="color: #4ec7d2;"></i>
                                Documentos que deberá presentar:
                            </p>
                            <ul class="small mb-0" style="color: #003b73; line-height: 1.8; list-style: none; padding-left: 0;">
                                <li class="mb-1"><i class="fas fa-check-circle me-2" style="color: #4ec7d2;"></i>Foto del estudiante (formato JPG/PNG)</li>
                                <li class="mb-1"><i class="fas fa-check-circle me-2" style="color: #4ec7d2;"></i>Acta de nacimiento</li>
                                <li class="mb-1"><i class="fas fa-check-circle me-2" style="color: #4ec7d2;"></i>Calificaciones del año anterior</li>
                            </ul>
                        </div>

                        <div class="file-upload-area" onclick="document.getElementById('documentos').click()">
                            <i class="fas fa-cloud-upload-alt" style="font-size: 2.5rem; color: #4ec7d2; margin-bottom: 10px;"></i>
                            <p style="color: #003b73; font-weight: 600; margin-bottom: 5px;">Haz clic para subir documentos</p>
                            <p style="color: #00508f; font-size: 0.85rem; margin-bottom: 0;">o arrastra y suelta aquí</p>
                            <small style="color: #6c757d;">Formatos: PDF, JPG, PNG (máx. 5MB por archivo)</small>
                        </div>

                        <input type="file" id="documentos" name="documentos[]" multiple accept=".pdf,.jpg,.jpeg,.png" style="display: none;" onchange="mostrarArchivos(this)">

                        <div id="listaArchivos" class="mt-3"></div>

                        <div class="mt-3 d-flex gap-2 align-items-start" style="background: rgba(78, 199, 210, 0.1); padding: 0.75rem; border-radius: 8px; border-left: 3px solid #4ec7d2;">
                            <i class="fas fa-info-circle" style="color: #00508f; margin-top: 2px;"></i>
                            <p class="small mb-0" style="color: #003b73;">
                                Los documentos pueden ser cargados después de registrar la matrícula. Máximo 5MB por archivo.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- BOTONES --}}
                <div class="d-flex gap-3 justify-content-center mt-4">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i>
                        <span>Enviar Solicitud de Matrícula</span>
                    </button>

                   <a href="{{ route('plantilla') }}" class="btn-cancel">
    <i class="fas fa-times"></i>
    <span>Cancelar</span>
</a>
                </div>

            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function toggleOtroParentesco() {
        const select = document.getElementById('padre_parentesco');
        const otroDiv = document.getElementById('otro_parentesco_div');

        if (select && otroDiv) {
            otroDiv.style.display = select.value === 'otro' ? 'block' : 'none';
        }
    }

    function mostrarArchivos(input) {
        const listaArchivos = document.getElementById('listaArchivos');
        if (!listaArchivos) return;

        listaArchivos.innerHTML = '';

        if (input.files.length > 0) {
            Array.from(input.files).forEach((file, index) => {
                if (file.size > 5 * 1024 * 1024) {
                    alert(El archivo ${file.name} excede el tamaño máximo de 5MB);
                    return;
                }

                const fileItem = document.createElement('div');
                fileItem.className = 'file-item';

                let icono = 'fa-file';
                if (file.type.includes('pdf')) icono = 'fa-file-pdf';
                else if (file.type.includes('image')) icono = 'fa-file-image';

                fileItem.innerHTML = `
                    <div>
                        <i class="fas ${icono} me-2" style="color: #4ec7d2; font-size: 1.2rem;"></i>
                        <span style="font-size: 0.95rem; color: #003b73; font-weight: 500;">${file.name}</span>
                        <small style="color: #6c757d; margin-left: 10px;">(${(file.size / 1024 / 1024).toFixed(2)} MB)</small>
                    </div>
                    <button type="button" class="btn-remove" onclick="removerArchivo(${index})">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                `;
                listaArchivos.appendChild(fileItem);
            });
        }
    }

    function removerArchivo(index) {
        const input = document.getElementById('documentos');
        if (!input) return;

        const dt = new DataTransfer();
        Array.from(input.files).forEach((file, i) => {
            if (i !== index) dt.items.add(file);
        });
        input.files = dt.files;
        mostrarArchivos(input);
    }

    document.addEventListener('DOMContentLoaded', function() {
        toggleOtroParentesco();
    });
    </script>
</body>
</html>
