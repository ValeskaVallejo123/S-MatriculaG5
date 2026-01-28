@extends('layouts.app')

@section('title', 'Estudiantes')

@section('page-title', 'Gestión de Estudiantes')

@section('content')
<div class="container" style="max-width: 1400px;">

    <!-- Barra de búsqueda -->
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
        <div class="card-body p-3">
            <div class="row align-items-center g-2">

                <!-- Buscador -->
                <div class="col-md-6">
                    <div class="position-relative">
                        <i class="fas fa-search position-absolute"
                           style="left: 12px; top: 50%; transform: translateY(-50%);
                                  color: #00508f; font-size: 0.9rem;"></i>

                        <input type="text" id="searchInput"
                               class="form-control form-control-sm ps-5"
                               placeholder="Buscar por nombre, DNI, grado..."
                               style="border: 2px solid #bfd9ea; border-radius: 8px;
                                      padding: 0.5rem 1rem 0.5rem 2.5rem;">
                    </div>
                </div>

                <!-- Resumen -->
                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-md-end gap-3">

                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-users" style="color: #00508f;"></i>
                            <span class="small">
                                <strong style="color: #00508f;">{{ $estudiantes->total() }}</strong>
                                <span class="text-muted">Total</span>
                            </span>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-check-circle" style="color: #4ec7d2;"></i>
                            <span class="small">
                                <strong style="color: #4ec7d2;">
                                    {{ $estudiantes->where('estado', 'activo')->count() }}
                                </strong>
                                <span class="text-muted">Activos</span>
                            </span>
                        </div>

                        <button class="btn btn-sm"
                                style="border: 2px solid #4ec7d2; color: #4ec7d2;">
                            <i class="fas fa-download"></i>
                        </button>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Tabla -->
    <div class="card border-0 shadow-sm" style="border-radius: 10px;">
        <div class="card-body p-0">
            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0" id="studentsTable">
                    <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
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

                        <tr class="student-row">

                            <!-- FOTO -->
                            <td class="px-3 py-2">
                                <img src="{{ asset('storage/' . $estudiante->foto) }}"
                                     class="rounded-circle object-fit-cover"
                                     style="width: 35px; height: 35px; border: 2px solid #4ec7d2;">
                            </td>

                            <!-- NOMBRE -->
                            <td class="px-3 py-2">
                                <div class="fw-semibold" style="color: #003b73; font-size: 0.9rem;">
                                    {{ $estudiante->nombre_completo }}
                                </div>

                                @if($estudiante->email)
                                    <small class="text-muted" style="font-size: 0.75rem;">
                                        {{ $estudiante->email }}
                                    </small>
                                @endif
                            </td>

                            <!-- DNI -->
                            <td class="px-3 py-2">
                                <span class="font-monospace small" style="color: #00508f;">
                                    {{ $estudiante->dni }}
                                </span>
                            </td>

                            <!-- GRADO -->
                            <td class="px-3 py-2">
                                <span class="badge"
                                      style="background: rgba(78,199,210,0.15);
                                             color: #00508f;
                                             border: 1px solid #4ec7d2;">
                                    {{ $estudiante->grado }}
                                </span>
                            </td>

                            <!-- SECCIÓN -->
                            <td class="px-3 py-2">
                                <span class="badge"
                                      style="background: rgba(78,199,210,0.15);
                                             color: #00508f;
                                             border: 1px solid #4ec7d2;">
                                    {{ $estudiante->seccion }}
                                </span>
                            </td>

                            <!-- ESTADO -->
                            <td class="px-3 py-2">

                                @php
                                    $estados = [
                                        'activo' => ['color' => '#00508f', 'bg' => 'rgba(78,199,210,0.2)', 'label' => 'Activo'],
                                        'inactivo' => ['color' => '#991b1b', 'bg' => '#fee2e2', 'label' => 'Inactivo'],
                                        'retirado' => ['color' => '#b45309', 'bg' => '#fef3c7', 'label' => 'Retirado'],
                                        'suspendido' => ['color' => '#4b5563', 'bg' => '#e5e7eb', 'label' => 'Suspendido'],
                                    ];
                                @endphp

                                <span class="badge rounded-pill"
                                      style="
                                          background: {{ $estados[$estudiante->estado]['bg'] }};
                                          color: {{ $estados[$estudiante->estado]['color'] }};
                                          padding: 0.3rem 0.7rem;
                                          border: 1px solid {{ $estados[$estudiante->estado]['color'] }};
                                      ">
                                    <i class="fas fa-circle" style="font-size: 0.4rem;"></i>
                                    {{ $estados[$estudiante->estado]['label'] }}
                                </span>

                            </td>

                            <!-- ACCIONES -->
                            <td class="px-3 py-2 text-end">
                                <div class="btn-group">

                                    <a href="{{ route('estudiantes.show', $estudiante->id) }}"
                                       class="btn btn-sm"
                                       style="border: 1.5px solid #00508f; color: #00508f;">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('estudiantes.edit', $estudiante->id) }}"
                                       class="btn btn-sm"
                                       style="border: 1.5px solid #4ec7d2; color: #4ec7d2;">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <button type="button"
                                            class="btn btn-sm"
                                            style="border: 1.5px solid #ef4444; color: #ef4444;"
                                            onclick="mostrarModalDelete('{{ route('estudiantes.destroy', $estudiante->id) }}',
                                            '¿Estás seguro de eliminar este estudiante?',
                                            '{{ $estudiante->nombre1 }} {{ $estudiante->apellido1 }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                </div>
                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-inbox fa-2x mb-2" style="color: #00508f; opacity: 0.5;"></i>
                                <h6 style="color: #003b73;">No hay estudiantes registrados</h6>

                                <a href="{{ route('estudiantes.create') }}"
                                   class="btn btn-sm"
                                   style="background: linear-gradient(135deg,#4ec7d2,#00508f); color:white;">
                                    <i class="fas fa-plus"></i>
                                    Registrar Estudiante
                                </a>
                                
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
