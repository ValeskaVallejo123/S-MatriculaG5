@extends('layouts.app')

@section('title', 'Detalles del Estudiante')
@section('page-title', 'Detalles del Estudiante')

@section('topbar-actions')
    <div class="d-flex gap-2">

        {{-- Volver --}}
        <a href="{{ route('estudiantes.index') }}"
           class="btn btn-sm"
           style="background:white; color:#00508f; padding:.5rem 1rem; border-radius:8px;
                  text-decoration:none; font-weight:600; border:2px solid #00508f;">
            <i class="fas fa-arrow-left me-1"></i>Volver
        </a>

        {{-- Vincular padre/tutor --}}
        <a href="{{ route('padres.buscar', ['estudiante_id' => $estudiante->id]) }}"
           class="btn btn-sm btn-primary"
           style="border-radius:8px; font-weight:600;">
            <i class="fas fa-link me-1"></i> Vincular Padre/Tutor
        </a>

        {{-- Documentos --}}
        @if($estudiante->documentos)
            <a href="{{ route('documentos.show', $estudiante->documentos->id) }}"
               class="btn btn-sm btn-outline-secondary"
               style="border-radius:8px; font-weight:600;">
                <i class="fas fa-file-alt me-1"></i> Ver Documentos
            </a>
        @else
            <a href="{{ route('documentos.create', ['estudiante_id' => $estudiante->id]) }}"
               class="btn btn-sm btn-outline-secondary"
               style="border-radius:8px; font-weight:600;">
                <i class="fas fa-file-upload me-1"></i> Subir Documentos
            </a>
        @endif

    </div>
@endsection

@section('content')
<div class="container" style="max-width:1200px;">

    {{-- ── Credenciales recién generadas ── --}}
    @if(session('credenciales_estudiante'))
        @php $cred = session('credenciales_estudiante'); @endphp
        <div class="alert border-0 mb-3 py-2 px-3"
             style="border-radius:8px; background:rgba(78,199,210,.12); border-left:3px solid #4ec7d2;">
            <div class="d-flex align-items-start">
                <i class="fas fa-key me-2 mt-1" style="color:#00508f;"></i>
                <div>
                    <strong style="color:#00508f;">Credenciales de acceso generadas para el estudiante:</strong>
                    <div class="mt-1" style="font-size:.85rem;">
                        <div><strong>Usuario (correo):</strong> {{ $cred['email']    ?? 'N/A' }}</div>
                        <div><strong>Contraseña temporal:</strong> {{ $cred['password'] ?? 'N/A' }}</div>
                    </div>
                    <small class="text-muted" style="font-size:.75rem;">
                        Recomiende al estudiante cambiar su contraseña en su primer inicio de sesión.
                    </small>
                </div>
            </div>
        </div>
    @endif

    {{-- ── Tarjeta de Perfil ── --}}
    <div class="card border-0 shadow-sm mb-3" style="border-radius:10px; overflow:hidden;">

        {{-- Header con gradiente --}}
        <div style="background:linear-gradient(135deg,#00508f 0%,#003b73 100%); padding:1.5rem;">
            <div class="d-flex align-items-center gap-3">

                {{-- Foto / avatar --}}
                @if($estudiante->foto)
                    <img src="{{ asset('storage/' . $estudiante->foto) }}"
                         alt="Foto de {{ $estudiante->nombre_completo }}"
                         style="width:70px; height:70px; border-radius:12px; object-fit:cover;
                                flex-shrink:0; box-shadow:0 4px 12px rgba(0,0,0,.2);
                                border:3px solid #4ec7d2;">
                @else
                    <div style="width:70px; height:70px; background:white; border-radius:12px;
                                display:flex; align-items:center; justify-content:center;
                                flex-shrink:0; box-shadow:0 4px 12px rgba(0,0,0,.1);
                                border:3px solid #4ec7d2;">
                        <span style="color:#00508f; font-weight:800; font-size:1.8rem;">
                            {{ strtoupper(
                                substr($estudiante->nombre1 ?? 'E', 0, 1) .
                                substr($estudiante->apellido1 ?? 'E', 0, 1)
                            ) }}
                        </span>
                    </div>
                @endif

                {{-- Nombre y grado --}}
                <div class="flex-grow-1">
                    <h2 class="mb-1 fw-bold text-white" style="font-size:1.4rem;">
                        {{ $estudiante->nombre_completo }}
                    </h2>
                    <p class="mb-0 text-white opacity-75" style="font-size:.9rem;">
                        <i class="fas fa-graduation-cap me-1"></i>
                        {{ $estudiante->grado }}
                        @if($estudiante->seccion)
                            - Sección {{ $estudiante->seccion }}
                        @else
                            - Sin sección asignada
                        @endif
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
                    $estado = $estados[$estudiante->estado ?? 'activo'] ?? $estados['activo'];
                @endphp
                <div>
                    <span class="badge"
                          style="background:white; color:{{ $estado['text'] }};
                                 padding:.5rem 1rem; font-size:.85rem; font-weight:700;
                                 border-radius:8px; border:2px solid {{ $estado['border'] }};">
                        <i class="fas fa-circle" style="font-size:.5rem;"></i>
                        {{ $estado['label'] }}
                    </span>
                </div>

            </div>
        </div>
        {{-- FIN header --}}

        {{-- ── Cuerpo de la tarjeta ── --}}
        <div class="card-body p-3">

            {{-- Información Personal --}}
            <div class="mb-3">
                <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center section-heading">
                    <i class="fas fa-user me-2"></i>Información Personal
                </h6>
                <div class="row g-2">
                    <div class="col-md-6">
                        @include('estudiantes._info-item', ['label' => 'Nombres',
                            'value' => trim(($estudiante->nombre1 ?? '') . ' ' . ($estudiante->nombre2 ?? ''))])
                    </div>
                    <div class="col-md-6">
                        @include('estudiantes._info-item', ['label' => 'Apellidos',
                            'value' => trim(($estudiante->apellido1 ?? '') . ' ' . ($estudiante->apellido2 ?? ''))])
                    </div>
                    <div class="col-md-6">
                        @include('estudiantes._info-item', ['label' => 'DNI',
                            'value' => $estudiante->dni ?? 'N/A', 'mono' => true])
                    </div>
                    <div class="col-md-6">
                        @include('estudiantes._info-item', ['label' => 'Fecha de Nacimiento',
                            'value' => $estudiante->fecha_nacimiento
                                ? $estudiante->fecha_nacimiento->format('d/m/Y')
                                : 'N/A'])
                    </div>
                </div>
            </div>

            {{-- Información de Contacto --}}
            <div class="mb-3">
                <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center section-heading">
                    <i class="fas fa-address-book me-2"></i>Información de Contacto
                </h6>
                <div class="row g-2">
                    <div class="col-md-6">
                        @include('estudiantes._info-item', ['label' => 'Email',
                            'value' => $estudiante->email ?? 'N/A'])
                    </div>
                    <div class="col-md-6">
                        @include('estudiantes._info-item', ['label' => 'Teléfono',
                            'value' => $estudiante->telefono ?? 'N/A'])
                    </div>
                    <div class="col-12">
                        @include('estudiantes._info-item', ['label' => 'Dirección',
                            'value' => $estudiante->direccion ?? 'N/A'])
                    </div>
                </div>
            </div>

            {{-- Información Académica --}}
            <div class="mb-3">
                <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center section-heading">
                    <i class="fas fa-graduation-cap me-2"></i>Información Académica
                </h6>
                <div class="row g-2">
                    <div class="col-md-6">
                        @include('estudiantes._info-item', ['label' => 'Grado',
                            'value' => $estudiante->grado ?? 'N/A'])
                    </div>
                    <div class="col-md-6">
                        @include('estudiantes._info-item', ['label' => 'Sección',
                            'value' => $estudiante->seccion ?? 'Sin asignar'])
                    </div>
                </div>
            </div>

            {{-- Observaciones (condicional) --}}
            @if($estudiante->observaciones)
                <div class="mb-3">
                    <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center section-heading">
                        <i class="fas fa-clipboard me-2"></i>Observaciones
                    </h6>
                    <div class="info-box">
                        <p class="mb-0" style="color:#003b73; font-size:.9rem; line-height:1.6;">
                            {{ $estudiante->observaciones }}
                        </p>
                    </div>
                </div>
            @endif

            {{-- Datos del Sistema --}}
            <div class="mb-2">
                <h6 class="mb-2 pb-2 border-bottom d-flex align-items-center section-heading">
                    <i class="fas fa-clock me-2"></i>Datos del Sistema
                </h6>
                <div class="row g-2">
                    <div class="col-md-6">
                        @include('estudiantes._info-item', ['label' => 'Fecha de Registro',
                            'value' => $estudiante->created_at
                                ? $estudiante->created_at->format('d/m/Y H:i')
                                : 'N/A'])
                    </div>
                    <div class="col-md-6">
                        @include('estudiantes._info-item', ['label' => 'Última Actualización',
                            'value' => $estudiante->updated_at
                                ? $estudiante->updated_at->format('d/m/Y H:i')
                                : 'N/A'])
                    </div>
                </div>
            </div>

            {{-- Botones de Acción --}}
            <div class="pt-3 border-top mt-3">
                <div class="d-flex gap-2">
                    <a href="{{ route('estudiantes.edit', $estudiante) }}"
                       class="btn btn-sm flex-fill"
                       style="background:linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);
                              color:white; border:none;
                              box-shadow:0 2px 8px rgba(78,199,210,.3);
                              padding:.6rem; border-radius:8px; font-weight:600;">
                        <i class="fas fa-edit me-1"></i>Editar
                    </a>

                    <button type="button"
                            onclick="abrirModalEliminar()"
                            class="btn btn-sm flex-fill"
                            style="border:2px solid #ef4444; color:#ef4444;
                                   background:white; padding:.6rem;
                                   border-radius:8px; font-weight:600;">
                        <i class="fas fa-trash me-1"></i>Eliminar
                    </button>
                </div>

                {{-- Form oculto para eliminar --}}
                <form id="delete-form"
                      action="{{ route('estudiantes.destroy', $estudiante) }}"
                      method="POST"
                      style="display:none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>

        </div>{{-- /card-body --}}
    </div>{{-- /card --}}

</div>{{-- /container --}}


{{-- ============================================================
     MODAL CONFIRMAR ELIMINACIÓN
     CORRECCIÓN: el modal original tenía el párrafo del mensaje
     duplicado y el @section('content') cerrado dos veces (@endsection
     al final era el segundo cierre). Se limpió todo.
============================================================ --}}
<div id="deleteModal" class="modal fade" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:12px; border:none; overflow:hidden;">

            {{-- Header --}}
            <div class="modal-header border-0" style="background:rgba(239,68,68,.08); padding:1.2rem;">
                <div class="d-flex align-items-center gap-2">
                    <div style="width:40px; height:40px; background:rgba(239,68,68,.15);
                                border-radius:10px; display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-exclamation-triangle" style="color:#ef4444; font-size:1.1rem;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title mb-0 fw-bold" id="deleteModalLabel"
                            style="color:#003b73; font-size:.95rem;">Confirmar Eliminación</h5>
                        <p class="mb-0 small text-muted">Esta acción no se puede deshacer</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body" style="padding:1.5rem;">
                <p class="mb-2" style="color:#003b73; font-size:.95rem;">
                    ¿Está seguro que desea eliminar al estudiante
                    <strong>{{ $estudiante->nombre_completo }}</strong>?
                </p>
                <p class="text-muted small mb-0">
                    Se perderán todos los datos asociados a este estudiante de forma permanente.
                </p>
            </div>

            {{-- Footer --}}
            <div class="modal-footer border-0" style="background:#f8f9fa; padding:1rem 1.5rem;">
                <button type="button"
                        class="btn btn-sm"
                        data-bs-dismiss="modal"
                        style="border:2px solid #00508f; color:#00508f; background:white;
                               padding:.5rem 1.2rem; border-radius:8px; font-weight:600;">
                    Cancelar
                </button>
                <button type="button"
                        onclick="document.getElementById('delete-form').submit()"
                        class="btn btn-sm"
                        style="background:#ef4444; color:white; border:none;
                               padding:.5rem 1.2rem; border-radius:8px; font-weight:600;
                               box-shadow:0 2px 8px rgba(239,68,68,.3);">
                    <i class="fas fa-trash me-1"></i>Sí, Eliminar
                </button>
            </div>

        </div>
    </div>
</div>

@endsection


@push('styles')
<style>
    /* ── Secciones de información ── */
    .section-heading {
        color: #00508f;
        font-weight: 600;
        font-size: .95rem;
    }
    .info-box {
        background: rgba(78,199,210,.08);
        border-radius: 8px;
        border-left: 3px solid #4ec7d2;
        padding: .5rem .75rem;
    }
    .info-box .info-label {
        font-size: .7rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: .15rem;
    }
    .info-box .info-value {
        color: #003b73;
        font-size: .9rem;
        font-weight: 600;
        margin: 0;
        word-break: break-word;
    }
    .info-box .info-value.font-monospace { font-family: monospace; }

    /* ── Bordes y botones ── */
    .border-bottom { border-color: rgba(0,80,143,.15) !important; }

    .btn:hover { transform: translateY(-2px); transition: all .3s ease; }

    /* ── Formulario (si se usa en esta vista) ── */
    .form-control-sm, .form-select-sm {
        border-radius: 6px;
        border: 1.5px solid #e2e8f0;
        padding: .5rem .75rem;
        transition: all .3s ease;
        font-size: .875rem;
    }
    .form-control-sm:focus, .form-select-sm:focus {
        border-color: #4ec7d2;
        box-shadow: 0 0 0 .15rem rgba(78,199,210,.15);
    }
</style>
@endpush


@push('scripts')
<script>
(function () {
    'use strict';

    /* ============================================================
       Abrir modal de eliminación con Bootstrap 5
       CORRECCIÓN: el original llamaba a confirmDelete() y submitDelete()
       como funciones globales sin usar la API de Bootstrap. Ahora se
       usa bootstrap.Modal correctamente.
    ============================================================ */
    window.abrirModalEliminar = function () {
        const modalEl = document.getElementById('deleteModal');
        if (modalEl) bootstrap.Modal.getOrCreate(modalEl).show();
    };

    /* ============================================================
       Generador de correo automático
       CORRECCIÓN: el original estaba dentro de @push('scripts') pero
       DESPUÉS de @endsection, lo que hace que Blade ignore el bloque
       completo. Ahora está correctamente antes del @endsection.

       Además los selectores getElementById fallaban porque esta es
       la vista SHOW (solo lectura), no la vista EDIT. Se agregan
       guards para evitar errores en consola.
    ============================================================ */
    document.addEventListener('DOMContentLoaded', function () {
        const nombre1Input   = document.getElementById('nombre1');
        const apellido1Input = document.getElementById('apellido1');
        const emailInput     = document.getElementById('email');

        // Solo ejecutar si los campos existen (vista edit)
        if (!nombre1Input || !apellido1Input || !emailInput) return;

        function normalizar(txt) {
            return (txt || '')
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')  // quita tildes
                .replace(/[^a-zA-Z]/g, '')        // solo letras
                .toLowerCase();
        }

        function generarCorreo() {
            const nombre   = normalizar(nombre1Input.value);
            const apellido = normalizar(apellido1Input.value);
            emailInput.value = (nombre && apellido)
                ? `${nombre}.${apellido}@egm.edu.hn`
                : '';
        }

        nombre1Input.addEventListener('input', generarCorreo);
        apellido1Input.addEventListener('input', generarCorreo);
    });

})();
</script>
@endpush
