@extends('layouts.app')

@section('title', 'Ciclos')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Gestión de Ciclos</h1>
        <a href="{{ route('ciclos.create') }}" 
           class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold transition">
            + Nuevo Ciclo
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sección</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Maestro</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jornada</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($ciclos as $ciclo)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $ciclo->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $ciclo->nombre }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $ciclo->seccion ?? 'Sin asignar' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $ciclo->maestro ?? 'Sin asignar' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $isMatutina = $ciclo->jornada === 'Matutina';
                                $badgeClass = $isMatutina ? 'bg-indigo-100 text-indigo-800' : 'bg-yellow-100 text-yellow-800';
                            @endphp
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $badgeClass }}">
                                {{ $ciclo->jornada ?? 'Sin asignar' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('ciclos.show', $ciclo) }}" 
                               class="text-blue-600 hover:text-blue-900 mr-3">Clases</a>
                            <a href="{{ route('ciclos.edit', $ciclo) }}" 
                               class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                            <form action="{{ route('ciclos.destroy', $ciclo) }}" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('¿Está seguro de eliminar este ciclo?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No hay ciclos registrados
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection