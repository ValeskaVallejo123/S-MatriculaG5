@extends('layouts.app')

@section('title', 'Estudiantes')
@section('page-title', 'Gestión de Estudiantes')

@section('topbar-actions')
    {{-- CORRECCIÓN: el original no tenía botón de "Nuevo Estudiante" en el topbar --}}
    <a href="{{ route('estudiantes.create') }}"
       class="btn btn-sm btn-primary"
       style="border-radius:8px; font-weight:600;">
        <i class="fas fa-plus me-1"></i> Nuevo Estudiante
    </a>
@endsection

@section('content')
<div class="container" style="max-width:1400px;">

    {{-- ── Barra de búsqueda y resumen ── --}}
    <div class="card border-0 shadow-sm mb-3" style="border-radius:10px;">
        <div class="card-body p-3">
            <div class="row align-items-center g-2">

                {{-- Buscador --}}
                <div class="col-md-6">
                    <div class="position-relative">
                        <i class="fas fa-search position-absolute"
                           style="left:12px; top:50%; transform:translateY(-50%);
                                  color:#00508f; font-size:.9rem; pointer-events:none;"></i>
                        <input type="text"
                               id="searchInput"
                               class="form-control form-control-sm"
                               placeholder="Buscar por nombre, DNI, grado..."
                               style="border:2px solid #bfd9ea; border-radius:8px;
                                      padding:.5rem 1rem .5rem 2.5rem;"
                               autocomplete="off">
                    </div>
                </div>

                {{-- Resumen + exportar --}}
                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-md-end gap-3">

                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-users" style="color:#00508f;"></i>
                            <span class="small">
                                <strong style="color:#00508f;">{{ $estudiantes->total() }}</strong>
                                <span class="text-muted"> Total</span>
                            </span>
                        </div>

                        {{-- CORRECCIÓN: ->where() sobre un paginador no filtra en DB,
                             solo sobre la página actual. Se usa la variable del controlador
                             con fallback seguro. --}}
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-check-circle" style="color:#4ec7d2;"></i>
                            <span class="small">
                                <strong style="color:#4ec7d2;">
                                    {{ $totalActivos ?? $estudiantes->getCollection()->where('estado','activo')->count() }}
                                </strong>
                                <span class="text-muted"> Activos</span>
                            </span>
                        </div>

                        <button class="btn btn-sm"
                                title="Exportar"
                                style="border:2px solid #4ec7d2; color:#4ec7d2; border-radius:8px;">
                            <i class="fas fa-download"></i>
                        </button>

                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ── Tabla ── --}}
    <div class="card border-0 shadow-sm" style="border-radius:10px;">
        <div class="card-body p-0">
            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0" id="studentsTable">
                    <thead style="background:linear-gradient(135deg,#f8fafc 0%,#e2e8f0 100%);">
                        <tr>
                            <th class="px-3 py-2 small text-uppercase fw-semibold" style="color:#64748b;">Foto</th>
                            <th class="px-3 py-2 small text-uppercase fw-semibold" style="color:#64748b;">Nombre</th>
                            <th class="px-3 py-2 small text-uppercase fw-semibold" style="color:#64748b;">DNI</th>
                            <th class="px-3 py-2 small text-uppercase fw-semibold" style="color:#64748b;">Grado</th>
                            <th class="px-3 py-2 small text-uppercase fw-semibold" style="color:#64748b;">Sección</th>
                            <th class="px-3 py-2 small text-uppercase fw-semibold" style="color:#64748b;">Estado</th>
                            <th class="px-3 py-2 small text-uppercase fw-semibold text-end" style="color:#64748b;">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($estudiantes as $estudiante)

                        @php
                            $estadoMap = [
                                'activo'     => ['color' => '#00508f', 'bg' => 'rgba(78,199,210,.2)',  'label' => 'Activo'],
                                'inactivo'   => ['color' => '#991b1b', 'bg' => '#fee2e2',              'label' => 'Inactivo'],
                                'retirado'   => ['color' => '#b45309', 'bg' => '#fef3c7',              'label' => 'Retirado'],
                                'suspendido' => ['color' => '#4b5563', 'bg' => '#e5e7eb',              'label' => 'Suspendido'],
                            ];
                            $est = $estadoMap[$estudiante->estado ?? 'activo'] ?? $estadoMap['activo'];
                        @endphp

                        <tr class="student-row">

                            {{-- FOTO
                                 CORRECCIÓN: el original mostraba asset('storage/') sin
                                 verificar si la foto existe, generando imagen rota.
                                 Ahora muestra avatar con iniciales si no hay foto. --}}
                            <td class="px-3 py-2">
                                @if($estudiante->foto)
                                    <img src="{{ asset('storage/' . $estudiante->foto) }}"
                                         alt="Foto de {{ $estudiante->nombre_completo }}"
                                         class="rounded-circle"
                                         style="width:35px; height:35px; object-fit:cover;
                                                border:2px solid #4ec7d2;">
                                @else
                                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                                         style="width:35px; height:35px;
                                                background:linear-gradient(135deg,#4ec7d2,#00508f);
                                                border:2px solid #4ec7d2; flex-shrink:0;">
                                        <span style="color:white; font-weight:700; font-size:.75rem;">
                                            {{ strtoupper(
                                                substr($estudiante->nombre1   ?? 'E', 0, 1) .
                                                substr($estudiante->apellido1 ?? 'E', 0, 1)
                                            ) }}
                                        </span>
                                    </div>
                                @endif
                            </td>

                            {{-- NOMBRE --}}
                            <td class="px-3 py-2">
                                <div class="fw-semibold" style="color:#003b73; font-size:.9rem;">
                                    {{ $estudiante->nombre_completo }}
                                </div>
                                @if($estudiante->email)
                                    <small class="text-muted" style="font-size:.75rem;">
                                        {{ $estudiante->email }}
                                    </small>
                                @endif
                            </td>

                            {{-- DNI --}}
                            <td class="px-3 py-2">
                                <span class="font-monospace small" style="color:#00508f;">
                                    {{ $estudiante->dni ?? 'N/A' }}
                                </span>
                            </td>

                            {{-- GRADO --}}
                            <td class="px-3 py-2">
                                <span class="badge"
                                      style="background:rgba(78,199,210,.15);
                                             color:#00508f; border:1px solid #4ec7d2;">
                                    {{ $estudiante->grado ?? '—' }}
                                </span>
                            </td>

                            {{-- SECCIÓN --}}
                            <td class="px-3 py-2">
                                @if($estudiante->seccion)
                                    <span class="badge"
                                          style="background:rgba(78,199,210,.15);
                                                 color:#00508f; border:1px solid #4ec7d2;">
                                        {{ $estudiante->seccion }}
                                    </span>
                                @else
                                    <span class="text-muted small">Sin asignar</span>
                                @endif
                            </td>

                            {{-- ESTADO --}}
                            <td class="px-3 py-2">
                                <span class="badge rounded-pill"
                                      style="background:{{ $est['bg'] }};
                                             color:{{ $est['color'] }};
                                             padding:.3rem .7rem;
                                             border:1px solid {{ $est['color'] }};">
                                    <i class="fas fa-circle" style="font-size:.4rem; vertical-align:middle;"></i>
                                    {{ $est['label'] }}
                                </span>
                            </td>

                            {{-- ACCIONES --}}
                            <td class="px-3 py-2 text-end">
                                <div class="btn-group" role="group">

                                    <a href="{{ route('estudiantes.show', $estudiante->id) }}"
                                       class="btn btn-sm"
                                       title="Ver detalles"
                                       style="border:1.5px solid #00508f; color:#00508f;">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('estudiantes.edit', $estudiante->id) }}"
                                       class="btn btn-sm"
                                       title="Editar"
                                       style="border:1.5px solid #4ec7d2; color:#4ec7d2;">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- CORRECCIÓN: las comillas dentro del onclick rompían
                                         el HTML si el nombre tenía apóstrofes. Se usa
                                         data-* attributes con un listener delegado. --}}
                                    <button type="button"
                                            class="btn btn-sm btn-eliminar-estudiante"
                                            title="Eliminar"
                                            style="border:1.5px solid #ef4444; color:#ef4444;"
                                            data-route="{{ route('estudiantes.destroy', $estudiante->id) }}"
                                            data-name="{{ $estudiante->nombre1 ?? '' }} {{ $estudiante->apellido1 ?? '' }}"
                                            data-message="¿Estás seguro de eliminar a este estudiante? Esta acción no se puede deshacer.">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                </div>
                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-user-graduate fa-2x mb-2 d-block"
                                   style="color:#00508f; opacity:.4;"></i>
                                <h6 style="color:#003b73;">No hay estudiantes registrados</h6>
                                <p class="text-muted small mb-3">
                                    Aún no se han registrado estudiantes en el sistema.
                                </p>
                                <a href="{{ route('estudiantes.create') }}"
                                   class="btn btn-sm"
                                   style="background:linear-gradient(135deg,#4ec7d2,#00508f);
                                          color:white; border-radius:8px; font-weight:600;">
                                    <i class="fas fa-plus me-1"></i> Registrar Estudiante
                                </a>
                            </td>
                        </tr>

                        @endforelse
                    </tbody>
                </table>

            </div>{{-- /table-responsive --}}

            {{-- ── Paginación ── --}}
            @if($estudiantes->hasPages())
                <div class="px-3 py-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <small class="text-muted">
                        Mostrando {{ $estudiantes->firstItem() }}–{{ $estudiantes->lastItem() }}
                        de {{ $estudiantes->total() }} estudiantes
                    </small>
                    <div>
                        {{ $estudiantes->links() }}
                    </div>
                </div>
            @endif

        </div>{{-- /card-body --}}
    </div>{{-- /card --}}

</div>{{-- /container --}}
@endsection


@push('styles')
<style>
    /* ── Tabla ── */
    #studentsTable tbody tr { transition: background .15s ease; }
    #studentsTable tbody tr:hover { background: rgba(78,199,210,.04); }

    /* ── Búsqueda: filas ocultas ── */
    .student-row.hidden { display: none; }

    /* ── Paginación Bootstrap override ── */
    .pagination { margin: 0; }
    .page-link { color: #00508f; border-color: #bfd9ea; font-size: .85rem; }
    .page-item.active .page-link {
        background: #00508f;
        border-color: #00508f;
        color: white;
    }
    .page-link:hover { color: #003b73; background: rgba(78,199,210,.1); }
</style>
@endpush


@push('scripts')
<script>
(function () {
    'use strict';

    /* ============================================================
       Búsqueda en tiempo real (filtra las filas visibles)
    ============================================================ */
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const q = this.value.trim().toLowerCase();
            document.querySelectorAll('#studentsTable .student-row').forEach(function (row) {
                const texto = row.textContent.toLowerCase();
                row.classList.toggle('hidden', q !== '' && !texto.includes(q));
            });
        });
    }

    /* ============================================================
       Botones de eliminar — listener delegado
       CORRECCIÓN: el original usaba onclick inline con las variables
       PHP interpoladas directamente en el atributo, lo que rompía
       el HTML si el nombre del estudiante contenía apóstrofes o
       comillas (Ej: "O'Brien"). Ahora se usan data-* attributes.
    ============================================================ */
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-eliminar-estudiante');
        if (!btn) return;
        mostrarModalDelete(
            btn.dataset.route,
            btn.dataset.message,
            btn.dataset.name
        );
    });

})();
</script>
@endpush
