<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema Escolar')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    
    <!-- Navegación Principal - MINIMALISTA -->
    <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-2.5">
                <!-- Logo y Nombre -->
                <a href="/" class="flex items-center gap-2.5">
                    <div class="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <span class="text-lg font-bold text-gray-800">Sistema Escolar</span>
                </a>

                <!-- Menú de Navegación -->
                <div class="hidden md:flex gap-1">
                    <a href="{{ route('admins.index') }}" class="px-3 py-1.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admins.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        Administradores
                    </a>
                    <a href="{{ route('estudiantes.index') }}" class="px-3 py-1.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('estudiantes.*') ? 'bg-green-100 text-green-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        Estudiantes
                    </a>
                    <a href="{{ route('profesores.index') }}" class="px-3 py-1.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('profesores.*') ? 'bg-purple-100 text-purple-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        Profesores
                    </a>
                </div>

                <!-- Menú móvil -->
                <button class="md:hidden p-1.5 rounded hover:bg-gray-100" onclick="toggleMobileMenu()">
                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Menú móvil desplegable -->
            <div id="mobileMenu" class="hidden md:hidden pb-2 space-y-1">
                <a href="{{ route('admins.index') }}" class="block px-3 py-2 rounded text-sm font-medium {{ request()->routeIs('admins.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                    Administradores
                </a>
                <a href="{{ route('estudiantes.index') }}" class="block px-3 py-2 rounded text-sm font-medium {{ request()->routeIs('estudiantes.*') ? 'bg-green-100 text-green-700' : 'text-gray-700 hover:bg-gray-100' }}">
                    Estudiantes
                </a>
                <a href="{{ route('profesores.index') }}" class="block px-3 py-2 rounded text-sm font-medium {{ request()->routeIs('profesores.*') ? 'bg-purple-100 text-purple-700' : 'text-gray-700 hover:bg-gray-100' }}">
                    Profesores
                </a>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <main class="flex-grow py-4">
        @if(session('success'))
            <div class="container mx-auto px-4 mb-3">
                <div class="bg-green-50 border-l-4 border-green-500 p-2.5 rounded">
                    <p class="text-green-800 text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container mx-auto px-4 mb-3">
                <div class="bg-red-50 border-l-4 border-red-500 p-2.5 rounded">
                    <p class="text-red-800 text-sm">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer Minimalista -->
    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="container mx-auto px-4 py-4">
            <div class="flex flex-col md:flex-row justify-between items-center gap-2 text-xs text-gray-600">
                <p>&copy; {{ date('Y') }} Sistema Escolar. Todos los derechos reservados.</p>
                <p class="text-gray-500">contacto@institucion.edu | +504 2222-2222</p>
            </div>
        </div>
    </footer>

    @stack('scripts')

    <script>
        function toggleMobileMenu() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        }
    </script>
</body>
</html>