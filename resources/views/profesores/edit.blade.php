@extends('layouts.app')

@section('title', 'Editar Profesor')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800"> Editar Profesor</h1>
        
        <form action="{{ route('profesores.update', $profesor) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Información Personal -->
            <div class="border-b pb-4">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Información Personal</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold mb-2">Nombre *</label>
                        <input 
                            type="text" 
                            name="nombre" 
                            value="{{ old('nombre', $profesor->nombre) }}"
                            class="w-full px-4 py-2 border rounded @error('nombre') border-red-500 @enderror" 
                            required
                        >
                        @error('nombre')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-semibold mb-2">Apellido *</label>
                        <input 
                            type="text" 
                            name="apellido" 
                            value="{{ old('apellido', $profesor->apellido) }}"
                            class="w-full px-4 py-2 border rounded @error('apellido') border-red-500 @enderror" 
                            required
                        >
                        @error('apellido')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-semibold mb-2">DNI *</label>
                        <input 
                            type="text" 
                            name="dni" 
                            value="{{ old('dni', $profesor->dni) }}"
                            class="w-full px-4 py-2 border rounded @error('dni') border-red-500 @enderror" 
                            required
                        >
                        @error('dni')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-semibold mb-2">Fecha de Nacimiento *</label>
                        <input 
                            type="date" 
                            name="fecha_nacimiento" 
                            value="{{ old('fecha_nacimiento', optional($profesor->fecha_nacimiento)->format('Y-m-d')) }}"
                            class="w-full px-4 py-2 border rounded @error('fecha_nacimiento') border-red-500 @enderror" 
                            required
                        >
                        @error('fecha_nacimiento')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Información de Contacto -->
            <div class="border-b pb-4">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Información de Contacto</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold mb-2">Email</label>
                        <input 
                            type="email" 
                            name="email" 
                            value="{{ old('email', $profesor->email) }}"
                            class="w-full px-4 py-2 border rounded @error('email') border-red-500 @enderror"
                        >
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-semibold mb-2">Teléfono</label>
                        <input 
                            type="text" 
                            name="telefono" 
                            value="{{ old('telefono', $profesor->telefono) }}"
                            class="w-full px-4 py-2 border rounded @error('telefono') border-red-500 @enderror"
                        >
                        @error('telefono')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block font-semibold mb-2">Dirección</label>
                        <textarea 
                            name="direccion" 
                            rows="2"
                            class="w-full px-4 py-2 border rounded @error('direccion') border-red-500 @enderror"
                        >{{ old('direccion', $profesor->direccion) }}</textarea>
                        @error('direccion')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Información Profesional -->
            <div class="border-b pb-4">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Información Profesional</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold mb-2">Especialidad *</label>
                        <select 
                            name="especialidad" 
                            class="w-full px-4 py-2 border rounded @error('especialidad') border-red-500 @enderror" 
                            required
                        >
                            <option value="">Seleccione...</option>
                            @foreach($especialidades as $especialidad)
                                <option value="{{ $especialidad }}" {{ old('especialidad', $profesor->especialidad) == $especialidad ? 'selected' : '' }}>
                                    {{ $especialidad }}
                                </option>
                            @endforeach
                        </select>
                        @error('especialidad')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-semibold mb-2">Tipo de Contrato *</label>
                        <select 
                            name="tipo_contrato" 
                            class="w-full px-4 py-2 border rounded @error('tipo_contrato') border-red-500 @enderror" 
                            required
                        >
                            <option value="">Seleccione...</option>
                            @foreach($tiposContrato as $key => $label)
                                <option value="{{ $key }}" {{ old('tipo_contrato', $profesor->tipo_contrato) == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('tipo_contrato')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-semibold mb-2">Salario (Lps)</label>
                        <input 
                            type="number" 
                            name="salario" 
                            value="{{ old('salario', $profesor->salario) }}"
                            step="0.01"
                            min="0"
                            class="w-full px-4 py-2 border rounded @error('salario') border-red-500 @enderror"
                        >
                        @error('salario')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-semibold mb-2">Fecha de Ingreso *</label>
                        <input 
                            type="date" 
                            name="fecha_ingreso" 
                            value="{{ old('fecha_ingreso', optional($profesor->fecha_ingreso)->format('Y-m-d')) }}"
                            class="w-full px-4 py-2 border rounded @error('fecha_ingreso') border-red-500 @enderror" 
                            required
                        >
                        @error('fecha_ingreso')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-semibold mb-2">Estado *</label>
                        <select 
                            name="estado" 
                            class="w-full px-4 py-2 border rounded @error('estado') border-red-500 @enderror" 
                            required
                        >
                            <option value="activo" {{ old('estado', $profesor->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ old('estado', $profesor->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                            <option value="licencia" {{ old('estado', $profesor->estado) == 'licencia' ? 'selected' : '' }}>Licencia</option>
                        </select>
                        @error('estado')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Observaciones -->
            <div>
                <label class="block font-semibold mb-2">Observaciones</label>
                <textarea 
                    name="observaciones" 
                    rows="3"
                    class="w-full px-4 py-2 border rounded @error('observaciones') border-red-500 @enderror"
                    placeholder="Información adicional sobre el profesor..."
                >{{ old('observaciones', $profesor->observaciones) }}</textarea>
                @error('observaciones')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botones -->
            <div class="flex gap-4 pt-4">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700">
                    Actualizar Profesor
                </button>
                <a href="{{ route('profesores.index') }}" class="flex-1 bg-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-400 text-center leading-[3rem]">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection