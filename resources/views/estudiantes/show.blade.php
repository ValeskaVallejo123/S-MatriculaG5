@extends('layouts.app')

@section('title', 'Detalles del Estudiante')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-white">{{ $estudiante->nombre_completo }}</h1>
                    <p class="text-blue-100 mt-1">{{ $estudiante->grado }} - Sección {{ $estudiante->seccion }}</p>
                </div>
                <div>
                    @if($estudiante->estado === 'activo')
                        <span class="px-4 py-2 bg-green-500 text-white rounded-full text-sm font-semibold">
                            ✓ Activo
                        </span>
                    @else
                        <span class="px-4 py-2 bg-red-500 text-white rounded-full text-sm font-semibold">
                            ✗ Inactivo
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Body -->
        <div class="p-8">
            <!-- Información Personal -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2"> Información Personal</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500 font-semibold">Nombre</p>
                        <p class="text-gray-900">{{ $estudiante->nombre }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-semibold">Apellido</p>
                        <p class="text-gray-900">{{ $estudiante->apellido }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-semibold">DNI</p>
                        <p class="text-gray-900">{{ $estudiante->dni }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-semibold">Fecha de Nacimiento</p>
                        <p class="text-gray-900">{{ $estudiante->fecha_nacimiento->format('d/m/Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $estudiante->fecha_nacimiento->age }} años</p>
                    </div>
                </div>
            </div>

            <!-- Información de Contacto -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2"> Información de Contacto</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
    <p class="text-sm text-gray-500 font-semibold">Email</p>
    <p class="text-gray-900">{{ $estudiante->email ?? 'No registrado' }}</p>
</div>
                    <div>
                        <p class="text-sm text-gray-500 font-semibold">Teléfono</p>
                        <p class="text-gray-900">{{ $estudiante->telefono ?? 'No registrado' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-500 font-semibold">Dirección</p>
                        <p class="text-gray-900">{{ $estudiante->direccion ?? 'No registrada' }}</p>
                    </div>
                </div>
            </div>

            <!-- Información Académica -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2"> Información Académica</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <p class="text-sm text-gray-500 font-semibold">Grado</p>
                        <p class="text-gray-900">{{ $estudiante->grado }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-semibold">Sección</p>
                        <p class="text-gray-900">{{ $estudiante->seccion }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-semibold">Estado</p>
                        <p class="text-gray-900">{{ ucfirst($estudiante->estado) }}</p>
                    </div>
                </div>
            </div>

            <!-- Observaciones -->
            @if($estudiante->observaciones)
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2"> Observaciones</h2>
                <div class="bg-gray-50 p-4 rounded">
                    <p class="text-gray-700">{{ $estudiante->observaciones }}</p>
                </div>
            </div>
            @endif

            <!-- Información del Sistema -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2"> Información del Sistema</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500 font-semibold">Fecha de Registro</p>
                        <p class="text-gray-900">{{ $estudiante->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-semibold">Última Actualización</p>
                        <p class="text-gray-900">{{ $estudiante->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex gap-4 pt-4 border-t">
                <a href="{{ route('estudiantes.edit', $estudiante) }}" class="flex-1 bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 text-center">
                    Editar Estudiante
                </a>
                <a href="{{ route('estudiantes.index') }}" class="flex-1 bg-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-400 text-center">
                    Volver a la Lista
                </a>
                <form action="{{ route('estudiantes.destroy', $estudiante) }}" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button 
                        type="submit" 
                        onclick="return confirm('¿Estás seguro de eliminar a {{ $estudiante->nombre_completo }}?')"
                        class="w-full bg-red-600 text-white py-3 rounded-lg font-semibold hover:bg-red-700"
                    >
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection