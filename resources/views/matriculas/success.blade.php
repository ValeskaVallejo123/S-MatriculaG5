{{-- resources/views/matriculas/success.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Solicitud Enviada – Gabriela Mistral</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #003b73 0%, #00508f 40%, #07196b 100%);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 40px 15px;
        }
        .success-card {
            background: white;
            border-radius: 24px;
            padding: 60px 50px;
            max-width: 560px; width: 100%;
            text-align: center;
            box-shadow: 0 30px 80px rgba(0,0,0,.25);
            animation: popIn .5s cubic-bezier(.34,1.56,.64,1);
        }
        @keyframes popIn {
            from { opacity: 0; transform: scale(.85); }
            to   { opacity: 1; transform: scale(1); }
        }
        .check-circle {
            width: 90px; height: 90px;
            background: linear-gradient(135deg, #4ec7d2, #00508f);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 28px;
            font-size: 2.8rem; color: white;
            box-shadow: 0 12px 35px rgba(78,199,210,.4);
        }
        h1 { font-size: 1.8rem; font-weight: 800; color: #003b73; margin-bottom: 10px; }
        .subtitle { color: #6c757d; font-size: .95rem; margin-bottom: 30px; line-height: 1.6; }
        .codigo-box {
            background: #f0fafc;
            border: 2px solid #4ec7d2;
            border-radius: 14px;
            padding: 18px 24px;
            margin-bottom: 30px;
        }
        .codigo-box p { color: #6c757d; font-size: .82rem; margin-bottom: 4px; }
        .codigo-box .codigo { font-size: 1.5rem; font-weight: 800; color: #003b73; letter-spacing: .08em; }
        .pasos { text-align: left; margin-bottom: 34px; }
        .paso-item {
            display: flex; gap: 14px; align-items: flex-start;
            margin-bottom: 14px;
        }
        .paso-num {
            min-width: 32px; height: 32px;
            background: linear-gradient(135deg, #4ec7d2, #00508f);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white; font-weight: 700; font-size: .85rem;
        }
        .paso-item p { margin: 0; color: #495057; font-size: .875rem; line-height: 1.5; }
        .paso-item strong { color: #003b73; }

        .btn-consultar {
            background: linear-gradient(135deg, #4ec7d2, #00508f);
            color: white; padding: 13px 36px;
            border-radius: 50px; font-weight: 700;
            text-decoration: none; display: inline-block;
            transition: all .3s; font-size: .95rem;
            box-shadow: 0 8px 25px rgba(78,199,210,.35);
        }
        .btn-consultar:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(78,199,210,.5);
            color: white;
        }
        .btn-inicio {
            color: #6c757d; font-size: .875rem;
            text-decoration: none; display: block; margin-top: 16px;
        }
        .btn-inicio:hover { color: #003b73; }
    </style>
</head>
<body>

<div class="success-card">

    <div class="check-circle">
        <i class="fas fa-check"></i>
    </div>

    <h1>¡Solicitud Enviada!</h1>
    <p class="subtitle">
        La solicitud de matrícula de <strong>{{ session('nombre_estudiante') }}</strong>
        fue recibida correctamente. Un administrador la revisará pronto.
    </p>

    <div class="codigo-box">
        <p>Tu código de seguimiento es:</p>
        <div class="codigo">{{ session('codigo') }}</div>
        <p class="mt-2" style="font-size:.78rem">
            <i class="fas fa-exclamation-circle text-warning me-1"></i>
            Guarda este código para consultar el estado de tu matrícula.
        </p>
    </div>

    <div class="pasos">
        <div class="paso-item">
            <div class="paso-num">1</div>
            <p><strong>Revisión:</strong> El equipo administrativo revisará tu solicitud en los próximos días hábiles.</p>
        </div>
        <div class="paso-item">
            <div class="paso-num">2</div>
            <p><strong>Notificación:</strong> Serás contactado al teléfono o correo registrado con la respuesta.</p>
        </div>
        <div class="paso-item">
            <div class="paso-num">3</div>
            <p><strong>Cita presencial:</strong> Si es aprobada, deberás presentarte con los documentos originales para finalizar.</p>
        </div>
    </div>

    <a href="{{ route('matriculas.index') }}" class="btn-consultar">
        <i class="fas fa-search me-2"></i>Consultar Estado
    </a>
    <a href="{{ url('/') }}" class="btn-inicio">
        <i class="fas fa-home me-1"></i>Volver al Inicio
    </a>

</div>

</body>
</html>
