@extends('layouts.app')

@section('title', 'Editar Ciclo')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Editar Ciclo</h1>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('ciclos.update', $ciclo) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre del Ciclo <span class="text-red-500">*</span>
                    </label>
                    <select name="nombre" id="nombre" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('nombre') border-red-500 @enderror"
                            required>
                        <option value="">Seleccione un ciclo</option>
                        <option value="Primer Ciclo" {{ old('nombre', $ciclo->nombre) == 'Primer Ciclo' ? 'selected' : '' }}>Primer Ciclo</option>
                        <option value="Segundo Ciclo" {{ old('nombre', $ciclo->nombre) == 'Segundo Ciclo' ? 'selected' : '' }}>Segundo Ciclo</option>
                        <option value="Tercer Ciclo" {{ old('nombre', $ciclo->nombre) == 'Tercer Ciclo' ? 'selected' : '' }}>Tercer Ciclo</option>
                    </select>
                    @error('nombre')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                  <label for="seccion" class="block text-sm font-medium text-gray-700 mb-2">
                    Sección <span class="text-red-500">*</span>
                    </label>
                    {{-- Cambiamos de <textarea> a <input type="text"> --}}
                    <input type="text" 
                    name="seccion" 
                    id="seccion"
                    value="{{ old('seccion', $ciclo->seccion) }}" 
                    placeholder="Ej: A, B, Nocturna"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('seccion') border-red-500 @enderror">
    
                    @error('seccion')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

               <div class="mb-6">
    <label for="jornada" class="block text-sm font-medium text-gray-700 mb-2">
        Jornada <span class="text-red-500">*</span>
    </label>
    <select name="jornada" id="jornada"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('jornada') border-red-500 @enderror"
            required>
        <option value="">Seleccione una jornada</option>
        
        {{-- Opción Matutina --}}
        <option value="Matutina" 
                {{ old('jornada', $grado->jornada ?? '') == 'Matutina' ? 'selected' : '' }}>
            Matutina
        </option>
        
        {{-- Opción Vespertina --}}
        <option value="Vespertina" 
                {{ old('jornada', $grado->jornada ?? '') == 'Vespertina' ? 'selected' : '' }}>
            Vespertina
            </option>
        </select>
    
        @error('jornada')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
        </div>

                <div class="flex gap-4">
                    <button type="submit" 
                            class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                        Actualizar Ciclo
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