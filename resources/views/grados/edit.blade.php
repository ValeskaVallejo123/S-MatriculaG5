@extends('layouts.app')

@section('title', 'Editar Grado')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Editar Grado</h1>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('grados.update', $grado) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre del Grado <span class="text-red-500">*</span>
                    </label>
                    <select name="nombre" id="nombre" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('nombre') border-red-500 @enderror"
                            required>
                        <option value="">Seleccione un grado</option>
                        <option value="Primero" {{ old('nombre', $grado->nombre) == 'Primero' ? 'selected' : '' }}>Primero</option>
                        <option value="Segundo" {{ old('nombre', $grado->nombre) == 'Segundo' ? 'selected' : '' }}>Segundo</option>
                        <option value="Tercero" {{ old('nombre', $grado->nombre) == 'Tercero' ? 'selected' : '' }}>Tercero</option>
                        <option value="Cuarto" {{ old('nombre', $grado->nombre) == 'Cuarto' ? 'selected' : '' }}>Cuarto</option>
                        <option value="Quinto" {{ old('nombre', $grado->nombre) == 'Quinto' ? 'selected' : '' }}>Quinto</option>
                        <option value="Sexto" {{ old('nombre', $grado->nombre) == 'Sexto' ? 'selected' : '' }}>Sexto</option>
                    </select>
                    @error('nombre')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="seccion" class="block text-sm font-medium text-gray-700 mb-2">
                        Sección
                    </label>
                    <input type="text" name="seccion" id="seccion"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('seccion') border-red-500 @enderror"
                           placeholder="Ej: A, B, C, Única"
                           value="{{ old('seccion', $grado->seccion) }}">
                    @error('seccion')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="nombre_maestro" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre del Maestro <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nombre_maestro" id="nombre_maestro"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('nombre_maestro') border-red-500 @enderror"
                           placeholder="Ingrese el nombre del maestro"
                           value="{{ old('nombre_maestro', $grado->nombre_maestro) }}"
                           required>
                    @error('nombre_maestro')
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
                                   {{ old('jornada', $grado->jornada) == 'Matutina' ? 'checked' : '' }}
                                   class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                   required>
                            <span class="ml-2 text-sm text-gray-700">Jornada Matutina</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="jornada" value="Vespertina" 
                                   {{ old('jornada', $grado->jornada) == 'Vespertina' ? 'checked' : '' }}
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
                        Actualizar Grado
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