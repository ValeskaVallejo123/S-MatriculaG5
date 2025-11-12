<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Horario Académico</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }
        th {
            background-color: #eaeaea;
        }
        .footer {
            text-align: center;
            font-size: 10px;
            color: gray;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h2>Horario Académico</h2>

    @if(isset($user))
        <p><strong>Usuario:</strong> {{ $user->name }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>Día</th>
                <th>Hora Inicio</th>
                <th>Hora Fin</th>
                <th>Materia</th>
                <th>Sección</th>
                <th>Salón</th>
            </tr>
        </thead>
        <tbody>
            @foreach($horarios as $horario)
                <tr>
                    <td>{{ $horario->dia }}</td>
                    <td>{{ $horario->hora_inicio }}</td>
                    <td>{{ $horario->hora_fin }}</td>
                    <td>{{ $horario->materia }}</td>
                    <td>{{ $horario->seccion }}</td>
                    <td>{{ $horario->salon }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Generado automáticamente por el Sistema de Matrícula - {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
