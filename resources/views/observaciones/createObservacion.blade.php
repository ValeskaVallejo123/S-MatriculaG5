@extends('layouts.app')

@section('title', 'Crear Observación')

@section('content')
    <div class="min-h-screen py-12">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-600 to-blue-800 rounded-2xl shadow-lg mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-3">Registro de Observación</h1>
                <p class="text-lg text-gray-600">Complete el formulario con la información de la observación</p>
                <div class="w-24 h-1 bg-blue-600 mx-auto mt-4 rounded-full"></div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
                    <h2 class="text-xl font-semibold text-white">Información de la Observación</h2>
                    <p class="text-blue-100 text-sm mt-1">Los campos marcados con asterisco son obligatorios</p>
                </div>

                <!-- Form Body -->
                <form action="{{ route('observaciones.store') }}" method="POST" class="p-8">
                    @csrf

                    <div class="space-y-8">
                        <!-- Sección: Selección de Estudiante -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-5 pb-2 border-b-2 border-blue-100">
                                Estudiante
                            </h3>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <select name="estudiante_id" class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all @error('estudiante_id') border-red-400 bg-red-50 @enderror" required>
                                    <option value="">Seleccione un estudiante</option>
                                    @foreach($estudiantes as $est)
                                        <option value="{{ $est->id }}" {{ old('estudiante_id') == $est->id ? 'selected' : '' }}>{{ $est->nombreCompleto }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('estudiante_id')
                            <p class="mt-2 text-sm text-red-600 flex items-center">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Sección: Tipo de Observación -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-5 pb-2 border-b-2 border-blue-100">
                                Tipo de Observación
                            </h3>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <select name="tipo" class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                                    <option value="positivo" {{ old('tipo') == 'positivo' ? 'selected' : '' }}>Positivo</option>
                                    <option value="negativo" {{ old('tipo') == 'negativo' ? 'selected' : '' }}>Negativo</option>
                                </select>
                            </div>
                        </div>

                        <!-- Sección: Descripción -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-5 pb-2 border-b-2 border-blue-100">
                                Descripción
                            </h3>
                            <div class="relative">
                                <div class="absolute top-4 left-0 pl-4 pointer-events-none">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <textarea name="descripcion" rows="5" class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all @error('descripcion') border-red-400 bg-red-50 @enderror" placeholder="Escriba la descripción de la observación">{{ old('descripcion') }}</textarea>
                            </div>
                            @error('descripcion')
                            <p class="mt-2 text-sm text-red-600 flex items-center">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="flex flex-col sm:flex-row gap-4 mt-10 pt-6 border-t-2 border-gray-100">
                        <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white py-4 rounded-xl font-semibold hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Registrar Observación
                        </button>
                        <a href="{{ route('observaciones.index') }}" class="flex-1 bg-white text-gray-700 py-4 rounded-xl font-semibold border-2 border-gray-300 hover:bg-gray-50 hover:border-gray-400 transition-all flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

