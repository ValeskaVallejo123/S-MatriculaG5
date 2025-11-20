@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-[#001D39] to-[#4E8EA2] flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-3xl bg-white rounded-3xl shadow-2xl overflow-hidden">
            <div class="bg-[#49769F] text-white px-8 py-6">
                <h2 class="text-3xl font-bold text-center">Buscar Registro de Estudiante</h2>
            </div>

            <div class="px-8 py-6">
                <form action="{{ route('registroestudiantes.buscarregistro') }}" method="GET">
                    <!-- Campo Nombre -->
                    <div>
                        <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-2">Nombre completo</label>
                        <input
                            type="text"
                            name="nombre"
                            id="nombre"
                            value="{{ request('nombre') }}"
                            placeholder="Ej. Juan Pérez"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#4E8EA2] focus:outline-none text-sm shadow-sm"
                            autocomplete="off"
                        >
                    </div>

                    <!-- Campo DNI -->
                    <div>
                        <label for="dni" class="block text-sm font-semibold text-gray-700 mb-2">DNI</label>
                        <input
                            type="text"
                            name="dni"
                            id="dni"
                            value="{{ request('dni') }}"
                            placeholder="Ej. 0801-1990-12345"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#4E8EA2] focus:outline-none text-sm shadow-sm"
                            autocomplete="off"
                        >
                    </div>

                    <!-- Botones -->
                    <div class="flex flex-col md:flex-row justify-center items-center gap-4 mt-4">
                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 px-6 py-2 bg-[#4E8EA2] text-white font-semibold rounded-lg shadow-md hover:bg-[#3f7c91] transition duration-300 ease-in-out transform hover:scale-105"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Buscar
                        </button>

                        <a href="{{ route('estudiantes.index') }}"
                           class="inline-flex items-center gap-2 px-6 py-3 bg-white text-[#49769F] font-semibold border-2 border-[#49769F] rounded-xl hover:bg-[#f0f4f8] hover:border-[#3f6b8a] transition-all shadow-sm hover:shadow-md"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Volver al listado
                        </a>
                    </div>
                </form>

                @if($busquedaRealizada)
                    <div class="mt-10 space-y-6">
                        @forelse($resultados as $estudiante)
                            <div class="bg-gray-50 border border-gray-200 rounded-2xl shadow-md p-6">
                                <h3 class="text-xl font-bold text-[#49769F] mb-4">Ficha del Estudiante</h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
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
                                        <p class="font-semibold mb-2">Foto del estudiante:</p>
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
    </div>
@endsection
