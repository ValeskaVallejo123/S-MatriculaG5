@extends('layouts.app')

@section('title', 'Estado de Solicitud')
@section('page-title', 'Estado de Solicitud de Matrícula')

@section('topbar-actions')
    {{-- NUEVO: Validación según el rol del usuario autenticado para regresar al dashboard correcto --}}
    @php
        $usuario = auth()->user();
        $rutaDashboard = match($usuario->rol->nombre ?? '') {
            'Administrador' => route('admin.dashboard'),
            'Super Administrador' => route('superadmin.dashboard'),
            'Profesor' => route('profesor.dashboard'),
            'Estudiante' => route('estudiante.dashboard'),
            'Padre' => route('padre.dashboard'),
            default => route('home'),
        };
    @endphp

    <a href="{{ $rutaDashboard }}" class="btn-back"
       style="background: white; color: #00508f; padding: 0.45rem 1rem; border-radius: 8px;
              text-decoration: none; font-weight: 600; display: inline-flex; align-items: center;
              gap: 0.5rem; border: 2px solid #00508f; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
@endsection

@section('content')
    <div class="container" style="max-width: 900px;">

        <!-- Header compacto -->
        <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg,#00508f 0%,#003b73 100%); border-radius:10px;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3" style="width:45px;height:45px;background:rgba(78,199,210,0.25);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-info-circle text-white" style="font-size:1.1rem;"></i>
                    </div>
                    <div class="text-white">
                        <h5 class="mb-0 fw-bold" style="font-size:1.05rem;">Estado de Solicitud de Matrícula</h5>
                        <p class="mb-0 opacity-90" style="font-size:0.82rem;">Consulta rápida por DNI el estado de tu solicitud</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card principal -->
        <div class="card border-0 shadow-sm" style="border-radius:10px;">
            <div class="card-body p-3">

                <!-- Buscador -->
                <form method="POST" action="{{ route('estado-solicitud') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="dni" class="form-label fw-semibold small mb-1" style="color:#003b73;">Buscar por DNI</label>
                        <div class="position-relative">
                            <i class="fas fa-id-card position-absolute" style="left:12px; top:50%; transform:translateY(-50%); color:#00508f; font-size:0.85rem; z-index:10;"></i>
                            <input type="text"
                                   id="dni"
                                   name="dni"
                                   required
                                   pattern="\d{4}-\d{4}-\d{5}"
                                   placeholder="Ej: 0801-1990-12345"
                                   class="form-control form-control-sm ps-5 @error('dni') is-invalid @enderror"
                                   style="border:2px solid #bfd9ea; border-radius:8px; padding:0.55rem 1rem 0.55rem 2.6rem;"
                                   autocomplete="off">
                            @error('dni')
                            <div class="invalid-feedback" style="font-size:0.8rem;">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 pt-2 border-top mt-3">
                        <button type="submit" class="btn btn-sm fw-semibold flex-fill" style="background: linear-gradient(135deg,#004191 0%,#0b96b6 100%); color:white; border:none; padding:0.55rem; border-radius:8px; box-shadow:0 2px 8px rgba(4,64,120,0.12);">
                            <i class="fas fa-search me-2"></i> Buscar solicitud
                        </button>

                        <a href="{{ route('estado-solicitud') }}" class="btn btn-sm fw-semibold flex-fill" style="background:white; color:#00508f; border:2px solid #00508f; padding:0.55rem; border-radius:8px; text-decoration:none;">
                            <i class="fas fa-undo me-2"></i> Limpiar
                        </a>
                    </div>
                </form>

                <!-- Resultado -->
                @if(isset($solicitud))
                    <div class="mt-4">
                        @if($solicitud)
                            <div class="text-center mb-4">
                                @php
                                    $estado = $solicitud->estado ?? 'revision';
                                @endphp

                                @if($estado === 'aprobada')
                                    <div class="d-inline-block px-3 py-1 rounded-pill fw-semibold" style="background:#e6ffef;color:#0f5132;">Tu solicitud ha sido aprobada</div>
                                @elseif($estado === 'rechazada')
                                    <div class="d-inline-block px-3 py-1 rounded-pill fw-semibold" style="background:#fff2f2;color:#7a1a1a;">Tu solicitud fue rechazada</div>
                                @else
                                    <div class="d-inline-block px-3 py-1 rounded-pill fw-semibold" style="background:#fff8e1;color:#6a4a00;">Tu solicitud está en revisión</div>
                                @endif
                            </div>

                            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm text-gray-700">
                                <h6 class="text-[#49769F] fw-bold mb-3">👤 Datos del solicitante</h6>
                                <div class="row g-2">
                                    <div class="col-12 col-sm-6"><strong>Nombre:</strong> {{ $solicitud->nombre }}</div>
                                    <div class="col-12 col-sm-6"><strong>DNI:</strong> {{ $solicitud->dni }}</div>
                                    <div class="col-12 col-sm-6"><strong>Correo:</strong> {{ $solicitud->correo ?? 'No registrado' }}</div>
                                    <div class="col-12 col-sm-6"><strong>Teléfono:</strong> {{ $solicitud->telefono ?? 'No registrado' }}</div>
                                    <div class="col-12 col-sm-6"><strong>Fecha de solicitud:</strong> {{ optional($solicitud->created_at)->format('d/m/Y') ?? '-' }}</div>
                                </div>
                            </div>

                            @if(!empty($solicitud->notificar))
                                <p class="mt-3 text-center text-xs text-gray-500 italic">Recibirás notificaciones cuando el estado cambie.</p>
                            @endif
                        @else
                            <div class="mt-3 alert border-0 py-2 px-3" style="border-radius:8px;background:rgba(255,235,238,0.6);border-left:3px solid #f8d7da;">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-exclamation-circle me-2" style="color:#7a1a1a;"></i>
                                    <div class="fw-semibold" style="color:#7a1a1a;">No se encontró ninguna solicitud con ese DNI. Verifique e intente nuevamente.</div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

            </div>
        </div>

        <!-- Nota compacta -->
        <div class="alert border-0 mt-3 py-2 px-3" style="border-radius:8px; background:rgba(78,199,210,0.08); border-left:3px solid #4ec7d2;">
            <div class="d-flex align-items-start">
                <i class="fas fa-info-circle me-2 mt-1" style="color:#00508f;"></i>
                <div>
                    <strong style="color:#00508f;">Información importante:</strong>
                    <span class="text-muted"> Usa el formato de DNI solicitado para obtener resultados más precisos.</span>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('styles')
    <style>
        .form-control-sm, .form-select-sm {
            border-radius: 6px;
            border: 1.5px solid #e2e8f0;
            padding: 0.5rem 0.75rem;
            transition: all 0.3s ease;
            font-size: 0.875rem;
        }
        .form-control-sm:focus {
            border-color: #4ec7d2;
            box-shadow: 0 0 0 0.15rem rgba(78,199,210,0.12);
        }
        .form-label {
            color:#003b73;
            font-size:0.85rem;
            margin-bottom:0.3rem;
        }
        .btn:hover {
            transform: translateY(-2px);
            transition: all 0.25s ease;
        }
        .btn-back:hover {
            background:#00508f !important;
            color:white !important;
            transform:translateY(-2px);
        }
        .border-top { border-color: rgba(0,80,143,0.08) !important; }
        .position-relative .fas { pointer-events: none; left:12px; position:absolute; }
        @media (max-width:768px){
            .d-flex.gap-2 { gap:0.5rem !important; }
        }
    </style>
@endpush
