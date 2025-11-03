<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registrar Plan de Estudio - Centro Básico</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">

    <div class="max-w-5xl mx-auto p-6 md:p-8 bg-white rounded-xl shadow-2xl mt-10 border border-gray-200">
        <h1 class="text-3xl font-extrabold text-gray-800 text-center mb-8">
            Registrar Plan de Estudio
        </h1>

        {{-- Mostrar errores de validación --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-md">
                <strong class="font-bold">¡Oops! Hay algunos errores:</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulario con método POST a la ruta store --}}
        <form action="{{ route('plan_estudios.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre del Plan <span class="text-red-500">*</span></label>
                <input type="text" id="nombre" name="nombre" required maxlength="150" value="{{ old('nombre') }}"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:ring-green-500 focus:border-green-500 transition duration-150">
                @error('nombre')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="3"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:ring-green-500 focus:border-green-500 transition duration-150"
                    placeholder="Breve resumen del propósito del plan...">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label for="nivel_educativo" class="block text-sm font-medium text-gray-700">Nivel Educativo <span class="text-red-500">*</span></label>
                    <input type="text" id="nivel_educativo" name="nivel_educativo" required maxlength="50" value="{{ old('nivel_educativo') }}"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:ring-green-500 focus:border-green-500 transition duration-150"
                        placeholder="Ej: Educación Básica">
                    @error('nivel_educativo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="grado" class="block text-sm font-medium text-gray-700">Grado</label>
                    <input type="text" id="grado" name="grado" maxlength="50" value="{{ old('grado') }}"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:ring-green-500 focus:border-green-500 transition duration-150"
                        placeholder="Ej: 7mo Grado">
                    @error('grado')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label for="anio" class="block text-sm font-medium text-gray-700">Año Vigente</label>
                    <input type="number" id="anio" name="anio" min="2000" max="2100" value="{{ old('anio') }}"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:ring-green-500 focus:border-green-500 transition duration-150"
                        placeholder="Ej: 2025">
                    @error('anio')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="duracion" class="block text-sm font-medium text-gray-700">Duración (años/ciclos) <span class="text-red-500">*</span></label>
                    <input type="number" id="duracion" name="duracion" required min="1" max="10" value="{{ old('duracion') }}"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:ring-green-500 focus:border-green-500 transition duration-150"
                        placeholder="Ej: 1">
                    @error('duracion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label for="jornada" class="block text-sm font-medium text-gray-700">Jornada <span class="text-red-500">*</span></label>
                    <select id="jornada" name="jornada" required
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:ring-green-500 focus:border-green-500">
                        <option value="">Seleccione una opción</option>
                        <option value="Matutina" {{ old('jornada') == 'Matutina' ? 'selected' : '' }}>Matutina</option>
                        <option value="Vespertina" {{ old('jornada') == 'Vespertina' ? 'selected' : '' }}>Vespertina</option>
                        <option value="Mixta" {{ old('jornada') == 'Mixta' ? 'selected' : '' }}>Mixta</option>
                    </select>
                    @error('jornada')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="fecha_aprobacion" class="block text-sm font-medium text-gray-700">Fecha de Aprobación <span class="text-red-500">*</span></label>
                    <input type="date" id="fecha_aprobacion" name="fecha_aprobacion" required value="{{ old('fecha_aprobacion') }}"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:ring-green-500 focus:border-green-500 transition duration-150">
                    @error('fecha_aprobacion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="centro_id" class="block text-sm font-medium text-gray-700">Centro Educativo <span class="text-red-500">*</span></label>
                <select id="centro_id" name="centro_id" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:ring-green-500 focus:border-green-500">
                    <option value="">Seleccione un centro</option>
                    @foreach($centros as $centro)
                        <option value="{{ $centro->id }}" {{ old('centro_id') == $centro->id ? 'selected' : '' }}>
                            {{ $centro->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('centro_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex space-x-2 pt-4">
                <button type="submit"
                    class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                    Guardar Plan
                </button>

                <a href="{{ route('plan_estudios.index') }}"
                    class="w-full bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-md shadow-md text-center focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition duration-150 ease-in-out">
                    Volver
                </a>
            </div>
        </form>
    </div>
</body>
</html>