@extends('layouts.app')

@section('content')
    <style>
        /* Fondo con gradiente */
        body {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            min-height: 100vh;
        }

        .card-custom {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            padding: 30px;
            color: #fff;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        h2 {
            font-weight: 700;
            color: #fff;
            text-shadow: 0px 2px 8px rgba(0,0,0,0.2);
        }

        label {
            font-weight: 600;
        }

        select, input[type="number"] {
            border-radius: 10px;
            border: none;
            padding: 10px;
        }

        select:focus, input:focus {
            box-shadow: 0 0 0 3px rgba(255, 192, 203, 0.5);
        }

        .btn-gradient {
            background: linear-gradient(90deg, #ff758c 0%, #ff7eb3 100%);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 10px 25px;
            transition: 0.3s;
        }

        .btn-gradient:hover {
            background: linear-gradient(90deg, #ff89a0 0%, #ff9ac2 100%);
            transform: translateY(-2px);
        }

        .table {
            color: #fff;
            border-radius: 10px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.05);
        }

        .table th {
            background-color: rgba(255, 255, 255, 0.15);
        }

        .alert {
            border-radius: 15px;
        }
    </style>

    <div class="container py-5">
        <div class="text-center mb-5">
            <h2>Registrar Calificaciones</h2>
            <p class="text-light mt-2">Selecciona el curso y período académico para ingresar o editar las notas de tus estudiantes.</p>
        </div>

        <div class="card-custom">
            <!-- Filtros -->
            <form method="GET" action="{{ route('registrarcalificaciones.registrarcalificaciones') }}">
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label for="curso" class="form-label">Curso</label>
                        <select name="curso" id="curso" class="form-select" required>
                            <option value="">Seleccione un curso</option>
                            @foreach($cursos as $curso)
                                <option value="{{ $curso->id }}" {{ request('curso') == $curso->id ? 'selected' : '' }}>
                                    {{ $curso->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="periodo" class="form-label">Período Académico</label>
                        <select name="periodo" id="periodo" class="form-select" required>
                            <option value="">Seleccione un período</option>
                            @foreach($periodos as $periodo)
                                <option value="{{ $periodo->id }}" {{ request('periodo') == $periodo->id ? 'selected' : '' }}>
                                    {{ $periodo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-gradient">Filtrar</button>
                </div>
            </form>

            <!-- Tabla de estudiantes -->
            @if(isset($estudiantes) && $estudiantes->count())
                <form method="POST" action="{{ route('registrarcalificaciones.registrarcalificaciones') }}">
                    @csrf
                    <table class="table table-bordered mt-4">
                        <thead>
                        <tr>
                            <th>Estudiante</th>
                            <th>Nota</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($estudiantes as $estudiante)
                            <tr>
                                <td>{{ $estudiante->nombre }}</td>
                                <td>
                                    <input type="number" name="notas[{{ $estudiante->id }}]" class="form-control" min="0" max="100" required>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-end">
                        <button type="submit" class="btn btn-gradient">Guardar Calificaciones</button>
                    </div>
                </form>
            @elseif(request()->has('curso') && request()->has('periodo'))
                <div class="alert alert-warning mt-4">
                    No se encontraron estudiantes matriculados en este curso y período.
                </div>
            @endif
        </div>
    </div>
@endsection
