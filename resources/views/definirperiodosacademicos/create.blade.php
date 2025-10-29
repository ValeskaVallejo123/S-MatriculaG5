<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo período académico</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
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
            margin-top: 15px;
            margin-bottom: 5px;
            align-self: flex-start;
        }

        input, select {
            padding: 10px;
            width: 100%;
            max-width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: center;
        }

        button {
            margin-top: 25px;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        .enlace {
            margin-top: 20px;
            display: block;
            color: #007bff;
            text-decoration: none;
        }

        .enlace:hover {
            text-decoration: underline;
        }

        .error {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
<div class="contenedor">
    <h2>Registrar nuevo período académico</h2>

    <form method="POST" action="{{ route('periodos-academicos.store') }}">
        @csrf

        <label for="nombre_periodo">Nombre del período</label>
        <input type="text" name="nombre_periodo" id="nombre_periodo" value="{{ old('nombre_periodo') }}" required>
        @error('nombre_periodo') <div class="error">{{ $message }}</div> @enderror

        <label for="tipo">Tipo de período</label>
        <select name="tipo" id="tipo" required>
            <option value="">-- Selecciona --</option>
            <option value="clases">Clases</option>
            <option value="vacaciones">Vacaciones</option>
            <option value="examenes">Exámenes</option>
        </select>
        @error('tipo') <div class="error">{{ $message }}</div> @enderror

        <label for="fecha_inicio">Fecha de inicio</label>
        <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio') }}" required>
        @error('fecha_inicio') <div class="error">{{ $message }}</div> @enderror

        <label for="fecha_fin">Fecha de fin</label>
        <input type="date" name="fecha_fin" id="fecha_fin" value="{{ old('fecha_fin') }}" required>
        @error('fecha_fin') <div class="error">{{ $message }}</div> @enderror

        <button type="submit">Guardar período</button>
    </form>

    <a href="{{ route('periodos-academicos.index') }}" class="enlace">← Volver al listado</a>
</div>
</body>
</html>
