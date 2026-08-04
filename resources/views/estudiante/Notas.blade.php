@extends('layouts.app')

@section('title', 'Mis Calificaciones')

@section('content')
    <div class="container-fluid px-4 py-4">
        {{-- Encabezado con estilo del Dashboard --}}
        <div class="card border-0 shadow-sm mb-4"
             style="border-radius:12px; background: linear-gradient(135deg, rgba(0,80,143,0.05) 0%, rgba(78,199,210,0.05) 100%);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h2 class="fw-bold mb-1" style="color:#003b73;">
                            <i class="fas fa-clipboard-check me-2" style="color:#4ec7d2;"></i>Mis Calificaciones
                        </h2>
                        <p class="text-muted mb-0">Consulta tu rendimiento académico detallado por materia.</p>
                    </div>
                    <a href="{{ route('estudiante.dashboard') }}" class="btn fw-bold shadow-sm"
                       style="border:2px solid #00508f; color:#00508f; border-radius:8px; padding: 10px 20px;">
                        <i class="fas fa-arrow-left me-1"></i> Volver al Panel
                    </a>
                </div>
            </div>
        </div>

        {{-- Tabla de Calificaciones --}}
        <div class="card border-0 shadow-sm" style="border-radius:12px; overflow:hidden;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background: #003b73; color: white;">
                        <tr>
                            <th class="px-4 py-3 border-0">Materia / Asignatura</th>
                            <th class="py-3 border-0 text-center">Periodo</th>
                            <th class="py-3 border-0 text-center">Nota Final</th>
                            <th class="py-3 border-0 text-center">Estado</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($estudiante->calificaciones as $nota)
                            <tr style="vertical-align: middle;">
                                <td class="px-4 py-3 fw-bold" style="color: #00508f;">
                                    {{ $nota->materia->nombre ?? 'Materia no asignada' }}
                                </td>
                                <td class="py-3 text-center text-muted">
                                    {{ $nota->periodo->nombre ?? 'N/A' }}
                                </td>
                                <td class="py-3 text-center">
                                    <div class="fw-bold" style="font-size: 1.1rem; color: {{ $nota->nota_final >= 70 ? '#10b981' : '#ef4444' }};">
                                        {{ number_format($nota->nota_final, 0) }}%
                                    </div>
                                </td>
                                <td class="py-3 text-center">
                                    @if($nota->nota_final >= 70)
                                        <span class="badge" style="background:rgba(16,185,129,0.1); color:#059669; border:1px solid #10b981;">
                                            <i class="fas fa-check-circle me-1"></i> Aprobado
                                        </span>
                                    @else
                                        <span class="badge" style="background:rgba(239,68,68,0.1); color:#dc2626; border:1px solid #ef4444;">
                                            <i class="fas fa-times-circle me-1"></i> Reprobado
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="fas fa-folder-open fa-3x mb-3" style="color: #cbd5e1;"></i>
                                        <p class="text-muted fw-semibold">Aún no tienes calificaciones registradas en este ciclo.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
