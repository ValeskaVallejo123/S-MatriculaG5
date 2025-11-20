@extends('layouts.app')

@section('title', 'Calificaciones - Consulta Pública')

@section('page-title', 'Consulta de Calificaciones')

@section('topbar-actions')
    {{-- Sin botones de acción en vista pública --}}
    <div class="alert alert-info mb-0 py-2 px-3" style="border-radius: 8px; font-size: 0.85rem;">
        <i class="fas fa-info-circle"></i> Vista de solo lectura
    </div>
@endsection

@section('content')
    <div class="container" style="max-width: 1400px;">

        <!-- Barra de búsqueda y resumen -->
        <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
            <div class="card-body p-3">
                <div class="row align-items-center g-2">
                    <!-- Buscador -->
                    <div class="col-md-6">
                        <div class="position-relative">
                            <i class="fas fa-search position-absolute"
                                style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.9rem;"></i>
                            <input type="text" id="searchInput" class="form-control form-control-sm ps-5"
                                placeholder="Buscar por nombre de alumno..."
                                style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.5rem 1rem 0.5rem 2.5rem;">
                        </div>
                    </div>

                    <!-- Resumen -->
                    <div class="col-md-6">
                        <div class="d-flex align-items-center justify-content-md-end gap-3">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-clipboard-list" style="color: #00508f;"></i>
                                <span class="small"><strong style="color: #00508f;">{{ $calificaciones->count() }}</strong>
                                    <span class="text-muted">Total</span></span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-check-circle" style="color: #4ec7d2;"></i>
                                <span class="small"><strong style="color: #4ec7d2;">
                                    {{ $calificaciones->where('estado', 'Aprobado')->count() }}</strong>
                                    <span class="text-muted">Aprobados</span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Calificaciones (SOLO LECTURA) -->
        <div class="card border-0 shadow-sm" style="border-radius: 10px;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="gradesTable">
                        <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
                            <tr>
                                <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; color: #003b73;">Alumno</th>
                                <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem; color: #003b73;">1° Parcial</th>
                                <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem; color: #003b73;">2° Parcial</th>
                                <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem; color: #003b73;">3° Parcial</th>
                                <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem; color: #003b73;">4° Parcial</th>
                                <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem; color: #003b73;">Promedio</th>
                                <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem; color: #003b73;">Recuperación</th>
                                <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem; color: #003b73;">Nota Final</th>
                                <th class="px-3 py-2 text-uppercase small fw-semibold text-center" style="font-size: 0.7rem; color: #003b73;">Estado</th>
                                {{-- SIN COLUMNA DE ACCIONES --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($calificaciones as $calificacion)
                                @php
                                    // Misma lógica de cálculo que en la vista privada
                                    $parciales = [
                                        $calificacion->primer_parcial,
                                        $calificacion->segundo_parcial,
                                        $calificacion->tercer_parcial,
                                        $calificacion->cuarto_parcial
                                    ];

                                    $parcialesValidos = array_filter($parciales, function ($value) {
                                        return $value !== null && $value !== '';
                                    });

                                    $promedioParciales = count($parcialesValidos) > 0
                                        ? array_sum($parcialesValidos) / count($parcialesValidos)
                                        : 0;

                                    $vaRecuperacion = $promedioParciales > 0 && $promedioParciales < 65;

                                    if ($vaRecuperacion && $calificacion->recuperacion !== null && $calificacion->recuperacion !== '') {
                                        $notaFinal = $calificacion->recuperacion;
                                    } else {
                                        $notaFinal = $promedioParciales;
                                    }

                                    $esAprobado = $notaFinal >= 60;
                                    $bgColorFinal = $esAprobado ? 'rgba(5, 150, 105, 0.1)' : 'rgba(239, 68, 68, 0.1)';
                                    $textColorFinal = $esAprobado ? '#059669' : '#dc2626';
                                    $borderColorFinal = $esAprobado ? '#10b981' : '#ef4444';

                                    $bgColorPromedio = $vaRecuperacion ? 'rgba(255, 193, 7, 0.1)' : 'rgba(78, 199, 210, 0.15)';
                                    $textColorPromedio = $vaRecuperacion ? '#f59e0b' : '#00508f';
                                    $borderColorPromedio = $vaRecuperacion ? '#fbbf24' : '#4ec7d2';
                                @endphp
                                <tr style="border-bottom: 1px solid #f1f5f9;" class="grade-row">
                                    <td class="px-3 py-2">
                                        <div class="fw-semibold" style="color: #003b73; font-size: 0.9rem;">
                                            {{ $calificacion->nombre_alumno }}
                                        </div>
                                        <small class="text-muted" style="font-size: 0.75rem;">ID: {{ $calificacion->id }}</small>
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <span class="badge" style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.3rem 0.6rem; font-size: 0.75rem;">
                                            {{ $calificacion->primer_parcial ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <span class="badge" style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.3rem 0.6rem; font-size: 0.75rem;">
                                            {{ $calificacion->segundo_parcial ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <span class="badge" style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.3rem 0.6rem; font-size: 0.75rem;">
                                            {{ $calificacion->tercer_parcial ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <span class="badge" style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.3rem 0.6rem; font-size: 0.75rem;">
                                            {{ $calificacion->cuarto_parcial ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <div class="d-flex flex-column align-items-center gap-1">
                                            <span class="badge" style="background: {{ $bgColorPromedio }}; color: {{ $textColorPromedio }}; border: 1px solid {{ $borderColorPromedio }}; padding: 0.3rem 0.7rem; font-size: 0.8rem;">
                                                {{ $promedioParciales > 0 ? number_format($promedioParciales, 2) : '-' }}
                                            </span>
                                            @if($vaRecuperacion)
                                                <small style="color: #f59e0b; font-size: 0.65rem;">
                                                    <i class="fas fa-exclamation-triangle"></i> Recuperación
                                                </small>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        @if($vaRecuperacion)
                                            <span class="badge" style="background: rgba(255, 193, 7, 0.15); color: #f59e0b; border: 1px solid #fbbf24; padding: 0.3rem 0.6rem; font-size: 0.75rem;">
                                                {{ $calificacion->recuperacion ?? 'Pendiente' }}
                                            </span>
                                        @else
                                            <span class="badge" style="background: rgba(203, 213, 225, 0.3); color: #64748b; border: 1px solid #cbd5e1; padding: 0.3rem 0.6rem; font-size: 0.75rem;">
                                                N/A
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <span class="badge" style="background: {{ $bgColorFinal }}; color: {{ $textColorFinal }}; border: 1px solid {{ $borderColorFinal }}; padding: 0.3rem 0.7rem; font-size: 0.8rem;">
                                            {{ $notaFinal > 0 ? number_format($notaFinal, 2) : '-' }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        @if($esAprobado)
                                            <span class="badge rounded-pill" style="background: rgba(78, 199, 210, 0.2); color: #00508f; padding: 0.3rem 0.7rem; border: 1px solid #4ec7d2; font-size: 0.75rem;">
                                                <i class="fas fa-circle" style="font-size: 0.4rem; color: #4ec7d2;"></i> Aprobado
                                            </span>
                                        @else
                                            <span class="badge rounded-pill" style="background: #fee2e2; color: #991b1b; padding: 0.3rem 0.7rem; border: 1px solid #ef4444; font-size: 0.75rem;">
                                                <i class="fas fa-circle" style="font-size: 0.4rem;"></i> Reprobado
                                            </span>
                                        @endif
                                    </td>
                                    {{-- SIN BOTONES DE ACCIÓN --}}
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5">
                                        <i class="fas fa-inbox fa-2x mb-2" style="color: #00508f; opacity: 0.5;"></i>
                                        <h6 style="color: #003b73;">No hay calificaciones registradas</h6>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-12">
                            {{ $calificaciones->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .table> :not(caption)>*>* {
                padding: 0.6rem 0.75rem;
            }
            .table tbody tr:hover {
                background-color: rgba(191, 217, 234, 0.08);
            }
            #searchInput:focus {
                border-color: #4ec7d2;
                box-shadow: 0 0 0 0.2rem rgba(78, 199, 210, 0.15);
                outline: none;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Mismo script de búsqueda
            document.addEventListener('DOMContentLoaded', function () {
                const searchInput = document.getElementById('searchInput');
                const rows = document.querySelectorAll('.grade-row');

                searchInput.addEventListener('keyup', function () {
                    const searchTerm = this.value.toLowerCase().trim();
                    
                    rows.forEach(function (row) {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                });
            });
        </script>
    @endpush
@endsection