<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Estado de Solicitud</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .contenedor {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 25px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            font-weight: bold;
            margin-bottom: 8px;
        }

        input[type="text"] {
            padding: 10px;
            width: 100%;
            max-width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .estado, .datos, .mensaje {
            margin-top: 25px;
            padding: 15px;
            border-radius: 8px;
            font-weight: bold;
        }

        .aprobada { background-color: #d4edda; color: #155724; }
        .rechazada { background-color: #f8d7da; color: #721c24; }
        .pendiente { background-color: #fff3cd; color: #856404; }
        .no-solicitud { background-color: #e2e3e5; color: #6c757d; }

        .datos {
            background-color: #eef;
            color: #333;
            font-weight: normal;
            text-align: left;
        }

        .datos p {
            margin: 5px 0;
        }

        .datos h4 {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="contenedor">
    <h2>Consulta de estado de solicitud</h2>

    <form method="POST" action="/estado-solicitud">
        @csrf
        <label for="dni">Buscar solicitud por DNI:</label>
        <input type="text" name="dni" id="dni" required
               pattern="\d{4}-\d{4}-\d{5}"
               title="Formato: ####-####-#####"
               placeholder="Ej: 0801-1990-12345">
        <button type="submit">Buscar solicitud de estudiante</button>
    </form>

    @if(isset($solicitud))
        @if($solicitud)
            <div class="estado
                    @if($solicitud->estado === 'aprobada') aprobada
                    @elseif($solicitud->estado === 'rechazada') rechazada
                    @else pendiente @endif">
                @if($solicitud->estado === 'aprobada')
                     Tu solicitud ha sido aprobada.
                @elseif($solicitud->estado === 'rechazada')
                     Tu solicitud fue rechazada.
                @else
                     Tu solicitud está en revisión.
                @endif
            </div>

            <div class="datos">
                <h4>📋 Datos del estudiante</h4>
                <p><strong>Nombre:</strong> {{ $solicitud->nombre }}</p>
                <p><strong>DNI:</strong> {{ $solicitud->dni }}</p>
                <p><strong>Correo:</strong> {{ $solicitud->correo }}</p>
                <p><strong>Teléfono:</strong> {{ $solicitud->telefono }}</p>
                <p><strong>Fecha de solicitud:</strong> {{ $solicitud->created_at->format('d/m/Y') }}</p>
            </div>

            @if($solicitud->notificar)
                <p style="margin-top: 10px;"> Recibirás notificaciones cuando el estado cambie.</p>
            @endif
        @else
            <div class="mensaje no-solicitud">
                 No se encontró ninguna solicitud con ese DNI. Verifica e intenta nuevamente.
            </div>
        @endif
    @endif
</div>
</body>
</html>
