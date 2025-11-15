@extends('layouts.app')

@section('title', 'Editar Calificación')

@section('page-title', 'Editar Calificación')

@section('topbar-actions')
    <a href="{{ route('calificaciones.index') }}" class="btn-back" 
       style="background: #e2e8f0; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 1px solid #bfd9ea; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
@endsection

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<div class="container" style="max-width: 900px; font-family: 'Poppins', sans-serif; margin: 0 auto; padding: 2rem 1rem;">
    
    <!-- Card Principal -->
    <div style="background: white; border-radius: 15px; box-shadow: 0 10px 40px rgba(0, 59, 115, 0.15); overflow: hidden; border: 1px solid #e2e8f0;">
        
        <!-- Header del Card -->
        <div style="background: linear-gradient(135deg, #003b73 0%, #00508f 50%, #4ec7d2 100%); padding: 2rem; border-bottom: 3px solid #4ec7d2;">
            <h1 style="color: white; font-size: 2rem; font-weight: 800; margin: 0; font-family: 'Poppins', sans-serif; display: flex; align-items: center; gap: 0.75rem;">
                <i class="fas fa-edit"></i> Editar Calificación
            </h1>
            <p style="color: rgba(255, 255, 255, 0.9); margin: 0.5rem 0 0 0; font-size: 0.95rem;">Actualice las calificaciones del estudiante</p>
        </div>

        <!-- Cuerpo del Formulario -->
        <div style="padding: 2.5rem;">
            <form action="{{ route('calificaciones.update', $calificacion) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Sección: Información General -->
                <div style="margin-bottom: 2rem;">
                    <h2 style="color: #003b73; font-size: 1.25rem; font-weight: 700; margin-bottom: 1.25rem; border-left: 4px solid #4ec7d2; padding-left: 0.75rem; font-family: 'Poppins', sans-serif;">
                        Información General
                    </h2>

                    <div style="margin-bottom: 1.5rem;">
                        <label for="nombre_alumno" style="display: block; color: #003b73; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.95rem; font-family: 'Poppins', sans-serif;">
                            Nombre del Alumno <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" 
                               name="nombre_alumno" 
                               id="nombre_alumno"
                               value="{{ old('nombre_alumno', $calificacion->nombre_alumno) }}"
                               placeholder="Ej: Juan Pérez López" 
                               required
                               style="width: 100%; padding: 0.875rem 1rem; border: 2px solid #bfd9ea; border-radius: 8px; font-size: 0.95rem; transition: all 0.3s ease; font-family: 'Poppins', sans-serif; background: white; color: #003b73; @error('nombre_alumno') border-color: #ef4444; @enderror"
                               onfocus="this.style.borderColor='#4ec7d2'; this.style.boxShadow='0 0 0 3px rgba(78, 199, 210, 0.1)';"
                               onblur="this.style.borderColor='#bfd9ea'; this.style.boxShadow='none';">

                        @error('nombre_alumno')
                            <p style="color: #ef4444; font-size: 0.85rem; margin-top: 0.5rem; font-family: 'Poppins', sans-serif;">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Sección: Calificaciones Parciales -->
                <div style="margin-bottom: 2rem;">
                    <h2 style="color: #003b73; font-size: 1.25rem; font-weight: 700; margin-bottom: 1.25rem; border-left: 4px solid #4ec7d2; padding-left: 0.75rem; font-family: 'Poppins', sans-serif;">
                        Calificaciones por Parcial (0 - 100)
                    </h2>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1.25rem; padding: 1.5rem; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-radius: 10px; border: 2px solid #bfd9ea;">
                        
                        <!-- Primer Parcial -->
                        <div>
                            <label for="primer_parcial" style="display: block; color: #00508f; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.85rem; font-family: 'Poppins', sans-serif; text-align: center;">
                                <i class="fas fa-file-alt" style="color: #4ec7d2;"></i> 1° Parcial
                            </label>
                            <input type="number" 
                                   name="primer_parcial" 
                                   id="primer_parcial"
                                   value="{{ old('primer_parcial', $calificacion->primer_parcial) }}"
                                   step="0.01" 
                                   min="0" 
                                   max="100"
                                   placeholder="0.00"
                                   style="width: 100%; padding: 0.75rem; border: 2px solid #bfd9ea; border-radius: 8px; text-align: center; font-size: 1rem; font-weight: 600; transition: all 0.3s ease; font-family: 'Poppins', sans-serif; background: white; color: #003b73; @error('primer_parcial') border-color: #ef4444; @enderror"
                                   onfocus="this.style.borderColor='#4ec7d2'; this.style.boxShadow='0 0 0 3px rgba(78, 199, 210, 0.1)';"
                                   onblur="this.style.borderColor='#bfd9ea'; this.style.boxShadow='none';">
                            
                            @error('primer_parcial')
                                <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem; text-align: center; font-family: 'Poppins', sans-serif;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Segundo Parcial -->
                        <div>
                            <label for="segundo_parcial" style="display: block; color: #00508f; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.85rem; font-family: 'Poppins', sans-serif; text-align: center;">
                                <i class="fas fa-file-alt" style="color: #4ec7d2;"></i> 2° Parcial
                            </label>
                            <input type="number" 
                                   name="segundo_parcial" 
                                   id="segundo_parcial"
                                   value="{{ old('segundo_parcial', $calificacion->segundo_parcial) }}"
                                   step="0.01" 
                                   min="0" 
                                   max="100"
                                   placeholder="0.00"
                                   style="width: 100%; padding: 0.75rem; border: 2px solid #bfd9ea; border-radius: 8px; text-align: center; font-size: 1rem; font-weight: 600; transition: all 0.3s ease; font-family: 'Poppins', sans-serif; background: white; color: #003b73; @error('segundo_parcial') border-color: #ef4444; @enderror"
                                   onfocus="this.style.borderColor='#4ec7d2'; this.style.boxShadow='0 0 0 3px rgba(78, 199, 210, 0.1)';"
                                   onblur="this.style.borderColor='#bfd9ea'; this.style.boxShadow='none';">
                            
                            @error('segundo_parcial')
                                <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem; text-align: center; font-family: 'Poppins', sans-serif;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tercer Parcial -->
                        <div>
                            <label for="tercer_parcial" style="display: block; color: #00508f; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.85rem; font-family: 'Poppins', sans-serif; text-align: center;">
                                <i class="fas fa-file-alt" style="color: #4ec7d2;"></i> 3° Parcial
                            </label>
                            <input type="number" 
                                   name="tercer_parcial" 
                                   id="tercer_parcial"
                                   value="{{ old('tercer_parcial', $calificacion->tercer_parcial) }}"
                                   step="0.01" 
                                   min="0" 
                                   max="100"
                                   placeholder="0.00"
                                   style="width: 100%; padding: 0.75rem; border: 2px solid #bfd9ea; border-radius: 8px; text-align: center; font-size: 1rem; font-weight: 600; transition: all 0.3s ease; font-family: 'Poppins', sans-serif; background: white; color: #003b73; @error('tercer_parcial') border-color: #ef4444; @enderror"
                                   onfocus="this.style.borderColor='#4ec7d2'; this.style.boxShadow='0 0 0 3px rgba(78, 199, 210, 0.1)';"
                                   onblur="this.style.borderColor='#bfd9ea'; this.style.boxShadow='none';">
                            
                            @error('tercer_parcial')
                                <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem; text-align: center; font-family: 'Poppins', sans-serif;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Cuarto Parcial -->
                        <div>
                            <label for="cuarto_parcial" style="display: block; color: #00508f; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.85rem; font-family: 'Poppins', sans-serif; text-align: center;">
                                <i class="fas fa-file-alt" style="color: #4ec7d2;"></i> 4° Parcial
                            </label>
                            <input type="number" 
                                   name="cuarto_parcial" 
                                   id="cuarto_parcial"
                                   value="{{ old('cuarto_parcial', $calificacion->cuarto_parcial) }}"
                                   step="0.01" 
                                   min="0" 
                                   max="100"
                                   placeholder="0.00"
                                   style="width: 100%; padding: 0.75rem; border: 2px solid #bfd9ea; border-radius: 8px; text-align: center; font-size: 1rem; font-weight: 600; transition: all 0.3s ease; font-family: 'Poppins', sans-serif; background: white; color: #003b73; @error('cuarto_parcial') border-color: #ef4444; @enderror"
                                   onfocus="this.style.borderColor='#4ec7d2'; this.style.boxShadow='0 0 0 3px rgba(78, 199, 210, 0.1)';"
                                   onblur="this.style.borderColor='#bfd9ea'; this.style.boxShadow='none';">
                            
                            @error('cuarto_parcial')
                                <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem; text-align: center; font-family: 'Poppins', sans-serif;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Sección: Recuperación -->
                <div style="margin-bottom: 2rem;">
                    <h2 style="color: #003b73; font-size: 1.25rem; font-weight: 700; margin-bottom: 1.25rem; border-left: 4px solid #4ec7d2; padding-left: 0.75rem; font-family: 'Poppins', sans-serif;">
                        Examen de Recuperación
                    </h2>

                    <div>
                        <label for="recuperacion" style="display: block; color: #003b73; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.95rem; font-family: 'Poppins', sans-serif;">
                            Nota de Recuperación (Opcional)
                        </label>
                        <input type="number" 
                               name="recuperacion" 
                               id="recuperacion"
                               value="{{ old('recuperacion', $calificacion->recuperacion) }}"
                               step="0.01" 
                               min="0" 
                               max="100"
                               placeholder="0.00"
                               style="width: 100%; padding: 0.875rem 1rem; border: 2px solid #bfd9ea; border-radius: 8px; text-align: center; font-size: 1.1rem; font-weight: 600; transition: all 0.3s ease; font-family: 'Poppins', sans-serif; background: white; color: #003b73; @error('recuperacion') border-color: #ef4444; @enderror"
                               onfocus="this.style.borderColor='#4ec7d2'; this.style.boxShadow='0 0 0 3px rgba(78, 199, 210, 0.1)';"
                               onblur="this.style.borderColor='#bfd9ea'; this.style.boxShadow='none';">
                        
                        <p style="color: #00508f; font-size: 0.85rem; margin-top: 0.5rem; font-family: 'Poppins', sans-serif; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-info-circle" style="color: #4ec7d2;"></i>
                            Ingrese la nota solo si el alumno realizó el examen de recuperación.
                        </p>

                        @error('recuperacion')
                            <p style="color: #ef4444; font-size: 0.85rem; margin-top: 0.5rem; font-family: 'Poppins', sans-serif;">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Aviso Importante -->
                <div style="background: linear-gradient(135deg, rgba(78, 199, 210, 0.1) 0%, rgba(191, 217, 234, 0.2) 100%); border: 2px solid #4ec7d2; border-radius: 10px; padding: 1.25rem; margin-bottom: 2rem;">
                    <p style="color: #00508f; font-size: 0.95rem; font-weight: 600; margin: 0; font-family: 'Poppins', sans-serif; display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fas fa-calculator" style="font-size: 1.5rem; color: #4ec7d2;"></i>
                        <span>La <strong>Nota Final</strong> se calculará automáticamente al guardar los cambios.</span>
                    </p>
                </div>

                <!-- Botones de Acción -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <button type="submit"
                            style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 1rem 1.5rem; border-radius: 10px; font-weight: 700; font-size: 1rem; border: none; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 8px 20px rgba(78, 199, 210, 0.3); font-family: 'Poppins', sans-serif; display: flex; align-items: center; justify-content: center; gap: 0.5rem;"
                            onmouseover="this.style.transform='translateY(-2px) scale(1.02)'; this.style.boxShadow='0 12px 30px rgba(78, 199, 210, 0.4)';"
                            onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 8px 20px rgba(78, 199, 210, 0.3)';">
                        <i class="fas fa-save"></i> Actualizar Calificación
                    </button>
                    
                    <a href="{{ route('calificaciones.index') }}"
                       style="background: #e2e8f0; color: #00508f; padding: 1rem 1.5rem; border-radius: 10px; font-weight: 600; font-size: 1rem; text-decoration: none; text-align: center; transition: all 0.3s ease; border: 2px solid #bfd9ea; font-family: 'Poppins', sans-serif; display: flex; align-items: center; justify-content: center; gap: 0.5rem;"
                       onmouseover="this.style.background='#bfd9ea'; this.style.transform='translateY(-2px)';"
                       onmouseout="this.style.background='#e2e8f0'; this.style.transform='translateY(0)';">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    * {
        font-family: 'Poppins', sans-serif !important;
    }

    body {
        background: linear-gradient(to bottom, #f8f9fa 0%, #ffffff 100%);
    }

    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(78, 199, 210, 0.3);
        background: #bfd9ea !important;
    }

    /* Animación de entrada */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .container > div {
        animation: fadeInUp 0.6s ease forwards;
    }
</style>
@endsection