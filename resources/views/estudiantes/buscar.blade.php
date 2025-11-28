@extends('layouts.app')

@section('title', 'Buscar Estudiante')

@section('page-title', 'Buscar Estudiante')

@section('content')
<div class="container-fluid px-4">

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
                            <h5 class="header-title">Buscar Estudiante</h5>
                            <p class="header-subtitle">Ingresa al menos un criterio de búsqueda</p>
                        </div>
                    </div>
                </div>
                <div class="search-card-body">
                    <form action="{{ route('estudiantes.buscar') }}" method="GET">
                        <div class="row g-4">
                            <div class="col-md-3">
                                <div class="form-group-modern">
                                    <label class="form-label-modern">
                                        <i class="fas fa-user"></i>
                                        Nombre
                                    </label>
                                    <input type="text"
                                           name="nombre"
                                           class="form-control-modern"
                                           placeholder="Nombre del estudiante"
                                           value="{{ request('nombre') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group-modern">
                                    <label class="form-label-modern">
                                        <i class="fas fa-id-card"></i>
                                        DNI/Identidad
                                    </label>
                                    <input type="text"
                                           name="dni"
                                           class="form-control-modern"
                                           placeholder="Número de identidad"
                                           value="{{ request('dni') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group-modern">
                                    <label class="form-label-modern">
                                        <i class="fas fa-hashtag"></i>
                                        Código
                                    </label>
                                    <input type="text"
                                           name="codigo"
                                           class="form-control-modern"
                                           placeholder="Código"
                                           value="{{ request('codigo') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group-modern">
                                    <label class="form-label-modern">
                                        <i class="fas fa-graduation-cap"></i>
                                        Grado
                                    </label>
                                    <input type="text"
                                           name="grado"
                                           class="form-control-modern"
                                           placeholder="Ej: 5°"
                                           value="{{ request('grado') }}">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="action-buttons">
                                    <button type="submit" class="btn-search">
                                        <i class="fas fa-search"></i>
                                        Buscar Estudiantes
                                    </button>
                                    <a href="{{ route('estudiantes.index') }}" class="btn-cancel">
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

    <!-- Resultados -->
    @if($busquedaRealizada)
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
                            {{ $estudiantes->count() }} {{ $estudiantes->count() == 1 ? 'encontrado' : 'encontrados' }}
                        </span>
                    </div>
                </div>
                <div class="results-body">
                    @if($estudiantes->count() > 0)
                        @foreach($estudiantes as $estudiante)
                        <div class="student-result-card">
                            <div class="row align-items-center g-3">
                                <div class="col-lg-6">
                                    <div class="student-info">
                                        <div class="student-avatar-small">
                                            @if($estudiante->nombre && $estudiante->apellido)
                                                {{ substr($estudiante->nombre, 0, 1) }}{{ substr($estudiante->apellido, 0, 1) }}
                                            @else
                                                {{ substr($estudiante->nombre ?? 'E', 0, 1) }}{{ substr($estudiante->apellido ?? 'S', 0, 1) }}
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="student-name-small">{{ $estudiante->nombre }} {{ $estudiante->apellido }}</h6>
                                            <div class="student-meta-small">
                                                @if($estudiante->dni)
                                                <span class="meta-badge">
                                                    <i class="fas fa-id-card"></i>
                                                    {{ $estudiante->dni }}
                                                </span>
                                                @endif
                                                @if($estudiante->codigo)
                                                <span class="meta-badge">
                                                    <i class="fas fa-hashtag"></i>
                                                    {{ $estudiante->codigo }}
                                                </span>
                                                @endif
                                                @if($estudiante->grado)
                                                <span class="meta-badge meta-badge-primary">
                                                    <i class="fas fa-graduation-cap"></i>
                                                    {{ $estudiante->grado }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 text-lg-end">
                                    <a href="{{ route('estudiantes.show', $estudiante->id) }}" class="btn-view-student">
                                        <i class="fas fa-eye"></i>
                                        Ver Detalles
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h5 class="empty-title">{{ $mensaje ?? 'No se encontraron resultados' }}</h5>
                        <p class="empty-text">Intenta con otros criterios de búsqueda.</p>
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
                    <h4 class="initial-state-title">Busca un estudiante</h4>
                    <p class="initial-state-text">
                        Completa el formulario con al menos un criterio de búsqueda para encontrar estudiantes.
                    </p>
                    <div class="initial-state-tips">
                        <div class="tip-item">
                            <i class="fas fa-lightbulb"></i>
                            <span>Puedes buscar por nombre, DNI, código o grado</span>
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

@push('styles')
<style>
:root {
    --primary: #00508f;
    --secondary: #4ec7d2;
    --light: #f8fafc;
    --dark: #1e293b;
    --border: #e2e8f0;
}

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
}

.form-control-modern:focus {
    outline: none;
    border-color: var(--secondary);
    box-shadow: 0 0 0 4px rgba(78, 199, 210, 0.1);
}

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
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-cancel:hover {
    background: var(--light);
}

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

.student-result-card {
    background: white;
    border: 2px solid var(--border);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.student-result-card:last-child {
    margin-bottom: 0;
}

.student-result-card:hover {
    border-color: var(--secondary);
    box-shadow: 0 4px 12px rgba(78, 199, 210, 0.15);
    transform: translateY(-2px);
}

.student-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.student-avatar-small {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--secondary) 0%, var(--primary) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.student-name-small {
    color: var(--dark);
    font-weight: 700;
    font-size: 1rem;
    margin: 0 0 0.5rem 0;
}

.student-meta-small {
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

.btn-view-student {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.875rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-view-student:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 80, 143, 0.2);
    color: white;
}

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
    margin-bottom: 0;
}

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

@media (max-width: 767px) {
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

    .btn-view-student {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endpush
@endsection
