@extends('layouts.app')

@section('title', 'Configurar Permisos')
@section('page-title', 'Configurar Permisos')

@push('styles')
<style>
    /* ══════════════════════════════════════════════
       VARIABLES DEL SISTEMA
    ══════════════════════════════════════════════ */
    :root {
        --navy:    #003b73;
        --blue:    #00508f;
        --teal:    #4ec7d2;
        --teal-lt: rgba(78,199,210,.12);
        --slate:   #64748b;
        --border:  #e2e8f0;
        --bg:      #f5f7fa;
        --white:   #ffffff;
        --radius:  12px;
        --shadow:  0 1px 4px rgba(0,59,115,.07);
    }

    .perm-wrap { font-family: 'Inter', sans-serif; }

    /* ── Botón volver ── */
    .btn-volver {
        display: inline-flex; align-items: center; gap: .45rem;
        padding: .45rem 1.1rem; border-radius: 8px;
        font-size: .82rem; font-weight: 600;
        background: var(--white); color: var(--blue);
        border: 1.5px solid var(--border);
        text-decoration: none; transition: all .2s;
    }
    .btn-volver:hover { border-color: var(--teal); color: var(--navy); background: var(--teal-lt); }

    /* ── Header de página ── */
    .perm-page-header {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 1rem;
        margin-bottom: 1.75rem;
    }
    .perm-page-header-left h2 {
        font-size: 1.4rem; font-weight: 800; color: var(--navy);
        margin: 0 0 .2rem; letter-spacing: -.02em;
    }
    .perm-page-header-left p {
        margin: 0; font-size: .82rem; color: var(--slate); font-weight: 500;
    }

    /* ── Card base ── */
    .perm-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    .perm-card-head {
        padding: .9rem 1.4rem;
        display: flex; align-items: center; gap: .6rem;
        border-bottom: 1px solid var(--border);
    }
    .perm-card-head.dark {
        background: linear-gradient(135deg, var(--navy) 0%, var(--blue) 100%);
        border-bottom: none;
    }
    .perm-card-head.dark .perm-card-title { color: var(--white); }
    .perm-card-head.dark .perm-card-icon  { color: var(--teal); }
    .perm-card-head.light { background: #f8fafc; }
    .perm-card-head.light .perm-card-title { color: var(--navy); }
    .perm-card-head.light .perm-card-icon  { color: var(--teal); }

    .perm-card-icon  { font-size: .95rem; flex-shrink: 0; }
    .perm-card-title { font-size: .92rem; font-weight: 700; margin: 0; }
    .perm-card-body  { padding: 1.4rem; }

    /* ── Info padre ── */
    .padre-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
    }
    @media(max-width: 640px) { .padre-grid { grid-template-columns: 1fr; } }
    @media(min-width: 641px) and (max-width: 900px) { .padre-grid { grid-template-columns: repeat(2, 1fr); } }

    .padre-field small {
        display: block; font-size: .68rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: .07em;
        color: var(--slate); margin-bottom: .2rem;
    }
    .padre-field span {
        font-size: .85rem; font-weight: 600; color: var(--navy);
    }

    /* ── Card estudiante ── */
    .est-header {
        display: flex; align-items: center;
        justify-content: space-between; flex-wrap: wrap; gap: .75rem;
    }
    .est-name {
        font-size: .98rem; font-weight: 700; color: var(--navy); margin: 0;
        display: flex; align-items: center; gap: .5rem;
    }
    .est-badge {
        font-size: .72rem; font-weight: 600; color: var(--slate);
        background: var(--bg); border: 1px solid var(--border);
        border-radius: 999px; padding: .18rem .7rem;
    }
    .est-actions { display: flex; gap: .5rem; flex-wrap: wrap; }

    .btn-est {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .38rem .85rem; border-radius: 7px; font-size: .75rem;
        font-weight: 600; border: none; cursor: pointer; transition: all .2s;
        text-decoration: none;
    }
    .btn-est-green  { background: #ecfdf5; color: #059669; }
    .btn-est-green:hover  { background: #059669; color: #fff; }
    .btn-est-amber  { background: #fffbeb; color: #92400e; }
    .btn-est-amber:hover  { background: #f59e0b; color: #fff; }
    .btn-est-slate  { background: #f1f5f9; color: var(--slate); }
    .btn-est-slate:hover  { background: var(--blue); color: #fff; }

    /* ── Sección de permisos ── */
    .perm-section-title {
        font-size: .72rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .1em; color: var(--teal);
        border-bottom: 2px solid var(--teal-lt);
        padding-bottom: .45rem; margin: 1.4rem 0 1rem;
        display: flex; align-items: center; gap: .4rem;
    }
    .perm-section-title:first-child { margin-top: 0; }
    .perm-section-title i { font-size: .8rem; }

    /* ── Grid de checkboxes ── */
    .perm-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: .75rem;
    }
    @media(max-width: 640px) { .perm-grid { grid-template-columns: 1fr; } }
    .perm-grid.full { grid-template-columns: 1fr; }

    /* ── Toggle item ── */
    .perm-toggle {
        display: flex; align-items: flex-start; gap: .75rem;
        padding: .85rem 1rem; border-radius: 10px;
        border: 1.5px solid var(--border);
        background: #fafbfc; cursor: pointer;
        transition: all .2s ease; position: relative;
    }
    .perm-toggle:hover {
        border-color: var(--teal);
        background: var(--teal-lt);
        box-shadow: 0 2px 8px rgba(78,199,210,.12);
    }
    .perm-toggle.checked {
        border-color: var(--teal);
        background: rgba(78,199,210,.07);
    }

    /* Switch personalizado */
    .perm-toggle input[type="checkbox"] {
        appearance: none; -webkit-appearance: none;
        width: 38px; height: 22px; border-radius: 999px;
        background: #cbd5e1; border: none; cursor: pointer;
        position: relative; flex-shrink: 0; margin-top: .1rem;
        transition: background .2s;
    }
    .perm-toggle input[type="checkbox"]::after {
        content: ''; position: absolute;
        top: 3px; left: 3px;
        width: 16px; height: 16px;
        border-radius: 50%; background: white;
        transition: transform .2s; box-shadow: 0 1px 3px rgba(0,0,0,.2);
    }
    .perm-toggle input[type="checkbox"]:checked { background: var(--teal); }
    .perm-toggle input[type="checkbox"]:checked::after { transform: translateX(16px); }

    .perm-toggle-body { flex: 1; min-width: 0; }
    .perm-toggle-label {
        font-size: .82rem; font-weight: 600; color: #1e293b;
        margin: 0 0 .15rem; display: flex; align-items: center; gap: .4rem;
    }
    .perm-toggle-label i { font-size: .8rem; color: var(--teal); }
    .perm-toggle-desc { font-size: .73rem; color: var(--slate); margin: 0; line-height: 1.4; }

    /* ── Notas ── */
    .perm-textarea {
        width: 100%; border: 1.5px solid var(--border);
        border-radius: 9px; padding: .75rem 1rem;
        font-size: .82rem; color: #1e293b; resize: vertical;
        font-family: 'Inter', sans-serif; transition: border-color .2s;
        background: #fafbfc; outline: none;
    }
    .perm-textarea:focus { border-color: var(--teal); background: var(--white); }

    /* ── Botón guardar ── */
    .btn-guardar {
        width: 100%; padding: .75rem 1rem;
        background: linear-gradient(135deg, var(--teal) 0%, var(--blue) 100%);
        color: white; border: none; border-radius: 9px;
        font-size: .88rem; font-weight: 700; cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: .5rem;
        transition: all .2s; box-shadow: 0 3px 10px rgba(0,80,143,.2);
        margin-top: 1.2rem;
    }
    .btn-guardar:hover {
        opacity: .92; transform: translateY(-1px);
        box-shadow: 0 5px 16px rgba(0,80,143,.28);
    }

    /* ── Alerta sin hijos ── */
    .perm-empty {
        background: #fffbeb; border: 1px solid #fcd34d;
        border-left: 4px solid #f59e0b; border-radius: 10px;
        padding: 1rem 1.25rem; font-size: .85rem; color: #92400e;
        display: flex; align-items: center; gap: .6rem;
    }
    .perm-empty i { font-size: 1rem; flex-shrink: 0; }
</style>
@endpush

@section('content')
<div class="perm-wrap">

    {{-- ══ Header ══ --}}
    <div class="perm-page-header">
        <div class="perm-page-header-left">
            <h2><i class="fas fa-user-lock" style="color:var(--teal);margin-right:.45rem;"></i>Configurar Permisos</h2>
            <p>Gestión de acceso para {{ $padre->nombre_completo }}</p>
        </div>
        <a href="{{ route('admin.permisos.index') }}" class="btn-volver">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    {{-- ══ Alertas ══ --}}
    @if(session('success'))
        <div class="flash-alert flash-success alert-dismissible fade show" style="margin-bottom:1rem;">
            <i class="fas fa-check-circle" style="flex-shrink:0;"></i>
            <span style="flex:1;padding-right:1.5rem;"><strong>Guardado.</strong> {{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="flash-alert flash-error alert-dismissible fade show" style="margin-bottom:1rem;">
            <i class="fas fa-exclamation-circle" style="flex-shrink:0;"></i>
            <span style="flex:1;padding-right:1.5rem;"><strong>Error.</strong> {{ session('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ══ Info del Padre ══ --}}
    <div class="perm-card">
        <div class="perm-card-head dark">
            <i class="fas fa-user perm-card-icon"></i>
            <h5 class="perm-card-title">Información del Padre / Tutor</h5>
        </div>
        <div class="perm-card-body">
            <div class="padre-grid">
                <div class="padre-field">
                    <small>Nombre completo</small>
                    <span>{{ $padre->nombre_completo }}</span>
                </div>
                <div class="padre-field">
                    <small>DNI</small>
                    <span>{{ $padre->dni ?? 'N/A' }}</span>
                </div>
                <div class="padre-field">
                    <small>Parentesco</small>
                    <span>{{ $padre->parentesco_formateado }}</span>
                </div>
                <div class="padre-field">
                    <small>Correo electrónico</small>
                    <span>{{ $padre->correo ?? 'N/A' }}</span>
                </div>
                <div class="padre-field">
                    <small>Teléfono</small>
                    <span>{{ $padre->telefono ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ══ Hijos / Permisos ══ --}}
    @if($padre->estudiantes->count() > 0)
        @foreach($padre->estudiantes as $estudiante)
        @php $pe = $permisosExistentes[$estudiante->id] ?? null; @endphp

        <div class="perm-card">
            {{-- Cabecera del estudiante --}}
            <div class="perm-card-head light" style="padding: 1rem 1.4rem;">
                <div class="est-header" style="width:100%;">
                    <h5 class="est-name">
                        <i class="fas fa-user-graduate" style="color:var(--teal);font-size:.9rem;"></i>
                        {{ $estudiante->nombre1 ?? 'N/A' }} {{ $estudiante->apellido1 ?? '' }}
                        <span class="est-badge">
                            {{ $estudiante->grado ?? 'N/A' }} &mdash; {{ $estudiante->seccion ?? 'N/A' }}
                        </span>
                    </h5>
                    <div class="est-actions">
                        <button type="button" class="btn-est btn-est-green"
                                onclick="activarTodos({{ $padre->id }}, {{ $estudiante->id }})">
                            <i class="fas fa-check-double"></i> Activar todos
                        </button>
                        <button type="button" class="btn-est btn-est-amber"
                                onclick="desactivarTodos({{ $padre->id }}, {{ $estudiante->id }})">
                            <i class="fas fa-times-circle"></i> Desactivar todos
                        </button>
                        <button type="button" class="btn-est btn-est-slate"
                                onclick="establecerDefecto({{ $padre->id }}, {{ $estudiante->id }})">
                            <i class="fas fa-undo"></i> Por defecto
                        </button>
                    </div>
                </div>
            </div>

            {{-- Formulario de permisos --}}
            <div class="perm-card-body">
                <form action="{{ route('admin.permisos.guardar', $padre->id) }}"
                      method="POST"
                      id="form-{{ $estudiante->id }}">
                    @csrf
                    <input type="hidden" name="estudiante_id" value="{{ $estudiante->id }}">

                    {{-- Visualización --}}
                    <div class="perm-section-title">
                        <i class="fas fa-eye"></i> Permisos de Visualización
                    </div>
                    <div class="perm-grid">

                        <label class="perm-toggle {{ $pe?->ver_calificaciones ? 'checked' : '' }}">
                            <input type="checkbox" name="ver_calificaciones"
                                   id="ver_calificaciones_{{ $estudiante->id }}"
                                   {{ $pe?->ver_calificaciones ? 'checked' : '' }}
                                   onchange="toggleChecked(this)">
                            <div class="perm-toggle-body">
                                <p class="perm-toggle-label">
                                    <i class="fas fa-star"></i> Ver Calificaciones
                                </p>
                                <p class="perm-toggle-desc">Permite ver las notas del estudiante</p>
                            </div>
                        </label>

                        <label class="perm-toggle {{ $pe?->ver_asistencias ? 'checked' : '' }}">
                            <input type="checkbox" name="ver_asistencias"
                                   id="ver_asistencias_{{ $estudiante->id }}"
                                   {{ $pe?->ver_asistencias ? 'checked' : '' }}
                                   onchange="toggleChecked(this)">
                            <div class="perm-toggle-body">
                                <p class="perm-toggle-label">
                                    <i class="fas fa-calendar-check"></i> Ver Asistencias
                                </p>
                                <p class="perm-toggle-desc">Permite ver el registro de asistencias</p>
                            </div>
                        </label>

                        <label class="perm-toggle {{ $pe?->ver_comportamiento ? 'checked' : '' }}">
                            <input type="checkbox" name="ver_comportamiento"
                                   id="ver_comportamiento_{{ $estudiante->id }}"
                                   {{ $pe?->ver_comportamiento ? 'checked' : '' }}
                                   onchange="toggleChecked(this)">
                            <div class="perm-toggle-body">
                                <p class="perm-toggle-label">
                                    <i class="fas fa-clipboard-list"></i> Ver Comportamiento
                                </p>
                                <p class="perm-toggle-desc">Permite ver reportes de conducta</p>
                            </div>
                        </label>

                        <label class="perm-toggle {{ $pe?->ver_tareas ? 'checked' : '' }}">
                            <input type="checkbox" name="ver_tareas"
                                   id="ver_tareas_{{ $estudiante->id }}"
                                   {{ $pe?->ver_tareas ? 'checked' : '' }}
                                   onchange="toggleChecked(this)">
                            <div class="perm-toggle-body">
                                <p class="perm-toggle-label">
                                    <i class="fas fa-tasks"></i> Ver Tareas
                                </p>
                                <p class="perm-toggle-desc">Permite ver las tareas asignadas</p>
                            </div>
                        </label>

                    </div>

                    {{-- Acción --}}
                    <div class="perm-section-title">
                        <i class="fas fa-mouse-pointer"></i> Permisos de Acción
                    </div>
                    <div class="perm-grid">

                        <label class="perm-toggle {{ $pe?->comunicarse_profesores ? 'checked' : '' }}">
                            <input type="checkbox" name="comunicarse_profesores"
                                   id="comunicarse_profesores_{{ $estudiante->id }}"
                                   {{ $pe?->comunicarse_profesores ? 'checked' : '' }}
                                   onchange="toggleChecked(this)">
                            <div class="perm-toggle-body">
                                <p class="perm-toggle-label">
                                    <i class="fas fa-comments"></i> Comunicarse con Profesores
                                </p>
                                <p class="perm-toggle-desc">Permite enviar mensajes a profesores</p>
                            </div>
                        </label>

                        <label class="perm-toggle {{ $pe?->autorizar_salidas ? 'checked' : '' }}">
                            <input type="checkbox" name="autorizar_salidas"
                                   id="autorizar_salidas_{{ $estudiante->id }}"
                                   {{ $pe?->autorizar_salidas ? 'checked' : '' }}
                                   onchange="toggleChecked(this)">
                            <div class="perm-toggle-body">
                                <p class="perm-toggle-label">
                                    <i class="fas fa-door-open"></i> Autorizar Salidas o Permisos
                                </p>
                                <p class="perm-toggle-desc">Permite autorizar salidas anticipadas</p>
                            </div>
                        </label>

                        <label class="perm-toggle {{ $pe?->modificar_datos_contacto ? 'checked' : '' }}">
                            <input type="checkbox" name="modificar_datos_contacto"
                                   id="modificar_datos_contacto_{{ $estudiante->id }}"
                                   {{ $pe?->modificar_datos_contacto ? 'checked' : '' }}
                                   onchange="toggleChecked(this)">
                            <div class="perm-toggle-body">
                                <p class="perm-toggle-label">
                                    <i class="fas fa-id-card"></i> Modificar Datos de Contacto
                                </p>
                                <p class="perm-toggle-desc">Permite actualizar información personal</p>
                            </div>
                        </label>

                        <label class="perm-toggle {{ $pe?->descargar_boletas ? 'checked' : '' }}">
                            <input type="checkbox" name="descargar_boletas"
                                   id="descargar_boletas_{{ $estudiante->id }}"
                                   {{ $pe?->descargar_boletas ? 'checked' : '' }}
                                   onchange="toggleChecked(this)">
                            <div class="perm-toggle-body">
                                <p class="perm-toggle-label">
                                    <i class="fas fa-file-download"></i> Descargar Boletas
                                </p>
                                <p class="perm-toggle-desc">Permite descargar reportes académicos</p>
                            </div>
                        </label>

                    </div>

                    {{-- Notificaciones --}}
                    <div class="perm-section-title">
                        <i class="fas fa-bell"></i> Notificaciones
                    </div>
                    <div class="perm-grid full">
                        <label class="perm-toggle {{ $pe?->recibir_notificaciones ? 'checked' : '' }}">
                            <input type="checkbox" name="recibir_notificaciones"
                                   id="recibir_notificaciones_{{ $estudiante->id }}"
                                   {{ $pe?->recibir_notificaciones ? 'checked' : '' }}
                                   onchange="toggleChecked(this)">
                            <div class="perm-toggle-body">
                                <p class="perm-toggle-label">
                                    <i class="fas fa-envelope"></i> Recibir Notificaciones
                                </p>
                                <p class="perm-toggle-desc">Recibe alertas por correo sobre actividad del estudiante</p>
                            </div>
                        </label>
                    </div>

                    {{-- Notas adicionales --}}
                    <div class="perm-section-title">
                        <i class="fas fa-sticky-note"></i> Notas Adicionales
                    </div>
                    <textarea class="perm-textarea"
                              id="notas_adicionales_{{ $estudiante->id }}"
                              name="notas_adicionales"
                              rows="3"
                              placeholder="Agregar observaciones o restricciones especiales sobre estos permisos...">{{ $pe->notas_adicionales ?? '' }}</textarea>

                    {{-- Guardar --}}
                    <button type="submit" class="btn-guardar">
                        <i class="fas fa-save"></i> Guardar Configuración
                    </button>

                </form>
            </div>
        </div>
        @endforeach

    @else
        <div class="perm-empty">
            <i class="fas fa-exclamation-triangle"></i>
            <span>Este padre / tutor no tiene hijos registrados en el sistema.</span>
        </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
    /* Sincroniza clase 'checked' en el label contenedor */
    function toggleChecked(input) {
        input.closest('.perm-toggle').classList.toggle('checked', input.checked);
    }

    function activarTodos(padreId, estudianteId) {
        document.getElementById(`form-${estudianteId}`)
            .querySelectorAll('input[type="checkbox"]')
            .forEach(cb => {
                cb.checked = true;
                cb.closest('.perm-toggle').classList.add('checked');
            });
    }

    function desactivarTodos(padreId, estudianteId) {
        document.getElementById(`form-${estudianteId}`)
            .querySelectorAll('input[type="checkbox"]')
            .forEach(cb => {
                cb.checked = false;
                cb.closest('.perm-toggle').classList.remove('checked');
            });
    }

    function establecerDefecto(padreId, estudianteId) {
        if (confirm('¿Establecer permisos por defecto? Esto sobrescribirá la configuración actual.')) {
            window.location.href = `/admin/permisos/${padreId}/${estudianteId}/defecto`;
        }
    }
</script>
@endpush