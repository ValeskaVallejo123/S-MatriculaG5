@extends('layouts.app')

@section('title', 'Nuevo Profesor')

@section('page-title', 'Registrar Nuevo Profesor')

@section('topbar-actions')
    <a href="{{ route('profesores.index') }}" class="btn-back" style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #4ec7d2; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 900px;">
    
    <!-- Formulario principal -->
    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body p-4">
            
            <form action="{{ route('profesores.store') }}" method="POST">
                @csrf

<<<<<<< HEAD
                <div class="space-y-8">
                    <!-- Sección: Información Personal -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-5 pb-2 border-b-2 border-purple-100">
                            Información Personal
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nombre -->
                            <div>
                                <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nombre
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="nombre"
                                        name="nombre"
                                        value="{{ old('nombre') }}"
                                        class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white outline-none transition-all @error('nombre') border-red-400 bg-red-50 @enderror"
                                        placeholder="Ingrese el nombre"
                                        required
                                        minlength="2"
                                        maxlength="50"
                                    >
                                </div>
                                <p class="text-xs text-gray-500 mt-2 ml-1">2-50 caracteres. Solo letras y espacios</p>
                                @error('nombre')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Apellido -->
                            <div>
                                <label for="apellido" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Apellido
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="apellido"
                                        name="apellido"
                                        value="{{ old('apellido') }}"
                                        class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white outline-none transition-all @error('apellido') border-red-400 bg-red-50 @enderror"
                                        placeholder="Ingrese el apellido"
                                        required
                                        minlength="2"
                                        maxlength="50"
                                    >
                                </div>
                                <p class="text-xs text-gray-500 mt-2 ml-1">2-50 caracteres. Solo letras y espacios</p>
                                @error('apellido')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- DNI -->
                            <div>
                                <label for="dni" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Número de Identidad
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="dni"
                                        name="dni"
                                        value="{{ old('dni') }}"
                                        class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white outline-none transition-all @error('dni') border-red-400 bg-red-50 @enderror"
                                        placeholder="0000000000000"
                                        required
                                        pattern="[0-9]{13}"
                                        maxlength="13"
                                    >
                                </div>
                                <p class="text-xs text-gray-500 mt-2 ml-1">Exactamente 13 dígitos. Ej: 0801198012345</p>
                                @error('dni')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Fecha de Nacimiento -->
                            <div>
                                <label for="fecha_nacimiento" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Fecha de Nacimiento
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <input
                                        type="date"
                                        id="fecha_nacimiento"
                                        name="fecha_nacimiento"
                                        value="{{ old('fecha_nacimiento') }}"
                                        max="{{ now()->subYears(18)->format('Y-m-d') }}"
                                        class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white outline-none transition-all @error('fecha_nacimiento') border-red-400 bg-red-50 @enderror"
                                        required
                                    >
                                </div>
                                <p class="text-xs text-gray-500 mt-2 ml-1">El profesor debe ser mayor de 18 años</p>
                                @error('fecha_nacimiento')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
=======
                <!-- Información Personal -->
                <div class="mb-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user" style="color: white; font-size: 0.9rem;"></i>
>>>>>>> origin/dev/valeska
                        </div>
                        <h6 class="mb-0 fw-bold" style="color: #003b73; font-size: 1rem;">Información Personal</h6>
                    </div>

<<<<<<< HEAD
                    <!-- Sección: Información de Contacto -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-5 pb-2 border-b-2 border-purple-100">
                            Información de Contacto
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Correo Electrónico
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white outline-none transition-all @error('email') border-red-400 bg-red-50 @enderror"
                                        placeholder="profesor@institucion.edu"
                                        maxlength="100"
                                    >
                                </div>
                                <p class="text-xs text-gray-500 mt-2 ml-1">Opcional. Máximo 100 caracteres</p>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Teléfono -->
                            <div>
                                <label for="telefono" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Teléfono
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="telefono"
                                        name="telefono"
                                        value="{{ old('telefono') }}"
                                        class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white outline-none transition-all @error('telefono') border-red-400 bg-red-50 @enderror"
                                        placeholder="00000000"
                                        pattern="[0-9]{8}"
                                        maxlength="8"
                                    >
                                </div>
                                <p class="text-xs text-gray-500 mt-2 ml-1">Opcional. Exactamente 8 dígitos. Ej: 99887766</p>
                                @error('telefono')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Dirección -->
                            <div class="md:col-span-2">
                                <label for="direccion" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Dirección de Residencia
                                </label>
                                <div class="relative">
                                    <div class="absolute top-4 left-0 pl-4 pointer-events-none">
                                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <textarea
                                        id="direccion"
                                        name="direccion"
                                        rows="3"
                                        maxlength="200"
                                        class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white outline-none transition-all @error('direccion') border-red-400 bg-red-50 @enderror"
                                        placeholder="Ingrese la dirección completa del profesor"
                                    >{{ old('direccion') }}</textarea>
                                </div>
                                <p class="text-xs text-gray-500 mt-2 ml-1">Opcional. Máximo 200 caracteres</p>
                                @error('direccion')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Sección: Información Profesional -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-5 pb-2 border-b-2 border-purple-100">
                            Información Profesional
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Especialidad -->
                            <div>
                                <label for="especialidad" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Especialidad
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                        </svg>
                                    </div>
                                    <select
                                        id="especialidad"
                                        name="especialidad"
                                        class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white outline-none transition-all appearance-none @error('especialidad') border-red-400 bg-red-50 @enderror"
                                        required
                                    >
                                        <option value="">Seleccione la especialidad</option>
                                        @foreach($especialidades as $especialidad)
                                            <option value="{{ $especialidad }}" {{ old('especialidad') == $especialidad ? 'selected' : '' }}>
                                                {{ $especialidad }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('especialidad')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Tipo de Contrato -->
                            <div>
                                <label for="tipo_contrato" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tipo de Contrato
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <select
                                        id="tipo_contrato"
                                        name="tipo_contrato"
                                        class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white outline-none transition-all appearance-none @error('tipo_contrato') border-red-400 bg-red-50 @enderror"
                                        required
                                    >
                                        <option value="">Seleccione el tipo</option>
                                        @foreach($tiposContrato as $key => $label)
                                            <option value="{{ $key }}" {{ old('tipo_contrato') == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('tipo_contrato')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Salario -->
                            <div>
                                <label for="salario" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Salario Mensual
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <input
                                        type="number"
                                        id="salario"
                                        name="salario"
                                        value="{{ old('salario') }}"
                                        step="0.01"
                                        min="0"
                                        max="999999.99"
                                        class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white outline-none transition-all @error('salario') border-red-400 bg-red-50 @enderror"
                                        placeholder="0.00"
                                    >
                                </div>
                                <p class="text-xs text-gray-500 mt-2 ml-1">Opcional. Máximo Lps 999,999.99</p>
                                @error('salario')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Fecha de Ingreso -->
                            <div>
                                <label for="fecha_ingreso" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Fecha de Ingreso
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <input
                                        type="date"
                                        id="fecha_ingreso"
                                        name="fecha_ingreso"
                                        value="{{ old('fecha_ingreso') }}"
                                        class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white outline-none transition-all @error('fecha_ingreso') border-red-400 bg-red-50 @enderror"
                                        required
                                    >
                                </div>
                                @error('fecha_ingreso')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Estado -->
                            <div>
                                <label for="estado" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Estado
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <select
                                        id="estado"
                                        name="estado"
                                        class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white outline-none transition-all appearance-none @error('estado') border-red-400 bg-red-50 @enderror"
                                        required
                                    >
                                        <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                                        <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                        <option value="licencia" {{ old('estado') == 'licencia' ? 'selected' : '' }}>Licencia</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('estado')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Sección: Observaciones -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-5 pb-2 border-b-2 border-purple-100">
                            Información Adicional
                        </h3>

                        <div>
                            <label for="observaciones" class="block text-sm font-semibold text-gray-700 mb-2">
                                Observaciones
                            </label>
                            <div class="relative">
                                <div class="absolute top-4 left-0 pl-4 pointer-events-none">
                                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <textarea
                                    id="observaciones"
                                    name="observaciones"
                                    rows="4"
                                    class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white outline-none transition-all @error('observaciones') border-red-400 bg-red-50 @enderror"
                                    placeholder="Información adicional relevante sobre el profesor (certificaciones, logros, notas especiales, etc.)"
                                >{{ old('observaciones') }}</textarea>
=======
                    <div class="row g-3">
                        <!-- Nombre -->
                        <div class="col-md-6">
                            <label for="nombre" class="form-label small fw-semibold" style="color: #003b73;">
                                Nombre <span style="color: #ef4444;">*</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-user position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                <input type="text" 
                                       class="form-control ps-5 @error('nombre') is-invalid @enderror" 
                                       id="nombre" 
                                       name="nombre" 
                                       value="{{ old('nombre') }}" 
                                       placeholder="Ej: Juan Carlos"
                                       style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                @error('nombre')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Apellido -->
                        <div class="col-md-6">
                            <label for="apellido" class="form-label small fw-semibold" style="color: #003b73;">
                                Apellido <span style="color: #ef4444;">*</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-user position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                <input type="text" 
                                       class="form-control ps-5 @error('apellido') is-invalid @enderror" 
                                       id="apellido" 
                                       name="apellido" 
                                       value="{{ old('apellido') }}" 
                                       placeholder="Ej: Pérez García"
                                       style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                @error('apellido')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- DNI -->
                        <div class="col-md-6">
                            <label for="dni" class="form-label small fw-semibold" style="color: #003b73;">
                                DNI <span style="color: #ef4444;">*</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-id-card position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                <input type="text" 
                                       class="form-control ps-5 @error('dni') is-invalid @enderror" 
                                       id="dni" 
                                       name="dni" 
                                       value="{{ old('dni') }}" 
                                       placeholder="Ej: 0801199512345"
                                       maxlength="13"
                                       style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                @error('dni')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <small class="text-muted" style="font-size: 0.75rem;">
                                <i class="fas fa-info-circle me-1"></i>Formato: 13 dígitos
                            </small>
                        </div>

                        <!-- Fecha de Nacimiento -->
                        <div class="col-md-6">
                            <label for="fecha_nacimiento" class="form-label small fw-semibold" style="color: #003b73;">
                                Fecha de Nacimiento
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-calendar position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                <input type="date" 
                                       class="form-control ps-5 @error('fecha_nacimiento') is-invalid @enderror" 
                                       id="fecha_nacimiento" 
                                       name="fecha_nacimiento" 
                                       value="{{ old('fecha_nacimiento') }}"
                                       style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                @error('fecha_nacimiento')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Género -->
                        <div class="col-md-6">
                            <label for="genero" class="form-label small fw-semibold" style="color: #003b73;">
                                Género
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-venus-mars position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem; z-index: 10;"></i>
                                <select class="form-select ps-5 @error('genero') is-invalid @enderror" 
                                        id="genero" 
                                        name="genero"
                                        style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                    <option value="">Seleccionar...</option>
                                    <option value="masculino" {{ old('genero') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                    <option value="femenino" {{ old('genero') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                    <option value="otro" {{ old('genero') == 'otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                                @error('genero')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Teléfono -->
                        <div class="col-md-6">
                            <label for="telefono" class="form-label small fw-semibold" style="color: #003b73;">
                                Teléfono
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-phone position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                <input type="text" 
                                       class="form-control ps-5 @error('telefono') is-invalid @enderror" 
                                       id="telefono" 
                                       name="telefono" 
                                       value="{{ old('telefono') }}" 
                                       placeholder="Ej: 9876-5432"
                                       style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                @error('telefono')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
>>>>>>> origin/dev/valeska
                            </div>
                        </div>
                    </div>
                </div>

<<<<<<< HEAD
                <!-- Botones de acción -->
                <div class="flex flex-col sm:flex-row gap-4 mt-10 pt-6 border-t-2 border-gray-100">
                    <button
                        type="submit"
                        class="flex-1 bg-gradient-to-r from-purple-600 to-purple-700 text-white py-4 rounded-xl font-semibold hover:from-purple-700 hover:to-purple-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Registrar Profesor
                    </button>
                    <a
                        href="{{ route('profesores.index') }}"
                        class="flex-1 bg-white text-gray-700 py-4 rounded-xl font-semibold border-2 border-gray-300 hover:bg-gray-50 hover:border-gray-400 transition-all flex items-center justify-center"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancelar
=======
                <!-- Información de Contacto -->
                <div class="mb-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-envelope" style="color: white; font-size: 0.9rem;"></i>
                        </div>
                        <h6 class="mb-0 fw-bold" style="color: #003b73; font-size: 1rem;">Información de Contacto</h6>
                    </div>

                    <div class="row g-3">
                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="email" class="form-label small fw-semibold" style="color: #003b73;">
                                Email <span style="color: #ef4444;">*</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-envelope position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                <input type="email" 
                                       class="form-control ps-5 @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       placeholder="profesor@ejemplo.com"
                                       style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                @error('email')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Dirección -->
                        <div class="col-md-6">
                            <label for="direccion" class="form-label small fw-semibold" style="color: #003b73;">
                                Dirección
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-map-marker-alt position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                <input type="text" 
                                       class="form-control ps-5 @error('direccion') is-invalid @enderror" 
                                       id="direccion" 
                                       name="direccion" 
                                       value="{{ old('direccion') }}" 
                                       placeholder="Ej: Barrio El Centro, Calle Principal"
                                       style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                @error('direccion')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información Académica -->
                <div class="mb-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-graduation-cap" style="color: white; font-size: 0.9rem;"></i>
                        </div>
                        <h6 class="mb-0 fw-bold" style="color: #003b73; font-size: 1rem;">Información Académica</h6>
                    </div>

                    <div class="row g-3">
                        <!-- Especialidad -->
                        <div class="col-md-6">
                            <label for="especialidad" class="form-label small fw-semibold" style="color: #003b73;">
                                Especialidad <span style="color: #ef4444;">*</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-book position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                <input type="text" 
                                       class="form-control ps-5 @error('especialidad') is-invalid @enderror" 
                                       id="especialidad" 
                                       name="especialidad" 
                                       value="{{ old('especialidad') }}" 
                                       placeholder="Ej: Matemáticas, Español, Ciencias"
                                       style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                @error('especialidad')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Nivel Académico -->
                        <div class="col-md-6">
                            <label for="nivel_academico" class="form-label small fw-semibold" style="color: #003b73;">
                                Nivel Académico
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-certificate position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem; z-index: 10;"></i>
                                <select class="form-select ps-5 @error('nivel_academico') is-invalid @enderror" 
                                        id="nivel_academico" 
                                        name="nivel_academico"
                                        style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                    <option value="">Seleccionar...</option>
                                    <option value="bachillerato" {{ old('nivel_academico') == 'bachillerato' ? 'selected' : '' }}>Bachillerato</option>
                                    <option value="licenciatura" {{ old('nivel_academico') == 'licenciatura' ? 'selected' : '' }}>Licenciatura</option>
                                    <option value="maestria" {{ old('nivel_academico') == 'maestria' ? 'selected' : '' }}>Maestría</option>
                                    <option value="doctorado" {{ old('nivel_academico') == 'doctorado' ? 'selected' : '' }}>Doctorado</option>
                                </select>
                                @error('nivel_academico')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información Laboral -->
                <div class="mb-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-briefcase" style="color: white; font-size: 0.9rem;"></i>
                        </div>
                        <h6 class="mb-0 fw-bold" style="color: #003b73; font-size: 1rem;">Información Laboral</h6>
                    </div>

                    <div class="row g-3">
                        <!-- Fecha de Contratación -->
                        <div class="col-md-6">
                            <label for="fecha_contratacion" class="form-label small fw-semibold" style="color: #003b73;">
                                Fecha de Contratación
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-calendar-check position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem;"></i>
                                <input type="date" 
                                       class="form-control ps-5 @error('fecha_contratacion') is-invalid @enderror" 
                                       id="fecha_contratacion" 
                                       name="fecha_contratacion" 
                                       value="{{ old('fecha_contratacion') }}"
                                       style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                @error('fecha_contratacion')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tipo de Contrato -->
                        <div class="col-md-6">
                            <label for="tipo_contrato" class="form-label small fw-semibold" style="color: #003b73;">
                                Tipo de Contrato
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-file-contract position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem; z-index: 10;"></i>
                                <select class="form-select ps-5 @error('tipo_contrato') is-invalid @enderror" 
                                        id="tipo_contrato" 
                                        name="tipo_contrato"
                                        style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                    <option value="">Seleccionar...</option>
                                    <option value="tiempo_completo" {{ old('tipo_contrato') == 'tiempo_completo' ? 'selected' : '' }}>Tiempo Completo</option>
                                    <option value="medio_tiempo" {{ old('tipo_contrato') == 'medio_tiempo' ? 'selected' : '' }}>Medio Tiempo</option>
                                    <option value="por_horas" {{ old('tipo_contrato') == 'por_horas' ? 'selected' : '' }}>Por Horas</option>
                                </select>
                                @error('tipo_contrato')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Estado -->
                        <div class="col-md-6">
                            <label for="estado" class="form-label small fw-semibold" style="color: #003b73;">
                                Estado <span style="color: #ef4444;">*</span>
                            </label>
                            <div class="position-relative">
                                <i class="fas fa-toggle-on position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.85rem; z-index: 10;"></i>
                                <select class="form-select ps-5 @error('estado') is-invalid @enderror" 
                                        id="estado" 
                                        name="estado"
                                        style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem 0.6rem 2.8rem; transition: all 0.3s ease;">
                                    <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                                    <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                    <option value="licencia" {{ old('estado') == 'licencia' ? 'selected' : '' }}>En Licencia</option>
                                </select>
                                @error('estado')
                                    <div class="invalid-feedback" style="font-size: 0.8rem;">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('profesores.index') }}" class="btn" style="border: 2px solid #00508f; color: #00508f; background: white; padding: 0.6rem 1.5rem; border-radius: 8px; font-weight: 600; transition: all 0.3s ease;">
                        <i class="fas fa-times me-1"></i>Cancelar
>>>>>>> origin/dev/valeska
                    </a>
                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; padding: 0.6rem 1.5rem; border-radius: 8px; font-weight: 600; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); transition: all 0.3s ease;">
                        <i class="fas fa-save me-1"></i>Guardar Profesor
                    </button>
                </div>

            </form>

        </div>
<<<<<<< HEAD

        <!-- Nota informativa -->
        <div class="mt-6 bg-purple-50 border border-purple-200 rounded-xl p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-purple-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div class="text-sm text-purple-800">
                    <p class="font-semibold mb-1">Información importante</p>
                    <p>Verifique que todos los datos del profesor sean correctos antes de registrar. El número de identidad debe ser único en el sistema y el profesor debe ser mayor de 18 años.</p>
                </div>
            </div>
        </div>



=======
>>>>>>> origin/dev/valeska
    </div>

</div>
@endsection
<<<<<<< HEAD
=======

@push('styles')
<style>
    .form-control:focus,
    .form-select:focus {
        border-color: #4ec7d2;
        box-shadow: 0 0 0 0.2rem rgba(78, 199, 210, 0.15);
        outline: none;
    }

    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: #ef4444;
        background-image: none;
    }

    .form-control.is-invalid:focus,
    .form-select.is-invalid:focus {
        border-color: #ef4444;
        box-shadow: 0 0 0 0.2rem rgba(239, 68, 68, 0.15);
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .invalid-feedback {
        display: block;
        margin-top: 0.35rem;
    }
</style>
@endpush
>>>>>>> origin/dev/valeska
