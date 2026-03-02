@extends('layouts.app')

@section('title', 'Dashboard Padre')

@section('content')
<div class="container py-4">
    
    <!-- Tarjeta de Bienvenida -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; background: linear-gradient(135deg, rgba(78, 199, 210, 0.15) 0%, rgba(0, 80, 143, 0.1) 100%);">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-auto">
                    <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 16px; display: flex; align-items: center; justify-content: center; border: 3px solid #4ec7d2;">
                        <i class="fas fa-user-friends" style="font-size: 2rem; color: white;"></i>
                    </div>
                </div>
                <div class="col">
                    <h2 class="mb-2 fw-bold" style="color: #003b73; font-size: 1.5rem;">
                        Bienvenido, {{ Auth::user()->name }}
                    </h2>
                    <p class="text-muted mb-0">
                        <i class="fas fa-envelope me-2"></i>{{ Auth::user()->email }}
                    </p>
                    <small class="text-muted">
                        <i class="fas fa-user-tag me-1"></i>Padre/Tutor
                    </small>
                </div>
            </div>
        </div>
    </div>

   

    <!-- Tarjetas de información -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 10px; border-left: 4px solid #4ec7d2;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-child fa-2x" style="color: #4ec7d2;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1 small">Mis Hijos</h6>
                            <h3 class="mb-0 fw-bold" style="color: #003b73;">0</h3>
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
                            <i class="fas fa-graduation-cap fa-2x" style="color: #00508f;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1 small">Matrículas Activas</h6>
                            <h3 class="mb-0 fw-bold" style="color: #003b73;">0</h3>
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
                            <i class="fas fa-bell fa-2x" style="color: #003b73;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1 small">Notificaciones</h6>
                            <h3 class="mb-0 fw-bold" style="color: #003b73;">0</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mensaje informativo -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
        <div class="card-body text-center py-5">
            <i class="fas fa-info-circle fa-3x mb-3" style="color: #4ec7d2;"></i>
            <h5 style="color: #003b73;">Portal en Construcción</h5>
            <p class="text-muted mb-3">
                Su cuenta ha sido activada correctamente. Pronto podrá ver las calificaciones, 
                asistencia y más información de sus hijos.
            </p>
            <p class="text-muted small">
                <strong>Estado de su cuenta:</strong> 
                <span class="badge bg-success">Activa</span>
            </p>
        </div>
    </div>

    <!-- Accesos Rápidos -->
    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0 fw-bold" style="color: #003b73;">
                <i class="fas fa-rocket me-2"></i>Accesos Rápidos
            </h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100 text-center" style="border-radius: 10px; opacity: 0.6;">
                        <div class="card-body py-4">
                            <i class="fas fa-book-open fa-2x mb-3" style="color: #4ec7d2;"></i>
                            <h6 class="mb-0" style="color: #003b73;">Tareas</h6>
                            <small class="text-muted">(Próximamente)</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100 text-center" style="border-radius: 10px; opacity: 0.6;">
                        <div class="card-body py-4">
                            <i class="fas fa-calendar-alt fa-2x mb-3" style="color: #00508f;"></i>
                            <h6 class="mb-0" style="color: #003b73;">Horarios</h6>
                            <small class="text-muted">(Próximamente)</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100 text-center" style="border-radius: 10px; opacity: 0.6;">
                        <div class="card-body py-4">
                            <i class="fas fa-chart-line fa-2x mb-3" style="color: #003b73;"></i>
                            <h6 class="mb-0" style="color: #003b73;">Calificaciones</h6>
                            <small class="text-muted">(Próximamente)</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100 text-center" style="border-radius: 10px; opacity: 0.6;">
                        <div class="card-body py-4">
                            <i class="fas fa-file-download fa-2x mb-3" style="color: #4ec7d2;"></i>
                            <h6 class="mb-0" style="color: #003b73;">Reportes</h6>
                            <small class="text-muted">(Próximamente)</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection