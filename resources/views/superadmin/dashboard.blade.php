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
        <span class="badge bg-primary" style="padding:.85rem .75rem;font-weight:800;">
            <i class="fas fa-user-shield me-1"></i> {{ $displayRole }}
        </span>
    </div>
@endsection

@section('content')
    <div class="container-fluid px-4">

        {{-- ── Bienvenida ── --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="welcome-avatar">
                            <i class="fas fa-school"></i>
                        </div>
                        <div>
                            <h2 class="welcome-title mb-1">
                                Bienvenido, {{ auth()->user()->name }}
                            </h2>
                            <p class="welcome-subtitle mb-0">
                                <i class="fas fa-circle-dot me-1" style="font-size:.6rem;"></i>
                                Sistema de Gestión Escolar · Gabriela Mistral
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Estadísticas ── --}}
        <div class="row g-3 mb-4">

            <div class="col-xl-3 col-md-6">
                <a href="{{ route('estudiantes.index') }}" class="stat-link">
                    <div class="stat-card stat-students">
                        <div class="stat-icon-wrap"><i class="fas fa-user-graduate"></i></div>
                        <div class="stat-body">
                            <span class="stat-label">Estudiantes</span>
                            <span class="stat-value">{{ $totalEstudiantes ?? \App\Models\Estudiante::count() }}</span>
                            <span class="stat-sub">
                            <i class="fas fa-check-circle me-1"></i>
                            {{ $estudiantesActivos ?? \App\Models\Estudiante::where('estado','activo')->count() }} activos
                        </span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-md-6">
                <a href="{{ route('profesores.index') }}" class="stat-link">
                    <div class="stat-card stat-teachers">
                        <div class="stat-icon-wrap"><i class="fas fa-chalkboard-teacher"></i></div>
                        <div class="stat-body">
                            <span class="stat-label">Profesores</span>
                            <span class="stat-value">{{ $totalProfesores ?? \App\Models\Profesor::count() }}</span>
                            <span class="stat-sub">
                            <i class="fas fa-check-circle me-1"></i>
                            {{ $profesoresActivos ?? \App\Models\Profesor::where('estado','activo')->count() }} en servicio
                        </span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-md-6">
                <a href="{{ route('matriculas.index') }}" class="stat-link">
                    <div class="stat-card stat-enrollments">
                        <div class="stat-icon-wrap"><i class="fas fa-file-signature"></i></div>
                        <div class="stat-body">
                            <span class="stat-label">Matrículas</span>
                            <span class="stat-value">{{ $totalMatriculas ?? \App\Models\Matricula::count() }}</span>
                            <span class="stat-sub">
                            <i class="fas fa-clock me-1"></i>
                            {{ $totalPendientes ?? 0 }} pendientes
                        </span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-md-6">
                <a href="{{ route('superadmin.usuarios.index') }}" class="stat-link">
                    <div class="stat-card stat-users">
                        <div class="stat-icon-wrap"><i class="fas fa-users-cog"></i></div>
                        <div class="stat-body">
                            <span class="stat-label">Usuarios</span>
                            <span class="stat-value">{{ $totalUsuarios ?? \App\Models\User::count() }}</span>
                            <span class="stat-sub">
                            <i class="fas fa-user-clock me-1"></i>
                            {{ $usuariosPorAprobar ?? \App\Models\User::where('activo', false)->count() }} por aprobar
                        </span>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        {{-- ── Solicitudes pendientes ── --}}
        @if(isset($matriculasPendientes) && $matriculasPendientes->count() > 0)
            <div class="row mb-4">
                <div class="col-12">
                    <div class="pending-panel">
                        <div class="pending-panel-header">
                            <div class="d-flex align-items-center gap-2">
                                <span class="pending-dot"></span>
                                <h5 class="mb-0 fw-700">Solicitudes de Matrícula Pendientes</h5>
                                <span class="badge-count">{{ $matriculasPendientes->count() }}</span>
                            </div>
                            <a href="{{ route('matriculas.index') }}" class="btn-link-custom">
                                <i class="fas fa-arrow-right me-1"></i>Ver todas
                            </a>
                        </div>

                        <div class="pending-grid">
                            @foreach($matriculasPendientes as $matricula)
                                <div class="pcard">
                                    <div class="pcard-top">
                            <span class="pcard-code">
                                <i class="fas fa-hashtag"></i>
                                {{ $matricula->codigo_matricula }}
                            </span>
                                        <span class="pcard-status">Pendiente</span>
                                    </div>

                                    <div class="pcard-body">
                                        <div class="pcard-person">
                                            <div class="pcard-avatar av-blue">
                                                {{ strtoupper(substr($matricula->estudiante->nombre1 ?? 'E', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="pcard-name">
                                                    {{ $matricula->estudiante->nombre1 ?? '' }}
                                                    {{ $matricula->estudiante->apellido1 ?? '' }}
                                                </div>
                                                <div class="pcard-meta">
                                                    <i class="fas fa-id-card me-1"></i>
                                                    DNI: {{ $matricula->estudiante->dni ?? 'N/A' }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="pcard-person">
                                            <div class="pcard-avatar av-purple">
                                                {{ strtoupper(substr($matricula->padre->nombre ?? 'P', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="pcard-name">
                                                    {{ $matricula->padre->nombre ?? '' }}
                                                    {{ $matricula->padre->apellido ?? '' }}
                                                </div>
                                                <div class="pcard-meta">
                                                    <i class="fas fa-phone me-1"></i>
                                                    {{ $matricula->padre->telefono ?? 'Sin teléfono' }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="pcard-chips">
                                <span class="chip chip-blue">
                                    <i class="fas fa-graduation-cap me-1"></i>
                                    {{ $matricula->estudiante->grado ?? 'Sin grado' }}
                                    @if($matricula->estudiante->seccion) · Sec. {{ $matricula->estudiante->seccion }} @endif
                                </span>
                                            <span class="chip chip-gray">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ \Carbon\Carbon::parse($matricula->fecha_matricula)->format('d/m/Y') }}
                                </span>
                                        </div>
                                    </div>

                                    <div class="pcard-footer">
                                        <button type="button"
                                                class="btn-gestionar btn-ver-detalles"
                                                data-matricula-id="{{ $matricula->id }}"
                                                data-url="{{ route('matriculas.detalles', $matricula->id) }}"
                                                data-confirmar-url="{{ route('matriculas.confirmar', $matricula->id) }}"
                                                data-rechazar-url="{{ route('matriculas.rechazar', $matricula->id) }}">
                                            <i class="fas fa-eye me-2"></i>Ver detalles y gestionar
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- ── Accesos rápidos ── --}}
        <div class="section-header mb-3">
            <h5 class="section-title"><i class="fas fa-grip-horizontal me-2"></i>Gestión Académica</h5>
        </div>

        <div class="quickaccess-grid mb-4">

            {{-- Estudiantes --}}
            <div class="qa-card qa-students">
                <div class="qa-icon"><i class="fas fa-user-graduate"></i></div>
                <div class="qa-info">
                    <span class="qa-title">Estudiantes</span>
                    <span class="qa-sub">Gestión de alumnos</span>
                </div>
                <div class="qa-actions">
                    <a href="{{ route('estudiantes.index') }}" class="qa-btn qa-btn-outline">
                        <i class="fas fa-list"></i> Ver
                    </a>
                    <a href="{{ route('estudiantes.create') }}" class="qa-btn qa-btn-solid">
                        <i class="fas fa-plus"></i> Nuevo
                    </a>
                </div>
            </div>

            {{-- Profesores --}}
            <div class="qa-card qa-teachers">
                <div class="qa-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                <div class="qa-info">
                    <span class="qa-title">Profesores</span>
                    <span class="qa-sub">Gestión de docentes</span>
                </div>
                <div class="qa-actions">
                    <a href="{{ route('profesores.index') }}" class="qa-btn qa-btn-outline">
                        <i class="fas fa-list"></i> Ver
                    </a>
                    <a href="{{ route('profesores.create') }}" class="qa-btn qa-btn-solid">
                        <i class="fas fa-plus"></i> Nuevo
                    </a>
                </div>
            </div>

            {{-- Padres --}}
            <div class="qa-card qa-parents">
                <div class="qa-icon"><i class="fas fa-users"></i></div>
                <div class="qa-info">
                    <span class="qa-title">Padres/Tutores</span>
                    <span class="qa-sub">Gestión de representantes</span>
                </div>
                <div class="qa-actions">
                    <a href="{{ route('padres.index') }}" class="qa-btn qa-btn-outline">
                        <i class="fas fa-list"></i> Ver
                    </a>
                    <a href="{{ route('padres.create') }}" class="qa-btn qa-btn-solid">
                        <i class="fas fa-plus"></i> Nuevo
                    </a>
                </div>
            </div>

            {{-- Matrículas --}}
            <div class="qa-card qa-enrollments">
                <div class="qa-icon"><i class="fas fa-file-signature"></i></div>
                <div class="qa-info">
                    <span class="qa-title">Matrículas</span>
                    <span class="qa-sub">Inscripciones y registros</span>
                </div>
                <div class="qa-actions">
                    <a href="{{ route('matriculas.index') }}" class="qa-btn qa-btn-outline">
                        <i class="fas fa-list"></i> Ver
                    </a>
                    <a href="{{ route('matriculas.create') }}" class="qa-btn qa-btn-solid">
                        <i class="fas fa-plus"></i> Nueva
                    </a>
                </div>
            </div>

            {{-- Plan Académico --}}
            <div class="qa-card qa-academic">
                <div class="qa-icon"><i class="fas fa-graduation-cap"></i></div>
                <div class="qa-info">
                    <span class="qa-title">Plan Académico</span>
                    <span class="qa-sub">Grados y materias</span>
                </div>
                <div class="qa-actions">
                    <a href="{{ route('superadmin.grados.index') }}" class="qa-btn qa-btn-outline">
                        <i class="fas fa-layer-group"></i> Grados
                    </a>
                    <a href="{{ route('superadmin.materias.index') }}" class="qa-btn qa-btn-solid">
                        <i class="fas fa-book"></i> Materias
                    </a>
                </div>
            </div>

            {{-- Horarios --}}
            <div class="qa-card qa-schedules">
                <div class="qa-icon"><i class="fas fa-clock"></i></div>
                <div class="qa-info">
                    <span class="qa-title">Horarios</span>
                    <span class="qa-sub">Horarios de clases</span>
                </div>
                <div class="qa-actions">
                    <a href="{{ route('superadmin.horarios_grado.index') }}" class="qa-btn qa-btn-solid" style="width:100%;">
                        <i class="fas fa-calendar-alt"></i> Ver Horarios
                    </a>
                </div>
            </div>

            {{-- Administración --}}
            <div class="qa-card qa-admin" style="grid-column: span 2;">
                <div class="qa-icon"><i class="fas fa-user-shield"></i></div>
                <div class="qa-info">
                    <span class="qa-title">Administración</span>
                    <span class="qa-sub">Usuarios y permisos del sistema</span>
                </div>
                <div class="qa-actions">
                    <a href="{{ route('superadmin.usuarios.index') }}" class="qa-btn qa-btn-outline">
                        <i class="fas fa-users"></i> Lista de Usuarios
                    </a>
                    <a href="{{ route('superadmin.usuarios.pendientes') }}" class="qa-btn qa-btn-warn">
                        <i class="fas fa-user-clock"></i> Usuarios Pendientes
                        @if(($usuariosPorAprobar ?? 0) > 0)
                            <span class="qa-badge">{{ $usuariosPorAprobar }}</span>
                        @endif
                    </a>
                </div>
            </div>

        </div>

    </div>{{-- fin container --}}


    {{-- ── MODAL: Detalles de Matrícula ── --}}
    <div class="modal fade" id="modalDetallesMatricula" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content modal-custom">
                <div class="modal-header modal-header-primary">
                    <h5 class="modal-title">
                        <i class="fas fa-file-alt me-2"></i>Detalles de la Solicitud de Matrícula
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4" id="contenidoDetallesMatricula"></div>
            </div>
        </div>
    </div>

    {{-- ── MODAL: Rechazar Matrícula ── --}}
    <div class="modal fade" id="modalRechazoMatricula" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-custom">
                <div class="modal-header modal-header-danger">
                    <h5 class="modal-title">
                        <i class="fas fa-times-circle me-2"></i>Rechazar Solicitud
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="formRechazoMatricula" method="POST" action="#">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="alert-soft alert-soft-warning mb-3">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <div>
                                <strong>Esta acción no se puede deshacer.</strong><br>
                                <small>El padre/tutor recibirá una notificación con el motivo del rechazo.</small>
                            </div>
                        </div>
                        <label class="form-label fw-600 mb-1">
                            Motivo del Rechazo <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control"
                                  id="motivo_rechazo_matricula"
                                  name="motivo_rechazo"
                                  rows="4"
                                  required
                                  minlength="10"
                                  placeholder="Ej: Documentación incompleta, datos incorrectos, cupo agotado..."></textarea>
                        <small class="text-muted mt-1 d-block">
                            <i class="fas fa-info-circle me-1"></i>Mínimo 10 caracteres.
                        </small>
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
                --c-primary:   #00508f;
                --c-secondary: #4ec7d2;
                --c-accent:    #f59e0b;
                --c-success:   #10b981;
                --c-danger:    #ef4444;
                --c-purple:    #6366f1;
                --c-border:    #e2e8f0;
                --c-surface:   #f8fafc;
                --c-text:      #1e293b;
                --c-muted:     #64748b;
            }

            /* ════════════════════════════════
               WELCOME
            ════════════════════════════════ */
            .welcome-card {
                background: linear-gradient(135deg, var(--c-primary) 0%, #0077cc 60%, var(--c-secondary) 100%);
                border-radius: 16px;
                padding: 1.75rem 2rem;
                color: white;
                box-shadow: 0 4px 20px rgba(0,80,143,.2);
            }
            .welcome-avatar {
                width: 56px; height: 56px;
                background: rgba(255,255,255,.15);
                border-radius: 14px;
                display: flex; align-items: center; justify-content: center;
                font-size: 1.5rem; flex-shrink: 0;
            }
            .welcome-title  { font-size: 1.6rem; font-weight: 700; color: white; margin: 0; }
            .welcome-subtitle { font-size: .875rem; opacity: .8; }

            /* ════════════════════════════════
               STAT CARDS (clickable)
            ════════════════════════════════ */
            .stat-link { text-decoration: none; display: block; height: 100%; }
            .stat-card {
                display: flex; align-items: center; gap: 1rem;
                background: white;
                border-radius: 14px;
                padding: 1.25rem 1.5rem;
                border: 1.5px solid var(--c-border);
                transition: all .25s ease;
                height: 100%;
            }
            .stat-link:hover .stat-card {
                transform: translateY(-3px);
                box-shadow: 0 8px 24px rgba(0,0,0,.08);
            }
            .stat-icon-wrap {
                width: 52px; height: 52px; border-radius: 12px;
                display: flex; align-items: center; justify-content: center;
                font-size: 1.4rem; flex-shrink: 0;
            }
            .stat-body { display: flex; flex-direction: column; }
            .stat-label { font-size: .75rem; font-weight: 600; text-transform: uppercase; letter-spacing: .6px; color: var(--c-muted); }
            .stat-value { font-size: 1.9rem; font-weight: 800; line-height: 1.1; color: var(--c-text); margin: .15rem 0; }
            .stat-sub   { font-size: .78rem; font-weight: 500; }

            .stat-students  .stat-icon-wrap { background: #e0f9fb; color: var(--c-secondary); }
            .stat-students  .stat-sub       { color: var(--c-secondary); }
            .stat-students:hover             { border-color: var(--c-secondary); }

            .stat-teachers  .stat-icon-wrap { background: #e6f0fb; color: var(--c-primary); }
            .stat-teachers  .stat-sub       { color: var(--c-primary); }
            .stat-teachers:hover             { border-color: var(--c-primary); }

            .stat-enrollments .stat-icon-wrap { background: #fff8e6; color: var(--c-accent); }
            .stat-enrollments .stat-sub       { color: var(--c-accent); }
            .stat-enrollments:hover           { border-color: var(--c-accent); }

            .stat-users .stat-icon-wrap { background: #fde8e8; color: var(--c-danger); }
            .stat-users .stat-sub       { color: var(--c-danger); }
            .stat-users:hover           { border-color: var(--c-danger); }

            /* ════════════════════════════════
               PENDING PANEL
            ════════════════════════════════ */
            .pending-panel {
                background: white;
                border: 2px solid #fbbf24;
                border-radius: 16px;
                overflow: hidden;
                box-shadow: 0 2px 12px rgba(251,191,36,.15);
            }
            .pending-panel-header {
                display: flex; align-items: center; justify-content: space-between;
                padding: 1rem 1.5rem;
                background: #fffbeb;
                border-bottom: 1px solid #fde68a;
                flex-wrap: wrap; gap: .75rem;
            }
            .pending-dot {
                width: 10px; height: 10px; border-radius: 50%;
                background: #f59e0b;
                animation: pulse-dot 1.5s infinite;
                flex-shrink: 0;
            }
            @keyframes pulse-dot {
                0%,100% { box-shadow: 0 0 0 0 rgba(245,158,11,.4); }
                50%      { box-shadow: 0 0 0 6px rgba(245,158,11,0); }
            }
            .badge-count {
                background: #f59e0b; color: white;
                font-size: .75rem; font-weight: 700;
                padding: .2rem .55rem; border-radius: 20px;
            }
            .btn-link-custom {
                font-size: .85rem; font-weight: 600;
                color: var(--c-primary); text-decoration: none;
                padding: .35rem .75rem; border-radius: 8px;
                border: 1.5px solid var(--c-primary);
                transition: all .2s;
            }
            .btn-link-custom:hover { background: var(--c-primary); color: white; }

            /* Pending grid */
            .pending-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                gap: 1rem;
                padding: 1.25rem;
            }

            /* Pending card */
            .pcard {
                border: 1.5px solid var(--c-border);
                border-radius: 12px;
                background: white;
                overflow: hidden;
                transition: all .25s ease;
                display: flex; flex-direction: column;
            }
            .pcard:hover {
                border-color: var(--c-secondary);
                box-shadow: 0 6px 20px rgba(0,80,143,.1);
                transform: translateY(-3px);
            }
            .pcard-top {
                display: flex; justify-content: space-between; align-items: center;
                padding: .65rem 1rem;
                background: var(--c-surface);
                border-bottom: 1px solid var(--c-border);
            }
            .pcard-code {
                font-size: .78rem; font-weight: 700; color: var(--c-primary);
                display: flex; align-items: center; gap: .3rem;
            }
            .pcard-code i { font-size: .7rem; opacity: .6; }
            .pcard-status {
                font-size: .7rem; font-weight: 700;
                background: #fef3c7; color: #92400e;
                padding: .25rem .6rem; border-radius: 6px;
            }
            .pcard-body { padding: 1rem; flex: 1; display: flex; flex-direction: column; gap: .75rem; }
            .pcard-person { display: flex; gap: .75rem; align-items: center; }
            .pcard-avatar {
                width: 38px; height: 38px; border-radius: 10px;
                display: flex; align-items: center; justify-content: center;
                font-size: .9rem; font-weight: 700; flex-shrink: 0;
            }
            .av-blue   { background: #e0f9fb; color: var(--c-secondary); }
            .av-purple { background: #ede9fe; color: var(--c-purple); }
            .pcard-name { font-size: .88rem; font-weight: 700; color: var(--c-text); line-height: 1.2; }
            .pcard-meta { font-size: .75rem; color: var(--c-muted); margin-top: .1rem; }
            .pcard-chips { display: flex; flex-wrap: wrap; gap: .4rem; padding-top: .5rem; border-top: 1px solid var(--c-border); }
            .chip { font-size: .72rem; font-weight: 600; padding: .2rem .55rem; border-radius: 6px; }
            .chip-blue  { background: #e0f9fb; color: #0e7490; }
            .chip-gray  { background: #f1f5f9; color: var(--c-muted); }
            .pcard-footer { padding: .75rem 1rem; border-top: 1px solid var(--c-border); }
            .btn-gestionar {
                width: 100%;
                background: var(--c-primary); color: white;
                border: none; border-radius: 8px;
                padding: .6rem; font-size: .85rem; font-weight: 600;
                cursor: pointer; transition: all .25s;
                display: flex; align-items: center; justify-content: center;
            }
            .btn-gestionar:hover {
                background: #003b73;
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(0,80,143,.3);
            }

            /* ════════════════════════════════
               SECTION HEADER
            ════════════════════════════════ */
            .section-header { border-bottom: 2px solid var(--c-border); padding-bottom: .6rem; }
            .section-title  { font-size: 1.1rem; font-weight: 700; color: var(--c-primary); margin: 0; }

            /* ════════════════════════════════
               QUICK ACCESS GRID
            ════════════════════════════════ */
            .quickaccess-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 1rem;
            }
            .qa-card {
                background: white;
                border: 1.5px solid var(--c-border);
                border-radius: 14px;
                padding: 1.25rem 1.5rem;
                display: flex; align-items: center; gap: 1rem;
                transition: all .25s ease;
                flex-wrap: wrap;
            }
            .qa-card:hover {
                box-shadow: 0 6px 20px rgba(0,0,0,.07);
                transform: translateY(-2px);
            }
            .qa-icon {
                width: 46px; height: 46px; border-radius: 11px;
                display: flex; align-items: center; justify-content: center;
                font-size: 1.2rem; flex-shrink: 0; color: white;
            }
            .qa-students  .qa-icon { background: var(--c-secondary); }
            .qa-teachers  .qa-icon { background: var(--c-primary); }
            .qa-parents   .qa-icon { background: var(--c-purple); }
            .qa-enrollments .qa-icon { background: var(--c-accent); }
            .qa-academic  .qa-icon { background: var(--c-success); }
            .qa-schedules .qa-icon { background: #0ea5e9; }
            .qa-admin     .qa-icon { background: var(--c-danger); }

            .qa-students:hover  { border-color: var(--c-secondary); }
            .qa-teachers:hover  { border-color: var(--c-primary); }
            .qa-parents:hover   { border-color: var(--c-purple); }
            .qa-enrollments:hover { border-color: var(--c-accent); }
            .qa-academic:hover  { border-color: var(--c-success); }
            .qa-schedules:hover { border-color: #0ea5e9; }
            .qa-admin:hover     { border-color: var(--c-danger); }

            .qa-info { flex: 1; min-width: 120px; }
            .qa-title { display: block; font-size: .95rem; font-weight: 700; color: var(--c-text); }
            .qa-sub   { display: block; font-size: .775rem; color: var(--c-muted); margin-top: .1rem; }
            .qa-actions { display: flex; gap: .5rem; flex-wrap: wrap; }
            .qa-btn {
                font-size: .8rem; font-weight: 600;
                padding: .4rem .85rem; border-radius: 8px;
                text-decoration: none; transition: all .2s;
                display: inline-flex; align-items: center; gap: .35rem;
                white-space: nowrap;
            }
            .qa-btn-outline {
                border: 1.5px solid var(--c-primary); color: var(--c-primary); background: transparent;
            }
            .qa-btn-outline:hover { background: var(--c-primary); color: white; }
            .qa-btn-solid {
                background: var(--c-primary); color: white; border: 1.5px solid var(--c-primary);
            }
            .qa-btn-solid:hover { background: #003b73; border-color: #003b73; }
            .qa-btn-warn {
                background: #fef3c7; color: #92400e; border: 1.5px solid #fbbf24;
                position: relative;
            }
            .qa-btn-warn:hover { background: #fbbf24; color: #451a03; }
            .qa-badge {
                background: var(--c-danger); color: white;
                font-size: .65rem; font-weight: 700;
                padding: .1rem .4rem; border-radius: 10px;
                margin-left: .25rem;
            }

            /* ════════════════════════════════
               MODALS
            ════════════════════════════════ */
            .modal-custom        { border-radius: 14px; overflow: hidden; border: none; }
            .modal-header-primary {
                background: linear-gradient(135deg, var(--c-primary) 0%, var(--c-secondary) 100%);
                color: white; border: none; padding: 1.1rem 1.5rem;
            }
            .modal-header-danger {
                background: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
                color: white; border: none; padding: 1.1rem 1.5rem;
            }
            .modal-title { font-weight: 700; font-size: 1rem; }
            .alert-soft {
                display: flex; align-items: flex-start; gap: .75rem;
                padding: .85rem 1rem; border-radius: 10px;
                font-size: .875rem;
            }
            .alert-soft-warning { background: #fffbeb; color: #92400e; border-left: 4px solid #fbbf24; }

            /* Spinner utilidades */
            .fw-600 { font-weight: 600; }
            .fw-700 { font-weight: 700; }

            /* ════════════════════════════════
               RESPONSIVE
            ════════════════════════════════ */
            @media (max-width: 768px) {
                .welcome-card    { padding: 1.25rem; }
                .welcome-title   { font-size: 1.3rem; }
                .pending-grid    { grid-template-columns: 1fr; }
                .quickaccess-grid { grid-template-columns: 1fr; }
                .qa-card[style*="span 2"] { grid-column: span 1 !important; }
                .qa-actions      { width: 100%; }
            }
            @media (max-width: 576px) {
                .stat-card { padding: 1rem; }
                .stat-value { font-size: 1.6rem; }
            }
        </style>
    @endpush


    @push('scripts')
        <script>
            (function () {
                'use strict';

                /* ── Helper: obtener o crear instancia Modal (compatible BS 5.0/5.1/5.2+) ── */
                function getModal(id) {
                    const el = document.getElementById(id);
                    if (!el) return null;
                    return bootstrap.Modal.getInstance(el) || new bootstrap.Modal(el);
                }

                const csrf = () => document.querySelector('meta[name="csrf-token"]')?.content ?? '';

                function spinner(msg) {
                    return `<div class="text-center py-5">
            <div class="spinner-border text-primary" style="width:3rem;height:3rem;" role="status"></div>
            <p class="mt-3 text-muted fw-semibold">${msg}</p>
        </div>`;
                }

                function alertHtml(msg) {
                    return `<div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i>${msg}</div>`;
                }

                /* ══════════════════════════════════════════════════
                   VER DETALLES
                ══════════════════════════════════════════════════ */
                document.addEventListener('click', function (e) {
                    const btn = e.target.closest('.btn-ver-detalles');
                    if (!btn) return;
                    e.preventDefault();

                    const url          = btn.dataset.url;
                    const matriculaId  = btn.dataset.matriculaId;
                    const confirmarUrl = btn.dataset.confirmarUrl;
                    const rechazarUrl  = btn.dataset.rechazarUrl;

                    const contenido = document.getElementById('contenidoDetallesMatricula');
                    if (!contenido) return;

                    contenido.innerHTML = spinner('Cargando información de la matrícula...');
                    getModal('modalDetallesMatricula').show();

                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                        .then(function (res) {
                            if (!res.ok) throw new Error('Error del servidor: ' + res.status);
                            return res.json();
                        })
                        .then(function (data) {
                            contenido.innerHTML = buildDetailHtml(data, matriculaId, confirmarUrl, rechazarUrl);
                        })
                        .catch(function (err) {
                            contenido.innerHTML = alertHtml(err.message);
                        });
                });

                /* ── Construir HTML de detalles ── */
                function buildDetailHtml(data, matriculaId, confirmarUrl, rechazarUrl) {
                    const est = data.estudiante ?? {};
                    const pad = data.padre      ?? {};
                    const mat = data.matricula  ?? {};

                    return `
        <div class="row g-4">
            <div class="col-12">
                <div class="p-3 rounded-3" style="background:#e0f9fb;">
                    <small class="text-muted fw-semibold d-block mb-1">CÓDIGO DE MATRÍCULA</small>
                    <h5 class="mb-0 fw-bold" style="color:#00508f">${mat.codigo ?? '—'}</h5>
                    <small class="text-muted">Año lectivo: ${mat.anio_lectivo ?? '—'} · Fecha: ${mat.fecha_matricula ?? '—'}</small>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light py-2">
                        <h6 class="mb-0"><i class="fas fa-user-graduate me-2 text-info"></i>Estudiante</h6>
                    </div>
                    <div class="card-body">
                        ${row('Nombre completo', est.nombre_completo)}
                        ${row('DNI', est.dni)}
                        ${row('Fecha de nacimiento', est.fecha_nacimiento)}
                        ${row('Sexo', est.sexo)}
                        ${rowBadge('Grado', est.grado, 'bg-primary')}
                        ${rowBadge('Sección', est.seccion, 'bg-info')}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light py-2">
                        <h6 class="mb-0"><i class="fas fa-user-friends me-2 text-info"></i>Padre / Tutor</h6>
                    </div>
                    <div class="card-body">
                        ${row('Nombre completo', pad.nombre_completo)}
                        ${row('DNI', pad.dni)}
                        ${rowBadge('Parentesco', pad.parentesco, 'bg-secondary')}
                        ${row('Email', pad.correo ?? 'No proporcionado')}
                        ${row('Teléfono', pad.telefono)}
                        ${row('Dirección', pad.direccion)}
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="fas fa-tasks me-2"></i>Acciones</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <form action="${confirmarUrl}" method="POST">
                                    <input type="hidden" name="_token" value="${csrf()}">
                                    <button type="submit" class="btn btn-success w-100 py-3">
                                        <i class="fas fa-check-circle me-2"></i><strong>Aprobar Matrícula</strong>
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <button type="button"
                                        class="btn btn-danger w-100 py-3 btn-rechazar-desde-modal"
                                        data-matricula-id="${matriculaId}"
                                        data-rechazar-url="${rechazarUrl}">
                                    <i class="fas fa-times-circle me-2"></i><strong>Rechazar Matrícula</strong>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
                }

                function row(label, value) {
                    return `<div class="mb-2">
            <small class="text-muted d-block">${label}</small>
            <strong>${value ?? '—'}</strong>
        </div>`;
                }

                function rowBadge(label, value, cls) {
                    return `<div class="mb-2">
            <small class="text-muted d-block">${label}</small>
            <span class="badge ${cls}">${value ?? '—'}</span>
        </div>`;
                }

                /* ══════════════════════════════════════════════════
                   RECHAZAR desde modal de detalles
                ══════════════════════════════════════════════════ */
                document.addEventListener('click', function (e) {
                    const btn = e.target.closest('.btn-rechazar-desde-modal');
                    if (!btn) return;
                    e.preventDefault();

                    const matriculaId = btn.dataset.matriculaId;
                    const rechazarUrl = btn.dataset.rechazarUrl;

                    // Cerrar modal de detalles
                    const mdDetalles = bootstrap.Modal.getInstance(
                        document.getElementById('modalDetallesMatricula')
                    );
                    if (mdDetalles) mdDetalles.hide();

                    setTimeout(() => mostrarModalRechazo(matriculaId, rechazarUrl), 400);
                });

                /* ══════════════════════════════════════════════════
                   MODAL DE RECHAZO
                ══════════════════════════════════════════════════ */
                let abortCtrl = null;

                function mostrarModalRechazo(matriculaId, rechazarUrl) {
                    const form     = document.getElementById('formRechazoMatricula');
                    const textarea = document.getElementById('motivo_rechazo_matricula');
                    const modalEl  = document.getElementById('modalRechazoMatricula');
                    if (!form || !textarea || !modalEl) return;

                    form.action    = rechazarUrl;
                    textarea.value = '';
                    textarea.classList.remove('is-invalid');

                    if (abortCtrl) abortCtrl.abort();
                    abortCtrl = new AbortController();

                    form.addEventListener('submit', function (e) {
                        e.preventDefault();

                        const motivo = textarea.value.trim();
                        if (motivo.length < 10) {
                            textarea.classList.add('is-invalid');
                            textarea.focus();
                            return;
                        }
                        textarea.classList.remove('is-invalid');

                        if (!confirm('¿Está seguro de que desea rechazar esta matrícula?')) return;

                        const btnSubmit = form.querySelector('[type="submit"]');
                        btnSubmit.disabled = true;
                        btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Procesando...';

                        fetch(rechazarUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                                'X-CSRF-TOKEN': csrf(),
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: new URLSearchParams({ '_token': csrf(), 'motivo_rechazo': motivo })
                        })
                            .then(function (res) {
                                if (!res.ok) throw new Error('Error en el servidor (' + res.status + ')');
                                return res;
                            })
                            .then(function () {
                                bootstrap.Modal.getInstance(modalEl)?.hide();
                                setTimeout(() => location.reload(), 350);
                            })
                            .catch(function (err) {
                                btnSubmit.disabled = false;
                                btnSubmit.innerHTML = '<i class="fas fa-ban me-1"></i>Confirmar Rechazo';
                                alert('Error: ' + err.message);
                            });

                    }, { signal: abortCtrl.signal });

                    getModal('modalRechazoMatricula').show();
                }

            })();
        </script>
    @endpush
@endsection
