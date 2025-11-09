@extends('layouts.admin')

@section('title', 'Dashboard Super Admin')
@section('page-title', 'Panel de Control')

@push('styles')
<style>
    /* Animaciones personalizadas */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
    }

    /* Tarjetas de estadísticas mejoradas */
    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        border: 1px solid #f0f0f0;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--card-color), transparent);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }

    .stat-card.primary { --card-color: #667eea; }
    .stat-card.danger { --card-color: #ef4444; }
    .stat-card.success { --card-color: #10b981; }
    .stat-card.warning { --card-color: #f59e0b; }

    .stat-icon {
        width: 70px;
        height: 70px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        transition: all 0.3s ease;
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.1) rotate(5deg);
    }

    /* Tabla mejorada */
    .custom-table {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }

    .custom-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .custom-table thead th {
        border: none;
        padding: 18px 20px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .custom-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f0f0f0;
    }

    .custom-table tbody tr:hover {
        background: #f8f9ff;
        transform: scale(1.01);
    }

    /* Buscador y filtros */
    .search-filter-section {
        background: white;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        margin-bottom: 25px;
    }

    .search-input {
        border: 2px solid #e0e7ff;
        border-radius: 12px;
        padding: 12px 20px 12px 45px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        width: 100%;
    }

    .search-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        outline: none;
    }

    .search-icon {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #95a5a6;
        font-size: 1.1rem;
    }

    /* Badges mejorados */
    .badge-custom {
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
        letter-spacing: 0.3px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    /* Botones de acción mejorados */
    .action-btn {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    /* Actividad reciente */
    .activity-item {
        padding: 15px;
        border-left: 3px solid #667eea;
        background: #f8f9ff;
        border-radius: 0 10px 10px 0;
        margin-bottom: 12px;
        transition: all 0.3s ease;
    }

    .activity-item:hover {
        background: white;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        transform: translateX(5px);
    }

    /* Gráfico placeholder */
    .chart-container {
        background: white;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        height: 350px;
    }
</style>
@endpush

@section('content')

<!-- Mensaje de bienvenida -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-4 fade-in-up" style="animation-delay: 0.1s;">
    <i class="fas fa-check-circle me-2"></i> 
    <strong>{{ session('success') }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Estadísticas principales -->
<div class="row g-4 mb-4">
    <!-- Total Administradores -->
    <div class="col-lg-3 col-md-6 fade-in-up" style="animation-delay: 0.1s;">
        <div class="stat-card primary">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-2 fw-semibold">Total Administradores</p>
                    <h2 class="mb-0 fw-bold">{{ $administradores->count() }}</h2>
                    <small class="text-success">
                        <i class="fas fa-arrow-up"></i> +2 este mes
                    </small>
                </div>
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Super Admins -->
    <div class="col-lg-3 col-md-6 fade-in-up" style="animation-delay: 0.2s;">
        <div class="stat-card danger">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-2 fw-semibold">Super Administradores</p>
                    <h2 class="mb-0 fw-bold">{{ $administradores->where('is_super_admin', true)->count() }}</h2>
                    <small class="text-muted">
                        <i class="fas fa-crown"></i> Acceso total
                    </small>
                </div>
                <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                    <i class="fas fa-crown"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Admins Regulares -->
    <div class="col-lg-3 col-md-6 fade-in-up" style="animation-delay: 0.3s;">
        <div class="stat-card success">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-2 fw-semibold">Admins Regulares</p>
                    <h2 class="mb-0 fw-bold">{{ $administradores->where('rol', 'admin')->count() }}</h2>
                    <small class="text-muted">
                        <i class="fas fa-user-shield"></i> Permisos limitados
                    </small>
                </div>
                <div class="stat-icon bg-success bg-opacity-10 text-success">
                    <i class="fas fa-user-tie"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Usuarios Totales del Sistema -->
    <div class="col-lg-3 col-md-6 fade-in-up" style="animation-delay: 0.4s;">
        <div class="stat-card warning">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-2 fw-semibold">Usuarios del Sistema</p>
                    <h2 class="mb-0 fw-bold">{{ App\Models\User::count() }}</h2>
                    <small class="text-warning">
                        <i class="fas fa-users"></i> Todos los roles
                    </small>
                </div>
                <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                    <i class="fas fa-users-cog"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Panel principal -->
    <div class="col-lg-8">
        <!-- Buscador y filtros -->
        <div class="search-filter-section fade-in-up" style="animation-delay: 0.5s;">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="position-relative">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" 
                               class="search-input" 
                               id="searchInput"
                               placeholder="Buscar por nombre o email...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filterRole" style="border: 2px solid #e0e7ff; border-radius: 12px; padding: 12px;">
                        <option value="">Todos los roles</option>
                        <option value="super_admin">Super Admin</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('superadmin.administradores.create') }}" class="btn btn-primary w-100" style="border-radius: 12px; padding: 12px;">
                        <i class="fas fa-plus-circle"></i> Nuevo Admin
                    </a>
                </div>
            </div>
        </div>

        <!-- Tabla de administradores -->
        <div class="custom-table fade-in-up" style="animation-delay: 0.6s;">
            <table class="table mb-0" id="adminTable">
                <thead>
                    <tr>
                        <th>Administrador</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Permisos</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($administradores as $admin)
                    <tr data-role="{{ $admin->rol }}" data-name="{{ strtolower($admin->name) }}" data-email="{{ strtolower($admin->email) }}">
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                    <strong class="text-primary fs-5">{{ substr($admin->name, 0, 1) }}</strong>
                                </div>
                                <div>
                                    <strong class="d-block">{{ $admin->name }}</strong>
                                    @if($admin->is_super_admin)
                                        <span class="badge-custom bg-danger text-white">
                                            <i class="fas fa-crown"></i> SUPER ADMIN
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <i class="fas fa-envelope text-muted me-2"></i>
                            <span>{{ $admin->email }}</span>
                        </td>
                        <td class="align-middle">
                            @if($admin->is_super_admin)
                                <span class="badge-custom bg-danger text-white">
                                    <i class="fas fa-star"></i> Super Admin
                                </span>
                            @else
                                <span class="badge-custom bg-primary text-white">
                                    <i class="fas fa-user-cog"></i> Administrador
                                </span>
                            @endif
                        </td>
                        <td class="align-middle">
                            @if($admin->is_super_admin)
                                <span class="badge-custom bg-success text-white">
                                    <i class="fas fa-infinity"></i> Ilimitados
                                </span>
                            @else
                                <span class="badge-custom bg-info text-white">
                                    <i class="fas fa-key"></i> {{ count($admin->permissions ?? []) }}
                                </span>
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            @if($admin->is_protected)
                                <span class="badge-custom bg-warning text-dark">
                                    <i class="fas fa-shield-alt"></i> Protegido
                                </span>
                            @else
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('superadmin.administradores.edit', $admin) }}" 
                                       class="action-btn bg-warning text-white"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('superadmin.administradores.destroy', $admin) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('¿Eliminar a {{ $admin->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="action-btn bg-danger text-white"
                                                title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                            <p class="text-muted mb-0">No hay administradores registrados</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Panel lateral -->
    <div class="col-lg-4">
        <!-- Actividad reciente -->
        <div class="card border-0 shadow-sm mb-4 fade-in-up" style="animation-delay: 0.7s; border-radius: 15px;">
            <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                <h5 class="mb-0">
                    <i class="fas fa-history text-primary"></i> Actividad Reciente
                </h5>
            </div>
            <div class="card-body">
                <div class="activity-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <strong>Admin creado</strong>
                            <p class="mb-0 small text-muted">Se agregó un nuevo administrador</p>
                        </div>
                        <span class="badge bg-success">Hoy</span>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <strong>Permisos actualizados</strong>
                            <p class="mb-0 small text-muted">Se modificaron permisos de usuario</p>
                        </div>
                        <span class="badge bg-info">Ayer</span>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <strong>Login exitoso</strong>
                            <p class="mb-0 small text-muted">Super Admin inició sesión</p>
                        </div>
                        <span class="badge bg-secondary">2d</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Acciones rápidas -->
        <div class="card border-0 shadow-sm fade-in-up" style="animation-delay: 0.8s; border-radius: 15px;">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0">
                    <i class="fas fa-bolt text-warning"></i> Acciones Rápidas
                </h5>
            </div>
            <div class="card-body">
                <a href="{{ route('superadmin.administradores.create') }}" class="btn btn-primary w-100 mb-3" style="border-radius: 12px;">
                    <i class="fas fa-user-plus"></i> Crear Administrador
                </a>
                <a href="#" class="btn btn-outline-primary w-100 mb-3" style="border-radius: 12px;">
                    <i class="fas fa-download"></i> Exportar Lista
                </a>
                <a href="#" class="btn btn-outline-secondary w-100" style="border-radius: 12px;">
                    <i class="fas fa-cog"></i> Configuración
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Búsqueda en tiempo real
    document.getElementById('searchInput').addEventListener('keyup', function() {
        filterTable();
    });

    document.getElementById('filterRole').addEventListener('change', function() {
        filterTable();
    });

    function filterTable() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const roleFilter = document.getElementById('filterRole').value;
        const rows = document.querySelectorAll('#adminTable tbody tr');

        rows.forEach(row => {
            const name = row.dataset.name || '';
            const email = row.dataset.email || '';
            const role = row.dataset.role || '';

            const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
            const matchesRole = !roleFilter || role === roleFilter;

            if (matchesSearch && matchesRole) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Auto-hide alerts
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
</script>
@endpush