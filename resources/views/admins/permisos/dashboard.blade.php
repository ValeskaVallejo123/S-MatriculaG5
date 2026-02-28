@extends('layouts.app')

@section('title', 'Dashboard Administrador')
@section('page-title', 'Panel de Administración')

@section('content')
<div class="container">
    <h1>Dashboard</h1>

    <div class="row">
        {{-- Verificar si tiene permiso para ver estudiantes --}}
        @if(auth()->user()->tienePermiso('ver_estudiantes'))
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius:10px;border-left:4px solid #4ec7d2 !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div style="width:45px;height:45px;background:rgba(78,199,210,0.15);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-user-graduate" style="color:#4ec7d2;font-size:1.3rem;"></i>
                        </div>
                        <h5 class="fw-bold mb-0" style="color:#003b73;">Estudiantes</h5>
                    </div>
                    <p class="text-muted small mb-3">Gestionar estudiantes del sistema</p>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.estudiantes.index') }}" class="btn btn-primary btn-sm flex-fill">
                            <i class="fas fa-list me-1"></i>Ver
                        </a>
                        @if(auth()->user()->tienePermiso('crear_estudiantes'))
                        <a href="{{ route('admin.estudiantes.create') }}" class="btn btn-outline-primary btn-sm flex-fill">
                            <i class="fas fa-plus me-1"></i>Crear
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Verificar si tiene permiso para crear estudiantes --}}
        @if(auth()->user()->tienePermiso('crear_estudiantes'))
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Nuevo Estudiante</h5>
                    <p class="card-text">Registrar un nuevo estudiante</p>
                    <a href="{{ route('admin.estudiantes.create') }}" class="btn btn-success">Crear Estudiante</a>
                </div>
            </div>
        </div>
        @endif

        {{-- Verificar si tiene permiso para ver profesores --}}
        @if(auth()->user()->tienePermiso('ver_profesores'))
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius:10px;border-left:4px solid #00508f !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div style="width:45px;height:45px;background:rgba(0,80,143,0.1);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-chalkboard-teacher" style="color:#00508f;font-size:1.3rem;"></i>
                        </div>
                        <h5 class="fw-bold mb-0" style="color:#003b73;">Profesores</h5>
                    </div>
                    <p class="text-muted small mb-3">Gestionar profesores del sistema</p>
                    <a href="{{ route('admin.profesores.index') }}" class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-list me-1"></i>Ver Profesores
                    </a>
                </div>
            </div>
        </div>
        @endif

        {{-- Verificar si tiene alguno de varios permisos --}}
        @if(auth()->user()->tieneAlgunPermiso(['ver_reportes', 'generar_reportes']))
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius:10px;border-left:4px solid #4ec7d2 !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div style="width:45px;height:45px;background:rgba(78,199,210,0.15);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-chart-bar" style="color:#4ec7d2;font-size:1.3rem;"></i>
                        </div>
                        <h5 class="fw-bold mb-0" style="color:#003b73;">Reportes</h5>
                    </div>
                    <p class="text-muted small mb-3">Ver y generar reportes del sistema</p>
                    <a href="{{ route('admin.reportes.index') }}" class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-chart-line me-1"></i>Ver Reportes
                    </a>
                </div>
            </div>
        </div>
        @endif

        {{-- Verificar si tiene un rol específico --}}
        @if(auth()->user()->tieneRol('Super Administrador'))
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius:10px;border-left:4px solid #dc3545 !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div style="width:45px;height:45px;background:rgba(220,53,69,0.1);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-cogs" style="color:#dc3545;font-size:1.3rem;"></i>
                        </div>
                        <h5 class="fw-bold mb-0" style="color:#003b73;">Configuración</h5>
                    </div>
                    <p class="text-muted small mb-3">Acceso total a configuración del sistema</p>
                    <a href="{{ route('superadmin.configuracion') }}" class="btn btn-danger btn-sm w-100">
                        <i class="fas fa-cog me-1"></i>Configurar
                    </a>
                </div>
            </div>
        </div>
        @endif

    </div>

    {{-- Mostrar permisos del usuario actual (para depuración) --}}
    @if(config('app.debug'))
    <div class="card border-0 shadow-sm" style="border-radius:12px;border:1px dashed #fbbf24 !important;">
        <div class="card-header border-0 py-3 px-4" style="background:rgba(251,191,36,0.1);border-radius:12px 12px 0 0;">
            <h6 class="fw-bold mb-0" style="color:#92400e;">
                <i class="fas fa-bug me-2"></i>Información de Depuración
                <span class="badge bg-warning text-dark ms-2" style="font-size:0.7rem;">DEBUG</span>
            </h6>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <p class="mb-1"><strong style="color:#003b73;">Usuario:</strong> {{ auth()->user()->name }}</p>
                    <p class="mb-0"><strong style="color:#003b73;">Rol:</strong>
                        {{ auth()->user()->rol->nombre ?? 'Sin rol' }}
                    </p>
                </div>
                <div class="col-md-6">
                    <p class="fw-bold mb-2" style="color:#003b73;">Permisos asignados:</p>
                    @php $permisos = auth()->user()->obtenerPermisos(); @endphp
                    @if(empty($permisos))
                        <span class="text-muted small">Sin permisos asignados</span>
                    @else
                        <div class="d-flex flex-wrap gap-1">
                            @foreach($permisos as $permiso)
                                {{-- obtenerPermisos() retorna array de strings --}}
                                <span class="badge" style="background:rgba(0,80,143,0.1);color:#00508f;border:1px solid #4ec7d2;font-size:0.75rem;">
                                    {{ $permiso }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection

{{--
EJEMPLOS DE USO EN OTROS CONTEXTOS:

1. En botones de acción:
@if(auth()->user()->tienePermiso('editar_estudiantes'))
    <a href="{{ route('estudiantes.edit', $estudiante->id) }}" class="btn btn-sm btn-warning">Editar</a>
@endif

@if(auth()->user()->tienePermiso('eliminar_estudiantes'))
    <form action="{{ route('estudiantes.destroy', $estudiante->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
    </form>
@endif

2. En menús de navegación:
<ul class="nav">
    @if(auth()->user()->tienePermiso('ver_estudiantes'))
    <li><a href="{{ route('admin.estudiantes.index') }}">Estudiantes</a></li>
    @endif

    @if(auth()->user()->tienePermiso('ver_profesores'))
    <li><a href="{{ route('admin.profesores.index') }}">Profesores</a></li>
    @endif

    @if(auth()->user()->tieneRol('Super Administrador'))
    <li><a href="{{ route('superadmin.dashboard') }}">Panel de Super Admin</a></li>
    @endif
</ul>

3. En secciones completas:
@if(auth()->user()->tienePermiso('ver_reportes'))
<section class="reportes">
    <h2>Reportes Disponibles</h2>
    <!-- Contenido de reportes -->
</section>
@endif
--}}
