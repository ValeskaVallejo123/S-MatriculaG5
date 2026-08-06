@extends('layouts.app')

@section('title', 'Crear Ciclo')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Crear Nuevo Ciclo</h1>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('ciclos.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre del Ciclo <span class="text-red-500">*</span>
                    </label>
                    <select name="nombre" id="nombre" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('nombre') border-red-500 @enderror"
                            required>
                        <option value="">Seleccione un ciclo</option>
                        <option value="Primer Ciclo" {{ old('nombre') == 'Primer Ciclo' ? 'selected' : '' }}>Primer Ciclo</option>
                        <option value="Segundo Ciclo" {{ old('nombre') == 'Segundo Ciclo' ? 'selected' : '' }}>Segundo Ciclo</option>
                        <option value="Tercer Ciclo" {{ old('nombre') == 'Tercer Ciclo' ? 'selected' : '' }}>Tercer Ciclo</option>
                    </select>
                    @error('nombre')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
    <label for="seccion" class="block text-sm font-medium text-gray-700 mb-2">
        Sección <span class="text-red-500">*</span>
    </label>
    {{-- Reemplazado <textarea> por <input type="text"> --}}
    <input type="text" 
           name="seccion" 
           id="seccion" 
           value="{{ old('seccion') }}" 
           placeholder="Ej: A, B, Nocturna"
           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('seccion') border-red-500 @enderror"
           required>
    
    @error('seccion')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

                <div class="mb-6">
    <label class="block text-sm font-medium text-gray-700 mb-3">
        Jornada <span class="text-red-500">*</span>
    </label>
    <div class="flex gap-6">
        <label class="flex items-center cursor-pointer">
            <input type="radio" name="jornada" value="Matutina" 
            {{ old('jornada', 'Matutina') == 'Matutina' ? 'checked' : '' }}
            {{ old('jornada') == 'Matutina' ? 'checked' : '' }}
            class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                required>
            <span class="ml-2 text-sm text-gray-700">Jornada Matutina</span>
        </label>
        <label class="flex items-center cursor-pointer">
            <input type="radio" name="jornada" value="Vespertina" 
                   {{ old('jornada') == 'Vespertina' ? 'checked' : '' }}
                   class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                   required>
            <span class="ml-2 text-sm text-gray-700">Jornada Vespertina</span>
        </label>
    </div>
    @error('jornada')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

                <div class="flex gap-4">
                    <button type="submit" 
                            class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                        Crear Ciclo
                    </button>
                    <a href="{{ route('ciclos.index') }}" 
                       class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-lg font-semibold text-center transition">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection