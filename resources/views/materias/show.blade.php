@extends('layouts.app')

@section('title', 'Detalle de Materia')

@section('page-title', 'Detalle de Materia')

@section('topbar-actions')
    <div class="d-flex gap-2">
        <a href="{{ route('materias.edit', $materia) }}" class="btn-back" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: none; box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3); font-size: 0.9rem;">
            <i class="fas fa-edit"></i>
            Editar
        </a>
        <a href="{{ route('materias.index') }}" class="btn-back" style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #00508f; box-shadow: 0 2px 8px rgba(0, 80, 143, 0.2); font-size: 0.9rem;">
            <i class="fas fa-arrow-left"></i>
            Volver
        </a>
    </div>
@endsection

@section('content')
<div class="container" style="max-width: 1200px;">

    <div class="row g-4">
        <!-- Información Principal -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
                <div class="card-header" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 12px 12px 0 0; padding: 1.2rem;">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-book"></i> Información de la Materia
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <!-- Nombre -->
                        <div class="col-12">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-book-open me-3" style="color: #4ec7d2; font-size: 1.2rem;"></i>
                                <div>
                                    <small class="text-muted d-block" style="font-size: 0.75rem;">NOMBRE DE LA MATERIA</small>
                                    <h4 class="mb-0 fw-bold" style="color: #003b73;">{{ $materia->nombre }}</h4>
                                </div>
                            </div>
                        </div>

                        <!-- Código -->
                        <div class="col-md-6">
                            <div class="p-3" style="background: rgba(78, 199, 210, 0.05); border-radius: 8px; border-left: 3px solid #4ec7d2;">
                                <small class="text-muted d-block mb-1" style="font-size: 0.75rem;">CÓDIGO</small>
                                <span class="badge" style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.4rem 0.8rem; font-weight: 600; font-size: 0.9rem; font-family: monospace;">
                                    {{ $materia->codigo }}
                                </span>
                            </div>
                        </div>

                        <!-- Área -->
                        <div class="col-md-6">
                            <div class="p-3" style="background: rgba(0, 80, 143, 0.05); border-radius: 8px; border-left: 3px solid #00508f;">
                                <small class="text-muted d-block mb-1" style="font-size: 0.75rem;">ÁREA</small>
                                <span class="badge" style="background: rgba(0, 80, 143, 0.1); color: #00508f; padding: 0.4rem 0.8rem; font-weight: 600; font-size: 0.9rem;">
                                    <i class="fas fa-shapes"></i> {{ $materia->area }}
                                </span>
                            </div>
                        </div>

                        <!-- Nivel -->
                        <div class="col-md-6">
                            <div class="p-3" style="background: rgba(78, 199, 210, 0.05); border-radius: 8px; border-left: 3px solid #4ec7d2;">
                                <small class="text-muted d-block mb-1" style="font-size: 0.75rem;">NIVEL EDUCATIVO</small>
                                @if($materia->nivel === 'primaria')
                                    <span class="badge" style="background: rgba(78, 199, 210, 0.2); color: #00508f; border: 1px solid #4ec7d2; padding: 0.4rem 0.8rem; font-weight: 600; font-size: 0.9rem;">
                                        <i class="fas fa-child"></i> Primaria (1° - 6°)
                                    </span>
                                @else
                                    <span class="badge" style="background: rgba(0, 80, 143, 0.2); color: #003b73; border: 1px solid #00508f; padding: 0.4rem 0.8rem; font-weight: 600; font-size: 0.9rem;">
                                        <i class="fas fa-user-graduate"></i> Secundaria (7° - 9°)
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Estado -->
                        <div class="col-md-6">
                            <div class="p-3" style="background: rgba(0, 80, 143, 0.05); border-radius: 8px; border-left: 3px solid #00508f;">
                                <small class="text-muted d-block mb-1" style="font-size: 0.75rem;">ESTADO</small>
                                @if($materia->activo)
                                    <span class="badge" style="background: rgba(78, 199, 210, 0.2); color: #00508f; padding: 0.4rem 0.8rem; font-weight: 600; border: 1px solid #4ec7d2; font-size: 0.9rem;">
                                        <i class="fas fa-check-circle"></i> Activa
                                    </span>
                                @else
                                    <span class="badge" style="background: #fee2e2; color: #991b1b; padding: 0.4rem 0.8rem; font-weight: 600; border: 1px solid #ef4444; font-size: 0.9rem;">
                                        <i class="fas fa-times-circle"></i> Inactiva
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Descripción -->
                        @if($materia->descripcion)
                        <div class="col-12">
                            <div class="p-3" style="background: rgba(78, 199, 210, 0.05); border-radius: 8px;">
                                <small class="text-muted d-block mb-2" style="font-size: 0.75rem;">DESCRIPCIÓN</small>
                                <p class="mb-0" style="color: #003b73;">{{ $materia->descripcion }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Grados Asignados -->
            @if($materia->grados->count() > 0)
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border-radius: 12px 12px 0 0; padding: 1rem;">
                    <h6 class="mb-0 fw-bold">
                        <i class="fas fa-school"></i> Grados donde se imparte esta materia ({{ $materia->grados->count() }})
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background: rgba(16, 185, 129, 0.1);">
                                <tr>
                                    <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem;">Grado</th>
                                    <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem;">Profesor</th>
                                    <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem;">Horas/Semana</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($materia->grados as $grado)
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td class="px-3 py-2">
                                        <span class="badge" style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.4rem 0.7rem; font-weight: 600;">
                                            {{ $grado->numero }}° {{ $grado->seccion ? 'Sección ' . $grado->seccion : '' }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2">
                                        @if($grado->pivot->profesor_id)
                                            <i class="fas fa-user-tie" style="color: #4ec7d2;"></i>
                                            {{ \App\Models\User::find($grado->pivot->profesor_id)->name ?? 'No asignado' }}
                                        @else
                                            <span class="text-muted small">Sin asignar</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2">
                                        <span class="badge" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.3rem 0.6rem;">
                                            {{ $grado->pivot->horas_semanales }} hrs
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Panel Lateral -->
        <div class="col-lg-4">
            <!-- Estadísticas -->
            <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
                <div class="card-header" style="background: white; border-bottom: 2px solid #bfd9ea; border-radius: 12px 12px 0 0; padding: 1rem;">
                    <h6 class="mb-0 fw-bold" style="color: #003b73;">
                        <i class="fas fa-chart-bar text-primary"></i> Estadísticas
                    </h6>
                </div>
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3 p-2" style="background: rgba(78, 199, 210, 0.05); border-radius: 8px;">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-school me-2" style="color: #4ec7d2; font-size: 1.2rem;"></i>
                            <span class="small text-muted">Grados asignados</span>
                        </div>
                        <span class="badge" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.4rem 0.7rem; font-size: 0.9rem;">
                            {{ $materia->grados->count() }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center p-2" style="background: rgba(0, 80, 143, 0.05); border-radius: 8px;">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-clock me-2" style="color: #00508f; font-size: 1.2rem;"></i>
                            <span class="small text-muted">Total horas semanales</span>
                        </div>
                        <span class="badge" style="background: rgba(0, 80, 143, 0.2); color: #003b73; padding: 0.4rem 0.7rem; font-size: 0.9rem;">
                            {{ $materia->grados->sum('pivot.horas_semanales') }} hrs
                        </span>
                    </div>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
                <div class="card-header" style="background: white; border-bottom: 2px solid #bfd9ea; border-radius: 12px 12px 0 0; padding: 1rem;">
                    <h6 class="mb-0 fw-bold" style="color: #003b73;">
                        <i class="fas fa-bolt text-warning"></i> Acciones Rápidas
                    </h6>
                </div>
                <div class="card-body p-3">
                    <div class="d-grid gap-2">
                        <a href="{{ route('materias.edit', $materia) }}" class="btn" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; border-radius: 8px; padding: 0.6rem; font-weight: 600;">
                            <i class="fas fa-edit"></i> Editar Materia
                        </a>
                        <a href="{{ route('grados.index') }}" class="btn" style="background: white; color: #4ec7d2; border: 2px solid #4ec7d2; border-radius: 8px; padding: 0.6rem; font-weight: 600;">
                            <i class="fas fa-tasks"></i> Ver Grados
                        </a>
                        <form action="{{ route('materias.destroy', $materia) }}" 
                              method="POST" 
                              onsubmit="return confirm('¿Está seguro de eliminar esta materia?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn w-100" style="background: white; color: #ef4444; border: 2px solid #ef4444; border-radius: 8px; padding: 0.6rem; font-weight: 600;">
                                <i class="fas fa-trash"></i> Eliminar Materia
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Información del Sistema -->
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header" style="background: white; border-bottom: 2px solid #bfd9ea; border-radius: 12px 12px 0 0; padding: 1rem;">
                    <h6 class="mb-0 fw-bold" style="color: #003b73;">
                        <i class="fas fa-info-circle text-info"></i> Información del Sistema
                    </h6>
                </div>
                <div class="card-body p-3">
                    <div class="small">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Creado:</span>
                            <strong style="color: #003b73;">{{ $materia->created_at->format('d/m/Y') }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Última actualización:</span>
                            <strong style="color: #003b73;">{{ $materia->updated_at->format('d/m/Y') }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('styles')
<style>
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-back:hover {
        transform: translateY(-2px);
    }
</style>
@endpush

@endsection