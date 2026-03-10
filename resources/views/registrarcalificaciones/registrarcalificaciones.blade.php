@extends('layouts.app')

@section('content')

    <div class="container">

        <h2>Registrar Calificaciones</h2>

        <form action="{{ route('registrarcalificaciones.store') }}" method="POST">

            @csrf

            <div class="mb-3">

                <label class="form-label">Curso</label>

                <select name="curso_id" class="form-select" required>

                    <option value="">Seleccione curso</option>

                    @foreach($cursos as $curso)

                        <option value="{{ $curso->id }}">

                            {{ $curso->nombre }} - Sección {{ $curso->seccion }}

                        </option>

                    @endforeach

                </select>

            </div>


            <div class="mb-3">

                <label class="form-label">Materia</label>

                <select name="materia_id" class="form-select" required>

                    <option value="">Seleccione materia</option>

                    @foreach($materias as $materia)

                        <option value="{{ $materia->id }}">

                            {{ $materia->nombre }}

                        </option>

                    @endforeach

                </select>

            </div>


            <div class="mb-3">

                <label class="form-label">Periodo académico</label>

                <select name="periodo_academico_id" class="form-select" required>
                    <option value="">Seleccione periodo</option>
                    @foreach($periodos as $periodo)
                        <option value="{{ $periodo->id }}">
                            {{ $periodo->nombre_periodo }}
                            ({{ ucfirst($periodo->tipo) }}: {{ $periodo->fecha_inicio }} - {{ $periodo->fecha_fin }})
                        </option>
                    @endforeach
                </select>

            </div>


            <hr>

            <h4>Estudiantes</h4>

            @forelse($estudiantes as $estudiante)

                <div class="mb-3">

                    <label>

                        {{ $estudiante->apellido1 }}
                        {{ $estudiante->apellido2 }}
                        {{ $estudiante->nombre1 }}
                        {{ $estudiante->nombre2 }}

                    </label>

                    <input type="number"

                           name="notas[{{ $estudiante->id }}]"

                           class="form-control"

                           min="0"

                           max="100"

                           step="0.01">

                </div>

            @empty

                <div class="alert alert-info">

                    Seleccione curso y periodo para ver estudiantes

                </div>

            @endforelse


            <button type="submit" class="btn btn-success">

                Guardar calificaciones

            </button>


        </form>

    </div>

@endsection
