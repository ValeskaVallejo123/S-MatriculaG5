@extends('layouts.app')

@section('title', 'Ver Ciclo')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Detalles del Ciclo</h1>
            <a href="{{ route('ciclos.index') }}" 
               class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition">
                Volver
            </a>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">ID</label>
                    <p class="text-lg text-gray-900">{{ $ciclo->id }}</p>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Nombre</label>
                    <p class="text-lg text-gray-900">{{ $ciclo->nombre }}</p>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Sección</label>
                    <p class="text-lg text-gray-900">{{ $ciclo->seccion ?? 'Sin especificar' }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Jornada</label>
                    <p class="text-sm text-gray-700">{{ $ciclo->jornada ?? 'Sin especificar' }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Actualizado</label>
                    <p class="text-sm text-gray-700">{{ $ciclo->updated_at?->format('d/m/Y H:i') ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        {{-- Sección de Clases --}}
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Clases del Ciclo</h2>
            
            <div class="space-y-3">
                {{-- Lenguaje y Literatura --}}
                <div class="border-l-4 border-blue-500 pl-4 py-2 bg-blue-50">
                    <h3 class="font-semibold text-lg text-gray-800">Lenguaje y Literatura</h3>
                </div>

                {{-- Matemáticas --}}
                <div class="border-l-4 border-green-500 pl-4 py-2 bg-green-50">
                    <h3 class="font-semibold text-lg text-gray-800">Matemáticas</h3>
                </div>

                {{-- Ciencias Naturales --}}
                <div class="border-l-4 border-purple-500 pl-4 py-2 bg-purple-50">
                    <h3 class="font-semibold text-lg text-gray-800">Ciencias Naturales</h3>
                </div>

                {{-- Ciencias Sociales --}}
                <div class="border-l-4 border-yellow-500 pl-4 py-2 bg-yellow-50">
                    <h3 class="font-semibold text-lg text-gray-800">Ciencias Sociales</h3>
                </div>

                {{-- Formación en tecnología e informática --}}
                <div class="border-l-4 border-indigo-500 pl-4 py-2 bg-indigo-50">
                    <h3 class="font-semibold text-lg text-gray-800">Formación en Tecnología e Informática</h3>
                </div>

                {{-- Inglés --}}
                <div class="border-l-4 border-red-500 pl-4 py-2 bg-red-50">
                    <h3 class="font-semibold text-lg text-gray-800">Inglés</h3>
                </div>

                {{-- Educación Física --}}
                <div class="border-l-4 border-orange-500 pl-4 py-2 bg-orange-50">
                    <h3 class="font-semibold text-lg text-gray-800">Educación Física</h3>
                </div>

                {{-- Educación Artística --}}
                <div class="border-l-4 border-pink-500 pl-4 py-2 bg-pink-50">
                    <h3 class="font-semibold text-lg text-gray-800">Educación Artística</h3>
                </div>
            </div>
        </div>

        {{-- Botones de acción --}}
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex gap-4">
                <a href="{{ route('ciclos.edit', $ciclo) }}" 
                   class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold text-center transition">
                    Editar
                </a>
                <form action="{{ route('ciclos.destroy', $ciclo) }}" 
                      method="POST" 
                      class="flex-1"
                      onsubmit="return confirm('¿Está seguro de eliminar este ciclo?')">
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