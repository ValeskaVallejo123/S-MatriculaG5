@extends('layouts.app')

@section('title', 'Estudiantes')
@section('page-title', 'Gestión de Estudiantes')

@section('content')
<div class="container" style="max-width:1400px;">

    {{-- ── Barra de búsqueda y resumen ──────────────────────────────────── --}}
    <div class="card border-0 shadow-sm mb-3" style="border-radius:10px;">
        <div class="card-body p-3">
            <div class="row align-items-center g-2">

                {{-- Buscador --}}
                <div class="col-md-6">
                    <div class="position-relative">
                        <i class="fas fa-search position-absolute"
                           style="left:12px; top:50%; transform:translateY(-50%);
                                  color:#00508f; font-size:0.9rem;"></i>
                        <input type="text" id="searchInput"
                               class="form-control form-control-sm ps-5"
                               placeholder="Buscar por nombre, DNI, grado..."
                               style="border:2px solid #bfd9ea; border-radius:8px;
                                      padding:0.5rem 1rem 0.5rem 2.5rem;">
                    </div>
                </div>

                {{-- Resumen y acciones --}}
                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-md-end gap-3">

                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-users" style="color:#00508f;"></i>
                            <span class="small">
                                <strong style="color:#00508f;">{{ $estudiantes->total() }}</strong>
                                <span class="text-muted">Total</span>
                            </span>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-check-circle" style="color:#4ec7d2;"></i>
                            <span class="small">
                                <strong style="color:#4ec7d2;">
                                    {{ $estudiantes->where('estado', 'activo')->count() }}
                                </strong>
                                <span class="text-muted">Activos</span>
                            </span>
                        </div>

                        <a href="{{ route('estudiantes.create') }}"
                           class="btn btn-sm fw-semibold"
                           style="background:linear-gradient(135deg,#4ec7d2,#00508f);
                                  color:white; border:none; border-radius:8px;">
                            <i class="fas fa-plus me-1"></i>Nuevo Estudiante
                        </a>

                        <button class="btn btn-sm"
                                style="border:2px solid #4ec7d2; color:#4ec7d2; border-radius:8px;"
                                title="Exportar">
                            <i class="fas fa-download"></i>
                        </button>

                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ── Tabla de estudiantes ───────────────────────────────────────────── --}}
    <div class="card border-0 shadow-sm" style="border-radius:10px;">
        <div class="card-body p-0">
            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0" id="studentsTable">
                    <thead style="background:linear-gradient(135deg,#f8fafc 0%,#e2e8f0 100%);">
                        <tr>
                            <th class="px-3 py-2 small text-uppercase fw-semibold">Foto</th>
                            <th class="px-3 py-2 small text-uppercase fw-semibold">Nombre</th>
                            <th class="px-3 py-2 small text-uppercase fw-semibold">DNI</th>
                            <th class="px-3 py-2 small text-uppercase fw-semibold">Grado</th>
                            <th class="px-3 py-2 small text-uppercase fw-semibold">Sección</th>
                            <th class="px-3 py-2 small text-uppercase fw-semibold">Estado</th>
                            <th class="px-3 py-2 small text-uppercase fw-semibold text-end">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse ($estudiantes as $estudiante)

                        @php
                            $estados = [
                                'activo'     => ['color' => '#00508f', 'bg' => 'rgba(78,199,210,0.2)', 'label' => 'Activo',     'icon' => 'fa-check-circle'],
                                'inactivo'   => ['color' => '#991b1b', 'bg' => '#fee2e2',              'label' => 'Inactivo',   'icon' => 'fa-times-circle'],
                                'retirado'   => ['color' => '#b45309', 'bg' => '#fef3c7',              'label' => 'Retirado',   'icon' => 'fa-sign-out-alt'],
                                'suspendido' => ['color' => '#4b5563', 'bg' => '#e5e7eb',              'label' => 'Suspendido', 'icon' => 'fa-pause-circle'],
                            ];
                            // Fallback si el estado no existe en el array
                            $estadoInfo = $estados[$estudiante->estado] ?? [
                                'color' => '#6b7280', 'bg' => '#f3f4f6',
                                'label' => ucfirst($estudiante->estado), 'icon' => 'fa-circle',
                            ];
                        @endphp

                        <tr class="student-row">

                            {{-- Foto --}}
                            <td class="px-3 py-2">
                                @if($estudiante->foto)
                                    <img src="{{ asset('storage/' . $estudiante->foto) }}"
                                         alt="Foto de {{ $estudiante->nombre1 }}"
                                         class="rounded-circle object-fit-cover"
                                         style="width:35px; height:35px; border:2px solid #4ec7d2;">
                                @else
                                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                                         style="width:35px; height:35px; background:rgba(78,199,210,0.2);
                                                border:2px solid #4ec7d2;">
                                        <i class="fas fa-user" style="color:#00508f; font-size:0.85rem;"></i>
                                    </div>
                                @endif
                            </td>

                            {{-- Nombre --}}
                            <td class="px-3 py-2">
                                <div class="fw-semibold" style="color:#003b73; font-size:0.9rem;">
                                    {{ $estudiante->nombre_completo }}
                                </div>
                                @if($estudiante->email)
                                    <small class="text-muted" style="font-size:0.75rem;">
                                        {{ $estudiante->email }}
                                    </small>
                                @endif
                            </td>

                            {{-- DNI --}}
                            <td class="px-3 py-2">
                                <span class="font-monospace small" style="color:#00508f;">
                                    {{ $estudiante->dni ?? '—' }}
                                </span>
                            </td>

                            {{-- Grado --}}
                            <td class="px-3 py-2">
                                <span class="badge"
                                      style="background:rgba(78,199,210,0.15);
                                             color:#00508f; border:1px solid #4ec7d2;">
                                    {{ $estudiante->grado }}
                                </span>
                            </td>

                            {{-- Sección --}}
                            <td class="px-3 py-2">
                                <span class="badge"
                                      style="background:rgba(78,199,210,0.15);
                                             color:#00508f; border:1px solid #4ec7d2;">
                                    {{ $estudiante->seccion }}
                                </span>
                            </td>

                            {{-- Estado --}}
                            <td class="px-3 py-2">
                                <span class="badge rounded-pill"
                                      style="background:{{ $estadoInfo['bg'] }};
                                             color:{{ $estadoInfo['color'] }};
                                             padding:0.3rem 0.7rem;
                                             border:1px solid {{ $estadoInfo['color'] }};">
                                    <i class="fas {{ $estadoInfo['icon'] }} me-1" style="font-size:0.65rem;"></i>
                                    {{ $estadoInfo['label'] }}
                                </span>
                            </td>

                            {{-- Acciones --}}
                            <td class="px-3 py-2 text-end">
                                <div class="btn-group">

                                    <a href="{{ route('estudiantes.show', $estudiante->id) }}"
                                       class="btn btn-sm"
                                       title="Ver detalle"
                                       style="border:1.5px solid #00508f; color:#00508f;">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('estudiantes.edit', $estudiante->id) }}"
                                       class="btn btn-sm"
                                       title="Editar"
                                       style="border:1.5px solid #4ec7d2; color:#4ec7d2;">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- Botón eliminar — un solo botón con data-* --}}
                                    <button type="button"
                                            class="btn btn-sm btn-delete-estudiante"
                                            title="Eliminar"
                                            style="border:1.5px solid #ef4444; color:#ef4444;"
                                            data-url="{{ route('estudiantes.destroy', $estudiante->id) }}"
                                            data-nombre="{{ $estudiante->nombre1 }} {{ $estudiante->apellido1 }}">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-inbox fa-2x mb-2 d-block" style="color:#00508f; opacity:0.5;"></i>
                                <h6 class="mb-3" style="color:#003b73;">No hay estudiantes registrados</h6>
                                <a href="{{ route('estudiantes.create') }}"
                                   class="btn btn-sm"
                                   style="background:linear-gradient(135deg,#4ec7d2,#00508f); color:white;">
                                    <i class="fas fa-plus me-1"></i>Registrar Estudiante
                                </a>
                            </td>
                        </tr>

                    @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    {{-- Paginación --}}
    @if($estudiantes->hasPages())
    <div class="d-flex justify-content-center mt-3">
        {{ $estudiantes->links() }}
    </div>
    @endif

</div>

{{-- Modal de confirmación de eliminación --}}
<div class="modal fade" id="modalDeleteEstudiante" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius:12px;">
            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center gap-2">
                    <div style="width:40px; height:40px; background:#fee2e2; border-radius:10px;
                                display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-trash" style="color:#ef4444;"></i>
                    </div>
                    <h6 class="modal-title fw-bold mb-0" style="color:#003b73;">Eliminar Estudiante</h6>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-3">
                <p class="text-muted mb-0">
                    ¿Estás seguro de que deseas eliminar a
                    <strong id="modalNombreEstudiante" style="color:#003b73;"></strong>?
                    Esta acción no se puede deshacer.
                </p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-sm fw-semibold"
                        data-bs-dismiss="modal"
                        style="border:2px solid #00508f; color:#00508f; border-radius:8px;">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <form id="formDeleteEstudiante" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="btn btn-sm fw-semibold"
                            style="background:#ef4444; color:white; border:none; border-radius:8px;">
                        <i class="fas fa-trash me-1"></i>Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Búsqueda en tiempo real ──────────────────────────────────────────
    const searchInput = document.getElementById('searchInput');
    const rows        = document.querySelectorAll('.student-row');

    searchInput?.addEventListener('input', function () {
        const term = this.value.toLowerCase();
        rows.forEach(function (row) {
            row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
        });
    });

    // ── Modal eliminar ───────────────────────────────────────────────────
    const botonesDelete = document.querySelectorAll('.btn-delete-estudiante');
    const modalEl       = document.getElementById('modalDeleteEstudiante');
    const modalNombre   = document.getElementById('modalNombreEstudiante');
    const formDelete    = document.getElementById('formDeleteEstudiante');
    const modal         = new bootstrap.Modal(modalEl);

    botonesDelete.forEach(function (btn) {
        btn.addEventListener('click', function () {
            modalNombre.textContent  = this.dataset.nombre;
            formDelete.action        = this.dataset.url;
            modal.show();
        });
    });

});
</script>
@endpush
