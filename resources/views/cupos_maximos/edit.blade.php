@extends('layouts.app')

@section('title', 'Actualizar Cupos - Escuela Gabriela Mistral')

@section('styles')
    <style>
        .form-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 40px auto;
        }

        /* Clase para uniformizar el ancho de los botones de acción (Cancelar, Guardar, Eliminar) */
        .btn-uniform-width {
            min-width: 130px;
            text-align: center;
        }

        /* ------------------------------------------- */
        /* --- ESTILOS DE BOTONES UNIFICADOS --- */
        /* ------------------------------------------- */

        /* 1. Botón Primario: Degradado (Guardar cambios) */
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

        /* 2. Botón Secundario: Contorno (Cancelar) */
        .btn-secondary-outline {
            background-color: white;
            border: 2px solid #1E5A8E;
            color: #1E5A8E;
            font-weight: bold;
            padding: 0.5rem 1.25rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease-in-out;
        }

        .btn-secondary-outline:hover {
            background-color: #f0f8ff;
            color: #1E5A8E;
            border-color: #1E5A8E;
        }

        /* 3. Botón "Volver" (Estilos por si se reintroduce) */
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

        /* 4. Botón de Peligro/Eliminar (Estilo con degradado rojo) */
        .btn-danger-themed {
            background: linear-gradient(135deg, #d90429 0%, #ef233c 100%);
            border: none;
            color: white;
            font-weight: bold;
            padding: 0.5rem 1.25rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 10px rgba(217, 4, 41, 0.4);
            transition: all 0.2s ease-in-out;
        }

        .btn-danger-themed:hover {
            background: linear-gradient(135deg, #b30321 0%, #d90429 100%);
            box-shadow: 0 6px 12px rgba(217, 4, 41, 0.6);
            color: white;
        }

    </style>
@endsection

@section('content')

    {{-- ELIMINAMOS LA BARRA DE NAVEGACIÓN MANUAL --}}

    <div class="container">
        <div class="form-container">
            <h4 class="text-center mb-4 fw-bold">Actualizar cupos</h4>

            @if (session('success'))
                {{-- Los mensajes de sesión ya se manejan en layouts/app.blade.php --}}
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                    <ul class="mb-0">
                        @foreach (collect($errors->all())->unique() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            <form id="cursoForm" method="POST" action="{{ route('cupos_maximos.update', $curso->id) }}">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label fw-bold">Nombre del curso:</label>
                        <select name="nombre" id="nombre" class="form-select form-select-sm" required>
                            <option value="">Seleccione un curso...</option>
                            @foreach(['1ro Primaria','2do Primaria','3ro Primaria','4to Primaria','5to Primaria','6to Primaria','1ro Secundaria','2do Secundaria','3ro Secundaria'] as $grado)
                                <option value="{{ $grado }}" {{ old('nombre', $curso->nombre) == $grado ? 'selected' : '' }}>{{ $grado }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="cupo_maximo" class="form-label fw-bold">Cupo de estudiantes:</label>
                        <input type="number" name="cupo_maximo" id="cupo_maximo" class="form-control form-control-sm"
                               value="{{ old('cupo_maximo', $curso->cupo_maximo) }}" min="1" max="35" required>
                        <small class="form-text text-muted">Ingrese un número de estudiantes (máximo 35)</small>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="jornada" class="form-label fw-bold">Jornada:</label>
                        <select name="jornada" id="jornada" class="form-select form-select-sm" required>
                            <option value="">Seleccione una jornada</option>
                            <option value="Matutina" {{ old('jornada', $curso->jornada) == 'Matutina' ? 'selected' : '' }}>Matutina</option>
                            <option value="Vespertina" {{ old('jornada', $curso->jornada) == 'Vespertina' ? 'selected' : '' }}>Vespertina</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="seccion" class="form-label fw-bold">Sección:</label>
                        <select name="seccion" id="seccion" class="form-select form-select-sm" required>
                            <option value="">Seleccione una sección...</option>
                            @foreach(['A','B','C','D'] as $sec)
                                <option value="{{ $sec }}" {{ old('seccion', $curso->seccion) == $sec ? 'selected' : '' }}>{{ $sec }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>

            {{-- SECCIÓN DE BOTONES (Guardar, Cancelar, Eliminar) --}}
            <div class="d-flex justify-content-between mt-4 align-items-center">

                {{-- 1. Botón Cancelar (IZQUIERDA) --}}
                <a href="{{ route('cupos_maximos.index') }}" class="btn btn-secondary-outline btn-uniform-width">
                    Cancelar
                </a>

                {{-- 2. Botón Guardar cambios (CENTRO) --}}
                <button type="submit" form="cursoForm" class="btn btn-primary-gradient btn-uniform-width">
                    Guardar cambios
                </button>

                {{-- 3. Botón Eliminar curso (DERECHA - Envuelto en su propio formulario) --}}
                <form action="{{ route('cupos_maximos.destroy', $curso->id) }}" method="POST" class="m-0 d-inline"
                      onsubmit="return confirm('¿Estás seguro de eliminar este curso? Esta acción no se puede deshacer.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger-themed btn-uniform-width">
                        Eliminar curso
                    </button>
                </form>
            </div>
            {{-- FIN DE LA SECCIÓN DE BOTONES --}}

        </div>

        {{-- ELIMINADO: Botón Volver a los administradores --}}

    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection