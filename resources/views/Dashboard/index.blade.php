@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Panel de Control - Super Administrador')

@section('content')
<div class="container-fluid" style="max-width: 1400px;">

    <!-- Mensaje de bienvenida -->
    <div class="welcome-banner mb-4" style="background: linear-gradient(135deg, #003b73 0%, #00508f 100%); border-radius: 12px; padding: 1.5rem 2rem; color: white; box-shadow: 0 4px 15px rgba(0, 59, 115, 0.2);">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1" style="font-weight: 700;">
                    <i class="fas fa-crown" style="color: #4ec7d2;"></i>
                    ¡Bienvenido, {{ auth()->user()->name }}!
                </h4>
                <p class="mb-0" style="font-size: 0.9rem; opacity: 0.9;">
                    <i class="far fa-calendar-alt"></i>
                    {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                    @if($periodoActual)
                        <span class="ms-3">
                            <i class="fas fa-circle-dot" style="color: #4ec7d2;"></i>
                            Período Actual: <strong>{{ $periodoActual->nombre_periodo }}</strong>
                        </span>
                    @endif
                </p>
            </div>
            <div class="text-end">
                <span class="badge" style="background: rgba(78, 199, 210, 0.2); color: white; padding: 0.5rem 1rem; font-size: 0.85rem; border: 1px solid rgba(78, 199, 210, 0.3);">
                    <i class="fas fa-user-shield"></i> Super Administrador
                </span>
            </div>
        </div>
    </div>

    <!-- Tarjetas de Estadísticas Principales -->
    <div class="row g-3 mb-4">
        <!-- Estudiantes -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 12px; padding: 1.5rem; color: white; box-shadow: 0 4px 15px rgba(78, 199, 210, 0.3); position: relative; overflow: hidden;">
                <div class="stat-icon" style="position: absolute; right: -10px; top: -10px; font-size: 6rem; opacity: 0.15;">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div style="position: relative; z-index: 1;">
                    <div class="d-flex align-items-center mb-2">
                        <div class="icon-box" style="background: rgba(255, 255, 255, 0.2); width: 50px; height: 50px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                            <i class="fas fa-user-graduate" style="font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <p class="mb-0" style="font-size: 0.8rem; opacity: 0.9;">Total Estudiantes</p>
                            <h2 class="mb-0" style="font-weight: 800; font-size: 2rem;">{{ $totalEstudiantes }}</h2>
                        </div>
                    </div>
                    <div class="mt-3 pt-2" style="border-top: 1px solid rgba(255, 255, 255, 0.2);">
                        <span style="font-size: 0.85rem;">
                            <i class="fas fa-check-circle"></i>
                            <strong>{{ $estudiantesActivos }}</strong> Activos
                        </span>
                        <a href="{{ route('estudiantes.index') }}" class="float-end text-white" style="font-size: 0.85rem; text-decoration: none;">
                            Ver todos <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profesores -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; padding: 1.5rem; color: white; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3); position: relative; overflow: hidden;">
                <div class="stat-icon" style="position: absolute; right: -10px; top: -10px; font-size: 6rem; opacity: 0.15;">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div style="position: relative; z-index: 1;">
                    <div class="d-flex align-items-center mb-2">
                        <div class="icon-box" style="background: rgba(255, 255, 255, 0.2); width: 50px; height: 50px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                            <i class="fas fa-chalkboard-teacher" style="font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <p class="mb-0" style="font-size: 0.8rem; opacity: 0.9;">Total Profesores</p>
                            <h2 class="mb-0" style="font-weight: 800; font-size: 2rem;">{{ $totalProfesores }}</h2>
                        </div>
                    </div>
                    <div class="mt-3 pt-2" style="border-top: 1px solid rgba(255, 255, 255, 0.2);">
                        <span style="font-size: 0.85rem;">
                            <i class="fas fa-check-circle"></i>
                            <strong>{{ $profesoresActivos }}</strong> Activos
                        </span>
                        <a href="{{ route('profesores.index') }}" class="float-end text-white" style="font-size: 0.85rem; text-decoration: none;">
                            Ver todos <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Matrículas -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 12px; padding: 1.5rem; color: white; box-shadow: 0 4px 15px rgba(240, 147, 251, 0.3); position: relative; overflow: hidden;">
                <div class="stat-icon" style="position: absolute; right: -10px; top: -10px; font-size: 6rem; opacity: 0.15;">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div style="position: relative; z-index: 1;">
                    <div class="d-flex align-items-center mb-2">
                        <div class="icon-box" style="background: rgba(255, 255, 255, 0.2); width: 50px; height: 50px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                            <i class="fas fa-clipboard-list" style="font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <p class="mb-0" style="font-size: 0.8rem; opacity: 0.9;">Total Matrículas</p>
                            <h2 class="mb-0" style="font-weight: 800; font-size: 2rem;">{{ $totalMatriculas }}</h2>
                        </div>
                    </div>
                    <div class="mt-3 pt-2" style="border-top: 1px solid rgba(255, 255, 255, 0.2);">
                        <span style="font-size: 0.85rem;">
                            <i class="fas fa-check-circle"></i>
                            <strong>{{ $matriculasAprobadas }}</strong> Aprobadas
                        </span>
                        <a href="{{ route('matriculas.index') }}" class="float-end text-white" style="font-size: 0.85rem; text-decoration: none;">
                            Ver todas <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cursos -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 12px; padding: 1.5rem; color: white; box-shadow: 0 4px 15px rgba(250, 112, 154, 0.3); position: relative; overflow: hidden;">
                <div class="stat-icon" style="position: absolute; right: -10px; top: -10px; font-size: 6rem; opacity: 0.15;">
                    <i class="fas fa-book-open"></i>
                </div>
                <div style="position: relative; z-index: 1;">
                    <div class="d-flex align-items-center mb-2">
                        <div class="icon-box" style="background: rgba(255, 255, 255, 0.2); width: 50px; height: 50px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                            <i class="fas fa-book-open" style="font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <p class="mb-0" style="font-size: 0.8rem; opacity: 0.9;">Total Cursos</p>
                            <h2 class="mb-0" style="font-weight: 800; font-size: 2rem;">{{ $totalCursos }}</h2>
                        </div>
                    </div>
                    <div class="mt-3 pt-2" style="border-top: 1px solid rgba(255, 255, 255, 0.2);">
                        <span style="font-size: 0.85rem;">
                            <i class="fas fa-clock"></i>
                            Activos
                        </span>
                        <span class="float-end" style="font-size: 0.85rem;">
                            <i class="fas fa-chart-line"></i> Gestión
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjetas Secundarias -->
    <div class="row g-3 mb-4">
        <!-- Usuarios del Sistema -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm" style="border-radius: 10px; border-left: 4px solid #00508f;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1" style="font-size: 0.75rem;">Usuarios Sistema</p>
                            <h4 class="mb-0" style="color: #003b73; font-weight: 700;">{{ $totalUsuarios }}</h4>
                        </div>
                        <div class="icon-box" style="background: rgba(0, 80, 143, 0.1); width: 45px; height: 45px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-users" style="font-size: 1.3rem; color: #00508f;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Administradores -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm" style="border-radius: 10px; border-left: 4px solid #4ec7d2;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1" style="font-size: 0.75rem;">Administradores</p>
                            <h4 class="mb-0" style="color: #003b73; font-weight: 700;">{{ $totalAdministradores }}</h4>
                        </div>
                        <div class="icon-box" style="background: rgba(78, 199, 210, 0.1); width: 45px; height: 45px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user-shield" style="font-size: 1.3rem; color: #4ec7d2;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Matrículas Pendientes -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm" style="border-radius: 10px; border-left: 4px solid #f59e0b;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1" style="font-size: 0.75rem;">Mat. Pendientes</p>
                            <h4 class="mb-0" style="color: #003b73; font-weight: 700;">{{ $matriculasPendientes }}</h4>
                        </div>
                        <div class="icon-box" style="background: rgba(245, 158, 11, 0.1); width: 45px; height: 45px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-clock" style="font-size: 1.3rem; color: #f59e0b;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Acción Rápida -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm" style="border-radius: 10px; background: linear-gradient(135deg, rgba(78, 199, 210, 0.1) 0%, rgba(0, 80, 143, 0.05) 100%);">
                <div class="card-body p-3">
                    <div class="text-center">
                        <p class="text-muted mb-2" style="font-size: 0.75rem;">Acción Rápida</p>
                        <a href="{{ route('estudiantes.create') }}" class="btn btn-sm w-100" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 8px; font-weight: 600; padding: 0.5rem;">
                            <i class="fas fa-plus"></i> Nuevo Estudiante
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos y Tablas -->
    <div class="row g-3 mb-4">
        <!-- Estudiantes por Grado -->
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm" style="border-radius: 10px;">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0" style="color: #003b73; font-weight: 700;">
                        <i class="fas fa-chart-bar" style="color: #4ec7d2;"></i>
                        Estudiantes por Grado
                    </h6>
                </div>
                <div class="card-body p-3">
                    @if($estudiantesPorGrado->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <tbody>
                              @foreach($estudiantesPorGrado as $item)
<tr>
    <td style="border: none; padding: 0.5rem 0;">
        <span style="color: #003b73; font-weight: 600; font-size: 0.85rem;">{{ $item->grado }}</span>
    </td>
    <td style="border: none; padding: 0.5rem 0; width: 50%;">
        @php 
            $porcentaje = $totalEstudiantes > 0 ? round(($item->total / $totalEstudiantes) * 100) : 0;
        @endphp
        <div class="progress" style="height: 8px; border-radius: 10px; background: rgba(78, 199, 210, 0.1);">
            <div class="progress-bar bg-gradient-custom" role="progressbar" aria-valuenow="<?php echo $porcentaje; ?>" aria-valuemin="0" aria-valuemax="100" style="border-radius: 10px; width: <?php echo $porcentaje; ?>%"></div>
        </div>
    </td>
    <td class="text-end" style="border: none; padding: 0.5rem 0;">
        <span class="badge" style="background: rgba(78, 199, 210, 0.15); color: #00508f; font-weight: 700;">{{ $item->total }}</span>
    </td>
</tr>
@endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-3 text-muted">
                            <i class="fas fa-inbox" style="font-size: 2rem; opacity: 0.3;"></i>
                            <p class="mb-0 mt-2">No hay datos disponibles</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Estudiantes por Sección -->
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm" style="border-radius: 10px;">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0" style="color: #003b73; font-weight: 700;">
                        <i class="fas fa-chart-pie" style="color: #4ec7d2;"></i>
                        Estudiantes por Sección
                    </h6>
                </div>
                <div class="card-body p-3">
                    @if($estudiantesPorSeccion->count() > 0)
                        <div class="row g-2">
                            @foreach($estudiantesPorSeccion as $item)
                            <div class="col-4">
                                <div class="text-center p-3" style="background: rgba(78, 199, 210, 0.05); border-radius: 10px; border: 2px solid rgba(78, 199, 210, 0.2);">
                                    <h3 class="mb-0" style="color: #00508f; font-weight: 800;">{{ $item->seccion }}</h3>
                                    <p class="text-muted mb-0" style="font-size: 0.75rem;">Sección</p>
                                    <h4 class="mb-0 mt-2" style="color: #003b73; font-weight: 700;">{{ $item->total }}</h4>
                                    <small class="text-muted">estudiantes</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-3 text-muted">
                            <i class="fas fa-inbox" style="font-size: 2rem; opacity: 0.3;"></i>
                            <p class="mb-0 mt-2">No hay datos disponibles</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Profesores por Especialidad -->
    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 10px;">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0" style="color: #003b73; font-weight: 700;">
                        <i class="fas fa-graduation-cap" style="color: #4ec7d2;"></i>
                        Top 5 Especialidades de Profesores
                    </h6>
                </div>
                <div class="card-body p-3">
                    @if($profesoresPorEspecialidad->count() > 0)
                        <div class="row g-2">
                            @foreach($profesoresPorEspecialidad as $item)
                            <div class="col-xl col-md-4 col-sm-6">
                                <div class="p-3 text-center" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.05) 100%); border-radius: 10px; border: 1px solid rgba(102, 126, 234, 0.2);">
                                    <i class="fas fa-book" style="font-size: 1.5rem; color: #667eea; margin-bottom: 0.5rem;"></i>
                                    <h5 class="mb-1" style="color: #003b73; font-weight: 700;">{{ $item->total }}</h5>
                                    <p class="mb-0 small text-muted" style="font-size: 0.75rem;">{{ $item->especialidad }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-3 text-muted">
                            <i class="fas fa-inbox" style="font-size: 2rem; opacity: 0.3;"></i>
                            <p class="mb-0 mt-2">No hay datos disponibles</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Últimas Actividades -->
    <div class="row g-3">
        <!-- Últimas Matrículas -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm" style="border-radius: 10px; height: 100%;">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0" style="color: #003b73; font-weight: 700;">
                        <i class="fas fa-clipboard-list" style="color: #4ec7d2;"></i>
                        Últimas Matrículas
                    </h6>
                </div>
                <div class="card-body p-0">
                    @if($ultimasMatriculas->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($ultimasMatriculas as $matricula)
                            <div class="list-group-item border-0 py-2 px-3" style="font-size: 0.85rem;">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <strong style="color: #003b73;">{{ $matricula->estudiante->nombre_completo ?? 'N/A' }}</strong>
                                        <p class="mb-0 small text-muted">{{ $matricula->codigo }}</p>
                                    </div>
                                    <span class="badge rounded-pill badge-estado-{{ $matricula->estado }}">
                                        {{ ucfirst($matricula->estado) }}
                                    </span>
                                </div>
                                <small class="text-muted" style="font-size: 0.7rem;">
                                    <i class="far fa-clock"></i>
                                    {{ $matricula->created_at->diffForHumans() }}
                                </small>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-inbox" style="font-size: 2rem; opacity: 0.3;"></i>
                            <p class="mb-0 mt-2 small">No hay matrículas recientes</p>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-white border-0 py-2 text-center">
                    <a href="{{ route('matriculas.index') }}" style="color: #00508f; text-decoration: none; font-size: 0.85rem; font-weight: 600;">
                        Ver todas las matrículas <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Estudiantes Recientes -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm" style="border-radius: 10px; height: 100%;">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0" style="color: #003b73; font-weight: 700;">
                        <i class="fas fa-user-graduate" style="color: #4ec7d2;"></i>
                        Estudiantes Recientes
                    </h6>
                </div>
                <div class="card-body p-0">
                    @if($estudiantesRecientes->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($estudiantesRecientes as $estudiante)
                            <div class="list-group-item border-0 py-2 px-3" style="font-size: 0.85rem;">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ asset('storage/' . $estudiante->foto) }}" 
                                         class="rounded-circle object-fit-cover" 
                                         style="width: 35px; height: 35px; border: 2px solid #4ec7d2;"
                                         alt="Foto">
                                    <div class="flex-grow-1">
                                        <strong style="color: #003b73; font-size: 0.85rem;">{{ $estudiante->nombre_completo }}</strong>
                                        <p class="mb-0 small text-muted">{{ $estudiante->grado }} - Sección {{ $estudiante->seccion }}</p>
                                    </div>
                                    <span class="badge" style="background: rgba(78, 199, 210, 0.15); color: #00508f; font-size: 0.7rem;">
                                        {{ $estudiante->dni }}
                                    </span>
                                </div>
                                <small class="text-muted" style="font-size: 0.7rem;">
                                    <i class="far fa-clock"></i>
                                    {{ $estudiante->created_at->diffForHumans() }}
                                </small>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-inbox" style="font-size: 2rem; opacity: 0.3;"></i>
                            <p class="mb-0 mt-2 small">No hay estudiantes recientes</p>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-white border-0 py-2 text-center">
                    <a href="{{ route('estudiantes.index') }}" style="color: #00508f; text-decoration: none; font-size: 0.85rem; font-weight: 600;">
                        Ver todos los estudiantes <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Profesores Recientes -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm" style="border-radius: 10px; height: 100%;">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0" style="color: #003b73; font-weight: 700;">
                        <i class="fas fa-chalkboard-teacher" style="color: #4ec7d2;"></i>
                        Profesores Recientes
                    </h6>
                </div>
                <div class="card-body p-0">
                    @if($profesoresRecientes->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($profesoresRecientes as $profesor)
                            <div class="list-group-item border-0 py-2 px-3" style="font-size: 0.85rem;">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div>
                                        <strong style="color: #003b73; font-size: 0.85rem;">{{ $profesor->nombre_completo }}</strong>
                                        <p class="mb-0 small" style="color: #667eea;">
                                            <i class="fas fa-book"></i>
                                            {{ $profesor->especialidad }}
                                        </p>
                                        <small class="text-muted" style="font-size: 0.7rem;">
                                            <i class="far fa-clock"></i>
                                            {{ $profesor->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    <span class="badge badge-estado-{{ $profesor->estado }}">
                                        {{ ucfirst($profesor->estado) }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-inbox" style="font-size: 2rem; opacity: 0.3;"></i>
                            <p class="mb-0 mt-2 small">No hay profesores recientes</p>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-white border-0 py-2 text-center">
                    <a href="{{ route('profesores.index') }}" style="color: #00508f; text-decoration: none; font-size: 0.85rem; font-weight: 600;">
                        Ver todos los profesores <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

@push('styles')
<style>
    /* Estilos para badges de estado */
    .badge-estado-aprobada {
        background: rgba(78, 199, 210, 0.2);
        color: #00508f;
        border: 1px solid #4ec7d2;
        font-size: 0.7rem;
        padding: 0.25rem 0.6rem;
    }

    .badge-estado-pendiente {
        background: rgba(245, 158, 11, 0.2);
        color: #92400e;
        border: 1px solid #f59e0b;
        font-size: 0.7rem;
        padding: 0.25rem 0.6rem;
    }

    .badge-estado-rechazada {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #ef4444;
        font-size: 0.7rem;
        padding: 0.25rem 0.6rem;
    }

    .badge-estado-activo {
        background: rgba(78, 199, 210, 0.2);
        color: #00508f;
        border: 1px solid #4ec7d2;
        font-size: 0.7rem;
        padding: 0.25rem 0.6rem;
    }

    .badge-estado-inactivo {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #ef4444;
        font-size: 0.7rem;
        padding: 0.25rem 0.6rem;
    }

    /* Animaciones y efectos */
    .stat-card:hover {
        transform: translateY(-5px);
        transition: all 0.3s ease;
    }

    .icon-box {
        transition: all 0.3s ease;
    }

    .card:hover .icon-box {
        transform: scale(1.1);
    }

    .list-group-item {
        transition: all 0.2s ease;
    }

    .list-group-item:hover {
        background-color: rgba(191, 217, 234, 0.08);
    }

    .progress-bar {
        transition: width 0.6s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stat-card, .card {
        animation: fadeIn 0.5s ease;
    }
</style>
@endpush
@endsection