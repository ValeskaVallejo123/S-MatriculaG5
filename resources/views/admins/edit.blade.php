@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-8">
    <h1 class="text-3xl font-bold mb-6">Editar Administrador</h1>
    
    <form action="{{ route('admins.update', $admin) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        
        <div>
            <label class="block font-semibold mb-2">Nombre Completo</label>
            <input 
                type="text" 
                name="nombre" 
                value="{{ old('nombre', $admin->nombre) }}" 
                class="w-full px-4 py-2 border rounded @error('nombre') border-red-500 @enderror" 
                required
            >
            @error('nombre')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-semibold mb-2">Email</label>
            <input 
                type="email" 
                name="email" 
                value="{{ old('email', $admin->email) }}" 
                class="w-full px-4 py-2 border rounded @error('email') border-red-500 @enderror" 
                required
            >
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-semibold mb-2">Nueva Contraseña (dejar vacío si no desea cambiarla)</label>
            <input 
                type="password" 
                name="password" 
                class="w-full px-4 py-2 border rounded @error('password') border-red-500 @enderror" 
                minlength="8"
            >
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-semibold mb-2">Confirmar Nueva Contraseña</label>
            <input 
                type="password" 
                name="password_confirmation" 
                class="w-full px-4 py-2 border rounded"
            >
        </div>

        <div>
            <label class="block font-semibold mb-3">Permisos de Administrador</label>
            <div class="grid grid-cols-2 gap-2">
                @foreach($permisos as $key => $label)
                    <label class="flex items-center p-2 border rounded hover:bg-gray-50">
                        <input 
                            type="checkbox" 
                            name="permisos[]" 
                            value="{{ $key }}" 
                            {{ in_array($key, old('permisos', $admin->permisos ?? [])) ? 'checked' : '' }}
                            class="mr-2"
                        >
                        <span class="text-sm">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-indigo-600 text-white py-3 rounded font-semibold hover:bg-indigo-700">
                Actualizar Administrador
            </button>
            <a href="{{ route('admins.index') }}" class="flex-1 bg-gray-300 text-gray-700 py-3 rounded font-semibold hover:bg-gray-400 text-center leading-[3rem]">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection