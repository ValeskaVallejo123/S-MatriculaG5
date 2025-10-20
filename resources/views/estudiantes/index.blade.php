@extends('layouts.app')

@section('title', 'Estudiantes')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">📚 Estudiantes</h1>
        <a href="{{ route('estudiantes.create') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 font-semibold shadow">
            + Nuevo Estudiante
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre Completo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">DNI</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Grado/Sección</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($estudiantes as $estudiante)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $estudiante->nombre_completo }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $estudiante->dni }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $estudiante->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $estudiante->grado }} - Sección {{ $estudiante->seccion }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($estudiante->estado === 'activo')
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Activo</span>
                            @else
                                <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">Inactivo</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('estudiantes.show', $estudiante) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                Ver
                            </a>
                            <a href="{{ route('estudiantes.edit', $estudiante) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                Editar
                            </a>
                            <form action="{{ route('estudiantes.destroy', $estudiante) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button 
                                    type="submit" 
                                    onclick="return confirm('¿Estás seguro de eliminar a {{ $estudiante->nombre_completo }}?')"
                                    class="text-red-600 hover:text-red-900"
                                >
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No hay estudiantes registrados
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $estudiantes->links() }}
    </div>
</div>
@endsection