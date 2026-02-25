<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema Escolar') - Escuela Gabriela Mistral</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fa;
            overflow-x: hidden;
        }

        /* ========== SIDEBAR ========== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            background: linear-gradient(180deg, #003b73 0%, #00508f 100%);
            padding: 0;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 4px 0 15px rgba(0, 59, 115, 0.2);
            overflow-y: auto;
        }

        .sidebar::-webkit-scrollbar { width: 8px; }
        .sidebar::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.15);
            border-radius: 10px;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(78, 199, 210, 0.6);
            border-radius: 10px;
            border: 1px solid rgba(0, 59, 115, 0.3);
        }
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(78, 199, 210, 0.9);
        }

        .sidebar-header {
            padding: 1.5rem 1.2rem;
            border-bottom: 1px solid rgba(78, 199, 210, 0.2);
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .sidebar-logo i {
            font-size: 2rem;
            color: #f59e0b;
            background: rgba(245, 158, 11, 0.15);
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            border: 3px solid rgba(245, 158, 11, 0.3);
        }

        .logo-text h4 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 700;
            color: #f59e0b;
            line-height: 1.2;
        }

        .logo-text p {
            margin: 0;
            font-size: 0.75rem;
            color: rgba(245, 158, 11, 0.8);
            letter-spacing: 0.5px;
            font-weight: 500;
        }

        .user-info {
            padding: 1.5rem 1.2rem;
            border-bottom: 1px solid rgba(78, 199, 210, 0.2);
            text-align: center;
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            font-weight: 700;
            margin: 0 auto 0.8rem;
            box-shadow: 0 4px 12px rgba(78, 199, 210, 0.4);
        }

        .user-details h6 {
            margin: 0 0 0.3rem 0;
            color: white;
            font-size: 0.95rem;
            font-weight: 600;
        }

        .user-details p {
            margin: 0;
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.6);
            font-weight: 500;
        }

        .sidebar-menu { list-style: none; padding: 1rem 0; }

        .menu-section-title {
            padding: 1rem 1.2rem 0.5rem;
            color: rgba(78, 199, 210, 0.8);
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
        }

        .menu-item { margin: 0; }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.75rem 1.2rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .menu-link i {
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
            color: rgba(78, 199, 210, 0.9);
        }

        .menu-link:hover {
            background: rgba(78, 199, 210, 0.15);
            color: white;
        }

        .menu-link:hover i { color: #4ec7d2; }

        .menu-link.active {
            background: rgba(78, 199, 210, 0.2);
            color: white;
            border-left: 3px solid #4ec7d2;
            padding-left: calc(1.2rem - 3px);
        }

        .menu-link.active i { color: #4ec7d2; }

        .menu-badge {
            margin-left: auto;
            background: #ef4444;
            color: white;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.15rem 0.5rem;
            border-radius: 12px;
            min-width: 24px;
            text-align: center;
        }

        /* ========== MAIN CONTENT ========== */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            transition: all 0.3s ease;
            background: #f5f7fa;
        }

        .main-content.no-sidebar { margin-left: 0; }

        /* ========== TOPBAR ========== */
        .topbar {
            background: white;
            padding: 0 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,.06);
            border-bottom: 1px solid #e5e7eb;
            position: sticky;
            top: 0;
            z-index: 100;
            min-height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: .75rem;
        }

        .topbar-left h5 {
            margin: 0;
            color: #003b73;
            font-weight: 700;
            font-size: 1.15rem;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: .6rem;
            flex-wrap: nowrap;
        }

        .topbar-divider {
            width: 1px;
            height: 24px;
            background: #e2e8f0;
            flex-shrink: 0;
        }

        .topbar-date {
            display: flex;
            align-items: center;
            gap: .4rem;
            color: #6b7280;
            font-size: .8rem;
            padding: .38rem .75rem;
            background: #f9fafb;
            border-radius: 7px;
            border: 1px solid #e5e7eb;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .topbar-date i { color: #00508f; font-size: .8rem; }

        .btn-logout {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border: none;
            padding: .38rem .9rem;
            border-radius: 7px;
            font-size: .82rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: .4rem;
            transition: all .2s ease;
            white-space: nowrap;
            flex-shrink: 0;
            cursor: pointer;
        }

        .btn-logout:hover {
            opacity: .9;
            transform: translateY(-1px);
        }

        .topbar-actions-group {
            display: flex;
            align-items: center;
            gap: .5rem;
            flex-wrap: nowrap;
        }

        .topbar-actions-group a,
        .topbar-actions-group button {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .38rem .9rem;
            border-radius: 7px;
            font-size: .82rem;
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap;
            transition: all .2s ease;
            cursor: pointer;
            border: none;
        }

        /* ========== CONTENT WRAPPER ========== */
        .content-wrapper { padding: 2rem; }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .sidebar { left: -280px; }
            .sidebar.active { left: 0; }
            .main-content { margin-left: 0; }
            .mobile-menu-btn { display: block !important; }
            .content-wrapper { padding: 1rem; }
            .topbar { padding: .75rem 1rem; }
            .topbar-date { display: none; }
            .topbar-divider { display: none; }
            .topbar-right { gap: .4rem; }
        }

        .mobile-menu-btn {
            display: none;
            background: linear-gradient(135deg, #4ec7d2, #00508f);
            color: white;
            border: none;
            padding: .5rem .75rem;
            border-radius: 7px;
            font-size: 1rem;
            cursor: pointer;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,.5);
            z-index: 999;
        }

        .sidebar-overlay.active { display: block; }

        /* ========== MODAL ELIMINACIÓN ========== */
        .modal-delete-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,.6);
            backdrop-filter: blur(4px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            opacity: 0;
            transition: opacity .3s ease;
        }

        .modal-delete-overlay.show {
            display: flex;
            animation: fadeIn .3s ease forwards;
        }

        @keyframes fadeIn { to { opacity: 1; } }

        .modal-delete {
            background: white;
            border-radius: 16px;
            max-width: 480px;
            width: 90%;
            box-shadow: 0 10px 40px rgba(239,68,68,.2);
            transform: scale(.95);
            animation: scaleUp .3s cubic-bezier(.68,-.55,.265,1.55) forwards;
            position: relative;
            overflow: hidden;
        }

        @keyframes scaleUp { to { transform: scale(1); } }

        .modal-delete-close {
            position: absolute;
            top: 1rem; right: 1rem;
            width: 32px; height: 32px;
            background: #f1f5f9;
            border: none; border-radius: 8px;
            color: #64748b; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: all .2s ease; z-index: 1;
        }

        .modal-delete-close:hover { background: #e2e8f0; color: #1e293b; }

        .modal-delete-icon {
            width: 80px; height: 80px;
            background: linear-gradient(135deg, rgba(239,68,68,.1), rgba(220,38,38,.1));
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 2rem auto 1.5rem;
            color: #ef4444; font-size: 2.5rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(239,68,68,.4); }
            50% { transform: scale(1.05); box-shadow: 0 0 0 15px rgba(239,68,68,0); }
        }

        .modal-delete-title {
            text-align: center; color: #1e293b;
            font-size: 1.5rem; font-weight: 700;
            margin: 0 0 1.5rem; padding: 0 2rem;
        }

        .modal-delete-content { padding: 0 2rem 2rem; }

        .modal-delete-message {
            text-align: center; color: #64748b;
            font-size: .938rem; line-height: 1.6;
            margin: 0 0 1.5rem;
        }

        .modal-delete-item {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            border-radius: 12px; padding: 1rem;
            display: flex; align-items: center; gap: 1rem;
            border-left: 4px solid #ef4444;
        }

        .delete-item-icon {
            width: 40px; height: 40px;
            background: white; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: #ef4444; font-size: 1.125rem; flex-shrink: 0;
        }

        .delete-item-details { flex: 1; }

        .delete-item-label {
            display: block; color: #64748b;
            font-size: .75rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: .5px; margin-bottom: .25rem;
        }

        .delete-item-name { display: block; color: #1e293b; font-size: .938rem; font-weight: 700; }

        .modal-delete-actions {
            padding: 1rem 1.5rem 1.5rem;
            display: flex; gap: .75rem;
            border-top: 1px solid #e2e8f0;
        }

        .btn-delete-cancel, .btn-delete-confirm {
            flex: 1; padding: .75rem 1.25rem;
            border-radius: 10px; font-weight: 600;
            font-size: .875rem; border: none; cursor: pointer;
            transition: all .3s ease;
            display: inline-flex; align-items: center;
            justify-content: center; gap: .5rem;
        }

        .btn-delete-cancel { background: #f1f5f9; color: #64748b; }
        .btn-delete-cancel:hover { background: #e2e8f0; transform: translateY(-2px); }

        .btn-delete-confirm {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white; box-shadow: 0 4px 12px rgba(239,68,68,.3);
        }
        .btn-delete-confirm:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(239,68,68,.4); }

        @media (max-width: 576px) {
            .modal-delete { max-width: calc(100% - 2rem); margin: 1rem; }
            .modal-delete-title { font-size: 1.25rem; padding: 0 1.5rem; }
            .modal-delete-content { padding: 0 1.5rem 1.5rem; }
            .modal-delete-actions { flex-direction: column; padding: 1rem 1.5rem 1.5rem; }
            .btn-delete-cancel, .btn-delete-confirm { width: 100%; }
        }
    </style>

    @stack('styles')
</head>
<body>

    @php
        $user = auth()->user();
        $isSuperAdmin = $user->is_super_admin == 1 || $user->role === 'super_admin';
        $isAdmin = in_array($user->role, ['admin', 'super_admin']) || $user->is_super_admin == 1;
        $showSidebar = $isSuperAdmin || $isAdmin;

        if ($isSuperAdmin) {
            $roleName = 'Super Administrador';
        } elseif ($user->role === 'admin') {
            $roleName = 'Administrador';
        } else {
            $roleName = ucfirst($user->role ?? 'Usuario');
        }
    @endphp

    @if($showSidebar)
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ $isSuperAdmin ? route('superadmin.dashboard') : route('admin.dashboard') }}" class="sidebar-logo">
                <i class="fas fa-graduation-cap"></i>
                <div class="logo-text">
                    <h4>Escuela G.M.</h4>
                    <p>Sistema de Gestión</p>
                </div>
            </a>
        </div>

        <div class="user-info">
            <div class="user-avatar">{{ substr($user->name ?? 'A', 0, 1) }}</div>
            <div class="user-details">
                <h6>{{ $user->name ?? 'Administrador' }}</h6>
                <p>{{ $roleName }}</p>
            </div>
        </div>

        <ul class="sidebar-menu">

            <!-- PRINCIPAL -->
            <li class="menu-section-title">PRINCIPAL</li>

            @if($isSuperAdmin)
            <li class="menu-item">
                <a href="{{ route('superadmin.dashboard') }}" class="menu-link {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i><span>Dashboard</span>
                </a>
            </li>
            @elseif($isAdmin)
            <li class="menu-item">
                <a href="{{ route('admin.dashboard') }}" class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i><span>Dashboard</span>
                </a>
            </li>
            @endif

            <li class="menu-section-title">GESTIÓN DE USUARIOS</li>

            @if($isSuperAdmin)
            <li class="menu-item">
                <a href="{{ route('superadmin.administradores.index') }}" class="menu-link {{ request()->routeIs('superadmin.administradores.*') ? 'active' : '' }}">
                    <i class="fas fa-user-shield"></i><span>Administradores</span>
                </a>
            </li>
            @endif

            <li class="menu-item">
                <a href="{{ route('estudiantes.index') }}" class="menu-link {{ request()->routeIs('estudiantes.*') ? 'active' : '' }}">
                    <i class="fas fa-user-graduate"></i>
                    <span>Estudiantes</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('calendario') }}" class="menu-link {{ request()->routeIs('calendario') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Calendario Académico</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('grados.index') }}" class="menu-link {{ request()->routeIs('grados.*') ? 'active' : '' }}">
                    <i class="fas fa-book-reader"></i>
                    <span>Plan de Estudios</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('secciones.index') }}" class="menu-link {{ request()->routeIs('secciones.*') ? 'active' : '' }}">
                    <i class="fas fa-layer-group"></i>
                    <span>Secciones</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('profesores.index') }}" class="menu-link {{ request()->routeIs('profesores.*') ? 'active' : '' }}">
                    <i class="fas fa-chalkboard-teacher"></i><span>Profesores</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('padres.index') }}" class="menu-link {{ request()->routeIs('padres.*') ? 'active' : '' }}">
                    <i class="fas fa-user-friends"></i><span>Padres/Tutores</span>
                </a>
            </li>

            <li class="menu-section-title">BÚSQUEDA</li>

            <li class="menu-item">
                <a href="{{ route('buscarregistro') }}" class="menu-link {{ request()->routeIs('buscarregistro') ? 'active' : '' }}">
                    <i class="fas fa-search"></i><span>Registro de estudiante</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('padres.buscar') }}" class="menu-link {{ request()->routeIs('padres.buscar') ? 'active' : '' }}">
                    <i class="fas fa-user-search"></i><span>Buscar Padre/Tutor</span>
                </a>
            </li>

            <li class="menu-section-title">GESTIÓN ACADÉMICA</li>

            <li class="menu-item">
                <a href="{{ route('matriculas.index') }}" class="menu-link {{ request()->routeIs('matriculas.*') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list"></i><span>Matrículas</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="#" class="menu-link {{ request()->routeIs('admin.solicitudes.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Solicitudes</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('grados.index') }}" class="menu-link {{ request()->routeIs('grados.*') ? 'active' : '' }}">
                    <i class="fas fa-layer-group"></i><span>Grados</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('materias.index') }}" class="menu-link {{ request()->routeIs('materias.*') ? 'active' : '' }}">
                    <i class="fas fa-book"></i><span>Materias</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('profesor_materia.index') }}" class="menu-link {{ request()->routeIs('profesor_materia.*') ? 'active' : '' }}">
                    <i class="fas fa-chalkboard-teacher"></i><span>Asignar Profesor</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('periodos-academicos.index') }}" class="menu-link {{ request()->routeIs('periodos-academicos.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i><span>Períodos Académicos</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('cupos_maximos.index') }}" class="menu-link {{ request()->routeIs('cupos_maximos.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i><span>Cupos Máximos</span>
                </a>
            </li>

            <li class="menu-section-title">DOCUMENTACIÓN</li>

            <li class="menu-item">
                <a href="{{ route('observaciones.index') }}" class="menu-link {{ request()->routeIs('observaciones.*') ? 'active' : '' }}">
                    <i class="fas fa-sticky-note"></i><span>Observaciones</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('documentos.index') }}" class="menu-link {{ request()->routeIs('documentos.*') ? 'active' : '' }}">
                    <i class="fas fa-folder-open"></i><span>Documentos</span>
                </a>
            </li>

            <li class="menu-section-title">PERMISOS</li>

            <li class="menu-item">
                <a href="{{ route('admins.permisos.index') }}" class="menu-link {{ request()->routeIs('admins.permisos.*') ? 'active' : '' }}">
                    <i class="fas fa-user-lock"></i><span>Permisos de Padres</span>
                </a>
            </li>

            <li class="menu-section-title">CONFIGURACIÓN</li>

            @if($isSuperAdmin)
            <li class="menu-item">
                <a href="{{ route('superadmin.perfil') }}" class="menu-link {{ request()->routeIs('superadmin.perfil') ? 'active' : '' }}">
                    <i class="fas fa-user-circle"></i><span>Mi Perfil</span>
                </a>
            </li>
            @endif

            <li class="menu-item">
                <a href="{{ route('cambiarcontrasenia.edit') }}" class="menu-link {{ request()->routeIs('cambiarcontrasenia.*') ? 'active' : '' }}">
                    <i class="fas fa-key"></i><span>Cambiar Contraseña</span>
                </a>
            </li>

            <li class="menu-section-title">AYUDA</li>

            <li class="menu-item">
                <a href="{{ route('estado-solicitud') }}" class="menu-link {{ request()->routeIs('estado-solicitud') ? 'active' : '' }}">
                    <i class="fas fa-question-circle"></i><span>Estado de Solicitud</span>
                </a>
            </li>

            <li class="menu-section-title">MÁS</li>

            <li class="menu-item">
                <a href="{{ route('acciones_importantes.index') }}" class="menu-link {{ request()->routeIs('acciones_importantes.index') ? 'active' : '' }}">
                    <i class="fas fa-history"></i><span>Ver acciones recientes</span>
                </a>
            </li>

        </ul>
    </aside>
    @endif

    <!-- MAIN CONTENT -->
    <main class="main-content {{ !$showSidebar ? 'no-sidebar' : '' }}">

        {{-- ── TOPBAR ── --}}
        <div class="topbar">

            {{-- Izquierda: menú móvil + título --}}
            <div class="topbar-left">
                @if($showSidebar)
                <button class="mobile-menu-btn" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                @endif
                <h5>@yield('page-title', 'Panel de Control')</h5>
            </div>

            {{-- Derecha: botones de acción | fecha | logout --}}
            <div class="topbar-right">

                @hasSection('topbar-actions')
                <div class="topbar-actions-group">
                    @yield('topbar-actions')
                </div>
                <div class="topbar-divider"></div>
                @endif

                <div class="topbar-date">
                    <i class="far fa-clock"></i>
                    <span>{{ now()->locale('es')->isoFormat('ddd, D [de] MMM [de] YYYY') }}</span>
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="fas fa-sign-out-alt"></i>
                        Cerrar Sesión
                    </button>
                </form>

            </div>
        </div>
        {{-- ── FIN TOPBAR ── --}}

        <!-- Content -->
        <div class="content-wrapper">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-left:4px solid #10b981;border-radius:10px;">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>¡Éxito!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-left:4px solid #ef4444;border-radius:10px;">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>¡Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Modal Eliminación -->
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('sidebarOverlay').classList.toggle('active');
        }

        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => new bootstrap.Alert(alert).close());
        }, 5000);

        const sidebar = document.getElementById('sidebar');
        if (sidebar) {
            const saved = sessionStorage.getItem('sidebarScrollPosition');
            if (saved) sidebar.scrollTop = parseInt(saved);

            sidebar.querySelectorAll('.menu-link').forEach(link => {
                link.addEventListener('click', () => sessionStorage.setItem('sidebarScrollPosition', sidebar.scrollTop));
            });

            sidebar.addEventListener('scroll', () => {
                sessionStorage.setItem('sidebarScrollPosition', sidebar.scrollTop);
            });

            const activeLink = sidebar.querySelector('.menu-link.active');
            if (activeLink && saved === null) {
                const sidebarRect = sidebar.getBoundingClientRect();
                const activeLinkRect = activeLink.getBoundingClientRect();

                if (activeLinkRect.top < sidebarRect.top || activeLinkRect.bottom > sidebarRect.bottom) {
                    const scrollPosition = activeLink.offsetTop - (sidebar.clientHeight / 2) + (activeLink.clientHeight / 2);
                    sidebar.scrollTo({ top: scrollPosition, behavior: 'smooth' });
                }
            }
        }

        let deleteFormAction = null;

        function mostrarModalDelete(url, mensaje = null, itemName = null) {
            deleteFormAction = url;
            document.getElementById('deleteMessage').textContent = mensaje || 'Esta acción no se puede deshacer. ¿Estás seguro de que deseas eliminar este registro?';
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
            deleteFormAction = null;
        }

        function confirmarEliminacion() {
            document.getElementById('formDelete').submit();
        }

        function mostrarModalDeleteData(button) {
            const route = button.dataset.route;
            const message = button.dataset.message;
            const name = button.dataset.name;
            mostrarModalDelete(route, message, name);
        }

        document.addEventListener('click', e => {
            if (e.target === document.getElementById('modalDelete')) cerrarModalDelete();
        });

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') cerrarModalDelete();
        });
    </script>

    @stack('scripts')
</body>
</html>