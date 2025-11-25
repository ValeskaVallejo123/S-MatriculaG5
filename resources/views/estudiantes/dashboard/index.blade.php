@extends('layouts.app')

@section('title', 'Dashboard Estudiante')
@section('page-title', 'Mi Panel Estudiantil')

@section('content')
<div class="container" style="max-width: 1200px;">
    
    <!-- Tarjeta de Bienvenida -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; background: linear-gradient(135deg, rgba(78, 199, 210, 0.15) 0%, rgba(0, 80, 143, 0.1) 100%);">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-auto">
                    <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 16px; display: flex; align-items: center; justify-content: center; border: 3px solid #4ec7d2;">
                        <i class="fas fa-user-graduate" style="font-size: 2rem; color: white;"></i>
                    </div>
                </div>
                <div class="col">
                    <h2 class="mb-2 fw-bold" style="color: #003b73; font-size: 1.5rem;">
                        Hola, {{ auth()->user()->name }}
                    </h2>
                    <p class="text-muted mb-0">Bienvenido a tu portal estudiantil</p>
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
                            <i class="fas fa-book fa-2x" style="color: #4ec7d2;"></i>
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
            <div class="card border-0 shadow-sm h-100" style="border-radius: 10px; border-left: 4px solid #00508f;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-clipboard-check fa-2x" style="color: #00508f;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1 small">Calificaciones</h6>
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
                            <i class="fas fa-calendar-alt fa-2x" style="color: #003b73;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1 small">Asistencia</h6>
                            <h3 class="mb-0 fw-bold" style="color: #003b73;">-</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mensaje informativo -->
    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body text-center py-5">
            <i class="fas fa-info-circle fa-3x mb-3" style="color: #4ec7d2;"></i>
            <h5 style="color: #003b73;">Portal en Construcción</h5>
            <p class="text-muted mb-0">Pronto podrás ver tus calificaciones, horarios y más información.</p>
        </div>
    </div>

</div>
@endsection