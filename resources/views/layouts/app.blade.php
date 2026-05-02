<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema Escolar') - Escuela Gabriela Mistral</title>

    <script>if(localStorage.getItem('theme')!=='light'){document.documentElement.setAttribute('data-theme','dark');}</script>
    <style>[data-theme="dark"]{background:#0f172a;}</style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        html { font-size: 17px; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fa;
            overflow-x: hidden;
            font-size: 1rem;
            transition: background 0.3s ease;
        }

        .btn-toggle-dark {
            background: #f1f5f9; color: #003b73; border: 1px solid #e5e7eb;
            padding: .5rem .8rem; border-radius: 8px; font-size: .85rem; font-weight: 700;
            display: flex; align-items: center; gap: .5rem; cursor: pointer; transition: 0.3s;
            white-space: nowrap;
        }
        body.dark-mode .btn-toggle-dark { background: #334155; color: #fbbf24; border-color: #475569; }

        /* ── SIDEBAR ── */
        .sidebar {
            position: fixed; top: 0; left: 0;
            height: 100vh; width: 280px;
            background: linear-gradient(180deg, #003b73 0%, #00508f 100%);
            transition: all .3s ease; z-index: 1000;
            box-shadow: 4px 0 15px rgba(0,59,115,.2);
            overflow-y: auto;
        }
        .sidebar-header { padding: 1.5rem 1.2rem; border-bottom: 1px solid rgba(78,199,210,.2); }
        .sidebar-logo { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .sidebar-logo i {
            font-size: 2rem; color: #f59e0b;
            background: rgba(245,158,11,.15);
            width: 50px; height: 50px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 12px; border: 3px solid rgba(245,158,11,.3);
        }
        .logo-text h4 { margin: 0; font-size: 1.1rem; font-weight: 700; color: #f59e0b; line-height: 1.2; }
        .logo-text p  { margin: 0; font-size: .75rem; color: rgba(245,158,11,.8); letter-spacing: .5px; font-weight: 500; }

        .user-info { padding: 1.5rem 1.2rem; border-bottom: 1px solid rgba(78,199,210,.2); text-align: center; }
        .user-avatar {
            width: 60px; height: 60px; border-radius: 50%;
            background: linear-gradient(135deg, #4ec7d2, #00508f);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; color: white; font-weight: 700; margin: 0 auto .8rem;
            box-shadow: 0 4px 12px rgba(78,199,210,.4);
        }
        .user-details h6 { margin: 0; color: white; font-size: .95rem; font-weight: 600; }
        .user-details p  { margin: 0; font-size: .75rem; color: rgba(255,255,255,.6); font-weight: 500; }

        .sidebar-menu { list-style: none; padding: 1rem 0; }
        .menu-section-title {
            padding: 1rem 1.2rem .5rem;
            color: rgba(78,199,210,.8);
            font-size: .80rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 1.2px;
        }
        .menu-item { margin: 0; }
        .menu-link {
            display: flex; align-items: center; gap: 12px;
            padding: .75rem 1.2rem;
            color: rgba(255,255,255,.8);
            text-decoration: none; transition: all .2s ease;
            font-size: .9rem; font-weight: 500;
        }
        .menu-link i { font-size: 1.1rem; width: 24px; text-align: center; color: rgba(78,199,210,.9); }
        .menu-link:hover { background: rgba(78,199,210,.15); color: white; }
        .menu-link.active { background: rgba(78,199,210,.2); color: white; border-left: 3px solid #4ec7d2; padding-left: calc(1.2rem - 3px); }

        /* ── MAIN ── */
        .main-content { margin-left: 280px; min-height: 100vh; background: #f5f7fa; }
        .main-content.no-sidebar { margin-left: 0; }

        /* ══════════════════════════════════════════════
           TOPBAR — botones siempre a la derecha
        ══════════════════════════════════════════════ */
        .topbar {
            background: white;
            padding: .75rem 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,.06);
            border-bottom: 1px solid #e5e7eb;
            position: sticky; top: 0; z-index: 100;
            min-height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .75rem;
            flex-wrap: wrap;
        }

        .topbar-left {
            display: flex; align-items: center; gap: .75rem;
            flex-shrink: 0;
        }
        .topbar-left h5 {
            margin: 0; color: #003b73; font-weight: 700;
            font-size: 1.15rem; white-space: nowrap;
        }

        /* FIX CLAVE: margin-left:auto empuja todo a la derecha siempre */
        .topbar-right {
            display: flex;
            align-items: center;
            gap: .6rem;
            flex-wrap: wrap;
            justify-content: flex-end;
            margin-left: auto;
        }

        .topbar-actions-group {
            display: flex;
            align-items: center;
            gap: .4rem;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .topbar-divider { width: 1px; height: 24px; background: #e2e8f0; flex-shrink: 0; }

        .btn-logout {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white; border: none;
            padding: .6rem .75rem; border-radius: 7px;
            font-size: .83rem; font-weight: 600;
            display: flex; align-items: center; gap: .4rem;
            cursor: pointer; transition: all .2s ease; white-space: nowrap;
        }
        .btn-logout:hover { opacity: .9; transform: translateY(-1px); }

        .btn-back-topbar {
            background: white; color: #00508f;
            border: 1.5px solid #00508f;
            padding: .6rem .75rem; border-radius: 7px;
            font-size: .83rem; font-weight: 600;
            display: flex; align-items: center; gap: .4rem;
            cursor: pointer; transition: all .2s ease; white-space: nowrap;
        }
        .btn-back-topbar:hover { background: #00508f; color: white; transform: translateY(-1px); }

        /* ── CONTENT ── */
        .content-wrapper { padding: 2rem; }

        /* ── RESPONSIVE ── */
        .mobile-menu-btn {
            display: none;
            background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
            color: white; border: none;
            padding: 0.6rem 0.9rem; border-radius: 8px; font-size: 1.1rem;
        }
        .sidebar-overlay {
            display: none; position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,.5); z-index: 999;
        }
        .sidebar-overlay.active { display: block; }

        @media (max-width: 768px) {
            .sidebar { left: -280px; }
            .sidebar.active { left: 0; }
            .main-content { margin-left: 0 !important; }
            .mobile-menu-btn { display: block !important; }
            .content-wrapper { padding: 1rem; }
            .topbar { padding: .75rem 1rem; }
            .topbar-divider { display: none; }
            .topbar-left h5 { font-size: .95rem; }
        }

        /* ══════════════════════════════════════════════
           MODAL ELIMINACIÓN
        ══════════════════════════════════════════════ */
        .modal-delete-overlay {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,.6); backdrop-filter: blur(4px);
            display: none; align-items: center; justify-content: center;
            z-index: 10000; opacity: 0; transition: opacity .3s ease;
        }
        .modal-delete-overlay.show { display: flex; animation: fadeIn .3s ease forwards; }
        @keyframes fadeIn { to { opacity: 1; } }

        .modal-delete {
            background: white; border-radius: 16px;
            max-width: 480px; width: 90%;
            box-shadow: 0 10px 40px rgba(239,68,68,.2);
            transform: scale(.95);
            animation: scaleUp .3s cubic-bezier(.68,-.55,.265,1.55) forwards;
            position: relative; overflow: hidden;
        }
        @keyframes scaleUp { to { transform: scale(1); } }

        .modal-delete-close {
            position: absolute; top: 1rem; right: 1rem;
            width: 32px; height: 32px;
            background: #f1f5f9; border: none; border-radius: 8px;
            color: #64748b; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: all .2s ease; z-index: 1;
        }
        .modal-delete-close:hover { background: #e2e8f0; }

        .modal-delete-icon {
            width: 80px; height: 80px;
            background: linear-gradient(135deg,rgba(239,68,68,.1),rgba(220,38,38,.1));
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 2rem auto 1.5rem; color: #ef4444; font-size: 2.5rem;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%,100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(239,68,68,.4); }
            50%      { transform: scale(1.05); box-shadow: 0 0 0 15px rgba(239,68,68,0); }
        }

        .modal-delete-title { text-align: center; color: #1e293b; font-size: 1.5rem; font-weight: 700; margin: 0 0 1.5rem; padding: 0 2rem; }
        .modal-delete-content { padding: 0 2rem 2rem; }
        .modal-delete-message { text-align: center; color: #64748b; font-size: .938rem; line-height: 1.6; margin: 0 0 1.5rem; }
        .modal-delete-item {
            background: linear-gradient(135deg,#f8fafc,#e2e8f0);
            border-radius: 12px; padding: 1rem;
            display: flex; align-items: center; gap: 1rem;
            border-left: 4px solid #ef4444;
        }
        .delete-item-icon {
            width: 40px; height: 40px; background: white; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: #ef4444; font-size: 1.125rem; flex-shrink: 0;
        }
        .delete-item-label { display: block; color: #64748b; font-size: .75rem; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; margin-bottom: .25rem; }
        .delete-item-name  { display: block; color: #1e293b; font-size: .938rem; font-weight: 700; }
        .modal-delete-actions {
            padding: 1rem 1.5rem 1.5rem; display: flex; gap: .75rem;
            border-top: 1px solid #e2e8f0;
        }
        .btn-delete-cancel, .btn-delete-confirm {
            flex: 1; padding: .75rem 1.25rem; border-radius: 10px;
            font-weight: 600; font-size: .875rem; border: none; cursor: pointer;
            transition: all .3s ease;
            display: inline-flex; align-items: center; justify-content: center; gap: .5rem;
        }
        .btn-delete-cancel { background: #f1f5f9; color: #64748b; }
        .btn-delete-cancel:hover { background: #e2e8f0; transform: translateY(-2px); }
        .btn-delete-confirm { background: linear-gradient(135deg,#ef4444,#dc2626); color: white; box-shadow: 0 4px 12px rgba(239,68,68,.3); }
        .btn-delete-confirm:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(239,68,68,.4); }

        @media (max-width: 576px) {
            .modal-delete { max-width: calc(100% - 2rem); margin: 1rem; }
            .modal-delete-title { font-size: 1.25rem; padding: 0 1.5rem; }
            .modal-delete-content { padding: 0 1.5rem 1.5rem; }
            .modal-delete-actions { flex-direction: column; }
            .btn-delete-cancel, .btn-delete-confirm { width: 100%; }
        }
    </style>
    @stack('styles')

    <style id="dark-mode-styles">
        body.dark-mode { background-color: #0f172a !important; color: #f1f5f9 !important; }
        body.dark-mode .sidebar { background: linear-gradient(180deg, #020617 0%, #0f172a 100%) !important; box-shadow: 4px 0 15px rgba(0,0,0,.5); }
        body.dark-mode .topbar { background: #1e293b !important; border-bottom: 1px solid #334155 !important; }
        body.dark-mode .main-content, body.dark-mode .content-wrapper { background: #0f172a !important; }
        body.dark-mode .topbar-divider { background: #334155 !important; }
        body.dark-mode .topbar-left h5 { color: #e2e8f0 !important; }

        body.dark-mode .card, body.dark-mode .welcome-card, body.dark-mode .adm-card,
        body.dark-mode .adm-stat, body.dark-mode .est-stat, body.dark-mode .stat-card,
        body.dark-mode .pub-stat, body.dark-mode .action-card, body.dark-mode .info-card,
        body.dark-mode .modal-content, body.dark-mode .adm-toolbar, body.dark-mode .pub-card {
            background-color: #1e293b !important; border-color: #334155 !important; color: #f1f5f9 !important;
        }
        body.dark-mode .card-header, body.dark-mode .adm-card-head,
        body.dark-mode .pub-card-head { border-color: #334155 !important; }
        body.dark-mode .card-footer { background: #1e293b !important; border-color: #334155 !important; }

        body.dark-mode h1, body.dark-mode h2, body.dark-mode h3, body.dark-mode h4,
        body.dark-mode h5, body.dark-mode h6, body.dark-mode .welcome-title,
        body.dark-mode .stat-value, body.dark-mode .adm-stat-num, body.dark-mode .est-stat-num,
        body.dark-mode .action-title, body.dark-mode .card-title, body.dark-mode .fw-bold,
        body.dark-mode .text-dark, body.dark-mode strong { color: #ffffff !important; }

        body.dark-mode .text-muted, body.dark-mode .adm-stat-lbl, body.dark-mode .est-stat-lbl,
        body.dark-mode .est-stat-sub, body.dark-mode .stat-label, body.dark-mode .welcome-subtitle,
        body.dark-mode .action-subtitle, body.dark-mode label, body.dark-mode p,
        body.dark-mode small { color: #cbd5e1 !important; }

        body.dark-mode span:not(.badge):not(.text-white):not(.w-badge) { color: inherit; }

        body.dark-mode .table, body.dark-mode .adm-tbl { color: #f1f5f9 !important; background: transparent !important; }
        body.dark-mode .table td, body.dark-mode .table th,
        body.dark-mode .text-primary, body.dark-mode .dni-text { color: #e2e8f0 !important; }
        body.dark-mode .table thead th { background: #1e293b !important; color: #4ec7d2 !important; border-bottom: 2px solid #334155 !important; }
        body.dark-mode .table td { border-bottom-color: #334155 !important; }
        body.dark-mode .table-striped > tbody > tr:nth-of-type(odd) > * { background-color: rgba(255,255,255,.03) !important; }
        body.dark-mode .table-hover > tbody > tr:hover > * { background-color: rgba(78,199,210,.07) !important; }

        body.dark-mode .form-control, body.dark-mode .form-select, body.dark-mode .input-group-text,
        body.dark-mode .est-search, body.dark-mode .adm-search {
            background-color: #0f172a !important; border-color: #334155 !important; color: #f1f5f9 !important;
        }
        body.dark-mode .form-control::placeholder, body.dark-mode .form-select::placeholder,
        body.dark-mode .est-search::placeholder { color: #475569 !important; }
        body.dark-mode .form-control:focus, body.dark-mode .form-select:focus, body.dark-mode .est-search:focus {
            background-color: #0f172a !important; border-color: #4ec7d2 !important;
            box-shadow: 0 0 0 3px rgba(78,199,210,.15) !important; color: #f1f5f9 !important;
        }

        body.dark-mode .alert { background-color: #1e293b !important; border-color: #334155 !important; color: #f1f5f9 !important; }
        body.dark-mode .alert-success { border-left-color: #34d399 !important; }
        body.dark-mode .alert-danger  { border-left-color: #f87171 !important; }
        body.dark-mode .alert-warning { border-left-color: #fbbf24 !important; }
        body.dark-mode .alert-info    { border-left-color: #4ec7d2 !important; }

        body.dark-mode .page-link { background-color: #1e293b !important; border-color: #334155 !important; color: #4ec7d2 !important; }
        body.dark-mode .page-item.active .page-link { background-color: #00508f !important; border-color: #00508f !important; color: #fff !important; }
        body.dark-mode .page-item.disabled .page-link { opacity: .4; }

        body.dark-mode .dropdown-menu { background-color: #1e293b !important; border-color: #334155 !important; }
        body.dark-mode .dropdown-item { color: #f1f5f9 !important; }
        body.dark-mode .dropdown-item:hover { background-color: #334155 !important; }
        body.dark-mode .dropdown-divider { border-color: #334155 !important; }

        body.dark-mode .btn-outline-secondary { color: #94a3b8 !important; border-color: #475569 !important; }
        body.dark-mode .btn-outline-secondary:hover { background-color: #334155 !important; color: #f1f5f9 !important; }
        body.dark-mode .btn-toggle-dark { background: #334155 !important; color: #fbbf24 !important; border-color: #475569 !important; }

        body.dark-mode .adm-toolbar, body.dark-mode .adm-filter-bar,
        body.dark-mode .est-filter-bar { background: #1e293b !important; border-color: #334155 !important; }

        body.dark-mode .legend-wrap { background: #1e293b !important; border-color: #334155 !important; }
        body.dark-mode .legend-item { color: #cbd5e1 !important; }

        body.dark-mode .badge.bg-light { background-color: #334155 !important; color: #e2e8f0 !important; }
        body.dark-mode .badge.bg-white { background-color: #334155 !important; color: #e2e8f0 !important; }

        body.dark-mode .adm-tbl thead th { background: #0f172a !important; color: #4ec7d2 !important; border-bottom-color: #334155 !important; }
        body.dark-mode .adm-tbl tbody td { color: #e2e8f0 !important; border-bottom-color: #1e293b !important; }
        body.dark-mode .adm-tbl tbody tr:hover { background: rgba(78,199,210,.06) !important; }
        body.dark-mode .adm-footer { background: #161f2e !important; border-top-color: #334155 !important; }
        body.dark-mode .adm-footer-info { color: #64748b !important; }
        body.dark-mode .adm-stat-sub { color: #64748b !important; }
        body.dark-mode .row-num { background: #334155 !important; color: #94a3b8 !important; border-color: #475569 !important; }
        body.dark-mode .adm-name  { color: #f1f5f9 !important; }
        body.dark-mode .adm-email { color: #94a3b8 !important; }
        body.dark-mode .adm-perpage { color: #94a3b8 !important; }
        body.dark-mode .adm-perpage select { background: #0f172a !important; border-color: #334155 !important; color: #f1f5f9 !important; }

        body.dark-mode .bpill.b-red    { background: rgba(220,38,38,.15) !important; color: #fca5a5 !important; }
        body.dark-mode .bpill.b-blue   { background: rgba(78,199,210,.12) !important; color: #4ec7d2 !important; }
        body.dark-mode .bpill.b-green  { background: rgba(16,185,129,.12) !important; color: #34d399 !important; }
        body.dark-mode .bpill.b-indigo { background: rgba(99,102,241,.15) !important; color: #a5b4fc !important; }
        body.dark-mode .bpill.b-amber  { background: rgba(245,158,11,.12) !important; color: #fbbf24 !important; }

        body.dark-mode .act-edit { background: rgba(78,199,210,.12) !important; color: #4ec7d2 !important; }
        body.dark-mode .act-edit:hover { background: #4ec7d2 !important; color: #0f172a !important; }
        body.dark-mode .act-del  { background: rgba(239,68,68,.12) !important; color: #f87171 !important; }
        body.dark-mode .act-del:hover  { background: #ef4444 !important; color: #fff !important; }

        body.dark-mode .search-input, body.dark-mode .filter-select { background: #0f172a !important; border-color: #334155 !important; color: #f1f5f9 !important; }
        body.dark-mode .filtros-card, body.dark-mode .hist-card, body.dark-mode .hist-stat,
        body.dark-mode .hist-ciclo { background: #1e293b !important; border-color: #334155 !important; }
        body.dark-mode .hist-ciclo-head { background: #0f172a !important; color: #e2e8f0 !important; border-bottom-color: #334155 !important; }
        body.dark-mode .hist-table thead tr { background: #1e293b !important; }
        body.dark-mode .hist-table th { color: #4ec7d2 !important; border-bottom-color: #334155 !important; }
        body.dark-mode .hist-table td { color: #e2e8f0 !important; border-top-color: #334155 !important; }
        body.dark-mode .hist-table tbody tr:hover { background: rgba(78,199,210,.05) !important; }
        body.dark-mode .hist-foot { border-top-color: #334155 !important; color: #64748b !important; }
        body.dark-mode .hist-stat-lbl { color: #64748b !important; }
        body.dark-mode .hist-stat-val { color: #4ec7d2 !important; }
        body.dark-mode .nota-materia  { color: #93c5fd !important; }
        body.dark-mode .nota-periodo  { color: #64748b !important; }
        body.dark-mode .nota-parciales { color: #94a3b8 !important; }
    </style>
</head>
<body>

@php
    $user         = auth()->user();
    $isSuperAdmin = $user && ($user->is_super_admin == 1 || $user->id_rol == 1);
    $isAdmin      = $user && in_array($user->id_rol, [1, 2]);
    $showSidebar  = $isAdmin;
    $roleName     = $isSuperAdmin ? 'Super Administrador' : ($isAdmin ? 'Administrador' : 'Usuario');
@endphp

@if($showSidebar)
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ $isSuperAdmin ? route('superadmin.dashboard') : route('admin.dashboard') }}" class="sidebar-logo">
                <i class="fas fa-graduation-cap"></i>
                <div class="logo-text"><h4>Escuela G.M.</h4><p>Sistema de Gestión</p></div>
            </a>
        </div>
        <div class="user-info">
            <div class="user-avatar">{{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}</div>
            <div class="user-details"><h6>{{ $user->name ?? 'Usuario' }}</h6><p>{{ $roleName }}</p></div>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-section-title">PRINCIPAL</li>
            <li class="menu-item">
                <a href="{{ $isSuperAdmin ? route('superadmin.dashboard') : route('admin.dashboard') }}"
                   class="menu-link {{ request()->routeIs('superadmin.dashboard', 'admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i><span>Dashboard</span>
                </a>
            </li>

            <li class="menu-section-title">USUARIOS</li>
            @if($isSuperAdmin)
            <li class="menu-item">
                <a href="{{ route('superadmin.administradores.index') }}"
                   class="menu-link {{ request()->routeIs('superadmin.administradores.*') ? 'active' : '' }}">
                    <i class="fas fa-user-shield"></i><span>Administradores</span>
                </a>
            </li>
            @endif
            <li class="menu-item">
                <a href="{{ route('estudiantes.index') }}"
                   class="menu-link {{ request()->routeIs('estudiantes.*') ? 'active' : '' }}">
                    <i class="fas fa-user-graduate"></i><span>Estudiantes</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('profesores.index') }}"
                   class="menu-link {{ request()->routeIs('profesores.*') ? 'active' : '' }}">
                    <i class="fas fa-chalkboard-teacher"></i><span>Profesores</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('padres.index') }}"
                   class="menu-link {{ request()->routeIs('padres.*') ? 'active' : '' }}">
                    <i class="fas fa-user-friends"></i><span>Padres / Tutores</span>
                </a>
            </li>

            <li class="menu-section-title">MATRÍCULAS</li>
            <li class="menu-item">
                <a href="{{ route('matriculas.index') }}"
                   class="menu-link {{ request()->routeIs('matriculas.*') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list"></i><span>Matrículas</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('admins.permisos.index') }}"
                   class="menu-link {{ request()->routeIs('admins.permisos.*') ? 'active' : '' }}">
                    <i class="fas fa-user-lock"></i><span>Permisos de Padres</span>
                </a>
            </li>

            <li class="menu-section-title">ACADÉMICO</li>
            <li class="menu-item">
                <a href="{{ $isSuperAdmin ? route('superadmin.grados.index') : route('grados.index') }}"
                   class="menu-link {{ request()->routeIs('grados.*', 'superadmin.grados.*') ? 'active' : '' }}">
                    <i class="fas fa-layer-group"></i><span>Grados</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ $isSuperAdmin ? route('superadmin.materias.index') : route('materias.index') }}"
                   class="menu-link {{ request()->routeIs('materias.*', 'superadmin.materias.*') ? 'active' : '' }}">
                    <i class="fas fa-book"></i><span>Materias</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('profesor_materia_grado.index') }}"
                   class="menu-link {{ request()->routeIs('profesor_materia.*') ? 'active' : '' }}">
                    <i class="fas fa-user-tag"></i><span>Asignar Profesor</span>
                </a>
            </li>
            <li class="menu-item">
                @if($isSuperAdmin)
                    <a href="{{ route('carga-docente.index') }}"
                       class="menu-link {{ request()->routeIs('carga-docente.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar"></i><span>Carga Docente</span>
                    </a>
                @else
                    <a href="#" class="menu-link disabled-link" title="Sin acceso">
                        <i class="fas fa-chart-bar"></i><span>Carga Docente</span>
                    </a>
                @endif
            </li>
            <li class="menu-item">
                <a href="{{ route('secciones.index') }}"
                   class="menu-link {{ request()->routeIs('secciones.*') ? 'active' : '' }}">
                    <i class="fas fa-sitemap"></i><span>Secciones</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('superadmin.cupos_maximos.index') }}"
                   class="menu-link {{ request()->routeIs('superadmin.cupos_maximos.*') ? 'active' : '' }}">
                    <i class="fas fa-users-cog"></i><span>Cupos Máximos</span>
                </a>
            </li>

            <li class="menu-section-title">CALIFICACIONES</li>
            <li class="menu-item">
                <a href="{{ route('registrarcalificaciones.index') }}"
                   class="menu-link {{ request()->routeIs('registrarcalificaciones.*') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-check"></i><span>Registrar Calificaciones</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('consultaestudiantesxcurso.index') }}"
                   class="menu-link {{ request()->routeIs('consultaestudiantesxcurso.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i><span>Estudiantes por Curso</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('h20cursos.index') }}"
                   class="menu-link {{ request()->routeIs('h20cursos.*') ? 'active' : '' }}">
                    <i class="fas fa-graduation-cap"></i><span>Cursos Secundaria</span>
                </a>
            </li>

            <li class="menu-section-title">CALENDARIO</li>
            <li class="menu-item">
                <a href="{{ route('periodos-academicos.index') }}"
                   class="menu-link {{ request()->routeIs('periodos-academicos.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i><span>Períodos Académicos</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('calendario') }}"
                   class="menu-link {{ request()->routeIs('calendario') ? 'active' : '' }}">
                    <i class="fas fa-calendar-week"></i><span>Calendario Académico</span>
                </a>
            </li>

            <li class="menu-section-title">DOCUMENTACIÓN</li>
            <li class="menu-item">
                <a href="{{ route('observaciones.index') }}"
                   class="menu-link {{ request()->routeIs('observaciones.*') ? 'active' : '' }}">
                    <i class="fas fa-sticky-note"></i><span>Observaciones</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('documentos.index') }}"
                   class="menu-link {{ request()->routeIs('documentos.*') ? 'active' : '' }}">
                    <i class="fas fa-folder-open"></i><span>Documentos</span>
                </a>
            </li>

            <li class="menu-section-title">CONFIGURACIÓN</li>
            @if($isSuperAdmin)
            <li class="menu-item">
                <a href="{{ route('superadmin.perfil') }}"
                   class="menu-link {{ request()->routeIs('superadmin.perfil') ? 'active' : '' }}">
                    <i class="fas fa-user-circle"></i><span>Mi Perfil</span>
                </a>
            </li>
            @endif
            <li class="menu-item">
                <a href="{{ route('estado-solicitud') }}"
                   class="menu-link {{ request()->routeIs('estado-solicitud') ? 'active' : '' }}">
                    <i class="fas fa-question-circle"></i><span>Estado de Solicitud</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('acciones_importantes.index') }}"
                   class="menu-link {{ request()->routeIs('acciones_importantes.*') ? 'active' : '' }}">
                    <i class="fas fa-bell"></i><span>Acciones Recientes</span>
                </a>
            </li>
        </ul>
    </aside>
@endif

<div class="main-content {{ !$showSidebar ? 'no-sidebar' : '' }}">
    <div class="topbar">
        {{-- Izquierda: solo el título --}}
        <div class="topbar-left">
            @if($showSidebar)
                <button class="mobile-menu-btn btn btn-sm btn-primary d-md-none" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
            @endif
            <h5>@yield('page-title', 'Panel de Control')</h5>
        </div>

        {{-- Derecha: botones siempre alineados a la derecha --}}
        <div class="topbar-right">
            @hasSection('topbar-actions')
                <div class="topbar-actions-group">
                    @yield('topbar-actions')
                </div>
                <div class="topbar-divider"></div>
            @endif

            @php
                $esDashboard = request()->routeIs(
                    '*.dashboard', 'superadmin.dashboard', 'admin.dashboard',
                    'profesor.dashboard', 'estudiante.dashboard', 'padre.dashboard',
                    'admins.dashboard'
                );
            @endphp
            @unless($esDashboard)
                <button type="button" onclick="history.back()" class="btn-back-topbar" title="Volver">
                    <i class="fas fa-arrow-left"></i> Volver
                </button>
                <div class="topbar-divider"></div>
            @endunless

            <button id="globalDarkModeToggle" class="btn-toggle-dark">
                <i class="fas fa-moon" id="globalDarkIcon"></i>
                <span id="globalDarkText" class="d-none d-md-inline">Modo Oscuro</span>
            </button>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="d-none d-md-inline">Cerrar Sesión</span>
                </button>
            </form>
        </div>
    </div>

    <div class="content-wrapper">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
    </div>
</div>

{{-- MODAL ELIMINACIÓN --}}
<div class="modal-delete-overlay" id="modalDelete">
    <div class="modal-delete">
        <button type="button" class="modal-delete-close" onclick="cerrarModalDelete()">
            <i class="fas fa-times"></i>
        </button>
        <div class="modal-delete-icon"><i class="fas fa-exclamation-triangle"></i></div>
        <h4 class="modal-delete-title">¿Confirmar Eliminación?</h4>
        <div class="modal-delete-content">
            <p class="modal-delete-message" id="deleteMessage">
                Esta acción no se puede deshacer. ¿Estás seguro de que deseas eliminar este registro?
            </p>
            <div class="modal-delete-item" id="deleteItemInfo" style="display:none;">
                <div class="delete-item-icon"><i class="fas fa-file-alt"></i></div>
                <div>
                    <span class="delete-item-label">Elemento a eliminar:</span>
                    <strong class="delete-item-name" id="deleteItemName"></strong>
                </div>
            </div>
        </div>
        <form id="formDelete" method="POST" style="display:none;">
            @csrf
            @method('DELETE')
        </form>
        <div class="modal-delete-actions">
            <button type="button" class="btn-delete-cancel" onclick="cerrarModalDelete()">
                <i class="fas fa-times"></i> Cancelar
            </button>
            <button type="button" class="btn-delete-confirm" onclick="confirmarEliminacion()">
                <i class="fas fa-trash-alt"></i> Eliminar
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('active');
    }

    (function() {
        const btn  = document.getElementById('globalDarkModeToggle');
        const icon = document.getElementById('globalDarkIcon');
        const text = document.getElementById('globalDarkText');
        function aplicarTema(isDark) {
            document.body.classList.toggle('dark-mode', isDark);
            document.documentElement.setAttribute('data-theme', isDark ? 'dark' : 'light');
            icon.className = isDark ? 'fas fa-sun'  : 'fas fa-moon';
            text.innerText = isDark ? 'Modo Claro'  : 'Modo Oscuro';
        }
        aplicarTema(localStorage.getItem('theme') !== 'light');
        btn.addEventListener('click', function() {
            const isDark = !document.body.classList.contains('dark-mode');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            aplicarTema(isDark);
        });
    })();
</script>
@stack('scripts')

<div id="sys-modal"
     style="display:none;position:fixed;inset:0;z-index:9999;
            background:rgba(0,45,90,.5);backdrop-filter:blur(4px);
            align-items:center;justify-content:center;">
    <div style="background:white;border-radius:16px;padding:2rem 1.8rem;
                max-width:400px;width:90%;box-shadow:0 24px 60px rgba(0,45,90,.35);
                animation:sysModalIn .18s ease;">
        <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.4rem;">
            <div style="width:50px;height:50px;border-radius:13px;flex-shrink:0;
                        background:linear-gradient(135deg,#002d5a,#00508f);
                        display:flex;align-items:center;justify-content:center;
                        box-shadow:0 4px 14px rgba(0,80,143,.3);">
                <i class="fas fa-question" style="color:white;font-size:1.2rem;"></i>
            </div>
            <div>
                <div style="font-size:.68rem;font-weight:700;text-transform:uppercase;
                            letter-spacing:.09em;color:#4ec7d2;margin-bottom:.25rem;">Confirmación</div>
                <p id="sys-modal-msg" style="font-size:.9rem;font-weight:600;color:#003b73;margin:0;line-height:1.4;"></p>
            </div>
        </div>
        <div style="display:flex;gap:.65rem;justify-content:flex-end;">
            <button id="sys-modal-cancel"
                    style="padding:.5rem 1.3rem;border-radius:8px;font-size:.82rem;font-weight:600;
                           border:1.5px solid #d1d9e6;background:white;color:#64748b;cursor:pointer;transition:all .15s;">
                <i class="fas fa-times me-1"></i>Cancelar
            </button>
            <button id="sys-modal-ok"
                    style="padding:.5rem 1.3rem;border-radius:8px;font-size:.82rem;font-weight:700;
                           border:none;background:linear-gradient(135deg,#002d5a,#00508f);
                           color:white;cursor:pointer;transition:all .15s;">
                <i class="fas fa-check me-1"></i>Confirmar
            </button>
        </div>
    </div>
</div>
<style>
@keyframes sysModalIn {
    from { transform:scale(.92);opacity:0; }
    to   { transform:scale(1);opacity:1; }
}
</style>
<script>
function sysConfirm(msg, onOk) {
    const modal  = document.getElementById('sys-modal');
    const okBtn  = document.getElementById('sys-modal-ok');
    const canBtn = document.getElementById('sys-modal-cancel');
    document.getElementById('sys-modal-msg').textContent = msg;
    modal.style.display = 'flex';
    function cleanup() {
        modal.style.display = 'none';
        okBtn.removeEventListener('click', yes);
        canBtn.removeEventListener('click', no);
        modal.removeEventListener('click', backdrop);
    }
    function yes()      { cleanup(); onOk(); }
    function no()       { cleanup(); }
    function backdrop(e){ if (e.target === modal) no(); }
    okBtn.addEventListener('click', yes);
    canBtn.addEventListener('click', no);
    modal.addEventListener('click', backdrop);
}
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('form[data-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            if (this._sysOk) return;
            e.preventDefault();
            const f = this;
            sysConfirm(f.dataset.confirm, function () {
                f._sysOk = true;
                HTMLFormElement.prototype.submit.call(f);
            });
        });
    });
});
</script>

<script>
(function () {
    const page = new URLSearchParams(window.location.search).get('page');
    if (!page || page === '1') return;
    function injectPage(form) {
        if (!form.querySelector('input[name="page"]')) {
            const h = document.createElement('input');
            h.type = 'hidden'; h.name = 'page'; h.value = page;
            form.appendChild(h);
        }
    }
    document.querySelectorAll('form').forEach(injectPage);
    document.addEventListener('show.bs.modal', function (e) {
        e.target.querySelectorAll('form').forEach(injectPage);
    });
})();
</script>

<script>
(function () {
    const sidebar = document.querySelector('.sidebar');
    if (!sidebar) return;
    const saved = sessionStorage.getItem('sidebar_scroll');
    if (saved) sidebar.scrollTop = parseInt(saved, 10);
    window.addEventListener('beforeunload', function () {
        sessionStorage.setItem('sidebar_scroll', sidebar.scrollTop);
    });
})();
</script>
</body>
</html>