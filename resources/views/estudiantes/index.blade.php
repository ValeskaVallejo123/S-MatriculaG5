@extends('layouts.app')

@section('title', 'Estudiantes')

@section('page-title', 'Gestión de Estudiantes')

@section('topbar-actions')
    <a href="{{ route('estudiantes.create') }}" class="btn-back" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: none; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3); font-size: 0.9rem;">
        <i class="fas fa-plus"></i>
        Nuevo Estudiante
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
                        <i class="fas fa-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #00508f; font-size: 0.9rem;"></i>
                        <input type="text"
                               id="searchInput"
                               class="form-control form-control-sm ps-5"
                               placeholder="Buscar por nombre, DNI, grado..."
                               style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.5rem 1rem 0.5rem 2.5rem; transition: all 0.3s ease;">
                    </div>
                </div>

                <!-- Resumen compacto -->
                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-md-end gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-users" style="color: #00508f; font-size: 0.9rem;"></i>
                            <span class="small"><strong style="color: #00508f;">{{ $estudiantes->total() }}</strong> <span class="text-muted">Total</span></span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-check-circle" style="color: #4ec7d2; font-size: 0.9rem;"></i>
                            <span class="small"><strong style="color: #4ec7d2;">{{ $estudiantes->where('estado', 'activo')->count() }}</strong> <span class="text-muted">Activos</span></span>
                        </div>
                        <button class="btn btn-sm" style="border: 2px solid #4ec7d2; color: #4ec7d2; background: white; border-radius: 6px; padding: 0.3rem 0.8rem; font-size: 0.85rem;">
                            <i class="fas fa-download"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla compacta de Estudiantes -->
    <div class="card border-0 shadow-sm" style="border-radius: 10px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="studentsTable">
                    <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
                        <tr>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Foto</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Nombre</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">DNI</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Grado</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Sección</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Estado</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold text-end" style="font-size: 0.7rem; letter-spacing: 0.3px; color: #003b73;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($estudiantes as $estudiante)
                        <tr style="border-bottom: 1px solid #f1f5f9; transition: all 0.2s ease;" class="student-row">
                            <td class="px-3 py-2">
                                <img src="{{ asset('storage/' . $estudiante->foto) }}"
                                     class="rounded-circle object-fit-cover"
                                     style="width: 35px; height: 35px; border: 2px solid #4ec7d2;"
                                     alt="Foto">
                            </td>
                            <td class="px-3 py-2">
                                <div class="fw-semibold" style="color: #003b73; font-size: 0.9rem;">{{ $estudiante->nombre }} {{ $estudiante->apellido }}</div>
                                @if($estudiante->email)
                                <small class="text-muted" style="font-size: 0.75rem;">{{ $estudiante->email }}</small>
                                @endif
                            </td>
                            <td class="px-3 py-2">
                                <span class="font-monospace small" style="color: #00508f; font-size: 0.85rem;">{{ $estudiante->dni }}</span>
                            </td>
                            <td class="px-3 py-2">
                                <span class="badge" style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.3rem 0.6rem; font-weight: 600; font-size: 0.75rem;">{{ $estudiante->grado }}</span>
                            </td>
                            <td class="px-3 py-2">
                                <span class="badge" style="background: rgba(78, 199, 210, 0.15); color: #00508f; border: 1px solid #4ec7d2; padding: 0.3rem 0.6rem; font-weight: 600; font-size: 0.75rem;">{{ $estudiante->seccion }}</span>
                            </td>
                            <td class="px-3 py-2">
                                @if($estudiante->estado === 'activo')
                                    <span class="badge rounded-pill" style="background: rgba(78, 199, 210, 0.2); color: #00508f; padding: 0.3rem 0.7rem; font-weight: 600; border: 1px solid #4ec7d2; font-size: 0.75rem;">
                                        <i class="fas fa-circle" style="font-size: 0.4rem; color: #4ec7d2;"></i> Activo
                                    </span>
                                @else
                                    <span class="badge rounded-pill" style="background: #fee2e2; color: #991b1b; padding: 0.3rem 0.7rem; font-weight: 600; border: 1px solid #ef4444; font-size: 0.75rem;">
                                        <i class="fas fa-circle" style="font-size: 0.4rem;"></i> Inactivo
                                    </span>
                                @endif
                            </td>
                            <td class="px-3 py-2 text-end">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('estudiantes.show', $estudiante->id) }}"
                                       class="btn btn-sm"
                                       style="border-radius: 6px 0 0 6px; border: 1.5px solid #00508f; color: #00508f; background: white; padding: 0.3rem 0.6rem; font-size: 0.8rem;"
                                       title="Ver"
                                       onmouseover="this.style.background='#00508f'; this.style.color='white';"
                                       onmouseout="this.style.background='white'; this.style.color='#00508f';">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('estudiantes.edit', $estudiante->id) }}"
                                       class="btn btn-sm"
                                       style="border-radius: 0; border: 1.5px solid #4ec7d2; border-left: none; color: #4ec7d2; background: white; padding: 0.3rem 0.6rem; font-size: 0.8rem;"
                                       title="Editar"
                                       onmouseover="this.style.background='#4ec7d2'; this.style.color='white';"
                                       onmouseout="this.style.background='white'; this.style.color='#4ec7d2';">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                   <button type="button"
        class="btn btn-sm"
        style="border-radius: 0 6px 6px 0; border: 1.5px solid #ef4444; border-left: none; color: #ef4444; background: white; padding: 0.3rem 0.6rem; font-size: 0.8rem;"
        title="Eliminar"
        onclick="mostrarModalDelete('{{ route('estudiantes.destroy', $estudiante->id) }}', '¿Estás seguro de eliminar este estudiante?', '{{ $estudiante->nombre1 }} {{ $estudiante->apellido1 }}')"
        onmouseover="this.style.background='#ef4444'; this.style.color='white';"
        onmouseout="this.style.background='white'; this.style.color='#ef4444';">
    <i class="fas fa-trash"></i>
</button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2" style="color: #00508f; opacity: 0.5;"></i>
                                    <h6 style="color: #003b73;">No hay estudiantes registrados</h6>
                                    <p class="small mb-3">Comienza agregando el primer estudiante</p>
                                    <a href="{{ route('estudiantes.create') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border-radius: 8px; padding: 0.5rem 1.2rem;">
                                        <i class="fas fa-plus me-1"></i>Registrar Estudiante
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginación compacta -->
        @if($estudiantes->hasPages())
        <div class="card-footer bg-white border-0 py-2 px-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small" style="font-size: 0.8rem;">
                    {{ $estudiantes->firstItem() }} - {{ $estudiantes->lastItem() }} de {{ $estudiantes->total() }}
                </div>
                <div>
                    {{ $estudiantes->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>

</div>

@push('styles')
<style>
    .table > :not(caption) > * > * {
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
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const table = document.getElementById('studentsTable');
    const rows = table.querySelectorAll('tbody .student-row');

    searchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase().trim();
        let visibleCount = 0;

        rows.forEach(function(row) {
            const text = row.textContent.toLowerCase();

            if (text.includes(searchTerm)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Mostrar mensaje si no hay resultados
        const emptyRow = table.querySelector('tbody tr:not(.student-row)');
        if (visibleCount === 0 && searchTerm !== '') {
            if (!document.querySelector('.no-results-row')) {
                const noResultsRow = document.createElement('tr');
                noResultsRow.className = 'no-results-row';
                noResultsRow.innerHTML = `
                    <td colspan="7" class="text-center py-4">
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
});
</script>
@endpush
@endsection
