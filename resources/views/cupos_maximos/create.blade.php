@extends('layouts.app')

@section('title', 'Registrar Curso - Escuela Gabriela Mistral')

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

        .btn-uniform-width {
            min-width: 130px;
            text-align: center;
        }

        /* --- ESTILOS DE BOTONES --- */

        /* 1. Botón Primario: Degradado AZUL (Guardar curso) */
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

        /* 2. Botón Secundario: Contorno AZUL (Cancelar, Limpiar) */
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

        /* 3. Botón Salir ROJO (Se puede dejar el estilo aunque el botón esté en el layout principal) */
        .btn-logout {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
        }

        .btn-logout:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
            color: white;
        }

        /* 4. Botón Volver (Mantenemos el estilo) */
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

    </style>
@endsection

@section('content')
    {{-- ELIMINAMOS LA BARRA DE NAVEGACIÓN MANUAL --}}

    <div class="container">
        <div class="form-container">
            <h4 class="text-center mb-4 fw-bold">Registrar nuevos cupos</h4>

            {{-- Mensaje de éxito --}}
            @if (session('success'))
                {{-- Los mensajes de sesión ya se manejan en layouts/app.blade.php --}}
            @endif

            {{-- Mensaje de errores --}}
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

            <form id="cursoForm" method="POST" action="{{ route('cupos_maximos.store') }}">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label fw-bold">Nombre del curso:</label>
                        <select name="nombre" id="nombre" class="form-select form-select-sm" required>
                            <option value="">Seleccione un curso...</option>
                            <option value="1ro Primaria" {{ old('nombre') == '1ro Primaria' ? 'selected' : '' }}>1ro Primaria</option>
                            <option value="2do Primaria" {{ old('nombre') == '2do Primaria' ? 'selected' : '' }}>2do Primaria</option>
                            <option value="3ro Primaria" {{ old('nombre') == '3ro Primaria' ? 'selected' : '' }}>3ro Primaria</option>
                            <option value="4to Primaria" {{ old('nombre') == '4to Primaria' ? 'selected' : '' }}>4to Primaria</option>
                            <option value="5to Primaria" {{ old('nombre') == '5to Primaria' ? 'selected' : '' }}>5to Primaria</option>
                            <option value="6to Primaria" {{ old('nombre') == '6to Primaria' ? 'selected' : '' }}>6to Primaria</option>
                            <option value="1ro Secundaria" {{ old('nombre') == '1ro Secundaria' ? 'selected' : '' }}>1ro Secundaria</option>
                            <option value="2do Secundaria" {{ old('nombre') == '2do Secundaria' ? 'selected' : '' }}>2do Secundaria</option>
                            <option value="3ro Secundaria" {{ old('nombre') == '3ro Secundaria' ? 'selected' : '' }}>3ro Secundaria</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="cupo_maximo" class="form-label fw-bold">Cupo de estudiantes:</label>
                        <input type="number" name="cupo_maximo" class="form-control form-control-sm" required value="{{ old('cupo_maximo') }}">
                        <small class="form-text text-muted">Ingrese un número de estudiantes (máximo 35)</small>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="jornada" class="form-label fw-bold">Jornada:</label>
                        <select name="jornada" id="jornada" class="form-select form-select-sm" required>
                            <option value="">Seleccione una jornada</option>
                            <option value="Matutina" {{ old('jornada') == 'Matutina' ? 'selected' : '' }}>Matutina</option>
                            <option value="Vespertina" {{ old('jornada') == 'Vespertina' ? 'selected' : '' }}>Vespertina</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="seccion" class="form-label fw-bold">Sección:</label>
                        <select name="seccion" id="seccion" class="form-select form-select-sm" required>
                            <option value="">Seleccione una sección...</option>
                            <option value="A" {{ old('seccion') == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ old('seccion') == 'B' ? 'selected' : '' }}>B</option>
                            <option value="C" {{ old('seccion') == 'C' ? 'selected' : '' }}>C</option>
                            <option value="D" {{ old('seccion') == 'D' ? 'selected' : '' }}>D</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('cupos_maximos.index') }}" class="btn btn-secondary-outline btn-uniform-width">Cancelar</a>
                    <button type="button" class="btn btn-secondary-outline btn-uniform-width" id="btnLimpiar">Limpiar</button>
                    <button type="submit" class="btn btn-primary-gradient btn-uniform-width">Guardar curso</button>
                </div>
            </form>
        </div>

        {{-- ELIMINADO: Botón Volver al Dashboard --}}

    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('btnLimpiar').addEventListener('click', function () {
            const form = document.getElementById('cursoForm');
            form.querySelectorAll('input').forEach(input => input.value = '');
            form.querySelectorAll('select').forEach(select => select.selectedIndex = 0);
            document.querySelectorAll('.alert').forEach(alert => alert.remove());
            form.querySelectorAll('input, select').forEach(el => el.classList.remove('is-invalid'));
        });
    </script>
@endsection
