@extends('layouts.app')

@section('title', 'Observaciones Conductuales')

@section('content')
    <div class="max-w-7xl mx-auto">

        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        Observaciones Conductuales
                    </h1>
                    <p class="text-gray-600 mt-2">Registro y seguimiento de observaciones de los estudiantes</p>
                </div>
                <a href="{{ route('observaciones.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-xl hover:from-blue-700 hover:to-blue-800 font-semibold shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Nueva Observación
                </a>
            </div>
        </div>

        <!-- Alerts -->
        @if(session('success'))
            <div class="mb-4 px-6 py-4 bg-green-100 text-green-800 rounded-lg border border-green-200 shadow">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filtros -->
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 mb-8 p-6">
            <form method="GET" action="{{ route('observaciones.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Filtro Nombre -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Estudiante</label>
                    <input type="text" name="nombre" value="{{ $filtros['nombre'] ?? '' }}"
                           placeholder="Buscar por nombre"
                           class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Filtro Tipo -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Observación</label>
                    <select name="tipo" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Todos</option>
                        <option value="positivo" @selected(($filtros['tipo'] ?? '') === 'positivo')>Positivo</option>
                        <option value="negativo" @selected(($filtros['tipo'] ?? '') === 'negativo')>Negativo</option>
                    </select>
                </div>

                <!-- Filtro Fecha Inicio -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha Inicio</label>
                    <input type="date" name="fecha_inicio" value="{{ $filtros['fecha_inicio'] ?? '' }}"
                           class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Filtro Fecha Fin -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha Fin</label>
                    <input type="date" name="fecha_fin" value="{{ $filtros['fecha_fin'] ?? '' }}"
                           class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Botones -->
                <div class="md:col-span-4 flex items-end gap-2">
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white px-4 py-2 rounded-lg hover:from-blue-700 hover:to-blue-800 font-semibold shadow-md">
                        Filtrar
                    </button>
                    <a href="{{ route('observaciones.index') }}" class="w-full bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 font-semibold shadow-md text-center">
                        Limpiar
                    </a>
                </div>
            </form>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <!-- Table Header -->
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-800">Lista de Observaciones</h2>
                    <span class="text-sm text-gray-600">{{ $observaciones->total() }} registros totales</span>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Estudiante</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Profesor</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Descripción</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tipo</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($observaciones as $obs)
                        <tr class="hover:bg-blue-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $obs->estudiante->nombreCompleto }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $obs->profesor->nombreCompleto }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $obs->descripcion }}
                            </td>
                            <td class="px-6 py-4">
                                @if($obs->tipo === 'positivo')
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full font-semibold">Positivo</span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full font-semibold">Negativo</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $obs->created_at->format('d-m-Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('observaciones.edit', $obs) }}" class="inline-flex items-center gap-1 px-3 py-2 bg-amber-100 text-amber-700 rounded-lg hover:bg-amber-200 transition-colors">
                                        Editar
                                    </a>
                                    <form action="{{ route('observaciones.destroy', $obs) }}" method="POST" class="inline" onsubmit="return confirm('¿Está seguro de eliminar esta observación?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                No hay observaciones registradas
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($observaciones->hasPages())
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    {{ $observaciones->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection


