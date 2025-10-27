@extends('layouts.app')

@section('title', 'Nueva Matrícula')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4">

        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-teal-500 to-teal-700 rounded-2xl shadow-lg mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Formulario de Matrícula</h1>
            <p class="text-gray-600">Complete todos los datos para matricular al estudiante</p>
        </div>

        <!-- Información de documentos -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-lg">
            <div class="flex">
                <svg class="w-5 h-5 text-blue-600 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div class="text-sm text-blue-800">
                    <p class="font-semibold mb-1">Documentos Obligatorios:</p>
                    <p>Los documentos se subirán después de registrar la matrícula</p>
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <form action="{{ route('matriculas.store') }}" method="POST" class="space-y-6">
            @csrf
            <!-- Card 1: Información del Padre/Tutor -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Información del Padre/Tutor
                    </h2>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nombre Padre -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Nombre <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="padre_nombre" value="{{ old('padre_nombre') }}"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('padre_nombre') border-red-400 @enderror"
                            placeholder="Nombre del padre/tutor" required>
                        @error('padre_nombre')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Apellido Padre -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Apellido <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="padre_apellido" value="{{ old('padre_apellido') }}"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('padre_apellido') border-red-400 @enderror"
                            placeholder="Apellido del padre/tutor" required>
                        @error('padre_apellido')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- DNI Padre -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Número de Identidad <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="padre_dni" value="{{ old('padre_dni') }}"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('padre_dni') border-red-400 @enderror"
                            placeholder="0000000000000" pattern="[0-9]{13}" maxlength="13" required>
                        @error('padre_dni')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Parentesco -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Parentesco <span class="text-red-500">*</span>
                        </label>
                        <select name="padre_parentesco" id="padre_parentesco"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('padre_parentesco') border-red-400 @enderror"
                            required onchange="toggleOtroParentesco()">
                            <option value="">Seleccione</option>
                            @foreach($parentescos as $key => $label)
                                <option value="{{ $key }}" {{ old('padre_parentesco') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('padre_parentesco')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Otro Parentesco (oculto) -->
                    <div id="otro_parentesco_div" class="md:col-span-2 hidden">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Especifique el parentesco <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="padre_parentesco_otro" value="{{ old('padre_parentesco_otro') }}"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Ej: Primo, Hermano, etc.">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Correo Electrónico <span class="text-red-500"></span>
                        </label>
                        <input type="email" name="padre_email" value="{{ old('padre_email') }}"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('padre_email') border-red-400 @enderror"
                            placeholder="ejemplo@correo.com">
                        @error('padre_email')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Teléfono -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Teléfono <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="padre_telefono" value="{{ old('padre_telefono') }}"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('padre_telefono') border-red-400 @enderror"
                            placeholder="00000000" pattern="[0-9]{8}" maxlength="8" required>
                        @error('padre_telefono')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Dirección -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Dirección <span class="text-red-500">*</span>
                        </label>
                        <textarea name="padre_direccion" rows="3"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('padre_direccion') border-red-400 @enderror"
                            placeholder="Dirección completa del padre/tutor" required>{{ old('padre_direccion') }}</textarea>
                        @error('padre_direccion')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Card 2: Información del Estudiante -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        Información del Estudiante
                    </h2>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nombre Estudiante -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Nombre <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="estudiante_nombre" value="{{ old('estudiante_nombre') }}"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('estudiante_nombre') border-red-400 @enderror"
                            placeholder="Nombre del estudiante" required>
                        @error('estudiante_nombre')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Apellido Estudiante -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Apellido <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="estudiante_apellido" value="{{ old('estudiante_apellido') }}"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('estudiante_apellido') border-red-400 @enderror"
                            placeholder="Apellido del estudiante" required>
                        @error('estudiante_apellido')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- DNI Estudiante -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Número de Identidad <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="estudiante_dni" value="{{ old('estudiante_dni') }}"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('estudiante_dni') border-red-400 @enderror"
                            placeholder="0000000000000" pattern="[0-9]{13}" maxlength="13" required>
                        @error('estudiante_dni')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fecha Nacimiento -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Fecha de Nacimiento <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="estudiante_fecha_nacimiento" value="{{ old('estudiante_fecha_nacimiento') }}"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('estudiante_fecha_nacimiento') border-red-400 @enderror"
                            required>
                        @error('estudiante_fecha_nacimiento')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Estudiante -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Correo Electrónico
                        </label>
                        <input type="email" name="estudiante_email" value="{{ old('estudiante_email') }}"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            placeholder="correo@ejemplo.com">
                    </div>

                    <!-- Teléfono Estudiante -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Teléfono
                        </label>
                        <input type="text" name="estudiante_telefono" value="{{ old('estudiante_telefono') }}"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            placeholder="00000000" pattern="[0-9]{8}" maxlength="8">
                    </div>

                    <!-- Grado -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Grado <span class="text-red-500">*</span>
                        </label>
                        <select name="estudiante_grado"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('estudiante_grado') border-red-400 @enderror"
                            required>
                            <option value="">Seleccione el grado</option>
                            @foreach($grados as $grado)
                                <option value="{{ $grado }}" {{ old('estudiante_grado') == $grado ? 'selected' : '' }}>{{ $grado }}</option>
                            @endforeach
                        </select>
                        @error('estudiante_grado')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sección -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Sección <span class="text-red-500">*</span>
                        </label>
                        <select name="estudiante_seccion"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('estudiante_seccion') border-red-400 @enderror"
                            required>
                            <option value="">Seleccione la sección</option>
                            @foreach($secciones as $seccion)
                                <option value="{{ $seccion }}" {{ old('estudiante_seccion') == $seccion ? 'selected' : '' }}>{{ $seccion }}</option>
                            @endforeach
                        </select>
                        @error('estudiante_seccion')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>


            <!-- Card 3: Documentos -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        Documentos Requeridos
                    </h2>
                </div>
                <div class="p-6">
                    <!-- Lista de documentos requeridos -->
                    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm font-semibold text-gray-700 mb-3">Documentos que deberá proporcionar:</p>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-purple-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Fotografía del estudiante
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-purple-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Acta de nacimiento del estudiante
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-purple-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Calificaciones Anteriores
                            </li>
                        </ul>
                    </div>

                    <!-- Botón para subir documentos -->
                    <button type="button" id="btnSubirDocumentos"
                        class="w-full bg-gradient-to-r from-purple-600 to-purple-700 text-white py-4 rounded-xl font-semibold hover:from-purple-700 hover:to-purple-800 transition-all shadow-lg hover:shadow-xl flex items-center justify-center group">
                        <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        Subir Documentos
                    </button>

                    <!-- Nota informativa -->
                    <div class="mt-4 flex items-start bg-blue-50 p-3 rounded-lg">
                        <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-xs text-blue-800">
                             Se aceptan formatos: PDF, JPG, PNG (máx. 5MB por archivo).
                        </p>
                    </div>
                </div>
            </div>

            <!-- Alerta para Documentos -->
            <div class="bg-amber-50 border-l-4 border-amber-500 p-5 rounded-lg">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-amber-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-sm font-bold text-amber-900 mb-1">Documentos Requeridos</h3>
                        <p class="text-sm text-amber-800 mb-3">
                            Después de registrar la matrícula, deberá subir los documentos obligatorios (Foto estudiante, Acta de nacimiento y calificaciones del estudiante del año anterior).
                        </p>
                    </div>
                </div>
            </div>
            <!-- Botones de Acción -->
            <div class="flex flex-col sm:flex-row gap-4">
                <button type="submit"
                    class="flex-1 bg-gradient-to-r from-teal-600 to-teal-700 text-white py-4 rounded-xl font-semibold hover:from-teal-700 hover:to-teal-800 transition-all shadow-lg hover:shadow-xl flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Registrar Matrícula
                </button>
                <a href="{{ route('matriculas.index') }}"
                    class="flex-1 bg-white text-gray-700 py-4 rounded-xl font-semibold border-2 border-gray-300 hover:bg-gray-50 transition-all flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function toggleOtroParentesco() {
    const select = document.getElementById('padre_parentesco');
    const otroDiv = document.getElementById('otro_parentesco_div');

    if (select.value === 'otro') {
        otroDiv.classList.remove('hidden');
    } else {
        otroDiv.classList.add('hidden');
    }
}

// Ejecutar al cargar si ya está seleccionado "otro"
document.addEventListener('DOMContentLoaded', function() {
    toggleOtroParentesco();
});

// Event listener para el botón de subir documentos

document.getElementById('btnSubirDocumentos').addEventListener('click', function() {
    // AQUÍ PUEDES VINCULAR TU FUNCIÓN PARA SUBIR DOCUMENTOS
    // Por ejemplo: abrirModalDocumentos() o redirigir a otra página
    console.log('Botón de Subir Documentos clickeado');
    // Tu código aquí...
});
</script>
@endsection
