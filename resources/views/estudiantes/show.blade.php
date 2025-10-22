@extends('layouts.app')

@extends('layouts.app')

@section('title', 'Detalles del Estudiante')

@section('content')
<div class="max-w-5xl mx-auto py-8">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li>
                <a href="{{ route('estudiantes.index') }}" class="hover:text-green-600 transition">Estudiantes</a>
            </li>
            <li>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </li>
            <li class="text-gray-900 font-medium">{{ $estudiante->nombre_completo }}</li>
        </ol>
    </nav>

    <!-- Profile Card -->
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 mb-6">
        <!-- Header with Gradient -->
        <div class="bg-gradient-to-r from-green-600 to-emerald-700 px-8 py-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="flex items-center gap-6">
                    <!-- Avatar -->
                    <div class="flex-shrink-0 w-24 h-24 bg-white rounded-2xl flex items-center justify-center shadow-xl">
                        <span class="text-green-600 font-bold text-3xl">
                            {{ strtoupper(substr($estudiante->nombre, 0, 1) . substr($estudiante->apellido, 0, 1)) }}
                        </span>
                    </div>
                    <!-- Info -->
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2">{{ $estudiante->nombre_completo }}</h1>
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium bg-white bg-opacity-20 text-white border border-white border-opacity-30">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                {{ $estudiante->grado }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium bg-white bg-opacity-20 text-white border border-white border-opacity-30">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Sección {{ $estudiante->seccion }}
                            </span>
                            <span class="text-green-100 text-sm">ID: #{{ $estudiante->id }}</span>
                        </div>
                    </div>
                </div>
                <!-- Status Badge -->
                <div>
                    @if($estudiante->estado === 'activo')
                        <span class="inline-flex items-center px-5 py-2.5 bg-white rounded-xl text-sm font-bold text-green-700 shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Activo
                        </span>
                    @else
                        <span class="inline-flex items-center px-5 py-2.5 bg-white rounded-xl text-sm font-bold text-red-700 shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            Inactivo
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Body Content -->
        <div class="p-8">
            <!-- Información Personal -->
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Información Personal</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Nombre</p>
                        <p class="text-gray-900 font-medium text-lg">{{ $estudiante->nombre }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Apellido</p>
                        <p class="text-gray-900 font-medium text-lg">{{ $estudiante->apellido }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Número de Identidad</p>
                        <p class="text-gray-900 font-medium text-lg flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                            </svg>
                            {{ $estudiante->dni }}
                        </p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Fecha de Nacimiento</p>
                        <p class="text-gray-900 font-medium text-lg">{{ $estudiante->fecha_nacimiento->format('d/m/Y') }}</p>
                        <p class="text-sm text-green-600 font-medium mt-1">{{ $estudiante->fecha_nacimiento->age }} años</p>
                    </div>
                </div>
            </div>

            <!-- Información de Contacto -->
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Información de Contacto</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Correo Electrónico</p>
                        <p class="text-gray-900 font-medium text-lg flex items-center gap-2">
                            @if($estudiante->email)
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                {{ $estudiante->email }}
                            @else
                                <span class="text-gray-400 italic">No registrado</span>
                            @endif
                        </p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Teléfono</p>
                        <p class="text-gray-900 font-medium text-lg flex items-center gap-2">
                            @if($estudiante->telefono)
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                {{ $estudiante->telefono }}
                            @else
                                <span class="text-gray-400 italic">No registrado</span>
                            @endif
                        </p>
                    </div>
                    <div class="md:col-span-2 bg-gray-50 rounded-xl p-5 border border-gray-200">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Dirección</p>
                        <p class="text-gray-900 font-medium text-lg flex items-start gap-2">
                            @if($estudiante->direccion)
                                <svg class="w-5 h-5 text-gray-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>{{ $estudiante->direccion }}</span>
                            @else
                                <span class="text-gray-400 italic">No registrada</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Información Académica -->
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Información Académica</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl p-5 border-2 border-indigo-200">
                        <p class="text-xs font-semibold text-indigo-600 uppercase tracking-wider mb-2">Grado</p>
                        <p class="text-indigo-900 font-bold text-2xl">{{ $estudiante->grado }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-5 border-2 border-purple-200">
                        <p class="text-xs font-semibold text-purple-600 uppercase tracking-wider mb-2">Sección</p>
                        <p class="text-purple-900 font-bold text-2xl">{{ $estudiante->seccion }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-{{ $estudiante->estado === 'activo' ? 'green' : 'red' }}-50 to-{{ $estudiante->estado === 'activo' ? 'green' : 'red' }}-100 rounded-xl p-5 border-2 border-{{ $estudiante->estado === 'activo' ? 'green' : 'red' }}-200">
                        <p class="text-xs font-semibold text-{{ $estudiante->estado === 'activo' ? 'green' : 'red' }}-600 uppercase tracking-wider mb-2">Estado</p>
                        <p class="text-{{ $estudiante->estado === 'activo' ? 'green' : 'red' }}-900 font-bold text-2xl">{{ ucfirst($estudiante->estado) }}</p>
                    </div>
                </div>
            </div>

            <!-- Observaciones -->
            @if($estudiante->observaciones)
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Observaciones</h2>
                </div>
                <div class="bg-amber-50 rounded-xl p-6 border-2 border-amber-200">
                    <p class="text-gray-700 leading-relaxed">{{ $estudiante->observaciones }}</p>
                </div>
            </div>
            @endif

            <!-- Información del Sistema -->
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Información del Sistema</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Fecha de Registro</p>
                        <p class="text-gray-900 font-medium text-lg flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ $estudiante->created_at->format('d/m/Y H:i') }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">{{ $estudiante->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Última Actualización</p>
                        <p class="text-gray-900 font-medium text-lg flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            {{ $estudiante->updated_at->format('d/m/Y H:i') }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">{{ $estudiante->updated_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t-2 border-gray-100">
                <a href="{{ route('estudiantes.edit', $estudiante) }}" class="flex-1 inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-4 rounded-xl font-semibold hover:from-blue-700 hover:to-blue-800 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Editar Estudiante
                </a>
                <a href="{{ route('estudiantes.index') }}" class="flex-1 inline-flex items-center justify-center gap-2 bg-white text-gray-700 px-6 py-4 rounded-xl font-semibold border-2 border-gray-300 hover:bg-gray-50 hover:border-gray-400 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver a la Lista
                </a>
                <form action="{{ route('estudiantes.destroy', $estudiante) }}" method="POST" class="flex-1" onsubmit="return confirm('¿Está seguro de eliminar al estudiante {{ $estudiante->nombre_completo }}?\n\nEsta acción no se puede deshacer y eliminará toda la información asociada.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-red-600 to-red-700 text-white px-6 py-4 rounded-xl font-semibold hover:from-red-700 hover:to-red-800 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection