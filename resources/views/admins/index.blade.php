<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Sistema Escolar</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': {
                            50: '#bfd9ea',
                            100: '#aec9e4',
                            200: '#afc5dd',
                            300: '#00508f',
                            400: '#003b73',
                            500: '#07196b',
                        },
                        'accent': {
                            100: '#4dcdcc',
                            200: '#50cbd2',
                            300: '#4ec7d2',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js para interactividad -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* Scrollbar personalizado */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #4ec7d2;
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #00508f;
        }

        /* Badge con animación */
        .badge-new {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: .5;
            }
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50" x-data="{ sidebarOpen: false, userMenuOpen: false }">

    <div class="flex h-screen overflow-hidden">

        <!-- ========== SIDEBAR ========== -->
        <aside
            x-cloak
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-primary-400 to-primary-500 text-white transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 flex flex-col shadow-2xl"
            @click.away="sidebarOpen = false"
        >
            <!-- Logo / Header -->
            <div class="flex items-center justify-between px-6 py-5 border-b border-primary-300" style="border-color: rgba(0, 80, 143, 0.3);">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="font-bold text-lg">Sistema Escolar</h1>
                        <p class="text-xs text-primary-50">Panel Admin</p>
                    </div>
                </div>

                <!-- Botón cerrar (solo móvil) -->
                <button @click="sidebarOpen = false" class="lg:hidden text-primary-50 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Navegación -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto custom-scrollbar">

                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('dashboard') ? 'bg-white text-primary-400 shadow-lg' : 'text-primary-50 hover:bg-primary-300 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>

                <!-- Separador -->
                <div class="py-2">
                    <div class="border-t border-primary-300" style="border-color: rgba(0, 80, 143, 0.3);"></div>
                </div>

                <!-- GESTIÓN DE PERSONAS -->
                <div class="px-4 py-2">
                    <p class="text-xs font-semibold text-accent-300 uppercase tracking-wider">Gestión de Personas</p>
                </div>

                <!-- Administradores -->
                <a href="{{ route('admins.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admins.*') ? 'bg-white text-primary-400 shadow-lg' : 'text-primary-50 hover:bg-primary-300 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span class="font-medium">Administradores</span>
                </a>

                <!-- Estudiantes -->
                <a href="{{ route('estudiantes.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('estudiantes.*') ? 'bg-white text-primary-400 shadow-lg' : 'text-primary-50 hover:bg-primary-300 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span class="font-medium">Estudiantes</span>
                </a>

                <!-- Profesores -->
                <a href="{{ route('profesores.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('profesores.*') ? 'bg-white text-primary-400 shadow-lg' : 'text-primary-50 hover:bg-primary-300 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span class="font-medium">Profesores</span>
                </a>

                <!-- Padres de Familia -->
                <a href="#"
                   class="flex items-center justify-between gap-3 px-4 py-3 rounded-lg transition-all text-primary-50 hover:bg-primary-300 hover:text-white">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="font-medium">Padres de Familia</span>
                    </div>
                    <span class="text-xs bg-accent-300 text-primary-500 px-2 py-0.5 rounded-full badge-new font-semibold">Nuevo</span>
                </a>

                <!-- Buscar Estudiante -->
                <a href="{{ route('estudiantes.buscar') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('estudiantes.buscar') ? 'bg-white text-primary-400 shadow-lg' : 'text-primary-50 hover:bg-primary-300 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span class="font-medium">Buscar Estudiante</span>
                </a>

                <!-- Separador -->
                <div class="py-2">
                    <div class="border-t border-primary-300" style="border-color: rgba(0, 80, 143, 0.3);"></div>
                </div>

                <!-- GESTIÓN ACADÉMICA -->
                <div class="px-4 py-2">
                    <p class="text-xs font-semibold text-accent-300 uppercase tracking-wider">Gestión Académica</p>
                </div>

                <!-- Matrículas -->
                <a href="{{ route('matriculas.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('matriculas.*') ? 'bg-white text-primary-400 shadow-lg' : 'text-primary-50 hover:bg-primary-300 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="font-medium">Matrículas</span>
                </a>

                <!-- Grados y Secciones -->
                <a href="#"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all text-primary-50 hover:bg-primary-300 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <span class="font-medium">Grados y Secciones</span>
                </a>

                <!-- Asignaturas -->
                <a href="#"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all text-primary-50 hover:bg-primary-300 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span class="font-medium">Asignaturas</span>
                </a>

                <!-- Horarios -->
                <a href="#"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all text-primary-50 hover:bg-primary-300 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-medium">Horarios</span>
                </a>

                <!-- Periodos Académicos -->
                <a href="{{ route('periodos-academicos.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('periodos-academicos.*') ? 'bg-white text-primary-400 shadow-lg' : 'text-primary-50 hover:bg-primary-300 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="font-medium">Periodos Académicos</span>
                </a>

                <!-- Cupos Máximos -->
                <a href="{{ route('cupos_maximos.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('cupos_maximos.*') ? 'bg-white text-primary-400 shadow-lg' : 'text-primary-50 hover:bg-primary-300 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span class="font-medium">Cupos por Curso</span>
                </a>

                <!-- Separador -->
                <div class="py-2">
                    <div class="border-t border-primary-300" style="border-color: rgba(0, 80, 143, 0.3);"></div>
                </div>

                <!-- EVALUACIÓN Y SEGUIMIENTO -->
                <div class="px-4 py-2">
                    <p class="text-xs font-semibold text-accent-300 uppercase tracking-wider">Evaluación</p>
                </div>

                <!-- Calificaciones -->
                <a href="#"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all text-primary-50 hover:bg-primary-300 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <span class="font-medium">Calificaciones</span>
                </a>

                <!-- Asistencias -->
                <a href="#"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all text-primary-50 hover:bg-primary-300 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                    <span class="font-medium">Asistencias</span>
                </a>

                <!-- Observaciones -->
                <a href="{{ route('observaciones.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('observaciones.*') ? 'bg-white text-primary-400 shadow-lg' : 'text-primary-50 hover:bg-primary-300 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span class="font-medium">Observaciones</span>
                </a>

                <!-- Reportes Académicos -->
                <a href="#"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all text-primary-50 hover:bg-primary-300 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="font-medium">Reportes Académicos</span>
                </a>

                <!-- Separador -->
                <div class="py-2">
                    <div class="border-t border-primary-300" style="border-color: rgba(0, 80, 143, 0.3);"></div>
                </div>

                <!-- COMUNICACIÓN -->
                <div class="px-4 py-2">
                    <p class="text-xs font-semibold text-accent-300 uppercase tracking-wider">Comunicación</p>
                </div>

                <!-- Mensajes -->
                <a href="#"
                   class="flex items-center justify-between gap-3 px-4 py-3 rounded-lg transition-all text-primary-50 hover:bg-primary-300 hover:text-white">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="font-medium">Mensajes</span>
                    </div>
                    <span class="text-xs bg-red-500 text-white px-2 py-0.5 rounded-full font-semibold">3</span>
                </a>

                <!-- Avisos y Comunicados -->
                <a href="#"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all text-primary-50 hover:bg-primary-300 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                    </svg>
                    <span class="font-medium">Avisos y Comunicados</span>
                </a>

                <!-- Separador -->
                <div class="py-2">
                    <div class="border-t border-primary-300" style="border-color: rgba(0, 80, 143, 0.3);"></div>
                </div>

                <!-- DOCUMENTOS Y ARCHIVOS -->
                <div class="px-4 py-2">
                    <p class="text-xs font-semibold text-accent-300 uppercase tracking-wider">Documentos</p>
                </div>

                <!-- Documentos -->
                <a href="{{ route('documentos.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('documentos.*') ? 'bg-white text-primary-400 shadow-lg' : 'text-primary-50 hover:bg-primary-300 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    <span class="font-medium">Documentos</span>
                </a>

                <!-- Certificados y Constancias -->
                <a href="#"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all text-primary-50 hover:bg-primary-300 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                    <span class="font-medium">Certificados</span>
                </a>

                <!-- Consultar Solicitud -->
               <a href="{{ route('admins.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('solicitud.*') ? 'bg-white text-primary-400 shadow-lg' : 'text-primary-50 hover:bg-primary-300 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                    <span class="font-medium">Consultar Solicitud</span>
               </a>

                <!-- Separador -->
                <div class="py-2">
                    <div class="border-t border-primary-300" style="border-color: rgba(0, 80, 143, 0.3);"></div>
                </div>

                <!-- SISTEMA -->
                <div class="px-4 py-2">
                    <p class="text-xs font-semibold text-accent-300 uppercase tracking-wider">Sistema</p>
                </div>

                <!-- Estadísticas -->
                <a href="#"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all text-primary-50 hover:bg-primary-300 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="font-medium">Estadísticas</span>
                </a>

                <!-- Configuración -->
                <a href="#"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all text-primary-50 hover:bg-primary-300 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="font-medium">Configuración</span>
                </a>

                <!-- Cambiar Contraseña -->
                <a href="{{ route('cambiarcontrasenia.edit') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('cambiarcontrasenia.*') ? 'bg-white text-primary-400 shadow-lg' : 'text-primary-50 hover:bg-primary-300 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <span class="font-medium">Cambiar Contraseña</span>
                </a>

                <!-- Ayuda y Soporte -->
                <a href="#"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all text-primary-50 hover:bg-primary-300 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-medium">Ayuda y Soporte</span>
                </a>

            </nav>

            <!-- Usuario logueado (Footer del sidebar) -->
            <div class="border-t border-primary-300 p-4" style="border-color: rgba(0, 80, 143, 0.3);">
                <div class="flex items-center gap-3 px-3 py-2 rounded-lg" style="background-color: rgba(0, 80, 143, 0.3);">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-primary-400 font-bold text-sm">
                            @auth
                                {{ strtoupper(substr(auth()->user()->nombre ?? auth()->user()->name ?? 'AD', 0, 2)) }}
                            @else
                                AD
                            @endauth
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-white truncate">
                            @auth
                                {{ auth()->user()->nombre ?? auth()->user()->name ?? 'Administrador' }}
                            @else
                                Administrador
                            @endauth
                        </p>
                        <p class="text-xs text-primary-50 truncate">
                            @auth
                                {{ auth()->user()->email ?? 'admin@sistema.com' }}
                            @else
                                admin@sistema.com
                            @endauth
                        </p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- ========== CONTENIDO PRINCIPAL ========== -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- Topbar -->
            <header class="bg-white border-b border-gray-200 shadow-sm z-10">
                <div class="flex items-center justify-between px-4 py-4">

                    <!-- Hamburger Button (Mobile) -->
                    <button @click="sidebarOpen = !sidebarOpen"
                            class="lg:hidden text-gray-600 hover:text-gray-900 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <!-- Título -->
                    <div class="hidden lg:block">
                        <h2 class="text-lg font-semibold text-primary-400">@yield('page-title', 'Panel de Control')</h2>
                        <p class="text-sm text-gray-500">@yield('page-subtitle', 'Bienvenido al sistema escolar')</p>
                    </div>

                    <!-- User Menu -->
                    <div class="relative ml-auto" x-data="{ open: false }">
                        <button @click="open = !open"
                                class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition">
                            <div class="w-8 h-8 bg-primary-300 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold text-xs">
                                    {{ strtoupper(substr(auth()->user()->nombre ?? auth()->user()->name ?? 'AD', 0, 2)) }}
                                </span>
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-medium text-gray-700">{{ auth()->user()->nombre ?? auth()->user()->name ?? 'Administrador' }}</p>
                                <p class="text-xs text-gray-500">{{ ucfirst(auth()->user()->rol ?? 'admin') }}</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown -->
                        <div x-show="open"
                             @click.away="open = false"
                             x-transition
                             class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl border border-gray-200 py-1 z-50">

                            <div class="px-4 py-3 border-b border-gray-200">
                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->nombre ?? auth()->user()->name ?? 'Admin' }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                            </div>

                            <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Mi Perfil
                            </a>

                            <a href="{{ route('cambiarcontrasenia.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Cambiar Contraseña
                            </a>

                            <div class="border-t border-gray-200 my-1"></div>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Contenido -->
            <main class="flex-1 overflow-y-auto bg-gray-50 custom-scrollbar">

                <!-- Alertas Flash -->
                @if(session('success'))
                    <div class="mx-4 mt-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                            </div>
                            <button @click="show = false" class="text-green-600 hover:text-green-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mx-4 mt-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                            </div>
                            <button @click="show = false" class="text-red-600 hover:text-red-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Overlay para cerrar sidebar en móvil -->
    <div x-show="sidebarOpen"
         @click="sidebarOpen = false"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"
         style="display: none;">
    </div>

    @stack('scripts')
</body>
</html>
