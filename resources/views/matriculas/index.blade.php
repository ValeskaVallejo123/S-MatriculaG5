@extends('layouts.app')

@section('title', 'Matrículas')

@section('page-title', 'Gestión de Matrículas')

@section('topbar-actions')
    <a href="{{ route('matriculas.create') }}" class="btn-back" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); font-size: 0.9rem;">
        <i class="fas fa-plus"></i>
        Nueva Matrícula
    </a>
@endsection

@section('content')
<div class="container" style="max-width: 1400px;">

    <!-- Resumen de matrículas -->
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="border-radius: 10px; background: linear-gradient(135deg, rgba(78, 199, 210, 0.1) 0%, rgba(0, 80, 143, 0.05) 100%);">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-clipboard-check" style="color: white; font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">Total Matriculados</p>
                            <h4 class="mb-0 fw-bold" style="color: #003b73;">{{ $matriculas->total() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de matrículas -->
    @forelse($matriculas as $matricula)
    <div class="card border-0 shadow-sm mb-2" style="border-radius: 10px; transition: all 0.2s ease;">
        <div class="card-body p-2">
            <div class="row align-items-center g-2">
                
                <!-- Avatar y Datos -->
                <div class="col-lg-5">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #00508f 0%, #003b73 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 2px solid #4ec7d2;">
                            <span class="text-white fw-bold" style="font-size: 0.95rem;">
                                {{ strtoupper(substr($matricula->nombre, 0, 1) . substr($matricula->apellido ?? '', 0, 1)) }}
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <h6 class="mb-0 fw-semibold text-truncate" style="color: #003b73; font-size: 0.9rem;">
                                {{ $matricula->nombre }} {{ $matricula->apellido }}
                            </h6>
                            <small class="text-muted" style="font-size: 0.75rem;">
                                <i class="fas fa-id-card me-1"></i>{{ $matricula->dni ?? 'Sin DNI' }}
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Grado y Sección -->
                <div class="col-lg-4">
                    <div class="d-flex flex-wrap gap-1">
                        <span class="badge" style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.3rem 0.6rem; font-weight: 600; font-size: 0.7rem;">
                            <i class="fas fa-graduation-cap me-1"></i>{{ $matricula->grado }}
                        </span>
                        <span class="badge" style="background: rgba(0, 59, 115, 0.1); color: #003b73; border: 1px solid #00508f; padding: 0.3rem 0.6rem; font-weight: 600; font-size: 0.7rem;">
                            Sección {{ $matricula->seccion }}
                        </span>
                    </div>
                </div>

                <!-- Estado y Acciones -->
                <div class="col-lg-3">
                    <div class="d-flex align-items-center justify-content-end gap-2">
                        <span class="badge rounded-pill" style="background: rgba(78, 199, 210, 0.2); color: #00508f; padding: 0.3rem 0.7rem; font-weight: 600; border: 1px solid #4ec7d2; font-size: 0.7rem;">
                            <i class="fas fa-circle" style="font-size: 0.4rem; color: #4ec7d2;"></i> Activo
                        </span>

                        <div class="btn-group" role="group">
                            <a href="{{ route('matriculas.show', $matricula) }}" 
                               class="btn btn-sm" 
                               style="border-radius: 6px 0 0 6px; border: 1.5px solid #00508f; color: #00508f; background: white; padding: 0.3rem 0.6rem; font-size: 0.8rem;"
                               title="Ver">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('matriculas.edit', $matricula) }}" 
                               class="btn btn-sm" 
                               style="border-radius: 0 6px 6px 0; border: 1.5px solid #4ec7d2; border-left: none; color: #4ec7d2; background: white; padding: 0.3rem 0.6rem; font-size: 0.8rem;"
                               title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @empty
        <div class="card border-0 shadow-sm" style="border-radius: 10px;">
            <div class="card-body text-center py-4">
                <i class="fas fa-clipboard-list mb-2" style="font-size: 2rem; color: #00508f; opacity: 0.5;"></i>
                <h6 style="color: #003b73;">No hay matrículas registradas</h6>
                <p class="text-muted small mb-3">Comienza registrando la primera matrícula</p>
                <a href="{{ route('matriculas.create') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; border-radius: 8px; padding: 0.5rem 1.2rem; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3);">
                    <i class="fas fa-plus me-1"></i>Nueva Matrícula
                </a>
            </div>
        </div>
    @endforelse

    <!-- Paginación -->
    @if($matriculas->hasPages())
    <div class="card border-0 shadow-sm mt-2" style="border-radius: 10px;">
        <div class="card-body py-2 px-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small" style="font-size: 0.8rem;">
                    {{ $matriculas->firstItem() }} - {{ $matriculas->lastItem() }} de {{ $matriculas->total() }}
                </div>
                <div>
                    {{ $matriculas->links() }}
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection