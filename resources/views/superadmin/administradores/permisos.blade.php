@extends('layouts.app')

<<<<<<< HEAD
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
    
=======
@section('title', 'Permisos y Roles')
@section('page-title', 'Gestión de Permisos y Roles')

@section('topbar-actions')
    <a href="{{ route('superadmin.administradores.index') }}"
       style="background: white; color: #00508f; padding: 0.5rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid #4ec7d2; font-size: 0.9rem;">
        <i class="fas fa-arrow-left"></i>
        Volver a Administradores
    </a>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header con descripción -->
    <div class="card mb-4 border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body p-4">
            <div class="d-flex align-items-start gap-3">
                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(78, 199, 210, 0.3);">
                    <i class="fas fa-shield-alt" style="color: white; font-size: 1.5rem;"></i>
                </div>
                <div class="flex-grow-1">
                    <h4 class="fw-bold mb-2" style="color: #003b73;">Sistema de Permisos y Roles</h4>
                    <p class="mb-0" style="color: #64748b; font-size: 0.938rem;">
                        Este sistema utiliza un modelo de permisos basado en roles. Cada usuario tiene asignado un rol que determina sus capacidades dentro del sistema.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards de Roles -->
    <div class="row g-4 mb-4">
        <!-- SUPER ADMIN -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #ef4444 !important;">
                <!-- Header -->
                <div class="card-header text-white" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); border-radius: 12px 12px 0 0; padding: 1.25rem 1.5rem;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-white rounded-3 p-2" style="box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                                <i class="fas fa-crown" style="color: #ef4444; font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">Super Administrador</h5>
                                <small class="opacity-90">Acceso Total al Sistema</small>
                            </div>
                        </div>
                        <span class="badge bg-white fw-bold" style="color: #ef4444; padding: 0.5rem 0.875rem; border-radius: 8px; font-size: 0.75rem; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);">MÁXIMO</span>
                    </div>
                </div>

                <!-- Body -->
                <div class="card-body p-4">
                    <div class="mb-3">
                        <h6 class="fw-bold mb-3" style="color: #ef4444;">
                            <i class="fas fa-bolt me-2"></i>Capacidades Especiales
                        </h6>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2 d-flex align-items-start gap-2">
                                <i class="fas fa-check-circle mt-1" style="color: #10b981; font-size: 0.938rem;"></i>
                                <span style="color: #64748b; font-size: 0.875rem;">Acceso completo a <strong style="color: #1e293b;">todas las funciones</strong></span>
                            </li>
                            <li class="mb-2 d-flex align-items-start gap-2">
                                <i class="fas fa-check-circle mt-1" style="color: #10b981; font-size: 0.938rem;"></i>
                                <span style="color: #64748b; font-size: 0.875rem;">Puede <strong style="color: #1e293b;">crear, editar y eliminar administradores</strong></span>
                            </li>
                            <li class="mb-2 d-flex align-items-start gap-2">
                                <i class="fas fa-check-circle mt-1" style="color: #10b981; font-size: 0.938rem;"></i>
                                <span style="color: #64748b; font-size: 0.875rem;">Asigna y modifica <strong style="color: #1e293b;">permisos de otros usuarios</strong></span>
                            </li>
                            <li class="mb-2 d-flex align-items-start gap-2">
                                <i class="fas fa-check-circle mt-1" style="color: #10b981; font-size: 0.938rem;"></i>
                                <span style="color: #64748b; font-size: 0.875rem;">Acceso a <strong style="color: #1e293b;">configuración del sistema</strong></span>
                            </li>
                            <li class="mb-2 d-flex align-items-start gap-2">
                                <i class="fas fa-check-circle mt-1" style="color: #10b981; font-size: 0.938rem;"></i>
                                <span style="color: #64748b; font-size: 0.875rem;">Gestiona <strong style="color: #1e293b;">periodos académicos y cupos</strong></span>
                            </li>
                            <li class="mb-2 d-flex align-items-start gap-2">
                                <i class="fas fa-check-circle mt-1" style="color: #10b981; font-size: 0.938rem;"></i>
                                <span style="color: #64748b; font-size: 0.875rem;">Visualiza <strong style="color: #1e293b;">todas las estadísticas y reportes</strong></span>
                            </li>
                        </ul>
                    </div>

                    <div class="alert mb-0" style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(220, 38, 38, 0.1) 100%); border: 1px solid rgba(239, 68, 68, 0.2); border-radius: 10px;">
                        <div class="d-flex align-items-start gap-2">
                            <i class="fas fa-exclamation-triangle mt-1" style="color: #ef4444;"></i>
                            <div>
                                <strong class="d-block mb-1" style="color: #1e293b; font-size: 0.875rem;">Importante</strong>
                                <small style="color: #64748b;">Este rol debe ser asignado solo a usuarios de máxima confianza.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ADMIN -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #4ec7d2 !important;">
                <!-- Header -->
                <div class="card-header text-white" style="background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%); border-radius: 12px 12px 0 0; padding: 1.25rem 1.5rem;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-white rounded-3 p-2" style="box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                                <i class="fas fa-user-shield" style="color: #00508f; font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">Administrador</h5>
                                <small class="opacity-90">Permisos Personalizables</small>
                            </div>
                        </div>
                        <span class="badge bg-white fw-bold" style="color: #00508f; padding: 0.5rem 0.875rem; border-radius: 8px; font-size: 0.75rem; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);">LIMITADO</span>
                    </div>
                </div>

                <!-- Body -->
                <div class="card-body p-4">
                    <div class="mb-3">
                        <h6 class="fw-bold mb-3" style="color: #00508f;">
                            <i class="fas fa-list-check me-2"></i>Permisos Disponibles
                        </h6>
                        <p class="mb-3" style="color: #64748b; font-size: 0.875rem;">El Super Admin puede asignar los siguientes permisos:</p>
                        <div class="d-flex flex-column gap-2" style="max-height: 300px; overflow-y: auto;">
                            @foreach($permisos as $key => $nombre)
                            <div class="d-flex align-items-center gap-2 p-2 rounded" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
                                <i class="fas fa-check-circle" style="color: #10b981; font-size: 0.875rem;"></i>
                                <span style="color: #1e293b; font-size: 0.875rem; font-weight: 500;">{{ $nombre }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="alert mb-0" style="background: linear-gradient(135deg, rgba(251, 191, 36, 0.1) 0%, rgba(245, 158, 11, 0.1) 100%); border: 1px solid rgba(251, 191, 36, 0.2); border-radius: 10px;">
                        <div class="d-flex align-items-start gap-2">
                            <i class="fas fa-info-circle mt-1" style="color: #f59e0b;"></i>
                            <div>
                                <strong class="d-block mb-1" style="color: #1e293b; font-size: 0.875rem;">Restricciones</strong>
                                <ul class="mb-0 ps-3" style="font-size: 0.813rem; color: #64748b;">
                                    <li>No puede gestionar otros administradores</li>
                                    <li>No tiene acceso a configuración del sistema</li>
                                    <li>Solo acciones según permisos asignados</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Lista de Usuarios con Permisos Configurables -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
        <div class="card-header text-white" style="background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%); border-radius: 12px 12px 0 0; padding: 1.25rem 1.5rem;">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-users-cog me-2"></i>Gestionar Permisos de Administradores
            </h5>
        </div>

        <div class="card-body p-4">
            <div class="mb-4">
                <p class="mb-3" style="color: #64748b;">
                    <i class="fas fa-info-circle me-2" style="color: #4ec7d2;"></i>
                    Selecciona un administrador para configurar sus permisos individuales
                </p>

                <!-- Filtros -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small" style="color: #003b73;">Buscar Usuario</label>
                        <input type="text"
                               class="form-control"
                               id="searchUser"
                               placeholder="Buscar por nombre o email..."
                               style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem; transition: all 0.3s ease;">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small" style="color: #003b73;">Filtrar por Rol</label>
                        <select class="form-select"
                                id="filterRole"
                                style="border: 2px solid #bfd9ea; border-radius: 8px; padding: 0.6rem 1rem; transition: all 0.3s ease;">
                            <option value="">Todos los roles</option>
                            <option value="admin">Administrador</option>
                            <option value="super_admin">Super Administrador</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small" style="color: #003b73;">Acciones</label>
                        <button type="button"
                                class="btn w-100"
                                onclick="limpiarFiltros()"
                                style="background: white; color: #00508f; border: 2px solid #4ec7d2; padding: 0.6rem 1rem; border-radius: 8px; font-weight: 600; transition: all 0.3s ease;">
                            <i class="fas fa-redo me-2"></i>Limpiar Filtros
                        </button>
                    </div>
                </div>
            </div>

            <!-- Lista de Usuarios -->
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="usersTable" style="border-collapse: separate; border-spacing: 0;">
                    <thead style="background: #f8fafc;">
                        <tr>
                            <th class="px-4 py-3" style="color: #003b73; font-weight: 700; font-size: 0.875rem; border: none;">
                                <i class="fas fa-user me-2" style="color: #4ec7d2;"></i>Usuario
                            </th>
                            <th class="px-4 py-3" style="color: #003b73; font-weight: 700; font-size: 0.875rem; border: none;">
                                <i class="fas fa-envelope me-2" style="color: #4ec7d2;"></i>Email
                            </th>
                            <th class="px-4 py-3 text-center" style="color: #003b73; font-weight: 700; font-size: 0.875rem; border: none;">
                                <i class="fas fa-shield-alt me-2" style="color: #4ec7d2;"></i>Rol
                            </th>
                            <th class="px-4 py-3 text-center" style="color: #003b73; font-weight: 700; font-size: 0.875rem; border: none;">
                                <i class="fas fa-check-circle me-2" style="color: #4ec7d2;"></i>Permisos
                            </th>
                            <th class="px-4 py-3 text-center" style="color: #003b73; font-weight: 700; font-size: 0.875rem; border: none;">
                                <i class="fas fa-cog me-2" style="color: #4ec7d2;"></i>Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $usuario)
                        <tr data-role="{{ $usuario->role }}" data-name="{{ strtolower($usuario->name) }}" data-email="{{ strtolower($usuario->email) }}" style="border-bottom: 1px solid #e2e8f0; transition: all 0.2s ease;">
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3);">
                                        <strong style="color: white; font-size: 1rem;">{{ substr($usuario->name, 0, 1) }}</strong>
                                    </div>
                                    <div>
                                        <strong class="d-block" style="color: #1e293b; font-size: 0.938rem;">{{ $usuario->name }}</strong>
                                        @if($usuario->is_protected)
                                        <span class="badge" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); font-size: 0.7rem; padding: 0.25rem 0.5rem; border-radius: 4px;">
                                            <i class="fas fa-lock me-1"></i>Protegido
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3" style="color: #64748b; font-size: 0.875rem;">
                                {{ $usuario->email }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($usuario->role === 'super_admin' || $usuario->is_super_admin)
                                    <span class="badge" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); padding: 0.5rem 0.875rem; border-radius: 8px; font-size: 0.813rem; font-weight: 600; box-shadow: 0 2px 6px rgba(239, 68, 68, 0.3);">
                                        <i class="fas fa-crown me-1"></i>Super Admin
                                    </span>
                                @elseif($usuario->role === 'admin')
                                    <span class="badge" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); padding: 0.5rem 0.875rem; border-radius: 8px; font-size: 0.813rem; font-weight: 600; box-shadow: 0 2px 6px rgba(78, 199, 210, 0.3);">
                                        <i class="fas fa-user-shield me-1"></i>Administrador
                                    </span>
                                @else
                                    <span class="badge" style="background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%); padding: 0.5rem 0.875rem; border-radius: 8px; font-size: 0.813rem; font-weight: 600; box-shadow: 0 2px 6px rgba(148, 163, 184, 0.3);">
                                        {{ ucfirst($usuario->role) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                @php
                                    $permisosActivos = is_array($usuario->permissions) ? count($usuario->permissions) : 0;
                                @endphp
                                @if($permisosActivos > 0)
    <span class="badge" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 0.5rem 0.875rem; border-radius: 8px; font-size: 0.813rem; font-weight: 600; box-shadow: 0 2px 6px rgba(16, 185, 129, 0.3);">
        {{ $permisosActivos }} / {{ count($permisos) }}
    </span>
@else
    <span class="badge" style="background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%); padding: 0.5rem 0.875rem; border-radius: 8px; font-size: 0.813rem; font-weight: 600; box-shadow: 0 2px 6px rgba(148, 163, 184, 0.3);">
        {{ $permisosActivos }} / {{ count($permisos) }}
    </span>
@endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if(!$usuario->is_super_admin && !$usuario->is_protected)
                                <button type="button"
                                        class="btn btn-sm"
                                        style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 2px 6px rgba(78, 199, 210, 0.3);"
                                        data-user-id="{{ $usuario->id }}"
                                        data-user-name="{{ $usuario->name }}"
                                        data-user-permissions='@json($usuario->permissions ?? [])'
                                        onclick="abrirModalPermisosData(this)">
                                    <i class="fas fa-edit me-1"></i>Configurar
                                </button>
                                @else
                                <span style="color: #94a3b8; font-size: 0.875rem; font-weight: 600;">
                                    <i class="fas fa-lock me-1"></i>No configurable
                                </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div style="padding: 3rem 1rem;">
                                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, rgba(78, 199, 210, 0.1) 0%, rgba(0, 80, 143, 0.1) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                                        <i class="fas fa-users-cog" style="font-size: 2rem; color: #4ec7d2;"></i>
                                    </div>
                                    <h6 style="color: #64748b; font-weight: 600; margin-bottom: 0.5rem;">No hay administradores registrados</h6>
                                    <p style="color: #94a3b8; font-size: 0.875rem; margin: 0;">Crea un administrador desde la sección de Administradores</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tabla Comparativa -->
    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-header text-white" style="background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%); border-radius: 12px 12px 0 0; padding: 1.25rem 1.5rem;">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-table me-2"></i>Tabla Comparativa de Permisos
            </h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="border-collapse: separate; border-spacing: 0;">
                    <thead style="background: #f8fafc;">
                        <tr>
                            <th class="px-4 py-3 fw-semibold" style="color: #003b73; font-size: 0.875rem; border: none;">Módulo / Función</th>
                            <th class="px-4 py-3 text-center fw-semibold" style="color: #003b73; font-size: 0.875rem; border: none;">Super Admin</th>
                            <th class="px-4 py-3 text-center fw-semibold" style="color: #003b73; font-size: 0.875rem; border: none;">Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dashboard -->
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <td class="px-4 py-3 fw-medium" style="color: #1e293b; font-size: 0.875rem;">Dashboard</td>
                            <td class="px-4 py-3 text-center">
                                <i class="fas fa-check-circle" style="color: #10b981; font-size: 1.25rem;"></i>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <i class="fas fa-check-circle" style="color: #10b981; font-size: 1.25rem;"></i>
                            </td>
                        </tr>

                        <!-- Gestionar Administradores -->
                        <tr style="background: rgba(239, 68, 68, 0.05); border-bottom: 1px solid #e2e8f0;">
                            <td class="px-4 py-3 fw-medium" style="color: #1e293b; font-size: 0.875rem;">Gestionar Administradores</td>
                            <td class="px-4 py-3 text-center">
                                <i class="fas fa-check-circle" style="color: #10b981; font-size: 1.25rem;"></i>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <i class="fas fa-times-circle" style="color: #ef4444; font-size: 1.25rem;"></i>
                            </td>
                        </tr>

                        @foreach($permisos as $key => $nombre)
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <td class="px-4 py-3 fw-medium" style="color: #1e293b; font-size: 0.875rem;">{{ $nombre }}</td>
                            <td class="px-4 py-3 text-center">
                                <i class="fas fa-check-circle" style="color: #10b981; font-size: 1.25rem;"></i>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="badge" style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); padding: 0.4rem 0.75rem; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">Configurable</span>
                            </td>
                        </tr>
                        @endforeach

                        <!-- Configuración del Sistema -->
                        <tr style="background: rgba(239, 68, 68, 0.05); border-bottom: 1px solid #e2e8f0;">
                            <td class="px-4 py-3 fw-medium" style="color: #1e293b; font-size: 0.875rem;">Configuración del Sistema</td>
                            <td class="px-4 py-3 text-center">
                                <i class="fas fa-check-circle" style="color: #10b981; font-size: 1.25rem;"></i>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <i class="fas fa-times-circle" style="color: #ef4444; font-size: 1.25rem;"></i>
                            </td>
                        </tr>

                        <!-- Cambiar Contraseña -->
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <td class="px-4 py-3 fw-medium" style="color: #1e293b; font-size: 0.875rem;">Cambiar Contraseña (propia)</td>
                            <td class="px-4 py-3 text-center">
                                <i class="fas fa-check-circle" style="color: #10b981; font-size: 1.25rem;"></i>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <i class="fas fa-check-circle" style="color: #10b981; font-size: 1.25rem;"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Modal de Configuración de Permisos -->
<div class="modal fade" id="modalPermisos" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #00508f 0%, #4ec7d2 100%); border-radius: 12px 12px 0 0; padding: 1.25rem 1.5rem;">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-shield-alt me-2"></i>
                    Configurar Permisos
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formPermisos" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="alert mb-4" style="background: linear-gradient(135deg, rgba(78, 199, 210, 0.1) 0%, rgba(0, 80, 143, 0.1) 100%); border: 1px solid rgba(78, 199, 210, 0.2); border-radius: 10px;">
                        <i class="fas fa-info-circle me-2" style="color: #4ec7d2;"></i>
                        Configurando permisos para: <strong id="nombreUsuario" style="color: #003b73;"></strong>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0 fw-bold" style="color: #003b73;">Permisos Disponibles</h6>
                            <div class="btn-group btn-group-sm">
                                <button type="button"
                                        class="btn"
                                        style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none; padding: 0.4rem 0.875rem; border-radius: 6px 0 0 6px; font-weight: 600; transition: all 0.3s ease;"
                                        onclick="seleccionarTodos()">
                                    <i class="fas fa-check-double me-1"></i>Todos
                                </button>
                                <button type="button"
                                        class="btn"
                                        style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border: none; padding: 0.4rem 0.875rem; border-radius: 0 6px 6px 0; font-weight: 600; transition: all 0.3s ease;"
                                        onclick="deseleccionarTodos()">
                                    <i class="fas fa-times me-1"></i>Ninguno
                                </button>
                            </div>
                        </div>

                        <div class="row g-3">
                            @foreach($permisos as $key => $nombre)
                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded hover-shadow" style="border: 2px solid #e2e8f0; border-radius: 10px; transition: all 0.3s ease;">
                                    <input class="form-check-input permiso-checkbox"
                                           type="checkbox"
                                           name="permisos[]"
                                           value="{{ $key }}"
                                           id="permiso_{{ $key }}"
                                           style="width: 40px; height: 20px; cursor: pointer;">
                                    <label class="form-check-label fw-medium ms-2" for="permiso_{{ $key }}" style="color: #1e293b; cursor: pointer;">
                                        {{ $nombre }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0;">
                    <button type="button"
                            class="btn"
                            style="background: white; color: #64748b; border: 2px solid #e2e8f0; padding: 0.6rem 1.2rem; border-radius: 8px; font-weight: 600; transition: all 0.3s ease;"
                            data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </button>
                    <button type="submit"
                            class="btn"
                            style="background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%); color: white; border: none; padding: 0.6rem 1.2rem; border-radius: 8px; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(78, 199, 210, 0.3);">
                        <i class="fas fa-save me-2"></i>Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .hover-shadow:hover {
        box-shadow: 0 4px 12px rgba(78, 199, 210, 0.2);
        background: linear-gradient(135deg, rgba(78, 199, 210, 0.05) 0%, rgba(0, 80, 143, 0.05) 100%);
        border-color: #4ec7d2 !important;
    }

    .form-check-input:checked {
        background-color: #4ec7d2;
        border-color: #4ec7d2;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #4ec7d2;
        box-shadow: 0 0 0 0.2rem rgba(78, 199, 210, 0.15);
    }

    .table tbody tr:hover {
        background-color: #f8fafc;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
    }
>>>>>>> cesia-dev
</style>
@endpush

@section('content')

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

    @if(auth()->user()->is_super_admin || (auth()->user()->rol && strtolower(auth()->user()->rol->nombre) === 'super administrador'))

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

    <form action="" method="POST" id="rpForm">
        @csrf
        @method('PUT')
        <input type="hidden" name="admin_id" id="rpAdminId" value="{{ old('admin_id') }}">

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
                    <div class="rp-user-item {{ old('admin_id') == $admin->id ? 'active' : '' }}"
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
                    <p>Elige un usuario de la lista para<br>configurar su rol y permisos de acceso.</p>
                </div>

                {{-- Panel activo --}}
                <div id="rpActive" class="{{ old('admin_id') ? '' : 'd-none' }}">

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

                        {{-- Rol --}}
                        <div>
                            <div class="rp-sec-label">Rol</div>
                            <div class="rp-rol-grid">

                                <label class="rp-rol-opt" id="rpOptAdmin">
                                    <input type="radio" name="rol" value="admin" id="rpRolAdmin">
                                    <div class="rp-rol-icon ad"><i class="fas fa-user-tie"></i></div>
                                    <div class="rp-rol-txt">
                                        <h6>Administrador</h6>
                                        <p>Permisos personalizables</p>
                                    </div>
                                    <div class="rp-check"><i class="fas fa-check"></i></div>
                                </label>

                                <label class="rp-rol-opt" id="rpOptSA">
                                    <input type="radio" name="rol" value="super_admin" id="rpRolSA">
                                    <div class="rp-rol-icon sa"><i class="fas fa-user-shield"></i></div>
                                    <div class="rp-rol-txt">
                                        <h6>Super Admin</h6>
                                        <p>Acceso total al sistema</p>
                                    </div>
                                    <div class="rp-check"><i class="fas fa-check"></i></div>
                                </label>

                            </div>
                        </div>

                        {{-- Permisos --}}
                        <div id="rpPermsSection" class="d-none" style="animation:rpFadeUp .2s ease">
                            <div class="rp-perms-head">
                                <div class="rp-sec-label" style="margin:0;flex:1">Permisos de acceso</div>
                                <div class="d-flex gap-2 ms-3">
                                    <button type="button" class="rp-link-btn" id="rpBtnAll">Todos</button>
                                    <span class="text-muted">·</span>
                                    <button type="button" class="rp-link-btn red" id="rpBtnNone">Ninguno</button>
                                </div>
                            </div>
                            <div class="rp-perms-grid mt-2">
                                @foreach($permisos as $key => $nombre)
                                <label class="rp-perm-item" id="rpw-{{ $key }}">
                                    <input type="checkbox" name="permisos[]" value="{{ $key }}"
                                           class="rp-perm-cb"
                                           {{ in_array($key, old('permisos', [])) ? 'checked' : '' }}>
                                    {{ $nombre }}
                                </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Aviso SA --}}
                        <div class="rp-sa-alert d-none" id="rpSAAlert">
                            <i class="fas fa-exclamation-triangle mt-1"></i>
                            <span>Este usuario tendrá <strong>control total</strong> sobre el sistema. Asegúrate de que sea de máxima confianza antes de guardar.</span>
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
                    @foreach($permisos as $key => $nombre)
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

<<<<<<< HEAD
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
    const rpRolAdmin   = document.getElementById('rpRolAdmin');
    const rpRolSA      = document.getElementById('rpRolSA');
    const rpOptAdmin   = document.getElementById('rpOptAdmin');
    const rpOptSA      = document.getElementById('rpOptSA');
    const rpPerms      = document.getElementById('rpPermsSection');
    const rpSAAlert    = document.getElementById('rpSAAlert');
    const checkboxes   = document.querySelectorAll('.rp-perm-cb');
    const permItems    = document.querySelectorAll('.rp-perm-item');
    const rpSearch     = document.getElementById('rpSearch');
    const rpNoResults  = document.getElementById('rpNoResults');

    /* ── Actualizar UI según rol ── */
    function updateRolUI() {
        const isSA = rpRolSA && rpRolSA.checked;
        rpOptAdmin.classList.toggle('sel-ad', !isSA);
        rpOptAdmin.classList.toggle('sel-sa', false);
        rpOptSA.classList.toggle('sel-sa',    isSA);
        rpOptSA.classList.toggle('sel-ad',    false);
        rpPerms.classList.toggle('d-none',   isSA);
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
=======
document.addEventListener('DOMContentLoaded', function() {
    modalPermisos = new bootstrap.Modal(document.getElementById('modalPermisos'));
});

function abrirModalPermisosData(button) {
    const userId = button.dataset.userId;
    const userName = button.dataset.userName;
    const userPermissions = JSON.parse(button.dataset.userPermissions);
    abrirModalPermisos(userId, userName, userPermissions);
}

function abrirModalPermisos(userId, userName, userPermissions) {
    document.getElementById('nombreUsuario').textContent = userName;
    document.getElementById('formPermisos').action = `/superadmin/administradores/${userId}/permisos`;

    document.querySelectorAll('.permiso-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });

    if (Array.isArray(userPermissions)) {
        userPermissions.forEach(permiso => {
            const checkbox = document.getElementById(`permiso_${permiso}`);
            if (checkbox) {
                checkbox.checked = true;
            }
        });
    }
    modalPermisos.show();
}
>>>>>>> cesia-dev

    /* ── Seleccionar usuario ── */
    function selectUser(item) {
        userItems.forEach(u => u.classList.remove('active'));
        item.classList.add('active');

        const permisos = JSON.parse(item.dataset.permisos || '[]');
        const isSA     = item.dataset.issa === '1';

        // ← Actualizar action del form con el ID del usuario
        document.getElementById('rpForm').action =
            '/admins/roles-permisos/' + item.dataset.id + '/guardar';

<<<<<<< HEAD
        rpAdminId.value        = item.dataset.id;
        rpAvatar.textContent   = item.dataset.initial;
        rpAvatar.style.background = item.dataset.color;
        rpName.textContent     = item.dataset.name;
        rpEmail.textContent    = item.dataset.email;

        (isSA ? rpRolSA : rpRolAdmin).checked = true;
        checkboxes.forEach(cb => { cb.checked = permisos.includes(cb.value); });

        updateRolUI();
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
=======
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchUser');
    const filterRole = document.getElementById('filterRole');

    if (searchInput) {
        searchInput.addEventListener('input', filtrarUsuarios);
    }

    if (filterRole) {
        filterRole.addEventListener('change', filtrarUsuarios);
>>>>>>> cesia-dev
    }

    /* ── Radio rol ── */
    if (rpRolAdmin) rpRolAdmin.addEventListener('change', updateRolUI);
    if (rpRolSA)    rpRolSA.addEventListener('change', updateRolUI);

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
<<<<<<< HEAD
</script>
@endpush
=======

function filtrarUsuarios() {
    const searchTerm = document.getElementById('searchUser').value.toLowerCase();
    const roleFilter = document.getElementById('filterRole').value.toLowerCase();
    const rows = document.querySelectorAll('#usersTable tbody tr');
    rows.forEach(row => {
        const name = row.dataset.name || '';
        const email = row.dataset.email || '';
        const role = row.dataset.role || '';

        const matchSearch = name.includes(searchTerm) || email.includes(searchTerm);
        const matchRole = !roleFilter || role === roleFilter;

        if (matchSearch && matchRole) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
@endpush
@endsection
>>>>>>> cesia-dev
