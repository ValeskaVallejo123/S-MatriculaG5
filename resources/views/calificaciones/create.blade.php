@extends('layouts.app')

@section('title', 'Crear Calificación')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Registrar Nueva Calificación</h1>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('calificaciones.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="nombre_alumno" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre del Alumno <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="nombre_alumno" 
                           id="nombre_alumno" 
                           value="{{ old('nombre_alumno') }}" 
                           placeholder="Ej: Juan Pérez López"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('nombre_alumno') border-red-500 @enderror"
                           required>
                    
                    @error('nombre_alumno')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="primer_parcial" class="block text-sm font-medium text-gray-700 mb-2">
                            Primer Parcial
                        </label>
                        <input type="number" 
                               name="primer_parcial" 
                               id="primer_parcial" 
                               value="{{ old('primer_parcial') }}" 
                               step="0.01"
                               min="0"
                               max="100"
                               placeholder="0.00"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('primer_parcial') border-red-500 @enderror">
                        
                        @error('primer_parcial')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="segundo_parcial" class="block text-sm font-medium text-gray-700 mb-2">
                            Segundo Parcial
                        </label>
                        <input type="number" 
                               name="segundo_parcial" 
                               id="segundo_parcial" 
                               value="{{ old('segundo_parcial') }}" 
                               step="0.01"
                               min="0"
                               max="100"
                               placeholder="0.00"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('segundo_parcial') border-red-500 @enderror">
                        
                        @error('segundo_parcial')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="tercer_parcial" class="block text-sm font-medium text-gray-700 mb-2">
                            Tercer Parcial
                        </label>
                        <input type="number" 
                               name="tercer_parcial" 
                               id="tercer_parcial" 
                               value="{{ old('tercer_parcial') }}" 
                               step="0.01"
                               min="0"
                               max="100"
                               placeholder="0.00"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('tercer_parcial') border-red-500 @enderror">
                        
                        @error('tercer_parcial')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="cuarto_parcial" class="block text-sm font-medium text-gray-700 mb-2">
                            Cuarto Parcial
                        </label>
                        <input type="number" 
                               name="cuarto_parcial" 
                               id="cuarto_parcial" 
                               value="{{ old('cuarto_parcial') }}" 
                               step="0.01"
                               min="0"
                               max="100"
                               placeholder="0.00"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('cuarto_parcial') border-red-500 @enderror">
                        
                        @error('cuarto_parcial')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label for="recuperacion" class="block text-sm font-medium text-gray-700 mb-2">
                        Recuperación (Opcional)
                    </label>
                    <input type="number" 
                           name="recuperacion" 
                           id="recuperacion" 
                           value="{{ old('recuperacion') }}" 
                           step="0.01"
                           min="0"
                           max="100"
                           placeholder="0.00"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('recuperacion') border-red-500 @enderror">
                    <p class="text-sm text-gray-500 mt-1">Solo si el alumno necesita recuperar</p>
                    
                    @error('recuperacion')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-blue-800">
                        <strong>Nota:</strong> La nota final se calculará automáticamente como el promedio de los 4 parciales. 
                        Si hay recuperación y el promedio es menor a 60, se tomará la mejor nota entre el promedio y la recuperación.
                    </p>
                </div>

                <div class="flex gap-4">
                    <button type="submit" 
                            class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                        Registrar Calificación
                    </button>
                    <a href="{{ route('calificaciones.index') }}" 
                       class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-lg font-semibold text-center transition">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection