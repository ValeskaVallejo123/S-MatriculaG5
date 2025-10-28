@extends('layouts.app')

@section('title', 'Editar Documentos')

@section('content')
    <div class="max-w-4xl mx-auto my-10">
        <div class="bg-white rounded-lg shadow p-8">
            <h1 class="text-3xl font-bold mb-6 text-gray-800"><i class="bi bi-pencil-square"></i> Editar Documentos del Estudiante</h1>

            <form action="{{ route('documentos.update', $documento->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Información del Estudiante -->
                <div class="border-b pb-4">
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">Información del Estudiante</h2>

                    <div>
                        <label class="block font-semibold mb-2">Nombre del Estudiante *</label>
                        <input
                            type="text"
                            name="nombre_estudiante"
                            value="{{ old('nombre_estudiante', $documento->nombre_estudiante) }}"
                            class="w-full px-4 py-2 border rounded @error('nombre_estudiante') border-red-500 @enderror"
                            required
                        >
                        @error('nombre_estudiante')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Archivos -->
                <div class="border-b pb-4">
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">Documentos</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Acta de nacimiento -->
                        <div>
                            <label class="block font-semibold mb-2">Acta de Nacimiento</label>
                            <div class="mb-2">
                                <a href="{{ asset('storage/' . $documento->acta_nacimiento) }}" target="_blank" class="btn btn-outline-info btn-sm">
                                    <i class="bi bi-eye"></i> Ver actual
                                </a>
                            </div>
                            <input
                                type="file"
                                name="acta_nacimiento"
                                id="acta_nacimiento"
                                accept=".jpg,.png,.pdf"
                                class="w-full px-4 py-2 border rounded @error('acta_nacimiento') border-red-500 @enderror"
                            >
                            <p class="text-gray-500 text-sm mt-1">Opcional — reemplaza el archivo si deseas actualizarlo. Máx 5 MB</p>
                            @error('acta_nacimiento')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Calificaciones -->
                        <div>
                            <label class="block font-semibold mb-2">Calificaciones</label>
                            <div class="mb-2">
                                <a href="{{ asset('storage/' . $documento->calificaciones) }}" target="_blank" class="btn btn-outline-info btn-sm">
                                    <i class="bi bi-eye"></i> Ver actual
                                </a>
                            </div>
                            <input
                                type="file"
                                name="calificaciones"
                                id="calificaciones"
                                accept=".jpg,.png,.pdf"
                                class="w-full px-4 py-2 border rounded @error('calificaciones') border-red-500 @enderror"
                            >
                            <p class="text-gray-500 text-sm mt-1">Opcional — reemplaza el archivo si deseas actualizarlo. Máx 5 MB</p>
                            @error('calificaciones')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex gap-4 pt-4">
                    <button type="submit" class="flex-1 bg-yellow-500 text-white py-3 rounded-lg font-semibold hover:bg-yellow-600">
                        Actualizar Documentos
                    </button>
                    <a href="{{ route('documentos.index') }}" class="flex-1 bg-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-400 text-center leading-[3rem]">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Validación de archivos --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const maxSize = 5 * 1024 * 1024;
                const allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];

                const acta = document.getElementById('acta_nacimiento').files[0];
                const calif = document.getElementById('calificaciones').files[0];

                let errorMessage = '';

                if (acta && (!allowedTypes.includes(acta.type) || acta.size > maxSize)) {
                    errorMessage = 'El Acta de Nacimiento debe ser JPG, PNG o PDF y no superar 5 MB.';
                } else if (calif && (!allowedTypes.includes(calif.type) || calif.size > maxSize)) {
                    errorMessage = 'Las Calificaciones deben ser JPG, PNG o PDF y no superar 5 MB.';
                }

                if (errorMessage) {
                    e.preventDefault();
                    alert(errorMessage);
                }
            });
        });
    </script>

    <style>
        body {
            background-color: #fffaf0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        input[type="file"] {
            padding: 0.5rem 0.5rem;
        }
    </style>
@endsection



