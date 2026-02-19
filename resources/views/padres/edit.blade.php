@extends('layouts.app')

@section('title', 'Editar Padre/Tutor')

@section('page-title', 'Editar Padre/Tutor')

@section('topbar-actions')
    <a href="{{ route('padres.show', $padre->id) }}" class="btn-back" style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #4ec7d2; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.2); font-size: 0.9rem;">
        <i class="fas fa-times"></i>
        Cancelar
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 1200px;">
    
    <!-- Mensajes de error -->
    @if ($errors->any())
        <div class="alert alert-dismissible fade show mb-3" style="background: #fee2e2; border: 1px solid #ef4444; border-radius: 10px; color: #991b1b;" role="alert">
            <div class="d-flex align-items-start">
                <i class="fas fa-exclamation-triangle me-3" style="font-size: 1.2rem; margin-top: 2px;"></i>
                <div class="flex-grow-1">
                    <strong>Por favor corrige los siguientes errores:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Formulario -->
    <form action="{{ route('padres.update', $padre->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Datos Personales -->
        <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
            <div class="card-header" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-bottom: 2px solid #4ec7d2; border-radius: 10px 10px 0 0;">
                <h5 class="mb-0" style="color: #003b73; font-weight: 700; font-size: 1rem;">
                    <i class="fas fa-id-card me-2" style="color: #4ec7d2;"></i>
                    Datos Personales
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <!-- Nombre -->
                    <div class="col-md-6">
                        <label for="nombre" class="form-label small fw-semibold" style="color: #003b73;">
                            Nombre <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('nombre') is-invalid @enderror" 
                               id="nombre" 
                               name="nombre" 
                               value="{{ old('nombre', $padre->nombre) }}"
                               style="border: 2px solid #bfd9ea; border-radius: 8px; transition: all 0.3s ease;" 
                               required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Apellido -->
                    <div class="col-md-6">
                        <label for="apellido" class="form-label small fw-semibold" style="color: #003b73;">
                            Apellido <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('apellido') is-invalid @enderror" 
                               id="apellido" 
                               name="apellido" 
                               value="{{ old('apellido', $padre->apellido) }}"
                               style="border: 2px solid #bfd9ea; border-radius: 8px; transition: all 0.3s ease;" 
                               required>
                        @error('apellido')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- DNI -->
                    <div class="col-md-6">
                        <label for="dni" class="form-label small fw-semibold" style="color: #003b73;">
                            DNI <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('dni') is-invalid @enderror" 
                               id="dni" 
                               name="dni" 
                               value="{{ old('dni', $padre->dni) }}"
                               style="border: 2px solid #bfd9ea; border-radius: 8px; transition: all 0.3s ease;" 
                               maxlength="13"
                               required>
                        @error('dni')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Parentesco -->
                    <div class="col-md-6">
                        <label for="parentesco" class="form-label small fw-semibold" style="color: #003b73;">
                            Parentesco <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('parentesco') is-invalid @enderror" 
                                id="parentesco" 
                                name="parentesco"
                                style="border: 2px solid #bfd9ea; border-radius: 8px; transition: all 0.3s ease;" 
                                required>
                            <option value="">Seleccione...</option>
                            <option value="padre" {{ old('parentesco', $padre->parentesco) == 'padre' ? 'selected' : '' }}>Padre</option>
                            <option value="madre" {{ old('parentesco', $padre->parentesco) == 'madre' ? 'selected' : '' }}>Madre</option>
                            <option value="tutor_legal" {{ old('parentesco', $padre->parentesco) == 'tutor_legal' ? 'selected' : '' }}>Tutor Legal</option>
                            <option value="abuelo" {{ old('parentesco', $padre->parentesco) == 'abuelo' ? 'selected' : '' }}>Abuelo</option>
                            <option value="abuela" {{ old('parentesco', $padre->parentesco) == 'abuela' ? 'selected' : '' }}>Abuela</option>
                            <option value="tio" {{ old('parentesco', $padre->parentesco) == 'tio' ? 'selected' : '' }}>Tío</option>
                            <option value="tia" {{ old('parentesco', $padre->parentesco) == 'tia' ? 'selected' : '' }}>Tía</option>
                            <option value="otro" {{ old('parentesco', $padre->parentesco) == 'otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('parentesco')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Otro Parentesco -->
                    <div class="col-md-12" id="otro-parentesco-div" style="display: {{ old('parentesco', $padre->parentesco) == 'otro' ? 'block' : 'none' }};">
                        <label for="parentesco_otro" class="form-label small fw-semibold" style="color: #003b73;">
                            Especifique el Parentesco
                        </label>
                        <input type="text" 
                               class="form-control @error('parentesco_otro') is-invalid @enderror" 
                               id="parentesco_otro" 
                               name="parentesco_otro" 
                               value="{{ old('parentesco_otro', $padre->parentesco_otro) }}"
                               style="border: 2px solid #bfd9ea; border-radius: 8px; transition: all 0.3s ease;" 
                               maxlength="50">
                        @error('parentesco_otro')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Estado -->
                    <div class="col-md-12">
                        <label for="estado" class="form-label small fw-semibold" style="color: #003b73;">
                            Estado <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('estado') is-invalid @enderror" 
                                id="estado" 
                                name="estado"
                                style="border: 2px solid #bfd9ea; border-radius: 8px; transition: all 0.3s ease;" 
                                required>
                            <option value="1" {{ old('estado', $padre->estado) == '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('estado', $padre->estado) == '0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('estado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Datos de Contacto -->
        <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
            <div class="card-header" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-bottom: 2px solid #4ec7d2; border-radius: 10px 10px 0 0;">
                <h5 class="mb-0" style="color: #003b73; font-weight: 700; font-size: 1rem;">
                    <i class="fas fa-phone me-2" style="color: #4ec7d2;"></i>
                    Datos de Contacto
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <!-- Correo -->
                    <div class="col-md-6">
                        <label for="correo" class="form-label small fw-semibold" style="color: #003b73;">
                            Correo Electrónico
                        </label>
                        <input type="email" 
                               class="form-control @error('correo') is-invalid @enderror" 
                               id="correo" 
                               name="correo" 
                               value="{{ old('correo', $padre->correo) }}"
                               style="border: 2px solid #bfd9ea; border-radius: 8px; transition: all 0.3s ease;">
                        @error('correo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Teléfono -->
                    <div class="col-md-6">
                        <label for="telefono" class="form-label small fw-semibold" style="color: #003b73;">
                            Teléfono <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('telefono') is-invalid @enderror" 
                               id="telefono" 
                               name="telefono" 
                               value="{{ old('telefono', $padre->telefono) }}"
                               style="border: 2px solid #bfd9ea; border-radius: 8px; transition: all 0.3s ease;" 
                               maxlength="8"
                               required>
                        <small class="text-muted">Formato: 8 dígitos</small>
                        @error('telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Teléfono Secundario -->
                    <div class="col-md-6">
                        <label for="telefono_secundario" class="form-label small fw-semibold" style="color: #003b73;">
                            Teléfono Secundario
                        </label>
                        <input type="text" 
                               class="form-control @error('telefono_secundario') is-invalid @enderror" 
                               id="telefono_secundario" 
                               name="telefono_secundario" 
                               value="{{ old('telefono_secundario', $padre->telefono_secundario) }}"
                               style="border: 2px solid #bfd9ea; border-radius: 8px; transition: all 0.3s ease;" 
                               maxlength="8">
                        <small class="text-muted">Formato: 8 dígitos</small>
                        @error('telefono_secundario')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Dirección -->
                    <div class="col-md-12">
                        <label for="direccion" class="form-label small fw-semibold" style="color: #003b73;">
                            Dirección
                        </label>
                        <textarea class="form-control @error('direccion') is-invalid @enderror" 
                                  id="direccion" 
                                  name="direccion" 
                                  rows="2"
                                  style="border: 2px solid #bfd9ea; border-radius: 8px; transition: all 0.3s ease;">{{ old('direccion', $padre->direccion) }}</textarea>
                        @error('direccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Información Laboral -->
        <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
            <div class="card-header" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-bottom: 2px solid #4ec7d2; border-radius: 10px 10px 0 0;">
                <h5 class="mb-0" style="color: #003b73; font-weight: 700; font-size: 1rem;">
                    <i class="fas fa-briefcase me-2" style="color: #4ec7d2;"></i>
                    Información Laboral
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <!-- Ocupación -->
                    <div class="col-md-4">
                        <label for="ocupacion" class="form-label small fw-semibold" style="color: #003b73;">
                            Ocupación
                        </label>
                        <input type="text" 
                               class="form-control @error('ocupacion') is-invalid @enderror" 
                               id="ocupacion" 
                               name="ocupacion" 
                               value="{{ old('ocupacion', $padre->ocupacion) }}"
                               style="border: 2px solid #bfd9ea; border-radius: 8px; transition: all 0.3s ease;">
                        @error('ocupacion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Lugar de Trabajo -->
                    <div class="col-md-4">
                        <label for="lugar_trabajo" class="form-label small fw-semibold" style="color: #003b73;">
                            Lugar de Trabajo
                        </label>
                        <input type="text" 
                               class="form-control @error('lugar_trabajo') is-invalid @enderror" 
                               id="lugar_trabajo" 
                               name="lugar_trabajo" 
                               value="{{ old('lugar_trabajo', $padre->lugar_trabajo) }}"
                               style="border: 2px solid #bfd9ea; border-radius: 8px; transition: all 0.3s ease;">
                        @error('lugar_trabajo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Teléfono de Trabajo -->
                    <div class="col-md-4">
                        <label for="telefono_trabajo" class="form-label small fw-semibold" style="color: #003b73;">
                            Teléfono de Trabajo
                        </label>
                        <input type="text" 
                               class="form-control @error('telefono_trabajo') is-invalid @enderror" 
                               id="telefono_trabajo" 
                               name="telefono_trabajo" 
                               value="{{ old('telefono_trabajo', $padre->telefono_trabajo) }}"
                               style="border: 2px solid #bfd9ea; border-radius: 8px; transition: all 0.3s ease;" 
                               maxlength="8">
                        <small class="text-muted">Formato: 8 dígitos</small>
                        @error('telefono_trabajo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Observaciones -->
        <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
            <div class="card-header" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-bottom: 2px solid #4ec7d2; border-radius: 10px 10px 0 0;">
                <h5 class="mb-0" style="color: #003b73; font-weight: 700; font-size: 1rem;">
                    <i class="fas fa-clipboard me-2" style="color: #4ec7d2;"></i>
                    Observaciones
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-12">
                        <label for="observaciones" class="form-label small fw-semibold" style="color: #003b73;">
                            Observaciones Adicionales
                        </label>
                        <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                  id="observaciones" 
                                  name="observaciones" 
                                  rows="3"
                                  style="border: 2px solid #bfd9ea; border-radius: 8px; transition: all 0.3s ease;">{{ old('observaciones', $padre->observaciones) }}</textarea>
                        @error('observaciones')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('padres.show', $padre->id) }}" class="btn" style="border: 2px solid #ef4444; color: #ef4444; background: white; border-radius: 8px; padding: 0.5rem 1.5rem; font-weight: 600; transition: all 0.3s ease;">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </a>
                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 8px; padding: 0.5rem 1.5rem; font-weight: 600; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); transition: all 0.3s ease;">
                        <i class="fas fa-save me-1"></i> Guardar Cambios
                    </button>
                </div>
            </div>
        </div>

    </form>

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
        box-shadow: 0 4px 12px rgba(78, 199, 210, 0.4) !important;
    }

    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(78, 199, 210, 0.4) !important;
    }
</style>
@endpush

@push('scripts')
<script>
document.getElementById('parentesco').addEventListener('change', function() {
    const otroDiv = document.getElementById('otro-parentesco-div');
    if (this.value === 'otro') {
        otroDiv.style.display = 'block';
    } else {
        otroDiv.style.display = 'none';
    }
});
</script>
@endpush
@endsection