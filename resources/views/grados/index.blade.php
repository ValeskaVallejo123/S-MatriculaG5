@extends('layouts.app')

@section('title', 'Grados')

@section('page-title', 'Gestión de Grados')

@section('topbar-actions')
    <a href="{{ route('grados.create') }}" class="btn-back"
        style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: none; box-shadow: 0 2px 8px rgba(218, 245, 247, 0.3); font-size: 0.9rem;">
        Nuevo Grado
    </a>
    <a href="{{ route('plantilla') }}" class="btn-back"
        style="background: #e2e8f0; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 1px solid #bfd9ea; font-size: 0.9rem;">
        Volver
    </a>
@endsection

@section('content')
    {{-- Asegúrate de que este CDN está antes de usar cualquier icono --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-RXf+QSDCUQs6Q0siJY9Jv2a8lm2SleqU9jwELyhlHLLJoPLD114F8CbnZ4PlzyBbs6k8ZZr3Su2MzKK3SU8ykg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <div class="container" style="max-width: 1400px; font-family: 'Poppins', sans-serif;">

        {{-- Mensaje de éxito --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert"
                style="border-radius: 8px; background-color: #d1f7e0; border-color: #4ec7d2; color: #00508f; font-family: 'Poppins', sans-serif;">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm mb-3"
            style="border-radius: 10px; box-shadow: 0 8px 30px rgba(0, 59, 115, 0.1) !important;">
            <div class="card-body p-3">
                <div class="row align-items-center g-2">
                    <div class="col-md-6">
                        <div class="position-relative">
                            <input type="text" id="searchInput" class="form-control form-control-sm ps-3"
                                placeholder="Buscar por grado, sección, maestro o jornada..."
                                style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.5rem 1rem; transition: all 0.3s ease; font-family: 'Poppins', sans-serif;">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex align-items-center justify-content-md-end gap-3">
                            <div class="d-flex align-items-center gap-2">
                                <span class="small" style="font-family: 'Poppins', sans-serif;"><strong
                                        style="color: #00508f;">{{ $grados->count() }}</strong> <span
                                        class="text-muted">Total de Grados</span></span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="small" style="font-family: 'Poppins', sans-serif;"><strong
                                        style="color: #4ec7d2;">{{ $grados->where('jornada', 'Matutina')->count() }}</strong>
                                    <span class="text-muted">Matutinos</span></span>
                            </div>
                            <button class="btn btn-sm"
                                style="border: 2px solid #4ec7d2; color: #4ec7d2; background: white; border-radius: 6px; padding: 0.3rem 0.8rem; font-size: 0.85rem; transition: all 0.3s ease; font-family: 'Poppins', sans-serif;">
                                Exportar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm"
            style="border-radius: 10px; background: white; box-shadow: 0 8px 30px rgba(0, 59, 115, 0.1) !important; overflow: hidden;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="gradosTable"
                        style="font-family: 'Poppins', sans-serif;">
                        <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
                            <tr>
                                <th class="px-3 py-2 text-uppercase small fw-semibold"
                                    style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73; font-family: 'Poppins', sans-serif;">
                                    ID</th>
                                <th class="px-3 py-2 text-uppercase small fw-semibold"
                                    style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73; font-family: 'Poppins', sans-serif;">
                                    Grado</th>
                                <th class="px-3 py-2 text-uppercase small fw-semibold"
                                    style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73; font-family: 'Poppins', sans-serif;">
                                    Sección</th>
                                <th class="px-3 py-2 text-uppercase small fw-semibold"
                                    style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73; font-family: 'Poppins', sans-serif;">
                                    Maestro Encargado</th>
                                <th class="px-3 py-2 text-uppercase small fw-semibold"
                                    style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73; font-family: 'Poppins', sans-serif;">
                                    Jornada</th>
                                <th class="px-3 py-2 text-uppercase small fw-semibold text-end"
                                    style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73; font-family: 'Poppins', sans-serif;">
                                    Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($grados as $grado)
                                <tr style="border-bottom: 1px solid #f1f5f9; transition: all 0.2s ease; background: white;"
                                    class="grado-row">
                                    <td class="px-3 py-2">
                                        <span class="font-monospace small"
                                            style="color: #00508f; font-size: 0.85rem; font-family: 'Poppins', sans-serif;">{{ $grado->id }}</span>
                                    </td>
                                    <td class="px-3 py-2">
                                        <div class="fw-semibold"
                                            style="color: #003b73; font-size: 0.9rem; font-family: 'Poppins', sans-serif; font-weight: 600;">
                                            {{ $grado->nombre }}
                                        </div>
                                    </td>
                                    <td class="px-3 py-2">
                                        <span class="badge"
                                            style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.3rem 0.6rem; font-weight: 600; font-size: 0.75rem; border-radius: 6px; font-family: 'Poppins', sans-serif;">
                                            {{ $grado->seccion ?? 'Sin asignar' }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2">
                                        <small class="text-muted"
                                            style="font-size: 0.8rem; font-family: 'Poppins', sans-serif;">
                                            {{ $grado->nombre_maestro ?? 'Sin asignar' }}
                                        </small>
                                    </td>
                                    <td class="px-3 py-2">
                                        @php
                                            $isMatutina = ($grado->jornada ?? '') === 'Matutina';
                                            $badgeBg = $isMatutina ? 'rgba(0, 80, 143, 0.1)' : 'rgba(255, 193, 7, 0.1)';
                                            $badgeColor = $isMatutina ? '#00508f' : '#856404';
                                            $badgeBorder = $isMatutina ? '#00508f' : '#ffc107';
                                        @endphp
                                        <span class="badge rounded-pill"
                                            style="background: {{ $badgeBg }}; color: {{ $badgeColor }}; padding: 0.3rem 0.7rem; font-weight: 600; border: 1px solid {{ $badgeBorder }}; font-size: 0.75rem; font-family: 'Poppins', sans-serif;">
                                            {{ $grado->jornada ?? 'Sin asignar' }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 text-end">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('grados.show', $grado->id) }}" 
                                               class="btn btn-sm btn-action-ver"
                                               style="border-radius: 6px 0 0 6px; border: 1.5px solid #00508f; color: #00508f; background: white; padding: 0.3rem 0.6rem; font-size: 0.8rem; transition: all 0.3s ease; font-family: 'Poppins', sans-serif;"
                                               title="Ver">
                                                Ver
                                            </a>
                                            <a href="{{ route('grados.edit', $grado->id) }}" 
                                               class="btn btn-sm btn-action-edit"
                                               style="border-radius: 0; border: 1.5px solid #4ec7d2; border-left: none; color: #4ec7d2; background: white; padding: 0.3rem 0.6rem; font-size: 0.8rem; transition: all 0.3s ease; font-family: 'Poppins', sans-serif;"
                                               title="Editar">
                                                Editar
                                            </a>
                                            <form action="{{ route('grados.destroy', $grado->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('¿Está seguro de eliminar el grado {{ $grado->nombre }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-action-delete"
                                                    style="border-radius: 0 6px 6px 0; border: 1.5px solid #ef4444; border-left: none; color: #ef4444; background: white; padding: 0.3rem 0.6rem; font-size: 0.8rem; transition: all 0.3s ease; font-family: 'Poppins', sans-serif;"
                                                    title="Eliminar">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted">
                                            <h6 style="color: #003b73; font-family: 'Poppins', sans-serif; font-weight: 700;">No
                                                hay grados registrados</h6>
                                            <p class="small mb-3" style="font-family: 'Poppins', sans-serif;">Comienza agregando
                                                el primer grado</p>
                                            <a href="{{ route('grados.create') }}" class="btn btn-sm"
                                                style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 8px; padding: 0.5rem 1.2rem; transition: all 0.4s ease; border: none; box-shadow: 0 8px 20px rgba(78, 199, 210, 0.3); font-family: 'Poppins', sans-serif; font-weight: 600;">
                                                Registrar Grado
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <hr>
                    <div
                        class="row">
                        <div class="col-sm-12">
                            {{ $grados->links() }}
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
                padding: 0.6rem 0.75rem;
            }

            .btn-group .btn:hover {
                transform: translateY(-2px) scale(1.05);
                z-index: 1;
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            }

            .btn-action-ver:hover {
                background: #00508f !important;
                color: white !important;
            }

            .btn-action-edit:hover {
                background: #4ec7d2 !important;
                color: white !important;
            }

            .btn-action-delete:hover {
                background: #ef4444 !important;
                color: white !important;
            }

            .table tbody tr:hover {
                background-color: rgba(191, 217, 234, 0.12) !important;
                box-shadow: 0 4px 15px rgba(0, 59, 115, 0.08);
                transform: translateY(-1px);
            }

            .btn-back:hover {
                transform: translateY(-3px) scale(1.05);
                box-shadow: 0 10px 30px rgba(78, 199, 210, 0.5) !important;
            }

            #searchInput:focus {
                border-color: #4ec7d2 !important;
                box-shadow: 0 0 0 0.25rem rgba(78, 199, 210, 0.25) !important;
                outline: none;
            }

            .card {
                transition: all 0.3s ease;
            }

            .card:hover {
                box-shadow: 0 12px 40px rgba(0, 59, 115, 0.15) !important;
            }

            /* Animaciones de entrada */
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

            .badge {
                transition: all 0.3s ease;
            }

            .badge:hover {
                transform: scale(1.1);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            }

            /* Botón de descarga */
            .btn-sm:has(.fa-download):hover {
                background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%) !important;
                color: white !important;
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(78, 199, 210, 0.4);
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const searchInput = document.getElementById('searchInput');
                const table = document.getElementById('gradosTable');
                const rows = table.querySelectorAll('tbody .grado-row');

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
                    const tbody = table.querySelector('tbody');
                    const existingNoResultsRow = document.querySelector('.no-results-row');

                    if (visibleCount === 0 && searchTerm !== '') {
                        if (!existingNoResultsRow) {
                            const noResultsRow = document.createElement('tr');
                            noResultsRow.className = 'no-results-row';
                            noResultsRow.innerHTML = `
                                <td colspan="6" class="text-center py-4" style="font-family: 'Poppins', sans-serif;">
                                    <p class="text-muted mt-2 mb-0">No se encontraron resultados para "<strong>${searchTerm}</strong>"</p>
                                </td>
                            `;
                            tbody.appendChild(noResultsRow);
                        } else {
                            // Actualizar el texto si ya existe la fila
                            existingNoResultsRow.querySelector('strong').textContent = searchTerm;
                            existingNoResultsRow.style.display = '';
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