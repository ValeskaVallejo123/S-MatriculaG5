@extends('layouts.app')

@section('title', 'Buscar Estudiante')

@section('page-title', 'Buscar Estudiante')

@section('content')
<div class="container-fluid px-4">

    <!-- FORMULARIO DE BÚSQUEDA -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="me-3 d-flex align-items-center justify-content-center bg-primary text-white rounded-3" style="width:48px; height:48px;">
                            <i class="fas fa-search"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-primary">Buscar Estudiante</h5>
                            <small class="text-muted">Ingresa al menos un criterio de búsqueda</small>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('estudiantes.buscar') }}" method="GET">
                        <div class="row g-3">

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-user me-1 text-primary"></i> Nombre
                                </label>
                                <input type="text"
                                       name="nombre"
                                       class="form-control"
                                       placeholder="Nombre del estudiante"
                                       value="{{ request('nombre') }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-id-card me-1 text-primary"></i> DNI / Identidad
                                </label>
                                <input type="text"
                                       name="dni"
                                       class="form-control"
                                       placeholder="Número de identidad"
                                       value="{{ request('dni') }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-hashtag me-1 text-primary"></i> Código
                                </label>
                                <input type="text"
                                       name="codigo"
                                       class="form-control"
                                       placeholder="Código"
                                       value="{{ request('codigo') }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-graduation-cap me-1 text-primary"></i> Grado
                                </label>
                                <input type="text"
                                       name="grado"
                                       class="form-control"
                                       placeholder="Ej: 5°"
                                       value="{{ request('grado') }}">
                            </div>

                            <div class="col-12 d-flex flex-wrap gap-2 mt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-1"></i>
                                    Buscar estudiantes
                                </button>

                                <a href="{{ route('estudiantes.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i>
                                    Limpiar / Cancelar
                                </a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- RESULTADOS -->
    @if($busquedaRealizada)
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="me-2 d-flex align-items-center justify-content-center bg-light text-primary rounded-3" style="width:40px; height:40px;">
                                    <i class="fas fa-list"></i>
                                </div>
                                <h6 class="mb-0 fw-bold">Resultados de búsqueda</h6>
                            </div>
                            <span class="badge bg-primary">
                                {{ $estudiantes->count() }} {{ $estudiantes->count() == 1 ? 'encontrado' : 'encontrados' }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body">
                        @if($estudiantes->count() > 0)
                            @foreach($estudiantes as $estudiante)
                                <div class="border rounded-3 p-3 mb-2 hover-shadow-sm">
                                    <div class="row align-items-center g-2">
                                        <div class="col-lg-8 d-flex align-items-center">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold me-3"
                                                 style="width:48px; height:48px; background: linear-gradient(135deg, #0d6efd, #0dcaf0);">
                                                @if($estudiante->nombre && $estudiante->apellido)
                                                    {{ substr($estudiante->nombre, 0, 1) }}{{ substr($estudiante->apellido, 0, 1) }}
                                                @else
                                                    {{ substr($estudiante->nombre ?? 'E', 0, 1) }}{{ substr($estudiante->apellido ?? 'S', 0, 1) }}
                                                @endif
                                            </div>

                                            <div>
                                                <h6 class="mb-1 fw-bold">
                                                    {{ $estudiante->nombre }} {{ $estudiante->apellido }}
                                                </h6>

                                                <div class="d-flex flex-wrap gap-1 small text-muted">
                                                    @if($estudiante->dni)
                                                        <span class="badge bg-light text-dark border">
                                                            <i class="fas fa-id-card me-1"></i>{{ $estudiante->dni }}
                                                        </span>
                                                    @endif

                                                    @if($estudiante->codigo)
                                                        <span class="badge bg-light text-dark border">
                                                            <i class="fas fa-hashtag me-1"></i>{{ $estudiante->codigo }}
                                                        </span>
                                                    @endif

                                                    @if($estudiante->grado)
                                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                                            <i class="fas fa-graduation-cap me-1"></i>{{ $estudiante->grado }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 text-lg-end mt-2 mt-lg-0">
                                            <a href="{{ route('estudiantes.show', $estudiante->id) }}"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye me-1"></i>
                                                Ver detalles
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center"
                                         style="width:70px; height:70px;">
                                        <i class="fas fa-search text-primary fs-4"></i>
                                    </div>
                                </div>
                                <h5 class="fw-bold mb-1">{{ $mensaje ?? 'No se encontraron resultados' }}</h5>
                                <p class="text-muted mb-0">Intenta modificando los criterios de búsqueda.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- ESTADO INICIAL -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="mb-3">
                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center"
                                 style="width:80px; height:80px;">
                                <i class="fas fa-search text-primary fs-3"></i>
                            </div>
                        </div>
                        <h4 class="fw-bold mb-2">Busca un estudiante</h4>
                        <p class="text-muted mb-4">
                            Completa el formulario con al menos un criterio de búsqueda para encontrar estudiantes.
                        </p>

                        <div class="d-inline-flex flex-column gap-2 text-start mx-auto" style="max-width:420px;">
                            <div class="d-flex align-items-center small text-muted">
                                <i class="fas fa-lightbulb text-warning me-2"></i>
                                <span>Puedes buscar por nombre, DNI, código o grado.</span>
                            </div>
                            <div class="d-flex align-items-center small text-muted">
                                <i class="fas fa-info-circle text-primary me-2"></i>
                                <span>Los resultados se mostrarán debajo del formulario.</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection
