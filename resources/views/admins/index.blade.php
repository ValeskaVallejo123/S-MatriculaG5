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
        
        <!-- Header del Listado CON BÚSQUEDA -->
        <div class="bg-white rounded-lg shadow-sm px-5 py-4 border border-gray-200">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <div>
                    <h2 class="text-base font-bold text-gray-800">Listado Completo</h2>
                    <span class="text-xs font-medium text-gray-600">{{ $admins->total() }} administradores</span>
                </div>
                
                <!-- Búsqueda integrada -->
                <form action="{{ route('admins.index') }}" method="GET" class="flex gap-2 w-full lg:w-auto lg:max-w-md">
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
                            placeholder="Buscar por nombre o email..."
                            class="w-full pl-9 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm"
                            autocomplete="off"
                        >
                    </div>
                    
                    <button 
                        type="submit"
                        class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition flex items-center gap-2 whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Buscar
                    </button>

                    @if(request('busqueda'))
                        <a href="{{ route('admins.index') }}" 
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
                                <h3 class="text-base font-semibold text-gray-900 truncate">{{ $admin->nombre }} {{ $admin->apellido }}</h3>
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
                            <button onclick="confirmDelete('{{ $admin->id }}', '{{ $admin->nombre }} {{ $admin->apellido }}')"
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
                    @if(request('busqueda'))
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-base font-semibold text-gray-900 mb-1">No se encontraron resultados</h3>
                        <p class="text-gray-500 text-sm mb-4">No hay administradores que coincidan con "{{ request('busqueda') }}"</p>
                        <a href="{{ route('admins.index') }}" 
                           class="inline-flex items-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-lg hover:bg-blue-700 font-medium transition text-sm shadow-sm">
                            Ver todos los administradores
                        </a>
                    @else
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
                    @endif
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

<!-- Modal de Credenciales (después de crear admin) -->
@if(session('credentials'))
<div id="credentialsModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-lg w-full transform transition-all max-h-[90vh] flex flex-col">
        <!-- Header (fijo) -->
        <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-5 rounded-t-xl flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-14 h-14 bg-white bg-opacity-10 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">¡Administrador Creado!</h3>
                    <p class="text-sm text-gray-200">Guarde esta información de forma segura</p>
                </div>
            </div>
        </div>
        
        <!-- Body (con scroll) -->
        <div class="px-6 py-6 overflow-y-auto flex-1">
            <!-- Alerta de advertencia -->
            <div class="bg-gray-50 border-l-4 border-gray-400 p-4 mb-5 rounded-r-lg">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-gray-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 mb-1">⚠️ Información Confidencial</h4>
                        <p class="text-xs text-gray-700 leading-relaxed">
                            Esta es la <strong>única vez</strong> que verá la contraseña. Guárdela en un lugar seguro.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Datos del administrador -->
            <div class="space-y-4">
                <!-- Nombre -->
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-300">
                    <label class="text-xs font-semibold text-gray-600 uppercase mb-2 block">👤 Administrador</label>
                    <p class="text-base font-bold text-gray-900">{{ session('credentials')['nombre'] }}</p>
                </div>

                <!-- Email -->
                <div class="bg-white rounded-lg p-4 border-2 border-gray-300">
                    <label class="text-xs font-semibold text-gray-700 uppercase mb-2 block flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Correo Electrónico
                    </label>
                    <div class="flex items-center justify-between gap-3 flex-wrap">
                        <p class="text-base font-mono font-semibold text-gray-900 break-all flex-1" id="emailText">{{ session('credentials')['email'] }}</p>
                        <button onclick="copyText('emailText')" 
                                class="px-3 py-1.5 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition text-xs font-medium whitespace-nowrap flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            Copiar
                        </button>
                    </div>
                    <span id="copied-email" class="text-xs text-green-600 font-medium mt-2 hidden block">✓ Copiado</span>
                </div>

                <!-- Contraseña -->
                <div class="bg-white rounded-lg p-4 border-2 border-gray-400">
                    <label class="text-xs font-semibold text-gray-800 uppercase mb-2 block flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Contraseña
                    </label>
                    <div class="flex items-center justify-between gap-3 flex-wrap">
                        <p class="text-base font-mono font-bold text-gray-900 break-all tracking-wide flex-1" id="passwordText">{{ session('credentials')['password'] }}</p>
                        <button onclick="copyText('passwordText')" 
                                class="px-3 py-1.5 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition text-xs font-medium whitespace-nowrap flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            Copiar
                        </button>
                    </div>
                    <span id="copied-password" class="text-xs text-green-600 font-medium mt-2 hidden block">✓ Copiado</span>
                </div>
            </div>

            <!-- Nota adicional -->
            <div class="mt-5 bg-gray-100 rounded-lg p-4 border border-gray-300">
                <p class="text-xs text-gray-700 leading-relaxed">
                    📝 <strong>Recomendación:</strong> Envíe estas credenciales al administrador por un canal seguro o compártalas en persona.
                </p>
            </div>
        </div>
        
        <!-- Footer (fijo) -->
        <div class="bg-gray-50 px-6 py-4 rounded-b-xl flex justify-end flex-shrink-0 border-t border-gray-300">
            <button onclick="closeCredentialsModal()" 
                    class="px-6 py-2.5 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition text-sm font-semibold shadow-sm">
                He guardado la información
            </button>
        </div>
    </div>
</div>
@endif

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
// ============ MODAL DE ELIMINACIÓN ============
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

// ============ MODAL DE CREDENCIALES ============
function closeCredentialsModal() {
    const modal = document.getElementById('credentialsModal');
    if (modal) {
        modal.classList.add('hidden');
    }
}

// Función mejorada para copiar texto desde un elemento
function copyText(elementId) {
    const element = document.getElementById(elementId);
    const text = element.textContent;
    
    navigator.clipboard.writeText(text).then(function() {
        // Determinar qué mensaje mostrar
        const type = elementId === 'emailText' ? 'email' : 'password';
        const copiedMsg = document.getElementById('copied-' + type);
        
        copiedMsg.classList.remove('hidden');
        
        // Ocultar después de 2 segundos
        setTimeout(function() {
            copiedMsg.classList.add('hidden');
        }, 2000);
    }).catch(function(err) {
        alert('Error al copiar: ' + err);
    });
}

// Cerrar modales con tecla ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
        closeCredentialsModal();
    }
});
</script>
@endpush