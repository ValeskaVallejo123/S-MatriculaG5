@extends('layouts.app')

@section('title', 'Ver Grado')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Detalles del Grado</h1>
                <a href="{{ route('grados.index') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition">
                    Volver
                </a>
            </div>

            <!-- Información General del Grado -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-indigo-100">
                    Información General
                </h2>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">ID</label>
                        <p class="text-lg text-gray-900">{{ $grado->id }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Jornada</label>
                        <span
                            class="px-3 py-1 text-sm rounded-full {{ $grado->jornada == 'Matutina' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ $grado->jornada == 'Matutina' ? '☀️ Matutina' : '🌙 Vespertina' }}
                        </span>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Nombre</label>
                        <p class="text-lg text-gray-900 font-semibold">{{ $grado->nombre }}</p>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Sección</label>
                        <p class="text-lg text-gray-900">{{ $grado->descripcion ?? 'Sin descripción' }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Creado</label>
                        <p class="text-sm text-gray-700">
                            {{ $grado->created_at ? $grado->created_at->format('d/m/Y H:i') : 'No disponible' }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Actualizado</label>
                        <p class="text-sm text-gray-700">
                            {{ $grado->updated_at ? $grado->updated_at->format('d/m/Y H:i') : 'No disponible' }}</p>
                    </div>
                </div>
            </div>

            <!-- Asignaturas Comunes -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-indigo-100">
                    📚 Asignaturas Comunes
                </h2>
                <p class="text-sm text-gray-600 mb-4">Materias que se imparten en este grado:</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @php
                        $asignaturas = [
                            [
                                'nombre' => 'Español',
                                'descripcion' => 'Lectura, escritura y gramática',
                                'icono' => '📖',
                                'color' => 'bg-red-50 border-red-200 text-red-800'
                            ],
                            [
                                'nombre' => 'Matemáticas',
                                'descripcion' => 'Aritmética y conceptos básicos de geometría',
                                'icono' => '🔢',
                                'color' => 'bg-blue-50 border-blue-200 text-blue-800'
                            ],
                            [
                                'nombre' => 'Ciencias',
                                'descripcion' => 'Ciencias Naturales y Ciencias Sociales',
                                'icono' => '🔬',
                                'color' => 'bg-green-50 border-green-200 text-green-800'
                            ],
                            [
                                'nombre' => 'Inglés',
                                'descripcion' => 'Introducción al idioma extranjero',
                                'icono' => '🌎',
                                'color' => 'bg-purple-50 border-purple-200 text-purple-800'
                            ],
                            [
                                'nombre' => 'Educación Física',
                                'descripcion' => 'Actividades deportivas y recreativas',
                                'icono' => '⚽',
                                'color' => 'bg-orange-50 border-orange-200 text-orange-800'
                            ],
                            [
                                'nombre' => 'Formación Ciudadana y Ética',
                                'descripcion' => 'Valores cívicos y formación moral',
                                'icono' => '🏛️',
                                'color' => 'bg-indigo-50 border-indigo-200 text-indigo-800'
                            ],
                            [
                                'nombre' => 'Arte',
                                'descripcion' => 'Expresión artística y creatividad',
                                'icono' => '🎨',
                                'color' => 'bg-pink-50 border-pink-200 text-pink-800'
                            ],
                            [
                                'nombre' => 'Computación',
                                'descripcion' => 'Habilidades tecnológicas básicas',
                                'icono' => '💻',
                                'color' => 'bg-gray-50 border-gray-200 text-gray-800'
                            ]
                        ];
                    @endphp

                    @foreach ($asignaturas as $asignatura)
                        <div class="border-2 rounded-lg p-4 {{ $asignatura['color'] }} hover:shadow-md transition">
                            <div class="flex items-start">
                                <span class="text-3xl mr-3">{{ $asignatura['icono'] }}</span>
                                <div>
                                    <h3 class="font-semibold text-base mb-1">{{ $asignatura['nombre'] }}</h3>
                                    <p class="text-sm opacity-80">{{ $asignatura['descripcion'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-sm text-blue-800">
                        <strong>📌 Nota:</strong> Estas son las asignaturas comunes para todos los grados de educación primaria en Honduras.
                    </p>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex gap-4">
                    <a href="{{ route('grados.edit', $grado) }}"
                        class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold text-center transition">
                        ✏️ Editar Grado
                    </a>
                    <form action="{{ route('grados.destroy', $grado) }}" method="POST" class="flex-1"
                        onsubmit="return confirm('¿Está seguro de eliminar este grado?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                            🗑️ Eliminar Grado
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection