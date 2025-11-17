<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Horario Académico</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 10px;
            color: #003b73;
            border-bottom: 3px solid #4ec7d2;
            padding-bottom: 10px;
        }
        .header-info {
            margin-bottom: 20px;
            font-size: 11px;
        }
        .header-info p {
            margin: 5px 0;
        }
        .header-info strong {
            color: #003b73;
            min-width: 120px;
            display: inline-block;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #003b73;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #4ec7d2;
            color: white;
            font-weight: 700;
            text-align: center;
        }
        td {
            background-color: #f9f9f9;
        }
        tr:nth-child(even) td {
            background-color: #f0f5f9;
        }
        tr:hover td {
            background-color: rgba(78, 199, 210, 0.1);
        }
        .center {
            text-align: center;
        }
        .footer {
            text-align: center;
            font-size: 10px;
            color: #666;
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ccc;
        }
        .logo-header {
            text-align: center;
            margin-bottom: 15px;
            color: #003b73;
        }
        .logo-header h1 {
            margin: 0;
            font-size: 18px;
        }
        .logo-header p {
            margin: 3px 0;
            font-size: 11px;
            color: #666;
        }
    </style>
</head>
<body>

    <div class="logo-header">
        <h1>📚 Escuela Gabriela Mistral</h1>
        <p>Sistema de Gestión Académica</p>
    </div>

    <h2>Horario Académico</h2>

    <!-- Información del Profesor -->
    @if(isset($profesor) && Auth::check() && Auth::user()->user_type === 'profesor')
        <div class="header-info">
            <p><strong>Profesor(a):</strong> {{ $profesor->nombre }} {{ $profesor->apellido ?? '' }}</p>
            <p><strong>Email:</strong> {{ $profesor->email ?? '—' }}</p>
            <p><strong>Teléfono:</strong> {{ $profesor->telefono ?? '—' }}</p>
            <p><strong>Fecha de Generación:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    @else
        <div class="header-info">
            <p><strong>Fecha de Generación:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    @endif

    <!-- Tabla de horarios -->
    @if($horarios->count() > 0)
        <table>
            <thead>
                <tr>
                    @if(Auth::check() && Auth::user()->user_type === 'admin')
                        <th class="center">Profesor</th>
                    @endif
                    <th class="center">Día</th>
                    <th class="center">Hora Inicio</th>
                    <th class="center">Hora Fin</th>
                    <th class="center">Grado</th>
                    <th class="center">Sección</th>
                    <th class="center">Aula</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($horarios as $horario)
                    <tr>
                        @if(Auth::check() && Auth::user()->user_type === 'admin')
                            <td class="center">{{ $horario->profesor->nombre ?? 'Sin asignar' }}</td>
                        @endif
                        <td class="center">{{ $horario->dia }}</td>
                        <td class="center">{{ \Carbon\Carbon::createFromFormat('H:i:s', $horario->hora_inicio)->format('H:i') }}</td>
                        <td class="center">{{ \Carbon\Carbon::createFromFormat('H:i:s', $horario->hora_fin)->format('H:i') }}</td>
                        <td class="center">{{ $horario->grado }}</td>
                        <td class="center">{{ $horario->seccion }}</td>
                        <td class="center">{{ $horario->aula ?? '—' }}</td>
                        <td>{{ $horario->observaciones ?? '—' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="center" style="padding: 20px; background: #f0f5f9; border-radius: 5px; color: #003b73;">
            <p><strong>No hay horarios disponibles.</strong></p>
        </div>
    @endif

    <div class="footer">
        <p>© {{ date('Y') }} Escuela Gabriela Mistral - Sistema de Matrícula</p>
        <p>Este documento fue generado automáticamente. No requiere firma.</p>
    </div>

</body>
</html>
