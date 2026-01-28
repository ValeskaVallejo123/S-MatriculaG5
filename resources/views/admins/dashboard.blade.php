{{-- Ejemplo de vista dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
< class="container">
    <h1>Dashboard</h1>

    <div class="row">
        {{-- Verificar si tiene permiso para ver estudiantes --}}
        @if(auth()->user()->tienePermiso('ver_estudiantes'))
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Estudiantes</h5>
                    <p class="card-text">Gestionar estudiantes del sistema</p>
                    <a href="{{ route('admin.estudiantes.index') }}" class="btn btn-primary">Ver Estudiantes</a>
                </div>
            </div>
        </div>
        @endif

        {{-- Verificar si tiene permiso para crear estudiantes --}}
        @if(auth()->user()->tienePermiso('crear_estudiantes'))
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Estudiante</h5>
                    <p class="card-text">Registrar un nuevo estudiante</p>
                    <a href="{{ route('admin.estudiantes.create') }}" class="btn btn-success">Crear Estudiante</a>
                </div>
            </div>
        </div>
        @endif

        {{-- Verificar si tiene permiso para ver profesores --}}
        @if(auth()->user()->tienePermiso('ver_profesores'))
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Profesores</h5>
                    <p class="card-text">Gestionar profesores del sistema</p>
                    <a href="{{ route('admin.profesores.index') }}" class="btn btn-primary">Ver Profesores</a>
                </div>
            </div>
        </div>
        @endif

        {{-- Verificar si tiene alguno de varios permisos --}}
        @if(auth()->user()->tieneAlgunPermiso(['ver_reportes', 'generar_reportes']))
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Reportes</h5>
                    <p class="card-text">Ver y generar reportes</p>
                    <a href="{{ route('admin.reportes.index') }}" class="btn btn-info">Ver Reportes</a>
                </div>
            </div>
        </div>
        @endif

        {{-- Verificar si tiene un rol específico --}}
        @if(auth()->user()->tieneRol('Super Administrador'))
        <div class="col-md-4">
            <div class="card border-danger">
                <div class="card-body">
                    <h5 class="card-title text-danger">Configuración del Sistema</h5>
                    <p class="card-text">Acceso total a configuración</p>
                    <a href="{{ route('superadmin.configuracion') }}" class="btn btn-danger">Configurar</a>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Mostrar permisos del usuario actual (para depuración) --}}
    @if(config('app.debug'))
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Información de Depuración
                </div>
                <div class="card-body">
                    <p><strong>Usuario:</strong> {{ auth()->user()->name }}</p>
                    <p><strong>Rol:</strong> {{ auth()->user()->rol ? auth()->user()->rol->nombre : 'Sin rol' }}</p>
                    <p><strong>Permisos:</strong></p>
                    <ul>
                        @foreach(auth()->user()->obtenerPermisos() as $permiso)
                        <li>{{ $permiso->nombre }} - {{ $permiso->descripcion }}</li>
                        @endforeach
                    </ul>
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
