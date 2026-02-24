@extends('layouts.app')

@section('title', 'Dashboard - Super Administrador')
@section('page-title', 'Panel de Control')

@section('topbar-actions')
    <div class="d-flex align-items-center gap-3">
        @php
            $user = auth()->user();
            $isSuperAdmin = $user->is_super_admin == 1 || $user->role === 'super_admin';
            $displayRole = $isSuperAdmin ? 'Super Administrador' : ucfirst($user->role ?? 'Usuario');
        @endphp
        <span class="badge bg-primary" style="padding: 0.5rem 1rem; font-weight: 500;">
            <i class="fas fa-user-shield me-1"></i> {{ $displayRole }}
        </span>
    </div>
@endsection

@section('content')
<div class="container-fluid px-4">

    {{-- Header de Bienvenida --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-card">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h2 class="welcome-title">
                            <i class="fas fa-school me-2"></i>
                            Bienvenido, {{ auth()->user()->name }}
                        </h2>
                        <p class="welcome-subtitle mb-0">Sistema de Gestión Escolar - Gabriela Mistral</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Estadísticas Principales --}}
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-students">
                <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
                <div class="stat-content">
                    <h6 class="stat-label">Estudiantes Registrados</h6>
                    <h2 class="stat-value">{{ \App\Models\Estudiante::count() }}</h2>
                    <div class="stat-footer">
                        <span class="stat-badge stat-badge-success">
                            <i class="fas fa-check-circle"></i>
                            {{ \App\Models\Estudiante::where('estado', 'activo')->count() }} Activos
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-teachers">
                <div class="stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                <div class="stat-content">
                    <h6 class="stat-label">Profesores Activos</h6>
                    <h2 class="stat-value">{{ \App\Models\Profesor::count() }}</h2>
                    <div class="stat-footer">
                        <span class="stat-badge stat-badge-info">
                            <i class="fas fa-check-circle"></i>
                            {{ \App\Models\Profesor::where('estado', 'activo')->count() }} En servicio
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-enrollments">
                <div class="stat-icon"><i class="fas fa-file-signature"></i></div>
                <div class="stat-content">
                    <h6 class="stat-label">Matrículas</h6>
                    <h2 class="stat-value">{{ \App\Models\Matricula::count() }}</h2>
                    <div class="stat-footer">
                        <span class="stat-badge stat-badge-warning">
                            <i class="fas fa-clock"></i>
                            {{ $totalPendientes ?? 0 }} Pendientes
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-users">
                <div class="stat-icon"><i class="fas fa-users-cog"></i></div>
                <div class="stat-content">
                    <h6 class="stat-label">Usuarios del Sistema</h6>
                    <h2 class="stat-value">{{ \App\Models\User::count() }}</h2>
                    <div class="stat-footer">
                        <span class="stat-badge stat-badge-danger">
                            <i class="fas fa-user-clock"></i>
                            {{ \App\Models\User::where('activo', false)->count() }} Por aprobar
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SOLICITUDES DE MATRÍCULA PENDIENTES --}}
    @if(isset($matriculasPendientes) && $matriculasPendientes->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0" style="border: 2px solid #ffc107 !important; border-radius: 12px;">
                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-bell text-warning me-2"></i>
                            Solicitudes de Matrícula Pendientes
                        </h5>
                        <div class="d-flex gap-2 align-items-center">
                            <span class="badge bg-warning text-dark" style="font-size: 0.9rem; padding: 0.5rem 1rem;">
                                <i class="fas fa-clock me-1"></i>
                                {{ $matriculasPendientes->count() }} {{ $matriculasPendientes->count() == 1 ? 'solicitud' : 'solicitudes' }}
                            </span>
                            <a href="{{ route('matriculas.index') }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-list me-1"></i> Ver Todas
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="matriculas-pendientes-grid">
                        @foreach($matriculasPendientes as $matricula)
                        <div class="matricula-card-compact">
                            <div class="matricula-header">
                                <span class="codigo-badge">
                                    <i class="fas fa-file-alt me-1"></i>{{ $matricula->codigo_matricula }}
                                </span>
                                <span class="estado-badge">
                                    <i class="fas fa-clock me-1"></i>Pendiente
                                </span>
                            </div>
                            <div class="matricula-content">
                                <div class="info-block">
                                    <div class="info-icon bg-students"><i class="fas fa-user-graduate"></i></div>
                                    <div class="info-text">
                                        <span class="info-label">Estudiante</span>
                                        <strong class="info-value">{{ $matricula->estudiante->nombre1 }} {{ $matricula->estudiante->apellido1 }}</strong>
                                        <small class="info-detail">DNI: {{ $matricula->estudiante->dni }}</small>
                                    </div>
                                </div>
                                <div class="info-block">
                                    <div class="info-icon bg-parents"><i class="fas fa-user-friends"></i></div>
                                    <div class="info-text">
                                        <span class="info-label">Padre/Tutor</span>
                                        <strong class="info-value">{{ $matricula->padre->nombre }} {{ $matricula->padre->apellido }}</strong>
                                        <small class="info-detail">{{ $matricula->padre->telefono }}</small>
                                    </div>
                                </div>
                                <div class="info-row">
                                    <div class="info-item">
                                        <i class="fas fa-graduation-cap text-primary me-1"></i>
                                        {{-- CORREGIDO: seccion puede ser null --}}
                                        <span class="badge bg-info">{{ $matricula->estudiante->grado }} - Sec. {{ $matricula->estudiante->seccion ?? 'Sin asignar' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <i class="fas fa-calendar-alt text-muted me-1"></i>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($matricula->fecha_matricula)->format('d/m/Y') }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="matricula-footer">
                                <button type="button" class="btn btn-primary btn-ver-detalles w-100"
                                        data-matricula-id="{{ $matricula->id }}">
                                    <i class="fas fa-eye me-2"></i>Ver Detalles y Gestionar
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Gestión Académica --}}
    <div class="row mb-4">
        <div class="col-12">
            <h5 class="section-title"><i class="fas fa-tasks me-2"></i>Gestión Académica</h5>
        </div>
    </div>

    <div class="row g-4 mb-4">
        {{-- Estudiantes --}}
        <div class="col-lg-4 col-md-6">
            <div class="action-card">
                <div class="action-card-header">
                    <div class="action-icon bg-students"><i class="fas fa-user-graduate"></i></div>
                    <div><h6 class="action-title">Estudiantes</h6><p class="action-subtitle">Gestión de alumnos</p></div>
                </div>
                <div class="action-card-body">
                    <a href="{{ route('estudiantes.index') }}" class="btn btn-outline-primary w-100 mb-2">
                        <i class="fas fa-list me-2"></i> Ver Estudiantes
                    </a>
                    <a href="{{ route('estudiantes.create') }}" class="btn btn-primary w-100">
                        <i class="fas fa-plus me-2"></i> Nuevo Estudiante
                    </a>
                </div>
            </div>
        </div>

        {{-- Profesores --}}
        <div class="col-lg-4 col-md-6">
            <div class="action-card">
                <div class="action-card-header">
                    <div class="action-icon bg-teachers"><i class="fas fa-chalkboard-teacher"></i></div>
                    <div><h6 class="action-title">Profesores</h6><p class="action-subtitle">Gestión de docentes</p></div>
                </div>
                <div class="action-card-body">
                    <a href="{{ route('profesores.index') }}" class="btn btn-outline-primary w-100 mb-2">
                        <i class="fas fa-list me-2"></i> Ver Profesores
                    </a>
                    <a href="{{ route('profesores.create') }}" class="btn btn-primary w-100">
                        <i class="fas fa-plus me-2"></i> Nuevo Profesor
                    </a>
                </div>
            </div>
        </div>

        {{-- Padres --}}
        <div class="col-lg-4 col-md-6">
            <div class="action-card">
                <div class="action-card-header">
                    <div class="action-icon bg-parents"><i class="fas fa-users"></i></div>
                    <div><h6 class="action-title">Padres/Tutores</h6><p class="action-subtitle">Gestión de representantes</p></div>
                </div>
                <div class="action-card-body">
                    <a href="{{ route('padres.index') }}" class="btn btn-outline-primary w-100 mb-2">
                        <i class="fas fa-list me-2"></i> Ver Padres
                    </a>
                    <a href="{{ route('padres.create') }}" class="btn btn-primary w-100">
                        <i class="fas fa-plus me-2"></i> Nuevo Padre/Tutor
                    </a>
                </div>
            </div>
        </div>

        {{-- Matrículas --}}
        <div class="col-lg-4 col-md-6">
            <div class="action-card">
                <div class="action-card-header">
                    <div class="action-icon bg-enrollments"><i class="fas fa-file-signature"></i></div>
                    <div><h6 class="action-title">Matrículas</h6><p class="action-subtitle">Inscripciones y registros</p></div>
                </div>
                <div class="action-card-body">
                    <a href="{{ route('matriculas.index') }}" class="btn btn-outline-primary w-100 mb-2">
                        <i class="fas fa-list me-2"></i> Ver Matrículas
                    </a>
                    <a href="{{ route('matriculas.create') }}" class="btn btn-primary w-100">
                        <i class="fas fa-plus me-2"></i> Nueva Matrícula
                    </a>
                </div>
            </div>
        </div>

        {{-- Grados y Materias — CORREGIDO: rutas con prefijo superadmin --}}
        <div class="col-lg-4 col-md-6">
            <div class="action-card">
                <div class="action-card-header">
                    <div class="action-icon bg-academic"><i class="fas fa-graduation-cap"></i></div>
                    <div><h6 class="action-title">Plan Académico</h6><p class="action-subtitle">Grados y materias</p></div>
                </div>
                <div class="action-card-body">
                    <a href="{{ route('superadmin.grados.index') }}" class="btn btn-outline-primary w-100 mb-2">
                        <i class="fas fa-list me-2"></i> Grados
                    </a>
                    <a href="{{ route('superadmin.materias.index') }}" class="btn btn-primary w-100">
                        <i class="fas fa-book me-2"></i> Materias
                    </a>
                </div>
            </div>
        </div>

        {{-- Administración --}}
        <div class="col-lg-4 col-md-6">
            <div class="action-card">
                <div class="action-card-header">
                    <div class="action-icon bg-admin"><i class="fas fa-user-shield"></i></div>
                    <div><h6 class="action-title">Administración</h6><p class="action-subtitle">Usuarios y permisos</p></div>
                </div>
                <div class="action-card-body">
                    <a href="{{ route('superadmin.usuarios.index') }}" class="btn btn-primary w-100 mb-2">
                        <i class="fas fa-users me-2"></i> Lista de Usuarios
                    </a>
                    <a href="{{ route('superadmin.usuarios.pendientes') }}" class="btn btn-warning w-100">
                        <i class="fas fa-user-clock me-2"></i> Usuarios Pendientes
                    </a>
                </div>
            </div>
        </div>

        {{-- Horarios --}}
        <div class="col-lg-4 col-md-6">
            <div class="action-card">
                <div class="action-card-header">
                    <div class="action-icon bg-info"><i class="fas fa-clock"></i></div>
                    <div><h6 class="action-title">Horarios</h6><p class="action-subtitle">Gestión de horarios de clases</p></div>
                </div>
                <div class="action-card-body">
                    <a href="{{ route('superadmin.horarios_grado.index') }}" class="btn btn-outline-primary w-100 mb-2">
                        <i class="fas fa-list me-2"></i> Ver Horarios
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- MODAL DETALLES MATRÍCULA --}}
<div class="modal fade" id="modalDetallesMatricula" tabindex="-1" aria-labelledby="modalDetallesLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header border-0" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 12px 12px 0 0;">
                <h5 class="modal-title fw-bold" id="modalDetallesLabel">
                    <i class="fas fa-file-alt me-2"></i>Detalles de la Solicitud de Matrícula
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="contenidoDetallesMatricula">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-3 text-muted">Cargando detalles de la solicitud...</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL RECHAZAR MATRÍCULA --}}
<div class="modal fade" id="modalRechazoMatricula" tabindex="-1" aria-labelledby="modalRechazoMatriculaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header border-0" style="background: linear-gradient(135deg, #f44336 0%, #e57373 100%); color: white; border-radius: 12px 12px 0 0;">
                <h5 class="modal-title fw-bold" id="modalRechazoMatriculaLabel">
                    <i class="fas fa-times-circle me-2"></i>Rechazar Solicitud de Matrícula
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formRechazoMatricula" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="alert alert-warning border-0 mb-3" style="background: rgba(255,193,7,0.1); border-left: 4px solid #ffc107 !important;">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-exclamation-triangle me-2 mt-1" style="color: #ffc107;"></i>
                            <div>
                                <strong>Atención:</strong> Esta acción rechazará permanentemente la solicitud de matrícula.
                                <br><small class="text-muted">El padre/tutor recibirá una notificación con el motivo del rechazo.</small>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="motivo_rechazo_matricula" class="form-label fw-semibold">
                            Motivo del Rechazo <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" id="motivo_rechazo_matricula" name="motivo_rechazo"
                                  rows="5" required
                                  placeholder="Ej: Documentación incompleta, datos incorrectos del estudiante, cupo agotado..."
                                  style="border: 2px solid #dee2e6; border-radius: 8px;"></textarea>
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Este motivo será visible para el padre/tutor y quedará registrado en el sistema.
                        </small>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-ban me-1"></i>Confirmar Rechazo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
:root {
    --primary-color: #00508f;
    --secondary-color: #4ec7d2;
    --accent-color: #fbbf24;
    --success-color: #10b981;
    --danger-color: #ef4444;
    --warning-color: #f59e0b;
    --light-bg: #f8fafc;
    --border-color: #e2e8f0;
}
.welcome-card { background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); border-radius: 16px; padding: 2rem; color: white; box-shadow: 0 4px 6px rgba(0,80,143,0.1); }
.welcome-title { font-size: 1.75rem; font-weight: 700; margin-bottom: 0.5rem; color: white; }
.welcome-subtitle { font-size: 1rem; opacity: 0.9; }
.stat-card { background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.05); border: 1px solid var(--border-color); transition: all 0.3s ease; height: 100%; }
.stat-card:hover { transform: translateY(-4px); box-shadow: 0 8px 16px rgba(0,80,143,0.1); }
.stat-icon { width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1rem; }
.stat-card-students .stat-icon { background: rgba(78,199,210,0.1); color: var(--secondary-color); }
.stat-card-teachers .stat-icon { background: rgba(0,80,143,0.1); color: var(--primary-color); }
.stat-card-enrollments .stat-icon { background: rgba(251,191,36,0.1); color: var(--accent-color); }
.stat-card-users .stat-icon { background: rgba(239,68,68,0.1); color: var(--danger-color); }
.stat-label { font-size: 0.875rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem; }
.stat-value { font-size: 2rem; font-weight: 700; color: var(--primary-color); margin-bottom: 1rem; }
.stat-footer { padding-top: 1rem; border-top: 1px solid var(--border-color); }
.stat-badge { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.375rem 0.75rem; border-radius: 6px; font-size: 0.813rem; font-weight: 500; }
.stat-badge-success { background: rgba(16,185,129,0.1); color: var(--success-color); }
.stat-badge-info { background: rgba(0,80,143,0.1); color: var(--primary-color); }
.stat-badge-warning { background: rgba(251,191,36,0.1); color: var(--accent-color); }
.stat-badge-danger { background: rgba(239,68,68,0.1); color: var(--danger-color); }
.matriculas-pendientes-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.25rem; }
.matricula-card-compact { background: white; border: 2px solid #e2e8f0; border-radius: 12px; overflow: hidden; transition: all 0.3s ease; display: flex; flex-direction: column; }
.matricula-card-compact:hover { border-color: #4ec7d2; box-shadow: 0 8px 20px rgba(0,80,143,0.15); transform: translateY(-4px); }
.matricula-header { background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 0.875rem 1rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #e2e8f0; gap: 0.5rem; flex-wrap: wrap; }
.codigo-badge { background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.4rem 0.75rem; border-radius: 6px; font-size: 0.813rem; font-weight: 700; display: inline-flex; align-items: center; letter-spacing: 0.3px; }
.estado-badge { background: #ffc107; color: #000; padding: 0.4rem 0.75rem; border-radius: 6px; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center; }
.matricula-content { padding: 1.25rem; flex: 1; display: flex; flex-direction: column; gap: 1rem; }
.info-block { display: flex; gap: 0.875rem; align-items: flex-start; }
.info-icon { width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 1.1rem; color: white; }
.info-text { flex: 1; display: flex; flex-direction: column; gap: 0.125rem; min-width: 0; }
.info-label { font-size: 0.7rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
.info-value { font-size: 0.938rem; color: #003b73; font-weight: 700; line-height: 1.3; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.info-detail { font-size: 0.75rem; color: #64748b; }
.info-row { display: flex; justify-content: space-between; align-items: center; gap: 0.75rem; padding-top: 0.75rem; border-top: 1px solid #e2e8f0; flex-wrap: wrap; }
.info-item { display: flex; align-items: center; gap: 0.25rem; font-size: 0.813rem; }
.matricula-footer { padding: 0 1rem 1rem 1rem; }
.matricula-footer .btn { font-size: 0.875rem; font-weight: 600; padding: 0.625rem 1rem; border-radius: 8px; transition: all 0.3s ease; }
.matricula-footer .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,80,143,0.3); }
.section-title { font-size: 1.25rem; font-weight: 700; color: var(--primary-color); margin-bottom: 0; padding-bottom: 0.75rem; border-bottom: 2px solid var(--border-color); }
.action-card { background: white; border-radius: 12px; border: 1px solid var(--border-color); overflow: hidden; transition: all 0.3s ease; height: 100%; }
.action-card:hover { transform: translateY(-4px); box-shadow: 0 8px 16px rgba(0,80,143,0.1); border-color: var(--primary-color); }
.action-card-header { display: flex; align-items: center; gap: 1rem; padding: 1.5rem; background: var(--light-bg); border-bottom: 1px solid var(--border-color); }
.action-icon { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; color: white; }
.bg-students { background: var(--secondary-color); }
.bg-teachers { background: var(--primary-color); }
.bg-parents { background: #6366f1; }
.bg-enrollments { background: var(--accent-color); }
.bg-academic { background: var(--success-color); }
.bg-admin { background: var(--danger-color); }
.action-title { font-size: 1rem; font-weight: 700; color: var(--primary-color); margin-bottom: 0.25rem; }
.action-subtitle { font-size: 0.813rem; color: #64748b; margin-bottom: 0; }
.action-card-body { padding: 1.5rem; }
.btn { font-weight: 500; border-radius: 8px; padding: 0.5rem 1rem; transition: all 0.3s ease; }
.btn-primary { background: var(--primary-color); border-color: var(--primary-color); }
.btn-primary:hover { background: #003b73; border-color: #003b73; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,80,143,0.2); }
.btn-outline-primary { color: var(--primary-color); border-color: var(--primary-color); }
.btn-outline-primary:hover { background: var(--primary-color); border-color: var(--primary-color); }
@media (max-width: 1200px) { .matriculas-pendientes-grid { grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem; } }
@media (max-width: 768px) { .welcome-card { padding: 1.5rem; } .welcome-title { font-size: 1.5rem; } .stat-value { font-size: 1.75rem; } .matriculas-pendientes-grid { grid-template-columns: 1fr; gap: 1rem; } }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('click', function(e) {
    const btnDetalles = e.target.closest('.btn-ver-detalles');
    if (btnDetalles) {
        e.preventDefault();
        verDetallesMatricula(btnDetalles.getAttribute('data-matricula-id'));
    }
});

function verDetallesMatricula(matriculaId) {
    const modalElement = document.getElementById('modalDetallesMatricula');
    if (!modalElement) return;

    const modal = new bootstrap.Modal(modalElement);
    const contenido = document.getElementById('contenidoDetallesMatricula');

    contenido.innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-primary" style="width:3rem;height:3rem;" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="mt-3 text-muted fw-medium">Cargando información...</p>
        </div>`;
    modal.show();

    fetch(`/matriculas/${matriculaId}/detalles`)
        .then(response => {
            if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);
            return response.json();
        })
        .then(data => {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            contenido.innerHTML = `
                <div class="row g-4">
                    <div class="col-12">
                        <div class="alert alert-primary border-0">
                            <strong>Código de Matrícula:</strong>
                            <h5 class="mb-0 mt-1">${data.matricula.codigo}</h5>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header"><h6 class="mb-0"><i class="fas fa-user-graduate me-2"></i>Información del Estudiante</h6></div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6"><label class="text-muted small">Nombre Completo</label><p class="fw-bold mb-0">${data.estudiante.nombre_completo}</p></div>
                                    <div class="col-md-3"><label class="text-muted small">DNI</label><p class="mb-0">${data.estudiante.dni}</p></div>
                                    <div class="col-md-3"><label class="text-muted small">Fecha de Nacimiento</label><p class="mb-0">${data.estudiante.fecha_nacimiento}</p></div>
                                    <div class="col-md-4"><label class="text-muted small">Grado</label><p class="mb-0"><span class="badge bg-primary">${data.estudiante.grado}</span></p></div>
                                    <div class="col-md-4"><label class="text-muted small">Sección</label><p class="mb-0"><span class="badge bg-info">${data.estudiante.seccion ?? 'Sin asignar'}</span></p></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header"><h6 class="mb-0"><i class="fas fa-user-friends me-2"></i>Información del Padre/Tutor</h6></div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6"><label class="text-muted small">Nombre Completo</label><p class="fw-bold mb-0">${data.padre.nombre_completo}</p></div>
                                    <div class="col-md-3"><label class="text-muted small">DNI</label><p class="mb-0">${data.padre.dni}</p></div>
                                    <div class="col-md-3"><label class="text-muted small">Parentesco</label><p class="mb-0"><span class="badge bg-secondary">${data.padre.parentesco}</span></p></div>
                                    <div class="col-md-6"><label class="text-muted small">Email</label><p class="mb-0">${data.padre.correo || 'No proporcionado'}</p></div>
                                    <div class="col-md-6"><label class="text-muted small">Teléfono</label><p class="mb-0">${data.padre.telefono}</p></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3"><i class="fas fa-tasks me-2"></i>Acciones Disponibles</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <form action="/matriculas/${matriculaId}/confirmar" method="POST">
                                            <input type="hidden" name="_token" value="${csrfToken}">
                                            <button type="submit" class="btn btn-success w-100 py-3">
                                                <i class="fas fa-check-circle me-2"></i><span class="fw-bold">Aprobar Matrícula</span>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-danger w-100 py-3 btn-rechazar-desde-modal"
                                                data-matricula-id="${matriculaId}">
                                            <i class="fas fa-times-circle me-2"></i><span class="fw-bold">Rechazar Matrícula</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
        })
        .catch(error => {
            contenido.innerHTML = `<div class="alert alert-danger"><h6>Error al cargar los detalles</h6><p>${error.message}</p></div>`;
        });
}

document.addEventListener('click', function(e) {
    const btnRechazar = e.target.closest('.btn-rechazar-desde-modal');
    if (!btnRechazar) return;
    e.preventDefault();
    const matriculaId = btnRechazar.dataset.matriculaId;
    const modalDetalles = bootstrap.Modal.getInstance(document.getElementById('modalDetallesMatricula'));
    if (modalDetalles) modalDetalles.hide();
    setTimeout(() => mostrarModalRechazoMatricula(matriculaId), 350);
});

function mostrarModalRechazoMatricula(matriculaId) {
    const form = document.getElementById('formRechazoMatricula');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    form.action = `/matriculas/${matriculaId}/rechazar`;
    document.getElementById('motivo_rechazo_matricula').value = '';

    const modal = new bootstrap.Modal(document.getElementById('modalRechazoMatricula'));
    modal.show();

    // Clonar para evitar listeners duplicados
    const nuevoForm = form.cloneNode(true);
    form.parentNode.replaceChild(nuevoForm, form);

    nuevoForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const motivo = document.getElementById('motivo_rechazo_matricula').value.trim();

        if (!motivo || motivo.length < 10) {
            alert('Por favor, proporcione un motivo más detallado (mínimo 10 caracteres).');
            return;
        }

        if (confirm('¿Está seguro de rechazar esta matrícula?')) {
            fetch(nuevoForm.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: new URLSearchParams({ '_token': csrfToken, 'motivo_rechazo': motivo })
            })
            .then(response => {
                if (response.ok) {
                    modal.hide();
                    alert('Matrícula rechazada correctamente');
                    location.reload();
                } else {
                    throw new Error('Error en la respuesta del servidor');
                }
            })
            .catch(() => alert('Error: No se pudo rechazar la matrícula'));
        }
    });
}
</script>
@endpush
@endsection
