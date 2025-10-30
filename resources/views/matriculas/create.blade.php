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

        <!-- Formulario -->
        <form id="formMatricula" action="{{ route('matriculas.store') }}" method="POST" class="space-y-6">
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
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre <span class="text-red-500">*</span></label>
                        <input type="text" name="padre_nombre" value="{{ old('padre_nombre') }}" class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('padre_nombre') border-red-400 @enderror" placeholder="Nombre del padre/tutor" required>
                        @error('padre_nombre')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Apellido Padre -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Apellido <span class="text-red-500">*</span></label>
                        <input type="text" name="padre_apellido" value="{{ old('padre_apellido') }}" class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('padre_apellido') border-red-400 @enderror" placeholder="Apellido del padre/tutor" required>
                        @error('padre_apellido')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- DNI Padre -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Número de Identidad <span class="text-red-500">*</span></label>
                        <input type="text" name="padre_dni" value="{{ old('padre_dni') }}" class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('padre_dni') border-red-400 @enderror" placeholder="0000000000000" pattern="[0-9]{13}" maxlength="13" required>
                        @error('padre_dni')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Parentesco -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Parentesco <span class="text-red-500">*</span></label>
                        <select name="padre_parentesco" id="padre_parentesco" class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('padre_parentesco') border-red-400 @enderror" required onchange="toggleOtroParentesco()">
                            <option value="">Seleccione</option>
                            @foreach($parentescos as $key => $label)
                                <option value="{{ $key }}" {{ old('padre_parentesco') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('padre_parentesco')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Otro Parentesco -->
                    <div id="otro_parentesco_div" class="md:col-span-2 hidden">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Especifique el parentesco <span class="text-red-500">*</span></label>
                        <input type="text" name="padre_parentesco_otro" value="{{ old('padre_parentesco_otro') }}" class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ej: Primo, Hermano, etc.">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Correo Electrónico</label>
                        <input type="email" name="padre_email" value="{{ old('padre_email') }}" class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="ejemplo@correo.com">
                    </div>

                    <!-- Teléfono -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Teléfono <span class="text-red-500">*</span></label>
                        <input type="text" name="padre_telefono" value="{{ old('padre_telefono') }}" class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('padre_telefono') border-red-400 @enderror" placeholder="00000000" pattern="[0-9]{8}" maxlength="8" required>
                        @error('padre_telefono')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Dirección -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Dirección <span class="text-red-500">*</span></label>
                        <textarea name="padre_direccion" rows="3" class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('padre_direccion') border-red-400 @enderror" placeholder="Dirección completa del padre/tutor" required>{{ old('padre_direccion') }}</textarea>
                        @error('padre_direccion')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
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
                    <!-- Nombre -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre <span class="text-red-500">*</span></label>
                        <input type="text" name="estudiante_nombre" value="{{ old('estudiante_nombre') }}" class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('estudiante_nombre') border-red-400 @enderror" placeholder="Nombre del estudiante" required>
                        @error('estudiante_nombre')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Apellido -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Apellido <span class="text-red-500">*</span></label>
                        <input type="text" name="estudiante_apellido" value="{{ old('estudiante_apellido') }}" class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('estudiante_apellido') border-red-400 @enderror" placeholder="Apellido del estudiante" required>
                        @error('estudiante_apellido')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- DNI -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Número de Identidad <span class="text-red-500">*</span></label>
                        <input type="text" name="estudiante_dni" value="{{ old('estudiante_dni') }}" class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('estudiante_dni') border-red-400 @enderror" placeholder="0000000000000" pattern="[0-9]{13}" maxlength="13" required>
                        @error('estudiante_dni')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Fecha Nacimiento -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Fecha de Nacimiento <span class="text-red-500">*</span></label>
                        <input type="date" name="estudiante_fecha_nacimiento" value="{{ old('estudiante_fecha_nacimiento') }}" class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('estudiante_fecha_nacimiento') border-red-400 @enderror" required>
                        @error('estudiante_fecha_nacimiento')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Grado -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Grado <span class="text-red-500">*</span></label>
                        <select name="estudiante_grado" class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('estudiante_grado') border-red-400 @enderror" required>
                            <option value="">Seleccione el grado</option>
                            @foreach($grados as $grado)
                                <option value="{{ $grado }}" {{ old('estudiante_grado') == $grado ? 'selected' : '' }}>{{ $grado }}</option>
                            @endforeach
                        </select>
                        @error('estudiante_grado')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Sección -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Sección <span class="text-red-500">*</span></label>
                        <select name="estudiante_seccion" class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('estudiante_seccion') border-red-400 @enderror" required>
                            <option value="">Seleccione la sección</option>
                            @foreach($secciones as $seccion)
                                <option value="{{ $seccion }}" {{ old('estudiante_seccion') == $seccion ? 'selected' : '' }}>{{ $seccion }}</option>
                            @endforeach
                        </select>
                        @error('estudiante_seccion')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <!-- Card 3: Subir Archivos -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
             <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                 <h2 class="text-xl font-bold text-white flex items-center">
                     <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M12 12v6M8 12v6m8-6v6"></path>
                     </svg>
                     Subir Archivos del Estudiante y Padre
                 </h2>
                </div>

                <div class="p-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Seleccione los archivos a subir</label>
                    <input type="file" name="archivos[]" multiple accept="image/*,application/pdf" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('archivos') border-red-400 @enderror">
                    <p class="mt-1 text-sm text-gray-500">Puede subir: foto del estudiante, acta de nacimiento, certificado de estudios, constancia de conducta, foto DNI estudiante y foto DNI padre.</p>
                    @error('archivos')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex flex-col sm:flex-row gap-4">
                <button type="submit" class="flex-1 bg-gradient-to-r from-teal-600 to-teal-700 text-white py-4 rounded-xl font-semibold hover:from-teal-700 hover:to-teal-800 transition-all shadow-lg hover:shadow-xl flex items-center justify-center">
                    Registrar Matrícula
                </button>
                <a href="{{ route('matriculas.index') }}" class="flex-1 bg-white text-gray-700 py-4 rounded-xl font-semibold border-2 border-gray-300 hover:bg-gray-50 transition-all flex items-center justify-center">
                    Cancelar
                </a>
            </div>

        </form>
    </div>
</div>

<!-- Scripts -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function toggleOtroParentesco() {
    const select = document.getElementById('padre_parentesco');
    const otroDiv = document.getElementById('otro_parentesco_div');
    if (select.value === 'otro') otroDiv.classList.remove('hidden');
    else otroDiv.classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', function() {
    toggleOtroParentesco();

    // Confirmación SweetAlert antes de enviar
    const form = document.getElementById('formMatricula');
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const padreNombre = form.querySelector('input[name="padre_nombre"]').value;
        const padreApellido = form.querySelector('input[name="padre_apellido"]').value;
        const padreDNI = form.querySelector('input[name="padre_dni"]').value;
        const padreParentesco = form.querySelector('select[name="padre_parentesco"]').value;
        const estudianteNombre = form.querySelector('input[name="estudiante_nombre"]').value;
        const estudianteApellido = form.querySelector('input[name="estudiante_apellido"]').value;
        const estudianteDNI = form.querySelector('input[name="estudiante_dni"]').value;
        const estudianteGrado = form.querySelector('select[name="estudiante_grado"]').value;
        const estudianteSeccion = form.querySelector('select[name="estudiante_seccion"]').value;

        const htmlResumen = `
            <strong>Padre/Tutor:</strong><br>
            Nombre: ${padreNombre} ${padreApellido}<br>
            DNI: ${padreDNI}<br>
            Parentesco: ${padreParentesco}<br><br>
            <strong>Estudiante:</strong><br>
            Nombre: ${estudianteNombre} ${estudianteApellido}<br>
            DNI: ${estudianteDNI}<br>
            Grado: ${estudianteGrado}<br>
            Sección: ${estudianteSeccion}
        `;

        Swal.fire({
            title: 'Confirmar Matrícula',
            html: htmlResumen,
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Sí, registrar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endsection
