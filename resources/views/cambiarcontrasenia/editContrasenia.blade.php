@extends('layouts.app')

@section('title', 'Cambiar Contraseña')

@section('content')
    <div class="max-w-lg mx-auto my-10 bg-white p-8 rounded-xl shadow-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">
            <i class="bi bi-key"></i> Cambiar Contraseña
        </h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4 border border-green-300">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4 border border-red-300">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('cambiarcontrasenia.update') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-gray-700">Contraseña actual</label>
                <input type="password" name="current_password" class="w-full border rounded px-4 py-2" required>
                @error('current_password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700">Nueva contraseña</label>
                <input type="password" name="new_password" class="w-full border rounded px-4 py-2" required>
                @error('new_password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700">Confirmar nueva contraseña</label>
                <input type="password" name="new_password_confirmation" class="w-full border rounded px-4 py-2" required>
            </div>

            <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded-lg font-semibold">
                Actualizar contraseña
            </button>
        </form>
    </div>
@endsection

