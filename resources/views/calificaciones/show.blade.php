@extends('layouts.app')

@section('title', 'Editar Calificación')

@section('content')
    <div class="container mx-auto px-4 py-10 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Card Contenedor Principal con estilo moderno -->
            <div class="bg-white rounded-xl shadow-2xl overflow-hidden p-8 sm:p-10 border border-gray-100">
                <h1 class="text-4xl font-extrabold text-indigo-700 mb-8 border-b pb-4">
                    <i class="fas fa-edit mr-3"></i> Editar Calificación
                </h1>

                <form action="{{ route('calificaciones.update', $calificacion) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Sección: Datos del Alumno -->
                    <h2 class="text-xl font-semibold text-gray-700 mb-4 border-l-4 border-indigo-500 pl-3">
                        Información General
                    </h2>

                    <div class="mb-6">
                        <label for="nombre_alumno" class="block text-sm font-bold text-gray-700 mb-2">
                            Nombre del Alumno <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nombre_alumno" id="nombre_alumno"
                            value="{{ old('nombre_alumno', $calificacion->nombre_alumno) }}"
                            placeholder="Ej: Juan Pérez López" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400
                                                  focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150
                                                  @error('nombre_alumno') border-red-500 ring-red-200 @enderror" required>

                        @error('nombre_alumno')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sección: Calificaciones Parciales -->
                    <h2 class="text-xl font-semibold text-gray-700 mb-4 mt-8 border-l-4 border-indigo-500 pl-3">
                        Calificaciones (0.00 - 100.00)
                    </h2>

                    <!-- Contenedor visual para los parciales -->
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-6 p-4 bg-gray-50 rounded-lg border">

                        <!-- Primer Parcial -->
                        <div>
                            <label for="primer_parcial" class="block text-sm font-medium text-gray-700 mb-2">
                                1er Parcial
                            </label>
                            <input type="number" name="primer_parcial" id="primer_parcial"
                                value="{{ old('primer_parcial', $calificacion->primer_parcial) }}" step="0.01" min="0"
                                max="100" placeholder="0.00" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm text-center
                                                      focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150
                                                      @error('primer_parcial') border-red-500 ring-red-200 @enderror">

                            @error('primer_parcial')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Segundo Parcial -->
                        <div>
                            <label for="segundo_parcial" class="block text-sm font-medium text-gray-700 mb-2">
                                2do Parcial
                            </label>
                            <input type="number" name="segundo_parcial" id="segundo_parcial"
                                value="{{ old('segundo_parcial', $calificacion->segundo_parcial) }}" step="0.01" min="0"
                                max="100" placeholder="0.00" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm text-center
                                                      focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150
                                                      @error('segundo_parcial') border-red-500 ring-red-200 @enderror">

                            @error('segundo_parcial')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tercer Parcial -->
                        <div>
                            <label for="tercer_parcial" class="block text-sm font-medium text-gray-700 mb-2">
                                3er Parcial
                            </label>
                            <input type="number" name="tercer_parcial" id="tercer_parcial"
                                value="{{ old('tercer_parcial', $calificacion->tercer_parcial) }}" step="0.01" min="0"
                                max="100" placeholder="0.00" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm text-center
                                                      focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150
                                                      @error('tercer_parcial') border-red-500 ring-red-200 @enderror">

                            @error('tercer_parcial')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Cuarto Parcial -->
                        <div>
                            <label for="cuarto_parcial" class="block text-sm font-medium text-gray-700 mb-2">
                                4to Parcial
                            </label>
                            <input type="number" name="cuarto_parcial" id="cuarto_parcial"
                                value="{{ old('cuarto_parcial', $calificacion->cuarto_parcial) }}" step="0.01" min="0"
                                max="100" placeholder="0.00" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm text-center
                                                      focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150
                                                      @error('cuarto_parcial') border-red-500 ring-red-200 @enderror">

                            @error('cuarto_parcial')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Sección: Recuperación -->
                    <h2 class="text-xl font-semibold text-gray-700 mb-4 mt-8 border-l-4 border-indigo-500 pl-3">
                        Recuperación
                    </h2>

                    <div class="mb-8">
                        <label for="recuperacion" class="block text-sm font-bold text-gray-700 mb-2">
                            Nota de Recuperación (Opcional)
                        </label>
                        <input type="number" name="recuperacion" id="recuperacion"
                            value="{{ old('recuperacion', $calificacion->recuperacion) }}" step="0.01" min="0" max="100"
                            placeholder="0.00" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm text-center
                                                  focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150
                                                  @error('recuperacion') border-red-500 ring-red-200 @enderror">
                        <p class="text-sm text-gray-500 mt-2">
                            Ingrese la nota solo si el alumno realizó el examen de recuperación.
                        </p>

                        @error('recuperacion')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Aviso Importante mejorado -->
                    <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4 mb-8">
                        <p class="text-sm font-medium text-indigo-800 flex items-center">
                            <i class="fas fa-info-circle mr-3"></i>
                            La **Nota Final** se recalculará automáticamente al guardar los cambios en el sistema.
                        </p>
                    </div>

                    <!-- Botones de Acción mejorados -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button type="submit"
                            class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white 
                                                   px-6 py-3 rounded-xl font-bold shadow-lg shadow-indigo-200 
                                                   transition transform hover:scale-[1.01] duration-300 flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i> Actualizar Calificación
                        </button>
                        <a href="{{ route('calificaciones.index') }}"
                            class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 
                                              px-6 py-3 rounded-xl font-semibold text-center 
                                              transition transform hover:scale-[1.01] duration-300 flex items-center justify-center">
                            <i class="fas fa-arrow-left mr-2"></i> Cancelar y Volver
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection