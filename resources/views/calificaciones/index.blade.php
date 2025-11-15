@extends('layouts.app')

@section('title', 'Calificaciones')

@section('page-title', 'Gestión de Calificaciones')

@section('topbar-actions')
    <a href="{{ route('calificaciones.create') }}" class="btn-back"
        style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); font-size: 0.9rem;">
        <i class="fas fa-plus"></i>
        Nueva Calificación
    </a>

    <a href="{{ route('plantilla') }}" class="btn-back"
        style="background: #e2e8f0; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 1px solid #bfd9ea; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
@endsection

@section('content')
    <div class="container" style="max-width: 1400px;">

        <!-- Barra de búsqueda y resumen compacto -->
        <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
            <div class="card-body p-3">
                <div class="row align-items-center g-2">
                    <!-- Buscador -->
                    <div class="col-md-6">
                        <div class="position-relative">
                            <i class="fas fa-search position-absolute"
                                style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.9rem;"></i>
                            <input type="text" id="searchInput" class="form-control form-control-sm ps-5"
                                placeholder="Buscar por nombre de alumno, estado..."
                                style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.5rem 1rem 0.5rem 2.5rem; transition: all 0.3s ease;">
                        </div>
                    </div>

                    <!-- Resumen compacto -->
                    <div class="col-md-6">
                        <div class="d-flex align-items-center justify-content-md-end gap-3">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-clipboard-list" style="color: #00508f; font-size: 0.9rem;"></i>
                                <span class="small"><strong style="color: #00508f;">{{ $calificaciones->count() }}</strong>
                                    <span class="text-muted">Total</span></span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-check-circle" style="color: #4ec7d2; font-size: 0.9rem;"></i>
                                <span class="small"><strong
                                        style="color: #4ec7d2;">{{ $calificaciones->where('estado', 'Aprobado')->count() }}</strong>
                                    <span class="text-muted">Aprobados</span></span>
                            </div>
                            <button class="btn btn-sm"
                                style="border: 2px solid #4ec7d2; color: #4ec7d2; background: white; border-radius: 6px; padding: 0.3rem 0.8rem; font-size: 0.85rem;">
                                <i class="fas fa-download"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla compacta de Calificaciones -->
        <div class="card border-0 shadow-sm" style="border-radius: 10px;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="gradesTable">
                        <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
                            <tr>
                                <th class="px-3 py-2 text-uppercase small fw-semibold"
                                    style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Alumno</th>
                                <th class="px-3 py-2 text-uppercase small fw-semibold text-center"
                                    style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">1° Parcial</th>
                                <th class="px-3 py-2 text-uppercase small fw-semibold text-center"
                                    style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">2° Parcial</th>
                                <th class="px-3 py-2 text-uppercase small fw-semibold text-center"
                                    style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">3° Parcial</th>
                                <th class="px-3 py-2 text-uppercase small fw-semibold text-center"
                                    style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">4° Parcial</th>
                                <th class="px-3 py-2 text-uppercase small fw-semibold text-center"
                                    style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Promedio</th>
                                <th class="px-3 py-2 text-uppercase small fw-semibold text-center"
                                    style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Recuperación</th>
                                <th class="px-3 py-2 text-uppercase small fw-semibold text-center"
                                    style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Nota Final</th>
                                <th class="px-3 py-2 text-uppercase small fw-semibold text-center"
                                    style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Estado</th>
                                <th class="px-3 py-2 text-uppercase small fw-semibold text-end"
                                    style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($calificaciones as $calificacion)
                                @php
                                    // Calcular promedio de los 4 parciales
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

                                    // Determinar si va a recuperación (promedio < 65)
                                    $vaRecuperacion = $promedioParciales > 0 && $promedioParciales < 65;

                                    // Calcular nota final
                                    if ($vaRecuperacion && $calificacion->recuperacion !== null && $calificacion->recuperacion !== '') {
                                        // Si va a recuperación y tiene nota de recuperación
                                        $notaFinal = $calificacion->recuperacion;
                                    } else {
                                        // Si no va a recuperación o no tiene nota de recuperación
                                        $notaFinal = $promedioParciales;
                                    }

                                    $esAprobado = $notaFinal >= 60;
                                    $bgColorFinal = $esAprobado ? 'rgba(5, 150, 105, 0.1)' : 'rgba(239, 68, 68, 0.1)';
                                    $textColorFinal = $esAprobado ? '#059669' : '#dc2626';
                                    $borderColorFinal = $esAprobado ? '#10b981' : '#ef4444';

                                    // Colores para el promedio
                                    $bgColorPromedio = $vaRecuperacion ? 'rgba(255, 193, 7, 0.1)' : 'rgba(78, 199, 210, 0.15)';
                                    $textColorPromedio = $vaRecuperacion ? '#f59e0b' : '#00508f';
                                    $borderColorPromedio = $vaRecuperacion ? '#fbbf24' : '#4ec7d2';
                                @endphp
                                <tr style="border-bottom: 1px solid #f1f5f9; transition: all 0.2s ease;" class="grade-row">
                                    <td class="px-3 py-2">
                                        <div class="fw-semibold" style="color: #003b73; font-size: 0.9rem;">
                                            {{ $calificacion->nombre_alumno }}
                                        </div>
                                        <small class="text-muted" style="font-size: 0.75rem;">ID:
                                            {{ $calificacion->id }}</small>
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <span class="badge"
                                            style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.3rem 0.6rem; font-weight: 600; font-size: 0.75rem;">
                                            {{ $calificacion->primer_parcial ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <span class="badge"
                                            style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.3rem 0.6rem; font-weight: 600; font-size: 0.75rem;">
                                            {{ $calificacion->segundo_parcial ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <span class="badge"
                                            style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.3rem 0.6rem; font-weight: 600; font-size: 0.75rem;">
                                            {{ $calificacion->tercer_parcial ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <span class="badge"
                                            style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.3rem 0.6rem; font-weight: 600; font-size: 0.75rem;">
                                            {{ $calificacion->cuarto_parcial ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <div class="d-flex flex-column align-items-center gap-1">
                                            <span class="badge"
                                                style="background: {{ $bgColorPromedio }}; color: {{ $textColorPromedio }}; border: 1px solid {{ $borderColorPromedio }}; padding: 0.3rem 0.7rem; font-weight: 700; font-size: 0.8rem;">
                                                {{ $promedioParciales > 0 ? number_format($promedioParciales, 2) : '-' }}
                                            </span>
                                            @if($vaRecuperacion)
                                                <small style="color: #f59e0b; font-size: 0.65rem; font-weight: 600;">
                                                    <i class="fas fa-exclamation-triangle"></i> Recuperación
                                                </small>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        @if($vaRecuperacion)
                                            <span class="badge"
                                                style="background: rgba(255, 193, 7, 0.15); color: #f59e0b; border: 1px solid #fbbf24; padding: 0.3rem 0.6rem; font-weight: 600; font-size: 0.75rem;">
                                                {{ $calificacion->recuperacion ?? 'Pendiente' }}
                                            </span>
                                        @else
                                            <span class="badge"
                                                style="background: rgba(203, 213, 225, 0.3); color: #64748b; border: 1px solid #cbd5e1; padding: 0.3rem 0.6rem; font-weight: 600; font-size: 0.75rem;">
                                                N/A
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <span class="badge"
                                            style="background: {{ $bgColorFinal }}; color: {{ $textColorFinal }}; border: 1px solid {{ $borderColorFinal }}; padding: 0.3rem 0.7rem; font-weight: 700; font-size: 0.8rem;">
                                            {{ $notaFinal > 0 ? number_format($notaFinal, 2) : '-' }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        @if($esAprobado)
                                            <span class="badge rounded-pill"
                                                style="background: rgba(78, 199, 210, 0.2); color: #00508f; padding: 0.3rem 0.7rem; font-weight: 600; border: 1px solid #4ec7d2; font-size: 0.75rem;">
                                                <i class="fas fa-circle" style="font-size: 0.4rem; color: #4ec7d2;"></i> Aprobado
                                            </span>
                                        @else
                                            <span class="badge rounded-pill"
                                                style="background: #fee2e2; color: #991b1b; padding: 0.3rem 0.7rem; font-weight: 600; border: 1px solid #ef4444; font-size: 0.75rem;">
                                                <i class="fas fa-circle" style="font-size: 0.4rem;"></i> Reprobado
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 text-end">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('calificaciones.show', $calificacion->id) }}" class="btn btn-sm"
                                                style="border-radius: 6px 0 0 6px; border: 1.5px solid #00508f; color: #00508f; background: white; padding: 0.3rem 0.6rem; font-size: 0.8rem;"
                                                title="Ver"
                                                onmouseover="this.style.background='#00508f'; this.style.color='white';"
                                                onmouseout="this.style.background='white'; this.style.color='#00508f';">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('calificaciones.edit', $calificacion->id) }}" class="btn btn-sm"
                                                style="border-radius: 0; border: 1.5px solid #4ec7d2; border-left: none; color: #4ec7d2; background: white; padding: 0.3rem 0.6rem; font-size: 0.8rem;"
                                                title="Editar"
                                                onmouseover="this.style.background='#4ec7d2'; this.style.color='white';"
                                                onmouseout="this.style.background='white'; this.style.color='#4ec7d2';">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('calificaciones.destroy', $calificacion->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('¿Está seguro de eliminar esta calificación?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm"
                                                    style="border-radius: 0 6px 6px 0; border: 1.5px solid #ef4444; border-left: none; color: #ef4444; background: white; padding: 0.3rem 0.6rem; font-size: 0.8rem;"
                                                    title="Eliminar"
                                                    onmouseover="this.style.background='#ef4444'; this.style.color='white';"
                                                    onmouseout="this.style.background='white'; this.style.color='#ef4444';">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-2x mb-2" style="color: #00508f; opacity: 0.5;"></i>
                                            <h6 style="color: #003b73;">No hay calificaciones registradas</h6>
                                            <p class="small mb-3">Comienza agregando la primera calificación</p>
                                            <a href="{{ route('calificaciones.create') }}" class="btn btn-sm"
                                                style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 8px; padding: 0.5rem 1.2rem;">
                                                <i class="fas fa-plus me-1"></i>Registrar Calificación
                                            </a>
                                        </div>
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

        @push('styles')
            <style>
                .table> :not(caption)>*>* {
                    padding: 0.6rem 0.75rem;
                }

                .btn-group .btn:hover {
                    transform: translateY(-1px);
                    z-index: 1;
                }

                .pagination {
                    margin-bottom: 0;
                }

                .pagination .page-link {
                    border-radius: 6px;
                    margin: 0 2px;
                    border: 1px solid #e2e8f0;
                    color: #00508f;
                    transition: all 0.3s ease;
                    padding: 0.3rem 0.6rem;
                    font-size: 0.85rem;
                }

                .pagination .page-link:hover {
                    background: #bfd9ea;
                    border-color: #4ec7d2;
                    color: #003b73;
                }

                .pagination .page-item.active .page-link {
                    background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
                    border-color: #4ec7d2;
                    color: white;
                }

                .table tbody tr:hover {
                    background-color: rgba(191, 217, 234, 0.08);
                }

                .btn-back:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 12px rgba(78, 199, 210, 0.4) !important;
                }

                #searchInput:focus {
                    border-color: #4ec7d2;
                    box-shadow: 0 0 0 0.2rem rgba(78, 199, 210, 0.15);
                    outline: none;
                }

                .no-results {
                    display: none;
                }
            </style>
        @endpush

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const searchInput = document.getElementById('searchInput');
                    const table = document.getElementById('gradesTable');
                    const rows = table.querySelectorAll('tbody .grade-row');

                    searchInput.addEventListener('keyup', function () {
                        const searchTerm = this.value.toLowerCase().trim();
                        let visibleCount = 0;

                        rows.forEach(function (row) {
                            const text = row.textContent.toLowerCase();

                            if (text.includes(searchTerm)) {
                                row.style.display = '';
                                visibleCount++;
                            } else {
                                row.style.display = 'none';
                            }
                        });

                        // Mostrar mensaje si no hay resultados
                        const emptyRow = table.querySelector('tbody tr:not(.grade-row)');
                        if (visibleCount === 0 && searchTerm !== '') {
                            if (!document.querySelector('.no-results-row')) {
                                const noResultsRow = document.createElement('tr');
                                noResultsRow.className = 'no-results-row';
                                noResultsRow.innerHTML = `
                                    <td colspan="10" class="text-center py-4">
                                        <i class="fas fa-search" style="color: #00508f; opacity: 0.5; font-size: 1.5rem;"></i>
                                        <p class="text-muted mt-2 mb-0">No se encontraron resultados para "<strong>${searchTerm}</strong>"</p>
                                    </td>
                                `;
                                table.querySelector('tbody').appendChild(noResultsRow);
                            }
                        } else {
                            const noResultsRow = document.querySelector('.no-results-row');
                            if (noResultsRow) {
                                noResultsRow.remove();
                            }
                        }
                    });

                    // Animación de aparición en scroll
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                entry.target.style.opacity = '0';
                                entry.target.style.transform = 'translateY(30px)';
                                entry.target.style.transition = 'all 0.6s ease';

                                setTimeout(() => {
                                    entry.target.style.opacity = '1';
                                    entry.target.style.transform = 'translateY(0)';
                                }, 100);
                            }
                        });
                    });

                    // Aplicar animación a las filas de la tabla
                    document.querySelectorAll('.grade-row').forEach(el => {
                        observer.observe(el);
                    });
                });
            </script>
        @endpush
@endsection