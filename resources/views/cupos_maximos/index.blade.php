@extends('layouts.app')
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Listado de Cursos - Escuela Gabriela Mistral</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Pacifico&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #e6f0ff;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        /* ------------------------------------------- */
        /* --- ESTILOS DE BOTONES TEMÁTICOS (REUSO) --- */
        /* ------------------------------------------- */

        /* Botón Primario: Degradado (Azul fuerte) */
        .btn-primary-gradient {
            background: linear-gradient(135deg, #1E5A8E 0%, #4C98B6 100%);
            border: none;
            color: white;
            font-weight: bold;
            padding: 0.5rem 1.25rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 10px rgba(30, 90, 142, 0.4);
            transition: all 0.2s ease-in-out;
        }

        .btn-primary-gradient:hover {
            background: linear-gradient(135deg, #1A4E78 0%, #4288A5 100%);
            box-shadow: 0 6px 12px rgba(30, 90, 142, 0.6);
            color: white;
        }

        /* Botón Secundario Temático: Contorno azul */
        .btn-secondary-themed {
            background-color: transparent;
            border: 2px solid #1E5A8E;
            color: #1E5A8E;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease-in-out;
        }

        .btn-secondary-themed:hover {
            background-color: #1E5A8E;
            color: white;
        }

        /* --- CORRECCIÓN AQUÍ --- */
        /* Botón Destructivo: Rojo (específico para Eliminar) */
        .btn-red-destructive {
            background-color: #d90429 !important; /* !important fuerza el color rojo */
            border: none !important;
            color: #fff !important; /* Fuerza el texto blanco */
            font-weight: 600;
            transition: background-color 0.2s;
            border-radius: 0.375rem;
        }

        .btn-red-destructive:hover {
            background-color: #a1031f !important; /* Rojo más oscuro al pasar el mouse */
            color: #fff !important;
        }
        /* ----------------------- */

        /* ------------------------------------------- */
        /* --- ESTILOS DE TABLA Y LAYOUT --- */
        /* ------------------------------------------- */
        .table th, .table td { vertical-align: middle !important; }
        .table-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-top: 20px;
            margin-bottom: 20px;
        }

        /* Estilo base para los botones pequeños dentro de la tabla */
        .table .btn-sm {
            padding: 0.3rem 0.6rem;
            font-size: 0.8rem;
        }

        /* Ajuste específico para el botón gradiente cuando es pequeño */
        .table .btn-primary-gradient.btn-sm {
            padding: 0.3rem 0.6rem;
        }

        /* CLASE CRÍTICA: Fuerza el mismo tamaño para Actualizar y Eliminar */
        .btn-table-action {
            min-width: 90px;
            text-align: center;
            display: inline-block;
        }

        /* Contenedor principal con margen izquierdo para la navbar */
        .main-content-wrapper {
            margin-left: 280px;
            padding: 40px 40px 40px 20px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        @media (max-width: 768px) {
            .main-content-wrapper {
                margin-left: 0;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<div class="main-content-wrapper">
    <div class="container-fluid">
        <div class="table-container">
            <h2 class="mb-4 text-center fw-bold">Listado de cupos</h2>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            @if (session('info'))
                <div class="alert alert-info alert-dismissible fade show text-center" role="alert">
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif


            <div class="row mb-3 align-items-center">
                {{-- Filtros y Búsqueda --}}
                <div class="col-md-4 mb-2 mb-md-0">
                    <input type="text" id="searchNombre" class="form-control form-control-sm" placeholder="Buscar por curso...">
                </div>
                <div class="col-md-2 mb-2 mb-md-0">
                    <select id="filterJornada" class="form-select form-select-sm">
                        <option value="">Jornada...</option>
                        <option value="Matutina">Matutina</option>
                        <option value="Vespertina">Vespertina</option>
                    </select>
                </div>
                <div class="col-md-2 mb-2 mb-md-0">
                    <select id="filterSeccion" class="form-select form-select-sm">
                        <option value="">Sección...</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>
                </div>
                {{-- Botón de Registrar con estilo Gradient --}}
                <div class="col-md-4 text-md-end text-center">
                    <a href="{{ route('cupos_maximos.index') }}"> class="btn btn-primary-gradient">
                        Registrar nuevo cupo
                    </a>
                </div>
            </div>


            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center" id="cursosTable">
                    <thead class="table-primary" style="background-color: #e6f0ff !important; color: #1E5A8E;">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Cupo Máximo</th>
                        <th>Jornada</th>
                        <th>Sección</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cursos as $curso)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="nombre">{{ $curso->nombre }}</td>
                            <td>{{ $curso->cupo_maximo }}</td>
                            <td class="jornada">{{ $curso->jornada ?? '-' }}</td>
                            <td class="seccion">{{ $curso->seccion ?? '-' }}</td>
                            <td>
                                {{-- Botón Actualizar (Azul Degradado) --}}
                                <a href="{{ route('cupos_maximos.edit', $curso->id) }}" class="btn btn-sm btn-primary-gradient btn-table-action">
                                    Actualizar
                                </a>
                                <form action="{{ route('cupos_maximos.destroy', $curso->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    {{-- Botón Eliminar (Rojo Forzado) --}}
                                    <button type="submit" class="btn btn-sm btn-red-destructive btn-table-action" onclick="return confirm('¿Está seguro que desea eliminar este cupo?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if($cursos->isEmpty())
                        <tr>
                            <td colspan="6">No se encontraron cursos.</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('admins.index') }}" class="btn btn-secondary px-4 py-2 fw-semibold">
            <i class="bi bi-arrow-left-circle"></i> Volver a los administradores
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const searchInput = document.getElementById('searchNombre');
    const filterJornada = document.getElementById('filterJornada');
    const filterSeccion = document.getElementById('filterSeccion');
    const table = document.getElementById('cursosTable').getElementsByTagName('tbody')[0];

    function filterTable() {
        const searchValue = searchInput.value.toLowerCase();
        const jornadaValue = filterJornada.value;
        const seccionValue = filterSeccion.value;

        let hasResults = false;

        Array.from(table.rows).forEach(row => {
            if (row.cells.length < 6) return;

            const nombre = row.querySelector('.nombre').textContent.toLowerCase();
            const jornada = row.querySelector('.jornada').textContent;
            const seccion = row.querySelector('.seccion').textContent;

            const matchNombre = nombre.includes(searchValue);
            const matchJornada = jornadaValue === '' || jornada === jornadaValue;
            const matchSeccion = seccionValue === '' || seccion === seccionValue;

            const isVisible = (matchNombre && matchJornada && matchSeccion);
            row.style.display = isVisible ? '' : 'none';

            if (isVisible) {
                hasResults = true;
            }
        });
    }

    searchInput.addEventListener('input', filterTable);
    filterJornada.addEventListener('change', filterTable);
    filterSeccion.addEventListener('change', filterTable);
</script>
</body>
</html>
