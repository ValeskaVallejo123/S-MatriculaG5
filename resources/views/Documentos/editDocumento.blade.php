@extends('layouts.app')

@section('title', 'Editar Documentos')

@section('content')
    <div class="max-w-4xl mx-auto my-10">
        <div class="bg-white rounded-lg shadow p-8">
            <h1 class="text-3xl font-bold mb-6 text-gray-800"><i class="bi bi-pencil-square"></i> Editar Documentos del Estudiante</h1>

            <form action="{{ route('documentos.update', $documento->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="border-b pb-4">
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">Información del Estudiante</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Nombre -->
                        <div>
                            <label class="block font-semibold mb-2">Nombre del Estudiante *</label>
                            <input type="text" name="nombre_estudiante" value="{{ old('nombre_estudiante', $documento->nombre_estudiante) }}"
                                   class="w-full px-4 py-2 border rounded @error('nombre_estudiante') border-red-500 @enderror" required>
                            @error('nombre_estudiante')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Foto del estudiante -->
                        <div>
                            <label class="block font-semibold mb-2">Foto del Estudiante *</label>
                            <div class="mb-2">
                                @if($documento->foto)
                                    <img src="{{ asset('storage/' . $documento->foto) }}" class="w-32 h-32 object-cover rounded">
                                @endif
                            </div>
                            <input type="file" name="foto" id="foto" accept=".jpg,.png"
                                   class="w-full px-4 py-2 border rounded @error('foto') border-red-500 @enderror" required>
                            <p class="text-gray-500 text-sm mt-1">JPG o PNG (máx. 5 MB)</p>
                            @error('foto')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <div class="border-b pb-4">
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">Documentos *</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Acta -->
                        <div>
                            <label class="block font-semibold mb-2">Acta de Nacimiento *</label>
                            <div class="mb-2">
                                @if($documento->acta_nacimiento)
                                    <a href="{{ asset('storage/' . $documento->acta_nacimiento) }}" target="_blank" class="btn btn-outline-info btn-sm">
                                        <i class="bi bi-eye"></i> Ver actual
                                    </a>
                                @endif
                            </div>
                            <input type="file" name="acta_nacimiento" id="acta_nacimiento" accept=".jpg,.png,.pdf"
                                   class="w-full px-4 py-2 border rounded @error('acta_nacimiento') border-red-500 @enderror" required>
                            <p class="text-gray-500 text-sm mt-1">JPG, PNG o PDF (máx. 5 MB)</p>
                            @error('acta_nacimiento')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Calificaciones -->
                        <div>
                            <label class="block font-semibold mb-2">Calificaciones *</label>
                            <div class="mb-2">
                                @if($documento->calificaciones)
                                    <a href="{{ asset('storage/' . $documento->calificaciones) }}" target="_blank" class="btn btn-outline-info btn-sm">
                                        <i class="bi bi-eye"></i> Ver actual
                                    </a>
                                @endif
                            </div>
                            <input type="file" name="calificaciones" id="calificaciones" accept=".jpg,.png,.pdf"
                                   class="w-full px-4 py-2 border rounded @error('calificaciones') border-red-500 @enderror" required>
                            <p class="text-gray-500 text-sm mt-1">JPG, PNG o PDF (máx. 5 MB)</p>
                            @error('calificaciones')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const maxSize = 5 * 1024 * 1024; // 5 MB
                const allowedFiles = {
                    foto: ['image/jpeg','image/png'],
                    otros: ['image/jpeg','image/png','application/pdf']
                };

                const foto = document.getElementById('foto').files[0];
                const acta = document.getElementById('acta_nacimiento').files[0];
                const calif = document.getElementById('calificaciones').files[0];

                let errorMessage = '';

                if (!foto) {
                    errorMessage = 'La Foto del Estudiante es obligatoria.';
                } else if (!allowedFiles.foto.includes(foto.type) || foto.size > maxSize) {
                    errorMessage = 'La Foto debe ser JPG o PNG y no superar 5 MB.';
                } else if (!acta) {
                    errorMessage = 'El Acta de Nacimiento es obligatoria.';
                } else if (acta && !allowedFiles.otros.includes(acta.type) || acta.size > maxSize) {
                    errorMessage = 'El Acta de Nacimiento debe ser JPG, PNG o PDF y no superar 5 MB.';
                } else if (!calif) {
                    errorMessage = 'Las Calificaciones son obligatorias.';
                } else if (calif && !allowedFiles.otros.includes(calif.type) || calif.size > maxSize) {
                    errorMessage = 'Las Calificaciones deben ser JPG, PNG o PDF y no superar 5 MB.';
                }

                if (errorMessage) {
                    e.preventDefault();
                    alert(errorMessage);
                }
            });
        });
    </script>
@endsection





