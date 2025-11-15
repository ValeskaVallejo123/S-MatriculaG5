<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de períodos académicos</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .contenedor {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .acciones {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .acciones form {
            display: inline;
        }

        .acciones button {
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
        }

        .editar { background-color: #ffc107; }
        .eliminar { background-color: #dc3545; }

        .crear {
            display: block;
            text-align: center;
            margin-top: 20px;
        }

        .crear a {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .crear a:hover {
            background-color: #218838;
        }

        .mensaje {
            text-align: center;
            color: #155724;
            background-color: #d4edda;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<div class="contenedor">
    <h2>Períodos académicos registrados</h2>

    @if(session('success'))
        <div class="mensaje">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
        <tr>
            <th>Nombre</th>
            <th>Tipo</th>
            <th>Inicio</th>
            <th>Fin</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @forelse($periodos as $periodo)
            <tr>
                <td>{{ $periodo->nombre_periodo }}</td>
                <td>{{ ucfirst($periodo->tipo) }}</td>
                <td>{{ \Carbon\Carbon::parse($periodo->fecha_inicio)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($periodo->fecha_fin)->format('d/m/Y') }}</td>
                <td class="acciones">
                    <a href="{{ route('periodos-academicos.edit', $periodo->id) }}">
                        <button class="editar">Editar</button>
                    </a>
                    <form method="POST" action="{{ route('periodos-academicos.destroy', $periodo->id) }}" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este período académico?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="eliminar">Eliminar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">No hay períodos registrados aún.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="crear">
        <a href="{{ route('periodos-academicos.create') }}">Registrar nuevo período</a>
    </div>
</div>
</body>
</html>
