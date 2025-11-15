@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-purple-200 to-blue-300 flex items-center justify-center px-4">
        <div class="w-full max-w-lg bg-purple-600 text-white rounded-2xl shadow-2xl p-8">
            <h2 class="text-3xl font-bold mb-6 text-center"> Buscar Registro de Estudiante</h2>

            <form action="{{ route('registroestudiantes.buscarregistro') }}" method="GET" class="space-y-6">
                <!-- Campo Nombre -->
                <div>
                    <label for="nombre" class="block text-sm font-semibold mb-2">Nombre completo</label>
                    <input
                        type="text"
                        name="nombre"
                        id="nombre"
                        value="{{ request('nombre') }}"
                        placeholder="Ej. Juan Pérez"
                        class="w-full px-4 py-2 rounded-lg text-gray-900 focus:ring-2 focus:ring-yellow-400 focus:outline-none text-sm shadow-sm"
                        autocomplete="off"
                    >
                </div>

                <!-- Campo DNI -->
                <div>
                    <label for="dni" class="block text-sm font-semibold mb-2">DNI</label>
                    <input
                        type="text"
                        name="dni"
                        id="dni"
                        value="{{ request('dni') }}"
                        placeholder="Ej. 0801-1990-12345"
                        class="w-full px-4 py-2 rounded-lg text-gray-900 focus:ring-2 focus:ring-yellow-400 focus:outline-none text-sm shadow-sm"
                        autocomplete="off"
                    >
                </div>

                <!-- Botón -->
                <div class="text-center">
                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2 bg-yellow-400 text-purple-900 font-semibold rounded-lg shadow-md hover:bg-yellow-300 transition duration-300 ease-in-out transform hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Buscar
                    </button>

                    <div class="text-center mt-6">
                        <a href="{{ route('estudiantes.index') }}"
                           class="inline-flex items-center gap-2 px-6 py-3 bg-white text-gray-700 font-semibold border-2 border-gray-300 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all shadow-sm hover:shadow-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Volver al listado
                        </a>
                    </div>

                </div>
            </form>

            @if($busquedaRealizada)
                <div class="mt-8 space-y-6">
                    @forelse($resultados as $estudiante)
                        <div class="bg-white text-gray-800 rounded-2xl shadow-xl p-6">
                            <h3 class="text-xl font-bold text-purple-700 mb-4"> Ficha del Estudiante</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <p><strong>Nombre:</strong> {{ $estudiante->nombre }}</p>
                                <p><strong>Apellido:</strong> {{ $estudiante->apellido }}</p>
                                <p><strong>DNI:</strong> {{ $estudiante->dni }}</p>
                                <p><strong>Fecha de nacimiento:</strong> {{ $estudiante->fecha_nacimiento->format('d/m/Y') }}</p>
                                <p><strong>Sexo:</strong> {{ ucfirst($estudiante->sexo) }}</p>
                                <p><strong>Correo electrónico:</strong> {{ $estudiante->email ?? 'No registrado' }}</p>
                                <p><strong>Teléfono:</strong> {{ $estudiante->telefono ?? 'No registrado' }}</p>
                                <p><strong>Dirección:</strong> {{ $estudiante->direccion ?? 'No registrada' }}</p>
                                <p><strong>Grado:</strong> {{ $estudiante->grado }}</p>
                                <p><strong>Sección:</strong> {{ $estudiante->seccion }}</p>
                                <p><strong>Estado:</strong>
                                    <span class="px-2 py-1 rounded-full {{ $estudiante->estado === 'activo' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($estudiante->estado) }}
                        </span>
                                </p>
                                <p><strong>Observaciones:</strong> {{ $estudiante->observaciones ?? 'Sin observaciones' }}</p>
                            </div>

                            @if($estudiante->foto)
                                <div class="mt-4">
                                    <p class="font-semibold mb-2"> Foto del estudiante:</p>
                                    <img src="{{ asset('storage/' . $estudiante->foto) }}" alt="Foto de {{ $estudiante->nombre }}" class="w-32 h-32 object-cover rounded-lg border">
                                </div>
                            @endif
                        </div>

                    @empty
                        <div class="bg-red-100 text-red-700 p-4 rounded-lg text-center font-semibold">
                            Estudiante no encontrado
                        </div>
                    @endforelse
                </div>
            @endif

        </div>
    </div>
@endsection

