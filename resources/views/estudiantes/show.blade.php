@extends('layouts.app')

@section('title', 'Detalles del Estudiante')
@section('page-title', 'Detalles del Estudiante')

@section('topbar-actions')
<div class="d-flex gap-2">

    {{-- Volver a la lista --}}
    <a href="{{ route('estudiantes.index') }}"
       class="btn btn-sm"
       style="background:white; color:#00508f; padding:0.5rem 1rem; border-radius:8px;
              font-weight:600; border:2px solid #00508f; text-decoration:none;">
        <i class="fas fa-arrow-left me-1"></i>Volver
    </a>

    {{-- Vincular padre/tutor --}}
    <a href="{{ route('padres.buscar', ['estudiante_id' => $estudiante->id]) }}"
       class="btn btn-sm btn-primary"
       style="border-radius:8px; font-weight:600;">
        <i class="fas fa-link me-1"></i>Vincular Padre/Tutor
    </a>

    {{-- Documentos del estudiante --}}
    @if($estudiante->documentos)
        <a href="{{ route('documentos.show', $estudiante->documentos->id) }}"
           class="btn btn-sm btn-outline-secondary"
           style="border-radius:8px; font-weight:600;">
            <i class="fas fa-file-alt me-1"></i>Ver Documentos
        </a>
    @else
        <a href="{{ route('documentos.create', ['estudiante_id' => $estudiante->id]) }}"
           class="btn btn-sm btn-outline-secondary"
           style="border-radius:8px; font-weight:600;">
            <i class="fas fa-file-upload me-1"></i>Subir Documentos
        </a>
    @endif

</div>
@endsection

@section('content')
<div class="container" style="max-width:1200px;">

    {{-- Credenciales recién generadas --}}
    @if(session('credenciales_estudiante'))
        @php $cred = session('credenciales_estudiante'); @endphp
        <div class="alert border-0 mb-3 py-2 px-3"
             style="border-radius:8px; background:rgba(78,199,210,0.12);
                    border-left:3px solid #4ec7d2 !important;">
            <div class="d-flex align-items-start">
                <i class="fas fa-key me-2 mt-1" style="color:#00508f;"></i>
                <div>
                    <strong style="color:#00508f;">Credenciales de acceso generadas para el estudiante:</strong>
                    <div class="mt-1" style="font-size:0.85rem;">
                        <div><strong>Usuario (correo):</strong> {{ $cred['email']    ?? 'N/A' }}</div>
                        <div><strong>Contraseña temporal:</strong> {{ $cred['password'] ?? 'N/A' }}</div>
                    </div>
                    <small class="text-muted" style="font-size:0.75rem;">
                        Recomiende al estudiante cambiar su contraseña en su primer inicio de sesión.
                    </small>
                </div>
            </div>
        </div>
    @endif

    {{-- ── Tarjeta de Perfil ────────────────────────────────────────────── --}}
    <div class="card border-0 shadow-sm mb-3" style="border-radius:10px; overflow:hidden;">

        {{-- Header con gradiente --}}
        <div style="background:linear-gradient(135deg,#00508f 0%,#003b73 100%); padding:1.5rem;">
            <div class="d-flex align-items-center gap-3">

                {{-- Foto o avatar --}}
                @if($estudiante->foto)
                    <img src="{{ asset('storage/' . $estudiante->foto) }}"
                         alt="Foto de {{ $estudiante->nombre_completo }}"
                         style="width:70px; height:70px; border-radius:12px; object-fit:cover;
                                flex-shrink:0; box-shadow:0 4px 12px rgba(0,0,0,0.2);
                                border:3px solid #4ec7d2;">
                @else
                    <div style="width:70px; height:70px; background:white; border-radius:12px;
                                display:flex; align-items:center; justify-content:center;
                                flex-shrink:0; box-shadow:0 4px 12px rgba(0,0,0,0.1);
                                border:3px solid #4ec7d2;">
                        <span style="color:#00508f; font-weight:800; font-size:1.8rem;">
                            {{ strtoupper(substr($estudiante->nombre1, 0, 1) . substr($estudiante->apellido1 ?? 'E', 0, 1)) }}
                        </span>
                    </div>
                @endif

                {{-- Nombre y grado --}}
                <div class="flex-grow-1">
                    <h2 class="mb-1 fw-bold text-white" style="font-size:1.4rem;">
                        {{ $estudiante->nombre_completo }}
                    </h2>
                    <p class="mb-0 text-white opacity-75" style="font-size:0.9rem;">
                        <i class="fas fa-graduation-cap me-1"></i>
                        {{ $estudiante->grado }} — Sección {{ $estudiante->seccion }}
                    </p>
                </div>

                {{-- Badge de estado --}}
                @php
                    $estados = [
                        'activo'     => ['label' => 'Activo',     'border' => '#4ec7d2', 'text' => '#00508f'],
                        'inactivo'   => ['label' => 'Inactivo',   'border' => '#ef4444', 'text' => '#ef4444'],
                        'retirado'   => ['label' => 'Retirado',   'border' => '#b45309', 'text' => '#b45309'],
                        'suspendido' => ['label' => 'Suspendido', 'border' => '#4b5563', 'text' => '#4b5563'],
                    ];
                    $estado = $estados[$estudiante->estado] ?? ['label' => ucfirst($estudiante->estado), 'border' => '#6b7280', 'text' => '#6b7280'];
                @endphp
                <span class="badge"
                      style="background:white; color:{{ $estado['text'] }};
                             padding:0.5rem 1rem; font-size:0.85rem; font-weight:700;
                             border-radius:8px; border:2px solid {{ $estado['border'] }};">
                    <i class="fas fa-circle me-1" style="font-size:0.5rem;"></i>{{ $estado['label'] }}
                </span>

            </div>
        </div>

        {{-- Cuerpo de la tarjeta --}}
        <div class="card-body p-3">

            {{-- Información Personal --}}
            <div class="mb-3">
                <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center"
                    style="color:#00508f; font-weight:600; font-size:0.95rem;">
                    <i class="fas fa-user me-2" style="font-size:0.9rem;"></i>Información Personal
                </h6>
                <div class="row g-2">

                    <div class="col-md-6">
                        <div class="p-2" style="background:rgba(78,199,210,0.08); border-radius:8px; border-left:3px solid #4ec7d2;">
                            <p class="text-muted mb-0" style="font-size:0.7rem; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Nombres</p>
                            <p class="mb-0 fw-semibold" style="color:#003b73; font-size:0.9rem;">
                                {{ $estudiante->nombre1 }} {{ $estudiante->nombre2 }}
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-2" style="background:rgba(78,199,210,0.08); border-radius:8px; border-left:3px solid #4ec7d2;">
                            <p class="text-muted mb-0" style="font-size:0.7rem; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Apellidos</p>
                            <p class="mb-0 fw-semibold" style="color:#003b73; font-size:0.9rem;">
                                {{ $estudiante->apellido1 }} {{ $estudiante->apellido2 }}
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-2" style="background:rgba(78,199,210,0.08); border-radius:8px; border-left:3px solid #4ec7d2;">
                            <p class="text-muted mb-0" style="font-size:0.7rem; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">DNI</p>
                            <p class="mb-0 fw-semibold font-monospace" style="color:#003b73; font-size:0.9rem;">
                                {{ $estudiante->dni ?? 'N/A' }}
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-2" style="background:rgba(78,199,210,0.08); border-radius:8px; border-left:3px solid #4ec7d2;">
                            <p class="text-muted mb-0" style="font-size:0.7rem; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Fecha de Nacimiento</p>
                            <p class="mb-0 fw-semibold" style="color:#003b73; font-size:0.9rem;">
                                {{ $estudiante->fecha_nacimiento?->format('d/m/Y') ?? 'N/A' }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Información de Contacto --}}
            <div class="mb-3">
                <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center"
                    style="color:#00508f; font-weight:600; font-size:0.95rem;">
                    <i class="fas fa-address-book me-2" style="font-size:0.9rem;"></i>Información de Contacto
                </h6>
                <div class="row g-2">

                    <div class="col-md-6">
                        <div class="p-2" style="background:rgba(78,199,210,0.08); border-radius:8px; border-left:3px solid #4ec7d2;">
                            <p class="text-muted mb-0" style="font-size:0.7rem; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Email</p>
                            <p class="mb-0 fw-semibold text-break" style="color:#003b73; font-size:0.85rem;">
                                {{ $estudiante->email ?? 'N/A' }}
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-2" style="background:rgba(78,199,210,0.08); border-radius:8px; border-left:3px solid #4ec7d2;">
                            <p class="text-muted mb-0" style="font-size:0.7rem; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Teléfono</p>
                            <p class="mb-0 fw-semibold" style="color:#003b73; font-size:0.9rem;">
                                {{ $estudiante->telefono ?? 'N/A' }}
                            </p>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="p-2" style="background:rgba(78,199,210,0.08); border-radius:8px; border-left:3px solid #4ec7d2;">
                            <p class="text-muted mb-0" style="font-size:0.7rem; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Dirección</p>
                            <p class="mb-0 fw-semibold" style="color:#003b73; font-size:0.9rem;">
                                {{ $estudiante->direccion ?? 'N/A' }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Información Académica --}}
            <div class="mb-3">
                <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center"
                    style="color:#00508f; font-weight:600; font-size:0.95rem;">
                    <i class="fas fa-graduation-cap me-2" style="font-size:0.9rem;"></i>Información Académica
                </h6>
                <div class="row g-2">

                    <div class="col-md-6">
                        <div class="p-2" style="background:rgba(78,199,210,0.08); border-radius:8px; border-left:3px solid #4ec7d2;">
                            <p class="text-muted mb-0" style="font-size:0.7rem; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Grado</p>
                            <p class="mb-0 fw-semibold" style="color:#003b73; font-size:0.9rem;">
                                {{ $estudiante->grado }}
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-2" style="background:rgba(78,199,210,0.08); border-radius:8px; border-left:3px solid #4ec7d2;">
                            <p class="text-muted mb-0" style="font-size:0.7rem; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Sección</p>
                            <p class="mb-0 fw-semibold" style="color:#003b73; font-size:0.9rem;">
                                {{ $estudiante->seccion }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Observaciones --}}
            @if($estudiante->observaciones)
            <div class="mb-3">
                <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center"
                    style="color:#00508f; font-weight:600; font-size:0.95rem;">
                    <i class="fas fa-clipboard me-2" style="font-size:0.9rem;"></i>Observaciones
                </h6>
                <div class="p-2" style="background:rgba(78,199,210,0.08); border-radius:8px; border-left:3px solid #4ec7d2;">
                    <p class="mb-0" style="color:#003b73; font-size:0.9rem; line-height:1.6;">
                        {{ $estudiante->observaciones }}
                    </p>
                </div>
            </div>
            @endif

            {{-- Datos del Sistema --}}
            <div class="mb-2">
                <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center"
                    style="color:#00508f; font-weight:600; font-size:0.95rem;">
                    <i class="fas fa-clock me-2" style="font-size:0.9rem;"></i>Datos del Sistema
                </h6>
                <div class="row g-2">

                    <div class="col-md-6">
                        <div class="p-2" style="background:rgba(78,199,210,0.08); border-radius:8px; border-left:3px solid #4ec7d2;">
                            <p class="text-muted mb-0" style="font-size:0.7rem; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Fecha de Registro</p>
                            <p class="mb-0 fw-semibold" style="color:#003b73; font-size:0.9rem;">
                                {{ $estudiante->created_at?->format('d/m/Y H:i') ?? 'N/A' }}
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-2" style="background:rgba(78,199,210,0.08); border-radius:8px; border-left:3px solid #4ec7d2;">
                            <p class="text-muted mb-0" style="font-size:0.7rem; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Última Actualización</p>
                            <p class="mb-0 fw-semibold" style="color:#003b73; font-size:0.9rem;">
                                {{ $estudiante->updated_at?->format('d/m/Y H:i') ?? 'N/A' }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Botones de acción --}}
            <div class="pt-3 border-top mt-3">
                <div class="d-flex gap-2">

                    <a href="{{ route('estudiantes.edit', $estudiante) }}"
                       class="btn btn-sm flex-fill"
                       style="background:linear-gradient(135deg,#4ec7d2,#00508f); color:white;
                              border:none; padding:0.6rem; border-radius:8px; font-weight:600;
                              box-shadow:0 2px 8px rgba(78,199,210,0.3);">
                        <i class="fas fa-edit me-1"></i>Editar
                    </a>

                    <button type="button"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteModal"
                            class="btn btn-sm flex-fill"
                            style="border:2px solid #ef4444; color:#ef4444; background:white;
                                   padding:0.6rem; border-radius:8px; font-weight:600;">
                        <i class="fas fa-trash me-1"></i>Eliminar
                    </button>

                    {{-- Form oculto para eliminar --}}
                    <form id="delete-form"
                          action="{{ route('estudiantes.destroy', $estudiante) }}"
                          method="POST"
                          class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>

                </div>
            </div>

        </div>{{-- /card-body --}}
    </div>{{-- /card --}}

</div>{{-- /container --}}

{{-- ── Modal de confirmación de eliminación ─────────────────────────────── --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius:12px; overflow:hidden;">

            <div class="modal-header border-0" style="background:rgba(239,68,68,0.1); padding:1.2rem;">
                <div class="d-flex align-items-center gap-2">
                    <div style="width:40px; height:40px; background:rgba(239,68,68,0.2); border-radius:10px;
                                display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-exclamation-triangle" style="color:#ef4444; font-size:1.2rem;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title mb-0 fw-bold" style="color:#003b73;">Confirmar Eliminación</h5>
                        <p class="mb-0 small text-muted">Esta acción no se puede deshacer</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" style="padding:1.5rem;">
                <p class="mb-2" style="color:#003b73; font-size:0.95rem;">
                    ¿Está seguro que desea eliminar al estudiante
                    <strong>{{ $estudiante->nombre_completo }}</strong>?
                </p>
                <p class="text-muted small mb-0">
                    Se perderán todos los datos asociados a este estudiante de forma permanente.
                </p>
            </div>

            <div class="modal-footer border-0" style="background:#f8f9fa; padding:1rem 1.5rem;">
                <button type="button"
                        class="btn btn-sm"
                        data-bs-dismiss="modal"
                        style="border:2px solid #00508f; color:#00508f; background:white;
                               padding:0.5rem 1.2rem; border-radius:8px; font-weight:600;">
                    Cancelar
                </button>
                <button type="button"
                        onclick="document.getElementById('delete-form').submit()"
                        class="btn btn-sm"
                        style="background:#ef4444; color:white; border:none;
                               padding:0.5rem 1.2rem; border-radius:8px; font-weight:600;
                               box-shadow:0 2px 8px rgba(239,68,68,0.3);">
                    <i class="fas fa-trash me-1"></i>Sí, Eliminar
                </button>
            </div>

        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .border-bottom {
        border-color: rgba(0,80,143,0.15) !important;
    }
    .btn:hover {
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }
    .btn-back:hover {
        background: #00508f !important;
        color: white !important;
    }
</style>
@endpush
