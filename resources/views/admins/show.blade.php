@extends('layouts.app')

@section('title', 'Detalles del Administrador')

@section('content')

<div class="min-h-screen py-12">
    <div class="max-w-5xl mx-auto">
        <!-- Breadcrumb -->
        <div class="mb-6">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admins.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Administradores
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Detalles</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
            <!-- Header con avatar y datos principales -->
            <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 px-8 py-8">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                    <!-- Avatar -->
                    <div class="flex-shrink-0">
                        <div class="w-24 h-24 bg-white bg-opacity-20 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-xl border-4 border-white border-opacity-30">
                            <span class="text-white font-bold text-3xl">
                                {{ strtoupper(substr($admin->nombre ?? 'A', 0, 1) . substr($admin->apellido ?? 'D', 0, 1)) }}
                            </span>
                        </div>
                    </div>

                    <!-- Info Principal -->
                    <div class="flex-1 text-center md:text-left">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div>
                                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">
                                    {{ $admin->nombre_completo }}
                                </h1>
                                <div class="flex flex-wrap items-center justify-center md:justify-start gap-3">
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium bg-white bg-opacity-20 text-white backdrop-blur-sm border border-white border-opacity-30">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                        {{ $admin->rol ?? 'Administrador' }}
                                    </span>
                                    <span class="text-blue-100 text-sm">ID: #{{ $admin->id }}</span>
                                </div>
                            </div>

                            <!-- Estado Badge -->
                            <div>
                                @if($admin->estado === 'activo')
                                    <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold bg-green-400 text-green-900 shadow-lg">
                                        <svg class="w-5 h-5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Activo
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold bg-red-400 text-red-900 shadow-lg">
                                        <svg class="w-5 h-5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        Inactivo
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="p-8">
                <div class="space-y-8">
                    <!-- Información Personal -->
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">Información Personal</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gradient-to-br from-gray-50 to-gray-100 p-6 rounded-2xl border border-gray-200">
                            <div class="space-y-1">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Nombre</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $admin->nombre ?? 'N/A' }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Apellido</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $admin->apellido ?? 'N/A' }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Número de Identidad</p>
                                <p class="text-lg font-semibold text-gray-900 font-mono">{{ $admin->dni ?? 'N/A' }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Fecha de Nacimiento</p>
                                @if($admin->fecha_nacimiento)
                                    <p class="text-lg font-semibold text-gray-900">{{ $admin->fecha_nacimiento->format('d/m/Y') }}</p>
                                    <p class="text-xs text-blue-600 font-medium">{{ $admin->fecha_nacimiento->age }} años</p>
                                @else
                                    <p class="text-lg font-semibold text-gray-500">No registrada</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Información de Contacto -->
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-green-100 to-green-200 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">Información de Contacto</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gradient-to-br from-gray-50 to-gray-100 p-6 rounded-2xl border border-gray-200">
                            <div class="space-y-1">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</p>
                                <p class="text-lg font-semibold text-gray-900 break-all">{{ $admin->email ?? 'No registrado' }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Teléfono</p>
                                <p class="text-lg font-semibold text-gray-900 font-mono">{{ $admin->telefono ?? 'No registrado' }}</p>
                            </div>
                            <div class="md:col-span-2 space-y-1">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Dirección</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $admin->direccion ?? 'No registrada' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Información Administrativa -->
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">Información Administrativa</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gradient-to-br from-gray-50 to-gray-100 p-6 rounded-2xl border border-gray-200">
                            <div class="space-y-1">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Rol</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $admin->rol ?? 'Administrador' }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Departamento</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $admin->departamento ?? 'No especificado' }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Nivel de Acceso</p>
                                <div class="flex items-center gap-2">
                                    @if(isset($admin->nivel_acceso))
                                        @if($admin->nivel_acceso === 'super_admin')
                                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-semibold bg-red-100 text-red-800">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                Super Admin
                                            </span>
                                        @elseif($admin->nivel_acceso === 'admin')
                                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-semibold bg-blue-100 text-blue-800">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                                </svg>
                                                Administrador
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-semibold bg-gray-100 text-gray-800">
                                                {{ ucfirst(str_replace('_', ' ', $admin->nivel_acceso)) }}
                                            </span>
                                        @endif
                                    @else
                                        <p class="text-lg font-semibold text-gray-500">No especificado</p>
                                    @endif
                                </div>
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Fecha de Ingreso</p>
                                @if($admin->fecha_ingreso)
                                    <p class="text-lg font-semibold text-gray-900">{{ $admin->fecha_ingreso->format('d/m/Y') }}</p>
                                    <p class="text-xs text-blue-600 font-medium">{{ $admin->fecha_ingreso->diffForHumans() }}</p>
                                @else
                                    <p class="text-lg font-semibold text-gray-500">No registrada</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Permisos y Accesos -->
                    @if(isset($admin->permisos) && !empty($admin->permisos))
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-100 to-purple-200 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">Permisos y Accesos</h2>
                        </div>
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-6 rounded-2xl border border-gray-200">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                @foreach($admin->permisos as $permiso)
                                    <div class="flex items-center gap-2 bg-white px-3 py-2 rounded-lg shadow-sm">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-700">{{ ucfirst(str_replace('_', ' ', $permiso)) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Observaciones -->
                    @if($admin->observaciones)
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-amber-100 to-amber-200 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">Observaciones</h2>
                        </div>
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-6 rounded-2xl border border-gray-200">
                            <p class="text-gray-700 leading-relaxed">{{ $admin->observaciones }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Información del Sistema -->
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-gray-200 to-gray-300 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">Información del Sistema</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gradient-to-br from-gray-50 to-gray-100 p-6 rounded-2xl border border-gray-200">
                            <div class="space-y-1">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Fecha de Registro</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $admin->created_at ? $admin->created_at->format('d/m/Y H:i') : 'No disponible' }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Última Actualización</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $admin->updated_at ? $admin->updated_at->format('d/m/Y H:i') : 'No disponible' }}</p>
                            </div>
                            @if(isset($admin->ultimo_acceso))
                            <div class="space-y-1">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Último Acceso</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $admin->ultimo_acceso->format('d/m/Y H:i') }}</p>
                                <p class="text-xs text-blue-600 font-medium">{{ $admin->ultimo_acceso->diffForHumans() }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="mt-10 pt-8 border-t-2 border-gray-200">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a 
                            href="{{ route('admins.edit', $admin) }}" 
                            class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white py-4 px-6 rounded-xl font-semibold hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:ring-blue-300 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-center flex items-center justify-center"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Editar Administrador
                        </a>
                        <a 
                            href="{{ route('admins.index') }}" 
                            class="flex-1 bg-gray-100 text-gray-700 py-4 px-6 rounded-xl font-semibold hover:bg-gray-200 focus:ring-4 focus:ring-gray-300 transition-all text-center flex items-center justify-center"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Volver a la Lista
                        </a>
                        <form action="{{ route('admins.destroy', $admin) }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button 
                                type="submit" 
                                onclick="return confirm('¿Estás seguro de eliminar a {{ $admin->nombre_completo }}?')"
                                class="w-full bg-gradient-to-r from-red-600 to-red-700 text-white py-4 px-6 rounded-xl font-semibold hover:from-red-700 hover:to-red-800 focus:ring-4 focus:ring-red-300 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection