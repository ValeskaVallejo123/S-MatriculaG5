<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Escuela Gabriela Mistral - Sistema Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }

        /* ========== NAVBAR ========== */
        .navbar-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 18px 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(10px);
        }

        .navbar-custom .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            font-weight: 700;
            font-size: 1.5rem;
            text-decoration: none;
        }

        .navbar-custom .navbar-brand i {
            font-size: 2rem;
        }

        .navbar-custom .nav-link {
            color: white !important;
            font-weight: 500;
            margin: 0 15px;
            transition: all 0.3s ease;
            position: relative;
        }

        .navbar-custom .nav-link:hover {
            transform: translateY(-2px);
        }

        .navbar-custom .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 3px;
            background: white;
            transition: width 0.3s ease;
        }

        .navbar-custom .nav-link:hover::after {
            width: 100%;
        }

        /* ========== HERO SECTION ========== */
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 140px 0 100px;
            position: relative;
            overflow: hidden;
        }

        /* Patrón de fondo */
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
            pointer-events: none;
        }

        /* Elementos decorativos flotantes */
        .floating-element {
            position: absolute;
            animation: float 8s ease-in-out infinite;
            opacity: 0.25;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
                opacity: 0.25;
            }
            25% {
                transform: translateY(-15px) rotate(3deg);
                opacity: 0.35;
            }
            50% {
                transform: translateY(-25px) rotate(-3deg);
                opacity: 0.3;
            }
            75% {
                transform: translateY(-10px) rotate(2deg);
                opacity: 0.35;
            }
        }

        .pencil {
            top: 15%;
            left: 8%;
            font-size: 3.5rem;
            animation-delay: 0s;
        }

        .ruler {
            top: 25%;
            right: 10%;
            font-size: 3rem;
            animation-delay: 1.5s;
        }

        .book {
            bottom: 25%;
            left: 5%;
            font-size: 4rem;
            animation-delay: 2.5s;
        }

        .atom {
            top: 45%;
            right: 8%;
            font-size: 3.5rem;
            animation-delay: 1s;
        }

        .calculator {
            top: 65%;
            right: 12%;
            font-size: 3rem;
            animation-delay: 0.8s;
        }

        .microscope {
            bottom: 18%;
            right: 18%;
            font-size: 3.5rem;
            animation-delay: 3s;
        }

        .hero-content {
            text-align: center;
            color: white;
            position: relative;
            z-index: 10;
            max-width: 900px;
            margin: 0 auto;
        }

        .hero-content h1 {
            font-size: 3.8rem;
            font-weight: 800;
            margin-bottom: 30px;
            text-shadow: 2px 4px 8px rgba(0, 0, 0, 0.2);
            line-height: 1.3;
            letter-spacing: -1px;
        }

        .hero-content h1 span {
            background: linear-gradient(to right, #fff, #e0e7ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-content p {
            font-size: 1.35rem;
            max-width: 750px;
            margin: 0 auto 50px;
            opacity: 0.95;
            line-height: 1.7;
            font-weight: 400;
            text-shadow: 1px 2px 4px rgba(0, 0, 0, 0.15);
        }

        .search-box {
            max-width: 700px;
            margin: 50px auto 70px;
            display: flex;
            gap: 0;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.25);
            border-radius: 50px;
            overflow: hidden;
            background: white;
            transition: all 0.3s ease;
        }

        .search-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .search-box input {
            flex: 1;
            padding: 20px 35px;
            border: none;
            font-size: 1.05rem;
            outline: none;
            color: #2c3e50;
        }

        .search-box input::placeholder {
            color: #95a5a6;
        }

        .search-box button {
            padding: 20px 50px;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border: none;
            color: white;
            font-weight: 700;
            font-size: 1.05rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .search-box button:hover {
            background: linear-gradient(135deg, #f5576c 0%, #f093fb 100%);
            transform: scale(1.02);
        }

        /* Etiquetas de categorías */
        .categories {
            text-align: center;
            margin-top: 50px;
        }

        .categories h3 {
            color: white;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 25px;
            opacity: 0.95;
        }

        .category-tags {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
            max-width: 800px;
            margin: 0 auto;
        }

        .category-tag {
            padding: 14px 32px;
            background: rgba(255, 255, 255, 0.25);
            border: 2px solid rgba(255, 255, 255, 0.8);
            color: white;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.4s ease;
            backdrop-filter: blur(10px);
            font-size: 0.95rem;
        }

        .category-tag:hover {
            background: white;
            color: #764ba2;
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
            border-color: white;
        }

        /* Imagen decorativa */
        .hero-rocket {
            position: absolute;
            bottom: 8%;
            left: 50%;
            transform: translateX(-50%);
            font-size: 7rem;
            color: rgba(255, 255, 255, 0.35);
            animation: rocketLaunch 4s ease-in-out infinite;
            filter: drop-shadow(0 8px 16px rgba(0, 0, 0, 0.3));
        }

        @keyframes rocketLaunch {
            0%, 100% {
                transform: translateX(-50%) translateY(0) rotate(-5deg);
                opacity: 0.35;
            }
            25% {
                transform: translateX(-50%) translateY(-20px) rotate(0deg);
                opacity: 0.45;
            }
            50% {
                transform: translateX(-50%) translateY(-40px) rotate(5deg);
                opacity: 0.4;
            }
            75% {
                transform: translateX(-50%) translateY(-20px) rotate(0deg);
                opacity: 0.45;
            }
        }

        /* ========== FEATURES SECTION ========== */
        .features-section {
            padding: 100px 0;
            background: white;
        }

        .section-title {
            text-align: center;
            margin-bottom: 70px;
        }

        .section-title h2 {
            font-size: 2.8rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .section-title p {
            font-size: 1.2rem;
            color: #7f8c8d;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            background: white;
            padding: 45px 35px;
            border-radius: 25px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-align: center;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 20px 50px rgba(102, 126, 234, 0.2);
            border-color: #667eea;
        }

        .feature-icon {
            width: 95px;
            height: 95px;
            margin: 0 auto 25px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.8rem;
            color: white;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.35);
            transition: all 0.4s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.5);
        }

        .feature-card h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .feature-card p {
            color: #7f8c8d;
            line-height: 1.7;
            margin-bottom: 25px;
        }

        .btn-feature {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 14px 35px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            transition: all 0.3s ease;
            border: none;
            font-size: 0.95rem;
        }

        .btn-feature:hover {
            transform: scale(1.08);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            color: white;
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }

        /* ========== STATS SECTION ========== */
        .stats-section {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            padding: 90px 0;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .stats-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                radial-gradient(circle at 30% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 70% 80%, rgba(255, 255, 255, 0.08) 0%, transparent 50%);
            pointer-events: none;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 50px;
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .stat-item {
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            transform: scale(1.1);
        }

        .stat-item h3 {
            font-size: 4rem;
            font-weight: 900;
            margin-bottom: 15px;
            text-shadow: 2px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .stat-item p {
            font-size: 1.2rem;
            opacity: 0.95;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* ========== CTA SECTION ========== */
        .cta-section {
            padding: 100px 0;
            background: #f8f9fa;
            text-align: center;
        }

        .cta-content h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .cta-content p {
            font-size: 1.2rem;
            color: #7f8c8d;
            margin-bottom: 40px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-cta {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 55px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.2rem;
            display: inline-block;
            transition: all 0.4s ease;
            border: none;
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.35);
            position: relative;
            overflow: hidden;
        }

        .btn-cta::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s ease;
        }

        .btn-cta:hover::before {
            left: 100%;
        }

        .btn-cta:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 20px 50px rgba(102, 126, 234, 0.45);
            color: white;
        }

        /* ========== FOOTER ========== */
        footer {
            background: #2c3e50;
            color: white;
            padding: 50px 0 30px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto 40px;
        }

        .footer-section h4 {
            font-size: 1.3rem;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .footer-section p,
        .footer-section a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            line-height: 2;
            display: block;
        }

        .footer-section a:hover {
            color: white;
            padding-left: 5px;
            transition: all 0.3s ease;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-icons a {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .social-icons a:hover {
            background: #4facfe;
            transform: translateY(-3px);
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.2rem;
            }

            .hero-content p {
                font-size: 1.1rem;
            }

            .search-box {
                flex-direction: column;
                border-radius: 15px;
            }

            .search-box button {
                border-radius: 0 0 15px 15px;
            }

            .floating-element {
                font-size: 2rem !important;
            }

            .section-title h2 {
                font-size: 2rem;
            }

            .navbar-custom .nav-link {
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>

<!-- ========== NAVBAR ========== -->
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="fas fa-graduation-cap"></i>
            Escuela Gabriela Mistral
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                style="background-color: rgba(255,255,255,0.3); border: none;">
            <span class="navbar-toggler-icon" style="filter: brightness(0) invert(1);"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">Nosotros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#modules">Módulos</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Servicios
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Matrículas</a></li>
                        <li><a class="dropdown-item" href="#">Calificaciones</a></li>
                        <li><a class="dropdown-item" href="#">Asistencias</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contacto</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- ========== HERO SECTION ========== -->
<section class="hero-section">
    <!-- Elementos decorativos flotantes -->
    <i class="fas fa-pencil-alt floating-element pencil"></i>
    <i class="fas fa-ruler floating-element ruler"></i>
    <i class="fas fa-book floating-element book"></i>
    <i class="fas fa-atom floating-element atom"></i>
    <i class="fas fa-calculator floating-element calculator"></i>
    <i class="fas fa-microscope floating-element microscope"></i>

    <div class="container hero-content">
        <h1><span>Centro de Educacion Basico</span><br>Gabriela Mistral</h1>
        <p>
            Moderniza la administración educativa de tu institución con nuestra plataforma integral.
            Gestiona matrículas, calificaciones, asistencias y mucho más en un solo lugar.
        </p>

        <div class="search-box">
            <input type="text" placeholder="Buscar estudiante, profesor, curso...">
            <button type="submit">
                <i class="fas fa-search"></i> Buscar
            </button>
        </div>

        <div class="categories">
            <h3>Acceso Rápido</h3>
            <div class="category-tags">
                <span class="category-tag">Matrículas</span>
                <span class="category-tag">Estudiantes</span>
                <span class="category-tag">Profesores</span>
                <span class="category-tag">Calificaciones</span>
                <span class="category-tag">Asistencias</span>
                <span class="category-tag">Reportes</span>
            </div>
        </div>
    </div>

    <i class="fas fa-rocket hero-rocket"></i>
</section>

<!-- ========== FEATURES SECTION ========== -->
<section class="features-section" id="modules">
    <div class="container">
        <div class="section-title">
            <h2>Nuestros Módulos</h2>
            <p>Todo lo que necesitas para gestionar tu escuela de manera eficiente</p>
        </div>

        <div class="features-grid">

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h3>Matrículas Online</h3>
                <p>Registra nuevos estudiantes de manera rápida y sencilla. Sistema automatizado con validación de datos.</p>
                <button class="btn-feature">Acceder</button>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Gestión de Estudiantes</h3>
                <p>Base de datos completa con historial académico, información personal y documentos importantes.</p>
                <button class="btn-feature">Acceder</button>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <h3>Portal de Profesores</h3>
                <p>Herramientas para docentes: registro de notas, control de asistencia y planificación académica.</p>
                <button class="btn-feature">Acceder</button>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h3>Calificaciones</h3>
                <p>Sistema completo para registro y consulta de notas. Generación automática de boletines.</p>
                <button class="btn-feature">Acceder</button>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <h3>Control de Asistencia</h3>
                <p>Registro diario automatizado con notificaciones a padres y reportes estadísticos.</p>
                <button class="btn-feature">Acceder</button>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Reportes y Estadísticas</h3>
                <p>Análisis detallados del rendimiento académico y generación de informes personalizados.</p>
                <button class="btn-feature">Acceder</button>
            </div>

        </div>
    </div>
</section>

<!-- ========== STATS SECTION ========== -->
<section class="stats-section">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item">
                <h3>850+</h3>
                <p>Estudiantes Activos</p>
            </div>
            <div class="stat-item">
                <h3>45</h3>
                <p>Profesores</p>
            </div>
            <div class="stat-item">
                <h3>12</h3>
                <p>Grados Escolares</p>
            </div>
            <div class="stat-item">
                <h3>98%</h3>
                <p>Satisfacción</p>
            </div>
        </div>
    </div>
</section>

<!-- ========== CTA SECTION ========== -->
<section class="cta-section" id="about">
    <div class="container cta-content">
        <h2>¿Listo para Digitalizar tu Escuela?</h2>
        <p>
            Únete a las instituciones educativas que ya están transformando su gestión administrativa
            con nuestra plataforma. Comienza hoy mismo.
        </p>
        <a href="#" class="btn-cta">
            <i class="fas fa-rocket"></i> Iniciar Sesión
        </a>
    </div>
</section>

<!-- ========== FOOTER ========== -->
<footer id="contact">
    <div class="container">
        <div class="footer-content">

            <div class="footer-section">
                <h4><i class="fas fa-graduation-cap"></i> Gabriela Mistral</h4>
                <p>Sistema integral de gestión escolar para instituciones educativas modernas.</p>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <div class="footer-section">
                <h4>Enlaces Rápidos</h4>
                <a href="#">Inicio</a>
                <a href="#">Nosotros</a>
                <a href="#">Módulos</a>
                <a href="#">Contacto</a>
            </div>

            <div class="footer-section">
                <h4>Servicios</h4>
                <a href="#">Matrículas</a>
                <a href="#">Calificaciones</a>
                <a href="#">Asistencias</a>
                <a href="#">Reportes</a>
            </div>

            <div class="footer-section">
                <h4>Contacto</h4>
                <p><i class="fas fa-map-marker-alt"></i> Danlí, El Paraíso, Honduras</p>
                <p><i class="fas fa-phone"></i> +504 2763-4567</p>
                <p><i class="fas fa-envelope"></i> info@gabrielamistral.edu.hn</p>
            </div>

        </div>

        <div class="footer-bottom">
            <p>&copy; 2026 Escuela Gabriela Mistral. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Animación de aparición suave
    document.addEventListener('DOMContentLoaded', function() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '0';
                    entry.target.style.transform = 'translateY(30px)';
                    entry.target.style.transition = 'all 0.6s ease';

                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, 100);
                }
            });
        });

        document.querySelectorAll('.feature-card, .stat-item').forEach(el => {
            observer.observe(el);
        });
    });

    // Scroll suave
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Efecto en category tags
    document.querySelectorAll('.category-tag').forEach(tag => {
        tag.addEventListener('click', function() {
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 200);
        });
    });
</script>

</body>
</html>
