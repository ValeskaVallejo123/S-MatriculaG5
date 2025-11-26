@extends('layouts.app')

@section('title', 'Estado de Solicitud')
@section('page-title', 'Estado de Solicitud de Matrícula')

@section('content')
    <div class="container" style="max-width: 900px;">

        <!-- HEADER -->
        <div class="card border-0 shadow-sm mb-4"
             style="background: linear-gradient(135deg,#00508f 0%,#003b73 100%); border-radius:10px;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3"
                         style="width:45px;height:45px;background:rgba(78,199,210,0.25);
                     border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-info-circle text-white" style="font-size:1.1rem;"></i>
                    </div>
                    <div class="text-white">
                        <h5 class="mb-0 fw-bold" style="font-size:1.05rem;">Consultar Estado de Solicitud</h5>
                        <p class="mb-0 opacity-90" style="font-size:0.82rem;">Consulta usando tu número de DNI</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD PRINCIPAL -->
        <div class="card border-0 shadow-sm" style="border-radius:10px;">
            <div class="card-body p-3">

                <!-- FORMULARIO -->
                <form method="POST" action="{{ route('estado-solicitud') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="dni" class="form-label fw-semibold small mb-1" style="color:#003b73;">
                            Buscar por DNI
                        </label>

                        <div class="position-relative">
                            <i class="fas fa-id-card position-absolute"
                               style="left:12px;top:50%;transform:translateY(-50%);color:#00508f;"></i>

                            <input type="text"
                                   id="dni"
                                   name="dni"
                                   required
                                   placeholder="Ej: 0801-1990-12345"
                                   class="form-control ps-5 @error('dni') is-invalid @enderror"
                                   style="border:2px solid #bfd9ea; border-radius:8px;">

                            @error('dni')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit"
                            class="btn w-100 fw-semibold"
                            style="background: linear-gradient(135deg,#004191 0%,#0b96b6 100%);
                        color:white; border:none; padding:0.55rem; border-radius:8px;">
                        <i class="fas fa-search me-2"></i> Buscar solicitud
                    </button>
                </form>

                <!-- MENSAJE DE ERROR -->
                @if(isset($error))
                    <div class="alert alert-warning mt-3">{{ $error }}</div>
                @endif

                <!-- RESULTADOS -->
                @if(isset($matricula))
                    <div class="mt-4">

                        <!-- ESTADO -->
                        <div class="text-center mb-3">
                            @if($matricula->estado === 'aprobada')
                                <span class="px-3 py-1 rounded-pill"
                                      style="background:#e6ffef;color:#0f5132;font-weight:600;">
                                    ✔ Solicitud Aprobada
                                </span>
                            @elseif($matricula->estado === 'rechazada')
                                <span class="px-3 py-1 rounded-pill"
                                      style="background:#ffe6e6;color:#7a1a1a;font-weight:600;">
                                    ✖ Solicitud Rechazada
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-pill"
                                      style="background:#fff4cc;color:#6a4a00;font-weight:600;">
                                    ⏳ En Revisión
                                </span>
                            @endif
                        </div>

                        <!-- DATOS DEL ESTUDIANTE -->
                        <div class="border rounded p-3 bg-light">
                            <h6 class="fw-bold mb-3" style="color:#49769F;">👤 Datos del Estudiante</h6>

                            <div><strong>Nombre:</strong> {{ $estudiante->nombre_completo }}</div>
                            <div><strong>DNI:</strong> {{ $estudiante->dni }}</div>
                            <div><strong>Correo:</strong> {{ $estudiante->email ?? 'No registrado' }}</div>
                        </div>

                        <!-- DATOS DE LA MATRÍCULA -->
                        <div class="border rounded p-3 bg-light mt-3">
                            <h6 class="fw-bold mb-3" style="color:#49769F;">📄 Información de la Matrícula</h6>

                            <div><strong>Código:</strong> {{ $matricula->codigo_matricula }}</div>
                            <div><strong>Año lectivo:</strong> {{ $matricula->anio_lectivo }}</div>
                            <div><strong>Fecha de solicitud:</strong> {{ $matricula->fecha_matricula->format('d/m/Y') }}</div>

                            <div><strong>Observaciones:</strong> {{ $matricula->observaciones ?? 'N/A' }}</div>

                            @if($matricula->estado === 'rechazada')
                                <div><strong>Motivo de rechazo:</strong> {{ $matricula->motivo_rechazo ?? 'No especificado' }}</div>
                            @endif
                        </div>

                    </div>
                @endif

            </div>
        </div>

    </div>
@endsection
