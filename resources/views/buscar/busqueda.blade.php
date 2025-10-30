<!-- Componente de Búsqueda Reutilizable -->
<div class="mb-6">
    <form action="{{ $route ?? '#' }}" method="GET" class="relative">
        <div class="relative max-w-md">
            <!-- Icono de búsqueda -->
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            
            <!-- Input de búsqueda -->
            <input 
                type="text" 
                name="busqueda" 
                value="{{ request('busqueda') }}"
                placeholder="{{ $placeholder ?? 'Buscar...' }}"
                class="w-full pl-10 pr-20 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm"
                autocomplete="off"
            >
            
            <!-- Botones -->
            <div class="absolute inset-y-0 right-0 flex items-center pr-2 gap-1">
                @if(request('busqueda'))
                    <!-- Botón limpiar -->
                    <a href="{{ $route ?? '#' }}" 
                       class="p-1.5 text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </a>
                @endif
                
                <!-- Botón buscar -->
                <button 
                    type="submit"
                    class="px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-md hover:bg-blue-700 transition">
                    Buscar
                </button>
            </div>
        </div>
    </form>
    
    <!-- Resultados de búsqueda -->
    @if(request('busqueda'))
        <div class="mt-2 text-sm text-gray-600">
            Mostrando resultados para: <span class="font-semibold">"{{ request('busqueda') }}"</span>
        </div>
    @endif
</div>