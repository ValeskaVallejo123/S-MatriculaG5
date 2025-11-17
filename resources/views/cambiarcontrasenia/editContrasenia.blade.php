@extends('layouts.app')

@section('title', 'Cambiar Contraseña')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white p-10 rounded-2xl shadow-lg border border-gray-200">
        <h1 class="text-3xl font-bold text-gray-900 mb-8 text-center">
            Cambiar Contraseña
        </h1>

        <!-- Mensajes de éxito y error -->
        @if (session('success'))
            <div class="bg-green-50 text-green-800 p-4 rounded-lg mb-5 border-l-4 border-green-500 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 text-red-800 p-4 rounded-lg mb-5 border-l-4 border-red-500 shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        <!-- Formulario -->
        <form action="{{ route('cambiarcontrasenia.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Contraseña actual</label>
                <input type="password" name="current_password" placeholder="Ingrese su contraseña actual"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition duration-200" required>
                @error('current_password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nueva contraseña</label>
                <input type="password" name="new_password" placeholder="Ingrese la nueva contraseña"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition duration-200" required>
                @error('new_password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Confirmar nueva contraseña</label>
                <input type="password" name="new_password_confirmation" placeholder="Repita la nueva contraseña"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition duration-200" required>
            </div>

            <button type="submit"
                class="w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white py-3 rounded-xl font-semibold shadow-md transition-all duration-300">
                Actualizar Contraseña
            </button>
        </form>
    </div>
</div>

@push('styles')
<style>
    /* Animación sutil en inputs y botón */
    input:focus {
        transform: scale(1.01);
    }

    button:hover {
        transform: translateY(-2px);
    }
</style>
@endpush
@endsection
