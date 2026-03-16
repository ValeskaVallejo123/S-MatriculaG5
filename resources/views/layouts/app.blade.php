<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema Escolar') - Escuela Gabriela Mistral</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
            overflow-x: hidden;
        }

        /* ========== SIDEBAR ========== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 260px;
            background: linear-gradient(180deg, #1E5A8E 0%, #2567A0 50%, #1A4E78 100%);
            padding: 0;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 4px 0 20px rgba(30, 90, 142, 0.2);
            overflow-y: auto;
        }

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(76, 152, 182, 0.3);
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(76, 152, 182, 0.5);
        }

        /* Header del Sidebar - MÁS COMPACTO */
        .sidebar-header {
            padding: 1.2rem 1rem;
            background: rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid rgba(76, 152, 182, 0.2);
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            text-decoration: none;
        }

        .sidebar-logo i {
            font-size: 1.5rem;
            background: linear-gradient(135deg, #4C98B6 0%, #1E5A8E 100%);
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(76, 152, 182, 0.3);
        }

        .logo-text h4 {
            margin: 0;
            font-size: 0.95rem;
            font-weight: 700;
            color: white;
        }

        .logo-text p {
            margin: 0;
            font-size: 0.65rem;
            color: rgba(255, 255, 255, 0.6);
            letter-spacing: 0.5px;
        }

        /* User Info - MÁS COMPACTO */
        .user-info {
            padding: 1rem;
            background: rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid rgba(76, 152, 182, 0.2);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4C98B6 0%, #1E5A8E 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: white;
            font-weight: 700;
            box-shadow: 0 3px 10px rgba(76, 152, 182, 0.4);
            flex-shrink: 0;
        }

        .user-details {
            flex: 1;
            min-width: 0;
        }

        .user-details h6 {
            margin: 0;
            color: white;
            font-size: 0.85rem;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-details p {
            margin: 0;
            font-size: 0.65rem;
            color: rgba(255, 255, 255, 0.6);
        }

        /* Badge diferenciador - MÁS PEQUEÑO */
        .user-role-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.6rem;
            font-weight: 700;
            margin-top: 2px;
            letter-spacing: 0.3px;
        }

        .badge-superadmin {
            background: linear-gradient(135deg, #4C98B6 0%, #1E5A8E 100%);
            color: white;
            box-shadow: 0 2px 6px rgba(76, 152, 182, 0.3);
        }

        .badge-admin {
            background: rgba(76, 152, 182, 0.2);
            color: #4C98B6;
            border: 1px solid rgba(76, 152, 182, 0.3);
        }

        /* Menu - MÁS COMPACTO */
        .sidebar-menu {
            list-style: none;
            padding: 0.8rem 0.6rem;
        }

        .menu-section-title {
            padding: 0.8rem 0.8rem 0.4rem;
            color: rgba(76, 152, 182, 0.8);
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .menu-item {
            margin-bottom: 2px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.6rem 0.8rem;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .menu-link i {
            font-size: 1rem;
            width: 22px;
            text-align: center;
            color: rgba(76, 152, 182, 0.8);
        }

        .menu-link:hover {
            background: rgba(76, 152, 182, 0.15);
            color: white;
            transform: translateX(3px);
        }

        .menu-link:hover i {
            color: #4C98B6;
        }

        .menu-link.active {
            background: linear-gradient(135deg, rgba(76, 152, 182, 0.25) 0%, rgba(76, 152, 182, 0.15) 100%);
            color: white;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(76, 152, 182, 0.2);
            border-left: 3px solid #4C98B6;
            padding-left: 0.6rem;
        }

        .menu-link.active i {
            color: #4C98B6;
        }

        /* Estilos para el submenú */
        #cuposSubmenu .menu-link {
            padding: 0.5rem 0.8rem;
            font-size: 0.8rem;
            font-weight: 400;
        }

        #cuposSubmenu .menu-link.active {
            font-weight: 500;
            background: rgba(76, 152, 182, 0.2);
        }


        /* ========== MAIN CONTENT ========== */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        .main-content.no-sidebar {
            margin-left: 0;
        }

        /* ========== TOPBAR BUTTON STYLES ========== */

        /* Botón Salir */
        .btn-logout {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
        }

        .btn-logout:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.5);
            color: white;
        }

        /* Botón Volver */
        .btn-back {
            background: linear-gradient(135deg, #1E5A8E 0%, #4C98B6 100%);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(30, 90, 142, 0.3);
        }

        .btn-back:hover {
            background: linear-gradient(135deg, #1A4E78 0%, #4288A5 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 90, 142, 0.5);
        }

        /* Botón Primario con Degradado */
        .btn-primary-gradient {
            background: linear-gradient(135deg, #1E5A8E 0%, #4C98B6 100%);
            border: none;
            color: white;
            font-weight: bold;
            padding: 0.5rem 1.25rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 10px rgba(30, 90, 142, 0.4);
            transition: all 0.2s ease-in-out;
        }

        .btn-primary-gradient:hover {
            background: linear-gradient(135deg, #1A4E78 0%, #4288A5 100%);
            box-shadow: 0 6px 12px rgba(30, 90, 142, 0.6);
            color: white;
            transform: translateY(-2px);
        }

        /* Botón Secundario con Contorno */
        .btn-secondary-outline {
            background-color: white;
            border: 2px solid #1E5A8E;
            color: #1E5A8E;
            font-weight: bold;
            padding: 0.5rem 1.25rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease-in-out;
        }

        .btn-secondary-outline:hover {
            background-color: #1E5A8E;
            color: white;
            border-color: #1E5A8E;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(30, 90, 142, 0.3);
        }

        .btn-secondary-outline:focus,
        .btn-secondary-outline:active {
            box-shadow: 0 0 0 0.25rem rgba(30, 90, 142, 0.25);
        }

        /* Botón Secundario Temático */
        .btn-secondary-themed {
            background-color: transparent;
            border: 2px solid white;
            color: white;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease-in-out;
        }

        .btn-secondary-themed:hover {
            background-color: white;
            color: #1E5A8E;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(255, 255, 255, 0.3);
        }

        /* ========== CONTENT WRAPPER - MÁS COMPACTO ========== */
        .content-wrapper {
            padding: 1.5rem;
        }

        /* ========== ALERTS - MÁS COMPACTOS ========== */
        .alert-custom {
            padding: 0.8rem 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            animation: slideInDown 0.4s ease;
            font-size: 0.9rem;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(30, 90, 142, 0.15) 0%, rgba(76, 152, 182, 0.1) 100%);
            border-left: 3px solid #1E5A8E;
            color: #1A4E78;
        }

        .alert-success i {
            color: #1E5A8E;
        }

        .alert-error {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border-left: 3px solid #ef4444;
            color: #991b1b;
        }

        .alert-error i {
            color: #ef4444;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .sidebar {
                left: -260px;
            }

            .sidebar.active {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-menu-btn {
                display: block !important;
            }

            .content-wrapper {
                padding: 1rem;
            }
        }

        .mobile-menu-btn {
            display: none;
            background: linear-gradient(135deg, #1E5A8E 0%, #4C98B6 100%);
            color: white;
            border: none;
            padding: 0.5rem 0.8rem;
            border-radius: 8px;
            font-size: 1.1rem;
            box-shadow: 0 2px 8px rgba(30, 90, 142, 0.3);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .sidebar-overlay.active {
            display: block;
        }

        /* Mejorar legibilidad en alertas */
        .alert-custom strong {
            font-weight: 700;
        }

        .alert-custom p {
            margin: 0;
        }

        /* Estilos adicionales para compatibilidad */
        .btn-uniform-width {
            min-width: 130px;
            text-align: center;
        }
    </style>

    @yield('styles')
    @stack('scripts')
</head>
<body>

@php
    $userType = auth()->user()->user_type ?? 'guest';
    $isSuperAdmin = auth()->user()->is_super_admin ?? false;
    $isAdmin = in_array($userType, ['admin', 'super_admin']);
    $showSidebar = $isSuperAdmin || $isAdmin;
@endphp

@if($showSidebar)
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="sidebar-logo">
                <i class="fas fa-graduation-cap"></i>
                <div class="logo-text">
                    <h4>Gabriela Mistral</h4>
                    <p>SISTEMA ESCOLAR</p>
                </div>
            </a>
        </div>

        <div class="user-info">
            <div class="user-avatar">
                {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
            </div>
            <div class="user-details">
                <h6>{{ auth()->user()->name ?? 'Administrador' }}</h6>
                @if($isSuperAdmin)
                    <span class="user-role-badge badge-superadmin">
                        <i class="fas fa-crown"></i> SUPER ADMIN
                    </span>
                @else
                    <span class="user-role-badge badge-admin">
                        <i class="fas fa-user-shield"></i> ADMIN
                    </span>
                @endif
            </div>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-section-title">Principal</li>
            <li class="menu-item">
                <a href="{{ url('/') }}" class="menu-link">
                    <i class="fas fa-home"></i>
                    <span>Inicio</span>
                </a>
            </li>

            @if($isSuperAdmin)
                <li class="menu-item">
                    <a href="{{ route('superadmin.dashboard') }}" class="menu-link {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            @endif

            <li class="menu-section-title">Gestión de Usuarios</li>

            @if($isSuperAdmin)
                <li class="menu-item">
                    <a href="{{ route('admins.index') }}" class="menu-link {{ request()->routeIs('admins.*') ? 'active' : '' }}">
                        <i class="fas fa-user-shield"></i>
                        <span>Administradores</span>
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
                <a href="{{ route('profesores.index') }}" class="menu-link {{ request()->routeIs('profesores.*') ? 'active' : '' }}">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>Profesores</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('estudiantes.buscar') }}" class="menu-link {{ request()->routeIs('estudiantes.buscar') ? 'active' : '' }}">
                    <i class="fas fa-search"></i>
                    <span>Buscar Estudiante</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('admins.permisos.index') }}"
                   class="menu-link {{ request()->routeIs('admins.permisos.*') ? 'active' : '' }}">
                    <i class="fas fa-user-lock"></i>
                    <span>Permisos de Padres</span>
                </a>
            </li>

            <li class="menu-section-title">Gestión Académica</li>

            <li class="menu-item">
                <a href="{{ route('matriculas.index') }}" class="menu-link {{ request()->routeIs('matriculas.*') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Matrículas</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('periodos-academicos.index') }}" class="menu-link {{ request()->routeIs('periodos-academicos.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Periodos Académicos</span>
                </a>
            </li>

            {{-- INICIO: OPCIÓN DE CUPOS MÁXIMOS CON SUBMENÚ DESPLEGABLE --}}
            <li class="menu-item">
                <a href="#cuposSubmenu" data-bs-toggle="collapse"
                   class="menu-link d-flex justify-content-between align-items-center {{ request()->routeIs('cupos_maximos.*') ? 'active' : '' }}"
                   aria-expanded="{{ request()->routeIs('cupos_maximos.*') ? 'true' : 'false' }}">
                    <div>
                        <i class="fas fa-users"></i>
                        <span>Cupos Máximos</span>
                    </div>
                    <i class="fas fa-caret-down" style="font-size: 0.7rem;"></i>
                </a>
                <ul class="collapse list-unstyled {{ request()->routeIs('cupos_maximos.*') ? 'show' : '' }}" id="cuposSubmenu">
                    <li class="menu-item" style="padding-left: 0.8rem;">
                        <a href="{{ route('cupos_maximos.index') }}" class="menu-link {{ request()->routeIs('cupos_maximos.index') ? 'active' : '' }}">
                            <i class="fas fa-list-alt"></i>
                            <span>Listado de cupos</span>
                        </a>
                    </li>
                    <li class="menu-item" style="padding-left: 0.8rem;">
                        <a href="{{ route('cupos_maximos.create') }}" class="menu-link {{ request()->routeIs('cupos_maximos.create') ? 'active' : '' }}">
                            <i class="fas fa-plus-circle"></i>
                            <span>Registrar cupo</span>
                        </a>
                    </li>
                </ul>
            </li>
            {{-- FIN: OPCIÓN DE CUPOS MÁXIMOS CON SUBMENÚ DESPLEGABLE --}}

            <li class="menu-item">
                <a href="{{ route('observaciones.index') }}" class="menu-link {{ request()->routeIs('observaciones.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Observaciones</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('documentos.index') }}" class="menu-link {{ request()->routeIs('documentos.*') ? 'active' : '' }}">
                    <i class="fas fa-folder-open"></i>
                    <span>Documentos</span>
                </a>
            </li>

            <li class="menu-section-title">Sistema</li>

            <li class="menu-item">
                <a href="{{ route('cambiarcontrasenia.edit') }}" class="menu-link {{ request()->routeIs('cambiarcontrasenia.*') ? 'active' : '' }}">
                    <i class="fas fa-key"></i>
                    <span>Cambiar Contraseña</span>
                </a>
            </li>
        </ul>
    </aside>
@endif

<main class="main-content {{ !$showSidebar ? 'no-sidebar' : '' }}">
    <div class="content-wrapper">
        @if(session('success'))
            <div class="alert-custom alert-success">
                <i class="fas fa-check-circle" style="font-size: 1.2rem;"></i>
                <div>
                    <strong>¡Éxito!</strong>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert-custom alert-error">
                <i class="fas fa-exclamation-circle" style="font-size: 1.2rem;"></i>
                <div>
                    <strong>¡Error!</strong>
                    <p>{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @yield('content')
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
    }

    // Auto-hide alerts after 5 seconds
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert-custom');
        alerts.forEach(alert => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);
</script>

@yield('scripts')
@stack('scripts')
</body>
</html>
