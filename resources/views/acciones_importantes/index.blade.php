@extends('layouts.app')

@section('title', 'Acciones Importantes')
@section('page-title', 'Acciones Importantes del Sistema')

@section('topbar-actions')
    @php
        $usuario = auth()->user();
        $rutaDashboard = match($usuario->rol->nombre ?? '') {
            'Administrador'       => route('admin.dashboard'),
            'Super Administrador' => route('superadmin.dashboard'),
            'Profesor'            => route('profesor.dashboard'),
            'Estudiante'          => route('estudiante.dashboard'),
            'Padre'               => route('padre.dashboard'),
            default               => route('home'),
        };
    @endphp
    <a href="{{ $rutaDashboard }}" class="btn btn-sm fw-semibold"
       style="background:white;color:#00508f;border:2px solid #00508f;border-radius:8px;">
        <i class="fas fa-arrow-left me-1"></i> Volver
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 1100px;">

    {{-- Encabezado --}}
    <div class="card border-0 shadow-sm mb-4"
         style="background:linear-gradient(135deg,#00508f 0%,#003b73 100%);border-radius:10px;">
        <div class="card-body p-3">
            <div class="d-flex align-items-center gap-3">
                <div style="width:45px;height:45px;background:rgba(78,199,210,0.25);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-bolt text-white" style="font-size:1.2rem;"></i>
                </div>
                <div class="text-white">
                    <h5 class="mb-0 fw-bold" style="font-size:1.05rem;">Acciones Importantes del Sistema</h5>
                    <p class="mb-0" style="font-size:0.82rem;opacity:0.9;">Resumen rápido de matrículas, solicitudes y calificaciones recientes</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tarjetas --}}
    <div class="row g-3">

        {{-- MATRÍCULAS --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius:10px;">
                <div class="card-header text-white fw-semibold"
                     style="background:linear-gradient(135deg,#004191 0%,#0b96b6 100%);border-radius:10px 10px 0 0;">
                    <i class="fas fa-user-graduate me-2"></i>Matrículas recientes
                </div>
                <div class="card-body p-2">
                    @if($matriculasRecientes->isEmpty())
                        <p class="text-muted small text-center py-3 mb-0">
                            <i class="fas fa-inbox me-1"></i>No hay matrículas recientes.
                        </p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($matriculasRecientes as $m)
                                <li class="list-group-item small px-2">
                                    {{-- nombre1 y apellido1 según modelo Estudiante --}}
                                    <strong style="color:#003b73;">
                                        {{ $m->estudiante->nombre1 ?? 'N/A' }} {{ $m->estudiante->apellido1 ?? '' }}
                                    </strong>
                                    <br>
                                    <span class="text-muted">
                                        <i class="fas fa-calendar-alt me-1"></i>{{ $m->fecha_matricula }}
                                        &nbsp;·&nbsp;
                                        <i class="fas fa-circle me-1" style="font-size:0.5rem;"></i>{{ ucfirst($m->estado) }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        {{-- SOLICITUDES --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius:10px;">
                <div class="card-header fw-semibold"
                     style="background:linear-gradient(135deg,#f7c948 0%,#f0ad4e 100%);color:#3b3b3b;border-radius:10px 10px 0 0;">
                    <i class="fas fa-file-alt me-2"></i>Solicitudes pendientes
                </div>
                <div class="card-body p-2">
                    @if($solicitudesPendientes->isEmpty())
                        <p class="text-muted small text-center py-3 mb-0">
                            <i class="fas fa-inbox me-1"></i>No hay solicitudes pendientes.
                        </p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($solicitudesPendientes as $s)
                                <li class="list-group-item small px-2">
                                    <strong style="color:#003b73;">
                                        {{ $s->estudiante->nombre1 ?? 'N/A' }} {{ $s->estudiante->apellido1 ?? '' }}
                                    </strong>
                                    <br>
                                    <span class="text-muted">
                                        <i class="fas fa-calendar-alt me-1"></i>{{ $s->created_at->format('d/m/Y') }}
                                        &nbsp;·&nbsp;
                                        <i class="fas fa-circle me-1" style="font-size:0.5rem;"></i>{{ ucfirst($s->estado) }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        {{-- CALIFICACIONES --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius:10px;">
                <div class="card-header text-white fw-semibold"
                     style="background:linear-gradient(135deg,#28a745 0%,#218838 100%);border-radius:10px 10px 0 0;">
                    <i class="fas fa-star me-2"></i>Calificaciones recientes
                </div>
                <div class="card-body p-2">
                    @if($calificacionesRecientes->isEmpty())
                        <p class="text-muted small text-center py-3 mb-0">
                            <i class="fas fa-inbox me-1"></i>No hay calificaciones recientes.
                        </p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($calificacionesRecientes as $c)
                                <li class="list-group-item small px-2">
                                    <strong style="color:#003b73;">
                                        {{ $c->estudiante->nombre1 ?? 'N/A' }} {{ $c->estudiante->apellido1 ?? '' }}
                                    </strong>
                                    <br>
                                    <span class="text-muted">
                                        <i class="fas fa-book me-1"></i>{{ $c->materia->nombre ?? 'N/A' }}
                                        &nbsp;·&nbsp;
                                        <i class="fas fa-star me-1"></i>{{ $c->nota }}
                                        &nbsp;·&nbsp;
                                        <i class="fas fa-calendar-alt me-1"></i>{{ $c->created_at->format('d/m/Y') }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

    </div>

    {{-- Nota institucional --}}
    <div class="alert border-0 mt-4 py-2 px-3"
         style="border-radius:8px;background:rgba(78,199,210,0.08);border-left:3px solid #4ec7d2 !important;">
        <div class="d-flex align-items-start gap-2">
            <i class="fas fa-info-circle mt-1" style="color:#00508f;"></i>
            <div>
                <strong style="color:#00508f;">Nota:</strong>
                <span class="text-muted"> Esta vista se actualiza con las últimas acciones registradas en el sistema.</span>
            </div>
        </div>
    </div>

</div>
@endsection
