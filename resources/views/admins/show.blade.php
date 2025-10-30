@extends('layouts.app')

@section('title', 'Detalles del Administrador')

@section('content')

<div class="min-h-screen py-8 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4">
        
        <!-- Navegación simple -->
        <div class="mb-6">
            <a href="{{ route('admins.index') }}" class="inline-flex items-center text-blue-700 hover:text-blue-900 font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver a Administradores
            </a>
        </div>

        <!-- Tarjeta Principal -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
            
            <!-- Encabezado con información básica -->
            <div class="bg-blue-700 px-6 py-6">
                <div class="flex items-center gap-5">
                    <!-- Iniciales -->
                    <div class="w-20 h-20 bg-white rounded-lg flex items-center justify-center flex-shrink-0">
                        <span class="text-blue-700 font-bold text-2xl">
                            {{ strtoupper(substr($admin->nombre ?? 'A', 0, 1) . substr($admin->apellido ?? 'D', 0, 1)) }}
                        </span>
                    </div>
                    
                    <!-- Nombre y rol -->
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold text-white mb-1">
                            {{ $admin->nombre_completo }}
                        </h1>
                        <p class="text-blue-100 text-sm">{{ $admin->rol ?? 'Administrador' }}</p>
                    </div>

                    <!-- Estado -->
                    <div>
                        @if($admin->estado === 'activo')
                            <span class="inline-block px-4 py-2 bg-green-100 text-green-800 rounded-lg text-sm font-semibold">
                                Activo
                            </span>
                        @else
                            <span class="inline-block px-4 py-2 bg-red-100 text-red-800 rounded-lg text-sm font-semibold">
                                Inactivo
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Contenido -->
            <div class="p-6">
                
                <!-- Información Personal -->
                <div class="mb-8">
                    <h2 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b-2 border-blue-600">
                        Información Personal
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Nombre</p>
                            <p class="text-base font-semibold text-gray-900">{{ $admin->nombre ?? 'N/A' }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Apellido</p>
                            <p class="text-base font-semibold text-gray-900">{{ $admin->apellido ?? 'N/A' }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Identificación</p>
                            <p class="text-base font-semibold text-gray-900">{{ $admin->identificacion ?? 'N/A' }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Fecha de Nacimiento</p>
                            <p class="text-base font-semibold text-gray-900">
                                {{ $admin->fecha_nacimiento ? \Carbon\Carbon::parse($admin->fecha_nacimiento)->format('d/m/Y') : 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Información de Contacto -->
                <div class="mb-8">
                    <h2 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b-2 border-green-600">
                        Información de Contacto
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Correo Electrónico</p>
                            <p class="text-base font-semibold text-gray-900 break-all">{{ $admin->correo ?? 'N/A' }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Teléfono</p>
                            <p class="text-base font-semibold text-gray-900">{{ $admin->telefono ?? 'N/A' }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg md:col-span-2">
                            <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Dirección</p>
                            <p class="text-base font-semibold text-gray-900">{{ $admin->direccion ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Permisos (si existen) -->
                @if(isset($admin->permisos) && count($admin->permisos) > 0)
                <div class="mb-8">
                    <h2 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b-2 border-purple-600">
                        Permisos de Acceso
                    </h2>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            @foreach($admin->permisos as $permiso)
                                <div class="flex items-center gap-2 bg-white px-3 py-2 rounded border border-gray-200">
                                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                    <span class="text-sm text-gray-700">{{ ucfirst(str_replace('_', ' ', $permiso)) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Observaciones (si existen) -->
                @if($admin->observaciones)
                <div class="mb-8">
                    <h2 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b-2 border-yellow-600">
                        Observaciones
                    </h2>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700 leading-relaxed">{{ $admin->observaciones }}</p>
                    </div>
                </div>
                @endif

                <!-- Información del Sistema -->
                <div class="mb-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b-2 border-gray-400">
                        Datos del Sistema
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Fecha de Registro</p>
                            <p class="text-base font-semibold text-gray-900">
                                {{ $admin->created_at ? $admin->created_at->format('d/m/Y') : 'No disponible' }}
                            </p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Última Actualización</p>
                            <p class="text-base font-semibold text-gray-900">
                                {{ $admin->updated_at ? $admin->updated_at->format('d/m/Y') : 'No disponible' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="pt-6 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('admins.edit', $admin) }}" 
                           class="flex-1 bg-blue-700 text-white py-3 px-4 rounded-lg font-semibold hover:bg-blue-800 transition text-center">
                            Editar
                        </a>
                        <a href="{{ route('admins.index') }}" 
                           class="flex-1 bg-gray-200 text-gray-800 py-3 px-4 rounded-lg font-semibold hover:bg-gray-300 transition text-center">
                            Volver
                        </a>
                        <button type="button"
                                onclick="event.preventDefault(); confirmDelete();"
                                class="flex-1 bg-red-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-red-700 transition">
                            Eliminar
                        </button>
                        
                        <!-- Form oculto para eliminar -->
                        <form id="delete-form" action="{{ route('admins.destroy', $admin) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
                ¿Está seguro que desea eliminar al administrador <strong class="text-gray-900">{{ $admin->nombre_completo }}</strong>?
            </p>
            <p class="text-gray-600 text-xs mt-3">
                Se perderán todos los datos asociados a este administrador de forma permanente.
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

<script>
function confirmDelete() {
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

function submitDelete() {
    document.getElementById('delete-form').submit();
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

@endsection