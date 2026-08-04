@extends('layouts.app')

@section('title', 'Configurar Permisos')
@section('page-title', 'Configurar Permisos')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    .perm-wrap { font-family: 'Inter', sans-serif; }

    /* ── Switches ─────────────────────────────────────────────── */
    .form-check-input:checked {
        background-color: #003b73;
        border-color: #003b73;
    }
    .form-check-input:focus {
        border-color: #4ec7d2;
        box-shadow: 0 0 0 0.25rem rgba(78,199,210,0.25);
    }

    .perm-switch {
        transition: all 0.18s ease;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        background: #fafbfc;
        padding: .75rem 1rem;
        margin-bottom: .4rem;
    }
    .perm-switch:hover {
        border-color: #4ec7d2;
        box-shadow: 0 2px 8px rgba(78,199,210,0.15);
        background: rgba(78,199,210,0.04);
    }
    .perm-switch .form-check-input {
        width: 2.2em;
        height: 1.15em;
        margin-top: .22em;
        cursor: pointer;
    }
    .perm-switch strong { font-size: .86rem; color: #0f172a; }
    .perm-switch small  { font-size: .72rem; color: #94a3b8; }

    /* ── Section divider ─────────────────────────────────────── */
    .section-divider {
        font-size: 0.7rem; font-weight: 700; letter-spacing: 0.08em;
        text-transform: uppercase; color: #00508f;
        border-bottom: 2px solid #e8f8f9;
        padding-bottom: 0.45rem; margin-bottom: .85rem; margin-top: .1rem;
        display: flex; align-items: center; gap: .4rem;
    }

    /* ── Botones de acción rápida ────────────────────────────── */
    .btn-accion {
        padding: .32rem .85rem; border-radius: 7px; font-size: .75rem;
        font-weight: 600; cursor: pointer; transition: all .15s;
        display: inline-flex; align-items: center; gap: .35rem;
        border: 1.5px solid; font-family: 'Inter', sans-serif;
    }
    .btn-activar    { background:#f0fdf4; color:#059669; border-color:#86efac; }
    .btn-activar:hover    { background:#059669; color:#fff; border-color:#059669; }
    .btn-desactivar { background:#fef2f2; color:#dc2626; border-color:#fca5a5; }
    .btn-desactivar:hover { background:#dc2626; color:#fff; border-color:#dc2626; }
    .btn-defecto    { background:#f8fafc; color:#475569; border-color:#e2e8f0; }
    .btn-defecto:hover    { background:#475569; color:#fff; border-color:#475569; }

    /* ── Botón guardar ───────────────────────────────────────── */
    .btn-guardar {
        width: 100%; padding: .7rem; border-radius: 9px; border: none;
        background: linear-gradient(135deg, #4ec7d2, #00508f);
        color: #fff; font-size: .9rem; font-weight: 700; cursor: pointer;
        font-family: 'Inter', sans-serif;
        box-shadow: 0 3px 10px rgba(78,199,210,.3);
        transition: opacity .15s, transform .15s;
        display: inline-flex; align-items: center; justify-content: center; gap: .5rem;
    }
    .btn-guardar:hover { opacity: .9; transform: translateY(-1px); }

    /* ── Card hijo ───────────────────────────────────────────── */
    .hijo-card {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0,0,0,.05);
        margin-bottom: .85rem;
        overflow: hidden;
        transition: box-shadow .18s;
    }
    .hijo-card:hover { box-shadow: 0 4px 14px rgba(0,59,115,.08); }

    .hijo-header {
        background: rgba(0,80,143,0.05);
        border-bottom: 2px solid #4ec7d2;
        padding: .9rem 1.5rem;
        display: flex; align-items: center;
        justify-content: space-between;
        flex-wrap: wrap; gap: .75rem;
    }

    .hijo-avatar {
        width: 42px; height: 42px; flex-shrink: 0;
        background: linear-gradient(135deg, #4ec7d2, #00508f);
        border-radius: 10px; display: flex; align-items: center;
        justify-content: center; color: #fff;
        font-weight: 700; font-size: .9rem;
    }

    /* ── Badge status ─────────────────────────────────────────── */
    .badge-configurado {
        display: inline-flex; align-items: center; gap: .3rem;
        background: rgba(16,185,129,.1); color: #065f46;
        border: 1px solid #6ee7b7; border-radius: 20px;
        padding: .2rem .6rem; font-size: .7rem; font-weight: 700;
    }
    .badge-sin-config {
        display: inline-flex; align-items: center; gap: .3rem;
        background: rgba(245,158,11,.1); color: #b45309;
        border: 1px solid #fcd34d; border-radius: 20px;
        padding: .2rem .6rem; font-size: .7rem; font-weight: 700;
    }

    /* ── Resumen permisos activos ─────────────────────────────── */
    .resumen-permisos {
        background: #f0fdf4; border: 1px solid #bbf7d0;
        border-radius: 9px; padding: .85rem 1rem; margin-bottom: 1.1rem;
    }
    .resumen-title {
        font-size: .68rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .07em; color: #059669; margin-bottom: .5rem;
    }
    .perm-chip {
        display: inline-flex; align-items: center; gap: .25rem;
        padding: .18rem .55rem; border-radius: 99px;
        background: #dcfce7; color: #166534;
        font-size: .68rem; font-weight: 700; margin: .1rem;
    }

    /* ── Stats hero ──────────────────────────────────────────── */
    .perm-stats {
        display: grid; grid-template-columns: repeat(3,1fr);
        gap: 1rem; margin-bottom: 1.25rem;
    }
    @media(max-width:768px){ .perm-stats { grid-template-columns: 1fr; } }

    .perm-stat {
        background: #fff; border-radius: 12px; border: 1px solid #e2e8f0;
        padding: 1rem 1.25rem; display: flex; align-items: center; gap: .9rem;
        box-shadow: 0 1px 3px rgba(0,0,0,.05);
    }
    .perm-stat-icon {
        width: 44px; height: 44px; border-radius: 11px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
    }
    .perm-stat-icon i { font-size: 1.1rem; color: #fff; }
    .perm-stat-lbl { font-size: .68rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .05em; color: #94a3b8; margin-bottom: .1rem; }
    .perm-stat-num { font-size: 1.5rem; font-weight: 700; color: #0f172a; line-height: 1; }

    /* ── Textarea ────────────────────────────────────────────── */
    .perm-textarea {
        width: 100%; border: 1.5px solid #e2e8f0; border-radius: 9px;
        padding: .65rem .85rem; font-size: .84rem; font-family: 'Inter', sans-serif;
        color: #1e293b; resize: vertical; transition: border-color .2s;
    }
    .perm-textarea:focus {
        border-color: #4ec7d2;
        box-shadow: 0 0 0 3px rgba(78,199,210,.12); outline: none;
    }

    /* ── Separador columnas ──────────────────────────────────── */
    @media(min-width:992px) {
        .col-sep-r { border-right: 1.5px solid #f1f5f9; padding-right: 1.5rem; }
        .col-sep-l { padding-left: 1.5rem; }
        .col-sep-m { padding-left: 1.5rem; padding-right: 1.5rem; border-right: 1.5px solid #f1f5f9; }
    }
</style>
@endpush

@section('content')
<div class="perm-wrap container-fluid px-4">

    {{-- Mensajes --}}
    @if(session('success'))
        <div style="background:#f0fdf4;border:1px solid #86efac;border-radius:10px;color:#065f46;padding:1rem 1.25rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:.75rem;">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.remove()"
                    style="margin-left:auto;background:none;border:none;color:#065f46;font-size:1.2rem;cursor:pointer;">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div style="background:#fef2f2;border:1px solid #fca5a5;border-radius:10px;color:#991b1b;padding:1rem 1.25rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:.75rem;">
            <i class="fas fa-exclamation-triangle"></i>
            <span>{{ session('error') }}</span>
            <button type="button" onclick="this.parentElement.remove()"
                    style="margin-left:auto;background:none;border:none;color:#991b1b;font-size:1.2rem;cursor:pointer;">&times;</button>
        </div>
    @endif

    {{-- ══ Hero Padre ══════════════════════════════════════════ --}}
    <div style="background:linear-gradient(135deg,#003b73,#00508f);border-radius:12px;padding:1.25rem 1.75rem;margin-bottom:1.25rem;display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;box-shadow:0 4px 14px rgba(0,59,115,.2);">
        <div style="display:flex;align-items:center;gap:1.1rem;">
            <div style="width:56px;height:56px;background:rgba(255,255,255,.1);border:2px solid #4ec7d2;border-radius:14px;display:flex;align-items:center;justify-content:center;font-weight:800;color:#4ec7d2;font-size:1.3rem;flex-shrink:0;">
                {{ strtoupper(substr($padre->nombre,0,1)) }}
            </div>
            <div>
                <div style="font-weight:700;color:#fff;font-size:1.1rem;margin-bottom:.25rem;">
                    {{ $padre->nombre }} {{ $padre->apellido }}
                </div>
                <div style="font-size:.76rem;color:rgba(255,255,255,.6);display:flex;gap:1.25rem;flex-wrap:wrap;">
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
        <div style="font-size:.78rem;color:rgba(255,255,255,.55);display:flex;align-items:center;gap:.4rem;">
            <i class="fas fa-child"></i>
            {{ $padre->estudiantes->count() }}
            {{ $padre->estudiantes->count() === 1 ? 'hijo vinculado' : 'hijos vinculados' }}
        </div>
    </div>

    {{-- ══ Stats ═══════════════════════════════════════════════ --}}
    @php
        $totalHijos      = $padre->estudiantes->count();
        $configurados    = collect($permisosExistentes)->count();
        $sinConfigurar   = $totalHijos - $configurados;
    @endphp
    <div class="perm-stats">
        <div class="perm-stat">
            <div class="perm-stat-icon" style="background:linear-gradient(135deg,#4ec7d2,#00508f);">
                <i class="fas fa-child"></i>
            </div>
            <div>
                <div class="perm-stat-lbl">Hijos vinculados</div>
                <div class="perm-stat-num">{{ $totalHijos }}</div>
            </div>
        </div>
        <div class="perm-stat">
            <div class="perm-stat-icon" style="background:linear-gradient(135deg,#10b981,#059669);">
                <i class="fas fa-key"></i>
            </div>
            <div>
                <div class="perm-stat-lbl">Configurados</div>
                <div class="perm-stat-num" style="color:#059669;">{{ $configurados }}</div>
            </div>
        </div>
        <div class="perm-stat">
            <div class="perm-stat-icon" style="background:linear-gradient(135deg,#fbbf24,#f59e0b);">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div>
                <div class="perm-stat-lbl">Sin configurar</div>
                <div class="perm-stat-num" style="color:#b45309;">{{ $sinConfigurar }}</div>
            </div>
        </div>
    </div>

    {{-- Sin hijos ──────────────────────────────────────────── --}}
    @if($padre->estudiantes->count() === 0)
    <div class="hijo-card">
        <div class="card-body text-center py-5">
            <i class="fas fa-user-graduate fa-2x mb-3" style="color:#c3d9ee;display:block;"></i>
            <h6 style="color:#003b73;">Sin estudiantes vinculados</h6>
            <p class="text-muted small mb-0">Este padre/tutor no tiene hijos registrados.</p>
        </div>
    </div>
    @endif

    {{-- ══ Un bloque por hijo ══════════════════════════════════ --}}
    @foreach($padre->estudiantes as $estudiante)
    @php $pe = $permisosExistentes[$estudiante->id] ?? null; @endphp

    <div class="hijo-card">

        {{-- Cabecera del hijo --}}
        <div class="hijo-header">
            <div style="display:flex;align-items:center;gap:.85rem;">
                <div class="hijo-avatar">
                    {{ strtoupper(substr($estudiante->nombre1,0,1).substr($estudiante->apellido1,0,1)) }}
                </div>
                <div>
                    <div style="font-weight:700;color:#003b73;font-size:.95rem;">
                        {{ $estudiante->nombre1 }} {{ $estudiante->nombre2 }}
                        {{ $estudiante->apellido1 }} {{ $estudiante->apellido2 }}
                    </div>
                    <div style="font-size:.74rem;color:#64748b;display:flex;align-items:center;gap:.6rem;flex-wrap:wrap;margin-top:.2rem;">
                        <span><i class="fas fa-graduation-cap me-1"></i>{{ $estudiante->grado }} — Sección {{ $estudiante->seccion }}</span>
                        @if($pe)
                            <span class="badge-configurado"><i class="fas fa-check-circle"></i> Permisos configurados</span>
                        @else
                            <span class="badge-sin-config"><i class="fas fa-exclamation-circle"></i> Sin configurar</span>
                        @endif
                    </div>
                </div>
            </div>

            <div style="display:flex;gap:.45rem;flex-wrap:wrap;">
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

        {{-- Formulario ─────────────────────────────────────── --}}
        <div style="padding:1.5rem;">
            <form action="{{ route('admins.permisos.guardar', $padre->id) }}"
                  method="POST" id="form-{{ $estudiante->id }}">
                @csrf
                <input type="hidden" name="estudiante_id" value="{{ $estudiante->id }}">

                <div class="row g-0">

                    {{-- Col izquierda: Visualización + Notificaciones --}}
                    <div class="col-lg-4 col-sep-r">

                        <p class="section-divider">
                            <i class="fas fa-eye" style="color:#4ec7d2;"></i> Visualización
                        </p>

                        <div class="perm-switch form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch"
                                   name="ver_calificaciones" id="vcal_{{ $estudiante->id }}"
                                   {{ $pe?->ver_calificaciones ? 'checked' : '' }}>
                            <label class="form-check-label" for="vcal_{{ $estudiante->id }}">
                                <i class="fas fa-star text-warning me-1"></i>
                                <strong>Ver Calificaciones</strong>
                                <small class="d-block">Notas y promedios del estudiante</small>
                            </label>
                        </div>
                        <div class="perm-switch form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch"
                                   name="ver_asistencias" id="vasi_{{ $estudiante->id }}"
                                   {{ $pe?->ver_asistencias ? 'checked' : '' }}>
                            <label class="form-check-label" for="vasi_{{ $estudiante->id }}">
                                <i class="fas fa-calendar-check text-success me-1"></i>
                                <strong>Ver Asistencias</strong>
                                <small class="d-block">Registro de asistencia y faltas</small>
                            </label>
                        </div>
                        <div class="perm-switch form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch"
                                   name="ver_comportamiento" id="vcom_{{ $estudiante->id }}"
                                   {{ $pe?->ver_comportamiento ? 'checked' : '' }}>
                            <label class="form-check-label" for="vcom_{{ $estudiante->id }}">
                                <i class="fas fa-smile text-info me-1"></i>
                                <strong>Ver Comportamiento</strong>
                                <small class="d-block">Reportes de conducta</small>
                            </label>
                        </div>
                        <div class="perm-switch form-check form-switch mb-4">
                            <input class="form-check-input" type="checkbox" role="switch"
                                   name="ver_tareas" id="vtar_{{ $estudiante->id }}"
                                   {{ $pe?->ver_tareas ? 'checked' : '' }}>
                            <label class="form-check-label" for="vtar_{{ $estudiante->id }}">
                                <i class="fas fa-tasks text-primary me-1"></i>
                                <strong>Ver Tareas</strong>
                                <small class="d-block">Lista de tareas asignadas</small>
                            </label>
                        </div>

                        <p class="section-divider">
                            <i class="fas fa-bell" style="color:#4ec7d2;"></i> Notificaciones
                        </p>
                        <div class="perm-switch form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch"
                                   name="recibir_notificaciones" id="rnot_{{ $estudiante->id }}"
                                   {{ $pe?->recibir_notificaciones ? 'checked' : '' }}>
                            <label class="form-check-label" for="rnot_{{ $estudiante->id }}">
                                <i class="fas fa-envelope text-primary me-1"></i>
                                <strong>Recibir Notificaciones</strong>
                                <small class="d-block">Alertas y avisos por correo</small>
                            </label>
                        </div>
                    </div>

                    {{-- Col central: Acciones --}}
                    <div class="col-lg-4 col-sep-m mt-4 mt-lg-0">

                        <p class="section-divider" style="margin-top:0;">
                            <i class="fas fa-check-circle" style="color:#4ec7d2;"></i> Acciones
                        </p>

                        <div class="perm-switch form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch"
                                   name="comunicarse_profesores" id="cpro_{{ $estudiante->id }}"
                                   {{ $pe?->comunicarse_profesores ? 'checked' : '' }}>
                            <label class="form-check-label" for="cpro_{{ $estudiante->id }}">
                                <i class="fas fa-comments text-success me-1"></i>
                                <strong>Comunicarse con Profesores</strong>
                                <small class="d-block">Enviar mensajes a docentes</small>
                            </label>
                        </div>
                        <div class="perm-switch form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch"
                                   name="autorizar_salidas" id="asal_{{ $estudiante->id }}"
                                   {{ $pe?->autorizar_salidas ? 'checked' : '' }}>
                            <label class="form-check-label" for="asal_{{ $estudiante->id }}">
                                <i class="fas fa-door-open text-warning me-1"></i>
                                <strong>Autorizar Salidas</strong>
                                <small class="d-block">Salidas y permisos anticipados</small>
                            </label>
                        </div>
                        <div class="perm-switch form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch"
                                   name="modificar_datos_contacto" id="mdat_{{ $estudiante->id }}"
                                   {{ $pe?->modificar_datos_contacto ? 'checked' : '' }}>
                            <label class="form-check-label" for="mdat_{{ $estudiante->id }}">
                                <i class="fas fa-edit text-danger me-1"></i>
                                <strong>Modificar Datos de Contacto</strong>
                                <small class="d-block">Actualizar información personal</small>
                            </label>
                        </div>
                        <div class="perm-switch form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch"
                                   name="descargar_boletas" id="dbol_{{ $estudiante->id }}"
                                   {{ $pe?->descargar_boletas ? 'checked' : '' }}>
                            <label class="form-check-label" for="dbol_{{ $estudiante->id }}">
                                <i class="fas fa-download text-info me-1"></i>
                                <strong>Descargar Boletas</strong>
                                <small class="d-block">Reportes y boletas académicas</small>
                            </label>
                        </div>
                    </div>

                    {{-- Col derecha: Notas + Guardar --}}
                    <div class="col-lg-4 col-sep-l mt-4 mt-lg-0">

                        <p class="section-divider" style="margin-top:0;">
                            <i class="fas fa-sticky-note" style="color:#4ec7d2;"></i> Notas Adicionales
                        </p>

                        <textarea class="perm-textarea mb-3" name="notas_adicionales" rows="6"
                                  placeholder="Observaciones especiales sobre estos permisos...">{{ $pe->notas_adicionales ?? '' }}</textarea>

                        {{-- Resumen permisos activos --}}
                        @if($pe)
                        <div class="resumen-permisos">
                            <div class="resumen-title">
                                <i class="fas fa-key me-1"></i> Permisos activos actualmente
                            </div>
                            @php
                                $activos = collect([
                                    'ver_calificaciones'       => 'Calificaciones',
                                    'ver_asistencias'          => 'Asistencias',
                                    'ver_comportamiento'       => 'Comportamiento',
                                    'ver_tareas'               => 'Tareas',
                                    'comunicarse_profesores'   => 'Comunicación',
                                    'autorizar_salidas'        => 'Salidas',
                                    'modificar_datos_contacto' => 'Datos contacto',
                                    'descargar_boletas'        => 'Boletas',
                                    'recibir_notificaciones'   => 'Notificaciones',
                                ])->filter(fn($label, $campo) => $pe->$campo)->values();
                            @endphp
                            @if($activos->count() > 0)
                                @foreach($activos as $label)
                                    <span class="perm-chip">
                                        <i class="fas fa-check" style="font-size:.55rem;"></i> {{ $label }}
                                    </span>
                                @endforeach
                            @else
                                <span style="font-size:.78rem;color:#64748b;font-style:italic;">Ningún permiso activo</span>
                            @endif
                        </div>
                        @endif

                        <button type="submit" class="btn-guardar">
                            <i class="fas fa-save"></i> Guardar Configuración
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