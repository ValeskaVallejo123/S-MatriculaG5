<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $grado->nombre_completo }} — Plan de Estudios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fa;
            overflow-x: hidden;
        }

        /* ===== NAVBAR PORTAL ===== */
        .navbar-custom {
            background: linear-gradient(135deg, #003b73 0%, #00508f 50%, #4ec7d2 100%);
            padding: 14px 0;
            box-shadow: 0 4px 20px rgba(0,59,115,0.3);
            position: fixed; width: 100%; top: 0; z-index: 1000;
        }
        .navbar-custom .navbar-brand {
            display: flex; align-items: center; gap: 10px;
            color: white; font-weight: 700; font-size: 1.25rem; text-decoration: none;
        }
        .navbar-custom .navbar-brand i { font-size: 1.6rem; color: #4ec7d2; }
        .navbar-custom .nav-link {
            color: white !important; font-weight: 500; margin: 0 8px;
            transition: all 0.3s ease; position: relative; font-size: 0.9rem;
        }
        .navbar-custom .nav-link:hover { color: #4ec7d2 !important; }
        .navbar-custom .nav-link.active-nav { color: #4ec7d2 !important; font-weight: 600; }
        .navbar-custom .nav-link::after {
            content: ''; position: absolute; bottom: -5px; left: 0;
            width: 0; height: 2px; background: #4ec7d2; transition: width 0.3s ease;
        }
        .navbar-custom .nav-link:hover::after,
        .navbar-custom .nav-link.active-nav::after { width: 100%; }
        .btn-login {
            background: rgba(78,199,210,0.2); color: white !important;
            padding: 7px 20px; border-radius: 25px; border: 2px solid #4ec7d2;
            font-weight: 600; transition: all 0.3s ease; text-decoration: none;
            display: inline-flex; align-items: center; gap: 7px; font-size: 0.88rem;
        }
        .btn-login:hover { background: #4ec7d2; color: #003b73 !important; }

        /* ===== PAGE WRAPPER ===== */
        .page-wrapper {
            margin-top: 64px;
            min-height: calc(100vh - 64px);
        }

        /* ===== TOPBAR INTERNO (estilo sistema) ===== */
        .inner-topbar {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 0 2rem;
            min-height: 60px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 64px; z-index: 100;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        }
        .inner-topbar-left { display: flex; align-items: center; gap: 0.75rem; }
        .inner-topbar-left h5 {
            margin: 0; color: #003b73; font-weight: 700; font-size: 1rem;
        }
        .breadcrumb-inline {
            display: flex; align-items: center; gap: 6px;
            font-size: 0.8rem; color: #94a3b8;
        }
        .breadcrumb-inline a { color: #00508f; text-decoration: none; font-weight: 500; }
        .breadcrumb-inline a:hover { text-decoration: underline; }
        .breadcrumb-inline i { font-size: 0.65rem; }
        .breadcrumb-inline span { color: #475569; font-weight: 600; }

        .btn-volver {
            background: white; color: #00508f;
            border: 1.5px solid #00508f;
            padding: 0.45rem 0.9rem; border-radius: 8px;
            font-size: 0.82rem; font-weight: 600;
            display: inline-flex; align-items: center; gap: 0.4rem;
            text-decoration: none; transition: all 0.2s ease;
        }
        .btn-volver:hover { background: #00508f; color: white; transform: translateY(-1px); }

        /* ===== CONTENT AREA ===== */
        .content-area { padding: 2rem; }

        /* ===== GRADO HEADER CARD ===== */
        .grado-header-card {
            background: linear-gradient(135deg, #003b73 0%, #00508f 70%, #4ec7d2 100%);
            border-radius: 14px;
            padding: 1.75rem 2rem;
            box-shadow: 0 4px 20px rgba(0,59,115,0.2);
            display: flex; align-items: center; gap: 1.5rem;
            margin-bottom: 1.75rem;
            position: relative; overflow: hidden;
        }
        .grado-header-card::after {
            content: '';
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(78,199,210,0.07) 1px, transparent 1px),
                linear-gradient(90deg, rgba(78,199,210,0.07) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
        }
        .grado-avatar {
            width: 70px; height: 70px; border-radius: 16px;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            color: white; flex-shrink: 0;
            border: 3px solid rgba(255,255,255,0.3);
            background: rgba(255,255,255,0.15) !important;
            backdrop-filter: blur(8px);
            position: relative; z-index: 1;
        }
        .primaria-av   { background: linear-gradient(135deg, #4ec7d2, #00508f); }
        .basica-av     { background: linear-gradient(135deg, #6366f1, #4f46e5); }
        .secundaria-av { background: linear-gradient(135deg, #00508f, #003b73); }
        .grado-avatar .num { font-size: 1.4rem; font-weight: 800; line-height: 1; }
        .grado-avatar .sec { font-size: 0.75rem; opacity: 0.9; font-weight: 600; }

        .grado-header-info { position: relative; z-index: 1; }
        .grado-header-info h2 {
            font-size: 1.45rem; font-weight: 700; color: white; margin: 0 0 0.6rem;
        }
        .grado-tags { display: flex; gap: 0.5rem; flex-wrap: wrap; }
        .tag {
            padding: 4px 12px; border-radius: 20px;
            font-size: 0.75rem; font-weight: 600;
            display: inline-flex; align-items: center; gap: 5px;
        }
        .tag-nivel   { background: rgba(78,199,210,0.25); color: #4ec7d2; border: 1px solid rgba(78,199,210,0.5); }
        .tag-anio    { background: rgba(255,255,255,0.15); color: white;   border: 1px solid rgba(255,255,255,0.3); }
        .tag-count   { background: rgba(16,185,129,0.25); color: #6ee7b7; border: 1px solid rgba(16,185,129,0.4); }

        /* ===== SECCIÓN MATERIAS ===== */
        .section-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 1.25rem;
        }
        .section-title {
            font-size: 1rem; font-weight: 700; color: #003b73;
            display: flex; align-items: center; gap: 0.6rem; margin: 0;
        }
        .section-title i { color: #4ec7d2; }
        .section-count {
            background: rgba(78,199,210,0.1); color: #00508f;
            border: 1px solid #4ec7d2;
            padding: 4px 14px; border-radius: 20px;
            font-size: 0.78rem; font-weight: 600;
        }

        /* ===== GRID MATERIAS ===== */
        .materias-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1rem;
        }
        .materia-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            padding: 1.1rem 1.25rem;
            display: flex; align-items: center; gap: 1rem;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        .materia-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,59,115,0.1);
            border-color: #4ec7d2;
        }
        .materia-num {
            width: 32px; height: 32px; border-radius: 8px;
            background: #f1f5f9; border: 1px solid #e2e8f0;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.75rem; font-weight: 700; color: #64748b; flex-shrink: 0;
        }
        .materia-icon {
            width: 42px; height: 42px; border-radius: 10px;
            background: linear-gradient(135deg, #00508f, #003b73);
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 0.95rem; flex-shrink: 0;
            border: 2px solid rgba(78,199,210,0.3);
        }
        .materia-info { flex: 1; min-width: 0; }
        .materia-info h6 {
            font-size: 0.9rem; font-weight: 600; color: #1e293b;
            margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .materia-info small { font-size: 0.72rem; color: #94a3b8; }
        .materia-badge {
            padding: 3px 10px; border-radius: 20px; flex-shrink: 0;
            font-size: 0.72rem; font-weight: 600;
            background: rgba(78,199,210,0.1); color: #00508f; border: 1px solid #4ec7d2;
        }

        /* ===== EMPTY STATE ===== */
        .empty-card {
            background: white; border-radius: 14px;
            border: 2px dashed #e2e8f0;
            padding: 3.5rem; text-align: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        .empty-card i { color: #4ec7d2; opacity: 0.4; }
        .empty-card h5 { color: #003b73; margin: 1rem 0 0.5rem; font-weight: 700; }
        .empty-card p  { color: #94a3b8; margin: 0; font-size: 0.9rem; }

        /* ===== CTA ===== */
        .cta-card {
            background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #4ec7d2 100%);
            border-radius: 14px; padding: 2rem 2.5rem;
            display: flex; align-items: center; justify-content: space-between;
            gap: 2rem; flex-wrap: wrap; margin-top: 2rem;
            position: relative; overflow: hidden;
        }
        .cta-card::before {
            content: ''; position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(78,199,210,0.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(78,199,210,0.08) 1px, transparent 1px);
            background-size: 40px 40px;
        }
        .cta-text { position: relative; z-index: 1; }
        .cta-text h4 { color: white; font-weight: 700; font-size: 1.2rem; margin: 0 0 0.35rem; }
        .cta-text p  { color: rgba(255,255,255,0.8); margin: 0; font-size: 0.88rem; }
        .btn-cta {
            background: #4ec7d2; color: #003b73;
            padding: 11px 28px; border-radius: 50px;
            font-weight: 700; font-size: 0.9rem; text-decoration: none;
            display: inline-flex; align-items: center; gap: 8px;
            transition: all 0.3s ease; flex-shrink: 0;
            box-shadow: 0 4px 16px rgba(78,199,210,0.4);
            position: relative; z-index: 1;
        }
        .btn-cta:hover {
            background: white; color: #003b73;
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(78,199,210,0.5);
        }

        /* ===== FOOTER ===== */
        .page-footer {
            background: #003b73; color: rgba(255,255,255,0.6);
            text-align: center; padding: 1.25rem;
            font-size: 0.82rem; margin-top: 2rem;
        }

        @media (max-width: 992px) {
            .stats-row { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 576px) {
            .stats-row { grid-template-columns: 1fr; }
            .content-area { padding: 1rem; }
            .inner-topbar { padding: 0 1rem; }
            .breadcrumb-inline { display: none; }
            .cta-card { flex-direction: column; text-align: center; }
        }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="{{ route('inicio') }}">
            <i class="fas fa-graduation-cap"></i>
            Escuela Gabriela Mistral
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                style="background-color: rgba(78,199,210,0.3); border: none;">
            <span class="navbar-toggler-icon" style="filter: brightness(0) invert(1);"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="{{ route('inicio') }}">Inicio</a></li>
                <li class="nav-item"><a class="nav-link active-nav" href="{{ route('portal.plan-estudios.index') }}">Plan de Estudios</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('matriculas.public.create') }}">Matrícula</a></li>
                <li class="nav-item ms-3">
                    <a class="btn-login" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt"></i> Acceso Sistema
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

@php
    $avatarClass = strtolower($grado->nivel) . '-av';
    $nivelLabel  = ucfirst($grado->nivel);
@endphp

<div class="page-wrapper">

    {{-- TOPBAR INTERNO --}}
    <div class="inner-topbar">
        <div class="inner-topbar-left">
            <div class="breadcrumb-inline">
                <a href="{{ route('inicio') }}">Inicio</a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('portal.plan-estudios.index') }}">Plan de Estudios</a>
                <i class="fas fa-chevron-right"></i>
                <span>{{ $grado->nombre_completo }}</span>
            </div>
        </div>
        <a href="{{ route('portal.plan-estudios.index') }}" class="btn-volver">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    {{-- CONTENT --}}
    <div class="content-area">

        {{-- GRADO HEADER --}}
        <div class="grado-header-card">
            <div class="grado-avatar {{ $avatarClass }}">
                <span class="num">{{ $grado->numero }}</span>
                @if($grado->seccion)
                    <span class="sec">{{ $grado->seccion }}</span>
                @endif
            </div>
            <div class="grado-header-info">
                <h2>{{ $grado->nombre_completo }}</h2>
                <div class="grado-tags">
                    <span class="tag tag-nivel"><i class="fas fa-layer-group"></i> {{ $nivelLabel }}</span>
                    <span class="tag tag-anio"><i class="fas fa-calendar-alt"></i> {{ $grado->anio_lectivo }}</span>
                    <span class="tag tag-count"><i class="fas fa-book"></i> {{ $grado->materias->count() }} materias</span>
                </div>
            </div>
        </div>

        {{-- MATERIAS --}}
        <div class="section-header">
            <h3 class="section-title">
                <i class="fas fa-list-ul"></i> Materias del plan de estudios
            </h3>
            @if($grado->materias->isNotEmpty())
            <span class="section-count">
                <i class="fas fa-book me-1"></i>{{ $grado->materias->count() }} materias en total
            </span>
            @endif
        </div>

        @if($grado->materias->isEmpty())
            <div class="empty-card">
                <i class="fas fa-book fa-3x"></i>
                <h5>Sin materias registradas</h5>
                <p>Este grado aún no tiene materias asignadas en su plan de estudios.</p>
            </div>
        @else
            <div class="materias-grid">
                @foreach($grado->materias as $index => $materia)
                <div class="materia-card">
                    <div class="materia-num">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                    <div class="materia-icon"><i class="fas fa-book-open"></i></div>
                    <div class="materia-info">
                        <h6>{{ $materia->nombre }}</h6>
                        @if(isset($materia->codigo) && $materia->codigo)
                            <small><i class="fas fa-barcode me-1"></i>{{ $materia->codigo }}</small>
                        @else
                            <small>{{ $nivelLabel }} · {{ $grado->anio_lectivo }}</small>
                        @endif
                    </div>
                    <span class="materia-badge">{{ $nivelLabel }}</span>
                </div>
                @endforeach
            </div>
        @endif

        {{-- CTA --}}
        <div class="cta-card">
            <div class="cta-text">
                <h4>¿Te interesa este grado?</h4>
                <p>Solicita la matrícula en línea y asegura el cupo de tu hijo.</p>
            </div>
            <a href="{{ route('matriculas.public.create') }}" class="btn-cta">
                <i class="fas fa-file-alt"></i> Solicitar Matrícula
            </a>
        </div>

    </div>{{-- /content-area --}}

    <footer class="page-footer">
        <p>© {{ date('Y') }} Escuela Gabriela Mistral. Todos los derechos reservados.</p>
    </footer>

</div>{{-- /page-wrapper --}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
