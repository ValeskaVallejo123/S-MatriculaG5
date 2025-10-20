@extends('layouts.app')

@section('title', 'Detalles del Profesor')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-white">{{ $profesor->nombre_completo }}</h1>
                    <p class="text-purple-100 mt-1">{{ $profesor->especialidad ?? 'Sin especialidad' }}</p>
                </div>
                <div>
                    @if($profesor->estado === 'activo')
                        <span class="px-4 py-2 bg-green-500 text-white rounded-full text-sm font-semibold">✓ Activo</span>
                    @elseif($profesor->estado === 'licencia')
                        <span class="px-4 py-2 bg-yellow-500 text-white rounded-full text-sm font-semibold">⚠ Licencia</span>
                    @else
                        <span class="px-4 py-2 bg-red-500 text-white rounded-full text-sm font-semibold">✗ Inactivo</span>
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
                        <p class="text-gray-900">{{ $profesor->nombre ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-semibold">Apellido</p>
                        <p class="text-gray-900">{{ $profesor->apellido ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-semibold">DNI</p>
                        <p class="text-gray-900">{{ $profesor->dni ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-semibold">Fecha de Nacimiento</p>
                        @if($profesor->fecha_nacimiento)
                            <p class="text-gray-900">{{ $profesor->fecha_nacimiento->format('d/m/Y') }}</p>
                            <p class="text-xs text-gray-500">{{ $profesor->fecha_nacimiento->age }} años</p>
                        @else
                            <p class="text-gray-900">No registrada</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Información de Contacto -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2"> Información de Contacto</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500 font-semibold">Email</p>
                        <p class="text-gray-900">{{ $profesor->email ?? 'No registrado' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-semibold">Teléfono</p>
                        <p class="text-gray-900">{{ $profesor->telefono ?? 'No registrado' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-500 font-semibold">Dirección</p>
                        <p class="text-gray-900">{{ $profesor->direccion ?? 'No registrada' }}</p>
                    </div>
                </div>
            </div>

            <!-- Información Profesional -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2"> Información Profesional</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500 font-semibold">Especialidad</p>
                        <p class="text-gray-900">{{ $profesor->especialidad ?? 'No especificada' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-semibold">Tipo de Contrato</p>
                        <p class="text-gray-900">{{ $profesor->tipo_contrato ? ucwords(str_replace('_', ' ', $profesor->tipo_contrato)) : 'No especificado' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-semibold">Salario</p>
                        <p class="text-gray-900">{{ $profesor->salario ? 'Lps ' . number_format($profesor->salario, 2) : 'No especificado' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-semibold">Fecha de Ingreso</p>
                        @if($profesor->fecha_ingreso)
                            <p class="text-gray-900">{{ $profesor->fecha_ingreso->format('d/m/Y') }}</p>
                            <p class="text-xs text-gray-500">{{ $profesor->fecha_ingreso->diffForHumans() }}</p>
                        @else
                            <p class="text-gray-900">No registrada</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-semibold">Estado</p>
                        <p class="text-gray-900">{{ $profesor->estado ? ucfirst($profesor->estado) : 'No especificado' }}</p>
                    </div>
                </div>
            </div>

            <!-- Observaciones -->
            @if($profesor->observaciones)
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2"> Observaciones</h2>
                <div class="bg-gray-50 p-4 rounded">
                    <p class="text-gray-700">{{ $profesor->observaciones }}</p>
                </div>
            </div>
            @endif

            <!-- Información del Sistema -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2"> Información del Sistema</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500 font-semibold">Fecha de Registro</p>
                        <p class="text-gray-900">{{ $profesor->created_at ? $profesor->created_at->format('d/m/Y H:i') : 'No disponible' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-semibold">Última Actualización</p>
                        <p class="text-gray-900">{{ $profesor->updated_at ? $profesor->updated_at->format('d/m/Y H:i') : 'No disponible' }}</p>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex gap-4 pt-4 border-t">
                <a href="{{ route('profesores.edit', $profesor) }}" class="flex-1 bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 text-center">
                    Editar Profesor
                </a>
                <a href="{{ route('profesores.index') }}" class="flex-1 bg-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-400 text-center">
                    Volver a la Lista
                </a>
                <form action="{{ route('profesores.destroy', $profesor) }}" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button 
                        type="submit" 
                        onclick="return confirm('¿Estás seguro de eliminar a {{ $profesor->nombre_completo }}?')"
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