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
                                @error('password')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirmar Nueva Contraseña</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Repita la contraseña" class="w-full pl-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl">
                            </div>
                        </div>

                    <!-- Permisos -->
                    <div>
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

                    <!-- Botones -->
                    <div class="flex flex-col sm:flex-row gap-4 mt-10 pt-6 border-t-2 border-gray-100">
                        <button type="submit" class="flex-1 bg-gradient-to-r from-amber-500 to-orange-600 text-white py-4 rounded-xl font-semibold">Actualizar Información</button>
                        <a href="{{ route('superadmin.administradores.index') }}" class="flex-1 bg-white text-gray-700 py-4 rounded-xl font-semibold border-2 border-gray-300">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@push('scripts')
<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>
@endpush
@endsection
