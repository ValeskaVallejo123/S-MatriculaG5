<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan de Estudio - Escuela Gabriela Mistral</title>
    <!-- Carga de Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Carga de Tailwind JIT para las clases personalizadas -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Configuración para usar la fuente Inter como predeterminada -->
    <style>
        :root {
            font-family: 'Inter', sans-serif;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<!-- Se cambió 'font-poppins' por 'font-inter' para consistencia con la configuración de fuentes, y se usa Tailwind para el estilo -->
<body class="bg-[#121212] font-inter text-[#f1f1f1]">
<div class="max-w-5xl mx-auto p-6 md:p-8 bg-[#1e1e1e] rounded-xl shadow-2xl mt-10 text-white">
    <!-- Detalle del Plan de Estudio -->
    <h1 class="text-3xl font-extrabold mb-6 border-b border-gray-600 pb-3">{{ $plan->nombre }}</h1>
    <p class="mb-4 text-gray-400">{{ $plan->descripcion }}</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
        <p><strong><i class="bi bi-book mr-2"></i>Nivel Educativo:</strong> {{ $plan->nivel_educativo }}</p>
        <p><strong><i class="bi bi-mortarboard mr-2"></i>Grado:</strong> {{ $plan->grado }}</p>
        <p><strong><i class="bi bi-calendar-check mr-2"></i>Año Vigente:</strong> {{ $plan->anio_vigente }}</p>
        <p><strong><i class="bi bi-clock mr-2"></i>Duración:</strong> {{ $plan->duracion }}</p>
        <p><strong><i class="bi bi-briefcase mr-2"></i>Jornada:</strong> {{ $plan->jornada }}</p>
        <p><strong><i class="bi bi-check2-square mr-2"></i>Aprobación:</strong> {{ $plan->fecha_aprobacion }}</p>
    </div>

    <!-- Secciones de Clases -->
    <h2 class="text-2xl font-bold mt-8 mb-4 border-b border-gray-600 pb-2">Clases del Plan</h2>
    @if($plan->clases->isEmpty())
        <div class="p-4 bg-[#2c2c2c] rounded-lg text-center text-gray-400">
            <i class="bi bi-info-circle text-xl mr-2"></i>No hay clases asignadas a este plan.
        </div>
    @else
        <div class="overflow-x-auto rounded-lg shadow-lg">
            <table class="min-w-full divide-y divide-gray-600">
                <thead class="bg-gray-700 text-sm uppercase tracking-wider">
                    <tr>
                        <th class="py-3 px-4">#</th>
                        <th class="py-3 px-4 text-left">Nombre</th>
                        <th class="py-3 px-4 text-left">Código</th>
                        <th class="py-3 px-4 text-center">Horas/Sem</th>
                        <th class="py-3 px-4 text-left">Docente</th>
                        <th class="py-3 px-4 text-left">Descripción</th>
                    </tr>
                </thead>
                <tbody class="bg-[#2c2c2c] divide-y divide-gray-700">
                    @foreach($plan->clases as $index => $clase)
                        <tr class="hover:bg-[#383838] transition duration-150 ease-in-out">
                            <td class="py-3 px-4 text-center">{{ $index + 1 }}</td>
                            <td class="py-3 px-4">{{ $clase->nombre ?? 'N/A' }}</td>
                            <td class="py-3 px-4">{{ $clase->codigo ?? 'N/A' }}</td>
                            <td class="py-3 px-4 text-center">{{ $clase->horas_semanales ?? 0 }}</td>
                            <!-- Asumiendo que 'docente' es una propiedad directa en Clase -->
                            <td class="py-3 px-4">{{ $clase->docente ?? 'Pendiente' }}</td>
                            <td class="py-3 px-4 text-sm text-gray-400 truncate max-w-xs">{{ $clase->descripcion ?? 'Sin descripción.' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- Botón de retorno (mejorado con estilo Tailwind/Bootstrap) -->
    <div class="flex justify-start mt-8">
        <a href="{{ route('plan_estudios.index') }}" class="inline-flex items-center bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200 shadow-md">
            <i class="bi bi-arrow-left mr-2"></i> Volver a la lista
        </a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
