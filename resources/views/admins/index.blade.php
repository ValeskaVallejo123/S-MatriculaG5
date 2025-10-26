@extends('layouts.app')

@section('title', 'Administradores')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-7xl">
    
    <!-- Encabezado con Acción -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Administradores</h1>
            <p class="text-sm text-gray-600 mt-0.5">Gestión de usuarios administrativos del sistema</p>
        </div>
        <a href="{{ route('admins.create') }}" 
           class="inline-flex items-center justify-center gap-2 bg-blue-600 text-white px-4 py-2.5 rounded-lg hover:bg-blue-700 font-medium transition text-sm shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Nuevo Administrador
        </a>
    </div>

    <!-- Tarjetas de Estadísticas -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        
        <!-- Total -->
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Total</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $admins->total() }}</p>
                    <p class="text-xs text-gray-500 mt-1">Registrados</p>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Activos -->
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Activos</p>
                    <p class="text-3xl font-bold text-green-600">{{ $admins->total() }}</p>
                    <p class="text-xs text-gray-500 mt-1">En el sistema</p>
                </div>
                <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Nuevos Hoy -->
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-amber-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Hoy</p>
                    <p class="text-3xl font-bold text-amber-600">{{ $admins->where('created_at', '>=', today())->count() }}</p>
                    <p class="text-xs text-gray-500 mt-1">Nuevos</p>
                </div>
                <div class="w-12 h-12 bg-amber-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
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
                <span class="text-xs font-medium text-gray-600">{{ $admins->total() }} administradores</span>
            </div>
        </div>

        <!-- Lista de Administradores en Cards -->
        @forelse($admins as $admin)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md hover:border-blue-300 transition-all">
                <div class="p-4">
                    <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                        
                        <!-- Información del Admin (Izquierda) -->
                        <div class="flex items-center gap-3 flex-1">
                            <!-- Avatar -->
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm">
                                <span class="text-white font-bold text-base">
                                    {{ strtoupper(substr($admin->nombre, 0, 2)) }}
                                </span>
                            </div>
                            
                            <!-- Datos -->
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base font-semibold text-gray-900 truncate">{{ $admin->nombre }}</h3>
                                <div class="flex flex-wrap items-center gap-3 mt-1">
                                    <span class="text-xs text-gray-600 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $admin->email }}
                                    </span>
                                    <span class="text-xs text-gray-500">•</span>
                                    <span class="text-xs text-gray-600 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $admin->created_at->format('d/m/Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Permisos (Centro) -->
                        <div class="flex-1">
                            <div class="flex flex-wrap gap-1.5">
                                @forelse($admin->permisos ?? [] as $permiso)
                                    <span class="inline-block px-2.5 py-1 bg-blue-50 text-blue-700 rounded-md text-xs font-medium">
                                        {{ $permiso }}
                                    </span>
                                @empty
                                    <span class="text-xs text-gray-400 italic">Sin permisos asignados</span>
                                @endforelse
                            </div>
                        </div>

                        <!-- Acciones (Derecha) -->
                        <div class="flex items-center gap-2 lg:justify-end">
                            <a href="{{ route('admins.show', $admin) }}" 
                               class="px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition text-xs font-medium border border-blue-200">
                                Ver
                            </a>
                            <a href="{{ route('admins.edit', $admin) }}" 
                               class="px-3 py-1.5 bg-amber-50 text-amber-700 rounded-lg hover:bg-amber-100 transition text-xs font-medium border border-amber-200">
                                Editar
                            </a>
                            <button onclick="confirmDelete('{{ $admin->id }}', '{{ $admin->nombre }}')"
                                    class="px-3 py-1.5 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition text-xs font-medium border border-red-200">
                                Eliminar
                            </button>
                            
                            <!-- Form oculto para eliminar -->
                            <form id="delete-form-{{ $admin->id }}" 
                                  action="{{ route('admins.destroy', $admin) }}" 
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900 mb-1">No hay administradores</h3>
                    <p class="text-gray-500 text-sm mb-4">Agregue el primer administrador al sistema</p>
                    <a href="{{ route('admins.create') }}" 
                       class="inline-flex items-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-lg hover:bg-blue-700 font-medium transition text-sm shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Crear Administrador
                    </a>
                </div>
            </div>
        @endforelse

        <!-- Paginación -->
        @if($admins->hasPages())
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 px-4 py-3">
                {{ $admins->links() }}
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
                ¿Está seguro que desea eliminar al administrador <strong id="adminName" class="text-gray-900"></strong>?
            </p>
            <p class="text-gray-600 text-xs mt-3">
                Se perderán todos los datos asociados a este usuario de forma permanente.
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

function confirmDelete(id, name) {
    currentDeleteId = id;
    document.getElementById('adminName').textContent = name;
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