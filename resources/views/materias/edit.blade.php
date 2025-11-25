@extends('layouts.admin')

@section('title', 'Editar Materia')

@section('page-title', 'Editar Materia')

@section('topbar-actions')
    <a href="{{ route('materias.index') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
@endsection

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-9">
            
            <!-- Card Principal -->
            <div class="edit-card">
                
                <!-- Header con Información de la Materia -->
                <div class="edit-header">
                    <div class="header-content">
                        <div class="header-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <div>
                            <h4 class="header-title">Editar Materia</h4>
                            <p class="header-subtitle">{{ $materia->nombre }} - {{ $materia->codigo }}</p>
                        </div>
                    </div>
                    <div class="header-badge">
                        <i class="fas fa-edit"></i>
                        Modificar
                    </div>
                </div>

                <!-- Formulario -->
                <div class="edit-body">
                    <form action="{{ route('materias.update', $materia) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Sección: Información Básica -->
                        <div class="form-section">
                            <div class="section-header">
                                <div class="section-icon">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <h6 class="section-title">Información Básica</h6>
                            </div>

                            <div class="row g-4">
                                <!-- Nivel Educativo -->
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label class="form-label-modern">
                                            <i class="fas fa-layer-group"></i>
                                            Nivel Educativo
                                            <span class="required-mark">*</span>
                                        </label>
                                        <select class="form-control-modern @error('nivel') is-invalid @enderror" 
                                                id="nivel" 
                                                name="nivel"
                                                required>
                                            <option value="">Seleccionar nivel...</option>
                                            <option value="primaria" {{ old('nivel', $materia->nivel) == 'primaria' ? 'selected' : '' }}>
                                                📚 Primaria (1° - 6° Grado)
                                            </option>
                                            <option value="secundaria" {{ old('nivel', $materia->nivel) == 'secundaria' ? 'selected' : '' }}>
                                                🎓 Secundaria (7° - 9° Grado)
                                            </option>
                                        </select>
                                        @error('nivel')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Nombre de la Materia -->
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label class="form-label-modern">
                                            <i class="fas fa-book"></i>
                                            Nombre de la Materia
                                            <span class="required-mark">*</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control-modern @error('nombre') is-invalid @enderror" 
                                               id="nombre" 
                                               name="nombre" 
                                               value="{{ old('nombre', $materia->nombre) }}"
                                               placeholder="Ej: Matemáticas"
                                               required>
                                        @error('nombre')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Código -->
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label class="form-label-modern">
                                            <i class="fas fa-barcode"></i>
                                            Código de Materia
                                            <span class="required-mark">*</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control-modern code-input @error('codigo') is-invalid @enderror" 
                                               id="codigo" 
                                               name="codigo" 
                                               value="{{ old('codigo', $materia->codigo) }}"
                                               placeholder="Ej: MAT-101"
                                               required>
                                        @error('codigo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Área -->
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label class="form-label-modern">
                                            <i class="fas fa-shapes"></i>
                                            Área de Conocimiento
                                            <span class="required-mark">*</span>
                                        </label>
                                        <select class="form-control-modern @error('area') is-invalid @enderror" 
                                                id="area" 
                                                name="area"
                                                required>
                                            <option value="">Seleccionar área...</option>
                                            <option value="Matemáticas" {{ old('area', $materia->area) == 'Matemáticas' ? 'selected' : '' }}>📐 Matemáticas</option>
                                            <option value="Español" {{ old('area', $materia->area) == 'Español' ? 'selected' : '' }}>📖 Español</option>
                                            <option value="Ciencias Naturales" {{ old('area', $materia->area) == 'Ciencias Naturales' ? 'selected' : '' }}>🔬 Ciencias Naturales</option>
                                            <option value="Ciencias Sociales" {{ old('area', $materia->area) == 'Ciencias Sociales' ? 'selected' : '' }}>🌍 Ciencias Sociales</option>
                                            <option value="Educación Física" {{ old('area', $materia->area) == 'Educación Física' ? 'selected' : '' }}>⚽ Educación Física</option>
                                            <option value="Educación Artística" {{ old('area', $materia->area) == 'Educación Artística' ? 'selected' : '' }}>🎨 Educación Artística</option>
                                            <option value="Inglés" {{ old('area', $materia->area) == 'Inglés' ? 'selected' : '' }}>🇬🇧 Inglés</option>
                                            <option value="Informática" {{ old('area', $materia->area) == 'Informática' ? 'selected' : '' }}>💻 Informática</option>
                                            <option value="Formación Ciudadana" {{ old('area', $materia->area) == 'Formación Ciudadana' ? 'selected' : '' }}>🏛️ Formación Ciudadana</option>
                                        </select>
                                        @error('area')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sección: Detalles Adicionales -->
                        <div class="form-section">
                            <div class="section-header">
                                <div class="section-icon">
                                    <i class="fas fa-align-left"></i>
                                </div>
                                <h6 class="section-title">Detalles Adicionales</h6>
                            </div>

                            <div class="row g-4">
                                <!-- Descripción -->
                                <div class="col-12">
                                    <div class="form-group-modern">
                                        <label class="form-label-modern">
                                            <i class="fas fa-file-alt"></i>
                                            Descripción
                                            <span class="optional-mark">(Opcional)</span>
                                        </label>
                                        <textarea class="form-control-modern @error('descripcion') is-invalid @enderror" 
                                                  id="descripcion" 
                                                  name="descripcion" 
                                                  rows="4"
                                                  placeholder="Descripción detallada de la materia, objetivos y contenidos...">{{ old('descripcion', $materia->descripcion) }}</textarea>
                                        @error('descripcion')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sección: Estado -->
                        <div class="form-section">
                            <div class="section-header">
                                <div class="section-icon">
                                    <i class="fas fa-toggle-on"></i>
                                </div>
                                <h6 class="section-title">Estado de la Materia</h6>
                            </div>

                            <div class="status-toggle-card">
                                <div class="toggle-content">
                                    <div class="toggle-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="toggle-info">
                                        <h6 class="toggle-title">Materia Activa</h6>
                                        <p class="toggle-description">
                                            Las materias activas están disponibles para ser asignadas a docentes y estudiantes
                                        </p>
                                    </div>
                                </div>
                                <div class="toggle-switch">
                                    <input type="checkbox" 
                                           class="toggle-checkbox" 
                                           id="activo" 
                                           name="activo" 
                                           value="1"
                                           {{ old('activo', $materia->activo) ? 'checked' : '' }}>
                                    <label class="toggle-label" for="activo">
                                        <span class="toggle-inner"></span>
                                        <span class="toggle-switch-btn"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="form-actions">
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-save"></i>
                                Guardar Cambios
                            </button>
                            <a href="{{ route('materias.index') }}" class="btn-cancel-form">
                                <i class="fas fa-times"></i>
                                Cancelar
                            </a>
                        </div>

                    </form>
                </div>

            </div>

        </div>
    </div>
</div>

@push('styles')
<style>
:root {
    --primary: #00508f;
    --secondary: #4ec7d2;
    --warning: #f59e0b;
    --warning-dark: #d97706;
    --success: #10b981;
    --danger: #ef4444;
    --light: #f8fafc;
    --dark: #1e293b;
    --border: #e2e8f0;
}

/* Botón Volver */
.btn-back {
    background: white;
    color: var(--primary);
    padding: 0.625rem 1.5rem;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    border: 2px solid var(--primary);
    box-shadow: 0 2px 8px rgba(0, 80, 143, 0.15);
    font-size: 0.938rem;
}

.btn-back:hover {
    background: var(--primary);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 80, 143, 0.25);
}

/* Card Principal */
.edit-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    margin-bottom: 2rem;
}

/* Header */
.edit-header {
    background: linear-gradient(135deg, var(--warning) 0%, var(--warning-dark) 100%);
    padding: 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
}

.header-content {
    display: flex;
    align-items: center;
    gap: 1.25rem;
}

.header-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.75rem;
    border: 3px solid rgba(255, 255, 255, 0.3);
}

.header-title {
    color: white;
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0 0 0.25rem 0;
}

.header-subtitle {
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.938rem;
    margin: 0;
    font-weight: 500;
}

.header-badge {
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    color: white;
    padding: 0.625rem 1.25rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.875rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

/* Body */
.edit-body {
    padding: 2.5rem;
}

/* Secciones del Formulario */
.form-section {
    margin-bottom: 2.5rem;
    padding-bottom: 2rem;
    border-bottom: 2px solid var(--border);
}

.form-section:last-of-type {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.section-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.section-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(217, 119, 6, 0.1) 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--warning);
    font-size: 1.125rem;
}

.section-title {
    color: var(--dark);
    font-weight: 700;
    font-size: 1.125rem;
    margin: 0;
}

/* Form Groups */
.form-group-modern {
    margin-bottom: 0;
}

.form-label-modern {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--dark);
    font-weight: 600;
    font-size: 0.875rem;
    margin-bottom: 0.625rem;
}

.form-label-modern i {
    color: var(--warning);
    font-size: 0.875rem;
}

.required-mark {
    color: var(--danger);
    font-weight: 700;
}

.optional-mark {
    color: #94a3b8;
    font-weight: 500;
    font-size: 0.813rem;
}

.form-control-modern {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid var(--border);
    border-radius: 10px;
    font-size: 0.938rem;
    transition: all 0.3s ease;
    background: white;
}

.form-control-modern:focus {
    outline: none;
    border-color: var(--warning);
    box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1);
}

.form-control-modern::placeholder {
    color: #94a3b8;
}

textarea.form-control-modern {
    resize: vertical;
    min-height: 100px;
}

.code-input {
    font-family: 'Courier New', monospace;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.is-invalid {
    border-color: var(--danger) !important;
}

.invalid-feedback {
    color: var(--danger);
    font-size: 0.813rem;
    margin-top: 0.375rem;
    display: block;
}

/* Toggle Status Card */
.status-toggle-card {
    background: linear-gradient(135deg, var(--light) 0%, white 100%);
    border: 2px solid var(--border);
    border-radius: 12px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
}

.toggle-content {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
}

.toggle-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.toggle-info {
    flex: 1;
}

.toggle-title {
    color: var(--dark);
    font-weight: 700;
    font-size: 1rem;
    margin: 0 0 0.25rem 0;
}

.toggle-description {
    color: #64748b;
    font-size: 0.875rem;
    margin: 0;
    line-height: 1.4;
}

/* Toggle Switch */
.toggle-switch {
    flex-shrink: 0;
}

.toggle-checkbox {
    display: none;
}

.toggle-label {
    display: block;
    width: 60px;
    height: 32px;
    background: #cbd5e1;
    border-radius: 50px;
    position: relative;
    cursor: pointer;
    transition: all 0.3s ease;
}

.toggle-checkbox:checked + .toggle-label {
    background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
}

.toggle-switch-btn {
    position: absolute;
    top: 3px;
    left: 3px;
    width: 26px;
    height: 26px;
    background: white;
    border-radius: 50%;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.toggle-checkbox:checked + .toggle-label .toggle-switch-btn {
    left: 31px;
}

/* Form Actions */
.form-actions {
    display: flex;
    gap: 1rem;
    padding-top: 2rem;
    margin-top: 2rem;
    border-top: 2px solid var(--border);
}

.btn-submit {
    flex: 1;
    background: linear-gradient(135deg, var(--warning) 0%, var(--warning-dark) 100%);
    color: white;
    border: none;
    padding: 0.875rem 2rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.938rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.25);
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(245, 158, 11, 0.35);
}

.btn-cancel-form {
    flex: 1;
    background: white;
    color: #64748b;
    border: 2px solid var(--border);
    padding: 0.875rem 2rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.938rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-cancel-form:hover {
    background: var(--light);
    border-color: #cbd5e1;
    transform: translateY(-2px);
}

/* Responsive */
@media (max-width: 767px) {
    .edit-header {
        padding: 1.5rem;
    }

    .header-content {
        flex-direction: column;
        text-align: center;
    }

    .header-icon {
        width: 50px;
        height: 50px;
        font-size: 1.5rem;
    }

    .header-title {
        font-size: 1.25rem;
    }

    .edit-body {
        padding: 1.5rem;
    }

    .form-actions {
        flex-direction: column;
    }

    .btn-submit,
    .btn-cancel-form {
        width: 100%;
    }

    .status-toggle-card {
        flex-direction: column;
        text-align: center;
    }
}
</style>
@endpush

@endsection