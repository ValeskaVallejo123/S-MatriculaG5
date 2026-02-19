@extends('layouts.app')

@section('title', 'Estudiantes')
@section('page-title', 'Gestión de Estudiantes')

@section('topbar-actions')
    <a href="{{ route('estudiantes.create') }}"
       style="background:linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);color:white;padding:0.5rem 1.2rem;border-radius:8px;text-decoration:none;font-weight:600;display:inline-flex;align-items:center;gap:0.5rem;border:none;box-shadow:0 2px 8px rgba(78,199,210,0.3);font-size:0.9rem;">
        <i class="fas fa-plus"></i> Nuevo Estudiante
    </a>
@endsection

@push('styles')
<style>
    .table > :not(caption) > * > * { padding: 0.6rem 0.75rem; }
    .btn-group .btn:hover { transform: translateY(-1px); z-index: 1; }
    .pagination { margin-bottom: 0; }
    .pagination .page-link {
        border-radius: 6px; margin: 0 2px; border: 1px solid #e2e8f0;
        color: #00508f; transition: all 0.3s ease; padding: 0.3rem 0.6rem; font-size: 0.85rem;
    }
    .pagination .page-link:hover { background:#bfd9ea; border-color:#4ec7d2; color:#003b73; }
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);
        border-color:#4ec7d2; color:white;
    }
    .table tbody tr:hover { background-color: rgba(191,217,234,0.08); }
    #searchInput:focus {
        border-color:#4ec7d2;
        box-shadow: 0 0 0 0.2rem rgba(78,199,210,0.15);
        outline: none;
    }
</style>
@endpush

@section('content')
<div class="container" style="max-width: 1400px;">

    {{-- Tarjetas de Estadísticas --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius:10px;border-left:4px solid #10b981 !important;">
                <div class="card-body d-flex align-items-center gap-3">
                    <i class="fas fa-users fa-2x" style="color:#10b981;"></i>
                    <div>
                        <p class="text-muted mb-0 small text-uppercase fw-semibold" style="font-size:0.7rem;">Total</p>
                        <h3 class="mb-0 fw-bold" style="color:#003b73;">{{ $estudiantes->total() }}</h3>
                        <small class="text-muted">Estudiantes</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius:10px;border-left:4px solid #4ec7d2 !important;">
                <div class="card-body d-flex align-items-center gap-3">
                    <i class="fas fa-check-circle fa-2x" style="color:#4ec7d2;"></i>
                    <div>
                        <p class="text-muted mb-0 small text-uppercase fw-semibold" style="font-size:0.7rem;">Activos</p>
                        <h3 class="mb-0 fw-bold" style="color:#003b73;">{{ $estudiantes->where('estado','activo')->count() }}</h3>
                        <small class="text-muted">En el sistema</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius:10px;border-left:4px solid #f59e0b !important;">
                <div class="card-body d-flex align-items-center gap-3">
                    <i class="fas fa-exclamation-triangle fa-2x" style="color:#f59e0b;"></i>
                    <div>
                        <p class="text-muted mb-0 small text-uppercase fw-semibold" style="font-size:0.7rem;">Inactivos</p>
                        <h3 class="mb-0 fw-bold" style="color:#003b73;">{{ $estudiantes->where('estado','inactivo')->count() }}</h3>
                        <small class="text-muted">Suspendidos</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius:10px;border-left:4px solid #8b5cf6 !important;">
                <div class="card-body d-flex align-items-center gap-3">
                    <i class="fas fa-clock fa-2x" style="color:#8b5cf6;"></i>
                    <div>
                        <p class="text-muted mb-0 small text-uppercase fw-semibold" style="font-size:0.7rem;">Hoy</p>
                        <h3 class="mb-0 fw-bold" style="color:#003b73;">{{ $estudiantes->where('created_at','>=',today())->count() }}</h3>
                        <small class="text-muted">Nuevos</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Buscador y resumen --}}
    <div class="card border-0 shadow-sm mb-3" style="border-radius:10px;">
        <div class="card-body p-3">
            <div class="row align-items-center g-2">
                <div class="col-md-6">
                    <div class="position-relative">
                        <i class="fas fa-search position-absolute"
                           style="left:12px;top:50%;transform:translateY(-50%);color:#00508f;font-size:0.9rem;"></i>
                        <input type="text" id="searchInput" class="form-control form-control-sm ps-5"
                               placeholder="Buscar por nombre, DNI, grado..."
                               style="border:2px solid #bfd9ea;border-radius:8px;padding:0.5rem 1rem 0.5rem 2.5rem;transition:all 0.3s ease;">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-md-end gap-3">
                        <span class="small">
                            <i class="fas fa-users me-1" style="color:#00508f;"></i>
                            <strong style="color:#00508f;">{{ $estudiantes->total() }}</strong>
                            <span class="text-muted">Total</span>
                        </span>
                        <span class="small">
                            <i class="fas fa-check-circle me-1" style="color:#4ec7d2;"></i>
                            <strong style="color:#4ec7d2;">{{ $estudiantes->where('estado','activo')->count() }}</strong>
                            <span class="text-muted">Activos</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="card border-0 shadow-sm" style="border-radius:10px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="studentsTable">
                    <thead style="background:linear-gradient(135deg,#f8fafc 0%,#e2e8f0 100%);">
                        <tr>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size:0.7rem;color:#003b73;">Foto</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size:0.7rem;color:#003b73;">Nombre</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size:0.7rem;color:#003b73;">DNI</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size:0.7rem;color:#003b73;">Grado</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size:0.7rem;color:#003b73;">Sección</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold" style="font-size:0.7rem;color:#003b73;">Estado</th>
                            <th class="px-3 py-2 text-uppercase small fw-semibold text-end" style="font-size:0.7rem;color:#003b73;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($estudiantes as $estudiante)
                        <tr style="border-bottom:1px solid #f1f5f9;transition:all 0.2s ease;" class="student-row">

                            {{-- Foto --}}
                            <td class="px-3 py-2">
                                @if($estudiante->foto)
                                    <img src="{{ asset('storage/' . $estudiante->foto) }}"
                                         class="rounded-circle object-fit-cover"
                                         style="width:35px;height:35px;border:2px solid #4ec7d2;"
                                         alt="Foto">
                                @else
                                    <div style="width:35px;height:35px;background:linear-gradient(135deg,#4ec7d2,#00508f);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:0.85rem;">
                                        {{-- nombre1 y apellido1 según modelo Estudiante --}}
                                        {{ strtoupper(substr($estudiante->nombre1 ?? 'E', 0, 1)) }}{{ strtoupper(substr($estudiante->apellido1 ?? '', 0, 1)) }}
                                    </div>
                                @endif
                            </td>

                            {{-- Nombre --}}
                            <td class="px-3 py-2">
                                <div class="fw-semibold" style="color:#003b73;font-size:0.9rem;">
                                    {{ $estudiante->nombre_completo }}
                                </div>
                                @if($estudiante->email)
                                    <small class="text-muted" style="font-size:0.75rem;">{{ $estudiante->email }}</small>
                                @endif
                            </td>

                            {{-- DNI --}}
                            <td class="px-3 py-2">
                                <span class="font-monospace small" style="color:#00508f;font-size:0.85rem;">{{ $estudiante->dni }}</span>
                            </td>

                            {{-- Grado --}}
                            <td class="px-3 py-2">
                                <span class="badge" style="background:rgba(78,199,210,0.15);color:#00508f;border:1px solid #4ec7d2;padding:0.3rem 0.6rem;font-size:0.75rem;">
                                    {{ $estudiante->grado }}
                                </span>
                            </td>

                            {{-- Sección --}}
                            <td class="px-3 py-2">
                                <span class="badge" style="background:rgba(78,199,210,0.15);color:#00508f;border:1px solid #4ec7d2;padding:0.3rem 0.6rem;font-size:0.75rem;">
                                    {{ $estudiante->seccion }}
                                </span>
                            </td>

                            {{-- Estado --}}
                            <td class="px-3 py-2">
                                @if($estudiante->estado === 'activo')
                                    <span class="badge rounded-pill"
                                          style="background:rgba(78,199,210,0.2);color:#00508f;border:1px solid #4ec7d2;padding:0.3rem 0.7rem;font-size:0.75rem;">
                                        <i class="fas fa-circle me-1" style="font-size:0.4rem;color:#4ec7d2;"></i>Activo
                                    </span>
                                @else
                                    <span class="badge rounded-pill"
                                          style="background:#fee2e2;color:#991b1b;border:1px solid #ef4444;padding:0.3rem 0.7rem;font-size:0.75rem;">
                                        <i class="fas fa-circle me-1" style="font-size:0.4rem;"></i>Inactivo
                                    </span>
                                @endif
                            </td>

                            {{-- Acciones --}}
                            <td class="px-3 py-2 text-end">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('estudiantes.show', $estudiante->id) }}"
                                       class="btn btn-sm"
                                       style="border-radius:6px 0 0 6px;border:1.5px solid #00508f;color:#00508f;background:white;padding:0.3rem 0.6rem;font-size:0.8rem;"
                                       title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('estudiantes.edit', $estudiante->id) }}"
                                       class="btn btn-sm"
                                       style="border-radius:0;border:1.5px solid #4ec7d2;border-left:none;color:#4ec7d2;background:white;padding:0.3rem 0.6rem;font-size:0.8rem;"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    {{-- Eliminar usa mostrarModalDelete() del layout --}}
                                    <button type="button"
                                            class="btn btn-sm"
                                            style="border-radius:0 6px 6px 0;border:1.5px solid #ef4444;border-left:none;color:#ef4444;background:white;padding:0.3rem 0.6rem;font-size:0.8rem;"
                                            title="Eliminar"
                                            onclick="mostrarModalDelete(
                                                '{{ route('estudiantes.destroy', $estudiante->id) }}',
                                                '¿Está seguro de eliminar este estudiante? Esta acción no se puede deshacer.',
                                                '{{ $estudiante->nombre_completo }}'
                                            )">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-inbox fa-2x mb-2" style="color:#00508f;opacity:0.5;"></i>
                                <h6 style="color:#003b73;">No hay estudiantes registrados</h6>
                                <p class="small mb-3 text-muted">Comienza agregando el primer estudiante</p>
                                <a href="{{ route('estudiantes.create') }}" class="btn btn-sm"
                                   style="background:linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);color:white;border-radius:8px;padding:0.5rem 1.2rem;">
                                    <i class="fas fa-plus me-1"></i>Registrar Estudiante
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Paginación --}}
        @if($estudiantes->hasPages())
        <div class="card-footer bg-white border-0 py-2 px-3">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    {{ $estudiantes->firstItem() }} – {{ $estudiantes->lastItem() }} de {{ $estudiantes->total() }}
                </small>
                {{ $estudiantes->links() }}
            </div>
        </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const tbody = document.querySelector('#studentsTable tbody');
    const rows = tbody.querySelectorAll('.student-row');

    searchInput.addEventListener('keyup', function () {
        const term = this.value.toLowerCase().trim();
        let visible = 0;

        rows.forEach(function (row) {
            const match = row.textContent.toLowerCase().includes(term);
            row.style.display = match ? '' : 'none';
            if (match) visible++;
        });

        // Mostrar/quitar fila de "sin resultados"
        let noRow = tbody.querySelector('.no-results-row');
        if (visible === 0 && term !== '') {
            if (!noRow) {
                noRow = document.createElement('tr');
                noRow.className = 'no-results-row';
                noRow.innerHTML = `<td colspan="7" class="text-center py-4">
                    <i class="fas fa-search" style="color:#00508f;opacity:0.5;font-size:1.5rem;"></i>
                    <p class="text-muted mt-2 mb-0">No se encontraron resultados para "<strong>${term}</strong>"</p>
                </td>`;
                tbody.appendChild(noRow);
            }
        } else if (noRow) {
            noRow.remove();
        }
    });
});
</script>
@endpush
