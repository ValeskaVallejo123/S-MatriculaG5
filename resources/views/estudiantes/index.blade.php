@extends('layouts.app')

@section('title', 'Estudiantes')

@section('page-title', 'Gestión de Estudiantes')

@section('topbar-actions')
    <a href="{{ route('estudiantes.create') }}" class="btn-back" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); font-size: 0.9rem;">
        <i class="fas fa-plus"></i>
        Nuevo Estudiante
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 1400px;">

<<<<<<< HEAD
    <!-- Encabezado con Acción -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Estudiantes</h1>
            <p class="text-sm text-gray-600 mt-0.5">Gestión de alumnos matriculados en la institución</p>
        </div>
        <a href="{{ route('estudiantes.create') }}"
           class="inline-flex items-center justify-center gap-2 bg-green-600 text-white px-4 py-2.5 rounded-lg hover:bg-green-700 font-medium transition text-sm shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Nuevo Estudiante
        </a>
    </div>

    <!-- Tarjetas de Estadísticas -->
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">

        <!-- Total -->
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Total</p>
                    <p class="text-3xl font-bold text-green-600">{{ $estudiantes->total() }}</p>
                    <p class="text-xs text-gray-500 mt-1">Estudiantes</p>
                </div>
                <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Activos -->
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Activos</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $estudiantes->where('estado', 'activo')->count() }}</p>
                    <p class="text-xs text-gray-500 mt-1">En el sistema</p>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Inactivos -->
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-amber-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Inactivos</p>
                    <p class="text-3xl font-bold text-amber-600">{{ $estudiantes->where('estado', 'inactivo')->count() }}</p>
                    <p class="text-xs text-gray-500 mt-1">Suspendidos</p>
                </div>
                <div class="w-12 h-12 bg-amber-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Nuevos Hoy -->
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Hoy</p>
                    <p class="text-3xl font-bold text-purple-600">{{ $estudiantes->where('created_at', '>=', today())->count() }}</p>
                    <p class="text-xs text-gray-500 mt-1">Nuevos</p>
                </div>
                <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Listado en Cards -->
    <div class="space-y-3">

        <!-- Header del Listado CON BÚSQUEDA -->
        <div class="bg-white rounded-lg shadow-sm px-5 py-4 border border-gray-200">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <div>
                    <h2 class="text-base font-bold text-gray-800">Listado Completo</h2>
                    <span class="text-xs font-medium text-gray-600">{{ $estudiantes->total() }} estudiantes</span>
                </div>

                <!-- Búsqueda integrada -->
                <form action="{{ route('estudiantes.index') }}" method="GET" class="flex gap-2 w-full lg:w-auto lg:max-w-md">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input
                            type="text"
                            name="busqueda"
                            value="{{ request('busqueda') }}"
                            placeholder="Buscar por nombre, DNI o email..."
                            class="w-full pl-9 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all text-sm"
                            autocomplete="off"
                        >
                    </div>

                    <button
                        type="submit"
                        class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition flex items-center gap-2 whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Buscar
                    </button>

                    @if(request('busqueda'))
                        <a href="{{ route('estudiantes.index') }}"
                           class="px-3 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Limpiar
                        </a>
                    @endif
                </form>

            </div>

            <!-- Mensaje de resultados de búsqueda -->
            @if(request('busqueda'))
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <p class="text-sm text-gray-600">
                        Mostrando resultados para: <span class="font-semibold text-gray-900">"{{ request('busqueda') }}"</span>
                    </p>
=======
    <!-- Barra de búsqueda y resumen compacto -->
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
        <div class="card-body p-3">
            <div class="row align-items-center g-2">
                <!-- Buscador -->
                <div class="col-md-6">
                    <div class="position-relative">
                        <i class="fas fa-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.9rem;"></i>
                        <input type="text" 
                               id="searchInput" 
                               class="form-control form-control-sm ps-5" 
                               placeholder="Buscar por nombre, DNI, grado..." 
                               style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.5rem 1rem 0.5rem 2.5rem; transition: all 0.3s ease;">
                    </div>
                </div>
                
                <!-- Resumen compacto -->
                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-md-end gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-users" style="color: #00508f; font-size: 0.9rem;"></i>
                            <span class="small"><strong style="color: #00508f;">{{ $estudiantes->total() }}</strong> <span class="text-muted">Total</span></span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-check-circle" style="color: #4ec7d2; font-size: 0.9rem;"></i>
                            <span class="small"><strong style="color: #4ec7d2;">{{ $estudiantes->where('estado', 'activo')->count() }}</strong> <span class="text-muted">Activos</span></span>
                        </div>
                        <button class="btn btn-sm" style="border: 2px solid #4ec7d2; color: #4ec7d2; background: white; border-radius: 6px; padding: 0.3rem 0.8rem; font-size: 0.85rem;">
                            <i class="fas fa-download"></i>
                        </button>
                    </div>
>>>>>>> 5567870dc482cc51bd50123ee3f8d77b5b73b3b6
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla compacta de Estudiantes -->
    <div class="card border-0 shadow-sm" style="border-radius: 10px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="studentsTable">
                    <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
                        <tr>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Foto</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Nombre</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">DNI</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Grado</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Sección</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Estado</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold text-end" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($estudiantes as $estudiante)
                        <tr style="border-bottom: 1px solid #f1f5f9; transition: all 0.2s ease;" class="student-row">
                            <td class="px-3 py-2">
                                <img src="{{ asset('storage/' . $estudiante->foto) }}" 
                                     class="rounded-circle object-fit-cover" 
                                     style="width: 35px; height: 35px; border: 2px solid #4ec7d2;"
                                     alt="Foto">
                            </td>
                            <td class="px-3 py-2">
                                <div class="fw-semibold" style="color: #003b73; font-size: 0.9rem;">{{ $estudiante->nombre }} {{ $estudiante->apellido }}</div>
                                @if($estudiante->email)
                                <small class="text-muted" style="font-size: 0.75rem;">{{ $estudiante->email }}</small>
                                @endif
                            </td>
                            <td class="px-3 py-2">
                                <span class="font-monospace small" style="color: #00508f; font-size: 0.85rem;">{{ $estudiante->dni }}</span>
                            </td>
                            <td class="px-3 py-2">
                                <span class="badge" style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.3rem 0.6rem; font-weight: 600; font-size: 0.75rem;">{{ $estudiante->grado }}</span>
                            </td>
                            <td class="px-3 py-2">
                                <span class="badge" style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.3rem 0.6rem; font-weight: 600; font-size: 0.75rem;">{{ $estudiante->seccion }}</span>
                            </td>
                            <td class="px-3 py-2">
                                @if($estudiante->estado === 'activo')
                                    <span class="badge rounded-pill" style="background: rgba(78, 199, 210, 0.2); color: #00508f; padding: 0.3rem 0.7rem; font-weight: 600; border: 1px solid #4ec7d2; font-size: 0.75rem;">
                                        <i class="fas fa-circle" style="font-size: 0.4rem; color: #4ec7d2;"></i> Activo
                                    </span>
                                @else
                                    <span class="badge rounded-pill" style="background: #fee2e2; color: #991b1b; padding: 0.3rem 0.7rem; font-weight: 600; border: 1px solid #ef4444; font-size: 0.75rem;">
                                        <i class="fas fa-circle" style="font-size: 0.4rem;"></i> Inactivo
                                    </span>
                                @endif
                            </td>
                            <td class="px-3 py-2 text-end">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('estudiantes.show', $estudiante->id) }}" 
                                       class="btn btn-sm" 
                                       style="border-radius: 6px 0 0 6px; border: 1.5px solid #00508f; color: #00508f; background: white; padding: 0.3rem 0.6rem; font-size: 0.8rem;"
                                       title="Ver"
                                       onmouseover="this.style.background='#00508f'; this.style.color='white';"
                                       onmouseout="this.style.background='white'; this.style.color='#00508f';">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('estudiantes.edit', $estudiante->id) }}" 
                                       class="btn btn-sm" 
                                       style="border-radius: 0; border: 1.5px solid #4ec7d2; border-left: none; color: #4ec7d2; background: white; padding: 0.3rem 0.6rem; font-size: 0.8rem;"
                                       title="Editar"
                                       onmouseover="this.style.background='#4ec7d2'; this.style.color='white';"
                                       onmouseout="this.style.background='white'; this.style.color='#4ec7d2';">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('estudiantes.destroy', $estudiante->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('¿Está seguro de eliminar este estudiante?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm" 
                                                style="border-radius: 0 6px 6px 0; border: 1.5px solid #ef4444; border-left: none; color: #ef4444; background: white; padding: 0.3rem 0.6rem; font-size: 0.8rem;"
                                                title="Eliminar"
                                                onmouseover="this.style.background='#ef4444'; this.style.color='white';"
                                                onmouseout="this.style.background='white'; this.style.color='#ef4444';">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2" style="color: #00508f; opacity: 0.5;"></i>
                                    <h6 style="color: #003b73;">No hay estudiantes registrados</h6>
                                    <p class="small mb-3">Comienza agregando el primer estudiante</p>
                                    <a href="{{ route('estudiantes.create') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 8px; padding: 0.5rem 1.2rem;">
                                        <i class="fas fa-plus me-1"></i>Registrar Estudiante
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

<<<<<<< HEAD
        <!-- Lista de Estudiantes en Cards -->
        @forelse($estudiantes as $estudiante)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md hover:border-green-300 transition-all">
                <div class="p-4">
                    <div class="flex flex-col lg:flex-row lg:items-center gap-4">

                        <!-- Información del Estudiante (Izquierda) -->
                        <div class="flex items-center gap-3 flex-1">
                            <!-- Avatar -->
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm">
                                <span class="text-white font-bold text-base">
                                    {{ strtoupper(substr($estudiante->nombre, 0, 1) . substr($estudiante->apellido ?? '', 0, 1)) }}
                                </span>
                            </div>

                            <!-- Datos -->
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base font-semibold text-gray-900 truncate">{{ $estudiante->nombre_completo }}</h3>
                                <div class="flex flex-wrap items-center gap-3 mt-1">
                                    @if($estudiante->email)
                                        <span class="text-xs text-gray-600 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $estudiante->email }}
                                        </span>
                                    @endif
                                    @if($estudiante->identificacion)
                                        <span class="text-xs text-gray-500">•</span>
                                        <span class="text-xs text-gray-600">ID: {{ $estudiante->identificacion }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Grado y Sección (Centro) -->
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-700 font-medium">
                                {{ $estudiante->grado }}@if($estudiante->seccion) - Sec. {{ $estudiante->seccion }}@endif
                            </span>
                        </div>

                        <!-- Estado -->
                        <div>
                            @if($estudiante->estado === 'activo')
                                <span class="inline-block px-3 py-1 bg-green-50 text-green-700 rounded-full text-xs font-semibold border border-green-200">
                                    Activo
                                </span>
                            @else
                                <span class="inline-block px-3 py-1 bg-red-50 text-red-700 rounded-full text-xs font-semibold border border-red-200">
                                    Inactivo
                                </span>
                            @endif
                        </div>

                        <!-- Acciones (Derecha) -->
                        <div class="flex items-center gap-2 lg:justify-end">
                            <a href="{{ route('estudiantes.show', $estudiante) }}"
                               class="px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition text-xs font-medium border border-blue-200">
                                Ver
                            </a>
                            <a href="{{ route('estudiantes.edit', $estudiante) }}"
                               class="px-3 py-1.5 bg-amber-50 text-amber-700 rounded-lg hover:bg-amber-100 transition text-xs font-medium border border-amber-200">
                                Editar
                            </a>
                            <button onclick="confirmDelete('{{ $estudiante->id }}', '{{ $estudiante->nombre_completo }}')"
                                    class="px-3 py-1.5 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition text-xs font-medium border border-red-200">
                                Eliminar
                            </button>

                            <!-- Form oculto para eliminar -->
                            <form id="delete-form-{{ $estudiante->id }}"
                                  action="{{ route('estudiantes.destroy', $estudiante) }}"
                                  method="POST"
                                  style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12">
                <div class="text-center">

                    @if(request('busqueda'))
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-base font-semibold text-gray-900 mb-1">No se encontraron resultados</h3>
                        <p class="text-gray-500 text-sm mb-4">No hay estudiantes que coincidan con "{{ request('busqueda') }}"</p>
                        <a href="{{ route('estudiantes.index') }}"
                           class="inline-flex items-center gap-2 bg-green-600 text-white px-5 py-2.5 rounded-lg hover:bg-green-700 font-medium transition text-sm shadow-sm">
                            Ver todos los estudiantes
                        </a>
                    @else
                        

                    @endif
                </div>
            </div>
        @endforelse

        <!-- Paginación -->
=======
        <!-- Paginación compacta -->
>>>>>>> 5567870dc482cc51bd50123ee3f8d77b5b73b3b6
        @if($estudiantes->hasPages())
        <div class="card-footer bg-white border-0 py-2 px-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small" style="font-size: 0.8rem;">
                    {{ $estudiantes->firstItem() }} - {{ $estudiantes->lastItem() }} de {{ $estudiantes->total() }}
                </div>
                <div>
                    {{ $estudiantes->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>

</div>

@push('styles')
<style>
    .table > :not(caption) > * > * {
        padding: 0.6rem 0.75rem;
    }

    .btn-group .btn:hover {
        transform: translateY(-1px);
        z-index: 1;
    }

    .pagination {
        margin-bottom: 0;
    }

    .pagination .page-link {
        border-radius: 6px;
        margin: 0 2px;
        border: 1px solid #e2e8f0;
        color: #00508f;
        transition: all 0.3s ease;
        padding: 0.3rem 0.6rem;
        font-size: 0.85rem;
    }

    .pagination .page-link:hover {
        background: #bfd9ea;
        border-color: #4ec7d2;
        color: #003b73;
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
        border-color: #4ec7d2;
        color: white;
    }

    .table tbody tr:hover {
        background-color: rgba(191, 217, 234, 0.08);
    }

    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(78, 199, 210, 0.4) !important;
    }

    #searchInput:focus {
        border-color: #4ec7d2;
        box-shadow: 0 0 0 0.2rem rgba(78, 199, 210, 0.15);
        outline: none;
    }

    .no-results {
        display: none;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const table = document.getElementById('studentsTable');
    const rows = table.querySelectorAll('tbody .student-row');
    
    searchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase().trim();
        let visibleCount = 0;
        
        rows.forEach(function(row) {
            const text = row.textContent.toLowerCase();
            
            if (text.includes(searchTerm)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        // Mostrar mensaje si no hay resultados
        const emptyRow = table.querySelector('tbody tr:not(.student-row)');
        if (visibleCount === 0 && searchTerm !== '') {
            if (!document.querySelector('.no-results-row')) {
                const noResultsRow = document.createElement('tr');
                noResultsRow.className = 'no-results-row';
                noResultsRow.innerHTML = `
                    <td colspan="7" class="text-center py-4">
                        <i class="fas fa-search" style="color: #00508f; opacity: 0.5; font-size: 1.5rem;"></i>
                        <p class="text-muted mt-2 mb-0">No se encontraron resultados para "<strong>${searchTerm}</strong>"</p>
                    </td>
                `;
                table.querySelector('tbody').appendChild(noResultsRow);
            }
        } else {
            const noResultsRow = document.querySelector('.no-results-row');
            if (noResultsRow) {
                noResultsRow.remove();
            }
        }
    });
});
</script>
@endpush
@endsection