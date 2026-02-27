<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Configuración Académica - Escuela Gabriela Mistral</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        /* Estilos esenciales copiados de la plantilla base para asegurar el diseño de la nueva sección */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            background: white;
        }

        /* Estilos para el título de sección */
        .section-title {
            text-align: center;
            margin-bottom: 70px;
            padding-top: 100px; /* Espacio superior para compensar el navbar fijo si se usa en una página separada */
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

        /* Estilos para la cuadrícula y las tarjetas */
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
            cursor: pointer; /* Asegurar el cursor de botón */
        }

        .btn-feature:hover {
            transform: scale(1.08);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            color: white;
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }

        /* Estilo para el contenedor principal, si esta es una página independiente */
        .main-content {
            padding-top: 100px; /* Para evitar que el contenido se oculte bajo la navbar fija si se usa */
            min-height: 100vh;
        }
    </style>
</head>

<body>
    <div class="main-content container my-5">
        
        <section class="features-section" id="config-academica">
            <div class="container">
                <div class="section-title">
                    <i class="fas fa-cogs" style="color: #667eea; font-size: 3rem; margin-bottom: 15px;"></i>
                    <h2>Configuración Académica</h2>
                    <p>Gestión de la estructura de grados y ciclos de la institución.</p>
                </div>

                <div class="features-grid" style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); max-width: 800px; margin: 0 auto;">

                    <div class="feature-card">
                        <div class="feature-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); box-shadow: 0 10px 30px rgba(245, 87, 108, 0.35);">
                            <i class="fas fa-sort-numeric-up-alt"></i> </div>
                        <h3>Gestión de Grados</h3>
                        <p>Administra y configura todos los grados académicos disponibles en la escuela.</p>
                        
                        <button class="btn-feature" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                            Grados
                        </button>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-history"></i> </div>
                        <h3>Gestión de Ciclos</h3>
                        <p>Define y organiza los períodos académicos (ciclos o años lectivos) de la institución.</p>
                        
                        <button class="btn-feature">
                            Ciclos
                        </button>
                    </div>

                </div>
            </div>
        </section>
        
        <div class="py-5"></div>
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Animación de aparición suave (copiada de la plantilla base)
        document.addEventListener('DOMContentLoaded', function () {
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

            // Aplica animación a las nuevas tarjetas
            document.querySelectorAll('.feature-card, .stat-item').forEach(el => {
                observer.observe(el);
            });
        });
    </script>

    </body>

</html>