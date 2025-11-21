<<<<<<< HEAD
@extends('layouts.app')

@section('title', 'Crear Grado')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Crear Nuevo Grado</h1>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('grados.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre del Grado <span class="text-red-500">*</span>
                    </label>
                    <select name="nombre" id="nombre" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('nombre') border-red-500 @enderror"
                            required>
                        <option value="">Seleccione un grado</option>
                        <option value="Primero" {{ old('nombre') == 'Primero' ? 'selected' : '' }}>Primero</option>
                        <option value="Segundo" {{ old('nombre') == 'Segundo' ? 'selected' : '' }}>Segundo</option>
                        <option value="Tercero" {{ old('nombre') == 'Tercero' ? 'selected' : '' }}>Tercero</option>
                        <option value="Cuarto" {{ old('nombre') == 'Cuarto' ? 'selected' : '' }}>Cuarto</option>
                        <option value="Quinto" {{ old('nombre') == 'Quinto' ? 'selected' : '' }}>Quinto</option>
                        <option value="Sexto" {{ old('nombre') == 'Sexto' ? 'selected' : '' }}>Sexto</option>
                    </select>
                    @error('nombre')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="seccion" class="block text-sm font-medium text-gray-700 mb-2">
                        Sección
                    </label>
                    <input type="text" 
                           name="seccion" 
                           id="seccion" 
                           value="{{ old('seccion') }}" 
                           placeholder="Ej: A, B, Nocturna"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('seccion') border-red-500 @enderror">
                    
                    @error('seccion')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="nombre_maestro" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre del Maestro <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="nombre_maestro" 
                           id="nombre_maestro"
                           value="{{ old('nombre_maestro') }}"
                           placeholder="Ingrese el nombre completo del maestro"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('nombre_maestro') border-red-500 @enderror"
                           required>
                    
                    @error('nombre_maestro')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Seleccione la Jornada: <span class="text-red-500">*</span>
                    </label>

                    <label class="inline-flex items-center mr-6">
                        <input type="radio" 
                               name="jornada" 
                               value="Matutina" 
                               {{ old('jornada', 'Matutina') == 'Matutina' ? 'checked' : '' }}
                               class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                               required>
                        <span class="ml-2 text-sm text-gray-700">Matutina</span>
                    </label>

                    <label class="inline-flex items-center">
                        <input type="radio" 
                               name="jornada" 
                               value="Vespertina" 
                               {{ old('jornada') == 'Vespertina' ? 'checked' : '' }}
                               class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                               required>
                        <span class="ml-2 text-sm text-gray-700">Vespertina</span>
                    </label>

                    @error('jornada')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4">
                    <button type="submit" 
                            class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                        Crear Grado
                    </button>
                    <a href="{{ route('grados.index') }}" 
                       class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-lg font-semibold text-center transition">
                        Cancelar
=======
@extends('layouts.admin')

@section('title', 'Nuevo Grado')

@section('page-title', 'Crear Nuevo Grado')

@section('topbar-actions')
    <a href="{{ route('grados.index') }}" class="btn-back" style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #00508f; box-shadow: 0 2px 8px rgba(0, 80, 143, 0.2); font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 900px;">

    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-header" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 12px 12px 0 0; padding: 1.2rem;">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-graduation-cap"></i> Formulario de Nuevo Grado
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('grados.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <!-- Nivel Educativo -->
                    <div class="col-md-6">
                        <label for="nivel" class="form-label fw-semibold" style="color: #003b73;">
                            <i class="fas fa-layer-group text-primary"></i> Nivel Educativo *
                        </label>
                        <select class="form-select @error('nivel') is-invalid @enderror" 
                                id="nivel" 
                                name="nivel"
                                required
                                style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem;">
                            <option value="">Seleccionar nivel...</option>
                            <option value="primaria" {{ old('nivel') == 'primaria' ? 'selected' : '' }}>
                                🎒 Primaria (1° - 6° Grado)
                            </option>
                            <option value="secundaria" {{ old('nivel') == 'secundaria' ? 'selected' : '' }}>
                                🎓 Secundaria (7° - 9° Grado)
                            </option>
                        </select>
                        @error('nivel')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Número de Grado -->
                    <div class="col-md-6">
                        <label for="numero" class="form-label fw-semibold" style="color: #003b73;">
                            <i class="fas fa-sort-numeric-up text-success"></i> Número de Grado *
                        </label>
                        <select class="form-select @error('numero') is-invalid @enderror" 
                                id="numero" 
                                name="numero"
                                required
                                style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem;">
                            <option value="">Seleccionar grado...</option>
                            <option value="1" {{ old('numero') == 1 ? 'selected' : '' }}>1° Grado</option>
                            <option value="2" {{ old('numero') == 2 ? 'selected' : '' }}>2° Grado</option>
                            <option value="3" {{ old('numero') == 3 ? 'selected' : '' }}>3° Grado</option>
                            <option value="4" {{ old('numero') == 4 ? 'selected' : '' }}>4° Grado</option>
                            <option value="5" {{ old('numero') == 5 ? 'selected' : '' }}>5° Grado</option>
                            <option value="6" {{ old('numero') == 6 ? 'selected' : '' }}>6° Grado</option>
                            <option value="7" {{ old('numero') == 7 ? 'selected' : '' }}>7° Grado</option>
                            <option value="8" {{ old('numero') == 8 ? 'selected' : '' }}>8° Grado</option>
                            <option value="9" {{ old('numero') == 9 ? 'selected' : '' }}>9° Grado</option>
                        </select>
                        @error('numero')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Sección -->
                    <div class="col-md-6">
                        <label for="seccion" class="form-label fw-semibold" style="color: #003b73;">
                            <i class="fas fa-list-ol text-info"></i> Sección
                        </label>
                        <select class="form-select @error('seccion') is-invalid @enderror" 
                                id="seccion" 
                                name="seccion"
                                style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem;">
                            <option value="">Sin sección</option>
                            <option value="A" {{ old('seccion') == 'A' ? 'selected' : '' }}>Sección A</option>
                            <option value="B" {{ old('seccion') == 'B' ? 'selected' : '' }}>Sección B</option>
                            <option value="C" {{ old('seccion') == 'C' ? 'selected' : '' }}>Sección C</option>
                            <option value="D" {{ old('seccion') == 'D' ? 'selected' : '' }}>Sección D</option>
                            <option value="E" {{ old('seccion') == 'E' ? 'selected' : '' }}>Sección E</option>
                        </select>
                        @error('seccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Opcional: Deja vacío si no aplica</small>
                    </div>

                    <!-- Año Lectivo -->
                    <div class="col-md-6">
                        <label for="anio_lectivo" class="form-label fw-semibold" style="color: #003b73;">
                            <i class="fas fa-calendar-alt text-warning"></i> Año Lectivo *
                        </label>
                        <input type="number" 
                               class="form-control @error('anio_lectivo') is-invalid @enderror" 
                               id="anio_lectivo" 
                               name="anio_lectivo" 
                               value="{{ old('anio_lectivo', date('Y')) }}"
                               min="2020"
                               max="2100"
                               required
                               style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem;">
                        @error('anio_lectivo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Estado Activo -->
                    <div class="col-12">
                        <div class="form-check form-switch" style="padding-left: 2.5rem;">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="activo" 
                                   name="activo" 
                                   value="1"
                                   {{ old('activo', true) ? 'checked' : '' }}
                                   style="width: 3rem; height: 1.5rem; cursor: pointer;">
                            <label class="form-check-label fw-semibold" for="activo" style="color: #003b73; margin-left: 0.5rem;">
                                <i class="fas fa-toggle-on text-success"></i> Grado Activo
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Información adicional -->
                <div class="alert alert-info mt-3 d-flex align-items-start" style="border-radius: 8px; border-left: 4px solid #4ec7d2; background: rgba(78, 199, 210, 0.1);">
                    <i class="fas fa-info-circle me-2 mt-1" style="color: #00508f;"></i>
                    <div>
                        <strong style="color: #003b73;">Nota importante:</strong>
                        <p class="mb-0 small text-muted">Después de crear el grado, podrás asignar las materias correspondientes desde la sección de gestión de grados.</p>
                    </div>
                </div>

                <!-- Botones -->
                <div class="d-flex gap-2 mt-4 pt-3 border-top">
                    <button type="submit" class="btn flex-fill" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 8px; padding: 0.7rem; font-weight: 600; border: none;">
                        <i class="fas fa-save"></i> Guardar Grado
                    </button>
                    <a href="{{ route('grados.index') }}" class="btn flex-fill" style="background: white; color: #6b7280; border: 2px solid #e5e7eb; border-radius: 8px; padding: 0.7rem; font-weight: 600;">
                        <i class="fas fa-times"></i> Cancelar
>>>>>>> 0c60f43d83749cde12f470882b2070e271fe5d92
                    </a>
                </div>
            </form>
        </div>
    </div>
<<<<<<< HEAD
</div>
=======

</div>

@push('styles')
<style>
    .form-control:focus, .form-select:focus {
        border-color: #4ec7d2;
        box-shadow: 0 0 0 0.2rem rgba(78, 199, 210, 0.15);
        outline: none;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-back:hover {
        background: #00508f !important;
        color: white !important;
        transform: translateY(-2px);
    }
</style>
@endpush

@push('scripts')
<script>
    // Filtrar números de grado según el nivel seleccionado
    document.getElementById('nivel').addEventListener('change', function() {
        const nivel = this.value;
        const numeroSelect = document.getElementById('numero');
        const options = numeroSelect.querySelectorAll('option');
        
        options.forEach(option => {
            if (option.value === '') return;
            
            const numero = parseInt(option.value);
            
            if (nivel === 'primaria') {
                option.style.display = (numero >= 1 && numero <= 6) ? '' : 'none';
            } else if (nivel === 'secundaria') {
                option.style.display = (numero >= 7 && numero <= 9) ? '' : 'none';
            } else {
                option.style.display = '';
            }
        });
        
        // Reset selection if current value is not valid
        const currentValue = parseInt(numeroSelect.value);
        if (nivel === 'primaria' && (currentValue < 1 || currentValue > 6)) {
            numeroSelect.value = '';
        } else if (nivel === 'secundaria' && (currentValue < 7 || currentValue > 9)) {
            numeroSelect.value = '';
        }
    });
</script>
@endpush

>>>>>>> 0c60f43d83749cde12f470882b2070e271fe5d92
@endsection