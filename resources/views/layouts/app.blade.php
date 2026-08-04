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

        /* ── Submenu colapsable ── */
        .menu-group {}
        .menu-group-toggle {
            display: flex; align-items: center; gap: 12px;
            padding: .75rem 1.2rem;
            color: rgba(255,255,255,.8);
            cursor: pointer; transition: all .2s ease;
            font-size: .9rem; font-weight: 500;
            user-select: none; list-style: none;
        }
        .menu-group-toggle i.icon-main { font-size: 1.1rem; width: 24px; text-align: center; color: rgba(78,199,210,.9); }
        .menu-group-toggle:hover { background: rgba(78,199,210,.15); color: white; }
        .menu-group-toggle .arrow {
            margin-left: auto; font-size: .7rem;
            color: rgba(255,255,255,.4); transition: transform .25s;
        }
        .menu-group-toggle.open .arrow { transform: rotate(180deg); }
        .menu-group-toggle.open { background: rgba(78,199,210,.1); color: white; }

        .menu-sub {
            list-style: none; padding: 0;
            max-height: 0; overflow: hidden;
            transition: max-height .3s ease;
            background: rgba(0,0,0,.12);
        }
        .menu-sub.open { max-height: 600px; }
        .menu-sub .menu-link {
            padding: .6rem 1.2rem .6rem 3.2rem;
            font-size: .85rem; color: rgba(255,255,255,.7);
        }
        .menu-sub .menu-link i { font-size: .95rem; }
        .menu-sub .menu-link:hover { color: white; background: rgba(78,199,210,.12); }
        .menu-sub .menu-link.active { color: white; border-left: 3px solid #4ec7d2; padding-left: calc(3.2rem - 3px); }

        /* ── MAIN ── */
        .main-content { margin-left: 280px; min-height: 100vh; background: #f5f7fa; }
        .main-content.no-sidebar { margin-left: 0; }

        /* ── TOPBAR ── */
        .topbar {
            background: white;
            padding: .75rem 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,.06);
            border-bottom: 1px solid #e5e7eb;
            position: sticky; top: 0; z-index: 100;
            min-height: 64px;
            display: flex; align-items: center;
            justify-content: space-between;
            gap: .75rem; flex-wrap: wrap;
        }
        .topbar-left { display: flex; align-items: center; gap: .75rem; flex-shrink: 0; }
        .topbar-left h5 { margin: 0; color: #003b73; font-weight: 700; font-size: 1.15rem; white-space: nowrap; }
        .topbar-right { display: flex; align-items: center; gap: .6rem; flex-wrap: wrap; justify-content: flex-end; margin-left: auto; }
        .topbar-actions-group { display: flex; align-items: center; gap: .4rem; flex-wrap: wrap; justify-content: flex-end; }
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

        /* ══════════════════════════════════════════════════
           ALERTAS FLOTANTES
        ══════════════════════════════════════════════════ */
        #sys-alerts-container {
            position: fixed;
            top: 1.1rem; right: 1.25rem;
            z-index: 999999;
            display: flex; flex-direction: column; gap: .6rem;
            pointer-events: none;
            max-width: 400px;
            width: calc(100vw - 2.5rem);
        }
        .sys-alert {
            pointer-events: all;
            display: flex; align-items: flex-start; gap: .85rem;
            padding: .9rem 1.1rem;
            border-radius: 13px;
            background: white;
            box-shadow: 0 8px 30px rgba(0,0,0,.13);
            border-left: 5px solid #10b981;
            animation: sysAlertIn .3s cubic-bezier(.34,1.56,.64,1) both;
            position: relative; overflow: hidden;
        }
        .sys-alert.leaving { animation: sysAlertOut .3s ease forwards; }
        .sys-alert.persistent { border-left-width: 6px; }

        @keyframes sysAlertIn {
            from { opacity:0; transform:translateX(60px) scale(.93); }
            to   { opacity:1; transform:translateX(0)    scale(1); }
        }
        @keyframes sysAlertOut {
            to { opacity:0; transform:translateX(60px) scale(.93); }
        }
        .sys-alert-bar { position: absolute; bottom: 0; left: 0; height: 3px; background: currentColor; opacity: .3; }
        .sys-alert.success { border-left-color: #10b981; color: #065f46; }
        .sys-alert.success .sys-alert-icon { background: rgba(16,185,129,.12); color: #10b981; }
        .sys-alert.error   { border-left-color: #ef4444; color: #7f1d1d; }
        .sys-alert.error   .sys-alert-icon { background: rgba(239,68,68,.12); color: #ef4444; }
        .sys-alert.warning { border-left-color: #f59e0b; color: #78350f; }
        .sys-alert.warning .sys-alert-icon { background: rgba(245,158,11,.12); color: #f59e0b; }
        .sys-alert.info    { border-left-color: #4ec7d2; color: #0e4f55; }
        .sys-alert.info    .sys-alert-icon { background: rgba(78,199,210,.12); color: #4ec7d2; }
        .sys-alert.credential { border-left-color: #6366f1; color: #312e81; }
        .sys-alert.credential .sys-alert-icon { background: rgba(99,102,241,.12); color: #6366f1; }
        .sys-alert-icon {
            width: 38px; height: 38px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: .95rem; flex-shrink: 0;
        }
        .sys-alert-body { flex: 1; min-width: 0; }
        .sys-alert-title { font-size: .8rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; margin-bottom: .18rem; opacity: .75; }
        .sys-alert-msg   { font-size: .88rem; font-weight: 600; line-height: 1.5; word-break: break-word; }
        .sys-alert-sticky { font-size: .65rem; font-weight: 700; background: rgba(99,102,241,.15); color: #4338ca; padding: .1rem .45rem; border-radius: 999px; display: inline-flex; align-items: center; gap: .25rem; margin-top: .3rem; }
        .sys-alert-close {
            width: 26px; height: 26px; border-radius: 7px; border: none;
            background: rgba(0,0,0,.06); color: currentColor; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: .7rem; flex-shrink: 0; transition: background .15s;
        }
        .sys-alert-close:hover { background: rgba(0,0,0,.13); }

        /* ══════════════════════════════════════════════════
           MODAL ELIMINACION
        ══════════════════════════════════════════════════ */
        #modalDelete {
            display: none; position: fixed; inset: 0; z-index: 99999;
            align-items: center; justify-content: center;
            background: rgba(0,0,0,.52);
            backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);
            padding: 1rem;
        }
        .mdel-card {
            background: white; border-radius: 20px; max-width: 460px; width: 100%;
            box-shadow: 0 24px 70px rgba(239,68,68,.2), 0 8px 24px rgba(0,0,0,.15);
            animation: mdelIn .24s cubic-bezier(.34,1.56,.64,1) both;
            position: relative; overflow: hidden;
        }
        .mdel-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #ef4444, #dc2626, #b91c1c); }
        @keyframes mdelIn { from { opacity:0; transform:scale(.88) translateY(16px); } to { opacity:1; transform:scale(1) translateY(0); } }
        .mdel-body { padding: 2.25rem 2rem 1.5rem; }
        .mdel-icon { width: 76px; height: 76px; border-radius: 50%; background: rgba(239,68,68,.1); border: 2px solid rgba(239,68,68,.2); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem; animation: mdelPulse 2.5s ease-in-out infinite; }
        @keyframes mdelPulse { 0%,100% { box-shadow: 0 0 0 0 rgba(239,68,68,.35); } 50% { box-shadow: 0 0 0 12px rgba(239,68,68,0); } }
        .mdel-icon i { font-size: 1.9rem; color: #ef4444; }
        .mdel-title    { text-align: center; font-size: 1.25rem; font-weight: 800; color: #0f172a; margin: 0 0 .5rem; }
        .mdel-subtitle { text-align: center; font-size: .88rem; color: #64748b; margin: 0 0 1.25rem; line-height: 1.5; }
        .mdel-item { background: linear-gradient(135deg,#fff5f5,#fee2e2); border: 1px solid #fca5a5; border-radius: 11px; padding: .9rem 1rem; display: flex; align-items: center; gap: .85rem; margin-bottom: 1.1rem; }
        .mdel-item-icon { width: 40px; height: 40px; border-radius: 9px; background: rgba(239,68,68,.12); display: flex; align-items: center; justify-content: center; color: #ef4444; font-size: 1rem; flex-shrink: 0; }
        .mdel-item-lbl  { font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: #ef4444; margin-bottom: .2rem; }
        .mdel-item-name { font-size: .95rem; font-weight: 700; color: #0f172a; }
        .mdel-warning { background: #fff7ed; border: 1px solid #fed7aa; border-radius: 9px; padding: .65rem .9rem; display: flex; gap: .5rem; align-items: flex-start; }
        .mdel-warning i    { color: #f59e0b; font-size: .82rem; margin-top: .18rem; flex-shrink: 0; }
        .mdel-warning span { font-size: .79rem; color: #92400e; line-height: 1.45; }
        .mdel-footer { padding: 1.1rem 1.5rem 1.5rem; display: flex; gap: .75rem; border-top: 1px solid #f1f5f9; }
        .mdel-btn-cancel { flex: 1; padding: .65rem 1rem; border-radius: 10px; border: 1.5px solid #e2e8f0; background: white; color: #64748b; font-weight: 600; font-size: .86rem; cursor: pointer; font-family: inherit; transition: all .15s; display: flex; align-items: center; justify-content: center; gap: .4rem; }
        .mdel-btn-cancel:hover { background: #f8fafc; border-color: #cbd5e1; color: #334155; }
        .mdel-btn-confirm { flex: 1; padding: .65rem 1rem; border-radius: 10px; border: none; background: linear-gradient(135deg,#ef4444,#b91c1c); color: white; font-weight: 700; font-size: .86rem; cursor: pointer; font-family: inherit; box-shadow: 0 4px 14px rgba(239,68,68,.4); transition: all .15s; display: flex; align-items: center; justify-content: center; gap: .4rem; }
        .mdel-btn-confirm:hover { opacity: .92; transform: translateY(-1px); }

        /* ── DARK MODE ── */
        body.dark-mode { background-color: #0f172a !important; color: #f1f5f9 !important; }
        body.dark-mode .sidebar { background: linear-gradient(180deg, #020617 0%, #0f172a 100%) !important; }
        body.dark-mode .topbar { background: #1e293b !important; border-bottom: 1px solid #334155 !important; }
        body.dark-mode .main-content, body.dark-mode .content-wrapper { background: #0f172a !important; }
        body.dark-mode .topbar-left h5 { color: #e2e8f0 !important; }
        body.dark-mode .topbar-divider { background: #334155 !important; }
        body.dark-mode .card, body.dark-mode .welcome-card, body.dark-mode .adm-card,
        body.dark-mode .adm-stat, body.dark-mode .est-stat, body.dark-mode .stat-card,
        body.dark-mode .action-card, body.dark-mode .info-card, body.dark-mode .modal-content,
        body.dark-mode .adm-toolbar { background-color: #1e293b !important; border-color: #334155 !important; color: #f1f5f9 !important; }
        body.dark-mode .card-header  { border-color: #334155 !important; }
        body.dark-mode .card-footer  { background: #1e293b !important; border-color: #334155 !important; }
        body.dark-mode h1,body.dark-mode h2,body.dark-mode h3,body.dark-mode h4,
        body.dark-mode h5,body.dark-mode h6,body.dark-mode .welcome-title,
        body.dark-mode .stat-value,body.dark-mode .action-title,body.dark-mode .card-title,
        body.dark-mode .fw-bold,body.dark-mode .text-dark,body.dark-mode strong { color: #ffffff !important; }
        body.dark-mode .text-muted,body.dark-mode .stat-label,body.dark-mode .welcome-subtitle,
        body.dark-mode label,body.dark-mode p,body.dark-mode small { color: #cbd5e1 !important; }
        body.dark-mode .table { color: #f1f5f9 !important; background: transparent !important; }
        body.dark-mode .table td,body.dark-mode .table th { color: #e2e8f0 !important; }
        body.dark-mode .table thead th { background: #1e293b !important; color: #4ec7d2 !important; border-bottom: 2px solid #334155 !important; }
        body.dark-mode .table td { border-bottom-color: #334155 !important; }
        body.dark-mode .table-hover > tbody > tr:hover > * { background-color: rgba(78,199,210,.07) !important; }
        body.dark-mode .form-control,body.dark-mode .form-select { background-color: #0f172a !important; border-color: #334155 !important; color: #f1f5f9 !important; }
        body.dark-mode .form-control:focus,body.dark-mode .form-select:focus { border-color: #4ec7d2 !important; box-shadow: 0 0 0 3px rgba(78,199,210,.15) !important; }
        body.dark-mode .alert { background-color: #1e293b !important; border-color: #334155 !important; color: #f1f5f9 !important; }
        body.dark-mode .page-link { background-color: #1e293b !important; border-color: #334155 !important; color: #4ec7d2 !important; }
        body.dark-mode .page-item.active .page-link { background-color: #00508f !important; color: #fff !important; }
        body.dark-mode .dropdown-menu { background-color: #1e293b !important; border-color: #334155 !important; }
        body.dark-mode .dropdown-item { color: #f1f5f9 !important; }
        body.dark-mode .dropdown-item:hover { background-color: #334155 !important; }
        body.dark-mode .btn-toggle-dark { background: #334155 !important; color: #fbbf24 !important; border-color: #475569 !important; }
        body.dark-mode .sys-alert { background: #1e293b !important; }
        body.dark-mode .sys-alert.success  { color: #6ee7b7 !important; }
        body.dark-mode .sys-alert.error    { color: #fca5a5 !important; }
        body.dark-mode .sys-alert.warning  { color: #fcd34d !important; }
        body.dark-mode .sys-alert.info     { color: #67e8f9 !important; }
        body.dark-mode .sys-alert.credential { color: #a5b4fc !important; }
        body.dark-mode .sys-alert-close    { background: rgba(255,255,255,.08) !important; color: inherit !important; }
        body.dark-mode .mdel-card  { background: #1e293b !important; }
        body.dark-mode .mdel-title { color: #f1f5f9 !important; }
        body.dark-mode .mdel-subtitle { color: #94a3b8 !important; }
        body.dark-mode .mdel-footer { border-top-color: #334155 !important; }
        body.dark-mode .mdel-btn-cancel { background: #0f172a !important; border-color: #334155 !important; color: #94a3b8 !important; }
        body.dark-mode .menu-sub { background: rgba(0,0,0,.25) !important; }
        body.dark-mode .menu-group-toggle.open { background: rgba(78,199,210,.08) !important; }
    </style>

    @stack('styles')
</head>
<body>

@php
    $user         = auth()->user();

    $isSuperAdmin = $user && ($user->is_super_admin == 1 || $user->id_rol == 1);
    $isAdmin      = $user && in_array($user->id_rol, [1, 2, 3]);
    // Sidebar visible para cualquier usuario autenticado
    $showSidebar  = $isAdmin;

    $roleName = $isSuperAdmin
        ? 'Super Administrador'
        : ($isAdmin
            ? 'Administrador'
            : ucfirst($user->user_type ?? 'Usuario'));

    // Helper para saber si una ruta esta activa
    $active = fn($routes) => request()->routeIs(...(array)$routes) ? 'active' : '';
@endphp

@if($showSidebar)
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>
<aside class="sidebar" id="sidebar">

    {{-- Logo --}}
    <div class="sidebar-header">
        <a href="{{ $isSuperAdmin ? route('superadmin.dashboard') : route('admin.dashboard') }}" class="sidebar-logo">
            <i class="fas fa-graduation-cap"></i>
            <div class="logo-text">
                <h4>Escuela G.M.</h4>
                <p>Sistema de Gesti&oacute;n</p>
            </div>
        </a>
    </div>

    {{-- Usuario --}}
    <div class="user-info">
        <div class="user-avatar">{{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}</div>
        <div class="user-details">
            <h6>{{ $user->name ?? 'Usuario' }}</h6>
            <p>{{ $roleName }}</p>
        </div>
    </div>

    <ul class="sidebar-menu">

        {{-- ══ PRINCIPAL ══ --}}
        <li class="menu-section-title">PRINCIPAL</li>
        <li class="menu-item">
            <a href="{{ $isSuperAdmin ? route('superadmin.dashboard') : route('admin.dashboard') }}"
               class="menu-link {{ $active(['superadmin.dashboard','admin.dashboard']) }}">
                <i class="fas fa-chart-line"></i><span>Dashboard</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('calendario.index') }}"
               class="menu-link {{ $active(['calendario.index','calendario.*']) }}">
                <i class="fas fa-calendar-week"></i><span>Calendario Acad&eacute;mico</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('acciones_importantes.index') }}"
               class="menu-link {{ $active('acciones_importantes.*') }}">
                <i class="fas fa-bell"></i><span>Acciones Recientes</span>
            </a>
        </li>

        {{-- ══ USUARIOS ══ --}}
        <li class="menu-section-title">USUARIOS</li>

        {{-- Administradores (solo superadmin) --}}
        @if($isSuperAdmin)
        <li class="menu-group">
            <div class="menu-group-toggle {{ request()->routeIs('superadmin.usuarios.*','superadmin.administradores.*') ? 'open' : '' }}"
                 onclick="toggleGroup(this)">
                <i class="fas fa-user-shield icon-main"></i>
                <span>Administraci&oacute;n</span>
                <i class="fas fa-chevron-down arrow"></i>
            </div>
            <ul class="menu-sub {{ request()->routeIs('superadmin.usuarios.*','superadmin.administradores.*') ? 'open' : '' }}">
                <li class="menu-item">
                    <a href="{{ route('superadmin.administradores.index') }}"
                       class="menu-link {{ $active('superadmin.administradores.*') }}">
                        <i class="fas fa-user-tie"></i><span>Administradores</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('superadmin.usuarios.index') }}"
                       class="menu-link {{ $active('superadmin.usuarios.*') }}">
                        <i class="fas fa-users-cog"></i><span>Usuarios del Sistema</span>
                    </a>
                </li>
            </ul>
        </li>
        @endif

        {{-- Estudiantes --}}
        <li class="menu-group">
            <div class="menu-group-toggle {{ request()->routeIs('estudiantes.*') ? 'open' : '' }}"
                 onclick="toggleGroup(this)">
                <i class="fas fa-user-graduate icon-main"></i>
                <span>Estudiantes</span>
                <i class="fas fa-chevron-down arrow"></i>
            </div>
            <ul class="menu-sub {{ request()->routeIs('estudiantes.*') ? 'open' : '' }}">
                <li class="menu-item">
                    <a href="{{ route('estudiantes.index') }}"
                       class="menu-link {{ $active('estudiantes.index') }}">
                        <i class="fas fa-list"></i><span>Listado</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('estudiantes.create') }}"
                       class="menu-link {{ $active('estudiantes.create') }}">
                        <i class="fas fa-user-plus"></i><span>Nuevo Estudiante</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('estudiantes.buscar') }}"
                       class="menu-link {{ $active('estudiantes.buscar') }}">
                        <i class="fas fa-search"></i><span>Buscar Estudiante</span>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Profesores --}}
        <li class="menu-group">
            <div class="menu-group-toggle {{ request()->routeIs('profesores.*','carga-docente.*','profesor_materia_grado.*') ? 'open' : '' }}"
                 onclick="toggleGroup(this)">
                <i class="fas fa-chalkboard-teacher icon-main"></i>
                <span>Profesores</span>
                <i class="fas fa-chevron-down arrow"></i>
            </div>
            <ul class="menu-sub {{ request()->routeIs('profesores.*','carga-docente.*','profesor_materia_grado.*') ? 'open' : '' }}">
                <li class="menu-item">
                    <a href="{{ route('profesores.index') }}"
                       class="menu-link {{ $active('profesores.index') }}">
                        <i class="fas fa-list"></i><span>Listado</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('profesores.create') }}"
                       class="menu-link {{ $active('profesores.create') }}">
                        <i class="fas fa-user-plus"></i><span>Nuevo Profesor</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('profesor_materia_grado.index') }}"
                       class="menu-link {{ $active('profesor_materia_grado.*') }}">
                        <i class="fas fa-user-tag"></i><span>Asignaci&oacute;n de Materias</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('carga-docente.index') }}"
                       class="menu-link {{ $active('carga-docente.*') }}">
                        <i class="fas fa-chart-bar"></i><span>Carga Docente</span>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Padres --}}
        <li class="menu-group">
            <div class="menu-group-toggle {{ request()->routeIs('padres.*','admins.permisos.*') ? 'open' : '' }}"
                 onclick="toggleGroup(this)">
                <i class="fas fa-user-friends icon-main"></i>
                <span>Padres / Tutores</span>
                <i class="fas fa-chevron-down arrow"></i>
            </div>
            <ul class="menu-sub {{ request()->routeIs('padres.*','admins.permisos.*') ? 'open' : '' }}">
                <li class="menu-item">
                    <a href="{{ route('padres.index') }}"
                       class="menu-link {{ $active('padres.index') }}">
                        <i class="fas fa-list"></i><span>Listado</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('padres.create') }}"
                       class="menu-link {{ $active('padres.create') }}">
                        <i class="fas fa-user-plus"></i><span>Nuevo Padre / Tutor</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admins.permisos.index') }}"
                       class="menu-link {{ $active('admins.permisos.*') }}">
                        <i class="fas fa-user-lock"></i><span>Permisos de Acceso</span>
                    </a>
                </li>
            </ul>
        </li>

        {{-- ══ ACADEMICO ══ --}}
        <li class="menu-section-title">ACAD&Eacute;MICO</li>

        {{-- Estructura academica --}}
        <li class="menu-group">
            <div class="menu-group-toggle {{ request()->routeIs('grados.*','superadmin.grados.*','materias.*','superadmin.materias.*','secciones.*','ciclos.*','periodos-academicos.*') ? 'open' : '' }}"
                 onclick="toggleGroup(this)">
                <i class="fas fa-school icon-main"></i>
                <span>Estructura Escolar</span>
                <i class="fas fa-chevron-down arrow"></i>
            </div>
            <ul class="menu-sub {{ request()->routeIs('grados.*','superadmin.grados.*','materias.*','superadmin.materias.*','secciones.*','ciclos.*','periodos-academicos.*') ? 'open' : '' }}">
                <li class="menu-item">
                    <a href="{{ $isSuperAdmin ? route('superadmin.grados.index') : route('grados.index') }}"
                       class="menu-link {{ $active(['grados.*','superadmin.grados.*']) }}">
                        <i class="fas fa-layer-group"></i><span>Grados</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ $isSuperAdmin ? route('superadmin.materias.index') : route('materias.index') }}"
                       class="menu-link {{ $active(['materias.*','superadmin.materias.*']) }}">
                        <i class="fas fa-book"></i><span>Materias</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('secciones.index') }}"
                       class="menu-link {{ $active('secciones.*') }}">
                        <i class="fas fa-sitemap"></i><span>Secciones</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('periodos-academicos.index') }}"
                       class="menu-link {{ $active('periodos-academicos.*') }}">
                        <i class="fas fa-calendar-alt"></i><span>Per&iacute;odos Acad&eacute;micos</span>
                    </a>
                </li>
                @if($isSuperAdmin)
                <li class="menu-item">
                    <a href="{{ route('superadmin.cupos_maximos.index') }}"
                       class="menu-link {{ $active('superadmin.cupos_maximos.*') }}">
                        <i class="fas fa-users-cog"></i><span>Cupos M&aacute;ximos</span>
                    </a>
                </li>
                @endif
            </ul>
        </li>

        {{-- Horarios --}}
        <li class="menu-group">
            <div class="menu-group-toggle {{ request()->routeIs('horarios_grado.*') ? 'open' : '' }}"
                 onclick="toggleGroup(this)">
                <i class="fas fa-clock icon-main"></i>
                <span>Horarios</span>
                <i class="fas fa-chevron-down arrow"></i>
            </div>
            <ul class="menu-sub {{ request()->routeIs('horarios_grado.*') ? 'open' : '' }}">
                <li class="menu-item">
                    <a href="{{ route('horarios_grado.gestionar') }}"
                       class="menu-link {{ $active('horarios_grado.gestionar') }}">
                        <i class="fas fa-calendar-plus"></i><span>Gestionar Horarios</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('horarios_grado.index') }}"
                       class="menu-link {{ $active(['horarios_grado.index','horarios_grado.show','horarios_grado.edit']) }}">
                        <i class="fas fa-calendar-alt"></i><span>Ver Horarios</span>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Cursos --}}
        <li class="menu-group">
            <div class="menu-group-toggle {{ request()->routeIs('h20cursos.*','consultaestudiantesxcurso.*') ? 'open' : '' }}"
                 onclick="toggleGroup(this)">
                <i class="fas fa-chalkboard icon-main"></i>
                <span>Cursos</span>
                <i class="fas fa-chevron-down arrow"></i>
            </div>
            <ul class="menu-sub {{ request()->routeIs('h20cursos.*','consultaestudiantesxcurso.*') ? 'open' : '' }}">
                <li class="menu-item">
                    <a href="{{ route('h20cursos.index') }}"
                       class="menu-link {{ $active('h20cursos.index') }}">
                        <i class="fas fa-graduation-cap"></i><span>Secundaria</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('consultaestudiantesxcurso.index') }}"
                       class="menu-link {{ $active('consultaestudiantesxcurso.*') }}">
                        <i class="fas fa-users"></i><span>Estudiantes por Curso</span>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Asistencias y Notas --}}
        <li class="menu-group">
            <div class="menu-group-toggle {{ request()->routeIs('asistencias.*','registrarcalificaciones.*') ? 'open' : '' }}"
                 onclick="toggleGroup(this)">
                <i class="fas fa-clipboard-check icon-main"></i>
                <span>Asistencias y Notas</span>
                <i class="fas fa-chevron-down arrow"></i>
            </div>
            <ul class="menu-sub {{ request()->routeIs('asistencias.*','registrarcalificaciones.*') ? 'open' : '' }}">
                <li class="menu-item">
                    <a href="{{ route('asistencias.index') }}"
                       class="menu-link {{ $active('asistencias.*') }}">
                        <i class="fas fa-user-check"></i><span>Asistencias</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('registrarcalificaciones.index') }}"
                       class="menu-link {{ $active('registrarcalificaciones.*') }}">
                        <i class="fas fa-pen-alt"></i><span>Calificaciones</span>
                    </a>
                </li>
            </ul>
        </li>

        {{-- ══ MATRICULAS ══ --}}
        <li class="menu-section-title">MATR&Iacute;CULAS</li>
        <li class="menu-group">
            <div class="menu-group-toggle {{ request()->routeIs('matriculas.*','admin.solicitudes.*') ? 'open' : '' }}"
                 onclick="toggleGroup(this)">
                <i class="fas fa-clipboard-list icon-main"></i>
                <span>Matr&iacute;culas</span>
                <i class="fas fa-chevron-down arrow"></i>
            </div>
            <ul class="menu-sub {{ request()->routeIs('matriculas.*','admin.solicitudes.*') ? 'open' : '' }}">
                <li class="menu-item">
                    <a href="{{ route('matriculas.index') }}"
                       class="menu-link {{ $active('matriculas.index') }}">
                        <i class="fas fa-list"></i><span>Listado</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('matriculas.create') }}"
                       class="menu-link {{ $active('matriculas.create') }}">
                        <i class="fas fa-plus"></i><span>Nueva Matr&iacute;cula</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.solicitudes.index') }}"
                       class="menu-link {{ $active('admin.solicitudes.*') }}">
                        <i class="fas fa-inbox"></i><span>Solicitudes</span>
                    </a>
                </li>
            </ul>
        </li>

        {{-- ══ DOCUMENTACION ══ --}}
        <li class="menu-section-title">DOCUMENTACI&Oacute;N</li>
        <li class="menu-group">
            <div class="menu-group-toggle {{ request()->routeIs('observaciones.*','documentos.*') ? 'open' : '' }}"
                 onclick="toggleGroup(this)">
                <i class="fas fa-folder icon-main"></i>
                <span>Documentos</span>
                <i class="fas fa-chevron-down arrow"></i>
            </div>
            <ul class="menu-sub {{ request()->routeIs('observaciones.*','documentos.*') ? 'open' : '' }}">
                <li class="menu-item">
                    <a href="{{ route('observaciones.index') }}"
                       class="menu-link {{ $active('observaciones.*') }}">
                        <i class="fas fa-sticky-note"></i><span>Observaciones</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('documentos.index') }}"
                       class="menu-link {{ $active('documentos.*') }}">
                        <i class="fas fa-folder-open"></i><span>Documentos</span>
                    </a>
                </li>
            </ul>
        </li>

        {{-- ══ CONFIGURACION ══ --}}
        <li class="menu-section-title">CONFIGURACI&Oacute;N</li>
        @if($isSuperAdmin)
        <li class="menu-item">
            <a href="{{ route('superadmin.perfil') }}"
               class="menu-link {{ $active('superadmin.perfil') }}">
                <i class="fas fa-user-circle"></i><span>Mi Perfil</span>
            </a>
        </li>
        @endif
        <li class="menu-item">
            <a href="{{ route('cambiarcontrasenia.edit') }}"
               class="menu-link {{ $active('cambiarcontrasenia.*') }}">
                <i class="fas fa-key"></i><span>Cambiar Contrase&ntilde;a</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('notificaciones.index') }}"
               class="menu-link {{ $active('notificaciones.*') }}">
                <i class="fas fa-bell"></i><span>Notificaciones</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('estado-solicitud') }}"
               class="menu-link {{ $active('estado-solicitud') }}">
                <i class="fas fa-question-circle"></i><span>Estado de Solicitud</span>
            </a>
        </li>

    </ul>
</aside>
@endif

<div class="main-content {{ !$showSidebar ? 'no-sidebar' : '' }}">
    <div class="topbar">
        <div class="topbar-left">
            @if($showSidebar)
                <button class="mobile-menu-btn btn btn-sm btn-primary d-md-none" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
            @endif
            <h5>@yield('page-title', 'Panel de Control')</h5>
        </div>
        <div class="topbar-right">
            @if(View::hasSection('topbar-actions'))
                <div class="topbar-actions-group">@yield('topbar-actions')</div>
                <div class="topbar-divider"></div>
            @endif
            <button id="globalDarkModeToggle" class="btn-toggle-dark">
                <i class="fas fa-moon" id="globalDarkIcon"></i>
                <span id="globalDarkText" class="d-none d-md-inline">Modo Oscuro</span>
            </button>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="d-none d-md-inline">Cerrar Sesi&oacute;n</span>
                </button>
            </form>
        </div>
    </div>
    <div class="content-wrapper">@yield('content')</div>
</div>

<div id="sys-alerts-container"></div>

{{-- Modal Eliminar --}}
<div id="modalDelete" onclick="cerrarModalDelete()">
    <div class="mdel-card" onclick="event.stopPropagation()">
        <div class="mdel-body">
            <div class="mdel-icon"><i class="fas fa-trash-alt"></i></div>
            <h5 class="mdel-title">&iquest;Confirmar eliminaci&oacute;n?</h5>
            <p class="mdel-subtitle">Esta acci&oacute;n no se puede deshacer.</p>
            <div class="mdel-item">
                <div class="mdel-item-icon"><i class="fas fa-user-graduate"></i></div>
                <div>
                    <div class="mdel-item-lbl">Elemento a eliminar</div>
                    <div class="mdel-item-name" id="mdelNombre">&mdash;</div>
                </div>
            </div>
            <div class="mdel-warning">
                <i class="fas fa-exclamation-triangle"></i>
                <span>Una vez eliminado, <strong>no podr&aacute;s recuperar</strong> este registro.</span>
            </div>
        </div>
        <div class="mdel-footer">
            <button type="button" class="mdel-btn-cancel" onclick="cerrarModalDelete()">
                <i class="fas fa-times"></i> Cancelar
            </button>
            <form id="formDelete" method="POST" style="flex:1;margin:0;">
                @csrf @method('DELETE')
                <button type="submit" class="mdel-btn-confirm" style="width:100%;">
                    <i class="fas fa-trash-alt"></i> S&iacute;, eliminar
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Modal confirmacion generico --}}
<div id="sys-modal" style="display:none;position:fixed;inset:0;z-index:99998;
     background:rgba(0,45,90,.5);backdrop-filter:blur(4px);
     align-items:center;justify-content:center;">
    <div style="background:white;border-radius:16px;padding:2rem 1.8rem;
                max-width:400px;width:90%;box-shadow:0 24px 60px rgba(0,45,90,.35);">
        <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.4rem;">
            <div style="width:50px;height:50px;border-radius:13px;flex-shrink:0;
                        background:linear-gradient(135deg,#002d5a,#00508f);
                        display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-question" style="color:white;font-size:1.2rem;"></i>
            </div>
            <p id="sys-modal-msg" style="font-size:.9rem;font-weight:600;color:#003b73;margin:0;line-height:1.4;"></p>
        </div>
        <div style="display:flex;gap:.65rem;justify-content:flex-end;">
            <button id="sys-modal-cancel"
                    style="padding:.5rem 1.3rem;border-radius:8px;font-size:.82rem;font-weight:600;
                           border:1.5px solid #d1d9e6;background:white;color:#64748b;cursor:pointer;">
                <i class="fas fa-times me-1"></i>Cancelar
            </button>
            <button id="sys-modal-ok"
                    style="padding:.5rem 1.3rem;border-radius:8px;font-size:.82rem;font-weight:700;
                           border:none;background:linear-gradient(135deg,#002d5a,#00508f);color:white;cursor:pointer;">
                <i class="fas fa-check me-1"></i>Confirmar
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>

/* ── Sidebar movil ── */
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('active');
    document.getElementById('sidebarOverlay').classList.toggle('active');
}

/* ── Submenus colapsables ── */
function toggleGroup(toggle) {
    var isOpen = toggle.classList.contains('open');
    var sub    = toggle.nextElementSibling;

    // Cerrar todos los demas del mismo nivel
    document.querySelectorAll('.menu-group-toggle.open').forEach(function(t) {
        if (t !== toggle) {
            t.classList.remove('open');
            t.nextElementSibling.classList.remove('open');
        }
    });

    toggle.classList.toggle('open', !isOpen);
    sub.classList.toggle('open', !isOpen);
    saveMenuState();
}

function saveMenuState() {
    var openGroups = [];
    document.querySelectorAll('.menu-group-toggle.open').forEach(function(t) {
        openGroups.push(t.querySelector('span').textContent.trim());
    });
    sessionStorage.setItem('sidebar_open_groups', JSON.stringify(openGroups));
}

// Restaurar estado al cargar
document.addEventListener('DOMContentLoaded', function() {
    var saved = [];
    try { saved = JSON.parse(sessionStorage.getItem('sidebar_open_groups') || '[]'); } catch(e){}
    document.querySelectorAll('.menu-group-toggle').forEach(function(t) {
        var label = t.querySelector('span').textContent.trim();
        if (saved.includes(label) && !t.classList.contains('open')) {
            t.classList.add('open');
            t.nextElementSibling.classList.add('open');
        }
    });
});

/* ── Dark Mode ── */
(function () {
    var btn  = document.getElementById('globalDarkModeToggle');
    var icon = document.getElementById('globalDarkIcon');
    var text = document.getElementById('globalDarkText');
    function aplicar(isDark) {
        document.body.classList.toggle('dark-mode', isDark);
        document.documentElement.setAttribute('data-theme', isDark ? 'dark' : 'light');
        icon.className = isDark ? 'fas fa-sun'  : 'fas fa-moon';
        text.innerText = isDark ? 'Modo Claro'  : 'Modo Oscuro';
    }
    aplicar(localStorage.getItem('theme') !== 'light');
    btn.addEventListener('click', function () {
        var isDark = !document.body.classList.contains('dark-mode');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
        aplicar(isDark);
    });
})();

/* ── Alertas flotantes ── */
function sysAlert(type, message, persistent, duration) {
    var icons  = { success:'fa-check-circle', error:'fa-times-circle', warning:'fa-exclamation-triangle', info:'fa-info-circle', credential:'fa-key' };
    var titles = { success:'&Eacute;xito', error:'Error', warning:'Advertencia', info:'Informaci&oacute;n', credential:'Credenciales' };
    var ms     = persistent ? 0 : (duration || 4500);
    var t      = type || 'success';
    var container = document.getElementById('sys-alerts-container');
    var el = document.createElement('div');
    el.className = 'sys-alert ' + t + (persistent ? ' persistent' : '');
    var barHtml    = !persistent ? '<div class="sys-alert-bar" style="animation:sysBar ' + ms + 'ms linear forwards;"></div>' : '';
    var stickyHtml = persistent  ? '<div class="sys-alert-sticky"><i class="fas fa-thumbtack"></i> Cierra manualmente</div>' : '';
    el.innerHTML =
        '<div class="sys-alert-icon"><i class="fas ' + (icons[t] || icons.success) + '"></i></div>' +
        '<div class="sys-alert-body"><div class="sys-alert-title">' + (titles[t]||'Aviso') + '</div>' +
        '<div class="sys-alert-msg">' + message + '</div>' + stickyHtml + '</div>' +
        '<button class="sys-alert-close" onclick="dismissAlert(this.parentElement)"><i class="fas fa-times"></i></button>' +
        barHtml;
    container.appendChild(el);
    if (!persistent) setTimeout(function () { dismissAlert(el); }, ms);
}
var styleBar = document.createElement('style');
styleBar.textContent = '@keyframes sysBar { from { width:100%; } to { width:0%; } }';
document.head.appendChild(styleBar);
function dismissAlert(el) {
    if (!el || !el.parentElement) return;
    el.classList.add('leaving');
    setTimeout(function () { if (el.parentElement) el.parentElement.removeChild(el); }, 300);
}

document.addEventListener('DOMContentLoaded', function () {
    @if(session('success'))
    var _msg = @json(session('success'));
    sysAlert(/correo|contrase|password|codigo|clave|acceso/i.test(_msg) ? 'credential' : 'success', _msg, /correo|contrase|password|codigo|clave|acceso/i.test(_msg));
    @endif
    @if(session('error'))   sysAlert('error',   @json(session('error')),   false, 6000); @endif
    @if(session('warning')) sysAlert('warning', @json(session('warning')), false, 5500); @endif
    @if(session('info'))    sysAlert('info',    @json(session('info')),    false, 5000); @endif
    @if(session('deleted')) sysAlert('error',   @json(session('deleted'))); @endif
    @if(session('updated')) sysAlert('warning', @json(session('updated'))); @endif
    @if(session('conflictos'))
    @json(session('conflictos')).forEach(function(msg) { sysAlert('error', msg, true); });
    @endif
});

/* ── Modal Eliminar ── */
function mostrarModalDelete(url, nombre) {
    document.getElementById('formDelete').action = url;
    document.getElementById('mdelNombre').textContent = nombre || '—';
    document.getElementById('modalDelete').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function cerrarModalDelete() {
    document.getElementById('modalDelete').style.display = 'none';
    document.body.style.overflow = '';
}
document.addEventListener('keydown', function (e) { if (e.key === 'Escape') cerrarModalDelete(); });

/* ── sysConfirm ── */
function sysConfirm(msg, onOk) {
    var modal  = document.getElementById('sys-modal');
    var okBtn  = document.getElementById('sys-modal-ok');
    var canBtn = document.getElementById('sys-modal-cancel');
    document.getElementById('sys-modal-msg').textContent = msg;
    modal.style.display = 'flex';
    function cleanup() { modal.style.display='none'; okBtn.removeEventListener('click',yes); canBtn.removeEventListener('click',no); modal.removeEventListener('click',backdrop); }
    function yes()       { cleanup(); onOk(); }
    function no()        { cleanup(); }
    function backdrop(e) { if (e.target===modal) no(); }
    okBtn.addEventListener('click', yes);
    canBtn.addEventListener('click', no);
    modal.addEventListener('click', backdrop);
}

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('form[data-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            if (this._sysOk) return;
            e.preventDefault();
            var f = this;
            sysConfirm(f.dataset.confirm, function () { f._sysOk = true; HTMLFormElement.prototype.submit.call(f); });
        });
    });
});

/* ── Preservar pagina en filtros ── */
(function () {
    var page = new URLSearchParams(window.location.search).get('page');
    if (!page || page === '1') return;
    document.querySelectorAll('form').forEach(function(form) {
        if (!form.querySelector('input[name="page"]')) {
            var h = document.createElement('input');
            h.type='hidden'; h.name='page'; h.value=page;
            form.appendChild(h);
        }
    });
})();

/* ── Guardar scroll del sidebar ── */
(function () {
    var sidebar = document.querySelector('.sidebar');
    if (!sidebar) return;
    var saved = sessionStorage.getItem('sidebar_scroll');
    if (saved) sidebar.scrollTop = parseInt(saved, 10);
    window.addEventListener('beforeunload', function () {
        sessionStorage.setItem('sidebar_scroll', sidebar.scrollTop);
    });
})();
</script>

@stack('scripts')
</body>
</html>