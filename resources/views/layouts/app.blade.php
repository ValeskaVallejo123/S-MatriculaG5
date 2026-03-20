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
        html { font-size: 17px; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fa;
            overflow-x: hidden;
            font-size: 1rem;
            transition: background 0.3s ease;
        }

        /* =========================================
           CONFIGURACIÓN MODO OSCURO (CORREGIDA)
           ========================================= */
        body.dark-mode {
            background-color: #0f172a !important;
            color: #f1f5f9;
        }

        /* Elementos del Layout */
        body.dark-mode .sidebar {
            background: linear-gradient(180deg, #020617 0%, #0f172a 100%) !important;
            box-shadow: 4px 0 15px rgba(0,0,0,0.5);
        }
        body.dark-mode .topbar {
            background: #1e293b !important;
            border-bottom: 1px solid #334155;
        }
        body.dark-mode .main-content { background: #0f172a !important; }

        /* UNIFICACIÓN DE TARJETAS (Cards) */
        body.dark-mode .card,
        body.dark-mode .welcome-card,
        body.dark-mode .adm-card,
        body.dark-mode .adm-stat,
        body.dark-mode .stat-card,
        body.dark-mode .action-card,
        body.dark-mode .modal-content,
        body.dark-mode .adm-toolbar {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #f1f5f9 !important;
        }

        /* TEXTOS PRINCIPALES (Forzar Blanco Puro) */
        body.dark-mode h1, body.dark-mode h2, body.dark-mode h3,
        body.dark-mode h4, body.dark-mode h5, body.dark-mode h6,
        body.dark-mode .welcome-title,
        body.dark-mode .stat-value,
        body.dark-mode .adm-stat-num,
        body.dark-mode .action-title,
        body.dark-mode .card-title,
        body.dark-mode .fw-bold,
        body.dark-mode .text-dark,
        body.dark-mode strong {
            color: #ffffff !important;
        }

        /* DATOS CRÍTICOS (DNI, Nombres en tabla, Celdas) */
        body.dark-mode .table td,
        body.dark-mode .table th,
        body.dark-mode .text-primary,
        body.dark-mode .dni-text {
            color: #ffffff !important;
        }

        /* TEXTOS SECUNDARIOS (Gris claro para legibilidad) */
        body.dark-mode .welcome-subtitle,
        body.dark-mode .stat-label,
        body.dark-mode .action-subtitle,
        body.dark-mode .adm-stat-lbl,
        body.dark-mode .text-muted,
        body.dark-mode label,
        body.dark-mode p {
            color: #cbd5e1 !important;
        }

        /* CORRECCIÓN PARA SPANS (Evita el tono transparente) */
        body.dark-mode span:not(.badge):not(.text-white) {
            color: inherit;
        }

        /* TABLAS Y BUSCADORES */
        body.dark-mode .table, body.dark-mode .adm-tbl { color: #f1f5f9 !important; }
        body.dark-mode .table thead th {
            background: #1e293b !important;
            color: #4ec7d2 !important;
            border-bottom: 2px solid #334155 !important;
        }
        body.dark-mode .table td { border-bottom-color: #334155 !important; }

        body.dark-mode .form-control {
            background-color: #0f172a !important;
            border-color: #334155 !important;
            color: #ffffff !important;
        }
        body.dark-mode .form-control::placeholder { color: #475569 !important; }

        /* Ajustes específicos para action-cards */
        body.dark-mode .action-card-header {
            background: rgba(255,255,255,0.03) !important;
            border-bottom-color: #334155 !important;
        }
        body.dark-mode .action-icon { opacity: 0.9; }

        body.dark-mode .action-card-body .btn-outline-primary {
            color: #4ec7d2;
            border-color: #4ec7d2;
        }
        body.dark-mode .action-card-body .btn-outline-primary:hover {
            background-color: #4ec7d2;
            color: #0f172a;
        }

        /* Botón de Modo Oscuro */
        .btn-toggle-dark {
            background: #f1f5f9; color: #003b73; border: 1px solid #e5e7eb;
            padding: .5rem .8rem; border-radius: 8px; font-size: .85rem; font-weight: 700;
            display: flex; align-items: center; gap: .5rem; cursor: pointer; transition: 0.3s;
        }
        body.dark-mode .btn-toggle-dark { background: #334155; color: #fbbf24; border-color: #475569; }

        /* =========================================
           ESTILOS ORIGINALES DEL SIDEBAR
           ========================================= */
        .sidebar {
            position: fixed; top: 0; left: 0;
            height: 100vh; width: 280px;
            background: linear-gradient(180deg, #003b73 0%, #00508f 100%);
            transition: all .3s ease; z-index: 1000;
            box-shadow: 4px 0 15px rgba(0,59,115,.2);
            overflow-y: auto;
        }
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

        .user-info { padding: 1.5rem 1.2rem; border-bottom: 1px solid rgba(78,199,210,.2); text-align: center; }
        .user-avatar {
            width: 60px; height: 60px; border-radius: 50%;
            background: linear-gradient(135deg, #4ec7d2, #00508f);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; color: white; font-weight: 700; margin: 0 auto .8rem;
            box-shadow: 0 4px 12px rgba(78,199,210,.4);
        }
        .user-details h6 { margin: 0; color: white; font-size: .95rem; font-weight: 600; }
        .user-details p  { margin: 0; font-size: .75rem; color: rgba(255,255,255,.6); font-weight: 500; }

        .sidebar-menu { list-style: none; padding: 1rem 0; }
        .menu-section-title { padding: 1rem 1.2rem .5rem; color: rgba(78,199,210,.8); font-size: .80rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.2px; }
        .menu-link { display: flex; align-items: center; gap: 12px; padding: .75rem 1.2rem; color: rgba(255,255,255,.8); text-decoration: none; transition: all .2s ease; font-size: .9rem; font-weight: 500; }
        .menu-link i { font-size: 1.1rem; width: 24px; text-align: center; color: rgba(78,199,210,.9); }
        .menu-link:hover { background: rgba(78,199,210,.15); color: white; }
        .menu-link.active { background: rgba(78,199,210,.2); color: white; border-left: 3px solid #4ec7d2; padding-left: calc(1.2rem - 3px); }

        .main-content { margin-left: 280px; min-height: 100vh; background: #f5f7fa; }
        .topbar {
            background: white; padding: 0 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,.06);
            border-bottom: 1px solid #e5e7eb;
            position: sticky; top: 0; z-index: 100;
            min-height: 64px; display: flex; align-items: center; justify-content: space-between;
        }
        .btn-logout { background: linear-gradient(135deg, #ef4444, #dc2626); color: white; border: none; padding: .6rem .75rem; border-radius: 7px; font-size: .83rem; font-weight: 600; display: flex; align-items: center; gap: .4rem; }
        .content-wrapper { padding: 2rem; }

        @media (max-width: 768px) {
            .sidebar { left: -280px; }
            .sidebar.active { left: 0; }
            .main-content { margin-left: 0 !important; }
        }
    </style>
    @stack('styles')
</head>
<body>

@php
    $user         = auth()->user();
    $isSuperAdmin = $user && ($user->is_super_admin == 1 || $user->id_rol == 1);
    $isAdmin      = $user && in_array($user->id_rol, [1, 2]);
    $showSidebar  = $isAdmin;
    $roleName     = $isSuperAdmin ? 'Super Administrador' : ($isAdmin ? 'Administrador' : 'Usuario');
@endphp

@if($showSidebar)
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ $isSuperAdmin ? route('superadmin.dashboard') : route('admin.dashboard') }}" class="sidebar-logo">
                <i class="fas fa-graduation-cap"></i>
                <div class="logo-text"><h4>Escuela G.M.</h4><p>Sistema de Gestión</p></div>
            </a>
        </div>
        <div class="user-info">
            <div class="user-avatar">{{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}</div>
            <div class="user-details"><h6>{{ $user->name ?? 'Usuario' }}</h6><p>{{ $roleName }}</p></div>
        </div>
        <ul class="sidebar-menu">
            {{-- Menu items go here --}}
            <li class="menu-section-title">PRINCIPAL</li>
            <li class="menu-item">
                <a href="{{ $isSuperAdmin ? route('superadmin.dashboard') : route('admin.dashboard') }}" class="menu-link {{ request()->routeIs('superadmin.dashboard', 'admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i><span>Dashboard</span>
                </a>
            </li>
            <li class="menu-section-title">USUARIOS</li>
            @if($isSuperAdmin)
                <li class="menu-item"><a href="{{ route('superadmin.administradores.index') }}" class="menu-link {{ request()->routeIs('superadmin.administradores.*') ? 'active' : '' }}"><i class="fas fa-user-shield"></i><span>Administradores</span></a></li>
                <li class="menu-item"><a href="{{ route('superadmin.usuarios.pendientes') }}" class="menu-link {{ request()->routeIs('superadmin.usuarios.pendientes') ? 'active' : '' }}"><i class="fas fa-user-clock"></i><span>Pendientes</span></a></li>
            @endif
            <li class="menu-item"><a href="{{ route('estudiantes.index') }}" class="menu-link {{ request()->routeIs('estudiantes.*') ? 'active' : '' }}"><i class="fas fa-user-graduate"></i><span>Estudiantes</span></a></li>
            <li class="menu-item"><a href="{{ route('profesores.index') }}" class="menu-link {{ request()->routeIs('profesores.*') ? 'active' : '' }}"><i class="fas fa-chalkboard-teacher"></i><span>Profesores</span></a></li>
            <li class="menu-section-title">MATRÍCULAS</li>
            <li class="menu-item"><a href="{{ route('matriculas.index') }}" class="menu-link {{ request()->routeIs('matriculas.*') ? 'active' : '' }}"><i class="fas fa-clipboard-list"></i><span>Matrículas</span></a></li>
            <li class="menu-section-title">ACADÉMICO</li>
            <li class="menu-item"><a href="{{ $isSuperAdmin ? route('superadmin.grados.index') : route('grados.index') }}" class="menu-link {{ request()->routeIs('superadmin.grados.*', 'grados.*') ? 'active' : '' }}"><i class="fas fa-layer-group"></i><span>Grados</span></a></li>
            <li class="menu-item"><a href="{{ $isSuperAdmin ? route('superadmin.materias.index') : route('materias.index') }}" class="menu-link {{ request()->routeIs('superadmin.materias.*', 'materias.*') ? 'active' : '' }}"><i class="fas fa-book"></i><span>Materias</span></a></li>
            <li class="menu-item"><a href="{{ route('superadmin.horarios_grado.index') }}" class="menu-link {{ request()->routeIs('superadmin.horarios_grado.*') ? 'active' : '' }}"><i class="fas fa-calendar-alt"></i><span>Horarios y Asignación</span></a></li>
            <li class="menu-item"><a href="{{ route('superadmin.cupos_maximos.index') }}" class="menu-link {{ request()->routeIs('superadmin.cupos_maximos.*') ? 'active' : '' }}"><i class="fas fa-users-cog"></i><span>Cupos Máximos</span></a></li>
            <li class="menu-section-title">CONFIGURACIÓN</li>
            @if($isSuperAdmin)
                <li class="menu-item"><a href="{{ route('superadmin.perfil') }}" class="menu-link {{ request()->routeIs('superadmin.perfil') ? 'active' : '' }}"><i class="fas fa-user-circle"></i><span>Mi Perfil</span></a></li>
            @endif
        </ul>
    </aside>
@endif

<div class="main-content {{ !$showSidebar ? 'no-sidebar' : '' }}">
    <div class="topbar">
        <div class="topbar-left d-flex align-items-center gap-3">
            @if($showSidebar)
                <button class="mobile-menu-btn btn btn-sm btn-primary d-md-none" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
            @endif
            <h5 class="mb-0">@yield('page-title', 'Panel de Control')</h5>
        </div>

        <div class="topbar-right d-flex align-items-center gap-3">
            {{-- BOTÓN MODO OSCURO (NATIVO EN LAYOUT) --}}
            <button id="globalDarkModeToggle" class="btn-toggle-dark">
                <i class="fas fa-moon" id="globalDarkIcon"></i>
                <span id="globalDarkText" class="d-none d-md-inline">Modo Oscuro</span>
            </button>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> <span class="d-none d-md-inline">Cerrar Sesión</span></button>
            </form>
        </div>
    </div>

    <div class="content-wrapper">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
    </div>
</div>

{{-- Modal and generic scripts --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('active');
    }

    // LÓGICA DE MODO OSCURO GLOBAL
    (function() {
        const btn = document.getElementById('globalDarkModeToggle');
        const icon = document.getElementById('globalDarkIcon');
        const text = document.getElementById('globalDarkText');

        function actualizarInterfaz(isDark) {
            if (isDark) {
                document.body.classList.add('dark-mode');
                icon.className = 'fas fa-sun';
                text.innerText = 'Modo Claro';
            } else {
                document.body.classList.remove('dark-mode');
                icon.className = 'fas fa-moon';
                text.innerText = 'Modo Oscuro';
            }
        }

        const themeSaved = localStorage.getItem('theme');
        if (themeSaved === 'dark') {
            actualizarInterfaz(true);
        }

        btn.addEventListener('click', () => {
            const isDark = document.body.classList.toggle('dark-mode');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            actualizarInterfaz(isDark);
        });
    })();
</script>
@stack('scripts')
</body>
</html>
