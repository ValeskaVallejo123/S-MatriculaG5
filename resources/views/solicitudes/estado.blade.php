@extends('layouts.app')

@section('title', 'Consulta de Solicitud')
@section('page-title', 'Estado de Solicitud')

@section('content')
<div class="container-fluid px-4">

    {{-- ── Encabezado ── --}}
    <div class="card border-0 shadow-sm mb-4"
         style="border-radius:14px;background:linear-gradient(135deg,#003b73 0%,#00508f 60%,#0369a1 100%);">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-3">
                <div style="width:60px;height:60px;background:rgba(78,199,210,.2);border-radius:14px;
                            display:flex;align-items:center;justify-content:center;
                            border:2px solid rgba(78,199,210,.4);">
                    <i class="fas fa-search" style="font-size:1.6rem;color:#4ec7d2;"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0 text-white" style="font-size:1.3rem;">
                        Consulta de Solicitud
                    </h3>
                    <p class="mb-0" style="color:rgba(255,255,255,.7);font-size:.88rem;">
                        Verifica el estado de la solicitud de un estudiante por DNI
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Formulario de búsqueda ── --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius:14px;">
        <div class="card-header border-0 py-3 px-4"
             style="background:white;border-radius:14px 14px 0 0;border-bottom:1px solid #f1f5f9;">
            <h6 class="fw-bold mb-0" style="color:#003b73;">
                <i class="fas fa-id-card me-2" style="color:#4ec7d2;"></i>
                Buscar solicitud por DNI
            </h6>
        </div>
        <div class="card-body p-4">
            <form method="POST" action="/estado-solicitud">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label for="dni" class="form-label fw-semibold" style="color:#374151;font-size:.88rem;">
                            DNI del estudiante
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"
                                  style="background:#f8fafc;border-color:#e2e8f0;color:#4ec7d2;">
                                <i class="fas fa-id-badge"></i>
                            </span>
                            <input type="text" id="dni" name="dni"
                                   class="form-control"
                                   pattern="\d{4}-\d{4}-\d{5}"
                                   placeholder="Ej: 0801-1990-12345"
                                   title="Formato: ####-####-#####"
                                   value="{{ old('dni') }}"
                                   style="border-color:#e2e8f0;font-size:.9rem;"
                                   required>
                        </div>
                        <small class="text-muted">Formato: ####-####-#####</small>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn w-100 fw-semibold"
                                style="background:linear-gradient(135deg,#00508f,#003b73);
                                       color:white;border-radius:8px;padding:.6rem 1rem;">
                            <i class="fas fa-search me-2"></i> Buscar Solicitud
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ── Resultado ── --}}
    @if(isset($solicitud))

        @if($solicitud)

            {{-- Estado de la solicitud --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius:14px;">
                <div class="card-body p-4">

                    @if($solicitud->estado === 'aprobada')
                    <div class="d-flex align-items-center gap-3 p-3 rounded-3"
                         style="background:rgba(16,185,129,.08);border:1px solid rgba(16,185,129,.25);">
                        <div style="width:50px;height:50px;background:rgba(16,185,129,.15);border-radius:12px;
                                    display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-check-circle" style="color:#10b981;font-size:1.5rem;"></i>
                        </div>
                        <div>
                            <div class="fw-bold" style="color:#059669;font-size:1rem;">Solicitud Aprobada</div>
                            <div style="color:#064e3b;font-size:.85rem;">
                                La solicitud de matrícula ha sido aprobada exitosamente.
                            </div>
                        </div>
                    </div>

                    @elseif($solicitud->estado === 'rechazada')
                    <div class="d-flex align-items-center gap-3 p-3 rounded-3"
                         style="background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.25);">
                        <div style="width:50px;height:50px;background:rgba(239,68,68,.15);border-radius:12px;
                                    display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-times-circle" style="color:#ef4444;font-size:1.5rem;"></i>
                        </div>
                        <div>
                            <div class="fw-bold" style="color:#dc2626;font-size:1rem;">Solicitud Rechazada</div>
                            <div style="color:#7f1d1d;font-size:.85rem;">
                                La solicitud fue rechazada. Contacta al administrador para más información.
                            </div>
                        </div>
                    </div>

                    @else
                    <div class="d-flex align-items-center gap-3 p-3 rounded-3"
                         style="background:rgba(245,158,11,.08);border:1px solid rgba(245,158,11,.25);">
                        <div style="width:50px;height:50px;background:rgba(245,158,11,.15);border-radius:12px;
                                    display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-hourglass-half" style="color:#f59e0b;font-size:1.5rem;"></i>
                        </div>
                        <div>
                            <div class="fw-bold" style="color:#d97706;font-size:1rem;">Solicitud en Revisión</div>
                            <div style="color:#78350f;font-size:.85rem;">
                                Tu solicitud está siendo procesada. Te notificaremos cuando haya una respuesta.
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
            </div>

            {{-- Datos del estudiante --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius:14px;">
                <div class="card-header border-0 py-3 px-4"
                     style="background:white;border-radius:14px 14px 0 0;border-bottom:1px solid #f1f5f9;">
                    <h6 class="fw-bold mb-0" style="color:#003b73;">
                        <i class="fas fa-user-graduate me-2" style="color:#4ec7d2;"></i>
                        Datos del Estudiante
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <div class="p-3 rounded-3" style="background:#f8fafc;border:1px solid #f1f5f9;">
                                <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;
                                            letter-spacing:.5px;color:#64748b;margin-bottom:.3rem;">
                                    Nombre Completo
                                </div>
                                <div class="fw-semibold" style="color:#1e293b;">{{ $solicitud->nombre }}</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 rounded-3" style="background:#f8fafc;border:1px solid #f1f5f9;">
                                <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;
                                            letter-spacing:.5px;color:#64748b;margin-bottom:.3rem;">
                                    DNI
                                </div>
                                <div class="fw-semibold" style="color:#1e293b;">{{ $solicitud->dni }}</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 rounded-3" style="background:#f8fafc;border:1px solid #f1f5f9;">
                                <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;
                                            letter-spacing:.5px;color:#64748b;margin-bottom:.3rem;">
                                    Correo Electrónico
                                </div>
                                <div class="fw-semibold" style="color:#1e293b;">{{ $solicitud->correo }}</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 rounded-3" style="background:#f8fafc;border:1px solid #f1f5f9;">
                                <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;
                                            letter-spacing:.5px;color:#64748b;margin-bottom:.3rem;">
                                    Teléfono
                                </div>
                                <div class="fw-semibold" style="color:#1e293b;">{{ $solicitud->telefono }}</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 rounded-3" style="background:#f8fafc;border:1px solid #f1f5f9;">
                                <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;
                                            letter-spacing:.5px;color:#64748b;margin-bottom:.3rem;">
                                    Fecha de Solicitud
                                </div>
                                <div class="fw-semibold" style="color:#1e293b;">
                                    <i class="fas fa-calendar-alt me-1" style="color:#4ec7d2;"></i>
                                    {{ $solicitud->created_at->format('d/m/Y') }}
                                </div>
                            </div>
                        </div>

                        @if($solicitud->notificar)
                        <div class="col-md-6">
                            <div class="p-3 rounded-3" style="background:rgba(78,199,210,.08);border:1px solid rgba(78,199,210,.25);">
                                <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;
                                            letter-spacing:.5px;color:#0e7490;margin-bottom:.3rem;">
                                    Notificaciones
                                </div>
                                <div class="fw-semibold" style="color:#0e7490;">
                                    <i class="fas fa-bell me-1"></i>
                                    Recibirás notificaciones cuando el estado cambie.
                                </div>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>

        @else

            {{-- No encontrado --}}
            <div class="card border-0 shadow-sm" style="border-radius:14px;">
                <div class="card-body p-5 text-center">
                    <div style="width:70px;height:70px;background:rgba(100,116,139,.1);border-radius:50%;
                                display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                        <i class="fas fa-search" style="font-size:1.8rem;color:#94a3b8;"></i>
                    </div>
                    <h5 class="fw-bold mb-2" style="color:#003b73;">No se encontró ninguna solicitud</h5>
                    <p class="text-muted mb-0">No existe una solicitud registrada con el DNI ingresado.<br>
                    Verifica el número e intenta de nuevo.</p>
                </div>
            </div>

        @endif

    @endif

</div>
@endsection
