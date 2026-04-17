<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan de Estudios - Escuela Gabriela Mistral</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh; overflow-x: hidden;
        }

        /* ===== NAVBAR ===== */
        .navbar-custom {
            background: linear-gradient(135deg, #003b73 0%, #00508f 50%, #4ec7d2 100%);
            padding: 18px 0;
            box-shadow: 0 4px 20px rgba(0,59,115,0.3);
            position: fixed; width: 100%; top: 0; z-index: 1000;
        }
        .navbar-custom .navbar-brand {
            display: flex; align-items: center; gap: 12px;
            color: white; font-weight: 700; font-size: 1.4rem; text-decoration: none;
        }
        .navbar-custom .navbar-brand i { font-size: 1.8rem; color: #4ec7d2; }
        .navbar-custom .nav-link {
            color: white !important; font-weight: 500; margin: 0 10px;
            transition: all 0.3s ease; position: relative;
        }
        .navbar-custom .nav-link:hover { color: #4ec7d2 !important; transform: translateY(-2px); }
        .navbar-custom .nav-link.active-nav { color: #4ec7d2 !important; font-weight: 600; }
        .navbar-custom .nav-link::after {
            content: ''; position: absolute; bottom: -5px; left: 0;
            width: 0; height: 3px; background: #4ec7d2; transition: width 0.3s ease;
        }
        .navbar-custom .nav-link:hover::after,
        .navbar-custom .nav-link.active-nav::after { width: 100%; }
        .btn-login {
            background: rgba(78,199,210,0.2); color: white !important;
            padding: 8px 24px; border-radius: 25px; border: 2px solid #4ec7d2;
            font-weight: 600; transition: all 0.3s ease; text-decoration: none;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-login:hover { background: #4ec7d2; color: #003b73 !important; transform: translateY(-2px); }

        /* ===== HEADER CARD ===== */
        .header-card {
            background: white;
            border-radius: 20px;
            border-left: 4px solid #4ec7d2;
            box-shadow: 0 8px 30px rgba(0,59,115,0.1);
            overflow: hidden;
            margin-bottom: 1.75rem;
        }
        .header-card-top {
            padding: 1.25rem 1.75rem;
            display: flex; align-items: center; justify-content: space-between;
            gap: 1rem; border-bottom: 1px solid rgba(0,80,143,0.07);
        }
        .header-card-title {
            display: flex; align-items: center; gap: 0.75rem;
        }
        .header-card-title i { color: #4ec7d2; font-size: 1.2rem; }
        .header-card-title h5 {
            margin: 0; font-size: 1rem; font-weight: 700; color: #003b73;
        }
        .header-card-title small {
            font-size: 0.75rem; color: #00508f; display: block; margin-top: 1px;
        }
        .header-stats-row {
            padding: 1rem 1.75rem;
            display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;
        }
        .stat-pill {
            display: inline-flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, rgba(78,199,210,0.1) 0%, rgba(0,80,143,0.05) 100%);
            border: 1px solid rgba(78,199,210,0.3);
            color: #00508f; padding: 6px 16px; border-radius: 50px;
            font-size: 0.82rem; font-weight: 600;
        }
        .stat-pill i { color: #4ec7d2; font-size: 0.9rem; }
        .stat-pill strong { color: #003b73; font-weight: 700; }
        .btn-volver {
            background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
            color: white; border: none;
            padding: 0.55rem 1.25rem; border-radius: 50px;
            font-size: 0.85rem; font-weight: 600;
            display: inline-flex; align-items: center; gap: 0.5rem;
            text-decoration: none; transition: all 0.3s ease; flex-shrink: 0;
            box-shadow: 0 4px 15px rgba(78,199,210,0.35);
        }
        .btn-volver:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(78,199,210,0.5);
            color: white;
        }

        /* ===== CONTENT ===== */
        .content-section { padding: 1.5rem 0 4rem; }

        /* ===== NIVEL SECTION ===== */
        .nivel-section { margin-bottom: 3rem; }
        .nivel-header {
            display: flex; align-items: center; gap: 1rem;
            margin-bottom: 1.5rem; padding-bottom: 1rem;
            border-bottom: 3px solid;
        }
        .nivel-header.primaria   { border-color: #4ec7d2; }
        .nivel-header.basica     { border-color: #6366f1; }
        .nivel-header.secundaria { border-color: #00508f; }

        .nivel-icon {
            width: 48px; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 1.2rem; flex-shrink: 0;
        }
        .primaria   .nivel-icon { background: linear-gradient(135deg, #4ec7d2, #00508f); }
        .basica     .nivel-icon { background: linear-gradient(135deg, #6366f1, #4f46e5); }
        .secundaria .nivel-icon { background: linear-gradient(135deg, #00508f, #003b73); }

        .nivel-info h2 { font-size: 1.35rem; font-weight: 700; color: #003b73; margin: 0; }
        .nivel-info p  { font-size: 0.82rem; color: #64748b; margin: 0; }

        .nivel-count {
            margin-left: auto; padding: 5px 14px; border-radius: 50px;
            font-size: 0.82rem; font-weight: 600;
        }
        .primaria   .nivel-count { background: rgba(78,199,210,0.12); color: #00508f; border: 1px solid #4ec7d2; }
        .basica     .nivel-count { background: rgba(99,102,241,0.12); color: #4f46e5; border: 1px solid #6366f1; }
        .secundaria .nivel-count { background: rgba(0,80,143,0.12);   color: #003b73; border: 1px solid #00508f; }

        /* ===== GRID 4 COLUMNAS ===== */
        .grados-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
        }

        /* ===== GRADO CARD ===== */
        .grado-card {
            background: white; border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0,59,115,0.08);
            overflow: hidden; transition: all 0.3s ease;
            display: flex; flex-direction: column;
        }
        .grado-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 40px rgba(0,59,115,0.15);
        }
        .primaria-card   { border-left: 4px solid #4ec7d2; }
        .basica-card     { border-left: 4px solid #6366f1; }
        .secundaria-card { border-left: 4px solid #00508f; }

        .gcard-top {
            padding: 1.25rem; display: flex; align-items: center; gap: 1rem;
            border-bottom: 1px solid #f1f5f9;
        }
        .gcard-avatar {
            width: 56px; height: 56px; border-radius: 50%;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            color: white; flex-shrink: 0;
        }
        .primaria-avatar   { background: linear-gradient(135deg, #4ec7d2, #00508f); }
        .basica-avatar     { background: linear-gradient(135deg, #6366f1, #4f46e5); }
        .secundaria-avatar { background: linear-gradient(135deg, #00508f, #003b73); }
        .gcard-avatar .num { font-size: 1.2rem; font-weight: 800; line-height: 1; }

        .gcard-meta { flex: 1; min-width: 0; }
        .gcard-meta h3 {
            font-size: 1rem; font-weight: 700; color: #003b73;
            margin: 0 0 0.25rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .gcard-meta .anio {
            font-size: 0.75rem; color: #64748b;
            display: flex; align-items: center; gap: 4px;
        }

        /* Secciones disponibles */
        .gcard-secciones {
            padding: 0.75rem 1.25rem 0;
            display: flex; align-items: center; gap: 0.5rem;
        }
        .secciones-badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 4px 12px; border-radius: 20px;
            font-size: 0.78rem; font-weight: 600;
        }
        .primaria-card   .secciones-badge { background: rgba(78,199,210,0.1); color: #00508f; border: 1px solid #4ec7d2; }
        .basica-card     .secciones-badge { background: rgba(99,102,241,0.1); color: #4f46e5; border: 1px solid #6366f1; }
        .secundaria-card .secciones-badge { background: rgba(0,80,143,0.1);   color: #003b73; border: 1px solid #00508f; }

        /* Ver detalle */
        .gcard-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(0,80,143,0.07);
            background: linear-gradient(135deg, rgba(78,199,210,0.04) 0%, rgba(0,80,143,0.02) 100%);
        }
        .btn-ver {
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
            padding: 0.6rem 1rem; border-radius: 50px;
            font-size: 0.83rem; font-weight: 600; text-decoration: none;
            transition: all 0.3s ease; width: 100%; border: none;
            background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(78,199,210,0.3);
        }
        .btn-ver:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(78,199,210,0.5);
            color: white;
        }

        /* Materias */
        .gcard-subjects { padding: 0.75rem 1.25rem 1rem; flex: 1; }
        .subjects-label {
            font-size: 0.7rem; font-weight: 600; color: #94a3b8;
            text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.4rem;
        }
        .subjects-list { display: flex; flex-wrap: wrap; gap: 0.35rem; }
        .subject-chip {
            background: linear-gradient(135deg, rgba(78,199,210,0.08) 0%, rgba(0,80,143,0.05) 100%);
            color: #00508f; padding: 3px 10px; border-radius: 20px;
            font-size: 0.72rem; font-weight: 500;
            border: 1px solid rgba(78,199,210,0.25);
        }
        .subject-more {
            background: linear-gradient(135deg, #4ec7d2, #00508f);
            color: white; padding: 3px 10px; border-radius: 20px;
            font-size: 0.72rem; font-weight: 600; border: none;
        }

        /* ===== EMPTY STATE ===== */
        .empty-nivel {
            background: white; border-radius: 14px; border: 2px dashed #e2e8f0;
            padding: 2.5rem; text-align: center; color: #94a3b8;
        }

        /* ===== CTA MATRÍCULA ===== */
        .cta-section {
            background: linear-gradient(135deg, #003b73 0%, #00508f 60%, #4ec7d2 100%);
            border-radius: 20px; padding: 2.5rem 2rem; text-align: center;
            position: relative; overflow: hidden; margin: 2rem 0 4rem;
        }
        .cta-section::before {
            content: ''; position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(78,199,210,0.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(78,199,210,0.08) 1px, transparent 1px);
            background-size: 40px 40px;
        }
        .cta-content { position: relative; z-index: 1; }
        .cta-section h3 { color: white; font-weight: 700; font-size: 1.6rem; margin-bottom: 0.6rem; }
        .cta-section p  { color: rgba(255,255,255,0.8); margin-bottom: 1.5rem; }
        .btn-cta {
            background: #4ec7d2; color: #003b73;
            padding: 12px 32px; border-radius: 50px;
            font-weight: 700; font-size: 0.95rem; text-decoration: none;
            display: inline-flex; align-items: center; gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(78,199,210,0.4);
        }
        .btn-cta:hover {
            background: white; color: #003b73; transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(78,199,210,0.5);
        }

        /* ===== FOOTER ===== */
        .page-footer {
            background: #003b73; color: rgba(255,255,255,0.7);
            text-align: center; padding: 1.5rem; font-size: 0.85rem;
        }

        @media (max-width: 1100px) {
            .grados-grid { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 768px) {
            .grados-grid { grid-template-columns: repeat(2, 1fr); }
            .header-stats-row { gap: 0.6rem; }
        }
        @media (max-width: 480px) {
            .grados-grid { grid-template-columns: 1fr; }
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

{{-- HEADER CARD --}}
@php $totalGrados = $grados->flatten()->count(); @endphp
<div style="margin-top: 72px; padding: 1.5rem 2rem 0;">
    <div class="header-card">
        <div class="header-card-top">
            <div class="header-card-title">
                <i class="fas fa-book-open"></i>
                <div>
                    <h5>Plan de Estudios</h5>
                    <small>Oferta académica {{ date('Y') }}</small>
                </div>
            </div>
            <a href="{{ route('inicio') }}" class="btn-volver">
                <i class="fas fa-arrow-left"></i> Volver al inicio
            </a>
        </div>
        <div class="header-stats-row">
            <div class="stat-pill">
                <i class="fas fa-school"></i>
                <strong>{{ $totalGrados }}</strong> Grados activos
            </div>
            @foreach($grados as $nivel => $items)
            <div class="stat-pill">
                @if($nivel === 'primaria')   <i class="fas fa-child"></i>
                @elseif($nivel === 'basica') <i class="fas fa-graduation-cap"></i>
                @else                        <i class="fas fa-user-graduate"></i>
                @endif
                <strong>{{ $items->count() }}</strong> {{ ucfirst($nivel) }}
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- CONTENIDO --}}
<section class="content-section">
    <div class="container-fluid px-4">

        @if($grados->isEmpty())
            <div class="empty-nivel">
                <i class="fas fa-book fa-3x mb-3" style="opacity: 0.3;"></i>
                <h5>No hay grados disponibles en este momento.</h5>
            </div>
        @else
            @php
                $nivelIcons = [
                    'primaria'   => 'fas fa-child',
                    'basica'     => 'fas fa-graduation-cap',
                    'secundaria' => 'fas fa-user-graduate',
                ];
                $nivelDesc = [
                    'primaria'   => 'Educación primaria · 1° a 6° grado',
                    'basica'     => 'Educación básica · Ciclo inicial',
                    'secundaria' => 'Educación secundaria · Bachillerato',
                ];
            @endphp

            @foreach($grados as $nivel => $items)
            @php
                $porNumero = $items->groupBy('numero')->sortKeys();
            @endphp
            <div class="nivel-section">
                <div class="nivel-header {{ strtolower($nivel) }}">
                    <div class="nivel-icon">
                        <i class="{{ $nivelIcons[$nivel] ?? 'fas fa-school' }}"></i>
                    </div>
                    <div class="nivel-info">
                        <h2>{{ ucfirst($nivel) }}</h2>
                        <p>{{ $nivelDesc[$nivel] ?? '' }}</p>
                    </div>
                    <span class="nivel-count">
                        {{ $porNumero->count() }} {{ $porNumero->count() === 1 ? 'grado' : 'grados' }}
                    </span>
                </div>

                <div class="grados-grid">
                    @foreach($porNumero as $numero => $secciones)
                    @php
                        $primero   = $secciones->first();
                        $nivelClass = strtolower($primero->nivel) . '-card';
                        $avatarClass = strtolower($primero->nivel) . '-avatar';
                        $todasMaterias = $secciones->flatMap(fn($g) => $g->materias)->unique('id')->sortBy('nombre');
                        $visibles  = $todasMaterias->take(4);
                        $restantes = $todasMaterias->count() - $visibles->count();
                    @endphp
                    <div class="grado-card {{ $nivelClass }}">
                        <div class="gcard-top">
                            <div class="gcard-avatar {{ $avatarClass }}">
                                <span class="num">{{ $numero }}°</span>
                            </div>
                            <div class="gcard-meta">
                                <h3>{{ $numero }}° Grado</h3>
                                <span class="anio">
                                    <i class="fas fa-calendar-alt"></i> {{ $primero->anio_lectivo }}
                                    &nbsp;·&nbsp;
                                    <i class="fas fa-book"></i> {{ $todasMaterias->count() }} materias
                                </span>
                            </div>
                        </div>

                        <div class="gcard-secciones">
                            <span class="secciones-badge">
                                <i class="fas fa-door-open"></i>
                                {{ $secciones->count() }} {{ $secciones->count() === 1 ? 'sección' : 'secciones' }} disponibles
                            </span>
                        </div>

                        @if($visibles->isNotEmpty())
                        <div class="gcard-subjects">
                            <div class="subjects-label">
                                <i class="fas fa-list me-1"></i>Materias
                            </div>
                            <div class="subjects-list">
                                @foreach($visibles as $mat)
                                    <span class="subject-chip">{{ $mat->nombre }}</span>
                                @endforeach
                                @if($restantes > 0)
                                    <span class="subject-more">+{{ $restantes }} más</span>
                                @endif
                            </div>
                        </div>
                        @endif

                        <div class="gcard-footer">
                            <a href="{{ route('portal.plan-estudios.show', $secciones->first()) }}" class="btn-ver">
                                <i class="fas fa-eye"></i> Ver plan completo
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        @endif

        {{-- CTA MATRÍCULA --}}
        <div class="cta-section">
            <div class="cta-content">
                <h3>¿Listo para inscribir a tu hijo?</h3>
                <p>Realiza tu solicitud de matrícula en línea de forma rápida y sencilla.</p>
                <a href="{{ route('matriculas.public.create') }}" class="btn-cta">
                    <i class="fas fa-file-alt"></i> Solicitar Matrícula
                </a>
            </div>
        </div>

    </div>
</section>

<footer class="page-footer">
    <p>© {{ date('Y') }} Escuela Gabriela Mistral. Todos los derechos reservados.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
