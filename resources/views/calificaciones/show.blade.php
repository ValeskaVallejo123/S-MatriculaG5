@extends('layouts.app')

@section('title', 'Ver Calificación')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Detalle de Calificación</h1>
            <a href="{{ route('calificaciones.index') }}" 
               class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition">
                Volver
            </a>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $calificacion->nombre_alumno }}</h2>
                <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $calificacion->estado_color }}">
                    {{ $calificacion->estado }}
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-blue-50 rounded-lg p-4">
                    <p class="text-sm text-gray-600 mb-1">Primer Parcial</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $calificacion->primer_parcial ?? 'Pendiente' }}</p>
                </div>

                <div class="bg-green-50 rounded-lg p-4">
                    <p class="text-sm text-gray-600 mb-1">Segundo Parcial</p>
                    <p class="text-2xl font-bold text-green-600">{{ $calificacion->segundo_parcial ?? 'Pendiente' }}</p>
                </div>

                <div class="bg-yellow-50 rounded-lg p-4">
                    <p class="text-sm text-gray-600 mb-1">Tercer Parcial</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $calificacion->tercer_parcial ?? 'Pendiente' }}</p>
                </div>

                <div class="bg-purple-50 rounded-lg p-4">
                    <p class="text-sm text-gray-600 mb-1">Cuarto Parcial</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $calificacion->cuarto_parcial ?? 'Pendiente' }}</p>
                </div>
            </div>

            @if($calificacion->recuperacion)
                <div class="bg-orange-50 rounded-lg p-4 mb-6">
                    <p class="text-sm text-gray-600 mb-1">Recuperación</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $calificacion->recuperacion }}</p>
                </div>
            @endif

            <div class="bg-indigo-50 border-2 border-indigo-200 rounded-lg p-6">
                <p class="text-sm text-gray-600 mb-1">Nota Final</p>
                <p class="text-4xl font-bold text-indigo-600">
                    {{ $calificacion->nota_final ? number_format($calificacion->nota_final, 2) : 'Pendiente' }}
                </p>
            </div>

            <div class="mt-6 grid grid-cols-2 gap-4 text-sm text-gray-600">
                <div>
                    <span class="font-medium">Registrado:</span>
                    {{ $calificacion->created_at?->format('d/m/Y H:i') }}
                </div>
                <div>
                    <span class="font-medium">Última actualización:</span>
                    {{ $calificacion->updated_at?->format('d/m/Y H:i') }}
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex gap-4">
                <a href="{{ route('calificaciones.edit', $calificacion) }}" 
                   class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold text-center transition">
                    Editar
                </a>
                <form action="{{ route('calificaciones.destroy', $calificacion) }}" 
                      method="POST" 
                      class="flex-1"
                      onsubmit="return confirm('¿Está seguro de eliminar esta calificación?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="w-full bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection