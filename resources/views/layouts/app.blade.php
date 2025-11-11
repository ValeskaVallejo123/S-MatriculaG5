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
    {{-- (Se mantiene igual tu bloque de estadísticas) --}}

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
    </div>

    {{-- Continúa el resto del código (tabla, cards, paginación, estilos y scripts) igual --}}
    
</div>

@endsection
