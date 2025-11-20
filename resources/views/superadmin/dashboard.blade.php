@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Panel de Control - Super Administrador')

@section('topbar-actions')
    <div class="d-flex align-items-center gap-2">
        <span class="text-muted small">{{ now()->format('d/m/Y') }}</span>
        @if(auth()->user()->rol)
        <div class="vr"></div>
        <span class="badge" style="background: rgba(78, 199, 210, 0.2); color: #00508f; padding: 0.4rem 0.8rem; font-weight: 600; border: 1px solid #4ec7d2;">
            <i class="fas fa-user-shield"></i> {{ auth()->user()->rol->nombre }}
        </span>
        @else
        <div class="vr"></div>
        <span class="badge" style="background: rgba(239, 68, 68, 0.2); color: #991b1b; padding: 0.4rem 0.8rem; font-weight: 600; border: 1px solid #ef4444;">
            <i class="fas fa-exclamation-triangle"></i> Sin rol asignado
        </span>
        @endif
    </div>
@endsection

@section('content')
<div class="container" style="max-width: 1400px;">

    <!-- Mensaje de bienvenida -->
    @if(session('success'))
    <div class="alert alert-dismissible fade show mb-3" style="background: rgba(78, 199, 210, 0.1); border: 1px solid #4ec7d2; border-radius: 10px; color: #003b73;">
        <i class="fas fa-check-circle" style="color: #4ec7d2;"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Tarjeta de Bienvenida -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%);">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="text-white mb-2">
                        <i class="fas fa-sun me-2" style="color: #ffd700;"></i>
                        ¡Bienvenido de nuevo, {{ auth()->user()->name }}!
                    </h3>
                    <p class="text-white opacity-75 mb-0">
                        <i class="fas fa-calendar-alt me-2"></i>
                        {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="text-white">
                        <i class="fas fa-clock me-2"></i>
                        <span id="currentTime" style="font-size: 1.2rem; font-weight: 600;"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas Principales -->
    <div class="row g-3 mb-4">
        <!-- Total Estudiantes -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #4ec7d2 !important;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0" style="width: 50px; height: 50px; background: rgba(78, 199, 210, 0.15); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user-graduate" style="color: #4ec7d2; font-size: 1.3rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px; font-weight: 600;">Estudiantes</div>
                            <h3 class="mb-0" style="color: #003b73; font-weight: 700;">{{ \App\Models\Estudiante::count() }}</h3>
                        </div>
                    </div>
                    <div class="mt-2 pt-2" style="border-top: 1px solid #f1f5f9;">
                        <small class="text-muted">
                            <i class="fas fa-check-circle" style="color: #4ec7d2;"></i>
                            <span class="fw-semibold" style="color: #00508f;">{{ \App\Models\Estudiante::where('estado', 'activo')->count() }}</span> activos
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Profesores -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #00508f !important;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0" style="width: 50px; height: 50px; background: rgba(0, 80, 143, 0.15); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-chalkboard-teacher" style="color: #00508f; font-size: 1.3rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px; font-weight: 600;">Profesores</div>
                            <h3 class="mb-0" style="color: #003b73; font-weight: 700;">{{ \App\Models\Profesor::count() }}</h3>
                        </div>
                    </div>
                    <div class="mt-2 pt-2" style="border-top: 1px solid #f1f5f9;">
                        <small class="text-muted">
                            <i class="fas fa-check-circle" style="color: #00508f;"></i>
                            <span class="fw-semibold" style="color: #00508f;">{{ \App\Models\Profesor::where('estado', 'activo')->count() }}</span> activos
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Matrículas -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #fbbf24 !important;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0" style="width: 50px; height: 50px; background: rgba(251, 191, 36, 0.15); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-file-alt" style="color: #fbbf24; font-size: 1.3rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px; font-weight: 600;">Matrículas</div>
                            <h3 class="mb-0" style="color: #003b73; font-weight: 700;">{{ \App\Models\Matricula::count() }}</h3>
                        </div>
                    </div>
                    <div class="mt-2 pt-2" style="border-top: 1px solid #f1f5f9;">
                        <small class="text-muted">
                            <i class="fas fa-clock" style="color: #fbbf24;"></i>
                            <span class="fw-semibold" style="color: #00508f;">{{ \App\Models\Matricula::where('estado', 'pendiente')->count() }}</span> pendientes
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Usuarios -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #ef4444 !important;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0" style="width: 50px; height: 50px; background: rgba(239, 68, 68, 0.15); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-users" style="color: #ef4444; font-size: 1.3rem;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px; font-weight: 600;">Usuarios</div>
                            <h3 class="mb-0" style="color: #003b73; font-weight: 700;">{{ \App\Models\User::count() }}</h3>
                        </div>
                    </div>
                    <div class="mt-2 pt-2" style="border-top: 1px solid #f1f5f9;">
                        <small class="text-muted">
                            <i class="fas fa-user-shield" style="color: #ef4444;"></i>
                            <span class="fw-semibold" style="color: #00508f;">{{ \App\Models\User::whereHas('rol')->count() }}</span> con roles
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Acciones Rápidas -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
        <div class="card-header bg-white py-3" style="border-bottom: 2px solid #f1f5f9; border-radius: 12px 12px 0 0;">
            <h5 class="mb-0" style="color: #003b73; font-weight: 700;">
                <i class="fas fa-bolt me-2" style="color: #4ec7d2;"></i>
                Acciones Rápidas
            </h5>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <!-- Gestión de Estudiantes -->
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 h-100 shadow-sm" style="border-radius: 10px; transition: all 0.3s ease; border: 2px solid transparent;"
                         onmouseover="this.style.borderColor='#4ec7d2'; this.style.transform='translateY(-4px)'"
                         onmouseout="this.style.borderColor='transparent'; this.style.transform='translateY(0)'">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center mb-3">
                                <div style="width: 45px; height: 45px; background: rgba(78, 199, 210, 0.15); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-user-graduate" style="color: #4ec7d2; font-size: 1.2rem;"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0" style="color: #003b73; font-weight: 700;">Estudiantes</h6>
                                    <small class="text-muted">Gestión completa</small>
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <a href="{{ route('estudiantes.index') }}" class="btn btn-sm" style="background: rgba(78, 199, 210, 0.1); color: #00508f; border: 1.5px solid #4ec7d2; border-radius: 6px; font-weight: 600; padding: 0.5rem;">
                                    <i class="fas fa-list me-1"></i> Ver Todos
                                </a>
                                <a href="{{ route('estudiantes.create') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 6px; font-weight: 600; padding: 0.5rem;">
                                    <i class="fas fa-plus me-1"></i> Nuevo Estudiante
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gestión de Profesores -->
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 h-100 shadow-sm" style="border-radius: 10px; transition: all 0.3s ease; border: 2px solid transparent;"
                         onmouseover="this.style.borderColor='#00508f'; this.style.transform='translateY(-4px)'"
                         onmouseout="this.style.borderColor='transparent'; this.style.transform='translateY(0)'">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center mb-3">
                                <div style="width: 45px; height: 45px; background: rgba(0, 80, 143, 0.15); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-chalkboard-teacher" style="color: #00508f; font-size: 1.2rem;"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0" style="color: #003b73; font-weight: 700;">Profesores</h6>
                                    <small class="text-muted">Gestión de docentes</small>
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <a href="{{ route('profesores.index') }}" class="btn btn-sm" style="background: rgba(0, 80, 143, 0.1); color: #00508f; border: 1.5px solid #00508f; border-radius: 6px; font-weight: 600; padding: 0.5rem;">
                                    <i class="fas fa-list me-1"></i> Ver Todos
                                </a>
                                <a href="{{ route('profesores.create') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #003b73 0%, #00508f 100%); color: white; border-radius: 6px; font-weight: 600; padding: 0.5rem;">
                                    <i class="fas fa-plus me-1"></i> Nuevo Profesor
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gestión de Padres -->
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 h-100 shadow-sm" style="border-radius: 10px; transition: all 0.3s ease; border: 2px solid transparent;"
                         onmouseover="this.style.borderColor='#6366f1'; this.style.transform='translateY(-4px)'"
                         onmouseout="this.style.borderColor='transparent'; this.style.transform='translateY(0)'">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center mb-3">
                                <div style="width: 45px; height: 45px; background: rgba(99, 102, 241, 0.15); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-users" style="color: #6366f1; font-size: 1.2rem;"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0" style="color: #003b73; font-weight: 700;">Padres/Tutores</h6>
                                    <small class="text-muted">Gestión de padres</small>
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <a href="{{ route('padres.index') }}" class="btn btn-sm" style="background: rgba(99, 102, 241, 0.1); color: #4338ca; border: 1.5px solid #6366f1; border-radius: 6px; font-weight: 600; padding: 0.5rem;">
                                    <i class="fas fa-list me-1"></i> Ver Todos
                                </a>
                                <a href="{{ route('padres.create') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%); color: white; border-radius: 6px; font-weight: 600; padding: 0.5rem;">
                                    <i class="fas fa-plus me-1"></i> Nuevo Padre/Tutor
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gestión de Matrículas -->
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 h-100 shadow-sm" style="border-radius: 10px; transition: all 0.3s ease; border: 2px solid transparent;"
                         onmouseover="this.style.borderColor='#fbbf24'; this.style.transform='translateY(-4px)'"
                         onmouseout="this.style.borderColor='transparent'; this.style.transform='translateY(0)'">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center mb-3">
                                <div style="width: 45px; height: 45px; background: rgba(251, 191, 36, 0.15); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-file-alt" style="color: #fbbf24; font-size: 1.2rem;"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0" style="color: #003b73; font-weight: 700;">Matrículas</h6>
                                    <small class="text-muted">Gestión de inscripciones</small>
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <a href="{{ route('matriculas.index') }}" class="btn btn-sm" style="background: rgba(251, 191, 36, 0.1); color: #92400e; border: 1.5px solid #fbbf24; border-radius: 6px; font-weight: 600; padding: 0.5rem;">
                                    <i class="fas fa-list me-1"></i> Ver Todas
                                </a>
                                <a href="{{ route('matriculas.create') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); color: white; border-radius: 6px; font-weight: 600; padding: 0.5rem;">
                                    <i class="fas fa-plus me-1"></i> Nueva Matrícula
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gestión Académica -->
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 h-100 shadow-sm" style="border-radius: 10px; transition: all 0.3s ease; border: 2px solid transparent;"
                         onmouseover="this.style.borderColor='#10b981'; this.style.transform='translateY(-4px)'"
                         onmouseout="this.style.borderColor='transparent'; this.style.transform='translateY(0)'">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center mb-3">
                                <div style="width: 45px; height: 45px; background: rgba(16, 185, 129, 0.15); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-graduation-cap" style="color: #10b981; font-size: 1.2rem;"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0" style="color: #003b73; font-weight: 700;">Académico</h6>
                                    <small class="text-muted">Grados y materias</small>
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <a href="{{ route('grados.index') }}" class="btn btn-sm" style="background: rgba(16, 185, 129, 0.1); color: #065f46; border: 1.5px solid #10b981; border-radius: 6px; font-weight: 600; padding: 0.5rem;">
                                    <i class="fas fa-list me-1"></i> Grados
                                </a>
                                <a href="{{ route('materias.index') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border-radius: 6px; font-weight: 600; padding: 0.5rem;">
                                    <i class="fas fa-book me-1"></i> Materias
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Administración del Sistema -->
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 h-100 shadow-sm" style="border-radius: 10px; transition: all 0.3s ease; border: 2px solid transparent;"
                         onmouseover="this.style.borderColor='#ef4444'; this.style.transform='translateY(-4px)'"
                         onmouseout="this.style.borderColor='transparent'; this.style.transform='translateY(0)'">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center mb-3">
                                <div style="width: 45px; height: 45px; background: rgba(239, 68, 68, 0.15); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-user-shield" style="color: #ef4444; font-size: 1.2rem;"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0" style="color: #003b73; font-weight: 700;">Administración</h6>
                                    <small class="text-muted">Control del sistema</small>
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <a href="{{ route('superadmin.administradores.index') }}" class="btn btn-sm" style="background: rgba(239, 68, 68, 0.1); color: #991b1b; border: 1.5px solid #ef4444; border-radius: 6px; font-weight: 600; padding: 0.5rem;">
                                    <i class="fas fa-users-cog me-1"></i> Administradores
                                </a>
                                <a href="{{ route('admins.index') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border-radius: 6px; font-weight: 600; padding: 0.5rem;">
                                    <i class="fas fa-user-tie me-1"></i> Gestión de Admins
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información del Sistema (Solo en modo Debug) -->
    @if(config('app.debug') && auth()->user()->rol)
    <div class="card border-0 shadow-sm" style="border-radius: 12px; border: 2px solid #f1f5f9;">
        <div class="card-header py-3" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-radius: 12px 12px 0 0;">
            <h6 class="mb-0" style="color: #003b73; font-weight: 700;">
                <i class="fas fa-bug me-2" style="color: #ef4444;"></i>
                Modo Debug - Información del Sistema
            </h6>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <h6 class="text-uppercase small fw-bold mb-3" style="color: #00508f; letter-spacing: 0.5px;">Información del Usuario</h6>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td class="text-muted" style="width: 120px;">ID:</td>
                            <td class="fw-semibold" style="color: #003b73;">{{ auth()->user()->id }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Nombre:</td>
                            <td class="fw-semibold" style="color: #003b73;">{{ auth()->user()->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Email:</td>
                            <td class="fw-semibold" style="color: #003b73;">{{ auth()->user()->email }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">ID Rol:</td>
                            <td class="fw-semibold" style="color: #003b73;">{{ auth()->user()->id_rol }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Rol:</td>
                            <td>
                                <span class="badge" style="background: rgba(78, 199, 210, 0.2); color: #00508f; padding: 0.3rem 0.7rem; font-weight: 600; border: 1px solid #4ec7d2;">
                                    {{ auth()->user()->rol->nombre }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6 class="text-uppercase small fw-bold mb-3" style="color: #00508f; letter-spacing: 0.5px;">
                        Permisos Asignados ({{ auth()->user()->obtenerPermisos()->count() }})
                    </h6>
                    <div class="row g-2">
                        @foreach(auth()->user()->obtenerPermisos() as $permiso)
                        <div class="col-12">
                            <span class="badge w-100 text-start" style="background: rgba(16, 185, 129, 0.1); color: #065f46; padding: 0.4rem 0.7rem; font-weight: 500; border: 1px solid #10b981; border-radius: 6px; font-size: 0.75rem;">
                                <i class="fas fa-check-circle me-1" style="color: #10b981;"></i>
                                {{ $permiso->nombre }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>

@push('styles')
<style>
    .card {
        transition: all 0.3s ease;
    }
    
    .card:hover {
        box-shadow: 0 8px 16px rgba(0, 80, 143, 0.1) !important;
    }
</style>
@endpush

@push('scripts')
<script>
// Reloj en tiempo real
function updateTime() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    document.getElementById('currentTime').textContent = `${hours}:${minutes}:${seconds}`;
}

// Actualizar cada segundo
setInterval(updateTime, 1000);
updateTime(); // Llamar inmediatamente
</script>
@endpush
@endsection