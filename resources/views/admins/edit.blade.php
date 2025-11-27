@extends('layouts.app')

@section('title', 'Editar Administrador')

@section('content')
<div class="min-h-screen py-12">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl shadow-lg mb-6">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-3">Editar Administrador</h1>
            <p class="text-lg text-gray-600">Actualice la información del administrador</p>
            <div class="w-24 h-1 bg-amber-500 mx-auto mt-4 rounded-full"></div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-amber-500 to-orange-600 px-8 py-6">
                <h2 class="text-xl font-semibold text-white">Información del Administrador</h2>
                <p class="text-amber-100 text-sm mt-1">Modifique los campos que desea actualizar</p>
            </div>

            <!-- Form -->
            <form action="{{ route('superadmin.administradores.update', ['administrador' => $admin->id]) }}" method="POST" class="p-8">
                @csrf
                @method('PUT')

                <div class="space-y-8">
                    <!-- Datos Personales -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-5 pb-2 border-b-2 border-amber-100">
                            Datos Personales
                        </h3>

                        <div class="space-y-6">
                            <!-- Nombre -->
                            <div>
                                <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nombre Completo <span class="text-red-500">*</span>
                                </label>

                                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $admin->nombre) }}"
                                    class="w-full pl-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                    required minlength="3" maxlength="50">
                                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $admin->nombre) }}"
                                    class="w-full pl-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                    required minlength="3" maxlength="50">

                                @error('nombre')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Correo Electrónico Institucional <span class="text-red-500">*</span>
                                </label>

                                <input type="email" name="email" id="email" value="{{ old('email', $admin->email) }}"
                                    class="w-full pl-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                    required maxlength="100">

                                <input type="email" name="email" id="email" value="{{ old('email', $admin->email) }}"
                                    class="w-full pl-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                    required maxlength="100">
                                @error('email')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Cambiar Contraseña -->
                    <div>

                        <h3 class="text-lg font-semibold text-gray-800 mb-5 pb-2 border-b-2 border-amber-100">Cambiar Contraseña</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Nueva Contraseña</label>
                                <input type="password" name="password" id="password" placeholder="Mínimo 8 caracteres" class="w-full pl-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl" minlength="8" maxlength="50">
                        <h3 class="text-lg font-semibold text-gray-800 mb-5 pb-2 border-b-2 border-amber-100">
                            Cambiar Contraseña
                        </h3>

                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-amber-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <div class="text-sm text-amber-800">
                                    <p class="font-semibold mb-1">Opcional</p>
                                    <p>Deje los campos en blanco si no desea cambiar la contraseña actual del administrador.</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nueva Contraseña
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </div>
                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        class="w-full pl-12 pr-12 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 focus:bg-white outline-none transition-all @error('password') border-red-400 bg-red-50 @enderror"
                                        placeholder="Mínimo 8 caracteres"
                                        minlength="8"
                                        maxlength="50"
                                    >
                                    <button
                                        type="button"
                                        onclick="togglePassword('password')"
                                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-amber-600 transition"
                                    >
                                        <svg id="eye-password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirmar Nueva Contraseña</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Repita la contraseña" class="w-full pl-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl">
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Confirmar Nueva Contraseña
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <input
                                        type="password"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        class="w-full pl-12 pr-12 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 focus:bg-white outline-none transition-all"
                                        placeholder="Repita la contraseña"
                                    >
                                    <button
                                        type="button"
                                        onclick="togglePassword('password_confirmation')"
                                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-amber-600 transition"
                                    >
                                        <svg id="eye-password_confirmation" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Permisos -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-5 pb-2 border-b-2 border-amber-100">
                            Permisos y Privilegios
                        </h3>

                        <div class="bg-gray-50 rounded-xl p-6 border-2 border-gray-200">
                            <p class="text-sm text-gray-600 mb-4">Seleccione los permisos que tendrá este administrador:</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($permisos as $key => $label)
                                    <label class="flex items-start p-4 bg-white border-2 border-gray-200 rounded-xl cursor-pointer hover:border-amber-400 hover:bg-amber-50 transition-all group">
                                        <input
                                            type="checkbox"
                                            name="permisos[]"
                                            value="{{ $key }}"
                                            {{ in_array($key, old('permisos', $admin->permisos ?? [])) ? 'checked' : '' }}
                                            class="w-5 h-5 mt-0.5 text-amber-600 border-gray-300 rounded focus:ring-2 focus:ring-amber-500 transition"
                                        >
                                        <div class="ml-3">
                                            <span class="text-sm font-medium text-gray-800 group-hover:text-amber-700">{{ $label }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-5 pb-2 border-b-2 border-amber-100">Permisos y Privilegios</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($permisos as $key => $label)
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="permisos[]" value="{{ $key }}" {{ in_array($key, old('permisos', $admin->permisos ?? [])) ? 'checked' : '' }}>
                                    <span>{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                        </div>
                    </div>

                <!-- Botones de acción -->
                <div class="flex flex-col sm:flex-row gap-4 mt-10 pt-6 border-t-2 border-gray-100">
                    <button
                        type="submit"
                        class="flex-1 bg-gradient-to-r from-amber-500 to-orange-600 text-white py-4 rounded-xl font-semibold hover:from-amber-600 hover:to-orange-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Actualizar Información
                    </button>
                    <a
                        href="{{ route('admins.index') }}"
                        class="flex-1 bg-white text-gray-700 py-4 rounded-xl font-semibold border-2 border-gray-300 hover:bg-gray-50 hover:border-gray-400 transition-all flex items-center justify-center"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancelar
                    </a>
                    <!-- Botones -->
                    <div class="flex flex-col sm:flex-row gap-4 mt-10 pt-6 border-t-2 border-gray-100">
                        <button type="submit" class="flex-1 bg-gradient-to-r from-amber-500 to-orange-600 text-white py-4 rounded-xl font-semibold">Actualizar Información</button>
                        <a href="{{ route('superadmin.administradores.index') }}" class="flex-1 bg-white text-gray-700 py-4 rounded-xl font-semibold border-2 border-gray-300">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    input.type = input.type === 'password' ? 'text' : 'password';
    const eye = document.getElementById('eye-' + inputId);

    if (input.type === 'password') {
        input.type = 'text';
    } else {
        input.type = 'password';
    }
}
</script>
@endpush
@endsection
