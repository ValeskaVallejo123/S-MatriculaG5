<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema Escolar') - Escuela Gabriela Mistral</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        /*
        ╔══════════════════════════════════════════════════════════════╗
        ║  🔤 TAMAÑO DE LETRA GLOBAL — afecta TODO el sitio            ║
        ║  Cambia el número para hacer todo más grande o pequeño.      ║
        ║  • 14px → más compacto                                       ║
        ║  • 16px → estándar                                           ║
        ║  • 17px → valor actual                                       ║
        ║  • 18px → más grande                                         ║
        ╚══════════════════════════════════════════════════════════════╝
        */
        html { font-size: 17px; }

        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fa;
            overflow-x: hidden;
            font-size: 1rem;
        }

        /* ══════════════════════════════════════════════
           SIDEBAR
        ══════════════════════════════════════════════ */
        .sidebar {
            position: fixed; top: 0; left: 0;
            height: 100vh; width: 280px;
            background: linear-gradient(180deg, #003b73 0%, #00508f 100%);
            transition: all .3s ease; z-index: 1000;
            box-shadow: 4px 0 15px rgba(0,59,115,.2);
            overflow-y: auto;
        }
        .sidebar::-webkit-scrollbar { width: 8px; }
        .sidebar::-webkit-scrollbar-track { background: rgba(0,0,0,.15); border-radius: 10px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(78,199,210,.6); border-radius: 10px; }
        .sidebar::-webkit-scrollbar-thumb:hover { background: rgba(78,199,210,.9); }

        .sidebar-header { padding: 1.5rem 1.2rem; border-bottom: 1px solid rgba(78,199,210,.2); }
        .sidebar-logo { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .sidebar-logo i {
            font-size: 2rem; color: #f59e0b;
            background: rgba(245,158,11,.15);
            width: 50px; height: 50px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 12px; border: 3px solid rgba(245,158,11,.3);
        }
        .logo-text h4 { margin: 0; font-size: 1.1rem; font-weight: 700; color: #f59e0b; line-height: 1.2; }
        .logo-text p  { margin: 0; font-size: .75rem; color: rgba(245,158,11,.8); letter-spacing: .5px; font-weight: 500; }

        .user-info {
            padding: 1.5rem 1.2rem;
            border-bottom: 1px solid rgba(78,199,210,.2);
            text-align: center;
        }
        .user-avatar {
            width: 60px; height: 60px; border-radius: 50%;
            background: linear-gradient(135deg, #4ec7d2, #00508f);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; color: white; font-weight: 700;
            margin: 0 auto .8rem;
            box-shadow: 0 4px 12px rgba(78,199,210,.4);
        }
        .user-details h6 { margin: 0; color: white; font-size: .95rem; font-weight: 600; }
        .user-details p  { margin: 0; font-size: .75rem; color: rgba(255,255,255,.6); font-weight: 500; }

        .sidebar-menu { list-style: none; padding: 1rem 0; }
        .menu-section-title {
            padding: 1rem 1.2rem .5rem;
            color: rgba(78,199,210,.8);
            font-size: .80rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 1.2px;
        }
        .menu-item { margin: 0; }
        .menu-link {
            display: flex; align-items: center; gap: 12px;
            padding: .75rem 1.2rem;
            color: rgba(255,255,255,.8);
            text-decoration: none; transition: all .2s ease;
            font-size: .9rem; font-weight: 500;
        }
        .menu-link i { font-size: 1.1rem; width: 24px; text-align: center; color: rgba(78,199,210,.9); }
        .menu-link:hover { background: rgba(78,199,210,.15); color: white; }
        .menu-link:hover i { color: #4ec7d2; }
        .menu-link.active {
            background: rgba(78,199,210,.2); color: white;
            border-left: 3px solid #4ec7d2;
            padding-left: calc(1.2rem - 3px);
        }
        .menu-link.active i { color: #4ec7d2; }
        .menu-link.disabled-link { opacity: .5; cursor: not-allowed; pointer-events: none; }

        /* Badge rojo para notificaciones en items del menú */
        .menu-badge {
            margin-left: auto;
            background: #ef4444; color: white;
            font-size: .7rem; font-weight: 700;
            padding: .15rem .5rem; border-radius: 12px;
            min-width: 24px; text-align: center;
        }

        /* ══════════════════════════════════════════════
           MAIN CONTENT
           — Con sidebar (admin/superadmin): margin-left 280px
           — Sin sidebar (profesor/estudiante/padre): sin margen
        ══════════════════════════════════════════════ */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            background: #f5f7fa;
            transition: all .3s ease;
        }

        /* Roles sin sidebar ocupan todo el ancho */
        .main-content.no-sidebar {
            margin-left: 0;
        }

        /* ══════════════════════════════════════════════
           TOPBAR
        ══════════════════════════════════════════════ */
        .topbar {
            background: white; padding: 0 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,.06);
            border-bottom: 1px solid #e5e7eb;
            position: sticky; top: 0; z-index: 100;
            min-height: 64px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .topbar-left { display: flex; align-items: center; gap: .75rem; }
        .topbar-left h5 { margin: 0; color: #003b73; font-weight: 700; font-size: 1.15rem; }
        .topbar-right { display: flex; align-items: center; gap: .6rem; flex-wrap: nowrap; }
        .topbar-divider { width: 1px; height: 24px; background: #e2e8f0; flex-shrink: 0; }

        /* Fecha/hora en topbar */
        .topbar-date {
            display: flex; align-items: center; gap: .5rem;
            color: #6b7280; font-size: .85rem;
            padding: .5rem 1rem;
            background: #f9fafb; border-radius: 8px;
        }
        .topbar-date i { color: #00508f; }

        .btn-logout {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white; border: none;
            padding: .6rem .75rem; border-radius: 7px;
            font-size: .83rem; font-weight: 600;
            display: flex; align-items: center; gap: .4rem;
            cursor: pointer; transition: all .2s ease;
            white-space: nowrap;
            box-shadow: 0 2px 6px rgba(239,68,68,.3);
        }
        .btn-logout:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            opacity: .9; transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(239,68,68,.4);
        }

        /* ══════════════════════════════════════════════
           CONTENT WRAPPER
           — Con sidebar: padding normal
           — Sin sidebar: padding lateral más generoso
        ══════════════════════════════════════════════ */
        .content-wrapper { padding: 2rem; }

        .no-sidebar .content-wrapper {
            padding: 1.5rem 2rem;
            /* Sin max-width para que ocupe todo el ancho disponible */
            width: 100%;
            box-sizing: border-box;
        }

        /* ══════════════════════════════════════════════
           MOBILE MENU
        ══════════════════════════════════════════════ */
        .mobile-menu-btn {
            display: none;
            background: linear-gradient(135deg, #4ec7d2, #00508f);
            color: white; border: none;
            padding: .5rem .75rem; border-radius: 7px;
            font-size: 1rem; cursor: pointer;
        }
        .sidebar-overlay {
            display: none; position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,.5); z-index: 999;
        }
        .sidebar-overlay.active { display: block; }

        @media (max-width: 768px) {
            .sidebar { left: -280px; }
            .sidebar.active { left: 0; }
            .main-content { margin-left: 0 !important; }
            .mobile-menu-btn { display: block !important; }
            .content-wrapper { padding: 1rem; }
            .no-sidebar .content-wrapper { padding: 1rem; }
            .topbar { padding: .75rem 1rem; }
            .topbar-date { display: none; }
            .topbar-divider { display: none; }
        }

        /* ══════════════════════════════════════════════
           MODAL ELIMINACIÓN
        ══════════════════════════════════════════════ */
        .modal-delete-overlay {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,.6); backdrop-filter: blur(4px);
            display: none; align-items: center; justify-content: center;
            z-index: 10000; opacity: 0; transition: opacity .3s ease;
        }
        .modal-delete-overlay.show { display: flex; animation: fadeIn .3s ease forwards; }
        @keyframes fadeIn { to { opacity: 1; } }

        .modal-delete {
            background: white; border-radius: 16px;
            max-width: 480px; width: 90%;
            box-shadow: 0 10px 40px rgba(239,68,68,.2);
            transform: scale(.95);
            animation: scaleUp .3s cubic-bezier(.68,-.55,.265,1.55) forwards;
            position: relative; overflow: hidden;
        }
        @keyframes scaleUp { to { transform: scale(1); } }

        .modal-delete-close {
            position: absolute; top: 1rem; right: 1rem;
            width: 32px; height: 32px;
            background: #f1f5f9; border: none; border-radius: 8px;
            color: #64748b; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: all .2s ease; z-index: 1;
        }
        .modal-delete-close:hover { background: #e2e8f0; }

        .modal-delete-icon {
            width: 80px; height: 80px;
            background: linear-gradient(135deg,rgba(239,68,68,.1),rgba(220,38,38,.1));
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 2rem auto 1.5rem;
            color: #ef4444; font-size: 2.5rem;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%,100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(239,68,68,.4); }
            50%      { transform: scale(1.05); box-shadow: 0 0 0 15px rgba(239,68,68,0); }
        }

        .modal-delete-title {
            text-align: center; color: #1e293b;
            font-size: 1.5rem; font-weight: 700;
            margin: 0 0 1.5rem; padding: 0 2rem;
        }
        .modal-delete-content { padding: 0 2rem 2rem; }
        .modal-delete-message {
            text-align: center; color: #64748b;
            font-size: .938rem; line-height: 1.6; margin: 0 0 1.5rem;
        }
        .modal-delete-item {
            background: linear-gradient(135deg,#f8fafc,#e2e8f0);
            border-radius: 12px; padding: 1rem;
            display: flex; align-items: center; gap: 1rem;
            border-left: 4px solid #ef4444;
        }
        .delete-item-icon {
            width: 40px; height: 40px; background: white; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: #ef4444; font-size: 1.125rem; flex-shrink: 0;
        }
        .delete-item-details { flex: 1; }
        .delete-item-label {
            display: block; color: #64748b; font-size: .75rem;
            font-weight: 600; text-transform: uppercase;
            letter-spacing: .5px; margin-bottom: .25rem;
        }
        .delete-item-name { display: block; color: #1e293b; font-size: .938rem; font-weight: 700; }

        .modal-delete-actions {
            padding: 1rem 1.5rem 1.5rem; display: flex; gap: .75rem;
            border-top: 1px solid #e2e8f0;
        }
        .btn-delete-cancel, .btn-delete-confirm {
            flex: 1; padding: .75rem 1.25rem;
            border-radius: 10px; font-weight: 600; font-size: .875rem;
            border: none; cursor: pointer; transition: all .3s ease;
            display: inline-flex; align-items: center; justify-content: center; gap: .5rem;
        }
        .btn-delete-cancel { background: #f1f5f9; color: #64748b; }
        .btn-delete-cancel:hover { background: #e2e8f0; transform: translateY(-2px); }
        .btn-delete-confirm {
            background: linear-gradient(135deg,#ef4444,#dc2626);
            color: white; box-shadow: 0 4px 12px rgba(239,68,68,.3);
        }
        .btn-delete-confirm:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(239,68,68,.4); }

        @media (max-width: 576px) {
            .modal-delete { max-width: calc(100% - 2rem); margin: 1rem; }
            .modal-delete-title { font-size: 1.25rem; padding: 0 1.5rem; }
            .modal-delete-content { padding: 0 1.5rem 1.5rem; }
            .modal-delete-actions { flex-direction: column; }
            .btn-delete-cancel, .btn-delete-confirm { width: 100%; }
        }
    </style>

    @stack('styles')
</head>
<body>

@php
    $user = auth()->user();
    {{-- Lógica dual: detecta rol por id_rol Y por nombre del rol --}}
    $isSuperAdmin = $user && (
        $user->is_super_admin == 1 ||
        $user->id_rol == 1 ||
        ($user->rol && strtolower($user->rol->nombre) === 'super administrador')
    );
    $isAdmin = $user && (
        in_array($user->id_rol, [1, 2]) ||
        ($user->rol && in_array(strtolower($user->rol->nombre), ['admin', 'administrador']))
    );
    $showSidebar = $isAdmin; {{-- Solo admins tienen sidebar --}}

    if ($isSuperAdmin) {
        $roleName = 'Super Administrador';
    } elseif ($isAdmin) {
        $roleName = 'Administrador';
    } else {
        $roleName = $user ? ucfirst($user->rol->nombre ?? 'Usuario') : 'Invitado';
    }
@endphp

@if($showSidebar)
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<aside class="sidebar" id="sidebar">

    {{-- Logo --}}
    <div class="sidebar-header">
        <a href="{{ $isSuperAdmin ? route('superadmin.dashboard') : route('admin.dashboard') }}" class="sidebar-logo">
            <i class="fas fa-graduation-cap"></i>
            <div class="logo-text">
                <h4>Escuela G.M.</h4>
                <p>Sistema de Gestión</p>
            </div>
        </a>
    </div>

    {{-- Usuario --}}
    <div class="user-info">
        <div class="user-avatar">{{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}</div>
        <div class="user-details">
            <h6>{{ $user->name ?? 'Administrador' }}</h6>
            <p>{{ $roleName }}</p>
        </div>
    </div>

    {{-- Menú --}}
    <ul class="sidebar-menu">

        {{-- ── PRINCIPAL ── --}}
        <li class="menu-section-title">PRINCIPAL</li>

        {{-- Dashboard separado por rol --}}
        @if($isSuperAdmin)
        <li class="menu-item">
            <a href="{{ route('superadmin.dashboard') }}"
               class="menu-link {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i><span>Dashboard</span>
            </a>
        </li>
        @elseif($isAdmin)
        <li class="menu-item">
            <a href="{{ route('admin.dashboard') }}"
               class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i><span>Dashboard</span>
            </a>
        </li>
        @endif

        {{-- ── USUARIOS ── --}}
        <li class="menu-section-title">USUARIOS</li>

        @if($isSuperAdmin)
        <li class="menu-item">
            <a href="{{ route('superadmin.administradores.index') }}"
               class="menu-link {{ request()->routeIs('superadmin.administradores.*') ? 'active' : '' }}">
                <i class="fas fa-user-shield"></i><span>Administradores</span>
            </a>
        </li>
        @endif

        <li class="menu-item">
            <a href="{{ route('estudiantes.index') }}"
               class="menu-link {{ request()->routeIs('estudiantes.*') ? 'active' : '' }}">
                <i class="fas fa-user-graduate"></i><span>Estudiantes</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('profesores.index') }}"
               class="menu-link {{ request()->routeIs('profesores.*') ? 'active' : '' }}">
                <i class="fas fa-chalkboard-teacher"></i><span>Profesores</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('padres.index') }}"
               class="menu-link {{ request()->routeIs('padres.*') ? 'active' : '' }}">
                <i class="fas fa-user-friends"></i><span>Padres / Tutores</span>
            </a>
        </li>

        {{-- ── BÚSQUEDA ── --}}
        <li class="menu-section-title">BÚSQUEDA</li>

        <li class="menu-item">
            <a href="{{ route('buscarregistro') }}"
               class="menu-link {{ request()->routeIs('buscarregistro') ? 'active' : '' }}">
                <i class="fas fa-search"></i><span>Registro de Estudiante</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('padres.buscar') }}"
               class="menu-link {{ request()->routeIs('padres.buscar') ? 'active' : '' }}">
                <i class="fas fa-search"></i><span>Buscar Padre / Tutor</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('consultaestudiantesxcurso.index') }}"
               class="menu-link {{ request()->routeIs('consultaestudiantesxcurso.*') ? 'active' : '' }}">
                <i class="fas fa-search"></i><span>Consulta Estudiantes por Curso</span>
            </a>
        </li>

        {{-- ── MATRÍCULAS ── --}}
        <li class="menu-section-title">MATRÍCULAS</li>

        <li class="menu-item">
            <a href="{{ route('matriculas.index') }}"
               class="menu-link {{ request()->routeIs('matriculas.*') ? 'active' : '' }}">
                <i class="fas fa-clipboard-list"></i><span>Matrículas</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admins.permisos.index') }}"
               class="menu-link {{ request()->routeIs('admins.permisos.*') ? 'active' : '' }}">
                <i class="fas fa-user-lock"></i><span>Permisos de Padres</span>
            </a>
        </li>

        {{-- ── ACADÉMICO ── --}}
        <li class="menu-section-title">ACADÉMICO</li>

        <li class="menu-item">
            <a href="{{ route('registrarcalificaciones.index') }}"
               class="menu-link {{ request()->routeIs('registrarcalificaciones.*') ? 'active' : '' }}">
                <i class="fas fa-clipboard-list"></i><span>Registrar Calificaciones</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ $isSuperAdmin ? route('superadmin.grados.index') : route('grados.index') }}"
               class="menu-link {{ request()->routeIs('grados.*', 'superadmin.grados.*') ? 'active' : '' }}">
                <i class="fas fa-layer-group"></i><span>Grados</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('h20cursos.index') }}"
               class="menu-link {{ request()->routeIs('h20cursos.*') ? 'active' : '' }}">
                <i class="fas fa-layer-group"></i><span>Cursos</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ $isSuperAdmin ? route('superadmin.materias.index') : route('materias.index') }}"
               class="menu-link {{ request()->routeIs('materias.*', 'superadmin.materias.*') ? 'active' : '' }}">
                <i class="fas fa-book"></i><span>Materias</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ $isSuperAdmin ? route('superadmin.profesor_materia.index') : route('profesor_materia.index') }}"
               class="menu-link {{ request()->routeIs('profesor_materia.*', 'superadmin.profesor_materia.*') ? 'active' : '' }}">
                <i class="fas fa-user-tag"></i><span>Asignar Profesor</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link disabled-link" title="Próximamente disponible">
                <i class="fas fa-chart-bar"></i><span>Carga Docente</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('secciones.index') }}"
               class="menu-link {{ request()->routeIs('secciones.*') ? 'active' : '' }}">
                <i class="fas fa-sitemap"></i><span>Secciones</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('cupos_maximos.index') }}"
               class="menu-link {{ request()->routeIs('cupos_maximos.*') ? 'active' : '' }}">
                <i class="fas fa-users-cog"></i><span>Cupos Máximos</span>
            </a>
        </li>

        {{-- ── CALENDARIO ── --}}
        <li class="menu-section-title">CALENDARIO</li>

        <li class="menu-item">
            <a href="{{ route('periodos-academicos.index') }}"
               class="menu-link {{ request()->routeIs('periodos-academicos.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i><span>Períodos Académicos</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('calendario') }}"
               class="menu-link {{ request()->routeIs('calendario') ? 'active' : '' }}">
                <i class="fas fa-calendar-week"></i><span>Calendario Académico</span>
            </a>
        </li>

        {{-- ── DOCUMENTACIÓN ── --}}
        <li class="menu-section-title">DOCUMENTACIÓN</li>

        <li class="menu-item">
            <a href="{{ route('observaciones.index') }}"
               class="menu-link {{ request()->routeIs('observaciones.*') ? 'active' : '' }}">
                <i class="fas fa-sticky-note"></i><span>Observaciones</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('documentos.index') }}"
               class="menu-link {{ request()->routeIs('documentos.*') ? 'active' : '' }}">
                <i class="fas fa-folder-open"></i><span>Documentos</span>
            </a>
        </li>

        {{-- ── CONFIGURACIÓN ── --}}
        <li class="menu-section-title">CONFIGURACIÓN</li>

        @if($isSuperAdmin)
        <li class="menu-item">
            <a href="{{ route('superadmin.perfil') }}"
               class="menu-link {{ request()->routeIs('superadmin.perfil') ? 'active' : '' }}">
                <i class="fas fa-user-circle"></i><span>Mi Perfil</span>
            </a>
        </li>
        @endif
        <li class="menu-item">
            <a href="{{ route('cambiarcontrasenia.edit') }}"
               class="menu-link {{ request()->routeIs('cambiarcontrasenia.*') ? 'active' : '' }}">
                <i class="fas fa-key"></i><span>Cambiar Contraseña</span>
            </a>
        </li>

        {{-- ── AYUDA ── --}}
        <li class="menu-section-title">AYUDA</li>

        <li class="menu-item">
            <a href="{{ route('estado-solicitud') }}"
               class="menu-link {{ request()->routeIs('estado-solicitud') ? 'active' : '' }}">
                <i class="fas fa-question-circle"></i><span>Estado de Solicitud</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('acciones_importantes.index') }}"
               class="menu-link {{ request()->routeIs('acciones_importantes.*') ? 'active' : '' }}">
                <i class="fas fa-history"></i><span>Ver Acciones Recientes</span>
            </a>
        </li>

    </ul>
</aside>
@endif

{{-- Main content: sin sidebar para roles no-admin --}}
<div class="main-content {{ !$showSidebar ? 'no-sidebar' : '' }}">

    <div class="topbar">
        <div class="topbar-left">
            @if($showSidebar)
            <button class="mobile-menu-btn" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            @endif
            <h5>@yield('page-title', 'Panel de Control')</h5>
        </div>

        <div class="topbar-right">
            @hasSection('topbar-actions')
                <div class="topbar-actions-group">
                    @yield('topbar-actions')
                </div>
                <div class="topbar-divider"></div>
            @endif

            {{-- Fecha/hora --}}
            <div class="topbar-date">
                <i class="far fa-clock"></i>
                <span>{{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</span>
            </div>

            <div class="topbar-divider"></div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                </button>
            </form>
        </div>
    </div>

    <div class="content-wrapper">

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert"
             style="border-left:4px solid #10b981;border-radius:10px;">
            <i class="fas fa-check-circle me-2"></i>
            <strong>¡Éxito!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"
             style="border-left:4px solid #ef4444;border-radius:10px;">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>¡Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')
    </div>
</div>

{{-- MODAL ELIMINACIÓN --}}
<div class="modal-delete-overlay" id="modalDelete">
    <div class="modal-delete">
        <button type="button" class="modal-delete-close" onclick="cerrarModalDelete()">
            <i class="fas fa-times"></i>
        </button>
        <div class="modal-delete-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h4 class="modal-delete-title">¿Confirmar Eliminación?</h4>
        <div class="modal-delete-content">
            <p class="modal-delete-message" id="deleteMessage">
                Esta acción no se puede deshacer. ¿Estás seguro de que deseas eliminar este registro?
            </p>
            <div class="modal-delete-item" id="deleteItemInfo" style="display:none;">
                <div class="delete-item-icon"><i class="fas fa-file-alt"></i></div>
                <div class="delete-item-details">
                    <span class="delete-item-label">Elemento a eliminar:</span>
                    <strong class="delete-item-name" id="deleteItemName"></strong>
                </div>
            </div>
        </div>
        <form id="formDelete" method="POST" style="display:none;">
            @csrf
            @method('DELETE')
        </form>
        <div class="modal-delete-actions">
            <button type="button" class="btn-delete-cancel" onclick="cerrarModalDelete()">
                <i class="fas fa-times"></i> Cancelar
            </button>
            <button type="button" class="btn-delete-confirm" onclick="confirmarEliminacion()">
                <i class="fas fa-trash-alt"></i> Eliminar
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Con null-check para seguridad
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        if (sidebar && overlay) {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }
    }

    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(el => {
            try { new bootstrap.Alert(el).close(); } catch(e) {}
        });
    }, 5000);

    const sidebar = document.getElementById('sidebar');
    if (sidebar) {
        const saved = sessionStorage.getItem('sidebarScrollPosition');
        if (saved) sidebar.scrollTop = parseInt(saved);

        sidebar.querySelectorAll('.menu-link').forEach(link => {
            link.addEventListener('click', () => {
                sessionStorage.setItem('sidebarScrollPosition', sidebar.scrollTop);
            });
        });

        sidebar.addEventListener('scroll', () => {
            sessionStorage.setItem('sidebarScrollPosition', sidebar.scrollTop);
        });

        const activeLink = sidebar.querySelector('.menu-link.active');
        if (activeLink && saved === null) {
            // Verifica visibilidad antes de hacer scroll
            const sidebarRect    = sidebar.getBoundingClientRect();
            const activeLinkRect = activeLink.getBoundingClientRect();
            if (activeLinkRect.top < sidebarRect.top || activeLinkRect.bottom > sidebarRect.bottom) {
                const scrollPosition = activeLink.offsetTop - (sidebar.clientHeight / 2) + (activeLink.clientHeight / 2);
                sidebar.scrollTo({ top: scrollPosition, behavior: 'smooth' });
            }
        }
    }

    function mostrarModalDelete(url, mensaje, itemName) {
        document.getElementById('deleteMessage').textContent =
            mensaje || 'Esta acción no se puede deshacer. ¿Estás seguro de que deseas eliminar este registro?';

        const itemInfo = document.getElementById('deleteItemInfo');
        if (itemName) {
            document.getElementById('deleteItemName').textContent = itemName;
            itemInfo.style.display = 'flex';
        } else {
            itemInfo.style.display = 'none';
        }

        document.getElementById('formDelete').action = url;
        document.getElementById('modalDelete').classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function cerrarModalDelete() {
        document.getElementById('modalDelete').classList.remove('show');
        document.body.style.overflow = '';
    }

    function confirmarEliminacion() {
        document.getElementById('formDelete').submit();
    }

    function mostrarModalDeleteData(button) {
        mostrarModalDelete(
            button.dataset.route,
            button.dataset.message,
            button.dataset.name
        );
    }

    document.addEventListener('click', function(e) {
        if (e.target === document.getElementById('modalDelete')) cerrarModalDelete();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') cerrarModalDelete();
    });
</script>

@stack('scripts')
</body>
</html>
