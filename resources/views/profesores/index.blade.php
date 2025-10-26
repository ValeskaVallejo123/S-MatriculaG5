@extends('layouts.app')

@section('title', 'Profesores')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-7xl">
    
    <!-- Encabezado con Acción -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Profesores</h1>
            <p class="text-sm text-gray-600 mt-0.5">Gestión del personal docente de la institución</p>
        </div>
        <a href="{{ route('profesores.create') }}" 
           class="inline-flex items-center justify-center gap-2 bg-purple-600 text-white px-4 py-2.5 rounded-lg hover:bg-purple-700 font-medium transition text-sm shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Nuevo Profesor
        </a>
    </div>

    <!-- Tarjetas de Estadísticas -->
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
        
        <!-- Total -->
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Total</p>
                    <p class="text-3xl font-bold text-purple-600">{{ $profesores->total() }}</p>
                    <p class="text-xs text-gray-500 mt-1">Profesores</p>
                </div>
                <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Activos -->
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Activos</p>
                    <p class="text-3xl font-bold text-green-600">{{ $profesores->where('estado', 'activo')->count() }}</p>
                    <p class="text-xs text-gray-500 mt-1">En servicio</p>
                </div>
                <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- En Licencia -->
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-amber-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Licencia</p>
                    <p class="text-3xl font-bold text-amber-600">{{ $profesores->where('estado', 'licencia')->count() }}</p>
                    <p class="text-xs text-gray-500 mt-1">Temporales</p>
                </div>
                <div class="w-12 h-12 bg-amber-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Inactivos -->
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Inactivos</p>
                    <p class="text-3xl font-bold text-red-600">{{ $profesores->where('estado', 'inactivo')->count() }}</p>
                    <p class="text-xs text-gray-500 mt-1">Suspendidos</p>
                </div>
                <div class="w-12 h-12 bg-red-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Listado en Cards -->
    <div class="space-y-3">
        
        <!-- Header del Listado -->
        <div class="bg-white rounded-lg shadow-sm px-5 py-3 border border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-base font-bold text-gray-800">Listado Completo</h2>
                <span class="text-xs font-medium text-gray-600">{{ $profesores->total() }} profesores</span>
            </div>
        </div>

        <!-- Lista de Profesores en Cards -->
        @forelse($profesores as $profesor)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md hover:border-purple-300 transition-all">
                <div class="p-4">
                    <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                        
                        <!-- Información del Profesor (Izquierda) -->
                        <div class="flex items-center gap-3 flex-1">
                            <!-- Avatar -->
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm">
                                <span class="text-white font-bold text-base">
                                    {{ strtoupper(substr($profesor->nombre, 0, 1) . substr($profesor->apellido ?? '', 0, 1)) }}
                                </span>
                            </div>
                            
                            <!-- Datos -->
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base font-semibold text-gray-900 truncate">{{ $profesor->nombre_completo }}</h3>
                                <div class="flex flex-wrap items-center gap-3 mt-1">
                                    @if($profesor->email)
                                        <span class="text-xs text-gray-600 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $profesor->email }}
                                        </span>
                                    @endif
                                    @if($profesor->dni)
                                        <span class="text-xs text-gray-500">•</span>
                                        <span class="text-xs text-gray-600">DNI: {{ $profesor->dni }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Especialidad y Tipo de Contrato (Centro) -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
                            @if($profesor->especialidad)
                                <span class="flex items-center gap-1 text-xs text-gray-700 font-medium bg-gray-50 px-2.5 py-1 rounded-md border border-gray-200">
                                    <svg class="w-3.5 h-3.5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    {{ $profesor->especialidad }}
                                </span>
                            @endif
                            @if($profesor->tipo_contrato)
                                <span class="text-xs text-white font-semibold bg-blue-500 px-2.5 py-1 rounded-md">
                                    {{ ucwords(str_replace('_', ' ', $profesor->tipo_contrato)) }}
                                </span>
                            @endif
                        </div>

                        <!-- Estado -->
                        <div>
                            @if($profesor->estado === 'activo')
                                <span class="inline-block px-3 py-1 bg-green-50 text-green-700 rounded-full text-xs font-semibold border border-green-200">
                                    Activo
                                </span>
                            @elseif($profesor->estado === 'licencia')
                                <span class="inline-block px-3 py-1 bg-amber-50 text-amber-700 rounded-full text-xs font-semibold border border-amber-200">
                                    Licencia
                                </span>
                            @else
                                <span class="inline-block px-3 py-1 bg-red-50 text-red-700 rounded-full text-xs font-semibold border border-red-200">
                                    Inactivo
                                </span>
                            @endif
                        </div>

                        <!-- Acciones (Derecha) -->
                        <div class="flex items-center gap-2 lg:justify-end">
                            <a href="{{ route('profesores.show', $profesor) }}" 
                               class="px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition text-xs font-medium border border-blue-200">
                                Ver
                            </a>
                            <a href="{{ route('profesores.edit', $profesor) }}" 
                               class="px-3 py-1.5 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition text-xs font-medium border border-purple-200">
                                Editar
                            </a>
                            <button onclick="confirmDelete('{{ $profesor->id }}', '{{ $profesor->nombre_completo }}')"
                                    class="px-3 py-1.5 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition text-xs font-medium border border-red-200">
                                Eliminar
                            </button>
                            
                            <!-- Form oculto para eliminar -->
                            <form id="delete-form-{{ $profesor->id }}" 
                                  action="{{ route('profesores.destroy', $profesor) }}" 
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
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900 mb-1">No hay profesores</h3>
                    <p class="text-gray-500 text-sm mb-4">Agregue el primer profesor al sistema</p>
                    <a href="{{ route('profesores.create') }}" 
                       class="inline-flex items-center gap-2 bg-purple-600 text-white px-5 py-2.5 rounded-lg hover:bg-purple-700 font-medium transition text-sm shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Crear Profesor
                    </a>
                </div>
            </div>
        @endforelse

        <!-- Paginación -->
        @if($profesores->hasPages())
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 px-4 py-3">
                {{ $profesores->links() }}
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
                ¿Está seguro que desea eliminar al profesor <strong id="profesorNombre" class="text-gray-900"></strong>?
            </p>
            <p class="text-gray-600 text-xs mt-3">
                Se perderán todos los datos asociados a este profesor de forma permanente.
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
    document.getElementById('profesorNombre').textContent = nombre;
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