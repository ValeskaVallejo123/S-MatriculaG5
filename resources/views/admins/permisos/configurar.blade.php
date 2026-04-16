@extends('layouts.app')

@section('title', 'Configurar Permisos')
@section('page-title', 'Configurar Permisos')


@push('styles')
<style>
    .form-check-input:checked { background-color:#003b73; border-color:#003b73; }
    .form-check-input:focus   { border-color:#4ec7d2; box-shadow:0 0 0 0.25rem rgba(78,199,210,0.25); }

    .perm-switch {
        transition: all 0.2s ease;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        background: #fafbfc;
    }
    .perm-switch:hover {
        border-color: #4ec7d2 !important;
        box-shadow: 0 2px 8px rgba(78,199,210,0.15);
        background: rgba(78,199,210,0.04);
    }

    .section-divider {
        font-size: 0.72rem; font-weight: 700; letter-spacing: 0.08em;
        text-transform: uppercase; color: #00508f;
        border-bottom: 2px solid #e8f8f9;
        padding-bottom: 0.5rem; margin-bottom: 1rem; margin-top: .25rem;
        display: flex; align-items: center; gap: .4rem;
    }

    .hijo-tab {
        padding: .55rem 1.1rem; border-radius: 8px; font-size: .82rem;
        font-weight: 600; border: 1.5px solid #e2e8f0; background: #f8fafc;
        color: #64748b; cursor: pointer; transition: all .15s; white-space: nowrap;
        text-decoration: none; display: inline-flex; align-items: center; gap: .4rem;
    }
    .hijo-tab.active, .hijo-tab:hover {
        background: linear-gradient(135deg,#4ec7d2,#00508f);
        color: #fff; border-color: #4ec7d2;
    }

    .btn-accion {
        padding: .32rem .85rem; border-radius: 7px; font-size: .75rem;
        font-weight: 600; cursor: pointer; transition: all .15s;
        display: inline-flex; align-items: center; gap: .35rem; border: 1.5px solid;
    }
    .btn-activar   { background:#f0fdf4; color:#059669; border-color:#86efac; }
    .btn-activar:hover   { background:#059669; color:#fff; }
    .btn-desactivar{ background:#fef2f2; color:#dc2626; border-color:#fca5a5; }
    .btn-desactivar:hover{ background:#dc2626; color:#fff; }
    .btn-defecto   { background:#f8fafc; color:#475569; border-color:#e2e8f0; }
    .btn-defecto:hover   { background:#475569; color:#fff; }

    .btn-guardar {
        width:100%; padding:.7rem; border-radius:9px; border:none;
        background:linear-gradient(135deg,#4ec7d2,#00508f);
        color:#fff; font-size:.9rem; font-weight:700; cursor:pointer;
        box-shadow:0 3px 10px rgba(78,199,210,.3); transition:opacity .15s, transform .15s;
    }
    .btn-guardar:hover { opacity:.9; transform:translateY(-1px); }
</style>
@endpush

@section('content')
<div class="container-fluid" style="max-width:100%;">

    {{-- ══ Hero del Padre ══════════════════════════════════════ --}}
    <div class="card border-0 shadow-sm mb-3" style="border-radius:12px;overflow:hidden;">
        <div style="background:linear-gradient(135deg,#003b73,#00508f);padding:1.25rem 1.75rem;display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
            <div style="display:flex;align-items:center;gap:1.1rem;">
                <div style="width:56px;height:56px;background:rgba(255,255,255,.1);border:2px solid #4ec7d2;border-radius:14px;display:flex;align-items:center;justify-content:center;font-weight:800;color:#4ec7d2;font-size:1.3rem;flex-shrink:0;">
                    {{ strtoupper(substr($padre->nombre,0,1)) }}
                </div>
                <div>
                    <div style="font-weight:700;color:#fff;font-size:1.1rem;margin-bottom:.25rem;">
                        {{ $padre->nombre }} {{ $padre->apellido }}
                    </div>
                    <div style="font-size:.78rem;color:rgba(255,255,255,.6);display:flex;gap:1.25rem;flex-wrap:wrap;">
                        <span><i class="fas fa-id-card me-1"></i>{{ $padre->dni ?? '—' }}</span>
                        <span><i class="fas fa-users me-1"></i>{{ $padre->parentesco_formateado }}</span>
                        @if($padre->correo)
                            <span><i class="fas fa-envelope me-1"></i>{{ $padre->correo }}</span>
                        @endif
                        @if($padre->telefono)
                            <span><i class="fas fa-phone me-1"></i>{{ $padre->telefono }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div style="font-size:.78rem;color:rgba(255,255,255,.5);">
                <i class="fas fa-child me-1"></i>
                {{ $padre->estudiantes->count() }} {{ $padre->estudiantes->count() === 1 ? 'hijo vinculado' : 'hijos vinculados' }}
            </div>
        </div>
    </div>

    {{-- Sin hijos ────────────────────────────────────────────── --}}
    @if($padre->estudiantes->count() === 0)
    <div class="card border-0 shadow-sm" style="border-radius:10px;">
        <div class="card-body text-center py-5">
            <i class="fas fa-user-graduate fa-2x mb-3" style="color:#cbd5e1;"></i>
            <h6 style="color:#003b73;">Sin estudiantes vinculados</h6>
            <p class="text-muted small mb-0">Este padre/tutor no tiene hijos registrados.</p>
        </div>
    </div>
    @endif

    {{-- ══ Un bloque por hijo ══════════════════════════════════ --}}
    @foreach($padre->estudiantes as $estudiante)
    @php $pe = $permisosExistentes[$estudiante->id] ?? null; @endphp

    <div class="card border-0 shadow-sm mb-3" style="border-radius:12px;overflow:hidden;">

        {{-- Cabecera del hijo --}}
        <div style="background:rgba(0,80,143,0.05);border-bottom:2px solid #4ec7d2;padding:1rem 1.5rem;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.75rem;">
            <div style="display:flex;align-items:center;gap:.85rem;">
                <div style="width:42px;height:42px;background:linear-gradient(135deg,#4ec7d2,#00508f);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.9rem;flex-shrink:0;">
                    {{ strtoupper(substr($estudiante->nombre1,0,1).substr($estudiante->apellido1,0,1)) }}
                </div>
                <div>
                    <div style="font-weight:700;color:#003b73;font-size:.95rem;">
                        {{ $estudiante->nombre1 }} {{ $estudiante->nombre2 }}
                        {{ $estudiante->apellido1 }} {{ $estudiante->apellido2 }}
                    </div>
                    <div style="font-size:.75rem;color:#64748b;">
                        <i class="fas fa-graduation-cap me-1"></i>
                        {{ $estudiante->grado }} — Sección {{ $estudiante->seccion }}
                        @if($pe)
                            &nbsp;·&nbsp;
                            <span style="color:#059669;font-weight:600;">
                                <i class="fas fa-key me-1"></i>Permisos configurados
                            </span>
                        @else
                            &nbsp;·&nbsp;
                            <span style="color:#f59e0b;font-weight:600;">
                                <i class="fas fa-exclamation-circle me-1"></i>Sin configurar
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
                <button type="button" class="btn-accion btn-activar"
                        onclick="activarTodos({{ $estudiante->id }})">
                    <i class="fas fa-check-double"></i> Activar todos
                </button>
                <button type="button" class="btn-accion btn-desactivar"
                        onclick="desactivarTodos({{ $estudiante->id }})">
                    <i class="fas fa-times"></i> Desactivar todos
                </button>
                <button type="button" class="btn-accion btn-defecto"
                        onclick="establecerDefecto({{ $padre->id }}, {{ $estudiante->id }})">
                    <i class="fas fa-undo"></i> Por defecto
                </button>
            </div>
        </div>

        {{-- Formulario ──────────────────────────────────────── --}}
        <div class="card-body p-4">
            <form action="{{ route('admins.permisos.guardar', $padre->id) }}"
                  method="POST" id="form-{{ $estudiante->id }}">
                @csrf
                <input type="hidden" name="estudiante_id" value="{{ $estudiante->id }}">

                <div class="row g-0">

                    {{-- Columna izquierda ── Visualización + Notificaciones --}}
                    <div class="col-lg-4 pe-lg-4" style="border-right:1.5px solid #f1f5f9;">

                        <p class="section-divider">
                            <i class="fas fa-eye" style="color:#4ec7d2;"></i> Visualización
                        </p>

                        <div class="d-flex flex-column gap-2 mb-4">
                            <div class="form-check form-switch p-3 perm-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                       name="ver_calificaciones" id="vcal_{{ $estudiante->id }}"
                                       {{ $pe?->ver_calificaciones ? 'checked' : '' }}>
                                <label class="form-check-label" for="vcal_{{ $estudiante->id }}">
                                    <i class="fas fa-star text-warning me-1"></i>
                                    <strong>Ver Calificaciones</strong>
                                    <small class="d-block text-muted">Notas y promedios del estudiante</small>
                                </label>
                            </div>
                            <div class="form-check form-switch p-3 perm-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                       name="ver_asistencias" id="vasi_{{ $estudiante->id }}"
                                       {{ $pe?->ver_asistencias ? 'checked' : '' }}>
                                <label class="form-check-label" for="vasi_{{ $estudiante->id }}">
                                    <i class="fas fa-calendar-check text-success me-1"></i>
                                    <strong>Ver Asistencias</strong>
                                    <small class="d-block text-muted">Registro de asistencia y faltas</small>
                                </label>
                            </div>
                            <div class="form-check form-switch p-3 perm-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                       name="ver_comportamiento" id="vcom_{{ $estudiante->id }}"
                                       {{ $pe?->ver_comportamiento ? 'checked' : '' }}>
                                <label class="form-check-label" for="vcom_{{ $estudiante->id }}">
                                    <i class="fas fa-smile text-info me-1"></i>
                                    <strong>Ver Comportamiento</strong>
                                    <small class="d-block text-muted">Reportes de conducta</small>
                                </label>
                            </div>
                            <div class="form-check form-switch p-3 perm-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                       name="ver_tareas" id="vtar_{{ $estudiante->id }}"
                                       {{ $pe?->ver_tareas ? 'checked' : '' }}>
                                <label class="form-check-label" for="vtar_{{ $estudiante->id }}">
                                    <i class="fas fa-tasks text-primary me-1"></i>
                                    <strong>Ver Tareas</strong>
                                    <small class="d-block text-muted">Lista de tareas asignadas</small>
                                </label>
                            </div>
                        </div>

                        <p class="section-divider">
                            <i class="fas fa-bell" style="color:#4ec7d2;"></i> Notificaciones
                        </p>
                        <div class="form-check form-switch p-3 perm-switch">
                            <input class="form-check-input" type="checkbox" role="switch"
                                   name="recibir_notificaciones" id="rnot_{{ $estudiante->id }}"
                                   {{ $pe?->recibir_notificaciones ? 'checked' : '' }}>
                            <label class="form-check-label" for="rnot_{{ $estudiante->id }}">
                                <i class="fas fa-envelope text-primary me-1"></i>
                                <strong>Recibir Notificaciones</strong>
                                <small class="d-block text-muted">Alertas y avisos por correo</small>
                            </label>
                        </div>
                    </div>

                    {{-- Columna central ── Acciones --}}
                    <div class="col-lg-4 px-lg-4" style="border-right:1.5px solid #f1f5f9;">

                        <p class="section-divider" style="margin-top:0;">
                            <i class="fas fa-check-circle" style="color:#4ec7d2;"></i> Acciones
                        </p>

                        <div class="d-flex flex-column gap-2">
                            <div class="form-check form-switch p-3 perm-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                       name="comunicarse_profesores" id="cpro_{{ $estudiante->id }}"
                                       {{ $pe?->comunicarse_profesores ? 'checked' : '' }}>
                                <label class="form-check-label" for="cpro_{{ $estudiante->id }}">
                                    <i class="fas fa-comments text-success me-1"></i>
                                    <strong>Comunicarse con Profesores</strong>
                                    <small class="d-block text-muted">Enviar mensajes a docentes</small>
                                </label>
                            </div>
                            <div class="form-check form-switch p-3 perm-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                       name="autorizar_salidas" id="asal_{{ $estudiante->id }}"
                                       {{ $pe?->autorizar_salidas ? 'checked' : '' }}>
                                <label class="form-check-label" for="asal_{{ $estudiante->id }}">
                                    <i class="fas fa-door-open text-warning me-1"></i>
                                    <strong>Autorizar Salidas</strong>
                                    <small class="d-block text-muted">Salidas y permisos anticipados</small>
                                </label>
                            </div>
                            <div class="form-check form-switch p-3 perm-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                       name="modificar_datos_contacto" id="mdat_{{ $estudiante->id }}"
                                       {{ $pe?->modificar_datos_contacto ? 'checked' : '' }}>
                                <label class="form-check-label" for="mdat_{{ $estudiante->id }}">
                                    <i class="fas fa-edit text-danger me-1"></i>
                                    <strong>Modificar Datos de Contacto</strong>
                                    <small class="d-block text-muted">Actualizar información personal</small>
                                </label>
                            </div>
                            <div class="form-check form-switch p-3 perm-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                       name="descargar_boletas" id="dbol_{{ $estudiante->id }}"
                                       {{ $pe?->descargar_boletas ? 'checked' : '' }}>
                                <label class="form-check-label" for="dbol_{{ $estudiante->id }}">
                                    <i class="fas fa-download text-info me-1"></i>
                                    <strong>Descargar Boletas</strong>
                                    <small class="d-block text-muted">Reportes y boletas académicas</small>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Columna derecha ── Notas + Guardar --}}
                    <div class="col-lg-4 ps-lg-4 mt-3 mt-lg-0">

                        <p class="section-divider" style="margin-top:0;">
                            <i class="fas fa-sticky-note" style="color:#4ec7d2;"></i> Notas Adicionales
                        </p>

                        <textarea class="form-control mb-4" name="notas_adicionales" rows="7"
                                  placeholder="Observaciones especiales sobre estos permisos..."
                                  style="border-radius:9px;border:1.5px solid #e2e8f0;font-size:.84rem;resize:vertical;">{{ $pe->notas_adicionales ?? '' }}</textarea>

                        {{-- Resumen de permisos activos --}}
                        @if($pe)
                        <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:9px;padding:.85rem 1rem;margin-bottom:1.25rem;">
                            <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#059669;margin-bottom:.5rem;">
                                <i class="fas fa-key me-1"></i> Permisos activos actualmente
                            </div>
                            @php
                                $activos = collect([
                                    'ver_calificaciones'      => 'Calificaciones',
                                    'ver_asistencias'         => 'Asistencias',
                                    'ver_comportamiento'      => 'Comportamiento',
                                    'ver_tareas'              => 'Tareas',
                                    'comunicarse_profesores'  => 'Comunicación',
                                    'autorizar_salidas'       => 'Salidas',
                                    'modificar_datos_contacto'=> 'Datos contacto',
                                    'descargar_boletas'       => 'Boletas',
                                    'recibir_notificaciones'  => 'Notificaciones',
                                ])->filter(fn($label, $campo) => $pe->$campo)->values();
                            @endphp
                            @if($activos->count() > 0)
                                @foreach($activos as $label)
                                    <span style="display:inline-flex;align-items:center;gap:.25rem;padding:.18rem .55rem;border-radius:99px;background:#dcfce7;color:#166534;font-size:.68rem;font-weight:700;margin:.1rem;">
                                        <i class="fas fa-check" style="font-size:.55rem;"></i> {{ $label }}
                                    </span>
                                @endforeach
                            @else
                                <span style="font-size:.78rem;color:#64748b;font-style:italic;">Ningún permiso activo</span>
                            @endif
                        </div>
                        @endif

                        <button type="submit" class="btn-guardar">
                            <i class="fas fa-save me-2"></i>Guardar Configuración
                        </button>

                    </div>
                </div>

            </form>
        </div>
    </div>
    @endforeach

</div>
@endsection

@push('scripts')
<script>
function activarTodos(estudianteId) {
    document.getElementById(`form-${estudianteId}`)
            .querySelectorAll('input[type="checkbox"]')
            .forEach(cb => cb.checked = true);
}

function desactivarTodos(estudianteId) {
    document.getElementById(`form-${estudianteId}`)
            .querySelectorAll('input[type="checkbox"]')
            .forEach(cb => cb.checked = false);
}

function establecerDefecto(padreId, estudianteId) {
    sysConfirm('¿Establecer los permisos por defecto? Esto sobrescribirá la configuración actual.', () => {
        window.location.href = `/admins/permisos/${padreId}/${estudianteId}/defecto`;
    });
}
</script>
@endpush
