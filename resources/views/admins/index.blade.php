@extends('layouts.app')

@section('title', 'Permisos por Rol')
@section('page-title', 'Gestión de Permisos')
@section('page-subtitle', 'Visualiza los permisos asignados a cada rol del sistema')

@section('content')
<div class="p-6 space-y-6">

    {{-- ===== ENCABEZADO ===== --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-xl flex items-center justify-center flex-shrink-0" style="background: linear-gradient(135deg, #003b73, #00508f);">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold" style="color: #003b73;">Sistema de Roles y Permisos</h2>
                <p class="text-sm text-gray-500 mt-1">El sistema maneja <strong>4 roles</strong> con permisos específicos. Cada usuario tiene un rol que define exactamente qué puede hacer.</p>
            </div>
        </div>
    </div>

    {{-- ===== RESUMEN DE ROLES (4 CARDS) ===== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        {{-- Super Admin --}}
        <div class="bg-white rounded-xl border-2 border-red-200 p-5 text-center hover:shadow-lg transition-shadow">
            <div class="w-12 h-12 mx-auto rounded-full flex items-center justify-center mb-3" style="background: linear-gradient(135deg, #ef4444, #f97316);">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <h4 class="font-bold text-gray-900">Super Admin</h4>
            <p class="text-xs text-gray-500 mt-1">Control total del sistema</p>
            <span class="inline-block mt-2 text-xs font-bold px-3 py-1 rounded-full bg-red-100 text-red-700">ACCESO COMPLETO</span>
        </div>

        {{-- Administrador --}}
        <div class="bg-white rounded-xl border-2 border-blue-200 p-5 text-center hover:shadow-lg transition-shadow">
            <div class="w-12 h-12 mx-auto rounded-full flex items-center justify-center mb-3" style="background: linear-gradient(135deg, #003b73, #00508f);">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <h4 class="font-bold text-gray-900">Administrador</h4>
            <p class="text-xs text-gray-500 mt-1">Gestión académica y operativa</p>
            <span class="inline-block mt-2 text-xs font-bold px-3 py-1 rounded-full bg-blue-100 text-blue-700">CONFIGURABLE</span>
        </div>

        {{-- Profesor --}}
        <div class="bg-white rounded-xl border-2 border-green-200 p-5 text-center hover:shadow-lg transition-shadow">
            <div class="w-12 h-12 mx-auto rounded-full flex items-center justify-center mb-3" style="background: linear-gradient(135deg, #059669, #10b981);">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <h4 class="font-bold text-gray-900">Profesor</h4>
            <p class="text-xs text-gray-500 mt-1">Gestión de clases y notas</p>
            <span class="inline-block mt-2 text-xs font-bold px-3 py-1 rounded-full bg-green-100 text-green-700">ACADÉMICO</span>
        </div>

        {{-- Padre --}}
        <div class="bg-white rounded-xl border-2 border-amber-200 p-5 text-center hover:shadow-lg transition-shadow">
            <div class="w-12 h-12 mx-auto rounded-full flex items-center justify-center mb-3" style="background: linear-gradient(135deg, #d97706, #f59e0b);">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <h4 class="font-bold text-gray-900">Padre/Tutor</h4>
            <p class="text-xs text-gray-500 mt-1">Consulta de información</p>
            <span class="inline-block mt-2 text-xs font-bold px-3 py-1 rounded-full bg-amber-100 text-amber-700">SOLO LECTURA</span>
        </div>
    </div>

    {{-- ===== DETALLE POR ROL ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- ==================== SUPER ADMIN ==================== --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4" style="background: linear-gradient(135deg, #ef4444, #f97316);">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white">Super Administrador</h3>
                            <p class="text-xs text-red-100">Acceso total — sin restricciones</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-6 space-y-4">
                {{-- Exclusivos --}}
                <div>
                    <h5 class="text-xs font-bold text-red-600 uppercase tracking-wider mb-3">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Permisos Exclusivos
                    </h5>
                    <div class="space-y-2">
                        <div class="flex items-center gap-3 p-3 bg-red-50 rounded-lg border border-red-100">
                            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-sm text-gray-800">Crear, editar y eliminar <strong>administradores</strong></span>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-red-50 rounded-lg border border-red-100">
                            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-sm text-gray-800">Asignar y modificar <strong>permisos de otros usuarios</strong></span>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-red-50 rounded-lg border border-red-100">
                            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-sm text-gray-800">Acceso a <strong>configuración del sistema</strong></span>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-red-50 rounded-lg border border-red-100">
                            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-sm text-gray-800">Gestionar <strong>periodos académicos y cupos</strong></span>
                        </div>
                    </div>
                </div>
                {{-- También tiene --}}
                <div>
                    <h5 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">
                        También tiene acceso a
                    </h5>
                    <div class="space-y-2">
                        <div class="flex items-center gap-3 p-2 rounded-lg">
                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-sm text-gray-600">Todas las funciones del <strong>Administrador</strong></span>
                        </div>
                        <div class="flex items-center gap-3 p-2 rounded-lg">
                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-sm text-gray-600">Dashboard completo con todas las estadísticas</span>
                        </div>
                        <div class="flex items-center gap-3 p-2 rounded-lg">
                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-sm text-gray-600">Reportes y exportaciones generales</span>
                        </div>
                    </div>
                </div>
                {{-- Advertencia --}}
                <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                    <p class="text-xs text-red-700">
                        <svg class="w-4 h-4 inline mr-1 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <strong>Importante:</strong> Asignar solo a usuarios de máxima confianza. Tiene control total sobre el sistema.
                    </p>
                </div>
            </div>
        </div>

        {{-- ==================== ADMINISTRADOR ==================== --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4" style="background: linear-gradient(135deg, #003b73, #00508f);">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white">Administrador</h3>
                            <p class="text-xs text-blue-200">Permisos configurables por el Super Admin</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-6 space-y-4">
                {{-- Permisos asignables --}}
                <div>
                    <h5 class="text-xs font-bold uppercase tracking-wider mb-3" style="color: #003b73;">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Permisos Configurables
                    </h5>
                    <div class="space-y-2">
                        @foreach($permisos as $key => $nombre)
                        <div class="flex items-center gap-3 p-3 bg-blue-50 rounded-lg border border-blue-100">
                            <svg class="w-5 h-5 flex-shrink-0" style="color: #4ec7d2;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-sm text-gray-800">{{ $nombre }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                {{-- Restricciones --}}
                <div>
                    <h5 class="text-xs font-bold text-red-500 uppercase tracking-wider mb-3">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                        No puede
                    </h5>
                    <div class="space-y-2">
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <svg class="w-4 h-4 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            <span class="text-sm text-gray-600">Gestionar otros administradores</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <svg class="w-4 h-4 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            <span class="text-sm text-gray-600">Acceder a configuración del sistema</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <svg class="w-4 h-4 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            <span class="text-sm text-gray-600">Modificar permisos de otros usuarios</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ==================== PROFESOR ==================== --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4" style="background: linear-gradient(135deg, #059669, #10b981);">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white">Profesor</h3>
                            <p class="text-xs text-green-100">Gestión académica de sus secciones</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-6 space-y-4">
                {{-- Puede --}}
                <div>
                    <h5 class="text-xs font-bold text-green-600 uppercase tracking-wider mb-3">Puede hacer</h5>
                    <div class="space-y-2">
                        <div class="flex items-center gap-3 p-3 bg-green-50 rounded-lg border border-green-100">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-sm text-gray-800">Registrar y editar <strong>calificaciones</strong> de sus secciones</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-green-50 rounded-lg border border-green-100">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-sm text-gray-800">Registrar <strong>asistencia</strong> diaria de sus alumnos</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-green-50 rounded-lg border border-green-100">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-sm text-gray-800">Ver listado de <strong>estudiantes</strong> de sus secciones</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-green-50 rounded-lg border border-green-100">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-sm text-gray-800">Registrar <strong>observaciones de comportamiento</strong></span>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-green-50 rounded-lg border border-green-100">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-sm text-gray-800">Comunicarse con <strong>padres/tutores</strong></span>
                        </div>
                    </div>
                </div>
                {{-- No puede --}}
                <div>
                    <h5 class="text-xs font-bold text-red-500 uppercase tracking-wider mb-3">No puede</h5>
                    <div class="space-y-2">
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <svg class="w-4 h-4 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            <span class="text-sm text-gray-600">Matricular o eliminar estudiantes</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <svg class="w-4 h-4 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            <span class="text-sm text-gray-600">Ver secciones que no le fueron asignadas</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <svg class="w-4 h-4 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            <span class="text-sm text-gray-600">Gestionar usuarios ni configuración</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ==================== PADRE/TUTOR ==================== --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4" style="background: linear-gradient(135deg, #d97706, #f59e0b);">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white">Padre / Tutor</h3>
                            <p class="text-xs text-amber-100">Consulta de información de sus hijos</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-6 space-y-4">
                {{-- Puede (configurable por admin) --}}
                <div>
                    <h5 class="text-xs font-bold text-amber-600 uppercase tracking-wider mb-3">Puede hacer (según permisos asignados)</h5>
                    <div class="space-y-2">
                        <div class="flex items-center gap-3 p-3 bg-amber-50 rounded-lg border border-amber-100">
                            <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-sm text-gray-800">Ver <strong>calificaciones</strong> de sus hijos</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-amber-50 rounded-lg border border-amber-100">
                            <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-sm text-gray-800">Ver <strong>asistencias</strong> de sus hijos</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-amber-50 rounded-lg border border-amber-100">
                            <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-sm text-gray-800">Ver reportes de <strong>comportamiento</strong></span>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-amber-50 rounded-lg border border-amber-100">
                            <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-sm text-gray-800"><strong>Descargar boletas</strong> y reportes académicos</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-amber-50 rounded-lg border border-amber-100">
                            <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-sm text-gray-800"><strong>Comunicarse</strong> con profesores</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-amber-50 rounded-lg border border-amber-100">
                            <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-sm text-gray-800">Recibir <strong>notificaciones</strong> por email</span>
                        </div>
                    </div>
                </div>
                {{-- No puede --}}
                <div>
                    <h5 class="text-xs font-bold text-red-500 uppercase tracking-wider mb-3">No puede</h5>
                    <div class="space-y-2">
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <svg class="w-4 h-4 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            <span class="text-sm text-gray-600">Editar calificaciones ni asistencias</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <svg class="w-4 h-4 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            <span class="text-sm text-gray-600">Ver información de otros estudiantes</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <svg class="w-4 h-4 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            <span class="text-sm text-gray-600">Acceder a módulos administrativos</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== TABLA COMPARATIVA ===== --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4" style="background: linear-gradient(135deg, #003b73, #00508f);">
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Módulo / Función</th>
                        <th class="px-4 py-3 text-center text-xs font-medium uppercase tracking-wider" style="color: #ef4444;">Super Admin</th>
                        <th class="px-4 py-3 text-center text-xs font-medium uppercase tracking-wider" style="color: #003b73;">Admin</th>
                        <th class="px-4 py-3 text-center text-xs font-medium uppercase tracking-wider" style="color: #059669;">Profesor</th>
                        <th class="px-4 py-3 text-center text-xs font-medium uppercase tracking-wider" style="color: #d97706;">Padre</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">

                    {{-- Dashboard --}}
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 text-sm font-medium text-gray-900">Dashboard</td>
                        <td class="px-4 py-3 text-center"><svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></td>
                        <td class="px-4 py-3 text-center"><svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></td>
                        <td class="px-4 py-3 text-center"><svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></td>
                        <td class="px-4 py-3 text-center"><svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></td>
                    </tr>

                    {{-- Gestionar Administradores --}}
                    <tr class="hover:bg-gray-50 bg-red-50">
                        <td class="px-6 py-3 text-sm font-medium text-gray-900">Gestionar Administradores</td>
                        <td class="px-4 py-3 text-center"><svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></td>
                        <td class="px-4 py-3 text-center"><svg class="w-5 h-5 text-red-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></td>
                        <td class="px-4 py-3 text-center"><svg class="w-5 h-5 text-red-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></td>
                        <td class="px-4 py-3 text-center"><svg class="w-5 h-5 text-red-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></td>
                    </tr>

                    {{-- Asignar Permisos --}}
                    <tr class="hover:bg-gray-50 bg-red-50">
                        <td class="px-6 py-3 text-sm font-medium text-gray-900">Asignar Permisos</td>
                        <td class="px-4 py-3 text-center"><svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></td>
                        <td class="px-4 py-3 text-center"><svg class="w-5 h-5 text-red-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></td>
                        <td class="px-4 py-3 text-center"><svg class="w-5 h-5 text-red-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></td>
                        <td class="px-4 py-3 text-center"><svg class="w-5 h-5 text-red-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></td>
                    </tr>

                    {{-- Configuración del Sistema --}}
                    <tr class="hover:bg-gray-50 bg-red-50">
                        <td class="px-6 py-3 text-sm font-medium text-gray-900">Configuración del Sistema</td>
                        <td class="px-4 py-3 text-center"><svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></td>
                        <td class="px-4 py-3 text-center"><svg class="w-5 h-5 text-red-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></td>
                        <td class="px-4 py-3 text-center"><svg class="w-5 h-5 text-red-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></td>
                        <td class="px-4 py-3 text-center"><svg class="w-5 h-5 text-red-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></td>
                    </tr>

                    {{-- Permisos configurables del Admin --}}
                    @foreach($permisos as $key => $nombre)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 text-sm font-medium text-gray-900">{{ $nombre }}</td>
                        <td class="px-4 py-3 text-center"><svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></td>
                        <td class="px-4 py-3 text-center"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">Configurable</span></td>
                        <td class="px-4 py-3 text-center">
                            @if(in_array($key, ['gestionar_calificaciones', 'gestionar_asistencias', 'gestionar_estudiantes']))
                                <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            @else
                                <svg class="w-5 h-5 text-red-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center"><svg class="w-5 h-5 text-red-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></td>
                    </tr>
                    @endforeach

                    {{-- Ver calificaciones (hijo) --}}
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 text-sm font-medium text-gray-900">Ver calificaciones (de sus hijos)</td>
                        <td class="px-4 py-3 text-center"><svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></td>
                        <td class="px-4 py-3 text-center"><svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></td>
                        <td class="px-4 py-3 text-center"><svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></td>
                        <td class="px-4 py-3 text-center"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">Configurable</span></td>
                    </tr>

                    {{-- Ver asistencias (hijo) --}}
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 text-sm font-medium text-gray-900">Ver asistencias (de sus hijos)</td>
                        <td class="px-4 py-3 text-center"><svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></td>
                        <td class="px-4 py-3 text-center"><svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></td>
                        <td class="px-4 py-3 text-center"><svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></td>
                        <td class="px-4 py-3 text-center"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">Configurable</span></td>
                    </tr>

                    {{-- Descargar boletas --}}
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 text-sm font-medium text-gray-900">Descargar boletas</td>
                        <td class="px-4 py-3 text-center"><svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></td>
                        <td class="px-4 py-3 text-center"><svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></td>
                        <td class="px-4 py-3 text-center"><svg class="w-5 h-5 text-red-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></td>
                        <td class="px-4 py-3 text-center"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">Configurable</span></td>
                    </tr>

                    {{-- Cambiar contraseña --}}
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 text-sm font-medium text-gray-900">Cambiar contraseña (propia)</td>
                        <td class="px-4 py-3 text-center"><svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></td>
                        <td class="px-4 py-3 text-center"><svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></td>
                        <td class="px-4 py-3 text-center"><svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></td>
                        <td class="px-4 py-3 text-center"><svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></td>
                    </tr>

                </tbody>
            </table>
        </div>

        {{-- Leyenda --}}
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            <div class="flex flex-wrap items-center gap-6 text-xs text-gray-600">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Tiene acceso</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    <span>Sin acceso</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">Configurable</span>
                    <span>El Super Admin decide si activarlo</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">Configurable</span>
                    <span>El Admin decide si activarlo para el padre</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Botón para volver --}}
    <div class="flex justify-end">
        <a href="{{ route('admins.index') }}" 
           class="inline-flex items-center gap-2 px-6 py-3 text-white rounded-lg transition shadow-lg hover:shadow-xl" style="background: linear-gradient(135deg, #003b73, #00508f);">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            Gestionar Administradores
        </a>
    </div>

</div>
@endsection