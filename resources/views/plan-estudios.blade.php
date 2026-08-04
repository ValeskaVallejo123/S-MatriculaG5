<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grados - Escuela Gabriela Mistral</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
    :root {
        --blue-dark: #003b73;
        --blue-mid:  #00508f;
        --teal:      #4ec7d2;
        --green:     #10b981;
        --indigo:    #6366f1;
        --amber:     #f59e0b;
        --border:    #e2e8f0;
        --surface:   #f8fafc;
        --text:      #0f172a;
        --muted:     #64748b;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Inter', sans-serif; background: #f0f4f8; }

    /* ══════════════════════════════════════════════
       HEADER INSTITUCIONAL
    ══════════════════════════════════════════════ */
    .inst-header {
        background: linear-gradient(135deg, #002d5a 0%, #00508f 50%, #0077b6 100%);
        padding: 0; position: relative; overflow: hidden;
    }
    .inst-header::before {
        content: ''; position: absolute; inset: 0;
        background: repeating-linear-gradient(
            45deg,
            transparent,
            transparent 20px,
            rgba(255,255,255,.02) 20px,
            rgba(255,255,255,.02) 40px
        );
    }
    .inst-topbar {
        background: rgba(0,0,0,.2);
        padding: .4rem 2rem;
        display: flex; align-items: center; justify-content: space-between;
        font-size: .72rem; color: rgba(255,255,255,.7);
    }
    .inst-topbar a {
        color: rgba(255,255,255,.7); text-decoration: none;
        display: inline-flex; align-items: center; gap: .35rem;
        transition: color .15s;
    }
    .inst-topbar a:hover { color: #fff; }

    .inst-main {
        padding: 1.75rem 2rem 1.5rem;
        display: flex; align-items: center; gap: 1.5rem;
        position: relative; z-index: 1;
    }
    .inst-logo-wrap {
        width: 80px; height: 80px; flex-shrink: 0;
        background: rgba(255,255,255,.15);
        border: 3px solid rgba(78,199,210,.5);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
    }
    .inst-logo-wrap i { font-size: 2.2rem; color: #f59e0b; }

    .inst-text h1 {
        font-size: 1.55rem; font-weight: 800; color: #fff;
        margin: 0 0 .15rem; line-height: 1.2;
    }
    .inst-text h1 span { color: var(--teal); }
    .inst-text p {
        font-size: .82rem; color: rgba(255,255,255,.75);
        margin: 0; letter-spacing: .3px;
    }
    .inst-badges {
        margin-top: .6rem; display: flex; gap: .5rem; flex-wrap: wrap;
    }
    .inst-badge {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .2rem .65rem; border-radius: 6px; font-size: .68rem; font-weight: 700;
        background: rgba(255,255,255,.15); color: rgba(255,255,255,.9);
        border: 1px solid rgba(255,255,255,.2);
    }

    .inst-nav {
        background: rgba(0,0,0,.25);
        border-top: 1px solid rgba(255,255,255,.1);
        padding: .5rem 2rem;
        display: flex; gap: .25rem; flex-wrap: wrap;
        position: relative; z-index: 1;
    }
    .inst-nav a {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .4rem .9rem; border-radius: 7px; font-size: .78rem; font-weight: 600;
        color: rgba(255,255,255,.75); text-decoration: none; transition: all .15s;
    }
    .inst-nav a:hover  { background: rgba(255,255,255,.12); color: #fff; }
    .inst-nav a.active { background: var(--teal); color: #fff; }

    /* ══════════════════════════════════════════════
       CONTENIDO PRINCIPAL
    ══════════════════════════════════════════════ */
    .main-wrap { max-width: 1280px; margin: 0 auto; padding: 2rem 1.5rem 3rem; }

    /* Banner de sección */
    .section-banner {
        background: linear-gradient(135deg, var(--teal) 0%, var(--blue-mid) 60%, var(--blue-dark) 100%);
        border-radius: 14px; padding: 1.4rem 1.75rem; margin-bottom: 1.75rem;
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 1rem;
        box-shadow: 0 6px 20px rgba(0,59,115,.2);
    }
    .section-banner-left { display: flex; align-items: center; gap: 1rem; }
    .section-banner-icon {
        width: 50px; height: 50px; border-radius: 12px; flex-shrink: 0;
        background: rgba(255,255,255,.18);
        display: flex; align-items: center; justify-content: center;
    }
    .section-banner-icon i { font-size: 1.3rem; color: #fff; }
    .section-banner-title { font-size: 1.2rem; font-weight: 700; color: #fff; margin: 0; }
    .section-banner-sub   { font-size: .78rem; color: rgba(255,255,255,.78); margin-top: .15rem; }
    .section-banner-count {
        background: rgba(255,255,255,.18); border-radius: 10px;
        padding: .6rem 1.1rem; text-align: center;
        border: 1px solid rgba(255,255,255,.25);
    }
    .section-banner-count .num { font-size: 1.6rem; font-weight: 800; color: #fff; line-height: 1; display: block; }
    .section-banner-count .lbl { font-size: .65rem; color: rgba(255,255,255,.8); text-transform: uppercase; letter-spacing: .06em; }

    /* Stats */
    .stats-row {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 1rem; margin-bottom: 1.5rem;
    }
    .stat-card {
        background: #fff; border-radius: 12px; border: 1px solid var(--border);
        padding: 1rem 1.25rem; display: flex; align-items: center; gap: .85rem;
        box-shadow: 0 1px 3px rgba(0,0,0,.05); transition: transform .2s;
        border-left: 4px solid transparent;
    }
    .stat-card:hover { transform: translateY(-2px); }
    .stat-card.s-total    { border-left-color: var(--blue-mid); }
    .stat-card.s-activos  { border-left-color: var(--green); }
    .stat-card.s-primaria { border-left-color: var(--teal); }
    .stat-card.s-basica   { border-left-color: var(--indigo); }
    .stat-card.s-secund   { border-left-color: var(--blue-dark); }
    .stat-icon {
        width: 42px; height: 42px; border-radius: 10px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; color: #fff;
    }
    .si-total    { background: linear-gradient(135deg, var(--blue-mid), var(--blue-dark)); }
    .si-activos  { background: linear-gradient(135deg, #10b981, #059669); }
    .si-primaria { background: linear-gradient(135deg, var(--teal), var(--blue-mid)); }
    .si-basica   { background: linear-gradient(135deg, #6366f1, #4f46e5); }
    .si-secund   { background: linear-gradient(135deg, var(--blue-mid), var(--blue-dark)); }
    .stat-num { font-size: 1.65rem; font-weight: 800; color: var(--blue-dark); line-height: 1; display: block; }
    .stat-lbl { font-size: .7rem; color: var(--muted); font-weight: 500; }

    /* Toolbar */
    .toolbar {
        background: #fff; border-radius: 12px; border: 1px solid var(--border);
        padding: 1rem 1.25rem; margin-bottom: 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,.05);
    }
    .toolbar-top { display: flex; gap: .75rem; flex-wrap: wrap; align-items: center; margin-bottom: 1rem; }
    .search-wrap { position: relative; flex: 1; min-width: 200px; }
    .search-wrap i { position: absolute; left: .85rem; top: 50%; transform: translateY(-50%); color: var(--teal); font-size: .82rem; pointer-events: none; }
    .search-input {
        width: 100%; padding: .45rem .85rem .45rem 2.4rem;
        border: 1.5px solid var(--border); border-radius: 9px;
        font-size: .83rem; background: var(--surface); color: var(--text);
        font-family: 'Inter', sans-serif; outline: none; transition: border-color .15s;
    }
    .search-input:focus { border-color: var(--teal); background: #fff; box-shadow: 0 0 0 3px rgba(78,199,210,.12); }
    .filter-wrap { position: relative; min-width: 160px; }
    .filter-wrap i { position: absolute; left: .85rem; top: 50%; transform: translateY(-50%); color: var(--teal); font-size: .78rem; pointer-events: none; }
    .filter-select {
        width: 100%; padding: .45rem .85rem .45rem 2.4rem;
        border: 1.5px solid var(--border); border-radius: 9px;
        font-size: .83rem; background: var(--surface); color: var(--text);
        font-family: 'Inter', sans-serif; outline: none; appearance: none; cursor: pointer;
    }
    .filter-select:focus { border-color: var(--teal); }
    .tabs-row { display: flex; gap: .5rem; flex-wrap: wrap; }
    .tab-btn {
        padding: .38rem 1rem; border-radius: 8px; font-size: .77rem; font-weight: 700;
        border: 1.5px solid var(--border); background: #fff; color: var(--muted);
        cursor: pointer; display: inline-flex; align-items: center; gap: .4rem;
        transition: all .15s; font-family: 'Inter', sans-serif;
    }
    .tab-btn:hover  { border-color: var(--teal); color: var(--blue-mid); }
    .tab-btn.active { background: linear-gradient(135deg, var(--teal), var(--blue-mid)); border-color: transparent; color: #fff; }

    /* Grid de grados */
    .grados-grid {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.25rem;
    }
    .grado-card {
        background: #fff; border-radius: 14px; border: 1.5px solid var(--border);
        overflow: hidden; display: flex; flex-direction: column;
        box-shadow: 0 1px 3px rgba(0,0,0,.05); transition: all .25s;
    }
    .grado-card:hover { transform: translateY(-4px); box-shadow: 0 10px 28px rgba(0,59,115,.13); }
    .grado-card.primaria-card:hover  { border-color: var(--teal); }
    .grado-card.basica-card:hover    { border-color: #6366f1; }
    .grado-card.secundaria-card:hover { border-color: var(--blue-mid); }

    .gcard-head {
        padding: 1.1rem 1.25rem; display: flex; align-items: center; gap: 1rem;
        background: linear-gradient(135deg, #f8fafc, #edf2f7);
        border-bottom: 1.5px solid var(--border);
    }
    .gcard-badge {
        width: 56px; height: 56px; border-radius: 50%; flex-shrink: 0;
        display: flex; flex-direction: column; align-items: center;
        justify-content: center; color: #fff;
    }
    .gcard-badge .gnum { font-size: 1.25rem; font-weight: 800; line-height: 1; }
    .gcard-badge .gsec { font-size: .62rem; font-weight: 700; opacity: .9; }
    .primaria-badge   { background: linear-gradient(135deg, var(--teal), var(--blue-mid)); }
    .basica-badge     { background: linear-gradient(135deg, #6366f1, #4f46e5); }
    .secundaria-badge { background: linear-gradient(135deg, var(--blue-mid), var(--blue-dark)); }

    .gcard-info { flex: 1; min-width: 0; }
    .gcard-title {
        font-size: .92rem; font-weight: 700; color: var(--blue-dark);
        margin: 0 0 .35rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .gcard-pills { display: flex; gap: .35rem; flex-wrap: wrap; }
    .gpill {
        display: inline-flex; align-items: center; gap: .25rem;
        padding: .18rem .55rem; border-radius: 6px; font-size: .67rem; font-weight: 700;
    }
    .gpill-nivel-primaria  { background: rgba(78,199,210,.12);  color: #005f6b; }
    .gpill-nivel-basica    { background: rgba(99,102,241,.12);  color: #3730a3; }
    .gpill-nivel-secundaria { background: rgba(0,80,143,.1);   color: var(--blue-dark); }
    .gpill-activo   { background: rgba(16,185,129,.1);  color: #065f46; }
    .gpill-inactivo { background: rgba(239,68,68,.1);   color: #991b1b; }

    .gcard-body {
        padding: .85rem 1.25rem; display: grid;
        grid-template-columns: 1fr 1fr; gap: .5rem; flex: 1;
    }
    .gcard-stat {
        display: flex; align-items: center; gap: .45rem;
        font-size: .77rem; color: var(--muted);
    }
    .gcard-stat i { color: var(--teal); font-size: .72rem; width: 14px; text-align: center; }
    .gcard-stat span { font-weight: 600; color: var(--text); }

    /* Solo botón Ver — sin editar ni eliminar */
    .gcard-foot {
        padding: .75rem 1.25rem; border-top: 1px solid #f1f5f9;
        background: var(--surface);
    }
    .btn-ver-pub {
        display: flex; align-items: center; justify-content: center; gap: .4rem;
        width: 100%; padding: .48rem; border-radius: 9px; font-size: .8rem; font-weight: 700;
        background: linear-gradient(135deg, var(--teal), var(--blue-mid));
        color: #fff; text-decoration: none; transition: opacity .15s; border: none;
    }
    .btn-ver-pub:hover { opacity: .88; color: #fff; }

    /* Empty */
    .empty-state { grid-column: 1/-1; text-align: center; padding: 3rem; color: var(--muted); }
    .empty-state i { font-size: 2.5rem; color: #cbd5e1; display: block; margin-bottom: .75rem; }

    /* Footer institucional */
    .inst-footer {
        background: var(--blue-dark); padding: 1.5rem 2rem;
        text-align: center; color: rgba(255,255,255,.6); font-size: .75rem; margin-top: 2rem;
    }
    .inst-footer strong { color: var(--teal); }

    /* Resultado count */
    .results-count { font-size: .75rem; color: var(--muted); margin-bottom: 1rem; display: flex; align-items: center; gap: .35rem; }
    .results-count span { font-weight: 700; color: var(--blue-mid); }

    @media (max-width: 640px) {
        .inst-main { padding: 1.25rem 1rem; }
        .inst-topbar, .inst-nav { padding-left: 1rem; padding-right: 1rem; }
        .main-wrap { padding: 1.25rem 1rem; }
        .grados-grid { grid-template-columns: 1fr; }
        .stats-row { grid-template-columns: 1fr 1fr; }
        .inst-text h1 { font-size: 1.2rem; }
    }
    </style>
</head>
<body>

{{-- ══ HEADER INSTITUCIONAL ══ --}}
<header class="inst-header">
    <div class="inst-topbar">
        <span><i class="fas fa-map-marker-alt me-1"></i> Tegucigalpa, Honduras</span>
        <div style="display:flex;gap:1.25rem;">
            <a href="mailto:info@egm.edu.hn"><i class="fas fa-envelope"></i> info@egm.edu.hn</a>
            <a href="{{ route('login') }}"><i class="fas fa-lock"></i> Acceso personal</a>
        </div>
    </div>

    <div class="inst-main">
        <div class="inst-logo-wrap">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <div class="inst-text">
            <h1>Centro de Educaci&oacute;n B&aacute;sica<br><span>Gabriela Mistral</span></h1>
            <p>Formando ciudadanos con valores, conocimiento y compromiso social</p>
            <div class="inst-badges">
                <span class="inst-badge"><i class="fas fa-star"></i> Educaci&oacute;n de Calidad</span>
                <span class="inst-badge"><i class="fas fa-users"></i> Comunidad Inclusiva</span>
                <span class="inst-badge"><i class="fas fa-award"></i> Acreditado SEH</span>
            </div>
        </div>
    </div>

    <nav class="inst-nav">
        <a href="{{ route('portal.inicio') }}"><i class="fas fa-home"></i> Inicio</a>
        <a href="{{ route('portal.plan-estudios.index') }}" class="active"><i class="fas fa-layer-group"></i> Plan de Estudios</a>
        <a href="{{ route('portal.profesores') }}"><i class="fas fa-chalkboard-teacher"></i> Docentes</a>
        <a href="{{ route('portal.horarios') }}"><i class="fas fa-clock"></i> Horarios</a>
        <a href="{{ route('matriculas.public.create') }}"><i class="fas fa-clipboard-list"></i> Matr&iacute;cula</a>
        <a href="{{ route('portal.contacto') }}"><i class="fas fa-envelope"></i> Contacto</a>
    </nav>
</header>

{{-- ══ CONTENIDO ══ --}}
<div class="main-wrap">

    {{-- Banner de sección --}}
    <div class="section-banner">
        <div class="section-banner-left">
            <div class="section-banner-icon"><i class="fas fa-layer-group"></i></div>
            <div>
                <div class="section-banner-title">Plan de Estudios</div>
                <div class="section-banner-sub">Conoce los grados, niveles y materias que ofrecemos</div>
            </div>
        </div>
        <div class="section-banner-count">
            <span class="num">{{ $grados->total() }}</span>
            <span class="lbl">Grados disponibles</span>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats-row">
        <div class="stat-card s-total">
            <div class="stat-icon si-total"><i class="fas fa-school"></i></div>
            <div>
                <span class="stat-num">{{ $grados->total() }}</span>
                <span class="stat-lbl">Total Grados</span>
            </div>
        </div>
        <div class="stat-card s-activos">
            <div class="stat-icon si-activos"><i class="fas fa-check-circle"></i></div>
            <div>
                <span class="stat-num">{{ $grados->where('activo', true)->count() }}</span>
                <span class="stat-lbl">Activos</span>
            </div>
        </div>
        <div class="stat-card s-primaria">
            <div class="stat-icon si-primaria"><i class="fas fa-child"></i></div>
            <div>
                <span class="stat-num">{{ $grados->where('nivel', 'primaria')->count() }}</span>
                <span class="stat-lbl">Primaria</span>
            </div>
        </div>
        <div class="stat-card s-basica">
            <div class="stat-icon si-basica"><i class="fas fa-graduation-cap"></i></div>
            <div>
                <span class="stat-num">{{ $grados->where('nivel', 'basica')->count() }}</span>
                <span class="stat-lbl">B&aacute;sica</span>
            </div>
        </div>
        <div class="stat-card s-secund">
            <div class="stat-icon si-secund"><i class="fas fa-user-graduate"></i></div>
            <div>
                <span class="stat-num">{{ $grados->where('nivel', 'secundaria')->count() }}</span>
                <span class="stat-lbl">Secundaria</span>
            </div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="toolbar">
        <div class="toolbar-top">
            <div class="search-wrap">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" class="search-input"
                       placeholder="Buscar por grado, secci&oacute;n, a&ntilde;o...">
            </div>
            <div class="filter-wrap">
                <i class="fas fa-filter"></i>
                <select id="filterNivel" class="filter-select">
                    <option value="">Todos los niveles</option>
                    <option value="primaria">Primaria</option>
                    <option value="basica">B&aacute;sica</option>
                    <option value="secundaria">Secundaria</option>
                </select>
            </div>
            <div class="filter-wrap">
                <i class="fas fa-list-ol"></i>
                <select class="filter-select" onchange="changePerPage(this.value)">
                    <option value="12" {{ !request('per_page') || request('per_page') == 12 ? 'selected' : '' }}>12 / p&aacute;gina</option>
                    <option value="24" {{ request('per_page') == 24 ? 'selected' : '' }}>24 / p&aacute;gina</option>
                    <option value="36" {{ request('per_page') == 36 ? 'selected' : '' }}>36 / p&aacute;gina</option>
                </select>
            </div>
        </div>
        <div class="tabs-row">
            <button class="tab-btn active" data-nivel="">
                <i class="fas fa-th-large"></i> Todos
            </button>
            <button class="tab-btn" data-nivel="primaria">
                <i class="fas fa-child"></i> Primaria
            </button>
            <button class="tab-btn" data-nivel="basica">
                <i class="fas fa-graduation-cap"></i> B&aacute;sica
            </button>
            <button class="tab-btn" data-nivel="secundaria">
                <i class="fas fa-user-graduate"></i> Secundaria
            </button>
        </div>
    </div>

    <div class="results-count" id="resultsCount">
        <i class="fas fa-info-circle" style="color:var(--teal);"></i>
        Mostrando <span id="visibleCount">{{ $grados->count() }}</span> de {{ $grados->total() }} grados
    </div>

    {{-- Grid de grados — SOLO LECTURA --}}
    <div class="grados-grid" id="gradosContainer">
        @forelse($grados as $grado)
        @php
            $nivel    = strtolower($grado->nivel);
            $badgeCls = $nivel . '-badge';
            $cardCls  = $nivel . '-card';
            $pillCls  = 'gpill-nivel-' . $nivel;
        @endphp
        <div class="grado-card {{ $cardCls }}"
             data-nivel="{{ $nivel }}"
             data-search="{{ strtolower($grado->numero . ' ' . $grado->seccion . ' ' . $grado->nivel . ' ' . $grado->anio_lectivo) }}">

            <div class="gcard-head">
                <div class="gcard-badge {{ $badgeCls }}">
                    <span class="gnum">{{ $grado->numero }}&deg;</span>
                    @if($grado->seccion)
                        <span class="gsec">{{ $grado->seccion }}</span>
                    @endif
                </div>
                <div class="gcard-info">
                    <div class="gcard-title">
                        {{ $grado->numero }}&deg; Grado
                        @if($grado->seccion) &mdash; Secci&oacute;n {{ $grado->seccion }} @endif
                    </div>
                    <div class="gcard-pills">
                        <span class="gpill {{ $pillCls }}">{{ ucfirst($grado->nivel) }}</span>
                        <span class="gpill {{ $grado->activo ? 'gpill-activo' : 'gpill-inactivo' }}">
                            <i class="fas fa-circle" style="font-size:.42rem;"></i>
                            {{ $grado->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="gcard-body">
                <div class="gcard-stat">
                    <i class="fas fa-calendar-alt"></i>
                    <span>{{ $grado->anio_lectivo }}</span>
                </div>
                <div class="gcard-stat">
                    <i class="fas fa-book"></i>
                    <span>{{ $grado->materias->count() }} materia(s)</span>
                </div>
                @if($grado->capacidad ?? false)
                <div class="gcard-stat">
                    <i class="fas fa-users"></i>
                    <span>Cap. {{ $grado->capacidad }}</span>
                </div>
                @endif
            </div>

            {{-- Solo botón Ver — sin editar, eliminar ni agregar --}}
            <div class="gcard-foot">
                <a href="{{ route('portal.plan-estudios.show', $grado) }}" class="btn-ver-pub">
                    <i class="fas fa-eye"></i> Ver Plan de Estudios
                </a>
            </div>
        </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <p>No hay grados disponibles en este momento</p>
            </div>
        @endforelse
    </div>

    {{-- Paginación --}}
    @if($grados->hasPages())
    <div style="margin-top:1.5rem;">
        {{ $grados->appends(request()->query())->links() }}
    </div>
    @endif

</div>

{{-- Footer institucional --}}
<footer class="inst-footer">
    &copy; {{ date('Y') }} <strong>Centro de Educaci&oacute;n B&aacute;sica Gabriela Mistral</strong>
    &mdash; Tegucigalpa, Honduras.
    Todos los derechos reservados.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const filterNivel = document.getElementById('filterNivel');
    const tabBtns     = document.querySelectorAll('.tab-btn');
    const cards       = document.querySelectorAll('.grado-card');
    const countEl     = document.getElementById('visibleCount');
    let   activeNivel = '';

    function applyFilter() {
        const term  = searchInput.value.toLowerCase().trim();
        const nivel = activeNivel;
        let   vis   = 0;

        cards.forEach(function (card) {
            const matchSearch = !term  || (card.dataset.search || '').includes(term);
            const matchNivel  = !nivel || card.dataset.nivel === nivel;
            const show = matchSearch && matchNivel;
            card.style.display = show ? '' : 'none';
            if (show) vis++;
        });

        if (countEl) countEl.textContent = vis;
    }

    tabBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            tabBtns.forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');
            activeNivel = btn.dataset.nivel;
            filterNivel.value = activeNivel;
            applyFilter();
        });
    });

    filterNivel.addEventListener('change', function () {
        activeNivel = this.value;
        tabBtns.forEach(function (btn) {
            btn.classList.toggle('active', btn.dataset.nivel === activeNivel);
        });
        applyFilter();
    });

    searchInput.addEventListener('input', applyFilter);
});

function changePerPage(value) {
    var url = new URL(window.location.href);
    url.searchParams.set('per_page', value);
    url.searchParams.delete('page');
    window.location.href = url.toString();
}
</script>
</body>
</html>