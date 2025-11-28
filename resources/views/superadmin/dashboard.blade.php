@extends('layouts.app')

@section('title', 'Dashboard - Super Administrador')

@section('page-title', 'Panel de Control')

@section('topbar-actions')
    <div class="d-flex align-items-center gap-3">

        @if(auth()->user()->rol)
        <div class="vr"></div>
        <span class="badge bg-primary" style="padding: 0.5rem 1rem; font-weight: 500;">
            <i class="fas fa-user-shield me-1"></i> {{ auth()->user()->rol->nombre }}
        </span>
        @else
        <span class="badge bg-warning text-dark" style="padding: 0.5rem 1rem; font-weight: 500;">
            <i class="fas fa-exclamation-triangle me-1"></i> Sin rol asignado
        </span>
        @endif
    </div>
@endsection

@section('content')
<div class="container-fluid px-4">

    <!-- Header de Bienvenida -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-card">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="welcome-content">
                            <h2 class="welcome-title">
                                <i class="fas fa-school me-2"></i>
                                Bienvenido, {{ auth()->user()->name }}
                            </h2>
                            <p class="welcome-subtitle mb-0">
                                Sistema de Gestión Escolar - Gabriela Mistral
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas Principales -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-students">
                <div class="stat-icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
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
                <div class="stat-icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
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
                <div class="stat-icon">
                    <i class="fas fa-file-signature"></i>
                </div>
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
                <div class="stat-icon">
                    <i class="fas fa-users-cog"></i>
                </div>
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

    <!-- SOLICITUDES DE MATRÍCULA PENDIENTES - DISEÑO COMPACTO -->
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
                            <!-- Header con código -->
                            <div class="matricula-header">
                                <span class="codigo-badge">
                                    <i class="fas fa-file-alt me-1"></i>
                                    {{ $matricula->codigo_matricula }}
                                </span>
                                <span class="estado-badge">
                                    <i class="fas fa-clock me-1"></i>Pendiente
                                </span>
                            </div>

                            <!-- Contenido principal -->
                            <div class="matricula-content">
                                <!-- Estudiante -->
                                <div class="info-block">
                                    <div class="info-icon bg-students">
                                        <i class="fas fa-user-graduate"></i>
                                    </div>
                                    <div class="info-text">
                                        <span class="info-label">Estudiante</span>
                                        <strong class="info-value">{{ $matricula->estudiante->nombre1 }} {{ $matricula->estudiante->apellido1 }}</strong>
                                        <small class="info-detail">DNI: {{ $matricula->estudiante->dni }}</small>
                                    </div>
                                </div>

                                <!-- Padre -->
                                <div class="info-block">
                                    <div class="info-icon bg-parents">
                                        <i class="fas fa-user-friends"></i>
                                    </div>
                                    <div class="info-text">
                                        <span class="info-label">Padre/Tutor</span>
                                        <strong class="info-value">{{ $matricula->padre->nombre }} {{ $matricula->padre->apellido }}</strong>
                                        <small class="info-detail">{{ $matricula->padre->telefono }}</small>
                                    </div>
                                </div>

                                <!-- Grado y Fecha -->
                                <div class="info-row">
                                    <div class="info-item">
                                        <i class="fas fa-graduation-cap text-primary me-1"></i>
                                        <span class="badge bg-info">{{ $matricula->estudiante->grado }} - Sec. {{ $matricula->estudiante->seccion }}</span>
                                    </div>
                                    <div class="info-item">
                                        <i class="fas fa-calendar-alt text-muted me-1"></i>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($matricula->fecha_matricula)->format('d/m/Y') }}</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer con botón -->
                            <div class="matricula-footer">
                                <button type="button"
                                        class="btn btn-primary btn-ver-detalles w-100"
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

    <!-- Gestión Académica -->
    <div class="row mb-4">
        <div class="col-12">
            <h5 class="section-title">
                <i class="fas fa-tasks me-2"></i>
                Gestión Académica
            </h5>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Estudiantes -->
        <div class="col-lg-4 col-md-6">
            <div class="action-card">
                <div class="action-card-header">
                    <div class="action-icon bg-students">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div>
                        <h6 class="action-title">Estudiantes</h6>
                        <p class="action-subtitle">Gestión de alumnos</p>
                    </div>
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

        <!-- Profesores -->
        <div class="col-lg-4 col-md-6">
            <div class="action-card">
                <div class="action-card-header">
                    <div class="action-icon bg-teachers">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div>
                        <h6 class="action-title">Profesores</h6>
                        <p class="action-subtitle">Gestión de docentes</p>
                    </div>
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

        <!-- Padres -->
        <div class="col-lg-4 col-md-6">
            <div class="action-card">
                <div class="action-card-header">
                    <div class="action-icon bg-parents">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <h6 class="action-title">Padres/Tutores</h6>
                        <p class="action-subtitle">Gestión de representantes</p>
                    </div>
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

        <!-- Matrículas -->
        <div class="col-lg-4 col-md-6">
            <div class="action-card">
                <div class="action-card-header">
                    <div class="action-icon bg-enrollments">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <div>
                        <h6 class="action-title">Matrículas</h6>
                        <p class="action-subtitle">Inscripciones y registros</p>
                    </div>
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

        <!-- Grados y Materias -->
        <div class="col-lg-4 col-md-6">
            <div class="action-card">
                <div class="action-card-header">
                    <div class="action-icon bg-academic">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div>
                        <h6 class="action-title">Plan Académico</h6>
                        <p class="action-subtitle">Grados y materias</p>
                    </div>
                </div>
                <div class="action-card-body">
                    <a href="{{ route('grados.index') }}" class="btn btn-outline-primary w-100 mb-2">
                        <i class="fas fa-list me-2"></i> Grados
                    </a>
                    <a href="{{ route('materias.index') }}" class="btn btn-primary w-100">
                        <i class="fas fa-book me-2"></i> Materias
                    </a>
                </div>
            </div>
        </div>

        <!-- Administración -->
        <div class="col-lg-4 col-md-6">
            <div class="action-card">
                <div class="action-card-header">
                    <div class="action-icon bg-admin">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div>
                        <h6 class="action-title">Administración</h6>
                        <p class="action-subtitle">Usuarios y permisos</p>
                    </div>
                </div>
                <div class="action-card-body">
                    <a href="{{ route('superadmin.administradores.index') }}" class="btn btn-outline-primary w-100 mb-2">
                        <i class="fas fa-users-cog me-2"></i> Administradores
                    </a>
                    <a href="{{ route('admins.index') }}" class="btn btn-primary w-100">
                        <i class="fas fa-user-tie me-2"></i> Gestión de Admins
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- MODAL PARA VER DETALLES DE MATRÍCULA --}}
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

{{-- MODAL PARA RECHAZAR MATRÍCULA --}}
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
                    <div class="alert alert-warning border-0 mb-3" style="background: rgba(255, 193, 7, 0.1); border-left: 4px solid #ffc107 !important;">
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
                        <textarea class="form-control"
                                  id="motivo_rechazo_matricula"
                                  name="motivo_rechazo"
                                  rows="5"
                                  required
                                  placeholder="Ej: Documentación incompleta, datos incorrectos del estudiante, cupo agotado para el grado solicitado, no cumple con los requisitos de edad..."
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

/* Welcome Card */
.welcome-card {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    border-radius: 16px;
    padding: 2rem;
    color: white;
    box-shadow: 0 4px 6px rgba(0, 80, 143, 0.1);
}

.welcome-title {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: white;
}

.welcome-subtitle {
    font-size: 1rem;
    opacity: 0.9;
}

.date-display, .time-display {
    background: rgba(255, 255, 255, 0.15);
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.9rem;
    backdrop-filter: blur(10px);
}

/* Statistics Cards */
.stat-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    height: 100%;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 16px rgba(0, 80, 143, 0.1);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 1rem;
}

.stat-card-students .stat-icon {
    background: rgba(78, 199, 210, 0.1);
    color: var(--secondary-color);
}

.stat-card-teachers .stat-icon {
    background: rgba(0, 80, 143, 0.1);
    color: var(--primary-color);
}

.stat-card-enrollments .stat-icon {
    background: rgba(251, 191, 36, 0.1);
    color: var(--accent-color);
}

.stat-card-users .stat-icon {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger-color);
}

.stat-label {
    font-size: 0.875rem;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.5rem;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 1rem;
}

.stat-footer {
    padding-top: 1rem;
    border-top: 1px solid var(--border-color);
}

.stat-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    font-size: 0.813rem;
    font-weight: 500;
}

.stat-badge-success {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success-color);
}

.stat-badge-info {
    background: rgba(0, 80, 143, 0.1);
    color: var(--primary-color);
}

.stat-badge-warning {
    background: rgba(251, 191, 36, 0.1);
    color: var(--accent-color);
}

.stat-badge-danger {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger-color);
}

/* ========================================
   MATRÍCULAS PENDIENTES - DISEÑO COMPACTO
   ======================================== */
.matriculas-pendientes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.25rem;
}

.matricula-card-compact {
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
}

.matricula-card-compact:hover {
    border-color: #4ec7d2;
    box-shadow: 0 8px 20px rgba(0, 80, 143, 0.15);
    transform: translateY(-4px);
}

.matricula-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 0.875rem 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid #e2e8f0;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.codigo-badge {
    background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
    color: white;
    padding: 0.4rem 0.75rem;
    border-radius: 6px;
    font-size: 0.813rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    letter-spacing: 0.3px;
}

.estado-badge {
    background: #ffc107;
    color: #000;
    padding: 0.4rem 0.75rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
}

.matricula-content {
    padding: 1.25rem;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.info-block {
    display: flex;
    gap: 0.875rem;
    align-items: flex-start;
}

.info-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 1.1rem;
    color: white;
}

.info-text {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.125rem;
    min-width: 0;
}

.info-label {
    font-size: 0.7rem;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value {
    font-size: 0.938rem;
    color: #003b73;
    font-weight: 700;
    line-height: 1.3;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.info-detail {
    font-size: 0.75rem;
    color: #64748b;
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 0.75rem;
    padding-top: 0.75rem;
    border-top: 1px solid #e2e8f0;
    flex-wrap: wrap;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.813rem;
}

.matricula-footer {
    padding: 0 1rem 1rem 1rem;
}

.matricula-footer .btn {
    font-size: 0.875rem;
    font-weight: 600;
    padding: 0.625rem 1rem;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.matricula-footer .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 80, 143, 0.3);
}

/* Section Title */
.section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 0;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid var(--border-color);
}

/* Action Cards */
.action-card {
    background: white;
    border-radius: 12px;
    border: 1px solid var(--border-color);
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
}

.action-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 16px rgba(0, 80, 143, 0.1);
    border-color: var(--primary-color);
}

.action-card-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: var(--light-bg);
    border-bottom: 1px solid var(--border-color);
}

.action-icon {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: white;
}

.bg-students { background: var(--secondary-color); }
.bg-teachers { background: var(--primary-color); }
.bg-parents { background: #6366f1; }
.bg-enrollments { background: var(--accent-color); }
.bg-academic { background: var(--success-color); }
.bg-admin { background: var(--danger-color); }

.action-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 0.25rem;
}

.action-subtitle {
    font-size: 0.813rem;
    color: #64748b;
    margin-bottom: 0;
}

.action-card-body {
    padding: 1.5rem;
}

/* Button Customization */
.btn {
    font-weight: 500;
    border-radius: 8px;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease;
}

.btn-primary {
    background: var(--primary-color);
    border-color: var(--primary-color);
}

.btn-primary:hover {
    background: #003b73;
    border-color: #003b73;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 80, 143, 0.2);
}

.btn-outline-primary {
    color: var(--primary-color);
    border-color: var(--primary-color);
}

.btn-outline-primary:hover {
    background: var(--primary-color);
    border-color: var(--primary-color);
}

/* Card Styles */
.card {
    border-radius: 12px;
}

.card-header {
    border-radius: 12px 12px 0 0 !important;
}

/* ========================================
   SISTEMA DE NOTIFICACIONES MEJORADO
   ======================================== */
.custom-notification {
    position: fixed;
    top: 20px;
    right: -400px;
    width: 380px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    z-index: 99999;
    transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    overflow: hidden;
    border: 2px solid transparent;
}

.custom-notification.show {
    right: 20px;
}

.custom-notification-success {
    border-color: #10b981;
}

.custom-notification-error {
    border-color: #ef4444;
}

.custom-notification-warning {
    border-color: #fbbf24;
}

.custom-notification-info {
    border-color: #3b82f6;
}

.notification-content {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1.25rem;
}

.notification-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.custom-notification-success .notification-icon {
    background: rgba(16, 185, 129, 0.15);
    color: #10b981;
}

.custom-notification-error .notification-icon {
    background: rgba(239, 68, 68, 0.15);
    color: #ef4444;
}

.custom-notification-warning .notification-icon {
    background: rgba(251, 191, 36, 0.15);
    color: #fbbf24;
}

.custom-notification-info .notification-icon {
    background: rgba(59, 130, 246, 0.15);
    color: #3b82f6;
}

.notification-text {
    flex: 1;
}

.notification-title {
    font-size: 1rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.notification-message {
    font-size: 0.875rem;
    color: #64748b;
    margin: 0;
    line-height: 1.5;
}

.notification-close {
    background: none;
    border: none;
    color: #94a3b8;
    cursor: pointer;
    padding: 0;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    transition: all 0.2s;
    flex-shrink: 0;
    font-size: 1.1rem;
}

.notification-close:hover {
    background: #f1f5f9;
    color: #475569;
}

.notification-progress {
    height: 4px;
    background: #e2e8f0;
    position: relative;
    overflow: hidden;
}

.notification-progress::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    animation: progress 5s linear;
}

.custom-notification-success .notification-progress::after {
    background: #10b981;
}

.custom-notification-error .notification-progress::after {
    background: #ef4444;
}

.custom-notification-warning .notification-progress::after {
    background: #fbbf24;
}

.custom-notification-info .notification-progress::after {
    background: #3b82f6;
}

@keyframes progress {
    from {
        transform: translateX(-100%);
    }
    to {
        transform: translateX(0);
    }
}

/* ========================================
   MODAL DE CONFIRMACIÓN PERSONALIZADO
   ======================================== */
.custom-confirm-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 100000;
    opacity: 0;
    transition: opacity 0.3s ease;
    backdrop-filter: blur(4px);
}

.custom-confirm-modal-overlay.show {
    opacity: 1;
}

.custom-confirm-modal {
    background: white;
    border-radius: 16px;
    padding: 2.5rem;
    max-width: 450px;
    width: 90%;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    transform: scale(0.9);
    transition: transform 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    text-align: center;
}

.custom-confirm-modal-overlay.show .custom-confirm-modal {
    transform: scale(1);
}

.custom-confirm-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    margin: 0 auto 1.5rem;
}

.custom-confirm-modal-success .custom-confirm-icon {
    background: rgba(16, 185, 129, 0.15);
}

.custom-confirm-modal-error .custom-confirm-icon {
    background: rgba(239, 68, 68, 0.15);
}

.custom-confirm-modal-warning .custom-confirm-icon {
    background: rgba(251, 191, 36, 0.15);
}

.custom-confirm-modal-info .custom-confirm-icon {
    background: rgba(59, 130, 246, 0.15);
}

.custom-confirm-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.75rem;
}

.custom-confirm-message {
    font-size: 1rem;
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 2rem;
}

.custom-confirm-actions {
    display: flex;
    gap: 0.75rem;
    justify-content: center;
}

.custom-confirm-btn {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.938rem;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 120px;
}

.custom-confirm-btn-cancel {
    background: #f1f5f9;
    color: #475569;
}

.custom-confirm-btn-cancel:hover {
    background: #e2e8f0;
    transform: translateY(-2px);
}

.custom-confirm-btn-confirm {
    color: white;
}

.custom-confirm-btn-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.custom-confirm-btn-success:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
}

.custom-confirm-btn-error {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

.custom-confirm-btn-error:hover {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(239, 68, 68, 0.4);
}

.custom-confirm-btn-warning {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    box-shadow: 0 4px 12px rgba(251, 191, 36, 0.3);
}

.custom-confirm-btn-warning:hover {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(251, 191, 36, 0.4);
}

.custom-confirm-btn-info {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.custom-confirm-btn-info:hover {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4);
}

/* Responsive ajustes */
@media (max-width: 1200px) {
    .matriculas-pendientes-grid {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1rem;
    }
}

@media (max-width: 768px) {
    .welcome-card {
        padding: 1.5rem;
    }

    .welcome-title {
        font-size: 1.5rem;
    }

    .stat-value {
        font-size: 1.75rem;
    }

    .matriculas-pendientes-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .matricula-header {
        padding: 0.75rem;
    }

    .codigo-badge {
        font-size: 0.75rem;
        padding: 0.35rem 0.65rem;
    }

    .estado-badge {
        font-size: 0.7rem;
        padding: 0.35rem 0.65rem;
    }

    .matricula-content {
        padding: 1rem;
        gap: 0.875rem;
    }

    .info-icon {
        width: 38px;
        height: 38px;
        font-size: 1rem;
    }

    .info-value {
        font-size: 0.875rem;
    }

    .info-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }

    .custom-notification {
        width: calc(100% - 40px);
        right: -100%;
    }

    .custom-notification.show {
        right: 20px;
    }

    .custom-confirm-modal {
        padding: 1.5rem;
        max-width: calc(100% - 40px);
    }

    .custom-confirm-icon {
        width: 64px;
        height: 64px;
        font-size: 2rem;
    }

    .custom-confirm-title {
        font-size: 1.25rem;
    }

    .custom-confirm-actions {
        flex-direction: column;
    }

    .custom-confirm-btn {
        width: 100%;
    }
}

@media (max-width: 480px) {
    .matricula-header {
        flex-direction: column;
        align-items: stretch;
        gap: 0.5rem;
    }

    .codigo-badge,
    .estado-badge {
        justify-content: center;
    }
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
    const timeElement = document.getElementById('currentTime');
    if (timeElement) {
        timeElement.textContent = `${hours}:${minutes}:${seconds}`;
    }
}

setInterval(updateTime, 1000);
updateTime();

// ========================================
// SISTEMA DE NOTIFICACIONES MEJORADO
// ========================================
function showNotification(type, title, message) {
    const existingNotification = document.querySelector('.custom-notification');
    if (existingNotification) {
        existingNotification.remove();
    }

    const notification = document.createElement('div');
    notification.className = `custom-notification custom-notification-${type}`;

    const icons = {
        success: 'fa-check-circle',
        error: 'fa-times-circle',
        warning: 'fa-exclamation-triangle',
        info: 'fa-info-circle'
    };

    notification.innerHTML = `
        <div class="notification-content">
            <div class="notification-icon">
                <i class="fas ${icons[type]}"></i>
            </div>
            <div class="notification-text">
                <h6 class="notification-title">${title}</h6>
                <p class="notification-message">${message}</p>
            </div>
            <button class="notification-close" onclick="closeNotification(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="notification-progress"></div>
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.classList.add('show');
    }, 10);

    setTimeout(() => {
        closeNotification(notification.querySelector('.notification-close'));
    }, 5000);
}

function closeNotification(button) {
    const notification = button.closest('.custom-notification');
    if (notification) {
        notification.classList.remove('show');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }
}

// ========================================
// MODAL DE CONFIRMACIÓN PERSONALIZADO
// ========================================
function showConfirmModal(title, message, onConfirm, type = 'warning') {
    const existingModal = document.querySelector('.custom-confirm-modal-overlay');
    if (existingModal) {
        existingModal.remove();
    }

    const overlay = document.createElement('div');
    overlay.className = 'custom-confirm-modal-overlay';

    const icons = {
        success: 'fa-check-circle',
        error: 'fa-times-circle',
        warning: 'fa-exclamation-triangle',
        info: 'fa-info-circle'
    };

    const colors = {
        success: '#10b981',
        error: '#ef4444',
        warning: '#ffc107',
        info: '#3b82f6'
    };

    overlay.innerHTML = `
        <div class="custom-confirm-modal custom-confirm-modal-${type}">
            <div class="custom-confirm-icon" style="color: ${colors[type]}">
                <i class="fas ${icons[type]}"></i>
            </div>
            <h4 class="custom-confirm-title">${title}</h4>
            <p class="custom-confirm-message">${message}</p>
            <div class="custom-confirm-actions">
                <button class="custom-confirm-btn custom-confirm-btn-cancel" onclick="closeConfirmModal()">
                    <i class="fas fa-times me-2"></i>Cancelar
                </button>
                <button class="custom-confirm-btn custom-confirm-btn-confirm custom-confirm-btn-${type}" onclick="confirmModalAction()">
                    <i class="fas fa-check me-2"></i>Confirmar
                </button>
            </div>
        </div>
    `;

    document.body.appendChild(overlay);
    window.currentModalCallback = onConfirm;

    setTimeout(() => {
        overlay.classList.add('show');
    }, 10);

    document.addEventListener('keydown', function escHandler(e) {
        if (e.key === 'Escape') {
            closeConfirmModal();
            document.removeEventListener('keydown', escHandler);
        }
    });
}

function closeConfirmModal() {
    const modal = document.querySelector('.custom-confirm-modal-overlay');
    if (modal) {
        modal.classList.remove('show');
        setTimeout(() => {
            modal.remove();
        }, 300);
    }
    window.currentModalCallback = null;
}

function confirmModalAction() {
    if (window.currentModalCallback) {
        window.currentModalCallback();
    }
    closeConfirmModal();
}

// ========================================
// EVENT LISTENERS CON DELEGACIÓN DE EVENTOS
// ========================================

// Ver detalles de matrícula
document.addEventListener('click', function(e) {
    if (e.target.closest('.btn-ver-detalles')) {
        e.preventDefault();
        const btn = e.target.closest('.btn-ver-detalles');
        const matriculaId = btn.getAttribute('data-matricula-id');
        console.log('Botón clickeado, ID:', matriculaId);
        verDetallesMatricula(matriculaId);
    }
});

// ========================================
// FUNCIONES PARA MATRÍCULAS
// ========================================

function verDetallesMatricula(matriculaId) {
    console.log('Abriendo detalles de matrícula:', matriculaId);

    const modalElement = document.getElementById('modalDetallesMatricula');
    if (!modalElement) {
        console.error('Modal no encontrado');
        showNotification('error', 'Error', 'No se pudo abrir el modal de detalles');
        return;
    }

    const modal = new bootstrap.Modal(modalElement);
    const contenido = document.getElementById('contenidoDetallesMatricula');

    contenido.innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="mt-3 text-muted fw-medium">Cargando información de la solicitud...</p>
        </div>
    `;

    modal.show();

    const url = `/matriculas/${matriculaId}/detalles`;
    console.log('Fetching:', url);

    fetch(url)
        .then(response => {
            console.log('Status:', response.status);
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Datos recibidos:', data);

            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            contenido.innerHTML = `
                <div class="row g-4">
                    <!-- Encabezado con código -->
                    <div class="col-12">
                        <div class="alert alert-primary border-0 d-flex align-items-center" style="background: linear-gradient(135deg, rgba(78, 199, 210, 0.1) 0%, rgba(0, 80, 143, 0.1) 100%); border-left: 4px solid #00508f !important;">
                            <i class="fas fa-file-alt fa-2x me-3" style="color: #00508f;"></i>
                            <div>
                                <strong style="color: #003b73; font-size: 1.1rem;">Código de Matrícula:</strong>
                                <h5 class="mb-0 mt-1" style="color: #00508f; font-weight: 700;">${data.matricula.codigo}</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Información del Estudiante -->
                    <div class="col-12">
                        <div class="card border-0 shadow-sm" style="border-radius: 12px; background: linear-gradient(135deg, rgba(0, 80, 143, 0.03) 0%, rgba(78, 199, 210, 0.03) 100%);">
                            <div class="card-header bg-transparent border-0 pt-4 px-4">
                                <h6 class="fw-bold mb-0" style="color: #003b73; font-size: 1.1rem;">
                                    <i class="fas fa-user-graduate me-2"></i>Información del Estudiante
                                </h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="text-muted small fw-semibold mb-1">Nombre Completo</label>
                                        <p class="mb-0 fw-bold" style="color: #003b73; font-size: 1.05rem;">${data.estudiante.nombre_completo}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="text-muted small fw-semibold mb-1">DNI</label>
                                        <p class="mb-0 fw-semibold" style="color: #00508f;"><i class="fas fa-id-card me-1"></i>${data.estudiante.dni}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="text-muted small fw-semibold mb-1">Fecha de Nacimiento</label>
                                        <p class="mb-0 fw-semibold" style="color: #00508f;"><i class="fas fa-birthday-cake me-1"></i>${data.estudiante.fecha_nacimiento}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="text-muted small fw-semibold mb-1">Sexo</label>
                                        <p class="mb-0 fw-semibold" style="color: #00508f;"><i class="fas fa-venus-mars me-1"></i>${data.estudiante.sexo}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="text-muted small fw-semibold mb-1">Grado</label>
                                        <p class="mb-0"><span class="badge bg-primary" style="font-size: 0.95rem; padding: 0.5rem 1rem;">${data.estudiante.grado}</span></p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="text-muted small fw-semibold mb-1">Sección</label>
                                        <p class="mb-0"><span class="badge bg-info" style="font-size: 0.95rem; padding: 0.5rem 1rem;">Sección ${data.estudiante.seccion}</span></p>
                                    </div>
                                    ${data.estudiante.email ? `
                                    <div class="col-md-6">
                                        <label class="text-muted small fw-semibold mb-1">Email</label>
                                        <p class="mb-0 fw-semibold" style="color: #00508f;"><i class="fas fa-envelope me-1"></i>${data.estudiante.email}</p>
                                    </div>
                                    ` : ''}
                                    ${data.estudiante.telefono ? `
                                    <div class="col-md-6">
                                        <label class="text-muted small fw-semibold mb-1">Teléfono</label>
                                        <p class="mb-0 fw-semibold" style="color: #00508f;"><i class="fas fa-phone me-1"></i>${data.estudiante.telefono}</p>
                                    </div>
                                    ` : ''}
                                    ${data.estudiante.direccion ? `
                                    <div class="col-12">
                                        <label class="text-muted small fw-semibold mb-1">Dirección</label>
                                        <p class="mb-0 fw-semibold" style="color: #00508f;"><i class="fas fa-map-marker-alt me-1"></i>${data.estudiante.direccion}</p>
                                    </div>
                                    ` : ''}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información del Padre -->
                    <div class="col-12">
                        <div class="card border-0 shadow-sm" style="border-radius: 12px; background: linear-gradient(135deg, rgba(78, 199, 210, 0.03) 0%, rgba(0, 80, 143, 0.03) 100%);">
                            <div class="card-header bg-transparent border-0 pt-4 px-4">
                                <h6 class="fw-bold mb-0" style="color: #003b73; font-size: 1.1rem;">
                                    <i class="fas fa-user-friends me-2"></i>Información del Padre/Tutor
                                </h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="text-muted small fw-semibold mb-1">Nombre Completo</label>
                                        <p class="mb-0 fw-bold" style="color: #003b73; font-size: 1.05rem;">${data.padre.nombre_completo}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="text-muted small fw-semibold mb-1">DNI</label>
                                        <p class="mb-0 fw-semibold" style="color: #00508f;"><i class="fas fa-id-card me-1"></i>${data.padre.dni}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="text-muted small fw-semibold mb-1">Parentesco</label>
                                        <p class="mb-0"><span class="badge bg-secondary" style="font-size: 0.9rem; padding: 0.5rem 0.75rem;">${data.padre.parentesco}</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-muted small fw-semibold mb-1">Email</label>
                                        <p class="mb-0 fw-semibold" style="color: #00508f;"><i class="fas fa-envelope me-1"></i>${data.padre.correo || 'No proporcionado'}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-muted small fw-semibold mb-1">Teléfono</label>
                                        <p class="mb-0 fw-semibold" style="color: #00508f;"><i class="fas fa-phone me-1"></i>${data.padre.telefono}</p>
                                    </div>
                                    <div class="col-12">
                                        <label class="text-muted small fw-semibold mb-1">Dirección</label>
                                        <p class="mb-0 fw-semibold" style="color: #00508f;"><i class="fas fa-map-marker-alt me-1"></i>${data.padre.direccion}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información de Matrícula -->
                    <div class="col-12">
                        <div class="card border-0 shadow-sm" style="border-radius: 12px; background: linear-gradient(135deg, rgba(78, 199, 210, 0.03) 0%, rgba(0, 59, 115, 0.03) 100%);">
                            <div class="card-header bg-transparent border-0 pt-4 px-4">
                                <h6 class="fw-bold mb-0" style="color: #003b73; font-size: 1.1rem;">
                                    <i class="fas fa-clipboard-list me-2"></i>Datos de la Matrícula
                                </h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="text-muted small fw-semibold mb-1">Año Lectivo</label>
                                        <p class="mb-0 fw-bold" style="color: #003b73; font-size: 1.2rem;"><i class="fas fa-calendar-alt me-2"></i>${data.matricula.anio_lectivo}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-muted small fw-semibold mb-1">Fecha de Matrícula</label>
                                        <p class="mb-0 fw-semibold" style="color: #00508f;"><i class="fas fa-calendar me-1"></i>${data.matricula.fecha_matricula}</p>
                                    </div>
                                    ${data.matricula.observaciones ? `
                                    <div class="col-12">
                                        <label class="text-muted small fw-semibold mb-1">Observaciones</label>
                                        <div class="alert alert-info border-0 mb-0" style="background: rgba(78, 199, 210, 0.1); border-left: 4px solid #4ec7d2 !important;">
                                            <i class="fas fa-comment-alt me-2"></i>${data.matricula.observaciones}
                                        </div>
                                    </div>
                                    ` : ''}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción con diseño mejorado -->
                    <div class="col-12">
                        <div class="card border-0 shadow-sm" style="background: #f8f9fa; border-radius: 12px;">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-3" style="color: #003b73;">
                                    <i class="fas fa-tasks me-2"></i>Acciones Disponibles
                                </h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <form action="/matriculas/${matriculaId}/confirmar" method="POST" class="mb-0" id="formAprobarMatricula">
                                            <input type="hidden" name="_token" value="${csrfToken}">
                                            <button type="button" class="btn btn-success w-100 py-3 d-flex align-items-center justify-content-center btn-aprobar-matricula" style="font-size: 1.05rem; border-radius: 10px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);" data-matricula-id="${matriculaId}">
                                                <i class="fas fa-check-circle me-2" style="font-size: 1.3rem;"></i>
                                                <span class="fw-bold">Aprobar Matrícula</span>
                                            </button>
                                        </form>
                                        <small class="text-muted d-block mt-2 text-center">
                                            <i class="fas fa-info-circle me-1"></i>
                                            El estudiante será registrado en el sistema
                                        </small>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-danger w-100 py-3 d-flex align-items-center justify-content-center btn-rechazar-desde-modal" style="font-size: 1.05rem; border-radius: 10px; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);" data-matricula-id="${matriculaId}">
                                            <i class="fas fa-times-circle me-2" style="font-size: 1.3rem;"></i>
                                            <span class="fw-bold">Rechazar Matrícula</span>
                                        </button>
                                        <small class="text-muted d-block mt-2 text-center">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Se solicitará un motivo de rechazo
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        })
        .catch(error => {
            console.error('Error completo:', error);
            contenido.innerHTML = `
                <div class="alert alert-danger border-0 mx-4 my-5">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-exclamation-triangle fa-2x me-3 text-danger"></i>
                        <div>
                            <h6 class="alert-heading fw-bold">Error al cargar los detalles</h6>
                            <p class="mb-2">${error.message}</p>
                            <hr>
                            <small class="mb-0">Por favor, intente nuevamente o contacte al administrador del sistema.</small>
                        </div>
                    </div>
                </div>
            `;
        });
}

// Aprobar matrícula desde modal con confirmación
document.addEventListener('click', function(e) {
    if (e.target.closest('.btn-aprobar-matricula')) {
        e.preventDefault();
        const btn = e.target.closest('.btn-aprobar-matricula');
        const matriculaId = btn.getAttribute('data-matricula-id');

        showConfirmModal(
            '¿Aprobar Matrícula?',
            'El estudiante y padre serán registrados en el sistema inmediatamente.',
            function() {
                const form = document.getElementById('formAprobarMatricula');
                if (form) {
                    form.submit();
                }
            },
            'success'
        );
    }
});

// Botón rechazar desde modal
document.addEventListener('click', function(e) {
    if (e.target.closest('.btn-rechazar-desde-modal')) {
        e.preventDefault();
        const btn = e.target.closest('.btn-rechazar-desde-modal');
        const matriculaId = btn.getAttribute('data-matricula-id');

        const modalDetalles = bootstrap.Modal.getInstance(document.getElementById('modalDetallesMatricula'));
        if (modalDetalles) {
            modalDetalles.hide();
        }

        setTimeout(() => {
            mostrarModalRechazoMatricula(matriculaId);
        }, 400);
    }
});

function mostrarModalRechazoMatricula(matriculaId) {
    const form = document.getElementById('formRechazoMatricula');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    form.action = `/matriculas/${matriculaId}/rechazar`;

    document.getElementById('motivo_rechazo_matricula').value = '';

    const modal = new bootstrap.Modal(document.getElementById('modalRechazoMatricula'));
    modal.show();

    form.onsubmit = function(e) {
        e.preventDefault();
        const motivo = document.getElementById('motivo_rechazo_matricula').value.trim();

        if (!motivo) {
            showNotification('warning', 'Campo Requerido', 'Por favor, indique el motivo del rechazo.');
            return false;
        }

        if (motivo.length < 10) {
            showNotification('warning', 'Motivo Muy Corto', 'Por favor, proporcione un motivo más detallado (mínimo 10 caracteres).');
            return false;
        }

        showConfirmModal(
            '¿Rechazar Matrícula?',
            'Esta acción no se puede deshacer. El padre/tutor recibirá el motivo del rechazo.',
            function() {
                showNotification('warning', 'Procesando...', 'Rechazando matrícula, por favor espere.');

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: new URLSearchParams({
                        '_token': csrfToken,
                        'motivo_rechazo': motivo
                    })
                })
                .then(response => {
                    if (response.ok) {
                        modal.hide();
                        showNotification('success', 'Matrícula Rechazada', 'La solicitud ha sido rechazada correctamente.');
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        throw new Error('Error en la respuesta del servidor');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('error', 'Error', 'No se pudo rechazar la matrícula. Intente nuevamente.');
                });
            },
            'error'
        );

        return false;
    };
}

// DEBUG: Verificar que el evento se está capturando
console.log('Script cargado correctamente');

// Test manual del botón
setTimeout(function() {
    const botones = document.querySelectorAll('.btn-ver-detalles');
    console.log('Botones encontrados:', botones.length);

    botones.forEach(function(boton) {
        console.log('Botón con ID:', boton.getAttribute('data-matricula-id'));
    });
}, 1000);
</script>
@endpush
@endsection
