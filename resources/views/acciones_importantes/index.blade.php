@extends('layouts.app')

@section('title', 'Acciones Importantes')
@section('page-title', 'Acciones Importantes del Sistema')

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
    <div class="container" style="max-width: 1100px;">

        <!-- Encabezado institucional -->
        <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg,#00508f 0%,#003b73 100%); border-radius:10px;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3" style="width:45px;height:45px;background:rgba(78,199,210,0.25);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-bolt text-white" style="font-size:1.2rem;"></i>
                    </div>
                    <div class="text-white">
                        <h5 class="mb-0 fw-bold" style="font-size:1.05rem;">Acciones Importantes del Sistema</h5>
                        <p class="mb-0 opacity-90" style="font-size:0.82rem;">Resumen rápido de matrículas, solicitudes y calificaciones recientes</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjetas de acciones -->
        <div class="row g-3">
            {{-- MATRÍCULAS --}}
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius:10px;">
                    <div class="card-header text-white fw-semibold" style="background: linear-gradient(135deg,#004191 0%,#0b96b6 100%); border-top-left-radius:10px; border-top-right-radius:10px;">
                        <i class="fas fa-user-graduate me-2"></i> Matrículas recientes
                    </div>
                    <div class="card-body">
                        @if($matriculasRecientes->isEmpty())
                            <p class="text-muted small">No hay matrículas recientes.</p>
                        @else
                            <ul class="list-group list-group-flush">
                                @foreach($matriculasRecientes as $m)
                                    <li class="list-group-item small">
                                        <strong>{{ $m->estudiante->nombre }}</strong><br>
                                        <span class="text-muted">📅 {{ $m->fecha_matricula }} | Estado: {{ ucfirst($m->estado) }}</span>
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
                    <div class="card-header fw-semibold" style="background: linear-gradient(135deg,#f7c948 0%,#f0ad4e 100%); color:#3b3b3b; border-top-left-radius:10px; border-top-right-radius:10px;">
                        <i class="fas fa-file-alt me-2"></i> Solicitudes pendientes
                    </div>
                    <div class="card-body">
                        @if($solicitudesPendientes->isEmpty())
                            <p class="text-muted small">No hay solicitudes pendientes.</p>
                        @else
                            <ul class="list-group list-group-flush">
                                @foreach($solicitudesPendientes as $s)
                                    <li class="list-group-item small">
                                        <strong>{{ $s->estudiante->nombre }}</strong><br>
                                        <span class="text-muted">📅 {{ $s->created_at->format('Y-m-d') }} | Estado: {{ ucfirst($s->estado) }}</span>
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
                    <div class="card-header text-white fw-semibold" style="background: linear-gradient(135deg,#28a745 0%,#218838 100%); border-top-left-radius:10px; border-top-right-radius:10px;">
                        <i class="fas fa-star me-2"></i> Calificaciones recientes
                    </div>
                    <div class="card-body">
                        @if($calificacionesRecientes->isEmpty())
                            <p class="text-muted small">No hay calificaciones recientes.</p>
                        @else
                            <ul class="list-group list-group-flush">
                                @foreach($calificacionesRecientes as $c)
                                    <li class="list-group-item small">
                                        <strong>{{ $c->estudiante->nombre }}</strong><br>
                                        <span class="text-muted">📚 {{ $c->materia->nombre }} | Nota: {{ $c->nota }} | 📅 {{ $c->created_at->format('Y-m-d') }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Nota institucional -->
        <div class="alert border-0 mt-4 py-2 px-3" style="border-radius:8px; background:rgba(78,199,210,0.08); border-left:3px solid #4ec7d2;">
            <div class="d-flex align-items-start">
                <i class="fas fa-info-circle me-2 mt-1" style="color:#00508f;"></i>
                <div>
                    <strong style="color:#00508f;">Nota:</strong>
                    <span class="text-muted"> Esta vista se actualiza con las últimas acciones registradas en el sistema.</span>
                </div>
            </div>
        </div>

    </div>
@endsection
