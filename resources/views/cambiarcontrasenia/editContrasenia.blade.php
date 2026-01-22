@extends('layouts.app')

@section('title', 'Cambiar Contraseña')

@section('content')
<div class="max-w-lg mx-auto my-10 bg-white p-8 rounded-xl shadow-lg border border-blue-200">

    <!-- Encabezado -->
    <div class="mb-6 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 mx-auto bg-gradient-to-tr from-blue-400 to-blue-600 text-white rounded-full shadow-md mb-3">
            <i class="bi bi-key text-2xl"></i>
        </div>
        <h1 class="text-2xl font-bold text-blue-800">Cambiar Contraseña</h1>
        <p class="text-blue-600 text-sm mt-1">Actualiza tu contraseña de manera segura</p>
    </div>

    <!-- Mensaje de éxito -->
    @if (session('success'))
        <div class="bg-blue-100 text-blue-800 p-3 rounded mb-4 border border-blue-300 flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Mensaje de error -->
    @if (session('error'))
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4 border border-red-300 flex items-center gap-2">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <form action="{{ route('cambiarcontrasenia.update') }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-semibold text-blue-700 mb-1">Contraseña actual</label>
            <input type="password" name="current_password" class="w-full border border-blue-200 rounded px-4 py-2 focus:ring-1 focus:ring-blue-400 focus:border-blue-400 transition" required>
            @error('current_password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-blue-700 mb-1">Nueva contraseña</label>
            <input type="password" name="new_password" class="w-full border border-blue-200 rounded px-4 py-2 focus:ring-1 focus:ring-blue-400 focus:border-blue-400 transition" required>
            @error('new_password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-blue-700 mb-1">Confirmar nueva contraseña</label>
            <input type="password" name="new_password_confirmation" class="w-full border border-blue-200 rounded px-4 py-2 focus:ring-1 focus:ring-blue-400 focus:border-blue-400 transition" required>
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white py-2 rounded-lg font-semibold shadow-md transition transform hover:-translate-y-0.5">
            Actualizar contraseña
        </button>
    </form>
</div>
@endsection
