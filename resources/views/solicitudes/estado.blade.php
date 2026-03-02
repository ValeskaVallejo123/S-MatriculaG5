@extends('layouts.app')

@section('title', 'Consulta de Solicitud')

@section('page-title', 'Estado de Solicitud del Estudiante')

@section('content')
<div class="container-fluid px-4">

    <!-- ENCABEZADO -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Consulta de Solicitud</h2>
            <p class="text-muted mb-0">Verifica el estado de la solicitud de un estudiante</p>
        </div>

        <span class="badge bg-primary p-2 px-3">
            <i class="fas fa-search me-1"></i> Consulta
        </span>
    </div>

    <!-- CARD PRINCIPAL -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">

            <h5 class="fw-semibold mb-3">
                <i class="fas fa-id-card me-2 text-primary"></i>
                Buscar solicitud por DNI
            </h5>

            <!-- FORMULARIO -->
            <form method="POST" action="/estado-solicitud" class="row g-3">
                @csrf

                <div class="col-md-6">
                    <label for="dni" class="form-label fw-bold">DNI del estudiante</label>
                    <input type="text" id="dni" name="dni"
                           class="form-control"
                           pattern="\d{4}-\d{4}-\d{5}"
                           placeholder="Ej: 0801-1990-12345"
                           title="Formato: ####-####-#####"
                           required>
                </div>

                <div class="col-md-6 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i> Buscar solicitud
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- RESULTADO -->
    @if(isset($solicitud))

        @if($solicitud)

            <!-- ESTADO -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">

                    <h5 class="fw-semibold mb-3">
                        <i class="fas fa-info-circle me-2 text-secondary"></i>
                        Resultado de la búsqueda
                    </h5>

                    <div class="p-3 rounded fw-bold
                        @if($solicitud->estado === 'aprobada') bg-success-subtle text-success
                        @elseif($solicitud->estado === 'rechazada') bg-danger-subtle text-danger
                        @else bg-warning-subtle text-warning
                        @endif">

                        @if($solicitud->estado === 'aprobada')
                            <i class="fas fa-check-circle me-2"></i> Tu solicitud ha sido aprobada.
                        @elseif($solicitud->estado === 'rechazada')
                            <i class="fas fa-times-circle me-2"></i> Tu solicitud fue rechazada.
                        @else
                            <i class="fas fa-hourglass-half me-2"></i> Tu solicitud está en revisión.
                        @endif
                    </div>

                </div>
            </div>

            <!-- DATOS DEL ESTUDIANTE -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">

                    <h5 class="fw-semibold mb-3">
                        <i class="fas fa-user-graduate me-2 text-primary"></i>
                        Datos del estudiante
                    </h5>

                    <div class="row gy-2">
                        <div class="col-md-6"><strong>Nombre:</strong> {{ $solicitud->nombre }}</div>
                        <div class="col-md-6"><strong>DNI:</strong> {{ $solicitud->dni }}</div>
                        <div class="col-md-6"><strong>Correo:</strong> {{ $solicitud->correo }}</div>
                        <div class="col-md-6"><strong>Teléfono:</strong> {{ $solicitud->telefono }}</div>
                        <div class="col-md-6"><strong>Fecha de solicitud:</strong> {{ $solicitud->created_at->format('d/m/Y') }}</div>
                    </div>

                    @if($solicitud->notificar)
                        <p class="mt-3 text-primary">
                            <i class="fas fa-bell me-1"></i> Recibirás notificaciones cuando el estado cambie.
                        </p>
                    @endif

                </div>
            </div>

        @else
            <div class="alert alert-secondary text-center shadow-sm">
                <i class="fas fa-exclamation-circle me-2"></i>
                No se encontró ninguna solicitud con ese DNI.
            </div>
        @endif

    @endif

</div>
@endsection
