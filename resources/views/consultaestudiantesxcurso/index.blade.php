@extends('layouts.app')

@section('title', 'Consulta de Estudiantes por Curso')
@section('page-title', 'Gestión de Cursos y Estudiantes')

@section('content')
    <div class="container-fluid">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Lista de cursos -->
        <div class="row g-4">
            @forelse($cursos as $curso)
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card border-0 shadow-sm h-100"
                         style="border-radius: 12px; border-left: 4px solid #4ec7d2;">

                        <div class="card-body p-4">

                            <!-- Nombre del curso (grado + sección) -->
                            <h5 class="fw-bold mb-2" style="color: #003b73;">
                                <i class="fas fa-book me-2" style="color: #4ec7d2;"></i>
                                {{ $curso->grado }} - Sección {{ $curso->seccion }}
                            </h5>

                            <!-- Cantidad de estudiantes -->
                            <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="badge"
                                  style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
                                         color: white;
                                         padding: 0.4rem 0.75rem;">
                                {{ $curso->total_estudiantes }} Estudiantes
                            </span>

                                <!-- Botón ver -->
                                <a href="{{ route('consultaestudiantesxcurso.show', ['grado' => $curso->grado, 'seccion' => $curso->seccion]) }}"
                                   class="btn btn-sm"
                                   style="border: 2px solid #4ec7d2;
                                      color: #4ec7d2;
                                      border-radius: 8px;
                                      font-weight: 600;">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-inbox" style="font-size: 2rem; color: #4ec7d2;"></i>
                        <p class="text-muted mt-2">No hay cursos registrados</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Paginación -->
        <div class="mt-4">
            {{ $cursos->links() }}
        </div>

    </div>
@endsection
