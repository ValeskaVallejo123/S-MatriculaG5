@extends('layouts.app')

@section('title', 'Dashboard Administrador')
@section('page-title', 'Dashboard del Administrador')

@section('content')
<div class="container" style="max-width: 1400px;">
    
    <!-- Tarjeta de Bienvenida -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; background: linear-gradient(135deg, rgba(78, 199, 210, 0.15) 0%, rgba(0, 80, 143, 0.1) 100%);">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-auto">
                    <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 16px; display: flex; align-items: center; justify-content: center; border: 3px solid #4ec7d2;">
                        <i class="fas fa-user-shield" style="font-size: 2rem; color: white;"></i>
                    </div>
                </div>
                <div class="col">
                    <h2 class="mb-2 fw-bold" style="color: #003b73; font-size: 1.5rem;">
                        Bienvenido, {{ auth()->user()->name }}
                    </h2>
                    <p class="text-muted mb-0">Panel de Control del Administrador</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 10px; border-left: 4px solid #4ec7d2;">
                <div class="card-body">
                    <h6 class="text-muted small mb-2">ESTUDIANTES</h6>
                    <h3 class="mb-0 fw-bold" style="color: #003b73;">{{ $totalEstudiantes ?? 0 }}</h3>
                    <p class="text-muted small mb-0 mt-1">{{ $estudiantesActivos ?? 0 }} activos</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 10px; border-left: 4px solid #00508f;">
                <div class="card-body">
                    <h6 class="text-muted small mb-2">PROFESORES</h6>
                    <h3 class="mb-0 fw-bold" style="color: #003b73;">{{ $totalProfesores ?? 0 }}</h3>
                    <p class="text-muted small mb-0 mt-1">{{ $profesoresActivos ?? 0 }} activos</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 10px; border-left: 4px solid #003b73;">
                <div class="card-body">
                    <h6 class="text-muted small mb-2">MATRÍCULAS</h6>
                    <h3 class="mb-0 fw-bold" style="color: #003b73;">{{ $totalMatriculas ?? 0 }}</h3>
                    <p class="text-muted small mb-0 mt-1">{{ $matriculasPendientes ?? 0 }} pendientes</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 10px; border-left: 4px solid #fbbf24;">
                <div class="card-body">
                    <h6 class="text-muted small mb-2">USUARIOS</h6>
                    <h3 class="mb-0 fw-bold" style="color: #003b73;">{{ $totalUsuarios ?? 0 }}</h3>
                    <p class="text-muted small mb-0 mt-1">{{ $totalAdministradores ?? 0 }} admins</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Accesos Rápidos -->
    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body p-4">
            <h5 class="mb-4 fw-bold" style="color: #003b73;">
                <i class="fas fa-rocket me-2" style="color: #4ec7d2;"></i>
                Accesos Rápidos
            </h5>

            <div class="row g-3">
                <div class="col-md-3">
                    <a href="{{ route('estudiantes.index') }}" class="text-decoration-none">
                        <div class="card border-0 h-100" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 10px;">
                            <div class="card-body text-center p-3">
                                <i class="fas fa-user-graduate" style="font-size: 2rem; color: white; margin-bottom: 0.5rem;"></i>
                                <h6 class="text-white fw-bold mb-0 small">Estudiantes</h6>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3">
                    <a href="{{ route('profesores.index') }}" class="text-decoration-none">
                        <div class="card border-0 h-100" style="background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 10px;">
                            <div class="card-body text-center p-3">
                                <i class="fas fa-chalkboard-teacher" style="font-size: 2rem; color: white; margin-bottom: 0.5rem;"></i>
                                <h6 class="text-white fw-bold mb-0 small">Profesores</h6>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3">
                    <a href="{{ route('matriculas.index') }}" class="text-decoration-none">
                        <div class="card border-0 h-100" style="background: linear-gradient(135deg, #003b73 0%, #00508f 100%); border-radius: 10px;">
                            <div class="card-body text-center p-3">
                                <i class="fas fa-clipboard-list" style="font-size: 2rem; color: white; margin-bottom: 0.5rem;"></i>
                                <h6 class="text-white fw-bold mb-0 small">Matrículas</h6>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3">
                    <a href="{{ route('grados.index') }}" class="text-decoration-none">
                        <div class="card border-0 h-100" style="background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%); border-radius: 10px;">
                            <div class="card-body text-center p-3">
                                <i class="fas fa-layer-group" style="font-size: 2rem; color: white; margin-bottom: 0.5rem;"></i>
                                <h6 class="text-white fw-bold mb-0 small">Grados</h6>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection