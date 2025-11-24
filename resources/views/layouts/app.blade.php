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

        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(78, 199, 210, 0.3);
            border-radius: 10px;
        }

        /* Header del Sidebar */
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
            color: #4ec7d2;
            background: rgba(78, 199, 210, 0.2);
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
        }

        .logo-text h4 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 700;
            color: white;
            line-height: 1.2;
        }

        .logo-text p {
            margin: 0;
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.6);
            letter-spacing: 0.5px;
            font-weight: 500;
        }

        /* User Info */
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

        /* Menu */
        .sidebar-menu {
            list-style: none;
            padding: 1rem 0;
        }

        .menu-section-title {
            padding: 1rem 1.2rem 0.5rem;
            color: rgba(78, 199, 210, 0.8);
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
        }

        .menu-item {
            margin: 0;
        }

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
            position: relative;
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

        .menu-link:hover i {
            color: #4ec7d2;
        }

        .menu-link.active {
            background: rgba(78, 199, 210, 0.2);
            color: white;
            border-left: 3px solid #4ec7d2;
            padding-left: calc(1.2rem - 3px);
        }

        .menu-link.active i {
            color: #4ec7d2;
        }

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

        .main-content.no-sidebar {
            margin-left: 0;
        }

        /* ========== TOPBAR ========== */
        .topbar {
            background: white;
            padding: 1.2rem 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid #e5e7eb;
        }

        .topbar-left h5 {
            margin: 0;
            color: #003b73;
            font-weight: 700;
            font-size: 1.3rem;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .topbar-date {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #6b7280;
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
            background: #f9fafb;
            border-radius: 8px;
        }

        .topbar-date i {
            color: #00508f;
        }

        .btn-logout {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.3);
        }

        .btn-logout:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(239, 68, 68, 0.4);
        }

        /* ========== CONTENT WRAPPER ========== */
        .content-wrapper {
            padding: 2rem;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .sidebar {
                left: -280px;
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

            .topbar {
                padding: 1rem;
            }

            .topbar-date {
                display: none;
            }
        }

        .mobile-menu-btn {
            display: none;
            background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
            color: white;
            border: none;
            padding: 0.6rem 0.9rem;
            border-radius: 8px;
            font-size: 1.1rem;
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
    </style>

    @stack('styles')
</head>
<body>

@php
    // Nuevo sistema de roles
    $userRol = auth()->user()->rol->nombre ?? null;
    $isSuperAdmin = $userRol === 'Super Administrador';
    $isAdmin = in_array($userRol, ['Administrador', 'Super Administrador']);
    $showSidebar = $isSuperAdmin || $isAdmin;
@endphp

    <!-- SIDEBAR (solo para admins) -->
@if($showSidebar)
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <aside class="sidebar" id="sidebar">
        <!-- Header -->
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="sidebar-logo">
                <i class="fas fa-graduation-cap"></i>
                <div class="logo-text">
                    <h4>Escuela G.M.</h4>
                    <p>Sistema de Gestión</p>
                </div>
            </a>
        </div>

        <!-- User Info -->
        <div class="user-info">
            <div class="user-avatar">
                {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
            </div>
            <div class="user-details">
                <h6>{{ auth()->user()->name ?? 'Administrador' }}</h6>
                <p>{{ $userRol ?? 'Sin rol' }}</p>
            </div>
        </div>

        <!-- Menu -->
        <ul class="sidebar-menu">

            <!-- PRINCIPAL -->
            <li class="menu-section-title">PRINCIPAL</li>

            @if($isSuperAdmin)
                <li class="menu-item">
                    <a href="{{ route('superadmin.dashboard') }}" class="menu-link {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            @else
                <li class="menu-item">
                    <a href="{{ route('dashboard') }}" class="menu-link {{ request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') || request()->routeIs('profesor.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            @endif

            <!-- GESTIÓN DE USUARIOS -->
            <li class="menu-section-title">GESTIÓN DE USUARIOS</li>

            @if($isSuperAdmin)
                <li class="menu-item">
                    <a href="{{ route('superadmin.administradores.index') }}" class="menu-link {{ request()->routeIs('superadmin.administradores.*') ? 'active' : '' }}">
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
                <a href="{{ route('padres.index') }}" class="menu-link {{ request()->routeIs('padres.*') ? 'active' : '' }}">
                    <i class="fas fa-user-friends"></i>
                    <span>Padres/Tutores</span>
                </a>
            </li>

            <!-- BÚSQUEDA -->
            <li class="menu-section-title">BÚSQUEDA</li>

            <li class="menu-item">
                <a href="{{ route('buscarregistro') }}" class="menu-link {{ request()->routeIs('buscarregistro') ? 'active' : '' }}">
                    <i class="fas fa-search"></i>
                    <span>Buscar Registro</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('padres.buscar') }}" class="menu-link {{ request()->routeIs('padres.buscar') ? 'active' : '' }}">
                    <i class="fas fa-user-search"></i>
                    <span>Buscar Padre/Tutor</span>
                </a>
            </li>

            <!-- GESTIÓN ACADÉMICA -->
            <li class="menu-section-title">GESTIÓN ACADÉMICA</li>

            <li class="menu-item">
                <a href="{{ route('matriculas.index') }}" class="menu-link {{ request()->routeIs('matriculas.*') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Matrículas</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('grados.index') }}" class="menu-link {{ request()->routeIs('grados.*') ? 'active' : '' }}">
                    <i class="fas fa-layer-group"></i>
                    <span>Grados</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('materias.index') }}" class="menu-link {{ request()->routeIs('materias.*') ? 'active' : '' }}">
                    <i class="fas fa-book"></i>
                    <span>Materias</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('periodos-academicos.index') }}" class="menu-link {{ request()->routeIs('periodos-academicos.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Períodos Académicos</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('cupos_maximos.index') }}" class="menu-link {{ request()->routeIs('cupos_maximos.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Cupos Máximos</span>
                </a>
            </li>

            <!-- DOCUMENTACIÓN -->
            <li class="menu-section-title">DOCUMENTACIÓN</li>

            <li class="menu-item">
                <a href="{{ route('observaciones.index') }}" class="menu-link {{ request()->routeIs('observaciones.*') ? 'active' : '' }}">
                    <i class="fas fa-sticky-note"></i>
                    <span>Observaciones</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('documentos.index') }}" class="menu-link {{ request()->routeIs('documentos.*') ? 'active' : '' }}">
                    <i class="fas fa-folder-open"></i>
                    <span>Documentos</span>
                </a>
            </li>

            <!-- PERMISOS -->
            <li class="menu-section-title">PERMISOS</li>

            <li class="menu-item">
                <a href="{{ route('admins.permisos.index') }}" class="menu-link {{ request()->routeIs('admins.permisos.*') ? 'active' : '' }}">
                    <i class="fas fa-user-lock"></i>
                    <span>Permisos de Padres</span>
                </a>
            </li>

            <!-- CONFIGURACIÓN -->
            <li class="menu-section-title">CONFIGURACIÓN</li>

            @if($isSuperAdmin)
                <li class="menu-item">
                    <a href="{{ route('superadmin.perfil') }}" class="menu-link {{ request()->routeIs('superadmin.perfil') ? 'active' : '' }}">
                        <i class="fas fa-user-circle"></i>
                        <span>Mi Perfil</span>
                    </a>
                </li>
            @endif

            <li class="menu-item">
                <a href="{{ route('cambiarcontrasenia.edit') }}" class="menu-link {{ request()->routeIs('cambiarcontrasenia.*') ? 'active' : '' }}">
                    <i class="fas fa-key"></i>
                    <span>Cambiar Contraseña</span>
                </a>
            </li>

            <!-- AYUDA -->
            <li class="menu-section-title">AYUDA</li>

            <li class="menu-item">
                <a href="{{ route('estado-solicitud') }}" class="menu-link {{ request()->routeIs('estado-solicitud') ? 'active' : '' }}">
                    <i class="fas fa-question-circle"></i>
                    <span>Estado de Solicitud</span>
                </a>
            </li>

        </ul>

        </ul>
    </aside>
@endif

<!-- MAIN CONTENT -->
<main class="main-content {{ !$showSidebar ? 'no-sidebar' : '' }}">
    <!-- Topbar -->
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
            @yield('topbar-actions')

            <div class="topbar-date">
                <i class="far fa-clock"></i>
                <span>{{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</span>
            </div>

            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i>
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </div>

    <!-- Content -->
    <div class="content-wrapper">
        <!-- Alerts -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-left: 4px solid #4ec7d2;">
                <i class="fas fa-check-circle me-2"></i>
                <strong>¡Éxito!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-left: 4px solid #ef4444;">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong>¡Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</main>

<!-- Bootstrap JS -->
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
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
</script>

@stack('scripts')
</body>
</html>
