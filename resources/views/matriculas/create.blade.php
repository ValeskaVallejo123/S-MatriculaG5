<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registrar Matrícula - Gabriela Mistral</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.form-section { display: none; }
.form-section.active { display: block; }
.btn-purple { background-color: #6a1b9a; color: #fff; border: none; padding: 10px 20px; border-radius: 6px; }
.btn-purple:hover { background-color: #581a84; }
</style>
</head>
<body>
<div class="container mt-5">
<h1>Registrar Matrícula</h1>

<form method="POST" action="{{ route('estudiantes.store') }}" enctype="multipart/form-data">
    @csrf

    <!-- SECCIÓN 1: Datos del Estudiante -->
    <div class="form-section active" id="section-estudiante">
        <h4>Datos del Estudiante</h4>

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Apellido</label>
            <input type="text" name="apellido" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Fecha de Nacimiento</label>
            <input type="date" name="fecha_nacimiento" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Grado</label>
            <select name="grado" class="form-select" required>
                @foreach($grados as $grado)
                    <option value="{{ $grado }}">{{ $grado }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Sección</label>
            <select name="seccion" class="form-select" required>
                @foreach($secciones as $seccion)
                    <option value="{{ $seccion }}">{{ $seccion }}</option>
                @endforeach
            </select>
        </div>

        <button type="button" class="btn-purple" onclick="nextSection()">Siguiente</button>
    </div>

    <!-- SECCIÓN 2: Datos del Padre -->
    <div class="form-section" id="section-padre">
        <h4>Datos del Padre/Tutor</h4>

        <div class="mb-3">
            <label>Nombre Padre/Tutor</label>
            <input type="text" name="nombre_padre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" name="telefono_padre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email_padre" class="form-control">
        </div>

        <button type="button" class="btn-purple" onclick="prevSection()">Anterior</button>
        <button type="button" class="btn-purple" onclick="nextSection()">Siguiente</button>
    </div>

    <!-- SECCIÓN 3: Documentos -->
    <div class="form-section" id="section-documentos">
        <h4>Subir Documentos</h4>

        <div class="mb-3">
            <label>Foto del Estudiante</label>
            <input type="file" name="foto" class="form-control" accept="image/*" required>
        </div>

        <div class="mb-3">
            <label>Copia del DNI</label>
            <input type="file" name="dni_doc" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
        </div>

        <button type="button" class="btn-purple" onclick="prevSection()">Anterior</button>
        <button type="submit" class="btn-purple">Registrar Matrícula</button>
    </div>

</form>
</div>

<script>
let currentSection = 0;
const sections = document.querySelectorAll('.form-section');

function showSection(index) {
    sections.forEach((s,i) => s.classList.toggle('active', i === index));
}

function nextSection() {
    if (currentSection < sections.length - 1) {
        currentSection++;
        showSection(currentSection);
    }
}

function prevSection() {
    if (currentSection > 0) {
        currentSection--;
        showSection(currentSection);
    }
}
</script>

</body>
</html>
