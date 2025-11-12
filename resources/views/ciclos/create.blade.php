@extends('layouts.app')

{{-- Define la variable de título de página para el layout (si existe) --}}
@section('page-title', 'Nuevo Ciclo')

{{-- Define las acciones superiores, como el botón de Volver --}}
@section('topbar-actions')
    <a href="{{ route('ciclos.index') }}" 
       class="flex items-center space-x-2 px-4 py-2 text-sm font-semibold rounded-lg transition duration-300 ease-in-out border-2 border-[#00508f] text-[#00508f] bg-white hover:bg-[#00508f] hover:text-white shadow-sm"
       style="font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        <span>Volver</span>
    </a>
@endsection

@section('content')
<div class="container mx-auto px-4" style="max-width: 1200px;">
    
    <!-- Header compacto con gradiente -->
    <div class="rounded-xl shadow-lg mb-4 p-4 text-white" 
         style="background: linear-gradient(135deg, #00508f 0%, #003b73 100%);">
        <div class="flex items-center">
            <div class="w-11 h-11 flex items-center justify-center rounded-lg me-3" 
                 style="background: rgba(78, 199, 210, 0.3);">
                <i class="fas fa-calendar-alt text-white" style="font-size: 1.3rem;"></i>
            </div>
            <div>
                <h5 class="mb-0 font-bold" style="font-size: 1.1rem;">Registro de Nuevo Ciclo</h5>
                <p class="mb-0 opacity-90 text-xs">Defina la configuración básica del nuevo ciclo académico</p>
            </div>
        </div>
    </div>

    <!-- Formulario compacto -->
    <div class="bg-white rounded-xl shadow-lg p-5">
        <form action="{{ route('ciclos.store') }}" method="POST">
            @csrf

            <!-- Información Principal del Ciclo -->
            <div class="mb-6">
                <div class="flex items-center gap-2 mb-4 pb-2 border-b border-gray-200">
                    <div class="w-8 h-8 flex items-center justify-center rounded-lg" 
                         style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);">
                        <i class="fas fa-layer-group text-white" style="font-size: 0.9rem;"></i>
                    </div>
                    <h6 class="mb-0 font-bold text-[#003b73]" style="font-size: 1rem;">Configuración del Ciclo</h6>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    
                    {{-- Campo: Nombre del Ciclo (Select) --}}
                    <div class="col-span-1">
                        <label for="nombre" class="block text-sm font-semibold mb-1 text-[#003b73]">
                            Nombre del Ciclo <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-list position-absolute text-[#00508f] text-sm" 
                               style="left: 12px; top: 50%; transform: translateY(-50%); z-index: 10;"></i>
                            <select name="nombre" id="nombre" 
                                    class="w-full px-5 py-2.5 pl-10 border-2 border-[#bfd9ea] rounded-lg text-sm transition focus:border-[#4ec7d2] focus:ring-0 @error('nombre') border-red-500 @enderror"
                                    required>
                                <option value="">Seleccione un ciclo</option>
                                <option value="Primer Ciclo" {{ old('nombre') == 'Primer Ciclo' ? 'selected' : '' }}>Primer Ciclo</option>
                                <option value="Segundo Ciclo" {{ old('nombre') == 'Segundo Ciclo' ? 'selected' : '' }}>Segundo Ciclo</option>
                                <option value="Tercer Ciclo" {{ old('nombre') == 'Tercer Ciclo' ? 'selected' : '' }}>Tercer Ciclo</option>
                            </select>
                            @error('nombre')
                                <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Campo: Sección (Input Text) --}}
                    <div class="col-span-1">
                        <label for="seccion" class="block text-sm font-semibold mb-1 text-[#003b73]">
                            Sección <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-tag position-absolute text-[#00508f] text-sm" 
                               style="left: 12px; top: 50%; transform: translateY(-50%); z-index: 10;"></i>
                            <input type="text" 
                                name="seccion" 
                                id="seccion" 
                                value="{{ old('seccion') }}" 
                                placeholder="Ej: A, B, Nocturna"
                                class="w-full px-5 py-2.5 pl-10 border-2 border-[#bfd9ea] rounded-lg text-sm transition focus:border-[#4ec7d2] focus:ring-0 @error('seccion') border-red-500 @enderror"
                                required>
                            
                            @error('seccion')
                                <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Campo: Jornada (Radio Buttons) -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-[#003b73] mb-3">
                    Jornada <span class="text-red-500">*</span>
                </label>
                <div class="flex gap-6">
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="jornada" value="Matutina" 
                            {{ old('jornada', 'Matutina') == 'Matutina' ? 'checked' : '' }}
                            class="w-4 h-4 text-[#00508f] border-gray-300 focus:ring-[#00508f]"
                            required>
                        <span class="ml-2 text-sm text-gray-700">Jornada Matutina</span>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="jornada" value="Vespertina" 
                                {{ old('jornada') == 'Vespertina' ? 'checked' : '' }}
                                class="w-4 h-4 text-[#00508f] border-gray-300 focus:ring-[#00508f]"
                                required>
                        <span class="ml-2 text-sm text-gray-700">Jornada Vespertina</span>
                    </label>
                </div>
                @error('jornada')
                    <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Botones compactos -->
            <div class="flex gap-3 pt-4 border-t border-gray-100">
                <button type="submit" 
                        class="flex-1 flex items-center justify-center space-x-2 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-300 ease-in-out"
                        style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; box-shadow: 0 4px 12px rgba(78, 199, 210, 0.4);">
                    <i class="fas fa-save"></i>
                    <span>Crear Ciclo</span>
                </button>
                <a href="{{ route('ciclos.index') }}" 
                   class="flex-1 flex items-center justify-center space-x-2 border-2 border-[#00508f] text-[#00508f] bg-white px-6 py-3 rounded-lg font-semibold text-center transition duration-300 ease-in-out hover:bg-gray-50">
                    <i class="fas fa-times"></i>
                    <span>Cancelar</span>
                </a>
            </div>
        </form>
    </div>

    <!-- Nota compacta -->
    <div class="mt-3 py-2 px-3 rounded-lg text-sm" 
         style="background: rgba(78, 199, 210, 0.1); border-left: 3px solid #4ec7d2;">
        <div class="flex items-start">
            <i class="fas fa-info-circle me-2 mt-1 text-[#00508f]"></i>
            <div>
                <strong style="color: #00508f;">Información:</strong>
                <span class="text-gray-600"> Los ciclos deben ser creados antes de asignar estudiantes.</span>
            </div>
        </div>
    </div>
</div>
@endsection