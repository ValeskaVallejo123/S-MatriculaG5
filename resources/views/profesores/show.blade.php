@extends('layouts.app')

@section('title', 'Detalles del Profesor')

@section('content')
<div class="min-h-screen py-12">
    <div class="max-w-5xl mx-auto">
        <!-- Breadcrumb -->
        <div class="mb-6">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('profesores.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-purple-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Profesores
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
            <div class="bg-gradient-to-r from-purple-600 via-purple-700 to-indigo-700 px-8 py-8">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                    <!-- Avatar -->
                    <div class="flex-shrink-0">
                        <div class="w-24 h-24 bg-white bg-opacity-20 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-xl border-4 border-white border-opacity-30">
                            <span class="text-white font-bold text-3xl">
                                {{ strtoupper(substr($profesor->nombre ?? 'P', 0, 1) . substr($profesor->apellido ?? 'R', 0, 1)) }}
                            </span>
                        </div>
                    </div>

                    <!-- Info Principal -->
                    <div class="flex-1 text-center md:text-left">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div>
                                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">
                                    {{ $profesor->nombre_completo }}
                                </h1>
                                <div class="flex flex-wrap items-center justify-center md:justify-start gap-3">
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium bg-white bg-opacity-20 text-white backdrop-blur-sm border border-white border-opacity-30">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                        </svg>
                                        {{ $profesor->especialidad ?? 'Sin especialidad' }}
                                    </span>
                                    <span class="text-purple-100 text-sm">ID: #{{ $profesor->id }}</span>
                                </div>
                            </div>

                            <!-- Estado Badge -->
                            <div>
                                @if($profesor->estado === 'activo')
                                    <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold bg-green-400 text-green-900 shadow-lg">
                                        <svg class="w-5 h-5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Activo
                                    </span>
                                @elseif($profesor->estado === 'licencia')
                                    <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold bg-amber-400 text-amber-900 shadow-lg">
                                        <svg class="w-5 h-5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                        </svg>
                                        Licencia
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
                                <p class="text-lg font-semibold text-gray-900">{{ $profesor->nombre ?? 'N/A' }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Apellido</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $profesor->apellido ?? 'N/A' }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Número de Identidad</p>
                                <p class="text-lg font-semibold text-gray-900 font-mono">{{ $profesor->dni ?? 'N/A' }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Fecha de Nacimiento</p>
                                @if($profesor->fecha_nacimiento)
                                    <p class="text-lg font-semibold text-gray-900">{{ $profesor->fecha_nacimiento->format('d/m/Y') }}</p>
                                    <p class="text-sm text-purple-600 font-medium">{{ $profesor->fecha_nacimiento->age }} años de edad</p>
                                @else
                                    <p class="text-lg text-gray-400 italic">No registrada</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Información de Contacto -->
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-100 to-indigo-200 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">Información de Contacto</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gradient-to-br from-gray-50 to-gray-100 p-6 rounded-2xl border border-gray-200">
                            <div class="space-y-1">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Correo Electrónico</p>
                                @if($profesor->email)
                                    <p class="text-lg font-semibold text-gray-900">{{ $profesor->email }}</p>
                                @else
                                    <p class="text-lg text-gray-400 italic">No registrado</p>
                                @endif
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Teléfono</p>
                                @if($profesor->telefono)
                                    <p class="text-lg font-semibold text-gray-900 font-mono">{{ $profesor->telefono }}</p>
                                @else
                                    <p class="text-lg text-gray-400 italic">No registrado</p>
                                @endif
                            </div>
                            <div class="md:col-span-2 space-y-1">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Dirección de Residencia</p>
                                @if($profesor->direccion)
                                    <p class="text-lg font-semibold text-gray-900">{{ $profesor->direccion }}</p>
                                @else
                                    <p class="text-lg text-gray-400 italic">No registrada</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Información Profesional -->
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-100 to-purple-200 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">Información Profesional</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gradient-to-br from-gray-50 to-gray-100 p-6 rounded-2xl border border-gray-200">
                            <div class="space-y-1">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Especialidad</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $profesor->especialidad ?? 'No especificada' }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Tipo de Contrato</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $profesor->tipo_contrato ? ucwords(str_replace('_', ' ', $profesor->tipo_contrato)) : 'No especificado' }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Salario Mensual</p>
                                @if($profesor->salario)
                                    <p class="text-lg font-semibold text-green-600">Lps {{ number_format($profesor->salario, 2) }}</p>
                                @else
                                    <p class="text-lg text-gray-400 italic">No especificado</p>
                                @endif
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Fecha de Ingreso</p>
                                @if($profesor->fecha_ingreso)
                                    <p class="text-lg font-semibold text-gray-900">{{ $profesor->fecha_ingreso->format('d/m/Y') }}</p>
                                    <p class="text-sm text-purple-600 font-medium">{{ $profesor->fecha_ingreso->diffForHumans() }}</p>
                                @else
                                    <p class="text-lg text-gray-400 italic">No registrada</p>
                                @endif
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Estado Laboral</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $profesor->estado ? ucfirst($profesor->estado) : 'No especificado' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Observaciones -->
                    @if($profesor->observaciones)
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-amber-100 to-amber-200 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">Observaciones</h2>
                        </div>
                        <div class="bg-gradient-to-br from-amber-50 to-amber-100 p-6 rounded-2xl border-2 border-amber-200">
                            <p class="text-gray-800 leading-relaxed">{{ $profesor->observaciones }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Información del Sistema -->
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">Información del Sistema</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gradient-to-br from-gray-50 to-gray-100 p-6 rounded-2xl border border-gray-200">
                            <div class="space-y-1">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Fecha de Registro</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $profesor->created_at ? $profesor->created_at->format('d/m/Y H:i') : 'No disponible' }}</p>
                                @if($profesor->created_at)
                                    <p class="text-sm text-gray-500">{{ $profesor->created_at->diffForHumans() }}</p>
                                @endif
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Última Actualización</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $profesor->updated_at ? $profesor->updated_at->format('d/m/Y H:i') : 'No disponible' }}</p>
                                @if($profesor->updated_at)
                                    <p class="text-sm text-gray-500">{{ $profesor->updated_at->diffForHumans() }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-10 pt-8 border-t-2 border-gray-100">
                    <a href="{{ route('profesores.edit', $profesor) }}" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white py-4 rounded-xl font-semibold hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Editar
                    </a>
                    <a href="{{ route('profesores.index') }}" class="inline-flex items-center justify-center gap-2 bg-white text-gray-700 py-4 rounded-xl font-semibold border-2 border-gray-300 hover:bg-gray-50 hover:border-gray-400 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver
                    </a>
                    <form action="{{ route('profesores.destroy', $profesor) }}" method="POST" onsubmit="return confirm('¿Está seguro de eliminar al profesor {{ $profesor->nombre_completo }}?\n\nEsta acción no se puede deshacer y se eliminará toda su información laboral.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-red-600 to-red-700 text-white py-4 rounded-xl font-semibold hover:from-red-700 hover:to-red-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Nota Informativa -->
        <div class="mt-6 bg-purple-50 border border-purple-200 rounded-xl p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-purple-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div class="text-sm text-purple-800">
                    <p class="font-semibold mb-1">Información Completa del Profesor</p>
                    <p>Todos los datos mostrados corresponden al registro actual del profesor en el sistema. Para realizar cambios, utilice el botón "Editar".</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection