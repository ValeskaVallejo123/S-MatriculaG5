@extends('layouts.app')

@section('title', 'Roles y Permisos')
@section('page-title', 'Roles y Permisos')

@push('styles')
<style>
    /* Prefijo rp- para evitar conflictos con Bootstrap y el layout */

    .rp-tabs {
        display: flex;
        gap: 3px;
        background: #f1f3f6;
        padding: 4px;
        border-radius: 10px;
        width: fit-content;
        margin-bottom: 20px;
    }
    .rp-tab {
        padding: 7px 20px;
        border-radius: 7px;
        font-size: .82rem;
        font-weight: 600;
        color: #6b7280;
        cursor: pointer;
        border: none;
        background: none;
        transition: all .2s;
    }
    .rp-tab.active {
        background: #fff;
        color: #003b73;
        box-shadow: 0 1px 4px rgba(0,0,0,.1);
    }
    .rp-pane { display: none; }
    .rp-pane.active { display: block; animation: rpFadeUp .2s ease; }
    @keyframes rpFadeUp {
        from { opacity: 0; transform: translateY(5px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ── Layout dos columnas ── */
    .rp-layout {
        display: grid;
        grid-template-columns: 250px 1fr;
        gap: 16px;
        align-items: start;
    }
    @media (max-width: 860px) { .rp-layout { grid-template-columns: 1fr; } }

    /* ── Card base ── */
    .rp-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,.05);
    }

    /* ── Sidebar usuarios ── */
    .rp-sidebar-title {
        padding: 12px 14px 8px;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .09em;
        text-transform: uppercase;
        color: #9ca3af;
        border-bottom: 1px solid #f3f4f6;
    }
    .rp-search {
        padding: 10px 12px;
        border-bottom: 1px solid #f3f4f6;
    }
    .rp-search input {
        width: 100%;
        padding: 7px 10px 7px 30px;
        font-size: .82rem;
        border: 1px solid #e5e7eb;
        border-radius: 7px;
        outline: none;
        color: #111827;
        font-family: 'Inter', sans-serif;
        background: #f9fafb url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='13' height='13' fill='none' stroke='%236b7280' stroke-width='2' viewBox='0 0 24 24'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='M21 21l-4.35-4.35'/%3E%3C/svg%3E") no-repeat 9px center;
        transition: border-color .2s, box-shadow .2s;
    }
    .rp-search input:focus {
        border-color: #00508f;
        box-shadow: 0 0 0 3px rgba(0,80,143,.1);
        background-color: #fff;
    }
    .rp-user-list { max-height: 400px; overflow-y: auto; }
    .rp-user-list::-webkit-scrollbar { width: 3px; }
    .rp-user-list::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }

    .rp-user-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        cursor: pointer;
        border-left: 3px solid transparent;
        transition: background .15s, border-color .15s;
    }
    .rp-user-item:hover  { background: #f9fafb; }
    .rp-user-item.active { background: #eff6ff; border-left-color: #00508f; }

    .rp-avatar {
        width: 34px; height: 34px;
        border-radius: 50%;
        font-size: .76rem; font-weight: 700;
        color: #fff;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .rp-uinfo { overflow: hidden; flex: 1; min-width: 0; }
    .rp-uinfo strong {
        display: block;
        font-size: .82rem; font-weight: 600;
        color: #111827;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .rp-uinfo span {
        font-size: .72rem; color: #6b7280;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block;
    }
    .rp-rbadge {
        flex-shrink: 0;
        font-size: .62rem; font-weight: 700;
        padding: 2px 7px; border-radius: 20px;
    }
    .rp-rbadge.sa { background: #fef2f2; color: #dc2626; }
    .rp-rbadge.ad { background: #eff6ff; color: #00508f; }
    .rp-no-results {
        padding: 20px; text-align: center;
        font-size: .82rem; color: #9ca3af; display: none;
    }

    /* ── Panel derecho ── */
    .rp-empty {
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        min-height: 380px; padding: 40px 24px; text-align: center;
    }
    .rp-empty-icon {
        width: 52px; height: 52px;
        background: #f3f4f6; border: 1px solid #e5e7eb;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        color: #9ca3af; font-size: 1.4rem;
        margin-bottom: 14px;
    }
    .rp-empty h6 { font-size: .92rem; font-weight: 600; color: #374151; margin-bottom: 4px; }
    .rp-empty p  { font-size: .8rem; color: #9ca3af; margin: 0; line-height: 1.6; }

    /* Panel head */
    .rp-panel-head {
        display: flex; align-items: center; justify-content: space-between;
        padding: 14px 18px;
        border-bottom: 1px solid #f3f4f6;
        background: #fafafa;
    }
    .rp-panel-user { display: flex; align-items: center; gap: 12px; }
    .rp-panel-user .rp-avatar { width: 40px; height: 40px; font-size: .88rem; }
    .rp-panel-name  { font-size: .9rem; font-weight: 700; color: #111827; display: block; }
    .rp-panel-email { font-size: .75rem; color: #6b7280; display: block; }

    /* Panel body */
    .rp-panel-body { padding: 18px; display: flex; flex-direction: column; gap: 18px; }

    /* Sec label */
    .rp-sec-label {
        font-size: .67rem; font-weight: 700; letter-spacing: .09em;
        text-transform: uppercase; color: #9ca3af;
        display: flex; align-items: center; gap: 8px;
        margin-bottom: 10px;
    }
    .rp-sec-label::after { content: ''; flex: 1; height: 1px; background: #f3f4f6; }

    /* Rol cards */
    .rp-rol-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    @media (max-width: 560px) { .rp-rol-grid { grid-template-columns: 1fr; } }

    .rp-rol-opt {
        position: relative;
        border: 1.5px solid #e5e7eb;
        border-radius: 8px;
        padding: 12px 12px 12px 14px;
        cursor: pointer;
        display: flex; align-items: center; gap: 10px;
        transition: border-color .2s, background .2s;
        user-select: none;
    }
    .rp-rol-opt:hover { border-color: #93c5fd; }
    .rp-rol-opt.sel-ad { border-color: #00508f; background: #eff6ff; }
    .rp-rol-opt.sel-sa { border-color: #dc2626; background: #fef2f2; }
    .rp-rol-opt input  { position: absolute; opacity: 0; pointer-events: none; }

    .rp-rol-icon {
        width: 32px; height: 32px; border-radius: 7px;
        display: flex; align-items: center; justify-content: center;
        font-size: .95rem; flex-shrink: 0;
    }
    .rp-rol-icon.ad { background: #dbeafe; color: #00508f; }
    .rp-rol-icon.sa { background: #fee2e2; color: #dc2626; }

    .rp-rol-txt h6 { font-size: .83rem; font-weight: 700; color: #111827; margin: 0 0 2px; }
    .rp-rol-txt p  { font-size: .71rem; color: #6b7280; margin: 0; line-height: 1.4; }

    .rp-check {
        margin-left: auto; flex-shrink: 0;
        width: 16px; height: 16px; border-radius: 50%;
        border: 1.5px solid #d1d5db; background: #fff;
        display: flex; align-items: center; justify-content: center;
        transition: all .2s;
    }
    .rp-rol-opt.sel-ad .rp-check { border-color: #00508f; background: #00508f; }
    .rp-rol-opt.sel-sa .rp-check { border-color: #dc2626; background: #dc2626; }
    .rp-check i { font-size: .45rem; color: #fff; display: none; }
    .rp-rol-opt.sel-ad .rp-check i,
    .rp-rol-opt.sel-sa .rp-check i { display: block; }

    /* Permisos */
    .rp-perms-head {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 10px;
    }
    .rp-link-btn {
        font-size: .75rem; font-weight: 500; color: #00508f;
        background: none; border: none; cursor: pointer; padding: 0;
        font-family: 'Inter', sans-serif;
        transition: opacity .15s;
    }
    .rp-link-btn:hover { opacity: .7; }
    .rp-link-btn.red   { color: #dc2626; }

    .rp-perms-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
        gap: 7px;
    }
    .rp-perm-item {
        display: flex; align-items: center; gap: 8px;
        padding: 9px 11px;
        border: 1px solid #e5e7eb; border-radius: 7px;
        cursor: pointer; user-select: none;
        transition: border-color .15s, background .15s;
        font-size: .8rem; color: #111827; font-weight: 500;
        font-family: 'Inter', sans-serif;
    }
    .rp-perm-item:hover { border-color: #93c5fd; background: #f0f7ff; }
    .rp-perm-item.on    { border-color: #00508f; background: #eff6ff; }
    .rp-perm-item input { width: 14px; height: 14px; accent-color: #00508f; flex-shrink: 0; cursor: pointer; }

    /* Aviso SA */
    .rp-sa-alert {
        display: flex; gap: 10px;
        padding: 11px 14px;
        background: #fffbeb; border: 1px solid #fde68a;
        border-radius: 8px; font-size: .8rem; color: #92400e; line-height: 1.5;
    }
    .rp-sa-alert i { color: #f59e0b; margin-top: 1px; flex-shrink: 0; }

    /* Footer form */
    .rp-footer {
        display: flex; align-items: center; justify-content: flex-end; gap: 8px;
        padding: 12px 18px; border-top: 1px solid #f3f4f6;
        background: #fafafa;
    }
    .rp-btn-cancel {
        padding: 8px 18px; border-radius: 8px;
        font-size: .82rem; font-weight: 600;
        cursor: pointer; border: 1px solid #e5e7eb;
        background: #fff; color: #6b7280;
        font-family: 'Inter', sans-serif;
        transition: background .15s;
    }
    .rp-btn-cancel:hover { background: #f3f4f6; }
    .rp-btn-save {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 20px; border-radius: 8px;
        font-size: .82rem; font-weight: 600;
        cursor: pointer; border: none;
        background: linear-gradient(135deg, #003b73 0%, #00508f 100%);
        color: #fff;
        font-family: 'Inter', sans-serif;
        box-shadow: 0 2px 6px rgba(0,59,115,.25);
        transition: all .2s;
    }
    .rp-btn-save:hover { box-shadow: 0 4px 12px rgba(0,59,115,.35); transform: translateY(-1px); }

    /* Alertas flash */
    .rp-flash-ok, .rp-flash-err {
        display: flex; align-items: center; gap: 8px;
        padding: 10px 14px; border-radius: 8px;
        font-size: .83rem; font-weight: 500;
        margin-bottom: 14px;
    }
    .rp-flash-ok  { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
    .rp-flash-err { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }

    /* ── Resumen roles compacto ── */
    .rp-roles-grid {
        display: grid; grid-template-columns: 1fr 1fr; gap: 12px;
        margin-bottom: 16px;
    }
    @media (max-width: 600px) { .rp-roles-grid { grid-template-columns: 1fr; } }

    .rp-role-sm { border: 1px solid #e5e7eb; border-radius: 9px; overflow: hidden; }
    .rp-role-sm-head {
        display: flex; align-items: center; gap: 8px;
        padding: 10px 14px;
        font-size: .8rem; font-weight: 700; color: #fff;
    }
    .rp-role-sm-head.sa { background: linear-gradient(90deg, #dc2626, #f97316); }
    .rp-role-sm-head.ad { background: linear-gradient(90deg, #003b73, #00508f); }
    .rp-role-sm-body { padding: 10px 14px; background: #fff; }
    .rp-role-row {
        display: flex; align-items: center; gap: 6px;
        font-size: .77rem; color: #374151;
        padding: 3px 0;
    }
    .rp-role-row .ok { color: #16a34a; font-size: .75rem; }
    .rp-role-row .no { color: #d1d5db; font-size: .75rem; }

    /* ── Tabla comparativa ── */
    .rp-table { width: 100%; border-collapse: collapse; font-size: .8rem; }
    .rp-table th {
        padding: 9px 14px; text-align: left;
        font-size: .68rem; font-weight: 700; letter-spacing: .07em;
        text-transform: uppercase; color: #9ca3af;
        background: #fafafa; border-bottom: 2px solid #e5e7eb;
    }
    .rp-table th:not(:first-child) { text-align: center; }
    .rp-table td {
        padding: 9px 14px; border-bottom: 1px solid #f3f4f6; color: #111827;
    }
    .rp-table td:not(:first-child) { text-align: center; }
    .rp-table tr:last-child td { border-bottom: none; }
    .rp-table tr:hover td { background: #f9fafb; }
    .rp-table tr.denied td { background: #fef9f9; }
    .ico-ok { color: #16a34a; }
    .ico-no { color: #d1d5db; }
    .rp-badge-cfg {
        display: inline-flex; padding: 1px 9px; border-radius: 20px;
        background: #eff6ff; color: #00508f;
        font-size: .68rem; font-weight: 700;
    }

    /* ── Restricted state ── */
    .rp-restricted {
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        padding: 60px 32px; text-align: center;
    }
    .rp-restricted .rp-empty-icon { font-size: 1.5rem; }
    
</style>
@endpush

@section('content')

@php
    // Definir permisos disponibles directamente en la vista
    $permisosDisponibles = [
        'ver_estudiantes' => 'Ver Estudiantes',
        'crear_estudiantes' => 'Crear Estudiantes',
        'editar_estudiantes' => 'Editar Estudiantes',
        'eliminar_estudiantes' => 'Eliminar Estudiantes',
        'ver_profesores' => 'Ver Profesores',
        'crear_profesores' => 'Crear Profesores',
        'editar_profesores' => 'Editar Profesores',
        'eliminar_profesores' => 'Eliminar Profesores',
        'ver_matriculas' => 'Ver Matrículas',
        'crear_matriculas' => 'Crear Matrículas',
        'aprobar_matriculas' => 'Aprobar Matrículas',
        'rechazar_matriculas' => 'Rechazar Matrículas',
        'ver_grados' => 'Ver Grados',
        'gestionar_grados' => 'Gestionar Grados',
        'ver_secciones' => 'Ver Secciones',
        'gestionar_secciones' => 'Gestionar Secciones',
        'ver_reportes' => 'Ver Reportes',
        'exportar_datos' => 'Exportar Datos',
    ];
@endphp

{{-- ── Header ── --}}
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h5 class="mb-0 fw-bold" style="color:#003b73">Roles y Permisos</h5>
        <p class="mb-0 small text-muted mt-1">Configura el nivel de acceso de cada administrador</p>
    </div>
    <a href="{{ route('superadmin.administradores.index') }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-2">
        <i class="fas fa-arrow-left" style="font-size:.75rem"></i>
        Administradores
    </a>
</div>

{{-- ── Tabs ── --}}
<div class="rp-tabs">
    <button class="rp-tab active" data-tab="config">
        <i class="fas fa-sliders-h me-1" style="font-size:.75rem"></i>Configurar
    </button>
    <button class="rp-tab" data-tab="resumen">
        <i class="fas fa-table me-1" style="font-size:.75rem"></i>Referencia
    </button>
</div>

{{-- ══════════ TAB: CONFIGURAR ══════════ --}}
<div class="rp-pane active" id="rp-tab-config">

    @if(auth()->user()->is_super_admin)

    {{-- Alertas flash --}}
    @if(session('success'))
    <div class="rp-flash-ok">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif
    @if($errors->any())
    <div class="rp-flash-err">
        <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
    </div>
    @endif

    <form action="{{ route('superadmin.administradores.permisos.update') }}" method="POST" id="rpForm">
        @csrf
        @method('PUT')
        <input type="hidden" name="usuario_id" id="rpAdminId" value="{{ old('usuario_id') }}">

        <div class="rp-layout">

            {{-- ── Sidebar ── --}}
            <div class="rp-card">
                <div class="rp-sidebar-title">Administradores</div>
                <div class="rp-search">
                    <input type="text" id="rpSearch" placeholder="Buscar usuario...">
                </div>
                <div class="rp-user-list" id="rpUserList">
                    @foreach($usuarios as $admin)
                    @php
                        $colors  = ['#6366f1','#14b8a6','#f59e0b','#ec4899','#8b5cf6','#0ea5e9','#84cc16','#ef4444'];
                        $color   = $colors[$loop->index % count($colors)];
                        $initial = strtoupper(mb_substr($admin->name, 0, 1));
                        $esSA    = $admin->is_super_admin;
                    @endphp
                    <div class="rp-user-item {{ old('usuario_id') == $admin->id ? 'active' : '' }}"
                         data-id="{{ $admin->id }}"
                         data-name="{{ $admin->name }}"
                         data-email="{{ $admin->email }}"
                         data-issa="{{ $esSA ? '1' : '0' }}"
                         data-permisos="{{ json_encode($admin->permissions ?? []) }}"
                         data-color="{{ $color }}"
                         data-initial="{{ $initial }}">
                        <div class="rp-avatar" style="background:{{ $color }}">{{ $initial }}</div>
                        <div class="rp-uinfo">
                            <strong>{{ $admin->name }}</strong>
                            <span>{{ $admin->email }}</span>
                        </div>
                        <span class="rp-rbadge {{ $esSA ? 'sa' : 'ad' }}">
                            {{ $esSA ? 'SA' : 'Admin' }}
                        </span>
                    </div>
                    @endforeach
                </div>
                <div class="rp-no-results" id="rpNoResults">Sin resultados</div>
            </div>

            {{-- ── Panel principal ── --}}
            <div class="rp-card">

                {{-- Estado vacío --}}
                <div class="rp-empty" id="rpEmpty">
                    <div class="rp-empty-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h6>Selecciona un administrador</h6>
                    <p>Elige un usuario de la lista para<br>configurar sus permisos de acceso.</p>
                </div>

                {{-- Panel activo --}}
                <div id="rpActive" class="{{ old('usuario_id') ? '' : 'd-none' }}">

                    {{-- Head --}}
                    <div class="rp-panel-head">
                        <div class="rp-panel-user">
                            <div class="rp-avatar" id="rpPanelAvatar" style="background:#6366f1;width:40px;height:40px;font-size:.88rem">?</div>
                            <div>
                                <span class="rp-panel-name"  id="rpPanelName">—</span>
                                <span class="rp-panel-email" id="rpPanelEmail">—</span>
                            </div>
                        </div>
                        <span class="rp-rbadge ad" id="rpPanelBadge">Admin</span>
                    </div>

                    {{-- Body --}}
                    <div class="rp-panel-body">

                        {{-- Permisos --}}
                        <div id="rpPermsSection">
                            <div class="rp-perms-head">
                                <div class="rp-sec-label" style="margin:0;flex:1">Permisos de acceso</div>
                                <div class="d-flex gap-2 ms-3">
                                    <button type="button" class="rp-link-btn" id="rpBtnAll">Todos</button>
                                    <span class="text-muted">·</span>
                                    <button type="button" class="rp-link-btn red" id="rpBtnNone">Ninguno</button>
                                </div>
                            </div>
                            <div class="rp-perms-grid mt-2">
                                @foreach($permisosDisponibles as $key => $nombre)
                                <label class="rp-perm-item" id="rpw-{{ $key }}">
                                    <input type="checkbox" name="permissions[]" value="{{ $key }}"
                                           class="rp-perm-cb"
                                           {{ in_array($key, old('permissions', [])) ? 'checked' : '' }}>
                                    {{ $nombre }}
                                </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Aviso SA --}}
                        <div class="rp-sa-alert d-none" id="rpSAAlert">
                            <i class="fas fa-exclamation-triangle mt-1"></i>
                            <span>Este es un Super Administrador con <strong>control total</strong> del sistema.</span>
                        </div>

                    </div>

                    {{-- Footer --}}
                    <div class="rp-footer">
                        <button type="button" class="rp-btn-cancel" id="rpBtnCancel">Cancelar</button>
                        <button type="submit" class="rp-btn-save">
                            <i class="fas fa-check" style="font-size:.75rem"></i>
                            Guardar cambios
                        </button>
                    </div>

                </div>{{-- /rpActive --}}
            </div>{{-- /rp-card panel --}}
        </div>{{-- /rp-layout --}}
    </form>

    @else
    <div class="rp-card">
        <div class="rp-restricted">
            <div class="rp-empty-icon"><i class="fas fa-lock"></i></div>
            <h6 class="mt-2 fw-bold">Acceso restringido</h6>
            <p class="text-muted small">Solo el Super Administrador puede gestionar<br>roles y permisos del sistema.</p>
        </div>
    </div>
    @endif

</div>{{-- /tab-config --}}

{{-- ══════════ TAB: REFERENCIA ══════════ --}}
<div class="rp-pane" id="rp-tab-resumen">

    {{-- Cards resumen compactas --}}
    <div class="rp-roles-grid">
        <div class="rp-role-sm">
            <div class="rp-role-sm-head sa">
                <i class="fas fa-user-shield"></i> Super Administrador
            </div>
            <div class="rp-role-sm-body">
                @foreach(['Acceso completo al sistema','Gestionar administradores','Asignar y modificar permisos','Configuración del sistema','Periodos académicos y cupos','Todas las estadísticas y reportes'] as $c)
                <div class="rp-role-row">
                    <i class="fas fa-check ok"></i> {{ $c }}
                </div>
                @endforeach
            </div>
        </div>
        <div class="rp-role-sm">
            <div class="rp-role-sm-head ad">
                <i class="fas fa-user-tie"></i> Administrador
            </div>
            <div class="rp-role-sm-body">
                <div class="rp-role-row"><i class="fas fa-check ok"></i> Acceso según permisos asignados</div>
                <div class="rp-role-row"><i class="fas fa-check ok"></i> Cambiar su propia contraseña</div>
                <div class="rp-role-row"><i class="fas fa-times no"></i> Gestionar otros administradores</div>
                <div class="rp-role-row"><i class="fas fa-times no"></i> Configuración del sistema</div>
                <div class="rp-role-row"><i class="fas fa-times no"></i> Modificar roles y permisos</div>
            </div>
        </div>
    </div>

    {{-- Tabla comparativa --}}
    <div class="rp-card overflow-hidden">
        <div class="px-3 py-2 border-bottom" style="background:#fafafa">
            <span class="fw-bold small" style="color:#003b73">Tabla comparativa de permisos</span>
        </div>
        <div class="table-responsive">
            <table class="rp-table">
                <thead>
                    <tr>
                        <th style="width:55%">Módulo / Función</th>
                        <th>Super Admin</th>
                        <th>Admin</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Dashboard</td>
                        <td><i class="fas fa-check ico-ok"></i></td>
                        <td><i class="fas fa-check ico-ok"></i></td>
                    </tr>
                    <tr class="denied">
                        <td>Gestionar Administradores</td>
                        <td><i class="fas fa-check ico-ok"></i></td>
                        <td><i class="fas fa-times ico-no"></i></td>
                    </tr>
                    @foreach($permisosDisponibles as $key => $nombre)
                    <tr>
                        <td>{{ $nombre }}</td>
                        <td><i class="fas fa-check ico-ok"></i></td>
                        <td><span class="rp-badge-cfg">Configurable</span></td>
                    </tr>
                    @endforeach
                    <tr class="denied">
                        <td>Configuración del Sistema</td>
                        <td><i class="fas fa-check ico-ok"></i></td>
                        <td><i class="fas fa-times ico-no"></i></td>
                    </tr>
                    <tr>
                        <td>Cambiar contraseña propia</td>
                        <td><i class="fas fa-check ico-ok"></i></td>
                        <td><i class="fas fa-check ico-ok"></i></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>{{-- /tab-resumen --}}

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Tabs ── */
    document.querySelectorAll('.rp-tab').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.rp-tab').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.rp-pane').forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('rp-tab-' + this.dataset.tab).classList.add('active');
        });
    });

    /* ── Refs ── */
    const userItems    = document.querySelectorAll('.rp-user-item');
    const rpEmpty      = document.getElementById('rpEmpty');
    const rpActive     = document.getElementById('rpActive');
    const rpAvatar     = document.getElementById('rpPanelAvatar');
    const rpName       = document.getElementById('rpPanelName');
    const rpEmail      = document.getElementById('rpPanelEmail');
    const rpBadge      = document.getElementById('rpPanelBadge');
    const rpAdminId    = document.getElementById('rpAdminId');
    const rpPerms      = document.getElementById('rpPermsSection');
    const rpSAAlert    = document.getElementById('rpSAAlert');
    const checkboxes   = document.querySelectorAll('.rp-perm-cb');
    const permItems    = document.querySelectorAll('.rp-perm-item');
    const rpSearch     = document.getElementById('rpSearch');
    const rpNoResults  = document.getElementById('rpNoResults');

    /* ── Actualizar UI según rol ── */
    function updateRolUI(isSA) {
        rpPerms.classList.toggle('d-none', isSA);
        rpSAAlert.classList.toggle('d-none', !isSA);
        checkboxes.forEach(cb => cb.disabled = isSA);
        rpBadge.textContent = isSA ? 'Super Admin' : 'Admin';
        rpBadge.classList.toggle('sa', isSA);
        rpBadge.classList.toggle('ad', !isSA);
    }

    /* ── Sync visual checkboxes ── */
    function syncPerms() {
        permItems.forEach(item => {
            const cb = item.querySelector('input');
            item.classList.toggle('on', cb && cb.checked);
        });
    }

    /* ── Seleccionar usuario ── */
    function selectUser(item) {
        userItems.forEach(u => u.classList.remove('active'));
        item.classList.add('active');

        const permisos = JSON.parse(item.dataset.permisos || '[]');
        const isSA     = item.dataset.issa === '1';

        rpAdminId.value        = item.dataset.id;
        rpAvatar.textContent   = item.dataset.initial;
        rpAvatar.style.background = item.dataset.color;
        rpName.textContent     = item.dataset.name;
        rpEmail.textContent    = item.dataset.email;

        checkboxes.forEach(cb => { cb.checked = permisos.includes(cb.value); });

        updateRolUI(isSA);
        syncPerms();

        rpEmpty.classList.add('d-none');
        rpActive.classList.remove('d-none');
    }

    userItems.forEach(item => item.addEventListener('click', () => selectUser(item)));

    /* Pre-cargar si hay old() */
    const oldId = rpAdminId && rpAdminId.value;
    if (oldId) {
        const pre = document.querySelector(`.rp-user-item[data-id="${oldId}"]`);
        if (pre) selectUser(pre);
    }

    /* ── Checkboxes ── */
    checkboxes.forEach(cb => cb.addEventListener('change', syncPerms));

    document.getElementById('rpBtnAll')?.addEventListener('click', () => {
        checkboxes.forEach(cb => { if (!cb.disabled) cb.checked = true; });
        syncPerms();
    });
    document.getElementById('rpBtnNone')?.addEventListener('click', () => {
        checkboxes.forEach(cb => { cb.checked = false; });
        syncPerms();
    });

    /* ── Cancelar ── */
    document.getElementById('rpBtnCancel')?.addEventListener('click', () => {
        userItems.forEach(u => u.classList.remove('active'));
        rpAdminId.value = '';
        rpEmpty.classList.remove('d-none');
        rpActive.classList.add('d-none');
    });

    /* ── Buscador ── */
    rpSearch?.addEventListener('input', function () {
        const q = this.value.toLowerCase();
        let vis = 0;
        userItems.forEach(item => {
            const match = item.dataset.name.toLowerCase().includes(q) ||
                          item.dataset.email.toLowerCase().includes(q);
            item.style.display = match ? '' : 'none';
            if (match) vis++;
        });
        rpNoResults.style.display = vis === 0 ? 'block' : 'none';
    });

});
</script>
@endpush