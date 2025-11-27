@extends('layouts.app')

@section('title', 'Dashboard Profesor')
@section('page-title', 'Dashboard del Profesor')

@section('content')
<div class="container" style="max-width: 1200px;">

    <!-- Tarjeta de Bienvenida -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; background: linear-gradient(135deg, rgba(78, 199, 210, 0.15) 0%, rgba(0, 80, 143, 0.1) 100%);">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-auto">
                    <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 16px; display: flex; align-items: center; justify-content: center; border: 3px solid #4ec7d2;">
                        <i class="fas fa-chalkboard-teacher" style="font-size: 2rem; color: white;"></i>
                    </div>
                </div>
                <div class="col">
                    <h2 class="mb-2 fw-bold" style="color: #003b73; font-size: 1.5rem;">
                        Bienvenido, {{ auth()->user()->name }}
                    </h2>
                    <p class="text-muted mb-0">Panel de Control del Profesor</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjetas de Estadísticas -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 10px; border-left: 4px solid #4ec7d2;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-users fa-2x" style="color: #4ec7d2;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1 small">Mis Estudiantes</h6>
                            <h3 class="mb-0 fw-bold" style="color: #003b73;">-</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 10px; border-left: 4px solid #00508f;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-book fa-2x" style="color: #00508f;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1 small">Mis Cursos</h6>
                            <h3 class="mb-0 fw-bold" style="color: #003b73;">-</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 10px; border-left: 4px solid #003b73;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-clipboard-list fa-2x" style="color: #003b73;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1 small">Calificaciones Pendientes</h6>
                            <h3 class="mb-0 fw-bold" style="color: #003b73;">-</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accesos Rápidos -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
        <div class="card-body p-4">
            <h5 class="mb-4 fw-bold" style="color: #003b73;">
                <i class="fas fa-rocket me-2" style="color: #4ec7d2;"></i>
                Accesos Rápidos
            </h5>

            <div class="row g-3">
                <div class="col-md-3">
                    <a href="#" class="text-decoration-none">
                        <div class="card border-0 h-100" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 10px;">
                            <div class="card-body text-center p-3">
                                <i class="fas fa-users" style="font-size: 2rem; color: white; margin-bottom: 0.5rem;"></i>
                                <h6 class="text-white fw-bold mb-0 small">Mis Estudiantes</h6>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3">
                    <a href="#" class="text-decoration-none">
                        <div class="card border-0 h-100" style="background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 10px;">
                            <div class="card-body text-center p-3">
                                <i class="fas fa-book" style="font-size: 2rem; color: white; margin-bottom: 0.5rem;"></i>
                                <h6 class="text-white fw-bold mb-0 small">Mis Cursos</h6>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3">
                    <a href="{{ route('registrarcalificaciones.create') }}" class="text-decoration-none" aria-label="Registrar calificaciones">
                        <div class="card border-0 h-100" style="background: linear-gradient(135deg, #003b73 0%, #00508f 100%); border-radius: 10px;">
                            <div class="card-body text-center p-3">
                                <i class="fas fa-clipboard-check" style="font-size: 2rem; color: white; margin-bottom: 0.5rem;"></i>
                                <h6 class="text-white fw-bold mb-0 small">Calificaciones</h6>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3">
                    <a href="{{route('horarios.index')}}" class="text-decoration-none">
                        <div class="card border-0 h-100" style="background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%); border-radius: 10px;">
                            <div class="card-body text-center p-3">
                                <i class="fas fa-calendar-alt" style="font-size: 2rem; color: white; margin-bottom: 0.5rem;"></i>
                                <h6 class="text-white fw-bold mb-0 small">Horarios</h6>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Información adicional -->
    <div class="row g-3">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3" style="color: #003b73;">
                        <i class="fas fa-bullhorn me-2" style="color: #4ec7d2;"></i>
                        Anuncios Recientes
                    </h6>
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-2x mb-2" style="color: #4ec7d2; opacity: 0.5;"></i>
                        <p class="text-muted small mb-0">No hay anuncios recientes</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3" style="color: #003b73;">
                        <i class="fas fa-calendar-check me-2" style="color: #4ec7d2;"></i>
                        Próximas Actividades
                    </h6>
                    <div class="text-center py-4">
                        <i class="fas fa-calendar fa-2x mb-2" style="color: #4ec7d2; opacity: 0.5;"></i>
                        <p class="text-muted small mb-0">No hay actividades programadas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mensaje informativo -->
    <div class="card border-0 shadow-sm mt-4" style="border-radius: 12px; border-left: 4px solid #4ec7d2;">
        <div class="card-body p-3">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle fa-2x me-3" style="color: #4ec7d2;"></i>
                <div>
                    <h6 class="mb-1 fw-bold" style="color: #003b73;">Portal en Construcción</h6>
                    <p class="text-muted small mb-0">Las funcionalidades completas del portal de profesores estarán disponibles próximamente.</p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
