@extends('layouts.app')

@section('title', 'Calificaciones')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Gestión de Calificaciones</h1>
        <a href="{{ route('calificaciones.create') }}" 
           class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold transition">
            + Nueva Calificación
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre Alumno</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">1er Parcial</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">2do Parcial</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">3er Parcial</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">4to Parcial</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Recuperación</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Nota Final</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Estado</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($calificaciones as $calificacion)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $calificacion->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $calificacion->nombre_alumno }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                            {{ $calificacion->primer_parcial ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                            {{ $calificacion->segundo_parcial ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                            {{ $calificacion->tercer_parcial ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                            {{ $calificacion->cuarto_parcial ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                            {{ $calificacion->recuperacion ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-gray-900">
                            {{ $calificacion->nota_final ? number_format($calificacion->nota_final, 2) : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $calificacion->estado_color }}">
                                {{ $calificacion->estado }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                            <a href="{{ route('calificaciones.show', $calificacion) }}" 
                               class="text-blue-600 hover:text-blue-900 mr-3">Ver</a>
                            <a href="{{ route('calificaciones.edit', $calificacion) }}" 
                               class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                            <form action="{{ route('calificaciones.destroy', $calificacion) }}" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('¿Está seguro de eliminar esta calificación?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-6 py-4 text-center text-gray-500">
                            No hay calificaciones registradas
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($calificaciones->count() > 0)
        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Estudiantes</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ $calificaciones->count() }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Aprobados</h3>
                <p class="text-3xl font-bold text-green-600">
                    {{ $calificaciones->where('nota_final', '>=', 60)->count() }}
                </p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Reprobados</h3>
                <p class="text-3xl font-bold text-red-600">
                    {{ $calificaciones->where('nota_final', '<', 60)->where('nota_final', '!=', null)->count() }}
                </p>
            </div>
        </div>
    @endif
</div>
@endsection