@extends('layouts.app')

@section('title', 'Grados Disponibles')

@section('page-title', 'Grados de Educación Primaria')

@section('topbar-actions')
    <a href="{{ route('plantilla') }}" class="btn-back"
        style="background: #e2e8f0; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 1px solid #bfd9ea; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i> Volver al Inicio
    </a>
@endsection

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <div class="container" style="max-width: 1400px; font-family: 'Poppins', sans-serif;">

        {{-- Información Introductoria --}}
        <div class="alert alert-info border-0 shadow-sm mb-4"
            style="border-radius: 10px; background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); border-left: 4px solid #0284c7;">
            <div class="d-flex align-items-start">
                <i class="fas fa-info-circle fa-2x me-3" style="color: #0284c7;"></i>
                <div>
                    <h5 class="mb-2" style="color: #0c4a6e; font-weight: 700;">Plan de Estudios de Educación Primaria</h5>
                    <p class="mb-0" style="color: #0c4a6e;">
                        Consulta los grados disponibles, secciones, maestros encargados y jornadas.
                        Haz clic en "Ver Clases" para conocer las materias de cada grado.
                    </p>
                </div>
            </div>
        </div>

        {{-- Card de búsqueda y estadísticas --}}
        <div class="card border-0 shadow-sm mb-3"
            style="border-radius: 10px; box-shadow: 0 8px 30px rgba(0, 59, 115, 0.1) !important;">
            <div class="card-body p-3">
                <div class="row align-items-center g-2">
                    <div class="col-md-6">
                        <div class="position-relative">
                            <i class="fas fa-search position-absolute"
                                style="left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                            <input type="text" id="searchInput" class="form-control form-control-sm"
                                placeholder="Buscar por grado, sección, maestro o jornada..."
                                style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.5rem 1rem 0.5rem 2.5rem;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center justify-content-md-end gap-3 flex-wrap">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-graduation-cap" style="color: #00508f;"></i>
                                <span class="small"><strong style="color: #00508f;">{{ $grados->total() }}</strong>
                                    <span class="text-muted">Grados Totales</span>
                                </span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-sun" style="color: #4ec7d2;"></i>
                                <span class="small"><strong
                                        style="color: #4ec7d2;">{{ $grados->where('jornada', 'Matutina')->count() }}</strong>
                                    <span class="text-muted">Matutinos</span>
                                </span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-moon" style="color: #fbbf24;"></i>
                                <span class="small"><strong
                                        style="color: #f59e0b;">{{ $grados->where('jornada', 'Vespertina')->count() }}</strong>
                                    <span class="text-muted">Vespertinos</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabla de Grados --}}
        <div class="card border-0 shadow-sm"
            style="border-radius: 10px; background: white; box-shadow: 0 8px 30px rgba(0, 59, 115, 0.1) !important; overflow: hidden;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="gradosTable">
                        <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
                            <tr>
                                <th class="px-4 py-3 text-uppercase small fw-semibold"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; color: #003b73;">
                                    <i class="fas fa-book-open me-2"></i>Grado
                                </th>
                                <th class="px-4 py-3 text-uppercase small fw-semibold"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; color: #003b73;">
                                    <i class="fas fa-layer-group me-2"></i>Sección
                                </th>
                                <th class="px-4 py-3 text-uppercase small fw-semibold"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; color: #003b73;">
                                    <i class="fas fa-chalkboard-teacher me-2"></i>Maestro Encargado
                                </th>
                                <th class="px-4 py-3 text-uppercase small fw-semibold"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; color: #003b73;">
                                    <i class="fas fa-clock me-2"></i>Jornada
                                </th>
                                <th class="px-4 py-3 text-uppercase small fw-semibold text-end"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; color: #003b73;">
                                    <i class="fas fa-cog me-2"></i>Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($grados as $grado)
                                <tr class="grado-row" style="border-bottom: 1px solid #f1f5f9; transition: all 0.3s ease;">
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3"
                                                style="width: 45px; height: 45px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.85rem; box-shadow: 0 4px 12px rgba(78, 199, 210, 0.3);">
                                                {{ substr($grado->nombre, 0, 2) }}
                                            </div>
                                            <div>
                                                <div class="fw-semibold"
                                                    style="color: #003b73; font-size: 0.95rem; font-weight: 600;">
                                                    {{ $grado->nombre }}
                                                </div>
                                                <small class="text-muted" style="font-size: 0.75rem;">Educación Primaria</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge"
                                            style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.4rem 0.8rem; font-weight: 600; font-size: 0.8rem; border-radius: 8px;">
                                            {{ $grado->seccion ?? 'Sin asignar' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="me-2"
                                                style="width: 32px; height: 32px; background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-user" style="color: #0284c7; font-size: 0.75rem;"></i>
                                            </div>
                                            <div>
                                                <div style="font-size: 0.85rem; color: #1e293b; font-weight: 500;">
                                                    {{ $grado->nombre_maestro ?? 'Sin asignar' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
                                            $isMatutina = ($grado->jornada ?? '') === 'Matutina';
                                            $badgeBg = $isMatutina ? 'rgba(0, 80, 143, 0.1)' : 'rgba(251, 191, 36, 0.1)';
                                            $badgeColor = $isMatutina ? '#00508f' : '#b45309';
                                            $badgeBorder = $isMatutina ? '#00508f' : '#fbbf24';
                                            $icon = $isMatutina ? 'fa-sun' : 'fa-moon';
                                        @endphp
                                        <span class="badge rounded-pill d-inline-flex align-items-center gap-1"
                                            style="background: {{ $badgeBg }}; color: {{ $badgeColor }}; padding: 0.4rem 0.9rem; font-weight: 600; border: 1px solid {{ $badgeBorder }}; font-size: 0.8rem;">
                                            <i class="fas {{ $icon }}"></i>
                                            {{ $grado->jornada ?? 'Sin asignar' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-end">
                                        <div class="btn-group" role="group">
    
    <div class="btn-group" role="group">
        <a href="{{ route('publico.grados.showPublico', $grado->id) }}"
    class="btn btn-sm btn-action-ver"
    style="border-radius: 6px; border: 1.5px solid #00508f; color: #00508f; background: white; padding: 0.3rem 0.6rem; font-size: 0.8rem; transition: all 0.3s ease; font-family: 'Poppins', sans-serif;"
    title="Ver Detalles del Grado">
    <i class="fas fa-eye me-1"></i> Ver Detalles
</a>
    </div>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-4x mb-3" style="color: #cbd5e1; opacity: 0.5;"></i>
                                            <h5 style="color: #64748b; font-weight: 600;">No hay grados registrados</h5>
                                            <p class="mb-0" style="color: #94a3b8;">Por el momento no hay información disponible
                                                sobre los grados.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if($grados->hasPages())
                        <hr class="my-0">
                        <div class="p-3 d-flex justify-content-center">
                            {{ $grados->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Información Adicional --}}
        <div class="row mt-4">
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 10px; border-left: 4px solid #4ec7d2;">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-graduation-cap fa-2x me-3" style="color: #4ec7d2;"></i>
                            <div>
                                <h6 class="mb-2" style="color: #003b73; font-weight: 700;">Educación de Calidad</h6>
                                <p class="small text-muted mb-0">Ofrecemos un plan de estudios completo y actualizado.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 10px; border-left: 4px solid #00508f;">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-users fa-2x me-3" style="color: #00508f;"></i>
                            <div>
                                <h6 class="mb-2" style="color: #003b73; font-weight: 700;">Maestros Calificados</h6>
                                <p class="small text-muted mb-0">Contamos con personal docente altamente capacitado.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 10px; border-left: 4px solid #0284c7;">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-clock fa-2x me-3" style="color: #0284c7;"></i>
                            <div>
                                <h6 class="mb-2" style="color: #003b73; font-weight: 700;">Horarios Flexibles</h6>
                                <p class="small text-muted mb-0">Jornadas matutina y vespertina disponibles.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            * {
                font-family: 'Poppins', sans-serif !important;
            }

            body {
                background: linear-gradient(to bottom, #f8f9fa 0%, #ffffff 100%);
            }

            .table> :not(caption)>*>* {
                padding: 0.75rem 1rem;
            }

            .table tbody tr:hover {
                background-color: rgba(78, 199, 210, 0.08) !important;
                box-shadow: 0 4px 20px rgba(0, 59, 115, 0.1);
                transform: translateY(-2px);
            }

            #searchInput:focus {
                border-color: #4ec7d2 !important;
                box-shadow: 0 0 0 0.25rem rgba(78, 199, 210, 0.25) !important;
                outline: none;
            }

            .btn-back:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(0, 80, 143, 0.2);
            }

            .btn-action-ver:hover {
                background: #00508f !important;
                color: white !important;
                transform: translateY(-2px) scale(1.05);
                box-shadow: 0 8px 20px rgba(0, 80, 143, 0.3);
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .grado-row {
                animation: fadeInUp 0.6s ease forwards;
                opacity: 0;
            }

            .grado-row:nth-child(1) {
                animation-delay: 0.05s;
            }

            .grado-row:nth-child(2) {
                animation-delay: 0.1s;
            }

            .grado-row:nth-child(3) {
                animation-delay: 0.15s;
            }

            .grado-row:nth-child(4) {
                animation-delay: 0.2s;
            }

            .grado-row:nth-child(5) {
                animation-delay: 0.25s;
            }

            .grado-row:nth-child(6) {
                animation-delay: 0.3s;
            }

            .grado-row:nth-child(7) {
                animation-delay: 0.35s;
            }

            .grado-row:nth-child(8) {
                animation-delay: 0.4s;
            }

            .grado-row:nth-child(9) {
                animation-delay: 0.45s;
            }

            .grado-row:nth-child(10) {
                animation-delay: 0.5s;
            }

            .card {
                transition: all 0.3s ease;
            }

            .card:hover {
                transform: translateY(-2px);
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const searchInput = document.getElementById('searchInput');
                const rows = document.querySelectorAll('.grado-row');

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

                    const tbody = document.querySelector('tbody');
                    let existingNoResultsRow = document.querySelector('.no-results-row');

                    if (visibleCount === 0 && searchTerm !== '') {
                        if (!existingNoResultsRow) {
                            const noResultsRow = document.createElement('tr');
                            noResultsRow.className = 'no-results-row';
                            noResultsRow.innerHTML = `
                                        <td colspan="5" class="text-center py-5">
                                            <i class="fas fa-search fa-3x mb-3" style="color: #cbd5e1; opacity: 0.5;"></i>
                                            <h6 class="text-muted">No se encontraron resultados</h6>
                                            <p class="small text-muted mb-0">No hay grados que coincidan con "<strong style="color: #00508f;">${searchTerm}</strong>"</p>
                                        </td>
                                    `;
                            tbody.appendChild(noResultsRow);
                        } else {
                            existingNoResultsRow.querySelector('strong').textContent = searchTerm;
                        }
                    } else {
                        if (existingNoResultsRow) {
                            existingNoResultsRow.remove();
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection