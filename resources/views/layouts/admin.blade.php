<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Administrativo') - Escuela Gabriela Mistral</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
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

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            background: linear-gradient(180deg, #1e3a8a 0%, #1e40af 100%);
            padding: 0;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        .sidebar-header {
            padding: 25px 20px;
            background: rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 15px;
            color: white;
            text-decoration: none;
        }

        .sidebar-logo i {
            font-size: 2.5rem;
            color: #fbbf24;
        }

        .logo-text h4 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 700;
            color: white;
        }

        .logo-text p {
            margin: 0;
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.7);
        }

        /* USER INFO */
        .user-info {
            padding: 20px;
            background: rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: white;
            font-weight: 600;
        }

        .user-details h6 {
            margin: 0;
            color: white;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .user-details p {
            margin: 0;
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .user-role-badge {
            display: inline-block;
            padding: 2px 8px;
            background: #dc2626;
            color: white;
            border-radius: 12px;
            font-size: 0.65rem;
            font-weight: 600;
            margin-top: 3px;
        }

        /* MENU */
        .sidebar-menu {
            list-style: none;
            padding: 15px 10px;
        }

        .menu-section-title {
            padding: 15px 15px 8px;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .menu-item {
            margin-bottom: 3px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .menu-link i {
            font-size: 1.1rem;
            width: 25px;
            text-align: center;
        }

        .menu-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(5px);
        }

        .menu-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            font-weight: 600;
        }

        .badge-count {
            margin-left: auto;
            padding: 2px 8px;
            background: #ef4444;
            color: white;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        /* MAIN CONTENT */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* TOPBAR */
        .topbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-left h5 {
            margin: 0;
            color: #1e293b;
            font-weight: 600;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .btn-logout {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(239, 68, 68, 0.3);
        }

        /* CONTENT WRAPPER */
        .content-wrapper {
            padding: 30px;
        }

        /* RESPONSIVE */
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
                display: block;
            }
        }

        .mobile-menu-btn {
            display: none;
            background: #1e40af;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 1.2rem;
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <!-- Header -->
        <div class="sidebar-header">
            <a href="#" class="sidebar-logo">
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
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div class="user-details">
                <h6>{{ auth()->user()->name }}</h6>
                @if(auth()->user()->isSuperAdmin())
                    <span class="user-role-badge">
                        <i class="fas fa-crown"></i> SUPER ADMIN
                    </span>
                @else
                    <p>Administrador</p>
                @endif
            </div>
        </div>

        <!-- Menu -->
        <ul class="sidebar-menu">
            <!-- Dashboard -->
            <li class="menu-section-title">Principal</li>
            <li class="menu-item">
                <a href="{{ route('superadmin.administradores.index') }}" class="menu-link {{ request()->routeIs('superadmin.*') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Gestión de Usuarios -->
            <li class="menu-section-title">Gestión de Usuarios</li>
            
            @if(auth()->user()->isSuperAdmin())
            <li class="menu-item">
                <a href="{{ route('superadmin.administradores.index') }}" class="menu-link {{ request()->routeIs('superadmin.administradores.*') ? 'active' : '' }}">
                    <i class="fas fa-user-shield"></i>
                    <span>Administradores</span>
                </a>
            </li>
            @endif

            <li class="menu-item">
                <a href="#" class="menu-link">
                    <i class="fas fa-user-graduate"></i>
                    <span>Estudiantes</span>
                    <span class="badge-count">125</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="#" class="menu-link">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>Profesores</span>
                </a>
            </li>

            <!-- Gestión Académica -->
            <li class="menu-section-title">Gestión Académica</li>
            
            <li class="menu-item">
                <a href="#" class="menu-link">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Matrículas</span>
                    <span class="badge-count">15</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="#" class="menu-link">
                    <i class="fas fa-layer-group"></i>
                    <span>Grados</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="#" class="menu-link">
                    <i class="fas fa-users-class"></i>
                    <span>Secciones</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="#" class="menu-link">
                    <i class="fas fa-book"></i>
                    <span>Asignaturas</span>
                </a>
            </li>

            <!-- Finanzas -->
            <li class="menu-section-title">Finanzas</li>
            
            <li class="menu-item">
                <a href="#" class="menu-link">
                    <i class="fas fa-dollar-sign"></i>
                    <span>Pagos</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="#" class="menu-link">
                    <i class="fas fa-receipt"></i>
                    <span>Facturas</span>
                </a>
            </li>

            <!-- Reportes -->
            <li class="menu-section-title">Reportes</li>
            
            <li class="menu-item">
                <a href="#" class="menu-link">
                    <i class="fas fa-chart-bar"></i>
                    <span>Estadísticas</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="#" class="menu-link">
                    <i class="fas fa-file-alt"></i>
                    <span>Reportes</span>
                </a>
            </li>

            <!-- Configuración -->
            <li class="menu-section-title">Sistema</li>
            
            <li class="menu-item">
                <a href="#" class="menu-link">
                    <i class="fas fa-cog"></i>
                    <span>Configuración</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="#" class="menu-link">
                    <i class="fas fa-bell"></i>
                    <span>Notificaciones</span>
                    <span class="badge-count">3</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <div class="topbar-left">
                <button class="mobile-menu-btn" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h5>@yield('page-title', 'Panel de Administración')</h5>
            </div>
            <div class="topbar-right">
                <span class="text-muted small">
                    <i class="far fa-clock"></i> 
                    {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                </span>
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
            @yield('content')
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
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