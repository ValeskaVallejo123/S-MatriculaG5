@extends('layouts.app')

@section('title', 'Buscar Padre/Tutor')

@section('page-title', 'Vincular Padre con Estudiante')

@section('content')
<div class="container-fluid px-4">

    <!-- Información del Estudiante -->
    @if(isset($estudiante) && $estudiante)
    <div class="row mb-4">
        <div class="col-12">
            <div class="student-info-card">
                <div class="student-info-content">
                    <div class="student-avatar">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="student-details">
                        <span class="student-label">Vincular padre/tutor para:</span>
                        <h3 class="student-name">{{ $estudiante->nombre }} {{ $estudiante->apellido }}</h3>
                        @if($estudiante->grado)
                        <div class="student-meta">
                            <span class="meta-item">
                                <i class="fas fa-graduation-cap"></i>
                                Grado: {{ $estudiante->grado }}
                            </span>
                            <span class="meta-separator">•</span>
                            <span class="meta-item">
                                <i class="fas fa-id-badge"></i>
                                ID: {{ $estudiante->id }}
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Formulario de Búsqueda -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="search-card">
                <div class="search-card-header">
                    <div class="d-flex align-items-center">
                        <div class="header-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <div>
                            <h5 class="header-title">Buscar Padre/Tutor</h5>
                            <p class="header-subtitle">Ingresa al menos un criterio de búsqueda</p>
                        </div>
                    </div>
                </div>
                <div class="search-card-body">
                    <form action="{{ route('padres.buscar') }}" method="GET">
                        @if(isset($estudiante) && $estudiante)
                            <input type="hidden" name="estudiante_id" value="{{ $estudiante->id }}">
                        @endif

                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="form-group-modern">
                                    <label class="form-label-modern">
                                        <i class="fas fa-user"></i>
                                        Nombre o Apellido
                                    </label>
                                    <input type="text"
                                           name="nombre"
                                           class="form-control-modern"
                                           placeholder="Ej: Juan Pérez"
                                           value="{{ request('nombre') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group-modern">
                                    <label class="form-label-modern">
                                        <i class="fas fa-id-card"></i>
                                        DNI/Identidad
                                    </label>
                                    <input type="text"
                                           name="identidad"
                                           class="form-control-modern"
                                           placeholder="Ej: 0801-1990-12345"
                                           value="{{ request('identidad') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group-modern">
                                    <label class="form-label-modern">
                                        <i class="fas fa-phone"></i>
                                        Teléfono
                                    </label>
                                    <input type="text"
                                           name="telefono"
                                           class="form-control-modern"
                                           placeholder="Ej: 9999-9999"
                                           value="{{ request('telefono') }}">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="action-buttons">
                                    <button type="submit" class="btn-search">
                                        <i class="fas fa-search"></i>
                                        Buscar Padres
                                    </button>
                                    <a href="{{ isset($estudiante) ? route('estudiantes.show', $estudiante->id) : route('padres.index') }}"
                                       class="btn-cancel">
                                        <i class="fas fa-times"></i>
                                        Cancelar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Resultados de Búsqueda -->
    @if(request()->anyFilled(['nombre', 'identidad', 'telefono']))
    <div class="row">
        <div class="col-12">
            <div class="results-card">
                <div class="results-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="results-icon">
                                <i class="fas fa-list"></i>
                            </div>
                            <h6 class="results-title">Resultados de Búsqueda</h6>
                        </div>
                        <span class="results-badge">
                            {{ $padres->count() }} {{ $padres->count() == 1 ? 'encontrado' : 'encontrados' }}
                        </span>
                    </div>
                </div>
                <div class="results-body">
                    @if($padres->count() > 0)
                        @foreach($padres as $padre)
                        <div class="parent-card">
                            <div class="row align-items-center g-3">
                                <!-- Información del Padre -->
                                <div class="col-lg-5">
                                    <div class="parent-info">
                                        <div class="parent-avatar">
                                            {{ substr($padre->nombre, 0, 1) }}{{ substr($padre->apellido, 0, 1) }}
                                        </div>
                                        <div class="parent-details">
                                            <h6 class="parent-name">{{ $padre->nombre }} {{ $padre->apellido }}</h6>
                                            <div class="parent-meta">
                                                @if($padre->dni)
                                                <span class="meta-badge">
                                                    <i class="fas fa-id-card"></i>
                                                    {{ $padre->dni }}
                                                </span>
                                                @endif
                                                <span class="meta-badge meta-badge-primary">
                                                    <i class="fas fa-user-tag"></i>
                                                    {{ ucfirst($padre->parentesco) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contacto -->
                                <div class="col-lg-4">
                                    <div class="contact-info">
                                        @if($padre->telefono)
                                        <div class="contact-item">
                                            <i class="fas fa-phone"></i>
                                            <span>{{ $padre->telefono }}</span>
                                        </div>
                                        @endif
                                        @if($padre->correo)
                                        <div class="contact-item">
                                            <i class="fas fa-envelope"></i>
                                            <span>{{ $padre->correo }}</span>
                                        </div>
                                        @endif
                                        @if(!$padre->telefono && !$padre->correo)
                                        <div class="contact-item text-muted">
                                            <i class="fas fa-info-circle"></i>
                                            <span>Sin contacto registrado</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Acción -->
                                <div class="col-lg-3">
                                    <div class="parent-actions">
                                        @if(isset($estudiante) && $estudiante)
                                            <button type="button"
                                                    class="btn-link-parent"
                                                    onclick="mostrarModalVincular({{ $padre->id }}, '{{ $padre->nombre }} {{ $padre->apellido }}', {{ $estudiante->id }}, '{{ $estudiante->nombre }} {{ $estudiante->apellido }}')">
                                                <i class="fas fa-link"></i>
                                                Vincular Padre
                                            </button>
                                        @else
                                            <a href="{{ route('padres.show', $padre->id) }}" class="btn-view-details">
                                                <i class="fas fa-eye"></i>
                                                Ver Detalles
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h5 class="empty-title">No se encontraron resultados</h5>
                        <p class="empty-text">No hay padres/tutores que coincidan con tu búsqueda. Intenta con otros criterios.</p>
                        <a href="{{ route('padres.create') }}" class="btn-create-new">
                            <i class="fas fa-plus-circle"></i>
                            Registrar Nuevo Padre/Tutor
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Estado inicial -->
    <div class="row">
        <div class="col-12">
            <div class="initial-state-card">
                <div class="initial-state-content">
                    <div class="initial-state-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h4 class="initial-state-title">Busca un padre o tutor</h4>
                    <p class="initial-state-text">
                        Completa el formulario superior con al menos un criterio de búsqueda para encontrar padres/tutores registrados en el sistema.
                    </p>
                    <div class="initial-state-tips">
                        <div class="tip-item">
                            <i class="fas fa-lightbulb"></i>
                            <span>Puedes buscar por nombre, DNI o teléfono</span>
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-info-circle"></i>
                            <span>Los resultados se mostrarán automáticamente</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>

<!-- Modal de Confirmación de Vinculación -->
<div class="modal-vincular-overlay" id="modalVincular">
    <div class="modal-vincular">
        <button type="button" class="modal-close-btn" onclick="cerrarModalVincular()">
            <i class="fas fa-times"></i>
        </button>

        <div class="modal-header-custom">
            <div class="modal-icon-custom">
                <i class="fas fa-link"></i>
            </div>
            <h5 class="modal-title-custom">Confirmar Vinculación</h5>
        </div>

        <div class="modal-body-custom">
            <div class="vinculacion-preview">
                <div class="preview-item">
                    <i class="fas fa-user-tie"></i>
                    <span id="modalPadreNombre"></span>
                </div>
                <div class="preview-separator">
                    <i class="fas fa-link"></i>
                </div>
                <div class="preview-item">
                    <i class="fas fa-user-graduate"></i>
                    <span id="modalEstudianteNombre"></span>
                </div>
            </div>

            <p class="modal-message-custom">
                ¿Deseas vincular este padre/tutor con el estudiante?
            </p>
        </div>

        <form id="formVincular" method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="estudiante_id" id="formEstudianteId">
        </form>

        <div class="modal-footer-custom">
            <button type="button" class="btn-modal-cancel" onclick="cerrarModalVincular()">
                <i class="fas fa-times"></i>
                Cancelar
            </button>
            <button type="button" class="btn-modal-confirm" onclick="confirmarVinculacion()">
                <i class="fas fa-check"></i>
                Confirmar
            </button>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
:root {
    --primary: #00508f;
    --secondary: #4ec7d2;
    --success: #10b981;
    --danger: #ef4444;
    --warning: #fbbf24;
    --light: #f8fafc;
    --dark: #1e293b;
    --border: #e2e8f0;
}

/* Student Info Card */
.student-info-card {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 12px rgba(0, 80, 143, 0.15);
    position: relative;
    overflow: hidden;
}

.student-info-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 300px;
    height: 300px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

.student-info-content {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    position: relative;
    z-index: 1;
}

.student-avatar {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    backdrop-filter: blur(10px);
    border: 3px solid rgba(255, 255, 255, 0.3);
    flex-shrink: 0;
}

.student-label {
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.875rem;
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.student-name {
    color: white;
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0 0 0.5rem 0;
}

.student-meta {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.meta-item {
    color: rgba(255, 255, 255, 0.95);
    font-size: 0.875rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.meta-separator {
    color: rgba(255, 255, 255, 0.5);
}

/* Search Card */
.search-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

.search-card-header {
    background: linear-gradient(135deg, var(--light) 0%, #e2e8f0 100%);
    padding: 1.5rem 2rem;
    border-bottom: 2px solid var(--border);
}

.header-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    margin-right: 1rem;
}

.header-title {
    color: var(--primary);
    font-size: 1.25rem;
    font-weight: 700;
    margin: 0;
}

.header-subtitle {
    color: #64748b;
    font-size: 0.875rem;
    margin: 0;
}

.search-card-body {
    padding: 2rem;
}

/* Form Modern */
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
    margin-bottom: 0.5rem;
}

.form-label-modern i {
    color: var(--primary);
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
    border-color: var(--secondary);
    box-shadow: 0 0 0 4px rgba(78, 199, 210, 0.1);
}

.form-control-modern::placeholder {
    color: #94a3b8;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.btn-search {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    color: white;
    border: none;
    padding: 0.875rem 2rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.938rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0, 80, 143, 0.2);
}

.btn-search:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 80, 143, 0.3);
}

.btn-cancel {
    background: white;
    color: #64748b;
    border: 2px solid var(--border);
    padding: 0.875rem 2rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.938rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-cancel:hover {
    background: var(--light);
    border-color: #cbd5e1;
}

/* Results Card */
.results-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

.results-header {
    background: white;
    padding: 1.5rem 2rem;
    border-bottom: 2px solid var(--border);
}

.results-icon {
    width: 40px;
    height: 40px;
    background: rgba(0, 80, 143, 0.1);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    margin-right: 1rem;
}

.results-title {
    color: var(--dark);
    font-weight: 700;
    margin: 0;
}

.results-badge {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    color: white;
    padding: 0.5rem 1.25rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.875rem;
}

.results-body {
    padding: 1.5rem;
}

/* Parent Card */
.parent-card {
    background: white;
    border: 2px solid var(--border);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.parent-card:last-child {
    margin-bottom: 0;
}

.parent-card:hover {
    border-color: var(--secondary);
    box-shadow: 0 4px 12px rgba(78, 199, 210, 0.15);
    transform: translateY(-2px);
}

.parent-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.parent-avatar {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, var(--secondary) 0%, var(--primary) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 1.25rem;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(0, 80, 143, 0.2);
}

.parent-name {
    color: var(--dark);
    font-weight: 700;
    font-size: 1.063rem;
    margin: 0 0 0.5rem 0;
}

.parent-meta {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.meta-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.25rem 0.75rem;
    background: #f1f5f9;
    color: #64748b;
    border-radius: 6px;
    font-size: 0.813rem;
    font-weight: 500;
}

.meta-badge-primary {
    background: rgba(0, 80, 143, 0.1);
    color: var(--primary);
}

.contact-info {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #64748b;
    font-size: 0.875rem;
}

.contact-item i {
    color: var(--primary);
    width: 20px;
}

.parent-actions {
    display: flex;
    justify-content: flex-end;
}

.btn-link-parent {
    background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.875rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
    width: 100%;
    justify-content: center;
}

.btn-link-parent:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.35);
}

.btn-view-details {
    background: white;
    color: var(--primary);
    border: 2px solid var(--primary);
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.875rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    width: 100%;
    justify-content: center;
}

.btn-view-details:hover {
    background: var(--primary);
    color: white;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, rgba(0, 80, 143, 0.1) 0%, rgba(78, 199, 210, 0.1) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    font-size: 2rem;
    margin: 0 auto 1.5rem;
}

.empty-title {
    color: var(--dark);
    font-weight: 700;
    font-size: 1.25rem;
    margin-bottom: 0.5rem;
}

.empty-text {
    color: #64748b;
    margin-bottom: 1.5rem;
}

.btn-create-new {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    color: white;
    border: none;
    padding: 0.875rem 2rem;
    border-radius: 10px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0, 80, 143, 0.2);
}

.btn-create-new:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 80, 143, 0.3);
}

/* Initial State */
.initial-state-card {
    background: linear-gradient(135deg, var(--light) 0%, white 100%);
    border: 2px dashed var(--border);
    border-radius: 16px;
    padding: 3rem 2rem;
}

.initial-state-content {
    text-align: center;
    max-width: 600px;
    margin: 0 auto;
}

.initial-state-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, rgba(0, 80, 143, 0.1) 0%, rgba(78, 199, 210, 0.1) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    font-size: 2.5rem;
    margin: 0 auto 1.5rem;
}

.initial-state-title {
    color: var(--dark);
    font-weight: 700;
    font-size: 1.5rem;
    margin-bottom: 0.75rem;
}

.initial-state-text {
    color: #64748b;
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 2rem;
}

.initial-state-tips {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    max-width: 400px;
    margin: 0 auto;
}

.tip-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    background: white;
    border-radius: 10px;
    color: #64748b;
    font-size: 0.875rem;
}

.tip-item i {
    color: var(--secondary);
    font-size: 1.25rem;
}

/* Modal de Vinculación - Diseño Compacto */
.modal-vincular-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(4px);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 10000;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.modal-vincular-overlay.show {
    display: flex;
    animation: fadeIn 0.3s ease forwards;
}

@keyframes fadeIn {
    to {
        opacity: 1;
    }
}

.modal-vincular {
    background: white;
    border-radius: 16px;
    max-width: 420px;
    width: 90%;
    box-shadow: 0 10px 40px rgba(0, 80, 143, 0.15);
    transform: scale(0.95);
    animation: scaleUp 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
    position: relative;
    overflow: hidden;
}

@keyframes scaleUp {
    to {
        transform: scale(1);
    }
}

.modal-close-btn {
    position: absolute;
    top: 1rem;
    right: 1rem;
    width: 32px;
    height: 32px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border: none;
    border-radius: 8px;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    z-index: 1;
}

.modal-close-btn:hover {
    background: rgba(255, 255, 255, 0.3);
}

.modal-header-custom {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    padding: 1.5rem;
    text-align: center;
    position: relative;
}

.modal-icon-custom {
    width: 56px;
    height: 56px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 0.75rem;
    color: white;
    font-size: 1.5rem;
    border: 3px solid rgba(255, 255, 255, 0.3);
}

.modal-title-custom {
    color: white;
    font-size: 1.25rem;
    font-weight: 700;
    margin: 0;
}

.modal-body-custom {
    padding: 1.5rem;
}

.vinculacion-preview {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 1rem;
}

.preview-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    background: white;
    border-radius: 8px;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: var(--dark);
    font-size: 0.938rem;
}

.preview-item:last-child {
    margin-bottom: 0;
}

.preview-item i {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.875rem;
    flex-shrink: 0;
}

.preview-separator {
    display: flex;
    justify-content: center;
    padding: 0.25rem 0;
    color: var(--secondary);
    font-size: 1rem;
}

.modal-message-custom {
    text-align: center;
    color: #64748b;
    font-size: 0.938rem;
    margin: 0;
    line-height: 1.5;
}

.modal-footer-custom {
    padding: 1rem 1.5rem 1.5rem;
    display: flex;
    gap: 0.75rem;
}

.btn-modal-cancel,
.btn-modal-confirm {
    flex: 1;
    padding: 0.75rem 1.25rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.875rem;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-modal-cancel {
    background: #f1f5f9;
    color: #64748b;
}

.btn-modal-cancel:hover {
    background: #e2e8f0;
    transform: translateY(-2px);
}

.btn-modal-confirm {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(0, 80, 143, 0.2);
}

.btn-modal-confirm:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 80, 143, 0.3);
}

/* Responsive */
@media (max-width: 991px) {
    .student-info-content {
        flex-direction: column;
        text-align: center;
    }

    .parent-actions {
        justify-content: stretch;
    }

    .btn-link-parent,
    .btn-view-details {
        width: 100%;
    }
}

@media (max-width: 767px) {
    .student-info-card {
        padding: 1.5rem;
    }

    .student-avatar {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }

    .student-name {
        font-size: 1.5rem;
    }

    .search-card-body {
        padding: 1.5rem;
    }

    .action-buttons {
        flex-direction: column;
    }

    .btn-search,
    .btn-cancel {
        width: 100%;
        justify-content: center;
    }

    .parent-card {
        padding: 1rem;
    }

    .modal-vincular {
        max-width: calc(100% - 2rem);
        margin: 1rem;
    }

    .modal-header-custom {
        padding: 1.25rem;
    }

    .modal-icon-custom {
        width: 48px;
        height: 48px;
        font-size: 1.25rem;
    }

    .modal-title-custom {
        font-size: 1.125rem;
    }

    .modal-body-custom {
        padding: 1.25rem;
    }

    .modal-footer-custom {
        flex-direction: column;
        padding: 1rem 1.25rem 1.25rem;
    }

    .btn-modal-cancel,
    .btn-modal-confirm {
        width: 100%;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Variables globales para el modal
let padreIdActual = null;

function mostrarModalVincular(padreId, padreNombre, estudianteId, estudianteNombre) {
    // Guardar datos
    padreIdActual = padreId;

    // Actualizar contenido del modal
    document.getElementById('modalPadreNombre').textContent = padreNombre;
    document.getElementById('modalEstudianteNombre').textContent = estudianteNombre;
    document.getElementById('formEstudianteId').value = estudianteId;
    document.getElementById('formVincular').action = `/padres/${padreId}/vincular`;

    // Mostrar modal
    const modal = document.getElementById('modalVincular');
    modal.classList.add('show');

    // Prevenir scroll del body
    document.body.style.overflow = 'hidden';
}

function cerrarModalVincular() {
    const modal = document.getElementById('modalVincular');
    modal.classList.remove('show');

    // Restaurar scroll del body
    document.body.style.overflow = '';

    // Limpiar datos
    padreIdActual = null;
}

function confirmarVinculacion() {
    // Enviar el formulario
    document.getElementById('formVincular').submit();
}

// Cerrar modal al hacer clic fuera de él
document.addEventListener('click', function(e) {
    const modal = document.getElementById('modalVincular');
    if (e.target === modal) {
        cerrarModalVincular();
    }
});

// Cerrar modal con tecla ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        cerrarModalVincular();
    }
});
</script>
@endpush
