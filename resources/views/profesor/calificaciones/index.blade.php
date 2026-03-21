@extends('layouts.app')

@section('title', 'Mis Calificaciones')

@section('page-title', 'Calificaciones')

@section('topbar-actions')
    <a href="{{ route('profesor.dashboard') }}" class="btn-back" style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #00508f; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 1400px;">

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-3" style="border-radius: 10px; border-left: 4px solid #388e3c !important;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    {{-- Resumen --}}
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
        <div class="card-body p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-4">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-chalkboard-teacher" style="color: #00508f; font-size: 0.9rem;"></i>
                        <span class="small">
                            <strong style="color: #00508f;">{{ $grupos->count() }}</strong>
                            <span class="text-muted"> Grupos asignados</span>
                        </span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-book-open" style="color: #4ec7d2; font-size: 0.9rem;"></i>
                        <span class="small">
                            <strong style="color: #4ec7d2;">{{ $grupos->flatten()->count() }}</strong>
                            <span class="text-muted"> Materias en total</span>
                        </span>
                    </div>
                </div>
                <span class="small text-muted">
                    <i class="fas fa-user-tie me-1" style="color: #00508f;"></i>
                    {{ $profesor->nombre_completo }}
                </span>
            </div>
        </div>
    </div>

    {{-- Sin asignaciones --}}
    @if($grupos->isEmpty())
        <div class="card border-0 shadow-sm" style="border-radius: 10px;">
            <div class="card-body text-center py-5">
                <i class="fas fa-inbox fa-3x mb-3" style="color: #00508f; opacity: 0.4;"></i>
                <h5 style="color: #003b73;">No tienes grupos asignados</h5>
                <p class="text-muted small mb-0">Contacta al administrador para que te asigne grados y materias.</p>
            </div>
        </div>
    @else
        @foreach($grupos as $clave => $materias)
            @php
                [$gradoId, $seccion] = explode('|', $clave);
                $grado = $materias->first()->grado;
            @endphp

            <div class="mb-4">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge fw-semibold" style="background: rgba(0,80,143,0.1); color: #00508f; border: 1px solid #00508f; padding: 0.4rem 0.9rem; font-size: 0.8rem; border-radius: 20px;">
                        <i class="fas fa-school me-1"></i>
                        {{ $grado->nombre ?? 'Grado' }} — Sección {{ $seccion }}
                    </span>
                    <span class="text-muted small">{{ $materias->count() }} {{ $materias->count() === 1 ? 'materia' : 'materias' }}</span>
                </div>

                <div class="row g-3">
                    @foreach($materias as $asignacion)
                        <div class="col-md-4 col-sm-6">
                            <a href="{{ route('profesor.calificaciones.listar', [
                                    'gradoId'   => $gradoId,
                                    'seccion'   => $seccion,
                                    'materiaId' => $asignacion->materia_id,
                                ]) }}" class="text-decoration-none">
                                <div class="card border-0 shadow-sm h-100 materia-card" style="border-radius: 10px; transition: all 0.3s ease; border-left: 4px solid #4ec7d2 !important;">
                                    <div class="card-body p-3 d-flex align-items-center gap-3">
                                        <div class="d-flex align-items-center justify-content-center rounded-3"
                                             style="width: 42px; height: 42px; background: rgba(78,199,210,0.12); flex-shrink: 0;">
                                            <i class="fas fa-book" style="color: #4ec7d2; font-size: 1.1rem;"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold" style="color: #003b73; font-size: 0.9rem;">
                                                {{ $asignacion->materia->nombre ?? 'Materia' }}
                                            </div>
                                            <div class="small text-muted">
                                                {{ $grado->nombre ?? '' }} · Sección {{ $seccion }}
                                            </div>
                                        </div>
                                        <i class="fas fa-chevron-right ms-auto" style="color: #c0c0c0; font-size: 0.8rem;"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @endif

</div>

@push('styles')
<style>
    .materia-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(78, 199, 210, 0.2) !important;
        border-left-color: #00508f !important;
    }
    .btn-back:hover {
        background: #00508f !important;
        color: white !important;
        transform: translateY(-2px);
    }
</style>
@endpush
@endsection
