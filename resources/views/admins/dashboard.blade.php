@extends('layouts.app')

@section('title', 'Dashboard Administrador')
@section('page-title', 'Panel de Administración')

@section('topbar-actions')
    <div class="d-flex align-items-center gap-3">
        <span class="badge bg-primary" style="padding: .85rem .75rem; font-weight: 800;">
            <i class="fas fa-user-shield me-1"></i> Administrador
        </span>
    </div>
@endsection

@section('content')
<div class="container-fluid px-4">

    {{-- ── Bienvenida ── --}}
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

    {{-- ── Estadísticas principales ── --}}
    <div class="row g-4 mb-4">

        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-students">
                <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
                <div class="stat-content">
                    <h6 class="stat-label">Estudiantes Registrados</h6>
                    <h2 class="stat-value">{{ $totalEstudiantes ?? 0 }}</h2>
                    <div class="stat-footer">
                        <span class="stat-badge stat-badge-success">
                            <i class="fas fa-check-circle"></i>
                            {{ $estudiantesActivos ?? 0 }} Activos
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
                    <h2 class="stat-value">{{ $totalProfesores ?? 0 }}</h2>
                    <div class="stat-footer">
                        <span class="stat-badge stat-badge-info">
                            <i class="fas fa-check-circle"></i>
                            {{ $profesoresActivos ?? 0 }} En servicio
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
                    <h2 class="stat-value">{{ $totalMatriculas ?? 0 }}</h2>
                    <div class="stat-footer">
                        <span class="stat-badge stat-badge-warning">
                            <i class="fas fa-clock"></i>
                            {{ $matriculasPendientes ?? 0 }} Pendientes
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
                    <h2 class="stat-value">{{ $totalUsuarios ?? 0 }}</h2>
                    <div class="stat-footer">
                        <span class="stat-badge stat-badge-danger">
                            <i class="fas fa-user-shield"></i>
                            {{ $totalAdministradores ?? 0 }} Admins
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ── Solicitudes pendientes ── --}}
    @php
        $pendientesCol = isset($ultimasMatriculas)
            ? $ultimasMatriculas->where('estado', 'pendiente')
            : collect([]);
    @endphp

    @if($pendientesCol->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 border-warning-custom">
                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-bell text-warning me-2"></i>
                            Solicitudes de Matrícula Pendientes
                        </h5>
                        <div class="d-flex gap-2 align-items-center">
                            <span class="badge bg-warning text-dark" style="font-size:.9rem;padding:.5rem 1rem;">
                                <i class="fas fa-clock me-1"></i>
                                {{ $pendientesCol->count() }} {{ $pendientesCol->count() == 1 ? 'solicitud' : 'solicitudes' }}
                            </span>
                            <a href="{{ route('matriculas.index') }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-list me-1"></i> Ver Todas
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="matriculas-pendientes-grid">
                        @foreach($pendientesCol as $matricula)
                        <div class="matricula-card-compact">
                            <div class="matricula-header">
                                <span class="codigo-badge">
                                    <i class="fas fa-file-alt me-1"></i>{{ $matricula->codigo_matricula ?? 'MAT-'.$matricula->id }}
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
                                        <strong class="info-value">
                                            {{ $matricula->estudiante->nombre1 ?? '' }}
                                            {{ $matricula->estudiante->apellido1 ?? 'N/A' }}
                                        </strong>
                                        <small class="info-detail">DNI: {{ $matricula->estudiante->dni ?? 'N/A' }}</small>
                                    </div>
                                </div>
                                <div class="info-block">
                                    <div class="info-icon bg-parents"><i class="fas fa-user-friends"></i></div>
                                    <div class="info-text">
                                        <span class="info-label">Padre/Tutor</span>
                                        <strong class="info-value">
                                            {{ $matricula->padre->nombre ?? '' }}
                                            {{ $matricula->padre->apellido ?? 'N/A' }}
                                        </strong>
                                        <small class="info-detail">{{ $matricula->padre->telefono ?? 'Sin teléfono' }}</small>
                                    </div>
                                </div>
                                <div class="info-row">
                                    <div class="info-item">
                                        <i class="fas fa-graduation-cap text-primary me-1"></i>
                                        <span class="badge bg-info">
                                            {{ $matricula->estudiante->grado ?? 'Sin grado' }}
                                            @if($matricula->estudiante->seccion ?? null)
                                                - Sec. {{ $matricula->estudiante->seccion }}
                                            @endif
                                        </span>
                                    </div>
                                    <div class="info-item">
                                        <i class="fas fa-calendar-alt text-muted me-1"></i>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($matricula->fecha_matricula ?? $matricula->created_at)->format('d/m/Y') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="matricula-footer">
                                <button type="button"
                                        class="btn btn-primary btn-ver-detalles w-100"
                                        data-matricula-id="{{ $matricula->id }}"
                                        data-url="{{ route('matriculas.detalles', $matricula->id) }}"
                                        data-confirmar-url="{{ route('matriculas.confirmar', $matricula->id) }}"
                                        data-rechazar-url="{{ route('matriculas.rechazar', $matricula->id) }}">
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

    {{-- ── Gestión Académica ── --}}
    <div class="row mb-3">
        <div class="col-12">
            <h5 class="section-title"><i class="fas fa-tasks me-2"></i>Gestión Académica</h5>
        </div>
    </div>

    <div class="row g-4 mb-4">

        <div class="col-lg-4 col-md-6">
            <div class="action-card">
                <div class="action-card-header">
                    <div class="action-icon bg-students"><i class="fas fa-user-graduate"></i></div>
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

        <div class="col-lg-4 col-md-6">
            <div class="action-card">
                <div class="action-card-header">
                    <div class="action-icon bg-teachers"><i class="fas fa-chalkboard-teacher"></i></div>
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

        <div class="col-lg-4 col-md-6">
            <div class="action-card">
                <div class="action-card-header">
                    <div class="action-icon bg-parents"><i class="fas fa-users"></i></div>
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

        <div class="col-lg-4 col-md-6">
            <div class="action-card">
                <div class="action-card-header">
                    <div class="action-icon bg-enrollments"><i class="fas fa-file-signature"></i></div>
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

        <div class="col-lg-4 col-md-6">
            <div class="action-card">
                <div class="action-card-header">
                    <div class="action-icon bg-academic"><i class="fas fa-graduation-cap"></i></div>
                    <div>
                        <h6 class="action-title">Plan Académico</h6>
                        <p class="action-subtitle">Grados y materias</p>
                    </div>
                </div>
                <div class="action-card-body">
                    <a href="{{ route('grados.index') }}" class="btn btn-outline-primary w-100 mb-2">
                        <i class="fas fa-layer-group me-2"></i> Grados
                    </a>
                    <a href="{{ route('materias.index') }}" class="btn btn-primary w-100">
                        <i class="fas fa-book me-2"></i> Materias
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="action-card">
                <div class="action-card-header">
                    <div class="action-icon bg-info text-white"><i class="fas fa-clock"></i></div>
                    <div>
                        <h6 class="action-title">Horarios y Permisos</h6>
                        <p class="action-subtitle">Horarios y accesos de padres</p>
                    </div>
                </div>
                <div class="action-card-body">
                    <a href="{{ route('horarios_grado.index') }}" class="btn btn-outline-primary w-100 mb-2">
                        <i class="fas fa-list me-2"></i> Ver Horarios
                    </a>
                    <a href="{{ route('admins.permisos.index') }}" class="btn btn-primary w-100">
                        <i class="fas fa-user-lock me-2"></i> Permisos Padres
                    </a>
                </div>
            </div>
        </div>

    </div>

    {{-- ── Últimas matrículas + Grados ── --}}
    <div class="row g-4">

        <div class="col-lg-8">
            <div class="card shadow-sm border-0" style="border-radius:12px;">
                <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 fw-bold" style="color:#003b73;">
                        <i class="fas fa-clipboard-list me-2 text-info"></i>Últimas Matrículas
                    </h6>
                    <a href="{{ route('matriculas.index') }}" class="btn btn-sm btn-outline-primary">
                        Ver todas <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    @if(isset($ultimasMatriculas) && $ultimasMatriculas->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead style="background:#f8fafc;">
                                <tr>
                                    <th>Estudiante</th>
                                    <th>Grado</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ultimasMatriculas as $m)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div style="width:32px;height:32px;border-radius:50%;
                                                        background:linear-gradient(135deg,#4ec7d2,#00508f);
                                                        display:flex;align-items:center;justify-content:center;
                                                        color:white;font-weight:700;font-size:.8rem;flex-shrink:0;">
                                                {{ strtoupper(substr($m->estudiante->nombre1 ?? 'E', 0, 1)) }}
                                            </div>
                                            <span class="fw-semibold" style="color:#1e293b;font-size:.88rem;">
                                                {{ $m->estudiante->nombre1 ?? '' }} {{ $m->estudiante->apellido1 ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td style="color:#64748b;font-size:.88rem;">{{ $m->estudiante->grado ?? '—' }}</td>
                                    <td>
                                        @php $estado = $m->estado ?? 'pendiente'; @endphp
                                        @if($estado == 'aprobada')
                                            <span style="padding:.3rem .7rem;border-radius:20px;font-size:.72rem;font-weight:600;background:rgba(16,185,129,.12);color:#059669;">Aprobada</span>
                                        @elseif($estado == 'pendiente')
                                            <span style="padding:.3rem .7rem;border-radius:20px;font-size:.72rem;font-weight:600;background:rgba(245,158,11,.12);color:#d97706;">Pendiente</span>
                                        @else
                                            <span style="padding:.3rem .7rem;border-radius:20px;font-size:.72rem;font-weight:600;background:rgba(239,68,68,.12);color:#dc2626;">{{ ucfirst($estado) }}</span>
                                        @endif
                                    </td>
                                    <td style="color:#94a3b8;font-size:.8rem;">{{ $m->created_at?->format('d/m/Y') ?? '—' }}</td>
                                    <td>
                                        <a href="{{ route('matriculas.show', $m->id) }}"
                                           class="btn btn-sm btn-outline-primary" style="font-size:.75rem;border-radius:6px;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-inbox d-block mb-2" style="font-size:2rem;"></i>
                        Sin matrículas registradas
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100" style="border-radius:12px;">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold" style="color:#003b73;">
                        <i class="fas fa-layer-group me-2 text-info"></i>Estudiantes por Grado
                    </h6>
                </div>
                <div class="card-body p-3">
                    @php $maxGrado = isset($estudiantesPorGrado) ? ($estudiantesPorGrado->max('total') ?: 1) : 1; @endphp
                    @if(isset($estudiantesPorGrado) && $estudiantesPorGrado->isNotEmpty())
                        @foreach($estudiantesPorGrado as $g)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span style="font-size:.83rem;font-weight:600;color:#374151;">Grado {{ $g->grado }}</span>
                                <span style="font-size:.83rem;color:#64748b;">{{ $g->total }}</span>
                            </div>
                            <div style="height:8px;background:#f1f5f9;border-radius:99px;overflow:hidden;">
                                <div style="height:100%;border-radius:99px;
                                            background:linear-gradient(90deg,#4ec7d2,#00508f);
                                            width:{{ ($g->total/$maxGrado)*100 }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    @else
                    <div class="text-center py-3 text-muted">
                        <i class="fas fa-inbox mb-2 d-block"></i> Sin datos
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

</div>

{{-- ── Modal: Detalles de Matrícula ── --}}
<div class="modal fade" id="modalDetallesMatricula" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content" style="border-radius:12px;">
            <div class="modal-header border-0"
                 style="background:linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);
                        color:white;border-radius:12px 12px 0 0;">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-file-alt me-2"></i>Detalles de la Solicitud de Matrícula
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="contenidoDetallesMatricula"></div>
        </div>
    </div>
</div>

{{-- ── Modal: Rechazar Matrícula ── --}}
<div class="modal fade" id="modalRechazoMatricula" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:12px;">
            <div class="modal-header border-0"
                 style="background:linear-gradient(135deg,#ef4444 0%,#dc2626 100%);
                        color:white;border-radius:12px 12px 0 0;">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-times-circle me-2"></i>Rechazar Solicitud de Matrícula
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formRechazoMatricula" method="POST" action="#">
                @csrf
                <div class="modal-body p-4">
                    <div class="alert alert-warning border-0 mb-3"
                         style="background:rgba(255,193,7,.1);border-left:4px solid #ffc107 !important;">
                        <i class="fas fa-exclamation-triangle me-2" style="color:#ffc107;"></i>
                        <strong>Atención:</strong> Esta acción rechazará permanentemente la solicitud.
                        <br><small class="text-muted">El padre/tutor recibirá una notificación con el motivo.</small>
                    </div>
                    <div class="mb-3">
                        <label for="motivo_rechazo_matricula" class="form-label fw-semibold">
                            Motivo del Rechazo <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" id="motivo_rechazo_matricula"
                                  name="motivo_rechazo" rows="5" required minlength="10"
                                  placeholder="Ej: Documentación incompleta, datos incorrectos, cupo agotado..."
                                  style="border:2px solid #dee2e6;border-radius:8px;"></textarea>
                        <small class="text-muted">Mínimo 10 caracteres. Quedará registrado en el sistema.</small>
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
    --light-bg: #f8fafc;
    --border-color: #e2e8f0;
}

.welcome-card {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    border-radius: 16px; padding: 2rem; color: white;
    box-shadow: 0 4px 6px rgba(0,80,143,.1);
}
.welcome-title   { font-size:1.75rem; font-weight:700; margin-bottom:.5rem; color:white; }
.welcome-subtitle { font-size:1rem; opacity:.9; }

.stat-card {
    background: white; border-radius: 12px; padding: 1.5rem;
    box-shadow: 0 2px 4px rgba(0,0,0,.05); border: 1px solid var(--border-color);
    transition: all .3s ease; height: 100%;
    display: flex; gap: 1rem; align-items: flex-start;
}
.stat-card:hover { transform: translateY(-4px); box-shadow: 0 8px 16px rgba(0,80,143,.1); }
.stat-icon {
    width: 60px; height: 60px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem; flex-shrink: 0;
}
.stat-card-students   .stat-icon { background: rgba(78,199,210,.1);  color: var(--secondary-color); }
.stat-card-teachers   .stat-icon { background: rgba(0,80,143,.1);    color: var(--primary-color); }
.stat-card-enrollments .stat-icon { background: rgba(251,191,36,.1); color: var(--accent-color); }
.stat-card-users      .stat-icon { background: rgba(239,68,68,.1);   color: var(--danger-color); }
.stat-content { flex: 1; }
.stat-label {
    font-size: .875rem; color: #64748b; font-weight: 600;
    text-transform: uppercase; letter-spacing: .5px; margin-bottom: .5rem;
}
.stat-value  { font-size: 2rem; font-weight: 700; color: var(--primary-color); margin-bottom: 1rem; }
.stat-footer { padding-top: 1rem; border-top: 1px solid var(--border-color); }
.stat-badge  {
    display: inline-flex; align-items: center; gap: .5rem;
    padding: .375rem .75rem; border-radius: 6px; font-size: .813rem; font-weight: 500;
}
.stat-badge-success { background: rgba(16,185,129,.1);  color: var(--success-color); }
.stat-badge-info    { background: rgba(0,80,143,.1);    color: var(--primary-color); }
.stat-badge-warning { background: rgba(251,191,36,.1);  color: var(--accent-color); }
.stat-badge-danger  { background: rgba(239,68,68,.1);   color: var(--danger-color); }

.border-warning-custom { border: 2px solid #ffc107 !important; border-radius: 12px; }
.matriculas-pendientes-grid {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(320px,1fr)); gap: 1.25rem;
}
.matricula-card-compact {
    background: white; border: 2px solid #e2e8f0; border-radius: 12px;
    overflow: hidden; transition: all .3s ease; display: flex; flex-direction: column;
}
.matricula-card-compact:hover {
    border-color: #4ec7d2; box-shadow: 0 8px 20px rgba(0,80,143,.15); transform: translateY(-4px);
}
.matricula-header {
    background: linear-gradient(135deg,#f8f9fa,#e9ecef);
    padding: .875rem 1rem; display: flex; justify-content: space-between;
    align-items: center; border-bottom: 2px solid #e2e8f0; gap: .5rem; flex-wrap: wrap;
}
.codigo-badge {
    background: linear-gradient(135deg,#4ec7d2,#00508f); color: white;
    padding: .4rem .75rem; border-radius: 6px; font-size: .813rem;
    font-weight: 700; display: inline-flex; align-items: center;
}
.estado-badge {
    background: #ffc107; color: #000; padding: .4rem .75rem; border-radius: 6px;
    font-size: .75rem; font-weight: 600; display: inline-flex; align-items: center;
}
.matricula-content { padding: 1.25rem; flex: 1; display: flex; flex-direction: column; gap: 1rem; }
.info-block { display: flex; gap: .875rem; align-items: flex-start; }
.info-icon {
    width: 42px; height: 42px; border-radius: 10px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; font-size: 1.1rem; color: white;
}
.bg-students { background: var(--secondary-color); }
.bg-parents  { background: #6366f1; }
.info-text { flex: 1; display: flex; flex-direction: column; gap: .125rem; min-width: 0; }
.info-label { font-size: .7rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; }
.info-value { font-size: .938rem; color: #003b73; font-weight: 700; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.info-detail { font-size: .75rem; color: #64748b; }
.info-row { display: flex; justify-content: space-between; padding-top: .75rem; border-top: 1px solid #e2e8f0; flex-wrap: wrap; gap: .75rem; }
.info-item { display: flex; align-items: center; gap: .25rem; font-size: .813rem; }
.matricula-footer { padding: 0 1rem 1rem 1rem; }
.matricula-footer .btn { font-size: .875rem; font-weight: 600; padding: .625rem 1rem; border-radius: 8px; transition: all .3s ease; }
.matricula-footer .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,80,143,.3); }

.section-title {
    font-size: 1.25rem; font-weight: 700; color: var(--primary-color);
    margin-bottom: 0; padding-bottom: .75rem; border-bottom: 2px solid var(--border-color);
}
.action-card {
    background: white; border-radius: 12px; border: 1px solid var(--border-color);
    overflow: hidden; transition: all .3s ease; height: 100%;
}
.action-card:hover { transform: translateY(-4px); box-shadow: 0 8px 16px rgba(0,80,143,.1); border-color: var(--primary-color); }
.action-card-header {
    display: flex; align-items: center; gap: 1rem; padding: 1.5rem;
    background: var(--light-bg); border-bottom: 1px solid var(--border-color);
}
.action-icon {
    width: 48px; height: 48px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center; font-size: 1.25rem; color: white;
}
.bg-teachers    { background: var(--primary-color); }
.bg-enrollments { background: var(--accent-color); }
.bg-academic    { background: var(--success-color); }
.action-title    { font-size: 1rem; font-weight: 700; color: var(--primary-color); margin-bottom: .25rem; }
.action-subtitle { font-size: .813rem; color: #64748b; margin-bottom: 0; }
.action-card-body { padding: 1.5rem; }

.table th { font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #64748b; padding: .75rem 1rem; }
.table td { padding: .75rem 1rem; vertical-align: middle; }
.table tbody tr { border-bottom: 1px solid #f8fafc; transition: background .15s; }
.table tbody tr:hover { background: #f8fafc; }

.btn { font-weight: 500; border-radius: 8px; padding: .5rem 1rem; transition: all .3s ease; }
.btn-primary { background: var(--primary-color); border-color: var(--primary-color); }
.btn-primary:hover { background: #003b73; border-color: #003b73; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,80,143,.2); }
.btn-outline-primary { color: var(--primary-color); border-color: var(--primary-color); }
.btn-outline-primary:hover { background: var(--primary-color); border-color: var(--primary-color); }

@media (max-width: 768px) {
    .welcome-card { padding: 1.5rem; }
    .welcome-title { font-size: 1.5rem; }
    .stat-value { font-size: 1.75rem; }
    .matriculas-pendientes-grid { grid-template-columns: 1fr; }
}
</style>
@endpush

@push('scripts')
<script>
(function () {
    'use strict';
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    function spinnerHtml(msg) {
        return `<div class="text-center py-5">
            <div class="spinner-border text-primary" style="width:3rem;height:3rem;" role="status"></div>
            <p class="mt-3 text-muted fw-medium">${msg}</p>
        </div>`;
    }

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-ver-detalles');
        if (!btn) return;
        e.preventDefault();
        abrirModalDetalles(btn.dataset.matriculaId, btn.dataset.url,
                           btn.dataset.confirmarUrl, btn.dataset.rechazarUrl);
    });

    function abrirModalDetalles(id, url, confirmarUrl, rechazarUrl) {
        const modalEl   = document.getElementById('modalDetallesMatricula');
        const contenido = document.getElementById('contenidoDetallesMatricula');
        if (!modalEl || !contenido) return;
        const modal = bootstrap.Modal.getOrCreate(modalEl);
        contenido.innerHTML = spinnerHtml('Cargando información de la matrícula...');
        modal.show();
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => { if (!r.ok) throw new Error('Error ' + r.status); return r.json(); })
            .then(data => { contenido.innerHTML = construirHtml(data, id, confirmarUrl, rechazarUrl); })
            .catch(err => { contenido.innerHTML = `<div class="alert alert-danger">${err.message}</div>`; });
    }

    function construirHtml(data, id, confirmarUrl, rechazarUrl) {
        const est = data.estudiante ?? {}, pad = data.padre ?? {}, mat = data.matricula ?? {};
        return `<div class="row g-4">
            <div class="col-12">
                <div class="alert alert-primary border-0">
                    <strong>Código de Matrícula:</strong>
                    <h5 class="mb-0 mt-1">${mat.codigo ?? '—'}</h5>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light"><h6 class="mb-0"><i class="fas fa-user-graduate me-2"></i>Estudiante</h6></div>
                    <div class="card-body">
                        <p class="mb-1"><strong>Nombre:</strong> ${est.nombre_completo ?? '—'}</p>
                        <p class="mb-1"><strong>DNI:</strong> ${est.dni ?? '—'}</p>
                        <p class="mb-1"><strong>F. Nacimiento:</strong> ${est.fecha_nacimiento ?? '—'}</p>
                        <p class="mb-0"><strong>Grado:</strong> <span class="badge bg-primary">${est.grado ?? 'Sin asignar'}</span></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light"><h6 class="mb-0"><i class="fas fa-user-friends me-2"></i>Padre/Tutor</h6></div>
                    <div class="card-body">
                        <p class="mb-1"><strong>Nombre:</strong> ${pad.nombre_completo ?? '—'}</p>
                        <p class="mb-1"><strong>DNI:</strong> ${pad.dni ?? '—'}</p>
                        <p class="mb-1"><strong>Teléfono:</strong> ${pad.telefono ?? '—'}</p>
                        <p class="mb-0"><strong>Email:</strong> ${pad.correo ?? '—'}</p>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row g-3">
                    <div class="col-md-6">
                        <form action="${confirmarUrl}" method="POST">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <button type="submit" class="btn btn-success w-100 py-3">
                                <i class="fas fa-check-circle me-2"></i><strong>Aprobar Matrícula</strong>
                            </button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-danger w-100 py-3 btn-rechazar-desde-modal"
                                data-matricula-id="${id}" data-rechazar-url="${rechazarUrl}">
                            <i class="fas fa-times-circle me-2"></i><strong>Rechazar Matrícula</strong>
                        </button>
                    </div>
                </div>
            </div>
        </div>`;
    }

    let abortController = null;

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-rechazar-desde-modal');
        if (!btn) return;
        e.preventDefault();
        const md = bootstrap.Modal.getInstance(document.getElementById('modalDetallesMatricula'));
        if (md) md.hide();
        setTimeout(() => mostrarModalRechazo(btn.dataset.matriculaId, btn.dataset.rechazarUrl), 350);
    });

    function mostrarModalRechazo(id, rechazarUrl) {
        const form     = document.getElementById('formRechazoMatricula');
        const textarea = document.getElementById('motivo_rechazo_matricula');
        const modalEl  = document.getElementById('modalRechazoMatricula');
        if (!form || !textarea || !modalEl) return;
        form.action    = rechazarUrl;
        textarea.value = '';
        if (abortController) abortController.abort();
        abortController = new AbortController();
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const motivo = textarea.value.trim();
            if (motivo.length < 10) { textarea.classList.add('is-invalid'); return; }
            textarea.classList.remove('is-invalid');
            if (!confirm('¿Confirmar rechazo?')) return;
            const btnSubmit = form.querySelector('[type="submit"]');
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Procesando...';
            fetch(rechazarUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded',
                           'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest' },
                body: new URLSearchParams({ '_token': csrfToken, 'motivo_rechazo': motivo })
            })
            .then(r => { if (!r.ok) throw new Error('Error ' + r.status); return r; })
            .then(() => {
                bootstrap.Modal.getInstance(modalEl)?.hide();
                setTimeout(() => location.reload(), 300);
            })
            .catch(err => {
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = '<i class="fas fa-ban me-1"></i>Confirmar Rechazo';
                alert('Error: ' + err.message);
            });
        }, { signal: abortController.signal });
        bootstrap.Modal.getOrCreate(modalEl).show();
    }
})();
</script>
@endpush

@endsection
