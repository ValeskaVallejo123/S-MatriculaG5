@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Panel de Control')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-7xl">
    
    <!-- Encabezado con Saludo -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            Bienvenido, {{ auth()->user()->nombre ?? 'Administrador' }} 👋
        </h1>
        <p class="text-sm text-gray-600 mt-1">
            Hoy es {{ \Carbon\Carbon::now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }} | {{ now()->format('h:i A') }}
        </p>
    </div>

    <!-- Tarjetas de Estadísticas Principales -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        
        <!-- Total Estudiantes -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium mb-1">Total Estudiantes</p>
                    <p class="text-4xl font-bold">{{ $stats['total_estudiantes'] }}</p>
                    <p class="text-blue-100 text-xs mt-2">
                        <span class="font-semibold">+{{ $stats['estudiantes_hoy'] }}</span> nuevos hoy
                    </p>
                </div>
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Profesores -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium mb-1">Total Profesores</p>
                    <p class="text-4xl font-bold">{{ $stats['total_profesores'] }}</p>
                    <p class="text-purple-100 text-xs mt-2">
                        <span class="font-semibold">+{{ $stats['profesores_hoy'] }}</span> nuevos hoy
                    </p>
                </div>
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Matrículas -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium mb-1">Total Matrículas</p>
                    <p class="text-4xl font-bold">{{ $stats['total_matriculas'] }}</p>
                    <p class="text-green-100 text-xs mt-2">
                        <span class="font-semibold">+{{ $stats['matriculas_hoy'] }}</span> nuevas hoy
                    </p>
                </div>
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Padres -->
        <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-amber-100 text-sm font-medium mb-1">Padres/Tutores</p>
                    <p class="text-4xl font-bold">{{ $stats['total_padres'] }}</p>
                    <p class="text-amber-100 text-xs mt-2">Registrados</p>
                </div>
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Estado de Matrículas -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        
        <!-- Pendientes -->
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-yellow-500 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Matrículas Pendientes</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $stats['matriculas_pendientes'] }}</p>
                    <a href="{{ route('matriculas.index') }}?estado=pendiente" class="text-xs text-yellow-600 hover:text-yellow-800 font-medium mt-2 inline-block">
                        Ver todas →
                    </a>
                </div>
                <div class="w-14 h-14 bg-yellow-50 rounded-lg flex items-center justify-center">
                    <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Aprobadas -->
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Matrículas Aprobadas</p>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['matriculas_aprobadas'] }}</p>
                    <a href="{{ route('matriculas.index') }}?estado=aprobada" class="text-xs text-green-600 hover:text-green-800 font-medium mt-2 inline-block">
                        Ver todas →
                    </a>
                </div>
                <div class="w-14 h-14 bg-green-50 rounded-lg flex items-center justify-center">
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Rechazadas -->
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-red-500 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Matrículas Rechazadas</p>
                    <p class="text-3xl font-bold text-red-600">{{ $stats['matriculas_rechazadas'] }}</p>
                    <a href="{{ route('matriculas.index') }}?estado=rechazada" class="text-xs text-red-600 hover:text-red-800 font-medium mt-2 inline-block">
                        Ver todas →
                    </a>
                </div>
                <div class="w-14 h-14 bg-red-50 rounded-lg flex items-center justify-center">
                    <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid de 2 columnas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        
        <!-- Estudiantes por Grado -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-800">Estudiantes por Grado</h2>
                <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">
                    {{ $stats['total_estudiantes'] }} Total
                </span>
            </div>
            <div class="p-6">
                @if($estudiantesPorGrado->count() > 0)
                    <div class="space-y-3">
                        @foreach($estudiantesPorGrado as $grado)
                            @php
                                $porcentaje = $stats['total_estudiantes'] > 0 ? ($grado->total / $stats['total_estudiantes']) * 100 : 0;
                            @endphp
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-700">{{ $grado->grado }}</span>
                                    <span class="text-sm font-bold text-blue-600">{{ $grado->total }} estudiantes</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-blue-600 h-2.5 rounded-full transition-all" style="width: {{ $porcentaje }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <p class="text-sm text-gray-500">No hay estudiantes registrados</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Actividad Reciente -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-bold text-gray-800">Actividad Reciente</h2>
            </div>
            <div class="p-6">
                @if(count($actividad_reciente) > 0)
                    <div class="space-y-4">
                        @foreach(array_slice($actividad_reciente, 0, 5) as $actividad)
                            <div class="flex items-start gap-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="w-10 h-10 bg-{{ $actividad['color'] }}-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-{{ $actividad['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-800">{{ $actividad['mensaje'] }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $actividad['fecha']->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <p class="text-sm text-gray-500">No hay actividad reciente</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Últimas Matrículas -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-800">Últimas Matrículas</h2>
            <a href="{{ route('matriculas.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                Ver todas →
            </a>
        </div>
        <div class="p-6">
            @if($ultimasMatriculas->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 uppercase">Estudiante</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 uppercase">Padre/Tutor</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 uppercase">Grado</th>
                                <th class="text-center py-3 px-4 text-xs font-semibold text-gray-600 uppercase">Estado</th>
                                <th class="text-center py-3 px-4 text-xs font-semibold text-gray-600 uppercase">Fecha</th>
                                <th class="text-center py-3 px-4 text-xs font-semibold text-gray-600 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ultimasMatriculas as $matricula)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <span class="text-white font-bold text-sm">
                                                    {{ strtoupper(substr($matricula->estudiante->nombre ?? 'E', 0, 1)) }}{{ strtoupper(substr($matricula->estudiante->apellido ?? 'E', 0, 1)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">{{ $matricula->estudiante->nombre_completo ?? 'N/A' }}</p>
                                                <p class="text-xs text-gray-500">{{ $matricula->estudiante->dni ?? 'Sin DNI' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <p class="text-sm text-gray-700">{{ $matricula->padre->nombre_completo ?? 'N/A' }}</p>
                                    </td>
                                    <td class="py-3 px-4">
                                        <p class="text-sm text-gray-700">{{ $matricula->estudiante->grado ?? 'N/A' }}</p>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                            @if($matricula->estado == 'aprobada') bg-green-100 text-green-700
                                            @elseif($matricula->estado == 'pendiente') bg-yellow-100 text-yellow-700
                                            @else bg-red-100 text-red-700
                                            @endif">
                                            {{ ucfirst($matricula->estado) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <p class="text-sm text-gray-600">{{ $matricula->created_at->format('d/m/Y') }}</p>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <a href="{{ route('matriculas.show', $matricula) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            Ver detalles
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-sm text-gray-500">No hay matrículas registradas</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Acciones Rápidas -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-lg p-8 text-white">
        <h2 class="text-2xl font-bold mb-6">Acciones Rápidas</h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <a href="{{ route('estudiantes.create') }}" class="bg-white bg-opacity-20 hover:bg-opacity-30 backdrop-blur-sm rounded-xl p-6 text-center transition transform hover:scale-105">
                <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                <span class="text-sm font-semibold">Nuevo Estudiante</span>
            </a>

            <a href="{{ route('matriculas.create') }}" class="bg-white bg-opacity-20 hover:bg-opacity-30 backdrop-blur-sm rounded-xl p-6 text-center transition transform hover:scale-105">
                <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span class="text-sm font-semibold">Nueva Matrícula</span>
            </a>

            <a href="{{ route('profesores.create') }}" class="bg-white bg-opacity-20 hover:bg-opacity-30 backdrop-blur-sm rounded-xl p-6 text-center transition transform hover:scale-105">
                <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                <span class="text-sm font-semibold">Nuevo Profesor</span>
            </a>

            <a href="{{ route('estudiantes.buscar') }}" class="bg-white bg-opacity-20 hover:bg-opacity-30 backdrop-blur-sm rounded-xl p-6 text-center transition transform hover:scale-105">
                <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <span class="text-sm font-semibold">Buscar Estudiante</span>
            </a>
        </div>
    </div>

</div>
@endsection