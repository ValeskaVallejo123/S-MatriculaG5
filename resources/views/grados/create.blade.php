@extends('layouts.app')

@section('title', 'Crear Grado')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Crear Nuevo Grado</h1>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('grados.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre del Grado <span class="text-red-500">*</span>
                    </label>
                    <select name="nombre" id="nombre" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('nombre') border-red-500 @enderror"
                            required>
                        <option value="">Seleccione un grado</option>
                        <option value="Primero" {{ old('nombre') == 'Primero' ? 'selected' : '' }}>Primero</option>
                        <option value="Segundo" {{ old('nombre') == 'Segundo' ? 'selected' : '' }}>Segundo</option>
                        <option value="Tercero" {{ old('nombre') == 'Tercero' ? 'selected' : '' }}>Tercero</option>
                        <option value="Cuarto" {{ old('nombre') == 'Cuarto' ? 'selected' : '' }}>Cuarto</option>
                        <option value="Quinto" {{ old('nombre') == 'Quinto' ? 'selected' : '' }}>Quinto</option>
                        <option value="Sexto" {{ old('nombre') == 'Sexto' ? 'selected' : '' }}>Sexto</option>
                    </select>
                    @error('nombre')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="seccion" class="block text-sm font-medium text-gray-700 mb-2">
                        Sección
                    </label>
                    <input type="text" 
                           name="seccion" 
                           id="seccion" 
                           value="{{ old('seccion') }}" 
                           placeholder="Ej: A, B, Nocturna"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('seccion') border-red-500 @enderror">
                    
                    @error('seccion')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="nombre_maestro" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre del Maestro <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="nombre_maestro" 
                           id="nombre_maestro"
                           value="{{ old('nombre_maestro') }}"
                           placeholder="Ingrese el nombre completo del maestro"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('nombre_maestro') border-red-500 @enderror"
                           required>
                    
                    @error('nombre_maestro')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Seleccione la Jornada: <span class="text-red-500">*</span>
                    </label>

                    <label class="inline-flex items-center mr-6">
                        <input type="radio" 
                               name="jornada" 
                               value="Matutina" 
                               {{ old('jornada', 'Matutina') == 'Matutina' ? 'checked' : '' }}
                               class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                               required>
                        <span class="ml-2 text-sm text-gray-700">Matutina</span>
                    </label>

                    <label class="inline-flex items-center">
                        <input type="radio" 
                               name="jornada" 
                               value="Vespertina" 
                               {{ old('jornada') == 'Vespertina' ? 'checked' : '' }}
                               class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                               required>
                        <span class="ml-2 text-sm text-gray-700">Vespertina</span>
                    </label>

                    @error('jornada')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4">
                    <button type="submit" 
                            class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                        Crear Grado
                    </button>
                    <a href="{{ route('grados.index') }}" 
                       class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-lg font-semibold text-center transition">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection