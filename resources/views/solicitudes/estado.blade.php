@extends('layouts.app')

@section('title', 'Estado de Solicitud')
@section('page-title', 'Estado de Solicitud de Matrícula')

@section('content')

    <div class="container-fluid">

        <!-- HEADER -->
        <div class="card border-0 shadow-sm mb-4"
             style="border-radius:12px;background:linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);">

            <div class="card-body p-3">

                <div class="d-flex align-items-center">

                    <div class="me-3"
                         style="width:48px;height:48px;border-radius:10px;
                     background:rgba(255,255,255,0.2);
                     display:flex;align-items:center;justify-content:center;">

                        <i class="fas fa-search text-white" style="font-size:1.2rem;"></i>

                    </div>

                    <div class="text-white">

                        <h5 class="mb-0 fw-bold" style="font-size:1.1rem;">
                            Consultar Estado de Solicitud
                        </h5>

                        <p class="mb-0 opacity-90" style="font-size:0.85rem;">
                            Ingresa tu número de DNI para verificar el estado de tu matrícula
                        </p>

                    </div>

                </div>

            </div>
        </div>


        <!-- CARD PRINCIPAL -->
        <div class="card border-0 shadow-sm" style="border-radius:12px;">

            <div class="card-body p-4">

                <!-- FORMULARIO -->
                <form method="POST" action="{{ route('estado-solicitud') }}">
                    @csrf

                    <div class="mb-3">

                        <label for="dni"
                               class="form-label fw-semibold small mb-2"
                               style="color:#003b73;">

                            Número de DNI

                        </label>

                        <div class="position-relative">

                            <i class="fas fa-id-card position-absolute"
                               style="left:12px;top:50%;transform:translateY(-50%);
                           color:#00508f;"></i>

                            <input type="text"
                                   id="dni"
                                   name="dni"
                                   required
                                   placeholder="Ej: 0801-1990-12345"
                                   class="form-control ps-5 @error('dni') is-invalid @enderror"
                                   style="border:2px solid #bfd9ea;border-radius:8px;padding:0.6rem;">

                            @error('dni')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                    </div>


                    <button type="submit"
                            class="btn w-100 fw-semibold"
                            style="background:linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);
                        color:white;border:none;padding:0.6rem;border-radius:8px;">

                        <i class="fas fa-search me-2"></i>
                        Buscar solicitud

                    </button>

                </form>


                <!-- ERROR -->
                @if(isset($error))

                    <div class="alert alert-warning mt-4 mb-0"
                         style="border-radius:8px;">

                        {{ $error }}

                    </div>

                @endif


                <!-- RESULTADO -->
                @if(isset($matricula))

                    <div class="mt-4">

                        <!-- ESTADO -->
                        <div class="text-center mb-4">

                            @if($matricula->estado === 'aprobada')

                                <span class="px-4 py-2 rounded-pill"
                                      style="background:#e6ffef;color:#0f5132;font-weight:600;">

                                ✔ Solicitud Aprobada

                            </span>

                            @elseif($matricula->estado === 'rechazada')

                                <span class="px-4 py-2 rounded-pill"
                                      style="background:#ffe6e6;color:#7a1a1a;font-weight:600;">

                                ✖ Solicitud Rechazada

                            </span>

                            @else

                                <span class="px-4 py-2 rounded-pill"
                                      style="background:#fff4cc;color:#6a4a00;font-weight:600;">

                                ⏳ Solicitud en Revisión

                            </span>

                            @endif

                        </div>


                        <!-- DATOS DEL ESTUDIANTE -->
                        <div class="card border-0 shadow-sm mb-3"
                             style="border-radius:10px;">

                            <div class="card-body">

                                <h6 class="fw-bold mb-3"
                                    style="color:#003b73;">

                                    <i class="fas fa-user me-2"></i>
                                    Datos del Estudiante

                                </h6>

                                <div class="mb-1">
                                    <strong>Nombre:</strong>
                                    {{ $estudiante->nombre_completo }}
                                </div>

                                <div class="mb-1">
                                    <strong>DNI:</strong>
                                    {{ $estudiante->dni }}
                                </div>

                                <div>
                                    <strong>Correo:</strong>
                                    {{ $estudiante->email ?? 'No registrado' }}
                                </div>

                            </div>

                        </div>


                        <!-- DATOS MATRÍCULA -->
                        <div class="card border-0 shadow-sm"
                             style="border-radius:10px;">

                            <div class="card-body">

                                <h6 class="fw-bold mb-3"
                                    style="color:#003b73;">

                                    <i class="fas fa-file-alt me-2"></i>
                                    Información de la Matrícula

                                </h6>

                                <div class="mb-1">
                                    <strong>Código:</strong>
                                    {{ $matricula->codigo_matricula }}
                                </div>

                                <div class="mb-1">
                                    <strong>Año lectivo:</strong>
                                    {{ $matricula->anio_lectivo }}
                                </div>

                                <div class="mb-1">
                                    <strong>Fecha de solicitud:</strong>
                                    {{ $matricula->fecha_matricula->format('d/m/Y') }}
                                </div>

                                <div class="mb-1">
                                    <strong>Observaciones:</strong>
                                    {{ $matricula->observaciones ?? 'N/A' }}
                                </div>

                                @if($matricula->estado === 'rechazada')

                                    <div>
                                        <strong>Motivo de rechazo:</strong>
                                        {{ $matricula->motivo_rechazo ?? 'No especificado' }}
                                    </div>

                                @endif

                            </div>

                        </div>

                    </div>

                @endif

            </div>

        </div>

    </div>

@endsection
