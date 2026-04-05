@extends('layouts.app')

@section('title', 'Consulta de Estudiantes por Curso')
@section('page-title', 'Gestión de Cursos y Estudiantes')

@section('content')
<div class="container-fluid px-4 py-3">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- HEADER --}}
    <div class="card border-0 shadow-sm mb-4"
         style="border-radius:12px;background:linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);">
        <div class="card-body p-3">
            <div class="d-flex align-items-center">
                <div class="me-3"
                     style="width:48px;height:48px;border-radius:10px;
                            background:rgba(255,255,255,0.2);
                            display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-school text-white fa-lg"></i>
                </div>
                <div class="text-white">
                    <h5 class="mb-0 fw-bold">Cursos y Secciones</h5>
                    <p class="mb-0 opacity-90" style="font-size:0.85rem;">
                        Listado de cursos con sus estudiantes matriculados
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- TARJETAS --}}
    <div class="row g-3">
        @forelse($cursos as $curso)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card border-0 shadow-sm h-100"
                     style="border-radius:12px;border-left:4px solid #4ec7d2 !important;">

                    <div class="card-body p-4">

                        {{-- Título --}}
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3"
                                 style="width:42px;height:42px;border-radius:10px;
                                        background:rgba(78,199,210,0.15);
                                        display:flex;align-items:center;
                                        justify-content:center;flex-shrink:0;">
                                <i class="fas fa-chalkboard" style="color:#00508f;"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0" style="color:#003b73;">
                                    {{ $curso->grado }}
                                </h6>
                                <small class="text-muted">
                                    Sección {{ $curso->seccion }}
                                </small>
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="d-flex align-items-center justify-content-between mt-auto pt-2"
                             style="border-top:1px solid #f1f5f9;">
                            <span class="badge"
                                  style="background:linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);
                                         color:white;padding:0.35rem 0.7rem;
                                         border-radius:8px;font-size:0.78rem;">
                                <i class="fas fa-user-graduate me-1"></i>
                                {{ $curso->total_estudiantes }} Est.
                            </span>

                            <a href="{{ route('consultaestudiantesxcurso.show', [$curso->grado, $curso->seccion]) }}"
                               class="btn btn-sm"
                               style="border:2px solid #4ec7d2;color:#4ec7d2;
                                      border-radius:8px;font-weight:600;
                                      padding:0.3rem 0.8rem;">
                                <i class="fas fa-eye me-1"></i> Ver
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm" style="border-radius:12px;">
                    <div class="card-body text-center py-5">
                        <div style="width:64px;height:64px;border-radius:50%;
                                    background:rgba(78,199,210,0.15);
                                    display:flex;align-items:center;justify-content:center;
                                    margin:0 auto 1rem;">
                            <i class="fas fa-inbox fa-2x" style="color:#4ec7d2;"></i>
                        </div>
                        <h6 style="color:#003b73;">No hay cursos registrados</h6>
                        <p class="text-muted small mb-0">
                            No hay estudiantes con grado y sección asignados.
                        </p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

</div>
@endsection
