@extends('layouts.app')

@section('title', 'Editar Estudiante')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">✏️ Editar Estudiante</h1>
        
        <form action="{{ route('estudiantes.update', $estudiante) }}" method="POST" class="space-y-6">
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
                            value="{{ old('nombre', $estudiante->nombre) }}"
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
                            value="{{ old('apellido', $estudiante->apellido) }}"
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
                            value="{{ old('dni', $estudiante->dni) }}"
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
                            value="{{ old('fecha_nacimiento', $estudiante->fecha_nacimiento->format('Y-m-d')) }}"
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
        value="{{ old('email', $estudiante->email) }}"
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
                            value="{{ old('telefono', $estudiante->telefono) }}"
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
                        >{{ old('direccion', $estudiante->direccion) }}</textarea>
                        @error('direccion')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Información Académica -->
            <div class="border-b pb-4">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Información Académica</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block font-semibold mb-2">Grado *</label>
                        <select 
                            name="grado" 
                            class="w-full px-4 py-2 border rounded @error('grado') border-red-500 @enderror" 
                            required
                        >
                            <option value="">Seleccione...</option>
                            @foreach($grados as $grado)
                                <option value="{{ $grado }}" {{ old('grado', $estudiante->grado) == $grado ? 'selected' : '' }}>
                                    {{ $grado }}
                                </option>
                            @endforeach
                        </select>
                        @error('grado')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-semibold mb-2">Sección *</label>
                        <select 
                            name="seccion" 
                            class="w-full px-4 py-2 border rounded @error('seccion') border-red-500 @enderror" 
                            required
                        >
                            <option value="">Seleccione...</option>
                            @foreach($secciones as $seccion)
                                <option value="{{ $seccion }}" {{ old('seccion', $estudiante->seccion) == $seccion ? 'selected' : '' }}>
                                    {{ $seccion }}
                                </option>
                            @endforeach
                        </select>
                        @error('seccion')
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
                            <option value="activo" {{ old('estado', $estudiante->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ old('estado', $estudiante->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
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
                    placeholder="Información adicional sobre el estudiante..."
                >{{ old('observaciones', $estudiante->observaciones) }}</textarea>
                @error('observaciones')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botones -->
            <div class="flex gap-4 pt-4">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700">
                    Actualizar Estudiante
                </button>
                <a href="{{ route('estudiantes.index') }}" class="flex-1 bg-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-400 text-center leading-[3rem]">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection