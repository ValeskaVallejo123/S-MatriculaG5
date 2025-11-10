@extends('layouts.app')

@section('title', 'Estudiantes')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-7xl">

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
                </div>
            @endif
        </div>

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
        @if($estudiantes->hasPages())
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 px-4 py-3">
                {{ $estudiantes->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal de Confirmación Personalizado -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full transform transition-all">
        <!-- Header -->
        <div class="bg-red-50 px-6 py-4 border-b border-red-100 rounded-t-xl">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Confirmar Eliminación</h3>
                    <p class="text-xs text-gray-600">Esta acción no se puede deshacer</p>
                </div>
            </div>
        </div>

        <!-- Body -->
        <div class="px-6 py-5">
            <p class="text-gray-700 text-sm leading-relaxed">
                ¿Está seguro que desea eliminar al estudiante <strong id="estudianteNombre" class="text-gray-900"></strong>?
            </p>
            <p class="text-gray-600 text-xs mt-3">
                Se perderán todos los datos asociados a este estudiante de forma permanente.
            </p>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-6 py-4 rounded-b-xl flex gap-3 justify-end">
            <button onclick="closeModal()"
                    class="px-4 py-2 bg-white text-gray-700 rounded-lg hover:bg-gray-100 transition text-sm font-medium border border-gray-300">
                Cancelar
            </button>
            <button onclick="submitDelete()"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium shadow-sm">
                Sí, Eliminar
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let currentDeleteId = null;

function confirmDelete(id, nombre) {
    currentDeleteId = id;
    document.getElementById('estudianteNombre').textContent = nombre;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    currentDeleteId = null;
}

function submitDelete() {
    if (currentDeleteId) {
        document.getElementById('delete-form-' + currentDeleteId).submit();
    }
}

// Cerrar modal al hacer clic fuera
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Cerrar con tecla ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
    }
});
</script>
@endpush
