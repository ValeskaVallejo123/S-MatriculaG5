@extends('layouts.app')

@section('title', 'Permisos por Rol')
@section('page-title', 'Gestión de Permisos')
@section('page-subtitle', 'Visualiza los permisos asignados a cada rol del sistema')

@section('content')
<div class="p-6 space-y-6">

    <!-- Header con descripción -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-900">Sistema de Permisos y Roles</h3>
                <p class="text-sm text-gray-600 mt-1">
                    Este sistema utiliza un modelo de permisos basado en roles. Cada usuario tiene asignado un rol que determina sus capacidades dentro del sistema.
                </p>
            </div>
        </div>

    <!-- Cards de Roles -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- SUPER ADMIN -->
        <div class="bg-gradient-to-br from-red-50 to-orange-50 rounded-xl shadow-lg border-2 border-red-200 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-red-500 to-orange-500 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Super Administrador</h3>
                            <p class="text-red-100 text-sm">Acceso Total al Sistema</p>
                        </div>
                    </div>
                    <span class="bg-white text-red-600 text-xs font-bold px-3 py-1 rounded-full">MÁXIMO</span>
                </div>
            </div>

            <!-- Body -->
            <div class="p-6 space-y-4">
                <div class="bg-white rounded-lg p-4 border border-red-200">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <h4 class="font-semibold text-gray-900">Capacidades Especiales</h4>
                    </div>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Acceso completo a <strong>todas las funciones</strong> del sistema</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Puede <strong>crear, editar y eliminar administradores</strong></span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Asigna y modifica <strong>permisos de otros usuarios</strong></span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Acceso a <strong>configuración del sistema</strong></span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Gestiona <strong>periodos académicos y cupos</strong></span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Visualiza <strong>todas las estadísticas y reportes</strong></span>
                        </li>
                    </ul>
                </div>

                <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-red-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-red-800">Importante</p>
                            <p class="text-xs text-red-700 mt-1">Este rol debe ser asignado solo a usuarios de máxima confianza ya que tiene control total sobre el sistema.</p>
                        </div>
                    </div>
                </div>
            @empty
                <p class="empty">No hay datos disponibles</p>
            @endforelse
        </div>

        <!-- ADMIN -->
        <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl shadow-lg border-2 border-blue-200 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-primary-400 to-accent-300 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Administrador</h3>
                            <p class="text-blue-100 text-sm">Permisos Personalizables</p>
                        </div>
                    </div>
                    <span class="bg-white text-primary-400 text-xs font-bold px-3 py-1 rounded-full">LIMITADO</span>
                </div>
            </div>

            <!-- Body -->
            <div class="p-6 space-y-4">
                <div class="bg-white rounded-lg p-4 border border-blue-200">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <h4 class="font-semibold text-gray-900">Permisos Disponibles</h4>
                    </div>
                    <p class="text-xs text-gray-600 mb-3">El Super Admin puede asignar los siguientes permisos:</p>

                    <div class="grid grid-cols-1 gap-2">
                        @foreach($permisos as $key => $nombre)
                        <div class="flex items-center gap-2 p-2 bg-gray-50 rounded-lg hover:bg-blue-50 transition">
                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm text-gray-700">{{ $nombre }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-200">
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-yellow-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-yellow-800">Restricciones</p>
                            <ul class="text-xs text-yellow-700 mt-1 space-y-1">
                                <li>• No puede gestionar otros administradores</li>
                                <li>• No tiene acceso a configuración del sistema</li>
                                <li>• Solo puede realizar acciones según permisos asignados</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Tabla Comparativa -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-primary-400 to-primary-300 px-6 py-4">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                <h3 class="text-lg font-bold text-white">Tabla Comparativa de Permisos</h3>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Módulo / Función
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Super Admin
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Admin
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Dashboard -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            Dashboard
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </td>
                    </tr>

                    <!-- Gestionar Administradores -->
                    <tr class="hover:bg-gray-50 bg-red-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            Gestionar Administradores
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <svg class="w-5 h-5 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </td>
                    </tr>

                    @foreach($permisos as $key => $nombre)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $nombre }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Configurable
                            </span>
                        </td>
                    </tr>
                    @endforeach

                    <!-- Configuración del Sistema -->
                    <tr class="hover:bg-gray-50 bg-red-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            Configuración del Sistema
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <svg class="w-5 h-5 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </td>
                    </tr>

                    <!-- Cambiar Contraseña -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            Cambiar Contraseña (propia)
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Botón para volver -->
    <div class="flex justify-end">
        <a href="{{ route('admins.index') }}"
           class="inline-flex items-center gap-2 px-6 py-3 bg-primary-400 text-white rounded-lg hover:bg-primary-500 transition shadow-lg hover:shadow-xl">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            Gestionar Administradores
        </a>
    </div>

</div>
@endsection
