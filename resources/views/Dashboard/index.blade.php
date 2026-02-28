@extends('layouts.app')

@section('title', 'Roles y Permisos')
@section('page-title', 'Gestión de Permisos y Roles')
@section('page-subtitle', 'Configura el acceso de los administradores del sistema')

@push('styles')
<style>
    /* ── Reset base ── */
    *, *::before, *::after { box-sizing: border-box; }

    /* ── Variables ── */
    :root {
        --border:    #e5e7eb;
        --bg:        #f9fafb;
        --surface:   #ffffff;
        --text:      #111827;
        --muted:     #6b7280;
        --primary:   #1e5fa8;   /* azul del sistema */
        --primary-l: #eff6ff;
        --danger:    #dc2626;
        --danger-l:  #fef2f2;
        --success:   #16a34a;
        --radius:    10px;
        --shadow:    0 1px 3px rgba(0,0,0,.07), 0 2px 8px rgba(0,0,0,.04);
    }

    /* ── Layout principal ── */
    .rp-layout {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 20px;
        align-items: start;
    }
    @media (max-width: 860px) { .rp-layout { grid-template-columns: 1fr; } }

    /* ══════════════════════════════
       SIDEBAR
    ══════════════════════════════ */
    .sidebar {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow);
        position: sticky;
        top: 20px;
    }

    .sidebar-title {
        padding: 14px 16px 10px;
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--muted);
        border-bottom: 1px solid var(--border);
    }

    /* Buscador */
    .search-wrap {
        padding: 10px 12px;
        border-bottom: 1px solid var(--border);
    }
    .search-wrap input {
        width: 100%;
        padding: 7px 10px 7px 32px;
        font-size: .82rem;
        border: 1px solid var(--border);
        border-radius: 7px;
        outline: none;
        color: var(--text);
        background: var(--bg) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' fill='none' stroke='%236b7280' stroke-width='2' viewBox='0 0 24 24'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='M21 21l-4.35-4.35'/%3E%3C/svg%3E") no-repeat 10px center;
        transition: border-color .2s, box-shadow .2s;
    }
    .search-wrap input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(30,95,168,.12);
        background-color: #fff;
    }

    /* Lista de usuarios */
    .user-list { max-height: 380px; overflow-y: auto; }
    .user-list::-webkit-scrollbar { width: 3px; }
    .user-list::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }

    .user-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 14px;
        cursor: pointer;
        border-left: 3px solid transparent;
        transition: background .15s, border-color .15s;
    }
    .user-item:hover  { background: #f3f4f6; }
    .user-item.active { background: var(--primary-l); border-left-color: var(--primary); }

    .u-avatar {
        width: 32px; height: 32px;
        border-radius: 50%;
        font-size: .75rem; font-weight: 700;
        color: #fff;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    .u-info { overflow: hidden; flex: 1; }
    .u-info strong {
        display: block;
        font-size: .82rem; font-weight: 600;
        color: var(--text);
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .u-info span {
        font-size: .72rem; color: var(--muted);
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        display: block;
    }

    .rbadge {
        flex-shrink: 0;
        font-size: .62rem; font-weight: 700;
        padding: 2px 7px; border-radius: 20px;
    }
    .rbadge.sa { background: var(--danger-l); color: var(--danger); }
    .rbadge.ad { background: var(--primary-l); color: var(--primary); }

    .no-results {
        padding: 24px; text-align: center;
        font-size: .82rem; color: var(--muted);
        display: none;
    }

    /* ══════════════════════════════
       PANEL DERECHO
    ══════════════════════════════ */
    .main-panel {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    /* Estado vacío */
    .state-empty {
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        min-height: 400px; padding: 48px 32px;
        text-align: center; color: var(--muted);
    }
    .state-empty .icon-wrap {
        width: 56px; height: 56px; border-radius: 14px;
        background: var(--bg); border: 1px solid var(--border);
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 16px;
    }
    .state-empty .icon-wrap svg { width: 26px; height: 26px; color: #9ca3af; }
    .state-empty h3 { font-size: .95rem; font-weight: 600; color: #374151; margin: 0 0 6px; }
    .state-empty p  { font-size: .82rem; margin: 0; line-height: 1.6; }

    /* Panel activo */
    .panel-head {
        display: flex; align-items: center; justify-content: space-between;
        padding: 16px 20px;
        border-bottom: 1px solid var(--border);
        background: var(--bg);
    }
    .panel-user-info { display: flex; align-items: center; gap: 12px; }
    .panel-user-info .u-avatar { width: 40px; height: 40px; font-size: .85rem; }
    .panel-user-info .name  { font-size: .92rem; font-weight: 700; color: var(--text); }
    .panel-user-info .email { font-size: .76rem; color: var(--muted); }

    .panel-body { padding: 20px; display: flex; flex-direction: column; gap: 20px; }

    /* ── Sección label ── */
    .sec-label {
        font-size: .68rem; font-weight: 700; letter-spacing: .09em;
        text-transform: uppercase; color: var(--muted);
        display: flex; align-items: center; gap: 8px;
        margin-bottom: 10px;
    }
    .sec-label::after { content: ''; flex: 1; height: 1px; background: var(--border); }

    /* ── Rol selector ── */
    .rol-options { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    @media (max-width: 560px) { .rol-options { grid-template-columns: 1fr; } }

    .rol-opt {
        position: relative;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        padding: 12px 14px;
        cursor: pointer;
        display: flex; align-items: center; gap: 10px;
        transition: border-color .2s, background .2s;
    }
    .rol-opt:hover { border-color: #93c5fd; }
    .rol-opt.sel-admin { border-color: var(--primary); background: var(--primary-l); }
    .rol-opt.sel-sa    { border-color: var(--danger);  background: var(--danger-l);  }
    .rol-opt input     { position: absolute; opacity: 0; pointer-events: none; }

    .rol-icon {
        width: 32px; height: 32px; border-radius: 7px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .rol-icon.admin { background: #dbeafe; color: var(--primary); }
    .rol-icon.sa    { background: #fee2e2; color: var(--danger); }
    .rol-icon svg   { width: 16px; height: 16px; }

    .rol-text h4 { font-size: .83rem; font-weight: 700; color: var(--text); margin: 0 0 2px; }
    .rol-text p  { font-size: .72rem; color: var(--muted); margin: 0; line-height: 1.4; }

    .rol-check {
        margin-left: auto; flex-shrink: 0;
        width: 16px; height: 16px; border-radius: 50%;
        border: 1.5px solid var(--border); background: #fff;
        display: flex; align-items: center; justify-content: center;
        transition: all .2s;
    }
    .rol-opt.sel-admin .rol-check { border-color: var(--primary); background: var(--primary); }
    .rol-opt.sel-sa    .rol-check { border-color: var(--danger);  background: var(--danger); }
    .rol-check svg { width: 9px; height: 9px; color: #fff; opacity: 0; }
    .rol-opt.sel-admin .rol-check svg,
    .rol-opt.sel-sa    .rol-check svg { opacity: 1; }

    /* ── Permisos ── */
    .perms-section { animation: fadeUp .2s ease; }
    @keyframes fadeUp { from { opacity:0; transform:translateY(5px); } to { opacity:1; transform:translateY(0); } }

    .perms-head {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 10px;
    }
    .perms-actions { display: flex; gap: 10px; }
    .link-btn {
        font-size: .75rem; font-weight: 500; color: var(--primary);
        background: none; border: none; cursor: pointer; padding: 0;
        transition: opacity .15s;
    }
    .link-btn:hover  { opacity: .7; }
    .link-btn.red    { color: var(--danger); }

    .perms-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(175px, 1fr));
        gap: 7px;
    }

    .perm-item {
        display: flex; align-items: center; gap: 8px;
        padding: 9px 11px;
        border: 1px solid var(--border); border-radius: 7px;
        cursor: pointer; user-select: none;
        transition: border-color .15s, background .15s;
        font-size: .8rem; color: var(--text); font-weight: 500;
    }
    .perm-item:hover  { border-color: #93c5fd; background: #f0f7ff; }
    .perm-item.on     { border-color: var(--primary); background: var(--primary-l); }
    .perm-item input  { width: 14px; height: 14px; accent-color: var(--primary); flex-shrink: 0; cursor: pointer; }

    /* ── Aviso SA ── */
    .sa-alert {
        display: flex; gap: 10px;
        padding: 11px 14px;
        background: #fffbeb; border: 1px solid #fde68a;
        border-radius: 8px; font-size: .8rem; color: #92400e; line-height: 1.5;
    }
    .sa-alert svg { width: 18px; height: 18px; color: #f59e0b; flex-shrink: 0; margin-top: 1px; }

    /* ── Resumen roles (compacto) ── */
    .roles-summary {
        display: grid; grid-template-columns: 1fr 1fr; gap: 10px;
        margin-bottom: 0;
    }
    @media (max-width: 600px) { .roles-summary { grid-template-columns: 1fr; } }

    .role-card-sm {
        border: 1px solid var(--border); border-radius: 9px;
        overflow: hidden;
    }
    .role-card-sm .rcs-head {
        display: flex; align-items: center; gap: 8px;
        padding: 10px 14px;
        font-size: .8rem; font-weight: 700; color: #fff;
    }
    .rcs-head.sa-head { background: linear-gradient(90deg, #dc2626, #f97316); }
    .rcs-head.ad-head { background: linear-gradient(90deg, #1e5fa8, #0ea5e9); }
    .rcs-head svg { width: 16px; height: 16px; }
    .role-card-sm .rcs-body {
        padding: 10px 14px; background: var(--surface);
    }
    .rcs-item {
        display: flex; align-items: center; gap: 6px;
        font-size: .77rem; color: #374151;
        padding: 3px 0;
    }
    .rcs-item svg.ok  { width: 13px; height: 13px; color: var(--success); flex-shrink: 0; }
    .rcs-item svg.no  { width: 13px; height: 13px; color: #d1d5db; flex-shrink: 0; }

    /* ── Tabla comparativa compacta ── */
    .cmp-table { width: 100%; border-collapse: collapse; font-size: .8rem; }
    .cmp-table th {
        padding: 8px 14px; text-align: left;
        font-size: .68rem; font-weight: 700; letter-spacing: .07em;
        text-transform: uppercase; color: var(--muted);
        background: var(--bg); border-bottom: 2px solid var(--border);
    }
    .cmp-table th:not(:first-child) { text-align: center; }
    .cmp-table td { padding: 9px 14px; border-bottom: 1px solid var(--border); color: var(--text); }
    .cmp-table td:not(:first-child) { text-align: center; }
    .cmp-table tr:last-child td { border-bottom: none; }
    .cmp-table tr:hover td { background: #f9fafb; }
    .cmp-table tr.denied td { background: #fef9f9; }
    .ic-ok { width: 16px; height: 16px; color: var(--success); margin: 0 auto; }
    .ic-no { width: 16px; height: 16px; color: #d1d5db; margin: 0 auto; }
    .badge-cfg {
        display: inline-flex; padding: 1px 8px; border-radius: 20px;
        background: var(--primary-l); color: var(--primary);
        font-size: .68rem; font-weight: 700;
    }

    /* ── Tabs ── */
    .tab-bar {
        display: flex; gap: 3px;
        background: #f3f4f6; padding: 3px;
        border-radius: 9px; width: fit-content;
        margin-bottom: 18px;
    }
    .tab-btn {
        padding: 6px 18px; border-radius: 7px;
        font-size: .82rem; font-weight: 600;
        color: var(--muted); cursor: pointer;
        border: none; background: none;
        transition: all .2s;
    }
    .tab-btn.active {
        background: #fff; color: var(--primary);
        box-shadow: 0 1px 4px rgba(0,0,0,.09);
    }
    .tab-pane { display: none; }
    .tab-pane.active { display: block; animation: fadeUp .2s ease; }

    /* ── Alertas ── */
    .flash-ok {
        display: flex; align-items: center; gap: 8px;
        padding: 10px 14px; border-radius: 8px;
        background: #f0fdf4; border: 1px solid #bbf7d0;
        color: #15803d; font-size: .83rem; font-weight: 500;
        margin-bottom: 16px;
    }
    .flash-err {
        display: flex; align-items: center; gap: 8px;
        padding: 10px 14px; border-radius: 8px;
        background: var(--danger-l); border: 1px solid #fecaca;
        color: var(--danger); font-size: .83rem; font-weight: 500;
        margin-bottom: 16px;
    }
    .flash-ok svg, .flash-err svg { width: 16px; height: 16px; flex-shrink: 0; }

    /* ── Footer form ── */
    .form-footer {
        display: flex; align-items: center; justify-content: flex-end; gap: 8px;
        padding: 12px 20px; border-top: 1px solid var(--border);
        background: var(--bg);
    }
    .btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 18px; border-radius: 8px;
        font-size: .82rem; font-weight: 600;
        cursor: pointer; border: none;
        transition: all .2s;
    }
    .btn svg { width: 14px; height: 14px; }
    .btn-ghost {
        background: transparent; color: var(--muted);
        border: 1px solid var(--border);
    }
    .btn-ghost:hover { background: #f3f4f6; }
    .btn-primary {
        background: var(--primary); color: #fff;
        box-shadow: 0 2px 6px rgba(30,95,168,.25);
    }
    .btn-primary:hover  { background: #1a4f8a; box-shadow: 0 4px 12px rgba(30,95,168,.3); transform: translateY(-1px); }
    .btn-primary:active { transform: translateY(0); }
</style>
@endpush

@section('content')
<div class="p-6 space-y-5">

    {{-- ─── Header ─── --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-900">Permisos y Roles</h1>
            <p class="text-sm text-gray-500 mt-0.5">Gestiona el nivel de acceso de cada administrador</p>
        </div>
        <a href="{{ route('admins.index') }}" class="btn btn-ghost text-sm">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Administradores
        </a>
    </div>

    {{-- ─── Tabs ─── --}}
    <div class="tab-bar">
        <button class="tab-btn active" data-tab="config">Configurar permisos</button>
        <button class="tab-btn" data-tab="resumen">Resumen de roles</button>
    </div>

    <!-- Cards de Roles -->
    <div class="row g-4 mb-4">

        <!-- SUPER ADMIN -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border: 2px solid #fca5a5 !important; overflow: hidden;">
                <div class="card-header border-0 py-4 px-4" style="background: linear-gradient(135deg, #ef4444 0%, #f97316 100%);">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width: 50px; height: 50px; background: white; border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                                <i class="fas fa-user-shield" style="font-size: 1.4rem; color: #ef4444;"></i>
                            </div>
                            <div>
                                <h5 class="text-white fw-bold mb-0">Super Administrador</h5>
                                <small class="text-white" style="opacity: 0.85;">Acceso Total al Sistema</small>
                            </div>
                        </div>
                        <span class="badge bg-white text-danger fw-bold">MÁXIMO</span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Capacidades -->
                    <div class="card border-0 mb-3" style="background: #f9fafb; border-radius: 10px;">
                        <div class="card-body p-3">
                            <h6 class="fw-bold mb-3" style="color: #003b73;">
                                <i class="fas fa-bolt me-2 text-warning"></i>Capacidades Especiales
                            </h6>
                            <ul class="list-unstyled mb-0">
                                <li class="d-flex align-items-start gap-2 mb-2">
                                    <i class="fas fa-check-circle text-success mt-1 flex-shrink-0"></i>
                                    <span class="text-muted" style="font-size: 0.9rem;">Acceso completo a <strong>todas las funciones</strong> del sistema</span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-2">
                                    <i class="fas fa-check-circle text-success mt-1 flex-shrink-0"></i>
                                    <span class="text-muted" style="font-size: 0.9rem;">Puede <strong>crear, editar y eliminar administradores</strong></span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-2">
                                    <i class="fas fa-check-circle text-success mt-1 flex-shrink-0"></i>
                                    <span class="text-muted" style="font-size: 0.9rem;">Asigna y modifica <strong>permisos de otros usuarios</strong></span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-2">
                                    <i class="fas fa-check-circle text-success mt-1 flex-shrink-0"></i>
                                    <span class="text-muted" style="font-size: 0.9rem;">Acceso a <strong>configuración del sistema</strong></span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-2">
                                    <i class="fas fa-check-circle text-success mt-1 flex-shrink-0"></i>
                                    <span class="text-muted" style="font-size: 0.9rem;">Gestiona <strong>periodos académicos y cupos</strong></span>
                                </li>
                                <li class="d-flex align-items-start gap-2 mb-0">
                                    <i class="fas fa-check-circle text-success mt-1 flex-shrink-0"></i>
                                    <span class="text-muted" style="font-size: 0.9rem;">Visualiza <strong>todas las estadísticas y reportes</strong></span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Aviso -->
                    <div class="alert alert-danger border-0 mb-0" style="background: rgba(239,68,68,0.08); border-left: 4px solid #ef4444 !important; border-radius: 8px;">
                        <div class="d-flex align-items-start gap-2">
                            <i class="fas fa-exclamation-triangle text-danger mt-1 flex-shrink-0"></i>
                            <div>
                                <p class="fw-semibold text-danger mb-1" style="font-size: 0.85rem;">Importante</p>
                                <p class="text-danger mb-0" style="font-size: 0.8rem; opacity: 0.85;">Este rol debe ser asignado solo a usuarios de máxima confianza ya que tiene control total sobre el sistema.</p>
                            </div>
                        </div>

                        {{-- Body --}}
                        <div class="panel-body">

                            {{-- Rol --}}
                            <div>
                                <div class="sec-label">Rol</div>
                                <div class="rol-options">

                                    <label class="rol-opt" id="optAdmin">
                                        <input type="radio" name="rol" value="admin" id="rolAdmin">
                                        <div class="rol-icon admin">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        </div>
                                        <div class="rol-text">
                                            <h4>Administrador</h4>
                                            <p>Permisos personalizables</p>
                                        </div>
                                        <div class="rol-check">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                    </label>

                                    <label class="rol-opt" id="optSA">
                                        <input type="radio" name="rol" value="super_admin" id="rolSA">
                                        <div class="rol-icon sa">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                        </div>
                                        <div class="rol-text">
                                            <h4>Super Admin</h4>
                                            <p>Acceso total al sistema</p>
                                        </div>
                                        <div class="rol-check">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                    </label>

                                </div>
                            </div>

                            {{-- Permisos --}}
                            <div class="perms-section hidden" id="permsSection">
                                <div class="perms-head">
                                    <div class="sec-label" style="margin:0;flex:1">Permisos</div>
                                    <div class="perms-actions">
                                        <button type="button" class="link-btn" id="btnAll">Todos</button>
                                        <span style="color:#d1d5db">·</span>
                                        <button type="button" class="link-btn red" id="btnNone">Ninguno</button>
                                    </div>
                                </div>
                                <div class="perms-grid" style="margin-top:10px">
                                    @foreach($permisos as $key => $nombre)
                                    <label class="perm-item" id="w-{{ $key }}">
                                        <input type="checkbox" name="permisos[]" value="{{ $key }}"
                                               class="perm-cb" {{ in_array($key, old('permisos', [])) ? 'checked' : '' }}>
                                        {{ $nombre }}
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Aviso SA --}}
                            <div class="sa-alert hidden" id="saAlert">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                <span>Este usuario tendrá <strong>control total</strong> sobre el sistema. Asegúrate de que sea de máxima confianza.</span>
                            </div>

                        </div>

                        {{-- Footer --}}
                        <div class="form-footer">
                            <button type="button" class="btn btn-ghost" id="btnCancel">Cancelar</button>
                            <button type="submit" class="btn btn-primary">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Guardar cambios
                            </button>
                        </div>

                    </div>{{-- /stateActive --}}
                </div>{{-- /main-panel --}}
            </div>{{-- /rp-layout --}}
        </form>

        @else
        <div class="main-panel">
            <div class="state-empty">
                <div class="icon-wrap">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <h3>Acceso restringido</h3>
                <p>Solo el Super Administrador puede gestionar<br>roles y permisos del sistema.</p>
            </div>
        </div>
        @endif

        <!-- ADMIN -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border: 2px solid #93c5fd !important; overflow: hidden;">
                <div class="card-header border-0 py-4 px-4" style="background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%);">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width: 50px; height: 50px; background: white; border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                                <i class="fas fa-user-cog" style="font-size: 1.4rem; color: #00508f;"></i>
                            </div>
                            <div>
                                <h5 class="text-white fw-bold mb-0">Administrador</h5>
                                <small class="text-white" style="opacity: 0.85;">Permisos Personalizables</small>
                            </div>
                        </div>
                        <span class="badge bg-white fw-bold" style="color: #00508f;">LIMITADO</span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Permisos disponibles -->
                    <div class="card border-0 mb-3" style="background: #f9fafb; border-radius: 10px;">
                        <div class="card-body p-3">
                            <h6 class="fw-bold mb-1" style="color: #003b73;">
                                <i class="fas fa-clipboard-list me-2" style="color: #4ec7d2;"></i>Permisos Disponibles
                            </h6>
                            <p class="text-muted mb-3" style="font-size: 0.8rem;">El Super Admin puede asignar los siguientes permisos:</p>
                            <div class="d-flex flex-column gap-2">
                                @foreach($permisos as $key => $nombre)
                                <div class="d-flex align-items-center gap-2 p-2 rounded" style="background: white; border: 1px solid #e2e8f0;">
                                    <i class="fas fa-check-circle text-success flex-shrink-0"></i>
                                    <span style="font-size: 0.875rem; color: #374151;">{{ $nombre }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Restricciones -->
                    <div class="alert alert-warning border-0 mb-0" style="background: rgba(245,158,11,0.08); border-left: 4px solid #f59e0b !important; border-radius: 8px;">
                        <div class="d-flex align-items-start gap-2">
                            <i class="fas fa-info-circle text-warning mt-1 flex-shrink-0"></i>
                            <div>
                                <p class="fw-semibold text-warning mb-1" style="font-size: 0.85rem;">Restricciones</p>
                                <ul class="mb-0 ps-3" style="font-size: 0.8rem; color: #92400e;">
                                    <li>No puede gestionar otros administradores</li>
                                    <li>No tiene acceso a configuración del sistema</li>
                                    <li>Solo puede realizar acciones según permisos asignados</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabla comparativa compacta --}}
        <div class="main-panel overflow-hidden">
            <div style="padding:14px 18px;border-bottom:1px solid var(--border);background:var(--bg)">
                <span style="font-size:.8rem;font-weight:700;color:var(--text)">Tabla comparativa de permisos</span>
            </div>
            <div class="overflow-x-auto">
                <table class="cmp-table">
                    <thead>
                        <tr>
                            <th>Módulo</th>
                            <th>Super Admin</th>
                            <th>Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Dashboard</td>
                            <td><svg class="ic-ok" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td>
                            <td><svg class="ic-ok" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td>
                        </tr>
                        <tr class="denied">
                            <td>Gestionar Administradores</td>
                            <td><svg class="ic-ok" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td>
                            <td><svg class="ic-no" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></td>
                        </tr>
                        @foreach($permisos as $key => $nombre)
                        <tr>
                            <td>{{ $nombre }}</td>
                            <td><svg class="ic-ok" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td>
                            <td><span class="badge-cfg">Configurable</span></td>
                        </tr>
                        @endforeach
                        <tr class="denied">
                            <td>Configuración del Sistema</td>
                            <td><svg class="ic-ok" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td>
                            <td><svg class="ic-no" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></td>
                        </tr>
                        <tr>
                            <td>Cambiar contraseña propia</td>
                            <td><svg class="ic-ok" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td>
                            <td><svg class="ic-ok" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">Módulo / Función</th>
                            <th class="text-center px-4 py-3">Super Admin</th>
                            <th class="text-center px-4 py-3">Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dashboard -->
                        <tr>
                            <td class="px-4 py-3 fw-semibold">Dashboard</td>
                            <td class="text-center"><i class="fas fa-check-circle text-success fs-5"></i></td>
                            <td class="text-center"><i class="fas fa-check-circle text-success fs-5"></i></td>
                        </tr>

                        <!-- Gestionar Administradores -->
                        <tr style="background: rgba(239,68,68,0.04);">
                            <td class="px-4 py-3 fw-semibold">Gestionar Administradores</td>
                            <td class="text-center"><i class="fas fa-check-circle text-success fs-5"></i></td>
                            <td class="text-center"><i class="fas fa-times-circle text-danger fs-5"></i></td>
                        </tr>

                        @foreach($permisos as $key => $nombre)
                        <tr>
                            <td class="px-4 py-3 fw-semibold">{{ $nombre }}</td>
                            <td class="text-center"><i class="fas fa-check-circle text-success fs-5"></i></td>
                            <td class="text-center">
                                <span class="badge" style="background: rgba(0,80,143,0.1); color: #00508f; font-size: 0.75rem;">Configurable</span>
                            </td>
                        </tr>
                        @endforeach

                        <!-- Configuración del Sistema -->
                        <tr style="background: rgba(239,68,68,0.04);">
                            <td class="px-4 py-3 fw-semibold">Configuración del Sistema</td>
                            <td class="text-center"><i class="fas fa-check-circle text-success fs-5"></i></td>
                            <td class="text-center"><i class="fas fa-times-circle text-danger fs-5"></i></td>
                        </tr>

                        <!-- Cambiar Contraseña -->
                        <tr>
                            <td class="px-4 py-3 fw-semibold">Cambiar Contraseña (propia)</td>
                            <td class="text-center"><i class="fas fa-check-circle text-success fs-5"></i></td>
                            <td class="text-center"><i class="fas fa-check-circle text-success fs-5"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Botón volver -->
    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('admins.index') }}" class="btn btn-primary px-4 py-2" style="border-radius: 8px;">
            <i class="fas fa-users me-2"></i>Gestionar Administradores
        </a>
    </div>

</div>
@endsection
