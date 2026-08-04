@extends('layouts.app')

@section('title', 'Lista de usuarios')
@section('page-title', 'Usuarios del Sistema')

@section('topbar-actions')
    <a href="{{ route('superadmin.usuarios.create') }}" class="usr-topbar-btn">
        <i class="fas fa-user-plus"></i>
        <span class="usr-btn-text">Nuevo Usuario</span>
    </a>
@endsection

@push('styles')
<style>
    /* ── Botón topbar ── */
    .usr-topbar-btn {
        display: inline-flex; align-items: center; gap: .45rem;
        background: linear-gradient(135deg,#4ec7d2 0%,#00508f 100%);
        color: white; padding: .5rem .9rem; border-radius: 8px;
        text-decoration: none; font-weight: 600; font-size: .83rem;
        box-shadow: 0 2px 8px rgba(78,199,210,0.3); white-space: nowrap;
    }
    .usr-topbar-btn:hover { opacity: .88; color: white; }
    @media(max-width: 600px) {
        .usr-btn-text { display: none; }
        .usr-topbar-btn { padding: .5rem .65rem; }
    }

    /* ── Variables ── */
    :root {
        --blue-dark:   #003b73;
        --blue-mid:    #00508f;
        --teal:        #4ec7d2;
        --teal-light:  rgba(78,199,210,0.12);
        --border:      #e8edf4;
        --surface:     #f5f8fc;
        --text-main:   #0d2137;
        --text-muted:  #6b7a90;
        --green:       #10b981;
        --amber:       #f59e0b;
        --red:         #ef4444;
        --slate:       #475569;
        --radius-lg:   14px;
        --radius-sm:   7px;
        --shadow-sm:   0 1px 4px rgba(0,59,115,0.07);
        --shadow-md:   0 4px 16px rgba(0,59,115,0.10);
    }

    /* ── Stats ── */
    .usr-stats {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    @media(max-width:1100px){ .usr-stats { grid-template-columns: repeat(3, 1fr); } }
    @media(max-width:700px) { .usr-stats { grid-template-columns: repeat(2, 1fr); } }
    @media(max-width:420px) { .usr-stats { grid-template-columns: 1fr 1fr; gap:.65rem; } }

    .usr-stat {
        background: white; border-radius: var(--radius-lg);
        border: 1px solid var(--border); padding: 1rem 1.1rem;
        display: flex; align-items: center; gap: .85rem;
        box-shadow: var(--shadow-sm); transition: transform .2s, box-shadow .2s;
        position: relative; overflow: hidden;
    }
    .usr-stat::before {
        content: ''; position: absolute; top: 0; left: 0;
        width: 4px; height: 100%; border-radius: 4px 0 0 4px;
    }
    .usr-stat-total::before    { background: var(--teal); }
    .usr-stat-admin::before    { background: var(--slate); }
    .usr-stat-profesor::before { background: var(--teal); }
    .usr-stat-alumno::before   { background: var(--blue-mid); }
    .usr-stat-padre::before    { background: var(--green); }
    .usr-stat:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

    .usr-stat-icon {
        width: 42px; height: 42px; border-radius: 11px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-size: 1.05rem;
    }
    .usr-stat-total    .usr-stat-icon { background: var(--teal-light);           color: var(--teal); }
    .usr-stat-admin    .usr-stat-icon { background: rgba(71,85,105,.12);          color: var(--slate); }
    .usr-stat-profesor .usr-stat-icon { background: rgba(78,199,210,.15);         color: var(--blue-mid); }
    .usr-stat-alumno   .usr-stat-icon { background: rgba(0,80,143,.1);            color: var(--blue-mid); }
    .usr-stat-padre    .usr-stat-icon { background: rgba(16,185,129,.12);         color: var(--green); }

    .usr-stat-lbl { font-size: .65rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--text-muted); margin-bottom: .15rem; }
    .usr-stat-num { font-size: 1.65rem; font-weight: 800; color: var(--blue-dark); line-height: 1; margin-bottom: .1rem; }
    .usr-stat-sub { font-size: .7rem; color: var(--text-muted); }

    /* ── Filtros ── */
    .usr-filter {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); padding: 1rem 1.25rem;
        margin-bottom: 1.25rem; box-shadow: var(--shadow-sm);
    }
    .filter-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr auto;
        gap: .65rem; align-items: end;
    }
    @media(max-width:800px){ .filter-grid { grid-template-columns: 1fr 1fr; } }
    @media(max-width:480px){ .filter-grid { grid-template-columns: 1fr; } }

    .filter-label {
        font-size: .7rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .05em; color: var(--blue-dark);
        margin-bottom: .35rem; display: block;
    }
    .filter-input, .filter-select {
        width: 100%; padding: .45rem .8rem;
        border: 2px solid #bfd9ea; border-radius: 8px;
        font-size: .85rem; font-family: inherit;
        color: var(--text-main); outline: none;
        transition: border-color .2s, box-shadow .2s; background: white;
    }
    .filter-input:focus, .filter-select:focus {
        border-color: var(--teal); box-shadow: 0 0 0 3px rgba(78,199,210,.12);
    }
    .filter-btn {
        display: inline-flex; align-items: center; justify-content: center; gap: .35rem;
        padding: .45rem 1rem; border-radius: 8px;
        background: linear-gradient(135deg, var(--teal), var(--blue-mid));
        color: #fff; border: none; font-size: .82rem; font-weight: 600;
        cursor: pointer; white-space: nowrap; width: 100%; font-family: inherit;
    }
    .filter-btn:hover { opacity: .88; }
    .filter-clear {
        font-size: .75rem; color: var(--text-muted); text-decoration: none;
        display: inline-flex; align-items: center; gap: .3rem; margin-top: .5rem;
        transition: color .15s;
    }
    .filter-clear:hover { color: var(--red); }

    /* ── Tabla card ── */
    .usr-card {
        background: white; border: 1px solid var(--border);
        border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-sm);
    }
    .usr-card-head {
        background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-mid) 100%);
        padding: .9rem 1.4rem; display: flex; align-items: center; gap: .6rem;
    }
    .usr-card-head i    { color: var(--teal); font-size: 1rem; }
    .usr-card-head span { color: white; font-weight: 700; font-size: .95rem; }

    /* ── Filtros por rol (tabs) ── */
    .usr-tabs {
        padding: .85rem 1.4rem .25rem;
        display: flex; flex-wrap: wrap; gap: .45rem;
        border-bottom: 1px solid var(--border);
    }
    .usr-tab {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .38rem .8rem; border-radius: 999px;
        font-size: .75rem; font-weight: 700; text-decoration: none;
        transition: all .2s;
    }
    .usr-tab i { font-size: .7rem; }
    .usr-tab-count {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 1.3rem; height: 1.3rem; border-radius: 999px; font-size: .65rem;
    }
    .usr-tab-active {
        background: linear-gradient(135deg,#4ec7d2,#00508f);
        color: white; border: 1.5px solid transparent;
        box-shadow: 0 2px 8px rgba(0,80,143,.25);
    }
    .usr-tab-active .usr-tab-count { background: rgba(255,255,255,.25); color: white; }
    .usr-tab-inactive {
        background: white; color: var(--blue-mid);
        border: 1.5px solid #bfd9ea;
    }
    .usr-tab-inactive .usr-tab-count { background: var(--border); color: var(--blue-mid); }
    .usr-tab-inactive:hover { background: var(--surface); border-color: var(--teal); }

    /* ── Scroll wrapper ── */
    .usr-tbl-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* ── Tabla ── */
    .usr-tbl { width: 100%; border-collapse: collapse; min-width: 720px; }
    .usr-tbl thead th {
        background: var(--surface); padding: .6rem .85rem;
        font-size: .67rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .06em; color: var(--text-muted);
        border-bottom: 1.5px solid var(--border); white-space: nowrap;
    }
    .usr-tbl thead th.tc { text-align: center; }
    .usr-tbl thead th.tr { text-align: right; }
    .usr-tbl tbody td {
        padding: .68rem .85rem; border-bottom: 1px solid #f1f5f9;
        font-size: .83rem; color: var(--text-main); vertical-align: middle;
    }
    .usr-tbl tbody td.tc { text-align: center; }
    .usr-tbl tbody td.tr { text-align: right; }
    .usr-tbl tbody tr:last-child td { border-bottom: none; }
    .usr-tbl tbody tr { transition: background .15s; }
    .usr-tbl tbody tr:hover { background: #f7fbff; }

    /* Número de fila */
    .row-num {
        width: 24px; height: 24px; border-radius: 6px;
        background: var(--surface); border: 1px solid var(--border);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: .7rem; font-weight: 700; color: var(--text-muted);
    }

    /* Avatar */
    .usr-av {
        width: 36px; height: 36px; border-radius: 9px; flex-shrink: 0;
        background: linear-gradient(135deg, var(--teal), var(--blue-mid));
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; color: #fff; font-size: .85rem;
        border: 2px solid rgba(78,199,210,.3);
    }
    .usr-name { font-weight: 600; color: var(--blue-dark); font-size: .85rem; }
    .usr-sub  { font-size: .71rem; color: var(--text-muted); margin-top: .1rem; }
    .usr-code { font-family: 'Courier New', monospace; font-size: .7rem; color: var(--blue-dark); font-weight: 700; }

    /* Badges rol */
    .bpill {
        display: inline-flex; align-items: center; gap: .22rem;
        padding: .2rem .6rem; border-radius: 999px;
        font-size: .7rem; font-weight: 600; white-space: nowrap;
    }
    .b-dark   { background: #1e293b; color: #e2e8f0; }
    .b-slate  { background: rgba(71,85,105,.12); color: #334155; border: 1px solid rgba(71,85,105,.25); }
    .b-cyan   { background: var(--teal-light); color: var(--blue-mid); border: 1px solid rgba(78,199,210,.35); }
    .b-blue   { background: rgba(0,80,143,.1); color: var(--blue-mid); border: 1px solid #bfd9ea; }
    .b-green  { background: rgba(16,185,129,.1); color: #059669; border: 1px solid rgba(16,185,129,.3); }
    .b-yellow { background: rgba(245,158,11,.1); color: #92400e; border: 1px solid rgba(245,158,11,.3); }
    .b-gray   { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }

    /* Badges estado */
    .b-activo    { background: #f0fdf4; color: #166534; border: 1px solid #86efac; }
    .b-pendiente { background: #fefce8; color: #854d0e; border: 1px solid #fde047; }

    /* Fecha */
    .usr-fecha { font-size: .76rem; color: var(--text-muted); }
    .usr-hora  { font-size: .68rem; color: #94a3b8; }

    /* ── Botones acción compactos ── */
    .act-wrap {
        display: inline-flex; gap: 3px;
        align-items: center; justify-content: flex-end; flex-wrap: nowrap;
    }
    .act-btn {
        width: 26px; height: 26px; border-radius: 6px;
        display: inline-flex; align-items: center; justify-content: center;
        border: 1.5px solid; font-size: .7rem;
        background: white; cursor: pointer;
        transition: all .15s; text-decoration: none;
        flex-shrink: 0; padding: 0;
    }
    .act-view { border-color: var(--blue-mid); color: var(--blue-mid); }
    .act-edit { border-color: var(--teal);     color: var(--teal); }
    .act-del  { border-color: #f87171;          color: #ef4444; }
    .act-view:hover { background: var(--blue-mid); color: white; }
    .act-edit:hover { background: var(--teal);     color: white; }
    .act-del:hover  { background: #ef4444;          color: white; }

    /* Alertas */
    .alert-temp {
        display: flex; align-items: flex-start; gap: .75rem;
        padding: .9rem 1.1rem; border-radius: 10px;
        background: rgba(78,199,210,.08);
        border: 1px solid #b2e8ed; color: #003b73;
        font-size: .83rem; margin-bottom: 1rem;
    }
    .alert-ok {
        padding: .9rem 1.1rem; border-radius: 10px;
        background: #f0fdf4; border: 1px solid #86efac;
        color: #166534; font-size: .83rem; margin-bottom: 1rem;
    }
    .alert-err {
        padding: .9rem 1.1rem; border-radius: 10px;
        background: #fef2f2; border: 1px solid #fca5a5;
        color: #991b1b; font-size: .83rem; margin-bottom: 1rem;
    }

    /* Empty state */
    .usr-empty { padding: 4rem 1rem; text-align: center; }
    .usr-empty i  { font-size: 2.5rem; color: #cbd5e1; display: block; margin-bottom: 1rem; }
    .usr-empty h6 { color: var(--blue-dark); font-weight: 600; margin-bottom: .4rem; }
    .usr-empty p  { font-size: .83rem; color: var(--text-muted); margin: 0 0 1.25rem; }

    /* Footer paginación */
    .usr-footer {
        padding: .85rem 1.25rem; border-top: 1px solid var(--border);
        background: var(--surface);
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: .5rem;
    }
    .usr-footer-info { font-size: .78rem; color: var(--text-muted); }

    .pagination { margin: 0; }
    .pagination .page-link {
        border-radius: 7px; margin: 0 2px; border: 1.5px solid var(--border);
        color: var(--blue-mid); padding: .28rem .6rem; font-size: .82rem; transition: all .15s;
    }
    .pagination .page-link:hover { background: var(--teal-light); border-color: var(--teal); color: var(--blue-dark); }
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, var(--teal), var(--blue-mid));
        border-color: var(--teal); color: white; box-shadow: 0 2px 6px rgba(78,199,210,.35);
    }

    /* Responsive */
    @media(max-width: 768px) {
        .usr-footer { flex-direction: column; align-items: center; gap: .75rem; }
        .usr-tbl thead th, .usr-tbl tbody td { padding: .5rem .5rem; font-size: .75rem; }
    }
    @media(max-width: 480px) {
        .usr-stats { grid-template-columns: repeat(2,1fr); gap: .65rem; }
        .usr-stat  { padding: .85rem .9rem; gap: .75rem; }
        .usr-stat-num  { font-size: 1.45rem; }
        .usr-stat-icon { width: 38px; height: 38px; font-size: .95rem; }
    }
</style>
@endpush

@section('content')
<div>

    {{-- ── STATS ── --}}
    <div class="usr-stats">

        {{-- Total --}}
        <div class="usr-stat usr-stat-total">
            <div class="usr-stat-icon"><i class="fas fa-users"></i></div>
            <div>
                <div class="usr-stat-lbl">Total</div>
                <div class="usr-stat-num">{{ $conteos['total'] }}</div>
                <div class="usr-stat-sub">Usuarios</div>
            </div>
        </div>

        {{-- Administradores --}}
        <div class="usr-stat usr-stat-admin">
            <div class="usr-stat-icon"><i class="fas fa-user-shield"></i></div>
            <div>
                <div class="usr-stat-lbl">Admins</div>
                <div class="usr-stat-num">{{ $conteos['admin'] }}</div>
                <div class="usr-stat-sub">Gestión del sistema</div>
            </div>
        </div>

        {{-- Profesores --}}
        <div class="usr-stat usr-stat-profesor">
            <div class="usr-stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
            <div>
                <div class="usr-stat-lbl">Profesores</div>
                <div class="usr-stat-num">{{ $conteos['profesor'] }}</div>
                <div class="usr-stat-sub">Docentes activos</div>
            </div>
        </div>

        {{-- Estudiantes --}}
        <div class="usr-stat usr-stat-alumno">
            <div class="usr-stat-icon"><i class="fas fa-user-graduate"></i></div>
            <div>
                <div class="usr-stat-lbl">Estudiantes</div>
                <div class="usr-stat-num">{{ $conteos['Estudiante'] }}</div>
                <div class="usr-stat-sub">Alumnos registrados</div>
            </div>
        </div>

        {{-- Padres --}}
        <div class="usr-stat usr-stat-padre">
            <div class="usr-stat-icon"><i class="fas fa-user-friends"></i></div>
            <div>
                <div class="usr-stat-lbl">Padres</div>
                <div class="usr-stat-num">{{ $conteos['Padre'] }}</div>
                <div class="usr-stat-sub">Tutores / padres</div>
            </div>
        </div>

    </div>

    {{-- ── ALERTAS ── --}}
    @if(session('password_temp') || session('success') || session('error'))
    <div style="margin-bottom:1.25rem;">
        @if(session('password_temp'))
        <div class="alert-temp">
            <i class="fas fa-key" style="flex-shrink:0;margin-top:2px;"></i>
            <div>
                <strong>Contraseña temporal generada:</strong>
                <span style="color:#ef4444;font-weight:700;margin-left:.4rem;">{{ session('password_temp') }}</span>
            </div>
        </div>
        @endif
        @if(session('success'))
        <div class="alert-ok">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="alert-err">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        </div>
        @endif
    </div>
    @endif

    {{-- ── FILTRO DE BÚSQUEDA ── --}}
    <div class="usr-filter">
        <form action="{{ route('superadmin.usuarios.index') }}" method="GET">
            @if($rolFiltro)
                <input type="hidden" name="rol" value="{{ $rolFiltro }}">
            @endif
            <div class="filter-grid">
                <div>
                    <label class="filter-label"><i class="fas fa-search me-1"></i> Buscar</label>
                    <input type="text" name="buscar" class="filter-input"
                           placeholder="Nombre, email..."
                           value="{{ request('buscar') }}">
                </div>
                <div>
                    <label class="filter-label"><i class="fas fa-flag me-1"></i> Estado</label>
                    <select name="estado" class="filter-select">
                        <option value="">Todos</option>
                        <option value="1" {{ request('estado') === '1' ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ request('estado') === '0' ? 'selected' : '' }}>Pendiente</option>
                    </select>
                </div>
                <div>
                    <label class="filter-label"><i class="fas fa-calendar me-1"></i> Año registro</label>
                    <select name="anio" class="filter-select">
                        <option value="">Todos</option>
                        @foreach(range(date('Y'), date('Y') - 4) as $y)
                            <option value="{{ $y }}" {{ request('anio') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="filter-label" style="opacity:0;">-</label>
                    <button type="submit" class="filter-btn">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                </div>
            </div>
            @if(request('buscar') || request('estado') !== null && request('estado') !== '' || request('anio'))
                <a href="{{ route('superadmin.usuarios.index', $rolFiltro ? ['rol' => $rolFiltro] : []) }}"
                   class="filter-clear">
                    <i class="fas fa-times"></i> Limpiar filtros
                </a>
            @endif
        </form>
    </div>

    {{-- ── TABLA CARD ── --}}
    <div class="usr-card">
        <div class="usr-card-head">
            <i class="fas fa-users"></i>
            <span>Lista de Usuarios</span>
        </div>

        {{-- Tabs por rol --}}
        @php
            $tabs = [
                ''           => ['label' => 'Todos',          'icon' => 'fa-users',             'count' => $conteos['total']],
                'admin'      => ['label' => 'Administradores','icon' => 'fa-user-shield',        'count' => $conteos['admin']],
                'profesor'   => ['label' => 'Profesores',     'icon' => 'fa-chalkboard-teacher', 'count' => $conteos['profesor']],
                'Estudiante' => ['label' => 'Estudiantes',    'icon' => 'fa-user-graduate',      'count' => $conteos['Estudiante']],
                'Padre'      => ['label' => 'Padres',         'icon' => 'fa-user-friends',       'count' => $conteos['Padre']],
            ];
        @endphp
        <div class="usr-tabs">
            @foreach ($tabs as $valor => $tab)
                @php
                    $activo = ($rolFiltro ?? '') === $valor;
                    $params = array_filter(['rol' => $valor ?: null, 'buscar' => request('buscar'), 'estado' => request('estado'), 'anio' => request('anio')]);
                    $url = route('superadmin.usuarios.index', $params);
                @endphp
                <a href="{{ $url }}"
                   class="usr-tab {{ $activo ? 'usr-tab-active' : 'usr-tab-inactive' }}">
                    <i class="fas {{ $tab['icon'] }}"></i>
                    {{ $tab['label'] }}
                    <span class="usr-tab-count">{{ $tab['count'] }}</span>
                </a>
            @endforeach
        </div>

        {{-- Tabla --}}
        <div class="usr-tbl-wrapper">
            <table class="usr-tbl">
                <thead>
                    <tr>
                        <th class="tc" style="width:44px;">#</th>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th class="tc" style="width:130px;">Rol</th>
                        <th class="tc" style="width:100px;">Estado</th>
                        <th class="tc" style="width:90px;">Registrado</th>
                        <th class="tr" style="width:80px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($usuarios as $i => $u)
                        @php
                            $nombreRol = $u->rol->nombre ?? 'Sin rol';
                            $coloresRol = [
                                'Super Administrador' => 'b-dark',
                                'super_admin'         => 'b-dark',
                                'Administrador'       => 'b-slate',
                                'admin'               => 'b-slate',
                                'Maestro'             => 'b-cyan',
                                'Profesor'            => 'b-cyan',
                                'profesor'            => 'b-cyan',
                                'Estudiante'          => 'b-blue',
                                'estudiante'          => 'b-blue',
                                'Padre'               => 'b-green',
                                'padre'               => 'b-green',
                            ];
                            $claseRol = $coloresRol[$nombreRol] ?? 'b-gray';
                            $iniciales = strtoupper(
                                substr($u->name, 0, 1) .
                                (strpos($u->name, ' ') !== false
                                    ? substr($u->name, strpos($u->name, ' ') + 1, 1)
                                    : '')
                            );
                        @endphp
                        <tr>
                            {{-- # --}}
                            <td class="tc">
                                <span class="row-num">{{ $usuarios->firstItem() + $i }}</span>
                            </td>

                            {{-- Usuario --}}
                            <td>
                                <div style="display:flex;align-items:center;gap:.6rem;">
                                    <div class="usr-av">{{ $iniciales }}</div>
                                    <div>
                                        <div class="usr-name">{{ $u->name }}</div>
                                        <div class="usr-sub">
                                            <span class="usr-code">#{{ $u->id }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Email --}}
                            <td>
                                <span style="font-size:.8rem;color:var(--text-muted);">{{ $u->email }}</span>
                            </td>

                            {{-- Rol --}}
                            <td class="tc">
                                <span class="bpill {{ $claseRol }}">
                                    {{ $nombreRol }}
                                </span>
                            </td>

                            {{-- Estado --}}
                            <td class="tc">
                                @if($u->activo)
                                    <span class="bpill b-activo">
                                        <i class="fas fa-circle" style="font-size:.42rem;"></i> Activo
                                    </span>
                                @else
                                    <span class="bpill b-pendiente">
                                        <i class="fas fa-circle" style="font-size:.42rem;"></i> Pendiente
                                    </span>
                                @endif
                            </td>

                            {{-- Fecha --}}
                            <td class="tc">
                                <span class="usr-fecha">{{ $u->created_at->format('d/m/Y') }}</span><br>
                                <span class="usr-hora">{{ $u->created_at->format('H:i') }}</span>
                            </td>

                            {{-- Acciones --}}
                            <td class="tr">
                                <div class="act-wrap">
                                    <a href="{{ route('superadmin.usuarios.show', $u->id) }}"
                                       class="act-btn act-view" title="Ver detalle">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('superadmin.usuarios.edit', $u->id) }}"
                                       class="act-btn act-edit" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="usr-empty">
                                    <i class="fas fa-users-slash"></i>
                                    <h6>No hay usuarios registrados</h6>
                                    <p>
                                        @if(request('buscar') || request('estado') !== null && request('estado') !== '' || request('anio'))
                                            No se encontraron usuarios con los filtros aplicados.
                                        @else
                                            Comienza registrando el primer usuario del sistema.
                                        @endif
                                    </p>
                                    <a href="{{ route('superadmin.usuarios.create') }}" class="usr-topbar-btn">
                                        <i class="fas fa-user-plus"></i> Nuevo Usuario
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        @if($usuarios->hasPages())
        <div class="usr-footer">
            <span class="usr-footer-info">
                Mostrando {{ $usuarios->firstItem() }}–{{ $usuarios->lastItem() }}
                de {{ $usuarios->total() }}
                @if($rolFiltro)
                    {{ ['admin'=>'administradores','profesor'=>'profesores','Estudiante'=>'estudiantes','Padre'=>'padres'][$rolFiltro] ?? strtolower($rolFiltro).'s' }}
                @else
                    usuarios
                @endif
            </span>
            {{ $usuarios->appends(request()->query())->links() }}
        </div>
        @endif

    </div>{{-- fin usr-card --}}

</div>
@endsection