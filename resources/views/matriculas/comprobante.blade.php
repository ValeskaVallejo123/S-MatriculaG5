<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Matrícula</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.5; }
        h1 { text-align: center; font-size: 16pt; }
        h2 { font-size: 14pt; margin-top: 20px; }
        p { font-size: 12pt; }
        .section { margin-bottom: 15px; }
        .footer { margin-top: 30px; text-align: center; font-size: 11pt; }
    </style>
</head>
<body>
    <h1>Comprobante de Matrícula</h1>

    <div class="section">
        <h2>Padre/Tutor</h2>
        <p>Nombre: {{ $matricula->padre->nombre }} {{ $matricula->padre->apellido }}</p>
        <p>DNI: {{ $matricula->padre->dni }}</p>
        <p>Parentesco: {{ $matricula->padre->parentesco }}</p>
        @if($matricula->padre->email)
            <p>Email: {{ $matricula->padre->email }}</p>
        @endif
        <p>Teléfono: {{ $matricula->padre->telefono }}</p>
        <p>Dirección: {{ $matricula->padre->direccion }}</p>
    </div>

    <div class="section">
        <h2>Estudiante</h2>
        <p>Nombre: {{ $matricula->estudiante->nombre }} {{ $matricula->estudiante->apellido }}</p>
        <p>DNI: {{ $matricula->estudiante->dni }}</p>
        <p>Fecha Nacimiento: {{ $matricula->estudiante->fecha_nacimiento }}</p>
        <p>Grado: {{ $matricula->grado }}</p>
        <p>Sección: {{ $matricula->seccion }}</p>
        @if($matricula->estudiante->email)
            <p>Email: {{ $matricula->estudiante->email }}</p>
        @endif
        @if($matricula->estudiante->telefono)
            <p>Teléfono: {{ $matricula->estudiante->telefono }}</p>
        @endif
    </div>

    <div class="section">
        <p>Año lectivo: {{ $matricula->anio_lectivo }}</p>
        <p>Estado: {{ ucfirst($matricula->estado) }}</p>
    </div>

    <div class="footer">
        <p>Este comprobante es generado automáticamente por el sistema de matrícula.</p>
    </div>
</body>
</html>
