@extends('layouts.admin')

@section('title', 'Dashboard Super Admin')
@section('page-title', 'Panel de Control')

@push('styles')
<style>
    /* Animaciones personalizadas */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
    }

    /* Tarjetas de estadísticas mejoradas */
    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        border: 1px solid #f0f0f0;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--card-color), transparent);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }

    .stat-card.primary { --card-color: #667eea; }
    .stat-card.danger { --card-color: #ef4444; }
    .stat-card.success { --card-color: #10b981; }
    .stat-card.warning { --card-color: #f59e0b; }
    .stat-card.info { --card-color: #3b82f6; }
    .stat-card.purple { --card-color: #8b5cf6; }

    .stat-icon {
        width: 70px;
        height: 70px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        transition: all 0.3s ease;
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.1) rotate(5deg);
    }

    /* Tarjetas de acceso rápido */
    .quick-access-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        border: 1px solid #f0f0f0;
        height: 100%;
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .quick-access-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        text-decoration: none;
    }

    .quick-access-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-bottom: 15px;
    }

    .quick-access-card h5 {
        font-weight: 700;
        margin-bottom: 8px;
        color: #1f2937;
    }

    .quick-access-card p {
        color: #6b7280;
        font-size: 0.9rem;
        margin-bottom: 15px;
    }

    .quick-access-buttons {
        display: flex;
        gap: 10px;
    }

    .quick-access-buttons .btn {
        flex: 1;
        border-radius: 10px;
        padding: 10px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    /* Tabla mejorada */
    .custom-table {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }

    .custom-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .custom-table thead th {
        border: none;
        padding: 18px 20px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .custom-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f0f0f0;
    }

    .custom-table tbody tr:hover {
        background: #f8f9ff;
        transform: scale(1.01);
    }

    /* Badges mejorados */
    .badge-custom {
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
        letter-spacing: 0.3px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    /* Actividad reciente */
    .activity-item {
        padding: 15px;
        border-left: 3px solid #667eea;
        background: #f8f9ff;
        border-radius: 0 10px 10px 0;
        margin-bottom: 12px;
        transition: all 0.3s ease;
    }

    .activity-item:hover {
        background: white;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        transform: translateX(5px);
    }
</style>
@endpush

@section('content')

<!-- Mensaje de bienvenida -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-4 fade-in-up" style="animation-delay: 0.1s;">
    <i class="fas fa-check-circle me-2"></i> 
    <strong>{{ session('success') }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Header de Bienvenida -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm fade-in-up" style="animation-delay: 0.1s; border-radius: 15px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body text-white p-4">
                <h2 class="mb-2 fw-bold">
                    👋 ¡Bienvenido, {{ Auth::user()->name }}!
                </h2>
                <p class="mb-0 opacity-75">Panel de Administración - Sistema de Matrículas Gabriela Mistral</p>
            </div>
        </div>
    </div>
</div>

<!-- Estadísticas principales -->
<div class="row g-4 mb-4">
    <!-- Total Materias -->
    <div class="col-lg-3 col-md-6 fade-in-up" style="animation-delay: 0.1s;">
        <div class="stat-card primary">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-2 fw-semibold">Total Materias</p>
                    <h2 class="mb-0 fw-bold">{{ \App\Models\Materia::count() }}</h2>
                    <small class="text-success">
                        <i class="fas fa-arrow-up"></i> Activas: {{ \App\Models\Materia::where('activo', true)->count() }}
                    </small>
                </div>
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="fas fa-book"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Grados -->
    <div class="col-lg-3 col-md-6 fade-in-up" style="animation-delay: 0.2s;">
        <div class="stat-card success">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-2 fw-semibold">Total Grados</p>
                    <h2 class="mb-0 fw-bold">{{ \App\Models\Grado::count() }}</h2>
                    <small class="text-success">
                        <i class="fas fa-check-circle"></i> Activos: {{ \App\Models\Grado::where('activo', true)->count() }}
                    </small>
                </div>
                <div class="stat-icon bg-success bg-opacity-10 text-success">
                    <i class="fas fa-school"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Profesores -->
    <div class="col-lg-3 col-md-6 fade-in-up" style="animation-delay: 0.3s;">
        <div class="stat-card warning">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-2 fw-semibold">Profesores</p>
                    <h2 class="mb-0 fw-bold">{{ \App\Models\User::where('role', 'profesor')->count() }}</h2>
                    <small class="text-muted">
                        <i class="fas fa-chalkboard-teacher"></i> Docentes activos
                    </small>
                </div>
                <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                    <i class="fas fa-user-tie"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Estudiantes -->
    <div class="col-lg-3 col-md-6 fade-in-up" style="animation-delay: 0.4s;">
        <div class="stat-card info">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-2 fw-semibold">Estudiantes</p>
                    <h2 class="mb-0 fw-bold">{{ \App\Models\User::where('role', 'estudiante')->count() }}</h2>
                    <small class="text-muted">
                        <i class="fas fa-graduation-cap"></i> Matriculados
                    </small>
                </div>
                <div class="stat-icon bg-info bg-opacity-10 text-info">
                    <i class="fas fa-user-graduate"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sección de Accesos Rápidos -->
<div class="row mb-4">
    <div class="col-12">
        <h4 class="fw-bold mb-3 fade-in-up" style="animation-delay: 0.5s;">
            <i class="fas fa-bolt text-warning"></i> Accesos Rápidos
        </h4>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Gestión de Materias -->
    <div class="col-lg-4 col-md-6 fade-in-up" style="animation-delay: 0.6s;">
        <div class="quick-access-card">
            <div class="quick-access-icon bg-primary bg-opacity-10 text-primary">
                <i class="fas fa-book-open"></i>
            </div>
            <h5>Gestión de Materias</h5>
            <p class="mb-3">Administra las materias y asignaturas del centro educativo para primaria y secundaria.</p>
            <div class="quick-access-buttons">
                <a href="{{ route('materias.index') }}" class="btn btn-primary">
                    <i class="fas fa-list"></i> Ver Todas
                </a>
                <a href="{{ route('materias.create') }}" class="btn btn-outline-primary">
                    <i class="fas fa-plus"></i> Crear
                </a>
            </div>
        </div>
    </div>

    <!-- Gestión de Grados -->
    <div class="col-lg-4 col-md-6 fade-in-up" style="animation-delay: 0.7s;">
        <div class="quick-access-card">
            <div class="quick-access-icon bg-success bg-opacity-10 text-success">
                <i class="fas fa-school"></i>
            </div>
            <h5>Gestión de Grados</h5>
            <p class="mb-3">Administra los grados escolares (1° a 9°) y asigna materias a cada sección.</p>
            <div class="quick-access-buttons">
                <a href="{{ route('grados.index') }}" class="btn btn-success">
                    <i class="fas fa-th-large"></i> Ver Todos
                </a>
                <a href="{{ route('grados.create') }}" class="btn btn-outline-success">
                    <i class="fas fa-plus"></i> Crear
                </a>
            </div>
        </div>
    </div>

    <!-- Asignación de Materias -->
    <div class="col-lg-4 col-md-6 fade-in-up" style="animation-delay: 0.8s;">
        <div class="quick-access-card">
            <div class="quick-access-icon bg-info bg-opacity-10 text-info">
                <i class="fas fa-link"></i>
            </div>
            <h5>Asignación de Materias</h5>
            <p class="mb-3">Asigna materias a grados, define profesores y establece horarios semanales.</p>
            <div class="quick-access-buttons">
                <a href="{{ route('grados.index') }}" class="btn btn-info text-white">
                    <i class="fas fa-tasks"></i> Gestionar
                </a>
            </div>
        </div>
    </div>

    <!-- Profesores -->
    <div class="col-lg-4 col-md-6 fade-in-up" style="animation-delay: 0.9s;">
        <div class="quick-access-card">
            <div class="quick-access-icon bg-warning bg-opacity-10 text-warning">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <h5>Gestión de Profesores</h5>
            <p class="mb-3">Administra el personal docente y sus asignaciones de materias.</p>
            <div class="quick-access-buttons">
                <a href="#" class="btn btn-warning text-white">
                    <i class="fas fa-users"></i> Ver Todos
                </a>
                <a href="#" class="btn btn-outline-warning">
                    <i class="fas fa-user-plus"></i> Agregar
                </a>
            </div>
        </div>
    </div>

    <!-- Estudiantes -->
    <div class="col-lg-4 col-md-6 fade-in-up" style="animation-delay: 1s;">
        <div class="quick-access-card">
            <div class="quick-access-icon bg-danger bg-opacity-10 text-danger">
                <i class="fas fa-user-graduate"></i>
            </div>
            <h5>Gestión de Estudiantes</h5>
            <p class="mb-3">Administra los estudiantes matriculados y sus inscripciones.</p>
            <div class="quick-access-buttons">
                <a href="#" class="btn btn-danger">
                    <i class="fas fa-graduation-cap"></i> Ver Todos
                </a>
                <a href="#" class="btn btn-outline-danger">
                    <i class="fas fa-user-plus"></i> Matricular
                </a>
            </div>
        </div>
    </div>

    <!-- Reportes -->
    <div class="col-lg-4 col-md-6 fade-in-up" style="animation-delay: 1.1s;">
        <div class="quick-access-card">
            <div class="quick-access-icon bg-purple bg-opacity-10 text-purple" style="color: #8b5cf6;">
                <i class="fas fa-chart-bar"></i>
            </div>
            <h5>Reportes y Estadísticas</h5>
            <p class="mb-3">Genera reportes del sistema y consulta estadísticas generales.</p>
            <div class="quick-access-buttons">
                <a href="#" class="btn text-white" style="background-color: #8b5cf6;">
                    <i class="fas fa-file-alt"></i> Ver Reportes
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Sección de Administradores (si tienes esta variable) -->
@if(isset($administradores) && $administradores->count() > 0)
<div class="row g-4">
    <!-- Panel principal -->
    <div class="col-lg-8">
        <div class="custom-table fade-in-up" style="animation-delay: 1.2s;">
            <div class="px-4 py-3 bg-white">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-users-cog text-primary"></i> Administradores del Sistema
                </h5>
            </div>
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Administrador</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($administradores->take(5) as $admin)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                    <strong class="text-primary">{{ substr($admin->name, 0, 1) }}</strong>
                                </div>
                                <div>
                                    <strong>{{ $admin->name }}</strong>
                                    @if($admin->is_super_admin)
                                        <span class="badge-custom bg-danger text-white ms-2">
                                            <i class="fas fa-crown"></i> SUPER
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <i class="fas fa-envelope text-muted me-2"></i>
                            {{ $admin->email }}
                        </td>
                        <td class="align-middle">
                            @if($admin->is_super_admin)
                                <span class="badge-custom bg-danger text-white">
                                    <i class="fas fa-star"></i> Super Admin
                                </span>
                            @else
                                <span class="badge-custom bg-primary text-white">
                                    <i class="fas fa-user-cog"></i> Admin
                                </span>
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            @if(!$admin->is_protected)
                                <a href="{{ route('superadmin.administradores.edit', $admin) }}" 
                                   class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @else
                                <span class="badge bg-warning">Protegido</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Panel lateral -->
    <div class="col-lg-4">
        <!-- Actividad reciente -->
        <div class="card border-0 shadow-sm fade-in-up" style="animation-delay: 1.3s; border-radius: 15px;">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-history text-primary"></i> Actividad Reciente
                </h5>
            </div>
            <div class="card-body">
                <div class="activity-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <strong>Materia creada</strong>
                            <p class="mb-0 small text-muted">Nueva materia agregada al sistema</p>
                        </div>
                        <span class="badge bg-success">Hoy</span>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <strong>Grado actualizado</strong>
                            <p class="mb-0 small text-muted">Se modificaron las asignaciones</p>
                        </div>
                        <span class="badge bg-info">Ayer</span>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <strong>Login exitoso</strong>
                            <p class="mb-0 small text-muted">Administrador inició sesión</p>
                        </div>
                        <span class="badge bg-secondary">2d</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
    // Auto-hide alerts
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
</script>
@endpush